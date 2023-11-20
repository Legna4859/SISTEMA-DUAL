<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\RegistroCoordinadores;
use Session;

class LiberaPlaneacionJefeController extends Controller
{

    public function index()
    {
        $periodo=Session::get('periodo_actual');
        $carrera = Session::get('carrera');

//dd($carrera."--".$periodo);
        
        $evidencias_no=DB::select('select DISTINCT actcomple_registros_coordinadores.id_reg_coordinador,abreviaciones.titulo,gnral_personales.nombre,actividades_complementarias.descripcion, actcomple_registros_coordinadores.no_evidencias, actcomple_registros_coordinadores.rubrica 
                                        from abreviaciones,abreviaciones_prof,gnral_personales,gnral_periodo_carreras,gnral_periodos,gnral_carreras,actividades_complementarias,actcomple_registros_coordinadores,actcomple_docente_actividad,actcomple_jefaturas 
                                        where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple 
                                        and gnral_personales.id_personal=actcomple_docente_actividad.id_personal 
                                        and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                        and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                        and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura 
                                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                        and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                        and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                        and gnral_periodos.id_periodo='.$periodo.' 
                                        and gnral_carreras.id_carrera='.$carrera.'
                                        and actcomple_registros_coordinadores.estado_evidencias=1');

        $evidencias_si=DB::select('select DISTINCT actcomple_registros_coordinadores.id_reg_coordinador,abreviaciones.titulo,gnral_personales.nombre,actividades_complementarias.descripcion, actcomple_registros_coordinadores.no_evidencias, actcomple_registros_coordinadores.rubrica 
                                        from abreviaciones,abreviaciones_prof,gnral_personales,gnral_carreras,gnral_periodo_carreras,gnral_periodos,actividades_complementarias,actcomple_registros_coordinadores,actcomple_docente_actividad,actcomple_jefaturas 
                                        where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple 
                                        and gnral_personales.id_personal=actcomple_docente_actividad.id_personal 
                                        and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                        and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                        and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura 
                                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                        and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                        and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera 
                                        and gnral_periodos.id_periodo='.$periodo.'
                                        and gnral_carreras.id_carrera='.$carrera.'
                                        and actcomple_registros_coordinadores.estado_evidencias=2');

        return view('actividades_complementarias.jefatura.liberacion_planeacion',compact('evidencias_no','evidencias_si'));

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
    
    public function planeacion_jefe(Request $request, $arreglo)
    {
        $datos=(explode(',',$arreglo));
       
        $ciclos=count($datos)/2;
        $limite=count($datos);
        
         $registro=array();
        $uno=2;
         for($i=$ciclos;$i<$limite;$i++)
         {

                $id=($datos[$i]);

                $datoss = array(

                    'estado_evidencias'=>$uno


                    );
                
                 RegistroCoordinadores::find($id)->update($datoss);
         }
         return redirect()->route('libera_planeacion.index');
    }

     /*public function planeacion_jefe_si(Request $request, $arreglo)
    {
      
       $datos=(explode(',',$arreglo));
       
        $ciclos=count($datos)/2;
        $limite=count($datos);
        
        $registro=array();
        $uno=1;
         for($i=$ciclos;$i<$limite;$i++)
         {

                $id=($datos[$i]);

                $datoss = array(

                    'estado_evidencias'=>$uno
                    );
                
                 RegistroCoordinadores::find($id)->update($datoss);

         }
         return redirect()->route('libera_planeacion.index');

    }*/
    public function destroy($id)
    {
       
    }
}
