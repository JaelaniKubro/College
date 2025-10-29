@include('layouts.header')

<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Daftar</li>
        </ol>
    </nav>

    <h2>Daftar Akun</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('/signup') }}" class="mt-3">
        @csrf
        <div class="mb-3">
            <label>Nama Pengguna</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Daftar Sebagai:</label>
            <select name="role" class="form-select">
                <option value="buyer">Pembeli</option>
                <option value="seller">Penjual</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>

@include('layouts.footer')
