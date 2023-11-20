<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class Ti_dep_inglesController extends Controller
{
    public function ingles_carreras(){
        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera != 9 and id_carrera != 11 and id_carrera != 15');
        return view('titulacion.jefe_ingles.ver_carreras_ingles',compact('carreras'));
    }
    public function ingles_alumnos_carrera($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM gnral_carreras where id_carrera='.$id_carrera.'');

        $registro_certificado=DB::select('SELECT in_certificado_acreditacion.*, gnral_alumnos.cuenta,
       gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno FROM
        in_certificado_acreditacion,gnral_alumnos WHERE gnral_alumnos.id_carrera='.$id_carrera.' 
      and gnral_alumnos.id_alumno=in_certificado_acreditacion.id_alumno ');


        $alumnos=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.id_alumno,gnral_alumnos.nombre,gnral_alumnos.apaterno,
         gnral_alumnos.amaterno from gnral_alumnos 
         where  gnral_alumnos.id_carrera='.$id_carrera.'  and  gnral_alumnos.id_alumno NOT in (SELECT id_alumno FROM in_certificado_acreditacion)  
ORDER BY `gnral_alumnos`.`apaterno`  ASC,`gnral_alumnos`.`amaterno`  ASC,`gnral_alumnos`.`nombre`  ASC');
        //dd($registro_certificado);
       return view('titulacion.jefe_ingles.registro_alumnos_certificado',compact('registro_certificado','carrera','alumnos'));
    }
    public function agregar_certificado($id_alumno){
       $alumno=DB::selectOne('select *from gnral_alumnos where id_alumno='.$id_alumno.'');
       return view("titulacion.jefe_ingles.modal_agregar_certificado",compact('alumno'));
    }
    public function guardar_certificado_alumno(Request  $request)
    {
        $documento=$request->file('documento');
        $id_alumno = $request->input("id_alumno");
        $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();

        $name="certificado_ingles_".$alumno[0]->cuenta.".".$documento->getClientOriginalExtension();
        $documento->move(public_path().'/certificado_ingles/',$name);
        $fecha_actual = date("d-m-Y");
        DB:: table('in_certificado_acreditacion')->insert([
            'pdf_certificado' =>$name,
            'fecha_registro' =>$fecha_actual,
            'id_alumno'=>$id_alumno]);
        return back();

    }
    public function editar_certificado($id_certificado_acreditacion){
 $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,in_certificado_acreditacion.* 
FROM gnral_alumnos,in_certificado_acreditacion 
where gnral_alumnos.id_alumno = in_certificado_acreditacion.id_alumno 
  and in_certificado_acreditacion.id_certificado_acreditacion='.$id_certificado_acreditacion.'');
 return view('titulacion.jefe_ingles.modificar_certificado',compact('alumno'));
    }
    public function modificar_edicion_datos_alumno(Request  $request){
        //dd($request);
        $documento=$request->file('documento');
        $id_certificado = $request->input("id_certificado");
        $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,in_certificado_acreditacion.* 
FROM gnral_alumnos,in_certificado_acreditacion 
where gnral_alumnos.id_alumno = in_certificado_acreditacion.id_alumno 
  and in_certificado_acreditacion.id_certificado_acreditacion='.$id_certificado.'');
        $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $alumno->id_alumno)->get();

        $name="certificado_ingles_".$alumno[0]->cuenta.".".$documento->getClientOriginalExtension();
        $documento->move(public_path().'/certificado_ingles/',$name);
        $fecha_actual = date("d-m-Y");
        DB::table('in_certificado_acreditacion')
            ->where('id_certificado_acreditacion', $id_certificado)
            ->update([ 'pdf_certificado' =>$name,
                'fecha_registro' =>$fecha_actual,
                ]);

        return back();
    }
    public function eliminar_certificado($id_certificado_acreditacion){
        $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,in_certificado_acreditacion.* 
FROM gnral_alumnos,in_certificado_acreditacion 
where gnral_alumnos.id_alumno = in_certificado_acreditacion.id_alumno 
  and in_certificado_acreditacion.id_certificado_acreditacion='.$id_certificado_acreditacion.'');

        return view('titulacion.jefe_ingles.eliminar_alumno_certificado',compact('alumno'));
    }
    public function enviar_certificado($id_certificado_acreditacion){
        $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,in_certificado_acreditacion.* 
FROM gnral_alumnos,in_certificado_acreditacion 
where gnral_alumnos.id_alumno = in_certificado_acreditacion.id_alumno 
  and in_certificado_acreditacion.id_certificado_acreditacion='.$id_certificado_acreditacion.'');
        return view('titulacion.jefe_ingles.enviar_certificado',compact('alumno','id_certificado_acreditacion'));
    }
    public function aceptar_envio_certificado(Request $request){
        $id_certificado = $request->input("id_certificado_acreditacion");
        $fecha_actual = date("d-m-Y");
        DB::table('in_certificado_acreditacion')
            ->where('id_certificado_acreditacion', $id_certificado)
            ->update([ 'enviado' =>1,
                'fecha_envio' =>$fecha_actual,
            ]);

        return back();
    }
    public function eliminacion_certificado(Request $request){
        $id_certificado = $request->input("id_certificado");
        DB::delete('DELETE FROM in_certificado_acreditacion WHERE id_certificado_acreditacion='.$id_certificado.' ');
        return back();
    }

}
