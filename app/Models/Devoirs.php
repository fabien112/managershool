<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devoirs extends Model
{
    use HasFactory;


    protected $fillable = [

        'matiere_id',
        'classe_id',
        'enseignants_id',
        'libelle',
        'dateLimite',
        'document',
        'statut',
        'verouiller',
        'support',
        'instructions',
        'imageLogo',
        'session',
        'codeEtab',
    ];

    public function Matiere  () {
        return $this->belongsTo(Matiere::class);
    }

    public function Enseignants  () {
        return $this->belongsTo(Enseignants::class);
    }

    public function Classe  () {
        return $this->belongsTo(Classe::class);
    }

}
