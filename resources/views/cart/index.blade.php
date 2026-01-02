@extends('layouts.user.app')

@section('title', 'Keranjang Pesanan')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Keranjang Pesanan</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($cart && count($cart) > 0)
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($cart as $id => $item)
                                @php 
                                    $product = \App\Models\Product::find($id);
                                    $total = $item['harga'] * $item['quantity']; 
                                    $grandTotal += $total; 
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($item['foto']) && $item['foto'])
                                                <img src="{{ asset('storage/' . $item['foto']) }}" width="60" height="60" class="me-2 rounded" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center me-2" style="width: 60px; height: 60px;">
                                                    <i class="bx bx-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $item['nama'] }}</strong>
                                                @if($product && $product->kategori)
                                                    <br><small class="text-muted">{{ $product->kategori->nama }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td>
                                        @if($product)
                                            <form action="{{ route('cart.update', $product->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $product->stok }}" class="form-control w-50">
                                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                                            </form>
                                            <small class="text-muted">Stok: {{ $product->stok }}</small>
                                        @else
                                            <span class="badge bg-danger">Produk tidak ditemukan</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($product)
                                            <form action="{{ route('cart.remove', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bx bx-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                                <td colspan="2" class="fw-bold text-primary">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Bagian Total + Tombol Checkout -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4 class="fw-bold">Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}</h4>
                <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg">
                    <i class="bx bx-credit-card me-2"></i>
                    Lanjut ke Pembayaran
                </a>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bx bx-cart text-muted" style="font-size: 64px;"></i>
                    <div class="alert alert-warning mt-3">Keranjang masih kosong.</div>
                </div>
            </div>
        @endif

        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">
            <i class="bx bx-arrow-back me-2"></i>
            Lanjut Belanja
        </a>
    </div>
@endsection
