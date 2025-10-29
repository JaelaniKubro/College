@include('layouts.header')

<section class="order-form-section py-5">
    <div class="container">
        <div class="shadow-lg bg-white rounded-4 p-5" style="max-width: 700px; margin: 0 auto;">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2">Rincian Pesanan</h2>
                <p class="text-muted">Lengkapi detail pesananmu untuk <strong>{{ $menu->menu_name }}</strong></p>
            </div>

            {{-- Tampilkan pesan sukses / error --}}
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Kirim Pesanan --}}
            <form action="{{ route('buyer.order', $menu->id) }}" method="POST" id="orderForm">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Pemesan</label>
                    <input type="text" class="form-control" id="name" name="buyer_name" placeholder="Nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label for="seat" class="form-label">Nomor Bangku</label>
                    <input type="text" class="form-control" id="seat" name="seat_number" placeholder="Contoh: B-12" required>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Metode Pemesanan</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="order_mode" id="byPortion" value="portion" checked>
                        <label class="form-check-label" for="byPortion">Jumlah Porsi</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="order_mode" id="byNominal" value="nominal">
                        <label class="form-check-label" for="byNominal">Nominal (Rp)</label>
                    </div>
                </div>

                <div class="mb-3" id="portionInput">
                    <label for="quantity" class="form-label">Jumlah Porsi</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                </div>

                <div class="mb-3 d-none" id="nominalInput">
                    <label for="nominal" class="form-label">Nominal (Rp)</label>
                    <input type="number" class="form-control" id="nominal" name="nominal" min="1000" placeholder="Contoh: 10000">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilihan / Catatan</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="options[]" value="Pedas" id="opt1">
                        <label class="form-check-label" for="opt1">Pedas</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="options[]" value="Kuah banyak" id="opt2">
                        <label class="form-check-label" for="opt2">Kuah banyak</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="options[]" value="Es sedikit" id="opt3">
                        <label class="form-check-label" for="opt3">Es sedikit</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="options[]" value="Tidak terlalu manis" id="opt4">
                        <label class="form-check-label" for="opt4">Tidak terlalu manis</label>
                    </div>
                </div>

                <div class="alert alert-light border text-center fw-semibold" id="priceEstimate">
                    Estimasi Total: <span id="totalPrice">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                </div>

                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('dashboard.buyer') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>

                    {{-- Tombol aktif & kirim --}}
                    <button type="submit" class="btn btn-success px-4" id="submitOrder">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const pricePerPortion = {{ $menu->price }};
    const quantityField = document.getElementById("quantity");
    const nominalField = document.getElementById("nominal");
    const totalPrice = document.getElementById("totalPrice");
    const byPortion = document.getElementById("byPortion");
    const byNominal = document.getElementById("byNominal");
    const portionInput = document.getElementById("portionInput");
    const nominalInput = document.getElementById("nominalInput");

    function updateEstimate() {
        let total = 0;
        if (byPortion.checked) {
            const qty = parseInt(quantityField.value || 1);
            total = qty * pricePerPortion;
        } else {
            total = parseInt(nominalField.value || 0);
        }
        totalPrice.textContent = 'Rp' + total.toLocaleString('id-ID');
    }

    function toggleInputs() {
        if (byPortion.checked) {
            portionInput.classList.remove("d-none");
            nominalInput.classList.add("d-none");
        } else {
            portionInput.classList.add("d-none");
            nominalInput.classList.remove("d-none");
        }
        updateEstimate();
    }

    quantityField.addEventListener("input", updateEstimate);
    nominalField.addEventListener("input", updateEstimate);
    byPortion.addEventListener("change", toggleInputs);
    byNominal.addEventListener("change", toggleInputs);
});
</script>

@include('layouts.footer')
