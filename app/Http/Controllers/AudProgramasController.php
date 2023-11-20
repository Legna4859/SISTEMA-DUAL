<?php

namespace App\Http\Controllers;

use App\AudAuditores;
use App\AudAuditoriaProceso;
use App\AudAuditorias;
use App\AudObjetivo;
use App\AudProgramas;
use App\ri_proceso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AudProgramasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $programas = AudProgramas::orderBy('fecha_i','ASC')->get();
        $esLider=false;
        if ($idLider = AudAuditores::where('id_categoria',1)->get()[0]->id_personal==Session::get('id_perso'))
            $esLider=true;
        return view("auditorias.programas",compact('programas','esLider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $programas = AudProgramas::orderBy('fecha_i','ASC')->get();
        $idLider = AudAuditores::where('id_categoria',1)->get()[0];
        return view("auditorias.programas",compact('programas','idLider'));
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
        $validator = Validator::make($request->all(), [
            'inicio' => 'required',
            'fin' => 'required',
            'lugar' => 'required',
            'alcance' => 'required',
            'objetivo' => 'required',
            'metodos' =>'required',
            'responsabilidades' => 'required',
        ],[
            'inicio.required' => 'La fecha de inicio es requerida',
            'fin.required' => 'La fecha de termino es requerida',
            'lugar.required' => 'El campo lugar es requerido',
            'alcance.required' => 'El alcance es requerido',
            'objetivo.required' => 'El objetivo es requerido',
            'metodos.required' =>'Los metodos a utilizar son requeridos',
            'responsabilidades.required' => 'Es necesario especificar las responsabilidades',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }
        $programa = array(
            'fecha_i' => Carbon::parse($request->get('inicio'))->format('Y-m-d'),
            'fecha_f' => Carbon::parse($request->get('fin'))->endOfMonth()->format('Y-m-d'),
            'lugar' => $request->get('lugar'),
            'alcance' => $request->get('alcance'),
            'objetivo' => $request->get('objetivo'),
            'metodos' => $request->get('metodos'),
            'responsabilidades' => $request->get('responsabilidades')
        );
        AudProgramas::create($programa);
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
        Session::put('id_programa',$id);
        $programas=AudProgramas::get()->where('id_programa',$id);
        $esLider=false;
        if ($idLider = AudAuditores::where('id_categoria',1)->get()[0]->id_personal==Session::get('id_perso'))
            $esLider=true;
       // return view('auditorias.ver_programa',compact('programas','objetivos','esLider'));
        return view('auditorias.ver_programa',compact('programas','esLider'));

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
        Session::put('id_programa',$id);
        $programas=AudProgramas::get()->where('id_programa',$id);
        $auditorias=AudAuditorias::orderBy('fecha_i','ASC')->where('id_programa',$id)->get();
        $procesos =ri_proceso::orderBy('clave','ASC')->orderBy('des_proceso','ASC')->get();
        //$procesosEnAgenda=AudAuditoriaProceso::orderBy('id_proceso')
        //->whereIn('id_auditoria',$auditorias->pluck('id_auditoria'))
        //->get()->pluck('id_proceso')->unique()->toArray();

       // dd($procesos);

        $procesosEnAgenda=AudAuditoriaProceso::join('aud_auditoria','aud_auditoria_proceso.id_auditoria','=','aud_auditoria.id_auditoria')
            ->join('ri_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
           // ->where('ri_proceso.id_proceso',"<>",44) //para ignorar proceso de audiotiras internas
            ->where('aud_auditoria.id_programa',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->where('aud_auditoria.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_proceso')
            ->orderBy('aud_auditoria_proceso.id_proceso')
            ->get()->pluck('id_proceso')->unique()->toArray();

        /*
          DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso','ri_proceso.id_proceso')
            ->orderBy('ri_proceso.clave','ASC')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();
         * */
        /*$sql="SELECT DISTINCT aud_auditoria_proceso.id_proceso
                FROM aud_auditoria_proceso
                INNER JOIN aud_auditoria ON aud_auditoria.id_auditoria = aud_auditoria_proceso.id_auditoria 
                INNER JOIN ri_proceso ON aud_auditoria_proceso.id_proceso=ri_proceso.id_proceso
                WHERE aud_auditoria.id_programa=:id";
        $procesosEnAgenda=DB::select($sql,['id'=>$id]);*/
       // dd($procesosEnAgenda);
        $porcentaje=round((sizeof($procesosEnAgenda)*100)/(sizeof($procesos)-1),0);// -1 para ignorar el proceso de auditorias internas

      //  dd($porcentaje);

        $porcentaje=$porcentaje>=100?'100':$porcentaje;
        $esLider=false;
        if ($idLider = AudAuditores::where('id_categoria',1)->get()[0]->id_personal==Session::get('id_perso'))
            $esLider=true;$idLider = AudAuditores::where('id_categoria',1)->get()[0];
        return view('auditorias.procesos_auditoria',compact('programas','esLider','auditorias','procesos','procesosEnAgenda','porcentaje'));
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
       // dd("edit");
        $validator = Validator::make($request->all(), [
            'inicio' => 'required',
            'fin' => 'required',
            'lugar' => 'required',
            'alcance' => 'required',
            'objetivo' => 'required',
            'metodos' =>'required',
            'responsabilidades' => 'required',
        ]);
        $validator2 = Validator::make($request->all(), [
            'recursos' => 'required',
            'requisitos' => 'required',
            'criterios' => 'required',
        ]);
        if (!$validator->fails()){
            $programa = array(
                'fecha_i' => Carbon::parse($request->get('inicio'))->format('Y-m-d'),
                'fecha_f' => Carbon::parse($request->get('fin'))->format('Y-m-d'),
                'lugar' => $request->get('lugar'),
                'alcance' => $request->get('alcance'),
                'objetivo' => $request->get('objetivo'),
                'metodos' => $request->get('metodos'),
                'responsabilidades' => $request->get('responsabilidades')
            );
            AudProgramas::find($id)->update($programa);
            return back();
        }

        if (!$validator2->fails()){
            $programa = array(
                'recursos' => $request->get('recursos'),
                'requisitos' => $request->get('requisitos'),
                'criterios' => $request->get('criterios'),
            );

            AudProgramas::find($id)->update($programa);
            return back();
        }

        if($validator->fails())
            Session::put('errors',$validator->errors());
        if ($validator2->fails())
            Session::put('errors',$validator->errors());
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
        AudProgramas::destroy($id);
        return back();
    }

    public function statePrograma(Request $request, $id)
    {

        AudProgramas::where("id_programa",$id)->update([
            "active"=>$request->statePrograma,
            'observaciones'=>$request->observaciones,
            'justificacion'=>$request->justificacion
        ]);
        return back();
    }

}
