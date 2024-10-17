<?php

namespace App\Http\Controllers;

use App\Models\Typedeclasse;
use Illuminate\Http\Request;

class TypedeclasseController extends Controller
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
        $data= Typedeclasse::create([
            'libelleType'=>$request->libelleType,
            'codeEtabType'=>$request->codeEtabType,
            'EtabType'=>$request->EtabType,
            'statutType'=> $status,
            'datecreaType'=>$date,
            'createbyType'=>$request->createbyNiveau,
            ]);

            $msg=' classe crée avec success';
             return response()->json($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Typedeclasse  $typedeclasse
     * @return \Illuminate\Http\Response
     */
    public function show(Typedeclasse $typedeclasse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Typedeclasse  $typedeclasse
     * @return \Illuminate\Http\Response
     */
    public function edit(Typedeclasse $typedeclasse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Typedeclasse  $typedeclasse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Typedeclasse $typedeclasse)
    {
        $request->validate([
            'libelleNiveau' => 'required|string',
            'codeEtabNiveau' => 'required|string'
        ]);

        $status="1";
        $date=date("d/m/dY");
        $data= Typedeclasse::update([
            'libelleType'=>$request->libelleType,
            'codeEtabType'=>$request->codeEtabType,
            'EtabType'=>$request->EtabType,
            'statutType'=> $status,
            'datecreaType'=>$date,
            'createbyType'=>$request->createbyNiveau,
            ]);

            $msg=' classe crée avec success';
             return response()->json($msg);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Typedeclasse  $typedeclasse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Typedeclasse $typedeclasse)
    {
        //
    }
}
