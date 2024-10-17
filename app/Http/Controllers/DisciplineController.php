<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\notif;
use App\Models\Session;
use App\Models\Trimestre;
use App\Models\discipline;
use App\Models\Evaluations;
use App\Models\Presences;
use App\Models\Student;
use Illuminate\Http\Request;

class DisciplineController extends Controller

{


    public function delateCension(Request $request)
    {


        $idPresence = $request->id;

        $this->validate($request, [

            'id' => 'required'

        ]);

        discipline::where('id',  $idPresence)->delete();
    }


    public function updateCension(Request $request)
    {



        $idPresence = $request->idPresence;


        // $absence = Presences::where('id', $request->id)->first();

        // $idPres = $absence['id'];

        $this->validate($request, [

            'duree' => 'required|numeric|min:1',

            'idPresence' => 'required'

        ]);

        discipline::where('id',  $idPresence)->update([
            'duree' => (int)$request->duree,
            'motif' => $request->motif

        ]);
    }

    public function addSencion(Request $request)
    {

        $request->validate([
            'mode' => 'required',
            'montant' => "required|numeric"

        ]);

        $trimestre = Trimestre::where('statut_semes', 1)->first();

        $evaluation = Evaluations::where('statut', 1)->first();

        $session = Session::with('etablissement')->first();

        $nomEcole = $session['etablissement']['libelleEtab'];

        $nomEleve = $request->eleveId['nom'];

        $prenomEleve = $request->eleveId['prenom'];

        $idparent = $request->eleveId['parent']['id'];

        $Classe = Classe::where('id', $request->eleveId['classe_id'])->first('libelleClasse');


        $libelleClasse = $Classe->libelleClasse;



        $user = discipline::Create([

            'student_id' => $request->eleveId['id'],
            'user_id' => 1,
            'classe_id' => $request->eleveId['classe_id'],
            'motif' => $request->motif,
            'mois_id' => $trimestre->id,
            'evaluation_id' => $evaluation->id,
            'duree' => $request->montant,
            'type' => $request->mode,
            'session' => $session->libelle_sess,
            'codeEtab' => $session->codeEtab_sess,

        ]);

        // Envoyer la notification au parent

        if ($request->mode == 'ex') {

            $data2 = notif::Create([

                'titre' => " Etablissement $nomEcole",
                'parent_id' =>  $idparent,
                'statut' => 0,
                'contenu' =>  " L'élève $nomEleve $prenomEleve en classe de $libelleClasse a été envoyé  en  consigne aujourd'hui pendant $request->montant heure(s) pour $request->motif.",

            ]);
        }

        if ($request->mode == 'con') {

            $data2 = notif::Create([

                'titre' => " Etablissement $nomEcole",
                'parent_id' =>  $idparent,
                'statut' => 0,
                'contenu' =>  " L'élève $nomEleve $prenomEleve en classe de $libelleClasse a reçu une exclusion aujourd'hui de  $request->montant jour(s) pour $request->motif.",

            ]);
        }
    }
    public function getAlldiscipline(Request  $request)

    {

        $infosCon = discipline::where('student_id', $request->idEleve)->where('type', 'con')->get();


        $infosEx = discipline::where('student_id', $request->idEleve)->where('type', 'ex')->get();


        $totalExc =  discipline::where('student_id', $request->idEleve)->where('type', 'ex')->sum('duree');

        $totalCon =  discipline::where('student_id', $request->idEleve)->where('type', 'con')->sum('duree');

        $datas =  array(

            'totalCon' =>  $totalCon,
            'totalExc' => $totalExc,
            'infosCon' => $infosCon,
            'infosEx' => $infosEx

        );


        return response()->json($datas);
    }


    public function AddabsenceSg(Request $request)
    { {


            $dat = Classe::where('id', $request->classeName)->first();

            $codeEtab = $dat->codeEtabClasse;

            $session = $dat->sessionClasse;


            //     // je recupere l 'id du trimestre de cette evaluation


            //     $value =  Evaluations::where('id', $request->libelleEvaluation)->first();


            //    $trimestreId = $value->trimestre_id ;

            $trimestreId = $request->libelleEvaluation;



            $notes = $request->Note;

            // validons les notes qui arrivent


            // on voit d'abord si le tableau notes est totalement vides

            if ($notes == []) {

                return response()->json([
                    'msg' => 'Aucune notes saisies',

                ], 403);
            } else {


                foreach ($notes as $valide) {

                    // Ensuite on verifie chaque note pour s'assurer quelle est bonne


                    if ($valide < 0) {

                        return response()->json([
                            'msg' => 'Soit la note est mauvaise, soit negative',

                        ], 402);
                    }
                }
            }



            // Les notes sont bonnes je peux continuer

            $eleves = $request->Classes;



            //je recupere les id de tous les elves


            foreach ($eleves  as $eleve) {

                $IdEleve = $eleve['id'];

                // Ajouter les notes dans la BD

                $this->validate($request, [

                    'classeName' => 'required|numeric',
                    'libelleEvaluation' => 'required|numeric',

                ]);

                // Je m'assure que je ne mest pas les notes deux fois pour la meme seq et matiere


                if (Presences::where('trimestre_id', $request->libelleEvaluation)->where('student_id', $IdEleve)

                    ->where('classe_id', $request->classeName)->exists()
                ) {


                    return response()->json([
                        'msg' => 'Existe deja',

                    ], 401);
                } else {


                    $data = Presences::Create([

                        'student_id' => $IdEleve,
                        'user_id' => 1,
                        'classe_id' => $request->classeName,
                        // 'dateHeure' => $datetime,
                        // 'date' => $date,
                        // 'heure' => $heure,
                        //'matiere' => $matiere,
                        // 'mois_id' => $trimestreId,
                        'trimestre_id' => $request->libelleEvaluation,
                        'etat' => 0,
                        'duree' =>  $notes[$IdEleve],
                        'session' => $session,
                        'codeEtab' => $codeEtab,

                    ]);
                }
            }
        }
    }

    public function getStudentBySg2(Request $request)
    {

        $Eleves = Student::where('classe_id', $request->classeName)->get();

        foreach ($Eleves as  $Ideleve) {

            $abs = Presences::where('student_id', $Ideleve->id)->where('trimestre_id', $request->libelleEvaluation)->sum('duree');


            $absJust = Presences::where('student_id', $Ideleve->id)->where('trimestre_id', $request->libelleEvaluation)->sum('etat');


            $idAbs = Presences::where('student_id', $Ideleve->id)->where('trimestre_id', $request->libelleEvaluation)->first();

            // dd($idAbs['id']);

            $Ideleve['heure'] = $abs;
            $Ideleve['heurejustif'] = $absJust;
            $Ideleve['id'] = $idAbs['id'];
        }

        return response()->json($Eleves);
    }

    public function justifierabsence(Request $request)
    {


        Presences::where('id', $request->id)->update([
            'etat' => (int)$request->data,

        ]);
    }
}
