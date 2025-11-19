@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Breadcrumb dinamis --}}
        <x-breadcrumb :items="[
            'Dashboard' => route('dashboard'),
            'Produk' => route('products.index'),
            'Edit Produk' => ''
        ]" />
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Produk</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update', $product->id ?? 1) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label" for="kategori_id">Kategori</label>
                                <select class="form-select" id="kategori_id" name="kategori_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                @error('kategori_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama Produk</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="nama" 
                                    name="nama" 
                                    placeholder="Masukkan nama produk"
                                    value="{{ old('nama', $product->nama ?? '') }}"
                                    required
                                />
                                @error('nama')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea 
                                    class="form-control" 
                                    id="deskripsi" 
                                    name="deskripsi" 
                                    rows="3"
                                    placeholder="Masukkan deskripsi produk"
                                >{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
                                @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="harga">Harga</label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    id="harga" 
                                    name="harga" 
                                    placeholder="0"
                                    step="0.01"
                                    min="0"
                                    value="{{ old('harga', $product->harga ?? '') }}"
                                    required
                                />
                                @error('harga')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="stok">Stok</label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    id="stok" 
                                    name="stok" 
                                    placeholder="0"
                                    min="0"
                                    value="{{ old('stok', $product->stok ?? '') }}"
                                    required
                                />
                                @error('stok')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="foto">Foto Produk</label>
                                <input 
                                    type="file" 
                                    class="form-control" 
                                    id="foto" 
                                    name="foto" 
                                    accept="image/*"
                                />
                                @if(isset($product) && $product->foto)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $product->foto) }}" alt="Current photo" height="100">
                                    </div>
                                @endif
                                @error('foto')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

