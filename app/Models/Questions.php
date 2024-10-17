<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $fillable = [

        'quizz_id',
        'mode_reponse',
        'libelle_question',
        'resp_question',
        'point'

    ];
}
