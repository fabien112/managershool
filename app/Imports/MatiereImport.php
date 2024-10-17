<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Session;
use App\Models\Student;
use App\Models\Enseignants;
use App\Models\ClasseEnseignants;
use App\Models\Matieres;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class MatiereImport implements ToCollection, WithHeadingRow

{


    public function collection(Collection $rows)

    {

        $sessions = Session::first();
        $libelleSession = $sessions['libelle_sess'];
        $CodeEtab = $sessions['codeEtab_sess'];

        foreach ($rows as $row) {




            $Matieres =  Matieres::create([

                'libelle' => $row['nom_matiere'],
                'coef' => $row['coef'],
                'cathegory_id' => $row['cathegory'],
                'classe_id' => $row['classe_id'],
                'enseignants_id' => $row['enseignants_id'],
                'affected' => 1,
                'codeEtab' => $CodeEtab,
                'session' => $libelleSession,

            ]);


            // Mettre a jour la table classe_enseignants

            $Data = ClasseEnseignants::create([
                'classe_id' => $Matieres->classe_id,
                'enseignants_id' =>  $Matieres->enseignants_id,
            ]);
        }

        // Mettons le professeur principale ( pas besoin de boucler car on a un fichier par classe)


        // $Data2 = Classe::where('id', $Data->classe_id)->update([

        //     'principale_Classe' => $rows[0]['principale']
        // ]);
    }
}
