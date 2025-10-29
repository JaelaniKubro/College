@include('layouts.header')

<section class="hero">
    <div class="parallax-bg"></div>
    <div class="hero-content">
        <h1>Dashboard Penjual</h1>
        <p>Selamat datang, {{ session('username') }}! Kelola daganganmu dan pantau pesanan pengunjung.</p>
        <div class="hero-buttons">
            <a href="#produk" class="hero-btn">Kelola Menu</a>
            <a href="#pesanan" class="hero-btn secondary">Lihat Pesanan</a>
        </div>
    </div>
</section>

<section id="produk" class="carousel-section">
    <div class="container">
        <div class="section-title">
            <h2>Daftar Produk Kamu</h2>
            <p>Tambah, ubah, atau hapus menu daganganmu di sini.</p>
        </div>

        <div class="card-grid">
            @foreach($menus as $menu)
                <div class="card-component">
                    <div class="card-img-container">
                        <img src="{{ asset('storage/' . $menu->image_path) }}" alt="{{ $menu->menu_name }}">
                    </div>
                    <div class="card-content">
                        <h3>{{ $menu->menu_name }}</h3>
                        <p>{{ $menu->description }}</p>
                        <div class="card-meta">
                            <i class="fas fa-tags"></i> Rp{{ number_format($menu->price, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('dashboard.upload.menu') }}" class="btn btn-outline-primary mt-3">Edit Menu</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('dashboard.upload.menu') }}" class="hero-btn2 secondary">+ Tambah Produk Baru</a>
        </div>
    </div>
</section>

<section id="pesanan" class="event-calendar py-5">
    <div class="container">
        <div class="section-title">
            <h2>Pesanan Terbaru</h2>
            <p>Lihat pesanan yang masuk dari pembeli di area wisata.</p>
        </div>

        @if($orders->isEmpty())
            <p class="text-center text-muted">Belum ada pesanan masuk.</p>
        @else
            <div class="calendar-highlight">
                @foreach($orders as $order)
                    <div class="event-item shadow-sm rounded-3 p-3 mb-3 bg-light border position-relative">
                        <div class="event-date text-center bg-success text-white rounded-3 p-2" style="width: 70px;">
                            <span class="day d-block fw-bold" style="font-size: 20px;">{{ $order->created_at->format('d') }}</span>
                            <span class="month text-uppercase">{{ $order->created_at->format('M') }}</span>
                        </div>

                        <div class="event-info ms-4 flex-grow-1">
                            <h4 class="fw-semibold mb-2">🍴 {{ $order->menu->menu_name }}</h4>
                            <p class="mb-1"><strong>Pemesan:</strong> {{ $order->buyer_name ?? $order->buyer->username }}</p>
                            <p class="mb-1"><strong>Bangku:</strong> {{ $order->seat_number }}</p>

                            @if($order->quantity)
                                <p class="mb-1"><strong>Jumlah:</strong> {{ $order->quantity }} porsi</p>
                            @endif

                            @if($order->preferences)
                                <p class="mb-1"><strong>Preferensi:</strong> {{ $order->preferences }}</p>
                            @endif

                            <p class="mb-2"><strong>Status:</strong>
                                <span class="badge 
                                    @if($order->status === 'Menunggu Konfirmasi') bg-warning 
                                    @elseif($order->status === 'Selesai') bg-success 
                                    @elseif($order->status === 'Dibatalkan') bg-danger 
                                    @else bg-secondary @endif">
                                    {{ $order->status }}
                                </span>
                            </p>

                            {{-- Tombol aksi --}}
                            @if($order->status === 'Menunggu Konfirmasi')
                                <div class="d-flex gap-2">
                                    <form action="{{ route('seller.order.complete', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check me-1"></i> Selesai
                                        </button>
                                    </form>

                                    <form action="{{ route('seller.order.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times me-1"></i> Batalkan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ✅ Listener Firebase Realtime --}}
<script type="module" src="{{ asset('js/firebase-listener.js') }}"></script>

@include('layouts.footer')
