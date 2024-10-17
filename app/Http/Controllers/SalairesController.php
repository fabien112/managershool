<?php

namespace App\Http\Controllers;

use App\Models\Mois;
use App\Models\User;
use App\Models\Books;
use App\Models\banque;
use App\Models\caisse;
use App\Models\Classe;
use App\Models\Session;
use App\Models\salaires;
use App\Models\Versements;
use App\Models\Enseignants;
use Illuminate\Http\Request;
use App\Models\approvisionnement;

class SalairesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllTotalSalairesMois(Request $request)

    {

        // depense pour payement prof par mois

        $salaires = salaires::where('mois_id', $request->idMois)->where('type', 0)->sum('montant');

        // depense pour payement personnel  par mois

        $salairesPersonnel = salaires::where('mois_id', $request->idMois)->where('type', 1)->sum('montant');


        // Toutes les autres depenses du moi

        $depensesAutres = salaires::where('mois_id', $request->idMois)->where('type', 2)->sum('montant');


        // calcul du solde


        $entreeTotal = Versements::where('mois', '<=', $request->idMois)->sum('montantverser');

        $sortieTotal = salaires::where('mois_id', '<=', $request->idMois)->sum('montant');

        $sommeBanqueCaisse = approvisionnement::where('mois_id', '<=', $request->idMois)->sum('montant');

        $soldeTotal =  $entreeTotal - $sortieTotal + $sommeBanqueCaisse;


        // calcul du total entree du mois

        $entreeMois = Versements::where('mois', $request->idMois)->sum('montantverser');

        // historiquea entrees et sorties du mois

        $entreeHistoriques = Versements::where('mois', '<=', $request->idMois)->orderBy('id', 'desc')->get();






        $datas =  array(

            'total' =>  $salaires,
            'totalp' => $salairesPersonnel,
            'totalAutre' => $depensesAutres,
            'solde' => $soldeTotal,
            'EntreMois' => $entreeMois,
            'HistEntree' => $entreeHistoriques

        );

        return response()->json($datas);
    }


    public function getAllFinancesJour(Request $request)

    {



        $entreJ = Versements::where('date', $request->jour)->sum('montantverser');

        $sortieJ = salaires::where('date', $request->jour)->sum('montant');

        // historiques entrees et sorties

        $sorties = salaires::where('date', $request->jour)->get();

        $entrees = Versements::with('student')->with('classe')->where('date', $request->jour)->get();

        // calculons le solde en caisse generale

        $entreeTotal = Versements::where('date', '<=', $request->jour)->sum('montantverser');

        $sortieTotal = salaires::where('date', '<=', $request->jour)->sum('montant');

        // $SommeCaisseBanque =   banque::where('type', 'dep')->where('date' , '<=', $request->jour) ->sum('montant');

        $sommeBanqueCaisse = approvisionnement::where('date', '<=', $request->jour)->sum('montant');

        $soldeTotal =  $entreeTotal - $sortieTotal + $sommeBanqueCaisse;


        $datas = [

            'entreJour' => $entreJ,
            'sortieJ' => $sortieJ,
            'solde' => $soldeTotal,
            'totalE' => $entrees,
            'totalS' => $sorties
        ];

        return response()->json($datas);
    }

    public function upadteSalaire(Request $request)
    {



        $this->validate($request, [

            'idMois' => 'required',
            'montant' => 'required',
            'id' => "required"
        ]);

        return salaires::where('id', $request->id)->update([

            'mois_id' => $request->idMois,
            'montant' => (float)$request->montant,

        ]);
    }

    public function delatePaiement(Request $request)
    {

        $this->validate($request, [

            'id' => 'required'

        ]);

        salaires::where('id', $request->id)->delete();
    }

    public function payerAutredepense(Request $request)


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


        // if($request->role=='banque'){

        //     $motif = "DepCaiVerBank";

        //     $this->validate($request, [

        //         // 'idMois' => 'required',
        //         'montant' => 'required|numeric',

        //     ]);

        //     $data = banque::create([

        //         // depot de caisse vers banque  ;

        //         'mois_id' => $idMois,
        //         'type' => 'dep' ,
        //         'montant' => $request->montant,
        //         'motif' => $motif,
        //         'codeEtab' => $codeEtab,
        //         // 'genre' =>1 , // 1= depot caisse vers banque ; 0 autre depense et NULL pour les salaires
        //         'session' => $sessionEncour,
        //         'date' => date('Y-m-d H')
        //     ]);
        // }



        $this->validate($request, [

            // 'idMois' => 'required',
            'montant' => 'required|numeric',
            'motif' => 'required',

        ]);

        // Autre depense hors mis salaires prof et personnel et aussi depot en banque

        $data = salaires::create([

            'mois_id' => $idMois,
            'type' => 2,      // 1 = salaire personnel , 0 = salaire enseigant et 2 = autres depense; 3 = depot caisse vers banque
            'montant' => $request->montant,
            'motif' => $request->motif,
            'codeEtab' => $codeEtab,
            // 'genre' => 0 , // 1 = depot caisse banque ; 0 = autre depense et NULL =  pour les salaires(prof et personnel)
            'session' => $sessionEncour,
            'date' => date('Y-m-d H')
        ]);

        // type = 0 lorsque la depense c'est le salaire des enseignants


        return response()->json($data);
    }

    public function payersalairePersonnel(Request $request)


    {



        // $idMois =  (int)date('m');

        $this->validate($request, [

            'idMois' => 'required',
            'montant' => 'required|numeric',

        ]);

        // Allons chercher le code etab et la session

        $donnees = caisse::where('user_id', $request->Teacherdata['user_id'])->first();

        $codeEtab = $donnees->codeEtab;
        $session = $donnees->session;


        // verifier si la somme versee ne depasse pas son salire du mois

        $Prix = $donnees->salaire; // salire du mois fixe



        // Recuperons la somme de ce qui aurait deja ete versee pour cet enseignant ce mois la

        $Somme = salaires::where('user_id', $request->Teacherdata['user_id'])
            ->where('mois_id', $request->idMois)->sum('montant');


        if ($Prix < $request->montant + $Somme) {

            return response()->json([
                'msg' => 'Montant trop grand',

            ], 400);
        } else {



            $data = salaires::create([

                'mois_id' => $request->idMois,
                'user_id' => $request->Teacherdata['user_id'],
                'type' => 1, // 1= personnel , 0 =enseigant et 2 = autres
                'montant' => $request->montant,
                'codeEtab' => $codeEtab,
                'session' => $session,
                'date' => date('Y-m-d H')
            ]);
        }



        // type = 0 lorsque la depense c'est le salaire des enseignants


        return response()->json($data);
    }

    public function payersalaireProf(Request $request)


    {

        // Je recupere automatiquement le mois en chiffre en cours ,; jan =1 , Fev = 2 ...

        // $idMois =  (int)date('m');

        $this->validate($request, [

            'idMois' => 'required',
            'montant' => 'required|numeric',

        ]);

        // Allons chercher le code etab et la session

        $donnees = Enseignants::where('user_id', $request->Teacherdata['id'])->first();

        $codeEtab = $donnees->codeEtab;
        $session = $donnees->session;


        // verifier si la somme versee ne depasse pas son salire du mois


        $heure = Books::where('user_id', $request->Teacherdata['id'])->where('mois_id', $request->idMois)->sum('duree');

        $Prix = Enseignants::where('user_id', $request->Teacherdata['id'])->first('salaire');

        // Salaire par heure du prof

        $prixHeure = $Prix->salaire;

        // Recuperons la somme de ce qui aurait deja ete versee pour cet enseignant ce mois la

        $Somme = salaires::where('user_id', $request->Teacherdata['id'])
            ->where('mois_id', $request->idMois)->sum('montant');


        if ($prixHeure * $heure < $request->montant + $Somme) {

            return response()->json([
                'msg' => 'Montant trop grand',

            ], 400);
        } else {



            $data = salaires::create([

                'mois_id' => $request->idMois,
                'user_id' => $request->Teacherdata['id'],
                'type' => 0,
                'montant' => $request->montant,
                'codeEtab' => $codeEtab,
                'session' => $session,
                'date' => date('Y-m-d H')
            ]);
        }



        // type = 0 lorsque la depense c'est le salaire des enseignants ;


        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTotaldepense(Request $request)

    {


        // $codeEtab = $request[0]['codeEtab'];
        // // Recuperer les informations sur la session en cour
        // $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)
        // ->orderBy('id', 'desc')->get();

        // $sessionEncour = $sessiondata[0]['libelle_sess'];


        $tranche0 = salaires::where('type', 0)->sum('montant'); // salire des profs

        $tranche1 = salaires::where('type', 1)->sum('montant'); // salaire du personnel

        $tranche2 = salaires::where('type', 2)->sum('montant'); // autres depenses courantes


        // Ici  ce la  sorti de la caisse vers la banque

        $depotBanque =  salaires::where('type', 3)->sum('montant');


        $total1 = $tranche0 + $tranche1 + $tranche2 + $depotBanque;

        $total = [

            'total' => $total1
        ];

        return response()->json($total);
    }




    public function getAllSalairesMoisAutre(Request $request)

    {




        $content = salaires::where('mois_id', $request->idMois)->where('type', 2)
            ->orderBy('id', 'desc')->skip($request->currentPage * 10)->take(9)->get();


        $mount = salaires::where('mois_id', $request->idMois)->where('type', 2)->sum('montant');


        $count = count(salaires::where('mois_id', $request->idMois)->where('type', 2)->get());

        $tranche['totalPages'] = $count;
        $tranche['content'] = $content;
        $tranche['mount'] = $mount;

        return response()->json($tranche);



        // dd($request->idMois)

    }

    public function getAllSalairesPersonnelMois(Request $request)

    {




        // Recuperons tous les prof dans la tables user

        $personnel = caisse::get(); // caise est la table qui contient tout le ersonnel exept les profs


        foreach ($personnel as $data) {


            // Je parcours chaque enseignants et je fais la somme de ce qu'il a deja recu comme paie

            $tranche = salaires::where('user_id', $data->user_id)->where('type', 1)->where('mois_id', $request->idMois)->sum('montant');

            // Je recupere le nom du mois

            $moisObj = Mois::where('id', $request->idMois)->first('nom');

            $mois =  $moisObj->nom;


            $datasTranches[$data->user_id] =  array(

                'total' =>  $tranche,
                'mois'      => $mois,
                'idMois' => $request->idMois

            );

            $data['scolarite'] = $datasTranches[$data->user_id];
        }

        return response()->json($personnel);



        // dd($request->idMois)

    }
    public function getAllSalairesMois(Request $request)

    {


        // Recuperons tous les prof dans la tables user

        $salaires = User::where('type', 'Enseignant')->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();

        foreach ($salaires as $data) {

            // Je parcours chaque enseignants et je fais la somme de ce qu'il a deja recu comme paie

            $tranche = salaires::where('user_id', $data->id)->where('mois_id', $request->idMois)->sum('montant');

            // Je recupere toute ses heures de cours

            $heure = Books::where('user_id', $data->id)->where('mois_id', $request->idMois)->sum('duree');

            $cours =  Books::with('Matiere', 'Classe')->where('user_id', $data->id)->where('mois_id', $request->idMois)->orderBy('id', 'desc')->get();


            // Je recupere le cout d'une heure pour chaque professeur


            $Prix = Enseignants::where('user_id', $data->id)->first('salaire');

            $prixHeure = $Prix->salaire;

            // Je recupere le nom du mois

            $moisObj = Mois::where('id', $request->idMois)->first('nom');

            $mois =  $moisObj->nom;


            $datasTranches[$data->id] =  array(

                'total' =>  $tranche,
                'heure' => $heure,
                'prixhoraire' => $prixHeure,
                'mois'      => $mois,
                'idMois' => $request->idMois,
                'cours' => $cours

            );

            $data['scolarite'] = $datasTranches[$data->id];
        }

        return response()->json($salaires);



        // dd($request->idMois)

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllHistorique(Request $request)

    {

        $datas = salaires::with('mois')->where('user_id', $request->Teacherdata['id'])

            ->where('mois_id', $request->Teacherdata['scolarite']['idMois'])->orderBy('id', 'DESC')->get();

        // $All = [];

        // foreach($datas as $data){

        //     $All[$data->id] = [

        //         'montant' => $data->montant,
        //         'date'    => $data->created_at->format('d/m/Y'),
        //         'id'  =>$data->id

        //     ] ;

        //     }

        return response()->json($datas);
    }

    public function getAllHistorique2(Request $request)

    {

        $datas = salaires::with('mois')->where('user_id', $request->Teacherdata['user_id'])

            ->where('mois_id', $request->Teacherdata['scolarite']['idMois'])->orderBy('id', 'DESC')->get();

        return response()->json($datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAdminHeure(Request $request)


    {




        $moisId = $request->idMois;

        $notes = $request->Note;

        // Ici je ne fais rien je veux je veux seulement le code te la session : le 1 la est aleatoire

        $dat = Classe::where('id', 1)->first();

        $codeEtab = $dat->codeEtabClasse;

        $session = $dat->sessionClasse;

        // validons les notes qui arrivent


        // on voit d'abord si le tableau notes est totalement vides

        if ($notes == []) {

            return response()->json([
                'msg' => 'Aucune notes saisies',

            ], 403);
        } else {


            foreach ($notes as $key  => $valide) {


                // Ensuite on verifie chaque note pour s'assurer quelle est bonne


                if ($valide < 0) {

                    return response()->json([
                        'msg' => 'Soit la note est mauvaise, soit negative ou sp a 20 soit elle est vide',

                    ], 402);
                }

                // Faudra commentez ce else if  lorsque les profs vont mettre les heures avec leurs phones eux mm

                else if (Books::where('user_id', $key)->where('mois_id', $moisId)->exists()) {


                    return response()->json([
                        'msg' => 'Existe deja',

                    ], 401);
                } else {


                    $cahiers = Books::Create([

                        // 'matiere_id' => $request->matiere,
                        'mois_id' =>  $moisId,
                        // 'classe_id' => $request->idClasse,
                        'user_id' => $key,
                        // 'syllabs_id' => $request->chapitre,
                        // 'date' => $request->date,
                        'duree' => $valide,
                        'codeEtab' => $codeEtab,
                        'session' => $session,
                    ]);
                }
            }
        }
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
