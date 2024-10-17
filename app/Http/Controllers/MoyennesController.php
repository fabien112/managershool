<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Classe;
use App\Models\Session;
use App\Models\Student;
use App\Models\Matieres;
use App\Models\Moyennes;
use App\Models\Trimestre;
use App\Models\Evaluations;
use App\Models\noteAnnuelle;
use Illuminate\Http\Request;
use App\Models\MoyenneAnnuelle;
use App\Models\NotesTrimestres;
use App\Models\MoyenneTrimestres;
use Illuminate\Support\Facades\DB;

class MoyennesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function updateMoyenneAnnuelle(Request $request)


    {


        $idClasse = $request->classeName;
        $code = Classe::where('id', $idClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;

        // Recuperons les Ids de tous les sequenes

        $Evaluations = Evaluations::where('codeEtab', $codeEtab)->get();

        $IdEv1 = $Evaluations[0]->id;
        $IdEv2 = $Evaluations[1]->id;
        $IdEv3 = $Evaluations[2]->id;
        $IdEv4 = $Evaluations[3]->id;
        $IdEv5 = $Evaluations[4]->id;







        noteAnnuelle::where('session', $session)
            ->where('codeEtab', $codeEtab)->where('classe_id', $idClasse)->delete();


        MoyenneAnnuelle::where('session', $session)
            ->where('codeEtab', $codeEtab)->where('classe_id', $idClasse)->delete();


        $classeData = Student::with('user', 'classe')->where('classe_id', $idClasse)
            ->where('session', $session)->where('statut', "!=", 3)
            ->where('codeEtab', $codeEtab)->get();

        $matieres = Matieres::with('Enseignants')->where('classe_id', $idClasse)->get();




        foreach ($classeData as $data) {

            $somme[$data->id] = 0;
            $sommeCoef[$data->id] = 0;

            foreach ($matieres as $matiere) {

                $Notes[$data->id][$matiere->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                    ->where('classe_id', $idClasse)
                    ->where('student_id', $data->id)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->where('matiere_id', $matiere->id)
                    ->where('status', NULL)
                    ->orderBy('matiere_id')
                    ->sum('valeur');


                $Nbrs[$data->id][$matiere->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                    ->where('classe_id', $idClasse)
                    ->where('student_id', $data->id)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->where('matiere_id', $matiere->id)
                    ->where('status', NULL)
                    ->orderBy('matiere_id')
                    ->get();



                $moyenMatiere[$data->id][$matiere->id] = number_format(($Notes[$data->id][$matiere->id]) / count($Nbrs[$data->id][$matiere->id]), 2);




                $resp[$data->id] = noteAnnuelle::create([
                    'matiere_id' => $matiere->id,
                    'classe_id' => $idClasse,
                    'user_id' => $matiere->Enseignants->user_id,
                    'student_id' => $data->id,
                    'valeur' => number_format(($Notes[$data->id][$matiere->id]) / count($Nbrs[$data->id][$matiere->id]), 2),
                    'cat_id' => $matiere->cathegory_id,
                    'codeEtab' => $codeEtab,
                    'session' => $session

                ]);



                $somme[$data->id] = $somme[$data->id] + ($moyenMatiere[$data->id][$matiere->id]) * $matiere->coef;
                $sommeCoef[$data->id] = $sommeCoef[$data->id] + $matiere->coef;
                $moyennennuelle[$data->id] =  number_format($somme[$data->id] / $sommeCoef[$data->id], 3);
            }


            MoyenneAnnuelle::create([
                'classe_id' => $idClasse,
                'student_id' => $data->id,
                'valeur' => $moyennennuelle[$data->id],
                'codeEtab' => $codeEtab,
                'session' => $session

            ]);








            // $Note1[$data->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
            //     ->where('classe_id', $idClasse)
            //     ->where('student_id', $data->id)
            //     ->where('codeEtab', $codeEtab)
            //     ->where('session', $session)
            //     ->orderBy('matiere_id')
            //     ->get();


            // $notesGroupedBySubject = Notes::with('matiere', 'student', 'evaluation', 'user')
            //     ->where('classe_id', $idClasse)
            //     ->where('student_id', $data->id)
            //     ->where('codeEtab', $codeEtab)
            //     ->where('session', $session)
            //     ->select('matiere_id', DB::raw('count(*) as nb_notes'))
            //     ->groupBy('matiere_id')
            //     ->orderBy('matiere_id')
            // ->get();

            // $notesGroupedBySubject[$data->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
            //     ->where('classe_id', $idClasse)
            //     ->where('status',  NULL)
            //     ->where('student_id', $data->id)
            //     ->where('codeEtab', $codeEtab)
            //     ->where('session', $session)
            //     ->select('matiere_id', 'cat_id', DB::raw('sum(valeur) as somme_notes'), DB::raw('count(*) as nb_notes'))
            //     ->groupBy('matiere_id')
            //     ->orderBy('matiere_id')
            //     ->get();


            // foreach ($notesGroupedBySubject as  $subjectData) {


            //     dd($subjectData);

            //     $subjectId = $subjectData['matiere_id'];
            //     $ubjectCat = $subjectData['cat_id'];
            //     $sommeNotes = $subjectData['somme_notes'];
            //     $nbNotes = $subjectData['nb_notes'];
            //     $moyenne = $sommeNotes / $nbNotes;
            // }





        }
    }


    // public function updateMoyenneAnnuelle(Request $request)


    // {


    //     $idClasse = $request->classeName;
    //     $code = Classe::where('id', $idClasse)->first();
    //     $codeEtab = $code->codeEtabClasse;
    //     $session = $code->sessionClasse;

    //     // Recuperons les id de tous les trimestres

    //     $Trimestres = Trimestre::where('codeEta_semes', $codeEtab)->get();

    //     $idTrim1 = $Trimestres[0]->id;
    //     $idTrim2 = $Trimestres[1]->id;
    //     $idTrim3 = $Trimestres[2]->id;



    //     noteAnnuelle::where('session', $session)
    //         ->where('codeEtab', $codeEtab)->where('classe_id', $idClasse)->delete();


    //     MoyenneAnnuelle::where('session', $session)
    //         ->where('codeEtab', $codeEtab)->where('classe_id', $idClasse)->delete();


    //     $NotesTrim1 = NotesTrimestres::with('matiere', 'student',  'user')

    //         ->where('classe_id', $idClasse)
    //         ->where('codeEtab', $codeEtab)
    //         ->where('session', $session)
    //         ->where('trimestre_id', $idTrim1)->orderBy('matiere_id')->get();



    //     $NotesTrim2 = NotesTrimestres::with('matiere', 'student',  'user')

    //         ->where('classe_id', $idClasse)
    //         ->where('codeEtab', $codeEtab)
    //         ->where('session', $session)
    //         ->where('trimestre_id', $idTrim2)->orderBy('matiere_id')->get();

    //     $NotesTrim3 = NotesTrimestres::with('matiere', 'student',  'user')

    //         ->where('classe_id', $idClasse)
    //         ->where('codeEtab', $codeEtab)
    //         ->where('session', $session)
    //         ->where('trimestre_id', $idTrim3)->orderBy('matiere_id')->get();


    //     if ((count($NotesTrim1) || count($NotesTrim2) || count($NotesTrim3)) == 0) {

    //         return response()->json([
    //             'msg' => 'Pas de note pour cette sequence',

    //         ], 403);
    //     }

    //     // Lorsque les notes des deux sequences ont ete saisie dans cette classe

    //     else {


    //         $classeData = Student::with('user', 'classe')->where('classe_id', $idClasse)->where('session', $session)
    //             ->where('codeEtab', $codeEtab)->get();


    //         // dd( $classeData);

    //         foreach ($classeData   as $key => $data) {


    //             $MoyenneTrimestre[$data->id] = MoyenneTrimestres::where('student_id', $data->id)->get();

    //             // dd($MoyenneSequence[$data->id]);

    //             $sommeNoteCoef = 0;
    //             $sommeCoef = 0;
    //             $Note1[$data->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

    //                 ->where('classe_id', $idClasse)
    //                 ->where('student_id', $data->id)
    //                 ->where('codeEtab', $codeEtab)
    //                 ->where('session', $session)
    //                 ->where('trimestre_id', $idTrim1)->orderBy('matiere_id')->get();


    //             // $Note2[$data->id] = Notes::with('matiere', 'student', 'evaluation', 'user')

    //             //     ->where('classe_id', $idClasse)
    //             //     ->where('student_id', $data->id)
    //             //     ->where('codeEtab', $codeEtab)
    //             //     ->where('session', $session)
    //             //     ->where('evaluation_id', $idEval2)->orderBy('matiere_id')->get();



    //             // Je recupere la somme des coef de toutes les matieres dans cette classe


    //             $sommeCoef = Matieres::where('classe_id', $idClasse)->get()->sum('coef');

    //             //dd($sommeCoef);

    //             foreach ($Note1[$data->id] as $key => $note1) {


    //                 // dd($note1->valeur);

    //                 // Je recuper les notes du trimestre 2

    //                 $note2 = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

    //                     ->where('classe_id', $idClasse)
    //                     ->where('student_id', $data->id)
    //                     ->where('matiere_id', $note1->matiere_id)
    //                     ->where('session', $session)
    //                     ->where('codeEtab', $codeEtab)
    //                     ->where('session', $session)
    //                     ->where('trimestre_id', $idTrim2)->orderBy('matiere_id')->first();

    //                 // Je recuper les nites du trimestre 3


    //                 $note3 = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

    //                     ->where('classe_id', $idClasse)
    //                     ->where('student_id', $data->id)
    //                     ->where('matiere_id', $note1->matiere_id)
    //                     ->where('session', $session)
    //                     ->where('codeEtab', $codeEtab)
    //                     ->where('session', $session)
    //                     ->where('trimestre_id', $idTrim3)->orderBy('matiere_id')->first();

    //                 // dd($note1->valeur . '#' . $note2->valeur . '#' . $note3->valeur);

    //                 $MoyennesTrimestre[$data->id] = MoyenneTrimestres::where('student_id', $data->id)->where('session', $session)
    //                     ->where('codeEtab', $codeEtab)
    //                     ->where('session', $session)->get();





    //                 // je recupere ses moyennes des trimestres pour voir s'il etait prent a tous les trimestres

    //                 // si un trimestre est nul on fait la somme des deux autre sinon on fait la somme des 3

    //                 $moyTrim1[$data->id] = $MoyennesTrimestre[$data->id][0]['valeur'];
    //                 $moyTrim2[$data->id] = $MoyennesTrimestre[$data->id][1]['valeur'];
    //                 $moyTrim3[$data->id] = $MoyennesTrimestre[$data->id][2]['valeur'];

    //                 if ($moyTrim1[$data->id] == 0) {

    //                     $noteMatiereAnnuelle[$data->id] = number_format(($note2->valeur + $note3->valeur) / 2, 2);
    //                 } else if ($moyTrim2[$data->id] == 0) {

    //                     $noteMatiereAnnuelle[$data->id] = number_format(($note1->valeur + $note3->valeur) / 2, 2);
    //                 } else if ($moyTrim3[$data->id] == 0) {

    //                     $noteMatiereAnnuelle[$data->id] = number_format(($note2->valeur + $note1->valeur) / 2, 2);
    //                 } else {

    //                     $noteMatiereAnnuelle[$data->id] = number_format(($note1->valeur + $note2->valeur + $note3->valeur) / 3, 2);
    //                 }




    //                 //  dd($noteMatiereTrimestre[$data->id]);



    //                 //  dd('JE ne comprends pas') ;

    //                 // La note du trimestre dans une matiere




    //                 //  $noteMatiereAnnuelle[$data->id] = ($note1->valeur + $note2->valeur+ $note3->valeur) / 3;





    //                 // Ajoutons la note annuelle  dans la bd

    //                 // si le nombre de note dans la table NoteTrimestre est egale au nombre de note saisie dans
    //                 // les tables notes des sequence alors on a deja  rempli la table noteTrimestre et il faut juste la mettre a jour


    //                 // if (count(noteAnnuelle::where('classe_id', $idClasse)->get()) == count($NotesTrim2)) {

    //                 //     $resp = noteAnnuelle::where('trimestre_id', $idTrimestre)->update([

    //                 //         'valeur' =>  $noteMatiereAnnuelle[$data->id],
    //                 //         // 'mention' => $metions,

    //                 //     ]);
    //                 // } else {


    //                 $resp = noteAnnuelle::create([
    //                     'matiere_id' => $note1->matiere->id,
    //                     'classe_id' => $idClasse,
    //                     'user_id' => $note1->user->id,
    //                     'student_id' => $data->id,
    //                     'valeur' =>   $noteMatiereAnnuelle[$data->id],
    //                     // 'mention' => $metions,
    //                     'cat_id' => $note1->cat_id,
    //                     'codeEtab' => $codeEtab,
    //                     'session' => $session

    //                 ]);


    //                 // Calculer la moyenne generale  du trimstre

    //                 // }

    //                 $sommeNoteCoef = $sommeNoteCoef + ($noteMatiereAnnuelle[$data->id] * $note1->matiere->coef);
    //             }

    //             // dd($sommeNoteCoef);

    //             $moyenne[$data->id] =  number_format($sommeNoteCoef / $sommeCoef, 2);

    //             //     // Inserrons la moyenne generale du trimestre  de chaue eleve dans la table moyenneTrimestre



    //             $resp = MoyenneAnnuelle::create([

    //                 'classe_id' => $idClasse,
    //                 'student_id' => $data->id,
    //                 'valeur' => $moyenne[$data->id],
    //                 'codeEtab' => $codeEtab,
    //                 'session' => $session

    //             ]);
    //         }
    //     }
    // }


    public function updateMoyenne(Request $request)

    {

        $idClasse = $request->idClasse;
        $idEvaluation = $request->libelleEvaluation;
        $codeEtab = $request->EtabInfos[0]['codeEtab'];
        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');
        $sessionEncour = $session->libelle_sess;

        $classeData = Student::where('classe_id', $idClasse)->where('session', $sessionEncour)
            ->where('codeEtab', $codeEtab)->where('statut', "!=", 3)->get();


        Moyennes::where('evaluation_id', $idEvaluation)->where('classe_id', $idClasse)
            ->where('session', $sessionEncour)
            ->where('codeEtab', $codeEtab)->delete();


        foreach ($classeData  as $key => $eleve) {

            $datas[$eleve->id] = Notes::with('matiere')
                ->where('evaluation_id', $idEvaluation)
                ->where('classe_id', $idClasse)
                ->where('student_id', $eleve->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $sessionEncour)->get();

            $sommeNoteCoef = 0;
            $sommeCoef = 0;


            foreach ($datas[$eleve->id] as $data) {

                if ($data->status == null) {

                    $sommeNoteCoef = $sommeNoteCoef + ($data->valeur * $data->matiere->coef);

                    $sommeCoef = $sommeCoef + $data->matiere->coef;
                }
            }



            if ($sommeCoef == 0) {
                $moyenne[$eleve->id]  = 0;
            } else {


                if ($idEvaluation == 6) {

                    $moyenne[$eleve->id] =  number_format($sommeNoteCoef / $sommeCoef, 3);
                } else {

                    $moyenne[$eleve->id] =  number_format($sommeNoteCoef / $sommeCoef, 2);
                }
            }

            $resp = Moyennes::create([

                'evaluation_id' => $idEvaluation,
                'classe_id' => $request->idClasse,
                'student_id' => $eleve->id,
                'valeur' =>  $moyenne[$eleve->id],
                //'mention' => $metions,
                'codeEtab' => $codeEtab,
                'session' => $sessionEncour

            ]);
        }
    }



    public function updateNoteTrimestre(Request $request)

    {




        $idClasse = $request->classeName;
        $idTrimestre = $request->libelleEvaluation;
        $code = Classe::where('id', $idClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;


        // Recuperons les id des evaluations correspondant au trimestre dont on a l'id en haut

        $Evalutions = Evaluations::where('trimestre_id', $idTrimestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->get();




        NotesTrimestres::where('trimestre_id', $idTrimestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('classe_id', $idClasse)->delete();


        MoyenneTrimestres::where('trimestre_id', $idTrimestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('classe_id', $idClasse)->delete();



        // Id premiere evaluation de ce trimestre

        $idEval1 = $Evalutions[0]->id;

        if (count($Evalutions) != 2 && $idEval1 != 6) {

            return response()->json([
                'msg' => 'Pas de note evaluation',

            ], 402);
        } else if ($idEval1 == 6) {


            $Notesequen1 = Notes::with('matiere', 'student', 'evaluation', 'user')

                ->where('classe_id', $idClasse)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)
                ->where('evaluation_id', $idEval1)->orderBy('matiere_id')->get();


            if ((count($Notesequen1)) == 0) {

                return response()->json([
                    'msg' => 'Pas de note pour cette sequence',

                ], 403);
            } else {


                $Notesequen1 = Notes::with('matiere', 'student', 'evaluation', 'user')

                    ->where('classe_id', $idClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->where('evaluation_id', $idEval1)->orderBy('matiere_id')->get();

                if (count($Notesequen1) == 0) {

                    return response()->json(
                        [
                            'msg' => 'Pas de note pour cette sequence',

                        ],
                        403
                    );
                } else {

                    $classeData = Student::with('user', 'classe')->where('statut', "!=", 3)->where('classe_id', $idClasse)->where('session', $session)
                        ->where('codeEtab', $codeEtab)->get();


                    foreach ($classeData as $key => $data) {


                        $MoyenneSequence[$data->id][0] = Moyennes::where('student_id', $data->id)->where('evaluation_id', $idEval1)->get();

                        $sommeNoteCoef = 0;

                        $sommeCoef = 0;

                        $Note1[$data->id] = Notes::with('matiere', 'student', 'evaluation', 'user')

                            ->where('classe_id', $idClasse)
                            ->where('student_id', $data->id)
                            ->where('codeEtab', $codeEtab)
                            ->where('session', $session)
                            ->where('evaluation_id', $idEval1)->orderBy('matiere_id')->get();


                        foreach ($Note1[$data->id] as $key => $note1) {


                            if (($note1->status == 1)) {

                                $noteMatiereTrimestre[$data->id] = 0;

                                $noteMatiereTrimestreStatus[$data->id] = 1;
                            } else {

                                $noteMatiereTrimestre[$data->id] = number_format(($note1->valeur), 2);

                                $noteMatiereTrimestreStatus[$data->id] = null;
                            }


                            $resp = NotesTrimestres::create([

                                'trimestre_id' => $idTrimestre,
                                'matiere_id' => $note1->matiere->id,
                                'classe_id' => $idClasse,
                                'user_id' => $note1->user->id,
                                'student_id' => $data->id,
                                'valeur' =>   $noteMatiereTrimestre[$data->id],
                                'status' => $noteMatiereTrimestreStatus[$data->id],
                                'cat_id' => $note1->cat_id,
                                'coef' => $note1->matiere->coef,
                                'codeEtab' => $codeEtab,
                                'session' => $session

                            ]);

                            $sommeCoef = NotesTrimestres::where('classe_id', $idClasse)->where('trimestre_id', $idTrimestre)
                                ->where('student_id', $data->id)->where('status', NULL)->get()->sum('coef');


                            $sommeNoteCoef = $sommeNoteCoef + ($noteMatiereTrimestre[$data->id] * $note1->matiere->coef);

                            if ($sommeCoef == 0) {

                                $moyenne[$data->id] = 0;
                            } else {

                                $moyenne[$data->id] =  number_format($sommeNoteCoef / $sommeCoef, 3);
                            }
                        }

                        //     // Inserrons la moyenne generale du trimestre  de chak eleve dans la table moyenneTrimestre


                        $resp = MoyenneTrimestres::create([

                            'trimestre_id' => $idTrimestre,
                            'classe_id' => $idClasse,
                            'student_id' => $data->id,
                            'valeur' => $moyenne[$data->id],
                            'codeEtab' => $codeEtab,
                            'session' => $session

                        ]);
                    }
                }
            }
        } else {




            // Id seconde  evaluation de ce trimestre

            $idEval2 = $Evalutions[1]->id;



            // Verifions s'il ya les notes de deux sequences pour cette classe


            $Notesequen1 = Notes::with('matiere', 'student', 'evaluation', 'user')

                ->where('classe_id', $idClasse)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)
                ->where('evaluation_id', $idEval1)->orderBy('matiere_id')->get();

            $Notesequen2 = Notes::with('matiere', 'student', 'evaluation', 'user')

                ->where('classe_id', $idClasse)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)
                ->where('evaluation_id', $idEval2)->orderBy('matiere_id')->get();

            // Lorsque les notes des deux sequences n'ont pas ete saisie dans cette classe

            if ((count($Notesequen1) || count($Notesequen2)) == 0) {

                return response()->json([
                    'msg' => 'Pas de note pour cette sequence',

                ], 403);
            }

            // Lorsque les notes des deux sequences ont ete saisie dans cette classe

            else {


                $classeData = Student::with('user', 'classe')->where('statut', "!=", 3)->where('classe_id', $idClasse)->where('session', $session)
                    ->where('codeEtab', $codeEtab)->get();


                // dd( $classeData);

                foreach ($classeData   as $key => $data) {


                    $MoyenneSequence[$data->id][0] = Moyennes::where('student_id', $data->id)->where('evaluation_id', $idEval1)->get();
                    $MoyenneSequence[$data->id][1] = Moyennes::where('student_id', $data->id)->where('evaluation_id', $idEval2)->get();



                    $sommeNoteCoef = 0;

                    $sommeCoef = 0;

                    $Note1[$data->id] = Notes::with('matiere', 'student', 'evaluation', 'user')

                        ->where('classe_id', $idClasse)
                        ->where('student_id', $data->id)
                        ->where('codeEtab', $codeEtab)
                        ->where('session', $session)
                        ->where('evaluation_id', $idEval1)->orderBy('matiere_id')->get();


                    $Note2[$data->id] = Notes::with('matiere', 'student', 'evaluation', 'user')

                        ->where('classe_id', $idClasse)
                        ->where('student_id', $data->id)
                        ->where('codeEtab', $codeEtab)
                        ->where('session', $session)
                        ->where('evaluation_id', $idEval2)->orderBy('matiere_id')->get();



                    // Je recupere la somme des coef de toutes les matieres dans cette classe






                    //dd($sommeCoef);

                    foreach ($Note1[$data->id] as $key => $note1) {


                        $note2 = Notes::with('matiere', 'student', 'evaluation', 'user')

                            ->where('classe_id', $idClasse)
                            ->where('student_id', $data->id)
                            ->where('matiere_id', $note1->matiere_id)
                            ->where('session', $session)
                            ->where('codeEtab', $codeEtab)
                            ->where('session', $session)
                            ->where('evaluation_id', $idEval2)->orderBy('matiere_id')->first();



                        if ($idEval1 == 6) {

                            $noteMatiereTrimestre[$data->id] = ($note1->valeur);
                        } else {



                            if (($note1->status == 1 && $note2->status == null) || ($note2->status == 1 && $note1->status == null)) {

                                $noteMatiereTrimestre[$data->id] = ($note1->valeur + $note2->valeur);

                                $noteMatiereTrimestreStatus[$data->id] = null;
                            } else if ($note1->status == 1 &&  $note2->status == 1) {

                                $noteMatiereTrimestre[$data->id] = 0;

                                $noteMatiereTrimestreStatus[$data->id] = 1;
                            } else {

                                $noteMatiereTrimestre[$data->id] = number_format(($note1->valeur + $note2->valeur) / 2, 2);

                                $noteMatiereTrimestreStatus[$data->id] = null;
                            }
                        }




                        // Ajoutons la note du trimestre dans la bd

                        // si le nombre de note dans la table NoteTrimestre est egale au nombre de note saisie dans
                        // les tables notes des sequence alors on a deja  rempli la table noteTrimestre et il faut juste la mettre a jour





                        $resp = NotesTrimestres::create([

                            'trimestre_id' => $idTrimestre,
                            'matiere_id' => $note1->matiere->id,
                            'classe_id' => $idClasse,
                            'user_id' => $note1->user->id,
                            'student_id' => $data->id,
                            'valeur' =>   $noteMatiereTrimestre[$data->id],
                            'status' => $noteMatiereTrimestreStatus[$data->id],
                            'cat_id' => $note1->cat_id,
                            'coef' => $note1->matiere->coef,
                            'codeEtab' => $codeEtab,
                            'session' => $session

                        ]);





                        $sommeCoef = NotesTrimestres::where('classe_id', $idClasse)->where('trimestre_id', $idTrimestre)
                            ->where('student_id', $data->id)->where('status', NULL)->get()->sum('coef');



                        $sommeNoteCoef = $sommeNoteCoef + ($noteMatiereTrimestre[$data->id] * $note1->matiere->coef);

                        if ($sommeCoef == 0) {

                            $moyenne[$data->id] = 0;
                        } else {

                            $moyenne[$data->id] =  number_format($sommeNoteCoef / $sommeCoef, 3);
                        }
                    }









                    //     // Inserrons la moyenne generale du trimestre  de chaue eleve dans la table moyenneTrimestre


                    $resp = MoyenneTrimestres::create([

                        'trimestre_id' => $idTrimestre,
                        'classe_id' => $idClasse,
                        'student_id' => $data->id,
                        'valeur' => $moyenne[$data->id],
                        // 'mention' => $metions,
                        'codeEtab' => $codeEtab,
                        'session' => $session

                    ]);
                }
            }
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
