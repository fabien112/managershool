<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salaires extends Model
{
    use HasFactory;

    protected $fillable = [

        'mois_id',
        'user_id',
        'banque_id',
        'type',
        'date',
        'sexe',
        'salire',
        'motif',
        'date',
        'role',
        'montant',
        'genre',
        'session',
        'codeEtab'

    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function mois()
    {
        return $this->belongsTo(Mois::class);
    }
}
