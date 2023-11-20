<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Session;

class Resi_agregar_revisores_anteproyectosController extends Controller
{
    public function index()
    {
        $periodo_actual=Session::get('periodo_actual');

        $periodo_siguiente=$periodo_actual+1;
        $id_profesor = Session::get('id_perso');
        $presidente=DB::selectOne('SELECT * FROM `resi_academia` WHERE `id_profesor` ='.$id_profesor.' ');
        //dd($presidente);
        $id_carrera=$presidente->id_carrera;
         $anteproyectos=DB::select('SELECT gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.cuenta,resi_anteproyecto.id_anteproyecto, resi_proyecto.nom_proyecto,
 0 asesor,0 profesor,0 titulo,resi_anteproyecto.autorizacion_departamento FROM resi_anteproyecto,resi_proyecto,gnral_alumnos WHERE 
 gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and gnral_alumnos.id_carrera='.$id_carrera.'   
  and resi_anteproyecto.id_periodo = '.$periodo_actual.' AND resi_anteproyecto.estado_enviado = 3 
  and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto and 
   resi_anteproyecto.id_anteproyecto not in(SELECT resi_asesores.id_anteproyecto FROM resi_asesores where resi_asesores.id_periodo='.$periodo_siguiente.') 
UNION
SELECT gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
gnral_alumnos.cuenta,resi_anteproyecto.id_anteproyecto, resi_proyecto.nom_proyecto,1 asesor,
gnral_personales.nombre profesor,abreviaciones.titulo,resi_anteproyecto.autorizacion_departamento 
FROM resi_anteproyecto,resi_proyecto,gnral_alumnos,resi_asesores,gnral_personales,abreviaciones_prof,abreviaciones
 WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and gnral_alumnos.id_carrera='.$id_carrera.'
     and resi_anteproyecto.id_periodo = '.$periodo_actual.' AND resi_anteproyecto.estado_enviado = 3 
     and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto and
      resi_asesores.id_profesor=gnral_personales.id_personal and 
      gnral_personales.id_personal=abreviaciones_prof.id_personal and
       abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
         resi_asesores.id_anteproyecto=resi_anteproyecto.id_anteproyecto');


        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$periodo_siguiente.' AND
            id_carrera='.$id_carrera.'');
        //dd($id_periodo_carrera);
        if ($id_periodo_carrera == null){
            $no_plantilla=0;
            $plantillas=0;
        }
        else{
            $no_plantilla=1;

        }
//dd($anteproyectos);

     return view('residencia.seguimiento.agregar_asesores_anteproyecto',compact('anteproyectos','plantillas','no_plantilla'));

    }
    public function mostrar_asesores_anteproyecto($id_anteproyecto){
        $periodo_actual=Session::get('periodo_actual');

        $periodo_siguiente=$periodo_actual+1;
        $id_profesor = Session::get('id_perso');
        $presidente=DB::selectOne('SELECT * FROM `resi_academia` WHERE `id_profesor` ='.$id_profesor.' ');
        //dd($presidente);
        $id_carrera=$presidente->id_carrera;
        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$periodo_siguiente.' AND
            id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id_periodo_carrera);
        $plantillas = DB::select('select gnral_personales.id_personal,gnral_personales.nombre 
FROM gnral_personales, gnral_horarios WHERE gnral_horarios.id_periodo_carrera='.$id_periodo_carrera.' 
AND gnral_horarios.id_personal=gnral_personales.id_personal');
       //  dd($plantillas);

return view('residencia.seguimiento.profesor_plantilla',compact('plantillas','id_anteproyecto'));
    }
    public function guardar_asesores_anteproyecto(Request $request){

        $periodo_actual=Session::get('periodo_actual');
        $periodo_siguiente=$periodo_actual+1;

        $this->validate($request,[
            'id_anteproyecto' => 'required',
            'selectPersonal' => 'required',
        ]);
        $id_anteproyecto = $request->input("id_anteproyecto");
        $id_personal = $request->input("selectPersonal");

        $id_profesor = Session::get('id_perso');
        $presidente=DB::selectOne('SELECT * FROM `resi_academia` WHERE `id_profesor` ='.$id_profesor.' ');
        $id_carrera=$presidente->id_carrera;

        DB:: table('resi_asesores')->insert(['id_profesor' =>$id_personal,'id_carrera' =>$id_carrera,'id_anteproyecto' =>$id_anteproyecto,'id_periodo'=>$periodo_siguiente]);
        return back();

    }
    public function modificar_asesores_anteproyecto($id_anteproyecto)
    {
        $periodo_actual=Session::get('periodo_actual');

        $periodo_siguiente=$periodo_actual+1;
        $id_profesor = Session::get('id_perso');
        $presidente=DB::selectOne('SELECT * FROM `resi_academia` WHERE `id_profesor` ='.$id_profesor.' ');
        //dd($presidente);
        $id_carrera=$presidente->id_carrera;
        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$periodo_siguiente.' AND
            id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id_periodo_carrera);
        $plantillas = DB::select('select gnral_personales.id_personal,gnral_personales.nombre 
FROM gnral_personales, gnral_horarios WHERE gnral_horarios.id_periodo_carrera='.$id_periodo_carrera.' 
AND gnral_horarios.id_personal=gnral_personales.id_personal');
 $asesores=DB::selectOne('SELECT * FROM `resi_asesores` WHERE `id_anteproyecto` = '.$id_anteproyecto.'');
  return view('residencia.seguimiento.modificar_asesores_anteproyecto',compact('plantillas','asesores'));


    }
    public function modificacion_asesores_anteproyecto(Request $request){

        $periodo_actual=Session::get('periodo_actual');
        $periodo_siguiente=$periodo_actual+1;

        $this->validate($request,[
            'id_anteproyecto' => 'required',
            'id_profesor' => 'required',
        ]);
        $id_anteproyecto = $request->input("id_anteproyecto");
        $id_profesor = $request->input("id_profesor");



        DB::update('UPDATE resi_asesores SET id_profesor = '.$id_profesor.' WHERE resi_asesores.id_anteproyecto = '.$id_anteproyecto.'');
        return back();

    }
}
