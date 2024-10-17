<?php

namespace App\Http\Controllers;

use App\Models\notif;
use App\Models\Parents;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{


    public function listeNotifications(Request $request)

    {


        $notificationsListe = [];



        $Idparent =  Parents::where('user_id', $request->id)->first('id');

        $liste  = notif::where('parent_id', $Idparent->id)->where('statut', 0)->count();

        if ($liste > 0) {

            $notificationsListe  = notif::where('parent_id', $Idparent->id)->where('statut', 0)->get();
        }

        return   $notificationsListe;

    }



    public function updateNotifications(Request $request)

    {



        // $Idparent =  Parents::where('user_id', $request->id)->first('id');

        //  $liste  = notif::where('parent_id', $Idparent->id)->where('statut',0)->count();

        $this->validate($request, [

            'id' => 'required'

        ]);

        notif::where('id', $request->id)->update([

            'statut' => 1,
        ]);
    }
}
