<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Trimestre;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Section;

class SessionController extends Controller


{

    public function cloturerSession(Request $request)
    {


        if ($request->rest == 0) {

            //  Dectiver le trimestre


            $datas = Trimestre::where('id', $request->id)->update([

                'statut_semes' => 0,


            ]);

            // $datas = Trimestre::where('id', "!=", $request->id)->update([

            //     'statut_semes' => 1,


            // ]);


        } else {

            //  Activer le trimestre


            $datas = Trimestre::where('id', $request->id)->update([

                'statut_semes' => 1,


            ]);

            $datas = Trimestre::where('id', "!=", $request->id)->update([

                'statut_semes' => 0,


            ]);
        }






        return response()->json($datas);
    }

    public function getTrimestreEtablissement(Request $request)

    {


        //  $codeEtab = $request[0]['codeEtab'];



        $datas = Session::with('Trimestres')->where('encours_sess', 1)->get();

        // dd($datas[0][]);

        // foreach ($datas as $data) {


        //     $trimetres = $data->trimestres;


        // }

        return response()->json($datas);
    }

    public function getSessionEtablissement(Request $request)

    {


        $codeEtab = $request[0]['codeEtab'];

        $datas = Session::with('Etablissement')->where('codeEtab_sess', $codeEtab)->orderBy('id', 'desc')->get();

        foreach ($datas as $data) {

            $SemestreEncours = $data->encours_sess;

            if ($SemestreEncours == 0) {

                $data->SemestreEncours = "TERMINEE";
            }

            if ($SemestreEncours == 1) {

                $data->SemestreEncours = "EN COURS ";
            }
        }


        return response()->json($datas);
    }

    public function addSession(Request $request)
    {

        // dd($request);


        $this->validate($request, [

            'AnneeScolaire' => 'required',
            'dateDebut' => 'required',
            'dateFin' => 'required'

        ]);

        if (Session::where('libelle_sess', $request->AnneeScolaire)->exists()) {
            return response()->json([
                'msg' => 'Existe deja',

            ], 400);
        } else {

            $sessionData = Session::Create([
                'libelle_sess' => $request->AnneeScolaire,
                'codeEtab_sess' => $request->EcoleInfos[0]['codeEtab'],
                'etablissement_id' => $request->EcoleInfos[0]['id'],
                'datedeb_sess' => $request->dateDebut,
                'datefin_sess' => $request->dateFin,
                'type_sess' => $request->buttonType,
                'encours_sess' => '1',
                'status_sess' => '1',
            ]);


            if ($request->buttonType == 'Trimestre') {

                $trimestre1 = Trimestre::Create([

                    'session_id' => $sessionData->id,
                    'codeEta_semes' => $sessionData->codeEtab_sess,
                    'libelle_semes' => ' TRIMESTRE 1 ',
                    'statut_semes' => '1',
                    'next_semes' => '1',

                ]);


                $trimestre2 = Trimestre::Create([

                    'session_id' => $sessionData->id,
                    'codeEta_semes' => $sessionData->codeEtab_sess,
                    'libelle_semes' => ' TRIMESTRE 2 ',
                    'statut_semes' => '0',
                    'next_semes' => '1',


                ]);

                $trimestre3 = Trimestre::Create([

                    'session_id' => $sessionData->id,
                    'codeEta_semes' => $sessionData->codeEtab_sess,
                    'libelle_semes' => ' TRIMESTRE 3 ',
                    'statut_semes' => '0',
                    'next_semes' => '1',


                ]);
            }


            if ($request->buttonType == 'Semestre') {

                $semestre1 = Trimestre::Create([

                    'session_id' => $sessionData->id,
                    'codeEta_semes' => $sessionData->codeEtab_sess,
                    'libelle_semes' => ' SEMESTRE 1 ',
                    'statut_semes' => '1',
                    'next_semes' => '1',


                ]);


                $semestre2 = Trimestre::Create([

                    'session_id' => $sessionData->id,
                    'codeEta_semes' => $sessionData->codeEtab_sess,
                    'libelle_semes' => ' SEMESTRE 2 ',
                    'statut_semes' => '0',
                    'next_semes' => '1',

                ]);
            }
        }

        return response()->json($sessionData);
    }


    public function section(Request $request)

    {

        $datas = Section::get();

        return response()->json($datas);
    }
}
