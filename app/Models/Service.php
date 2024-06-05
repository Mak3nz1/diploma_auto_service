<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service',
        'description',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'service_id');
    }
    public function getPrice()
    {
        
        return $this->price;
    }
    public function coupons()
{
    return $this->hasMany(Coupon::class);
}
    public function latestService()
{
    return Service::where('user_id', auth()->id())->latest('order_date')->first();
}
}