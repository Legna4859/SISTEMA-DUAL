<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class Resi_Registrar_anteproyectoController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $registro_proy=DB::selectOne('select count(resi_anteproyecto.id_anteproyecto) proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $registro_proy=$registro_proy->proy;
         if($registro_proy ==0){
    $autorizar_proyecto=0;
          }
         else{
             $reg_proy=DB::selectOne('select resi_anteproyecto.id_anteproyecto proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
$reg_proy=$reg_proy->proy;
             $anteproyecto_completo=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto) anteproyecto from resi_anteproyecto,resi_alcances,resi_justificacion,resi_marco_teorico,resi_objetivos WHERE resi_alcances.id_anteproyecto=resi_anteproyecto.id_anteproyecto and resi_justificacion.id_anteproyecto=resi_anteproyecto.id_anteproyecto and resi_marco_teorico.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_objetivos.id_anteproyecto=resi_anteproyecto.id_anteproyecto and resi_anteproyecto.id_anteproyecto='.$reg_proy.'');
             $anteproyecto_completo=$anteproyecto_completo->anteproyecto;
             $cronograma=DB::selectOne('SELECT MAX(resi_cronograma.no_semana) numero from resi_cronograma where id_anteproyecto='.$reg_proy.'');
         $cronograma=$cronograma->numero;
      //  dd($anteproyecto_completo);
             if ($periodo%2==0) {
                 if($cronograma==17 and $anteproyecto_completo==1)
                 {

                     $autorizar_proyecto=1;
                 }
                 else{
                     $autorizar_proyecto=0;
                 }
             }
             else{

                 if($cronograma==19 and $anteproyecto_completo==1)
                 {
                     $autorizar_proyecto=1;
                 }
                 else{
                     $autorizar_proyecto=0;
                 }

             }
             }
        $enviado_anteproyecto=DB::selectOne('select resi_anteproyecto.estado_enviado proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        //dd($enviado_anteproyecto);
        if($enviado_anteproyecto == null)
        {
            $enviado_anteproyecto=0;
        }
        else{
            $enviado_anteproyecto=$enviado_anteproyecto->proy;
        }
//dd($autorizar_proyecto);

          return view('residencia.registro_anteproyecto',compact('registro_proy','autorizar_proyecto','reg_proy','enviado_anteproyecto'));
}
public function  enviar(Request $request)
{
    $this->validate($request,[
        'id_anteproyecto' => 'required',
    ]);

    $id_anteproyecto = $request->input("id_anteproyecto");
    DB:: table('resi_contar_evaluaciones')->insert(['id_anteproyecto' => $id_anteproyecto, 'numero_evaluacion' =>1]);


    DB::update("UPDATE resi_anteproyecto SET estado_enviado =1 WHERE resi_anteproyecto.id_anteproyecto =$id_anteproyecto");

return back();
}

}
