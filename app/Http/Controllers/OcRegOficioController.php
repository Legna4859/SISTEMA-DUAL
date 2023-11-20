<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\oc_oficio;
use App\oc_oficio_personal;
use App\oc_oficio_vehiculo;
use Session;

class OcRegOficioController extends Controller
{
    public function index()
    {
        //mostrar oficios de por unidad administrativa
        $fecha = date("Y-m-d");
        $ayer = date('Y-m-d', strtotime("-1 day", strtotime(($fecha))));
        $id_usuario = Session::get('usuario_alumno');
        $solicitudes = oc_oficio::has('comisionesvalidadas')
            ->where('id_usuario','=',$id_usuario)
            ->whereDate('fecha_salida', '>', $ayer)
            ->orderBy('fecha_hora','DESC')->get();

        return view('comision_oficio.registro_oficios',compact( 'solicitudes'));
    }
    public function historialoficios()
    {
        //mostrar  historial de  oficios por cada unidad
        $id_usuario = Session::get('usuario_alumno');
        $fecha = date("Y-m-d");

        $historiales = DB::table('oc_oficio_personal')
            ->join('oc_oficio','oc_oficio.id_oficio','=','oc_oficio_personal.id_oficio')
            ->join('gnral_personales','oc_oficio_personal.id_personal','=','gnral_personales.id_personal')->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->whereIn('oc_oficio_personal.id_notificacion',[1,2,3,4])
            ->where('oc_oficio.id_usuario','=',$id_usuario)
            ->whereDate('oc_oficio.fecha_salida', '<', $fecha)
            ->select('oc_oficio_personal.id_oficio_personal','oc_oficio.fecha_hora','oc_oficio.desc_comision','oc_oficio_personal.id_notificacion','oc_oficio_personal.viaticos','oc_oficio_personal.automovil','abreviaciones.titulo','gnral_personales.nombre')
            ->orderBy('oc_oficio.fecha_hora', 'DESC')
            ->get();

        return view('comision_oficio.historial_oficios_enviado', compact('historiales'));
    }
    public function mostrar($id_oficio){
        //mostar la solicitud por comisionado
        $oficios=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.desc_comision,oc_oficio.fecha_salida,oc_oficio.fecha_regreso,oc_oficio.hora_s,oc_oficio.hora_r from oc_oficio,oc_oficio_personal WHERE   oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
       $dependencias=DB::select('SELECT oc_depend_domicilio.*,gnral_estados.nombre_estado,gnral_municipios.nombre_municipio FROM oc_depend_domicilio,gnral_municipios,gnral_estados WHERE oc_depend_domicilio.id_municipio=gnral_municipios.id_municipio 
and gnral_municipios.id_estado=gnral_estados.id_estado and oc_depend_domicilio.id_oficio ='.$oficios->id_oficio.'');
        $personal=DB::selectOne('SELECT oc_oficio_vehiculo.licencia,oc_vehiculo.modelo,oc_vehiculo.placas,gnral_personales.nombre,abreviaciones.titulo,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_personal from oc_vehiculo,oc_oficio_vehiculo,oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_vehiculo.id_vehiculo=oc_oficio_vehiculo.id_vehiculo and oc_oficio_vehiculo.id_oficio_personal=oc_oficio_personal.id_oficio_personal and oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.id_oficio_personal='.$id_oficio.' and oc_oficio_personal.automovil=2 UNION SELECT 0,0,0,gnral_personales.nombre,abreviaciones.titulo,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_personal from oc_oficio_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and oc_oficio_personal.automovil=1 and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $lugar_s=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar,oc_oficio_personal WHERE oc_oficio.id_lugar_salida=oc_lugar.id_lugar and oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $lugar_r=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar,oc_oficio_personal WHERE oc_oficio.id_lugar_entrada=oc_lugar.id_lugar and oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');

       return view('comision_oficio.partialsof.modal_oficio',compact('dependencias'))->with([ 'oficios' => $oficios,'lugar_s' => $lugar_s,'lugar_r' => $lugar_r,'personal'=>$personal]);

    }

    public function  envio($id_oficio){
     //enviar oficio

        $fechass=date("Y-m-d H:i");
        $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
        $id_usuario = Session::get('usuario_alumno');
        if($jefe_division===true)
        {

            $departamento=DB::selectOne('select gnral_unidad_personal.id_unidad_persona from gnral_unidad_personal,gnral_personales WHERE gnral_personales.id_personal=gnral_unidad_personal.id_personal and gnral_personales.tipo_usuario='.$id_usuario.'');
            $departamento=$departamento->id_unidad_persona;
            $adscripto= DB::selectOne(' SELECT COUNT(adscripcion_personal.id_personal) numero FROM adscripcion_personal,oc_oficio_personal WHERE adscripcion_personal.id_personal=oc_oficio_personal.id_personal and oc_oficio_personal.id_oficio='.$id_oficio.' and adscripcion_personal.id_unidad_persona='.$departamento.'');
            $adscripto=$adscripto->numero;
           if($departamento == 24 || $departamento == 32 )
           {
               DB::update('UPDATE oc_oficio_personal SET id_notificacion = 1 WHERE oc_oficio_personal.id_oficio=' . $id_oficio . '');
               DB::table('oc_oficio')
                   ->where('id_oficio', $id_oficio)
                   ->update(['id_notificacion_solicitud' => 1, 'fecha_hora' => $fechass]);
               return redirect('/oficios/registrosoficio');
           }
           else {


               if ($adscripto == 0) {
                   DB::update('UPDATE oc_oficio_personal SET id_notificacion = 5 WHERE oc_oficio_personal.id_oficio=' . $id_oficio . '');
                   DB::table('oc_oficio')
                       ->where('id_oficio', $id_oficio)
                       ->update(['id_notificacion_solicitud' => 5, 'fecha_hora' => $fechass]);
                   return redirect('/oficios/registrosoficio');
               } else {
                   DB::update('UPDATE oc_oficio_personal SET id_notificacion = 1 WHERE oc_oficio_personal.id_oficio=' . $id_oficio . '');
                   DB::table('oc_oficio')
                       ->where('id_oficio', $id_oficio)
                       ->update(['id_notificacion_solicitud' => 1, 'fecha_hora' => $fechass]);
                   return redirect('/oficios/registrosoficio');
               }

           }

        }
        else{
            $unidad = DB::selectOne('SELECT gnral_unidad_personal.id_unidad_persona 
                from gnral_unidad_personal,gnral_unidad_administrativa,gnral_personales 
                WHERE gnral_unidad_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin 
                and gnral_unidad_personal.id_personal=gnral_personales.id_personal 
                and gnral_personales.tipo_usuario=' . $id_usuario . '');
            $unidad = $unidad->id_unidad_persona;
            //dd($unidad);
            if($unidad == 28)
            {
                DB::update('UPDATE oc_oficio_personal SET id_notificacion = 5 WHERE oc_oficio_personal.id_oficio=' . $id_oficio . '');
                DB::table('oc_oficio')
                    ->where('id_oficio', $id_oficio)
                    ->update(['id_notificacion_solicitud' => 5,'fecha_hora' => $fechass]);
                return redirect('/oficios/registrosoficio');

            }
            else {


                DB::update('UPDATE oc_oficio_personal SET id_notificacion = 1 WHERE oc_oficio_personal.id_oficio=' . $id_oficio . '');
                // DB::update('UPDATE oc_oficio SET id_notificacion_solicitud = 1 WHERE oc_oficio.id_oficio='.$id_oficio.'');
                DB::table('oc_oficio')
                    ->where('id_oficio', $id_oficio)
                    ->update(['id_notificacion_solicitud' => 1, 'fecha_hora' => $fechass]);
            }
        }


        return redirect('/oficios/registrosoficio');

    }
    public  function  aceptar_modificacion($id_oficio_comisionado)
    {
        $oficio= DB::selectOne('SELECT * FROM oc_oficio_personal WHERE id_oficio_personal = '.$id_oficio_comisionado.'');
       $id_oficio=$oficio->id_oficio;
       $ofi=DB::selectOne('SELECT * FROM oc_oficio WHERE id_oficio = '.$id_oficio.'');
        DB::update("UPDATE oc_oficio_personal SET estado_oficio = 0,fecha_salida ='$ofi->fecha_salida',fecha_regreso='$ofi->fecha_regreso'  WHERE oc_oficio_personal.id_oficio=$id_oficio ");
        DB::update("UPDATE oc_oficio_vehiculo SET fecha_salida ='$ofi->fecha_salida',fecha_regreso='$ofi->fecha_regreso'  WHERE oc_oficio_vehiculo.id_oficio_personal=$id_oficio_comisionado ");
        return redirect('/oficios/registrosoficio');
    }
    /*public function  ver_comisionados($id_oficio){
        //mostrar  comisionados para los pdf
        $comisionados=DB::select('SELECT abreviaciones.titulo,gnral_personales.id_personal,gnral_personales.nombre,oc_oficio_personal.viaticos,oc_oficio_personal.automovil,oc_oficio_personal.id_oficio_personal from abreviaciones_prof,abreviaciones,gnral_personales,oc_oficio,oc_oficio_personal WHERE abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and abreviaciones_prof.id_personal=gnral_personales.id_personal and oc_oficio.id_oficio=oc_oficio_personal.id_oficio and gnral_personales.id_personal=oc_oficio_personal.id_personal and oc_oficio_personal.id_oficio='.$id_oficio.'');


            return view('comision_oficio.pdf_comisionados', compact('comisionados'));


    }*/

    public function aceptado($id_oficio){
        //estado de la solicitud de  oficio aceptado
        $usuario= DB::selectOne('SELECT  oc_oficio.id_usuario FROM oc_oficio_personal,oc_oficio WHERE oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
       $usuario=$usuario->id_usuario;

        $anio=date("Y");
        $numero= DB::selectOne('SELECT MAX(oc_oficio_personal.no_oficio) numero FROM oc_oficio_personal WHERE anio='.$anio.'');
        $numero=$numero->numero;
        if($numero==0)
        {
            $numeross=1;
            DB::update('UPDATE oc_oficio_personal SET id_notificacion = 2,no_oficio='.$numeross.' WHERE oc_oficio_personal.id_oficio_personal = '.$id_oficio.'');
        }
        else
        {
            $numeross=$numero+1;
            DB::update('UPDATE oc_oficio_personal SET id_notificacion = 2,no_oficio='.$numeross.' WHERE oc_oficio_personal.id_oficio_personal = '.$id_oficio.'');

        }

        DB:: table('oc_notificacion')->insert(['id_usuario'=>$usuario,'id_oficio_personal'=>$id_oficio]);




        return redirect('/oficios/evaluacion');
    }
    public function rechazado($id_oficio){
        $usuario= DB::selectOne('SELECT  oc_oficio.id_usuario FROM oc_oficio_personal,oc_oficio WHERE oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $usuario=$usuario->id_usuario;
        $auto=DB::selectOne('SELECT oc_oficio_personal.automovil from oc_oficio_personal WHERE oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $auto=$auto->automovil;
        if ($auto == 2){
            DB::update('UPDATE oc_oficio_vehiculo SET notificacion =1 WHERE oc_oficio_vehiculo.id_oficio_personal  = '.$id_oficio.'');


        }

        DB::update('UPDATE oc_oficio_personal SET id_notificacion = 3,estado_oficio=1 WHERE oc_oficio_personal.id_oficio_personal  = '.$id_oficio.'');
        DB:: table('oc_notificacion')->insert(['id_usuario'=>$usuario,'id_oficio_personal'=>$id_oficio]);
        return redirect('/oficios/evaluacion');
    }
    public function aceptadosubdireccion($id_oficio){


        $usuario= DB::selectOne('SELECT  oc_oficio.id_usuario FROM oc_oficio_personal,oc_oficio WHERE oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $usuario=$usuario->id_usuario;

        $anio=date("Y");
        $numero= DB::selectOne('SELECT MAX(oc_oficio_personal.no_oficio) numero FROM oc_oficio_personal WHERE anio='.$anio.'');
        $numero=$numero->numero;
        if($numero==0)
        {
            $numeross=1;
            DB::update('UPDATE oc_oficio_personal SET id_notificacion = 2,no_oficio='.$numeross.' WHERE oc_oficio_personal.id_oficio_personal = '.$id_oficio.'');
        }
        else
        {
            $numeross=$numero+1;
            DB::update('UPDATE oc_oficio_personal SET id_notificacion = 2,no_oficio='.$numeross.' WHERE oc_oficio_personal.id_oficio_personal = '.$id_oficio.'');

        }

        DB:: table('oc_notificacion')->insert(['id_usuario'=>$usuario,'id_oficio_personal'=>$id_oficio]);



        return redirect('/oficios/evaluacionsubdirecion');
    }
    public function rechazadosubdireccion($id_oficio){
        $auto=DB::selectOne('SELECT oc_oficio_personal.automovil from oc_oficio_personal WHERE oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $auto=$auto->automovil;
        $usuario= DB::selectOne('SELECT  oc_oficio.id_usuario FROM oc_oficio_personal,oc_oficio WHERE oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $usuario=$usuario->id_usuario;
        if ($auto == 2){
            DB::update('UPDATE oc_oficio_vehiculo SET notificacion =1 WHERE oc_oficio_vehiculo.id_oficio_personal  = '.$id_oficio.'');

        }
        DB::update('UPDATE oc_oficio_personal SET id_notificacion =6,estado_oficio=1 WHERE oc_oficio_personal.id_oficio_personal  = '.$id_oficio.'');
        DB:: table('oc_notificacion')->insert(['id_usuario'=>$usuario,'id_oficio_personal'=>$id_oficio]);
        return redirect('/oficios/evaluacionsubdirecion');
    }

}
