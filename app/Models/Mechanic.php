<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    /** @use HasFactory<\Database\Factories\MechanicFactory> */
    use HasFactory;

    public function mechanicApplication()
    {
        return $this->belongsTo(MechanicApplication::class, 'mechanic_applicant_id', 'id');
    }

    // public function cars()
    // {
    //     return $this->hasMany(Car::class);
    // }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function incentives()
    {
        return $this->hasMany(Incentives::class); 
    }
}
