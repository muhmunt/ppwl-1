@extends('layouts.user.app')

@section('title', $product->nama)

@section('content')
    <section class="py-5">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#produk">Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->nama }}</li>
                </ol>
            </nav>

            <div class="row g-5">
                <!-- Gambar Produk -->
                <div class="col-md-5">
                    <div class="card shadow-sm border-0">
                        @if($product->foto)
                            <img 
                                src="{{ asset('storage/' . $product->foto) }}" 
                                class="card-img-top rounded-top" 
                                alt="{{ $product->nama }}"
                                style="height: 500px; object-fit: cover;"
                                onerror="this.src='{{ asset('assets/img/default-product.png') }}'"
                            >
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center rounded-top" style="height: 500px;">
                                <i class="bx bx-image text-muted" style="font-size: 128px;"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="col-md-7">
                    <div class="mb-3">
                        @if($product->kategori)
                            <span class="badge bg-primary mb-2">{{ $product->kategori->nama }}</span>
                        @endif
                        @if($product->stok <= 0)
                            <span class="badge bg-danger mb-2">Stok Habis</span>
                        @elseif($product->stok <= 5)
                            <span class="badge bg-warning mb-2">Stok Terbatas</span>
                        @else
                            <span class="badge bg-success mb-2">Tersedia</span>
                        @endif
                    </div>

                    <h2 class="fw-bold mb-3">{{ $product->nama }}</h2>
                    
                    <div class="mb-4">
                        <h3 class="text-primary fw-bold mb-2">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </h3>
                        <p class="text-muted mb-0">Harga sudah termasuk PPN</p>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Deskripsi Produk</h5>
                        <p class="text-muted" style="line-height: 1.8; white-space: pre-line;">{{ $product->deskripsi }}</p>
                    </div>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-package text-primary me-2 fs-5"></i>
                                        <div>
                                            <small class="text-muted d-block">Stok Tersedia</small>
                                            <strong class="d-block">
                                                {{ $product->stok > 0 ? $product->stok . ' unit' : 'Habis' }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-category text-primary me-2 fs-5"></i>
                                        <div>
                                            <small class="text-muted d-block">Kategori</small>
                                            <strong class="d-block">
                                                {{ $product->kategori ? $product->kategori->nama : '-' }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        @if($product->stok > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bx bx-cart-add me-2"></i>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                                <i class="bx bx-x-circle me-2"></i>
                                Stok Habis
                            </button>
                        @endif
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bx bx-arrow-back me-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

