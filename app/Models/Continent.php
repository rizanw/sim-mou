<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    public $timestamps = false;
    protected $primaryKey   = 'id';
    protected $keyType = 'string';

    /**
     * Get the countries for the continent.
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
