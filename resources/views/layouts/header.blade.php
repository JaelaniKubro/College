<!DOCTYPE html>
<html lang="id" itemscope itemtype="https://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jelajahi keindahan Ponorogo dengan wisata alam, budaya, kuliner, dan petualangan yang tak terlupakan. Temukan Reog Ponorogo, Telaga Ngebel, dan destinasi menarik lainnya.">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
    <!-- Header -->
<header>
    <div class="container header-container d-flex justify-content-between align-items-center">
        <div class="logo">
            <h1><a href="{{ route('home') }}" class="text-decoration-none text-dark">JajanNgebel</a></h1>
        </div>

        <!-- Tombol menu tiga garis -->
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button"
                id="menuDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                style="border: none; background: none; font-size: 1.5rem;">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="menuDropdown" style="min-width: 220px;">

                @if(!session('user_id'))
                    <!-- Belum login -->
                    <li class="dropdown-header text-muted small px-3">Masuk Sebagai</li>
                    <li><a class="dropdown-item" href="{{ route('login') }}?role=buyer">
                        <i class="fas fa-user me-2 text-success"></i>Pembeli
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('login') }}?role=seller">
                        <i class="fas fa-store me-2 text-primary"></i>Pedagang
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-success fw-semibold" href="{{ route('signup') }}">
                        <i class="fas fa-user-plus me-2"></i>Daftar Akun Baru
                    </a></li>

                @elseif(session('role') === 'buyer')
                    <!-- Menu buyer -->
                    <li class="dropdown-header text-muted small px-3">Hai, {{ session('username') }}</li>
                    <li><a class="dropdown-item" href="#">
                        <i class="fas fa-user me-2"></i>Profil
                    </a></li>
                    <li><a class="dropdown-item" href="#">
                        <i class="fas fa-shopping-cart me-2"></i>Pesanan Saya
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>

                @elseif(session('role') === 'seller')
                    <!-- Menu seller -->
                    <li class="dropdown-header text-muted small px-3">Toko: {{ session('username') }}</li>
                    <li><a class="dropdown-item" href="#">
                        <i class="fas fa-id-card me-2"></i>Profil Dagang
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('dashboard.seller') }}">
                        <i class="fas fa-chart-line me-2"></i>Dashboard Seller
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>

                @elseif(session('success'))
                    <div class="alert alert-success text-center mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </ul>
        </div>
    </div>
</header>
