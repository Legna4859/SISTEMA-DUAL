<?php

namespace App\Http\Controllers;
use App\oc_oficio;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

use Illuminate\Http\Request;

class OcEvaluacionOficioController extends Controller
{
    public function index()
    {

        $solicitudes = oc_oficio::has('comisionados')->orderBy('fecha_hora')->get();

        $ofic=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) ofs from oc_oficio_personal where  oc_oficio_personal.id_notificacion=1');
        $ofic=$ofic->ofs;
 //dd($oficioss);
       return view('comision_oficio.evaluacion_oficio', compact('solicitudes'))->with(['ofic'=>$ofic]);
    }
    public function subdireccion(){
        $solicitudes = oc_oficio::has('comisionadosprofesores')->orderBy('fecha_hora')->get();
        $ofic=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) ofs from oc_oficio_personal where  oc_oficio_personal.id_notificacion=5');
        $ofic=$ofic->ofs;

       // dd($notification);

        return view('comision_oficio.validacion_profesores', compact('solicitudes'))->with(['ofic'=>$ofic]);

    }
    public function historialrecibidos()
    {
           $anos_oficios=DB::select('SELECT * FROM oc_anos');
        $id_anos=0;
        $mostrar=0;


        $ofic=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) ofs from oc_oficio_personal where  oc_oficio_personal.id_notificacion=1');
        $ofic=$ofic->ofs;

        return view('comision_oficio.historial_oficios_recibidos', compact('ofic','anos_oficios','id_anos','mostrar'));
    }
    public function historial_mostrar($id_anos){
        $id_a=DB::selectOne('SELECT * FROM oc_anos where id_ano='.$id_anos.'');
       $id_a=$id_a->descripcion;
       // dd($id_anos);
        $anos_oficios=DB::select('SELECT * FROM oc_anos');
        $oficioss = DB::table('oc_oficio_personal')
            ->join('oc_oficio','oc_oficio.id_oficio','=','oc_oficio_personal.id_oficio')
            ->join('gnral_personales','oc_oficio_personal.id_personal','=','gnral_personales.id_personal')->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->where('oc_oficio_personal.anio','=',$id_a)
            ->where('oc_oficio_personal.id_notificacion','=',2)
            ->orwhere('oc_oficio_personal.id_notificacion','=',3)
            ->select('oc_oficio_personal.id_oficio_personal','oc_oficio_personal.no_oficio','oc_oficio_personal.estado_oficio','oc_oficio.hora_s','oc_oficio.hora_r','oc_oficio.fecha_hora','oc_oficio.fecha_salida','oc_oficio.fecha_salida','oc_oficio.fecha_regreso','oc_oficio.id_lugar_salida','oc_oficio.id_lugar_salida','oc_oficio.id_lugar_entrada','oc_oficio.desc_comision','oc_oficio_personal.id_notificacion','oc_oficio_personal.viaticos','oc_oficio_personal.automovil','abreviaciones.titulo','gnral_personales.nombre')
            ->orderBy('oc_oficio.fecha_hora', 'DESC')
            ->get();
        $mostrar=1;


        $ofic=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) ofs from oc_oficio_personal where  oc_oficio_personal.id_notificacion=1');
        $ofic=$ofic->ofs;

        return view('comision_oficio.historial_oficios_recibidos', compact('oficioss','ofic','anos_oficios','id_anos','mostrar'));

       // dd('hola');
    }
    public function historialprofesores()
    {

        $anos_oficios=DB::select('SELECT * FROM oc_anos');
        $id_anos=0;
        $mostrar=0;



        $ofic=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) ofs from oc_oficio_personal where  oc_oficio_personal.id_notificacion=5');
        $ofic=$ofic->ofs;

        return view('comision_oficio.historial_oficios_profesores', compact('anos_oficios','ofic','id_anos','mostrar'));
    }
    public function historial_mostrar_profesores($id_anos){
        $anos_oficios=DB::select('SELECT * FROM oc_anos');
        $id_a=DB::selectOne('SELECT * FROM oc_anos where id_ano='.$id_anos.'');
        $id_a=$id_a->descripcion;
        $mostrar=1;
        $id_periodo = Session::get('periodotrabaja');
        $oficioss = DB::table('oc_oficio_personal')
            ->join('oc_oficio','oc_oficio.id_oficio','=','oc_oficio_personal.id_oficio')
            ->join('gnral_personales','oc_oficio_personal.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->join('gnral_horarios','gnral_horarios.id_personal','=','gnral_personales.id_personal')
            ->join('gnral_periodo_carreras','gnral_periodo_carreras.id_periodo_carrera','=','gnral_horarios.id_periodo_carrera')
            ->where('oc_oficio_personal.anio','=',$id_a)
            ->where('gnral_periodo_carreras.id_periodo','=',$id_periodo)
            ->whereIn('oc_oficio_personal.id_notificacion',[1,2,3,6])
            ->select ('oc_oficio_personal.id_oficio_personal','oc_oficio.fecha_hora','oc_oficio.desc_comision','oc_oficio_personal.id_notificacion','oc_oficio_personal.viaticos','oc_oficio_personal.automovil','abreviaciones.titulo','gnral_personales.nombre','oc_oficio_personal.no_oficio')
            ->distinct()
            ->orderBy('oc_oficio.fecha_hora', 'DESC')
            ->get();

        $ofic=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) ofs from oc_oficio_personal where  oc_oficio_personal.id_notificacion=5');
        $ofic=$ofic->ofs;
       // dd($oficioss);
        return view('comision_oficio.historial_oficios_profesores', compact('oficioss','anos_oficios','ofic','id_anos','mostrar'));

    }
    public function mostrar($id_oficio){


        //ver oficio por comisionado
        $oficios=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.desc_comision,oc_oficio.fecha_salida,oc_oficio.fecha_regreso,oc_oficio.hora_s,oc_oficio.hora_r from oc_oficio,oc_oficio_personal WHERE   oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $dependencias=DB::select('SELECT oc_depend_domicilio.*,gnral_estados.nombre_estado,gnral_municipios.nombre_municipio FROM oc_depend_domicilio,gnral_municipios,gnral_estados WHERE oc_depend_domicilio.id_municipio=gnral_municipios.id_municipio 
and gnral_municipios.id_estado=gnral_estados.id_estado and oc_depend_domicilio.id_oficio ='.$oficios->id_oficio.''); $personales=DB::selectOne('SELECT oc_oficio_vehiculo.licencia, oc_vehiculo.modelo,oc_vehiculo.placas,gnral_personales.nombre,abreviaciones.titulo,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_personal from oc_vehiculo,oc_oficio_vehiculo,oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_vehiculo.id_vehiculo=oc_oficio_vehiculo.id_vehiculo and oc_oficio_vehiculo.id_oficio_personal=oc_oficio_personal.id_oficio_personal and oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.id_oficio_personal='.$id_oficio.' and oc_oficio_personal.automovil=2 UNION SELECT 0,0,0,gnral_personales.nombre,abreviaciones.titulo,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_personal from oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.automovil=1 and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $lugar_s=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar,oc_oficio_personal WHERE oc_oficio.id_lugar_salida=oc_lugar.id_lugar and oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $lugar_r=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar,oc_oficio_personal WHERE oc_oficio.id_lugar_entrada=oc_lugar.id_lugar and oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        return view('comision_oficio.partialsof.modal_comisionados',compact('dependencias'))->with([ 'personales' => $personales,'oficios' => $oficios,'lugar_s' => $lugar_s,'lugar_r' => $lugar_r]);
    }
    public function editarsudireccion($id_oficio){

        DB::update('UPDATE oc_oficio_personal SET id_notificacion = 4 WHERE oc_oficio_personal.id_oficio='.$id_oficio.'');
        DB::update('UPDATE oc_oficio SET id_notificacion_solicitud =4  WHERE oc_oficio.id_oficio='.$id_oficio.'');
        return redirect('/oficios/evaluacionsubdirecion');

    }
    public  function permisoeditar($id_oficio){
        DB::update('UPDATE oc_oficio_personal SET id_notificacion = 4 WHERE oc_oficio_personal.id_oficio='.$id_oficio.'');
        DB::update('UPDATE oc_oficio SET id_notificacion_solicitud =4  WHERE oc_oficio.id_oficio='.$id_oficio.'');
        return redirect('/oficios/evaluacion');
    }
    public  function  mostrarvalidados(){
        $ofic=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) ofs from oc_oficio_personal where  oc_oficio_personal.id_notificacion=5');

        return response()->json($ofic);

    }
    public function mostrarvalidadospersonal(){
        $oficiosp=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) ofp from oc_oficio_personal where  oc_oficio_personal.id_notificacion=1');
        return response()->json($oficiosp);
    }
    public function  notificaciones() {
        $id_usuario = Session::get('usuario_alumno');
        $noti=DB::selectOne('SELECT COUNT(oc_notificacion.id_notificacion) ofsl from oc_notificacion where  oc_notificacion.id_usuario='.$id_usuario.'');

        return response()->json($noti);

    }
    public function liberarcomisionado(Request $request){
        $oficio_personal = $request->input("personal");
        $estado_oficio = $request->input("optradio");
        if ($estado_oficio == 1){
        DB::update("UPDATE oc_oficio_personal SET estado_oficio = 1 WHERE oc_oficio_personal.id_oficio_personal= $oficio_personal");
        }
        else{
            $oficio=DB::selectOne('SELECT * FROM oc_oficio_personal WHERE id_oficio_personal = '.$oficio_personal.' ORDER BY id_oficio DESC');
            $oficio=$oficio->id_oficio;
            $solicitud=DB::selectOne('SELECT * FROM oc_oficio WHERE id_oficio = '.$oficio.' ORDER BY id_oficio DESC');
            $comisionados=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) comisionados from oc_oficio_personal WHERE oc_oficio_personal.id_oficio='.$oficio.'');
           if($comisionados->comisionados == 1)
           {
               DB::update("UPDATE oc_oficio_personal SET estado_oficio = 2 WHERE oc_oficio_personal.id_oficio_personal= $oficio_personal");

           }
           else{
               $numero= DB::selectOne('SELECT MAX(oc_oficio.id_oficio) numero FROM oc_oficio');
               $numero=$numero->numero;
               $numeross=($numero)+1;
               DB:: table('oc_oficio')->insert(['id_oficio'=>$numeross,'fecha'=>$solicitud->fecha,'desc_comision'=>$solicitud->desc_comision,
                   'fecha_salida'=>$solicitud->fecha_salida,'fecha_regreso'=>$solicitud->fecha_regreso,'hora_s'=>$solicitud->hora_s,
                   'hora_r'=>$solicitud->hora_r,'id_lugar_salida'=>$solicitud->id_lugar_salida,'id_lugar_entrada'=>$solicitud->id_lugar_entrada,
                   'fecha_hora'=>$solicitud->fecha_hora,'id_usuario'=>$solicitud->id_usuario,'id_notificacion_solicitud'=>$solicitud->id_notificacion_solicitud
            ]);
               $dependencias= DB::select('SELECT * FROM oc_depend_domicilio WHERE id_oficio = '.$oficio.' ORDER BY oc_depend_domicilio.id_depend_domicilio ASC');
             foreach ($dependencias as $dependencias){
                 DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencias->dependencia,'domicilio'=>$dependencias->domicilio,
                     'id_oficio'=>$numeross,'id_municipio'=>$dependencias->id_municipio]);

             }
               DB::update("UPDATE oc_oficio_personal SET estado_oficio = 2,id_oficio = $numeross WHERE oc_oficio_personal.id_oficio_personal= $oficio_personal");


           }


        }


    return back();
    }
    public function estado_dependencia($id_estado){
        $estadosd=DB::select('SELECT * FROM gnral_estados WHERE id_estado = '.$id_estado.'');
        return response()->json($estadosd);
    }

}
