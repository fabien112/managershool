<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabs extends Model
{
    use HasFactory;
    protected $fillable = [

        'chapitre',
        'date',
        'codeEtab',
        'duree',
        'session',
        'matiere_id',
        'classe_id',
        'user_id',

    ] ;

    public function Matiere  () {
        return $this->belongsTo(Matiere::class);
    }

    public function Objectif  () {
        return $this->hasMany(ObjectifSyllabs::class);
    }

    public function Partie  () {
        return $this->hasMany(partiesyl::class);
    }



    public function User  () {
        return $this->belongsTo(User::class);
    }

    public function Classe  () {
        return $this->belongsTo(Classe::class);
    }
}
