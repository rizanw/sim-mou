<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * Get the documents for the Program.
     * many-to-many relationship
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'documents_programs', 'program_id', 'document_id');
    }
}
