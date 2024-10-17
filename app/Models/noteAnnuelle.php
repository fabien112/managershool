<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class noteAnnuelle extends Model
{
    use HasFactory;

    protected $fillable = [

        'matiere_id',
        'cat_id',
        'classe_id',
        'student_id',
        'user_id',
        'valeur',
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
