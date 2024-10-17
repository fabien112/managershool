<?php

namespace App\Http\Controllers;

use App\Models\Devoirs;
use App\Models\Enseignants;
use App\Models\Heure;
use App\Models\Session;
use Illuminate\Http\Request;

class DevoirsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDevoir ( Request $request)
    {

        $request->validate([
            'classeName' => 'required',
            'libelleDevoir'=>'required|string',
            'dateLimite'=>'required',
            'instructions'=>'required',

        ]);

        $users = Enseignants::where('user_id',$request->users['id'])->first();

        $idTeacher = $users->id;

        $codeEtab = $users->codeEtab;

        $session = $users->session;

        if($request->verrouiller=='Oui'){

            $request->verrouiller = 1 ;


        }


        else {

            $request->verrouiller = 0 ;


        }

        $ClasseData = Devoirs::create([

            'classe_id' => $request->classeName,
            'matiere_id'=>$request->matiere,
            'enseignants_id'=>$idTeacher,
            'libelle'=>$request->libelleDevoir,
            'dateLimite'=>$request->dateLimite,
            'document'=>$request->imageLogo,
            'instructions'=>$request->instructions,
            'session'=>$session,
            'codeEtab'=>$codeEtab

        ]);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function getAllHeures( Request $request)

    {


        $datas =  Heure::All();


        return  response()->json($datas);
    }


    public function getAllDevoirsParentParClasse(Request $request){



        $codeEtab = $request->classe['codeEtabClasse'];

        $sessionEncour = $request->classe['sessionClasse'];

        $classId = $request->classe['id'];

        $datas =  Devoirs::with('Matiere','Enseignants','Classe')->where('classe_id',$classId)->where('statut', 1)
                        ->where('codeEtab',$codeEtab)->where('session', $sessionEncour)->orderBy('id','desc')->get();

        return  response()->json($datas);

     }


     public function getAllDevoirsLocalParClasse(Request $request){


        $codeEtab = $request['EtabInfos'][0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $datas =  Devoirs::with('Matiere','Enseignants','Classe')->where('classe_id',$request->classeName)->where('codeEtab',$codeEtab)->where('session', $sessionEncour)->orderBy('id','desc')->get();

        return  response()->json($datas);

     }

    public function getAllDevoirsLocal( Request $request)

    {

        $codeEtab = $request[0]['codeEtab'];

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $datas =  Devoirs::with('Matiere','Enseignants','Classe')->where('codeEtab',$codeEtab)->where('session', $sessionEncour)->orderBy('id','desc')->get();


        return  response()->json($datas);
    }


    public function getAllDevoirsTeacher ( Request $request)

    {

        $users = Enseignants::where('user_id', $request->id)->first();

        $idTeacher = $users['id'];


        $codeEtab = $users['codeEtab'];



        $session = $users['session'];


        $datas =  Devoirs::with('Matiere','Enseignants','Classe')->where('enseignants_id',$idTeacher)->where('codeEtab',$codeEtab)->where('session', $session)->orderBy('id','desc')->get();


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

    public function delateDevoir(Request $request){

        $this->validate($request, [

            'id' => 'required'

        ]);


        return Devoirs::where('id', $request->id)->delete();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function posterCorrectionDevoirsTeacher (Request $request)
    {



        $this->validate($request, [

            'idDevoir' => 'required'

        ]);

         Devoirs::where('id',$request->idDevoir)->update(['support'=> $request->imageEmploiTmp]);

    }
    public function updateDevoirsTeacher (Request $request)
    {
        $this->validate($request, [

            'idDevoir' => 'required'

        ]);

         Devoirs::where('id',$request->idDevoir)->update(['statut'=> 1]);

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
