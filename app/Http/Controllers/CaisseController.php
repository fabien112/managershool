<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\caisse;
use App\Models\Classe;
use App\Models\Parents;
use App\Models\Session;
use App\Models\Student;
use App\Models\Trimestre;
use App\Models\discipline;
use App\Models\Enseignants;
use Illuminate\Http\Request;
use App\Models\Etablissement;

class CaisseController extends Controller
{



    public function affecterSurveillant2(Request  $request){

        $idTeacher = $request->Surveillant;

        $request->validate([
            'id' => 'required',
            'Surveillant' =>"required"

        ]);


        // ici je mets l'id de l'enseigant dans la table matiere

        // Je mets a jour affect dans la table matiere de 0 a 1

        $idMatiere = Classe::where('id', $request->id)->update([

            //'sectionClasse' => '1', // occupee ou non
            'order_Classe' => $idTeacher // Id du surveillant
        ]);

    }

    public function affecterSurveillant(Request  $request){

        $idTeacher = $request->Surveillant;

        $request->validate([
            'id' => 'required',
            'Surveillant' =>"required"

        ]);


        // ici je mets l'id de l'enseigant dans la table matiere

        // Je mets a jour affect dans la table matiere de 0 a 1

        $idMatiere = Classe::where('id', $request->id)->update([

            'sectionClasse' => '1', // occupee ou non
            'order_Classe' => $idTeacher // Id du surveillant
        ]);

    }


    public function getAllSurveillant (Request  $request)

    {


        $codeEtab = $request[0]['codeEtab'];

        // dd($request[0]['codeEtab']);

        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->first();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata['libelle_sess'];



        $infos = caisse::where('role','SG')->where('codeEtab',$codeEtab)->where('session',$sessionEncour)->get();

        return response()->json($infos);



    }


    public function getEtabinfosCaisse(Request  $request)

    {

        //  Je recupre ici comme si c'etait un admin ( utuliateur id = 1 dans user ) pour ne plus refaire les mm api


        $user = User::with('Etablissements')->where('id', 1)->get();

        $id = $user[0]['Etablissements'][0]['id'];

        $infos = Etablissement::with('users')->where('id', $id)->get();

        return response()->json($infos);
    }

    public function getCaissep(Request $request)

    {


        //  Recuperons le code etab

        $codeEtab = $request['EcoleInfos'][0]['codeEtab'];


        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->first();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata['libelle_sess'];

        // Recuperons tous les enseignants

        $Datas = caisse::where('session', $sessionEncour)->where('sexe', 'per')->where('codeEtab', $codeEtab)->orderBy('id', 'desc')->get();

        return  response()->json($Datas);
    }

    public function getCaisse(Request $request)

    {


        //  Recuperons le code etab

        $codeEtab = $request['EcoleInfos'][0]['codeEtab'];


        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->first();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata['libelle_sess'];

        // Recuperons tous les enseignants

        $Datas = caisse::where('session', $sessionEncour)->where('sexe',NULL)->where('codeEtab', $codeEtab)->orderBy('id', 'desc')->get();

        return  response()->json($Datas);
    }

    public function updatecaissiere(Request $request)

    {

        if ($request->role == 'autre') {
            $role = $request->autre;
        } else {

            $role = $request->role;
        }





        //  Recuperons le code etab

        // $codeEtab = $request['EcoleInfos'][0]['codeEtab'];

        // // Recuperons les datas de la session en cour

        // $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        // // Recuperons le libelle  de la session en cour

        // $sessionEncour = $sessiondata[0]['libelle_sess'];

        // dd( $codeEtab);

        $this->validate($request, [

            'nomAdmin' => 'required',
            'PrenomAdmin' => 'required',
            'telAdmin' => 'required',
            'salaire' => 'required',
            'role' => 'required',
            // 'loginAdmin' => 'required',
            // 'passAdmin' => 'required',
            'emailAdmin' => 'required|email',

        ]);


        // Enregistrer dans la table User

        if ($request->imageLogo == '') {

            $request->imageLogo = 'elevedefault.png';
        }


        if ($request->type == '') {

            $request->type = 1; // titulaire enseigant par default

        }


        // if (User::where('nom', $request->nomAdmin)->where('prenom', $request->PrenomAdmin)
        //     ->where('telephone', $request->telAdmin)->exists()
        // ) {
        //     return response()->json([
        //         'msg' => 'Existe deja',

        //     ], 400);
        // } else if (User::where('login', $request->loginAdmin)->exists()) {
        //     return response()->json([
        //         'msg' => 'Ce login existe deja',

        //     ], 401);
        // } else {

        // Dans la table user

        if ($request->imageLogo == '') {

            if ($request->sexe = 'M') {

                $request->imageLogo = 'elevedefaultgarcon.png';
            } else {

                $request->imageLogo = 'elevedefaultfille.png';
            }
        }

        // je verrifie si le champ autre a ete choisin en front



        $user = User::where('id', $request->user_id)->update([

            'nom' => $request->nomAdmin,
            'prenom' => $request->PrenomAdmin,
            'email' => $request->emailAdmin,
            // 'login' => $request->loginAdmin,
            'telephone' => $request->telAdmin,
            // 'password' => bcrypt($request->passAdmin),
            'photo' => $request->imageLogo,
            'type' => $role,

        ]);


        // Enregistrer dans la table Enseignant

        $user = caisse::where('id', $request->id)->update([
            // 'user_id' => $user->id,
            'nom' => $request->nomAdmin,
            'prenom' => $request->PrenomAdmin,
            'tel' => $request->telAdmin,
            'email' => $request->emailAdmin,
            'role' => $role,
            'salaire' => $request->salaire,
            // 'codeEtab' => $codeEtab,
            // 'session' => $sessionEncour,

        ]);
        // }
    }


    public function addcaissiere(Request $request)

    {

        if ($request->role == 'autre') {

            $role = $request->autre;
        } else {

            $role = $request->role;
        }





        //  Recuperons le code etab

        $codeEtab = $request['EcoleInfos'][0]['codeEtab'];

        // Recuperons les datas de la session en cour

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->get();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata[0]['libelle_sess'];

        // dd( $codeEtab);

        $this->validate($request, [

            'nomAdmin' => 'required',
            'PrenomAdmin' => 'required',
            'telAdmin' => 'required',
            'salaire' => 'required',
            'role' => 'required',
            'loginAdmin' => 'required',
            'passAdmin' => 'required',
            'emailAdmin' => 'required|email',

        ]);


        // Enregistrer dans la table User

        if ($request->imageLogo == '') {

            $request->imageLogo = 'elevedefault.png';
        }


        if ($request->type == '') {

            $request->type = 1; // titulaire enseigant par default

        }


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

            // Dans la table user

            if ($request->imageLogo == '') {

                if ($request->sexe = 'M') {

                    $request->imageLogo = 'elevedefaultgarcon.png';
                } else {

                    $request->imageLogo = 'elevedefaultfille.png';
                }
            }

            // je verrifie si le champ autre a ete choisin en front



            $user = User::Create([

                'nom' => $request->nomAdmin,
                'prenom' => $request->PrenomAdmin,
                'email' => $request->emailAdmin,
                'login' => $request->loginAdmin,
                'telephone' => $request->telAdmin,
                'password' => bcrypt($request->passAdmin),
                'photo' => $request->imageLogo,
                'type' => $role,


            ]);


            // Enregistrer dans la table Enseignant

            $user = caisse::Create([
                'user_id' => $user->id,
                'nom' => $request->nomAdmin,
                'prenom' => $request->PrenomAdmin,
                'tel' => $request->telAdmin,
                'email' => $request->emailAdmin,
                'role' => $role,
                'salaire' => $request->salaire,
                'codeEtab' => $codeEtab,
                'session' => $sessionEncour,
                'sexe' => $request->status

            ]);
        }
    }


    public function delateCaissiere(Request $request)

    {


        // On supprimera dans la table user et celui-ci supprimera dans la table caisse

        $teacher = caisse::where('id', $request->id)->first();


        $idUser = $teacher['user_id'];

        $this->validate($request, [

            'id' => 'required'

        ]);

        User::where('id', $idUser)->delete();
    }
}
