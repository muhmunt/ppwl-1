<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function history()
    {
        $orderProducts = OrderProduct::whereHas('order', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['product', 'order'])
            ->latest()
            ->get();

        return view('user.riwayat', ['orders' => $orderProducts]);
    }
}
