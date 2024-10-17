<?php

namespace App\Models;

use App\Models\Enseignants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'libelle', 'codeEtab', 'session', 'coef', 'classe' . 'teacher',
        'cath', 'classe_id', 'affected'
    ];


    public function Enseignants()

    {

        return $this->belongsToMany(Enseignants::class);
    }
}
