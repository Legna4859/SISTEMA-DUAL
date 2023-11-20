<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\EvidenciaAlumno;
use App\EvaluacionEvidencias;
use Session;



class ConsultaGenralProfController extends Controller
{



    public function index()
    {

    $usuario = Session::get('usuario_alumno');
    $periodo=Session::get('periodo_actual');

        $personall=DB::selectOne('select gnral_personales.id_personal from gnral_personales,users
                                    where gnral_personales.tipo_usuario=users.id
                                    and gnral_personales.tipo_usuario='.$usuario.'');
        $persona=$personall->id_personal;



        $docente_actividad=DB::selectOne('select actcomple_docente_actividad.id_docente_actividad
                                        from actcomple_docente_actividad,gnral_personales,actividades_complementarias 
                                        where gnral_personales.id_personal=actcomple_docente_actividad.id_personal 
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple 
                                        and actcomple_docente_actividad.id_periodo='.$periodo.'
                                        and gnral_personales.id_personal='.$persona.'');
        $docente_act=(isset($docente_actividad->id_docente_actividad)?$docente_actividad->id_docente_actividad:0);


        $carrera_act=DB::selectOne('select gnral_carreras.id_carrera 
                                from gnral_carreras,actcomple_docente_actividad,actividades_complementarias,actcomple_jefaturas
                                where actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                and actcomple_docente_actividad.id_periodo='.$periodo.'
                                and actcomple_docente_actividad.id_docente_actividad='.$docente_act.'');
        $carrera=isset($carrera_act->id_carrera)?$carrera_act->id_carrera:0;
        //dd($carrera);


        $evaluacioon=DB::select('Select actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_semestres.descripcion semestre,
                                gnral_carreras.nombre carrera,actividades_complementarias.descripcion actividad,actividades_complementarias.horas,actcomple_registros_coordinadores.no_evidencias evidencias,
                                actcomple_registros_coordinadores.rubrica,actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion promedio
                                from actcomple_registro_alumnos,gnral_alumnos,gnral_semestres,gnral_carreras,actividades_complementarias,actcomple_docente_actividad,gnral_personales,
                                actcomple_evidencias_alumno,actcomple_registros_coordinadores,gnral_periodo_carreras,gnral_periodos
                                where gnral_periodos.id_periodo='.$periodo.'
                                and gnral_personales.id_personal='.$persona.'
                                 and actcomple_docente_actividad.id_periodo='.$periodo.'
                                and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                and actcomple_registro_alumnos.id_semestre=gnral_semestres.id_semestre
                                and gnral_alumnos.id_carrera=gnral_carreras.id_carrera
                                and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                and actcomple_docente_actividad.id_personal=gnral_personales.id_personal
                                and actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                                and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo    
                                group by id_registro_alumno,cuenta,apaterno,amaterno,nombre,semestre,carrera,actividad,horas,evidencias,rubrica,id_actividad_comple');
        //dd($evaluacioon);
        $contador=count($evaluacioon);
        for ($i=0; $i < $contador ; $i++) 
        { 
            $registro=($evaluacioon[$i]->id_registro_alumno);
            $promedio=0;
            
            $evidencia=DB::Select('Select actcomple_evidencias_alumno.id_evidencia_alumno from actcomple_evidencias_alumno,actcomple_registro_alumnos
                                    where actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                                    and actcomple_registro_alumnos.id_registro_alumno='.$registro.'');

            $cont=count($evidencia);

            for ($j=0; $j < $cont ; $j++) 
            { 
                $evidencia_eva=DB::selectOne('select actcomple_evaluaciones.id_evaluacion,actcomple_evaluaciones.calificacion 
                                            from actcomple_evaluaciones,actcomple_evidencias_alumno
                                            where actcomple_evidencias_alumno.id_evidencia_alumno=actcomple_evaluaciones.id_evidencia_alumno
                                            and actcomple_evidencias_alumno.id_evidencia_alumno='.$evidencia[$j]->id_evidencia_alumno.'');
                if ($evidencia_eva==null) 
                {
                    $promedio=$promedio+0;

                }
                else
                {
                    $promedio=$promedio+($evidencia_eva->calificacion);
                }
            }

            $promedio=$promedio/$cont;
            $promedio=round($promedio);
            $promedio=intval($promedio);
         
            $evaluacioon[$i]->promedio=$promedio;


         
        }
 



        return view('actividades_complementarias.profesor.index',compact('evaluaa','evaluacionn','evaluacioon','promedio','tabla_evaluacion'));
    
    }
    public function create()
    {
        
    }
    public function store(Request $request)
    {
           
    }
    public function show($id)
    {
        
    }
    public function edit($id_registro_alumno)
    {
        $usuario = Session::get('usuario_alumno');
        $periodo=Session::get('periodo_actual');
        //dd($usuario);

        $nombre=DB::selectOne('select DISTINCT gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno
                            from gnral_alumnos,actcomple_registro_alumnos,actcomple_evidencias_alumno
                            where gnral_alumnos.cuenta=actcomple_registro_alumnos.cuenta
                            and actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                            and actcomple_registro_alumnos.id_registro_alumno='.$id_registro_alumno.'');
        $nombre=$nombre->nombre." ".$nombre->apaterno." ".$nombre->amaterno;
        Session::put('nombres',$nombre);

        $personall=DB::selectOne('select gnral_personales.id_personal from gnral_personales,users
                                    where gnral_personales.tipo_usuario=users.id
                                    and gnral_personales.tipo_usuario='.$usuario.'');
        $persona=$personall->id_personal;

        $docente_actividad=DB::selectOne('select actcomple_docente_actividad.id_docente_actividad
                                        from actcomple_docente_actividad,gnral_personales,actividades_complementarias 
                                        where gnral_personales.id_personal=actcomple_docente_actividad.id_personal 
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple 
                                        and actcomple_docente_actividad.id_periodo='.$periodo.'
                                        and gnral_personales.id_personal='.$persona.'');
       
        $docente_act=($docente_actividad->id_docente_actividad);

      //  dd($docente_actividad);

        $carrera_act=DB::selectOne('select gnral_carreras.id_carrera 
                                from gnral_carreras,actcomple_docente_actividad,actividades_complementarias,actcomple_jefaturas
                                where actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                 and actcomple_docente_actividad.id_periodo='.$periodo.'
                                and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                and actcomple_docente_actividad.id_docente_actividad='.$docente_act.'');
        $carrera=$carrera_act->id_carrera;


        $evaluacioon=DB::select('Select actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_semestres.descripcion semestre,
                                gnral_carreras.nombre carrera,actividades_complementarias.descripcion actividad,actividades_complementarias.horas,actcomple_registros_coordinadores.no_evidencias evidencias,
                                actcomple_registros_coordinadores.rubrica,actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion promedio
                                from actcomple_registro_alumnos,gnral_alumnos,gnral_semestres,gnral_carreras,actividades_complementarias,actcomple_docente_actividad,gnral_personales,
                                actcomple_evidencias_alumno,actcomple_registros_coordinadores,gnral_periodo_carreras,gnral_periodos
                                where gnral_periodos.id_periodo='.$periodo.'
                                and gnral_personales.id_personal='.$persona.'
                                 
                                 and actcomple_docente_actividad.id_periodo='.$periodo.'

                                and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                and actcomple_registro_alumnos.id_semestre=gnral_semestres.id_semestre
                                and gnral_alumnos.id_carrera=gnral_carreras.id_carrera
                                and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                and actcomple_docente_actividad.id_personal=gnral_personales.id_personal
                                and actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                                and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo    
                                group by id_registro_alumno,cuenta,apaterno,amaterno,nombre,semestre,carrera,actividad,horas,evidencias,rubrica,id_actividad_comple');


       $contador=count($evaluacioon);
        for ($i=0; $i < $contador ; $i++) 
        { 
            $registro=($evaluacioon[$i]->id_registro_alumno);

            //dd($cuentaa);
            $promedio=0;
            
            $evidencia=DB::Select('Select actcomple_evidencias_alumno.id_evidencia_alumno from actcomple_evidencias_alumno,actcomple_registro_alumnos
                                    where actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                                    and actcomple_registro_alumnos.id_registro_alumno='.$registro.'');

            $cont=count($evidencia);

            for ($j=0; $j < $cont ; $j++) 
            { 
                $evidencia_eva=DB::selectOne('select actcomple_evaluaciones.id_evaluacion,actcomple_evaluaciones.calificacion 
                                            from actcomple_evaluaciones,actcomple_evidencias_alumno
                                            where actcomple_evidencias_alumno.id_evidencia_alumno=actcomple_evaluaciones.id_evidencia_alumno
                                            and actcomple_evidencias_alumno.id_evidencia_alumno='.$evidencia[$j]->id_evidencia_alumno.'');
                if ($evidencia_eva==null) 
                {
                    $promedio=$promedio+0;

                }
                else
                {
                    $promedio=$promedio+($evidencia_eva->calificacion);
                }
            }

            $promedio=$promedio/$cont;
            $promedio=round($promedio);
            $promedio=intval($promedio);
         
            $evaluacioon[$i]->promedio=$promedio;


         
        }

       $cont=count($evaluacioon);
       //dd($evaluacioon);
        $evalua_evidencia=DB::select('Select concat(actcomple_evidencias_alumno.id_evidencia_alumno,"A") nombre,concat(actcomple_evidencias_alumno.id_evidencia_alumno,"B") evidencia,gnral_alumnos.cuenta,actcomple_evidencias_alumno.id_evidencia_alumno,actcomple_evidencias_alumno.archivo,actcomple_registros_coordinadores.no_evidencias,actcomple_registros_coordinadores.rubrica,gnral_semestres.descripcion semestre
                                    from gnral_alumnos,gnral_grupos,gnral_carreras,actividades_complementarias,actcomple_registros_coordinadores,actcomple_evidencias_alumno,gnral_semestres,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_personales
                                    where gnral_alumnos.grupo=gnral_grupos.id_grupo
                                    and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad                                    
                                    and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                    and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                    and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                    and gnral_carreras.id_carrera='.$carrera.'
                                    and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                     and actcomple_docente_actividad.id_periodo='.$periodo.'
                                    AND gnral_personales.id_personal='.$persona.'
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                    and actcomple_evidencias_alumno.id_registro_alumno='.$id_registro_alumno.'');

        $combo=DB::select('Select concat(actcomple_evidencias_alumno.id_evidencia_alumno,"A") nombre, concat(actcomple_evidencias_alumno.id_evidencia_alumno,"B") evidencia, gnral_alumnos.cuenta,  actcomple_evidencias_alumno.id_evidencia_alumno,actcomple_evidencias_alumno.archivo,actcomple_registros_coordinadores.no_evidencias,actcomple_registros_coordinadores.rubrica,gnral_semestres.descripcion semestre
                                    from gnral_alumnos,gnral_grupos,gnral_carreras,actividades_complementarias,actcomple_registros_coordinadores,actcomple_evidencias_alumno,gnral_semestres,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_personales
                                    where gnral_alumnos.grupo=gnral_grupos.id_grupo
                                    and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad                                    
                                    and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                    and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                     
                                    and actcomple_docente_actividad.id_periodo='.$periodo.'

                                    and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                    and gnral_carreras.id_carrera='.$carrera.'
                                    and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                    AND gnral_personales.id_personal='.$persona.'
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                    and actcomple_evidencias_alumno.id_registro_alumno='.$id_registro_alumno.'');

        $evalua_evi = EvidenciaAlumno::find($id_registro_alumno);

        return view('actividades_complementarias.profesor.index',compact('evalua_evidencia','evalua_evi','evaluacioon','combo','promedio','tabla_evaluacion'))->with(['evaluacionnn' => true, 'evalua_evi' => $evalua_evi]);
    
    }
    public function update(Request $request, $id)
    {
        
    }
    public function destroy($id)
    {
      
    }
    public function datos(Request $request,$arreglo)
    {

        $datoss=(explode(',',$arreglo));
        $tamaño=count($datoss);
        $ciclos=$tamaño/3;

        $hola=1;
        $estado=0;
        $abreviaciones=[];
        $calificaciones=[];
        $id_evidencia=[];
        for ($i=0; $i < $ciclos ; $i++) 
        { 
            $cuent=$datoss[$i+$ciclos+$ciclos];
            //dd($cuent);
            $calificaciones[$i]=$datoss[$i];
            $id_evidencia[$i]=$datoss[$i+$ciclos];


            if($calificaciones[$i]==100)
            {
                $abreviaciones[$i]='Excelente';
            }
            if($calificaciones[$i]==90)
            {
                $abreviaciones[$i]='Muy Bien';
            }
            if($calificaciones[$i]==80)
            {
                $abreviaciones[$i]='Bien';
            }
            if($calificaciones[$i]==70)
            {
                $abreviaciones[$i]='Regular';
            }
            if($calificaciones[$i]==0)
            {
                $abreviaciones[$i]='No Aprobado';
            }

                $evalua=array(
                                    'estado' => $estado,
                                    'abreviaciones' => $abreviaciones[$i],
                                    'id_evidencia_alumno' => $id_evidencia[$i],
                                    'calificacion' => $calificaciones[$i],
                                    'cuenta'=>$cuent
                                );  

                $evidencialu=EvaluacionEvidencias::create($evalua);
        }

       return redirect('/consulta_general'); 

    }
}
