<?php

namespace App\Http\Controllers;

use App\RmSectorauxs;
use App\gnral_unidad_administrativa;
use App\Gnral_Personales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use \Validator;
use DB;

class RmSectorauxsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar  = $request->get('buscarpor');
        $tipo = $request->get('tipo');
        $sectores = RmSectorauxs::buscarpor($tipo, $buscar)->paginate(2);
        $departamentos = gnral_unidad_administrativa::all();
        return view('RMateriales.sectorauxs',compact('sectores','departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $sectores = RmSectorauxs::paginate(2);
        $departamentos = gnral_unidad_administrativa::all();
        return view('RMateriales.sectorauxs',compact('sectores','departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nombre' => 'required|string',
                'csp' => 'required',
                'id_area' => 'required|integer',
                //'id_per' => 'required|integer',
                'puesto' => 'required|string',
                'fechain' => 'required|date',
            ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $sectores = new RmSectorauxs();
        $sectores->nombre = $request->get('nombre');
        $sectores->csp = $request->get('csp');
        $sectores->id_area = $request->get('id_area');
        $sectores->puesto = $request->get('puesto');
        $sectores->fechain = $request->get('fechain');
        $sectores->save();
        return Redirect::to('/SectorAux');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\RmCategoria  $rmSectorauxs
     * @return \Illuminate\Http\Response
     */
    public function show(RmSectorauxs $rmSectorauxs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RmCategoria  $rmSectorauxs
     * @return \Illuminate\Http\Response
     */
    public function edit(RmSectorauxs $rmSectorauxs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RmCategoria  $rmSectorauxs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sectores = RmSectorauxs::findOrFail($id);
        $sectores->nombre = $request->input('nombre');
        $sectores->csp = $request->input('csp');
        $sectores->id_area = $request->get('id_area');
        $sectores->puesto = $request->input('puesto');
        $sectores->fechain = $request->input('fechain');
        $sectores->save();

        return Redirect::to('/SectorAux');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RmCategoria  $rmSectorauxs
     * @return \Illuminate\Http\Response
     */
    public function destroy(RmSectorauxs $rmSectorauxs)
    {
        //
    }
    public function desactivar(Request $request)
    {
        $sectores = RmSectorauxs::findOrFail($request->id);
        $sectores->condicion = '0';
        $sectores->save();
        return Redirect::to('/SectorAux');
    }
}