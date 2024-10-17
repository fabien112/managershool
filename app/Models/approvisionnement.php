<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approvisionnement extends Model
{
    use HasFactory;

    protected $fillable = [

        'mois_id',
        'banque_id',
        'date',
        'date',
        'montant',
        'session',
        'codeEtab'

    ];
}
