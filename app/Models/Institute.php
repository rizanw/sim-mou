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
     * Get the Institute that owns the type.
     */
    public function type()
    {
        return $this->belongsTo(InstituteType::class);
    }
}
