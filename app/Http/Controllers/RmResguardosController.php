<?php

namespace App\Http\Controllers;

use App\gnral_unidad_administrativa;
use Illuminate\Support\Facades\Response;
use App\RmBienes;
use App\RmResguardos;
use App\RmSectorauxs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class RmResguardosController extends Controller
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
        $resguardos = RmResguardos::buscarpor($tipo, $buscar)->paginate(10);
        $bienes = RmBienes::where('condicion', '=', '1')->select('id','nombre')
            ->orderBy('nombre','asc')->get();
        $sectores = RmSectorauxs::select('id','nombre')->get();

        return view('RMateriales.resguardos',compact('resguardos','bienes','sectores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resguardos = RmResguardos::paginate(10);
        $bienes = RmBienes::where('condicion', '=', '1')->select('id','nombre as nombre_bien')
        ->orderBy('nombre','asc')->get();
       // dd($bienes);
        $sectores = RmSectorauxs::where('condicion', '=', '1')->select('id','nombre')
            ->orderBy('nombre','asc')->get();
        return view('RMateriales.resguardos',compact('resguardos','bienes','sectores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =\Validator::make($request->all(),
            [
                'id_bienres' => 'required|integer',
                'id_sector' => 'required|integer',
                'fecha' => 'required|date'
            ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $resguardos = new RmResguardos();
        $resguardos->id_bienres = $request->get('id_bienres');
        $resguardos->id_sector = $request->get('id_sector');
        $resguardos->fecha = $request->get('fecha');
        $resguardos->save();
        return Redirect::to('/Resguardos');
    }
    public function find(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $sectores = RmSectorauxs::search($term)->limit(5)->get();

        $formatted_tags = [];

        foreach ($sectores as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nombre];
        }

        return \Response::json($formatted_tags);
    }
    public function PDFTarjetas($id)
    {
        $resguardos = RmResguardos::find($id);
        $sectores = RmSectorauxs::all();
        $pdf = PDF::loadview('RMateriales.pdfresguardo',compact('resguardos','sectores'));

        return $pdf->setPaper('a4','landscape')->stream('tarjeta de resguardo.pdf');
    }
    public function consult()
    {
        $resguardos = RmResguardos::paginate(10);
        $bienes = RmBienes::where('condicion', '=', '1')->select('id','nombre')
            ->orderBy('nombre','asc')->get();
        $sectores = RmSectorauxs::all();
        return view('RMateriales.resguardost',compact('resguardos','bienes','sectores'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RmResguardos  $rmResguardos
     * @return \Illuminate\Http\Response
     */
    public function show(RmResguardos $rmResguardos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RmResguardos  $rmResguardos
     * @return \Illuminate\Http\Response
     */
    public function edit(RmResguardos $rmResguardos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RmResguardos  $rmResguardos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $resguardos  = RmResguardos::findOrFail($id);
        $resguardos->id_bienres = $request->get('id_bienres');//se usa get para actualizar llaves foraneas
        $resguardos->id_sector = $request->get('id_sector');
        $resguardos->fecha = $request->input('fecha');
        $resguardos->save();

        return Redirect::to('/Resguardos');
    }
    public function consultp(Request $request)
    {
        $sec = $request->get('busqueda');
        if($sec == null){
            $sec=0;
        }else{
            $sec=$sec;
        }
        $resguardos = RmResguardos::sector($sec)->paginate(10);
        //dd($resguardos);
                    $bienes = RmBienes::where('condicion', '=', '1')->select('id','nombre')
                        ->orderBy('nombre','asc')->get();
                    $sectores = RmSectorauxs::where('condicion', '=', '1')->select('id','nombre')
                        ->orderBy('nombre','asc')->get();
                    return view('RMateriales.padronbienes',compact('resguardos','bienes','sectores'));
    }
    public function PDFpadron()
    {
        $resguardos = RmResguardos::all();
        $sectores = RmSectorauxs::all();
        $pdf = PDF::loadview('RMateriales.pdfpadron',compact('resguardos','sectores'));
        return $pdf->setPaper('a4','landscape')->stream('padron de bienes.pdf');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RmResguardos  $rmResguardos
     * @return \Illuminate\Http\Response
     */
    public function destroy(RmResguardos $rmResguardos)
    {
        //
    }
}
