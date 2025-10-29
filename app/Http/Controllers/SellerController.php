<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    //Tampilkan form upload + daftar menu
    public function showUploadForm()
    {
        if (!session('user_id') || session('role') !== 'seller') {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai penjual untuk mengakses halaman ini.');
        }

        $menus = MenuItem::where('seller_id', session('user_id'))->latest()->get();
        return view('dashboard_upload_menu', compact('menus'));
    }

    //Simpan menu baru
    public function storeMenu(Request $request)
    {
        if (!session('user_id') || session('role') !== 'seller') {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai penjual untuk menambahkan menu.');
        }

        $request->validate([
            'menu_name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $imagePath = $request->file('image')->store('menu_images', 'public');

        MenuItem::create([
            'seller_id' => session('user_id'),
            'menu_name' => $request->menu_name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image_path' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    //Edit menu
    public function editMenu($id)
    {
        if (!session('user_id') || session('role') !== 'seller') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Login sebagai penjual terlebih dahulu.');
        }

        $menu = MenuItem::where('seller_id', session('user_id'))->findOrFail($id);
        $menus = MenuItem::where('seller_id', session('user_id'))->latest()->get();

        return view('dashboard_upload_menu', compact('menu', 'menus'));
    }

    //Update menu
    public function updateMenu(Request $request, $id)
    {
        if (!session('user_id') || session('role') !== 'seller') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Login sebagai penjual terlebih dahulu.');
        }

        $menu = MenuItem::where('seller_id', session('user_id'))->findOrFail($id);

        $request->validate([
            'menu_name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        //Update field dasar
        $menu->menu_name = $request->menu_name;
        $menu->category = $request->category;
        $menu->price = $request->price;
        $menu->description = $request->description;

        //Jika user upload gambar baru
        if ($request->hasFile('image')) {
            if ($menu->image_path) {
                Storage::disk('public')->delete($menu->image_path);
            }
            $menu->image_path = $request->file('image')->store('menu_images', 'public');
        }

        $menu->save();

        return redirect()->route('dashboard.upload.menu')->with('success', 'Menu berhasil diperbarui!');
    }

    //Hapus menu
    public function deleteMenu($id)
    {
        if (!session('user_id') || session('role') !== 'seller') {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai penjual untuk menghapus menu.');
        }

        $menu = MenuItem::where('seller_id', session('user_id'))->findOrFail($id);

        if ($menu->image_path) {
            Storage::disk('public')->delete($menu->image_path);
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    //Dashboard Seller
    public function dashboard()
    {
        if (!session('user_id') || session('role') !== 'seller') {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai penjual untuk membuka dashboard.');
        }

        $menus = MenuItem::where('seller_id', session('user_id'))->latest()->get();

        $orders = Order::with(['buyer', 'menu'])
            ->where('seller_id', session('user_id'))
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard_seller', compact('menus', 'orders'));
    }

    //Halaman utama (public)
    public function welcome()
    {
        $menus = MenuItem::latest()->get();
        return view('welcome', compact('menus'));
    }
}
