@extends('layouts.user.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body text-center p-5">
            <h2 class="text-success mb-3">Pesanan Berhasil Dibuat!</h2>
            <p class="mb-4">
                Terima kasih sudah berbelanja di toko kami.<br>
                Pesanan kamu sudah tercatat dengan status <strong>Pending</strong>.
            </p>

            <div class="alert alert-info text-start">
                <h5>Instruksi Pembayaran:</h5>
                <ul class="mb-0">
                    <li>Metode Pembayaran: <strong>Transfer Bank</strong></li>
                    <li>Nomor Rekening: <strong>1234567890 (BCA a.n PT TokoKita)</strong></li>
                    <li>Total yang harus dibayar sesuai dengan detail pesanan.</li>
                    <li>Setelah transfer, silakan kirim bukti pembayaran ke admin.</li>
                </ul>
            </div>

            {{-- Form upload bukti pembayaran --}}
            @if($order)
            <div class="mt-4 text-start">
                <h5>Upload Bukti Pembayaran:</h5>
                <form action="{{ route('checkout.updatePaymentProof', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="bukti_pembayaran" class="form-label">Pilih file bukti pembayaran (jpg/png/pdf)</label>
                        <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required>
                        @error('bukti_pembayaran')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Bukti Pembayaran</button>
                </form>
            </div>
            @endif

            <a href="{{ route('home') }}" class="btn btn-primary mt-4">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection

