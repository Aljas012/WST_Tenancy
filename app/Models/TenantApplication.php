<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantApplication extends Model
{
    /** @use HasFactory<\Database\Factories\TenantApplicationFactory> */
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'contact',
        'business',
        'domain',
        'subscription',
    ];

    public function tenantInfo()
    {
        return $this->hasOne(TenantInfo::class);
    }
}
