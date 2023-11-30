<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;
use App\alumnos;
use App\carreras;
use App\ValidacionCarga;
use App\Activa_evaluacion;

class Dual_Validar_Carga_Academica_Alumno extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $periodo=Session::get('periodo_actual');
        //checar si el periodo esta activo
        $periodo_actual = DB::selectOne('SELECT *FROM gnral_periodos WHERE  estado = 1');
        $id_periodo_actual=$periodo_actual->id_periodo;

        if( $periodo == $id_periodo_actual ){
            $periodo_activo=1;
        }else{
            $periodo_activo=0;
        }
        $consulta=DB::select('SELECT eva_validacion_de_cargas.id, eva_validacion_de_cargas.id_alumno,gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno, gnral_carreras.nombre carreras 
                                FROM eva_validacion_de_cargas, gnral_alumnos, gnral_carreras 
                                WHERE eva_validacion_de_cargas.id_periodo='.$periodo.' 
                                AND eva_validacion_de_cargas.estado_validacion= 1
                                AND eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno 
                                AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera');
        $consulta2=DB::select('SELECT eva_validacion_de_cargas.id, eva_validacion_de_cargas.id_alumno,
          gnral_alumnos.cuenta, gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno, 
          gnral_carreras.nombre carreras, gnral_semestres.descripcion semestre 
            FROM eva_validacion_de_cargas, gnral_alumnos, gnral_carreras, gnral_semestres 
            WHERE eva_validacion_de_cargas.id_periodo='.$periodo.' 
            AND eva_validacion_de_cargas.estado_validacion= 2 
            AND eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno 
            AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
            AND gnral_alumnos.id_semestre = gnral_semestres.id_semestre');
        // dd($consulta2);

//version nueva
        $consulta3=DB::select('SELECT eva_validacion_de_cargas.id, eva_validacion_de_cargas.id_alumno,
          gnral_alumnos.cuenta, gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno, gnral_carreras.nombre carreras, gnral_semestres.descripcion semestre 
            FROM eva_validacion_de_cargas, gnral_alumnos, gnral_carreras, gnral_semestres 
            WHERE eva_validacion_de_cargas.id_periodo='.$periodo.' 
            AND eva_validacion_de_cargas.estado_validacion= 8 
            AND eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno 
            AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
            AND gnral_alumnos.id_semestre = gnral_semestres.id_semestre');
        //version antigua
        $consulta4=DB::select('select eva_validacion_de_cargas.id, eva_validacion_de_cargas.id_alumno,
          gnral_alumnos.cuenta, gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno, 
          gnral_carreras.nombre carreras, gnral_semestres.descripcion semestre FROM eva_validacion_de_cargas, gnral_alumnos, 
          gnral_carreras, gnral_semestres where eva_validacion_de_cargas.id_periodo='.$periodo.' 
          AND eva_validacion_de_cargas.estado_validacion=9 AND eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno 
          AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera and gnral_alumnos.id_semestre = gnral_semestres.id_semestre');

        $activar=DB::selectOne('select eva_activa_evaluacion.estado from eva_activa_evaluacion where eva_activa_evaluacion.id=2');
        $activar=$activar->estado;
        $activar_periodo_carga=DB::selectOne('SELECT * FROM eva_validacion_carga WHERE id_validacion_carga=1');

        return view('evaluacion_docente.Admin.validacion_de_carga',
            compact('consulta','consulta2','consulta3','consulta4',
                'activar','activar_periodo_carga','periodo_activo'));
    }
    public function alumno_baja(Request $request){
        $id_carga_a=$request->get('id_carga_a');
        $estado=$request->get('estado');
        $obser=$request->get('obser');
        if($estado== 1){
            $est=7;
            $comentario_estado="EL USUARIO DIO BAJA TEMPORAL (SIN ELIMINACION DE CARGA)";
            $datos=array(

                'descripcion'=>$obser,
                'estado_validacion' => 10
            );
        }
        elseif($estado == 2){
            $est=8;
            $comentario_estado="EL USUARIO DIO BAJA TEMPORAL (ELIMINACION DE CARGA)";
            $datos=array(
                'descripcion'=>$obser,
                'estado_validacion' => 11
            );
        }
        elseif ($estado == 3){
            $est=9;
            $comentario_estado="EL USUARIO DIO BAJA TEMPORA DEFINITIVA";
            $datos=array(
                'descripcion'=>$obser,
                'estado_validacion' => 12
            );
        }

//registrar usuario que hizo la modificacion

        $fecha_hoy = date("Y-m-d H:i:s");
        $usuario = Session::get('usuario_alumno');
        DB:: table('cal_usuario_estado')->insert(['id_usuario' => $usuario,
            'fecha' => $fecha_hoy, 'id_validacion_carga' => $id_carga_a,'estado'=>$comentario_estado,'id_estado'=>$est]);

        ValidacionCarga::find($id_carga_a)->update($datos);
        return back();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  function activar_periodo_remplazo($id)
    {

        //  DB::update('UPDATE eva_validacion_de_cargas SET estado_validacion = 4 WHERE id='.$id.'');



        return redirect('/duales/llenar_carga_academica_dual');

    }
    public  function desactivar_periodo_remplazo(Request $request,$id)
    {
        /*  $periodo=Session::get('periodo_actual');
          $consulta2=DB::select('select eva_validacion_de_cargas.id, eva_validacion_de_cargas.id_alumno,gnral_alumnos.cuenta, gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno, gnral_carreras.nombre carreras
                                     FROM eva_validacion_de_cargas, gnral_alumnos, gnral_carreras
                                     where eva_validacion_de_cargas.id_periodo='.$periodo.'
                                     AND eva_validacion_de_cargas.estado_validacion=4
                                     AND eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                                     AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera');

          foreach($consulta2 as $consultas)
          {
              DB::update('UPDATE eva_validacion_de_cargas SET estado_validacion = 2 WHERE id='.$consultas->id.'');

          }

          DB::update('UPDATE eva_validacion_carga SET descripcion =2  WHERE id_validacion_carga='.$id.'');
  */
        return redirect('/duales/llenar_carga_academica_dual');

    }
    public function create()
    {
        //
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
        //dd($request);
        $validez=$request->get('optradio');
        // dd($validez);

        //registrar usuario que hizo la modificacion
        if($validez ==1){
            $comentario_estado="Autorización de Carga Academica";
        }else{
            $comentario_estado="Rechazaron  Carga Academica";
        }
        $fecha_hoy = date("Y-m-d H:i:s");
        $usuario = Session::get('usuario_alumno');
        DB:: table('cal_usuario_estado')->insert(['id_usuario' => $usuario,
            'fecha' => $fecha_hoy, 'id_validacion_carga' => $id,'estado'=>$comentario_estado,'id_estado'=>$validez]);

        if($validez == 1)
        {
            $carga=DB::selectOne('SELECT * FROM `eva_validacion_de_cargas` WHERE `id` = '.$id.'');
            $id_alumno=$carga->id_alumno;
            $alum=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` ='.$id_alumno.'');
            $curp=$alum->curp_al;
            $genero=$al_año=substr($curp, 10,1);

            if($genero == "H"){
                $genero="M";
            }else{
                $genero="F";
            }

            $al_año=substr($curp, 4,1); //sacar el año

            if($al_año == 9 || $al_año == 8  || $al_año == 7 || $al_año == 6)
            {
                $al_año2=substr($curp, 5,1);
                $amo="19".$al_año.$al_año2;
                $mes=substr($curp, 6,2);
                $dia=substr($curp, 8,2);
                $ano_diferencia  = date("Y") - $amo;

                $mes_diferencia =   date("m")-$mes;

                $dia_diferencia   =   date("d")- $dia;

                if ($dia_diferencia < 0 && $mes_diferencia == 0 || $mes_diferencia < 0)
                {
                    $ano_diferencia=$ano_diferencia-1;
                }
                else{
                    $ano_diferencia=$ano_diferencia;
                }
            }
            else if($al_año ==0 || $al_año == 1 || $al_año == 2){
                $al_año2=substr($curp, 5,1);
                $amo="20".$al_año.$al_año2;
                $mes=substr($curp, 6,2);
                $dia=substr($curp, 8,2);
                $ano_diferencia  = date("Y") - $amo;

                $mes_diferencia =   date("m")-$mes;

                $dia_diferencia   =   date("d")- $dia;

                if ($dia_diferencia < 0 && $mes_diferencia == 0 || $mes_diferencia < 0)
                {
                    $ano_diferencia=$ano_diferencia-1;
                }
                else{
                    $ano_diferencia=$ano_diferencia;
                }
            }

            $edad=$ano_diferencia;

            $periodo_act=DB::selectOne('SELECT * FROM `gnral_periodos` WHERE `estado` =1');
            $period_ins=DB::selectOne('SELECT * FROM `eva_semestre_alumno` WHERE `id_alumno` = '.$id_alumno.'');
            $periodo_ins=$period_ins->id_periodo;
            $semestresins=$period_ins->id_semestre;
            $semestres_cursados=$periodo_act->id_periodo-$periodo_ins;

            if($semestres_cursados == 0){
                $semestres_cursados=1;
                $encuesta=1;
            }else{
                $semestres_cursados=$semestres_cursados+$semestresins;
                $encuesta=2;
            }
            $periodo=Session::get('periodo_actual');

            ////encuesta de satisfaccion al cliente inscripcion
            if($encuesta == 1){
                $estado = DB::selectOne('SELECT count(id_alumno) contar from enc_incripcion where id_alumno = '.$id_alumno.' and id_periodo = '.$periodo.' ');
                if( $estado->contar == 0){
                    DB:: table('enc_incripcion')->insert([
                        'id_periodo' => $periodo,
                        'id_alumno' => $id_alumno,
                    ]);
                }
            }
            ////encuesta de satisfaccion al cliente reinscripcion
            if($encuesta == 2){
                $estado = DB::selectOne('SELECT count(id_alumno) contar from enc_reinscripcion where id_alumno = '.$id_alumno.' and id_periodo = '.$periodo.' ');
                if( $estado->contar == 0){
                    DB:: table('enc_reinscripcion')->insert([
                        'id_periodo' => $periodo,
                        'id_alumno' => $id_alumno,
                    ]);
                }
            }

            $fecha_actual = date('d-m-Y');

            DB:: table('eva_act_semestre')->insert([
                'id_periodo' => $periodo_act->id_periodo,
                'id_alumno' => $id_alumno,
                'semestre_actualizado'=>$semestres_cursados,
                'fecha_actualizacion' => $fecha_actual,
            ]);

            DB::table('gnral_alumnos')
                ->where('id_alumno', $id_alumno)
                ->update([
                    'id_semestre' => $semestres_cursados,
                    's_a' => $semestres_cursados,
                ]);

            DB::table('gnral_alumnos')
                ->where('id_alumno', $id_alumno)
                ->update(['edad' => $edad,'genero' => $genero]);
            $estado_alumno=$request->get('estado');

            if($estado_alumno ==1)
            {
                $datos=array(
                    'descripcion'=>NULL,
                    'estado_validacion' => 2
                );
            }
            if($estado_alumno ==2)
            {
                $datos=array(
                    'descripcion'=>NULL,
                    'estado_validacion' => 8
                );
            }
            if($estado_alumno ==3)
            {
                $datos=array(
                    'descripcion'=>NULL,
                    'estado_validacion' => 9
                );
            }
            /// estado del alumno
            /// normal 2
            /// dual nueva version 8
            /// dual version antigua 9

            ValidacionCarga::find($id)->update($datos);
        }
        if($validez == 2)
        {
            $obser=$request->get('obser');
            $datos=array(
                'descripcion'=>$obser,
                'estado_validacion' => 3
            );
            ValidacionCarga::find($id)->update($datos);
        }
        return redirect()->route('llenar_carga_academica_dual.index');
    }
    public function estado_carga (Request $request){
        $this->validate($request,[
            'id_carga' => 'required',
            'estado' => 'required'
        ]);
        $id=$request->get('id_carga');
        $estado_alumno=$request->get('estado');

        if($estado_alumno ==1)
        {
            $est=3;
            $comentario_estado="Cambio a alumno normal";
            $datos=array(
                'descripcion'=>NULL,
                'estado_validacion' => 2
            );
        }
        if($estado_alumno ==2)
        {
            $est=4;
            $comentario_estado="Cambio a dual vesion nueva";
            $datos=array(
                'descripcion'=>NULL,
                'estado_validacion' => 8
            );
        }
        if($estado_alumno ==3)
        {
            $est=5;
            $comentario_estado="Cambio a dual version antigua";
            $datos=array(
                'descripcion'=>NULL,
                'estado_validacion' => 9
            );
        }
        if($estado_alumno ==4)
        {
            $est=6;
            $comentario_estado="Permiso de modificar";
            $datos=array(
                'descripcion'=>'PERMISO DE MODIFICAR',
                'estado_validacion' =>3
            );
        }
        //registrar usuario que hizo la modificacion

        $fecha_hoy = date("Y-m-d H:i:s");
        $usuario = Session::get('usuario_alumno');
        DB:: table('cal_usuario_estado')->insert(['id_usuario' => $usuario,
            'fecha' => $fecha_hoy, 'id_validacion_carga' => $id,'estado'=>$comentario_estado,'id_estado'=>$est]);

        ValidacionCarga::find($id)->update($datos);
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
    }
    public function desactivar()
    {
        $activar=DB::selectOne('SELECT eva_activa_evaluacion.estado FROM eva_activa_evaluacion WHERE eva_activa_evaluacion.id=2');
        $activar=$activar->estado;
        $id=2;
        if($activar==1)
        {
            $datos=array('estado'=>2);
            Activa_evaluacion::find($id)->update($datos);
            return $this->index();
        }
        if($activar==2)
        {
            $datos=array('estado'=>1);
            Activa_evaluacion::find($id)->update($datos);
            return $this->index();
        }
    }
    public function calificar_estudiante($id_carga)
    {
        $validar_carga = DB::table('eva_validacion_de_cargas')
            ->where('id', '=', $id_carga)
            ->get();

        $id_alumno = $validar_carga[0]->id_alumno;
        $id_periodo = $validar_carga[0]->id_periodo;
        $alum = DB::table('gnral_alumnos')
            ->where('id_alumno', '=', $id_alumno)
            ->get();
        $nombre_alumno = $alum[0]->cuenta . " " . mb_strtoupper($alum[0]->apaterno, 'utf-8') . " " . mb_strtoupper($alum[0]->amaterno, 'utf-8') . " " . mb_strtoupper($alum[0]->nombre, 'utf-8');
        $calificar_dual = DB::table('cal_duales_actuales')
            ->select(DB::raw('count(*) as calificado'))
            ->where('id_alumno', '=', $id_alumno)
            ->where('id_periodo', '=', $id_periodo)
            ->where('id_estado','>', 0)
            ->get();
        $calificar_dual=$calificar_dual[0]->calificado;
        $profesores=DB::select('SELECT gnral_personales.id_personal,gnral_personales.nombre,abreviaciones.titulo 
        FROM abreviaciones_prof,abreviaciones,gnral_personales where
        gnral_personales.id_personal=abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion ORDER BY `gnral_personales`.`nombre` ASC');

        if($calificar_dual == 0){
            $calificar_dual=0;
            $mentor=0;
        }
        else{
            $profesor = DB::table('cal_duales_actuales')
                ->where('cal_duales_actuales.id_alumno', '=', $id_alumno)
                ->where('cal_duales_actuales.id_periodo', '=', $id_periodo)
                ->get();
            $mentor=$profesor[0]->id_personal;
            $calificar_dual=1;
        }
        $materias=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre as materias,gnral_materias.unidades,gnral_materias.id_materia,eva_tipo_curso.nombre_curso,
        eva_carga_academica.id_carga_academica,eva_carga_academica.grupo,gnral_materias.id_semestre,
        gnral_materias.creditos,eva_status_materia.nombre_status from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos,eva_validacion_de_cargas
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                                and gnral_periodos.id_periodo='.$id_periodo.'
                                and eva_carga_academica.id_materia  NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
                                and gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno
                                and gnral_periodos.id_periodo=eva_validacion_de_cargas.id_periodo
                                and eva_validacion_de_cargas.id_alumno='.$id_alumno.'
                                and eva_status_materia.id_status_materia=1');
        $array_materias=array();
        $mayor_unidades=0;
        $esc_alumno=false;
        foreach ($materias as $dat_alumno)
        {
            $esc_alumno=false;
            $suma_unidades=0;
            $unidades_evaluadas=0;
            $promedio_general=0;
            $dat_materia['id_carga_academica']=$dat_alumno->id_carga_academica;
            $dat_materia['id_materia']=$dat_alumno->id_materia;
            $dat_materia['curso']=$dat_alumno->nombre_curso;
            $dat_materia["materia"]=$dat_alumno->materias;
            $dat_materia["unidades"]=$dat_alumno->unidades;
            $mayor_unidades= $mayor_unidades > $dat_alumno->unidades ? $mayor_unidades : $dat_alumno->unidades;
            $array_calificaciones=array();
            $calificaciones=DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica='.$dat_alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones.id_unidad');
            $calificaciones != null ? $unidades_evaluadas=0 : $unidades_evaluadas=1;
            foreach ($calificaciones as $calificacion)
            {
                $dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
                $dat_calificaciones['calificacion']=$calificacion->calificacion;
                $dat_calificaciones['id_unidad']=$calificacion->id_unidad;
                if ($calificacion->calificacion<70 || $calificacion->esc==1)
                {
                    $esc_alumno=true;
                }
                if ($calificacion->calificacion<70 )
                {
                    $promedio_general++;
                    //dd($promedio_general);
                }
                $unidades_evaluadas++;
                $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                array_push($array_calificaciones,$dat_calificaciones);
            }
            if($promedio_general == 0){

                $dat_materia['promedio'] = intval(round($suma_unidades / $unidades_evaluadas) + 0);

            }
            else {
                $dat_materia['promedio']=0;
            }
            //  $dat_materia['promedio']=intval(round($suma_unidades/$unidades_evaluadas)+0);
            $dat_materia['esc_alumno']=$esc_alumno;
            $dat_materia["calificaciones"]=$array_calificaciones;
            array_push($array_materias,$dat_materia);
            //dd($dat_materia["calificaciones"]);
        }

        return view('duales.Mentor_Dual_Calificar.calificar_estudiante_dual',compact('mentor','profesores','id_alumno','id_periodo','array_materias','mayor_unidades','nombre_alumno','calificar_dual'));

    }
    public function calificar_estudiante_duales_actuales($id_carga_academica){
        $carga_academica=DB::selectOne('SELECT * FROM `eva_carga_academica` WHERE `id_carga_academica`='.$id_carga_academica.'');
        $id_materia=$carga_academica->id_materia;
        $materia=DB::selectOne('SELECT * FROM `gnral_materias` WHERE `id_materia` ='.$id_materia.'');
        $unidades=$materia->unidades;
        $array_cali=array();
        for($i=1; $i<=$unidades;$i++){
            $cal=DB::selectOne('SELECT * FROM `cal_evaluaciones` WHERE `id_unidad` = '.$i.' AND `id_carga_academica` = '.$id_carga_academica.'');
            $dat_cal['id_unidad']=$i;
            if($cal == null){
                $dat_cal['calificacion']=0;
            }
            else{
                $dat_cal['calificacion']=$cal->calificacion;
            }

            $dat_cal['id_carga_academica']=$id_carga_academica;
            array_push($array_cali,$dat_cal);
        }
        //dd($array_cali);
        return view('duales.Jefe_Dual_Calificar.calificar_alumnnos_duales',compact('array_cali','id_carga_academica','unidades'));
    }

    public function terminar_calificar_duales_actuales(Request $request,$id_alumno,$id_periodo){

        $actualizar = DB::table('cal_duales_actuales')
        ->where(['id_alumno' => $id_alumno, 'id_periodo' => $id_periodo])
        ->update([
            'id_estado' => 1,
            'id_personal' => $request->get('mentor'), // Este valor puede ser nulo
        ]);

    return back();
    }

}