<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home/landing page
     */
    public function index(): View
    {
        $products = Product::with('kategori')
            ->where('stok', '>', 0) // Hanya produk yang ada stoknya
            ->orderBy('created_at', 'desc')
            ->limit(8) // Tampilkan 8 produk terbaru
            ->get();

        return view('home', compact('products'));
    }
}
