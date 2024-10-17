<?php

namespace App\Models;

use App\Models\Trimestre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluations extends Model
{
    use HasFactory;

    protected $fillable = [

        'trimestre_id', 'libelle','statut','dateDeb','dateFin', 'codeEtab','session'
    ];

    public function trimestre(){
        return $this->belongsTo(Trimestre::class);
    }
}
