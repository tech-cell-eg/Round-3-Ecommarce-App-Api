<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'stock', 'image_url'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients');
    }
}
