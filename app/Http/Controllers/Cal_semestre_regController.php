<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class Cal_semestre_regController extends Controller
{
    public function reg_semestre_alumno_carrera(){
        $carreras = DB::table('gnral_carreras')
            ->where('id_carrera', '!=', 9)
            ->where('id_carrera', '!=', 11)
            ->where('id_carrera', '!=', 15)
            ->get();
        return view('servicios_escolares.reg_datos_alumno.reg_semestre_alumno', compact('carreras'));
    }
    public function registrar_semestre_al($id_carrera){
        $periodo=Session::get('periodo_actual');
        $alumnos=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.id_alumno,
        gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno  from gnral_alumnos,eva_validacion_de_cargas 
        WHERE eva_validacion_de_cargas.id_alumno = gnral_alumnos.id_alumno and eva_validacion_de_cargas.id_periodo = '.$periodo.' 
          and eva_validacion_de_cargas.estado_validacion IN (2,8,9) and gnral_alumnos.id_carrera = '.$id_carrera.' and gnral_alumnos.id_disponible=0 and gnral_alumnos.id_alumno
        NOT in (SELECT eva_semestre_alumno.id_alumno from eva_semestre_alumno) ORDER by gnral_alumnos.apaterno asc,
        gnral_alumnos.amaterno asc, gnral_alumnos.nombre asc');
        $reg_alumnos=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
           gnral_alumnos.amaterno, gnral_periodos.periodo, eva_semestre_alumno.*,gnral_semestres.descripcion semestre 
           from gnral_alumnos, eva_semestre_alumno, gnral_semestres, gnral_periodos WHERE 
           gnral_alumnos.id_alumno = eva_semestre_alumno.id_alumno and eva_semestre_alumno.id_semestre = gnral_semestres.id_semestre 
           and eva_semestre_alumno.id_periodo = gnral_periodos.id_periodo and gnral_alumnos.id_carrera ='.$id_carrera.'
           ORDER by gnral_alumnos.apaterno asc, gnral_alumnos.amaterno asc, gnral_alumnos.nombre asc');

        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.' ORDER BY `nombre` ASC ');

        return view('servicios_escolares.reg_datos_alumno.alumnos_reg_semestre', compact('id_carrera','alumnos','carrera','reg_alumnos'));
    }
    public function agregar_semestre_al($id_alumno){
        $periodo=Session::get('periodo_actual');
           $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.id_alumno,
           gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos 
           where gnral_alumnos.id_alumno='.$id_alumno.' ORDER by gnral_alumnos.apaterno asc,gnral_alumnos.amaterno asc,
           gnral_alumnos.nombre asc');

           $periodos=DB::select('SELECT *FROM gnral_periodos WHERE id_periodo >=13  ORDER BY id_periodo ASC');
           $semestres=DB::select('SELECT * FROM `gnral_semestres` ORDER BY `gnral_semestres`.`id_semestre` ASC ');


        return view('servicios_escolares.reg_datos_alumno.partials_agregar_semestre', compact('alumno','semestres','periodos'));
    }
    public function guardar_semestre_al(Request $request,$id_alumno,$id_estado){

        $fecha_actual = date('d-m-Y');

        $id_periodo = $request->input('id_periodo');
        $id_semestre= $request->input('id_semestre');
        $usuario = Session::get('usuario_alumno');

if($id_estado == 2){
    $id_estado=2;
}else{
    $id_estado=1;
}
        DB:: table('eva_semestre_alumno')->insert([
            'id_periodo' => $id_periodo,
            'id_semestre' => $id_semestre,
            'id_estado_autorizacion' => 1,
            'id_alumno' => $id_alumno,
            'fecha_registro' => $fecha_actual,
            'id_estado_rev'=>$id_estado,
            'id_usuario_mod' => $usuario,
        ]);
        return back();

    }
    public function eliminar_semestre_al($id_semestre_al){
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno, gnral_alumnos.amaterno, gnral_periodos.periodo, eva_semestre_alumno.*,
       gnral_semestres.descripcion semestre from gnral_alumnos, eva_semestre_alumno, gnral_semestres, gnral_periodos 
       WHERE gnral_alumnos.id_alumno = eva_semestre_alumno.id_alumno and eva_semestre_alumno.id_semestre = gnral_semestres.id_semestre  
        and eva_semestre_alumno.id_periodo = gnral_periodos.id_periodo and eva_semestre_alumno.id_semestres_al ='.$id_semestre_al.'');

        return view('servicios_escolares.reg_datos_alumno.partials_eliminar_reg_estudiante', compact('alumno'));
    }
    public function guardar_eliminar_semestre_al(Request $request, $id_semestres_al){
        $alumno=DB::selectOne('SELECT * FROM `eva_semestre_alumno` WHERE `id_semestres_al` = '.$id_semestres_al.' ');

        DB::table('eva_semestre_alumno')->
        where('id_semestres_al', $id_semestres_al)->delete();

        DB::table('eva_act_semestre')->
        where('id_alumno', $alumno->id_alumno)->delete();
        return back();
    }
    public function desactivar_al($id_aumno){
     $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos where gnral_alumnos.id_alumno ='.$id_aumno.'');
        return view('servicios_escolares.reg_datos_alumno.desactivar_estudiante', compact('alumno'));
    }
    public function guardar_desactivar_estudiante($id_alumno){
        DB::table('gnral_alumnos')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_disponible' => 1,
            ]);

        return back();
    }
    public function carrera_estudiantes_desactivados(){
        $carreras = DB::table('gnral_carreras')
            ->where('id_carrera', '!=', 9)
            ->where('id_carrera', '!=', 11)
            ->where('id_carrera', '!=', 15)
            ->get();
        return view('servicios_escolares.reg_datos_alumno.carrera_estudiantes_inactivos', compact('carreras'));
    }
    public function estudiantes_inactivos($id_carrera){
        $alumnos=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
        gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos where gnral_alumnos.id_carrera = '.$id_carrera.'
        and gnral_alumnos.id_disponible=1 ORDER by gnral_alumnos.apaterno asc, gnral_alumnos.amaterno asc, 
        gnral_alumnos.nombre asc');
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.' ORDER BY `nombre` ASC ');

        return view('servicios_escolares.reg_datos_alumno.alumnos_inactivos', compact('alumnos','carrera','id_carrera'));

    }
    public function activacion_estudiante_seme($id_alumno){
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos where gnral_alumnos.id_alumno ='.$id_alumno.'');
        return view('servicios_escolares.reg_datos_alumno.partials_activacion_estudiante', compact('alumno'));
    }
    public function guardar_activar_estudiante(Request $request,$id_alumno){
        DB::table('gnral_alumnos')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_disponible' => 0,
            ]);

        return back();
    }
    public function carrera_actualizar_semestre_periodo(){
       $periodos_semestre=DB::select('SELECT eva_periodos_semestres_act.*,gnral_periodos.periodo FROM 
       eva_periodos_semestres_act, gnral_periodos WHERE eva_periodos_semestres_act.id_periodo = gnral_periodos.id_periodo');




           $periodos=DB::select('SELECT * FROM `gnral_periodos` WHERE `estado` = 1 and id_periodo NOT IN (SELECT id_periodo from eva_periodos_semestres_act)');



        $periodo_activo=DB::selectOne('SELECT eva_periodos_semestres_act.*,gnral_periodos.periodo FROM 
       eva_periodos_semestres_act, gnral_periodos WHERE eva_periodos_semestres_act.id_periodo = gnral_periodos.id_periodo 
       and eva_periodos_semestres_act.id_estado_actualizacion = 1');



        return view('servicios_escolares.reg_datos_alumno.periodos_actualizar_sem', compact('periodos','periodos_semestre','periodo_activo'));

    }
    public function reg_periodo_act_sem(Request $request){
        $fecha_actual = date('d-m-Y');
        $id_periodo = $request->input('id_periodo');

        DB:: table('eva_periodos_semestres_act')->insert([
            'id_periodo' => $id_periodo,
            'fecha_registro' => $fecha_actual,
        ]);
        return back();
    }
    public function activar_periodo_act_sem($id_periodos_sem_act){
       $periodo=DB::selectOne('SELECT eva_periodos_semestres_act.*,gnral_periodos.periodo FROM 
       eva_periodos_semestres_act, gnral_periodos WHERE eva_periodos_semestres_act.id_periodo = gnral_periodos.id_periodo and eva_periodos_semestres_act.id_periodos_sem_act='.$id_periodos_sem_act.' ');

        return view('servicios_escolares.reg_datos_alumno.partials_activacion_periodo', compact('periodo'));

    }
    public function guardar_activar_periodo(Request $request,$id_periodos_sem_act)
    {
        $fecha_actual = date('d-m-Y');
        DB::table('eva_periodos_semestres_act')
            ->where('id_periodos_sem_act', $id_periodos_sem_act)
            ->update([
                'id_estado_actualizacion' =>1,
                'fecha_actualizacion'=>$fecha_actual,
            ]);

        return back();
    }
    public function guardar_finalizacion_periodo(Request $request){
        $periodo_activo=DB::selectOne('SELECT eva_periodos_semestres_act.*,gnral_periodos.periodo FROM 
       eva_periodos_semestres_act, gnral_periodos WHERE eva_periodos_semestres_act.id_periodo = gnral_periodos.id_periodo 
       and eva_periodos_semestres_act.id_estado_actualizacion = 1');
        $fecha_actual = date('d-m-Y');
        DB::table('eva_periodos_semestres_act')
            ->where('id_periodos_sem_act', $periodo_activo->id_periodos_sem_act)
            ->update([
                'id_estado_actualizacion' =>2,
                'fecha_actualizacion'=>$fecha_actual,
            ]);

        return back();
    }
    public function carreras_act_sem(){
        $carreras = DB::table('gnral_carreras')
            ->where('id_carrera', '!=', 9)
            ->where('id_carrera', '!=', 11)
            ->where('id_carrera', '!=', 15)
            ->get();
        return view('servicios_escolares.reg_datos_alumno.carreras_actualizacion_semestre', compact('carreras'));
    }
    public function carrera_estudiantes_act_sem($id_carrera){
        $periodo_activo=DB::selectOne('SELECT eva_periodos_semestres_act.*,gnral_periodos.periodo FROM 
       eva_periodos_semestres_act, gnral_periodos WHERE eva_periodos_semestres_act.id_periodo = gnral_periodos.id_periodo 
       and eva_periodos_semestres_act.id_estado_actualizacion = 1');
        $id_periodo=$periodo_activo->id_periodo;

        $reg_alumnos=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.id_alumno,
        gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno  from gnral_alumnos,eva_validacion_de_cargas,eva_semestre_alumno
        WHERE eva_validacion_de_cargas.id_alumno = gnral_alumnos.id_alumno and eva_validacion_de_cargas.id_periodo = '.$id_periodo.' 
          and eva_validacion_de_cargas.estado_validacion IN (2,8,9) and gnral_alumnos.id_carrera = '.$id_carrera.' and gnral_alumnos.id_disponible=0
          and eva_semestre_alumno.id_alumno = gnral_alumnos.id_alumno and eva_semestre_alumno.id_alumno = eva_validacion_de_cargas.id_alumno 
          and gnral_alumnos.id_alumno NOT in(SELECT id_alumno from eva_act_semestre WHERE id_periodo = '.$id_periodo.')');

        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.' ORDER BY `nombre` ASC ');

        $alumnos_act=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.id_alumno, gnral_alumnos.nombre,
        gnral_alumnos.apaterno, gnral_alumnos.amaterno,gnral_semestres.descripcion semestre from gnral_alumnos,eva_act_semestre, 
        gnral_semestres where eva_act_semestre.id_periodo='.$id_periodo.' and eva_act_semestre.id_alumno=gnral_alumnos.id_alumno 
        and gnral_alumnos.id_carrera = '.$id_carrera.' and gnral_semestres.id_semestre = gnral_alumnos.id_semestre ');


        return view('servicios_escolares.reg_datos_alumno.alumnos_actualizar_semestre', compact('reg_alumnos','carrera','periodo_activo','alumnos_act'));

    }
    public function guardar_act_sem_al(Request $request,$id_periodo,$id_carrera){
        $reg_alumnos=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.id_alumno,
        gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno,eva_semestre_alumno.id_periodo,eva_semestre_alumno.id_semestre  from gnral_alumnos,eva_validacion_de_cargas,eva_semestre_alumno
        WHERE eva_validacion_de_cargas.id_alumno = gnral_alumnos.id_alumno and eva_validacion_de_cargas.id_periodo = '.$id_periodo.' 
          and eva_validacion_de_cargas.estado_validacion IN (2,8,9) and gnral_alumnos.id_carrera = '.$id_carrera.' and gnral_alumnos.id_disponible=0
          and eva_semestre_alumno.id_alumno = gnral_alumnos.id_alumno and eva_semestre_alumno.id_alumno = eva_validacion_de_cargas.id_alumno 
          and gnral_alumnos.id_alumno NOT in(SELECT id_alumno from eva_act_semestre WHERE id_periodo = '.$id_periodo.')');

        $fecha_actual = date('d-m-Y');
        foreach ($reg_alumnos as $reg_alumno) {
            $semestres_pasar=$id_periodo - $reg_alumno->id_periodo;
            $suma_semestres=$semestres_pasar+$reg_alumno->id_semestre;


            DB:: table('eva_act_semestre')->insert([
                'id_periodo' => $id_periodo,
                'id_alumno' => $reg_alumno->id_alumno,
                'semestre_actualizado'=>$suma_semestres,
                'fecha_actualizacion' => $fecha_actual,
            ]);

            DB::table('gnral_alumnos')
                ->where('id_alumno', $reg_alumno->id_alumno)
                ->update([
                    'id_semestre' => $suma_semestres,
                    's_a' => $suma_semestres,
                ]);

        }
        return back();
    }
    public function actualizar_semestre_al($id_semestres_al){
        $datos_actu=DB::selectOne('SELECT gnral_semestres.descripcion semestre,gnral_periodos.periodo,
                            eva_semestre_alumno.* from gnral_semestres, gnral_periodos,eva_semestre_alumno where 
                            eva_semestre_alumno.id_semestres_al = '.$id_semestres_al.' and eva_semestre_alumno.id_periodo = gnral_periodos.id_periodo 
                            and eva_semestre_alumno.id_semestre = gnral_semestres.id_semestre');
        $periodos=DB::select('SELECT *FROM gnral_periodos WHERE id_periodo >= 13  ORDER BY id_periodo ASC');
        $semestres=DB::select('SELECT * FROM `gnral_semestres` ORDER BY `gnral_semestres`.`id_semestre` ASC ');

        return view('servicios_escolares.reg_datos_alumno.partials_modificar_semestre', compact('datos_actu','periodos','semestres'));

    }
    public function guardar_mod_semestre_al(Request $request,$id_semestres_al){
        $datos_actu=DB::selectOne('SELECT gnral_semestres.descripcion semestre,gnral_periodos.periodo,
                            eva_semestre_alumno.* from gnral_semestres, gnral_periodos,eva_semestre_alumno where 
                            eva_semestre_alumno.id_semestres_al = '.$id_semestres_al.' and eva_semestre_alumno.id_periodo = gnral_periodos.id_periodo 
                            and eva_semestre_alumno.id_semestre = gnral_semestres.id_semestre');
        $fecha_actual = date('d-m-Y');
        $mod_id_periodo = $request->input('mod_id_periodo');
        $mod_id_semestre = $request->input('mod_id_semestre');
        $usuario = Session::get('usuario_alumno');
        DB::table('eva_semestre_alumno')
            ->where('id_semestres_al', $id_semestres_al)
            ->update([
                'id_periodo' => $mod_id_periodo,
                'id_semestre' => $mod_id_semestre,
                'id_estado_autorizacion' => 1,
            'id_alumno' => $datos_actu->id_alumno,
            'fecha_registro' => $fecha_actual,
            'id_usuario_mod' => $usuario,
            ]);
        return back();
    }
    public function autorizar_semestre_al($id_semestres_al){
        return view('servicios_escolares.reg_datos_alumno.partials_autorizar_semestre', compact('id_semestres_al'));

    }
    public function guardar_autorizar_semestre_al(Request $request,$id_semestres_al){
        $fecha_actual = date('d-m-Y');

        $usuario = Session::get('usuario_alumno');
        DB::table('eva_semestre_alumno')
            ->where('id_semestres_al', $id_semestres_al)
            ->update([
                'id_estado_autorizacion' => 1,
                'fecha_registro' => $fecha_actual,
                'id_usuario_mod' => $usuario,
                'id_estado_rev'=>1,
            ]);
        return back();

    }
}
