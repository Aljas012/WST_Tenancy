<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory;

    protected $fillable = [
        'category',
        'quantity',
        'part_number',
        'description',
        'price'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class); 
    }

    public function incentive()
    {
        return $this->hasMany(Incentives::class); 
    }
}
