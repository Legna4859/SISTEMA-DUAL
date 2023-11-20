<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Excel;
use Session;

class ExcelController extends Controller
{
    public function exportAlumnos()
    {
        Excel::create('EstudiantesInscritos',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15  ORDER BY id_carrera ');
            $semestres=DB::select('SELECT * FROM gnral_semestres');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {
                $tot_masc=0; $tot_fem=0;
                $dat_carreras['id_carrera']=$carrera->id_carrera;
                $dat_carreras['nom_carrera']=$carrera->nombre;
                $dat_carreras['siglas']=$carrera->siglas;
                $array_semestres=array();
                $total_gral=0;
                foreach ($semestres as $semestre)
                {
                    $dat_semestres['id_semestre']=$semestre->id_semestre;
                    $dat_semestres['nom_semestre']=$semestre->descripcion;
                    $datos_inscritos=DB::select("SELECT * FROM (SELECT COUNT(gnral_alumnos.id_alumno)Masculino FROM 
                                    gnral_alumnos,eva_validacion_de_cargas WHERE
                                      gnral_alumnos.id_carrera=$carrera->id_carrera AND
                                      gnral_alumnos.id_semestre=$semestre->id_semestre AND
                                      eva_validacion_de_cargas.id_periodo=$periodo AND
                                      eva_validacion_de_cargas.estado_validacion IN (2,8,9) and 
               eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                                      gnral_alumnos.genero='M') t1,
                                  (SELECT COUNT(gnral_alumnos.id_alumno)Femenino FROM
                                      gnral_alumnos,eva_validacion_de_cargas WHERE
                                      gnral_alumnos.id_carrera=$carrera->id_carrera AND
                                      gnral_alumnos.id_semestre=$semestre->id_semestre AND
                                      eva_validacion_de_cargas.id_periodo=$periodo AND
                                      eva_validacion_de_cargas.estado_validacion IN (2,8,9) and 
                                     eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                                      gnral_alumnos.genero='F') t2");
                    $array_datos=array();
                    foreach ($datos_inscritos as $dato)
                    {
                        $dat_alumno['masculino']=$dato->Masculino;
                        $dat_alumno['femenino']=$dato->Femenino;
                        $tot_masc+=($dato->Masculino);
                        $tot_fem+=($dato->Femenino);
                        $dat_alumno['total']=($dato->Masculino)+($dato->Femenino);
                        $total_gral= $total_gral+($dato->Masculino)+($dato->Femenino);
                        array_push($array_datos, $dat_alumno);
                    }
                    $dat_semestres['datos']=$array_datos;
                    array_push($array_semestres,$dat_semestres);
                }
                $dat_carreras['tot_gral']=$total_gral;
                $dat_carreras['tot_masculino']=$tot_masc;
                $dat_carreras['tot_femenino']=$tot_fem;
                $dat_carreras['semestres']=$array_semestres;
                array_push($array_carreras,$dat_carreras);
            }
            //dd($array_carreras);
            foreach ($array_carreras as $carrera)
            {
                $i=1;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:C1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(2, [
                        'Semestre', 'Masculino', 'Femenino', 'Total', 'Porcentaje'
                    ]);
                    foreach ($carrera['semestres'] as $semestre)
                    {
                        foreach ($semestre['datos'] as $dato)
                        {
                            $i++;
                            $sheet->row($i+1, [
                                $semestre['nom_semestre'], $dato['masculino'], $dato['femenino'], $dato['total'], round((($dato['total']*100)/$carrera['tot_gral']), 2).'%'
                            ]);
                        }
                    }
                    $sheet->row($i+2, [
                        'TOTAL', $carrera['tot_masculino'], $carrera['tot_femenino'], ($carrera['tot_masculino'] + $carrera['tot_femenino']),
                    ]);
                });
            }
        })->export('xlsx');
    }
    public function exportMunicipios()
    {
        Excel::create('EstudiantesPorMunicipio',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {
                $tot_municipio=0;
                $dat_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_carreras['nom_carrera'] = $carrera->nombre;
                $dat_carreras['siglas'] = $carrera->siglas;
                $datos_municipios=DB::select('SELECT COUNT(gnral_alumnos.id_municipio) cantidad,gnral_municipios.nombre_municipio municipio
            FROM gnral_alumnos,gnral_municipios,eva_validacion_de_cargas  WHERE
           eva_validacion_de_cargas.estado_validacion IN (2,8,9) and 
               eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                eva_validacion_de_cargas.id_periodo='.$periodo.'  AND
            gnral_alumnos.id_municipio=gnral_municipios.id_municipio AND
            id_carrera='.$carrera->id_carrera.' GROUP BY gnral_municipios.id_municipio ORDER BY cantidad DESC');
                $array_municipios=array();
                foreach ($datos_municipios as $dato)
                {
                    $dat_mpios['municipio']=$dato->municipio;
                    $dat_mpios['cantidad']=$dato->cantidad;
                    array_push($array_municipios,$dat_mpios);
                    $tot_municipio+=$dato->cantidad;
                }
                $dat_carreras['dat_mpios']=$array_municipios;
                $dat_carreras['tot_mun_carrera']=$tot_municipio;
                array_push($array_carreras,$dat_carreras);
            }

            foreach ($array_carreras as $carrera)
            {
                $i=1;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:E1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(2, [
                        'Municipio', 'Cantidad', 'Porcentaje'
                    ]);
                    foreach ($carrera['dat_mpios'] as $municipio)
                    {
                        $i++;
                        $sheet->row($i+1, [
                            $municipio['municipio'], $municipio['cantidad'], round((($municipio['cantidad']*100)/$carrera['tot_mun_carrera']), 1).'%'
                        ]);
                    }
                    $sheet->row($i+2, [
                        'TOTAL', $carrera['tot_mun_carrera'],
                    ]);
                });
            }
            //dd($array_carreras);
        })->export('xlsx');
    }
    public function exportEdades()
    {
        Excel::create('EstudiantesPorEdad',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {
                $tot_edades=0;
                $dat_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_carreras['nom_carrera'] = $carrera->nombre;
                $dat_carreras['siglas'] = $carrera->siglas;
                $datos_edades=DB::select('SELECT COUNT(gnral_alumnos.id_alumno) cantidad,edad FROM gnral_alumnos, eva_validacion_de_cargas WHERE 
 eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and eva_validacion_de_cargas.id_periodo='.$periodo.' 
  and eva_validacion_de_cargas.estado_validacion  IN (2,8,9)and   edad!=\'\'GROUP BY edad');
                $array_edades=array();
                foreach ($datos_edades as $dato)
                {
                    $dat_edades['edad']=$dato->edad;
                    $dat_edades['cantidad']=$dato->cantidad;
                    $tot_edades+=$dato->cantidad;
                    array_push($array_edades,$dat_edades);
                }
                $dat_carreras['dat_edades']=$array_edades;
                $dat_carreras['tot_edad_carrera']=$tot_edades;
                array_push($array_carreras,$dat_carreras);
            }

            foreach ($array_carreras as $carrera)
            {
                $i=1;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:E1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(2, [
                        'Edad', 'Cantidad', 'Porcentaje'
                    ]);
                    foreach ($carrera['dat_edades'] as $edad)
                    {
                        $i++;
                        $sheet->row($i+1, [
                            $edad['edad'], $edad['cantidad'], round((($edad['cantidad']*100)/$carrera['tot_edad_carrera']), 1).'%'
                        ]);
                    }
                    $sheet->row($i+2, [
                        'TOTAL', $carrera['tot_edad_carrera'],
                    ]);
                });
            }
        })->export('xlsx');
    }
    public function exportIndRep()
    {
        Excel::create('IndRep',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $semestres=DB::select('SELECT * FROM gnral_semestres');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {
                $tot_edades=0;
                $dat_ind_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_ind_carreras['nom_carrera'] = $carrera->nombre;
                $dat_ind_carreras['siglas'] = $carrera->siglas;
                $array_ind_semestres=array();
                foreach ($semestres as $semestre)
                {
                    $dat_ind_semestres['id_semestre']=$semestre->id_semestre;
                    $dat_ind_semestres['nom_semestre']=$semestre->descripcion;
                    $materias_ind=DB::select('select  DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.id_materia,gnral_materias.nombre mat, gnral_semestres.id_semestre idsem,gnral_carreras.nombre,gnral_carreras.id_carrera,gnral_semestres.descripcion semestre,
                gnral_horas_profesores.grupo grupo, gnral_personales.nombre nombrepro, gnral_personales.id_personal 
                from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                and gnral_semestres.id_semestre='.$semestre->id_semestre.'
                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                and gnral_horarios.id_personal=gnral_personales.id_personal 
                and gnral_materias.id_semestre=gnral_semestres.id_semestre ORDER BY gnral_materias.nombre');
                    $array_ind_materias=array();
                    foreach ($materias_ind as $materia_ind)
                    {
                        $dat_ind_materias['id_materia']=$materia_ind->id_materia;
                        $dat_ind_materias['mat']=$materia_ind->mat;
                        $dat_ind_materias['docente']=$materia_ind->nombrepro;
                        $dat_ind_materias['grupo']=$materia_ind->grupo;
                        $alumnos=DB::select('SELECT COUNT(*) totAlumnos FROM (SELECT gnral_alumnos.id_alumno
                            from gnral_alumnos,eva_carga_academica,cal_unidades,cal_evaluaciones, cal_periodos_califica,gnral_materias,gnral_materias_perfiles,gnral_horas_profesores, gnral_horarios,gnral_periodo_carreras, gnral_periodos,gnral_carreras,eva_tipo_curso,gnral_personales,gnral_semestres 
                            where gnral_periodos.id_periodo='.$periodo.'
                            and gnral_materias.id_materia='.$materia_ind->id_materia.'
                            and gnral_horarios.id_personal='.$materia_ind->id_personal.' 
                            and gnral_horas_profesores.grupo='.$materia_ind->grupo.'
                            and eva_carga_academica.grupo='.$materia_ind->grupo.'
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                            and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                            and cal_unidades.id_unidad=cal_periodos_califica.id_unidad
                            and cal_unidades.id_unidad=cal_evaluaciones.id_unidad
                            and cal_periodos_califica.id_periodos=gnral_periodos.id_periodo
                            and gnral_materias.id_materia=cal_periodos_califica.id_materia
                            and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                            and gnral_horarios.id_personal=gnral_personales.id_personal
                            and gnral_materias.id_materia=eva_carga_academica.id_materia
                            and gnral_materias.id_semestre=gnral_semestres.id_semestre GROUP BY gnral_alumnos.id_alumno) as numAlumnos');

                        $alReprobados=DB::select('SELECT COUNT(*) AS reprobados FROM (select DISTINCT(cal_evaluaciones.id_carga_academica) porcentaje
                        from eva_carga_academica,cal_evaluaciones, cal_periodos_califica,gnral_materias,gnral_materias_perfiles,gnral_horas_profesores, gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_personales
                        where gnral_periodos.id_periodo='.$periodo.'
                        and gnral_materias.id_materia='.$materia_ind->id_materia.'
                        and gnral_horarios.id_personal='.$materia_ind->id_personal.' 
                        and gnral_horas_profesores.grupo='.$materia_ind->grupo.'
                        and eva_carga_academica.grupo='.$materia_ind->grupo.'
                        and cal_evaluaciones.calificacion<70
                        and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                        and eva_carga_academica.id_carga_academica=cal_evaluaciones.id_carga_academica
                        and eva_carga_academica.id_materia=gnral_materias.id_materia
                        and cal_periodos_califica.id_periodos=gnral_periodos.id_periodo
                        and gnral_materias.id_materia=cal_periodos_califica.id_materia
                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                        and gnral_horarios.id_personal=gnral_personales.id_personal GROUP BY id_evaluacion ORDER BY `id_evaluacion` ASC) as rep');
                        $dat_ind_materias['matricula']=$alumnos[0]->totAlumnos;
                        $dat_ind_materias['reprobados']=$alReprobados[0]->reprobados;
                        $dat_ind_materias['ind_rep']=($alumnos[0]->totAlumnos!=0 && $alReprobados[0]->reprobados!=0 ? (round(($alReprobados[0]->reprobados*100)/$alumnos[0]->totAlumnos,2)) :'0');

                        $promedio_grupo=DB::select('SELECT SUM(calificacion) suma,COUNT(calificacion) total FROM (select cal_evaluaciones.calificacion
                        from eva_carga_academica,cal_evaluaciones, cal_periodos_califica,gnral_materias,gnral_materias_perfiles,gnral_horas_profesores, gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_personales
                        where gnral_periodos.id_periodo='.$periodo.'
                        and gnral_materias.id_materia='.$materia_ind->id_materia.'
                        and gnral_horarios.id_personal='.$materia_ind->id_personal.' 
                        and gnral_horas_profesores.grupo='.$materia_ind->grupo.'
                        and eva_carga_academica.grupo='.$materia_ind->grupo.'
                        and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                        and eva_carga_academica.id_carga_academica=cal_evaluaciones.id_carga_academica
                        and eva_carga_academica.id_materia=gnral_materias.id_materia
                        and cal_periodos_califica.id_periodos=gnral_periodos.id_periodo
                        and gnral_materias.id_materia=cal_periodos_califica.id_materia
                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                        and gnral_horarios.id_personal=gnral_personales.id_personal GROUP BY id_evaluacion ORDER BY `id_evaluacion` ASC) as prom');
                        $dat_ind_materias['promedio']= ($promedio_grupo[0]->suma!=0 && $promedio_grupo[0]->total!=0) ? (round($promedio_grupo[0]->suma/$promedio_grupo[0]->total,2)) : '0';
                        array_push($array_ind_materias,$dat_ind_materias);
                    }
                    $dat_ind_semestres['materias']=$array_ind_materias;
                    array_push($array_ind_semestres,$dat_ind_semestres);
                }
                $dat_ind_carreras['semestres']=$array_ind_semestres;
                array_push($array_carreras,$dat_ind_carreras);
            }
            //dd($array_carreras);
                $i=1;
            $excel->sheet("BD REP POR MAT", function($sheet) use($array_carreras,$i)
            {
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  9
                    )
                ));

                foreach ($array_carreras as $carrera)
                {
                    $sheet->row(1, [
                        'CARRERA','MATERIA', 'DOCENTE','GRUPO','MATRICULA','PROMEDIO MATERIA','ALUMNOS REPROBADOS','INDICE DE REPROBACIÓN'
                    ]);
                    foreach ($carrera['semestres'] as $semestre)
                    {
                        foreach ($semestre['materias'] as $materia)
                        {
                            $i++;
                            $sheet->row($i, [
                                $carrera['nom_carrera'],$materia['mat'], $materia['docente'], $materia['grupo'], $materia['matricula'],$materia['promedio'],$materia['reprobados'], $materia['ind_rep']."%"
                            ]);
                        }
                    }
                }
            });
            /*$excel->sheet("BD REP POR MAT", function($sheet) use($array_carreras,$i)
            {
                $cont_carrera=0;
                foreach ($array_carreras as $carrera)
                {
                    $sheet->mergeCells('A1:E1');
                    $sheet->row(1, [
                        "Tecnológico de Estudios Superiores de Valle de Bravo"
                    ]);
                    $sheet->row(($i+$cont_carrera), [
                        $carrera['nom_carrera']
                    ]);
                    $i++;
                    foreach ($carrera['semestres'] as $semestre)
                    {
                        $sheet->row(($i+$cont_carrera), [
                            $semestre['nom_semestre']
                        ]);
                        $cont_carrera++;
                    }
                }
            });*/

        })->export('xlsx');
    }
    public function exportDatosGeneralesAlumnos()
    {
        Excel::create('DatosGeneralesAlumnos',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {

                $dat_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_carreras['nom_carrera'] = $carrera->nombre;
                $dat_carreras['siglas'] = $carrera->siglas;
                $datos_generales=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
gnral_alumnos.apaterno, 
gnral_alumnos.amaterno,gnral_alumnos.genero,gnral_alumnos.fecha_nac,
gnral_alumnos.edad,gnral_alumnos.curp_al,gnral_alumnos.edo_civil,
gnral_alumnos.nacionalidad,gnral_alumnos.correo_al,gnral_alumnos.cel_al,
gnral_alumnos.grado_estudio_al,gnral_carreras.nombre carrera,gnral_semestres.descripcion semestre,
gnral_alumnos.grupo,gnral_alumnos.promedio_preparatoria,gnral_estados.nombre_estado,
gnral_municipios.nombre_municipio,gnral_alumnos.calle_al,gnral_alumnos.n_ext_al numero_exterior,
gnral_alumnos.n_int_al numero_interior,gnral_alumnos.entre_calle,
gnral_alumnos.y_calle,gnral_alumnos.otra_ref,
gnral_alumnos.colonia_al,gnral_alumnos.cp,gnral_alumnos.discapacidad,
gnral_alumnos.descripcion_discapacidad,gnral_alumnos.lengua,gnral_alumnos.descripcion_lengua,
gnral_alumnos.id_seguro_social seguro,gnral_alumnos.numero_seguro_social,gnral_alumnos.id_semestre,gnral_alumnos.id_escuela_procedencia FROM
 gnral_alumnos,eva_validacion_de_cargas,gnral_carreras,
 gnral_semestres,gnral_grupos,gnral_estados,gnral_municipios WHERE
 gnral_grupos.id_grupo=gnral_alumnos.grupo and 
 gnral_alumnos.estado=gnral_estados.id_estado and 
 gnral_alumnos.id_municipio=gnral_municipios.id_municipio and 
 gnral_alumnos.id_semestre=gnral_semestres.id_semestre AND
 gnral_carreras.id_carrera=gnral_alumnos.id_carrera AND eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
  and eva_validacion_de_cargas.id_periodo='.$periodo.' and eva_validacion_de_cargas.estado_validacion in (2,8,9) 
  and gnral_carreras.id_carrera='.$carrera->id_carrera.'  ORDER BY gnral_alumnos.apaterno ASC');

                $array_generales=array();
                foreach ($datos_generales as $dato)
                {
                    $tutor=DB::selectOne('SELECT * FROM `eva_tutor` WHERE `id_alumno` ='.$dato->id_alumno.'');
                    $contar_escuela=DB::selectOne('SELECT count(id_alumno) contar from gnral_alumnos,gnral_escuela_procedencia 
where gnral_alumnos.id_escuela_procedencia=gnral_escuela_procedencia.id_escuela_procedencia and gnral_alumnos.id_alumno='.$dato->id_alumno.' ');
                    $contar_escuela=$contar_escuela->contar;
                    $dat_generales['cuenta']=$dato->cuenta;
                    $dat_generales['nombre']=$dato->nombre;
                    $dat_generales['apaterno']=$dato->apaterno;
                    $dat_generales['amaterno']=$dato->amaterno;
                    $dat_generales['genero']=$dato->genero;
                    $dat_generales['fecha_nac']=$dato->fecha_nac;
                    $dat_generales['edad']=$dato->edad;
                    $dat_generales['curp_al']=$dato->curp_al;
                    $dat_generales['edo_civil']=$dato->edo_civil;
                    $dat_generales['nacionalidad']=$dato->nacionalidad;
                    $dat_generales['correo_al']=$dato->correo_al;
                    $dat_generales['cel_al']=$dato->cel_al;
                    $dat_generales['grado_estudio_al']=$dato->grado_estudio_al;
                    $dat_generales['carrera']=$dato->carrera;
                    $dat_generales['semestre']=$dato->semestre;
                    $dat_generales['grupo']=$dato->id_semestre."0".$dato->grupo;
                    $dat_generales['promedio']=$dato->promedio_preparatoria;
                    $dat_generales['nombre_estado']=$dato->nombre_estado;
                    $dat_generales['nombre_municipio']=$dato->nombre_municipio;
                    $dat_generales['calle_al']=$dato->calle_al;
                    $dat_generales['numero_exterior']=$dato->numero_exterior;
                    $dat_generales['numero_interior']=$dato->numero_interior;
                    $dat_generales['entre_calle']=$dato->entre_calle;
                    $dat_generales['y_calle']=$dato->y_calle;
                    $dat_generales['otra_ref']=$dato->otra_ref;
                    $dat_generales['colonia_al']=$dato->colonia_al;
                    $dat_generales['cp']=$dato->cp;
                    if($dato->discapacidad==1)
                    {
                        $dat_generales['discapacidad']='NO';
                    }
                    if($dato->discapacidad==2)
                    {
                        $dat_generales['discapacidad']='SI';
                    }
                    $dat_generales['descripcion_discapacidad']=$dato->descripcion_discapacidad;
                    if($dato->lengua == 1)
                    {
                        $dat_generales['lengua']='NO';
                    }
                    if($dato->lengua == 2)
                    {
                        $dat_generales['lengua']='SI';
                    }
                    $dat_generales['descripcion_lengua']=$dato->descripcion_lengua;
                    if($dato->seguro == 0)
                    {
                        $dat_generales['seguro']='No selecciono';
                    }
                    if($dato->seguro == 1)
                    {
                        $dat_generales['seguro']='IMSS';

                    }
                    if($dato->seguro == 2)
                    {
                        $dat_generales['seguro']='ISSSTE';
                    }
                    if($dato->seguro == 3)
                    {
                        $dat_generales['seguro']='ISSEMYM';
                    }
                    if($dato->seguro == 4)
                    {
                        $dat_generales['seguro']='SEGURO POPULAR';
                    }

                    $dat_generales['numero_seguro_social']=$dato->numero_seguro_social;

                    $dat_generales['nombre_tutor']=$tutor->nombre;
                    $dat_generales['apaterno_tutor']=$tutor->ap_paterno_T;
                    $dat_generales['amaterno_tutor']=$tutor->ap_mat_T;
                    $dat_generales['curp_tutor']=$tutor->curp;
                    $dat_generales['fecha_nac_tutor']=$tutor->fecha_nac_T;
                    $dat_generales['correo_tutor']=$tutor->correo_t;
                    $genero_tutor=substr($tutor->curp, 10,1);
                    if($genero_tutor == "H"){
                        $genero_tutor="M";
                    }else {
                        $genero_tutor = "F";
                    }
                    $dat_generales['sexo_tutor']=$genero_tutor;
                    $dat_generales['parentezco_tutor']=$tutor->parentezco;
                    $dat_generales['telefono_tutor']=$tutor->cel_t;
                    if($contar_escuela ==0){
                        $dat_generales['nombre_escuela']="";
                        $dat_generales['estado_escuela']="";
                        $dat_generales['municipio_escuela']="";
                    }else{
                        $escuela_procedencia=DB::selectOne('SELECT * FROM `gnral_escuela_procedencia` WHERE `id_escuela_procedencia` = '.$dato->id_escuela_procedencia.' ');

                        $dat_generales['nombre_escuela']=$escuela_procedencia->nombre_escuela;
                        $dat_generales['estado_escuela']=$escuela_procedencia->estado;
                        $dat_generales['municipio_escuela']=$escuela_procedencia->municipio;
                    }

                    array_push($array_generales,$dat_generales);
                }
                $dat_carreras['dat_general']=$array_generales;
                array_push($array_carreras,$dat_carreras);
            }
          // dd($array_carreras);

            foreach ($array_carreras as $carrera)
            {
                $i=2;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:E1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(2, [
                        'Cuenta', 'Nombre','Apellido paterno','Apellido materno','Genero','Fecha nacimiento','Edad','Curp','Estado civil','Nacionalidad','Correo','Celular','Grado de estudios','Carrera','Semestre','Grupo','Promedio de Preparatoria','Estado','Municipio','Calle','Número exterior',
                        'Número interior','Entre calle','Y calle','Otra referencia','Colonia','Codigo postal','Discapacidad','Descripción discapacidad',
                        'Lengua','Tipo lengua','Seguro','Número de seguro social','','', 'Nombre de la escuela de procedencia', 'Estado de la escuela de procedencia', 'Municipio de la escuela de procedencia','','Curp del tutor','Nombre del tutor','Apellido Paterno del tutor','Apellido Materno del tutor','Fecha de nacimiento del tutor','Correo electronico del tutor','Genero del tutor','Parentezco del alumno','Telefono del tutor'
                    ]);
                    foreach ($carrera['dat_general'] as $generales)
                    {

                        $i++;
                        $sheet->row($i, [
                            $generales['cuenta'],$generales['nombre'],$generales['apaterno'],$generales['amaterno'],$generales['genero'],
                            $generales['fecha_nac'],$generales['edad'],$generales['curp_al'],$generales['edo_civil'],$generales['nacionalidad'],
                            $generales['correo_al'],$generales['cel_al'],$generales['grado_estudio_al'],$generales['carrera'],$generales['semestre'],
                            $generales['grupo'],$generales['promedio'],$generales['nombre_estado'],$generales['nombre_municipio'],$generales['calle_al'],
                            $generales['numero_exterior'],$generales['numero_interior'],$generales['entre_calle'],$generales['y_calle'],$generales['otra_ref'],
                            $generales['colonia_al'],$generales['cp'],$generales['discapacidad'],$generales['descripcion_discapacidad'],
                            $generales['lengua'],$generales['descripcion_lengua'],$generales['seguro'],$generales['numero_seguro_social'],'','',
                            $generales['nombre_escuela'],$generales['estado_escuela'],$generales['municipio_escuela'],'',
                            $generales['curp_tutor'],$generales['nombre_tutor'],$generales['apaterno_tutor'],$generales['amaterno_tutor'],$generales['fecha_nac_tutor'],
                            $generales['correo_tutor'],$generales['sexo_tutor'],$generales['parentezco_tutor'],$generales['telefono_tutor'],
                        ]);
                    }

                });
            }
        })->export('xlsx');
    }
    public function concentrado_calificaciones($id_carrera,$id_semestre,$grupo)
    {
        Session::put('concentrado_id_carrera',$id_carrera);
        Session::put('concentrado_id_semestre',$id_semestre);
        Session::put('concentrado_id_grupo',$grupo);
        $carr=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        $carr=$carr->nombre;


        Excel::create('Concentrado_'.$carr.'_'.$id_semestre.'0'.$grupo,function ($excel)
        {
            $id_periodo=Session::get('periodo_actual');
            $id_carrera=Session::get('concentrado_id_carrera');
            $id_semestre=Session::get('concentrado_id_semestre');
            $grupo=Session::get('concentrado_id_grupo');
            $alumnos = DB::select('SELECT  gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_validacion_de_cargas.estado_validacion FROM eva_carga_academica,gnral_materias, gnral_alumnos,
eva_validacion_de_cargas,gnral_reticulas WHERE  gnral_materias.id_semestre=' . $id_semestre . ' 
and gnral_reticulas.id_carrera=' . $id_carrera . ' and gnral_materias.id_reticula=gnral_reticulas.id_reticula and 
eva_carga_academica.id_materia = gnral_materias.id_materia AND eva_carga_academica.id_status_materia = 1 
AND eva_carga_academica.id_periodo = ' . $id_periodo . ' AND eva_carga_academica.grupo = ' . $grupo . ' 
and gnral_alumnos.id_alumno=eva_carga_academica.id_alumno and
  eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and 
eva_validacion_de_cargas.estado_validacion in (2,9,10) GROUP by gnral_alumnos.id_alumno  
ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre  ASC');
            // dd($alumnos);

            $materias = DB::select('select DISTINCT  gnral_periodo_carreras.id_carrera,gnral_horas_profesores.grupo,gnral_materias.creditos,gnral_materias.id_semestre,gnral_materias.unidades,gnral_materias.id_materia, gnral_materias.clave,gnral_materias.nombre materia,abreviaciones.titulo,gnral_personales.nombre,gnral_horarios.aprobado FROM 
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales, 
            hrs_rhps,gnral_periodo_carreras,abreviaciones_prof,abreviaciones WHERE 
            gnral_periodo_carreras.id_carrera=' . $id_carrera . ' AND 
            gnral_periodo_carreras.id_periodo=' . $id_periodo . ' AND 
            gnral_materias.id_semestre=' . $id_semestre . ' AND 
            gnral_horas_profesores.grupo=' . $grupo . ' AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND  
            gnral_horarios.id_personal=gnral_personales.id_personal AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND 
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor and abreviaciones_prof.id_personal=gnral_personales.id_personal 
            and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion  order by gnral_materias.nombre ASC ');

            $array_mat=array();
            $array_mat_sin=array();
            $mat_calificada=0;
            $mat_sin_cal=0;
            foreach ($materias as $materia) {
                $calificada=DB::selectOne('SELECT count(id_calificar_sumativas) contar_sumativas FROM `gnral_calificar_sumativas` 
           WHERE `id_materia` = '.$materia->id_materia.' AND `id_grupo` = '.$materia->grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$id_periodo.'');
                $calificada=$calificada->contar_sumativas;



                if($calificada == 0) {
                    $mat_sin_cal++;
                    $dat_mater['id_materia'] = $materia->id_materia;
                    $dat_mater['clave'] = $materia->clave;
                    $dat_mater['nombre'] =$materia->titulo.' '.$materia->nombre;
                    $dat_mater['nombre_materia'] = $materia->materia;

                    array_push($array_mat_sin,$dat_mater);
                }
                else{
                    $dat_materiass['id_materia'] = $materia->id_materia;
                    $dat_materiass['clave'] = $materia->clave;
                    $dat_materiass['nombre'] =$materia->titulo.' '.$materia->nombre;
                    $dat_materiass['nombre_materia'] = $materia->materia;
                    $dat_materiass['creditos'] = $materia->creditos;
                    $dat_materiass['te'] = 'TE';
                    $dat_materiass['unidades'] = $materia->unidades;
                    $mat_calificada++;
                    $dat_materiass['status'] =1;
                    array_push($array_mat,$dat_materiass);
                }

            }

            if($mat_calificada ==0){
                return view('servicios_escolares.concentrado_calificaciones.concentrado_materias', compact('mat_calificada'));

            }
            else {


                $numero = 0;
                $materias_calificaciones = array();
                $estado_materias = 0;
                $numero_alumno = 0;
                $promedio_general = 0;
                $numero_promedio_aprobado = 0;
                $numero_promedio_reprobado = 0;
                $porcentaje_final_aprobado = 0;
                $porcentaje_final_reprobado = 0;
                foreach ($alumnos as $alumno) {
                    $numero++;
                    $dat_l['numero'] = $numero;
                    $dat_l['id_alumno'] = $alumno->id_alumno;
                    $dat_l['cuenta'] = $alumno->cuenta;
                    $dat_l['estado_validacion'] = $alumno->estado_validacion;
                    $dat_l['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                    $cal_al = array();
                    $suma_promedio_final = 0;
                    $suma_materia = 0;
                    $estado_materia = 0;
                    foreach ($array_mat as $materiass) {

                        $inscrito = DB::selectOne('SELECT * FROM `eva_carga_academica` 
                  WHERE `id_materia` = ' . $materiass['id_materia'] . ' AND `id_status_materia` = 1 
                  AND `id_periodo` = ' . $id_periodo . ' AND `grupo` = ' . $grupo . ' and id_alumno=' . $alumno->id_alumno . '');
//dd($inscrito);
                        if ($inscrito == null) {
                            $datos_alumnos['id_carga_academica'] = 0;
                            $datos_alumnos['id_materia'] = $materiass['id_materia'];
                            $datos_alumnos['nombre_materia'] = '';
                            $datos_alumnos['estado'] = 1;
                            $datos_alumnos['promedio'] = '';
                            $datos_alumnos['te'] = '';
                        } else {
                            $suma_materia++;
                            $datos_alumnos['id_carga_academica'] = $inscrito->id_carga_academica;
                            $datos_alumnos['id_materia'] = $inscrito->id_materia;
                            $datos_alumnos['nombre_materia'] = $materiass['nombre_materia'];
                            $datos_alumnos['estado'] = 2;


                            $materia_promedio = DB::selectOne('SELECT SUM(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` =' . $inscrito->id_carga_academica . ' and calificacion >=70');
                            $materia_promedio = $materia_promedio->suma;

                            $contar_unidades_pasadas = DB::selectOne('SELECT count(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` = ' . $inscrito->id_carga_academica . ' and calificacion >=70');
                            $contar_unidades_pasadas = $contar_unidades_pasadas->suma;

                            $contar_unidades_sumativas = DB::selectOne('SELECT count(calificacion) num FROM `cal_evaluaciones` WHERE `id_carga_academica` = ' . $inscrito->id_carga_academica . ' and esc=1');
                            $contar_unidades_sumativas = $contar_unidades_sumativas->num;

                            if ($contar_unidades_pasadas == $materiass['unidades']) {
                                if ($materia_promedio == 0) {
                                    $promedio = 0;
                                } else {
                                    $promedio = round($materia_promedio / $materiass['unidades']);
                                }
                                if ($inscrito->id_tipo_curso == 1 and $contar_unidades_sumativas == 0) {
                                    $te = 'O';
                                    $valor = 10;
                                    $estado_materia += $valor;
                                } elseif ($inscrito->id_tipo_curso == 1 and $contar_unidades_sumativas > 0) {
                                    $te = 'ESC';
                                    $valor = 10;
                                    $estado_materia += $valor;
                                } elseif ($inscrito->id_tipo_curso == 2 and $contar_unidades_sumativas == 0) {
                                    $te = 'O2';
                                    $valor = 100;
                                    $estado_materia += $valor;
                                } elseif ($inscrito->id_tipo_curso == 2 and $contar_unidades_sumativas > 0) {
                                    $te = 'ESC2';
                                    $valor = 100;
                                    $estado_materia += $valor;
                                }
                                if ($inscrito->id_tipo_curso == 3 and $contar_unidades_sumativas == 0) {
                                    $te = 'CE';
                                    $valor = 1000;
                                    $estado_materia += $valor;
                                }
                                if ($inscrito->id_tipo_curso == 3 and $contar_unidades_sumativas > 0) {
                                    $te = 'EG';
                                    $valor = 1000;
                                    $estado_materia += $valor;
                                }
                                if ($inscrito->id_tipo_curso == 4) {
                                    $te = 'EG';
                                    $valor = 10000;
                                    $estado_materia += $valor;
                                }
                            } else {

                                if ($materia_promedio == 0) {
                                    $promedio = 0;
                                } else {
                                    $promedio = 0;
                                }
                                if ($inscrito->id_tipo_curso == 1) {
                                    $te = 'ESC';
                                    $valor = 10;
                                    $estado_materia += $valor;
                                }
                                if ($inscrito->id_tipo_curso == 2) {
                                    $te = 'ESC2';
                                    $valor = 100;
                                    $estado_materia += $valor;
                                }
                                if ($inscrito->id_tipo_curso == 3) {
                                    $valor = 1000;
                                    $estado_materia += $valor;
                                    $te = 'EG';
                                }
                                if ($inscrito->id_tipo_curso == 4) {
                                    $valor = 10000;
                                    $estado_materia += $valor;
                                    $te = 'EG';
                                }


                            }
                            $datos_alumnos['promedio'] = $promedio;
                            $datos_alumnos['te'] = $te;
                            $suma_promedio_final += $promedio;

                        }

                        array_push($cal_al, $datos_alumnos);
                    }
                    $estado_materias = $estado_materia;
                    if ($estado_materias < 100) {
                        $estado_al = 1;

                    } elseif ($estado_materias < 1000) {
                        $estado_al = 2;
                    } elseif ($estado_materias < 10000) {
                        $estado_al = 3;
                    } elseif ($estado_materias < 100000) {
                        $estado_al = 4;
                    }
                    if ($suma_promedio_final == 0) {
                        $promedio_f = 0;
                    } else {
                        $promedio_f = $suma_promedio_final / $suma_materia;
                    }
                    if ($alumno->estado_validacion != 10) {
                        $numero_alumno++;
                        $promedio_general += number_format($promedio_f, 2, '.', ' ');
                        $pro_al = number_format($promedio_f, 2, '.', ' ');
                        if ($pro_al >= 70) {
                            $numero_promedio_aprobado++;
                        } else {
                            $numero_promedio_reprobado++;
                        }

                    }
                    $dat_l['promedio_f'] = number_format($promedio_f, 2, '.', ' ');
                    $dat_l['l'] = $cal_al;
                    $dat_l['estado_alumno'] = $estado_al;
                    array_push($materias_calificaciones, $dat_l);
                }
                $promedio_general = $promedio_general / $numero_alumno;
               // dd($array_mat);

//dd($materias_calificaciones);
                $com = array();
                foreach ($array_mat as $mater) {
                    $esta = false;

                    $contar_alumnos = 0;
                    $contar_reprobados = 0;
                    $contar_aprobados = 0;
                    $suma_promedioss = 0;
                    $bajas = 0;
                    foreach ($materias_calificaciones as $cal) {
                        if ($cal['estado_validacion'] != 10) {
                            foreach ($cal['l'] as $mate) {
                                if ($mater['id_materia'] == $mate['id_materia']) {
                                    if ($mate['estado'] == 2) {
                                        $contar_alumnos++;
                                        if ($mate['promedio'] < 70) {
                                            $contar_reprobados++;
                                        } else {
                                            $contar_aprobados++;
                                        }
                                        $suma_promedioss += $mate['promedio'];
                                        if ($mate['te'] == 'EG') {
                                            $bajas++;
                                        }
                                    }
                                    $esta = true;
                                    break;
                                } // esta es la que se me olvidaba
                            }
                        } else {
                            $bajas++;
                        }
                    }
                    $compra['id_materia'] = $mater['id_materia'];
                    $compra['nombre_materia'] = $mater['nombre_materia'];
                    $compra['creditos'] = $mater['creditos'];
                    $compra['aprobados'] = $contar_aprobados;
                    $compra['reprobados'] = $contar_reprobados;
                    $compra['suma_promedios'] = $suma_promedioss;
                    $compra['bajas'] = $bajas;
                    $compra['total'] = $contar_alumnos;
                    array_push($com, $compra);
                }
                $i=3;





                $excel->sheet(''.$id_semestre.'0'.$grupo, function($sheet) use($i,$id_semestre,$grupo,$id_carrera,$numero_promedio_reprobado,$numero_promedio_aprobado,$numero_alumno,$promedio_general,$mat_sin_cal,$array_mat_sin,$com,$array_mat,$mat_calificada,$materias_calificaciones,$bajas)
                {
                    $sheet->loadView('servicios_escolares.concentrado_calificaciones.concentrado_excel',compact('id_semestre','grupo','id_carrera','numero_promedio_reprobado','numero_promedio_aprobado','numero_alumno','promedio_general','mat_sin_cal','array_mat_sin','com','array_mat','mat_calificada','materias_calificaciones','bajas'))
                      ;
                    $sheet->setOrientation('landscape');


                    });



                //dd($array_carreras);
            }
        })->export('xlsx');

    }
    public function promedio_alumnos_semestres_excel($id_carrera,$id_semestre){
        Session::put('promedio_id_carrera',$id_carrera);
        Session::put('promedio_id_semestre',$id_semestre);

        $carr=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        $carr=$carr->nombre;
       $nombre_p= Session::get('nombre_periodo');


        Excel::create('PROMEDIO_'.$carr.'_SEMESTRE_'.$id_semestre.'_'.$nombre_p,function ($excel)
        {
            $id_periodo=Session::get('periodo_actual');
            $id_carrera=Session::get('promedio_id_carrera');
            $id_semestre=Session::get('promedio_id_semestre');


            $alumnos = DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,eva_validacion_de_cargas.estado_validacion from gnral_alumnos,eva_validacion_de_cargas 
where gnral_alumnos.id_carrera=' . $id_carrera . ' and gnral_alumnos.id_semestre=' . $id_semestre . ' and 
gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno and 
eva_validacion_de_cargas.id_periodo=' . $id_periodo . ' and 
eva_validacion_de_cargas.estado_validacion in (2,9,10)  
ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC');
            $array_datos_alumnos = array();
            $numero1=0;
            foreach ($alumnos as $alumno) {
                $numero1++;
                $datos_alumnos['numero1'] = $numero1;
                $datos_alumnos['id_alumno'] = $alumno->id_alumno;
                $datos_alumnos['cuenta'] = $alumno->cuenta;
                $datos_alumnos['nombre'] = $alumno->nombre;
                $datos_alumnos['apaterno'] = $alumno->apaterno;
                $datos_alumnos['amaterno'] = $alumno->amaterno;
                $datos_alumnos['estado'] = $alumno->estado_validacion;

                $carga_academica = DB::table('eva_carga_academica')
                    ->join('gnral_materias','gnral_materias.id_materia','=','eva_carga_academica.id_materia')
                    ->join('eva_tipo_curso','eva_tipo_curso.id_tipo_curso','=','eva_carga_academica.id_tipo_curso')
                    ->join('gnral_semestres','gnral_semestres.id_semestre','=','gnral_materias.id_semestre')
                    ->where('id_periodo', '=', $id_periodo)
                    ->where('id_alumno', '=', $alumno->id_alumno)
                    ->where('id_status_materia', '=', 1)
                    ->select('eva_carga_academica.id_carga_academica','eva_carga_academica.id_tipo_curso','eva_tipo_curso.nombre_curso','gnral_materias.*','gnral_semestres.descripcion as semestre')
                    ->get();
                $suma_promedio_final=0;
                $suma_materia=0;
                $alumnos= array();
                foreach($carga_academica as $materias){
                    $suma_materia++;
                    $datos_alumnos['numero']=$suma_materia;
                    $datos_alumnos['id_carga_academica']=$materias->id_carga_academica;
                    $datos_alumnos['id_materia']=$materias->id_materia;
                    $datos_alumnos['nombre_materia']=$materias->nombre;
                    $datos_alumnos['semestre']=$materias->semestre;
                    $datos_alumnos['clave']=$materias->clave;

                    $materia_promedio=DB::selectOne('SELECT SUM(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` ='.$materias->id_carga_academica.' and calificacion >=70');
                    $materia_promedio=$materia_promedio->suma;

                    $contar_unidades_pasadas=DB::selectOne('SELECT count(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` = '.$materias->id_carga_academica.' and calificacion >=70');
                    $contar_unidades_pasadas=$contar_unidades_pasadas->suma;
                    if($contar_unidades_pasadas ==$materias->unidades){
                        if($materia_promedio == 0){
                            $promedio=0;
                        }
                        else{
                            $promedio=round($materia_promedio/$materias->unidades);
                        }
                        if($materias->id_tipo_curso ==1){
                            $te='O';
                        }

                        if($materias->id_tipo_curso ==2){
                            $te='O2';
                        }
                        if($materias->id_tipo_curso ==3){
                            $te='CE';
                        }
                        if($materias->id_tipo_curso ==3){
                            $te='EG';
                        }
                    }
                    else{

                        if($materia_promedio == 0){
                            $promedio=0;
                        }
                        else{
                            $promedio=0;
                        }
                        if($materias->id_tipo_curso ==1){
                            $te='ESC';
                        }
                        if($materias->id_tipo_curso ==2){
                            $te='ESC2';
                        }
                        if($materias->id_tipo_curso ==3){
                            $te='EG';
                        }
                        if($materias->id_tipo_curso ==4){
                            $te='EG';
                        }



                    }
                    $datos_alumnos['promedio']=$promedio;
                    $datos_alumnos['te']=$te;
                    $suma_promedio_final+=$promedio;
                    array_push($alumnos,$datos_alumnos);
                }
                if($suma_promedio_final > 0){
                    $promedio_final=($suma_promedio_final/$suma_materia);
                    $promedio_final = number_format($promedio_final, 2, '.', ' ');
                }
                else{
                    $promedio_final=0;
                }
                $datos_alumnos['promedio_final']=$promedio_final;
                array_push($array_datos_alumnos, $datos_alumnos);

            }

                $i=3;





                $excel->sheet(''.$id_semestre, function($sheet) use($i,$id_semestre,$id_carrera,$array_datos_alumnos)
                {
                    $sheet->loadView('servicios_escolares.promedio_al_periodo.promedio_alumnos_excel',compact('id_semestre','id_carrera','array_datos_alumnos'))
                    ;
                    $sheet->setOrientation('landscape');


                });



                //dd($array_carreras);

        })->export('xlsx');

    }

    public function  exportar_social_servicio(Request $request)
    {
        $this->validate($request,[
            'id_periodo' => 'required',
        ]);
        $id_periodo = $request->input("id_periodo");
        Session::put('id_periodo_social',$id_periodo);

        Excel::create('DatosGeneralesAlumnos',function ($excel)
        {



            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {
                $periodo=Session::get('id_periodo_social');
                $dat_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_carreras['nom_carrera'] = $carrera->nombre;
                $dat_carreras['siglas'] = $carrera->siglas;
                $datos_generales=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,
gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno,gnral_alumnos.genero,serv_datos_alumnos.correo_electronico,
   gnral_alumnos.cel_al    
FROM gnral_alumnos,gnral_carreras,serv_datos_alumnos,serv_constancia_presentacion 
WHERE gnral_carreras.id_carrera=gnral_alumnos.id_carrera 
and gnral_carreras.id_carrera='.$carrera->id_carrera.' and 
gnral_alumnos.id_alumno=serv_datos_alumnos.id_alumno and
 serv_datos_alumnos.id_alumno=serv_constancia_presentacion.id_alumno 
 and serv_constancia_presentacion.id_periodo='.$periodo.' and
  serv_datos_alumnos.id_estado_presentacion=4 
  ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC ');
                       $array_generales=array();
                foreach ($datos_generales as $dato)
                {
                    $dat_generales['cuenta']=$dato->cuenta;
                    $dat_generales['nombre']=$dato->nombre;
                    $dat_generales['apaterno']=$dato->apaterno;
                    $dat_generales['amaterno']=$dato->amaterno;
                    $dat_generales['genero']=$dato->genero;
                    $dat_generales['correo_electronico']=$dato->correo_electronico;
                    $dat_generales['celular']=$dato->cel_al;

                    array_push($array_generales,$dat_generales);
                }
                $dat_carreras['dat_general']=$array_generales;
                array_push($array_carreras,$dat_carreras);
            }
            // dd($array_carreras);

            foreach ($array_carreras as $carrera)
            {
                $i=2;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:E1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(2, [
                        'Cuenta', 'Nombre','Apellido paterno','Apellido materno','Genero','Celular','Correo Electronico'
                    ]);
                    foreach ($carrera['dat_general'] as $generales)
                    {

                        $i++;
                        $sheet->row($i, [
                            $generales['cuenta'],$generales['nombre'],$generales['apaterno'],$generales['amaterno'],$generales['genero'],$generales['celular'],$generales['correo_electronico']
                        ]);
                    }

                });
            }
        })->export('xlsx');
        return back();
    }


}
