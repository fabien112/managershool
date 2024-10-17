<?php

namespace App\Models;

use App\Models\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trimestre extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'session_id','libelle_semes','statut_semes','next_semes','codeEta_semes'
    ];

    public function Session () {
        

        return $this->belongsTo(Session::class);

    }

    

}
