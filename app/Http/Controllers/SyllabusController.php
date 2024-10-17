<?php

namespace App\Http\Controllers;

use App\Models\Heure;
use App\Models\Classe;
use App\Models\Syllabs;
use App\Models\Enseignants;
use Illuminate\Http\Request;
use App\Models\PartieSyllabs;
use App\Models\ObjectifSyllabs;
use App\Models\partiesyl;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function delateSyllabus(Request $request)
    {





        $this->validate($request, [

            'idCahier' => 'required'

        ]);


        return Syllabs::where('id', $request->idCahier)->delete();
    }

    public function getAllSyllabusByATeacher(Request $request)

    {

        $users = Enseignants::where('user_id', $request->id)->first();

        $codeEtab = $users['codeEtab'];

        $session = $users['session'];

        $datas =  Syllabs::with('Matiere', 'User', 'Classe', 'Objectif', 'Partie')->where('user_id', $request->id)

            ->where('codeEtab', $codeEtab)->where('session', $session)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
    }

    public function createSyllabus(Request $request)
    {




        $classes = Classe::where('id', $request->idClasse)->first();

        $codeEtab = $classes->codeEtabClasse;

        $session = $classes->sessionClasse;

        $Idduree = $request->duree;

        // $heures = Heure::where('id', $Idduree)->first('libelle');

        $dureeVrai = $Idduree;

        $objectifs = $request->inputs1;

        $parties = $request->inputs2;


        $this->validate($request, [

            'classeName' => 'required|numeric',
            'chapitre' => 'required|string',
            // 'date' => 'required',
            'matiere' => 'required|numeric',
            'duree'  => 'required|numeric'

        ]);


        foreach ($objectifs as $valide) {

            // Ensuite on verifie chaque note pour s'assurer quelle est bonne


            if ($valide['objectif'] == '' ||  $valide['objectif']  == null) {

                return response()->json([
                    'msg' => 'Tous les obejectifs ne sont pas saisies',

                ], 402);
            }
        }

        foreach ($parties as $valide) {

            // Ensuite on verifie chaque note pour s'assurer quelle est bonne


            if ($valide['partie'] == '' ||  $valide['partie'] == null) {

                return response()->json([
                    'msg' => 'Tous les parties ne sont pas saisies',

                ], 402);
            }
        }


        // Ajouter le syllabus

        $syllabus = Syllabs::Create([

            'matiere_id' => $request->matiere,
            'classe_id' => $request->idClasse,
            'user_id' => $request->users['id'],
            'chapitre' => $request->chapitre,
            'date' => $request->date,
            'duree' => $dureeVrai,
            'codeEtab' => $codeEtab,
            'session' => $session,
        ]);

        // Creer les objectis du syllabus



        foreach ($objectifs as $objectif) {


            $questions = ObjectifSyllabs::Create([
                'syllabs_id' => $syllabus->id,
                'libelle' => $objectif['objectif'],
                'codeEtab' => $codeEtab,
                'session' => $session,
            ]);
        }

        // Creer les parties du syllabus




        foreach ($parties as $partie) {

            $parties = partiesyl::Create([
                'syllabs_id' => $syllabus->id,
                'libelle' => $partie['partie'],
                'exercice' => $partie['exercie'],
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
