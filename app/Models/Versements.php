<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Versements extends Model
{
    use HasFactory;

    protected $fillable = [

        'classe_id',
        'student_id',
        'codeEtab',
        'session',
        'date',
        'code',
        'motif',
        'mois',
        'mode',
        'deposant',
        'receptionneur',
        'montantverser'

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
