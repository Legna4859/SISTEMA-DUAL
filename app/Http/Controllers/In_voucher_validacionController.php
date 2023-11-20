<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rules\In;
use PhpParser\Node\Stmt\While_;
use App\In_voucher_pago;
use Session;


class In_voucher_validacionController extends Controller
{
    public function index()
    {
        $periodo_ingles=Session::get('periodo_ingles');

        $alumnos=DB::select('SELECT gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno, in_voucher_pago.id_voucher, in_voucher_pago.id_usuario, in_voucher_pago.voucher, in_voucher_pago.linea_captura, in_voucher_pago.fecha_cambio, in_voucher_pago.id_estado_carga_voucher, in_voucher_pago.id_estado_valida_voucher, in_voucher_pago.id_periodo_ingles, in_voucher_pago.id_tipo_voucher
        FROM users, gnral_alumnos, in_voucher_pago, in_periodos
        WHERE users.id = gnral_alumnos.id_usuario
        AND in_voucher_pago.id_usuario = users.id
        AND in_voucher_pago.id_periodo_ingles = in_periodos.id_periodo_ingles
        AND in_voucher_pago.id_periodo_ingles = '.$periodo_ingles.' 
        AND in_voucher_pago.id_estado_valida_voucher = 1');

        return view('ingles.cargas_ingles.vouchers_validar', compact('alumnos'));
    }

    public function vouchers_aceptados()
    {
        $periodo_ingles=Session::get('periodo_ingles');



        $estado_voucher_excell=DB::selectOne('SELECT COUNT(id_estado_voucher_aut_excel) contar 
        from in_estado_voucher_aut_excel where id_periodo_ingles ='.$periodo_ingles.'');
        if($estado_voucher_excell->contar == 0){
            $estado_voucher_excell=0;
            $alumnos=DB::select('SELECT gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno, in_voucher_pago.id_voucher, in_voucher_pago.id_usuario, in_voucher_pago.voucher, in_voucher_pago.linea_captura, in_voucher_pago.fecha_cambio, in_voucher_pago.id_estado_carga_voucher, in_voucher_pago.id_estado_valida_voucher, in_voucher_pago.id_periodo_ingles,in_voucher_pago.id_tipo_voucher
        FROM users, gnral_alumnos, in_voucher_pago, in_periodos
        WHERE users.id = gnral_alumnos.id_usuario
        AND in_voucher_pago.id_usuario = users.id
        AND in_voucher_pago.id_periodo_ingles = in_periodos.id_periodo_ingles
        AND in_voucher_pago.id_periodo_ingles = '.$periodo_ingles.' 
        AND in_voucher_pago.id_estado_valida_voucher = 2');
        }else{
            $estado_voucher_excell=1;
            $alumnos=DB::select('SELECT gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno,
       in_voucher_pago.id_voucher, in_voucher_pago.id_usuario, in_voucher_pago.voucher, in_voucher_pago.linea_captura, in_voucher_pago.fecha_cambio, in_voucher_pago.id_estado_carga_voucher, in_voucher_pago.id_estado_valida_voucher,in_voucher_pago.estado_agregacion_excel, in_voucher_pago.id_periodo_ingles,in_voucher_pago.id_tipo_voucher
        FROM users, gnral_alumnos, in_voucher_pago, in_periodos
        WHERE users.id = gnral_alumnos.id_usuario
        AND in_voucher_pago.id_usuario = users.id
        AND in_voucher_pago.id_periodo_ingles = in_periodos.id_periodo_ingles
        AND in_voucher_pago.id_periodo_ingles = '.$periodo_ingles.'
        AND in_voucher_pago.id_estado_valida_voucher = 2 
        ORDER BY in_voucher_pago.estado_agregacion_excel ASC');
        }

        return view('ingles.cargas_ingles.vouchers_aceptados', compact('alumnos','estado_voucher_excell'));
    }

    public function vouchers_rechazados()
    {
        $periodo_ingles=Session::get('periodo_ingles');

        $alumnos=DB::select('SELECT gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno, in_voucher_pago.id_voucher, in_voucher_pago.id_usuario, in_voucher_pago.voucher, in_voucher_pago.linea_captura, in_voucher_pago.fecha_cambio, in_voucher_pago.id_estado_carga_voucher, in_voucher_pago.id_estado_valida_voucher, in_voucher_pago.id_periodo_ingles
        FROM users, gnral_alumnos, in_voucher_pago, in_periodos
        WHERE users.id = gnral_alumnos.id_usuario
        AND in_voucher_pago.id_usuario = users.id
        AND in_voucher_pago.id_periodo_ingles = in_periodos.id_periodo_ingles
        AND in_voucher_pago.id_periodo_ingles = '.$periodo_ingles.' 
        AND in_voucher_pago.id_estado_valida_voucher = 3');

        return view('ingles.cargas_ingles.vouchers_rechazados', compact('alumnos'));
    }

    public function maximo_grupo_alumnos()
    {
        $periodo_ingles=Session::get('periodo_ingles');
        $estado_maximo = DB::selectOne('SELECT COUNT(id_maximo_grupo_ingles) contar FROM in_maximo_grupo_ingles WHERE id_periodo_ingles = '.$periodo_ingles.'');
        $periodo = DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles='.$periodo_ingles.'');

        if ($estado_maximo->contar == 0) {
            $estado_maximo = 0;
            $maximo_estudiantes = 0;
        }
        else{
            $estado_maximo = 1;
            $maximo_estudiantes = DB::selectOne('SELECT * FROM in_maximo_grupo_ingles WHERE id_periodo_ingles = '.$periodo_ingles.'');
        }
        return view('ingles.cargas_ingles.maximo_grupo_alumnos', compact('estado_maximo','periodo','maximo_estudiantes'));
    }

    public function destroy($id_voucher)
    {
        $alumno = In_voucher_pago::find($id_voucher);
        $alumno->delete();
        return redirect()->back();
    }

    public function aceptar_voucher ($id_voucher)
    {
        $alumno = In_voucher_pago::find($id_voucher);
        $alumno->id_estado_valida_voucher = 2;
        $alumno->update();
        return redirect()->back();
    }

    public function rechazar_voucher (Request $request, $id_voucher)
    {
        $alumno = In_voucher_pago::find($id_voucher);
        $alumno->id_estado_valida_voucher = 3;
        $alumno->comentario =$request->comentario;
        $alumno->update();
        return redirect()->back();
    }

    public function modificar_voucher_ingles ($id_voucher)
    {
      $periodo_ingles=Session::get('periodo_ingles');
      $modificar_voucher =  DB::selectOne('SELECT nombre, apaterno,amaterno,cuenta,id_voucher,id_alumno FROM gnral_alumnos, 
        in_voucher_pago WHERE gnral_alumnos.id_usuario = in_voucher_pago.id_usuario AND in_voucher_pago.id_voucher = '.$id_voucher.'');
      return view ('ingles.departamento.partials_enviar_mod', compact('modificar_voucher'));
       
    }

    public function guardar_maximo_grupo_alumnos(Request $request)
    {
        $num_max_alumnos = $request->input('num_max_alumnos');
        $periodo_ingles=Session::get('periodo_ingles');
        //dd($request);
        DB::table('in_maximo_grupo_ingles')->insert([
            'id_periodo_ingles' => $periodo_ingles,
            'num_maximo_alumnos' =>$num_max_alumnos,
        ]);

        return back();
    }

    public function guardar_editar_boton(Request $request)
    {
        $num_max_alumnos = $request->input('num_max_alumnos');
          $periodo_ingles=Session::get('periodo_ingles');
        
         DB::table('in_maximo_grupo_ingles')
            ->where('id_periodo_ingles',$periodo_ingles)
            ->update([
                'num_maximo_alumnos'=>$num_max_alumnos,
        ]);
            return back();
    }
    public function guardar_aceptacion_excel_voucher(Request $request){
        $hoy = date("Y-m-d H:i:s");
        $periodo_ingles=Session::get('periodo_ingles');

            DB::table('in_voucher_pago')
                ->where('id_periodo_ingles',$periodo_ingles)
                ->where('id_estado_valida_voucher',2)
                ->where('estado_agregacion_excel',0)
                ->update([
                    'estado_agregacion_excel'=>1,
                    ]);
        DB::table('in_estado_voucher_aut_excel')->insert([
            'estado' => 1,
            'id_periodo_ingles' => $periodo_ingles,
            'fecha_registro'=>$hoy
        ]);

        return back();
    }
    public function ver_registro_voucher($id_voucher){
        $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno,
       in_voucher_pago.id_voucher, in_voucher_pago.id_usuario, in_voucher_pago.voucher, in_voucher_pago.linea_captura, in_voucher_pago.fecha_cambio, in_voucher_pago.id_estado_carga_voucher, in_voucher_pago.id_estado_valida_voucher,in_voucher_pago.estado_agregacion_excel, in_voucher_pago.id_periodo_ingles,in_voucher_pago.id_tipo_voucher
        FROM users, gnral_alumnos, in_voucher_pago, in_periodos
        WHERE users.id = gnral_alumnos.id_usuario
        AND in_voucher_pago.id_usuario = users.id
        AND in_voucher_pago.id_periodo_ingles = in_periodos.id_periodo_ingles
        AND in_voucher_pago.id_voucher ='.$id_voucher.'');

        return view('ingles.cargas_ingles.registro_voucher_alumno',compact('alumno'));

    }
    public function guardar_reg_alumno_excel_voucher(Request $request, $id_voucher){
        DB::table('in_voucher_pago')
            ->where('id_voucher',$id_voucher)
            ->update([
                'estado_agregacion_excel'=>1,
            ]);
        return back();
    }
    public function guardar_agregar_pendi_excel(){
        $periodo_ingles=Session::get('periodo_ingles');

        DB::table('in_voucher_pago')
            ->where('id_periodo_ingles',$periodo_ingles)
            ->where('id_estado_valida_voucher',2)
            ->where('estado_agregacion_excel',0)
            ->update([
                'estado_agregacion_excel'=>1,
            ]);
        return back();
    }

}
