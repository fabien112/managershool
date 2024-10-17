<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Enseignants;
use PDF;
use App\Models\Notes;
use App\Models\Session;
use App\Models\Student;
use App\Models\Matieres;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Evaluations;
use App\Models\Matiere;
use App\Models\NotesTrimestres;
use App\Models\Trimestre;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function AnnulerSequence(Request $request)

    {





        $idEval = $request->datas['libelleEvaluation'];


        $trimestre = Evaluations::where('id', $idEval)->first();


        $idtrim = $trimestre['trimestre_id'];

        // Supprimer les notes au cas ou elles existent

        Notes::where('student_id', $request->id)->where('evaluation_id', $idEval)->delete();


        foreach ($request->matiere as $value) {

            $data = Notes::create([

                'evaluation_id' =>  $idEval,
                'trimestre_id' => $idtrim,
                'matiere_id' => $value['id'],
                'classe_id' => $request->classe_id,
                'student_id' => $request->id,
                'user_id' => Enseignants::where('id', $value['enseignants_id'])->first('user_id')['user_id'],
                'valeur' => 0,
                'cat_id' => $value['cathegory_id'],
                'codeEtab' => $request->codeEtab,
                'session' => $request->session,
                'status' => 1

            ]);
        }
    }


    public function BlamerNoteteacher(Request $request)

    {


        Notes::where('id', $request['idNote'])->update([

            // ce zero sera pris en compte dans le bulletin  car statut == null

            'status' => null,
            'valeur' => 0
        ]);
    }

    public function BlamerNote(Request $request)
    {

        // ce zero sera pris en compte dans le bulletin  car statut == null



        $dataFormats =  Notes::where('id', $request["note"]['id'])->update([

            'status' => null,
            'valeur' => 0
        ]);
    }

    public function JustifierNoteteacher(Request $request)
    {



        // ce zero ne sera pris en compte dans le bulletin  car statut == 1


        Notes::where('id', $request['idNote'])->update([

            'status' => 1,
            'valeur' => 0
        ]);
    }

    public function justifierNote(Request $request)
    {

        // ce zero ne sera pris en compte dans le bulletin  car statut == 1


        Notes::where('id', $request["note"]['id'])->update([

            'status' => 1,
            'valeur' => 0
        ]);
    }

    public function getBulletinEleveByParentTrimestre(Request $request)
    {




        $idClasse = $request->datasEnfant['classe']['id'];

        $idEvaluation = $request->libelleEvaluation;

        $idEleve = $request->datasEnfant['id'];

        $session = $request->datasEnfant['classe']['sessionClasse'];

        $codeEtab = $request->datasEnfant['classe']['codeEtabClasse'];


        $datas = NotesTrimestres::with('matiere', 'user')
            ->where('trimestre_id', $idEvaluation)
            ->where('classe_id', $idClasse)
            ->where('student_id', $idEleve)
            ->where('codeEtab', $codeEtab)
            ->where('session', $session)

            ->get();
        $sommeNoteCoef = 0;
        $sommeCoef = 0;

        foreach ($datas as $data) {

            $sommeNoteCoef = $sommeNoteCoef + ($data->valeur * $data->matiere->coef);

            $sommeCoef = $sommeCoef + $data->matiere->coef;
        }

        $moyenne =  number_format($sommeNoteCoef / $sommeCoef, 2);
        // if ($sommeCoef == 0) {
        //     $moyenne = "-";
        // } else {


        // }



        $dataFormats = [
            'datas' => $datas,
            'moyenne' => $moyenne
        ];



        return response()->json($dataFormats);
    }

    public function getBulletinEleveByParent(Request $request)
    {

        $idClasse = $request->datasEnfant['classe']['id'];

        $idEvaluation = $request->libelleEvaluation;

        $idEleve = $request->datasEnfant['id'];

        $session = $request->datasEnfant['classe']['sessionClasse'];

        $codeEtab = $request->datasEnfant['classe']['codeEtabClasse'];


        $datas = Notes::with('matiere', 'user')
            ->where('evaluation_id', $idEvaluation)
            ->where('classe_id', $idClasse)
            ->where('student_id', $idEleve)
            ->where('codeEtab', $codeEtab)
            ->where('session', $session)->get();
        $sommeNoteCoef = 0;
        $sommeCoef = 0;

        foreach ($datas as $data) {

            $sommeNoteCoef = $sommeNoteCoef + ($data->valeur * $data->matiere->coef);

            $sommeCoef = $sommeCoef + $data->matiere->coef;
        }

        $moyenne =  number_format($sommeNoteCoef / $sommeCoef, 2);
        // if ($sommeCoef == 0) {
        //     $moyenne = "-";
        // } else {


        // }



        $dataFormats = [
            'datas' => $datas,
            'moyenne' => $moyenne
        ];



        return response()->json($dataFormats);
    }


    public function getBulletinEleve(Request $request)
    {


        $idClasse = $request->classeId;


        $sessions = Classe::where('id', $idClasse)->first();

        $codeEtab  =  $sessions->codeEtabClasse;

        $session = $sessions->sessionClasse;

        $idEvaluation = $request->libelleEvaluation;

        $eleves = Student::where('classe_id',  $idClasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();


        foreach ($eleves as $eleve) {


            $eleve->matiere = Matiere::where('classe_id', $idClasse)->orderBy('id', 'ASC')->get();


            foreach ($eleve->matiere   as $matiere) {

                $note[$matiere->id] = Notes::where('evaluation_id', $request->libelleEvaluation)
                    ->where('student_id', $eleve->id)
                    ->where('matiere_id', $matiere->id)
                    ->where('session', $session)->first();

                $matiere->note =  $note[$matiere->id];

                $matiere->idElve = $eleve->id;

                if ($note[$matiere->id] != null) {

                    $matiere->status = $note[$matiere->id]['status'];
                } else {

                    $matiere->status = null;
                }

                // $matiere->status = $note[$matiere->id]['status'];
            }
        }


        $dataFormats = ($eleves);





        return response()->json($dataFormats);
    }


    public function  AddNoteAlone(Request $request)

    {

        // dd($request);


        $this->validate($request, [

            'idEleve' => 'required|numeric',
            'idClasse' => 'required|numeric',
            'libelleEvaluation' => 'required|numeric',
            'matiere' => 'required|numeric',
            'note' => 'required|numeric|min:0|max:20'

        ]);





        // Ici je recupere juste le code etab et la session grace a la matiere venant du front

        $matiere = Matiere::where('id',  $request->matiere)->first();
        $idMatiere = $matiere->id;
        $codeEtab = $matiere->codeEtab;
        $session = $matiere->session;
        $cat = $matiere->cathegory_id;



        $trimestre = Evaluations::where('id', $request->libelleEvaluation)->first();


        if (Notes::where('evaluation_id', $request->libelleEvaluation)->where('student_id', $request->idEleve)

            ->where('matiere_id', $idMatiere)->where('classe_id', $request->idClasse)->exists()
        ) {


            return response()->json([
                'msg' => 'Existe deja',

            ], 401);
        } else {


            // if ($notes[$IdEleve] >= 0 && $notes[$IdEleve] < 10) {
            //     $metions = 'Non acquis';
            // }


            // if ($notes[$IdEleve] >= 10 && $notes[$IdEleve] <= 14) {
            //     $metions = 'ECA';
            // }

            // if ($notes[$IdEleve] > 14 && $notes[$IdEleve] <= 17) {
            //     $metions = 'Acquis';
            // }

            // if ($notes[$IdEleve] > 17 && $notes[$IdEleve] <= 20) {
            //     $metions = 'Expert';
            // }


            $data = Notes::create([

                'trimestre_id' => $trimestre->trimestre_id,
                'matiere_id' => $idMatiere,
                'evaluation_id' => $request->libelleEvaluation,
                'classe_id' => $request->idClasse,
                'student_id' => $request->idEleve,
                'user_id' => $request->users['id'],
                'valeur' => $request->note,
                'cat_id' => $cat,
                // 'mention' => $metions,
                'codeEtab' => $codeEtab,
                'session' => $session

            ]);
        }
    }

    public function  AddNotelocale(Request $request)

    {






        $notes = $request->Note;

        // validons les notes qui arrivent


        // on voit d'abord si le tableau notes est totalement vides

        if ($notes == []) {

            return response()->json([
                'msg' => 'Aucune notes saisies',

            ], 403);
        } else {


            foreach ($notes as $key => $valide) {


                if ($valide < 0 ||  $valide > 20) {

                    return response()->json([
                        'msg' => 'Inf a 0 ou sup a 20 ou  null ',

                    ], 405);
                }
            }
        }



        // Les notes sont bonnes je peux continuer

        $eleves = $request->Classes;

        // Ici je recupere juste le code etab et la session grace a la matiere venant du front

        $matiere = Matiere::where('id',  $request->matiere)->first();
        $idMatiere = $matiere->id;
        $codeEtab = $matiere->codeEtab;
        $session = $matiere->session;
        $cat = $matiere->cathegory_id;

        // Je recupere l'id du trimestre correspondants a la sequence

        $trimsetres = Evaluations::where('id', $request->libelleEvaluation)->first();

        $idTrimsetre = $trimsetres->trimestre_id;

        //je recupere les id de tous les elves


        foreach ($eleves  as $eleve) {

            $IdEleve = $eleve['id'];

            // Ajouter les notes dans la BD

            $this->validate($request, [

                'idClasse' => 'required|numeric',
                'libelleEvaluation' => 'required|numeric',
                // 'trimestre' => 'required|numeric',
                'matiere' => 'required',
            ]);

            // Je m'assure que je ne mest pas les notes deux fois pour la meme seq et matiere


            if (Notes::where('evaluation_id', $request->libelleEvaluation)->where('student_id', $IdEleve)

                ->where('matiere_id', $idMatiere)->where('classe_id', $request->idClasse)->exists()
            ) {


                return response()->json([
                    'msg' => 'Existe deja',

                ], 401);
            } else {



                // Je dois recuperer l'id du prof de la matiere dans cette classe


                $matiere = Matieres::with('enseignants')->where('id', $idMatiere)->first();

                //  dd($matiere->enseignants['user_id']);





                //  statuts => 1 : Il ne sera pas pris en coompte dans le bulletin

                //  statuts => NULL : Il sera pas pris en coompte dans le bulletin


                if ($request->choice == 0) {

                    $data = Notes::create([

                        'trimestre_id' => $idTrimsetre,
                        'matiere_id' => $idMatiere,
                        'evaluation_id' => $request->libelleEvaluation,
                        'classe_id' => $request->idClasse,
                        'student_id' => $IdEleve,
                        'user_id' => $matiere->enseignants['user_id'],
                        'valeur' => $notes[$IdEleve],
                        'cat_id' => $cat,
                        // 'status' => 1, // Il ne sera pas pris en coompte dans le bulletin
                        'codeEtab' => $codeEtab,
                        'session' => $session

                    ]);
                } else {

                    $data = Notes::create([

                        'trimestre_id' => $idTrimsetre,
                        'matiere_id' => $idMatiere,
                        'evaluation_id' => $request->libelleEvaluation,
                        'classe_id' => $request->idClasse,
                        'student_id' => $IdEleve,
                        'user_id' => $matiere->enseignants['user_id'],
                        'valeur' => $notes[$IdEleve],
                        'cat_id' => $cat,
                        'status' => 1, // Il ne sera pas pris en coompte dans le bulletin
                        'codeEtab' => $codeEtab,
                        'session' => $session

                    ]);
                }
            }
        }
    }

    public function  AddNote(Request $request)

    {

        $notes = $request->Note;


        // validons les notes qui arrivent


        // on voit d'abord si le tableau notes est totalement vides

        if ($notes == []) {

            return response()->json([
                'msg' => 'Aucune notes saisies',

            ], 403);
        } else {


            foreach ($notes as $key => $valide) {


                // $this->validate($notes, [

                //     'key' => 'required|numeric',

                // ]);

                // Ensuite on verifie chaque note pour s'assurer quelle est bonne



                // if ($valide == null) {

                //     return response()->json([
                //         'msg' => ' null genre on avait rien mis',

                //     ], 405);
                // }


                if ($valide < 0 ||  $valide > 20) {

                    return response()->json([
                        'msg' => 'Inf a 0 ou sup a 20 ou  null ',

                    ], 405);
                }
            }
        }



        // Les notes sont bonnes je peux continuer

        $eleves = $request->Classes;

        // Ici je recupere juste le code etab et la session grace a la matiere venant du front

        $matiere = Matiere::where('classe_id', $request->idClasse)->where('libelle', $request->matiere)->first();
        $idMatiere = $matiere->id;
        $codeEtab = $matiere->codeEtab;
        $session = $matiere->session;
        $cat = $matiere->cathegory_id;




        //je recupere les id de tous les elves


        foreach ($eleves  as $eleve) {

            $IdEleve = $eleve['id'];

            // Ajouter les notes dans la BD

            $this->validate($request, [

                'idClasse' => 'required|numeric',
                'libelleEvaluation' => 'required|numeric',
                'trimestre' => 'required|numeric',
                'matiere' => 'required',
            ]);

            // Je m'assure que je ne mest pas les notes deux fois pour la meme seq et matiere


            if (Notes::where('evaluation_id', $request->libelleEvaluation)->where('student_id', $IdEleve)

                ->where('matiere_id', $idMatiere)->where('classe_id', $request->idClasse)->exists()
            ) {


                return response()->json([
                    'msg' => 'Existe deja',

                ], 401);
            } else {






                $data = Notes::create([

                    'trimestre_id' => $request->trimestre,
                    'matiere_id' => $idMatiere,
                    'evaluation_id' => $request->libelleEvaluation,
                    'classe_id' => $request->idClasse,
                    'student_id' => $IdEleve,
                    'user_id' => $request->users['id'],
                    'valeur' => $notes[$IdEleve],
                    //  'status' => 1, : La note ne sera pas pries en compte dans le bulletin et  Null sera pris en compte
                    'cat_id' => $cat,
                    'codeEtab' => $codeEtab,
                    'session' => $session

                ]);
            }
        }
    }

    public function getBulletinPdf($id)

    {


        // Je recupere le codeEtab, la session et l'id de la classe

        $data =  explode('*', $id);

        $IdEleve = $data[0];
        $codeEtab  = $data[1];
        $sessionEncour  = $data[2];
        $idEvaluation = $data[3];
        $idClasse = $data[4];

        $eleves = Student::with('classe', 'user')->where('classe_id', $idClasse)
            ->where('id', $IdEleve)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->first();


        $datas = Notes::with('matiere', 'user', 'evaluation')
            ->where('evaluation_id', $idEvaluation)
            ->where('classe_id', $idClasse)
            ->where('student_id', $IdEleve)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->get();
        $sommeNoteCoef = 0;
        $sommeCoef = 0;

        foreach ($datas as $data) {

            $sommeNoteCoef = $sommeNoteCoef + ($data->valeur * $data->matiere->coef);

            $sommeCoef = $sommeCoef + $data->matiere->coef;
        }

        $moyenne =  number_format($sommeNoteCoef / $sommeCoef, 2);


        $dataFormats = [
            'datas' => $datas,
            'moyenne' => $moyenne
        ];

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $matiere = $dataFormats['datas'];

        $moyenne = $dataFormats['moyenne'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  getStudentByTeacherVoirNote(Request $request)

    {

        $matiere = Matiere::where('id', $request->matiere)->first();
        $codeEtab = $matiere->codeEtab;
        $session = $matiere->session;

        $datas = Student::with('user')->where('classe_id', $request->idClasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();


        foreach ($datas as $data) {


            $dat[$data->id] = Notes::where('matiere_id', $request->matiere)->where('evaluation_id', $request->libelleEvaluation)
                ->where('classe_id', $request->idClasse)->where('student_id', $data->id)->where('codeEtab', $codeEtab)
                ->where('session', $session)->first();



            // $data->valeur = $dat[$data->id]['valeur'] ;
            // $data->mention = $dat[$data->id]['mention'];
            // $data->idNote = $dat[$data->id]['id'];

            if ($dat[$data->id] == null) {

                $data->valeur = null;
                $data->idNote  = null;
            } else {

                $data->valeur = $dat[$data->id]['valeur'];
                // $data->mention = $dat[$data->id]['mention'];
                $data->idNote = $dat[$data->id]['id'];
                $data->statusNote = $dat[$data->id]['status'];
            }
        }

        // $datas = Notes::with('student')->where('matiere_id', $request->matiere)->where('evaluation_id', $request->libelleEvaluation)
        //     ->where('classe_id', $request->idClasse)->where('codeEtab', $codeEtab)
        //     ->where('session', $session)->get();

        return response()->json($datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function updateNote2(Request $request)
    {






        if ($request->dec == 0) {


            $idMatiere = $request->reste['id'];
            $codeEtab = $request->reste['codeEtab'];
            $session = $request->reste['session'];
            $idClasse = $request->reste['classe_id'];
            $cat = $request->reste['cathegory_id'];
            $idEval = $request->reste['Ideval'];
            $idEleve = $request->reste['idElve'];

            $trimestre = Evaluations::where('id', $idEval)->first();
            $trimestreId =   $trimestre->trimestre_id;




            // Id du  prof de la matiere


            $matiere = Matieres::with('enseignants')->where('id', $idMatiere)->first();

            $userTeacher = $matiere->enseignants['user_id'];


            $this->validate($request, [

                'note' => 'required|numeric|min:0|max:20',
                //'mention' => 'required',

            ]);


            $data = Notes::create([
                'trimestre_id' => $trimestreId,
                'matiere_id' =>  $idMatiere,
                'evaluation_id' => $idEval,
                'classe_id' => $idClasse,
                'student_id' => $idEleve,
                'user_id' =>  $userTeacher,
                'valeur' => $request->note,
                'cat_id' => $cat,
                // 'mention' => $metions,
                'codeEtab' => $codeEtab,
                'session' => $session

            ]);
        }
        if ($request->dec == 1) {



            $this->validate($request, [

                'idNote' => 'required|numeric|min:1',
                'note' => 'required|numeric|min:0|max:20',
                //'mention' => 'required',

            ]);

            Notes::where('id',  $request->idNote)->update([

                'valeur' => $request->note,
                'status' => null,

                // 'mention' =>$request->mention,
            ]);
        }
    }
    public function updateNote(Request $request)
    {





        // si la note existe deja je la met juste a jour , sinon je la cree


        if ($request->dec == 0) {


            $matiere = Matiere::where('id',  $request->reste['matiere'])->first();
            $idMatiere = $matiere->id;
            $codeEtab = $matiere->codeEtab;
            $session = $matiere->session;
            $cat = $matiere->cathegory_id;



            $trimestre = Evaluations::where('id',  $request->reste['libelleEvaluation'])->first();
            $trimestreId =   $trimestre->trimestre_id;




            // Id du  prof de la matiere


            $matiere = Matieres::with('enseignants')->where('id', $idMatiere)->first();

            //  dd($matiere->enseignants['user_id']);


            $this->validate($request, [

                'note' => 'required|numeric|min:0|max:20',
                //'mention' => 'required',

            ]);


            $data = Notes::create([
                'trimestre_id' => $trimestreId,
                'matiere_id' => $request->reste['matiere'],
                'evaluation_id' => $request->reste['libelleEvaluation'],
                'classe_id' => $request->reste['idClasse'],
                'student_id' => $request->eleveId,
                'user_id' => $matiere->enseignants['user_id'],
                'valeur' => $request->note,
                'cat_id' => $cat,
                // 'mention' => $metions,
                'codeEtab' => $codeEtab,
                'session' => $session

            ]);
        }
        if ($request->dec == 1) {



            $this->validate($request, [

                'idNote' => 'required|numeric|min:1',
                'note' => 'required|numeric|min:0|max:20',
                //'mention' => 'required',

            ]);

            Notes::where('id',  $request->idNote)->update([

                'valeur' => $request->note,

                // 'mention' =>$request->mention,
            ]);
        }
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
