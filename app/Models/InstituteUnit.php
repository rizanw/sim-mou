<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteUnit extends Model
{
    use HasFactory;

    /**
     * Get the continent that owns the country.
     */
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
}
