<?php

namespace App\Models;

use App\Models\Trimestre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'libelle_sess', 'codeEtab_sess', 'datedeb_sess', 'datefin_sess', 'type_sess' ,'encours_sess','status_sess','etablissement_id'
    ];

    public function Trimestres () {
        
        return $this->hasMany(Trimestre::class);

    }

    public function Etablissement () {
        
        return $this->belongsTo(Etablissement::class);

    }
}
