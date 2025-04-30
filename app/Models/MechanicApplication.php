<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicApplication extends Model
{
    /** @use HasFactory<\Database\Factories\MechanicApplicationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'address',
        'status',
    ];

    public function mechanic()
    {
        return $this->hasOne(Mechanic::class, 'mechanic_applicant_id', 'id');
    }
}
