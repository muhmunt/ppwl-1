@extends('layouts.user.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Checkout</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cart && count($cart) > 0)
    <div class="row">
        <!-- Ringkasan Pesanan -->
        <div class="col-md-7">
            <h4 class="fw-bold mb-3">Ringkasan Pesanan</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $total = $item['harga'] * $item['quantity']; $grandTotal += $total; @endphp
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="fw-bold text-end">Grand Total:</td>
                        <td class="fw-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Form Data Pembeli -->
        <div class="col-md-5">
            <h4 class="fw-bold mb-3">Data Pembeli</h4>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $user->name ?? '') }}" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Pengiriman</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $user->alamat ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">No. Telepon</label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $user->telepon ?? '') }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="metode" class="form-label">Metode Pembayaran</label>
                    <input type="text" value="Transfer Bank" class="form-control" disabled>
                    <input type="hidden" name="metode" value="transfer">
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg">Proses Pembayaran</button>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-warning">Keranjang masih kosong.</div>
    <a href="/" class="btn btn-secondary mt-3">Lanjut Belanja</a>
    @endif
</div>
@endsection
