<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'id_issuing',
        'id_receptor',
    ];

    // Relación con el usuario que emite el comentario
    public function issuingUser()
    {
        return $this->belongsTo(User::class, 'id_issuing');
    }

    // Relación con el usuario que recibe el comentario
    public function receptorUser()
    {
        return $this->belongsTo(User::class, 'id_receptor');
    }
}
