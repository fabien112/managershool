<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Session;
use App\Models\Affecter;
use App\Models\cathegory;
use App\Models\cats;
use App\Models\ClasseEnseignants;
use App\Models\config;
use App\Models\Matieres;
use App\Models\Enseignants;
use Illuminate\Http\Request;
use App\Models\libelleMatieres;
use App\Models\EnseignantsMatiere;
use App\Models\EnseignantsMatieres;
use App\Models\Heure;
use App\Models\Matiere;
use App\Models\tabletimes;
use App\Models\timetablesV;

class MatiereController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function delatimetable(Request $request)
    {

        $this->validate($request, [

            'id' => 'required'

        ]);

        tabletimes::where('id', $request->id)->delete();
    }

    public function getTimestabs(Request $request)
    {


        for ($i = 1; $i < 8; $i++) {

            $Datas[$i] = tabletimes::with('enseignant')->with('classe')->where('classe_id', $request['classeId']['id'])->where('id_jour', $i)->orderBy('id_heureD', 'ASC')->orderBy('id_heureF', 'ASC')->get();
        }





        return  response()->json($Datas);
    }

    public function createEmpldoiTempsDashvrai(Request $request)


    {


        $cours = $request->inputs2;



        $IDjour = $request->jour;

        $IdClasse = $request->idClasse;



        tabletimes::where('classe_id', $IdClasse)->where('id_jour', $IDjour)->delete();



        foreach ($cours as $key => $cour) {


            if ($cour['matiere']['libelle'] == "") {

                $cour['matiere']['enseignants_id'] = NULL;

                $cour['matiere']['libelle'] = 'PAUSE';
            }




            tabletimes::Create([

                'id_jour' => $IDjour,
                'id_heureD' => $cour['heureD']['heure_D'],
                'id_heureF' =>  $cour['heureD']['heure_F'],
                'matiere' =>  $cour['matiere']['libelle'],
                'enseignant_id' =>  $cour['matiere']['enseignants_id'],
                'classe_id' => $IdClasse

            ]);
        }
    }


    public function createEmpldoiTempsDash(Request $request)


    {




        // ici on cree les heures


        $cours = $request->inputs2;

        foreach ($cours as $key => $cour) {


            Heure::Create([

                'libelle' => "Horaire " . ($key + 1),
                'heure_D' => $cour['heureD'],
                'heure_F' =>  $cour['heureF']

            ]);
        }
    }




    public function getHeures(Request $request)
    {

        $Datas = Heure::get();

        return  response()->json($Datas);
    }

    public function updatelibelle(Request $request)
    {

        $this->validate($request, [

            'id' => 'required',

        ]);

        // mettre a jour dans la table matiere


        Matieres::where('libelle', $request->libelleAncien)->update([

            'libelle' => $request->libelle,
        ]);


        // mettre a jour dans la table libellematiere

        libelleMatieres::where('id',  $request->id)->update([
            'libelle' => $request->libelle,

        ]);
    }

    public function updateMatiere(Request $request)

    {




        $this->validate($request, [

            'id' => 'required',
            'coef' => 'required|numeric|min:1',
            'categorie' => 'required'

        ]);

        Matieres::where('id',  $request->id)->update([
            'libelle' => $request->libelle,
            'cathegory_id' => $request->categorie,
            'coef' => $request->coef

        ]);
    }

    public function delateMatiere(Request $request)

    {




        $this->validate($request, [

            'id' => 'required'

        ]);

        Matieres::where('id', $request->id)->delete();
    }

    public function delateLibelle(Request $request)

    {




        $this->validate($request, [

            'id' => 'required'

        ]);

        libelleMatieres::where('id', $request->id)->delete();
    }

    public function Addconfig(Request $request)
    {


        $request->validate([
            'moymin' => 'required|numeric|min:0|max:19',
            'moyth' => 'required|numeric|min:0|max:19',
            'abs' => 'required|numeric|min:0'

        ]);

        $Data = config::create([

            'header' => $request->imageEmploiTmp,
            'abscenceMax' => $request->abs,
            'MoyenneMin' => $request->moymin,
            'MoyenneTH' => $request->moyth,
            'codeEtab' => $request->EcoleInfos[0]['codeEtab']
        ]);
    }
    public function getLibelles(Request $request)

    {


        //  Recuperons le code etab

        $codeEtab = $request['ClasseInfos']['codeEtabClasse'];


        // Recuperons le libelle  de la session en cour

        $sessioEncour = $request['ClasseInfos']['sessionClasse'];

        $count = count(libelleMatieres::where('session', $sessioEncour)->where('codeEtab', $codeEtab)->orderBy('id', 'DESC')->get());


        // $content = libelleMatieres::where('session', $sessioEncour)->where('codeEtab', $codeEtab)->orderBy('libelle', 'ASC')->skip($request->currentPage * 10)->take(9)->get();

        $content = libelleMatieres::where('session', $sessioEncour)->where('codeEtab', $codeEtab)->orderBy('libelle', 'ASC')->get();

        $Datas['totalPages'] = $count;
        $Datas['content'] = $content;
        return  response()->json($Datas);
    }

    public function getcat(Request $request)

    {



        $Datas = cats::get();

        return  response()->json($Datas);
    }

    public function getClasses(Request $request)

    {

        // Recuperer le code etab et la session en cour

        $codeEtab = $request['ClasseInfos']['codeEtabClasse'];

        // Recuperons la session en cour


        $sessioEncour = $request['ClasseInfos']['sessionClasse'];


        $Datas = Classe::where('sessionClasse', $sessioEncour)->where('codeEtabClasse', $codeEtab)->get();

        return  response()->json($Datas);
    }

    public function addLibelle(Request $request)

    {

        //  Recuperons le code etab

        $codeEtab = $request['ClasseInfos']['codeEtabClasse'];


        // Recuperons le libelle  de la session en cour

        $sessioEncour = $request['ClasseInfos']['sessionClasse'];

        // Enregistrer le libelle

        $request->validate([
            'libelle' => 'required|string'
        ]);


        if (libelleMatieres::where('libelle', $request->libelle)->where('codeEtab', $codeEtab)
            ->where('session', $sessioEncour)->exists()
        ) {

            return response()->json([
                'msg' => 'Existe deja',

            ], 400);
        } else {

            $Data = libelleMatieres::create([

                'libelle' => $request->libelle,
                'codeEtab' => $codeEtab,
                'session' => $sessioEncour
            ]);
        }
    }


    public function addMatiere(Request $request)

    {

        //  dd($request->categorie);

        //  Recuperons le code etab




        $codeEtab = $request['ClasseInfos']['codeEtabClasse'];

        // Recuperer l'identifiant  de la classe dans laquelle la matiere est ajoute

        $idClasse = $request['ClasseInfos']['id'];

        // Recuperons le libelle  de la session en cour

        $sessioEncour = $request['ClasseInfos']['sessionClasse'];

        // dd($request->matiere);

        // Enregistrer la matiere

        $request->validate([
            'matiere' => 'required|string',
            'coef' => 'required|string',
        ]);



        if (Matieres::where('libelle', $request->matiere)->where('classe_id', $idClasse)->where('codeEtab', $codeEtab)
            ->where('session', $sessioEncour)->exists()
        ) {

            return response()->json([
                'msg' => 'Existe deja',

            ], 400);
        } else {

            $Data = Matieres::create([

                'libelle' => $request->matiere,
                'codeEtab' => $codeEtab,
                'session' => $sessioEncour,
                'classe_id' => $idClasse,
                'coef' => $request->coef,
                'cathegory_id' => $request->categorie

            ]);
        }




        return response()->json($Data);
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


    public function createHoraires(Request $request)


    {



        $heures = $request->inputs2;


        foreach ($heures as $valide) {



            // Ensuite on verifie chaque note pour s'assurer quelle est bonne


            if ($valide['heureD'] == '' ||  $valide['heureD']  == null) {

                return response()->json([
                    'msg' => 'Toutes les heures ne sont pas saisies',

                ], 402);
            }

            $syllabus = Heure::Create([

                'libelle' => $valide['heureD'],


            ]);
        }
    }


    public function getMatieresClasse2(Request $request)

    {

        // Recuperons les matieres de cette classe en particulier

        $Datas = Matieres::where('classe_id', $request->idClasse)->orderBy('id', 'DESC')->get();

        foreach ($Datas as $data) {

            if ($data->enseignants_id == null) {
                $data['enseignant'] = 'Disponible';
            } else {

                $data['enseignant'] = Enseignants::where('id', $data->enseignants_id)->first();
            }
        }


        return  response()->json($Datas);
    }
    public function getMatieresClasse(Request $request)

    {

        //  Recuperons le code etab

        $codeEtab = $request['ClasseInfos']['codeEtabClasse'];

        // Recuperer l'identifiant  de la classe dans laquelle la matiere est ajoute

        $idClasse = $request['ClasseInfos']['id'];


        // Recuperons le libelle  de la session en cour

        $sessioEncour = $request['ClasseInfos']['sessionClasse'];


        // Recuperons les matieres de cette classe en particulier

        $Datas = Matieres::where('session', $sessioEncour)->where('codeEtab', $codeEtab)->where('classe_id', $idClasse)->orderBy('id', 'ASC')->get();

        foreach ($Datas as $data) {

            if ($data->enseignants_id == null) {
                $data['enseignant'] = 'Disponible';
            } else {

                $data['enseignant'] = Enseignants::where('id', $data->enseignants_id)->first();
            }
        }


        return  response()->json($Datas);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */

    public function affecterTeacher2(Request  $request)

    {
        // Je recupere l'id de l'enseigant car c'est l'id qui arrive dans la value



        $idTeacher = $request->Enseignants;

        $request->validate([
            'id' => 'required',

        ]);


        // ici je mets l'id de l'enseigant dans la table matiere

        // Je mets a jour affect dans la table matiere de 0 a 1

        $idMatiere = Matieres::where('id', $request->id)->update([

            'affected' => '1',
            'enseignants_id' => $request->Enseignants
        ]);



        //Ensuite  je rempli la table enseignant-matiere , table qui lie la classe et l'enseignant

        // Allons recuperer l'id de la classe  danslaquelle cette matiere existe

        $Classe = Matieres::Find($request->id);

        $idClasse = $Classe['classe_id'];

        $Data = ClasseEnseignants::where('classe_id', $idClasse)->update([
            'classe_id' => $idClasse,
            'enseignants_id' => $request->Enseignants,
        ]);
    }
    public function affecterTeacher(Request  $request)

    {
        // Je recupere l'id de l'enseigant car c'est l'id qui arrive dans la value


        $idTeacher = $request->Enseignants;

        $request->validate([
            'id' => 'required',

        ]);


        // ici je mets l'id de l'enseigant dans la table matiere

        // Je mets a jour affect dans la table matiere de 0 a 1

        $idMatiere = Matieres::where('id', $request->id)->update([

            'affected' => '1',
            'enseignants_id' => $request->Enseignants
        ]);



        //Ensuite  je rempli la table enseignant-matiere , table qui lie la classe et l'enseignant

        // Allons recuperer l'id de la classe  danslaquelle cette matiere existe

        $Classe = Matieres::Find($request->id);

        $idClasse = $Classe['classe_id'];

        $Data = ClasseEnseignants::create([
            'classe_id' => $idClasse,
            'enseignants_id' => $request->Enseignants,
            'codeEtab' => $request->codeEtab,
            'session' => $request->session,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit(Matieres $matiere)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matieres $matiere)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matieres $matiere)
    {
        //
    }
}
