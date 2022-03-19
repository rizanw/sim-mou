<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'continent_id'
    ];

    public $timestamps = false;
    protected $primaryKey   = 'id';
    protected $keyType = 'string';

    /**
     * Get the continent that owns the country.
     */
    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }
}
