<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\RmBitRes;
use QrCode;
use App\RmBienes;
use App\RmCategoria;
use App\RmEstadouso;
use App\RmMarcas;
use App\RmModelos;
use App\RmColores;
use App\RmProvedores;
use App\RmTipoadqui;
use App\RmTipobienes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Session;
use \Validator;
use DB;
use ZipStream\File;

class   RmBienesController extends Controller
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
        $bienes = RmBienes::buscarpor($tipo, $buscar)->paginate(5);//para buscar variables

        $categorias = RmCategoria::where('condicion' ,'=' ,'1' )->select('id','nombre')
            ->orderBy('nombre','asc')->get();
        $provedores = RmProvedores::where('condicion','=','1')->select('id','nombre')
            ->orderBy('nombre','asc')->get();
        $modelos = RmModelos::where('condicion','=','1')->select('id','modelo')
            ->orderBy('modelo','asc')->get();
        $marcas = RmMarcas::where('condicion','=','1')->select('id','marca')
            ->orderBy('marca','asc')->get();
        $usos = RmEstadouso::all();
        $bienest = RmTipobienes::all();
        $colores = RmColores::all();
        $adquisiciones = RmTipoadqui::all();

        return view('RMateriales.bienes', compact('bienes','categorias',
            'marcas','provedores','modelos','usos','bienest','colores','adquisiciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bienes = RmBienes::paginate(5);
        $categorias = RmCategoria::where('condicion' ,'=' ,'1' )->select('id','nombre')
        ->orderBy('nombre','asc')->get();
        $provedores = RmProvedores::where('condicion','=','1')->select('id','nombre')
        ->orderBy('nombre','asc')->get();
        $modelos = RmModelos::where('condicion','=','1')->select('id','modelo')
            ->orderBy('modelo','asc')->get();
        $marcas = RmMarcas::where('condicion','=','1')->select('id','marca')
            ->orderBy('marca','asc')->get();
        $usos = RmEstadouso::all();
        $bienest = RmTipobienes::all();
        $colores = RmColores::all();
        $adquisiciones = RmTipoadqui::all();
        return view('RMateriales.bienes', compact('bienes','categorias',
            'marcas','provedores','modelos','usos','bienest','colores','adquisiciones'));
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
                'caracteristicas' => 'required|string',
                'num_inventario' => 'required|string',
                'nick' => 'required|string',
                'serie' => 'required|string',
                'costo' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'fechadqui' => 'required|date',
                'factura' => 'required|string',
                'id_categoria' => 'required|integer',
                'id_provedor' => 'required|integer',
                'id_modelo' =>'required|integer',
                'id_estado' => 'required|integer',
                'id_marca' => 'required|integer',
                'id_tipob' => 'required|integer',
                'id_tipoadqui' => 'required|integer',
                'id_color' => 'required|integer',
            ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $bienes = new RmBienes();
        $bienes->nombre=$request->get('nombre');
        $bienes->caracteristicas=$request->get('caracteristicas');
        $bienes->num_inventario=$request->get('num_inventario');
        $bienes->nick=$request->get('nick');
        $bienes->serie=$request->get('serie');
        $bienes->costo=$request->get('costo');
        $bienes->factura=$request->get('factura');
        $bienes->fechadqui=$request->get('fechadqui');
        $bienes->id_tipoadqui=$request->get('id_tipoadqui');
        $bienes->id_categoria = $request->get('id_categoria');
        $bienes->id_provedor = $request->get('id_provedor');
        $bienes->id_modelo = $request->get('id_modelo');
        $bienes->id_estado = $request->get('id_estado');
        $bienes->id_marca = $request->get('id_marca');
        $bienes->id_tipob = $request->get('id_tipob');
        $bienes->id_color = $request->get('id_color');
        $bienes->save();
        return Redirect::to('/Bienes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RmBienes  $rmBienes
     * @return \Illuminate\Http\Response
     */
    public function show(RmBienes $rmBienes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RmBienes  $rmBienes
     * @return \Illuminate\Http\Response
     */
    public function edit(RmBienes $rmBienes)
    {
        //
    }
    public function downloadExcel($type)
    {
        $data = RmBienes::get()->toArray();
        return Excel::create('Concentrado de Bienes del TESVB', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
    public function vistaexcel()
    {
        return view('RMateriales.excelbienes');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RmBienes  $rmBienes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bienes = RmBienes::findOrFail($id);
        $bienes->nombre=$request->input('nombre');
        $bienes->caracteristicas=$request->input('caracteristicas');
        $bienes->costo=$request->input('costo');
        $bienes->factura=$request->input('factura');
        $bienes->fechadqui=$request->input('fechadqui');
        $bienes->id_categoria = $request->get('id_categoria');
        $bienes->id_provedor = $request->get('id_provedor');
        $bienes->id_modelo = $request->get('id_modelo');
        $bienes->id_estado = $request->get('id_estado');
        $bienes->id_marca = $request->get('id_marca');
        $bienes->id_tipob=$request->get('id_tipob');
        $bienes->id_color=$request->get('id_color');
        $bienes->save();
        return Redirect::to('/Bienes');
    }


    public function activar(Request $request)
    {
        $bienes = RmBienes::findOrFail($request->id);
        $bienes->condicion = '1';
        $bienes->save();
        return Redirect::to('/Bienes');
    }
    public function desactivar(Request $request)
    {
        $bienes = RmBienes::findOrFail($request->id);
        $bienes->condicion = '0';
        $bienes->save();
        return Redirect::to('/Bienes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RmBienes  $rmBienes
     * @return \Illuminate\Http\Response
     */
    public function destroy(RmBienes $rmBienes)
    {
        //
    }
}
