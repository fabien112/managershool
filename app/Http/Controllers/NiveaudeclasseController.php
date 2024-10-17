<?php

namespace App\Http\Controllers;

use App\Models\Niveaudeclasse;
use Illuminate\Http\Request;

class NiveaudeclasseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'libelleNiveau' => 'required|string',
            'codeEtabNiveau' => 'required|string'
        ]);

        $status="1";
        $date=date("d/m/dY");
        $data= Niveaudeclasse::create([
            'libelleNiveau'=>$request->libelleNiveau,
            'codeEtabNiveau'=>$request->codeEtabNiveau,
            'statutNiveau'=> $status,
            'datecreaNiveau'=>$date,
            'createbyNiveau'=>$request->createbyNiveau,
            ]);

            $msg=' classe crée avec success';
             return response()->json($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Niveaudeclasse  $niveaudeclasse
     * @return \Illuminate\Http\Response
     */
    public function show(Niveaudeclasse $niveaudeclasse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Niveaudeclasse  $niveaudeclasse
     * @return \Illuminate\Http\Response
     */
    public function edit(Niveaudeclasse $niveaudeclasse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Niveaudeclasse  $niveaudeclasse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Niveaudeclasse $niveaudeclasse)
    {
        $request->validate([
            'libelleNiveau' => 'required|string',
            'codeEtabNiveau' => 'required|string'
        ]);

        $status="1";
        $date=date("d/m/dY");
        $data= Niveaudeclasse::update([
            'libelleNiveau'=>$request->libelleNiveau,
            'codeEtabNiveau'=>$request->codeEtabNiveau,
            'statutNiveau'=> $status,
            'datecreaNiveau'=>$date,
            'createbyNiveau'=>$request->createbyNiveau,
            ]);

            $msg=' classe crée avec success';
             return response()->json($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Niveaudeclasse  $niveaudeclasse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Niveaudeclasse $niveaudeclasse)
    {
        //
    }
}
