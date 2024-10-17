<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllab extends Model
{
    use HasFactory;

    protected $fillable = [

        'chapitre',
        'date',
        'codeEtab',
        'session',
        'matiere_id',
        'classe_id',
        'enseignant_id',

    ] ;


}
