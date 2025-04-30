<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /** @use HasFactory<\Database\Factories\SettingsFactory> */
    use HasFactory;

    protected $fillable = [
        'color',
        'font',
        'incentive_percentage',
        'layout',
        'menu_order',
    ];

    protected $casts = [
        'menu_order' => 'array',
    ];
}
