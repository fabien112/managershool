<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Matieres;
use App\Models\Enseignants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tabletimes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_jour',
        'id_heureD',
        'id_heureF',
        'enseignant_id',
        'matiere_id',
        'matiere',
        'classe_id',


    ] ;


    public function classe () {

        return $this->belongsTo(Classe::class);

    }

    public function enseignant () {

        return $this->belongsTo(Enseignants::class);

    }

    public function matiere () {

        return $this->belongsTo(Matieres::class);

    }


}
