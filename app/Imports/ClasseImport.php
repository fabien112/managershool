<?php

namespace App\Imports;

use App\Models\Classe;
use App\Models\User;
use App\Models\Session;
use App\Models\Student;
use App\Models\Enseignants;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class ClasseImport implements ToCollection, WithHeadingRow

{


    public function collection(Collection $rows)

    {

        $sessions = Session::first();
        $libelleSession = $sessions['libelle_sess'];
        $CodeEtab = $sessions['codeEtab_sess'];



        foreach ($rows as $row) {



                $classes =  Classe::create([

                    'libelleClasse' => $row['nom'],
                    'inscription_Classe' => $row['fraistranche2'],  // tranche 2
                    'scolarite_Classe' => $row['fraistranche1'],    // TRanche 1
                    'scolariteaff_Classe' => $row['fraisape'], //APE
                    'emp_Classe' => $row['phototimetable'],
                    'codeEtabClasse' => $CodeEtab,
                    'sessionClasse' => $libelleSession,

                // 'codeEtab'=>$row['codeetab'],
                // 'session'=>$row['session']

            ]);
        }
    }
}
