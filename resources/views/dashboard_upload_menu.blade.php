@include('layouts.header')

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.seller') }}">Dashboard Penjual</a></li>
            <li class="breadcrumb-item active">Kelola Menu</li>
        </ol>
    </nav>

    <h2 class="mb-4">Kelola Menu Dagangan</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- FORM TAMBAH / EDIT MENU --}}
    <form 
        action="{{ isset($menu) ? url('/seller/update-menu/'.$menu->id) : url('/seller/upload-menu') }}" 
        method="POST" 
        enctype="multipart/form-data" 
        class="p-4 shadow-sm rounded bg-light mb-5"
    >
        @csrf
        @if(isset($menu))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="menu_name" class="form-label">Nama Menu</label>
            <input type="text" name="menu_name" id="menu_name" class="form-control" 
                   value="{{ $menu->menu_name ?? '' }}" placeholder="Contoh: Pentol Mercon" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select name="category" id="category" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Makanan" {{ isset($menu) && $menu->category == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="Minuman" {{ isset($menu) && $menu->category == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="Snack" {{ isset($menu) && $menu->category == 'Snack' ? 'selected' : '' }}>Snack</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input type="number" name="price" id="price" class="form-control"
                   value="{{ $menu->price ?? '' }}" placeholder="Contoh: 10000" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Menu</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Tulis deskripsi singkat tentang menu Anda">{{ $menu->description ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Upload Foto Menu</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" {{ isset($menu) ? '' : 'required' }}>
            @if(isset($menu) && $menu->image_path)
                <img src="{{ asset('storage/'.$menu->image_path) }}" alt="Menu" width="120" class="mt-2 rounded">
            @endif
        </div>

        <button type="submit" class="hero-btn2 secondary w-100 py-2 mt-3">
            {{ isset($menu) ? 'Perbarui Menu' : 'Upload Menu Baru' }}
        </button>
    </form>

    {{-- DAFTAR MENU --}}
    <h4 class="mb-3">Daftar Menu Anda</h4>
    <div class="card-grid">
        @forelse($menus as $item)
            <div class="card-component">
                <div class="card-img-container">
                    <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->menu_name }}">
                </div>
                <div class="card-content">
                    <h3>{{ $item->menu_name }}</h3>
                    <p>{{ $item->description }}</p>
                    <div class="card-meta">
                        <i class="fas fa-tags"></i> Rp{{ number_format($item->price, 0, ',', '.') }}
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ url('/seller/edit-menu/'.$item->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                        <form action="{{ url('/seller/delete-menu/'.$item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada menu yang diunggah.</p>
        @endforelse
    </div>
</div>

@include('layouts.footer')
