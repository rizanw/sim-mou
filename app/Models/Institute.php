<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;

    /**
     * Get the units for the Institute.
     */
    public function units()
    {
        return $this->hasMany(InstituteUnit::class);
    }

    /**
     * Get the country that owns the Institute.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the type that owns the Institute.
     */
    public function instituteType()
    {
        return $this->belongsTo(InstituteType::class);
    }
}
