<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use Session;
class Tu_eva_exportar_exel_turoresController extends Controller
{
    public function index()
    {   

      
        //dd($tutores);
        //Session::put('id_carrera_tutorias',$id_carrera);
        //$carreras = DB::selectOne('SELECT car.nombre FROM gnral_carreras car WHERE car.id_carrera = '.$id_carrera.' ');
        Excel::create('Tutores',function ($excel)
        {
            $periodo = Session::get('periodo_actual');
            //dd($periodo);
            $tutores = DB::SELECT('SELECT gnral_p.nombre nombre_tutor  FROM tu_grupo_tutorias tu_grupo_t
                                    INNER JOIN tu_grupo_semestre tu_grupo_s
                                    ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                                    INNER JOIN exp_asigna_tutor exp_asigna_t 
                                    ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                                    INNER JOIN gnral_personales gnral_p 
                                    ON gnral_p.id_personal = exp_asigna_t.id_personal 
                                    INNER JOIN gnral_jefes_periodos gnral_j 
                                    ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                    INNER JOIN gnral_carreras car
                                    ON car.id_carrera = gnral_j.id_carrera
                                    where gnral_j.id_periodo = '.$periodo.'  and exp_asigna_t.id_asigna_tutor  not in (Select id_asigna_tutor from tu_eva_autoevaluacion )
                                    GROUP BY gnral_p.nombre');
            //$id_carrera=Session::get('id_carrera_tutorias');
            $array_grupos = array();
            /*foreach ($tutores as $tutor) {


                $dat_semestre['grupo'] = $tutor->grupo;
                $datos_alumnos = DB::select('SELECT CONCAT(alumno.nombre," ",alumno.apaterno," ",alumno.amaterno) nombre, alumno.cuenta FROM gnral_alumnos alumno
                                                INNER JOIN exp_asigna_alumnos asigna
                                                ON asigna.id_alumno = alumno.id_alumno
                                                WHERE asigna.id_asigna_generacion = '.$tutor->id_asigna_generacion.' AND asigna.id_asigna_alumno NOT IN (SELECT id_asigna_alumno FROM tu_eva_resultados_formulario)');
                $array_alumnos = array();
                foreach ($datos_alumnos as $dato) {
                    $dat_alum['cuenta'] = $dato->cuenta;
                    $dat_alum['nombre'] = $dato->nombre;
                    array_push($array_alumnos, $dat_alum);

                }
                $dat_semestre['alumnos'] = $array_alumnos;
                array_push($array_grupos, $dat_semestre);

            }*/

          $i=0;
                $excel->sheet('TUTORES', function ($sheet) use ($tutores, $i) {
                    $sheet->mergeCells('A1:E1');
                    
                    $sheet->row(1, [
                        'TUTORES SIN AUTOEVALUACIÓN',
                    ]);
                    foreach ($tutores as $tutor) {
                        $i++;
                        $sheet->row($i + 1, [
                            $tutor->nombre_tutor,
                        ]);
                    }
                });
            
            //dd($array_carreras);
        })->export('xlsx');
    }
}
