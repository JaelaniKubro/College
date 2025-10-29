@include('layouts.header')

<!-- Hero Section dengan Parallax -->
<section class="hero">
    <div class="parallax-bg"></div>
    <div class="hero-content">
        <h1>JajanNgebel</h1>
        <p>"Discover Local Taste, Instantly"</p>
        <div class="hero-buttons">
            <a href="#menu" class="hero-btn">Jelajahi Sekarang</a>
            <a href="{{ url('tiket') }}" class="hero-btn secondary">Beli Tiket Online</a>
        </div>
    </div>
</section>

<!-- Menu Section -->
<section id="menu" class="carousel-section">
    <div class="container">            
        <div class="card-grid">
            @foreach($menus as $menu)
                <a href="{{ route('buyer.menu.detail', $menu->id) }}" class="card-link">
                    <div class="card-component" data-aos="fade-up">
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

<!-- Event Calendar Section -->
<section id="acara" class="event-calendar">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Kalender Acara 2025</h2>
            <p>Jangan lewatkan berbagai event menarik di Telaga Ngebel sepanjang tahun</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <div class="calendar-highlight">
                    <h3 class="mb-4">Acara Mendatang</h3>
                    
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">15</span>
                            <span class="month">Okt</span>
                        </div>
                        <div class="event-info">
                            <h4>Festival Reog Nasional</h4>
                            <p>Lokasi: Alun-alun Ponorogo | Waktu: 09.00 - 22.00 WIB</p>
                        </div>
                    </div>
                    
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">22</span>
                            <span class="month">Nov</span>
                        </div>
                        <div class="event-info">
                            <h4>Grebeg Suro Ponorogo</h4>
                            <p>Lokasi: Kawasan Batoro Katong | Waktu: 07.00 - Selesai</p>
                        </div>
                    </div>
                    
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">10</span>
                            <span class="month">Des</span>
                        </div>
                        <div class="event-info">
                            <h4>Ponorogo Jazz Festival</h4>
                            <p>Lokasi: Telaga Ngebel | Waktu: 16.00 - 23.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section id="berita" class="carousel-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Berita Terbaru</h2>
            <p>Informasi terkini seputar pariwisata Ponorogo</p>
        </div>
        
        <div class="card-grid">
            <div class="card-component" data-aos="fade-up" data-aos-delay="100">
                <div class="card-img-container">
                    <img src="https://images.pexels.com/photos/4604846/pexels-photo-4604846.jpeg" alt="Berita 1">
                </div>
                <div class="card-content">
                    <span class="card-category">Olahraga</span>
                    <h4>Ponorogo Sprint Competition 2025 Meriahkan Haornas</h4>
                    <p>Kejuaraan Ponorogo Sprint Competition (PSC) 2025 sukses digelar dengan antusiasme luar biasa...</p>
                    <div class="card-meta">
                        <i class="far fa-calendar"></i> 30 September 2025
                    </div>
                    <a href="#" class="btn btn-link p-0 mt-2">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            
            <div class="card-component" data-aos="fade-up" data-aos-delay="200">
                <div class="card-img-container">
                    <img src="https://images.pexels.com/photos/30721931/pexels-photo-30721931.jpeg" alt="Berita 2">
                </div>
                <div class="card-content">
                    <span class="card-category">Budaya</span>
                    <h4>Ekosistem Reog Ponorogo: Pelestarian Budaya</h4>
                    <p>Reog Ponorogo, yang telah diakui UNESCO sebagai Warisan Budaya Takbenda, kini menjadi fokus utama...</p>
                    <div class="card-meta">
                        <i class="far fa-calendar"></i> 25 September 2025
                    </div>
                    <a href="#" class="btn btn-link p-0 mt-2">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            
            <div class="card-component" data-aos="fade-up" data-aos-delay="300">
                <div class="card-img-container">
                    <img src="https://images.pexels.com/photos/2158963/pexels-photo-2158963.jpeg" alt="Berita 3">
                </div>
                <div class="card-content">
                    <span class="card-category">Olahraga</span>
                    <h4>Gowes Bareng Sepeda Tua Warnai Haornas 2025</h4>
                    <p>Dalam rangka menyemarakkan peringatan Hari Olahraga Nasional (Haornas), Komunitas Sepeda Tua Indonesia...</p>
                    <div class="card-meta">
                        <i class="far fa-calendar"></i> 15 September 2025
                    </div>
                    <a href="#" class="btn btn-link p-0 mt-2">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2 style="color: white;">Peta Wisata Ponorogo</h2>
            <p style="color: #ccc;">Temukan lokasi destinasi wisata favorit Anda di Ponorogo</p>
        </div>
        
        <div class="map-container" data-aos="fade-up">
            <div style="width: 100%; height: 100%; background-color: #eee; display: flex; align-items: center; justify-content: center; color: #666;">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                    <p>Peta Interaktif Destinasi Wisata Ponorogo</p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')
