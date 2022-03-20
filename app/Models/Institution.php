<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    /**
     * Get one level of child the Institution.
     */
    public function institutions()
    {
        return $this->hasMany(Institution::class, 'parent_id');
    }

    /**
     * Get childs of the Institution.
     * recursive relationship
     */
    public function childInstitutions()
    {
        return $this->hasMany(Institution::class, 'parent_id')->with('institutions');
    }

    /**
     * Get one level of parent of the Institution.
     */
    public function parent()
    {
        return $this->belongsTo(Institution::class, 'parent_id');
    }

    /**
     * Get parents of the Institution.
     */
    public function parents()
    {
        return $this->belongsTo(Institution::class, 'parent_id')->with('parents');
    }

    /**
     * Get the type that owns the Institution.
     */
    public function institutionType()
    {
        return $this->belongsTo(InstitutionType::class);
    }

    /**
     * Get the country that owns the Institution.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * The contacts that belong to the Institution.
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }

    /**
     * The documents that belong to the Institution.
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
