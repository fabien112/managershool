<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\User;
use App\Models\Session;
use App\Models\Messages;
use App\Models\Assigners;
use App\Models\Classe;
use App\Models\Enseignants;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Parents;
use App\Models\Student;
use PhpParser\Node\Expr\Assign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EtablissementController extends Controller
{


    public function getstatsEtab(Request $request)
    {





        // Compter les élèves dont le statut est différent de 3
        $nbreEleves = Student::where('statut', '!=', 3)->count();

        // Compter les élèves dont le statut est égal à 2
        $nbreElevesEngles = Student::where('statut', 2)->count();

        // Compter le nombre de parents
        $nbreParents = Parents::count();

        // Compter le nombre d'enseignants
        $nbreEnseignants = Enseignants::count();

        // Compter le nombre de classes
        $nbrsClasses = Classe::count();


        $stats = [
            'totalEleves' => $nbreEleves,
            'totalParents' => $nbreParents,
            'totalEnseignants' => $nbreEnseignants,
            'totalClasse' => $nbrsClasses,
            'totalElevesRegle' => $nbreElevesEngles
        ];

        return response()->json($stats);
    }


    public function getEtabinfos(Request  $request)
    {


        // Recuperons l'id de l'etablissment

        $user = User::with('Etablissements')->where('id', $request->id)->get();

        $id = $user[0]['Etablissements'][0]['id'];

        $infos = Etablissement::with('users')->where('id', $id)->get();

        return response()->json($infos);
    }

    public function create(Request $request)
    {


        $data = Pays::All();
        //var_dump($pays);
        return response()->json($data);
    }

    public function addAdmin(Request $request)
    {


        $this->validate($request, [

            'nomAdmin' => 'required',
            'PrenomAdmin' => 'required',
            'telAdmin' => 'required',
            'fonctionAdmin' => 'required',
            'emailAdmin' => 'required|email',
            'loginAdmin' => 'required',
            'passAdmin' => 'required',
            'CpassAdmin' => 'required',

        ]);


        // Recuperer l 'id de la derniere ecole cree




        if ($request->imageLogo == null) {

            $request->imageLogo = "profildefaut.png";
        }

        $data = User::Create([

            'nom' => $request->nomAdmin,
            'prenom' => $request->PrenomAdmin,
            'datenais' => $request->dateNaiss,
            'email' => $request->emailAdmin,
            'fonction' => $request->fonctionAdmin,
            'login' => $request->loginAdmin,
            'telephone' => $request->telAdmin,
            'password' => $request->passAdmin,
            'type' => $request->type,
            'photo' => $request->imageLogo

        ]);

        return response()->json($data);
    }



    public function upload(Request $request)
    {



        $this->validate($request, [

            'file' => 'required|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx'

        ]);

        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('Photos/Logos'), $fileName);

        return $fileName;
    }





    public function upload2(Request $request)


    {



        header('Access-Control-Allow-Origin: *');

        //Storage::disk('local')->put('avatars', $request->image);

        dd($request);

        // $this->validate($request, [

        //     'file' => 'required|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx'

        // ]);

        // $fileName = time() . '.' . $request->file->extension();

        // $request->file->move(public_path('Photos/Logos'), $fileName);

        // return $fileName;
    }

    public function addEtablissement(Request $request)

    {




        $this->validate($request, [

            'codeEtablissement' => 'required',
            'libelleEtablissement' => 'required',
            'sigleEtablissement' => 'required',
            'sloganEtablissement' => 'required',
            'codeEtablissement' => 'required',
            'libelleEtablissement' => 'required',
            'emailEtablissement' => 'required',
            'dateCreation' => 'required',
            'telephoneEtablissement' => 'required',
            'telephoneEtablissementSecond' => 'required',
            'paysEtablissement' => 'required',
            'villeEtablissement' => 'required',
            'directeurEtablissement' => 'required',
            'telephoneDirecteurEtablissement' => 'required',
            'addressEtablissement' => 'required',
            'nomAdmin' => 'required',
            'PrenomAdmin' => 'required',
            'telAdmin' => 'required',
            'fonctionAdmin' => 'required',
            'emailAdmin' => 'required',
            'loginAdmin' => 'required',
            'passAdmin' => 'required',
            'CpassAdmin' => 'required',

        ]);

        if ($request->groupe == "Oui") {

            $request->groupe = 1;
        } else if ($request->groupe == "Non") {

            $request->groupe = 0;

            $request->groupeName = '';
        }


        if ($request->siteInternetEtablissement == null) {

            $request->siteInternetEtablissement = "";
        }

        if ($request->imageLogo == null) {

            $request->imageLogo = "logodefaut.png";
        }

        // @insertion dans la table Etablissement

        $data = Etablissement::Create([
            'groupnameEtab' => $request->groupeName,
            'groupstateEtab' => $request->groupe,
            'mixteEtab' => $request->mixte,
            'codeEtab' => $request->codeEtablissement,
            'libelleEtab' => $request->libelleEtablissement,
            'sigleEtab' => $request->sigleEtablissement,
            'sloganEtab' => $request->sloganEtablissement,
            'emailEtab' => $request->emailEtablissement,
            'datecreationEtab' => $request->dateCreation,
            'principaltelEtab' => $request->telephoneEtablissement,
            'secondairetelEtab' => $request->telephoneEtablissementSecond,
            'paysEtab' => $request->paysEtablissement,
            'villeEtab' => $request->villeEtablissement,
            'sitewebEtab' => $request->siteInternetEtablissement,
            'directeurEtab' => $request->directeurEtablissement,
            'principalteldirecteurEtab' => $request->telephoneDirecteurEtablissement,
            'adresseEtab' => $request->addressEtablissement,
            'logoEtab' => $request->imageLogo

        ]);





        // insertion dans la table utulisateur (compte)

        $user = User::Create([

            'nom' => $request->nomAdmin,
            'prenom' => $request->PrenomAdmin,
            'datenais' => $request->dateNaiss,
            'email' => $request->emailAdmin,
            'fonction' => $request->fonctionAdmin,
            'login' => $request->loginAdmin,
            'telephone' => $request->telAdmin,
            'password' => bcrypt($request->passAdmin),
            'type' => $request->type,

        ]);

        // insertion dans la table Assigner


        $assigner = Assigners::Create([

            'user_id' => $user->id,
            'etablissement_id' => $data->id

        ]);
    }

    //  Recuperation des ecoles

    public function getAllEtablissement()
    {


        $datas = Etablissement::orderBy('id', 'desc')->get();

        return response()->json($datas);
    }

    public function delateEtablissement(Request $request)
    {

        //dd($request->id);

        return Etablissement::where('id', $request->id)->delete();
    }

    //  Editer une ecole

    public function updateEtablissement(Request $request)
    {

        //dd($request);


        $this->validate($request, [

            'id' => 'required'

        ]);

        if ($request->sitewebEtab == null) {

            $request->sitewebEtab = "";
        }

        if ($request->logoEtab == null) {

            $request->logoEtab = "logodefaut.png";
        }

        return Etablissement::where('id', $request->id)->update([

            //'groupnameEtab' => $request->groupnameEtab,
            //'groupstateEtab' => $request->groupstateEtab,
            //'mixteEtab' => $request->mixteEtab,
            'codeEtab' => $request->codeEtab,
            'libelleEtab' => $request->libelleEtab,
            'sigleEtab' => $request->sigleEtab,
            'sloganEtab' => $request->sloganEtab,
            'emailEtab' => $request->emailEtab,
            'datecreationEtab' => $request->datecreationEtab,
            'principaltelEtab' => $request->principaltelEtab,
            'secondairetelEtab' => $request->secondairetelEtab,
            'paysEtab' => $request->paysEtab,
            'villeEtab' => $request->villeEtab,
            'sitewebEtab' => $request->sitewebEtab,
            'directeurEtab' => $request->directeurEtab,
            'principalteldirecteurEtab' => $request->principalteldirecteurEtab,
            'adresseEtab' => $request->adresseEtab,
            //'logoEtab' => $request->logoEtab
        ]);
    }


    public function delateImage(Request $request)

    {

        $fileName = $request->imageProfil;
        $this->delateFileFromServer($fileName);
        return 'done';
    }

    public function delateFileFromServer($fileName)
    {

        $filePatch = public_path() . '/Photos/admins' . $fileName;

        if (file_exists($filePatch)) {

            unlink($filePatch);
        }

        return;
    }


    public function destroy($id)
    {
        //
    }
}
