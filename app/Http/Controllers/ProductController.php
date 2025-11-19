<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        // TODO: Implement product listing with search functionality
        // $products = Product::when($search, function($query, $search) {
        //     return $query->where('nama', 'like', "%{$search}%");
        // })->paginate(10);
        
        return view('products.index', [
            // 'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // TODO: Load categories for dropdown
        // $categories = Category::all();
        
        return view('products.create', [
            // 'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // max 2MB
        ]);

        // TODO: Handle file upload
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '_' . $image->getClientOriginalName();
        //     $image->storeAs('public/products', $imageName);
        //     $validated['foto'] = 'products/' . $imageName;
        // }

        // TODO: Create product
        // Product::create($validated);
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // TODO: Implement show logic
        // $product = Product::findOrFail($id);
        // return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // TODO: Load product and categories
        // $product = Product::findOrFail($id);
        // $categories = Category::all();
        
        return view('products.edit', [
            // 'product' => $product,
            // 'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implement validation and update logic
        // $product = Product::findOrFail($id);
        // $validated = $request->validate([...]);
        // $product->update($validated);
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Implement delete logic
        // $product = Product::findOrFail($id);
        // $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
