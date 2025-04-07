<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['id','order_no', 'user_id', 'price', 'quantity', 'total'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y/m/d');
    }
}
