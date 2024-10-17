<?php

namespace App\Http\Controllers;

use App\Models\Mois;
use App\Models\User;
use App\Models\Heure;
use App\Models\notif;
use App\Mail\TestMail;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Parents;
use App\Models\Session;
use App\Models\Student;
use App\Models\Matieres;
use App\Models\Presences;
use App\Models\Trimestre;
use App\Models\tabletimes;
use App\Models\Enseignants;
use App\Models\Evaluations;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use SebastianBergmann\CodeCoverage\Report\Xml\Tests;



class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function getpermissionAll(Request $request)

     {


        $alls = Enseignants::get();

        foreach($alls as $all){

            Enseignants::where('id',  $all->id )->update([

                'state' =>$request->state,


            ]);


        }



        Enseignants::update([
            'state' => intval($request->state)
        ]);




     }

     public function getpermission(Request $request)

    {




        $id = $request->id;

        $state = $request->state;




       Enseignants::where('id',  $id )->update([

            'state' => $state,


        ]);



    }


    public function editEnseignant(Request $request)

    {



        $this->validate($request, [

            'nomAdmin' => 'required',
            'PrenomAdmin' => 'required',
            'telAdmin' => 'required',
            'sexe' => 'required',
            'emailAdmin' => 'required',
            //'loginAdmin' => 'required',
            //'passAdmin' => 'required',
            // 'CpassAdmin' => 'required',
            //'salaire' => 'required',

        ]);

        $idElev = $request->user_id;



        // Enregistrer dans la table User

        if ($request->imageLogo == '') {

            $request->imageLogo = 'elevedefault.png';
        }


        if ($request->type == '') {

            $request->type = 1; // titulaire enseigant par default

        }


        // if (User::where('nom', $request->nomAdmin)->where('prenom', $request->PrenomAdmin)
        //     ->where('telephone', $request->telAdmin)->exists()
        // ) {
        //     return response()->json([
        //         'msg' => 'Existe deja',

        //     ], 400);
        // }
        if (User::where('login', $request->loginAdmin)->exists()) {
            return response()->json([
                'msg' => 'Ce login existe deja',

            ], 401);
        } else {

            // Dans la table user

            if ($request->imageLogo == '') {

                if ($request->sexe = 'M') {

                    $request->imageLogo = 'elevedefaultgarcon.png';
                } else {

                    $request->imageLogo = 'elevedefaultfille.png';
                }
            }

            $user = User::where('id', $idElev)->update([

                'nom' => $request->nomAdmin,
                'prenom' => $request->PrenomAdmin,
                'email' => $request->emailAdmin,
                'telephone' => $request->telAdmin,
                // 'login' => $request->loginAdmin,
                // 'password' => bcrypt($request->passAdmin),
                'photo' => $request->imageLogo,
                'type' => 'Enseignant',

            ]);


            // Enregistrer dans la table Enseignant

            $user = Enseignants::where('id', $request->id)->update([
                //'user_id' =>  $idElev,
                'nom' => $request->nomAdmin,
                'prenom' => $request->PrenomAdmin,
                'tel' => $request->telAdmin,
                'email' => $request->emailAdmin,
                'sexe' => $request->sexe,
                'matricule' => $request->matricule,
                // 'situation' => $request->situation,
                // 'salaire' => $request->salaire,
                // 'dateEmbauche' => $request->embauche,
                // 'type' => $request->type,
                // // 'codeEtab' => $codeEtab,
                // // 'session' => $sessionEncour,
                // 'nationalite' => $request->natio

            ]);
        }
    }


    public function getAllMois()
    {

        $Mois = Mois::All();

        return response()->json($Mois);
    }

    public function delateTeacher(Request $request)
    {


        // On supprimera dans la table user et celui-ci supprimera dans la table parent

        $teacher = Enseignants::where('id', $request->id)->first();


        $idUser = $teacher['user_id'];

        $this->validate($request, [

            'id' => 'required'

        ]);

        User::where('id', $idUser)->delete();
    }

    public function getTeacherBylocale(Request $request)
    {

        $datas = Enseignants::where('id', $request->id)->first();

        return  $datas;
    }

    public function getAllasseTeacherBylocale(Request $request)
    {

        $datas = Matieres::with('Classe')->where('enseignants_id', $request->id)->get();

        return  $datas;


        // for ($i = 1; $i < 8; $i++) {

        //     $Datas[$i] = tabletimes::with('enseignant')->with('classe')->where('enseignant_id', $request->id)->where('id_jour', $i)->get();
        // }





        return  response()->json($Datas);
    }

    public function getAllasseTeacherBylocale2(Request $request)
    {

        // $datas = Matieres::with('Classe')->where('enseignants_id', $request->id)->get();

        // return  $datas;


        $idTeacher = $request[0]['enseignants_id'];


        for ($i = 1; $i < 8; $i++) {

            $Datas[$i] = tabletimes::with('enseignant')->with('classe')->with('matiere')->where('enseignant_id',  $idTeacher)->where('id_jour', $i)->get();
        }





        return  response()->json($Datas);
    }

    public function DoRetardByTeacher(Request $request)

    {


        // Voici les enfants en retard

        $abs = $request->retard;


        // On recupere le jour , la classe, la matiere et les dates: classeName contient id de la claase


        $Classe = Classe::where('id', $request->classeName)->first();

        $libelleClasse = $Classe->libelleClasse;

        $codeEtab = $Classe->codeEtabClasse;

        // Recuperons le nom de l'ecole grace a son codeEtab

        $Ecoles = Etablissement::where('codeEtab', $codeEtab)->first('libelleEtab');

        $nomEcole = $Ecoles->libelleEtab;

        $sessionEncour = $Classe->sessionClasse;

        // Je recupere le trimestre en cour


        $trimestre = Trimestre::where('statut_semes', 1)->first();

        $matiere = $request->matiere;

        $datetime = $request->dateJour;

        // Je recupere l'evaluation en cour


        $evalution = Evaluations::where('statut', 1)->first();

        // c'est l'id de l'heure qui arrive, il faut aller chercher la vrai dans la bd heure

        $Idduree = $request->duree;

        // $heures = Heure::where('id', $Idduree)->first('libelle');

        $dureeVrai = $Idduree;


        $date = date('d-m-Y', strtotime($datetime));

        $heure = date('H:i:s', strtotime($datetime));


        // Recuperer les ID des eleves absents

        $Eleves = $request->checkBoxs;

        foreach ($Eleves as  $Ideleve) {


            // Enregistrer les absents dans la table presence

            $this->validate($request, [

                'classeName' => 'required',
                'matiere' => 'required',
                'dateJour' => 'required',
                'duree' => 'required'

            ]);


            $Eleves = Student::with('parent')->where('id', $Ideleve)->first();

            $idParent = $Eleves->parent['id'];

            $nomEleve = $Eleves->nom;

            $prenomEleve = $Eleves->prenom;

            $nomParent = $Eleves->parent['nomParent'];

            $prenomParent = $Eleves->parent['prenomParent'];


            $data2 = notif::Create([

                'titre' => " Etablissement $nomEcole",
                'parent_id' =>  $idParent,
                'statut' => 0,
                'contenu' =>  " M/Mme  $nomParent  $prenomParent  l'élève $nomEleve $prenomEleve en classe de $libelleClasse est  en retard  au cour de $matiere ayant debuté le $date à $heure. Le cours a durée  $request->duree h",

            ]);
        }
    }



    public function DoAppelByTeacher(Request $request)

    {


        // Voici les enfants en retard

        $abs = $request->retard;



        // On recupere le jour , la classe, la matiere et les dates: classeName contient id de la claase




        $Classe = Classe::where('id', $request->classeName)->first();

        $libelleClasse = $Classe->libelleClasse;

        $codeEtab = $Classe->codeEtabClasse;

        // Recuperons le nom de l'ecole grace a son codeEtab

        $Ecoles = Etablissement::where('codeEtab', $codeEtab)->first('libelleEtab');

        $nomEcole = $Ecoles->libelleEtab;

        $sessionEncour = $Classe->sessionClasse;

        // Je recupere le trimestre en cour


        $trimestre = Trimestre::where('statut_semes', 1)->first();

        $matiere = $request->matiere;

        $datetime = $request->dateJour;

        // Je recupere l'evaluation en cour


        $evalution = Evaluations::where('statut', 1)->first();

        // c'est l'id de l'heure qui arrive, il faut aller chercher la vrai dans la bd heure

        $Idduree = $request->duree;

        // $heures = Heure::where('id', $Idduree)->first('libelle');

        $dureeVrai = $Idduree;


        $date = date('d-m-Y', strtotime($datetime));

        $heure = date('H:i:s', strtotime($datetime));


        // Recuperer les ID des eleves absents

        $Eleves = $request->checkBoxs;

        foreach ($Eleves as  $Ideleve) {


            // Enregistrer les absents dans la table presence

            $this->validate($request, [

                'classeName' => 'required',
                'matiere' => 'required',
                'dateJour' => 'required',
                'duree' => 'required'

            ]);

            // Recuperons le nom de l'enfant grace a son id

            // $Eleves = Student::where('id', $Ideleve)->first();

            $Eleves = Student::with('parent')->where('id', $Ideleve)->first();

            // $Idsparent = Student::with('parent')->where('id', $Ideleve)->first();

            // $InfosParent =$Idsparent->parent;



            $idParent = $Eleves->parent['id'];

            // dump($idParent);

            $nomEleve = $Eleves->nom;

            $prenomEleve = $Eleves->prenom;



            $data = Presences::Create([

                'student_id' => $Ideleve,
                'user_id' => 1,
                'classe_id' => $request->classeName,
                'dateHeure' => $datetime,
                'date' => $date,
                'heure' => $heure,
                'mois_id' => $trimestre->id,
                'evaluation_id' => $evalution->id,
                'duree' => $request->duree,
                'matiere' => $matiere,
                'session' => $sessionEncour,
                'codeEtab' => $codeEtab,

            ]);



            $nomParent = $Eleves->parent['nomParent'];

            $prenomParent = $Eleves->parent['prenomParent'];


            $data2 = notif::Create([

                'titre' => " Etablissement $nomEcole",
                'parent_id' =>  $idParent,
                'statut' => 0,
                'contenu' =>  "M/Mme.  $nomParent  $prenomParent l'élève $nomEleve $prenomEleve en classe de $libelleClasse est  absent(e)  au cour de $matiere le $date à $heure. Le cours a durée  $request->duree h",

            ]);
        }
    }



    public function getEploiTempsTeacherForAclasse(Request $request)
    {

        // Recuperer l'id de la classe

        $idclasse = $request->classe_id;

        // Recuperer le code de l'ecole

        $codeEtab  = $request->codeEtab;

        // Recuperer la session en cour

        $sessionEncour  = $request->session;

        // Recuperer les eleves d'une classes

        // $EleveData = Student::with('user)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('id', 'desc')->get();

        $Data = Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->where('id', $idclasse)->first();

        return response()->json($Data);
    }

    public function getEleveclasseByTeacher(Request $request)
    {

        // Recuperer l'id de la classe

        $idclasse = $request->classe_id;

        // Recuperer le code de l'ecole

        $codeEtab  = $request->codeEtab;

        // Recuperer la session en cour

        $sessionEncour  = $request->session;

        // Recuperer les eleves d'une classes

        // $EleveData = Student::with('user)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('id', 'desc')->get();

        $EleveData = Student::with('user', 'classe')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();

        return response()->json($EleveData);
    }


    public function getInfosTeacher(Request $request)
    {

        $this->validate($request, [
            'id' => 'required'
        ]);

        // RECUPERONS LES INFOS DE LA TABLE ENSEIGNANT

        $Ecole = Enseignants::where('user_id', $request->id)->first();



        // id du prof dan la table enseignant

        $idProf = $Ecole->id;


        // Prenons le codeEtab

        $codeEtab = $Ecole->codeEtab;

        //  Prenons  la session

        $sessionEncour = $Ecole->session;

        $Datas = Matieres::with('Classe')->where('enseignants_id', $idProf)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return  response()->json($Datas);
    }
    public function addEnseignant(Request $request)

    {

        //  Recuperons le code etab

        $codeEtab = $request['EcoleInfos'][0]['codeEtab'];

        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata[0]['libelle_sess'];

        // dd( $codeEtab);

        $this->validate($request, [

            'nomAdmin' => 'required',
            'PrenomAdmin' => 'required',
            'telAdmin' => 'required',
            'sexe' => 'required',
            'emailAdmin' => 'required|email',
            'loginAdmin' => 'required',
            'passAdmin' => 'required',
            // 'CpassAdmin' => 'required',
            //'salaire' => 'required',


        ]);


        // Enregistrer dans la table User

        if ($request->imageLogo == '') {

            $request->imageLogo = 'elevedefault.png';
        }


        if ($request->type == '') {

            $request->type = 1; // titulaire enseigant par default

        }


        if (User::where('nom', $request->nomAdmin)->where('prenom', $request->PrenomAdmin)
            ->where('telephone', $request->telAdmin)->exists()
        ) {
            return response()->json([
                'msg' => 'Existe deja',

            ], 400);
        } else if (User::where('login', $request->loginAdmin)->exists()) {
            return response()->json([
                'msg' => 'Ce login existe deja',

            ], 401);
        } else {

            // Dans la table user

            if ($request->imageLogo == '') {

                if ($request->sexe = 'M') {

                    $request->imageLogo = 'elevedefaultgarcon.png';
                } else {

                    $request->imageLogo = 'elevedefaultfille.png';
                }
            }

            $user = User::Create([

                'nom' => $request->nomAdmin,
                'prenom' => $request->PrenomAdmin,
                'email' => $request->emailAdmin,
                'login' => $request->loginAdmin,
                'telephone' => $request->telAdmin,
                'password' => bcrypt($request->passAdmin),
                'photo' => $request->imageLogo,
                'type' => 'Enseignant',

            ]);


            // Enregistrer dans la table Enseignant

            $user = Enseignants::Create([
                'user_id' => $user->id,
                'nom' => $request->nomAdmin,
                'prenom' => $request->PrenomAdmin,
                'tel' => $request->telAdmin,
                'email' => $request->emailAdmin,
                'sexe' => $request->sexe,
                'matricule' => $request->matricule,
                'situation' => $request->situation,
                'salaire' => $request->salaire,
                'dateEmbauche' => $request->embauche,
                'type' => $request->type,
                'codeEtab' => $codeEtab,
                'session' => $sessionEncour,
                'nationalite' => $request->natio

            ]);
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
    public function getAllEnseignant(Request $request)

    {


        // $Datas = Enseignants::orderBy('nom')->orderBy('prenom')->paginate($request->total);

        $count = count(Enseignants::orderBy('nom')->orderBy('prenom')->get());


        $content = Enseignants::orderBy('nom')->orderBy('prenom')->skip($request->currentPage * 10)->take(9)->get();



        //$contentSimple = Enseignants::get();

        $contentSimple = Enseignants::with('user')->orderBy('nom')->orderBy('prenom')->get();
        // $contentSimple = Enseignants::with('user')->orderBy('id', 'ASC')->get();




        // $enseignant->user->getRawOriginal('password');


        $Datas['totalPages'] = $count;
        $Datas['content'] = $content;

        $Datas['contentSimple'] = $contentSimple;

        // dd($contentSimple[0]->user->getAuthPassword('password'));

        return  response()->json($Datas);
    }







    public function  getAllEnseignantAffectMatieres(Request $request)
    {

        //  Recuperons le code etab

        $codeEtab = $request['codeEtabClasse'];

        // Recuperons les datas de la session en cour

        $sessionEncour = $request['sessionClasse'];

        // Recuperons tous les enseignants de cette classe avec leurs matieres

        $Datas = Matieres::with('Enseignants')->where('classe_id', $request->id)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->get();


        return  response()->json($Datas);
    }

    public function getAllEnseignantAffect(Request $request)

    {

        //  Recuperons le code etab

        $codeEtab = $request['codeEtabClasse'];

        // Recuperons les datas de la session en cour

        $sessionEncour = $request['sessionClasse'];

        // Recuperons tous les enseignants

        // $Datas = Matieres::with('Enseignants')->where('id', $request->id)->get();

        $Datas = Enseignants::where('session', $sessionEncour)->where('codeEtab', $codeEtab)->orderBy('nom')->orderBy('prenom')->get();


        return  response()->json($Datas);
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
