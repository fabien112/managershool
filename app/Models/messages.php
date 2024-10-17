<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Messages extends Model
{
    use HasFactory;

    protected $fillable = [
        'classe_id',
        'object',
        'commentaires',
        'destinataires',
        'precis',
        'statut',
        'type',
        'date',
        'session',
        'codeEtab',
        'document',
        'liste_destinataire'
    ];

    public function User () {
        return $this->belongsTo(User::class);
    }
}
