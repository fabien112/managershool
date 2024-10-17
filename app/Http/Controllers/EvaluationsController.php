<?php

namespace App\Http\Controllers;

use App\Models\Enseignants;
use App\Models\Evaluations;
use App\Models\Session;
use App\Models\Trimestre;
use Illuminate\Http\Request;

class EvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function activateEvaluation(Request $request)
    {



        $this->validate($request, [

            'id' => 'required'

        ]);

        $datas =  Evaluations::where('id', $request->id)->update(['statut' => 1]);


        $datas =  Evaluations::where('id', '!=', $request->id)->update(['statut' => 0]);


        return $datas;
    }

    public function delateEvaluation(Request $request)
    {


        $this->validate($request, [

            'id' => 'required'

        ]);


        return Evaluations::where('id', $request->id)->delete();
    }

    public function addEvaluations(Request $request)

    {

        $this->validate($request, [

            'dateDebut' => 'required',
            'dateFin' => 'required',
            'libelle' => 'required',

        ]);

        //  Recuperons le code etab

        $codeEtab = $request['EtabInfos'][0]['codeEtab'];


        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->first();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata['libelle_sess'];

        // Recuperons le trimestre actif (id)

        $Trimestre = Trimestre::where('statut_semes', 1)->where('codeEta_semes', $codeEtab)->first('id');

        $IdTrimestre = $Trimestre['id'];

        // Assurons qu'on ne puisse pas creer 2 evaluations dans un trimestre


        $datas  = Evaluations::where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('trimestre_id', $IdTrimestre)->orderBy('id', 'desc')->get();

        if (count($datas) == 2) {

            return response()->json([
                'msg' => 'Plus de 2 evalutions impossible par trimestre',

            ], 400);
        } else {

            $datas = Evaluations::Create([
                'trimestre_id' => $IdTrimestre,
                'libelle' => $request->libelle,
                'statut' => 0,
                'dateDeb' => $request->dateDebut,
                'dateFin' => $request->dateFin,
                'codeEtab' => $codeEtab,
                'session' => $sessionEncour
            ]);
        }


        return response()->json($datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEvaluationAll(Request $request)

    {


        //  Recuperons le code etab

        $datas = Enseignants::where('user_id', $request['id'])->first();

        $codeEtab = $datas['codeEtab'];
        $session = $datas['session'];

        $datas  = Evaluations::with('trimestre')->where('codeEtab', $codeEtab)->where('session', $session)->orderBy('id', 'desc')->get();

        return response()->json($datas);
    }

    public function getEvaluationActif(Request $request)

    {

        $datasTrimestre   = Trimestre::where('statut_semes', 1)->first();

        //  dd($datasTrimestre);


        // $datas  = Evaluations::with('trimestre')->where('statut', 1)->orderBy('id', 'desc')->first();


        $datas  = Evaluations::with('trimestre')->where('trimestre_id', $datasTrimestre->id)->orderBy('id', 'asc')->get();

        return response()->json($datas);
    }

    public function getAllEvaluationsByParent(Request $request)

    {


        //  Recuperons le code etab

        $codeEtab = $request['classe']['codeEtabClasse'];

        // Recuperons les datas de la session en cour

        $session =  $request['classe']['sessionClasse'];

        $datas  = Evaluations::with('trimestre')->where('codeEtab', $codeEtab)->where('session', $session)->orderBy('id', 'desc')->get();


        return response()->json($datas);
    }

    public function getAllEvaluations(Request $request)

    {


        //  Recuperons le code etab

        $codeEtab = $request[0]['codeEtab'];
        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->first();
        // Recuperons le libelle  de la session en cour

        $session = $sessiondata['libelle_sess'];

        $datas  = Evaluations::with('trimestre')->where('codeEtab', $codeEtab)->where('session', $session)->orderBy('id', 'desc')->get();


        return response()->json($datas);
    }

    public function getAllEvaluations2(Request $request)

    {





        $datas  = Evaluations::with('trimestre')->orderBy('id', 'desc')->get();


        return response()->json($datas);
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
