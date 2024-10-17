<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Moyennes;
use Illuminate\Http\Request;
use App\Models\MoyenneTrimestres;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatClasse(Request $request)

    {


        // STAT ECOLE

        $MaxEcole = Moyennes::with('student')->where('evaluation_id', $request->libelleEvaluation)->max('valeur');

        $eleveMaxEcole = Moyennes::with('student')->where('evaluation_id', $request->libelleEvaluation)->where('valeur', $MaxEcole)->first();

        $photoMax = Student::with('user', 'classe')->where('id', $eleveMaxEcole->student->id)->first();

        $eleveMaxEcole->photo = $photoMax;

        $MinEcole = Moyennes::with('student')->where('evaluation_id', $request->libelleEvaluation)->where('valeur', '>', 0)->min('valeur');

        $eleveMinEcole = Moyennes::with('student')->where('evaluation_id', $request->libelleEvaluation)->where('valeur', $MinEcole)->first();

        $photoMin = Student::with('user', 'classe')->where('id', $eleveMinEcole->student->id)->first();

        $eleveMinEcole->photo = $photoMin;

        // STAT CLASSE

        $TotalNotes =  Moyennes::where('evaluation_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->get();

        $TotalNotesResuiiste =  Moyennes::where('evaluation_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->where('valeur', '>=', 10)->get();

        $TotalNotesEcole = Moyennes::where('evaluation_id', $request->libelleEvaluation)->get();

        $TotalNotesResuiisteEcole =  Moyennes::where('evaluation_id', $request->libelleEvaluation)->where('valeur', '>=', 10)->get();



        // pourcentage par garcons et filles

        $nombreGarcon = 0;
        $nombreGarconAdmis = 0;
        $nombreFilleAdmis = 0;
        $nombreFille = 0;


        // Je totLIE LES GARCON  et fille DE LA CLASSE

        foreach ($TotalNotes as $note) {

            // Total garcon

            $Eleve =  Student::where('id', $note->student_id)->where('sexe', 'M')->get();

            $nombreGarcon =  $nombreGarcon + count($Eleve);
        }



        $nombreFille =  count($TotalNotes) - $nombreGarcon;


        // Je totLIE LES GARCON DE LA CLASSE ADMIS


        foreach ($TotalNotesResuiiste as $note) {


            $Eleve =  Student::where('id', $note->student_id)->where('sexe', 'M')->get();

            $nombreGarconAdmis =  $nombreGarconAdmis + count($Eleve);
        }



        // Je totLIE LES Fille  DE LA CLASSE ADMISe


        foreach ($TotalNotesResuiiste as $note) {


            $Eleve =  Student::where('id', $note->student_id)->where('sexe', 'F')->get();

            $nombreFilleAdmis =  $nombreFilleAdmis + count($Eleve);
        }

        if ($nombreFille == 0 && $nombreGarcon != 0) {

            $porcentageFilleAdmise = 0;

            $porcentageGarconAdmis = 100 * $nombreGarconAdmis / $nombreGarcon;
        }
        if ($nombreGarcon == 0 && $nombreFille != 0) {

            $porcentageGarconAdmis = 0;

            $porcentageFilleAdmise = 100 * $nombreFilleAdmis / $nombreFille;
        }


        if ($nombreGarcon != 0 && $nombreFille != 0) {
            $porcentageFilleAdmise = 100 * $nombreFilleAdmis / $nombreFille;

            $porcentageGarconAdmis = 100 * $nombreGarconAdmis / $nombreGarcon;
        }

        if (count($TotalNotes) == 0) {

            return response()->json([
                'msg' => 'Aucn eleve ',
                'status' => 'NOK'
            ], 401);
        }


        if (count($TotalNotes) != 0) {


            $Max = Moyennes::with('student')->where('evaluation_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->max('valeur');

            $eleveMax = Moyennes::with('student')->where('evaluation_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->where('valeur', $Max)->first();

            $photoMax = Student::with('user')->where('id', $eleveMax->student->id)->first();

            $eleveMax->photo = $photoMax;

            $Min = Moyennes::with('student')->where('evaluation_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->where('valeur', '>', 0)->min('valeur');

            $eleveMin = Moyennes::with('student')->where('evaluation_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->where('valeur', $Min)->first();

            $photoMin = Student::with('user')->where('id', $eleveMin->student->id)->first();

            $eleveMin->photo = $photoMin;



            $datas = [

                'nbreAll' => count($TotalNotes),
                'nbreAllAdmis' => count($TotalNotesResuiiste),
                'pourcetageAlladmis' => number_format((count($TotalNotesResuiiste) / count($TotalNotes)) * 100, 2),
                'pourcetageAlladmis' => number_format((count($TotalNotesResuiiste) / count($TotalNotes)) * 100, 2),
                'numberGarcon' => $nombreGarcon,
                'numberGarconAdmis' => $nombreGarconAdmis,
                'pourcentgarconAdmis' => number_format($porcentageGarconAdmis, 2),
                'nombreFille' => $nombreFille,
                'nombreFilleAdmis' => $nombreFilleAdmis,
                'pourcentfilleAdmis' => number_format($porcentageFilleAdmise, 2),
                'eleveMax' => $eleveMax,
                'eleveMin' => $eleveMin,
                'porcentageAdmisEcole' => number_format((count($TotalNotesResuiisteEcole) / count($TotalNotesEcole)) * 100, 2),
                'eleveMaxEcole' => $eleveMaxEcole,
                'eleveMinEcole' => $eleveMinEcole,

            ];


            return  response()->json($datas);
        }
    }


    public function getStatClasseTrimestre(Request $request)

    {


        // STAT ECOLE

        $MaxEcole = MoyenneTrimestres::with('student')->where('trimestre_id', $request->libelleEvaluation)->max('valeur');

        $eleveMaxEcole = MoyenneTrimestres::with('student')->where('trimestre_id', $request->libelleEvaluation)->where('valeur', $MaxEcole)->first();

        $photoMax = Student::with('user', 'classe')->where('id', $eleveMaxEcole->student->id)->first();

        $eleveMaxEcole->photo = $photoMax;

        $MinEcole = MoyenneTrimestres::with('student')->where('trimestre_id', $request->libelleEvaluation)->where('valeur', '>', 0)->min('valeur');

        $eleveMinEcole = MoyenneTrimestres::with('student')->where('trimestre_id', $request->libelleEvaluation)->where('valeur', $MinEcole)->first();

        $photoMin = Student::with('user', 'classe')->where('id', $eleveMinEcole->student->id)->first();

        $eleveMinEcole->photo = $photoMin;

        // STAT CLASSE

        $TotalNotes =  MoyenneTrimestres::where('trimestre_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->get();

        $TotalNotesResuiiste =  MoyenneTrimestres::where('trimestre_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->where('valeur', '>=', 10)->get();

        $TotalNotesEcole = MoyenneTrimestres::where('trimestre_id', $request->libelleEvaluation)->get();

        $TotalNotesResuiisteEcole =  MoyenneTrimestres::where('trimestre_id', $request->libelleEvaluation)->where('valeur', '>=', 10)->get();



        // pourcentage par garcons et filles

        $nombreGarcon = 0;
        $nombreGarconAdmis = 0;
        $nombreFilleAdmis = 0;
        $nombreFille = 0;


        // Je totLIE LES GARCON  et fille DE LA CLASSE

        foreach ($TotalNotes as $note) {

            // Total garcon

            $Eleve =  Student::where('id', $note->student_id)->where('sexe', 'M')->get();

            $nombreGarcon =  $nombreGarcon + count($Eleve);
        }



        $nombreFille =  count($TotalNotes) - $nombreGarcon;


        // Je totLIE LES GARCON DE LA CLASSE ADMIS


        foreach ($TotalNotesResuiiste as $note) {


            $Eleve =  Student::where('id', $note->student_id)->where('sexe', 'M')->get();

            $nombreGarconAdmis =  $nombreGarconAdmis + count($Eleve);
        }



        // Je totLIE LES Fille  DE LA CLASSE ADMISe


        foreach ($TotalNotesResuiiste as $note) {


            $Eleve =  Student::where('id', $note->student_id)->where('sexe', 'F')->get();

            $nombreFilleAdmis =  $nombreFilleAdmis + count($Eleve);
        }

        if ($nombreFille == 0 && $nombreGarcon != 0) {

            $porcentageFilleAdmise = 0;

            $porcentageGarconAdmis = 100 * $nombreGarconAdmis / $nombreGarcon;
        }
        if ($nombreGarcon == 0 && $nombreFille != 0) {

            $porcentageGarconAdmis = 0;

            $porcentageFilleAdmise = 100 * $nombreFilleAdmis / $nombreFille;
        }


        if ($nombreGarcon != 0 && $nombreFille != 0) {
            $porcentageFilleAdmise = 100 * $nombreFilleAdmis / $nombreFille;

            $porcentageGarconAdmis = 100 * $nombreGarconAdmis / $nombreGarcon;
        }

        if (count($TotalNotes) == 0) {

            return response()->json([
                'msg' => 'Aucn eleve ',
                'status' => 'NOK'
            ], 401);
        }


        if (count($TotalNotes) != 0) {


            $Max = MoyenneTrimestres::with('student')->where('trimestre_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->max('valeur');

            $eleveMax = MoyenneTrimestres::with('student')->where('trimestre_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->where('valeur', $Max)->first();

            $photoMax = Student::with('user')->where('id', $eleveMax->student->id)->first();

            $eleveMax->photo = $photoMax;

            $Min = MoyenneTrimestres::with('student')->where('trimestre_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->where('valeur', '>', 0)->min('valeur');

            $eleveMin = MoyenneTrimestres::with('student')->where('trimestre_id', $request->libelleEvaluation)->where('classe_id', $request->idClasse)->where('valeur', $Min)->first();

            $photoMin = Student::with('user')->where('id', $eleveMin->student->id)->first();

            $eleveMin->photo = $photoMin;



            $datas = [

                'nbreAll' => count($TotalNotes),
                'nbreAllAdmis' => count($TotalNotesResuiiste),
                'pourcetageAlladmis' => number_format((count($TotalNotesResuiiste) / count($TotalNotes)) * 100, 2),
                'pourcetageAlladmis' => number_format((count($TotalNotesResuiiste) / count($TotalNotes)) * 100, 2),
                'numberGarcon' => $nombreGarcon,
                'numberGarconAdmis' => $nombreGarconAdmis,
                'pourcentgarconAdmis' => number_format($porcentageGarconAdmis, 2),
                'nombreFille' => $nombreFille,
                'nombreFilleAdmis' => $nombreFilleAdmis,
                'pourcentfilleAdmis' => number_format($porcentageFilleAdmise, 2),
                'eleveMax' => $eleveMax,
                'eleveMin' => $eleveMin,
                'porcentageAdmisEcole' => number_format((count($TotalNotesResuiisteEcole) / count($TotalNotesEcole)) * 100, 2),
                'eleveMaxEcole' => $eleveMaxEcole,
                'eleveMinEcole' => $eleveMinEcole,

            ];


            return  response()->json($datas);
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
