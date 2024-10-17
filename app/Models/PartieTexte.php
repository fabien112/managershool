<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartieTexte extends Model
{
    use HasFactory;


    protected $fillable = [

        'textes_id',
        'partie_syllabs _id',
        'souspartie',
        'codeEtab',
        'session',
    ] ;
}
