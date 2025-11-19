@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome {{ Auth::user()->name }}! 🎉</h5>
                                <p class="mb-4">
                                    You're logged in as <span class="fw-bold">{{ ucfirst(Auth::user()->role) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
