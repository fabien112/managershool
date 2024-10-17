<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Session;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function updateParent(Request $request)

    {


        $idElev = $request->user_id;


        if ($request->imageLogo == '') {

            $request->imageLogo = 'parentdefault.png';
        }

        // if($request->cni||$request->address||$request->natio==''){

        //     $request->cni =  $request->address = $request->natio= 'RAS';

        // }
        //  Recuperons le code etab

        // $codeEtab = $request['EcoleInfos'][0]['codeEtab'];

        // // Recuperons les datas de la session en cour

        // $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        // // Recuperons le libelle  de la session en cour

        // $sessionEncour = $sessiondata[0]['libelle_sess'];


        $this->validate($request, [

            'nomAdmin' => 'required',
            'PrenomAdmin' => 'required',
            'telAdmin' => 'required',
            //'sexe' => 'required',
            // 'emailAdmin' => 'required',
            // 'loginAdmin' => 'required',
            //'passAdmin' => 'required',
            // 'CpassAdmin' => 'required',
            'profession' => 'required',

        ]);

        // Enregistrer dans la table user

        // if (User::where('nom', $request->nomAdmin)->where('prenom', $request->PrenomAdmin)
        //     ->where('telephone', $request->telAdmin)->exists()
        // ) {
        //     return response()->json([
        //         'msg' => 'Existe deja',

        //     ], 400);
        // }
        if (User::where('login', $request->loginAdmin)->exists()) {
            return response()->json([
                'msg' => 'Ce login existe deja',

            ], 401);
        } else {

            $user = User::where('id', $idElev)->update([
                'nom' => $request->nomAdmin,
                'prenom' => $request->PrenomAdmin,
                //'email' => $request->emailAdmin,
                //'login' => $request->loginAdmin,
                'telephone' => $request->telAdmin,
                //'password' => bcrypt($request->passAdmin),
                'photo' => $request->imageLogo,
                'type' => 'Parent'
            ]);

            // Enregistrer dans la table parent

            $parent  = Parents::where('id', $request->id)->update([

                'nomParent' => $request->nomAdmin,
                'prenomParent' => $request->PrenomAdmin,
                //'emailParent' => $request->emailAdmin,
                'telParent' => $request->telAdmin,
                // 'user_id' => $idElev,
                //'cniParent' => $request->cni,
                // 'nationaliteParent' => $request->natio,
                'professionParent' => $request->profession,
                // 'sexeParent' => $request->sexe,
                // 'addressParent' => $request->address,
                // 'codeEtab' => $codeEtab,
                // 'session' => $sessionEncour,

            ]);
        }



        // dd($request);
    }

    public function delateParent(Request $request)

    {


        // On supprimera dans la table user et celui-ci supprimera dans la table parent automatiquement

        $parent = Parents::where('id', $request->id)->first();

        $idUser = $parent->user_id;

        $this->validate($request, [

            'id' => 'required'

        ]);

        User::where('id', $idUser)->delete();
    }

    public function getInfosParent(Request $request)

    {

        // RECUPERONS LES INFOS DE LA TABLE ENSEIGNANT

        $Ecole = Parents::where('user_id', $request->id)->first();

        // id du parent  dans la table enseignant parent

        $idParent = $Ecole->id;

        // Prenons le codeEtab

        $codeEtab = $Ecole->codeEtab;

        //  Prenons  la session

        $sessionEncour = $Ecole->session;

        $Datas = Student::with('parent', 'Classe', 'user')->where('parent_id', $idParent)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return  response()->json($Datas);
    }



    public function getAllStudentofeParentByLocal(Request $request)

    {

        // Recuperrons l'id du parent

        $parentId = $request->id;

        $studentsParent = Student::with('classe', 'user')->where('parent_id', $parentId)
            ->where('session', $request->session)
            ->where('codeEtab', $request->codeEtab)->orderBy('id', 'desc')->get();

        return  response()->json($studentsParent);
    }


    public function addParent(Request $request)

    {


        //dd($request->cni);

        if ($request->imageLogo == '') {

            $request->imageLogo = 'parentdefault.png';
        }

        // if($request->cni||$request->address||$request->natio==''){

        //     $request->cni =  $request->address = $request->natio= 'RAS';

        // }
        //  Recuperons le code etab

        $codeEtab = $request['EcoleInfos'][0]['codeEtab'];

        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata[0]['libelle_sess'];


        $this->validate($request, [

            'nomAdmin' => 'required',
            'PrenomAdmin' => 'required',
            'telAdmin' => 'required',
            //'sexe' => 'required',
            // 'emailAdmin' => 'required',
            // 'loginAdmin' => 'required',
            'passAdmin' => 'required',
            // 'CpassAdmin' => 'required',
            'profession' => 'required',

        ]);

        // Enregistrer dans la table user

        if (User::where('nom', $request->nomAdmin)->where('prenom', $request->PrenomAdmin)
            ->where('telephone', $request->telAdmin)->exists()
        ) {
            return response()->json([
                'msg' => 'Existe deja',

            ], 400);
        } else if (User::where('login', $request->loginAdmin)->exists()) {
            return response()->json([
                'msg' => 'Ce login existe deja',

            ], 401);
        } else {

            $user = User::Create([
                'nom' => $request->nomAdmin,
                'prenom' => $request->PrenomAdmin,
                //'email' => $request->emailAdmin,
                'login' => $request->loginAdmin,
                'telephone' => $request->telAdmin,
                'password' => bcrypt($request->passAdmin),
                'photo' => $request->imageLogo,
                'type' => 'Parent'
            ]);

            // Enregistrer dans la table parent

            $parent  = Parents::Create([

                'nomParent' => $request->nomAdmin,
                'prenomParent' => $request->PrenomAdmin,
                //'emailParent' => $request->emailAdmin,
                'telParent' => $request->telAdmin,
                'user_id' => $user->id,
                //'cniParent' => $request->cni,
                // 'nationaliteParent' => $request->natio,
                'professionParent' => $request->profession,
                // 'sexeParent' => $request->sexe,
                // 'addressParent' => $request->address,
                'codeEtab' => $codeEtab,
                'session' => $sessionEncour,

            ]);
        }









        // dd($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getParent(Request $request)
    {

        // dd($request);

        //  Recuperons le code etab



        // Compter le nombre total de parents
        $count = Parents::count();

        // Récupérer les parents triés par nom et prénom
        $parents = Parents::orderBy('nomParent')
            ->orderBy('prenomParent')
            ->get();



        $Datas['totalPages'] = $count;
        // $Datas['content'] = $content;
        $Datas['parents'] = $parents;

        return response()->json($Datas);
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
