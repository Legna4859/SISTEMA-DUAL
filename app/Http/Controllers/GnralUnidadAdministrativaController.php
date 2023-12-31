<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\gnral_unidad_administrativa;
class GnralUnidadAdministrativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
         $unidades = DB::table('gnral_unidad_administrativa')
            ->orderBy('id_unidad_admin', 'asc')
            ->get();
        return view('generales.unidad_administrativa',compact('unidades'));
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
        $this->validate($request,[
            'nombre' => 'required',
            'clave' => 'required',
            'codigo' => 'required',

        ]);

        $unidad = array(
            'nom_departamento' => mb_strtoupper($request->get('nombre'),'utf-8'),
            'clave' => mb_strtoupper($request->get('clave'),'utf-8'),
            'cod' => mb_strtoupper($request->get('codigo'),'utf-8')

        );

        gnral_unidad_administrativa::create($unidad);
        return redirect('/generales/unidad_administrativa');
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
        return (gnral_unidad_administrativa::find($id));
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
        $this->validate($request,[
            'nombre_mod' => 'required',
            'clave_mod' => 'required',
            'codigo_mod' => 'required',

        ]);

        $unidad = array(
            'nom_departamento' => mb_strtoupper($request->get('nombre_mod'),'utf-8'),
            'clave' => mb_strtoupper($request->get('clave_mod'),'utf-8'),
            'cod' => mb_strtoupper($request->get('codigo_mod'),'utf-8')

        );

        gnral_unidad_administrativa::find($id)->update($unidad);
        return back();
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
        gnral_unidad_administrativa::destroy($id);
        return redirect('/generales/unidad_administrativa');
    }
}