<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectifSyllabs extends Model
{
    use HasFactory;

    protected $fillable = [

        'syllabs_id',
        'libelle',
        'codeEtab',
        'session'

    ] ;


}
