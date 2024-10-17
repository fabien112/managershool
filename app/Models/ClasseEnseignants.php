<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseEnseignants extends Model
{
    use HasFactory;
    protected $fillable = [
        'classe_id',
        'enseignants_id',
        'codeEtab',
        'session'
    ];
}
