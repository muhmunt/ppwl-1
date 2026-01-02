<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\View\View;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
    public function index(): View
    {
        $cart = Session::get('cart', []);
        return view('user.checkout', compact('cart'));
    }

    /**
     * Proses checkout
     */
    public function process(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (!$cart || count($cart) === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        // Validasi form
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'metode' => 'required|in:transfer,cod,ewallet',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'alamat.required' => 'Alamat pengiriman wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'metode.required' => 'Metode pembayaran wajib dipilih.',
            'metode.in' => 'Metode pembayaran tidak valid.',
        ]);

        // TODO: Simpan data pesanan ke database
        // Untuk sekarang kita anggap sukses

        Session::forget('cart'); // Kosongkan keranjang setelah checkout

        return redirect()->route('checkout.index')
            ->with('success', 'Pesanan berhasil diproses! Terima kasih sudah berbelanja.');
    }
}
