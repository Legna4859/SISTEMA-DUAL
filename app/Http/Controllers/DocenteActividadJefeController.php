<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Abreviaciones;
use App\Abreviaciones_prof;
use App\ActividadesComplementarias;
use App\CategoriaAct;
use App\Personal;
use App\DocenteActividad;
use Session;

class DocenteActividadJefeController extends Controller
{

    public function index()
    {
        $periodo=Session::get('periodo_actual');
        $carrera = Session::get('carrera');

        $actividades=ActividadesComplementarias::all();

        $actividad_extra=DB::selectOne('select hrs_act_extra_clases.id_act_extra_clase from gnral_personales,gnral_horarios,
       gnral_periodos,gnral_periodo_carreras,gnral_carreras,hrs_actividades_extras,
        hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase
                                where gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_personales.id_personal=gnral_horarios.id_personal
                                and hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra 
                                and hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase 
                                and hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor 
                                and hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase  
                                and gnral_carreras.id_carrera='.$carrera.'
                                and gnral_periodos.id_periodo='.$periodo.'
                                and hrs_actividades_extras.id_hrs_actividad_extra=20005');
       // dd($actividad_extra);
      
        if($actividad_extra==null)
        {
            $mensaje_evidencias="NO EXISTE ACTIVIDAD";
            return view('actividades_complementarias.alumnos.mensajes',compact('mensaje_evidencias'));
        }

 $docentes_tabla=DB::select('select distinct 
    actcomple_docente_actividad.id_docente_actividad,gnral_personales.id_personal,abreviaciones.titulo, gnral_personales.nombre,actividades_complementarias.descripcion,actcomple_categorias.descripcion_cat,actividades_complementarias.horas
                                    from gnral_personales, abreviaciones,abreviaciones_prof,gnral_horarios,gnral_periodos,
                                    gnral_periodo_carreras,gnral_carreras,actividades_complementarias,actcomple_categorias,
                                    actcomple_docente_actividad,actcomple_jefaturas
                                    where gnral_personales.id_personal=abreviaciones_prof.id_personal
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                    and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                    and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                    and gnral_personales.id_personal=gnral_horarios.id_personal
                                   
                                    and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                    and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                    and actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                    and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                    and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                    and actcomple_docente_actividad.id_personal=gnral_personales.id_personal 
                                    and actcomple_docente_actividad.id_periodo=gnral_periodos.id_periodo
                                    and gnral_carreras.id_carrera='.$carrera.'
                                    and gnral_periodos.id_periodo='.$periodo.'
                                     and actcomple_docente_actividad.id_periodo='.$periodo.'
                                    and actcomple_docente_actividad.estado=1');
// dd($periodo."---".$carrera);
        $docentes= DB::select('select distinct gnral_personales.id_personal,abreviaciones.titulo,
                                gnral_personales.nombre,gnral_horarios.id_horario_profesor 
                                from gnral_personales, abreviaciones,abreviaciones_prof,gnral_horarios,
                                gnral_periodos,gnral_periodo_carreras,gnral_carreras,hrs_actividades_extras,
                                hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase
                                where gnral_personales.id_personal=abreviaciones_prof.id_personal 
                                and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_personales.id_personal=gnral_horarios.id_personal
                                and hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra 
                                and hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase 
                                and  hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor 
                                and hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase  
                               and hrs_actividades_extras.id_hrs_actividad_extra=20005
                                and gnral_carreras.id_carrera='.$carrera.'
                                and gnral_periodos.id_periodo='.$periodo.'');

//dd($docentes);

        if($docentes==null)
        {
            $mensaje_evidencias="NO EXISTEN DOCENTES";
            return view('actividades_complementarias.alumnos.mensajes',compact('mensaje_evidencias'));
        }


        $categorias=DB::select('select DISTINCT(actcomple_categorias.descripcion_cat),actcomple_categorias.id_categoria
                                from actividades_complementarias,actcomple_categorias,gnral_carreras,actcomple_jefaturas
                                where actividades_complementarias.id_categoria=actcomple_categorias.id_categoria 
                                and actcomple_jefaturas.id_jefatura=actividades_complementarias.id_jefatura
                                and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                and actividades_complementarias.estado=1
                                and gnral_carreras.id_carrera='.$carrera.'');

       
        $horas=DB::select('select actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion,actcomple_categorias.descripcion_cat,
                            actividades_complementarias.horas from actividades_complementarias,actcomple_categorias
                            where actividades_complementarias.id_categoria=actcomple_categorias.id_categoria');

//elimino la variable activi
        return view('actividades_complementarias.jefatura.docente_actividad',compact('carrera','actividades','horas','docentes','categorias','docentes_tabla'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $periodo=Session::get('periodo_actual');

        $this->validate($request,[
            'actividad_docente'=>'required',
            'categoria_docente'=>'required',
            'docente'=>'required'

        ]);

        $estado=1;
        $datos=array(

            'id_actividad_comple' => $request->get('actividad_docente'),
            'id_personal' => $request->get('docente'),
            'estado' => $estado,'id_periodo'=>$periodo
            );
        //dd($datos);

       $docente=DocenteActividad::create($datos);      
       return redirect('/docente_actividad');
    }
    public function show($id)
    {
       
    }
    public function edit($id_docente_actividad)
    {
        $carrera = Session::get('carrera');
        $periodo=Session::get('periodo_actual');
       $docentes_tabla=DB::select('select distinct 
    actcomple_docente_actividad.id_docente_actividad,gnral_personales.id_personal,abreviaciones.titulo, gnral_personales.nombre,actividades_complementarias.descripcion,actcomple_categorias.descripcion_cat,actividades_complementarias.horas
                                    from gnral_personales, abreviaciones,abreviaciones_prof,gnral_horarios,gnral_periodos,gnral_periodo_carreras,gnral_carreras,actividades_complementarias,actcomple_categorias,
                                    actcomple_docente_actividad,actcomple_jefaturas
                                    where gnral_personales.id_personal=abreviaciones_prof.id_personal
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                    and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                    and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                    and gnral_personales.id_personal=gnral_horarios.id_personal
                                   
                                    and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                    and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                    and actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                    and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                    and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                    and actcomple_docente_actividad.id_personal=gnral_personales.id_personal 
                                    and actcomple_docente_actividad.id_periodo=gnral_periodos.id_periodo
                                    and gnral_carreras.id_carrera='.$carrera.'
                                    and gnral_periodos.id_periodo='.$periodo.'
                                     and actcomple_docente_actividad.id_periodo='.$periodo.'
                                    and actcomple_docente_actividad.estado=1');
        $actividades=DB::select('select actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion 
                                    from actividades_complementarias,actcomple_jefaturas,actcomple_categorias,gnral_carreras 
                                    WHERE actividades_complementarias.id_categoria=actcomple_categorias.id_categoria 
                                    and actcomple_jefaturas.id_jefatura=actividades_complementarias.id_jefatura 
                                    and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera 
                                    and gnral_carreras.id_carrera='.$carrera.'');

        $categorias=DB::select('select DISTINCT(actcomple_categorias.descripcion_cat),actcomple_categorias.id_categoria
                                from actividades_complementarias,actcomple_categorias,gnral_carreras,actcomple_jefaturas
                                where actividades_complementarias.id_categoria=actcomple_categorias.id_categoria 
                                and actcomple_jefaturas.id_jefatura=actividades_complementarias.id_jefatura
                                and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                and actividades_complementarias.estado=1
                                and gnral_carreras.id_carrera='.$carrera.'');

     $actividad_extra=DB::selectOne('select hrs_act_extra_clases.id_act_extra_clase 
                                from gnral_personales,gnral_horarios,gnral_periodos,gnral_periodo_carreras,gnral_carreras,
                                hrs_actividades_extras,hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase
                                where gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_personales.id_personal=gnral_horarios.id_personal
                                and hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra 
                                and hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase 
                                and hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor 
                                and hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase  
                                and gnral_carreras.id_carrera='.$carrera.'
                                and gnral_periodos.id_periodo='.$periodo.'
                                and hrs_actividades_extras.id_hrs_actividad_extra=20005');
        $act=$actividad_extra->id_act_extra_clase;

        $docentes= DB::select('select distinct gnral_personales.id_personal,abreviaciones.titulo, gnral_personales.nombre,gnral_horarios.id_horario_profesor 
                                from gnral_personales, abreviaciones,abreviaciones_prof,gnral_horarios,gnral_periodos,
                                gnral_periodo_carreras,gnral_carreras,hrs_actividades_extras,hrs_act_extra_clases,
                                hrs_extra_clase,hrs_horario_extra_clase
                                where gnral_personales.id_personal=abreviaciones_prof.id_personal 
                                and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_personales.id_personal=gnral_horarios.id_personal
                                and hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra 
                                and hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase 
                                and  hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor 
                                and hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase  
                               and hrs_actividades_extras.id_hrs_actividad_extra=20005
                                and gnral_carreras.id_carrera='.$carrera.'
                                and gnral_periodos.id_periodo='.$periodo.'');
       
        $horas=DB::select('select actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion,actcomple_categorias.descripcion_cat,
                            actividades_complementarias.horas from actividades_complementarias,actcomple_categorias
                            where actividades_complementarias.id_categoria=actcomple_categorias.id_categoria');

        $doce = DocenteActividad::find($id_docente_actividad);
        return view('actividades_complementarias/jefatura.docente_actividad',compact('carrera','activi','actividades','horas','docentes','categorias','docentes_tabla'))->with(['editar_docente' => true, 'doce' => $doce]);
    }
  
    
    public function update(Request $request, $id_docente_actividad)
    {
         $this->validate($request,[
            'actividad_docente'=>'required',
            'docente'=>'required'

        ]);
        $datos=array(
            'id_actividad_comple' => $request->get('actividad_docente'),
            'id_personal' => $request->get('docente')
            );

        DocenteActividad::find($id_docente_actividad)->update($datos);      
       return redirect('/docente_actividad');
        
    }

    public function destroy($id)
    {
        $elimina_registro=DB::table('actcomple_docente_actividad')->where('id_docente_actividad',$id)->update(['estado'=>0]);
        return redirect('/docente_actividad');
    }

}
