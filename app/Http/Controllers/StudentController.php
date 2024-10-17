<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Classe;
use App\Models\Parents;
use App\Models\Session;
use App\Models\Student;
use App\Models\Versements;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\MoyenneTrimestres;
use App\Models\Notes;
use App\Models\NotesTrimestres;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Illuminate\Foundation\Auth\User as AuthUser;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     */


    public function  getParentByIdClasse(Request $request)
    {




        $datas = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
            ->where('students.classe_id', $request->classe)
            ->where('students.statut', 2)
            ->where('moyenne_trimestres.trimestre_id', $request->libelleEvaluation)
            ->join('parents', 'students.parent_id', '=', 'parents.id')
            ->join('presences', 'moyenne_trimestres.student_id', '=', 'presences.student_id')
            ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
            ->where('parents.telParent', 'like', '6%')
            ->get();


        return response()->json($datas);
    }


    public function regulstudent(Request $request)
    {


        // $students = Student::where('classe_id', $request->idclasse)->get();


        // dd($students);

        // foreach( $students as $student) {


        // }


        if ($request->cheek == 0) {

            //  Tous rendre irregulier status = 0


            foreach ($request->tab as $studentId) {




                $dataStudents  =  Student::where('id', $studentId)->update([


                    'statut' => 0



                ]);
            }
        }
        if (
            $request->cheek == 2
        ) {

            // Tous rendre regulier , status  = 2


            foreach ($request->tab as $key =>  $studentId) {


                $dataStudents  =  Student::where('id', $studentId)->update([


                    'statut' => 2



                ]);
            }
        }

        if (
            $request->cheek == 3
        ) {

            // DESACTIVER,  Stautu = 3


            foreach ($request->tab as $key =>  $studentId) {


                $dataStudents  =  Student::where('id', $studentId)->update([


                    'statut' => 3



                ]);
            }
        }
    }

    public function updateinscripEleve(Request $request)

    {







        if ($request->imageLogo == null) {

            $request->imageLogo = $request->user['photo'];
        } else {

            $request->imageLogo  = $request->imageLogo;
        }

        $this->validate($request, [

            'id' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'matricule' => 'required',
            'sexe' => 'required',
            'classe_id' => 'required',
            //'login' => 'required',
            //'pass' => 'required',
            'dateNaiss' => 'required',
            'lieuNaiss' => 'required',
            'sexe' => 'required',

        ]);


        //  Mettre a jour l'enfant dans la table user

        $idElev = $request->user['id'];

        $dataUser =  User::where('id', $idElev)->update([

            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'datenais' => $request->dateNaiss,
            'lieunais' => $request->lieuNaiss,
            'genre' => $request->sexe,
            // 'email' => $request->email,
            // 'login' => $request->login,
            // 'password' => bcrypt($request->pass),
            //'type' => 'Eleve',
            'photo' => $request->imageLogo

        ]);



        // id de sa classe

        $idclasse = $request->classe;  // Car c'est l'id qui arrive dans la value cote  vuejs


        if ($request->classe_id != $request->classe) {



            Notes::where('id', $request->id)->delete();

            // NotesTrimestres ::where('id', $request->id)->delete();

        }


        if ($request->parent_id == 310) {


            $user1 = User::Create([
                'nom' => $request->nomParent,
                'prenom' => "",
                'tel' => $request->telParent
            ]);


            $parent1 = Parents::Create([

                'nomParent' => $request->nomParent,
                'prenomParent' => "",
                'telParent' => $request->telParent,
                'user_id'   =>  $user1->id
            ]);


            $dataStudents  =  Student::where('id', $request->id)->update([


                'parent_id' => $parent1->id,

            ]);
        } else {

            Parents::where('id', $request->parent_id)->update([

                'nomParent' => $request->nomParent,
                'prenomParent' => "",
                'telParent' => $request->telParent,


            ]);






            $dataStudents  =  Student::where('id', $request->id)->update([

                'parent_id' => $request->parent['id'],

            ]);
        }

        if ($request->parent2 == null || $request->parent2_id == 0) {


            $user2 = User::Create([
                'nom' => $request->nomParent2,
                'prenom' => "",

            ]);




            $parent2 = Parents::Create([
                'nomParent' => $request->nomParent2,
                'prenomParent' => "",
                'user->id' => $user2->id

            ]);


            $dataStudents  =  Student::where('id', $request->id)->update([

                'parent2_id' => $parent2->id,

            ]);
        } else {

            Parents::where('id', $request->parent2_id)->update([

                'nomParent' => $request->nomParent2,
                'prenomParent' => "",


            ]);

            $dataStudents  =  Student::where('id', $request->id)->update([

                'parent2_id' =>
                $request->parent2_id

            ]);
        }



        // Mettre a jour ces paiement dans la nouvelle classe


        $dataStudents  =  Student::where('id', $request->id)->update([

            // //'user_id' => $idElev,
            // 'parent_id' =>
            // $parent1->id,
            // 'parent2_id' => $request->idParent2,
            'classe_id' => $idclasse,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'dateNaiss' => $request->dateNaiss,
            'lieuNaiss' => $request->lieuNaiss,
            'sexe' => $request->sexe,
            //'email' => $request->email,
            'nationalite' => $request->natio,
            // 'codeEtab' => $codeEtab,
            // 'session' => $sessionEncour,
            'matricule' => $request->matricule,
            'doublant' => $request->redoubl

        ]);


        $paid = Versements::where('student_id', $request->id)->count();



        if ($paid > 0) {


            $dataStudentsVersement  =  Versements::where('student_id', $request->id)->update([

                'classe_id' =>  $request->classe,

            ]);
        }


        // Gestion du parent
    }


    public function  delateEleve(Request $request)
    {



        $this->validate($request, [

            'id' => 'required'

        ]);

        // je supprime dans la table user et ca supprimerra dans la table eleve automatiquement

        User::where('id', $request->user_id)->delete();

        // Notes::Where('student', $request->user_id)->delete();


    }



    public function rechercher(Request $request)
    {
        $keyword = $request->nom; // Le mot-clé à rechercher

        $datas = Student::with('user', 'classe')
            ->where(function ($query) use ($keyword) {
                $query->where('nom', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('prenom', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('matricule', 'LIKE', '%' . $keyword . '%');
            })
            ->get();

        return response()->json($datas);
    }


    public function getEleveAndParentInfos(Request $request)
    {

        // Recuperer l'id de la classe

        $idEleve = $request->id;



        // Recuperer le code de l'ecole

        $codeEtab  = $request->codeEtab;

        // Recuperer la session en cour

        $sessionEncour  = $request->session;

        // Recuperer les eleves d'une classes

        // $EleveData = Student::with('user)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('id', 'desc')->get();

        $EleveData = Student::with('parent', 'user', 'classe')->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)
            ->where('id', $idEleve)->orderBy('nom', 'asc')->get();

        return response()->json($EleveData[0]);
    }

    public function getEleveAndParentInfosTeacher(Request $request)
    {

        // Recuperer l'id de la classe

        $idEleve = $request->id;



        // Recuperer le code de l'ecole

        $codeEtab  = $request->codeEtab;

        // Recuperer la session en cour

        $sessionEncour  = $request->session;

        // Recuperer les eleves d'une classes

        // $EleveData = Student::with('user)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('id', 'desc')->get();

        $EleveData = Student::with('parent', 'user', 'classe')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('id', $idEleve)->orderBy('nom', 'asc')->get();

        return response()->json($EleveData[0]);
    }

    public function getEleveclasseById(Request $request)
    {


        $classes  = Classe::where('id', $request->idClasse)->first();



        // Recuperer le code de l'ecole

        $codeEtab  = $classes->codeEtabClasse;

        // Recuperer la session en cour

        $sessionEncour  = $classes->sessionClasse;

        // Recuperer les eleves d'une classes, on couple avec la table user pour pouvoir recuperer les photos

        // $EleveData = Student::with('user)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('id', 'desc')->get();

        $EleveData = Student::where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $request->idClasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();

        return response()->json($EleveData);
    }

    public function getEleveclasse(Request $request)

    {



        // Recuperer l'id de la classe

        $idclasse = $request->classeId['id'];

        // Recuperer le code de l'ecole

        $codeEtab  = $request->classeId['codeEtabClasse'];

        // Recuperer la session en cour

        $sessionEncour  = $request->classeId['sessionClasse'];

        // Recuperer les eleves d'une classes, on couple avec la table user pour pouvoir recuperer les photos


        $count = count(Student::with('user', 'parent')->where('statut', "!=", 3)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->get());

        // $content = Student::with('user', 'parent')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->skip($request->currentPage * 10)->take(50)->get();

        $content = Student::with('user', 'parent')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();

        foreach ($content as $cont) {


            $cont->parent2 = Parents::where('id', $cont->parent2_id)->first();

            // dd($cont->parent2);
        }

        $Datas['totalPages'] = $count;
        $Datas['content'] = $content;







        return response()->json($Datas);
    }

    public function getEleveclasseadmin(Request $request)

    {




        // Recuperer les eleves d'une classes, on couple avec la table user pour pouvoir recuperer les photos


        $count = count(Student::where('statut', "!=", 3)->where('classe_id', $request->data)->get());

        // $content = Student::with('user', 'parent')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->skip($request->currentPage * 10)->take(50)->get();

        $content = Student::with('user', 'parent', 'classe')->where('statut', "!=", 3)->where('classe_id', $request->data)->get();


        $Datas['totalPages'] = $count;
        $Datas['content'] = $content;







        return response()->json($Datas);
    }




    public function SearchParent(Request $request)

    {



        // Recuperons le parent grace a son telephone

        if ($request->check == 1) {
            $tel = $request->telSeach;
        } else {
            $tel = $request->telSeach2;
        }

        //  $parent = Parents::where('telParent', $tel)->get();

        $parent = Parents::where('nomParent', 'LIKE', '%' . $tel . '%')
            ->orWhere('prenomParent', 'LIKE', '%' . $tel . '%')
            ->orWhere('telParent', 'LIKE', '%' . $tel . '%')->get();



        return response()->json($parent);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getEleveInfos(Request $request)
    {

        // RECUPERONS LES INFOS DE LA TABLE ENSEIGNANT


        $Ecole = Student::where('user_id', $request->id)->first();


        // id enfant   dans la table eleve

        $idEleve = $Ecole->id;

        // Prenons le codeEtab

        $codeEtab = $Ecole->codeEtab;

        //  Prenons  la session

        $sessionEncour = $Ecole->session;

        $Datas = Student::with('parent', 'Classe', 'user')->where('id', $idEleve)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->orderBy('id', 'desc')->first();

        return  response()->json($Datas);
    }
    public function inscripEleve(Request $request)

    {




        // Recuperer le code etablissement

        $codeEtab = $request['EcoleInfos'][0]['codeEtab'];

        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata[0]['libelle_sess'];

        $this->validate($request, [

            'nom' => 'required',
            'Prenom' => 'required',
            // 'matricule' => 'required',
            'sexe' => 'required',
            'classe' => 'required',
            // 'login' => 'required',
            // 'pass' => 'required',
            'dateNaiss' => 'required',
            'lieuNaiss' => 'required',
            'sexe' => 'required',

        ]);




        if (User::where('login', $request->login)->exists()) {
            return response()->json([
                'msg' => 'Ce login existe deja',

            ], 401);
        } else {

            //  Inscrivez l'enfant dans la table user


            $user =  User::Create([

                'nom' => $request->nom,
                'prenom' => $request->Prenom,
                'datenais' => $request->dateNaiss,
                'lieunais' => $request->lieuNaiss,
                'genre' => $request->sexe,
                // 'email' => $request->email,
                'login' => 'test',
                'password' => bcrypt('student'),
                'type' => 'Eleve',
                'photo' => 'test.jpg'

            ]);


            // id de l'eleve nouvelement inscrit dans user





            // id de sa classe

            $idclasse = $request->classe;  // Car c'est l'id qui arrive dans la value cote  vuejs


            // Enregistrer dans la table students

            // Matricule automatique


            $code = "24LTM";

            if ($user->id < 10) {

                $matricule = $code . '000' . $user->id;
            }

            if ($user->id >= 10 && $user->id < 100) {

                $matricule = $code . '00' . $user->id;
            }

            if ($user->id >= 100 && $user->id < 1000) {

                $matricule = $code . '0' . $user->id;
            }

            if ($user->id > 1000 && $user->idv < 10000) {

                $matricule = $code . $user->id;
            }




            $mat = $matricule;

            // dd($matricule);

            $dataStudents  =  Student::Create([
                'user_id' => $user->id,
                'parent_id' => $request->idParent,
                'parent2_id' => $request->parent2['id'],
                'classe_id' => $idclasse,
                'nom' => $request->nom,
                'prenom' => $request->Prenom,
                'dateNaiss' => $request->dateNaiss,
                'lieuNaiss' => $request->lieuNaiss,
                'sexe' => $request->sexe,
                'email' => $request->email,
                'nationalite' => $request->natio,
                'codeEtab' => $codeEtab,
                'session' => $sessionEncour,
                'matricule' => $mat,
                'doublant' => $request->redoubl

            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getStudentBySg(Request $request)
    {
        $EleveData = Student::with('user')
            ->where('classe_id', $request->classeName)
            ->where('statut', "!=", 3)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();

        return  response()->json($EleveData);
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

    public function upload(Request $request)
    {

        dd('salutttt');
    }
}
