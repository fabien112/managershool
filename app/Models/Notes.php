<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Matieres;
use App\Models\Evaluations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = [

        'trimestre_id',
        'matiere_id',
        'evaluation_id',
        'classe_id',
        'student_id',
        'user_id',
        'valeur',
        'mention',
        'status',
        'cat_id',
        'codeEtab',
        'session'

    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function matiere()
    {

        return $this->belongsTo(Matieres::class);
    }


    public function classe()
    {

        return $this->belongsTo(Classe::class);
    }

    public function evaluation()
    {

        return $this->belongsTo(Evaluations::class);
    }


    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
