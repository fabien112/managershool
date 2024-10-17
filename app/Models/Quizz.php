<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Questions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quizz extends Model
{
    use HasFactory;

    protected $fillable = [

        'matiere_id',
        'user_id',
        'classe_id',
        'libelle',
        'consigne',
        'instruction',
        'date',
        'duree',
        'verrouiller',
        'statut',
        'codeEtab',
        'session'

    ];

    public function Matiere  () {
        return $this->belongsTo(Matiere::class);
    }

    public function Question  () {
        return $this->hasMany(Questions::class);
    }

    public function User  () {
        return $this->belongsTo(User::class);
    }

    public function Classe  () {
        return $this->belongsTo(Classe::class);
    }
}
