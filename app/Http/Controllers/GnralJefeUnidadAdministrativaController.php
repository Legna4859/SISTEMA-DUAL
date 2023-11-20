<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\GnralJefeUnidadAdministrativa;
use App\Gnral_Personales;
use App\gnral_unidad_administrativa;
class GnralJefeUnidadAdministrativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jefes_unidades = DB::select('select up.id_unidad_persona, up.id_personal,p.nombre, ua.id_unidad_admin,ua.nom_departamento from gnral_unidad_personal up,gnral_unidad_administrativa ua,
        gnral_personales p where up.id_personal=p.id_personal and   ua.id_unidad_admin=up.id_unidad_admin');
        $unidad_administrativa=gnral_unidad_administrativa::all();
        $personal=DB::select('SELECT * FROM gnral_personales ORDER BY gnral_personales.nombre ASC');
        return view('generales.jefe_unidad_administrativa',compact('jefes_unidades','unidad_administrativa','personal'));
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
        $this->validate($request, [
            'unidad_administrativa' => 'required',
            'personal' => 'required',
        ]);

        $jefe_unidad = array(
            'id_unidad_admin' => mb_strtoupper($request->get('unidad_administrativa'),'utf-8'),
            'id_personal' => mb_strtoupper($request->get('personal'),'utf-8'),

        );

        GnralJefeUnidadAdministrativa::create($jefe_unidad);

        return back();



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
        return (GnralJefeUnidadAdministrativa::find($id));

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
        $this->validate($request, [
            'unidad_administrativa_modi' => 'required',
            'personal_modi' => 'required',
        ]);

        $jefe_unidad = array(
            'id_unidad_admin' => mb_strtoupper($request->get('unidad_administrativa_modi'),'utf-8'),
            'id_personal' => mb_strtoupper($request->get('personal_modi'),'utf-8'),

        );
        GnralJefeUnidadAdministrativa::find($id)->update($jefe_unidad);
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
        //dd($id);
        GnralJefeUnidadAdministrativa::destroy($id);
        return back();
    }
    public function mostrar()//creamos una funcion para mostrar las áreas junto con sus encargados
    {

        $jefes_unidades = DB::select('select up.id_unidad_persona, up.id_personal,p.nombre, ua.id_unidad_admin,ua.nom_departamento from gnral_unidad_personal up,gnral_unidad_administrativa ua,
        gnral_personales p where up.id_personal=p.id_personal and   ua.id_unidad_admin=up.id_unidad_admin');
        $unidad_administrativa=gnral_unidad_administrativa::all();




        return view('RMateriales.listadoareas',compact('jefes_unidades','unidad_administrativa'));

    }
}
