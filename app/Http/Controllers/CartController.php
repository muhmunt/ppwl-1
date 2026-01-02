<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang
     */
    public function index(): View
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Menambah produk ke keranjang
     */
    public function add(Product $product)
    {
        $cart = session()->get('cart', []);
        
        // Validasi stok
        if ($product->stok <= 0) {
            return back()->with('error', 'Stok produk habis!');
        }
        
        // Jika produk sudah ada di cart, increment quantity
        if (isset($cart[$product->id])) {
            // Cek apakah quantity yang akan ditambah melebihi stok
            if ($cart[$product->id]['quantity'] >= $product->stok) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $cart[$product->id]['quantity']++;
        } else {
            // Jika produk belum ada di cart, tambahkan baru
            $cart[$product->id] = [
                "nama" => $product->nama,
                "quantity" => 1,
                "harga" => $product->harga,
                "foto" => $product->foto
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index')
            ->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Update jumlah produk di keranjang
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stok
        ], [
            'quantity.required' => 'Jumlah produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka.',
            'quantity.min' => 'Jumlah produk minimal 1.',
            'quantity.max' => 'Jumlah produk tidak boleh melebihi stok yang tersedia.',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Jumlah produk diperbarui!');
    }

    /**
     * Menghapus produk dari keranjang
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Produk dihapus dari keranjang!');
    }
}
