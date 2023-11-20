<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ActividadesComplementarias;
use Illuminate\Support\Facades\DB;
use App\CategoriaAct;
use App\RegistroCoordinadores;
use App\Carreras;
use Storage;
use Session;

class PlaneaActividadProfController extends Controller
{

    public function index()
    {

        $usuario = Session::get('usuario_alumno');
        //dd($usuario);
        //$carrera = Session::get('carrera');
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
        

        $persona_actividad=DB::selectOne('select gnral_personales.id_personal 
                                            from gnral_personales,actcomple_docente_actividad,users
                                            where gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                            and gnral_personales.tipo_usuario=users.id
                                            and gnral_personales.tipo_usuario='.$usuario.'');
        if($persona_actividad==null)
        {
       
            $mensaje_evidencias="NO EXISTE ASIGNACIÓN DE ACTIVIDAD";
            return view('actividades_complementarias.alumnos.mensajes',compact('mensaje_evidencias'));

        }

        $categorias= CategoriaAct::all();
        $actividades=ActividadesComplementarias::all();
       

        $personall=DB::selectOne('select gnral_personales.id_personal from gnral_personales,users
                                    where gnral_personales.tipo_usuario=users.id
                                    and gnral_personales.tipo_usuario='.$usuario.'');
        $persona=$personall->id_personal;

        $actividad_docen=DB::select('select actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion,actividades_complementarias.horas
                                    from actividades_complementarias,gnral_personales,actcomple_docente_actividad
                                    where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and actcomple_docente_actividad.estado=1
                                    and actcomple_docente_actividad.id_periodo='.$periodo.'
                                    and gnral_personales.id_personal='.$persona.'');

        $docente_actividad=DB::select('select DISTINCT gnral_personales.id_personal,actcomple_registros_coordinadores.id_reg_coordinador,abreviaciones.titulo, gnral_personales.nombre,actividades_complementarias.descripcion,actcomple_categorias.descripcion_cat,
                                    actividades_complementarias.horas,actividades_complementarias.creditos,actcomple_registros_coordinadores.no_evidencias,
                                    actcomple_registros_coordinadores.rubrica,actcomple_registros_coordinadores.estado_evidencias,actcomple_registros_coordinadores.estado_evidencias evi
                                    from gnral_personales, abreviaciones,abreviaciones_prof,gnral_horarios,gnral_periodos,gnral_periodo_carreras,gnral_carreras,actividades_complementarias,
                                    actcomple_categorias,actcomple_docente_actividad,actcomple_registros_coordinadores
                                    where gnral_personales.id_personal=abreviaciones_prof.id_personal
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                    and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                    and gnral_personales.id_personal=gnral_horarios.id_personal
                                    and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                    and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                    and actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                    and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad                                    
                                    and actcomple_docente_actividad.id_periodo=gnral_periodos.id_periodo
                                    and gnral_periodos.id_periodo='.$periodo.'
                                    and actcomple_docente_actividad.id_personal='.$persona.'');
//dd($docente_actividad);

        return view('actividades_complementarias.profesor.planeacion_actividad',compact('actividad_docen','condicion','actividades','categorias','actividades2','docente_actividad'));
        
    }

    public function create()
    {
        
    }


    public function store(Request $request)
    {
        $usuario = Session::get('usuario_alumno');
        $periodo=Session::get('periodo_actual');

         
            $this->validate($request,[
            'actividad_docen'=>'required',
            'evidencias_doc'=>'required'

        ]);

        $id_actividad_comple=$request->get('actividad_docen');


        $personall=DB::selectOne('select gnral_personales.id_personal from gnral_personales,users
                                    where gnral_personales.tipo_usuario=users.id
                                    and gnral_personales.tipo_usuario='.$usuario.'');
        $persona=$personall->id_personal;
        $vigencia=1;
        $estado_evi=1;

        $docente_actividad=DB::selectOne('select actcomple_docente_actividad.id_docente_actividad
                                        from actcomple_docente_actividad,gnral_personales,actividades_complementarias 
                                        where gnral_personales.id_personal=actcomple_docente_actividad.id_personal 
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple 
                                        and actcomple_docente_actividad.id_actividad_comple='.$id_actividad_comple.'
                                        and actcomple_docente_actividad.id_periodo='.$periodo.'
                                        and gnral_personales.id_personal='.$persona.'');
        $docente_act=($docente_actividad->id_docente_actividad);

        $carrera_act=DB::selectOne('select gnral_carreras.id_carrera 
                                from gnral_carreras,actcomple_docente_actividad,actividades_complementarias,actcomple_jefaturas
                                where actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                and actcomple_docente_actividad.id_docente_actividad='.$docente_act.'');
        $carrera=$carrera_act->id_carrera;
        $periodo_carrera=DB::selectOne('select gnral_periodo_carreras.id_periodo_carrera 
                                    from gnral_periodo_carreras,gnral_periodos,gnral_carreras 
                                    where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                                    and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                                    and gnral_carreras.id_carrera='.$carrera.' 
                                    and gnral_periodos.id_periodo='.$periodo.'');
        $periodo_car=($periodo_carrera->id_periodo_carrera);

        $img = $request->file('urlImg');
        $file_route=$img->getClientOriginalName();
        Storage::disk('ArchivosDocentes')->put($file_route,file_get_contents($img->getRealPath()));
       

        $registro_coordinador=DB::select('select actcomple_registros_coordinadores.id_docente_actividad
                                        from actcomple_registros_coordinadores,actcomple_docente_actividad
                                        where actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                        and actcomple_docente_actividad.id_docente_actividad='.$docente_act.'
                                        and actcomple_docente_actividad.id_periodo='.$periodo.'');
        if($registro_coordinador==null)
        {

            $datos=array(
                
                'id_docente_actividad'=>$docente_act,
                'no_evidencias' => $request->get('evidencias_doc'),
                'rubrica'=> $file_route,
                'id_periodo_carrera' => $periodo_car,
                'vigencia' => $vigencia,
                'fecha_registro'=>$request->get('fecha'),
                'estado_evidencias' => $estado_evi

        
                );
            $planeacion=RegistroCoordinadores::create($datos);
            Session::put('entra',0);
            return redirect('/planeacion_actividad'); 
             //Session::destroy('retornar',);
        }
        else
        {
            Session::put('entra',1);
            return redirect('/planeacion_actividad'); 
        }
}

    public function show($id)
    {
        
    }


    public function edit($id_reg_coordinador)
    {


        $usuario = Session::get('usuario_alumno');
        //$carrera = Session::get('carrera');
        $periodo=Session::get('periodo_actual');

        $categorias= CategoriaAct::all();
        $actividades=ActividadesComplementarias::all();

        $personall=DB::selectOne('select gnral_personales.id_personal from gnral_personales,users
                                    where gnral_personales.tipo_usuario=users.id
                                    and gnral_personales.tipo_usuario='.$usuario.'');
        $persona=$personall->id_personal;


        $actividad_docen=DB::select('select actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion,actividades_complementarias.horas
                                    from actividades_complementarias,gnral_personales,actcomple_docente_actividad
                                    where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and gnral_personales.id_personal='.$persona.'');

 

        $docente_actividad=DB::select('select DISTINCT gnral_personales.id_personal,actcomple_registros_coordinadores.id_reg_coordinador,abreviaciones.titulo, gnral_personales.nombre,actividades_complementarias.descripcion,
                                    actcomple_categorias.descripcion_cat,actividades_complementarias.horas,actividades_complementarias.creditos,actcomple_registros_coordinadores.no_evidencias,
                                    actcomple_registros_coordinadores.rubrica,actcomple_registros_coordinadores.no_evidencias evi
                                    from gnral_personales, abreviaciones,abreviaciones_prof,gnral_horarios,gnral_periodos,gnral_periodo_carreras,gnral_carreras,actividades_complementarias,
                                    actcomple_categorias,actcomple_docente_actividad,actcomple_registros_coordinadores
                                    where gnral_personales.id_personal=abreviaciones_prof.id_personal
                                    and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                    and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                    and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                    and gnral_personales.id_personal=gnral_horarios.id_personal
                                    and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                    and actcomple_registros_coordinadores.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                    and actividades_complementarias.id_categoria=actcomple_categorias.id_categoria
                                    and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                    and actcomple_registros_coordinadores.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad                                    
                                    and gnral_periodos.id_periodo='.$periodo.'
                                    and actcomple_docente_actividad.id_personal='.$persona.'
                                    and actcomple_registros_coordinadores.estado_evidencias=1');

        $planeacion = RegistroCoordinadores::find($id_reg_coordinador);
        $condicion=0;
                  //dd($planeacion);
        return view('actividades_complementarias.profesor.planeacion_actividad',compact('condicion','actividad_docen','actividades','categorias','actividades2','docente_actividad'))->with(['editar_planeacion' => true, 'planeacion' => $planeacion]);
        
    }


    public function update(Request $request, $id_reg_coordinador)
    {
            $this->validate($request,[
            'evidencias_doc'=>'required'

            ]);
            $valor=$request->get('oculto');
            
            if($valor==1)
            {

                $img = $request->file('urlImg');
                $file_route=$img->getClientOriginalName();
                Storage::disk('ArchivosDocentes')->put($file_route,file_get_contents($img->getRealPath()));
       

                 $datos=array(
            
           
                        'no_evidencias' => $request->get('evidencias_doc'),
                        'rubrica'=> $file_route,
                 );
                 RegistroCoordinadores::find($id_reg_coordinador)->update($datos);  
                 return redirect('/planeacion_actividad');
            }
            else
            {
                $datos=array(
                    'no_evidencias' => $request->get('evidencias_doc'),
                );
                RegistroCoordinadores::find($id_reg_coordinador)->update($datos);    
            }
            return redirect('/planeacion_actividad'); 
    }

    public function destroy($id)
    {

        RegistroCoordinadores::destroy($id);           
        return redirect('/planeacion_actividad');  
    }
}
