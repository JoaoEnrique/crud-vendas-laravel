<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $table = 'sale_item';
    protected $fillable = [
        'id_sale',
        'id_product',
        'quantity',
        'price'
    ];
}
