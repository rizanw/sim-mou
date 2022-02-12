<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * Get the continent that owns the country.
     */
    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }
}
