<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Parents;
use App\Models\Versements;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [

        'nom',
        'prenom',
        'user_id',
        'parent_id',
        'classe_id',
        'matricule',
        'email',
        'nationalite',
        'sexe',
        'dateNaiss',
        'lieuNaiss',
        'statut',
        'codeEtab',
        'session',
        'user_id',
        'classe',
        'parent2_id',
        'dateNaiss',
        'lieuNaiss',
        'doublant'

    ];

    public function versements()
    {

        return $this->hasMany(Versements::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
