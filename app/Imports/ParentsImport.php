<?php

namespace App\Imports;

use App\Models\Parents;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class ParentsImport implements ToCollection, WithHeadingRow

{
    public function collection(Collection $rows)

    {


        $sessions = Session::first();
        $libelleSession = $sessions['libelle_sess'];
        $CodeEtab = $sessions['codeEtab_sess'];



        foreach ($rows as $row) {


            $user = User::create([

                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'email' => $row['email'],
                'telephone' => $row['telephone'],
                // 'genre'=>$row['genre'],
                // 'login'=>$row['login'],
                // 'password'=>bcrypt($row['password']),
                'type' => 'Parent'

            ]);

            $parent =  Parents::create([

                'nomParent' => $row['nom'],
                'prenomParent' => $row['prenom'],
                'emailParent' => $row['email'],
                'telParent' => $row['telephone'],
                'user_id' => $user->id,
                // 'nationaliteParent'=>$row['nationalite'],
                // 'professionParent'=>$row['profession'],
                //'sexeParent' => $row['genre'],
                'codeEtab' => $CodeEtab,
                'session' => $libelleSession

            ]);
        }
    }
}
