<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\In_voucher_pago;


use Illuminate\Validation\Rule;
use Session;

class In_voucher_pagoController extends Controller
{
    public function index()
    {
        $periodo_ingles=Session::get('periodo_ingles');
        $num_veces_usado = 0;
        $ruta = 0;
        $voucher = 0;
        $dato_voucher = 0;
        //obtener el usuario
        $id_usuario = Session::get('usuario_alumno');
        //obetener la fecha del sistema
        //$fecha = Carbon::now();

        //esta para saber que pantalla se le mostrará al usuario si ya subio o no ha subido su baucher
       /* $contar = DB::table('in_voucher_pago')
            ->join('users', 'users.id', '=', 'in_voucher_pago.id_usuario')
            ->where('in_voucher_pago.id_usuario', '=', $id_usuario)
            ->where('in_voucher_pago.id_periodo_ingles','=', $periodo_ingles)
            ->select(DB::raw('count(in_voucher_pago.id_estado_carga_voucher) as total'))
            ->get();
       */

        $contar = DB::selectOne('SELECT count(id_voucher) total 
        from in_voucher_pago where id_usuario = '.$id_usuario.' and id_periodo_ingles = '.$periodo_ingles.' ');
        //dd($contar);

        //este se hace ya que al principio no hay ningun registro en la tabla y si no marca error
        if($contar->total == 0)
        {
            $id_estado_carga_voucher = 0;
        }
        //ya hay registros y comprueba si ya subieron (1) o si no (0)
        else
        {
            $id_estado_carga_voucher = 1;

            //obtiene el estado de la carga del baucher
          /*  $id_estado_carga_voucher = DB::table('in_voucher_pago')
                ->join('users', 'users.id', '=', 'in_voucher_pago.id_usuario')
                ->where('in_voucher_pago.id_usuario', '=', $id_usuario)
                ->where('in_voucher_pago.id_periodo_ingles','=', $periodo_ingles)
                ->select('in_voucher_pago.id_estado_carga_voucher as id_estado_carga_voucher')
                ->get();
          */
            //dd($id_estado_carga_voucher);
           // $id_estado_carga_voucher=$id_estado_carga_voucher[0]->id_estado_carga_voucher;

            //obtiene la ruta del pdf del usuario
           /* $voucher = DB::table('in_voucher_pago')
                ->join('users', 'users.id', '=', 'in_voucher_pago.id_usuario')
                ->where('in_voucher_pago.id_usuario', '=', $id_usuario)
                ->where('in_voucher_pago.id_periodo_ingles','=', $periodo_ingles)
                ->select('in_voucher_pago.voucher as voucher')
                ->get();
           */
            $voucher = DB::selectOne('SELECT *from in_voucher_pago where id_usuario = '.$id_usuario.' and id_periodo_ingles = '.$periodo_ingles.' ');
            $ruta=$voucher->voucher;

            $dato_voucher = DB::selectOne('SELECT * FROM in_voucher_pago WHERE id_usuario = '.$id_usuario.' AND id_periodo_ingles = '.$periodo_ingles.'');
            //dd($dato_voucher);
        }

        $contar_periodo_ingles = DB::selectOne('SELECT COUNT(id_periodo_ingles) contar FROM in_periodos where id_periodo_ingles = '.
            $periodo_ingles.' and estado_actual = 1');
        if($contar_periodo_ingles->contar == 0){
            $estado_periodo=0;
        }
        else{
            $estado_periodo=1;
        }

        return view('ingles.cargas_ingles.cargar_voucher_pago', compact('id_estado_carga_voucher', 'ruta','estado_periodo','dato_voucher'));
    }

    public function create()
    {
        return view("ingles.cargas_ingles.cargar_voucher_pago");
    }

    public function store(Request $request)
    {



            //obtener usuario
            $id_usuario = Session::get('usuario_alumno');
            //obtener periodo
            $periodo_ingles=Session::get('periodo_ingles');
            //$ruta ="/ingles_horarios/cargar_baucher_pago";

            $numero_cuenta_in = DB::selectOne('SELECT gnral_alumnos.cuenta FROM gnral_alumnos WHERE id_usuario ='.$id_usuario.'');
            $numero_cuenta_in = $numero_cuenta_in->cuenta;

            $newvoucher = new In_voucher_pago();

            if($request->hasFile('voucher')) {
                $file = $request->file('voucher');
                $destinationPath = 'vouchers_ingles';
                $filename = $numero_cuenta_in . '_' . $periodo_ingles . '_' . $file->getClientOriginalName();
                $request->file('voucher')->move($destinationPath, $filename);
                $newvoucher->voucher = $destinationPath . '/'. $filename;
            }

            $newvoucher->id_usuario = $id_usuario;
            $newvoucher->linea_captura =$request->linea_captura;
            $newvoucher->fecha_cambio = $request->fecha_cambio;
            $newvoucher->id_estado_carga_voucher = 1;
            $newvoucher->id_estado_valida_voucher = 1;
            $newvoucher->id_periodo_ingles = $periodo_ingles;
            $newvoucher->num_veces_usado = 1;
            $newvoucher->id_tipo_voucher = $request->id_tipo_voucher;

            $newvoucher->save();

            //return view("ingles.cargas_ingles.cargar_baucher_pago", compact('id_estado_carga_baucher','ruta'));
            return redirect()->action('In_voucher_pagoController@index');



    }

    public function show(In_voucher_pago $in_voucher_pago)
    {

    }

    public function edit(In_voucher_pago $in_voucher_pago)
    {

    }

    public function update(Request $request, In_voucher_pago $in_voucher_pago)
    {

    }

    public function destroy(In_voucher_pago $in_voucher_pago)
    {

    }

    public function cargar_voucher_modificar(Request $request, $id_voucher)
    {
        //dd($request);
        $fecha_cambio_mod = $request->input("fecha_cambio_mod");
        $linea_captura_mod = $request->input("linea_captura_mod");
        $id_tipo_voucher_mod = $request->input("id_tipo_voucher_mod");
        $periodo_ingles=Session::get('periodo_ingles');

        $registro_voucher= DB::selectOne('SELECT gnral_alumnos.cuenta, in_voucher_pago.* 
        from gnral_alumnos, in_voucher_pago where gnral_alumnos.id_usuario = in_voucher_pago.id_usuario 
        and in_voucher_pago.id_voucher = '.$id_voucher.'');


        if($request->hasFile('voucher_mod')) {
            $file = $request->file('voucher_mod');
            $destinationPath = 'vouchers_ingles';
            $filename = $registro_voucher->cuenta. '_' . $periodo_ingles . '_' . $file->getClientOriginalName();
            $uploadSuccess = $request->file('voucher_mod')->move($destinationPath, $filename);
            $ruta= $destinationPath . '/'. $filename;
        }


        DB::table('in_voucher_pago')
        ->where('id_voucher',$id_voucher)
        ->update([
            'fecha_cambio' => $fecha_cambio_mod,
            'linea_captura' => $linea_captura_mod,
            'id_tipo_voucher' => $id_tipo_voucher_mod,
            'id_estado_valida_voucher' => 1,
            'voucher' => $ruta
        ]);

        return back();
    }
    public function ver_calificacion_ingles_alumno()
    {
        $periodo_ingles=Session::get('periodo_ingles');
        $periodo = DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles='.$periodo_ingles.'');
        $id_usuario = Session::get('usuario_alumno');
        $alumnoscal = DB::selectOne('SELECT * FROM gnral_alumnos WHERE gnral_alumnos.id_usuario = '.$id_usuario.'');
        //dd($alumnoscal);
        $ver_calificacion = 
            DB::selectOne('SELECT COUNT(in_validar_carga.id_validar_carga) contar 
                FROM in_validar_carga, in_carga_academica_ingles, in_evaluar_calificacion 
                    WHERE in_validar_carga.id_alumno = in_carga_academica_ingles.id_alumno 
                AND in_validar_carga.id_periodo = in_carga_academica_ingles.id_periodo_ingles
                AND in_validar_carga.id_periodo = '.$periodo_ingles.' 
                AND in_evaluar_calificacion.id_carga_ingles = in_carga_academica_ingles.id_carga_ingles
                AND in_evaluar_calificacion.id_unidad = 4 
                AND in_validar_carga.id_alumno = '.$alumnoscal->id_alumno.'');


            if ($ver_calificacion->contar==0) 
            {
                $estado_calificacion_ingles = 0;
                $ver_estado_cal=0;
               
            }
            else
            {
                $estado_calificacion_ingles = 1;
                
                 $ver_estado_cal = 
                DB::select('SELECT in_evaluar_calificacion.* 
                    FROM in_evaluar_calificacion, in_carga_academica_ingles 
                    WHERE in_carga_academica_ingles.id_alumno = '.$alumnoscal->id_alumno.' 
                    AND in_carga_academica_ingles.id_carga_ingles = in_evaluar_calificacion.id_carga_ingles 
                    AND in_carga_academica_ingles.id_periodo_ingles = '.$periodo_ingles.'');
            }
            //dd($ver_estado_cal);
            return view ('ingles.ver_cal_alumno_ingles',compact('alumnoscal','ver_calificacion','periodo','estado_calificacion_ingles','ver_estado_cal'));

    }
    public function imprimir_calificacion_ingles_alumno ($id_alumno)
    {
        dd($id_alumno);
    }

    public function ver_calificacion_ingles_coordinador()
    {
        $periodo_ingles=Session::get('periodo_ingles');
        $periodo = DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles='.$periodo_ingles.'');
        $id_usuario = Session::get('usuario_alumno');
        $carreras =DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();

            return view ('ingles.departamento.ver_cal_coordinador_ingles',compact('periodo','carreras'));
    }

    public function mostrar_calificaciones_coordinador($id_carrera)
    {
        $periodo_ingles=Session::get('periodo_ingles');
        $periodo = DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles='.$periodo_ingles.'');
        $mostrar_carreras = DB::selectOne('SELECT * FROM `gnral_carreras` WHERE id_carrera = '.$id_carrera.'');
        $carreras =DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar_estado_calificacion =
        DB::selectOne('SELECT COUNT(in_validar_carga.id_validar_carga) contar 
                FROM in_validar_carga, in_carga_academica_ingles, in_evaluar_calificacion 
                WHERE in_validar_carga.id_alumno = in_validar_carga.id_alumno 
                AND in_carga_academica_ingles.id_periodo_ingles = in_carga_academica_ingles.id_periodo_ingles 
                AND in_validar_carga.id_periodo = '.$periodo_ingles.' 
                AND in_evaluar_calificacion.id_carga_ingles = in_carga_academica_ingles.id_carga_ingles
                AND in_evaluar_calificacion.id_unidad = 4');
        //dd($mostrar_estado_calificacion);
        if ($mostrar_estado_calificacion->contar == 0) 
        {
            $estado_cal_ingles_coordinador = 0;
            $alumnos_cal = 0;
        }
        else
        {
            $estado_cal_ingles_coordinador = 1;
            $alumnos_cal = 
            DB::select('SELECT gnral_alumnos.id_alumno, gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno
                FROM gnral_alumnos, in_carga_academica_ingles, in_evaluar_calificacion,in_validar_carga
                WHERE gnral_alumnos.id_alumno = in_validar_carga.id_alumno
                AND in_validar_carga.id_alumno = in_carga_academica_ingles.id_alumno
                AND in_validar_carga.id_periodo = in_carga_academica_ingles.id_periodo_ingles
                AND in_validar_carga.id_estado = 2
                AND in_validar_carga.id_periodo = '.$periodo_ingles.'
                AND in_carga_academica_ingles.id_carga_ingles = in_evaluar_calificacion.id_carga_ingles
                AND in_evaluar_calificacion.id_unidad = 4
                AND gnral_alumnos.id_carrera = '.$id_carrera.'');
            //dd($alumnos_cal);
        }
        return view ('ingles.departamento.mostrar_calificacion_ingles_coordinador',compact('mostrar_estado_calificacion','alumnos_cal','estado_cal_ingles_coordinador','periodo','carreras','mostrar_carreras'));
    }

}


