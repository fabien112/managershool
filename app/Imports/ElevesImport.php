<?php

namespace App\Imports;

use DateTime;
use App\Models\User;
use App\Models\Session;
use App\Models\Student;
use App\Models\Enseignants;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class ElevesImport implements ToCollection, WithHeadingRow

{


    protected $classeId;

    // Constructeur pour recevoir classeId
    public function __construct($classeId)
    {
        $this->classeId = $classeId;
    }


    public function collection(Collection $rows)

    {



        $sessions = Session::first();
        $libelleSession = $sessions['libelle_sess'];
        $CodeEtab = $sessions['codeEtab_sess'];



        foreach ($rows as $row) {





            // Convertir la chaine en objet DateTime
            $date = DateTime::createFromFormat('d/m/Y', $row['datenaiss']);

            // Si la conversion est réussie, formater la date pour le champ HTML de type 'date'
            if ($date) {
                // Format ISO 8601 'Y-m-d' requis pour les champs de type 'date'
                $formattedDate = $date->format('Y-m-d');
            } else {
                $formattedDate = ''; // Valeur vide si la date est incorrecte
            }





            // $dateNaiss = explode('-', $row['datenaiss']);

            // $row['datenaiss'] = $dateNaiss[2] . "-" . $dateNaiss[1] . "-" . $dateNaiss[0];


            $user = User::create([

                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'email' => 'test@gmail.com',
                'datenais' =>  $row['datenaiss'],
                'photo' => 'test.png',
                'lieunais' => $row['lieunaiss'],
                'genre' => $row['genre'],
                'login' => 'hello',
                'password' => bcrypt('hello'),
                'type' => 'Eleve'
            ]);



            // $code = "24LTM";

            // if ($user->id < 10) {

            //     $matricule = $code . '000' . $user->id;
            // }

            // if ($user->id >= 10 && $user->id < 100) {

            //     $matricule = $code . '00' . $user->id;
            // }

            // if ($user->id >= 100 && $user->id < 1000) {

            //     $matricule = $code . '0' . $user->id;
            // }

            // if ($user->id > 1000 && $user->idv < 10000) {

            //     $matricule = $code . $user->id;
            // }




            $Student =  Student::create([

                'user_id' => $user->id,
                'parent_id' => 2160,
                'classe_id' => $this->classeId,
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'nationalite' => 'CMR', //
                'statut' => $row['statut'], // ce champs dit s'il est nouveau ou ancien eleve , j'ai utulise nationalite dans la bb et statut dans le fichier
                'matricule' => '00000',
                'dateNaiss' => $formattedDate,
                'lieuNaiss' =>  $row['lieunaiss'],
                'sexe' => $row['genre'],
                'email' => 'test@gmail.com',
                'doublant' => $row['doublant'],
                'codeEtab' => $CodeEtab,
                'session' => $libelleSession,



            ]);
        }
    }
}
