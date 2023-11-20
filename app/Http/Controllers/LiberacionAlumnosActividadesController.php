<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class LiberacionAlumnosActividadesController extends Controller
{

    public function index()
    {
        $usuario = Session::get('usuario');
        $carrera = Session::get('carrera');
        $periodo=Session::get('periodo_actual');


        $libera_activi=DB::select("Select DISTINCT actcomple_registro_alumnos.id_registro_alumno id_registro_alumno,actcomple_registro_alumnos.id_registro_alumno pro,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
                            CONCAT(gnral_semestres.id_semestre,0,gnral_grupos.id_grupo) grupo,ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio ,actcomple_categorias.descripcion_cat,gnral_personales.nombre docente,actividades_complementarias.creditos,gnral_carreras.nombre carrera,actividades_complementarias.descripcion,actividades_complementarias.horas,actcomple_registros_coordinadores.no_evidencias,gnral_semestres.descripcion semestre
                            from actcomple_categorias,actcomple_evaluaciones,gnral_periodos,gnral_alumnos,gnral_grupos,gnral_carreras,actividades_complementarias,actcomple_registros_coordinadores,actcomple_evidencias_alumno,gnral_semestres,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_personales   
                            where gnral_alumnos.grupo=gnral_grupos.id_grupo
                            and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                            and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                            and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                            and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                            and actcomple_evidencias_alumno.id_evidencia_alumno=actcomple_evaluaciones.id_evidencia_alumno
                            and actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                            and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                            and actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                            and gnral_carreras.id_carrera=gnral_alumnos.id_carrera
                            and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                            and gnral_periodos.id_periodo=$periodo
                            and gnral_carreras.id_carrera=$carrera 
                            and gnral_alumnos.cuenta='$usuario'                       
                            and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                            and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                            and actcomple_evaluaciones.estado=1
                            group by actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,
                            gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_semestres.id_semestre,
                            gnral_grupos.id_grupo,actcomple_categorias.descripcion_cat,gnral_personales.nombre,actividades_complementarias.creditos,
                            gnral_carreras.nombre,actividades_complementarias.descripcion,actividades_complementarias.horas,actcomple_registros_coordinadores.no_evidencias,
                            gnral_semestres.descripcion");
       /*$ciclos=count($libera_activi);
        for ($i=0; $i <$ciclos ; $i++) 
        { 

            $cuenta=($libera_activi[$i]->cuenta);
            $promedio=DB::selectOne('select ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio 
                                        from actcomple_evaluaciones,actcomple_evidencias_alumno,actcomple_registro_alumnos,gnral_alumnos 
                                        where actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta 
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno 
                                        and actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno 
                                        and gnral_alumnos.cuenta='.$usuario.' 
                                        group by actcomple_registro_alumnos.id_registro_alumno');
            $promedio_real=isset($promedio->promedio)?$promedio->promedio:0;
            $libera_activi[$i]->pro=$promedio_real;
            //dd($promedio_real);

            //dd($libera_act);
        }*/
        return view('actividades_complementarias.alumnos.liberacion_actividades',compact('libera_activi'));
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
}
