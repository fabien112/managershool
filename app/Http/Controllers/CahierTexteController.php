<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Heure;
use App\Models\Texte;
use App\Models\Classe;
use App\Models\CahierTexte;
use App\Models\Enseignants;
use App\Models\PartieTexte;
use Illuminate\Http\Request;
use App\Models\CahierTexteNew;
use App\Models\partiebooks;
use App\Models\PartieCahierTexteNew;
use App\Models\partiesyl;

class CahierTexteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getAllCahierNewByATeacher(Request $request)

    {


        $idMois =  (int)date('m');

        $users = Enseignants::where('user_id', $request->id)->first();

        $codeEtab = $users['codeEtab'];

        $session = $users['session'];

        $datas =  Books::with('Matiere', 'User', 'Classe', 'Syllabs')->where('user_id', $request->id)

            ->where('codeEtab', $codeEtab)->where('session', $session)->orderBy('id', 'desc')->get();



        foreach ($datas as $item) {


            // // Les partie du cour

            $parties  = partiebooks::where('books_id', $item->id)->get();

            $sousParties = explode('#', $item->souspartie);


            $part[$item->id] =  array(

                'partie' => $parties,

            );



            $item['partie'] = $part[$item->id];
        }

        return  response()->json($datas);
    }

    public function createCahierTexte(Request $request)
    {

        $idMois =  (int)date('m');


        $classes = Classe::where('id', $request->idClasse)->first();

        $codeEtab = $classes->codeEtabClasse;

        $session = $classes->sessionClasse;

        $Idduree = $request->duree;

        // $heures = Heure::where('id', $Idduree)->first('libelle');

        // $dureeVrai = $heures->libelle[0];

        $dureeVrai = $Idduree;

        $this->validate($request, [

            'classeName' => 'required|numeric',
            'chapitre' => 'required|numeric',
            'date' => 'required',
            'matiere' => 'required|numeric',
            // 'idMois' => 'required|numeric',
            'duree' => 'required|numeric|min:0'

        ]);

        // Ajouter le cahier de texte


        $parties = $request->inputs2;; // les parties ne doivent etre vides


        foreach ($parties as $valide) {



            if ($valide['partie'] == '') {

                return response()->json([
                    'msg' => 'Soit la note est mauvaise, soit negative ou sp a 20 soit elle est vide',

                ], 402);
            }
        }


        $cahiers = Books::Create([

            'matiere_id' => $request->matiere,
            'mois_id' => $idMois,
            'classe_id' => $request->idClasse,
            'user_id' => $request->users['id'],
            'syllabs_id' => $request->chapitre,
            'date' => $request->date,
            'duree' => $dureeVrai,
            'codeEtab' => $codeEtab,
            'session' => $session,
        ]);




        // Ajouter les parties de





        foreach ($parties as $partie) {


            $libelle = partiesyl::where('id', $partie['partie'])->first();

            $libelleNet = $libelle->libelle;

            $parties  = partiebooks::Create([

                'books_id' => $cahiers->id,
                'partie' => $libelleNet,
                'user_id' => $request->users['id'],
                'souspartie' => $partie['souspartie'],
                'codeEtab' => $codeEtab,
                'session' => $session,
            ]);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delateBook(Request $request)

    {


        $this->validate($request, [

            'id' => 'required'

        ]);

        Books::where('id', $request->id)->delete();


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
