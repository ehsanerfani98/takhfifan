<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_document_id',
        'path',
    ];

    public function userDocument()
    {
        return $this->belongsTo(UserDocument::class);
    }
}
