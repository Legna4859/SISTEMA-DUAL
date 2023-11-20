<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\RegistroAlumno;
use App\Alumnos;
use App\User;
use Session;

class DatosGraficosHistoricos extends Controller
{

    public function index()
    {
        $periodo=Session::get('periodo_actual');
        $carreras=DB::select('select gnral_carreras.nombre from gnral_carreras');       

        $numero_carreras=count($carreras);
        $arregloF="[";
        $arregloM="[";
        for ($i=0; $i < $numero_carreras ; $i++) 
        { 
            $carrera=$carreras[$i]->nombre;
                $f="F";
                $M="M";

                $datos_mujeres=DB::selectOne('select DISTINCT count(datos_gra_historicos.id_registro_alumno) numero
                                                from datos_gra_historicos,actividades_complementarias,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_carreras,gnral_periodos,gnral_alumnos
                                                where gnral_alumnos.genero="'.$f.'"
                                                and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                                and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                                and actcomple_registro_alumnos.id_registro_alumno=datos_gra_historicos.id_registro_alumno
                                                and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                                 and actcomple_docente_actividad.id_periodo='.$periodo.'
                                                and datos_gra_historicos.cuenta=gnral_alumnos.cuenta
                                                and gnral_carreras.id_carrera=gnral_alumnos.id_carrera
                                                and gnral_periodos.id_periodo='.$periodo.'
                                                and gnral_carreras.nombre="'.$carrera.'"
                                                GROUP BY(datos_gra_historicos.genero)');


                $datos_hombres=DB::selectOne('select DISTINCT count(datos_gra_historicos.id_registro_alumno) numero
                                                from datos_gra_historicos,actividades_complementarias,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_carreras,gnral_periodos,gnral_alumnos
                                                where gnral_alumnos.genero="'.$M.'"
                                                and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                                and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                                and actcomple_registro_alumnos.id_registro_alumno=datos_gra_historicos.id_registro_alumno
                                                and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                                 and actcomple_docente_actividad.id_periodo='.$periodo.'
                                                and datos_gra_historicos.cuenta=gnral_alumnos.cuenta
                                                and gnral_carreras.id_carrera=gnral_alumnos.id_carrera
                                                and gnral_periodos.id_periodo='.$periodo.'
                                                and gnral_carreras.nombre="'.$carrera.'"
                                                GROUP BY(datos_gra_historicos.genero)');

                        
        $numeromu=isset($datos_mujeres->numero)?$datos_mujeres->numero:0;
        $numerohombres=isset($datos_hombres->numero)?$datos_hombres->numero:0;


        $arregloF.=$numeromu.",";
        $arregloM.=$numerohombres.",";

        }    
        $arregloF.="]";
        $arregloM.="]";
      

      
       
        return view('actividades_complementarias.subdireccion.datos_graficos_historicos',
            compact('carreras','datos_hombres','datos_mujeres','arregloM','arregloF','numero_carreras'));

    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
    public function excelAlumnosActividades()
    {
        $periodo=Session::get('periodo_actual');
        $datos_excel=DB::select('select gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.genero,
                                gnral_semestres.descripcion,actividades_complementarias.descripcion actividad,ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio,gnral_carreras.nombre carrera,gnral_periodos.periodo,abreviaciones.titulo titulo,gnral_personales.nombre docente
                                from abreviaciones,abreviaciones_prof,actividades_complementarias,actcomple_docente_actividad,actcomple_registros_coordinadores,actcomple_registro_alumnos,actcomple_evidencias_alumno,actcomple_evaluaciones,gnral_alumnos,gnral_periodos,gnral_carreras,gnral_semestres,gnral_personales
                                where gnral_periodos.id_periodo='.$periodo.'
                                and actcomple_evaluaciones.estado=1
                                and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                and actcomple_docente_actividad.id_docente_actividad=actcomple_registros_coordinadores.id_docente_actividad
                                and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                and actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                                and actcomple_evidencias_alumno.id_evidencia_alumno=actcomple_evaluaciones.id_evidencia_alumno
                                 and actcomple_docente_actividad.id_periodo='.$periodo.'
                                and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                and gnral_alumnos.id_carrera=gnral_carreras.id_carrera
                                and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                and actcomple_docente_actividad.id_personal=gnral_personales.id_personal
                                and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                GROUP BY actcomple_registro_alumnos.id_registro_alumno,cuenta,nombre,amaterno,apaterno,genero,descripcion,
                                    actividad,promedio,carrera,periodo,docente,titulo');


        $this->datos_excel = $datos_excel;
        Excel::create('AlumnosActividades-'.date('d-m-Y'), function($excel) {

            $excel->sheet('Datos Estadísticos', function($sheet)
            {
                
                $cabeceras = array();
                array_push($cabeceras, array('Cuenta','Nombre del Alumno','Género','Semestre','Actividad','Promedio','Carrera','Periodo','Docente Encargado'));

                $sheet->fromArray($cabeceras, null, 'A1', false, false);

                foreach ($this->datos_excel as $datos_excel) {
                    $nombre_alumno=$datos_excel->nombre.' '.$datos_excel->apaterno.' '.$datos_excel->amaterno;
                    $nombre_docente=$datos_excel->titulo.' '.$datos_excel->docente;
                    $cuerpo = array();
                    array_push($cuerpo, 
                        array(html_entity_decode($datos_excel->cuenta) ,
                        html_entity_decode($nombre_alumno),html_entity_decode($datos_excel->genero),
                        html_entity_decode($datos_excel->descripcion),html_entity_decode($datos_excel->actividad),
                        html_entity_decode($datos_excel->promedio),html_entity_decode($datos_excel->carrera),
                        html_entity_decode($datos_excel->periodo),html_entity_decode($nombre_docente)));
                    $sheet->fromArray($cuerpo, null, '', false, false);
                    

                    
                }
                
            });
        })->export('xls');

        return back();
    }
}
