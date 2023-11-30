<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Session;

class Dual_Concentrado_Calificaciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $carreras = DB::table('gnral_carreras')
            ->where('id_carrera', '!=', 9)
            ->where('id_carrera', '!=', 11)
            ->where('id_carrera', '!=', 15)
            ->get();

        return view('duales.concentrado_calificaciones_duales.concentrado_calificaciones', compact('carreras'));
    }

    public function concentrado_calificaciones($id_carrera)
    {
        $carrera = $id_carrera;
        $periodo = Session::get('periodo_actual');
        $grupos = DB::select('SELECT DISTINCT m.id_semestre, hp.grupo ,c.id_carrera FROM 
                gnral_periodos pe, gnral_carreras c, gnral_periodo_carreras pc, gnral_horarios h, gnral_materias m, 
                gnral_personales p, gnral_materias_perfiles mf, gnral_horas_profesores hp,gnral_grupos g WHERE 
                mf.id_personal = p.id_personal AND 
                mf.id_materia = m.id_materia AND 
                mf.id_materia_perfil = hp.id_materia_perfil AND 
                hp.id_horario_profesor = h.id_horario_profesor AND 
                h.id_periodo_carrera = pc.id_periodo_carrera AND 
                pc.id_periodo = pe.id_periodo AND 
                pe.id_periodo =' . $periodo . ' AND 
                pc.id_carrera = c.id_carrera AND 
                c.id_carrera =' . $carrera . '
                ORDER BY m.id_semestre ASC ');
        $carr = DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = ' . $id_carrera . '');
        $nombre_carrera = $carr->nombre;
        return view('duales.concentrado_calificaciones_duales.concentrado_semestres', compact('grupos', 'nombre_carrera'));

    }

    public function concentrado_materias($id_carrera, $id_semestre, $grupo)
    {
        $id_periodo = Session::get('periodo_actual');
        $carr = DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = ' . $id_carrera . '');
        $nombre_carrera = $carr->nombre;
        $id_alumno = 0;

        /**/

        $alumnos = DB::select('SELECT gnral_alumnos.id_alumno,  gnral_alumnos.cuenta,  gnral_alumnos.nombre,  gnral_alumnos.apaterno,  gnral_alumnos.amaterno, MAX(cal_duales_actuales.id_duales_actuales) AS max_id_duales_actuales, MAX(IFNULL(eva_validacion_de_cargas.estado_validacion, 0)) AS max_estado_validacion
        FROM  gnral_alumnos
        JOIN cal_duales_actuales ON gnral_alumnos.id_alumno = cal_duales_actuales.id_alumno
        JOIN eva_carga_academica ON gnral_alumnos.id_alumno = eva_carga_academica.id_alumno
        JOIN gnral_materias ON eva_carga_academica.id_materia = gnral_materias.id_materia
        JOIN gnral_reticulas ON gnral_materias.id_reticula = gnral_reticulas.id_reticula
        LEFT JOIN eva_validacion_de_cargas ON eva_carga_academica.id_alumno = eva_validacion_de_cargas.id_alumno
        AND eva_validacion_de_cargas.id_periodo = eva_carga_academica.id_periodo 
        WHERE cal_duales_actuales.id_periodo = ' . $id_periodo . '  
        AND gnral_alumnos.id_carrera = ' . $id_carrera . '
        AND gnral_materias.id_semestre > 5  
        AND gnral_reticulas.id_carrera = ' . $id_carrera . '
        AND eva_carga_academica.id_status_materia = 1 
        AND eva_carga_academica.id_periodo = ' . $id_periodo . '
        AND eva_carga_academica.grupo = ' . $grupo . ' 
        AND (eva_validacion_de_cargas.estado_validacion IN (2, 8, 10) OR eva_validacion_de_cargas.estado_validacion IS NULL)
        GROUP BY
            gnral_alumnos.id_alumno, 
            gnral_alumnos.cuenta, 
            gnral_alumnos.nombre, 
            gnral_alumnos.apaterno, 
            gnral_alumnos.amaterno
        ORDER BY
            gnral_alumnos.apaterno,
            gnral_alumnos.amaterno,
            gnral_alumnos.nombre ASC');
        //dd($alumnos);

       $materias = DB::select('SELECT gnral_materias.id_materia,MAX(gnral_materias.nombre) AS materias,MAX(gnral_materias.unidades) AS unidades,MAX(gnral_materias.clave) AS clave,MAX(eva_tipo_curso.nombre_curso) AS nombre_curso,MAX(eva_carga_academica.id_carga_academica) AS id_carga_academica,MAX(eva_carga_academica.grupo) AS grupo,MAX(gnral_materias.id_semestre) AS id_semestre,MAX(gnral_materias.creditos) AS creditos,MAX(eva_status_materia.nombre_status) AS nombre_status
        FROM gnral_materias
        JOIN eva_carga_academica ON eva_carga_academica.id_materia = gnral_materias.id_materia
        JOIN eva_status_materia ON eva_carga_academica.id_status_materia = eva_status_materia.id_status_materia
        JOIN eva_tipo_curso ON eva_carga_academica.id_tipo_curso = eva_tipo_curso.id_tipo_curso
        JOIN gnral_grupos ON eva_carga_academica.grupo = gnral_grupos.id_grupo
        JOIN gnral_periodos ON eva_carga_academica.id_periodo = gnral_periodos.id_periodo
        JOIN gnral_alumnos ON eva_carga_academica.id_alumno = gnral_alumnos.id_alumno
        JOIN eva_validacion_de_cargas ON gnral_alumnos.id_alumno = eva_validacion_de_cargas.id_alumno
        WHERE gnral_periodos.id_periodo = '.$id_periodo.'  
        AND eva_carga_academica.id_materia NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
        AND gnral_periodos.id_periodo = eva_validacion_de_cargas.id_periodo
        AND eva_validacion_de_cargas.id_alumno IN (SELECT cal_duales_actuales.id_alumno FROM cal_duales_actuales 
            WHERE cal_duales_actuales.id_periodo = '.$id_periodo.')
        AND eva_status_materia.id_status_materia = 1
        GROUP BY gnral_materias.id_materia');

        /*$materias = DB::select('SELECT gnral_materias.id_materia, gnral_materias.nombre AS materias, gnral_materias.unidades, gnral_materias.id_materia, eva_tipo_curso.nombre_curso,
            eva_carga_academica.id_carga_academica, eva_carga_academica.grupo, gnral_materias.id_semestre,
            gnral_materias.creditos, eva_status_materia.nombre_status
            FROM gnral_materias, eva_status_materia, eva_tipo_curso, gnral_grupos, eva_carga_academica, gnral_periodos, gnral_alumnos, eva_validacion_de_cargas
            WHERE eva_carga_academica.id_materia = gnral_materias.id_materia
            AND eva_carga_academica.id_status_materia = eva_status_materia.id_status_materia
            AND eva_carga_academica.id_tipo_curso = eva_tipo_curso.id_tipo_curso
            AND eva_carga_academica.id_periodo = gnral_periodos.id_periodo
            AND eva_carga_academica.grupo = gnral_grupos.id_grupo
            AND eva_carga_academica.id_alumno = gnral_alumnos.id_alumno
            AND gnral_periodos.id_periodo = '.$id_periodo.'
            AND eva_carga_academica.id_materia NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
            AND gnral_alumnos.id_alumno = eva_validacion_de_cargas.id_alumno
            AND gnral_periodos.id_periodo = eva_validacion_de_cargas.id_periodo
            AND eva_validacion_de_cargas.id_alumno IN (SELECT cal_duales_actuales.id_alumno FROM cal_duales_actuales WHERE cal_duales_actuales.id_periodo = '.$id_periodo.')
            AND eva_status_materia.id_status_materia = 1
            AND gnral_alumnos.id_carrera = '.$id_carrera.'');*/

        //dd($materias);

        $array_materias = [];

// Iteramos sobre los resultados y almacenamos los datos en el array
foreach ($materias as $materia) {
    $array_materia = [
        'id_materia' => $materia->id_materia,
        'nombre' => $materia->materias,
        'clave' => $materia->clave,
        'creditos' => $materia->creditos,
        'unidades' => $materia->unidades,
        // Puedes agregar más campos según sea necesario
    ];

    // Agregamos el array de la materia al array general
    $array_materias[] = $array_materia;
}

         return view('duales.concentrado_calificaciones_duales.concentrado_materias', compact('materias','nombre_carrera','id_semestre','grupo','alumnos','array_materias'));

    }
}