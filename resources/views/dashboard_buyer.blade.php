@include('layouts.header')

<section class="hero">
    <div class="parallax-bg"></div>
    <div class="hero-content">
        <h1>Dashboard Pembeli</h1>
        <p>Hai, {{ session('username') }}! Pesan jajanan favoritmu dari area wisata Telaga Ngebel.</p>
        <div class="hero-buttons">
            <a href="#menu" class="hero-btn">Lihat Menu</a>
            <a href="#pesanan" class="hero-btn secondary">Riwayat Pesanan</a>
        </div>
    </div>
</section> 

{{-- Jika user sedang melihat detail 1 menu --}}
@if(isset($menu))
<section id="menu" class="carousel-section py-5">
    <div class="container">
        <div class="row align-items-center justify-content-center shadow-lg rounded-4 p-4 bg-white" style="max-width: 900px; margin: 0 auto;">
            
            {{-- Kolom Gambar --}}
            <div class="col-md-5 text-center mb-4 mb-md-0">
                <img src="{{ asset('storage/' . $menu->image_path) }}" 
                     alt="{{ $menu->menu_name }}" 
                     class="img-fluid rounded-3 shadow-sm" 
                     style="max-height: 350px; object-fit: cover;">
            </div>

            {{-- Kolom Detail Menu --}}
            <div class="col-md-7">
                <h2 class="fw-bold mb-2">{{ $menu->menu_name }}</h2>
                <p class="text-muted mb-3">{{ $menu->description }}</p>
                <h4 class="text-success fw-semibold mb-4">Rp{{ number_format($menu->price, 0, ',', '.') }}</h4>

                <form action="{{ route('buyer.order', $menu->id) }}" method="POST" class="d-flex gap-3">
                    @csrf
                    <a href="{{ route('buyer.order.form', $menu->id) }}" class="btn btn-success px-4 py-2">
                        <i class="fas fa-shopping-cart me-2"></i> Pesan Sekarang
                    </a>
                    <a href="{{ route('dashboard.buyer') }}" class="btn btn-outline-secondary px-4 py-2">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Jika user belum klik menu apapun --}}
@else
<section id="menu" class="carousel-section py-5">
    <div class="container">            
        <div class="card-grid">
            @foreach($menus as $menu)
                <a href="{{ route('buyer.menu.detail', $menu->id) }}" class="card-link">
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
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section id="pesanan" class="event-calendar py-5">
    <div class="container">
        <div class="section-title">
            <h2>Riwayat Pesananmu</h2>
            <p>Lihat pesanan yang sudah kamu lakukan sebelumnya.</p>
        </div>

        @if(isset($orders) && $orders->isNotEmpty())
            <div class="calendar-highlight">
                @foreach($orders as $order)
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">{{ $order->created_at->format('d') }}</span>
                            <span class="month">{{ $order->created_at->format('M') }}</span>
                        </div>
                        <div class="event-info">
                            <h4>{{ $order->menu->menu_name }}</h4>
                            <p>Status: <strong>{{ $order->status }}</strong><br>Nomor Bangku: {{ $order->seat_number }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">Belum ada pesanan.</p>
        @endif
    </div>
</section>
@endif

@include('layouts.footer')
