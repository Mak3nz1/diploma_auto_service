<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model

{   protected $table = 'orders';

    // Define the primary key for the table
    protected $primaryKey = 'order_id';
    public $timestamps = false;
     protected $fillable = [
        'user_id',
        'car_id',
        'service_id',
        'status',
        'car_date',
        'car_time',
        'order_date',
        'payment_method', 
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
{
    return $this->belongsTo(Car::class, 'car_id');
}

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function orderDetails()
    {
        return $this->hasOne(OrderDetail::class, 'order_id');
    }
}