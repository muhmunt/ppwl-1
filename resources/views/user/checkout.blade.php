@extends('layouts.user.app')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Keranjang</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        <h2 class="fw-bold mb-4">
            <i class="bx bx-credit-card text-primary me-2"></i>
            Checkout
        </h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bx bx-error-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($cart && count($cart) > 0)
            <div class="row">
                <!-- Ringkasan Pesanan -->
                <div class="col-md-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="bx bx-receipt me-2"></i>
                                Ringkasan Pesanan
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $grandTotal = 0; @endphp
                                        @foreach($cart as $id => $item)
                                            @php 
                                                $total = $item['harga'] * $item['quantity']; 
                                                $grandTotal += $total; 
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if(isset($item['foto']) && $item['foto'])
                                                            <img src="{{ asset('storage/' . $item['foto']) }}" width="50" height="50" class="me-2 rounded" style="object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $item['nama'] }}</strong>
                                                            <br>
                                                            <small class="text-muted">Rp {{ number_format($item['harga'], 0, ',', '.') }} / unit</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $item['quantity'] }}</td>
                                                <td class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="fw-bold text-end">Grand Total:</td>
                                            <td class="fw-bold text-primary">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Data Pembeli -->
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="bx bx-user me-2"></i>
                                Data Pembeli
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('checkout.process') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-semibold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="nama" 
                                        id="nama" 
                                        class="form-control @error('nama') is-invalid @enderror" 
                                        value="{{ old('nama', auth()->user()->name ?? '') }}"
                                        required
                                    >
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label fw-semibold">
                                        Alamat Pengiriman <span class="text-danger">*</span>
                                    </label>
                                    <textarea 
                                        name="alamat" 
                                        id="alamat" 
                                        class="form-control @error('alamat') is-invalid @enderror" 
                                        rows="3"
                                        required
                                    >{{ old('alamat', auth()->user()->alamat ?? '') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telepon" class="form-label fw-semibold">
                                        No. Telepon <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="telepon" 
                                        id="telepon" 
                                        class="form-control @error('telepon') is-invalid @enderror" 
                                        value="{{ old('telepon', auth()->user()->telepon ?? '') }}"
                                        required
                                    >
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="metode" class="form-label fw-semibold">
                                        Metode Pembayaran <span class="text-danger">*</span>
                                    </label>
                                    <select 
                                        name="metode" 
                                        id="metode" 
                                        class="form-select @error('metode') is-invalid @enderror" 
                                        required
                                    >
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="transfer" {{ old('metode') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                        <option value="cod" {{ old('metode') == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                                        <option value="ewallet" {{ old('metode') == 'ewallet' ? 'selected' : '' }}>E-Wallet (OVO, Dana, GoPay)</option>
                                    </select>
                                    @error('metode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bx bx-check-circle me-2"></i>
                                        Proses Pembayaran
                                    </button>
                                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-arrow-back me-2"></i>
                                        Kembali ke Keranjang
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bx bx-cart text-muted" style="font-size: 64px;"></i>
                    <div class="alert alert-warning mt-3">Keranjang masih kosong.</div>
                    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">
                        <i class="bx bx-arrow-back me-2"></i>
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

