<?php

namespace App\Imports;

use App\Models\Enseignants;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class EnseignantsImport implements ToCollection, WithHeadingRow

{
    public function collection(Collection $rows)

    {


        // dd($rows);



        $sessions = Session::first();
        $libelleSession = $sessions['libelle_sess'];
        $CodeEtab = $sessions['codeEtab_sess'];

        foreach ($rows as $row) {

            $user = User::create([

                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'email' => $row['email'],
                'telephone' => $row['telephone'],
                'genre' => $row['genre'],
                'login' => $row['login'],
                'password' => bcrypt($row['password']),
                'type' => 'Enseignant'

            ]);

            // dd($row['genre']);


            $teachers =  Enseignants::create([

                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'email' => $row['email'],
                'tel' => $row['telephone'],
                'matricule' => $row['matricule'],
                'user_id' => $user->id,
                'sexe' => $row['genre'],
                'statut' => $row['statut'],
                // 'nationalite' => $row['nationalite'],
                // 'salaire' => $row['salaireheure'],
                // 'situation' => $row['situation'], // Maritalement parlant
                // 'dateEmbauche' => $row['dateembauche'],
                'codeEtab' => $CodeEtab,
                'session' => $libelleSession


            ]);
        }
    }
}
