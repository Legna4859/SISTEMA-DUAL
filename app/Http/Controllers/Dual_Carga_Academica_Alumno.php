<?php

namespace App\Http\Controllers;

use App\Gnral_Materias_Perfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;


class Dual_Carga_Academica_Alumno extends Controller
{
    public function index()
    {
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $reticulas = DB::select('select *from gnral_reticulas WHERE gnral_reticulas.id_carrera=' . $id_carrera . '');
        $datos_reticulas = array();

        /*$plantillas = DB::select('SELECT  gnral_alumnos.id_alumno, gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno,
        cal_duales_actuales.id_duales_actuales  
        FROM gnral_alumnos, cal_duales_actuales 
        WHERE gnral_alumnos.id_alumno = cal_duales_actuales.id_alumno 
        AND cal_duales_actuales.id_periodo = ' . $id_periodo . ' 
        AND gnral_alumnos.id_carrera = ' . $id_carrera . '');*/

        $plantillas = DB::select('SELECT gnral_alumnos.id_alumno, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno, 
       MAX(cal_duales_actuales.id_duales_actuales) AS id_duales_actuales
        FROM gnral_alumnos
        INNER JOIN cal_duales_actuales ON gnral_alumnos.id_alumno = cal_duales_actuales.id_alumno
        WHERE cal_duales_actuales.id_periodo = ' . $id_periodo . ' 
              AND gnral_alumnos.id_carrera = ' . $id_carrera . '
        GROUP BY gnral_alumnos.id_alumno, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno');

        $materias_alumnos_duales = DB::select('SELECT gnral_materias.id_materia, gnral_materias.nombre
            FROM gnral_reticulas, gnral_materias
            WHERE gnral_materias.id_reticula = gnral_reticulas.id_reticula
            AND gnral_reticulas.id_carrera =' . $id_carrera . '');


        //dd($materias_alumnos_duales);

        foreach ($reticulas as $reticula) {
            $nombre['id_reticula'] = $reticula->id_reticula;
            $nombre['reticula'] = $reticula->clave;

            $semestres = DB::select('SELECT DISTINCT gnral_materias.id_semestre,gnral_semestres.descripcion semestre FROM 
                gnral_reticulas,gnral_materias,gnral_semestres WHERE gnral_reticulas.id_reticula=' . $reticula->id_reticula . ' AND
                gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
                gnral_materias.id_semestre=gnral_semestres.id_semestre order by id_semestre');
            $datos_semestres = array();
            if ($semestres != null) {
                foreach ($semestres as $semes) {
                    $semestres = array();
                    $semestres['semestre'] = $semes->semestre;
                    $semestres['id_semestre'] = $semes->id_semestre;
                    $materias = DB::select('SELECT gnral_materias.id_materia,gnral_materias.nombre,gnral_materias.clave,
                        gnral_materias.id_semestre ,gnral_materias.id_reticula 
                        FROM gnral_materias,gnral_reticulas WHERE 
                        gnral_materias.id_reticula=' . $reticula->id_reticula . ' AND 
                        gnral_materias.id_semestre=' . $semes->id_semestre . ' AND 
                        gnral_materias.id_reticula=gnral_reticulas.id_reticula');
                    $nombre_materias = array();
                    if ($materias != null) {
                        foreach ($materias as $mates) {
                            $nombrem = array();
                            $nombrem['id_materia'] = $mates->id_materia;
                            $nombrem['materia'] = $mates->nombre;
                            $nombrem['clave'] = $mates->clave;
                            $nombrem['id_semestre'] = $mates->id_semestre;
                            $nombrem['id_reticula'] = $mates->id_reticula;
                            array_push($nombre_materias, $nombrem);
                        }
                        $semestres["materias"] = $nombre_materias;
                        array_push($datos_semestres, $semestres);
                    } else {
                        $nombrem = "No existen materias";
                        array_push($nombre_materias, $nombrem);

                        $semestres["materias"] = $nombre_materias;
                        array_push($datos_semestres, $semestres);
                    }
                }
                $nombre["semestres"] = $datos_semestres;
                array_push($datos_reticulas, $nombre);
            }
        }
        //dd($datos_reticulas);

        return view('duales.llenar_carga_academica_dual', compact('plantillas','materias_alumnos_duales'))->with('reticulas', $datos_reticulas);
    }

}
