<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partiebooks extends Model
{
    use HasFactory;

    protected $fillable = [

        'books_id',
        'partie',
        'souspartie',
        'codeEtab',
        'session',
    ] ;

}
