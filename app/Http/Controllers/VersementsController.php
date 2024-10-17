<?php

namespace App\Http\Controllers;

use App\Models\banque;
use PDF;
use App\Models\notif;
use App\Models\Classe;
use App\Models\Session;
use App\Models\Student;
use App\Models\Versements;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\salaires;

class VersementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function getEntressAutre2()
    {

        // Toutes les  sorties de la banque

        $data = Versements::where('mode', 'tranche')->orderBy('id', 'desc')->get();

        $datatotal = Versements::where('mode', 'tranche')->orderBy('id', 'desc')->sum('montantverser');

        $array = [
            'appro' => $data,
            'totalAppro' => $datatotal,

        ];

        return response()->json($array);
    }

    public function addAutreversement(Request $request)


    {

        // Je recupere automatiquement le mois en chiffre en cours ,; jan =1 , Fev = 2 ...

        $idMois =  (int)date('m');

        $codeEtab = $request->EtabInfos[0]['codeEtab'];

        // Recuperons les datas de la session en cour

        $sessiondata = Session::where(
            'codeEtab_sess',
            $codeEtab
        )->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata[0]['libelle_sess'];




            $this->validate($request, [

                'montant' => 'required|numeric',
                'motif' => 'required',

            ]);

            $role = $request->motif;

            $data = Versements::create([
                'mois' => $idMois,
                'montantverser' => $request->montant,
                'motif' =>  $role,
                'codeEtab' => $codeEtab,
                'session' => $sessionEncour,
                'mode' => "tranche",  // une autre entree ( subvention, don ....)
                'date' => $request->date
            ]);

        // else {

        //     // Retrait  banquaire , on met dans la table bank avec type = ret

        //     $role = "RetraitBank-Caisse";

        //     $data = banque::create([

        //         'mois_id' => $idMois,
        //         'montant' => $request->montant,
        //         'motif' =>  "RetraitBank-Caisse",
        //         'codeEtab' => $codeEtab,
        //         'session' => $sessionEncour,
        //         'type' => 'ret',  // depot de banque vers caisse
        //         'date' => $request->date
        //     ]);

        //      // Ensuite on credite les entrees mais avec motif = tranche0


        //      $data = Versements::create([

        //          'mois_id' => $idMois,
        //          'montantverser' => $request->montant,
        //          'mode' =>  "tranche0",
        //          'codeEtab' => $codeEtab,
        //          'session' => $sessionEncour,
        //          'type' => 'ret',  // depot de banque vers caisse
        //          'date' => $request->date
        //      ]);
        // }

        return response()->json($data);
    }

    public function delateVersement(Request $request)
    {

        $this->validate($request, [

            'id' => 'required'

        ]);

        Versements::where('id', $request->id)->delete();
    }


    public function getRecapFinances(Request $request)

    {


        $codeEtab = $request[0]['codeEtab'];
        // Recuperer les informations sur la session en cour
        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        $sessionEncour = $sessiondata[0]['libelle_sess'];


        // Recuperer tous les classes et les eleves de chaque de classe de cette ecole pour cette session en cour


        //$ClasseData = Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->orderBy('id', 'desc')->get();

        $ClasseData = Classe::with('eleves')->where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->orderBy('id', 'desc')->get();

        $tranche1 = 0;
        $tranche2 = 0;
        $ape = 0;



        foreach ($ClasseData as $value) {

            $nbr = count($value->eleves);

            $tranche1 = $tranche1  + ($value->scolarite_Classe) * $nbr;

            $tranche2 = $tranche2  + ($value->inscription_Classe) * $nbr;

            $ape = $ape  + ($value->scolariteaff_Classe) * $nbr;

            $datas = [
                'tranche1' => $tranche1,
                'tranche2' => $tranche2,
                'ape' => $ape
            ];
        }

        return response()->json($datas);
    }

    public function  getEleveclasseFinances(Request $request)

    {


        $codeEtab = $request['EtabInfos'][0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;


        $datas = Student::with('classe')->where('classe_id', $request->idClasse)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->orderBy('nom')->orderBy('prenom')->get();




        // somme deja paye par classe


        $tranche1Classe = Versements::where('classe_id', $request->idClasse)->where('motif', 'tranche1')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');

        $tranche2Classe = Versements::where('classe_id', $request->idClasse)->where('motif', 'tranche2')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');

        $ApeClasse = Versements::where('classe_id', $request->idClasse)->where('motif', 'APE')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');


        $datasClassePaye =  array(

            'tranche1' => $tranche1Classe,
            'tranche2' =>   $tranche2Classe,
            'ape' =>  $ApeClasse,

        );


        // Reste a  paye par classe

        // effectif de la classe

        $effectif = Student::with('classe')->where('classe_id', $request->idClasse)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->count();


        $classeData = Classe::where('id', $request->idClasse)->first();

        // somme a payer pa classe

        $datasClasseApayer =  array(

            'tranche1' => $effectif * $classeData->scolarite_Classe,
            'tranche2' =>  $effectif * $classeData->inscription_Classe,
            'ape' => $effectif * $classeData->scolariteaff_Classe,

        );


        foreach ($datas as $data) {


            $tranche1 = Versements::where('classe_id', $request->idClasse)->where('student_id', $data->id)->where('motif', 'tranche1')

                ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');


            $tranche2 = Versements::where('classe_id', $request->idClasse)->where('student_id', $data->id)->where('motif', 'tranche2')

                ->where('codeEtab', $codeEtab)->where('session',  $sessionEncour)->sum('montantverser');

            $ape = Versements::where('classe_id', $request->idClasse)->where('student_id', $data->id)->where('motif', 'APE')

                ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');

            $datasTranches[$data->id] =  array(

                'tranche1' =>  $tranche1,
                'tranche2' =>  $tranche2,
                'ape' =>  $ape,

            );


            $data['scolarite'] = $datasTranches[$data->id];

            $data['ClassePaye'] =  $datasClassePaye;

            $data['ClasseAPayer'] =  $datasClasseApayer;
        }



        return response()->json($datas);
    }



    public function getAstudentDatailsFinancesDashboard(Request $request)

    {


        $codeEtab = $request[0]['codeEtab'];
        // Recuperer les informations sur la session en cour
        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        $sessionEncour = $sessiondata[0]['libelle_sess'];

        $tranche1 = Versements::where('motif', 'tranche1')
            ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');

        $tranche2 = Versements::where('motif', 'tranche2')
            ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');

        $ape = Versements::where('motif', 'APE')->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->sum('montantverser');


        // ici ce sont les autres entrees en dehors de la scolarite , celles ci augmentent les entrees totales de l'ecole

        $autreEntrees =  Versements::where('mode', 'tranche')
            ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');




        // ici ce sont les entrees  de  banque la  vers caisse  , celles ci n'augmentent pas les entrees totales de l'ecole mais plutot le solde en caisse

        $SommeCaisseBanque =   banque::where('type', 'dep')->where('codeEtab', $codeEtab)
                                                            ->where('session', $sessionEncour)
                                                            ->sum('montant');

        $sommeBanqueCaisse = banque::where('type', 'ret')->where('codeEtab', $codeEtab)
                                                         ->where('session', $sessionEncour)
                                                         ->sum('montant');



        $datas = [

            'tranche1' =>  $tranche1,
            'tranche2' =>  $tranche2,
            'ape' =>  $ape,
            'autre' => $autreEntrees,
            'totalBanqueCaisse' => $sommeBanqueCaisse,
            'totalCaiiseBanque' => $SommeCaisseBanque,
        ];


        return response()->json($datas);
    }


    public function getAstudentDatailsFinancesInfos(Request $request)
    {

        $tranche1 = Versements::where('student_id', $request->id)->where('classe_id', $request->classe_id)->where('motif', 'tranche1')

            ->where('codeEtab', $request->codeEtab)->where('session', $request->session)->sum('montantverser');

        $tranche2 = Versements::where('student_id', $request->id)->where('classe_id', $request->classe_id)->where('motif', 'tranche2')

            ->where('codeEtab', $request->codeEtab)->where('session', $request->session)->sum('montantverser');

        $ape = Versements::where('student_id', $request->id)->where('classe_id', $request->classe_id)->where('motif', 'APE')

            ->where('codeEtab', $request->codeEtab)->where('session', $request->session)->sum('montantverser');

        $datas = [

            'tranche1' =>  $tranche1,
            'tranche2' =>  $tranche2,
            'ape' =>  $ape
        ];


        return response()->json($datas);
    }


    public function getAstudentFinancesInfos(Request $request)
    {


        $datas = Versements::where('student_id', $request->id)
            ->where('codeEtab', $request->codeEtab)->where('session', $request->session)->orderBy('id', 'desc')->get();

        return response()->json($datas);
    }

    public function addVersement(Request $request)

    {



        $date = date_create($request->date);
        $IdMois = (int)$date->format('m');


        // Traiteme de la date

        // $datetamp =  date('d m Y h:i:s');
        // $splitDateStamp = explode(" ", $datetamp);
        // $j =  $splitDateStamp[0];
        // $m =  $splitDateStamp[1];
        // $a = $splitDateStamp[2];

        // Traitement de l'heure

        // $timetamp = date('h:i:s');
        // $splitTimeStamp = explode(":", $timetamp);
        // $heure = $splitTimeStamp[0];
        // $min = $splitTimeStamp[1];
        // $sec = $splitTimeStamp[2];

        $codeEtab = $request['EleveInfos']['codeEtab'];

        $etabs = Etablissement::where('codeEtab', $codeEtab)->first('libelleEtab');

        $nomEcole = $etabs->libelleEtab;

        $matricule = $request['EleveInfos']['matricule'];

        $nomEleve = $request['EleveInfos']['nom'];

        $prenomEleve = $request['EleveInfos']['prenom'];

        // Obliger a saisir une valeur inferieur a la tranche choisi dans cette classe



        //  Code du versement

        //  $code = $codeEtab . $matricule . $j . $m . $a . $heure . $min . $sec;

        $session = $request['EleveInfos']['session'];

        $idClasse = $request['EleveInfos']['classe_id'];

        $idEleve = $request['EleveInfos']['id'];

        // Id de son parent de la table parent

        $idUserparent = $request['EleveInfos']['parent_id'];

        $nomparent = $request['EleveInfos']['parent']['nomParent'];

        $prenomparent = $request['EleveInfos']['parent']['prenomParent'];


        $motif = $request->motif;

        // Je recupere les montants a payer normalemt dans la  classe pour chaque tranche

        $Montant = Classe::where('id', $idClasse)->first();


        $libelleClasse = $Montant['libelleClasse'];

        $tracnhe1Classe = $Montant['scolarite_Classe'];

        $tracnhe2Classe = $Montant['inscription_Classe'];

        $apeClasse = $Montant['scolariteaff_Classe'];

        // Je veux savoir combien il a deja paye pour chaque tranche

        $tranche1Payed = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'tranche1')

            ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

        $tranche2Payed = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'tranche2')

            ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

        $apePayed = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'ape')

            ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

        $this->validate($request, [

            'date' => 'required|date',
            'deposant' => 'required',
            'montantverse' => 'required|numeric|min:0',
            'motif' => 'required',
            // 'mode' => 'required'
        ]);

        $classeNews  = Classe::where('id', $idClasse)->where('codeEtabClasse', $codeEtab)->where('sessionClasse', $session)->first();

        // Total a payer

        $aPayertotal = $classeNews->inscription_Classe + $classeNews->scolarite_Classe + $classeNews->scolariteaff_Classe;



        if ($motif == 'tranche1') {

            if ($request->montantverse + $tranche1Payed > $tracnhe1Classe) {

                return response()->json([
                    'msg' => 'Montant trop grand',

                ], 400);
            } else {



                $data = Versements::create([
                    'classe_id' => $idClasse,
                    'student_id' => $idEleve,
                    'codeEtab' => $codeEtab,
                    'session' => $session,
                    'date' => $request->date,
                    //'code' => $code,
                    'mode' => $request->mode,
                    'motif' => $request->motif,
                    'deposant' => $request->deposant,
                    'receptionneur' => $request->percepteur,
                    'montantverser' => $request->montantverse,
                    'mois' => $IdMois,

                ]);

                // Ici je veux  savoir si l'enfant a tout paye pour savoir son statut (vert, rouge ou jaune)


                $tranche1 = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'tranche1')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                $tranche2 = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'tranche2')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                $ape = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'ape')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                // Total deja paye par l'enfant

                $total = $tranche1 + $tranche2 + $ape;


                if ($total >= $aPayertotal) {

                    Student::where('id', $idEleve)->update([

                        'statut' => 2 // eleve ayant tout payes
                    ]);
                }

                if ($total > 0 && $total < $aPayertotal) {

                    Student::where('id', $idEleve)->update([

                        'statut' => 1, // eleve ayant avance
                    ]);
                }

                 // je cree la notif que le parent verra


                 $data2 = notif::Create([

                    'titre' => " Etablissement $nomEcole",
                    'parent_id' =>  $idUserparent,
                    'statut' => 0,
                    'contenu' =>  " M/Mme  $nomparent $prenomparent  un versement de $request->montantverse F a été fait pour paiement   $motif  de l'élève  $nomEleve $prenomEleve en classe de $libelleClasse.",

                ]);
            }
        } else if ($motif == 'tranche2') {

            if ($request->montantverse + $tranche2Payed > $tracnhe2Classe) {

                return response()->json([
                    'msg' => 'Montant trop grand',

                ], 400);
            } else {

                $data = Versements::create([
                    'classe_id' => $idClasse,
                    'student_id' => $idEleve,
                    'codeEtab' => $codeEtab,
                    'session' => $session,
                    'date' => $request->date,
                    //'code' => $code,
                    'mode' => $request->mode,
                    'motif' => $request->motif,
                    'deposant' => $request->deposant,
                    'receptionneur' => $request->percepteur,
                    'montantverser' => $request->montantverse,
                    'mois' => $IdMois,


                ]);


                // Ici je veux  savoir si l'enfant a tout paye pour savoir son statut (vert, rouge ou jaune)


                $tranche1 = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'tranche1')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                $tranche2 = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'tranche2')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                $ape = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'ape')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                // Total deja paye par l'enfant

                $total = $tranche1 + $tranche2 + $ape;

                if ($total >= $aPayertotal) {

                    Student::where('id', $idEleve)->update([

                        'statut' => 2 // eleve ayant tou payes
                    ]);
                }

                if ($total > 0 && $total < $aPayertotal) {


                    Student::where('id', $idEleve)->update([

                        'statut' => 1, // eleve ayant avance
                    ]);
                }


                $data2 = notif::Create([

                    'titre' => " Etablissement $nomEcole",
                    'parent_id' =>  $idUserparent,
                    'statut' => 0,
                    'contenu' =>  " M/Mme  $nomparent $prenomparent  un versement de $request->montantverse F a été fait pour paiement  $motif  de l'élève  $nomEleve $prenomEleve en classe de $libelleClasse.",

                ]);
            }
        } else if ($motif == 'APE') {

            if ($request->montantverse + $apePayed > $apeClasse) {

                return response()->json([
                    'msg' => 'Montant trop grand',

                ], 400);
            } else {

                $data = Versements::create([
                    'classe_id' => $idClasse,
                    'student_id' => $idEleve,
                    'codeEtab' => $codeEtab,
                    'session' => $session,
                    'date' => $request->date,
                    //'code' => $code,
                    'mode' => $request->mode,
                    'motif' => $request->motif,
                    'deposant' => $request->deposant,
                    'receptionneur' => $request->percepteur,
                    'montantverser' => $request->montantverse,
                    'mois' => $IdMois,

                ]);



                // Ici je veux  savoir si l'enfant a tout paye pour savoir son statut (vert, rouge ou jaune)


                $tranche1 = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'tranche1')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                $tranche2 = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'tranche2')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                $ape = Versements::where('classe_id', $idClasse)->where('student_id', $idEleve)->where('motif', 'ape')

                    ->where('codeEtab', $codeEtab)->where('session', $session)->sum('montantverser');

                // Total deja paye par l'enfant

                $total = $tranche1 + $tranche2 + $ape;



                if ($total >= $aPayertotal) {

                    Student::where('id', $idEleve)->update([

                        'statut' => 2 // eleve ayant tou payes
                    ]);
                }

                if ($total > 0 && $total < $aPayertotal) {


                    Student::where('id', $idEleve)->update([

                        'statut' => 1, // eleve ayant avance
                    ]);
                }

                 // je cree la notif que le parent verra

                 notif::Create([

                    'titre' => " Etablissement $nomEcole",
                    'parent_id' =>  $idUserparent,
                    'statut' => 0,
                    'contenu' =>  " M/Mme  $nomparent $prenomparent  un versement de $request->montantverse F a été fait pour paiement   $motif  de l'élève  $nomEleve $prenomEleve en classe de $libelleClasse.",

                ]);
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
