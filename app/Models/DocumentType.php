<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;
    use Loggable;

    /**
     * Get the documents for the DocumentType.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
