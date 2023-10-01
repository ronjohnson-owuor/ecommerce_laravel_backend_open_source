<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_quantity',
        'product_image',
        'customer_name',
        'customer_number',
        'customer_email',
        'customer_location',
        'product_price',
        'product_delivered'
    ];
    
}
