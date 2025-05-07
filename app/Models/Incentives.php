<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incentives extends Model
{
    /** @use HasFactory<\Database\Factories\IncentivesFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'mechanic_id',
        'percentage',
        'incentive',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
