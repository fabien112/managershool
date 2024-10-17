<?php

namespace App\Http\Controllers;

use App\Models\Trimestre;
use App\Models\Enseignants;
use Illuminate\Http\Request;

class TrimestreController extends Controller
{
    public function getTrimestreActif(Request $request)

    {


        //  Recuperons le code etab

        $datas = Enseignants::where('user_id', $request['id'])->first();

        $codeEtab = $datas['codeEtab'];

        $datas  = Trimestre::where('statut_semes', 1)->where('codeEta_semes', $codeEtab)->first();

        return response()->json($datas);
    }

    public function getAllTrimestre()

    {


        //  Recuperons le code etab

        $datas = Trimestre::all();
        return response()->json($datas);
    }
}
