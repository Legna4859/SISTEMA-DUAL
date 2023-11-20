<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use App\Carreras;
class Datos_GeneralesalumnosController extends Controller
{
    public function index()
{
    $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');

    $carrerita=0;
    $ver=0;
    return view('evaluacion_docente.Alumnos.datos_generales_alumnos',compact('carreras','carrerita','ver'));
}
    public function datosgeneralesal($id_carrera){
        $periodo=Session::get('periodo_actual');
        $alumnos=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno FROM
 gnral_alumnos,eva_validacion_de_cargas WHERE eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
  and eva_validacion_de_cargas.id_periodo='.$periodo.' and eva_validacion_de_cargas.estado_validacion in (2,8,9)
  and gnral_alumnos.id_carrera='.$id_carrera.'  ORDER BY gnral_alumnos.apaterno ASC ');
        $carrerita=$id_carrera;
        $ver=1;
        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');

        return view('evaluacion_docente.Alumnos.datos_generales_alumnos',compact('alumnos','carreras','carrerita','ver'));

    }
    public function  mostrar($id)
    {
 $datos= DB::selectOne('SELECT gnral_alumnos.id_semestre,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
gnral_alumnos.apaterno, 
gnral_alumnos.amaterno,gnral_alumnos.genero,gnral_alumnos.fecha_nac,
gnral_alumnos.edad,gnral_alumnos.curp_al,gnral_alumnos.edo_civil,
gnral_alumnos.nacionalidad,gnral_alumnos.correo_al,gnral_alumnos.cel_al,
gnral_alumnos.grado_estudio_al,gnral_carreras.nombre carrera,gnral_semestres.descripcion semestre,
gnral_alumnos.grupo,gnral_alumnos.promedio_preparatoria,gnral_estados.nombre_estado,
gnral_municipios.nombre_municipio,gnral_alumnos.calle_al,gnral_alumnos.n_ext_al numero_exterior,
gnral_alumnos.n_int_al numero_interior,gnral_alumnos.entre_calle,
gnral_alumnos.y_calle,gnral_alumnos.otra_ref,
gnral_alumnos.localidad_al,gnral_alumnos.cp,gnral_alumnos.discapacidad,
gnral_alumnos.descripcion_discapacidad,gnral_alumnos.lengua,gnral_alumnos.descripcion_lengua,
gnral_alumnos.id_seguro_social seguro,gnral_alumnos.numero_seguro_social FROM
 gnral_alumnos,gnral_carreras,
 gnral_semestres,gnral_estados,gnral_municipios WHERE
 gnral_alumnos.estado=gnral_estados.id_estado and 
 gnral_alumnos.id_municipio=gnral_municipios.id_municipio and 
 gnral_alumnos.id_semestre=gnral_semestres.id_semestre AND
 gnral_carreras.id_carrera=gnral_alumnos.id_carrera 
  and gnral_alumnos.id_alumno='.$id.'');
 //dd($datos);
        return view('evaluacion_docente.Alumnos.ver_alumnos_datos')->with([ 'datos' => $datos]);
    }
    public function mostrar_calificaciones($id_alumno){

        $periodo=Session::get('periodo_actual');
        $carrera = Session::get('carrera');
        $mayor_unidades=0;
        $esc_alumno=false;
        $datos_alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` = '.$id_alumno.'');

          $alumno=$id_alumno;
        $docentes=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre as materias,gnral_materias.unidades,gnral_materias.id_materia,eva_tipo_curso.nombre_curso,
eva_carga_academica.id_carga_academica,eva_carga_academica.grupo,gnral_materias.id_semestre,
gnral_materias.creditos,eva_status_materia.nombre_status from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos,eva_validacion_de_cargas
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                                and gnral_periodos.id_periodo='.$periodo.'
                                 and eva_carga_academica.id_materia  NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
                                and gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno
                                and gnral_periodos.id_periodo=eva_validacion_de_cargas.id_periodo
                                and eva_validacion_de_cargas.estado_validacion in (2,8,9)
                                and eva_validacion_de_cargas.id_alumno='.$alumno.'
                                and eva_status_materia.id_status_materia=1');
        $array_materias=array();
        foreach ($docentes as $dat_alumno)
        {
            $esc_alumno=false;
            $suma_unidades=0;
            $unidades_evaluadas=0;
            $promedio_general=0;
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
                }

                $unidades_evaluadas++;
                $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                array_push($array_calificaciones,$dat_calificaciones);
            }
            //dd($promedio_general);
           if($promedio_general == 0){

               $dat_materia['promedio'] = intval(round($suma_unidades / $unidades_evaluadas) + 0);

           }
           else {
               $dat_materia['promedio']=0;
           }
            $dat_materia['esc_alumno']=$esc_alumno;
            $dat_materia["calificaciones"]=$array_calificaciones;
            array_push($array_materias,$dat_materia);
        }

        $residencia=DB::selectOne('select count(eva_carga_academica.id_alumno) contar from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos,eva_validacion_de_cargas
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                                and gnral_periodos.id_periodo='.$periodo.'
                                 and eva_carga_academica.id_materia   IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
                                and gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno
                                and gnral_periodos.id_periodo=eva_validacion_de_cargas.id_periodo
                                and eva_validacion_de_cargas.estado_validacion in (2,8,9)
                                and eva_validacion_de_cargas.id_alumno='.$alumno.'
                                and eva_status_materia.id_status_materia=1');
       $cal_resi=0;
       $calificada=0;
       $resi="";
        if($residencia->contar == 0){

        }
        else{
            $cal_resi=1;
            $contar_r=DB::selectOne('SELECT count(id_cal_residencia) contar_residencia  FROM `cal_residencia` WHERE `id_alumno` = '.$alumno.'');

            if($contar_r->contar_residencia == 0){

            }
            else{
                $calificada=1;
                $resi=DB::selectOne('SELECT   *FROM `cal_residencia` WHERE `id_alumno` = '.$alumno.'');


            }
        }


        // dd($docentes);
        // $array_profesor=array();
        $profesores=DB::select('select gnral_personales.nombre,gnral_materias.nombre materias,gnral_horas_profesores.grupo,gnral_horas_profesores.id_hrs_profesor ,gnral_materias.id_semestre
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_periodos,eva_carga_academica,
                            eva_validacion_de_cargas
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo  
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_periodos.id_periodo='.$periodo.'
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.id_alumno='.$alumno.'
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.estado_validacion in (2,8,9)');


        $turnos=DB::select('SELECT * FROM `cal_turno` ');
        $semestres=DB::select('SELECT * FROM `gnral_semestres` ');
        $grupos=DB::select('SELECT * FROM `gnral_grupos` ');
        //dd($array_materias);
        return view('evaluacion_docente.Alumnos.calificaciones_alumno',compact('grupos','semestres','turnos','docentes','mayor_unidades','array_materias','profesores','datos_alumno','id_alumno','cal_resi','calificada','resi'));

    }
}
