<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\oc_oficio;
use App\oc_oficio_personal;
use App\oc_oficio_vehiculo;
use Session;


class OficiosRegistrarcomisionadosController extends Controller
{
    public function store(Request $request){
        $numeross = $request->input("id_oficio");
        $personal = $request->input("selectPersonal");
        $selectViatico = $request->input("selectViatico");
        $selectAutomovil= $request->input("selectAutomovil");
        $anio=date("Y");
        $numero= DB::selectOne('SELECT MAX(oc_oficio_personal.id_oficio_personal) numero FROM oc_oficio_personal ');
        $numero=$numero->numero;
        $num=isset($numero);

        if($num==false)
        {
            $numer=1;
            $oficios=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.fecha_salida,oc_oficio.fecha_regreso from oc_oficio WHERE oc_oficio.id_oficio='.$numeross.'');
            $fecha_salida=$oficios->fecha_salida;
            $fecha_regreso=$oficios->fecha_regreso;
            DB:: table('oc_oficio_personal')->insert(['id_oficio_personal'=>$numer,'id_oficio'=>$numeross,'anio'=>$anio,'id_personal'=>$personal,'viaticos' =>$selectViatico,'automovil'=>$selectAutomovil,'no_oficio'=>0,'fecha_salida' => $fecha_salida,'fecha_regreso'=>$fecha_regreso]);
            if($selectAutomovil == 2) {
                $automoviles = $request->input("automoviles");
                $licencia = $request->input("licencia");
                DB:: table('oc_oficio_vehiculo')->insert(['id_vehiculo'=>$automoviles,'id_oficio_personal'=>$numer,'fecha_salida' => $fecha_salida,'fecha_regreso'=>$fecha_regreso,'licencia'=>$licencia]);
            }
        }
        if($num==true)
        {
            $numer=$numero+1;
            $oficios=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio.fecha_salida,oc_oficio.fecha_regreso from oc_oficio WHERE oc_oficio.id_oficio='.$numeross.'');
            $fecha_salida=$oficios->fecha_salida;
            $fecha_regreso=$oficios->fecha_regreso;
            DB:: table('oc_oficio_personal')->insert(['id_oficio_personal'=>$numer,'id_oficio'=>$numeross,'anio'=>$anio,'id_personal'=>$personal,'viaticos' =>$selectViatico,'automovil'=>$selectAutomovil,'no_oficio'=>0,'fecha_salida' => $fecha_salida,'fecha_regreso'=>$fecha_regreso]);
            if($selectAutomovil == 2) {
                $automoviles = $request->input("automoviles");
                $licencia = $request->input("licencia");
                DB:: table('oc_oficio_vehiculo')->insert(['id_vehiculo'=>$automoviles,'id_oficio_personal'=>$numer,'fecha_salida' => $fecha_salida,'fecha_regreso'=>$fecha_regreso,'licencia'=>$licencia]);
            }
        }

return back();
    }
    public function rediccionamiento(){
        $id_usuario = Session::get('usuario_alumno');
        DB::delete('DELETE FROM oc_notificacion WHERE id_usuario='.$id_usuario.'');
         return redirect('/oficios/registrosoficio');
    }
}
