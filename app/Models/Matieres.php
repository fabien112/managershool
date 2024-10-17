<?php

namespace App\Models;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matieres extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'libelle', 'codeEtab', 'session', 'coef', 'classe' . 'teacher', 'classe_id',
        'enseignants_id', 'cathegory_id', 'affected'
    ];

    public function Enseignants()
    {

        return $this->belongsTo(Enseignants::class);
    }

    public function Classe()
    {

        return $this->belongsTo(Classe::class);
    }
}
