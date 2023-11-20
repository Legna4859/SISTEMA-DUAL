<?php

namespace App\Http\Controllers;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Redirect;
use App\Estados;
use App\Municipios;
use App\Oc_lugar;
use App\oc_oficio;
use App\oc_oficio_personal;
use App\oc_oficio_vehiculo;
use App\oc_dependencias;
class OficiosComisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $estados_alu = Estados::all();
        $estados_segundo = Estados::all();
        $lugares = Oc_lugar::all();
        $estados_tercero = Estados::all();
        $estados_cuarto = Estados::all();


        return view('comision_oficio.solicitud_oficio', compact('estados_alu','lugares','estados_segundo','estados_tercero','estados_cuarto'));
    }
    public function store(Request $request)
    {

        $this->validate($request,[
            'descripcion_oficio' => 'required',
            'dependencia' => 'required',
            'domicilio' => 'required',
            'hora_s' => 'required',
            'fecha_salida' => 'required',
            'hora_r' => 'required',
            'fecha_regreso' => 'required',
            'selectLugar_s' => 'required',
            'selectLugar_r' => 'required',
            'municipios' => 'required',
            'segunda_dependencia'=> 'required',
        ]);

        $motivo = $request->input("descripcion_oficio");
        $motivo = ucfirst($motivo);
        $dependencia = $request->input("dependencia");
        $descripcion_oficio=$motivo;
        $domicilio = $request->input("domicilio");
        $hora_s = $request->input("hora_s");
        $fecha_salida = $request->input("fecha_salida");
        $hora_r = $request->input("hora_r");
        $fecha_regreso = $request->input("fecha_regreso");
        $id_lugar_s = $request->input("selectLugar_s");
        $id_lugar_r = $request->input("selectLugar_r");
        $id_municipios = $request->input("municipios");
        $fecha= date("Y-m-d");
        $hora=date("Y-m-d H:i");
        ///////////////////////////////*
        $segunda_dependencia= $request->input("segunda_dependencia");
        ////////////////////////////////////////////////////

        $id_usuario = Session::get('usuario_alumno');
        $numero= DB::selectOne('SELECT MAX(oc_oficio.id_oficio) numero FROM oc_oficio');
        $numero=$numero->numero;
        $num=isset($numero);
        if($num == false){
            $numeross=1;
            if($segunda_dependencia==2)
            {
                $tercera_dependencia= $request->input("tercera_dependencia");
                $dependencia2= $request->input("dependencia2");
                $municipio2= $request->input("municipio2");
                $domicilio2= $request->input("domicilio2");
                if($tercera_dependencia==2){
                    $cuarta_dependencia= $request->input("cuarta_dependencia");
                    $dependencia3= $request->input("dependencia3");
                    $domicilio3= $request->input("domicilio3");
                    $municipio3= $request->input("municipio3");
                    if($cuarta_dependencia==2){
                        $dependencia4= $request->input("dependencia4");
                        $domicilio4= $request->input("domicilio4");
                        $municipio4= $request->input("municipio4");

                        DB:: table('oc_oficio')->insert(['id_oficio'=>$numeross,'fecha'=>$fecha,'desc_comision'=>$descripcion_oficio,
                            'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso,'hora_s'=>$hora_s,
                            'hora_r'=>$hora_r,'id_lugar_salida'=>$id_lugar_s,'id_lugar_entrada'=>$id_lugar_r,
                            'fecha_hora'=>$hora,'id_usuario'=>$id_usuario,'id_notificacion_solicitud'=>1
                        ]);
                        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,
                            'id_oficio'=>$numeross,'id_municipio'=>$id_municipios]);
                        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia2,'domicilio'=>$domicilio2,
                            'id_oficio'=>$numeross,'id_municipio'=>$municipio2]);
                        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia3,'domicilio'=>$domicilio3,
                            'id_oficio'=>$numeross,'id_municipio'=>$municipio3]);
                        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia4,'domicilio'=>$domicilio4,
                            'id_oficio'=>$numeross,'id_municipio'=>$municipio4]);

                    }
                    else{
                        DB:: table('oc_oficio')->insert(['id_oficio'=>$numeross,'fecha'=>$fecha,'desc_comision'=>$descripcion_oficio,
                            'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso,'hora_s'=>$hora_s,
                            'hora_r'=>$hora_r,'id_lugar_salida'=>$id_lugar_s,'id_lugar_entrada'=>$id_lugar_r,
                            'fecha_hora'=>$hora,'id_usuario'=>$id_usuario,'id_notificacion_solicitud'=>1
                        ]);
                        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,
                            'id_oficio'=>$numeross,'id_municipio'=>$id_municipios]);
                        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia2,'domicilio'=>$domicilio2,
                            'id_oficio'=>$numeross,'id_municipio'=>$municipio2]);
                        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia3,'domicilio'=>$domicilio3,
                            'id_oficio'=>$numeross,'id_municipio'=>$municipio3]);


                    }

                }
                else{

                    DB:: table('oc_oficio')->insert(['id_oficio'=>$numeross,'fecha'=>$fecha,'desc_comision'=>$descripcion_oficio,
                        'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso,'hora_s'=>$hora_s,
                        'hora_r'=>$hora_r,'id_lugar_salida'=>$id_lugar_s,'id_lugar_entrada'=>$id_lugar_r,
                        'fecha_hora'=>$hora,'id_usuario'=>$id_usuario,'id_notificacion_solicitud'=>1
                    ]);
                    DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,
                        'id_oficio'=>$numeross,'id_municipio'=>$id_municipios]);
                    DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia2,'domicilio'=>$domicilio2,
                        'id_oficio'=>$numeross,'id_municipio'=>$municipio2]);

                }
            }
            else{
                DB:: table('oc_oficio')->insert(['id_oficio'=>$numeross,'fecha'=>$fecha,'desc_comision'=>$descripcion_oficio,
                    'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso,'hora_s'=>$hora_s,
                    'hora_r'=>$hora_r,'id_lugar_salida'=>$id_lugar_s,'id_lugar_entrada'=>$id_lugar_r,
                    'fecha_hora'=>$hora,'id_usuario'=>$id_usuario,'id_notificacion_solicitud'=>1
                ]);
                DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,'id_oficio'=>$numeross,'id_municipio'=>$id_municipios]);

            } }
        if($num == true){
            $numeross=$numero+1;
             if($segunda_dependencia==2)
             {
                 $tercera_dependencia= $request->input("tercera_dependencia");
                 $dependencia2= $request->input("dependencia2");
                 $municipio2= $request->input("municipio2");
                 $domicilio2= $request->input("domicilio2");
                 if($tercera_dependencia==2){
                     $cuarta_dependencia= $request->input("cuarta_dependencia");
                     $dependencia3= $request->input("dependencia3");
                     $domicilio3= $request->input("domicilio3");
                     $municipio3= $request->input("municipio3");

                         DB:: table('oc_oficio')->insert(['id_oficio'=>$numeross,'fecha'=>$fecha,'desc_comision'=>$descripcion_oficio,
                             'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso,'hora_s'=>$hora_s,
                             'hora_r'=>$hora_r,'id_lugar_salida'=>$id_lugar_s,'id_lugar_entrada'=>$id_lugar_r,
                             'fecha_hora'=>$hora,'id_usuario'=>$id_usuario,'id_notificacion_solicitud'=>1
                         ]);
                         DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,
                             'id_oficio'=>$numeross,'id_municipio'=>$id_municipios]);
                         DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia2,'domicilio'=>$domicilio2,
                             'id_oficio'=>$numeross,'id_municipio'=>$municipio2]);
                         DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia3,'domicilio'=>$domicilio3,
                             'id_oficio'=>$numeross,'id_municipio'=>$municipio3]);




                 }
                 else{

                     DB:: table('oc_oficio')->insert(['id_oficio'=>$numeross,'fecha'=>$fecha,'desc_comision'=>$descripcion_oficio,
                         'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso,'hora_s'=>$hora_s,
                         'hora_r'=>$hora_r,'id_lugar_salida'=>$id_lugar_s,'id_lugar_entrada'=>$id_lugar_r,
                         'fecha_hora'=>$hora,'id_usuario'=>$id_usuario,'id_notificacion_solicitud'=>1
                     ]);
                     DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,
                         'id_oficio'=>$numeross,'id_municipio'=>$id_municipios]);
                     DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia2,'domicilio'=>$domicilio2,
                         'id_oficio'=>$numeross,'id_municipio'=>$municipio2]);

                 }
             }
             else{
                 DB:: table('oc_oficio')->insert(['id_oficio'=>$numeross,'fecha'=>$fecha,'desc_comision'=>$descripcion_oficio,
                     'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso,'hora_s'=>$hora_s,
                     'hora_r'=>$hora_r,'id_lugar_salida'=>$id_lugar_s,'id_lugar_entrada'=>$id_lugar_r,
                     'fecha_hora'=>$hora,'id_usuario'=>$id_usuario,'id_notificacion_solicitud'=>1
                 ]);
                 DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,
                     'id_oficio'=>$numeross,'id_municipio'=>$id_municipios]);

             }





        }

        return redirect()->route('personalcomisionado', $numeross);
    }
    public function  editar($id_oficio){
        //editar oficio
        $conaut= DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) personal from oc_oficio_personal where  oc_oficio_personal.id_oficio='.$id_oficio.'');
        $conaut=$conaut->personal;
        $oficio= DB::selectOne('SELECT * FROM oc_oficio WHERE  oc_oficio.id_oficio='.$id_oficio.'');
        $lugares = Oc_lugar::all();
        if ($conaut>0){
            $mensaje=1;
$comisionadosauto=DB::select('SELECT gnral_personales.nombre,abreviaciones.titulo,
oc_oficio_personal.viaticos,oc_oficio_personal.automovil,
oc_oficio_personal.id_personal,oc_oficio_personal.id_oficio_personal 
from oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones
 WHERE  oc_oficio_personal.id_personal=gnral_personales.id_personal and 
  gnral_personales.id_personal=abreviaciones_prof.id_personal and 
  abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
   oc_oficio_personal.id_oficio='.$id_oficio.'');
            return view('comision_oficio.partialsof.edit_comision',compact('lugares','comisionadosauto'))->with(['oficio'=>$oficio,'mensaje'=>$mensaje]);
        }
        else{
            $mensaje=0;
            return view('comision_oficio.partialsof.edit_comision',compact('lugares'))->with(['oficio'=>$oficio,'mensaje'=>$mensaje]);
        }



    }
    public function  editar_oficio($id_oficio){
        //editar oficio

        $oficio= DB::selectOne('SELECT * FROM oc_oficio WHERE  oc_oficio.id_oficio='.$id_oficio.'');
        $lugares = Oc_lugar::all();

            $mensaje=1;
            $comisionadosauto=DB::select('SELECT gnral_personales.nombre,abreviaciones.titulo,
oc_oficio_personal.viaticos,oc_oficio_personal.automovil,
oc_oficio_personal.id_personal,oc_oficio_personal.id_oficio_personal 
from oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones
 WHERE  oc_oficio_personal.id_personal=gnral_personales.id_personal and 
  gnral_personales.id_personal=abreviaciones_prof.id_personal and 
  abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
   oc_oficio_personal.id_oficio='.$id_oficio.'');
            return view('comision_oficio.partialsof.editar_oficio_comision',compact('lugares','comisionadosauto'))->with(['oficio'=>$oficio,'mensaje'=>$mensaje]);





    }
    public  function modificar_oficio_comisionado(Request $request){
        $this->validate($request,[
            'id_oficio' => 'required',
            'descripcion_oficio' => 'required',
            'hora_s' => 'required',
            'fecha_salida' => 'required',
            'hora_r' => 'required',
            'fecha_regreso' => 'required',
            'selectLugar_s' => 'required',
            'selectLugar_r' => 'required',
        ]);
        $id_oficio = $request->input("id_oficio");
        $descripcion_oficio = $request->input("descripcion_oficio");
        $descripcion_oficio = ucfirst($descripcion_oficio);
        $hora_s = $request->input("hora_s");
        $fecha_salida = $request->input("fecha_salida");
        $hora_r = $request->input("hora_r");
        $fecha_regreso = $request->input("fecha_regreso");
        $id_lugar_s = $request->input("selectLugar_s");
        $id_lugar_r = $request->input("selectLugar_r");
        $hora=date("Y-m-d H:i");
        $oficio= oc_oficio::find($id_oficio);
        $oficio->desc_comision = $descripcion_oficio;
        $oficio->fecha_salida = $fecha_salida;
        $oficio->fecha_regreso = $fecha_regreso;
        $oficio->hora_s = $hora_s;
        $oficio->hora_r = $hora_r;
        $oficio->id_lugar_salida = $id_lugar_s;
        $oficio->id_lugar_entrada = $id_lugar_r;
        $oficio->fecha_hora = $hora;
        $oficio->save();
return back();
    }
    public  function  modificar(Request $request){
       //modificar oficios
        $this->validate($request,[
            'id_oficio' => 'required',
           'descripcion_oficio' => 'required',
            'hora_s' => 'required',
            'fecha_salida' => 'required',
            'hora_r' => 'required',
            'fecha_regreso' => 'required',
            'selectLugar_s' => 'required',
            'selectLugar_r' => 'required',
        ]);
        $id_oficio = $request->input("id_oficio");
        $descripcion_oficio = $request->input("descripcion_oficio");
        $descripcion_oficio = ucfirst($descripcion_oficio);
        $hora_s = $request->input("hora_s");
        $fecha_salida = $request->input("fecha_salida");
        $hora_r = $request->input("hora_r");
        $fecha_regreso = $request->input("fecha_regreso");
        $id_lugar_s = $request->input("selectLugar_s");
        $id_lugar_r = $request->input("selectLugar_r");
        $hora=date("Y-m-d H:i");

        $oficios = DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.fecha_salida,oc_oficio.fecha_regreso from oc_oficio WHERE oc_oficio.id_oficio=' . $id_oficio . '');
        $fechasalida = $oficios->fecha_salida;
        $fecharegreso = $oficios->fecha_regreso;
        $id_usuario = Session::get('usuario_alumno');
        if($fechasalida == $fecha_salida and $fecharegreso == $fecha_regreso )
        {
            $oficio= oc_oficio::find($id_oficio);
            $oficio->desc_comision = $descripcion_oficio;
            $oficio->fecha_salida = $fecha_salida;
            $oficio->fecha_regreso = $fecha_regreso;
            $oficio->hora_s = $hora_s;
            $oficio->hora_r = $hora_r;
            $oficio->id_lugar_salida = $id_lugar_s;
            $oficio->id_lugar_entrada = $id_lugar_r;
            $oficio->fecha_hora = $hora;
            $oficio->save();



                return redirect()->route('personalcomisionado', $id_oficio);


        }
        else{
            $conaut= DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) personal from oc_oficio_personal,oc_oficio_vehiculo where oc_oficio_personal.id_oficio_personal=oc_oficio_vehiculo.id_oficio_personal and oc_oficio_personal.id_oficio='.$id_oficio.'');
             if($conaut->personal >0){
                 $personalauto= DB::select('SELECT oc_oficio_personal.id_oficio_personal from oc_vehiculo,oc_oficio_vehiculo,oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_vehiculo.id_vehiculo=oc_oficio_vehiculo.id_vehiculo and oc_oficio_vehiculo.id_oficio_personal=oc_oficio_personal.id_oficio_personal and oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.id_oficio='.$id_oficio.'');
                 foreach($personalauto as $personal){
                     DB::delete('DELETE FROM oc_oficio_vehiculo WHERE id_oficio_personal='.$personal->id_oficio_personal.'');
                     oc_oficio_personal::destroy($personal->id_oficio_personal);

                 }
             }
            $sinaut= DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) personal from oc_oficio_personal where  oc_oficio_personal.automovil=1 and  oc_oficio_personal.id_oficio='.$id_oficio.'');
           $sinaut=$sinaut->personal;
            if($sinaut >0){
                $personalsinauto= DB::select('SELECT oc_oficio_personal.id_oficio_personal from oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_oficio_personal.automovil=1 and   oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.id_oficio='.$id_oficio.'');
                foreach($personalsinauto as $personal){
                    oc_oficio_personal::destroy($personal->id_oficio_personal);
                      }

            }
            $oficio= oc_oficio::find($id_oficio);
            $oficio->desc_comision = $descripcion_oficio;
            $oficio->fecha_salida = $fecha_salida;
            $oficio->fecha_regreso = $fecha_regreso;
            $oficio->hora_s = $hora_s;
            $oficio->hora_r = $hora_r;
            $oficio->id_lugar_salida = $id_lugar_s;
            $oficio->id_lugar_entrada = $id_lugar_r;
            $oficio->fecha_hora = $hora;
            $oficio->save();

                return redirect()->route('personalcomisionado', $id_oficio);

        }


    }


    public function registrados($id_oficio){
        //registro de  comisionados de unidades
        $id_usuario = Session::get('usuario_alumno');
        $estados = Estados::all();
        $encontrado= DB::selectOne('SELECT oc_oficio.id_oficio,1 numero FROM oc_oficio,oc_oficio_personal WHERE oc_oficio_personal.id_oficio=oc_oficio.id_oficio AND oc_oficio.id_oficio='.$id_oficio.' UNION Select oc_oficio.id_oficio,0 numero from oc_oficio where oc_oficio.id_oficio='.$id_oficio.' and not exists (select oc_oficio_personal.id_oficio from oc_oficio_personal where oc_oficio.id_oficio = oc_oficio_personal.id_oficio)');
        $encontrado=$encontrado->numero;
        $dependencias_r=DB::selectOne('SELECT count(oc_depend_domicilio.id_depend_domicilio) dependenciasr  FROM oc_depend_domicilio WHERE oc_depend_domicilio.id_oficio ='.$id_oficio.'');

    $solicitudes=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.desc_comision,
    oc_oficio.fecha_salida,oc_oficio.fecha_regreso,oc_oficio.hora_s,oc_oficio.hora_r 
    from oc_oficio WHERE oc_oficio.id_oficio='.$id_oficio.'');
    $dependencias= DB::select('SELECT oc_depend_domicilio.*,gnral_municipios.nombre_municipio,gnral_estados.nombre_estado FROM oc_depend_domicilio,gnral_estados,gnral_municipios WHERE oc_depend_domicilio.id_municipio=gnral_municipios.id_municipio and gnral_municipios.id_estado=gnral_estados.id_estado and oc_depend_domicilio.id_oficio= '.$id_oficio.'');
        $lugar_s=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar WHERE oc_oficio.id_lugar_salida=oc_lugar.id_lugar and oc_oficio.id_oficio='.$id_oficio.'');
        $lugar_r=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar WHERE oc_oficio.id_lugar_entrada=oc_lugar.id_lugar and oc_oficio.id_oficio='.$id_oficio.'');
        $comisionados=DB::select('SELECT oc_vehiculo.modelo,oc_vehiculo.placas,oc_oficio_vehiculo.licencia,gnral_personales.nombre,abreviaciones.titulo,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_personal,oc_oficio_personal.id_oficio_personal from oc_vehiculo,oc_oficio_vehiculo,oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_vehiculo.id_vehiculo=oc_oficio_vehiculo.id_vehiculo and oc_oficio_vehiculo.id_oficio_personal=oc_oficio_personal.id_oficio_personal and oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.id_oficio='.$id_oficio.' and oc_oficio_personal.automovil=2 UNION SELECT 0,0,0,gnral_personales.nombre,abreviaciones.titulo,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_personal,oc_oficio_personal.id_oficio_personal from oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.automovil=1 and oc_oficio_personal.id_oficio='.$id_oficio.'');
        $oficios=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.fecha_salida,oc_oficio.fecha_regreso from oc_oficio WHERE oc_oficio.id_oficio='.$id_oficio.'');


        $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;

        if($jefe_division == true) {
            $id_periodo = Session::get('periodotrabaja');
            $id_carrera = Session::get('carrera');
            $num = DB::selectOne('SELECT count(oc_oficio_personal.id_oficio_personal)num from oc_oficio_personal WHERE oc_oficio_personal.id_oficio=' . $id_oficio . '');
            if ($num->num == 0) {
                $fecha_salida = $oficios->fecha_salida;
                $fecha_regreso = $oficios->fecha_regreso;
                $departamento = DB::selectOne('select gnral_unidad_personal.id_unidad_persona from gnral_unidad_personal,gnral_personales WHERE gnral_personales.id_personal=gnral_unidad_personal.id_personal and gnral_personales.tipo_usuario=' . $id_usuario . '');
                $departamento = $departamento->id_unidad_persona;
                $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
                $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;
                $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))
                   UNION  select gnral_personales.id_personal,gnral_personales.nombre FROM gnral_personales, adscripcion_personal 
                    WHERE adscripcion_personal.id_personal=gnral_personales.id_personal  and gnral_personales.tipo_usuario=$id_usuario 
                    and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))
                     UNION SELECT gnral_personales.id_personal,gnral_personales.nombre 
                     FROM gnral_personales,adscripcion_personal,gnral_cargos 
                     where adscripcion_personal.id_personal=gnral_personales.id_personal and gnral_cargos.id_cargo=gnral_personales.id_cargo 
                     and adscripcion_personal.id_unidad_persona=$departamento and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))");
                $mensaje = 0;
                return view('comision_oficio.solicitud_comisionados', compact('dependencias_r','estados','personales', 'comisionados','dependencias'))->with(['oficios' => $oficios, 'solicitudes' => $solicitudes, 'lugar_salida' => $lugar_s, 'lugar_regreso' => $lugar_r, 'encontrado' => $encontrado, 'mensaje' => $mensaje]);


            } elseif ($num->num == 1) {
                $departamento = DB::selectOne('select gnral_unidad_personal.id_unidad_persona from gnral_unidad_personal,gnral_personales WHERE gnral_personales.id_personal=gnral_unidad_personal.id_personal and gnral_personales.tipo_usuario=' . $id_usuario . '');
                $departamento = $departamento->id_unidad_persona;
                $fecha_salida = $oficios->fecha_salida;
                $fecha_regreso = $oficios->fecha_regreso;
                $adscripto = DB::selectOne(' SELECT COUNT(adscripcion_personal.id_personal) numero FROM adscripcion_personal,oc_oficio_personal WHERE adscripcion_personal.id_personal=oc_oficio_personal.id_personal and oc_oficio_personal.id_oficio=' . $id_oficio . ' and adscripcion_personal.id_unidad_persona=' . $departamento . '');
                $adscripto = $adscripto->numero;
                if ($adscripto == 1) {
                    $personales = DB::select("SELECT gnral_personales.id_personal,gnral_personales.nombre 
                     FROM gnral_personales,adscripcion_personal,gnral_cargos 
                     where adscripcion_personal.id_personal=gnral_personales.id_personal and gnral_cargos.id_cargo=gnral_personales.id_cargo 
                     and adscripcion_personal.id_unidad_persona=$departamento and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))");
                    $mensaje = 0;
                    return view('comision_oficio.solicitud_comisionados', compact('dependencias_r','estados','personales', 'comisionados','dependencias'))->with(['oficios' => $oficios, 'solicitudes' => $solicitudes, 'lugar_salida' => $lugar_s, 'lugar_regreso' => $lugar_r, 'encontrado' => $encontrado, 'mensaje' => $mensaje]);

                } else {
                    $fecha_salida = $oficios->fecha_salida;
                    $fecha_regreso = $oficios->fecha_regreso;
                    $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
                    $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;
                    $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))
                   UNION  select gnral_personales.id_personal,gnral_personales.nombre FROM gnral_personales, adscripcion_personal 
                    WHERE adscripcion_personal.id_personal=gnral_personales.id_personal  and gnral_personales.tipo_usuario=$id_usuario 
                    and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))");
                    $mensaje = 0;
                    return view('comision_oficio.solicitud_comisionados', compact('dependencias_r','estados','personales', 'comisionados','dependencias'))->with(['oficios' => $oficios, 'solicitudes' => $solicitudes, 'lugar_salida' => $lugar_s, 'lugar_regreso' => $lugar_r, 'encontrado' => $encontrado, 'mensaje' => $mensaje]);
                }
            } else {
                $departamento = DB::selectOne('select gnral_unidad_personal.id_unidad_persona from gnral_unidad_personal,gnral_personales WHERE gnral_personales.id_personal=gnral_unidad_personal.id_personal and gnral_personales.tipo_usuario=' . $id_usuario . '');
                $departamento = $departamento->id_unidad_persona;
                $adscripto = DB::selectOne(' SELECT COUNT(adscripcion_personal.id_personal) numero FROM adscripcion_personal,oc_oficio_personal WHERE adscripcion_personal.id_personal=oc_oficio_personal.id_personal and oc_oficio_personal.id_oficio=' . $id_oficio . ' and adscripcion_personal.id_unidad_persona=' . $departamento . '');
                $adscripto = $adscripto->numero;
                if ($adscripto == 0) {
                    $fecha_salida = $oficios->fecha_salida;
                    $fecha_regreso = $oficios->fecha_regreso;
                    $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
                    $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;
                    $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))
                   UNION  select gnral_personales.id_personal,gnral_personales.nombre FROM gnral_personales, adscripcion_personal 
                    WHERE adscripcion_personal.id_personal=gnral_personales.id_personal  and gnral_personales.tipo_usuario=$id_usuario 
                    and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))");
                    $mensaje = 0;
                    return view('comision_oficio.solicitud_comisionados', compact('dependencias_r','estados','personales', 'comisionados','dependencias'))->with(['oficios' => $oficios, 'solicitudes' => $solicitudes, 'lugar_salida' => $lugar_s, 'lugar_regreso' => $lugar_r, 'encontrado' => $encontrado, 'mensaje' => $mensaje]);

                } else {
                    $departamento = DB::selectOne('select gnral_unidad_personal.id_unidad_persona from gnral_unidad_personal,gnral_personales WHERE gnral_personales.id_personal=gnral_unidad_personal.id_personal and gnral_personales.tipo_usuario=' . $id_usuario . '');
                    $departamento = $departamento->id_unidad_persona;
                    $fecha_salida = $oficios->fecha_salida;
                    $fecha_regreso = $oficios->fecha_regreso;
                    $personales = DB::select("SELECT gnral_personales.id_personal,gnral_personales.nombre 
                     FROM gnral_personales,adscripcion_personal,gnral_cargos 
                     where adscripcion_personal.id_personal=gnral_personales.id_personal and gnral_cargos.id_cargo=gnral_personales.id_cargo 
                     and adscripcion_personal.id_unidad_persona=$departamento and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))");
                    $mensaje = 0;
                    return view('comision_oficio.solicitud_comisionados', compact('dependencias_r','estados','personales', 'comisionados','dependencias'))->with(['oficios' => $oficios, 'solicitudes' => $solicitudes, 'lugar_salida' => $lugar_s, 'lugar_regreso' => $lugar_r, 'encontrado' => $encontrado, 'mensaje' => $mensaje]);

                }

            }
        }
        else {
            $unidad = DB::selectOne('SELECT gnral_unidad_personal.id_unidad_persona 
                from gnral_unidad_personal,gnral_unidad_administrativa,gnral_personales 
                WHERE gnral_unidad_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin 
                and gnral_unidad_personal.id_personal=gnral_personales.id_personal 
                and gnral_personales.tipo_usuario=' . $id_usuario . '');
            $unidad = $unidad->id_unidad_persona;
            $fecha_salida = $oficios->fecha_salida;
            $fecha_regreso = $oficios->fecha_regreso;
            if($unidad == 17)
            {
                $personales = DB::select("SELECT gnral_personales.id_personal, gnral_personales.nombre 
                from gnral_personales,adscripcion_personal WHERE gnral_personales.id_personal=adscripcion_personal.id_personal 
                and adscripcion_personal.id_unidad_persona=$unidad and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal where 
                (CAST(fecha_salida AS DATE) between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )or
               ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0) or
                ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0)) or
               ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0) and (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))  
               UNION SELECT gnral_personales.id_personal, gnral_personales.nombre 
                from gnral_personales,adscripcion_personal WHERE adscripcion_personal.id_personal=gnral_personales.id_personal
                 and gnral_personales.tipo_usuario= $id_usuario and gnral_personales.id_personal 
                 NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))
              UNION   SELECT gnral_personales.id_personal,gnral_personales.nombre FROM gnral_personales,adscripcion_personal,gnral_cargos                                               where adscripcion_personal.id_personal=gnral_personales.id_personal 
              and gnral_cargos.id_cargo=gnral_personales.id_cargo and gnral_personales.id_personal=270
              UNION   SELECT gnral_personales.id_personal,gnral_personales.nombre FROM gnral_personales,adscripcion_personal,gnral_cargos                                               where adscripcion_personal.id_personal=gnral_personales.id_personal 
              and gnral_cargos.id_cargo=gnral_personales.id_cargo and gnral_personales.id_personal=277");
                $mensaje = 0;

            }
            else{
                $personales = DB::select("SELECT gnral_personales.id_personal, gnral_personales.nombre 
                from gnral_personales,adscripcion_personal WHERE gnral_personales.id_personal=adscripcion_personal.id_personal 
                and adscripcion_personal.id_unidad_persona=$unidad and gnral_personales.id_personal NOT IN(select id_personal from oc_oficio_personal where 
                (CAST(fecha_salida AS DATE) between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )or
               ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0) or
                ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0)) or
               ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0) and (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))  
               UNION SELECT gnral_personales.id_personal, gnral_personales.nombre 
                from gnral_personales,adscripcion_personal WHERE adscripcion_personal.id_personal=gnral_personales.id_personal
                 and gnral_personales.tipo_usuario= $id_usuario and gnral_personales.id_personal 
                 NOT IN(select id_personal from oc_oficio_personal 
               where (CAST(fecha_salida AS DATE)  between '$fecha_salida' and  '$fecha_regreso' and estado_oficio=0 )
               or ( CAST(fecha_regreso AS DATE)  between '$fecha_salida' and '$fecha_regreso' and estado_oficio=0)
               or ((CAST(fecha_salida AS DATE)<'$fecha_salida' and estado_oficio=0) and (CAST(fecha_regreso AS DATE)> '$fecha_salida' and estado_oficio=0))
              or ((CAST(fecha_regreso AS DATE)>'$fecha_regreso' and estado_oficio=0)and
              (CAST(fecha_salida AS DATE)< '$fecha_regreso' and estado_oficio=0)))");
                $mensaje = 0;

            }


            return view('comision_oficio.solicitud_comisionados', compact( 'dependencias_r','estados','personales', 'comisionados','dependencias'))->with(['oficios' => $oficios, 'solicitudes' => $solicitudes, 'lugar_salida' => $lugar_s, 'lugar_regreso' => $lugar_r, 'encontrado' => $encontrado, 'mensaje' => $mensaje]);

        }


    }
    public function destroy(Request $request)
    {
        $id_oficio = $request->input("id_oficio_dep");
        $conaut= DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) personal from oc_oficio_personal,oc_oficio_vehiculo where oc_oficio_personal.id_oficio_personal=oc_oficio_vehiculo.id_oficio_personal and oc_oficio_personal.id_oficio='.$id_oficio.'');
        if($conaut->personal >0){
            $personalauto= DB::select('SELECT oc_oficio_personal.id_oficio_personal from oc_vehiculo,oc_oficio_vehiculo,oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_vehiculo.id_vehiculo=oc_oficio_vehiculo.id_vehiculo and oc_oficio_vehiculo.id_oficio_personal=oc_oficio_personal.id_oficio_personal and oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.id_oficio='.$id_oficio.'');
            foreach($personalauto as $personal){
                DB::delete('DELETE FROM oc_oficio_vehiculo WHERE id_oficio_personal='.$personal->id_oficio_personal.'');
                oc_oficio_personal::destroy($personal->id_oficio_personal);

            }
        }
        $sinaut= DB::selectOne('SELECT COUNT(oc_oficio_personal.id_oficio_personal) personal from oc_oficio_personal where  oc_oficio_personal.automovil=1 and  oc_oficio_personal.id_oficio='.$id_oficio.'');
        $sinaut=$sinaut->personal;
        if($sinaut >0){
            $personalsinauto= DB::select('SELECT oc_oficio_personal.id_oficio_personal from oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_oficio_personal.automovil=1 and   oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.id_oficio='.$id_oficio.'');
            foreach($personalsinauto as $personal){
                oc_oficio_personal::destroy($personal->id_oficio_personal);
            }

        }
        DB::delete('DELETE FROM  oc_depend_domicilio WHERE id_oficio='.$id_oficio.'');
        oc_oficio::find($id_oficio)-> delete();
        return redirect('/oficios/solicitud');
    }

    public function comisionadoeliminado($id_oficio_personal)
    {

        $oficio = DB::selectOne(' SELECT oc_oficio_personal.id_oficio_personal,oc_oficio_personal.automovil from oc_oficio_personal where oc_oficio_personal.id_oficio_personal='.$id_oficio_personal.'');
        $oficio=$oficio->automovil;
        if($oficio == 1)
        {
            oc_oficio_personal::destroy($id_oficio_personal);
        }
        if($oficio == 2)
        {
            oc_oficio_personal::destroy($id_oficio_personal);
            DB::delete('DELETE FROM oc_oficio_vehiculo WHERE id_oficio_personal='.$id_oficio_personal.'');
        }

        return back();
    }
    public function auto(Request $request,$id_personal,$id_oficio){

        $oficios=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.fecha_salida,oc_oficio.fecha_regreso from oc_oficio WHERE oc_oficio.id_oficio='.$id_oficio.'');
        $fecha_salida=$oficios->fecha_salida;
        $fecha_regreso=$oficios->fecha_regreso;
if($id_personal == 342)
{
    $automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion in (2,1)") ;
    //$automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=2 and oc_vehiculo.id_vehiculo NOT IN (SELECT DISTINCT oc_oficio_vehiculo.id_vehiculo from oc_oficio_vehiculo WHERE (oc_oficio_vehiculo.fecha_salida<= '$fecha_salida' and oc_oficio_vehiculo.fecha_regreso >= '$fecha_salida') OR (oc_oficio_vehiculo.fecha_regreso<= '$fecha_regreso' AND oc_oficio_vehiculo.fecha_salida>='$fecha_regreso') OR (oc_oficio_vehiculo.fecha_salida>='$fecha_salida' and oc_oficio_vehiculo.fecha_regreso<='$fecha_regreso'))");

}
else {


    $director = DB::selectOne('SELECT COUNT(gnral_unidad_personal.id_personal) numero from gnral_unidad_personal WHERE gnral_unidad_personal.id_personal=' . $id_personal . ' and gnral_unidad_personal.id_unidad_admin=3');
    if ($director->numero == 1) {
        $automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=2 and oc_vehiculo.id_vehiculo NOT IN (SELECT DISTINCT oc_oficio_vehiculo.id_vehiculo from oc_oficio_vehiculo WHERE (oc_oficio_vehiculo.fecha_salida<= '$fecha_salida' and oc_oficio_vehiculo.fecha_regreso >= '$fecha_salida') OR (oc_oficio_vehiculo.fecha_regreso<= '$fecha_regreso' AND oc_oficio_vehiculo.fecha_salida>='$fecha_regreso') OR (oc_oficio_vehiculo.fecha_salida>='$fecha_salida' and oc_oficio_vehiculo.fecha_regreso<='$fecha_regreso'))");

    }
    if ($director->numero == 0) {
        $contralor = DB::selectOne('SELECT COUNT(gnral_unidad_personal.id_personal) numero from gnral_unidad_personal WHERE gnral_unidad_personal.id_personal=' . $id_personal . ' and gnral_unidad_personal.id_unidad_admin=40');
        if ($contralor->numero == 1) {
            $automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=3");
            //$automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=3 and oc_vehiculo.id_vehiculo NOT IN (SELECT DISTINCT oc_oficio_vehiculo.id_vehiculo from oc_oficio_vehiculo WHERE (oc_oficio_vehiculo.fecha_salida<= '$fecha_salida' and oc_oficio_vehiculo.fecha_regreso >= '$fecha_salida') OR (oc_oficio_vehiculo.fecha_regreso<= '$fecha_regreso' AND oc_oficio_vehiculo.fecha_salida>='$fecha_regreso') OR (oc_oficio_vehiculo.fecha_salida>='$fecha_salida' and oc_oficio_vehiculo.fecha_regreso<='$fecha_regreso'))");

        }
        if ($contralor->numero == 0) {
            $automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=1");
            //$automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=1 and oc_vehiculo.id_vehiculo NOT IN (SELECT DISTINCT oc_oficio_vehiculo.id_vehiculo from oc_oficio_vehiculo WHERE (oc_oficio_vehiculo.fecha_salida<= '$fecha_salida' and oc_oficio_vehiculo.fecha_regreso >= '$fecha_salida' and oc_oficio_vehiculo.notificacion =0) OR (oc_oficio_vehiculo.fecha_regreso<= '$fecha_regreso' AND oc_oficio_vehiculo.fecha_salida>='$fecha_regreso' and oc_oficio_vehiculo.notificacion =0) OR (oc_oficio_vehiculo.fecha_salida>='$fecha_salida' and oc_oficio_vehiculo.fecha_regreso<='$fecha_regreso')and oc_oficio_vehiculo.notificacion =0) ");
        }
    }
}
        return response()->json($automoviles);
    }
    public function viatico(Request $request,$id_personal,$id_oficio){
        $id_periodo = Session::get('periodotrabaja');
        $jefesdivision= DB::selectOne('SELECT COUNT(gnral_jefes_periodos.id_personal)num FROM gnral_personales,gnral_jefes_periodos,gnral_carreras,gnral_periodos WHERE gnral_personales.id_personal=gnral_jefes_periodos.id_personal AND gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera and gnral_periodos.id_periodo=gnral_jefes_periodos.id_periodo AND gnral_jefes_periodos.id_periodo='.$id_periodo.' and gnral_jefes_periodos.id_personal='.$id_personal.'');

        if($jefesdivision->num == 1 || $jefesdivision->num == 2 )
          {
            $viaticos= DB::select("select *from oc_respuesta where id_respuesta=1");
           }
        if( $jefesdivision->num == 0){
        $jefedepartamento= DB::selectOne('SELECT COUNT(gnral_unidad_personal.id_personal)num FROM gnral_unidad_personal WHERE gnral_unidad_personal.id_personal='.$id_personal.'');
        if($jefedepartamento->num ==1){
        $viaticos= DB::select("select *from oc_respuesta where id_respuesta=1");
        }
        if($jefedepartamento->num == 0){
       $viaticos= DB::select("select *from oc_respuesta");
        }
       }

        return response()->json($viaticos);
    }
    public function dependencia($id_dependencia){
        //registrar comisionados
       $dependencias= DB::selectOne('SELECT oc_depend_domicilio.*,gnral_municipios.id_municipio,gnral_municipios.id_estado FROM oc_depend_domicilio,gnral_municipios 
   WHERE gnral_municipios.id_municipio=oc_depend_domicilio.id_municipio 
   and oc_depend_domicilio.id_depend_domicilio ='.$id_dependencia.'');
        $estados = Estados::all();
        $municipios= DB::select('SELECT * FROM gnral_municipios WHERE gnral_municipios.id_estado='.$dependencias->id_estado.'');
        return view('comision_oficio.partialsof.edit_dependencia', compact('estados','dependencias','municipios'));

    }
    public function editar_dependencia(Request $request){
        $this->validate($request,[
            'id_oficio' => 'required',
            'id_dependecia_domicilio' => 'required',
            'dependencia' => 'required',
            'domicilio' => 'required',
            'estadss' => 'required',
            'municipios' => 'required',

        ]);
        $id_dependecia_domicilio = $request->input("id_dependecia_domicilio");
        $dependencia = $request->input("dependencia");
        $domicilio = $request->input("domicilio");
        $estados = $request->input("estadss");
        $municipios = $request->input("municipios");
        $id_oficio = $request->input("id_oficio");

        $dependencia_dom=oc_dependencias::find($id_dependecia_domicilio);
        $dependencia_dom->dependencia =$dependencia;
        $dependencia_dom->domicilio =$domicilio;
        $dependencia_dom->id_municipio =$municipios;
        $dependencia_dom->save();
       return back();

    }
    public function  eliminar_dependencia(Request $request)
    {
        $id_dependecia_domicilio = $request->input("id_dependencia");
        DB::delete('DELETE FROM oc_depend_domicilio WHERE id_depend_domicilio='.$id_dependecia_domicilio.'');

        return back();
    }
    public function  insertar_dependencia(Request $request){
        $this->validate($request,[
            'id_oficio' => 'required',
            'dependencia' => 'required',
            'domicilio' => 'required',
            'municipio' => 'required',


        ]);
        $id_oficio = $request->input("id_oficio");
        $dependencia = $request->input("dependencia");
        $domicilio = $request->input("domicilio");
        $municipio = $request->input("municipio");
        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,'id_oficio'=>$id_oficio,'id_municipio'=>$municipio]);
        return back();

    }
    public function  insertar_dependencia_comisionado(Request $request){
        $this->validate($request,[
            'id_oficio' => 'required',
            'dependencia' => 'required',
            'domicilio' => 'required',
            'municipioss' => 'required',


        ]);
        $id_oficio = $request->input("id_oficio");
        $dependencia = $request->input("dependencia");
        $domicilio = $request->input("domicilio");
        $municipio = $request->input("municipioss");
        DB:: table('oc_depend_domicilio')->insert(['dependencia'=>$dependencia,'domicilio'=>$domicilio,'id_oficio'=>$id_oficio,'id_municipio'=>$municipio]);
        return back();

    }
    public function  modificaregistrados($id_oficio){
        $numeross=$id_oficio;
        return redirect()->route('personalcomisionado', $numeross);
    }
    public function modificaroficio_aceptado($id_oficio_personal){
        $estados = Estados::all();
        $ofic=DB::selectOne('SELECT * FROM oc_oficio_personal WHERE id_oficio_personal = '.$id_oficio_personal.' ORDER BY id_oficio DESC');
       $id_oficio=$ofic->id_oficio;
        $encontrado= DB::selectOne('SELECT oc_oficio.id_oficio,1 numero FROM oc_oficio,oc_oficio_personal WHERE oc_oficio_personal.id_oficio=oc_oficio.id_oficio AND oc_oficio.id_oficio='.$id_oficio.' UNION Select oc_oficio.id_oficio,0 numero from oc_oficio where oc_oficio.id_oficio='.$id_oficio.' and not exists (select oc_oficio_personal.id_oficio from oc_oficio_personal where oc_oficio.id_oficio = oc_oficio_personal.id_oficio)');
        $encontrado=$encontrado->numero;
        $dependencias_r=DB::selectOne('SELECT count(oc_depend_domicilio.id_depend_domicilio) dependenciasr  FROM oc_depend_domicilio WHERE oc_depend_domicilio.id_oficio ='.$id_oficio.'');
        $solicitudes=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.desc_comision,
    oc_oficio.fecha_salida,oc_oficio.fecha_regreso,oc_oficio.hora_s,oc_oficio.hora_r 
    from oc_oficio WHERE oc_oficio.id_oficio='.$id_oficio.'');
        $dependencias= DB::select('SELECT oc_depend_domicilio.*,gnral_municipios.nombre_municipio,gnral_estados.nombre_estado FROM oc_depend_domicilio,gnral_estados,gnral_municipios WHERE oc_depend_domicilio.id_municipio=gnral_municipios.id_municipio and gnral_municipios.id_estado=gnral_estados.id_estado and oc_depend_domicilio.id_oficio= '.$id_oficio.'');
        $lugar_s=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar WHERE oc_oficio.id_lugar_salida=oc_lugar.id_lugar and oc_oficio.id_oficio='.$id_oficio.'');
        $lugar_r=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar WHERE oc_oficio.id_lugar_entrada=oc_lugar.id_lugar and oc_oficio.id_oficio='.$id_oficio.'');
        $comisionados=DB::select('SELECT oc_vehiculo.modelo,oc_vehiculo.placas,oc_oficio_vehiculo.licencia,gnral_personales.nombre,abreviaciones.titulo,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_personal,oc_oficio_personal.id_oficio_personal from oc_vehiculo,oc_oficio_vehiculo,oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_vehiculo.id_vehiculo=oc_oficio_vehiculo.id_vehiculo and oc_oficio_vehiculo.id_oficio_personal=oc_oficio_personal.id_oficio_personal and oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.id_oficio='.$id_oficio.' and oc_oficio_personal.automovil=2 UNION SELECT 0,0,0,gnral_personales.nombre,abreviaciones.titulo,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_personal,oc_oficio_personal.id_oficio_personal from oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.automovil=1 and oc_oficio_personal.id_oficio='.$id_oficio.'');
        $oficios=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.fecha_salida,oc_oficio.fecha_regreso from oc_oficio WHERE oc_oficio.id_oficio='.$id_oficio.'');




            return view('comision_oficio.modificar_oficio_aceptado', compact( 'dependencias_r', 'comisionados','dependencias','estados'))->with(['oficios' => $oficios, 'solicitudes' => $solicitudes, 'lugar_salida' => $lugar_s, 'lugar_regreso' => $lugar_r, 'encontrado' => $encontrado]);



    }
    public function editar_comisionado($id_comisionado){
        $comisionado=DB::selectOne('SELECT oc_oficio_personal.*,gnral_personales.nombre FROM oc_oficio_personal,gnral_personales WHERE gnral_personales.id_personal=oc_oficio_personal.id_personal and oc_oficio_personal.id_oficio_personal='.$id_comisionado.'');
        $director = DB::selectOne('SELECT COUNT(gnral_unidad_personal.id_personal) numero from gnral_unidad_personal WHERE gnral_unidad_personal.id_personal=' .$comisionado->id_personal. ' and gnral_unidad_personal.id_unidad_admin=3');
        if ($director->numero == 1) {
            $automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=2");

        }
        if ($director->numero == 0) {
            $contralor = DB::selectOne('SELECT COUNT(gnral_unidad_personal.id_personal) numero from gnral_unidad_personal WHERE gnral_unidad_personal.id_personal=' . $comisionado->id_personal. ' and gnral_unidad_personal.id_unidad_admin=40');
            if ($contralor->numero == 1) {
                $automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=3");
                //$automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=3 and oc_vehiculo.id_vehiculo NOT IN (SELECT DISTINCT oc_oficio_vehiculo.id_vehiculo from oc_oficio_vehiculo WHERE (oc_oficio_vehiculo.fecha_salida<= '$fecha_salida' and oc_oficio_vehiculo.fecha_regreso >= '$fecha_salida') OR (oc_oficio_vehiculo.fecha_regreso<= '$fecha_regreso' AND oc_oficio_vehiculo.fecha_salida>='$fecha_regreso') OR (oc_oficio_vehiculo.fecha_salida>='$fecha_salida' and oc_oficio_vehiculo.fecha_regreso<='$fecha_regreso'))");

            }
            if ($contralor->numero == 0) {
                $automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=1");
                //$automoviles = DB::select("SELECT * from oc_vehiculo WHERE oc_vehiculo.id_asignacion=1 and oc_vehiculo.id_vehiculo NOT IN (SELECT DISTINCT oc_oficio_vehiculo.id_vehiculo from oc_oficio_vehiculo WHERE (oc_oficio_vehiculo.fecha_salida<= '$fecha_salida' and oc_oficio_vehiculo.fecha_regreso >= '$fecha_salida' and oc_oficio_vehiculo.notificacion =0) OR (oc_oficio_vehiculo.fecha_regreso<= '$fecha_regreso' AND oc_oficio_vehiculo.fecha_salida>='$fecha_regreso' and oc_oficio_vehiculo.notificacion =0) OR (oc_oficio_vehiculo.fecha_salida>='$fecha_salida' and oc_oficio_vehiculo.fecha_regreso<='$fecha_regreso')and oc_oficio_vehiculo.notificacion =0) ");
            }
        }
        $id_periodo = Session::get('periodotrabaja');
        $jefesdivision= DB::selectOne('SELECT COUNT(gnral_jefes_periodos.id_personal)num FROM gnral_personales,gnral_jefes_periodos,gnral_carreras,gnral_periodos WHERE gnral_personales.id_personal=gnral_jefes_periodos.id_personal AND gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera and gnral_periodos.id_periodo=gnral_jefes_periodos.id_periodo AND gnral_jefes_periodos.id_periodo='.$id_periodo.' and gnral_jefes_periodos.id_personal='.$comisionado->id_personal.'');

        if($jefesdivision->num == 1 || $jefesdivision->num == 2)
        {
            $respuestas= DB::select("select *from oc_respuesta where id_respuesta=1");
        }
        if( $jefesdivision->num == 0){
            $jefedepartamento= DB::selectOne('SELECT COUNT(gnral_unidad_personal.id_personal)num FROM gnral_unidad_personal WHERE gnral_unidad_personal.id_personal='.$comisionado->id_personal.'');
            if($jefedepartamento->num ==1){
                $respuestas= DB::select("select *from oc_respuesta where id_respuesta=1");
            }
            if($jefedepartamento->num == 0){
                $respuestas= DB::select("select *from oc_respuesta");
            }
        }
        $respuestass=DB::select('SELECT * FROM oc_respuesta');
        $con_auto=$comisionado->automovil;
        if($con_auto == 2){
           $auto=2;
            $comi=$comisionado->id_oficio_personal;
            $auto_comisionado=DB::selectOne('SELECT * FROM oc_oficio_vehiculo WHERE id_oficio_personal ='.$comi.'');


        }
        else{
          $auto=1;

          $auto_comisionado=0;

        }
        return view('comision_oficio.partialsof.edit_comisionado', compact( 'auto_comisionado','comisionado','respuestas','respuestass','auto','automoviles'));
    }
    public function  modificar_comisionado(Request $request){
        $this->validate($request,[
            'id_oficio_comisionado' => 'required',
            'viaticos' => 'required',
            'automoviles' => 'required',


        ]);
        $id_oficio_comisionado = $request->input("id_oficio_comisionado");
        $oficio=DB::selectOne('SELECT  *from oc_oficio_personal where id_oficio_personal= '.$id_oficio_comisionado.'');
$ofici=$oficio->id_oficio;
        $oficio=DB::selectOne(' SELECT * FROM oc_oficio WHERE id_oficio = '.$ofici.'');
$fecha_salida=$oficio->fecha_salida;
        $fecha_regreso=$oficio->fecha_regreso;

        $viaticos = $request->input("viaticos");
        $automoviles = $request->input("automoviles");
       if($automoviles == 2){
           $con_auto=DB::selectOne('SELECT count(id_oficio_personal) num from oc_oficio_vehiculo where id_oficio_personal= '.$id_oficio_comisionado.'');
           $automovil = $request->input("automovil");
           $licencia = $request->input("licencia");
           if($con_auto->num ==1)
           {

               DB::update("UPDATE oc_oficio_personal SET viaticos= $viaticos,automovil=$automoviles,fecha_salida=$fecha_salida,fecha_regreso=$fecha_regreso WHERE oc_oficio_personal.id_oficio_personal= $id_oficio_comisionado");
               DB::update("UPDATE oc_oficio_vehiculo SET id_vehiculo =$automovil,licencia =$licencia,fecha_salida=$fecha_salida,fecha_regreso=$fecha_regreso  WHERE oc_oficio_vehiculo.id_oficio_personal = $id_oficio_comisionado");

           }
           else{
               DB::update("UPDATE oc_oficio_personal SET viaticos= $viaticos,automovil=$automoviles WHERE oc_oficio_personal.id_oficio_personal= $id_oficio_comisionado");
               DB:: table('oc_oficio_vehiculo')->insert(['id_vehiculo'=>$automovil,'id_oficio_personal'=>$id_oficio_comisionado,'licencia'=>$licencia,'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso]);


           }


       }
       else{
           $con_auto=DB::selectOne('SELECT count(id_oficio_personal) num from oc_oficio_vehiculo where id_oficio_personal= '.$id_oficio_comisionado.'');
           if($con_auto->num ==1)
           {
               DB::update("UPDATE oc_oficio_personal SET viaticos= $viaticos,automovil=$automoviles,fecha_salida=$fecha_salida,fecha_regreso=$fecha_regreso WHERE oc_oficio_personal.id_oficio_personal= $id_oficio_comisionado");

               DB::delete('DELETE FROM oc_oficio_vehiculo WHERE id_oficio_personal='.$id_oficio_comisionado.'');
           }
           else{
               DB::update("UPDATE oc_oficio_personal SET viaticos= $viaticos,automovil=$automoviles,fecha_salida=$fecha_salida,fecha_regreso=$fecha_regreso WHERE oc_oficio_personal.id_oficio_personal= $id_oficio_comisionado");

           }
       }
       return back();


    }

}