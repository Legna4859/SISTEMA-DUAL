<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Personal;
use App\ActividadesComplementarias;
use App\EvaluacionEvidencias;
use Session;

class LiberaActividadJefeController extends Controller
{

    public function index()
    {
       
        $carrera = Session::get('carrera');
        //dd($carrera);
        $periodo=Session::get('periodo_actual');

        $liberacion_evaluacion_si=DB::select('Select DISTINCT actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
                                        CONCAT(gnral_semestres.id_semestre,"0",gnral_grupos.id_grupo) grupo,ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio,abreviaciones.titulo,gnral_personales.nombre docente,actividades_complementarias.creditos,gnral_carreras.nombre carrera,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                        actcomple_registros_coordinadores.no_evidencias,gnral_semestres.descripcion semestre
                                        from abreviaciones,abreviaciones_prof,actcomple_evaluaciones,gnral_periodos,gnral_alumnos,gnral_grupos,gnral_carreras,actividades_complementarias,actcomple_registros_coordinadores,actcomple_evidencias_alumno,gnral_periodo_carreras,gnral_semestres,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_personales                   
                                        where gnral_alumnos.grupo=gnral_grupos.id_grupo
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                        and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                        and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                        and actcomple_docente_actividad.id_docente_actividad=actcomple_registros_coordinadores.id_docente_actividad
                                        and actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                        and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                        and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                        and gnral_periodos.id_periodo='.$periodo.'
                                        and gnral_carreras.id_carrera='.$carrera.'    
                                        and actcomple_docente_actividad.id_periodo='.$periodo.'                   
                                        and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                        and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                        and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                        and actcomple_evaluaciones.estado=0
                                        group by actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.amaterno,
                                        gnral_alumnos.apaterno,gnral_semestres.id_semestre,gnral_grupos.id_grupo,gnral_personales.nombre, docente,actividades_complementarias.creditos,carrera,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                        actcomple_registros_coordinadores.no_evidencias,semestre,abreviaciones.titulo
                                       ');
      //dd($liberacion_evaluacion_si);
       /*$ciclos=count($liberacion_evaluacion_si);
        for ($i=0; $i <$ciclos ; $i++) 
        { 

            $cuenta=($liberacion_evaluacion_si[$i]->cuenta);
            $promedio=DB::selectOne('select ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio 
                                        from actcomple_evaluaciones,actcomple_evidencias_alumno,actcomple_registro_alumnos,gnral_alumnos 
                                        where actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta 
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno 
                                        and actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno 
                                        and gnral_alumnos.cuenta='.$cuenta.' 
                                        group by actcomple_registro_alumnos.id_registro_alumno');
            $promedio_real=isset($promedio->promedio)?$promedio->promedio:0;
            $liberacion_evaluacion_si[$i]->pro=$promedio_real;
        }
*/
        $liberacion_evaluacion_no=DB::select(' select * from (Select DISTINCT actcomple_evaluaciones.estado,actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
                                        CONCAT(gnral_semestres.id_semestre,"0",gnral_grupos.id_grupo) grupo,ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio,abreviaciones.titulo,gnral_personales.nombre docente,actividades_complementarias.creditos,gnral_carreras.nombre carrera,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                        actcomple_registros_coordinadores.no_evidencias,gnral_semestres.descripcion semestre
                                        from abreviaciones,abreviaciones_prof,actcomple_evaluaciones,gnral_periodos,gnral_alumnos,gnral_grupos,gnral_carreras,actividades_complementarias,actcomple_registros_coordinadores,actcomple_evidencias_alumno,gnral_periodo_carreras,gnral_semestres,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_personales                   
                                        where 
                                        
                                        gnral_alumnos.grupo=gnral_grupos.id_grupo
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                        and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                        and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                        and actcomple_docente_actividad.id_docente_actividad=actcomple_registros_coordinadores.id_docente_actividad
                                        and actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                        and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                        and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                        and gnral_periodos.id_periodo='.$periodo.'
                                        and gnral_carreras.id_carrera='.$carrera.'     

                                        and actcomple_docente_actividad.id_periodo='.$periodo.'

                                        and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                        and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                        and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                        and actcomple_evaluaciones.estado=1
                                        group by actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.amaterno,
                                        gnral_alumnos.apaterno,gnral_semestres.id_semestre,gnral_grupos.id_grupo,gnral_personales.nombre, docente,actividades_complementarias.creditos,carrera,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                        actcomple_registros_coordinadores.no_evidencias,semestre,actcomple_evaluaciones.estado,abreviaciones.titulo) as resultado where resultado.promedio >69');

      
        $promedio_cero=DB::select('Select DISTINCT actcomple_evaluaciones.estado,actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
                                        CONCAT(gnral_semestres.id_semestre,"0",gnral_grupos.id_grupo) grupo,ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio,abreviaciones.titulo,gnral_personales.nombre docente,actividades_complementarias.creditos,gnral_carreras.nombre carrera,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                        actcomple_registros_coordinadores.no_evidencias,gnral_semestres.descripcion semestre
                                        from abreviaciones,abreviaciones_prof,actcomple_evaluaciones,gnral_periodos,gnral_alumnos,gnral_grupos,gnral_carreras,actividades_complementarias,actcomple_registros_coordinadores,actcomple_evidencias_alumno,gnral_periodo_carreras,gnral_semestres,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_personales                   
                                        where gnral_alumnos.grupo=gnral_grupos.id_grupo
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                        and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                        and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                        and actcomple_docente_actividad.id_docente_actividad=actcomple_registros_coordinadores.id_docente_actividad
                                        and actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                        and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                        and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                        and gnral_periodos.id_periodo='.$periodo.'
                                        and gnral_carreras.id_carrera='.$carrera.'   


                                        and actcomple_docente_actividad.id_periodo='.$periodo.'


                                        and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                        and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                        and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                        and actcomple_evaluaciones.estado=1
                                        group by actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.amaterno,
                                        gnral_alumnos.apaterno,gnral_semestres.id_semestre,gnral_grupos.id_grupo,gnral_personales.nombre, docente,actividades_complementarias.creditos,carrera,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                        actcomple_registros_coordinadores.no_evidencias,semestre,actcomple_evaluaciones.estado,abreviaciones.titulo');
                    
   // dd($promedio_cero);

      /*  $ciclos=count($liberacion_evaluacion_no);
        for ($i=0; $i <$ciclos ; $i++) 
        { 

            $cuenta=($liberacion_evaluacion_no[$i]->cuenta);
            $promedio=DB::selectOne('select ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio 
                                        from actcomple_evaluaciones,actcomple_evidencias_alumno,actcomple_registro_alumnos,gnral_alumnos 
                                        where actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta 
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno 
                                        and actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno 
                                        and gnral_alumnos.cuenta='.$cuenta.' 
                                        group by actcomple_registro_alumnos.id_registro_alumno');
            $promedio_real=isset($promedio->promedio)?$promedio->promedio:0;
            $liberacion_evaluacion_no[$i]->pro=$promedio_real;
        }*/

 
        return view('actividades_complementarias.jefatura.imprimir_constancias',compact('promedio_cero','liberacion_evaluacion_no','liberacion_evaluacion_si'));
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
    public function edit($id)
    {
        
    }
    public function update(Request $request, $id)
    {
        
    }
    public function destroy($id)
    {
        
    }
   public function constancias_si(Request $request, $arreglo)
    {

        //$carrera = Session::get('carrera');
        //dd($carrera);

        $datoss=(explode(',',$arreglo));

        //dd($datoss);
        $tamaño=count($datoss);
        $ciclos=$tamaño/2;/////numero de ciclos




    for ($j=$ciclos; $j < $tamaño; $j++) { 

        $registro=$datoss[$j]; ////id_registro_alumno

        /////consulta para obtener el id_evidencia alumno de acuerdo al numero de evidencias que ha cargado el alumno
        $id_evidencia=DB::select('Select actcomple_evaluaciones.id_evaluacion 
                                        from actcomple_evidencias_alumno,actcomple_registro_alumnos,actcomple_evaluaciones,gnral_alumnos
                                        where actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                        and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta              
                                        and actcomple_registro_alumnos.id_registro_alumno='.$registro.'
                                        and actcomple_evaluaciones.estado=0');

        ////numero de evidencias de acuerdo al id_registro_alumno
        $num_evi=count($id_evidencia);
        $cuenta=array();
        $estado=1;

        for ($i=0; $i < $num_evi ; $i++) 
        { 

            $id_eva=($id_evidencia[$i]->id_evaluacion);

                $inserta = array(

                    'estado'=>$estado
                );
            EvaluacionEvidencias::find($id_eva)->update($inserta);
       

        }
}
       return redirect()->route('constancias.index'); 

    }

    /*public function constancias_no(Request $request, $arreglo)
    {

        $carreras = Session::get('carreras');

        $datoss=(explode(',',$arreglo));
        //dd($datoss);
        //$tamaño=count($datoss);
        //$ciclos=$tamaño/2;/////numero de ciclos
    
        $registro=$datoss[1]; ////id_registro_alumno

        /////consulta para obtener el id_evidencia alumno de acuerdo al numero de evidencias que ha cargado el alumno
        $id_evidencia=DB::select('Select actcomple_evaluaciones.id_evaluacion 
                                        from actcomple_evidencias_alumno,actcomple_registro_alumnos,actcomple_evaluaciones,gnral_alumnos,gnral_carreras
                                        where actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                        and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                        and gnral_alumnos.id_carrera=gnral_carreras.id_carrera
                                        and gnral_carreras.id_carrera='.$carreras.'                
                                        and actcomple_registro_alumnos.id_registro_alumno='.$registro.'
                                        and actcomple_evaluaciones.estado=1');

        ////numero de evidencias de acuerdo al id_registro_alumno
        $num_evi=count($id_evidencia);
        $cuenta=array();
        $estado=0;

        for ($i=0; $i < $num_evi ; $i++) 
        { 

            $id_eva=($id_evidencia[$i]->id_evaluacion);

                $inserta = array(

                    'estado'=>$estado
                );
            EvaluacionEvidencias::find($id_eva)->update($inserta);
       

        }

       return redirect('/constancias'); 

    }*/
 
}
