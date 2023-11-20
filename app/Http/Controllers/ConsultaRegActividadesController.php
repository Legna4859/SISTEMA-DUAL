<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Abreviaciones;
use App\Abreviaciones_prof;
use App\ActividadesComplementarias;
use App\CategoriaAct;
use App\DocenteActividad;
use App\RegistroAlumnos;
use App\RegistroCoordinadores;
use App\Personal;
use Session;

class ConsultaRegActividadesController extends Controller
{

    public function index()
    {

    $usuario = Session::get('usuario');
    $carrera = Session::get('carrera');
    $periodo=Session::get('periodo_actual');

    $entra = Session::get('entra');
    if($entra==0)
    {
        $condicion=0;
    }
    else
    {
        $condicion=1;
    }

        $consulta_alumno=DB::select("select DISTINCT actcomple_registro_alumnos.liberacion,actcomple_registro_alumnos.liberacion lib, actcomple_registro_alumnos.id_registro_alumno,actcomple_registro_alumnos.cuenta,actividades_complementarias.descripcion,actividades_complementarias.horas,actividades_complementarias.creditos,actcomple_categorias.descripcion_cat,actcomple_registro_alumnos.fecha_registro,abreviaciones.titulo,gnral_personales.nombre,gnral_personales.id_personal
                                from actividades_complementarias,actcomple_categorias,actcomple_registro_alumnos,abreviaciones,
                                gnral_personales,actcomple_docente_actividad,actcomple_registros_coordinadores,abreviaciones_prof,gnral_periodos,gnral_alumnos
                                where actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
                                and gnral_personales.id_personal=abreviaciones_prof.id_personal 
                                and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                and actcomple_registro_alumnos.cuenta='$usuario'
                                and gnral_periodos.id_periodo=$periodo
                                and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                and actividades_complementarias.estado=1");

        

        $suma=DB::selectOne("select SUM(actividades_complementarias.horas) horas 
                            from actividades_complementarias,actcomple_registro_alumnos,gnral_alumnos,actcomple_docente_actividad,gnral_periodos
                            WHERE actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                            and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                            and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                            and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_periodos.id_periodo=$periodo");
                                
        $suma=isset($suma->horas)?$suma->horas:0;
        $docente_actividad=DB::select("select  actcomple_docente_actividad.id_docente_actividad,abreviaciones.titulo,gnral_personales.nombre,
gnral_personales.id_personal,actividades_complementarias.descripcion,
actividades_complementarias.horas,actividades_complementarias.id_actividad_comple, actcomple_docente_actividad.id_periodo

from 
actcomple_registros_coordinadores, gnral_horarios,gnral_periodo_carreras,gnral_carreras,abreviaciones,abreviaciones_prof,gnral_personales,actividades_complementarias,actcomple_docente_actividad,actcomple_jefaturas

where 
abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
and gnral_personales.id_personal=abreviaciones_prof.id_personal 
and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple 
and actcomple_docente_actividad.id_personal=gnral_personales.id_personal 
and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad             and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
and gnral_personales.id_personal=abreviaciones_prof.id_personal
and gnral_personales.id_personal=gnral_horarios.id_personal
and gnral_periodo_carreras.id_periodo_carrera=actcomple_registros_coordinadores.id_periodo_carrera
and gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
and actcomple_docente_actividad.id_docente_actividad=actcomple_registros_coordinadores.id_docente_actividad
and (gnral_carreras.id_carrera='{$carrera}' or gnral_carreras.id_carrera=9)
and actcomple_registros_coordinadores.estado_evidencias=2
and actcomple_docente_actividad.id_periodo=".$periodo);

    	return view('actividades_complementarias.alumnos.consulta_reg_actividades',compact('condicion','liberaa','libera','actividad','consulta_alumno','docente_actividad','suma','nuevo'));
    
    }
    
    public function create()
    {
       
    }

  
    public function store(Request $request)
    {
        $usuario = Session::get('usuario');
        $periodo=Session::get('periodo_actual');

       /* $this->validate($request,[
            'actividad_alumnos'=>'required'

        ]);*/
        $liberacion=0;
        $id_actividad_comple=$request->get('actividad_alu');
        $docentes=$request->get('profesor_alu');
        $fecha=$request->get('fecha_alu');
        
        $semestre_alu=DB::selectOne("select gnral_alumnos.id_semestre 
                                    from gnral_alumnos,gnral_semestres 
                                    where gnral_alumnos.id_semestre=gnral_semestres.id_semestre 
                                    and gnral_alumnos.cuenta='$usuario'");
        $semestre=($semestre_alu->id_semestre);

        $docente_nombre=DB::selectOne('select gnral_personales.id_personal 
                                            from gnral_personales,actcomple_docente_actividad,actividades_complementarias
                                            WHERE actcomple_docente_actividad.id_personal=gnral_personales.id_personal
                                            and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                            and gnral_personales.nombre="'.$docentes.'"
                                            and actividades_complementarias.id_actividad_comple='.$id_actividad_comple.'');

        $docente=($docente_nombre->id_personal);

        $docente_actividad=DB::selectOne('select actcomple_docente_actividad.id_docente_actividad
                                        from actcomple_docente_actividad,gnral_personales,actividades_complementarias 
                                        where gnral_personales.id_personal=actcomple_docente_actividad.id_personal 
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple 
                                        and actcomple_docente_actividad.id_actividad_comple='.$id_actividad_comple.'
                                        and gnral_personales.id_personal='.$docente.'
                                        and actcomple_docente_actividad.id_periodo='.$periodo.'');
        $docente_act=($docente_actividad->id_docente_actividad);

        $registro_alumno=DB::select("select actcomple_registro_alumnos.id_docente_actividad
                                        from actcomple_registro_alumnos,actcomple_docente_actividad
                                        where actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                        and actcomple_docente_actividad.id_docente_actividad=$docente_act
                                        and actcomple_registro_alumnos.cuenta='$usuario'");
       // dd($registro_alumno);
        
    if($registro_alumno==null)
    {

        $alumno=array(
            
            'id_docente_actividad'=>$docente_act,
            'cuenta' => $usuario,
            'id_periodo' => $periodo,
            'liberacion' => $liberacion,
            'fecha_registro'=>$request->get('fecha_alu'),
            'id_semestre' => $semestre

            );
         $suma=DB::selectOne("select SUM(actividades_complementarias.horas) horas 
                            from actividades_complementarias,actcomple_registro_alumnos,gnral_alumnos,actcomple_docente_actividad
                            WHERE actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                            and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                            and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                            and gnral_alumnos.cuenta='$usuario' and actcomple_docente_actividad.id_periodo=$periodo");
        $suma=isset($suma->horas)?$suma->horas:0;

        $horas=DB::selectOne('select horas from actividades_complementarias where id_actividad_comple='.$id_actividad_comple.'');
        $horas=($horas->horas);

        $suma_final=$suma+$horas;

        if($suma_final>40)
        {
            return redirect('/consulta_actividades');
        }
        else
        {
            $actividad_alumnos=RegistroAlumnos::create($alumno);
            Session::put('entra',0);      
            return redirect('/consulta_actividades');
        }
    }
    else
    {
            Session::put('entra',1);
            return redirect('/consulta_actividades'); 
    }






        
    }

    public function show()
    {

    }

    public function edit($id_registro_alumno)
    {
        $usuario = Session::get('usuario');
        $carrera = Session::get('carrera');
        $periodo=Session::get('periodo_actual');

        $consulta_alumno=DB::select("select DISTINCT actcomple_registro_alumnos.liberacion,actcomple_registro_alumnos.liberacion lib, actcomple_registro_alumnos.id_registro_alumno,actcomple_registro_alumnos.cuenta,actividades_complementarias.descripcion,actividades_complementarias.horas,actividades_complementarias.creditos,actcomple_categorias.descripcion_cat,actcomple_registro_alumnos.fecha_registro,abreviaciones.titulo,gnral_personales.nombre,gnral_personales.id_personal
                                from actividades_complementarias,actcomple_categorias,actcomple_registro_alumnos,abreviaciones,
                                gnral_personales,actcomple_docente_actividad,actcomple_registros_coordinadores,abreviaciones_prof,gnral_periodos,gnral_alumnos
                                where actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
                                and gnral_personales.id_personal=abreviaciones_prof.id_personal 
                                and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                and actcomple_registro_alumnos.cuenta='$usuario'
                                and gnral_periodos.id_periodo=$periodo
                                 and actcomple_docente_actividad.id_periodo=$periodo
                                and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                and actividades_complementarias.estado=1");

        

        $suma=DB::selectOne("select SUM(actividades_complementarias.horas) horas 
                            from actividades_complementarias,actcomple_registro_alumnos,gnral_alumnos,actcomple_docente_actividad,gnral_periodos
                            WHERE actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                            and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                             and actcomple_docente_actividad.id_periodo=$periodo
                            and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                            and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_periodos.id_periodo=$periodo");
        //dd($suma);
                                
        $suma=isset($suma->horas)?$suma->horas:0;
        $docente_actividad=DB::select('select distinct actcomple_docente_actividad.id_docente_actividad,abreviaciones.titulo,gnral_personales.nombre,gnral_personales.id_personal,actividades_complementarias.descripcion,
                                    actividades_complementarias.horas,actividades_complementarias.id_actividad_comple 
                                    from gnral_horarios,gnral_periodo_carreras,gnral_carreras,abreviaciones,abreviaciones_prof,gnral_personales,actividades_complementarias,actcomple_docente_actividad,actcomple_jefaturas
                                    where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion and gnral_personales.id_personal=abreviaciones_prof.id_personal
                                    and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple 
                                     and actcomple_docente_actividad.id_periodo='.$periodo.'
                                    and actcomple_docente_actividad.id_personal=gnral_personales.id_personal
                                    and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                    and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                    and (gnral_carreras.id_carrera='.$carrera.'
                                    or gnral_carreras.id_carrera=9)
                                    and actividades_complementarias.estado=1');
        $editar_actalu= RegistroAlumnos::find($id_registro_alumno); 
        $condicion=0;
        return view('actividades_complementarias.alumnos.consulta_reg_actividades',compact('condicion','liberaa','libera','actividad','consulta_alumno','docente_actividad','suma','nuevo'))->with(['edit' => true, 'editar_actalu' => $editar_actalu]);



    }
   
    public function update(Request $request, $id_registro_alumno)
    {
        //dd($id_registro_alumno);
        $usuario = Session::get('usuario');
        $carrera = Session::get('carrera');

        $this->validate($request,[
            'actividad_alumnos'=>'required'

        ]);

        $id_actividad_comple=$request->get('actividad_alumnos');
        $docentes=$request->get('profesoredit');
        $horasresta=$request->get('horas_alumnoo');
       //dd($docentes);
        
//dd($horasresta);
        $docente_nombre=DB::selectOne('select gnral_personales.id_personal 
                                            from gnral_personales,actcomple_docente_actividad,actividades_complementarias
                                            WHERE actcomple_docente_actividad.id_personal=gnral_personales.id_personal
                                             and actcomple_docente_actividad.id_periodo='.$periodo.'
                                            and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                            and gnral_personales.nombre="'.$docentes.'"
                                            and actividades_complementarias.id_actividad_comple='.$id_actividad_comple.'');

        $docente=($docente_nombre->id_personal);
        //dd($docente);
        $docente_actividad=DB::selectOne('select actcomple_docente_actividad.id_docente_actividad
                                        from actcomple_docente_actividad,gnral_personales,actividades_complementarias 
                                        where gnral_personales.id_personal=actcomple_docente_actividad.id_personal 
                                         and actcomple_docente_actividad.id_periodo='.$periodo.'
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple 
                                        and actcomple_docente_actividad.id_actividad_comple='.$id_actividad_comple.'
                                        and gnral_personales.id_personal='.$docente.'');
        $docente_act=($docente_actividad->id_docente_actividad);
        //dd($docente_act);

        $alumno=array(
            
            'id_docente_actividad'=>$docente_act,
            );
 
         $suma=DB::selectOne('select SUM(actividades_complementarias.horas) horas 
                                from actividades_complementarias,actcomple_registro_alumnos,gnral_alumnos,actcomple_docente_actividad
                                WHERE actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                 and actcomple_docente_actividad.id_periodo='.$periodo.'
                                and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                and gnral_alumnos.cuenta='.$usuario.'');
        $suma=isset($suma->horas)?$suma->horas:0;
        $suma=$suma-$horasresta;
     //   dd($suma);

        //$horas=DB::selectOne('select horas from actividades_complementarias where id_actividad_comple='.$id_actividad_comple.'');
        //$horas=($horas->horas);

        //$suma_final=$suma;
      //  dd($suma_final);

        if($suma>41)
        {
            //dd("Excede numero horas");
            return redirect('/consulta_actividades');
        }
        else
        {
            RegistroAlumnos::find($id_registro_alumno)->update($alumno);      
            return redirect('/consulta_actividades');
        }
        

        

    }

    public function destroy($id)
    {
        RegistroAlumnos::destroy($id);           
        return redirect('/consulta_actividades');
        
    }
    public function evidencias()
    {
        
    }


}
