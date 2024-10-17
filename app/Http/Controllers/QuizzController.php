<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use App\Models\Classe;
use App\Models\Session;
use App\Models\Questions;
use App\Models\Enseignants;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getAllQuizzLocalParClasse(Request $request)
    {


        $codeEtab = $request['EtabInfos'][0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $datas =  Quizz::with('Matiere', 'user', 'Classe', 'Question')->where('classe_id', $request->classeName)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
    }

    public function getAllQuizzParentParClasse(Request $request)
    {


        $codeEtab = $request->classe['codeEtabClasse'];

        $sessionEncour = $request->classe['sessionClasse'];

        $classId = $request->classe['id'];

        $datas =  Quizz::with('Matiere', 'user', 'Classe', 'Question')->where('classe_id', $classId)->where('statut', 1)
            ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
    }


    public function getAllQuizzLocal(Request $request)

    {

        $codeEtab = $request[0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $datas =  Quizz::with('Matiere', 'user', 'Classe', 'Question')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
    }


    public function delateQuizz(Request $request)
    {



        $this->validate($request, [

            'idCahier' => 'required'

        ]);


        return Quizz::where('id', $request->idCahier)->delete();
    }


    public function updateQuizz(Request $request)
    {


        $this->validate($request, [

            'idCahier' => 'required'

        ]);

        Quizz::where('id', $request->idCahier)->update(['statut' => 1]);
    }


    public function getAllQuizzByATeacher(Request $request)

    {

        $users = Enseignants::where('user_id', $request->id)->first();

        $codeEtab = $users['codeEtab'];

        $session = $users['session'];

        $datas =  Quizz::with('Matiere', 'User', 'Classe', 'Question')->where('user_id', $request->id)

            ->where('codeEtab', $codeEtab)->where('session', $session)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
    }


    public function createQuizz(Request $request)

    {



        $classes = Classe::where('id', $request->idClasse)->first();

        $codeEtab = $classes->codeEtabClasse;

        $session = $classes->sessionClasse;

        $this->validate($request, [

            'classeName' => 'required',
            'libelleDevoir' => 'required',
            'dateLimite' => 'required',
            'duree' => 'required',
            'consigne' => 'required',
            'verrouiller' => 'required'

        ]);

        if ($request->verrouiller = 'Oui') {

            $request->verrouiller = 1;
        }

        if ($request->verrouiller != 'Oui') {

            $request->verrouiller = 0;
        }

        // Creer le quizz tout seul


        $Quests = $request->inputs; // les questions

        foreach ($Quests as $valide) {



            if ($valide['name'] == '' || $valide['resp'] == "" || $valide['point'] == "") {

                return response()->json([
                    'msg' => 'Soit la note est mauvaise, soit negative ou sp a 20 soit elle est vide',

                ], 402);
            }
        }


        $quizz = Quizz::Create([

            'matiere_id' => $request->matiere,
            'classe_id' => $request->idClasse,
            'user_id' => $request->users['id'],
            'libelle' => $request->libelleDevoir,
            'consigne' => $request->consigne,
            'date' => $request->dateLimite,
            'duree' => $request->duree,
            'verrouiller' => $request->verrouiller,
            'statut' => '0',
            'codeEtab' => $codeEtab,
            'session' => $session,
        ]);

        // Creer les questions du  quizz




        foreach ($Quests as $quest) {


            $questions = Questions::Create([

                'quizz_id' => $quizz->id,
                'libelle_question' => $quest['name'],
                'resp_question' => $quest['resp'],
                'point' => $quest['point'],
                'mode_reponse' => "V/F",
            ]);
        }






        //dd($request);









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
