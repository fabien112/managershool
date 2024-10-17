<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Classe;
use App\Models\Session;
use App\Models\Matieres;
use App\Models\Enseignants;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllCoursLocal ( Request $request)

    {



        $codeEtab = $request[0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');


        $sessionEncour = $session->libelle_sess;


        $datas =  Cours::with('Matiere','Enseignants','Classe')->where('codeEtab',$codeEtab)->where('session', $sessionEncour)->orderBy('id','desc')->get();


       return  response()->json($datas);

    }

    public function getAllCoursParentParClasse(Request $request)  {

        $idClasse  = $request['classe']['id'];

        $codeEtab = $request['classe']['codeEtabClasse'];

        $sessionEncour = $request['classe']['sessionClasse'];

        $datas =  Cours::with('Matiere','Enseignants','Classe')->where('classe_id',$idClasse)->where('codeEtab',$codeEtab)->where('session', $sessionEncour)->orderBy('id','desc')->get();

        return  response()->json($datas);

     }

    public function delateCoursTeacher(Request $request){


        return Cours::where('id', $request->idCahier)->delete();

    }

    public function updateCoursTeacher (Request $request)

    {



        $this->validate($request, [

            'idCahier' => 'required'

        ]);

         Cours::where('id',$request->idCahier)->update(['statut'=> 1]);

    }

    public function getAllCoursByATeacher ( Request $request)

    {

        $users = Enseignants::where('user_id', $request->id)->first();

        $idTeacher = $users['id'];

        $codeEtab = $users['codeEtab'];

        $session = $users['session'];


        $datas =  Cours::with('Matiere','Enseignants','Classe')->where('enseignants_id',$idTeacher)->where('codeEtab',$codeEtab)->where('session', $session)->orderBy('id','desc')->get();

        return  response()->json($datas);
    }
    public function createCours ( Request $request)

    {

        $request->validate([

            'idClasse' => 'required|numeric',
            'imageEmploiTmp'=>'required',
            'chapitre'=>'required',
            'competence'=>'required',
            'idMatiere'=>'required|numeric',

        ]);

        $users = Enseignants::where('user_id',$request->users['id'])->first();

        $idTeacher = $users->id;

        $codeEtab = $users->codeEtab;

        $session = $users->session;

        $Matiere = Matieres::where('id',$request->idMatiere)->first('libelle');

        $libelleMatiere = $Matiere->libelle;

        $Classe = Classe::where('id',$request->idClasse)->first('libelleClasse');

        $libelleClasse = $Classe->libelleClasse;

        $ClasseData = Cours::create([

            'classe_id' => $request->idClasse,
            'matiere_id'=>$request->idMatiere,
            'enseignants_id'=>$idTeacher,
            'libelle'=>$request->libelleDevoir,
            'chapitre'=>$request->chapitre,
            'competence'=>$request->competence,
            'document'=>$request->imageEmploiTmp,
            'statut'=>0,
            'session'=>$session,
            'codeEtab'=>$codeEtab

        ]);

        // Adaptons la valeur envoye a la vue aux valeurs pris dans mouted,
        //ceci permet d'eviter de recharger la page poir voir le new cree

        $datsFormat =

        [

                'chapitre' => $request->chapitre,
                'competence' => $request->competence,
                'statut'=>0,
                'document'=>$request->imageEmploiTmp,
                'classe' => [

                    'libelleClasse'=>$libelleClasse,
                ],
                'matiere'=>[
                    'libelle'=>$libelleMatiere
                ]

        ];

        return  response()->json($datsFormat);



//         $url = 'https://fcm.googleapis.com/fcm/send';

//         $apiKey = "BPYOocomuWjTlePlyTezoccPhE5ovz4bE4qyPAiP8o1ML8U-IXikvtazy3ztI8abisIsLD9zzdF7Qnsa81d_1eA";

//         $headers = array (
//             'Authorization:key=' . $apiKey,
//             'Content-Type:application/json'
//           );

//           // Add notification content to a variable for easy reference
//           $notifData = [
//             'title' => "Test Title",
//             'body' => "Test notification body",
//             'click_action' => "android.intent.action.MAIN"
//           ];

//           $apiBody = [
//             'notification' => $notifData,
//             'data' => $notifData,
//             "time_to_live" => "600" , // Optional
//             // 'to' => '/topics/mytargettopic' // Replace 'mytargettopic' with your intended notification audience

//             'to' => '/topics/mytargettopic'
//           ];

//            // Initialize curl with the prepared headers and body
//   $ch = curl_init();
//   curl_setopt ($ch, CURLOPT_URL, $url );
//   curl_setopt ($ch, CURLOPT_POST, true );
//   curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
//   curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true );
//   curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

//   // Execute call and save result
//   $result = curl_exec ( $ch );

//   // Close curl after call
//   curl_close ( $ch );

//   return $result;





    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCoursLocalParClasse (Request $request)
    {
        $codeEtab = $request['EtabInfos'][0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');


        $sessionEncour = $session->libelle_sess;


        $datas =  Cours::with('Matiere', 'Enseignants', 'Classe')->where('classe_id', $request->classeName)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return  response()->json($datas);
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
