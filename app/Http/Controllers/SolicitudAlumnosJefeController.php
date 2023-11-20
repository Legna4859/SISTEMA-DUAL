<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Personal;
use App\CategoriaAct;
use App\DocenteActividad;
use App\RegistroAlumnos;
use App\ActividadesComplementarias;
use Session;

class SolicitudAlumnosJefeController extends Controller
{

    public function index()
    {

        $carrera = Session::get('carrera');
        $periodo=Session::get('periodo_actual');
        

        $libera_alumnos=DB::select('select actcomple_registro_alumnos.id_registro_alumno,actcomple_registro_alumnos.liberacion,actcomple_categorias.descripcion_cat,gnral_alumnos.cuenta,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre alumno,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                    actividades_complementarias.creditos,gnral_semestres.descripcion semestre,abreviaciones.titulo,gnral_personales.nombre docente,gnral_carreras.nombre carrera
                                    from actividades_complementarias,gnral_periodos,gnral_semestres,abreviaciones,abreviaciones_prof, actcomple_categorias,gnral_alumnos, actcomple_docente_actividad, actcomple_registro_alumnos,gnral_personales,gnral_carreras,actcomple_jefaturas
                                    where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                    and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                    and gnral_alumnos.cuenta=actcomple_registro_alumnos.cuenta
                                    and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                    and actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                    and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                    and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                    and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                    and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                    and actividades_complementarias.estado=1
                                    and gnral_carreras.id_carrera='.$carrera.'
                                    and gnral_periodos.id_periodo='.$periodo.'
                                    and actcomple_registro_alumnos.liberacion=0');


        $liberacion_si=DB::select('select actcomple_registro_alumnos.id_registro_alumno,actcomple_registro_alumnos.liberacion,actcomple_categorias.descripcion_cat,gnral_alumnos.cuenta,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre alumno,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                    actividades_complementarias.creditos,gnral_semestres.descripcion semestre,abreviaciones.titulo,gnral_personales.nombre docente,gnral_carreras.nombre carrera
                                    from actividades_complementarias,gnral_periodos,gnral_semestres,abreviaciones,abreviaciones_prof, actcomple_categorias,gnral_alumnos, actcomple_docente_actividad, actcomple_registro_alumnos,gnral_personales,gnral_carreras,actcomple_jefaturas
                                    where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                    and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                    and gnral_alumnos.cuenta=actcomple_registro_alumnos.cuenta
                                    and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                    and actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                    and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                    and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                    and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                    and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                    and actividades_complementarias.estado=1
                                    and gnral_carreras.id_carrera='.$carrera.'
                                    and gnral_periodos.id_periodo='.$periodo.'
                                    and actcomple_registro_alumnos.liberacion=1');

        $liberacion_registro=DB::select('select actcomple_registro_alumnos.id_registro_alumno,actcomple_registro_alumnos.liberacion,actcomple_categorias.descripcion_cat,gnral_alumnos.cuenta,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre alumno,actividades_complementarias.descripcion,actividades_complementarias.horas,
                                    actividades_complementarias.creditos,gnral_semestres.descripcion semestre,abreviaciones.titulo,gnral_personales.nombre docente,gnral_carreras.nombre carrera
                                    from actividades_complementarias,gnral_periodos,gnral_semestres,abreviaciones,abreviaciones_prof, actcomple_categorias,gnral_alumnos, actcomple_docente_actividad, actcomple_registro_alumnos,gnral_personales,gnral_carreras,actcomple_jefaturas
                                    where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                    and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                    and gnral_alumnos.cuenta=actcomple_registro_alumnos.cuenta
                                    and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
                                    and actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                    and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                    and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                    and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                    and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                    and actividades_complementarias.estado=1
                                    and gnral_carreras.id_carrera='.$carrera.'
                                    and gnral_periodos.id_periodo='.$periodo.'
                                    and actcomple_registro_alumnos.liberacion=2');

//elimino la variable usuario

        return view('actividades_complementarias.jefatura.alumnos_act',compact('liberacion_registro','libera_alumnos','liberacion_si'));
    }


    public function create()
    {
        
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
   public function modifica_jefe(Request $request, $arreglo)
    {

        $datos=(explode(',',$arreglo));
       
        $ciclos=count($datos)/2;
        $limite=count($datos);
     
        $cuenta=array();

        $uno=1;
         for($i=$ciclos;$i<$limite;$i++)
         {

                $id=($datos[$i]);

                $datoss = array(

                    'liberacion'=>$uno


                    );
                //dd($datoss);
                 RegistroAlumnos::find($id)->update($datoss);


         }
         return redirect()->route('alumnos_actividades.index');


    }





//////////////////////////////////////////////////////////////////////////////////////7no
   /*  public function modifica_jefe_no(Request $request, $arreglo)
    {
        $datos=(explode(',',$arreglo));
       
        $ciclos=count($datos)/2;
        $limite=count($datos);
        
         $cuenta=array();
        $uno=0;
         for($i=$ciclos;$i<$limite;$i++)
         {

                $id=($datos[$i]);

                $datoss = array(

                    'liberacion'=>$uno


                    );
                
                 RegistroAlumnos::find($id)->update($datoss);


         }
         return redirect()->route('alumnos_actividades.index');


    }*/

    public function destroy($id)
    {
        //
    }
}
