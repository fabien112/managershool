<?php

namespace App\Models;

use App\Models\Syllabs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Books extends Model
{
    use HasFactory;

    protected $fillable = [

        'classe_id',
        'user_id',
        'mois_id',
        'matiere_id',
        'syllabs_id',
        'date',
        'duree',
        'codeEtab',
        'session',
    ];

    public function Matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function Syllabs()
    {
        return $this->belongsTo(Syllabs::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Classe()
    {
        return $this->belongsTo(Classe::class);
    }


}
