<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class libelleMatieres extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'libelle','codeEtab','session' ];
}
