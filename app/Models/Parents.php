<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parents extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomParent',
        'prenomParent',
        'user_id',
        'telParent',
        'emailParent',
        'cniParent',
        'professionParent',
        'nationaliteParent',
        'sexeParent',
        'addressParent',
        'session',
        'codeEtab'

    ];



}
