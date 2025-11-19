@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Breadcrumb dinamis --}}
        <x-breadcrumb :items="[
            'Dashboard' => route('dashboard'),
            'Produk' => route('products.index'),
            'Tambah Produk' => ''
        ]" />
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>

            <!-- Basic with Icons -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Tambah Produk Baru</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Kategori -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kategori_id">Kategori</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-kategori2" class="input-group-text">
                                            <i class="bx bx-category"></i>
                                        </span>
                                        <select 
                                            class="form-select @error('kategori_id') is-invalid @enderror" 
                                            id="kategori_id" 
                                            name="kategori_id"
                                            aria-describedby="basic-icon-default-kategori2"
                                        >
                                            <option value="">Pilih Kategori</option>
                                            {{-- TODO: Populate categories dynamically --}}
                                        </select>
                                    </div>
                                    @error('kategori_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="image">Foto</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="file"
                                            class="form-control @error('image') is-invalid @enderror"
                                            id="image"
                                            name="image"
                                            accept="image/*"
                                            aria-describedby="inputGroupFileAddon04"
                                            aria-label="Upload"
                                        />
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nama</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text">
                                            <i class="bx bx-package"></i>
                                        </span>
                                        <input
                                            type="text"
                                            class="form-control @error('nama') is-invalid @enderror"
                                            id="basic-icon-default-fullname"
                                            name="nama"
                                            placeholder="Silahkan isi nama produk"
                                            value="{{ old('nama') }}"
                                            aria-label="Silahkan isi nama produk"
                                            aria-describedby="basic-icon-default-fullname2"
                                        />
                                    </div>
                                    @error('nama')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label" for="basic-icon-default-message">Deskripsi</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-message2" class="input-group-text">
                                            <i class="bx bx-comment-detail"></i>
                                        </span>
                                        <textarea
                                            id="basic-icon-default-message"
                                            class="form-control @error('deskripsi') is-invalid @enderror"
                                            name="deskripsi"
                                            placeholder="Silahkan isi deskripsi produk"
                                            aria-label="Silahkan isi deskripsi produk"
                                            aria-describedby="basic-icon-default-message2"
                                            rows="3"
                                        >{{ old('deskripsi') }}</textarea>
                                    </div>
                                    @error('deskripsi')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label" for="basic-icon-default-phone">Harga</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-phone2" class="input-group-text">
                                            <i class="bx bx-dollar-circle"></i>
                                        </span>
                                        <input
                                            type="number"
                                            id="basic-icon-default-phone"
                                            class="form-control @error('harga') is-invalid @enderror"
                                            name="harga"
                                            placeholder="1000000"
                                            value="{{ old('harga') }}"
                                            step="0.01"
                                            min="0"
                                            aria-label="Harga"
                                            aria-describedby="basic-icon-default-phone2"
                                        />
                                    </div>
                                    @error('harga')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Stok -->
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label" for="basic-icon-default-stok">Stok</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-stok2" class="input-group-text">
                                            <i class="bx bx-package"></i>
                                        </span>
                                        <input
                                            type="number"
                                            id="basic-icon-default-stok"
                                            class="form-control @error('stok') is-invalid @enderror"
                                            name="stok"
                                            placeholder="10"
                                            value="{{ old('stok') }}"
                                            min="0"
                                            aria-label="Stok"
                                            aria-describedby="basic-icon-default-stok2"
                                        />
                                    </div>
                                    @error('stok')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
