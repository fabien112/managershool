<?php

namespace App\Http\Controllers;

use App\Models\ClasseEnseignants;
use App\Models\Session;
use App\Models\messages;
use App\Models\Enseignants;
use Illuminate\Http\Request;
use App\Models\destinataires;
use App\Models\Parents;
use App\Models\Student;

class MessageController extends Controller


{


    public function getMessageSendByParents(Request $request)
    {


        $codeEtab = $request[0]['codeEtab'];

        $idEtab = $request[0]['id'];

        $session = Session::where('etablissement_id', $idEtab)->first();

        $sessionEncour = $session['libelle_sess'];

        $idUser = $request[0]['users'][0]['id'];

        $Messages = destinataires::with('messages', 'user')
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)
            ->where('type_destinataire', 'Administration')
            ->where('user_id', '!=', $idUser)
            ->orderBy('id', 'desc')->get();

        return response()->json($Messages);
    }

    public function getMessagesTeacher(Request $request)
    {

        $idUser = $request->id;

        $sata = Enseignants::where('user_id', $idUser)->first();


        $idTeacher = $sata->id;

        $codeEtab =  $sata->codeEtab;

        $sessionEncour = $sata->session;

        $Messages = destinataires::with('messages', 'user')->where('liste_destinataire', 3000)
            ->where('codeEtab', $codeEtab)
            ->where('type_destinataire', 'Enseignants')
            ->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return response()->json($Messages);
    }

    public function updateMessagesParent(Request $request)
    {


        $this->validate($request, [

            'id' => 'required'

        ]);

        messages::where('id', $request->messages['id'])->update([

            'statut' => 1,
        ]);
    }

    public function getMessagesParent(Request $request)
    {

        $idUser = $request->id;

        $sata = Parents::where('user_id', $idUser)->first();

        $idParent = $sata->id;

        $codeEtab =  $sata->codeEtab;

        $sessionEncour = $sata->session;

        // Recuperons l'enfant de ce parent

        $child = Student::where('parent_id', $idParent)->first();

        // Recuperons l'id de la classe de cet enfant

        $idClasseChild = $child->classe_id;

        $Messages = destinataires::with('messages', 'user')->where('liste_destinataire', 0)
            ->orWhere('liste_destinataire', $idParent)
            ->where('type_destinataire', "Parents")
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return response()->json($Messages);
    }



    public function getMessageEnvoyesParent(Request $request)
    {



        $idUser = $request->id;

        $sata = Parents::where('user_id', $idUser)->first();

        $idParent = $sata->id;

        $codeEtab =  $sata->codeEtab;

        $sessionEncour = $sata->session;

        $Messages = destinataires::with('messages', 'user')
            ->where('user_id', $idUser)
            ->where('type_destinataire', "Administration")
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return response()->json($Messages);
    }

    public function sendMessageByParent(Request $request)

    {



        $datasUser = $request->senderData;

        $idSender = $datasUser['id'];

        $Parent = Parents::where('user_id', $idSender)->first();


        $codeEtab = $Parent['codeEtab'];


        $sessionEncour = $Parent['session'];

        $this->validate($request, [

            // 'destinataire' => 'required',
            'message' => 'required',
            'objet' => 'required',
            'tous' => 'required'
        ]);


        $data = messages::create([
            'document' => $request->imageEmploiTmp,
            'object' => $request->objet,
            'commentaires' => $request->message,
            'precis' => 0,
            'statut' => 0,
            'type' => 0,
            'date' => date('Y-m-d H:i:s'),


        ]);

        destinataires::create([

            'user_id' => $idSender,
            'messages_id' => $data->id,
            'session' => $sessionEncour,
            'codeEtab' => $codeEtab,
            'type_destinataire' => "Administration",

        ]);
    }


    public function sendMessage(Request $request)
    {


        $idSender = $request['EtabInfos'][0]['users'][0]['id'];

        $codeEtab = $request['EtabInfos'][0]['codeEtab'];

        $sessiondata = Session::where('codeEtab_sess', $codeEtab)

            ->where('encours_sess', 1)->orderBy('id', 'desc')->first();

        // Recuperons le libelle  de la session en cour

        $sessionEncour = $sessiondata['libelle_sess'];

        $this->validate($request, [

            'destinataire' => 'required',
            'message' => 'required',
            'objet' => 'required',
            'tous' => 'required'
        ]);

        // Si le message est destinee aux parents




        // si le message est pour tous les parents

        if ($request->destinataire == "Parents" && $request->tous == 'NON') {

            $data = messages::create([

                // type = 0 ou 1  pour les messages envoyes/recu

                // statut = 0 ou 1 pour les messages lu/non lu

                // precis = 0 pour les messages de tous les parents et 1 pour ceux d'une classe

                'document' => $request->imageEmploiTmp,
                'object' => $request->objet,
                'commentaires' => $request->message,
                'precis' => 0,
                'statut' => 0,
                'type' => 0,
                'date' => date('Y-m-d H:i:s'),


            ]);

            destinataires::create([

                'user_id' => $idSender,
                'messages_id' => $data->id,
                'liste_destinataire' => 0,
                'session' => $sessionEncour,
                'codeEtab' => $codeEtab,
                'type_destinataire' => $request->destinataire,

            ]);
        }

        // si le message est pour les parents d'une classe en particulier

        if ($request->destinataire == "Parents" &&  $request->tous == 'OUI') {

            $idClasse = $request->classe;


            /*
                Recuperons tous les id des parents de cette classe.
                pour le faire recuperons d'abord les id des eleves de cette classes car le parent et la
                classe ne sont pas liee
            */

            $data = messages::create([

                /*
                type = 0 ou 1  pour les messages envoyes/recu
                statut = 0 ou 1 pour les messages lu/non lu
                 precis = 0 pour les messages de tous les parents et 1 pour ceux d'une classe specifique
                */

                'classe_id' => $request->classe,
                'document' => $request->imageEmploiTmp,
                'object' => $request->objet,
                'commentaires' => $request->message,
                'precis' => 1,
                'statut' => 0,
                'type' => 0,
                'date' => date('Y-m-d H:i:s'),


            ]);


            $students = Student::distinct()->where('classe_id', $idClasse)->get('parent_id');


            foreach ($students as $value) {

                $idParent = $value->parent_id;


                destinataires::create([

                    'messages_id' => $data->id,
                    'liste_destinataire' => $idParent,
                    'user_id' => $idSender,
                    'session' => $sessionEncour,
                    'codeEtab' => $codeEtab,
                    'type_destinataire' => $request->destinataire,

                ]);
            }
        }



        // MESSAGE ENSEIGNANTS


        //  si le message est pour tous les enseignants

        if ($request->destinataire == "Enseignants" && $request->tous == 'NON') {


            $data = messages::create([

                // type = 0 ou 1  pour les messages envoyes/recu

                // statut = 0 ou 1 pour les messages lu/non lu

                // precis = 0 pour les messages de tous les parents et 1 pour ceux d'une classe


                'document' => $request->imageEmploiTmp,
                'object' => $request->objet,
                'commentaires' => $request->message,
                'precis' => 0,
                'statut' => 0,
                'type' => 0,
                'date' => date('Y-m-d H:i:s')

            ]);

            destinataires::create([

                'user_id' => $idSender,
                'messages_id' => $data->id,
                'liste_destinataire' => 3000, // ceci est un message pour tous les enseignants de l'ecole
                'session' => $sessionEncour,
                'codeEtab' => $codeEtab,
                'type_destinataire' => $request->destinataire,

            ]);
        }

        //     // si le message est pour les enseignants  d'une classe en particulier


        // if($request->destinataire == "Enseignants" && $request->tous=='NON') {

        //     // dd($request);

        //     //     $idClasse = $request->classe;

        //     //     $data = Messages::create([

        //     //         // type = 0 ou 1  pour les messages envoyes/recu

        //     //         // statut = 0 ou 1 pour les messages lu/non lu

        //     //         // precis = 0 pour les messages de tous les parents et 1 pour ceux d'une classe specifique

        //     //     'classe_id'=>$idClasse,
        //     //     'user_id' => $idSender,
        //     //     'object'=>$request->objet,
        //     //     'document'=>$request->imageEmploiTmp,
        //     //     'commentaires'=>$request->message,
        //     //     // 'destinataires'=>$request->destinataire,
        //     //     'precis'=>1,
        //     //     'statut'=>0,
        //     //     'type'=>0,
        //     //     'date'=>date('Y-m-d H:i:s'),
        //     //     // 'session'=>$sessionEncour,
        //     //     // 'codeEtab'=>$codeEtab

        //     // ]);

        //     // // Recuperons les id de tous les enseignants de la classe choisie

        //     // $teachers = ClasseEnseignants::distinct()->where('classe_id','=',$idClasse)->get('enseignants_id');



        //     //             foreach($teachers as $value){

        //     //                 $idProf = $value->enseignants_id;

        //     //             destinataires::create([

        //     //                 'messages_id'=>$data->id,
        //     //                 'liste_destinataire'=> $idProf,
        //     //                 'user_id' =>$idSender,
        //     //                 'session'=>$sessionEncour,
        //     //                 'codeEtab'=>$codeEtab,
        //     //                 'type_destinataire'=>$request->destinataire,

        //     //             ]);


        //     //            }


        //     // }
        // }
    }



    // cette fonction recupere tous les messages envoyes par un utulisateurs (boite d'envoie avec user_id)

    public function getMessageEnvoyes(Request $request)
    {


        $idSender = $request['EtabInfos'][0]['users'][0]['id'];
        $codeEtab = $request['EtabInfos'][0]['codeEtab'];
        $sessiondata = Session::where('codeEtab_sess', $codeEtab)->where('encours_sess', 1)->orderBy('id', 'desc')->first();
        // Recuperons le libelle  de la session en cour
        $sessionEncour = $sessiondata['libelle_sess'];

        $Messages = destinataires::with('messages')->where('user_id', $idSender)->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->orderBy('id', 'desc')->get();

        return response()->json($Messages);
    }
}
