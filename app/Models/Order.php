<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    // Define the relationship between Order and Payment
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
