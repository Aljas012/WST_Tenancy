<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'mechanic_id',
        'quantity',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo(Inventory::class);
    }
}
