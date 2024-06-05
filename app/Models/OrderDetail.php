<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'promo_code',
        'payment_method',
        'address',
        'total_amount',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    
}
