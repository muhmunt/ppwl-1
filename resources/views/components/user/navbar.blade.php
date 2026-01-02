@php
    $cart = session()->get('cart', []);
    $cartCount = 0;
    foreach ($cart as $item) {
        $cartCount += $item['quantity'];
    }
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">TokoKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#produk">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testimoni">Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kontak">Pembayaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}" title="Keranjang Belanja">
                        <i class="bx bx-cart fs-4"></i>
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
            <a href="{{ route('login') }}" class="btn btn-primary ms-lg-3">Login</a>
        </div>
    </div>
</nav>