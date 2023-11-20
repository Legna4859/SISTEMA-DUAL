<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use Session;
class Tu_eva_exportar_exel_carreraController extends Controller
{
    public function index($id_carrera)
    {
        Session::put('id_carrera_tutorias',$id_carrera);
        $carreras = DB::selectOne('SELECT car.nombre FROM gnral_carreras car WHERE car.id_carrera = '.$id_carrera.' ');
        Excel::create($carreras->nombre,function ($excel)
        {
            $periodo = Session::get('periodo_actual');
            $id_carrera=Session::get('id_carrera_tutorias');



            $tutores = DB::SELECT('SELECT exp_asigna_t.id_asigna_generacion,tu_grupo_s.id_grupo_semestre,car.nombre carrera, car.id_carrera, tu_grupo_t.descripcion grupo, gnral_p.nombre nombre_tutor, gnral_p.tipo_usuario tipo FROM tu_grupo_tutorias tu_grupo_t
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
                              WHERE gnral_j.id_periodo = '.$periodo.' AND car.id_carrera = '.$id_carrera.' ');

            $array_grupos = array();

            foreach ($tutores as $tutor) {


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

            }

            foreach ($array_grupos as $grupos) {
                $i = 1;
                $excel->sheet('GRUPO_'.$grupos['grupo'], function ($sheet) use ($grupos, $i) {
                    $sheet->mergeCells('A1:E1');

                    $sheet->row(1, [
                        $grupos['grupo']
                    ]);
                    $sheet->row(2, [
                        'CUENTA', 'NOMBRE'
                    ]);
                    foreach ($grupos['alumnos'] as $alumno) {
                        $i++;
                        $sheet->row($i + 1, [
                            $alumno['cuenta'], $alumno['nombre'],
                        ]);
                    }
                });
            }
            //dd($array_carreras);
        })->export('xlsx');
    }
}
