<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discipline extends Model
{
    use HasFactory;

    protected $fillable = [

        'student_id',
        'user_id',
        'classe_id',
        'mois_id',
        'dateHeure',
        'date',
        'type',
        'motif',
        'heure',
        'duree',
        'matiere',
        'session',
        'codeEtab',
        'evaluation_id'
    ];
}


