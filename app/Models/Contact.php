<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * Get the institute that owns the Contact
     */
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
}
