@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

{{-- Breadcrumb dinamis --}}

<x-breadcrumb :items="[

'Kategori' => route('category.index'),

'Edit Kategori' => ''

]" />

<div class="row">

<div class="mb-4">

<a href="{{ url()->previous() }}" class="btn btn-secondary">

<i class="bx bx-arrow-back"></i> Kembali

</a>

</div>

<div class="col-xxl">

<div class="card mb-4">

<div class="card-header d-flex justify-content-between align-items-center">

<h5 class="mb-0">Edit Kategori</h5>

</div>

<div class="card-body">

<form action="{{ route('category.update', $category->id) }}" method="POST">

@csrf

@method('PUT')

<div class="row mb-3">

<label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nama Kategori</label>

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

placeholder="Silahkan isi nama kategori"

aria-label="Silahkan isi nama kategori"

aria-describedby="basic-icon-default-fullname2"

value="{{ old('nama', $category->nama) }}"

required

minlength="3"

maxlength="255"

/>

@error('nama')

<div class="invalid-feedback">{{ $message }}</div>

@enderror

</div>

</div>

</div>

<div class="row justify-content-end">

<div class="col-sm-10">

<button type="submit" class="btn btn-primary">Update</button>

</div>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

@endsection
