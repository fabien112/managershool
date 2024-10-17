<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cahier extends Model
{
    use HasFactory;
    protected $fillable = [

        'classe_id',
        'matiere_id',
        'enseignants_id',
        'dateDeb',
        'dateFin',
        'document',
        'statut',
        'codeEtab',
        'session',
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
