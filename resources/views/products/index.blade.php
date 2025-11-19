@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Breadcrumb dinamis --}}
        <x-breadcrumb :items="[
            'Dashboard' => route('dashboard'),
            'Produk' => route('products.index'),
            'Daftar Produk' => ''
        ]" />

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(request('search'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bx bx-info-circle me-2"></i>
                Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-light ms-2">
                    <i class="bx bx-x me-1"></i> Hapus Filter
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Responsive Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-package text-primary fs-4"></i>
                    <h5 class="mb-0 fw-bold">Daftar Produk</h5>
                    @if(request('search'))
                        <span class="badge bg-info">Pencarian Aktif</span>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Search Form -->
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2" id="searchForm">
                        <div class="input-group" style="width: 280px;">
                            <span class="input-group-text">
                                <i class="bx bx-search"></i>
                            </span>
                            <input 
                                type="text" 
                                name="search"
                                id="searchInput"
                                class="form-control"
                                placeholder="Cari produk..."
                                value="{{ request('search') }}"
                                autocomplete="off"
                            >
                            @if(request('search'))
                                <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()" title="Hapus pencarian">
                                    <i class="bx bx-x"></i>
                                </button>
                            @endif
                        </div>
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bx bx-search me-1"></i> Cari
                        </button>
                    </form>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Tambah Produk
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;" class="text-center">No</th>
                                <th style="width: 100px;" class="text-center">Foto</th>
                                <th>Nama</th>
                                <th style="width: 120px;">Kategori</th>
                                <th style="width: 200px;">Deskripsi</th>
                                <th style="width: 120px;" class="text-end">Harga</th>
                                <th style="width: 80px;" class="text-center">Stok</th>
                                <th style="width: 120px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                    <td class="text-center">
                                        @if($product->foto)
                                            <img 
                                                src="{{ asset('storage/' . $product->foto) }}" 
                                                alt="{{ $product->nama }}" 
                                                class="img-thumbnail rounded" 
                                                style="width: 80px; height: 80px; object-fit: cover;"
                                                onerror="this.src='{{ asset('assets/img/default-product.png') }}'"
                                            />
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 80px; height: 80px;">
                                                <i class="bx bx-image text-muted fs-4"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $product->nama }}</div>
                                    </td>
                                    <td>
                                        @if($product->kategori)
                                            <span class="badge bg-label-primary">
                                                <i class="bx bx-category me-1"></i>{{ $product->kategori->nama }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $product->deskripsi }}">
                                            {{ Str::limit($product->deskripsi, 50) }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-semibold text-success">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($product->stok > 0)
                                            <span class="badge bg-label-success">{{ $product->stok }}</span>
                                        @else
                                            <span class="badge bg-label-danger">Habis</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger" onclick="deleteConfirm('{{ $product->id }}', '{{ addslashes($product->nama) }}')" title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-package text-muted" style="font-size: 48px;"></i>
                                            <p class="text-muted mt-3 mb-0">Tidak ada data produk</p>
                                            @if(request('search'))
                                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="bx bx-x me-1"></i> Hapus Filter
                                                </a>
                                            @else
                                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="bx bx-plus me-1"></i> Tambah Produk Pertama
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if($products->hasPages() || request('search'))
                    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-muted">
                            @if(request('search'))
                                Menampilkan {{ $products->total() }} hasil pencarian untuk "{{ request('search') }}"
                            @else
                                Menampilkan {{ $products->firstItem() ?? 0 }} sampai {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} data
                            @endif
                        </div>
                        <div>
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteConfirm(id, nama) {
            Swal.fire({
                title: 'Yakin mau hapus produk ini?',
                text: "Produk '" + nama + "' akan dihapus. Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Fungsi untuk clear search
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            window.location.href = '{{ route('products.index') }}';
        }

        // Enter key untuk submit search
        document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });

        // Auto focus pada search input jika ada hasil pencarian
        @if(request('search'))
            document.getElementById('searchInput')?.focus();
        @endif
    </script>
@endpush
