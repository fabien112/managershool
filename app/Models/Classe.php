<?php

namespace App\Models;


use App\Models\Eleves;
use App\Models\Student;
use App\Models\Enseignants;
use App\Models\Spectialites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [

        'id',
        'libelleClasse',
        'inscription_Classe',
        'statutClasse',
        'scolarite_Classe',
        'scolariteaff_Classe',
        'reinscription_Classe',
        'codeEtabClasse',
        'sessionClasse',
        'emp_Classe',
        'cycles_id',
        'filieres_id',
        'specialite_id'
    ];


    public function eleves()
    {

        return $this->hasMany(Student::class);
    }

    public function Enseignants()
    {
        return $this->belongsToMany(Enseignants::class);
    }

    public function Filieres()
    {
        return $this->belongsTo(Fillieres::class);
    }

    public function Spectialites()
    {
        return $this->belongsTo(Spectialites::class);
    }
}
