<?php

namespace App\Models;

use App\Models\Eleves;
use App\Models\Student;
use App\Models\Assigners;
use App\Models\Enseignants;
use App\Models\Etablissement;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'email',
        'password',
        'prenom',
        'datenais',
        'lieunais',
        'genre',
        'telephone',
        'fonction',
        'login',
        'password',
        'photo',
        'type'
    ];

    public function etablissements()
    {

        return $this->belongsToMany(Etablissement::class, 'Assigners');
    }

    public function eleve()
    {

        return $this->hasOne(Student::class);
    }

    public function Enseignants()
    {
        return $this->hasOne(Enseignants::class);
    }





    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
