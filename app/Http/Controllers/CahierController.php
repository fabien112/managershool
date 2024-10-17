<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Cahier;
use App\Models\Classe;
use App\Models\Session;
use App\Models\Syllabs;
use App\Models\Matieres;
use App\Models\partiesyl;
use App\Models\Enseignants;
use App\Models\partiebooks;
use Illuminate\Http\Request;
use App\Models\PartieSyllabs;

class CahierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function getDetailsCahierTexte(Request $request){

        $id = $request->idTexte;

        $syllabus = Books::with('Syllabs')->where('id', $id)->first();

        // chapitre du cour ( il vient su syllabus )

        $titre =  $syllabus->Syllabs['chapitre'];

        $duree =  $syllabus->duree;


        // Les parties faites en classe


         $parties  = partiebooks::where('books_id', $syllabus->id)->get();


         foreach($parties as $data){

            $data['sp'] = [

                'sous' => explode('#', $data->souspartie)

            ] ;

            }


         $datas =  array(

            'titre' =>  $titre,
            'partie' => $parties,
            'duree'=>$duree

        );

        return response()->json($datas);

     }

    public function updatecahier(Request $request)
    {


        $this->validate($request, [

            'id' => 'required'

        ]);


        $user = Books::where('id', $request->id)->update([

            'duree' => $request->duree,

        ]);

    }

    public function delateNewBook(Request $request)
    {


        $this->validate($request, [

            'idCahier' => 'required'

        ]);


        return Books::where('id', $request->idCahier)->delete();
    }


    public function getPartieByMatiereAndclasse(Request $request)
    {

        $idChapitre = $request->chapitre;

        $datas =  partiesyl::where('syllabs_id', $idChapitre)->get();

        return  response()->json($datas);
    }


    public function getChapitreByMatiereAndclasse(Request $request)
    {

        $idClasse = $request->idClasse;

        $idMatiere = $request->matiere;

        $classes = Classe::where('id', $request->idClasse)->first();

        $codeEtab = $classes->codeEtabClasse;

        $session = $classes->sessionClasse;


        $datas =  Syllabs::with('Matiere', 'User', 'Classe', 'Objectif', 'Partie')->where('matiere_id', $idMatiere)->where('classe_id', $idClasse)

            ->where('codeEtab', $codeEtab)->where('session', $session)->get();

        return  response()->json($datas);
    }

    public function getAllCahierParentParClasse(Request $request)
    {


        $idClasse  = $request->classe['id'];

        $codeEtab = $request->classe['codeEtabClasse'] ;

        $sessionEncour = $request->classe['sessionClasse']  ;

        $datas =  Books::with('Matiere','user')->where('classe_id', $idClasse)->where('codeEtab', $codeEtab)
        ->where('session', $sessionEncour)->where('date', $request->date)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
    }

    public function getAllCahiersLocalParClasse(Request $request)
    {

        $codeEtab = $request['EtabInfos'][0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $datas =  Cahier::with('Matiere', 'Enseignants', 'Classe')->where('classe_id', $request->classeName)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
    }


    public function delateteCahierTeacher(Request $request)
    {


        return Cahier::where('id', $request->idCahier)->delete();
    }

    public function updateCahierTeacher(Request $request)

    {



        $this->validate($request, [

            'idCahier' => 'required'

        ]);

        Cahier::where('id', $request->idCahier)->update(['statut' => 1]);
    }


    public function getAllCahiersLocal(Request $request)

    {



        $codeEtab = $request[0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');


        $sessionEncour = $session->libelle_sess;


        $datas =  Cahier::with('Matiere', 'Enseignants', 'Classe')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->orderBy('id', 'desc')->get();


        return  response()->json($datas);
    }

    public function getAllCahierByATeacher(Request $request)

    {

        $users = Enseignants::where('user_id', $request->id)->first();

        $idTeacher = $users['id'];

        $codeEtab = $users['codeEtab'];

        $session = $users['session'];


        $datas =  Cahier::with('Matiere', 'Enseignants', 'Classe')->where('enseignants_id', $idTeacher)->where('codeEtab', $codeEtab)->where('session', $session)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
    }

    public function createCahier(Request $request)

    {

        $request->validate([

            'idClasse' => 'required|numeric',
            'imageEmploiTmp' => 'required',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date',
            'idMatiere' => 'required|numeric',

        ]);

        $users = Enseignants::where('user_id', $request->users['id'])->first();

        $idTeacher = $users->id;

        $codeEtab = $users->codeEtab;

        $session = $users->session;

        $Matiere = Matieres::where('id', $request->idMatiere)->first('libelle');

        $libelleMatiere = $Matiere->libelle;

        $Classe = Classe::where('id', $request->idClasse)->first('libelleClasse');

        $libelleClasse = $Classe->libelleClasse;

        $ClasseData = Cahier::create([

            'classe_id' => $request->idClasse,
            'matiere_id' => $request->idMatiere,
            'enseignants_id' => $idTeacher,
            'libelle' => $request->libelleDevoir,
            'dateDeb' => $request->dateDebut,
            'dateFin' => $request->dateFin,
            'document' => $request->imageEmploiTmp,
            'statut' => 0,
            'session' => $session,
            'codeEtab' => $codeEtab

        ]);

        // Adaptons la valeur envoye a la vue aux valeurs pris dans mouted,
        //ceci permet d'eviter de recharger la page poir voir le new cree

        $datsFormat =

            [

                'dateDeb' => $request->dateDebut,
                'dateFin' => $request->dateDebut,
                'statut' => 0,
                'document' => $request->imageEmploiTmp,
                'classe' => [

                    'libelleClasse' => $libelleClasse,
                ],
                'matiere' => [
                    'libelle' => $libelleMatiere
                ]

            ];

        return  response()->json($datsFormat);
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
