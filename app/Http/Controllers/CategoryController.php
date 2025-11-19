<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search');
        
        $categories = Category::when($search, function($query, $search) {
            $query->where('nama', 'like', '%' . trim($search) . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString(); // Mempertahankan query string saat pagination

        return view('category.index', compact('categories', 'search'));
    }

    public function create(): View
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|min:3|max:255',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.min' => 'Nama kategori minimal harus 3 karakter.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
        ]);

        Category::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('category.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|min:3|max:255',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.min' => 'Nama kategori minimal harus 3 karakter.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
        ]);

        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect()
            ->route('category.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}

