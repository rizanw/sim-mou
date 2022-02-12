<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    use HasFactory;


    /**
     * Get the countries for the continent.
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
