<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;
    protected $fillable = [
        'designation',
        'lieucontriexg',
        'amountlieucontriexg', // Montant contre-extrait

        'lieucontripar',
        'amountlieucontripar', // Montant contribution parent

        'lieufraistimbre',
        'amountlieufraistimbre', // Montant frais timbre

        'lieufraisexam',
        'amountlieufraisexam', // Montant frais examen

        'section',
    ];
}
