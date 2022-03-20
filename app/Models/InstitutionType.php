<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionType extends Model
{
    use HasFactory;

    /**
     * Get the institutions for the InstituteType.
     */
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
}
