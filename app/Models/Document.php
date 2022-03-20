<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * Get the programs for the Document.
     * many-to-many relationship
     */
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'documents_programs', 'document_id', 'program_id');
    }
}