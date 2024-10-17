<?php

namespace App\Http\Controllers;

use App\Models\approvisionnement;
use App\Models\banque;
use App\Models\Session;
use App\Models\salaires;
use Illuminate\Http\Request;


class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function addVersementBanque(Request $request)


    {

        // Je verse en banque (ajoute dans la table banque ) et je diminue la caisse ( j'ajoute dans la table salaire)



        $idMois =  (int)date('m');

        $codeEtab = $request->EtabInfos[0]['codeEtab'];

        $sessiondata = Session::where(
            'codeEtab_sess',
            $codeEtab
        )->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        $sessionEncour = $sessiondata[0]['libelle_sess'];

        $data = banque::create([

            'mois_id' => $idMois,
            'montant' => $request->montant,
            'motif' =>  "Caisse-Banque",
            'codeEtab' => $codeEtab,
            'session' => $sessionEncour,
            'type' => 'dep',  // depot de banque vers caisse
            'date' => $request->date
        ]);

        $data2 = salaires::create([

            'banque_id' => $data->id,
            'mois_id' => $idMois,
            'type' => 3,      // 1 = salaire personnel , 0 = salaire enseigant et 2 = autres depense; 3 = depot caisse vers banque
            'montant' => $request->montant,
            'motif' => $request->motif,
            'codeEtab' => $codeEtab,
            'session' => $sessionEncour,
            'date' => date('Y-m-d H')
        ]);




    }


    public function getEntressAutre()
    {

        // Toutes les entrees et sorties de la banque

        $data = banque::where('type', 'dep')->orderBy('id', 'desc')->get();

        $datasorti = banque::where('type', 'ret')->orderBy('id', 'desc')->get();


        $datatotal = banque::where('type', 'dep')->orderBy('id', 'desc')->sum('montant');

        $datasortiTotal = banque::where('type', 'ret')->orderBy('id', 'desc')->sum('montant');



        $array = [
            'appro' => $data,
            'sorti' => $datasorti,
            'totalAppro' => $datatotal,
            'totalSortiBank' =>  $datasortiTotal
        ];

        return response()->json($array);
    }


    public function retraitBanque(Request $request)


    {


      /* Ici je diminue l'argent en Banque (table bank) et j'augmente la caisse (table approvisionnement) */

        $idMois =  (int)date('m');

        $codeEtab = $request->EtabInfos[0]['codeEtab'];

        // Recuperons les datas de la session en cour

        $sessiondata = Session::where(
            'codeEtab_sess',
            $codeEtab
        )->where('encours_sess', 1)->orderBy('id', 'desc')->get();


        $sessionEncour = $sessiondata[0]['libelle_sess'];

        $data = banque::create([

            'mois_id' => $idMois,
            'montant' => $request->montant,
            'motif' =>  "Banque-Caisse",
            'codeEtab' => $codeEtab,
            'session' => $sessionEncour,
            'type' => 'ret',  // depot de banque vers caisse
            'date' => $request->date
        ]);

        $data = approvisionnement::create([
            'banque_id'=> $data->id,
            'mois_id' => $idMois,
            'montant' => $request->montant,
            'codeEtab' => $codeEtab,
            'session' => $sessionEncour,
            'date' => $request->date

        ]);
    }


    public function delateBanque(Request $request) {


        $this->validate($request, [

            'id' => 'required'

        ]);


        banque::where('id', $request->id)->delete();

        if($request->type=='dep') {

            salaires::where('banque_id', $request->id)->delete();

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
