<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteType extends Model
{
    use HasFactory;

    /**
     * Get the institutes for the InstituteType.
     */
    public function institutes()
    {
        return $this->hasMany(Institute::class);
    }
}
