<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\ClasseImport;

use App\Imports\ElevesImport;

use App\Imports\ParentsImport;

use App\Imports\EnseignantsImport;
use App\Imports\MatiereImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadteacher(Request $request)


    {


        $this->validate($request, [

            'file' => 'required|mimes:xls,xlsx'

        ]);


        $file =  $request->file;

        $data = Excel::import(new EnseignantsImport, $file);

        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('Photos/Logos'), $fileName);

        return $fileName;
    }
    public function uploadparent(Request $request)


    {


        $this->validate($request, [

            'file' => 'required|mimes:xls,xlsx'

        ]);


        $file =  $request->file;

        $data = Excel::import(new ParentsImport, $file);

        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('Photos/Logos'), $fileName);

        return $fileName;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    //  public function loadEleveExcel(Request $request) {

    //     $data = Excel::import(new ElevesImport($request->idClasse), $request->imageEmploiTmp);

    //  }

    public function uploadclasse(Request $request)

    {
        $this->validate($request, [

            'file' => 'required|mimes:xls,xlsx'

        ]);


        $file =  $request->file;

        $data = Excel::import(new ClasseImport, $file);

        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('Photos/Logos'), $fileName);

        return $file;
    }

    public function uploadstudent(Request $request)

    {







        $this->validate($request, [

            'file' => 'required|mimes:xls,xlsx'

        ]);


        $file =  $request->file;

        $import = new ElevesImport($request->currentPage);

        Excel::import($import, $file);

        //  $data = Excel::import(new ElevesImport, $file);

        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('Photos/Logos2'), $fileName);

        return $file;
    }


    public function uploadsmatieres(Request $request)

    {
        $this->validate($request, [

            'file' => 'required|mimes:xls,xlsx'

        ]);



        $file =  $request->file;

        $data = Excel::import(new MatiereImport, $file);

        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('Photos/Logos'), $fileName);

        return $file;
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
