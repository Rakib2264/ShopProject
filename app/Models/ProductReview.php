<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
    'customer_id',
    'product_id',
    'description',
    'rating',
];


     public function profile()
    {
        return $this->belongsTo(CustomerProfile::class, 'customer_id');
    }

       public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
