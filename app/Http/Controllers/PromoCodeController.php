<?php

namespace App\Http\Controllers;
use App\Models\Coupon;

class PromoCodeController extends Controller
{
    public function getPromoCodes()
    {
        $promoCodes = Coupon::all();
        return response()->json($promoCodes);
    }
}