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

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <div class="mb-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>

            <!-- Basic with Icons -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center" style="color: white !important;">
                        <h5 class="mb-0" style="color: white !important;">
                            <i class="bx bx-edit me-2"></i>
                            Edit Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Foto -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="foto">Foto</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">
                                            <i class="bx bx-image"></i>
                                        </span>
                                        <input
                                            type="file"
                                            name="foto"
                                            class="form-control @error('foto') is-invalid @enderror"
                                            id="foto"
                                            aria-describedby="fotoHelp"
                                            aria-label="Upload"
                                            accept="image/*"
                                            onchange="previewImage(this)"
                                        />
                                    </div>
                                    <div id="fotoHelp" class="form-text">Format: JPEG, PNG, JPG, GIF, SVG, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</div>
                                    @error('foto')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Preview Foto Lama -->
                                    @if($product->foto)
                                        <div class="mt-3">
                                            <label class="form-label">Foto Saat Ini:</label>
                                            <div>
                                                <img 
                                                    src="{{ asset('storage/' . $product->foto) }}" 
                                                    alt="Foto Produk" 
                                                    class="img-thumbnail rounded" 
                                                    id="currentImage"
                                                    style="max-width: 200px; max-height: 200px; object-fit: cover;"
                                                    onerror="this.src='{{ asset('assets/img/default-product.png') }}'"
                                                >
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Preview Foto Baru -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <label class="form-label">Preview Foto Baru:</label>
                                        <div>
                                            <img id="previewImg" src="" alt="Preview" class="img-thumbnail rounded" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
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
                                            name="nama"
                                            class="form-control @error('nama') is-invalid @enderror"
                                            id="basic-icon-default-fullname"
                                            placeholder="Silahkan isi nama produk"
                                            aria-label="Silahkan isi nama produk"
                                            aria-describedby="basic-icon-default-fullname2"
                                            value="{{ old('nama', $product->nama) }}"
                                            required
                                            maxlength="255"
                                        />
                                    </div>
                                    @error('nama')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kategori_id">Kategori</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-kategori2" class="input-group-text">
                                            <i class="bx bx-category"></i>
                                        </span>
                                        <select 
                                            name="kategori_id" 
                                            id="kategori_id" 
                                            class="form-select @error('kategori_id') is-invalid @enderror"
                                            aria-describedby="basic-icon-default-kategori2"
                                            required
                                        >
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    {{ old('kategori_id', $product->kategori_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('kategori_id')
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
                                            name="deskripsi"
                                            id="basic-icon-default-message"
                                            class="form-control @error('deskripsi') is-invalid @enderror"
                                            placeholder="Silahkan isi deskripsi produk"
                                            aria-label="Silahkan isi deskripsi produk"
                                            aria-describedby="basic-icon-default-message2"
                                            rows="4"
                                        >{{ old('deskripsi', $product->deskripsi) }}</textarea>
                                    </div>
                                    @error('deskripsi')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label" for="basic-icon-default-harga">Harga</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-harga2" class="input-group-text">
                                            <i class="bx bx-dollar-circle"></i>
                                        </span>
                                        <input
                                            type="number"
                                            name="harga"
                                            id="basic-icon-default-harga"
                                            class="form-control @error('harga') is-invalid @enderror"
                                            placeholder="1000000"
                                            aria-label="Harga"
                                            aria-describedby="basic-icon-default-harga2"
                                            value="{{ old('harga', $product->harga) }}"
                                            step="1"
                                            min="0"
                                            required
                                        />
                                    </div>
                                    <div class="form-text">Masukkan harga tanpa titik atau koma</div>
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
                                            name="stok"
                                            id="basic-icon-default-stok"
                                            class="form-control @error('stok') is-invalid @enderror"
                                            placeholder="10"
                                            aria-label="Stok"
                                            aria-describedby="basic-icon-default-stok2"
                                            value="{{ old('stok', $product->stok) }}"
                                            min="0"
                                            required
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
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i> Update
                                    </button>
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                        <i class="bx bx-x me-1"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview image before upload
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const currentImage = document.getElementById('currentImage');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                    // Hide current image when new image is selected
                    if (currentImage) {
                        currentImage.style.opacity = '0.5';
                    }
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                // Show current image again if file input is cleared
                if (currentImage) {
                    currentImage.style.opacity = '1';
                }
            }
        }

        // Format harga input (optional - bisa dihapus jika tidak diperlukan)
        document.getElementById('basic-icon-default-harga')?.addEventListener('input', function(e) {
            // Remove non-numeric characters except decimal point
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@endpush
