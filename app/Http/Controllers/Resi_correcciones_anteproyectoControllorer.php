<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class Resi_correcciones_anteproyectoControllorer extends Controller
{
    public function  index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $id_carrera=$datosalumno->id_carrera;

        $permiso_modificar=DB::selectOne('SELECT estado_enviado,id_anteproyecto 
from resi_anteproyecto where id_alumno='.$alumno.' and id_periodo='.$periodo.' ');
        if($permiso_modificar == null){
            $modificar=0;
            return view('residencia.correcciones_anteproyecto.corregir_anteproyecto',compact('modificar','datosalumno','tipo_proyecto'));
        }
        else{
            $modificar=$permiso_modificar->estado_enviado;
            if($modificar == 2  || $modificar==3){
                $periodo = Session::get('periodo_actual');
                $id_usuario = Session::get('usuario_alumno');
                $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
                $alumno=$datosalumno->id_alumno;
                $portada=DB::selectOne('SELECT resi_anteproyecto.*,resi_proyecto.nom_proyecto,resi_proyecto.id_tipo_proyecto FROM resi_anteproyecto,resi_proyecto 
WHERE resi_proyecto.id_proyecto=resi_anteproyecto.id_proyecto and resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
                $tipo_proyecto=DB::select('SELECT * FROM resi_tipo_proyecto where id_tipo_proyecto=2');
                //  dd($portada->id_anteproyecto);
                $contar_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$portada->id_anteproyecto.' ');
                $contar_evaluacion=$contar_evaluacion->numero_evaluacion;
                $comentarios_portada=DB::select('SELECT resi_comentarios_portada.*,gnral_personales.nombre,resi_estado_evaluacion.descripcion
 FROM resi_comentarios_portada,gnral_personales,resi_estado_evaluacion WHERE resi_comentarios_portada.id_anteproyecto = '.$portada->id_anteproyecto.' and resi_comentarios_portada.id_profesor=gnral_personales.id_personal 
and resi_comentarios_portada.id_estado_evaluacion=resi_estado_evaluacion.id_estado_evaluacion and resi_comentarios_portada.numero_evaluacion='.$contar_evaluacion.' ');
                return view('residencia.correcciones_anteproyecto.corregir_portada',compact('portada','tipo_proyecto','datosalumno','comentarios_portada','modificar'));

            }
            else{
                $modificar=$permiso_modificar->estado_enviado;
                $revisores_faltan=DB::select('SELECT * FROM resi_revisores,gnral_personales 
WHERE gnral_personales.id_personal=resi_revisores.id_profesor and  
resi_revisores.id_carrera ='.$id_carrera.'  AND resi_revisores.id_periodo ='.$periodo.' 
and resi_revisores.id_profesor NOT in (SELECT id_profesor FROM resi_anteproyecto_profesor 
WHERE id_anteproyecto ='.$permiso_modificar->id_anteproyecto.') ');


                $revisores=DB::select('SELECT * FROM resi_revisores,gnral_personales 
WHERE gnral_personales.id_personal=resi_revisores.id_profesor and  
resi_revisores.id_carrera = '.$id_carrera.' AND resi_revisores.id_periodo = '.$periodo.' ');

                return view('residencia.correcciones_anteproyecto.corregir_anteproyecto',compact('modificar','revisores','revisores_faltan'));

            }
          //  $anteproyecto=DB::selectOne('');

        }


    }
    public function guardar_correciones_portada(Request $request){
        $this->validate($request,[
            'anteproyecto' => 'required',
            'nombre_proyecto' => 'required',
        ]);
        $anteproyecto = $request->input("anteproyecto");
        $nombre_proyecto = $request->input("nombre_proyecto");
        $nombre_proyecto= mb_strtoupper($nombre_proyecto, 'utf-8') ;
        $alumno=DB::selectOne('SELECT * FROM resi_anteproyecto WHERE id_anteproyecto ='.$anteproyecto.'');
        DB::update("UPDATE resi_proyecto SET nom_proyecto ='$nombre_proyecto'  WHERE resi_proyecto.id_proyecto =$alumno->id_proyecto");

        // dd($request);
        return back();
    }
    public function corregir_objetivos(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
$anteproyecto=$anteproyecto->id_anteproyecto;
        $contar_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$anteproyecto.' ');
        $contar_evaluacion=$contar_evaluacion->numero_evaluacion;
        $objetivos=DB::selectOne('SELECT * FROM resi_objetivos WHERE id_anteproyecto ='.$anteproyecto.'');
        $comentarios_objetivos=DB::select('SELECT resi_comentarios_objetivos.*,gnral_personales.nombre,resi_estado_evaluacion.descripcion 
FROM resi_comentarios_objetivos,gnral_personales,resi_estado_evaluacion 
WHERE resi_comentarios_objetivos.id_anteproyecto = '.$anteproyecto.' and resi_comentarios_objetivos.id_profesor=gnral_personales.id_personal 
and resi_comentarios_objetivos.id_estado_evaluacion=resi_estado_evaluacion.id_estado_evaluacion and resi_comentarios_objetivos.numero_evaluacion='.$contar_evaluacion.'   ');

         //dd($comentarios_objetivos);
       // dd($anteproyecto);
      //  dd($objetivos);
        return view('residencia.correcciones_anteproyecto.corregir_objetivos',compact('anteproyecto','objetivos','comentarios_objetivos'));

    }
    public function guardar_correciones_objetivos(Request $request){
        $this->validate($request,[
            'anteproyecto' => 'required',
            'objetivo_general' => 'required',
            'objetivo_especifico' => 'required',
        ]);

        $anteproyecto = $request->input("anteproyecto");
        $objetivo_general = $request->input("objetivo_general");
        $objetivo_especifico = $request->input("objetivo_especifico");
        DB::update("UPDATE resi_objetivos SET obj_general ='$objetivo_general', obj_especifico ='$objetivo_especifico'  WHERE resi_objetivos.id_anteproyecto =$anteproyecto");
return back();
    }
    public function corregir_alcances(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $anteproyecto=$anteproyecto->id_anteproyecto;
        $contar_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$anteproyecto.' ');
        $contar_evaluacion=$contar_evaluacion->numero_evaluacion;
        $alcances=DB::selectOne('SELECT * FROM resi_alcances WHERE id_anteproyecto ='.$anteproyecto.'');
        $comentarios_alcances=DB::select('SELECT resi_comentarios_alcances.*,gnral_personales.nombre,resi_estado_evaluacion.descripcion 
FROM resi_comentarios_alcances,gnral_personales,resi_estado_evaluacion WHERE resi_comentarios_alcances.id_anteproyecto = '.$anteproyecto.' 
and resi_comentarios_alcances.id_profesor=gnral_personales.id_personal and resi_comentarios_alcances.id_estado_evaluacion=resi_estado_evaluacion.id_estado_evaluacion and resi_comentarios_alcances.numero_evaluacion='.$contar_evaluacion.'   ');
       //dd($alcances);
        return view('residencia.correcciones_anteproyecto.corregir_alcances',compact('anteproyecto','alcances','comentarios_alcances'));
    }

    public function guardar_correciones_alcances(Request $request){
        $this->validate($request,[
            'anteproyecto' => 'required',
            'alcance' => 'required',
            'limitacion' => 'required',
        ]);

        $anteproyecto = $request->input("anteproyecto");
        $alcance = $request->input("alcance");
        $limitacion = $request->input("limitacion");
        DB::update("UPDATE resi_alcances SET alcances = '$alcance', limitaciones = '$limitacion'  WHERE resi_alcances.id_anteproyecto =$anteproyecto");
return back();
    }
    public function corregir_justificacion(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $anteproyecto=$anteproyecto->id_anteproyecto;
        $contar_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$anteproyecto.' ');
        $contar_evaluacion=$contar_evaluacion->numero_evaluacion;
        $justificacion=DB::selectOne('SELECT * FROM resi_justificacion WHERE id_anteproyecto ='.$anteproyecto.'');
        $comentarios_justificacion=DB::select('SELECT resi_comentarios_justificacion.*,gnral_personales.nombre,resi_estado_evaluacion.descripcion 
FROM resi_comentarios_justificacion,gnral_personales,resi_estado_evaluacion 
WHERE resi_comentarios_justificacion.id_anteproyecto = '.$anteproyecto.'
 and resi_comentarios_justificacion.id_profesor=gnral_personales.id_personal 
 and resi_comentarios_justificacion.id_estado_evaluacion=resi_estado_evaluacion.id_estado_evaluacion and resi_comentarios_justificacion.numero_evaluacion='.$contar_evaluacion.'   ');

//dd($justificacion);
        return view('residencia.correcciones_anteproyecto.corregir_justificacion',compact('anteproyecto','justificacion','comentarios_justificacion'));

    }
    public function guardar_correciones_justificacion(Request $request){
        $this->validate($request,[
            'id_anteproyecto' => 'required',
            'justificacion' => 'required',
        ]);

        $id_anteproyecto = $request->input("id_anteproyecto");
        $justificacion = $request->input("justificacion");

        DB::update("UPDATE resi_justificacion SET justificacion = '$justificacion' WHERE resi_justificacion.id_anteproyecto=$id_anteproyecto");
return back();
    }

    public function corregir_marco_teorico(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $anteproyecto=$anteproyecto->id_anteproyecto;
        $contar_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$anteproyecto.' ');
        $contar_evaluacion=$contar_evaluacion->numero_evaluacion;
        $marco_teorico=DB::selectOne('SELECT * FROM resi_marco_teorico WHERE id_anteproyecto ='.$anteproyecto.'');
        $comentarios_marco_teorico=DB::select('SELECT resi_comentarios_marcoteorico.*,gnral_personales.nombre,resi_estado_evaluacion.descripcion 
FROM resi_comentarios_marcoteorico,gnral_personales,resi_estado_evaluacion 
WHERE resi_comentarios_marcoteorico.id_anteproyecto ='.$anteproyecto.' and resi_comentarios_marcoteorico.id_profesor=gnral_personales.id_personal
and resi_comentarios_marcoteorico.id_estado_evaluacion=resi_estado_evaluacion.id_estado_evaluacion and resi_comentarios_marcoteorico.numero_evaluacion='.$contar_evaluacion.'  ');

        //dd($marco_teorico);
        return view('residencia.correcciones_anteproyecto.corregir_marco_teorico',compact('anteproyecto','marco_teorico','comentarios_marco_teorico'));

    }
    public function guardar_correciones_marco_teorico(Request $request)
    {

        $this->validate($request,[
        'id_anteproyecto' => 'required',
        'marco_teorico' => 'required',
    ]);

        $id_anteproyecto = $request->input("id_anteproyecto");
        $marco_teorico = $request->input("marco_teorico");

        $s=DB::update("UPDATE resi_marco_teorico SET marco_teorico = '$marco_teorico' WHERE resi_marco_teorico.id_anteproyecto=$id_anteproyecto");

        return back();
    }
    public function corregir_cronograma(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $anteproyecto=$anteproyecto->id_anteproyecto;
        $contar_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$anteproyecto.' ');
        $contar_evaluacion=$contar_evaluacion->numero_evaluacion;
        $cronograma=DB::select('SELECT * FROM resi_cronograma WHERE id_anteproyecto = '.$anteproyecto.' ORDER BY resi_cronograma.no_semana ASC');
        $comentarios_cronograma=DB::select('SELECT resi_comentarios_cronograma.*,gnral_personales.nombre,resi_estado_evaluacion.descripcion 
FROM resi_comentarios_cronograma,gnral_personales,resi_estado_evaluacion 
WHERE resi_comentarios_cronograma.id_anteproyecto ='.$anteproyecto.' 
and resi_comentarios_cronograma.id_profesor=gnral_personales.id_personal 
and resi_comentarios_cronograma.id_estado_evaluacion=resi_estado_evaluacion.id_estado_evaluacion and resi_comentarios_cronograma.numero_evaluacion='.$contar_evaluacion.' ');
      //  dd($cronograma);
        return view('residencia.correcciones_anteproyecto.corregir_cronograma',compact('anteproyecto','cronograma','comentarios_cronograma'));

    }
    public function guardar_correciones_cronograma(Request $request){
        $this->validate($request,[
            'fecha_inicial' => 'required',
            'id_cronograma' => 'required',
            'fecha_s' => 'required',
            'actividades' => 'required',
        ]);
        $fecha_inicial = $request->input("fecha_inicial");
        $id_cronograma = $request->input("id_cronograma");
        $fecha_final = $request->input("fecha_s");
        $actividades = $request->input("actividades");
        DB::update("UPDATE resi_cronograma SET resi_cronograma.actividad ='$actividades',resi_cronograma.f_inicio ='$fecha_inicial',resi_cronograma.f_termino ='$fecha_final' WHERE resi_cronograma.id_cronograma= $id_cronograma");
        return back();
    }
    public function enviar_anteproyecto(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.* FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $id_anteproyecto=$anteproyecto->id_anteproyecto;
        $modificar=$anteproyecto->estado_enviado;
        return view('residencia.revisar_anteproyecto.enviar_anteproyecto',compact('id_anteproyecto','modificar'));


    }
    public function enviar_anteproyecto_corregido(Request $request){
        $this->validate($request,[
            'id_anteproyecto' => 'required',

        ]);

        $id_anteproyecto = $request->input("id_anteproyecto");
        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto ='.$id_anteproyecto.' ');
        $numero_evaluacion=$numero_evaluacion->numero_evaluacion ;
        //dd($numero_evaluacion);
        $numero_evaluacion=($numero_evaluacion)+(1);
//dd($numero_evaluacion);
        $contar_profesores=DB::selectOne('SELECT count(id_aceptado) aceptado FROM resi_aceptado_anteproyecto WHERE id_anteproyecto ='.$id_anteproyecto.'');
        $contar_profesores=$contar_profesores->aceptado;
       // dd($contar_profesores);
        DB::delete('DELETE FROM resi_anteproyecto_profesor WHERE id_anteproyecto='.$id_anteproyecto.'');
        if($contar_profesores == 0)
        {

        }
        else{
        $profesores=DB::select('SELECT *FROM resi_aceptado_anteproyecto WHERE id_anteproyecto ='.$id_anteproyecto.'');
//dd($profesores);
        foreach ($profesores as $profesor)
        {
            $descripcion_comentario="Autorizado";
            DB:: table('resi_comentarios_portada')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $profesor->id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => 1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);
            $id_objetivos=DB::selectOne('SELECT * FROM resi_objetivos WHERE id_anteproyecto= '.$id_anteproyecto.'');
            $id_objetivos=$id_objetivos->id_objetivos;
            DB:: table('resi_comentarios_objetivos')->insert(['id_objetivos' => $id_objetivos,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $profesor->id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => 1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);
            $id_alcances=DB::selectOne('SELECT * FROM resi_alcances WHERE id_anteproyecto ='.$id_anteproyecto.' ');
            $id_alcances=$id_alcances->id_alcances;
            DB:: table('resi_comentarios_alcances')->insert(['id_alcances' => $id_alcances, 'id_anteproyecto' => $id_anteproyecto, 'id_profesor' => $profesor->id_profesor, 'comentario' => $descripcion_comentario, 'id_estado_evaluacion' => 1, 'estado_evaluacion' => 1, 'numero_evaluacion' =>$numero_evaluacion]);
           $id_justificacion=DB::selectOne('SELECT * FROM resi_justificacion WHERE id_anteproyecto ='.$id_anteproyecto.'');
           $id_justificacion=$id_justificacion->id_justificacion;
            DB:: table('resi_comentarios_justificacion')->insert(['id_justificacion' => $id_justificacion,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $profesor->id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' =>1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);
          $id_marco_teorico=DB::selectOne('SELECT * FROM resi_marco_teorico WHERE id_anteproyecto ='.$id_anteproyecto.'');
           $id_marco_teorico=$id_marco_teorico->id_marco_teorico;
            DB:: table('resi_comentarios_marcoteorico')->insert(['id_marco_teorico' => $id_marco_teorico,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $profesor->id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => 1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);

            DB:: table('resi_comentarios_cronograma')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $profesor->id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' =>1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);
            DB:: table('resi_anteproyecto_profesor')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $profesor->id_profesor]);

        }
        }
        DB::update("UPDATE resi_anteproyecto SET estado_enviado =1 WHERE resi_anteproyecto.id_anteproyecto =$id_anteproyecto");
        DB::update("UPDATE resi_contar_evaluaciones SET numero_evaluacion='.$numero_evaluacion.' WHERE resi_contar_evaluaciones.id_anteproyecto =$id_anteproyecto");
        return redirect('/residencia/correcciones_anteproyecto');

    }

    public function guardar_documentacion_alta(Request $request){
        //dd($request);
        $id_usuario = Session::get('usuario_alumno');
        $id_periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $id_alumno=$datosalumno->id_alumno;
        $cuenta=$datosalumno->cuenta;
        ///////solicitud de residencia
        $solicitud_residencia = $request->file('solicitud_residencia');
        $name_solicitud_residencia = "solicitud_residencia_".$cuenta."_".$id_periodo.".pdf";
        $solicitud_residencia->move(public_path().'/Documentos_alta_residencia/solicitud_residencia/', $name_solicitud_residencia);

        ///////constancia_noadeudo
        $constancia_noadeudo = $request->file('constancia_noadeudo');
        $name_constancia_noadeudo = "constancia_noadeudo_".$cuenta."_".$id_periodo.".pdf";
        $constancia_noadeudo->move(public_path().'/Documentos_alta_residencia/constancia_noadeudo/', $name_constancia_noadeudo);

        ///////comprobante_seguro
        $comprobante_seguro = $request->file('comprobante_seguro');
        $name_comprobante_seguro = "comprobante_seguro_".$cuenta."_".$id_periodo.".pdf";
        $comprobante_seguro->move(public_path().'/Documentos_alta_residencia/comprobante_seguro/', $name_comprobante_seguro);

        ///////oficio_asignacion
        $oficio_asignacion = $request->file('oficio_asignacion');
        $name_oficio_asignacion = "oficio_asignacion_".$cuenta."_".$id_periodo.".pdf";
        $oficio_asignacion->move(public_path().'/Documentos_alta_residencia/oficio_asignacion/', $name_oficio_asignacion);

        ///////oficio_aceptacion
        $oficio_aceptacion = $request->file('oficio_aceptacion');
        $name_oficio_aceptacion = "oficio_aceptacion_".$cuenta."_".$id_periodo.".pdf";
        $oficio_aceptacion->move(public_path().'/Documentos_alta_residencia/oficio_aceptacion/', $name_oficio_aceptacion);

        ///////oficio_presentacion
        $oficio_presentacion = $request->file('oficio_presentacion');
        $name_oficio_presentacion = "oficio_presentacion_".$cuenta."_".$id_periodo.".pdf";
        $oficio_presentacion->move(public_path().'/Documentos_alta_residencia/oficio_presentacion/', $name_oficio_presentacion);

        ///////anteproyecto
        $anteproyecto = $request->file('anteproyecto');
        $name_anteproyecto = "anteproyecto_".$cuenta."_".$id_periodo.".pdf";
        $anteproyecto->move(public_path().'/Documentos_alta_residencia/anteproyecto/', $name_anteproyecto);

        ///////carta_compromiso
        $carta_compromiso = $request->file('carta_compromiso');
        $name_carta_compromiso = "carta_compromiso_".$cuenta."_".$id_periodo.".pdf";
        $carta_compromiso->move(public_path().'/Documentos_alta_residencia/carta_compromiso/', $name_carta_compromiso);

        ///////carta_compromiso
        $convenio = $request->file('convenio');
        $name_convenio = "convenio_".$cuenta."_".$id_periodo.".pdf";
        $convenio->move(public_path().'/Documentos_alta_residencia/convenio/', $name_convenio);

        DB:: table('resi_alta_residencia')->insert([
            'pdf_solicitud_residencia '=>$name_solicitud_residencia,
            'pdf_constancia_avance_academico'=>$name_constancia_noadeudo,
            'pdf_comprobante_seguro'=>$name_comprobante_seguro,
            'pdf_oficio_asignacion_jefatura'=>$name_oficio_asignacion,
            'pdf_oficio_aceptacion_empresa'=>$name_oficio_aceptacion,
            'pdf_oficio_presentacion_tecnologico'=>$name_oficio_presentacion,
            'pdf_anteproyecto'=>$name_anteproyecto,
            'pdf_carta_compromiso '=>$name_carta_compromiso,
            'pdf_convenio_empresa '=>$name_convenio,
            ]);


    }

}
