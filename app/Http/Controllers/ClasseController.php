<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cycle;
use App\Models\Notes;
use App\Models\notif;
use App\Models\banque;
use App\Models\caisse;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Session;
use App\Models\Student;
use App\Models\Matieres;
use App\Models\salaires;
use App\Models\Presences;
use App\Models\Versements;
use App\Models\Enseignants;
use Illuminate\Http\Request;
use App\Models\MoyenneAnnuelle;
use App\Http\Controllers\Absences;
use App\Models\Fillieres;
use App\Models\Specialite;
use App\Models\Spectialites;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getFileres(Request $request)


    {

        $cycles = Fillieres::orderBy('nom', 'ASC')->get();

        return response()->json($cycles, 200);
    }
    public function getSpectialites(Request $request)
    {

        $cycles = Spectialites::orderBy('nom', 'ASC')->get();

        return response()->json($cycles, 200);
    }
    public function Getcycle(Request $request)
    {



        // Créer un nouvel enregistrement dans la table cycles
        $cycles = Cycle::where('section', $request->section)->orderBy('id', 'DESC')->get();
        // Retourner une réponse
        return response()->json($cycles, 200);
    }

    public function Addcycle(Request $request)
    {


        // Valider les données
        $request->validate([
            'nom' => 'required|string|max:255',
            'lieupaiecontrexi' => 'nullable|string|max:255',
            'amountlieupaiecontrexi' => 'nullable|numeric|min:0',
            'lieucontriparent' => 'nullable|string|max:255',
            'amountlieucontriparent' => 'nullable|numeric|min:0',
            'paiefraistimbre' => 'nullable|string|max:255',
            'amountpaiefraistimbre' => 'nullable|numeric|min:0',
            'paiefraisexam' => 'nullable|string|max:255',
            'amountpaiefraisexam' => 'nullable|numeric|min:0',
        ]);

        // Créer un nouvel enregistrement dans la table cycles
        $cycle = Cycle::create([
            'designation' => $request->nom,
            'lieucontriexg' => $request->lieupaiecontrexi,
            'amountlieucontriexg' => $request->amountlieupaiecontrexi, // Montant contre-extrait

            'lieucontripar' => $request->lieucontriparent,
            'amountlieucontripar' => $request->amountlieucontriparent, // Montant contribution parent

            'lieufraistimbre' => $request->paiefraistimbre,
            'amountlieufraistimbre' => $request->amountpaiefraistimbre, // Montant frais timbre

            'lieufraisexam' => $request->paiefraisexam,
            'amountlieufraisexam' => $request->amountpaiefraisexam, // Montant frais examen

            'section'
            => $request->section,
        ]);

        // Retourner une réponse
        return response()->json($cycle, 200);
    }



    public function changeClasse(Request $request)

    {



        // je recupere les passees
        $data = Student::where('classe_id', $request->classeName)
            ->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')
            ->get();

        // $dataLoss = MoyenneAnnuelle::with('student')->where('classe_id', $request->classeName)->where('valeur', '<', $request->moy)->get();

        // foreach ($data as $dat) {

        //     $dat['photo'] = User::where('id', $dat->student->user_id)->get('photo')[0]['photo'];
        // }



        // Mettre redoublant ceux qui restent dans cette classe


        return response()->json($data);
    }



    // public function changeClasse(Request $request)

    // {



    //     // je recupere les passees
    //     $data = MoyenneAnnuelle::with('student')->where('classe_id', $request->classeName)
    //         ->where('valeur', '>=', $request->moy)->orderBy('valeur', 'desc')
    //         ->get();

    //     // $dataLoss = MoyenneAnnuelle::with('student')->where('classe_id', $request->classeName)->where('valeur', '<', $request->moy)->get();

    //     foreach ($data as $dat) {

    //         $dat['photo'] = User::where('id', $dat->student->user_id)->get('photo')[0]['photo'];
    //     }



    //     // Mettre redoublant ceux qui restent dans cette classe


    //     return response()->json($data);
    // }


    // public function changeClasseTranfert(Request $request)
    // {




    //     if ($request->checkedNames == []) {


    //         $data = MoyenneAnnuelle::with('student')->where('classe_id', $request->classeName)
    //             ->where('valeur', '>=', $request->moy)->orderBy('valeur', 'desc')
    //             ->get();

    //         $dataDoub =
    //             MoyenneAnnuelle::with('student')->where('classe_id', $request->classeName)
    //             ->where('valeur', '<', $request->moy)->orderBy('valeur', 'desc')
    //             ->get();


    //         foreach ($data as $note) {

    //             Student::where('id', $note->student_id)->update([

    //                 'classe_id' => $request->classeName1

    //             ]);
    //         }


    //         foreach ($dataDoub as $value) {

    //             Student::where('id', $value->student_id)->update([

    //                 'doublant' => 'OUI'

    //             ]);
    //         }
    //     } else {

    //         $dataclasse = Student::where('classe_id', $request->classeName)
    //             ->get();


    //         foreach ($request->checkedNames as $IdStudent) {

    //             Student::where('id', $IdStudent)->update([

    //                 'classe_id' => $request->classeName1

    //             ]);
    //         }


    //         foreach ($dataclasse as $student) {

    //             foreach ($request->checkedNames as $IdStudent) {

    //                 if ($student->id == $IdStudent) {
    //                 } else {
    //                     Student::where('id', $student->id)->update([

    //                         'doublant' => 'OUI'

    //                     ]);
    //                 }
    //             }

    //             Student::where('id', $IdStudent)->update([

    //                 'classe_id' => $request->classeName1

    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'message' => 'Classe updated successfully',
    //         'status' => 200
    //     ], 200);
    // }


    public function changeClasseTranfert(Request $request)
    {




        foreach ($request->checkedNames as $IdStudent) {

            Student::where('id', $IdStudent)->update([

                'classe_id' => $request->classeName1

            ]);
        }

        return response()->json([
            'message' => 'Classe updated successfully',
            'status' => 200
        ], 200);
    }


    // public function changeClasse(Request $request)

    // {



    //     // je recupere les passees
    //     $data = MoyenneAnnuelle::with('student')->where('classe_id', $request->classeName)->where('valeur', '>=', $request->moy)->get();



    //     // je recupere les echoues
    //     $dataLoss = MoyenneAnnuelle::with('student')->where('classe_id', $request->classeName)->where('valeur', '<', $request->moy)->get();






    //     if ($request->dec == 1) {


    //         // cette partie traite du passage en classe sup


    //         // quand on chosi un a un




    //         // Juste pour aller chercher la photo dans user


    //         // foreach ($data as $dat) {

    //         //     $dat['photo'] = User::where('id', $dat->student->user_id)->get('photo')[0]['photo'];
    //         // }

    //         if ($request->checkedNames == []) {


    //             // cas ou il  veut transferer toute la classe


    //             foreach ($data as $value) {


    //                 // leur chamger de classe

    //                 Student::where('id', $value->student->id)->update([

    //                     'classe_id' => $request->classeName1

    //                 ]);


    //                 // Detruire toutes leurs notes


    //                 Notes::where('student_id', $value->student->id)->delete();
    //             }
    //         } else {

    //             // cas ou il a plutot cocher ceux qu'ils veut transferer



    //             foreach ($request->checkedNames as $studentId) {


    //                 Student::where('id', $studentId)->update([

    //                     'classe_id' => $request->classeName1

    //                 ]);

    //                 Notes::where('student_id', $studentId)->delete();
    //             }
    //         }

    //         MoyenneAnnuelle::where('student_id', $studentId)->delete();
    //     } else {

    //         // cette partie affiche juste les passees

    //         // Juste pour aller chercher la photo dans user

    //         foreach ($data as $dat) {

    //             $dat['photo'] = User::where('id', $dat->student->user_id)->get('photo')[0]['photo'];
    //         }
    //     }


    //     // Mettre redoublant ceux qui restent dans cette classe



    //     foreach ($dataLoss as $value) {

    //         Student::where(
    //             'id',
    //             $value->student->id
    //         )->update([

    //             'doublant' => 'OUI'

    //         ]);
    //     }



    //     return response()->json($data);
    // }


    public function doProfPrincipal(Request $request)

    {

        $idTeacher = $request->Enseignants;

        $request->validate([
            'id' => 'required',

        ]);


        $idMatiere = Classe::where('id', $request->id)->update([

            'principale_Classe' => $request->Enseignants
        ]);
    }


    public function updateClasse(Request $request)

    {



        $this->validate($request, [

            'idClasse' => 'required',
            'libelleClasse' => 'required',
            'inscription_Classe' => 'required|numeric|min:0',
            'scolarite_Classe' => 'required|numeric|min:0',
            'scolariteaff_Classe' => 'required|numeric|min:0',

        ]);



        Classe::where('id',  $request->idClasse)->update([

            'libelleClasse' => $request->libelleClasse,
            'scolariteaff_Classe' => $request->scolariteaff_Classe,
            'inscription_Classe' => $request->inscription_Classe,
            'scolarite_Classe' => $request->scolarite_Classe,
            //'emp_Classe'=>$emploiTempsUpadte


        ]);;
    }

    public function delateClasse(Request $request)

    {

        $this->validate($request, [

            'id' => 'required'

        ]);

        Classe::where('id', $request->id)->delete();
    }

    public function getLibelleMatiereclasseLocaleById(Request $request)

    {

        //  Recuperons le code etab

        $codeEtab = $request['EtabInfos'][0]['codeEtab'];


        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->first();

        // Recuperons le libelle  de la session en cour

        $session = $sessiondata['libelle_sess'];

        $donnees =  Matiere::where('classe_id', $request->idClasse)->where('session', $session)->where('codeEtab', $codeEtab)->get();

        return response()->json($donnees);
    }

    public function getLibelleMatiereclasseById(Request $request)

    {

        $userId = $request->users['id'];
        $teacher = Enseignants::where('user_id', $userId)->first();
        $session = $teacher->session;
        $codeEtab = $teacher->codeEtab;
        $donnees =  Matiere::where('classe_id', $request->classeName)->where('enseignants_id', $teacher->id)->where('session', $session)->where('codeEtab', $codeEtab)->get();
        return response()->json($donnees);
    }

    public function getAllTimetableTeacher(Request $request)
    {

        // Recuperons l'id de cet enseigant dans la table enseignant car les donnes qui arrivent viennent de user

        $dataProf = Enseignants::where('user_id', $request->id)->first();

        $data = Enseignants::with('classe')->where('id', $dataProf->id)->get();

        return response()->json($data[0]['classe']);
    }

    public function updateTimetable(Request $request)
    {

        $idClasse = $request->itemElement['id'];


        $this->validate($request, [

            'itemElement' => 'required'

        ]);

        Classe::where('id', $idClasse)->update(['emp_Classe' => $request->imageEmploiTmp]);
    }






    public function getAllTimetable(Request $request)
    {


        //  Recuperons le code etab

        $codeEtab = $request['EtabInfos'][0]['codeEtab'];


        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->first();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata['libelle_sess'];

        $data = Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->orderBy('id', 'desc')->get();


        foreach ($data as $dat) {

            $dat->number =  Student::where('classe_id', $dat->id)->count();
        }


        return response()->json($data);
    }



    public function getAllasseByATeacher(Request $request)
    {

        // RECUPERONS LES INFOS DE LA TABLE ENSEIGNANT

        $Enseignants = Enseignants::with('classe')->where('user_id', $request->id)->first();

        // id du prof dans  la table enseignant

        $idProf = $Enseignants->id;


        // Prenons le codeEtab

        $codeEtab = $Enseignants->codeEtab;

        //  Prenons  la session

        $sessionEncour = $Enseignants->session;

        // Recuperons les classes de cet enseigants

        $Datas =   Classe::with('eleves')->where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->orderBy('id', 'desc')->get();

        return response()->json($Datas);
    }


    public function getAllClasseOfTeacher(Request $request)
    {

        // RECUPERONS LES INFOS DE LA TABLE ENSEIGNANT

        $Enseignants = Enseignants::with('classe')->where('user_id', $request->id)->first();

        // id du prof dan la table enseignant

        $idProf = $Enseignants->id;

        // Prenons le codeEtab

        $codeEtab = $Enseignants->codeEtab;

        //  Prenons  la session

        $sessionEncour = $Enseignants->session;

        // Recuperons les classes de cet enseigants

        $Datas = Matieres::select('classe_id') // Sélectionnez uniquement l'identifiant de la classe
            ->with('Classe') // Charger la relation Classe
            ->where('enseignants_id', $idProf)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)
            ->groupBy('classe_id') // Regrouper par l'identifiant de la classe
            ->orderBy('id', 'desc')
            ->get();


        // si on est au primaire , prendre cette requette et adapter la partie vue

        // $Datas =  Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse',$sessionEncour )->orderBy('id', 'desc')->get('libelleClasse');

        return response()->json($Datas);
    }


    public function getAcllasseTeacher(Request $request)
    {

        // RECUPERONS LES INFOS DE LA TABLE ENSEIGNANT

        $Enseignants = Enseignants::with('classe')->where('user_id', $request->id)->first();

        // id du prof dan la table enseignant

        $idProf = $Enseignants->id;


        // Prenons le codeEtab

        $codeEtab = $Enseignants->codeEtab;

        //  Prenons  la session

        $sessionEncour = $Enseignants->session;

        // Recuperons les classes de cet enseigants

        $Datas =   Enseignants::with('Classe')->where('id', $idProf)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return response()->json($Datas[0]['classe']);
    }

    public function getClasseEtablissement2(Request $request)
    {
        // Récupérer les données depuis le request
        $cycle = $request[0]['cycle'];
        $section = $request[0]['section'];

        // Récupérer les classes avec les relations nécessaires
        $ClasseData = Classe::with(['eleves' => function ($query) {
            $query->where('statut', '!=', 3)
                ->orderBy('nom')
                ->orderBy('prenom');
        }, 'Spectialites', 'Filieres'])
            ->where('statutClasse', $cycle)
            ->where('cycles_id', $section) // Niveau comme 6ème, 5ème, etc.
            ->orderBy('libelleClasse')
            ->get();

        // Parcourir les classes pour calculer les nombres de garçons et de filles
        foreach ($ClasseData as $data) {
            // Ajouter l'enseignant principal ou "Aucun" si absent
            $data['enseignantPrincipal'] = $data->principale_Classe
                ? Enseignants::find($data->principale_Classe)
                : 'Aucun';

            // Récupérer les élèves garçons et filles de la classe
            $eleves = Student::where('classe_id', $data->id)
                ->where('statut', '!=', 3)
                ->select('sexe')
                ->get()
                ->groupBy('sexe');

            // Compter les garçons et les filles
            $data->garcon = isset($eleves['M']) ? $eleves['M']->count() : 0;
            $data->fille = isset($eleves['F']) ? $eleves['F']->count() : 0;
        }

        // Retourner les données sous forme de JSON
        return response()->json($ClasseData);
    }



    public function getclassesadmin(Request $request)
    {




        // Recuperer tous les classes et les eleves de chaque de classe de cette ecole pour cette session en cour


        // $ClasseData = Classe::with('eleves')
        //     ->where('codeEtabClasse', $codeEtab)
        //     ->where('statutClasse', $cycle)
        //     ->where('sessionClasse', $sessionEncour)

        //     ->orderBy('libelleClasse', 'asc')->get();


        $ClasseData  =   Classe::with(['eleves' => function ($query) {
            $query->where('statut', '!=', 3)
                ->orderBy('nom')->orderBy('prenom');
        }])
            ->where('statutClasse', $request->data)
            ->orderBy('libelleClasse')->get();


        $nombreGarcon = 0;


        foreach ($ClasseData as $data) {

            if ($data->principale_Classe == null) {
                $data['enseignantPrincipal'] = 'Aucun';
            } else {

                $data['enseignantPrincipal'] = Enseignants::where('id', $data->principale_Classe)->first();
            }


            $Eleve =  Student::where('classe_id', $data->id)->where('statut', '!=', 3)->where('sexe', 'M')->get();

            $nombreGarcon =  count($Eleve);

            $data->garcon = $nombreGarcon;
        }




        return response()->json($ClasseData);
    }

    public function getClasseEtablissementSurveillant(Request $request)
    {


        $codeEtab = $request[0]['codeEtab'];

        $cycle = $request[0]['cycle'];
        // Recuperer les informations sur la session en cour
        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        $sessionEncour = $sessiondata[0]['libelle_sess'];


        // Recuperer tous les classes et les eleves de chaque de classe de cette ecole pour cette session en cour


        //$ClasseData = Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->orderBy('id', 'desc')->get();

        $ClasseData = Classe::with('eleves')->where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->where('statutClasse', $cycle)->orderBy('id', 'desc')->get();

        foreach ($ClasseData as $data) {

            if ($data->order_Classe == 0) {
                $data['surveillant'] = 'Disponible';
            } else {

                $data['surveillant'] = caisse::where('id', $data->order_Classe)->first();
            }
        }

        return response()->json($ClasseData);
    }

    public function getClasseEtablissementBySg(Request $request)

    {

        // $cycle = $request[0]['cycle'];
        // Recuperer les informations sur la session en cour
        $sessiondata = Session::where('encours_sess', 1)->orderBy('id', 'desc')->first();

        $sessionEncour = $sessiondata['libelle_sess'];

        $codeEtab = $sessiondata['codeEtab_sess'];



        // Recuperer tous les classes et les eleves de chaque de classe de cette ecole pour cette session en cour


        $Caisse  =  caisse::where('user_id', $request->id)->first();

        $idSurveillant = $Caisse['id'];



        // $ClasseData = Classe::with('eleves')->where('codeEtabClasse', $codeEtab)
        //     ->where('sessionClasse', $sessionEncour)->where('order_Classe', $idSurveillant)->orderBy('id', 'desc')->get();


        $ClasseData = Classe::with('eleves')->where('codeEtabClasse', $codeEtab)
            ->where('sessionClasse', $sessionEncour)->orderBy('libelleClasse', 'ASC')->get();

        //  dd($ClasseData);

        // $ClasseData = Classe::All();

        return response()->json($ClasseData);
    }

    public function getClasseEtablissement(Request $request)
    {


        $codeEtab = $request[0]['codeEtab'];

        // $cycle = $request[0]['cycle'];
        // Recuperer les informations sur la session en cour
        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        $sessionEncour = $sessiondata[0]['libelle_sess'];


        // Recuperer tous les classes et les eleves de chaque de classe de cette ecole pour cette session en cour


        //$ClasseData = Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->orderBy('id', 'desc')->get();

        $ClasseData = Classe::with('eleves')->where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->orderBy('libelleClasse', 'ASC')->get();

        //  dd($ClasseData);

        // $ClasseData = Classe::All();

        return response()->json($ClasseData);
    }


    public function getClasseEtablissementTest(Request $request)
    {



        $ClasseData = Classe::with('eleves')->orderBy('libelleClasse', 'ASC')->get();


        return response()->json($ClasseData);
    }
    public function Addclasse(Request $request)

    {



        //  Recuperons le code etab

        $codeEtab = $request['EcoleInfos'][0]['codeEtab'];

        $cycle = $request['EcoleInfos'][0]['cycle'];

        $section = $request['EcoleInfos'][0]['section'];


        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();


        // Recuperons le libelle  de la session en cour

        $sessioEncour = $sessiondata[0]['libelle_sess'];


        $request->validate([
            // 'sigleClasse' => 'required|string',
            // 'MontantScol' => 'required|numeric|min:0',
            // 'FraisInscrip' => 'required|numeric|min:0',
            // 'MontantScolAffect' => 'required|numeric|min:0',
            // 'Fraistrois' => 'required|numeric|min:0',
        ]);


        if (Classe::where('libelleClasse', $request->sigleClasse)->where('codeEtabClasse', $codeEtab)
            ->where('sessionClasse', $sessioEncour)->exists()
        ) {

            return response()->json([
                'msg' => 'Existe deja',

            ], 400);
        } else {


            $ClasseData = Classe::create([

                'libelleClasse' => $request->sigleClasse,

                'scolariteaff_Classe' =>  1,  // $request->MontantScolAffect, Incription

                'scolarite_Classe' =>  1,    // $request->MontantScol Tranche 1

                'inscription_Classe' => 1,  //  $request->FraisInscrip Tranche 2

                'reinscription_Classe' => 1,  // $request->Fraistrois Tranche 3


                'codeEtabClasse' => $codeEtab,
                'sessionClasse' => $sessioEncour,
                'statutClasse' => $cycle,
                'cycles_id' => $section,
                'filieres_id' => $request->IdFiliere,
                'specialite_id' => $request->IdSpecialite


            ]);
        }

        // Formatter en fonction de ce aui est afficher sur classe.vue
        // pour eviter le rechargement de la page apres creatio

        $ClasseDataFormat = [

            'id' => $ClasseData->id,
            'libelleClasse' => $request->sigleClasse,
            'inscription_Classe' => $request->FraisInscrip,
            'scolarite_Classe' => $request->MontantScol,
            'scolariteaff_Classe' => $request->MontantScolAffect,
            'codeEtabClasse' => $codeEtab,
            'sessionClasse' => $sessioEncour,
            'emp_Classe' => $request->imageEmploiTmp,
            'eleves' => []
        ];



        return response()->json($ClasseDataFormat);
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
        $request->validate([
            'libelleClasse' => 'required|string',
            'codeEtabClasse' => 'required|string'
        ]);

        $status = "1";
        $date = date("d/m/dY");
        $data = Classe::create([
            'libelleClasse' => $request->libelleClasse,
            'codeEtabClasse' => $request->codeEtabClasse,
            'statutClasse' => $status,
            'datecreaClasse' => $date,
            'sessionClasse' => $request->sessionClasse,
            'sectionClasse' => $request->sectionClasse,
            'inscription_Classe' => $request->inscription_Classe,
            'scolarite_Classe' => $request->scolarite_Classe,
            'scolariteaff_Classe' => $request->scolariteaff_Classe,
            'reinscription_Classe' => $request->reinscription_Classe,
            'type_Classe' => $request->type_Classe,
            'niveau_Classe' => $request->niveau_Classe,
            'cycle_Classe' => $request->cycle_Classe,
            'libellecycle_Classe' => $request->libellecycle_Classe,
            'principale_Classe' => $request->principale_Classe,
            'order_Classe' => $request->order_Classe,
            'mixte_Classe' => $request->mixte_Classe,
            'emp_Classe' => $request->emp_Classe,
            'primaireEtab' => $request->primaireEtab,
            'createby_Classe' => $request->createby_Classe,
            //'user_id'=> $data->user_id= Auth::user()->id,
        ]);

        $msg = ' classe crée avec success';
        return response()->json($msg);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function show(Classe $classe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function edit(Classe $classe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'libelleClasse' => 'required|string',
            'codeEtabClasse' => 'required|string',
            'inscription_Classe' => 'required|string',
            'scolarite_Classe' => 'required|string'
        ]);

        // $status="1";
        // $data= Classe::update([
        //     'libelleClasse'=>$request->libelleClasse,
        //     'codeEtabClasse'=>$request->codeEtabClasse,
        //     'statutClasse'=>$status,
        //     'datecreaClasse'=>$request->datecreaClasse,
        //     'sessionClasse'=>$request->sessionClasse,
        //     'sectionClasse'=>$request->sectionClasse,
        //     'inscription_Classe'=>$request->inscription_Classe,
        //     'scolarite_Classe'=>$request->scolarite_Classe,
        //     'scolariteaff_Classe'=>$request->scolariteaff_Classe,
        //     'reinscription_Classe'=>$request->reinscription_Classe,
        //     'type_Classe'=>$request->type_Classe,
        //     'niveau_Classe'=>$request->niveau_Classe,
        //     'cycle_Classe'=>$request->cycle_Classe,
        //     'libellecycle_Classe'=>$request->libellecycle_Classe,
        //     'principale_Classe'=>$request->principale_Classe,
        //     'order_Classe'=>$request->order_Classe,
        //     'mixte_Classe'=>$request->mixte_Classe,
        //     'emp_Classe'=>$request->emp_Classe,
        //     'primaireEtab'=>$request->primaireEtab,
        //     'createby_Classe'=>$request->createby_Classe,
        //     ]);

        $msg = ' classe crée avec success';
        return response()->json($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classe $classe)
    {
        //
    }
}
