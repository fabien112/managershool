<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;

use Patrickmaken\AvlyText\Client as AVTClient;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function sendTw(Request $request)
    // {


    //     $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));

    //     // $to = $request->get('to');
    //     $message = "$request->nom" . "$request->prenom" . "\n" . "$request->libelleClasse" . "\n" . " MOYENNE TRIMESTRE 1 : " . "$request->valeur " . "\n" . " ABSENCE : $request->duree";

    //     //237656496172;

    //     $client->messages->create("+237693333162", [
    //         'from' => env('TWILIO_NUMBER'),
    //         'body' => $message,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'status' => 500
    //     ]);
    // }


    public function sendCmr(Request $request)

    {



        $api_key = '1f77JiTawAfDqkdNNmJ9u8z4GZKZ5D5Hp3vMbbRV8GcZShwqvNFBgQeBOZvxeWdO3Ck7';

        // $telephone = '+237697396871';

        // $telephone = '+237693333162';



        $telephone = '+237' . "$request->telParent";

        // $text = "$request->nom" . "$request->prenom" . "\n" . "$request->libelleClasse" . "\n" . " MOYENNE TRIMESTRE 1 : " . "$request->valeur " . "\n" . " ABSENCE : $request->duree" . " " . " h";

        $text = "07/02/2024 : Entrainement au défilé , Investissement humain "
            . "\n" . "08/02/2024 : Prédéfilé a la place des d’Ebone"
            . "\n" . "09/02/2024 : Soirée de l’excellence au Lycée bilingue d’Ebone"
            . "\n" . "11/02/2024 : Défilé a la place des fêtes d’Ebone ";


        $senderID = 'LY_TECH_MAN';

        $response = AVTClient::sendSMS($telephone, $text, $senderID, $api_key);

        return $response;
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
