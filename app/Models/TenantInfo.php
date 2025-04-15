<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantInfo extends Model
{
    /** @use HasFactory<\Database\Factories\TenantInfoFactory> */
    use HasFactory;

    protected $fillable = [
        'subscription_start_date',
        'subscription_end_date',
        'application_status',
        'domain_status'
    ];

    public function tenantApplication()
    {
        return $this->belongsTo(TenantApplication::class);
    }
}
