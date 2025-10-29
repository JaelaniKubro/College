@include('layouts.header')

<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Login</li>
        </ol>
    </nav>

    <h2>Masuk Akun</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}" class="mt-3">
        @csrf
        <div class="mb-3">
            <label>Nama Pengguna</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Masuk</button>
    </form>
</div>

@include('layouts.footer')
