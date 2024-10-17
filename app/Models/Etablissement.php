<?php

namespace App\Models;

use App\Models\User;

use App\Models\Session;
use App\Models\Assigners;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etablissement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'codeEtab', 'libelleEtab', 'sigleEtab', 'sloganEtab', 
        'emailEtab', 'datecreationEtab', 'principaltelEtab', 'secondairetelEtab', 
        'villeEtab', 'paysEtab','sitewebEtab','directeurEtab','mixteEtab ','groupstateEtab','groupnameEtab',
        'typeEtab','principalteldirecteurEtab','adresseEtab','logoEtab'
    ];

    public function users() {

        return $this->belongsToMany(User::class,'Assigners');

    }

    public function Sessions () {
        return $this->hasMany(Session::class);
    }

    
}
