<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_registro_juradoController extends Controller
{
    public function otraf(){
        $id_usuario = Session::get('usuario_alumno');
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_usuario` = '.$id_usuario.'');
        $id_alumno=$alumno->id_alumno;
        $estado_fecha=DB::selectOne('SELECT COUNT(id_fecha_jurado_alumn) contar from ti_fecha_jurado_alumn where id_alumno='.$id_alumno.'');
        $estado_fecha=$estado_fecha->contar;
        if($estado_fecha == 0) {
            $estado = 0;
        }
        else{
            $estado=1;
        }
        return view('titulacion.alumno_titulacion.tercera_etapa.consultar_fecha_titulacion', compact('estado'));

    }
    public function index(){

        $id_usuario = Session::get('usuario_alumno');
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_usuario` = '.$id_usuario.'');
        $id_alumno=$alumno->id_alumno;
        $estado_fecha=DB::selectOne('SELECT COUNT(id_fecha_jurado_alumn) contar from ti_fecha_jurado_alumn where  id_horarios_dias > 0 and  id_alumno='.$id_alumno.' and id_autorizar_agendar_jurado =1');
        $estado_fecha=$estado_fecha->contar;
        $estado_jurado=0;
        $presidente=0;
        $dato_presidente=0;
        $secretario=0;
        $dato_secretario=0;
        $vocal=0;
        $dato_vocal=0;
        $suplente=0;
        $dato_suplente=0;





        if($estado_fecha == 0){
            $estado=0;
            $horarios=DB::select('SELECT * FROM `ti_horarios_dias` ');
            $registro_fecha="";
            $salas=DB::select('SELECT * FROM `ti_sala` WHERE `id_estado` = 1  ');

            //dd($salas);

        }else{
            $salas=DB::select('SELECT * FROM `ti_sala` WHERE `id_estado` =1 ');
            $estado=1;
            $horarios=DB::select('SELECT * FROM `ti_horarios_dias` ');
            $registro_fecha=DB::selectOne('SELECT ti_fecha_jurado_alumn.*,ti_horarios_dias.horario_dia FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias=ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');




            /*
            $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo and gnral_personales.id_personal NOT IN(SELECT ti_jurado_alumno.id_personal from ti_jurado_alumno,ti_fecha_jurado_alumn 
                   where ti_jurado_alumno.id_fecha_jurado_alumn=ti_fecha_jurado_alumn.id_fecha_jurado_alumn and
                         ti_fecha_jurado_alumn.fecha_titulacion=$registro_fecha->fecha_titulacion and ti_fecha_jurado_alumn.id_horarios_dias=$registro_fecha->id_horarios_dias )");
            */

            $estado_jurado=DB::selectOne('SELECT COUNT(id_jurado_alumno) contar from ti_jurado_alumno where id_alumno='.$id_alumno.'');
            $estado_jurado=$estado_jurado->contar;

            if($estado_jurado == 0){
                $estado_jurado=0;

            }else {
                $estado_jurado = 1;
            }
                $presidente=DB::selectOne('SELECT count(id_jurado_alumno)contar from ti_jurado_alumno WHERE id_alumno='.$id_alumno.' and id_tipo_jurado=1');
                $presidente=$presidente->contar;
                if($presidente == 0){
                    $presidente=0;
                    $dato_presidente=0;
                }else{
                    $presidente=1;
                    $dato_presidente=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 1 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
                }
                $secretario=DB::selectOne('SELECT count(id_jurado_alumno)contar from ti_jurado_alumno WHERE id_alumno='.$id_alumno.' and id_tipo_jurado=2');
                $secretario=$secretario->contar;
                if($secretario == 0){
                    $secretario=0;
                    $dato_secretario=0;
                }else{
                    $secretario=1;
                    $dato_secretario=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 2 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
                }
                $vocal=DB::selectOne('SELECT count(id_jurado_alumno)contar from ti_jurado_alumno WHERE id_alumno='.$id_alumno.' and id_tipo_jurado=3');
                $vocal=$vocal->contar;
                if($vocal == 0){
                    $vocal=0;
                    $dato_vocal=0;
                }else{
                    $vocal=1;
                    $dato_vocal=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
                }
                $suplente=DB::selectOne('SELECT count(id_jurado_alumno)contar from ti_jurado_alumno WHERE id_alumno='.$id_alumno.' and id_tipo_jurado=4');
                $suplente=$suplente->contar;
                if($suplente == 0){
                    $suplente=0;
                    $dato_suplente=0;
                }else{
                    $suplente=1;
                    $dato_suplente=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 4 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
                }




        }


        return view('titulacion.alumno_titulacion.tercera_etapa.reg_jurado_alumno',
            compact('salas','id_alumno','estado','horarios','registro_fecha','estado_jurado',
        'presidente','dato_presidente','secretario','dato_secretario','vocal','dato_vocal','suplente','dato_suplente'));

    }
    public function registrar_fecha_jurado(Request $request,$id_alumno){

        $this->validate($request,[
            'fecha_titulacion' => 'required',
            'sala_titulacion' => 'required',
            'hora_titulacion' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");

        $fecha_titulacion = $request->input("fecha_titulacion");
        $sala_titulacion = $request->input("sala_titulacion");
        $hora_titulacion = $request->input("hora_titulacion");



        DB::table('ti_fecha_jurado_alumn')
            ->where('id_alumno', $id_alumno)
            ->update(['fecha_titulacion'=>$fecha_titulacion,
                'id_horarios_dias'=>$hora_titulacion,
                'id_sala'=>$sala_titulacion,
                'fecha_registro'=>$fecha_hoy,]);

        return redirect("/titulacion/registro_jurado");

    }
    public function modificar_fecha_titulacion($id_alumno){
        $registro_fecha=DB::selectOne('SELECT ti_fecha_jurado_alumn.*,ti_horarios_dias.horario_dia FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias=ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');
        $horarios=DB::select('SELECT * FROM `ti_horarios_dias` ');

        return view('titulacion.alumno_titulacion.tercera_etapa.modal_modificar_fecha', compact('registro_fecha','horarios'));
    }
    public function editar_fecha_jurado(Request $request){

        $this->validate($request,[
            'fecha_titulacion' => 'required',
            'horario' => 'required',
            'id_fecha_jurado_alumn' => 'required',

        ]);
        $fecha_hoy = date("Y-m-d H:i:s");

        $fecha_titulacion = $request->input("fecha_titulacion");
        $horario = $request->input("horario");
        $id_fecha_jurado_alumn = $request->input("id_fecha_jurado_alumn");

        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update(['fecha_titulacion'=>$fecha_titulacion,
                'id_horarios_dias'=>$horario,
                'fecha_registro'=>$fecha_hoy,]);

        return back();
    }
    public function agregar_presidente($id_alumno){
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
        $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;

        $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo ");

        $registro_fecha=DB::selectOne('SELECT ti_fecha_jurado_alumn.*,ti_horarios_dias.horario_dia FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias=ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');


        return view('titulacion.alumno_titulacion.tercera_etapa.modal_agregar_presidente',compact('personales','registro_fecha'));

    }
    public function  guardar_presidente(Request $request){

        $this->validate($request,[
            'id_fecha_jurado_alumn' => 'required',
            'presidente' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");

        $id_fecha_jurado_alumn = $request->input("id_fecha_jurado_alumn");
        $fecha_registro=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE id_fecha_jurado_alumn='.$id_fecha_jurado_alumn.'');
        $id_alumno=$fecha_registro->id_alumno;
        $presidente = $request->input("presidente");

        DB:: table('ti_jurado_alumno')->insert([
            'id_alumno'=>$id_alumno ,
            'id_tipo_jurado'=>1,
            'id_alumno'=>$id_alumno,
            'fecha_registro'=>$fecha_hoy,
            'id_personal'=>$presidente,
            'id_fecha_jurado_alumn'=>$id_fecha_jurado_alumn,
        ]);
        return back();


    }
    public function modificar_presidente($id_alumno){
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');
        $id_carrera=$id_carrera->id_carrera;
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
        $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;


        $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo ");


        $registro_jurado=DB::selectOne('SELECT * FROM `ti_jurado_alumno` 
WHERE `id_alumno` = '.$id_alumno.' AND `id_tipo_jurado` = 1 ');


        return view('titulacion.alumno_titulacion.tercera_etapa.modal_modificar_presidente',compact('personales','registro_jurado'));


    }
    public function guardar_modificacion_presidente(Request $request){

        $this->validate($request,[
            'id_jurado_alumno' => 'required',
            'presidente' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");
        $id_jurado_alumno = $request->input("id_jurado_alumno");
        $presidente = $request->input("presidente");


        DB::table('ti_jurado_alumno')
            ->where('id_jurado_alumno', $id_jurado_alumno)
            ->update(['id_personal'=>$presidente,
                'fecha_registro'=>$fecha_hoy,]);
        return back();


    }
    public function agregar_secretario($id_alumno){
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
        $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;

        $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo ");

        $registro_fecha=DB::selectOne('SELECT ti_fecha_jurado_alumn.*,ti_horarios_dias.horario_dia FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias=ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');


        return view('titulacion.alumno_titulacion.tercera_etapa.modal_agregar_secretario',compact('personales','registro_fecha'));

    }
    public function guardar_secretario(Request $request){
        $this->validate($request,[
            'id_fecha_jurado_alumn' => 'required',
            'secretario' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");

        $id_fecha_jurado_alumn = $request->input("id_fecha_jurado_alumn");
        $fecha_registro=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE id_fecha_jurado_alumn='.$id_fecha_jurado_alumn.'');
        $id_alumno=$fecha_registro->id_alumno;
        $secretario = $request->input("secretario");

        DB:: table('ti_jurado_alumno')->insert([
            'id_alumno'=>$id_alumno ,
            'id_tipo_jurado'=>2,
            'id_alumno'=>$id_alumno,
            'fecha_registro'=>$fecha_hoy,
            'id_personal'=>$secretario,
            'id_fecha_jurado_alumn'=>$id_fecha_jurado_alumn,
        ]);
        return back();
    }
    public function modificar_secretario($id_alumno){
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');
        $id_carrera=$id_carrera->id_carrera;
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
        $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;

        $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo ");

        $registro_jurado=DB::selectOne('SELECT * FROM `ti_jurado_alumno` 
WHERE `id_alumno` = '.$id_alumno.' AND `id_tipo_jurado` = 2 ');

        return view('titulacion.alumno_titulacion.tercera_etapa.modal_modificar_secretario',compact('personales','registro_jurado'));

    }
    public function guardar_modificacion_secretario(Request $request){
        $this->validate($request,[
            'id_jurado_alumno' => 'required',
            'secretario' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");
        $id_jurado_alumno = $request->input("id_jurado_alumno");
        $secretario = $request->input("secretario");


        DB::table('ti_jurado_alumno')
            ->where('id_jurado_alumno', $id_jurado_alumno)
            ->update(['id_personal'=>$secretario,
                'fecha_registro'=>$fecha_hoy,]);
        return back();
    }
    public function agregar_vocal($id_alumno){
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
        $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;

        $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo ");

        $registro_fecha=DB::selectOne('SELECT ti_fecha_jurado_alumn.*,ti_horarios_dias.horario_dia FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias=ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');


        return view('titulacion.alumno_titulacion.tercera_etapa.modal_agregar_vocal',compact('personales','registro_fecha'));

    }
    public function guardar_vocal(Request $request){
        $this->validate($request,[
            'id_fecha_jurado_alumn' => 'required',
            'vocal' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");

        $id_fecha_jurado_alumn = $request->input("id_fecha_jurado_alumn");
        $fecha_registro=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE id_fecha_jurado_alumn='.$id_fecha_jurado_alumn.'');
        $id_alumno=$fecha_registro->id_alumno;
        $vocal = $request->input("vocal");

        DB:: table('ti_jurado_alumno')->insert([
            'id_alumno'=>$id_alumno ,
            'id_tipo_jurado'=>3,
            'id_alumno'=>$id_alumno,
            'fecha_registro'=>$fecha_hoy,
            'id_personal'=>$vocal,
        ]);
        return back();

    }
    public function modificar_vocal($id_alumno){
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');
        $id_carrera=$id_carrera->id_carrera;
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
        $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;

        $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo ");

        $registro_jurado=DB::selectOne('SELECT * FROM `ti_jurado_alumno` 
WHERE `id_alumno` = '.$id_alumno.' AND `id_tipo_jurado` = 3 ');

        return view('titulacion.alumno_titulacion.tercera_etapa.modal_modificar_vocal',compact('personales','registro_jurado'));

    }
    public  function guardar_modificacion_vocal(Request $request){

        $this->validate($request,[
            'id_jurado_alumno' => 'required',
            'vocal' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");
        $id_jurado_alumno = $request->input("id_jurado_alumno");
        $vocal = $request->input("vocal");


        DB::table('ti_jurado_alumno')
            ->where('id_jurado_alumno', $id_jurado_alumno)
            ->update(['id_personal'=>$vocal,
                'fecha_registro'=>$fecha_hoy,]);
        return back();

    }
    public function agregar_suplente($id_alumno){
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
        $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;

        $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo ");

        $registro_fecha=DB::selectOne('SELECT ti_fecha_jurado_alumn.*,ti_horarios_dias.horario_dia FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias=ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');


        return view('titulacion.alumno_titulacion.tercera_etapa.modal_agregar_suplente',compact('personales','registro_fecha'));

    }
    public function guardar_suplente(Request $request){
        $this->validate($request,[
            'id_fecha_jurado_alumn' => 'required',
            'suplente' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");

        $id_fecha_jurado_alumn = $request->input("id_fecha_jurado_alumn");
        $fecha_registro=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE id_fecha_jurado_alumn='.$id_fecha_jurado_alumn.'');
        $id_alumno=$fecha_registro->id_alumno;
        $suplente = $request->input("suplente");

        DB:: table('ti_jurado_alumno')->insert([
            'id_alumno'=>$id_alumno ,
            'id_tipo_jurado'=>4,
            'id_alumno'=>$id_alumno,
            'fecha_registro'=>$fecha_hoy,
            'id_personal'=>$suplente,
        ]);
        return back();
    }
    public function modificar_suplente ($id_alumno){

        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');
        $id_carrera=$id_carrera->id_carrera;
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo=' . $id_periodo . ' AND id_carrera=' . $id_carrera . '');
        $id_periodo_carrera = $id_periodo_carrera->id_periodo_carrera;

        $personales = DB::select("select gnral_personales.id_personal,gnral_personales.nombre 
                   FROM gnral_personales, gnral_horarios, abreviaciones_prof,abreviaciones,gnral_cargos 
                  WHERE gnral_horarios.id_periodo_carrera=$id_periodo_carrera AND gnral_horarios.id_personal=gnral_personales.id_personal and 
                  abreviaciones_prof.id_personal=gnral_personales.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
                   gnral_cargos.id_cargo=gnral_personales.id_cargo ");

        $registro_jurado=DB::selectOne('SELECT * FROM `ti_jurado_alumno` 
WHERE `id_alumno` = '.$id_alumno.' AND `id_tipo_jurado` = 4 ');


        return view('titulacion.alumno_titulacion.tercera_etapa.modal_modificar_suplente',compact('personales','registro_jurado'));

    }
    public function guardar_modificacion_suplente(Request $request){

        $this->validate($request,[
            'id_jurado_alumno' => 'required',
            'suplente' => 'required',
        ]);
        $fecha_hoy = date("Y-m-d H:i:s");
        $id_jurado_alumno = $request->input("id_jurado_alumno");
        $suplente = $request->input("suplente");


        DB::table('ti_jurado_alumno')
            ->where('id_jurado_alumno', $id_jurado_alumno)
            ->update(['id_personal'=>$suplente,
                'fecha_registro'=>$fecha_hoy,]);
        return back();
    }
    public function enviar_jurado(Request $request, $id_alumno){

        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,
       ti_reg_datos_alum.amaterno,ti_reg_datos_alum.correo_electronico, ti_fecha_jurado_alumn.* 
from ti_reg_datos_alum,ti_fecha_jurado_alumn 
WHERE ti_fecha_jurado_alumn.id_alumno=ti_reg_datos_alum.id_alumno and 
      ti_reg_datos_alum.id_alumno='.$id_alumno.'');

        $nombre_alumno=$alumno->no_cuenta.' '.$alumno->nombre_al.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.alumno_titulacion.tercera_etapa.notificacion_envio',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($correo_alumno,$nombre_alumno);
            $message->to($jefe_correo,"")->subject('Notificación de envio para la autorización del jurado');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        $fecha_hoy = date("Y-m-d H:i:s");
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_estado_enviado' => 1,
                'fecha_registro' => $fecha_hoy,
            ]);
        return back();
    }

    public function consultar_fechas_titulacion($fecha_inicial,$fecha_final){

        $id_carrera = Session::get('carrera');
        $lunes=date("Y-m-d",strtotime($fecha_inicial."+0 days"));
//dd($lunes);


        $lunes1=DB::select("SELECT ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.id_carrera,ti_fecha_jurado_alumn.* 
from ti_fecha_jurado_alumn,ti_reg_datos_alum where ti_fecha_jurado_alumn.fecha_titulacion='$lunes' 
    and ti_fecha_jurado_alumn.id_estado_enviado in (2,4) 
     and ti_fecha_jurado_alumn.id_alumno=ti_reg_datos_alum.id_alumno 
                                               and ti_reg_datos_alum.id_carrera=$id_carrera ");

        $martes=date("Y-m-d",strtotime($fecha_inicial."+1 days"));


        $martes1=DB::select("SELECT ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.id_carrera,ti_fecha_jurado_alumn.* 
from ti_fecha_jurado_alumn,ti_reg_datos_alum where ti_fecha_jurado_alumn.fecha_titulacion='$martes' 
    and ti_fecha_jurado_alumn.id_estado_enviado in (2,4) 
     and ti_fecha_jurado_alumn.id_alumno=ti_reg_datos_alum.id_alumno 
                                               and ti_reg_datos_alum.id_carrera=$id_carrera ");

        $miercoles=date("Y-m-d",strtotime($fecha_inicial."+2 days"));


        $miercoles1=DB::select("SELECT ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.id_carrera,ti_fecha_jurado_alumn.* 
from ti_fecha_jurado_alumn,ti_reg_datos_alum where ti_fecha_jurado_alumn.fecha_titulacion='$miercoles' 
    and ti_fecha_jurado_alumn.id_estado_enviado in (2,4) 
     and ti_fecha_jurado_alumn.id_alumno=ti_reg_datos_alum.id_alumno 
                                               and ti_reg_datos_alum.id_carrera=$id_carrera ");


        $jueves=date("Y-m-d",strtotime($fecha_inicial."+3 days"));


        $viernes=date("Y-m-d",strtotime($fecha_inicial."+4 days"));



    }
    public function validacion_agregar_jurado_carreras(){
        $carreras=DB::select('SELECT * FROM `gnral_carreras` WHERE id_carrera !=9 and id_carrera !=11 and id_carrera !=15 ');
        return view('titulacion.jefe_titulacion.validar_agregar_jurado.carrera_validar_gregar_jurado',compact('carreras'));

    }
    public function validacion_agregar_jurado_alumnos($id_carrera)
    {

        $autorizar_alumnos = DB::select('SELECT ti_fecha_jurado_alumn.*,
       ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,
       ti_reg_datos_alum.amaterno FROM ti_reg_datos_alum,ti_fecha_jurado_alumn 
where ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno and
      ti_reg_datos_alum.id_enviado_biblioteca=1 and ti_fecha_jurado_alumn.id_autorizar_agendar_jurado=0 
  and ti_reg_datos_alum.id_carrera='.$id_carrera.' ');


        $autorizados_alumnos = DB::select('SELECT ti_fecha_jurado_alumn.*,
       ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,
       ti_reg_datos_alum.amaterno FROM ti_reg_datos_alum,ti_fecha_jurado_alumn 
where ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno and
      ti_reg_datos_alum.id_enviado_biblioteca=1 and ti_fecha_jurado_alumn.id_autorizar_agendar_jurado=1 and ti_fecha_jurado_alumn.id_liberado_titulado=0
  and ti_reg_datos_alum.id_carrera='.$id_carrera.' ');


        $carrera = DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = ' . $id_carrera. '');
        return view('titulacion.jefe_titulacion.validar_agregar_jurado.alumnos_validar_agregar_jurado',compact('autorizar_alumnos','autorizados_alumnos','carrera'));

    }
    public function autorizacion_jurado_alumno($id_fecha_jurado_alumn){
      $alumno=DB::selectOne('SELECT ti_reg_datos_alum.no_cuenta,
       ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.amaterno,
       ti_fecha_jurado_alumn.* FROM ti_reg_datos_alum, ti_fecha_jurado_alumn 
where ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno and
      ti_fecha_jurado_alumn.id_fecha_jurado_alumn='.$id_fecha_jurado_alumn.'');
        return view('titulacion.jefe_titulacion.validar_agregar_jurado.autorizar_alumno_agregar_jurado',compact('alumno'));

    }
    public function guardar_autorizar_agregar_jurado(Request $request){
        $id_fecha_jurado_alumn = $request->input("id_fecha_jurado_alumn");
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'id_autorizar_agendar_jurado' => 1,
            ]);
        return back();

    }
    public function fecha_titulacion_alumnos($fecha_titulacion,$sala_titulacion){
        $id_usuario = Session::get('usuario_alumno');
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_usuario` = '.$id_usuario.'');
        $id_alumno=$alumno->id_alumno;
          $sala=DB::selectOne('SELECT * FROM `ti_sala` WHERE `id_sala` = '.$sala_titulacion.'');
           $fecha_hora1=DB::selectOne("SELECT count(id_fecha_jurado_alumn) contar 
           FROM ti_fecha_jurado_alumn where fecha_titulacion = '$fecha_titulacion' and id_horarios_dias = 1 and id_sala = $sala_titulacion ");
           $fecha_hora1=$fecha_hora1->contar;
           $horas_disponible=array();
           $disponibilidad_dia=0;
          if($fecha_hora1 == 0){
              $disponibilidad_dia++;
              $horas['id_horario_dias']=1;
              $horas['nombre_hora']="10:00 hrs.";
              array_push($horas_disponible, $horas);
          }else{

          }
        $fecha_hora2=DB::selectOne("SELECT count(id_fecha_jurado_alumn) contar 
           FROM ti_fecha_jurado_alumn where fecha_titulacion = '$fecha_titulacion' and id_horarios_dias = 2 and id_sala = $sala_titulacion ");
        $fecha_hora2=$fecha_hora2->contar;
        if($fecha_hora2 == 0){
            $disponibilidad_dia++;
            $horas['id_horario_dias']=2;
            $horas['nombre_hora']="11:30 hrs.";
            array_push($horas_disponible, $horas);
        }else{

        }

        $fecha_hora3=DB::selectOne("SELECT count(id_fecha_jurado_alumn) contar 
           FROM ti_fecha_jurado_alumn where fecha_titulacion = '$fecha_titulacion' and id_horarios_dias = 3 and id_sala = $sala_titulacion ");
        $fecha_hora3=$fecha_hora3->contar;
        if($fecha_hora3 == 0){
            $disponibilidad_dia++;
            $horas['id_horario_dias']=3;
            $horas['nombre_hora']="13:00 hrs.";
            array_push($horas_disponible, $horas);
        }else{

        }
        $fecha_hora4=DB::selectOne("SELECT count(id_fecha_jurado_alumn) contar 
           FROM ti_fecha_jurado_alumn where fecha_titulacion = '$fecha_titulacion' and id_horarios_dias = 4 and id_sala = $sala_titulacion ");
        $fecha_hora4=$fecha_hora4->contar;
        if($fecha_hora4 == 0){
            $disponibilidad_dia++;
            $horas['id_horario_dias']=4;
            $horas['nombre_hora']="14:30 hrs.";
            array_push($horas_disponible, $horas);
        }else{

        }

        $fecha_hora5=DB::selectOne("SELECT count(id_fecha_jurado_alumn) contar 
           FROM ti_fecha_jurado_alumn where fecha_titulacion = '$fecha_titulacion' and id_horarios_dias = 5 and id_sala = $sala_titulacion ");
        $fecha_hora5=$fecha_hora5->contar;
        if($fecha_hora5 == 0){
            $disponibilidad_dia++;
            $horas['id_horario_dias']=5;
            $horas['nombre_hora']="16:00 hrs.";
            array_push($horas_disponible, $horas);
        }else{


        }
        return view('titulacion.alumno_titulacion.tercera_etapa.reg_fecha_hora_titulacion',compact('sala','horas_disponible','disponibilidad_dia','fecha_titulacion','id_alumno'));

    }
    public function eliminar_fecha_titulacion(Request $request, $id_alumno){

        $fecha_hoy = date("Y-m-d H:i:s");
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_alumno', $id_alumno)
            ->update(['fecha_titulacion'=>"",
                'id_horarios_dias'=>0,
                'id_sala'=>0,
                'fecha_registro'=>$fecha_hoy,]);


        return back();

    }
    public function elim_fe_titulacion(Request $request, $id_alumno){
        $fecha_hoy = date("Y-m-d H:i:s");
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_alumno', $id_alumno)
            ->update(['fecha_titulacion'=>"",
                'id_horarios_dias'=>0,
                'id_sala'=>0,
                'fecha_registro'=>$fecha_hoy,]);


        return redirect('/titulacion/registro_jurado');
    }
}
