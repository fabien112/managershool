<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classe;
use App\Models\Matieres;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enseignants extends Model

{
    use HasFactory;

    protected $fillable = [

        'nom',
        'prenom',
        'user_id',
        'matricule',
        'tel',
        'email',
        'nationalite',
        'sexe',
        'situation',
        'matricule',
        'salaire',
        'dateEmbauche',
        'type',
        'statut',
        'state',
        'codeEtab',
        'session',
        'nationalite'
    ];


    public function Matieres()
    {
        return $this->hasMany(Matieres::class);
    }

    public function Classe()
    {
        return $this->belongsToMany(Classe::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
