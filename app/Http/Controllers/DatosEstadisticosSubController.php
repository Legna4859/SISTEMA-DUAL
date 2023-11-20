<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\RegistroAlumno;
use App\Alumnos;
use Session;

class DatosEstadisticosSubController extends Controller
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
            //dd($actividad);
                $f="F";
                $M="M";

                $datos_mujeres=DB::selectOne('select count(actcomple_registro_alumnos.id_registro_alumno) numero from 
                                            actcomple_registro_alumnos,gnral_periodos,gnral_alumnos,actcomple_docente_actividad, actividades_complementarias,gnral_carreras
                                            where gnral_alumnos.genero="'.$f.'"
                                            and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                            and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                            and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                             and actcomple_docente_actividad.id_periodo='.$periodo.'
                                            and gnral_carreras.id_carrera=gnral_alumnos.id_carrera
                                            and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                            and gnral_periodos.id_periodo='.$periodo.'
                                            and gnral_carreras.nombre="'.$carrera.'"
                                            and actcomple_registro_alumnos.liberacion=2');


                $datos_hombres=DB::selectOne('select count(actcomple_registro_alumnos.id_registro_alumno) numero from 
                                            actcomple_registro_alumnos,gnral_periodos,gnral_alumnos,actcomple_docente_actividad, actividades_complementarias,gnral_carreras
                                            where gnral_alumnos.genero="'.$M.'"
                                            and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                            and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                             and actcomple_docente_actividad.id_periodo='.$periodo.'
                                            and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                            and gnral_carreras.id_carrera=gnral_alumnos.id_carrera
                                            and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                            and gnral_periodos.id_periodo='.$periodo.'
                                            and gnral_carreras.nombre="'.$carrera.'"
                                            and actcomple_registro_alumnos.liberacion=2');

                        $numeromu=$datos_mujeres->numero;
        //dd($numeromu);
        $numerohombres=$datos_hombres->numero;

        $arregloF.=$numeromu.",";
        $arregloM.=$numerohombres.",";

        }    
        $arregloF.="]";
        $arregloM.="]";
      

      
       
        return view('actividades_complementarias.subdireccion.datos_estadisticos',compact('carreras','datos_hombres','datos_mujeres','arregloM','arregloF','numero_carreras'));
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
}
