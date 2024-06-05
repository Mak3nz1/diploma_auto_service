<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
class OrdersController extends Controller
{
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['orderDetails', 'car', 'service'])
            ->latest('car_date')
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->car_date)->format('Y-m-d');
            });
    
        return view('pages.orders', compact('orders'));
    }
    
}