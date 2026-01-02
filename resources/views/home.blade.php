@extends('layouts.user.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <h1 class="fw-bold mb-3">Selamat Datang di <span class="text-primary">TokoKu</span></h1>
            <p class="lead text-muted">Belanja mudah, cepat, dan terpercaya dengan produk pilihan terbaik.</p>
            <a href="#produk" class="btn btn-primary btn-lg mt-3">
                <i class="bx bx-shopping-bag me-2"></i> Belanja Sekarang
            </a>
        </div>
    </section>

    <!-- Produk Section -->
    <section id="produk" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Produk Unggulan</h2>
            <div class="row g-4 mt-3">
                @forelse($products as $product)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="position-relative">
                                @if($product->foto)
                                    <img 
                                        src="{{ asset('storage/' . $product->foto) }}" 
                                        class="card-img-top" 
                                        alt="{{ $product->nama }}"
                                        style="height: 250px; object-fit: cover;"
                                        onerror="this.src='{{ asset('assets/img/default-product.png') }}'"
                                    >
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                        <i class="bx bx-image text-muted" style="font-size: 64px;"></i>
                                    </div>
                                @endif
                                @if($product->stok <= 0)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Habis</span>
                                @elseif($product->stok <= 5)
                                    <span class="badge bg-warning position-absolute top-0 end-0 m-2">Terbatas</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ $product->nama }}</h5>
                                @if($product->kategori)
                                    <span class="badge bg-label-primary mb-2">{{ $product->kategori->nama }}</span>
                                @endif
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($product->deskripsi, 80) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <h6 class="text-primary mb-0 fw-bold">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </h6>
                                    @if($product->stok > 0)
                                        <span class="text-muted small">Stok: {{ $product->stok }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary w-100 mt-3">
                                    <i class="bx bx-info-circle me-1"></i> Detail Produk
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bx bx-package text-muted" style="font-size: 64px;"></i>
                            <p class="text-muted mt-3">Belum ada produk tersedia.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
