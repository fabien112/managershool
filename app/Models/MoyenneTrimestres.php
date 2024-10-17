<?php

namespace App\Models;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MoyenneTrimestres extends Model
{
    use HasFactory;

    protected $fillable = [

        'trimestre_id',
        'classe_id',
        'student_id',
        'valeur',
        'mention',
        'codeEtab',
        'session',
        'coef'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
