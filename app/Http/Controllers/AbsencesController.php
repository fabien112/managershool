<?php

namespace App\Http\Controllers;

use App\Models\Presences;
use Illuminate\Http\Request;
use App\Http\Controllers\Absences;
use App\Models\Evaluations;
use App\Models\Parents;

class AbsencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function updateAbsence(Request $request)
    {


        $idPresence = $request->id['id'];


        // $absence = Presences::where('id', $request->id)->first();

        // $idPres = $absence['id'];

        $this->validate($request, [

            'duree' => 'required|numeric|min:0'

        ]);

        Presences::where('id',  $idPresence)->update([
            'duree' => (int)$request->duree

        ]);
    }
    public function delateAbsence(Request $request)
    {

        // On supprimera dans la table absence


        $absence = Presences::where('id', $request->id)->first();

        $idPres = $absence['id'];

        $this->validate($request, [

            'id' => 'required'

        ]);

        // Presences::where('id', $idPres)->delete();

        Presences::where('id',  $idPres)->update([
            'etat' => 1

        ]);
    }
    public function getAbensesOfEleveclasseById(Request $request)


    {


        $this->validate($request, [

            'idEleve' => 'required|numeric|min:1',
            'idClasse' => 'required|numeric|min:1',
            'idTrimestre' => 'required|numeric|min:1',

        ]);



        $datas = Presences::with('student')
            ->where('student_id', $request->idEleve)->where('mois_id', $request->idTrimestre)->where('duree', '>', 0)->orderBy('dateHeure', 'desc')->get();

        foreach ($datas as $data) {



            $data['Parent'] = Parents::where('id', $data->student['parent_id'])->first();
        }


        // Somme heure annee


        $somme = Presences::with('student')
            ->where('student_id', $request->idEleve)->orderBy('dateHeure', 'asc')->sum('duree');


        // Somme heure annee non jsutifies


        $sommeNonJust = Presences::with('student')
            ->where('student_id', $request->idEleve)->where('etat', 0)->orderBy('dateHeure', 'asc')->sum('duree');



        // Absence totale
        $sommeTrimestre = Presences::with('student')->where('classe_id', $request->idClasse)
            ->where('student_id', $request->idEleve)->where('mois_id', $request->idTrimestre)->orderBy('dateHeure', 'asc')->sum('duree');


        // Absence non justifees
        $sommeTrimestreNonJust = Presences::with('student')->where('classe_id', $request->idClasse)
            ->where('student_id', $request->idEleve)->where('mois_id', $request->idTrimestre)->where('etat', 0)->orderBy('dateHeure', 'asc')->sum('duree');


        $total = [

            'sommeAnnee' => $somme,
            'sommeAnneeNjust' => $sommeNonJust,
            'sommmeTrimetre' => $sommeTrimestre,
            'sommeTrimestreNonJust' => $sommeTrimestreNonJust,
            'listeTrimestre' => $datas
        ];

        return response()->json($total);
    }

    public function getAbensesOfEleveclasseByParent(Request $request)

    {
        $datas = Presences::with('student')->where('classe_id', $request->classe_id)
            ->where('student_id', $request->id)
            ->where('duree', '>', 0)
            ->where('etat', 0)
            ->orderBy('id', 'DESC')->get();
        return response()->json($datas);
    }

    public function getAbensesOfEleveclasseByEleve(Request $request)

    {


        $datas = Presences::with('student')->where('classe_id', $request->classe_id)
            ->where('student_id', $request->id)
            ->where('duree', '>', 0)
            ->where('etat', 0)
            ->orderBy('id', 'DESC')->get();


        $evalutions = Evaluations::get();




        foreach ($datas as $dat) {

            $som1 = $som2 = $som3 = 0;

            if ($dat->evaluation_id == $evalutions[0]['id'] || $dat->evaluation_id == $evalutions[1]['id']) {

                $som1 = $som1 + $dat->duree;
            }

            if ($dat->evaluation_id == $evalutions[2]['id'] || $dat->evaluation_id == $evalutions[3]['id']) {

                $som2 = $som2 + $dat->duree;
            }

            if ($dat->evaluation_id == $evalutions[4]['id'] || $dat->evaluation_id == $evalutions[5]['id']) {

                $som3 = $som3 + $dat->duree;
            }

            $heures['T1'] = $som1;
            $heures['T2'] = $som2;
            $heures['T3'] = $som3;
        }

        return response()->json($heures);
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
