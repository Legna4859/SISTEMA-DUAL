<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Carreras;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                $carreras = DB::table('gnral_carreras')
                ->orderBy('id_carrera', 'asc')
                ->get();
        return view('generales.carreras',compact('carreras'));

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
                        $this->validate($request,[
                'nombre_carrera' => 'required',
                'color' => 'required',
                ]);

                $carreras2 = array(
                    'nombre' => mb_strtoupper($request->get('nombre_carrera'),'utf-8'),
                    'COLOR' => mb_strtoupper($request->get('color'),'utf-8')
                    );

                $agrega_carrera=Carreras::create($carreras2);
                return redirect('/generales/carreras');
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
    public function edit($id_carrera)
    {
       $carreras = DB::table('gnral_carreras')
                ->orderBy('id_carrera', 'asc')
                ->get();
        $carrera_edit = Carreras::find($id_carrera);

        return view('generales.carreras',compact('carreras'))->with(['edit' => true, 'carrera_edit' => $carrera_edit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_carrera)
    {
        $this->validate($request,[
                'nombre_carrera' => 'required',
                'color' => 'required',
                ]);

                $carreras = array(
                    'nombre' => mb_strtoupper($request->get('nombre_carrera'),'utf-8'),
                    'COLOR' => mb_strtoupper($request->get('color'),'utf-8')
                    );      
        Carreras::find($id_carrera)->update($carreras);
        return redirect('/generales/carreras'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_carrera)
    {
        Carreras::destroy($id_carrera);
        return redirect('/generales/carreras');
    }
}
