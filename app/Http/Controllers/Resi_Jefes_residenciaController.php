<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use Session;
class Resi_Jefes_residenciaController extends Controller
{
    public function index(){
        $id_periodo = Session::get('periodo_actual');
        $id_carrera = Session::get('carrera');

        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$id_periodo.' AND
            id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id_periodo_carrera);
       $plantillas = DB::select('select gnral_personales.id_personal,gnral_personales.nombre 
FROM gnral_personales, gnral_horarios WHERE gnral_horarios.id_periodo_carrera='.$id_periodo_carrera.' 
AND gnral_horarios.id_personal=gnral_personales.id_personal AND gnral_personales.id_personal 
NOT IN (select resi_revisores.id_profesor 
FROM resi_revisores WHERE resi_revisores.id_carrera='.$id_carrera.' and resi_revisores.id_periodo='.$id_periodo.')');
       $revisores=DB::select('SELECT * FROM resi_revisores,gnral_personales WHERE gnral_personales.id_personal=resi_revisores.id_profesor and  resi_revisores.id_carrera = '.$id_carrera.' AND resi_revisores.id_periodo = '.$id_periodo.' ');
       $contar_revisores=DB::selectOne('SELECT COUNT(resi_revisores.id_revisores) contar_revisores FROM resi_revisores WHERE id_carrera ='.$id_carrera.'  AND id_periodo = '.$id_periodo.'');
       $contar_revisores=$contar_revisores->contar_revisores;
       if($contar_revisores == 3){
           $maximorev=1;
       }
       else{
           $maximorev=0;
       }
        return view('residencia.asignar_revisores',compact('plantillas','revisores','contar_revisores','maximorev'));
    }
    public function agregar_revisores($id_asesor){
       $asesor=DB::selectOne('SELECT *  FROM gnral_personales WHERE id_personal ='.$id_asesor.'');
return view('residencia.partials.asesor',compact('asesor'));
    }
    public function eliminar_revisor(Request $request)
    {
        $this->validate($request,[
            'id_revisores' => 'required',

        ]);
        $id_revisores = $request->input("id_revisores");
        DB::delete('DELETE FROM resi_revisores WHERE resi_revisores.id_revisores = '.$id_revisores.'');
        return back();

    }
    public function periodo_asesor(Request $request){
        $this->validate($request,[
            'id_profesor' => 'required',

        ]);

        $id_profesor = $request->input("id_profesor");
        $periodo = Session::get('periodo_actual');
        $id_carrera=Session::get('carrera');
        DB:: table('resi_revisores')->insert(['id_profesor' => $id_profesor, 'id_carrera' => $id_carrera, 'id_periodo' => $periodo]);
return back();
    }
    public function  academia(){
        $cargos_academia=DB::select('SELECT * FROM resi_cargo_academia');
        $id_periodo = Session::get('periodo_actual');
        $id_carrera = Session::get('carrera');
$contar_academia=DB::selectOne('SELECT count(resi_academia.id_academia) academia FROM resi_academia WHERE id_carrera ='.$id_carrera.'');
$contar_academia=$contar_academia->academia;
if($contar_academia==2)
{
    $maximo_academia=1;
}
else{
    $maximo_academia=0;
}
        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$id_periodo.' AND
            id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id_periodo_carrera);
        $plantillas = DB::select('select gnral_personales.id_personal,gnral_personales.nombre 
FROM gnral_personales, gnral_horarios WHERE gnral_horarios.id_periodo_carrera='.$id_periodo_carrera.' 
AND gnral_horarios.id_personal=gnral_personales.id_personal');
        $academias=DB::select('SELECT gnral_personales.nombre,resi_cargo_academia.cargo,resi_academia.* 
from gnral_personales,resi_academia,resi_cargo_academia 
where gnral_personales.id_personal=resi_academia.id_profesor 
and resi_cargo_academia.id_cargo_academia=resi_academia.id_cargo_academia 
and resi_academia.id_carrera='.$id_carrera.'');
        return view('residencia.asignar_academia',compact('maximo_academia','cargos_academia','plantillas','academias'));

    }
    public function agregar_academia(Request $request){
        $this->validate($request,[
            'id_profesor' => 'required',
            'id_cargo' => 'required',

        ]);

        $id_profesor = $request->input("id_profesor");
        $id_cargo = $request->input("id_cargo");
        $id_carrera=Session::get('carrera');
        DB:: table('resi_academia')->insert(['id_profesor' => $id_profesor, 'id_carrera' => $id_carrera,'id_cargo_academia' => $id_cargo]);
        return back();
    }
    public function modificar_academia($id_academia){
        $cargos_academia=DB::select('SELECT * FROM resi_cargo_academia');
        $id_periodo = Session::get('periodo_actual');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$id_periodo.' AND
            id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id_periodo_carrera);
        $plantillas = DB::select('select gnral_personales.id_personal,gnral_personales.nombre 
FROM gnral_personales, gnral_horarios WHERE gnral_horarios.id_periodo_carrera='.$id_periodo_carrera.' 
AND gnral_horarios.id_personal=gnral_personales.id_personal');

        $academia=DB::selectOne('SELECT * FROM resi_academia WHERE id_academia ='.$id_academia.'');
        return view('residencia.partials.modificar_academia',compact('cargos_academia','plantillas','academia'));

    }
    public function modificacion_academia(Request $request){
        $this->validate($request,[
            'id_academica' => 'required',
            'id_profesor' => 'required',
            'id_cargo' => 'required',
        ]);
        $id_academica = $request->input("id_academica");
        $id_profesor = $request->input("id_profesor");
        $id_cargo = $request->input("id_cargo");
        DB::update("UPDATE resi_academia SET id_profesor = $id_profesor,id_cargo_academia = $id_cargo WHERE resi_academia.id_academia =$id_academica");
return back();
    }
    public function residentes_carrera(){
        $id_periodo = Session::get('periodo_actual');
        $id_carrera = Session::get('carrera');

        $anteproyectos=DB::select('
SELECT gnral_alumnos.id_alumno,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
gnral_alumnos.cuenta,resi_anteproyecto.id_anteproyecto, resi_proyecto.nom_proyecto,1 asesor,
gnral_personales.nombre profesor,abreviaciones.titulo, resi_asesores.id_asesores 
FROM resi_anteproyecto,resi_proyecto,gnral_alumnos,resi_asesores,gnral_personales,abreviaciones_prof,abreviaciones
 WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and gnral_alumnos.id_carrera='.$id_carrera.'
     and resi_asesores.id_periodo = '.$id_periodo.' AND resi_anteproyecto.estado_enviado = 3 
     and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto and
      resi_asesores.id_profesor=gnral_personales.id_personal and 
      gnral_personales.id_personal=abreviaciones_prof.id_personal and
       abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
         resi_asesores.id_anteproyecto=resi_anteproyecto.id_anteproyecto');


        $periodo=DB::selectOne('select *from gnral_periodos where id_periodo='.$id_periodo.'');


        return view('residencia.departamento_residencia.residentes_carrera',compact('anteproyectos','periodo'));
    }
    public function carrera_oficio_aceptacion(){
        $id_periodo = Session::get('periodo_actual');
        $id_carrera = Session::get('carrera');

        $anteproyectos=DB::select('
SELECT gnral_alumnos.id_alumno,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
gnral_alumnos.cuenta,resi_anteproyecto.id_anteproyecto, resi_proyecto.nom_proyecto,1 asesor,
gnral_personales.nombre profesor,abreviaciones.titulo, resi_asesores.id_asesores 
FROM resi_anteproyecto,resi_proyecto,gnral_alumnos,resi_asesores,gnral_personales,abreviaciones_prof,abreviaciones
 WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and gnral_alumnos.id_carrera='.$id_carrera.'
     and resi_asesores.id_periodo = '.$id_periodo.' AND resi_anteproyecto.estado_enviado = 3 
     and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto and
      resi_asesores.id_profesor=gnral_personales.id_personal and 
      gnral_personales.id_personal=abreviaciones_prof.id_personal and
       abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
         resi_asesores.id_anteproyecto=resi_anteproyecto.id_anteproyecto');

        $datos_alumn=array();
        foreach ($anteproyectos as $anteproyecto){
            $dat['id_alumno']=$anteproyecto->id_alumno;
            $dat['nombre']=$anteproyecto->apaterno.' '.$anteproyecto->amaterno.' '.$anteproyecto->nombre;
            $dat['cuenta']=$anteproyecto->cuenta;
            $dat['id_anteproyecto']=$anteproyecto->id_anteproyecto;
            $dat['nom_proyecto']=$anteproyecto->nom_proyecto;
            $dat['nombre_profesor']=$anteproyecto->titulo.' '.$anteproyecto->profesor;
            $dat['id_asesores']=$anteproyecto->id_asesores;
            $estado_numero=DB::selectOne('SELECT count(id_oficio_aceptacion) contar from resi_oficio_acept_proy WHERE id_asesores ='.$anteproyecto->id_asesores.'');
            if($estado_numero->contar == 0){
                $dat['estado']=1;
                $dat['numero_oficio']=1;
            }else{
                $dat['estado']=2;
                $numero_oficio=DB::selectOne('SELECT *from resi_oficio_acept_proy WHERE id_asesores ='.$anteproyecto->id_asesores.'');
                $dat['numero_oficio']=$numero_oficio->numero_oficio;
            }

            array_push($datos_alumn,$dat);
        }
       // dd($datos_alumn);


        $periodo=DB::selectOne('select *from gnral_periodos where id_periodo='.$id_periodo.'');


        return view('residencia.departamento_residencia.oficio_aceptacion',compact('datos_alumn','periodo'));
    }
    public function agregar_no_oficio_aceptacion($id_asesor){
       $profesor=DB::selectOne('SELECT gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno, resi_asesores.id_asesores 
       from gnral_alumnos, resi_anteproyecto, resi_asesores WHERE gnral_alumnos.id_alumno = resi_anteproyecto.id_alumno and 
       resi_anteproyecto.id_anteproyecto = resi_asesores.id_anteproyecto and resi_asesores.id_asesores ='.$id_asesor.'');

        return view('residencia.departamento_residencia.agregar_numero_oficio',compact('profesor'));
    }
    public function guardar_no_oficio(Request $request, $id_asesor){
        $numero_oficio = $request->input("numero_oficio");
        $hoy = date("Y-m-d H:i:s");
        DB:: table('resi_oficio_acept_proy')->insert(['numero_oficio' => $numero_oficio, 'id_asesores' => $id_asesor,'fecha_registro' =>$hoy ]);
        return back();

    }
    public function modificar_no_oficio_aceptacion($id_asesor){
        $profesor=DB::selectOne('SELECT gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno, resi_asesores.id_asesores 
       from gnral_alumnos, resi_anteproyecto, resi_asesores WHERE gnral_alumnos.id_alumno = resi_anteproyecto.id_alumno and 
       resi_anteproyecto.id_anteproyecto = resi_asesores.id_anteproyecto and resi_asesores.id_asesores ='.$id_asesor.'');
        $numero_oficio=DB::selectOne('SELECT * FROM `resi_oficio_acept_proy` WHERE `id_asesores` = '.$id_asesor.'');
        return view('residencia.departamento_residencia.modificar_numero_oficio',compact('profesor','numero_oficio'));

    }
    public function guardar_mod_no_oficio(Request $request,$id_asesor){
        $numero_oficio = $request->input("mod_numero_oficio");
        $hoy = date("Y-m-d H:i:s");

        DB::table('resi_oficio_acept_proy')
            ->where('id_asesores', $id_asesor)
            ->update([
                'numero_oficio' => $numero_oficio,
                'fecha_m' => $hoy
            ]);
        return back();
    }
    public function residentes_alumno($id_anteproyecto){
        $asignadas = DB::selectOne('SELECT MAX(semana) semana FROM resi_rubro_aplicacion WHERE `id_anteproyecto` = '.$id_anteproyecto.'');
        $asignadas=$asignadas->semana;
        $semanas_asignadas=DB::select('SELECT resi_cronograma.*,resi_promedio_rubros.promedio FROM
 resi_cronograma,resi_promedio_rubros WHERE resi_cronograma.id_cronograma=resi_promedio_rubros.id_cronograma 
 and resi_promedio_rubros.id_anteproyecto='.$id_anteproyecto.'  
ORDER BY `resi_cronograma`.`no_semana` ASC');
        $promedio=DB::selectOne('SELECT sum(resi_promedio_rubros.promedio) promedio FROM resi_promedio_rubros WHERE resi_promedio_rubros.id_anteproyecto='.$id_anteproyecto.'');

        if ($promedio == null){
            $promedio=0;
        }
        else{
            if($asignadas == null){
                $promedio=0;
            }
            else{
                if($promedio->promedio != 0 and $asignadas !=0){
                    $promedio=($promedio->promedio/$asignadas);
                }
                else{
                    $promedio=0;
                }

            }

        }

        //dd($promedio);
        $semana_siguiente=$asignadas+1;
        // dd($semana_siguiente);
        $ultima_semana=DB::selectOne('SELECT MAX(resi_cronograma.no_semana) semana FROM resi_cronograma WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $ultima_semana=$ultima_semana->semana+1;
        $semana= DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' and no_semana='.$semana_siguiente.' ORDER BY `no_semana` ASC');
        if($semana == null){
            $calificar=0;
        }
        else {
            $fecha_inicio = $semana->f_inicio;
            $fecha_final = $semana->f_termino;
            $fecha_actual = date("Y-m-d");
            $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio . "+0 days"));
            $fecha_final = date("Y-m-d", strtotime($fecha_final . "+0 days"));

            //dd($fecha_actual);
            if ($fecha_inicio <= $fecha_actual) {
                $calificar = 1;
                //dd($calificar);
            } else {
                $calificar=0;
            }
        }

        $array_periodos = array();
        foreach ($semanas_asignadas as $asignada) {
            $array_crono['no_semana'] = $asignada->no_semana;
            $array_crono['id_cronograma'] = $asignada->id_cronograma;
            $array_crono['actividad'] = $asignada->actividad;
            $array_crono['f_inicio'] = $asignada->f_inicio;
            $array_crono['f_termino'] = $asignada->f_termino;
            $array_crono['promedio']= $asignada->promedio;
            $array_crono['estatus'] = 1;
            array_push($array_periodos, $array_crono);

        }
        $asignacion=$asignadas+1;
        $array_peri = array();
        for ($i = $asignacion; $i < $ultima_semana; $i++) {

            $semanass= DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' and no_semana='.$i.' ORDER BY `no_semana` ASC');

            if ($i == $semana_siguiente and $calificar==1) {

                $array_crono['no_semana'] = $i;
                $array_crono['id_cronograma'] =$semanass->id_cronograma;
                $array_crono['actividad'] = $semanass->actividad;
                $array_crono['f_inicio'] = $semanass->f_inicio;
                $array_crono['f_termino'] = $semanass->f_termino;
                $array_crono['promedio']=0;
                $array_crono['estatus'] = 2;

            } else {
                $array_crono['no_semana'] = $i;
                $array_crono['id_cronograma'] =$semanass->id_cronograma;
                $array_crono['actividad'] = $semanass->actividad;
                $array_crono['f_inicio'] = $semanass->f_inicio;
                $array_crono['f_termino'] = $semanass->f_termino;
                $array_crono['promedio']=0;
                $array_crono['estatus'] = 3;

            }

            array_push($array_peri, $array_crono);
        }
        $semanas = array_merge($array_periodos, $array_peri);
        $ultima=DB::selectOne('SELECT MAX(resi_cronograma.no_semana) semana FROM resi_cronograma WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $ultima=$ultima->semana;
        $proyecto_calificado=DB::selectOne('SELECT max(id_semana)semana FROM `resi_promedio_rubros` WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $proyecto_calificado=$proyecto_calificado->semana;
        if($ultima== $proyecto_calificado){
            $terminado_proyecto=1;
        }else{
            $terminado_proyecto=0;
        }

        $promedio_resi=DB::selectOne('SELECT count(id_anteproyecto) numero FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'' );
        if($promedio_resi->numero == 0){
            $promedio_final=0;
            $promedio_residencia=0;
        }
        else{
            $promedio_final=1;
            $promedio_residencia=DB::selectOne('SELECT *FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'' );
            $promedio_residencia=$promedio_residencia->promedio_general;



        }
        $alumno_anteproyecto=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno from gnral_alumnos,resi_anteproyecto where gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'');
        $nombre_alumno=$alumno_anteproyecto->cuenta." ".$alumno_anteproyecto->nombre." ".$alumno_anteproyecto->apaterno." ".$alumno_anteproyecto->amaterno;
        return view('residencia.seguimiento.mostrar_actividades_evaluadas_alumno',compact('semanas','promedio','terminado_proyecto','id_anteproyecto','promedio_residencia','promedio_final','nombre_alumno'));



    }
}
