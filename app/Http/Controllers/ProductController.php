<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        
        $products = Product::with('kategori')
            ->when($search, function($query, $search) {
                $query->where('nama', 'like', '%' . trim($search) . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    /**
     * Menampilkan form tambah produk
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru
     */
    public function store(Request $request)
    {
        // Debug: Log request info
        \Log::info('Store product request', [
            'has_file' => $request->hasFile('foto'),
            'file_size' => $request->hasFile('foto') ? $request->file('foto')->getSize() : null,
            'file_mime' => $request->hasFile('foto') ? $request->file('foto')->getMimeType() : null,
            'all_files' => array_keys($request->allFiles())
        ]);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'kategori_id' => 'required|exists:categories,id',
        ], [
            'nama.required' => 'Nama produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'stok.required' => 'Stok produk wajib diisi.',
            'stok.integer' => 'Stok harus berupa bilangan bulat.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'deskripsi.required' => 'Deskripsi produk wajib diisi.',
            'foto.required' => 'Foto produk wajib diisi.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
            'kategori_id.required' => 'Kategori produk wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
        ]);

        try {
            // Pastikan file ada
            if (!$request->hasFile('foto')) {
                \Log::error('Upload foto gagal: File tidak ditemukan', [
                    'request_all' => $request->all(),
                    'files' => $request->allFiles()
                ]);
                return back()->withInput()->withErrors(['foto' => 'Foto produk wajib diisi.']);
            }

            $file = $request->file('foto');
            
            // Validasi file
            if (!$file->isValid()) {
                \Log::error('Upload foto gagal: File tidak valid', [
                    'error' => $file->getError(),
                    'error_message' => $file->getErrorMessage()
                ]);
                return back()->withInput()->withErrors(['foto' => 'File tidak valid: ' . $file->getErrorMessage()]);
            }

            // Cek apakah folder writable
            $storagePath = storage_path('app/public/produk');
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            
            if (!is_writable($storagePath)) {
                \Log::error('Upload foto gagal: Folder tidak writable', ['path' => $storagePath]);
                return back()->withInput()->withErrors(['foto' => 'Folder penyimpanan tidak dapat ditulis.']);
            }

            // Upload foto
            $fotoPath = $file->store('produk', 'public');

            if (!$fotoPath) {
                \Log::error('Upload foto gagal: store() mengembalikan false');
                return back()->withInput()->withErrors(['foto' => 'Gagal mengupload foto.']);
            }

            \Log::info('Foto berhasil diupload', ['path' => $fotoPath]);

            Product::create([
                'nama' => $request->nama,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi,
                'kategori_id' => $request->kategori_id,
                'foto' => $fotoPath,
            ]);

            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Upload foto exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->withErrors(['foto' => 'Gagal mengupload foto: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan form edit produk
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Mengupdate produk
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'kategori_id' => 'required|exists:categories,id',
        ], [
            'nama.required' => 'Nama produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'stok.required' => 'Stok produk wajib diisi.',
            'stok.integer' => 'Stok harus berupa bilangan bulat.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
            'kategori_id.required' => 'Kategori produk wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
        ]);

        $data = $request->except('foto');

        try {
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($product->foto && file_exists(public_path('storage/' . $product->foto))) {
                    unlink(public_path('storage/' . $product->foto));
                }
                
                // Upload foto baru
                $fotoPath = $request->file('foto')->store('produk', 'public');
                
                if (!$fotoPath) {
                    return back()->withInput()->withErrors(['foto' => 'Gagal mengupload foto.']);
                }
                
                $data['foto'] = $fotoPath;
            }

            $product->update($data);
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['foto' => 'Gagal mengupload foto: ' . $e->getMessage()]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk
     */
    public function destroy(Product $product)
    {
        // Hapus foto jika ada
        if ($product->foto && file_exists(public_path('storage/' . $product->foto))) {
            unlink(public_path('storage/' . $product->foto));
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
