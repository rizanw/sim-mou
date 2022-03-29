<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    use Loggable;

    /**
     * The institutions that belong to the Contact.
     */
    public function institutions()
    {
        return $this->belongsToMany(Institution::class);
    }
}
