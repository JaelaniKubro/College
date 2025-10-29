<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(Request $request, $id)
    {
        // Pastikan user login sebagai pembeli
        if (!session('user_id') || session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pembeli.');
        }

        // Ambil data menu yang dipesan
        $menu = MenuItem::findOrFail($id);

        // Validasi input
        $request->validate([
            'buyer_name'  => 'required|string|max:255',
            'seat_number' => 'required|string|max:10',
            'order_mode'  => 'required|in:portion,nominal',
            'quantity'    => 'nullable|numeric|min:1',
            'nominal'     => 'nullable|numeric|min:1000',
            'options'     => 'nullable|array',
        ]);

        // Hitung jumlah porsi berdasarkan mode pemesanan
        $quantity = $request->order_mode === 'nominal'
            ? floor($request->nominal / $menu->price)
            : $request->quantity;

        if ($quantity < 1) {
            return back()->with('error', 'Nominal terlalu kecil untuk 1 porsi.')->withInput();
        }

        // Gabungkan preferensi pembeli
        $preferences = $request->options ? implode(', ', $request->options) : null;

        // Simpan ke database lokal (MySQL)
        $order = Order::create([
            'buyer_id'    => session('user_id'),
            'seller_id'   => $menu->seller_id,
            'menu_id'     => $menu->id,
            'buyer_name'  => $request->buyer_name,
            'seat_number' => $request->seat_number,
            'quantity'    => $quantity,
            'preferences' => $preferences,
            'status'      => 'Dalam Pembuatan',
        ]);

        // 🔥 Kirim ke Node.js server agar tersimpan juga di Firebase
        try {
            $response = Http::post('http://localhost:5000/api/add-order', [
                'order_id'    => $order->id,
                'buyer_name'  => $request->buyer_name,
                'seat_number' => $request->seat_number,
                'quantity'    => $quantity,
                'menu_name'   => $menu->menu_name,
                'seller_id'   => $menu->seller_id,
                'preferences' => $preferences,
                'status'      => 'Dalam Pembuatan',
                'created_at'  => now()->toDateTimeString(),
            ]);

            if ($response->failed()) {
                info('⚠️ Gagal sinkron ke Node.js: ' . $response->body());
            }
        } catch (\Exception $e) {
            info('❌ Gagal kirim ke Node.js: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.buyer')
            ->with('success', 'Pesanan berhasil dikirim dan sedang diproses!');
    }

    // ✅ Seller menandai pesanan selesai
    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'Selesai';
        $order->save();

        // Kirim pembaruan status ke Node.js/Firebase
        try {
            Http::post('http://localhost:5000/api/update-status', [
                'order_id' => $id,
                'status'   => 'Selesai',
            ]);
        } catch (\Exception $e) {
            info('Error update ke Node.js: ' . $e->getMessage());
        }

        return back()->with('success', 'Pesanan telah diselesaikan.');
    }

    // ✅ Seller membatalkan pesanan
    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'Dibatalkan (Stok Habis)';
        $order->save();

        try {
            Http::post('http://localhost:5000/api/update-status', [
                'order_id' => $id,
                'status'   => 'Dibatalkan (Stok Habis)',
            ]);
        } catch (\Exception $e) {
            info('Error kirim pembatalan ke Node.js: ' . $e->getMessage());
        }

        return back()->with('error', 'Pesanan telah dibatalkan karena stok habis.');
    }
}
