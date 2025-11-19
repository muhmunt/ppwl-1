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

        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">
                            <i class="bx bx-plus-circle text-primary me-2"></i>
                            Tambah Produk Baru
                        </h4>
                        <p class="text-muted mb-0">Lengkapi form di bawah untuk menambahkan produk baru</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary" style="color: white !important;">
                        <h5 class="mb-0" style="color: white !important;">
                            <i class="bx bx-package me-2"></i>
                            Informasi Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                            @csrf

                            <!-- Foto Produk -->
                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label fw-semibold" for="foto">
                                    <i class="bx bx-image text-primary me-1"></i>
                                    Foto Produk <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="card border-2 border-dashed" id="uploadArea" style="cursor: pointer; transition: all 0.3s;">
                                        <div class="card-body text-center p-4">
                                            <div id="uploadPlaceholder">
                                                <i class="bx bx-cloud-upload text-primary" style="font-size: 48px;"></i>
                                                <p class="mt-3 mb-1 fw-semibold">Klik untuk upload atau drag & drop</p>
                                                <p class="text-muted small mb-0">Format: JPEG, PNG, JPG, GIF, SVG, WEBP (Maks. 2MB)</p>
                                            </div>
                                            <input
                                                type="file"
                                                name="foto"
                                                class="d-none @error('foto') is-invalid @enderror"
                                                id="foto"
                                                accept="image/*"
                                                onchange="previewImage(this)"
                                                required
                                            />
                                        </div>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail rounded" style="width: 150px; height: 150px; object-fit: cover;">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Preview Foto</h6>
                                                        <p class="text-muted small mb-2" id="fileName"></p>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImage()">
                                                            <i class="bx bx-trash me-1"></i> Hapus Foto
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @error('foto')
                                        <div class="alert alert-danger mt-2 mb-0">
                                            <i class="bx bx-error-circle me-1"></i>
                                            <strong>Error:</strong> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Informasi Dasar -->
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="bx bx-info-circle me-1"></i>
                                Informasi Dasar
                            </h6>

                            <!-- Nama -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-semibold" for="basic-icon-default-fullname">
                                    Nama Produk <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text">
                                            <i class="bx bx-package"></i>
                                        </span>
                                        <input
                                            type="text"
                                            name="nama"
                                            class="form-control @error('nama') is-invalid @enderror"
                                            id="basic-icon-default-fullname"
                                            placeholder="Contoh: Meja Kantor Kayu Jati"
                                            aria-label="Nama Produk"
                                            aria-describedby="basic-icon-default-fullname2"
                                            value="{{ old('nama') }}"
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
                                <label class="col-sm-3 col-form-label fw-semibold" for="kategori_id">
                                    Kategori <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
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
                                                <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
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
                                <label class="col-sm-3 col-form-label fw-semibold" for="basic-icon-default-message">
                                    Deskripsi <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span id="basic-icon-default-message2" class="input-group-text align-items-start pt-3">
                                            <i class="bx bx-comment-detail"></i>
                                        </span>
                                        <textarea
                                            name="deskripsi"
                                            id="basic-icon-default-message"
                                            class="form-control @error('deskripsi') is-invalid @enderror"
                                            placeholder="Jelaskan detail produk, spesifikasi, dan keunggulan produk..."
                                            aria-label="Deskripsi Produk"
                                            aria-describedby="basic-icon-default-message2"
                                            rows="5"
                                            required
                                        >{{ old('deskripsi') }}</textarea>
                                    </div>
                                    <div class="form-text">Jelaskan produk secara detail untuk membantu pelanggan memahami produk Anda</div>
                                    @error('deskripsi')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Informasi Harga & Stok -->
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="bx bx-dollar-circle me-1"></i>
                                Informasi Harga & Stok
                            </h6>

                            <div class="row">
                                <!-- Harga -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold" for="basic-icon-default-harga">
                                        Harga <span class="text-danger">*</span>
                                    </label>
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
                                            value="{{ old('harga') }}"
                                            step="1"
                                            min="0"
                                            required
                                        />
                                    </div>
                                    <div class="form-text">Masukkan harga dalam Rupiah (tanpa titik atau koma)</div>
                                    @error('harga')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Stok -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold" for="basic-icon-default-stok">
                                        Stok <span class="text-danger">*</span>
                                    </label>
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
                                            value="{{ old('stok', 0) }}"
                                            min="0"
                                            required
                                        />
                                    </div>
                                    <div class="form-text">Jumlah stok produk yang tersedia</div>
                                    @error('stok')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                            <i class="bx bx-x me-1"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bx bx-save me-1"></i> Simpan Produk
                                        </button>
                                    </div>
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
        // Upload area click handler
        document.getElementById('uploadArea').addEventListener('click', function() {
            document.getElementById('foto').click();
        });

        // Drag and drop functionality
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('foto');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadArea.classList.add('border-primary');
            uploadArea.style.backgroundColor = '#f0f4ff';
        }

        function unhighlight(e) {
            uploadArea.classList.remove('border-primary');
            uploadArea.style.backgroundColor = '';
        }

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            previewImage(fileInput);
        }

        // Preview image before upload
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');
            const fileName = document.getElementById('fileName');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                    uploadPlaceholder.style.display = 'none';
                    fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                uploadPlaceholder.style.display = 'block';
            }
        }

        // Remove image
        function removeImage() {
            const fileInput = document.getElementById('foto');
            const preview = document.getElementById('imagePreview');
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');
            
            fileInput.value = '';
            preview.style.display = 'none';
            uploadPlaceholder.style.display = 'block';
        }

        // Format harga input
        document.getElementById('basic-icon-default-harga')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Format harga on blur (add thousand separator for display)
        document.getElementById('basic-icon-default-harga')?.addEventListener('blur', function(e) {
            if (this.value) {
                const formatted = parseInt(this.value).toLocaleString('id-ID');
                // Store original value in data attribute
                this.setAttribute('data-display', formatted);
            }
        });
    </script>
@endpush

