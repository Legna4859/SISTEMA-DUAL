<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;

class In_carga_academicaController extends Controller
{
    public function index(){
        $periodo_ingles=Session::get('periodo_ingles');
        $id_usuario = Session::get('usuario_alumno');
        //dd($id_usuario);
        //dd($id_alumno);

        //verifica que estado de validacion tiene el voucher para dejar al alumno si o no realizar su carga
        $count = DB::table('in_voucher_pago')
            ->join('users', 'users.id', '=', 'in_voucher_pago.id_usuario')
            ->where('in_voucher_pago.id_usuario', '=', $id_usuario)
            ->select(DB::raw('count(in_voucher_pago.id_estado_valida_voucher) as total'))
            ->get();

        if($count[0]->total == 0)
        {
            $id_estado_valida_voucher = 0;
        }
        else
        {
            $id_estado_valida_voucher = DB::table('in_voucher_pago')
                ->join('users', 'users.id', '=', 'in_voucher_pago.id_usuario')
                ->where('in_voucher_pago.id_usuario', '=', $id_usuario)
                ->select('in_voucher_pago.id_estado_valida_voucher as id_estado_valida_voucher')
                ->get();
            $id_estado_valida_voucher=$id_estado_valida_voucher[0]->id_estado_valida_voucher;

            //para controlar el número de veces que se ha usado el voucher durante el periodo cursado de ingles
            $con = DB::select('SELECT in_voucher_pago.num_veces_usado, in_voucher_pago.id_periodo_ingles
        FROM in_voucher_pago, users 
        WHERE in_voucher_pago.id_usuario=users.id 
        AND in_voucher_pago.id_usuario=' . $id_usuario. '') ;
            foreach ($con as $co)
            {
                $num_veces_usado = $co->num_veces_usado;
                $id_periodo_ingles = $co->id_periodo_ingles;
            }
            if(/*$id_periodo_ingles != $periodo_ingles &&*/ $num_veces_usado == 1)
            {
                ///////////////////////#############################################################
                //se requiere comprobar si quiere realizar una nueva carga academica
                //$periodo_ingles == $id_periodo_ingles+1 || $periodo_ingles == $id_periodo_ingles+2
                //$periodo_ingles > $id_periodo_ingles
                if($periodo_ingles == $id_periodo_ingles + 1 || $periodo_ingles == $id_periodo_ingles + 2)
                {
                    /*
                    DB::table('in_voucher_pago')
                        ->where('id_usuario', $id_usuario)
                        ->update(['num_veces_usado' => 2, 'id_periodo_ingles' => $periodo_ingles]);

                    return redirect()->back();
                    */
                }
                else if($periodo_ingles == $id_periodo_ingles + 3 || $periodo_ingles == $id_periodo_ingles + 4 || $periodo_ingles == $id_periodo_ingles+5)
                {
                    /*
                    DB::table('in_voucher_pago')
                        ->where('id_usuario', $id_usuario)
                        ->delete();
                    return redirect()->back();

                    */
                }
                else
                {
                    /*
                    DB::table('in_voucher_pago')
                        ->where('id_usuario', $id_usuario)
                        ->update(['num_veces_usado' => 1, 'id_periodo_ingles' => $id_periodo_ingles]);
                    */
                }
            }
            else if(/*$id_periodo_ingles != $periodo_ingles &&*/ $num_veces_usado == 2)
            {
                if($periodo_ingles > $id_periodo_ingles)
                {
                    /*
                    DB::table('in_voucher_pago')
                        ->where('id_usuario', $id_usuario)
                        ->delete();
                    return redirect()->back();
                    */
                }

                #########################################//////////////////////////
            }
            ///
        }
        ///


        $periodo_actual = DB::table('in_periodos')
            ->where('id_periodo_ingles', '=',$periodo_ingles)
            ->where('estado_actual', '=',1)
            ->select(DB::raw('count(in_periodos.id_periodo_ingles) as estado_actual'))
            ->get();
        $periodo_actual=$periodo_actual[0]->estado_actual;

        if($periodo_actual == 0)
        {
            $contar_disponibilidad=1; //disponibilidad de periodo
        }
        else {

            $datosalumno = DB::table('gnral_alumnos')
                ->where('id_usuario', '=', $id_usuario)
                ->select('gnral_alumnos.*')
                ->get();
            $alumno = $datosalumno[0]->id_alumno;
            $enviado = DB::table('in_validar_carga')
                ->where('in_validar_carga.id_periodo', '=', $periodo_ingles)
                ->where('in_validar_carga.id_alumno', '=', $alumno)
                ->where('in_validar_carga.id_estado', '=', 2)
                ->select(DB::raw('count(in_validar_carga.id_validar_carga) as total'))
                ->get();
            $enviado = $enviado[0]->total;

            $contar_disponibilidad = DB::table('in_hrs_ingles_profesor')
                ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
                ->select(DB::raw('count(in_hrs_ingles_profesor.id_nivel) as total'))
                ->get();

            $contar_disponibilidad = $contar_disponibilidad[0]->total;

            if ($contar_disponibilidad == 0) {
                $contar_disponibilidad = 0;
            } else {

                $contar_disponibilidad = 2;

                $contar_pr = DB::table('in_carga_academica_ingles')
                    ->join('in_validar_carga', 'in_validar_carga.id_alumno', '=', 'in_carga_academica_ingles.id_alumno')
                    ->join('in_evaluar_calificacion', 'in_evaluar_calificacion.id_carga_ingles', '=', 'in_carga_academica_ingles.id_carga_ingles')
                    ->where('in_carga_academica_ingles.id_alumno', '=', $alumno)
                    ->where('in_validar_carga.id_estado', '=', 2)
                    ->where('in_evaluar_calificacion.id_unidad', '=', 4)
                    ->select(DB::raw('count(in_carga_academica_ingles.id_carga_ingles) as total'))
                    ->get();
                $contar_pr = $contar_pr[0]->total;


                if ($contar_pr == 0) {
                    $niveles = DB::table('in_niveles_ingles')
                        ->join('in_hrs_ingles_profesor', 'in_hrs_ingles_profesor.id_nivel', '=', 'in_niveles_ingles.id_niveles_ingles')
                        ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
                        ->select('in_hrs_ingles_profesor.id_nivel', 'in_niveles_ingles.descripcion')
                        ->groupBy('in_hrs_ingles_profesor.id_nivel')
                        ->orderBy('in_hrs_ingles_profesor.id_nivel', 'ASC')
                        ->get();


                } else {
                    $carga_anterior = DB::table('in_carga_academica_ingles')
                        ->join('in_evaluar_calificacion', 'in_evaluar_calificacion.id_carga_ingles', '=', 'in_carga_academica_ingles.id_carga_ingles')
                        ->join('in_validar_carga', 'in_validar_carga.id_alumno', '=', 'in_carga_academica_ingles.id_alumno')
                        ->where('in_carga_academica_ingles.id_alumno', '=', $alumno)
                        ->where('in_validar_carga.id_estado', '=', 2)
                        ->where('in_evaluar_calificacion.id_unidad', '=', 4)
                        ->select(DB::raw('max(in_carga_academica_ingles.id_carga_ingles) as id_carga'))
                        ->get();

                    $carga_anterior = $carga_anterior[0]->id_carga;

                    $unidad1 = DB::table('in_evaluar_calificacion')
                        ->where('in_evaluar_calificacion.id_carga_ingles', '=', $carga_anterior)
                        ->where('in_evaluar_calificacion.id_unidad', '=', 1)
                        ->select('in_evaluar_calificacion.calificacion as unidad1')
                        ->get();
                    $unidad1=$unidad1[0]->unidad1;
                    $unidad2 = DB::table('in_evaluar_calificacion')
                        ->where('in_evaluar_calificacion.id_carga_ingles', '=', $carga_anterior)
                        ->where('in_evaluar_calificacion.id_unidad', '=', 2)
                        ->select('in_evaluar_calificacion.calificacion as unidad2')
                        ->get();
                    $unidad2=$unidad2[0]->unidad2;
                    $unidad3 = DB::table('in_evaluar_calificacion')
                        ->where('in_evaluar_calificacion.id_carga_ingles', '=', $carga_anterior)
                        ->where('in_evaluar_calificacion.id_unidad', '=', 3)
                        ->select('in_evaluar_calificacion.calificacion as unidad3')
                        ->get();
                    $unidad3=$unidad3[0]->unidad3;
                    $unidad4 = DB::table('in_evaluar_calificacion')
                        ->where('in_evaluar_calificacion.id_carga_ingles', '=', $carga_anterior)
                        ->where('in_evaluar_calificacion.id_unidad', '=', 4)
                        ->select('in_evaluar_calificacion.calificacion as unidad4')
                        ->get();
                    $unidad4=$unidad4[0]->unidad4;
                    $promedio=($unidad1+$unidad2+$unidad3+$unidad4)/4;
                    $promedio=round($promedio);



                    if($promedio < 80)
                    {

                        $baja = DB::table('in_carga_academica_ingles')
                            ->where('in_carga_academica_ingles.id_carga_ingles', '=', $carga_anterior)
                            ->select('in_carga_academica_ingles.*')
                            ->get();
                        $baja_alumno=$baja[0]->estado_nivel+1;


                        if($baja_alumno == 5){
                            $contar_disponibilidad=4;
                        }
                        else{
                            $nivel=$baja[0]->id_nivel;
                            $niveles = DB::table('in_niveles_ingles')
                                ->join('in_hrs_ingles_profesor', 'in_hrs_ingles_profesor.id_nivel', '=', 'in_niveles_ingles.id_niveles_ingles')
                                ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
                                ->where('in_hrs_ingles_profesor.id_nivel', '=', $nivel)
                                ->select(DB::raw('count(in_hrs_ingles_profesor.id_nivel) as total'))
                                ->get();
                            //dd($nivel);
                            if($niveles[0]->total == 0){

                                $contar_disponibilidad=3;
                            }
                            else{

                                $niveles = DB::table('in_niveles_ingles')
                                    ->join('in_hrs_ingles_profesor', 'in_hrs_ingles_profesor.id_nivel', '=', 'in_niveles_ingles.id_niveles_ingles')
                                    ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
                                    ->where('in_hrs_ingles_profesor.id_nivel', '=', $nivel)
                                    ->select('in_hrs_ingles_profesor.id_nivel', 'in_niveles_ingles.descripcion')
                                    ->groupBy('in_hrs_ingles_profesor.id_nivel')
                                    ->orderBy('in_hrs_ingles_profesor.id_nivel', 'ASC')
                                    ->get();


                            }

                        }

                    }
                    else{
                        $nivel_anterior = DB::table('in_carga_academica_ingles')
                            ->where('in_carga_academica_ingles.id_carga_ingles', '=', $carga_anterior)
                            ->select('in_carga_academica_ingles.*')
                            ->get();
                        $nivel_siguiente=$nivel_anterior[0]->id_nivel+1;

                        $niveles = DB::table('in_niveles_ingles')
                            ->join('in_hrs_ingles_profesor', 'in_hrs_ingles_profesor.id_nivel', '=', 'in_niveles_ingles.id_niveles_ingles')
                            ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
                            ->where('in_hrs_ingles_profesor.id_nivel', '=', $nivel_siguiente)
                            ->select('in_hrs_ingles_profesor.id_nivel', 'in_niveles_ingles.descripcion')
                            ->groupBy('in_hrs_ingles_profesor.id_nivel')
                            ->orderBy('in_hrs_ingles_profesor.id_nivel', 'ASC')
                            ->get();


                    }



                }


            }
        }
        $disponibilidad = 0;

        return view('ingles.alumno_ingles.llenar_carga_ingles',compact('niveles','disponibilidad','contar_disponibilidad','enviado','id_estado_valida_voucher'));
    }
    public function carga_academica_niveles($id_niveles){
        $periodo_ingles=Session::get('periodo_ingles');
        $grupos = DB::table('in_hrs_ingles_profesor')
            ->where('id_periodo', '=', $periodo_ingles)
            ->where('id_nivel', '=', $id_niveles)
            ->select('in_hrs_ingles_profesor.*')
            ->orderBy('in_hrs_ingles_profesor.id_grupo', 'ASC')
            ->get();
        return response()->json($grupos);
    }
    public function carga_academica_grupo($id_hrs_niveles_grupo){
        $id_estado_valida_voucher=2;
        $periodo_ingles=Session::get('periodo_ingles');
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno = DB::table('gnral_alumnos')
            ->where('id_usuario', '=', $id_usuario)
            ->select('gnral_alumnos.*')
            ->get();
        $alumno=$datosalumno[0]->id_alumno;
        $registrado = DB::table('in_validar_carga')
            ->where('in_validar_carga.id_periodo','=',$periodo_ingles)
            ->where('in_validar_carga.id_alumno','=',$alumno)
            ->select(DB::raw('count(in_validar_carga.id_validar_carga) as total'))
            ->get();
        $registrado=$registrado[0]->total;
        $horario_profesor=DB::selectOne('SELECT * FROM in_hrs_ingles_profesor WHERE id_hrs_ingles_profesor = '.$id_hrs_niveles_grupo.' ORDER BY id_grupo ASC');
        $id_grupo=$horario_profesor->id_grupo;
        $id_nivel=$horario_profesor->id_nivel;
        $id_profesor=$horario_profesor->id_profesor;
        $id_periodo=$horario_profesor->id_periodo;
        $horas_profesor=DB::select('SELECT in_hrs_horas_profesor.id_semana FROM in_hrs_horas_profesor WHERE id_grupo = '.$id_grupo.' AND id_nivel = '.$id_nivel.' AND id_periodo = '.$id_periodo.'');
        $array_horario_profesor_ing=array();
        $array_semana=array();
        foreach($horas_profesor as $hora_profesor)
        {
            $horario_prof_grupo['id_semana']=$hora_profesor->id_semana;
            array_push($array_horario_profesor_ing,$horario_prof_grupo);
        }
        $sem=DB::select('select id_semana FROM hrs_semanas ');
        foreach($sem as $sem)
        {
            $semanas['id_semana']=$sem->id_semana;
            array_push($array_semana,$semanas);
        }

        $resultado_semana=array();
        foreach ($array_semana as $semana_hora) {
            $esta=false;
            foreach ($array_horario_profesor_ing as $hrs_profesor) {
                if ($semana_hora['id_semana']==$hrs_profesor['id_semana']) {
                    $esta=true;
                    break;
                } // esta es la que se me olvidaba
            }
            if (!$esta) $resultado_semana[]=$semana_hora;
        }
        $array_ingles=array();
        foreach ($resultado_semana as $resultado)
        {
            $array_ing['id_semana']= $resultado['id_semana'];
            $array_ing['nombre']=0;
            $array_ing['id_nivel']=0;
            $array_ing['id_grupo']=0;
            $array_ing['disponibilidad']=3;

            array_push($array_ingles,$array_ing);
        }
        $profesores_horario=DB::select('SELECT in_hrs_horas_profesor.id_semana,in_profesores_ingles.nombre,in_profesores_ingles.apellido_paterno,in_profesores_ingles.apellido_materno 
FROM in_hrs_horas_profesor,in_profesores_ingles WHERE in_profesores_ingles.id_profesores=in_hrs_horas_profesor.id_profesor 
and in_hrs_horas_profesor.id_grupo ='.$id_grupo.' AND in_hrs_horas_profesor.id_nivel ='.$id_nivel.' AND in_hrs_horas_profesor.id_periodo ='.$id_periodo.' ORDER BY in_hrs_horas_profesor.id_semana ASC');
        ;
        $niv=DB::selectOne('SELECT * FROM `in_niveles_ingles` WHERE `id_niveles_ingles` ='.$id_nivel.'');
        $niv=$niv->descripcion;
        foreach ($profesores_horario as $profesor_hor)
        {
            $array_labor['id_semana']= $profesor_hor->id_semana;
            $array_labor['nombre']=$profesor_hor->nombre.' '.$profesor_hor->apellido_paterno.' '.$profesor_hor->apellido_materno;
            $array_labor['id_nivel']=$niv;
            $array_labor['id_grupo']=$id_grupo;
            $array_labor['disponibilidad']=2;

            array_push($array_ingles,$array_labor);
        }
        foreach ($array_ingles as $key => $row) {
            $aux[$key] = $row['id_semana'];
        }
        array_multisort($aux, SORT_ASC, $array_ingles);
        $dias = DB::select('select DISTINCT dia FROM hrs_semanas');
        $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
        $disponibilidad=1;
        $periodo_ingles=Session::get('periodo_ingles');
        $niveles=DB::select('SELECT in_hrs_ingles_profesor.id_nivel,in_niveles_ingles.descripcion 
FROM in_hrs_ingles_profesor,in_niveles_ingles where in_hrs_ingles_profesor.id_nivel=in_niveles_ingles.id_niveles_ingles and in_hrs_ingles_profesor.id_periodo='.$periodo_ingles.'
GROUP by in_hrs_ingles_profesor.id_nivel ORDER BY in_hrs_ingles_profesor.id_nivel ASC');
        $grupos = DB::table('in_hrs_ingles_profesor')
            ->where('id_periodo', '=', $periodo_ingles)
            ->where('id_nivel', '=', $id_nivel)
            ->select('in_hrs_ingles_profesor.*')
            ->orderBy('in_hrs_ingles_profesor.id_grupo', 'ASC')
            ->get();
        // $grupos=DB::select('SELECT * FROM in_hrs_ingles_profesor WHERE id_nivel = '.$id_nivel.' ORDER BY in_hrs_ingles_profesor.id_grupo ASC');
        return view('ingles.alumno_ingles.llenar_carga_ingles',compact('id_estado_valida_voucher','array_ingles','disponibilidad','id_nivel','id_hrs_niveles_grupo','niveles','grupos','semanas','registrado'));
    }
public function seleccionar_grupo_carga($id_hrs_niveles_grupo,$numero){

    $id_usuario = Session::get('usuario_alumno');
    $datosalumno = DB::table('gnral_alumnos')
        ->where('id_usuario', '=', $id_usuario)
        ->select('gnral_alumnos.*')
        ->get();
   $alumno=$datosalumno[0]->id_alumno;
    $hrs_profesor = DB::table('in_hrs_ingles_profesor')
        ->where('id_hrs_ingles_profesor', '=', $id_hrs_niveles_grupo)
        ->select('in_hrs_ingles_profesor.*')
        ->get();
    $id_grupo=$hrs_profesor[0]->id_grupo;
    $id_nivel=$hrs_profesor[0]->id_nivel;
    $periodo_ingles=Session::get('periodo_ingles');
    if($numero == 1){
        DB:: table('in_carga_academica_ingles')->insert(['id_alumno'=>$alumno,'id_nivel'=>$id_nivel,'id_grupo'=>$id_grupo,'id_periodo_ingles'=>$periodo_ingles]);
        DB:: table('in_validar_carga')->insert(['id_alumno'=>$alumno,'id_periodo'=>$periodo_ingles]);
    }
    if($numero == 2){
        $registrado = DB::table('in_validar_carga')
            ->where('in_validar_carga.id_periodo','=',$periodo_ingles)
            ->where('in_validar_carga.id_alumno','=',$alumno)
            ->where('in_validar_carga.id_estado','=',3)
            ->select(DB::raw('count(in_validar_carga.id_validar_carga) as total'))
            ->get();
        if($registrado[0]->total == 0) {
            DB::table('in_carga_academica_ingles')
                ->where('id_alumno', $alumno)
                ->where('id_periodo_ingles', $periodo_ingles)
                ->update(['id_nivel' => $id_nivel, 'id_grupo' => $id_grupo]);
        }
        else{
            $corregir = DB::table('in_carga_academica_ingles')
                ->where('in_carga_academica_ingles.id_periodo_ingles','=',$periodo_ingles)
                ->where('in_carga_academica_ingles.id_alumno','=',$alumno)
                ->select('in_carga_academica_ingles.*')
                ->get();
            if ($corregir[0]->id_nivel == $id_nivel and $corregir[0]->id_grupo == $id_grupo){
                DB::table('in_carga_academica_ingles')
                    ->where('id_alumno', $alumno)
                    ->where('id_periodo_ingles', $periodo_ingles)
                    ->update(['id_nivel' => $id_nivel, 'id_grupo' => $id_grupo]);
            }
            else{
                $comentario="";
                DB::table('in_carga_academica_ingles')
                    ->where('id_alumno', $alumno)
                    ->where('id_periodo_ingles', $periodo_ingles)
                    ->update(['id_nivel' => $id_nivel,'id_grupo' => $id_grupo]);
                DB::table('in_validar_carga')
                    ->where('id_alumno', $alumno)
                    ->where('id_periodo', $periodo_ingles)
                    ->update(['id_estado' =>0,'comentario' => $comentario]);

            }
        }

    }
    return redirect('/ingles_horarios/revision_carga_academica/');

}
    public function revision_carga_academica(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo_ingles=Session::get('periodo_ingles');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;


        $registrado = DB::table('in_validar_carga')
            ->where('in_validar_carga.id_periodo','=',$periodo_ingles)
            ->where('in_validar_carga.id_alumno','=',$alumno)
            ->select(DB::raw('count(in_validar_carga.id_validar_carga) as total'))
            ->get();
        $registrado=$registrado[0]->total;
         if($registrado == 0){
             return view('ingles.alumno_ingles.revision_carga_ingles',compact('registrado'));

         }
         else {
$registrado=1;
            $carga_academica = DB::selectOne('SELECT in_niveles_ingles.clave,in_niveles_ingles.descripcion nivel,in_grupo_ingles.descripcion grupo,
in_carga_academica_ingles.* from in_niveles_ingles,in_grupo_ingles,in_carga_academica_ingles 
where in_carga_academica_ingles.id_nivel=in_niveles_ingles.id_niveles_ingles 
and in_carga_academica_ingles.id_grupo=in_grupo_ingles.id_grupo_ingles 
and in_carga_academica_ingles.id_alumno=' . $alumno . ' and in_carga_academica_ingles.id_periodo_ingles=' .$periodo_ingles. '') ;

             $id_grupo = $carga_academica->id_grupo;
             $id_nivel = $carga_academica->id_nivel;


             $horario_grupo = DB::select('SELECT * FROM in_hrs_horas_profesor WHERE id_grupo =' . $id_grupo . ' AND id_nivel = ' . $id_nivel . ' AND id_periodo = ' . $periodo_ingles . '');

             $array_horario_ing = array();
             $array_semana = array();
             foreach ($horario_grupo as $horario_grupo) {
                 $horario_prof['id_semana'] = $horario_grupo->id_semana;
                 array_push($array_horario_ing, $horario_prof);
             }

             $sem = DB::select('select id_semana FROM hrs_semanas ');
             foreach ($sem as $sem) {
                 $semanas['id_semana'] = $sem->id_semana;
                 array_push($array_semana, $semanas);
             }

             $resultado_semana = array();
             foreach ($array_semana as $vehiculo) {
                 $esta = false;
                 foreach ($array_horario_ing as $vehiculo2) {
                     if ($vehiculo['id_semana'] == $vehiculo2['id_semana']) {
                         $esta = true;
                         break;
                     } // esta es la que se me olvidaba
                 }
                 if (!$esta) $resultado_semana[] = $vehiculo;
             }

             $array_ingles = array();
             foreach ($resultado_semana as $resultado) {
                 $array_ing['id_semana'] = $resultado['id_semana'];
                 $array_ing['nivel'] = 0;
                 $array_ing['grupo'] = 0;
                 $array_ing['disponibilidad'] = 3;
                 array_push($array_ingles, $array_ing);
             }
             $profesores_horario = DB::select('
SELECT in_grupo_ingles.descripcion grupo,in_niveles_ingles.descripcion nivel, in_hrs_horas_profesor.* 
FROM  in_hrs_horas_profesor,in_niveles_ingles,in_grupo_ingles 
WHERE in_hrs_horas_profesor.id_grupo = ' . $id_grupo . ' AND in_hrs_horas_profesor.id_nivel = ' . $id_nivel . '
 AND in_hrs_horas_profesor.id_periodo = ' . $periodo_ingles . ' and in_hrs_horas_profesor.id_grupo=in_grupo_ingles.id_grupo_ingles
  and in_hrs_horas_profesor.id_nivel=in_niveles_ingles.id_niveles_ingles  
ORDER BY `in_hrs_horas_profesor`.`id_semana` ASC');
//dd($profesores_horario);
             foreach ($profesores_horario as $profesor_hor) {
                 $array_labor['id_semana'] = $profesor_hor->id_semana;
                 $array_labor['nivel'] = $profesor_hor->nivel;
                 $array_labor['grupo'] = $profesor_hor->grupo;
                 $array_labor['disponibilidad'] = 2;

                 array_push($array_ingles, $array_labor);
             }
             foreach ($array_ingles as $key => $row) {
                 $aux[$key] = $row['id_semana'];
             }
             array_multisort($aux, SORT_ASC, $array_ingles);

             $profesor = DB::selectOne('SELECT in_profesores_ingles.* FROM in_hrs_ingles_profesor,in_profesores_ingles 
WHERE in_hrs_ingles_profesor.id_grupo = ' . $id_grupo . ' AND in_hrs_ingles_profesor.id_nivel = ' . $id_nivel . ' 
AND in_hrs_ingles_profesor.id_periodo = ' . $periodo_ingles . '
 and in_hrs_ingles_profesor.id_profesor=in_profesores_ingles.id_profesores');
             $semanas = DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
             $enviado = DB::table('in_validar_carga')
                 ->where('in_validar_carga.id_periodo','=',$periodo_ingles)
                 ->where('in_validar_carga.id_alumno','=',$alumno)
                 ->where('in_validar_carga.id_estado','=',2)
                 ->select(DB::raw('count(in_validar_carga.id_validar_carga) as total'))
                 ->get();
            $enviado=$enviado[0]->total;
             $comentario = DB::table('in_validar_carga')
                 ->where('in_validar_carga.id_periodo','=',$periodo_ingles)
                 ->where('in_validar_carga.id_alumno','=',$alumno)
                 ->select('in_validar_carga.*')
                 ->get();
             $contar_pr = DB::table('in_carga_academica_ingles')
                 ->join('in_validar_carga', 'in_validar_carga.id_alumno', '=', 'in_carga_academica_ingles.id_alumno')
                 ->join('in_evaluar_calificacion', 'in_evaluar_calificacion.id_carga_ingles', '=', 'in_carga_academica_ingles.id_carga_ingles')
                 ->where('in_carga_academica_ingles.id_alumno', '=', $alumno)
                 ->where('in_validar_carga.id_estado', '=', 2)
                 ->where('in_evaluar_calificacion.id_unidad', '=', 2)
                 ->select(DB::raw('count(in_carga_academica_ingles.id_carga_ingles) as total'))
                 ->get();
             $contar_pr = $contar_pr[0]->total;

if($contar_pr == 0){
    $eva_tipo_curso = DB::table('eva_tipo_curso')
        ->orderBy('eva_tipo_curso.id_tipo_curso', 'ASC')
        ->get();
}
else{
    $carga_anterior = DB::table('in_carga_academica_ingles')
        ->join('in_evaluar_calificacion', 'in_evaluar_calificacion.id_carga_ingles', '=', 'in_carga_academica_ingles.id_carga_ingles')
        ->join('in_validar_carga', 'in_validar_carga.id_alumno', '=', 'in_carga_academica_ingles.id_alumno')
        ->where('in_carga_academica_ingles.id_alumno', '=', $alumno)
        ->where('in_validar_carga.id_estado', '=', 2)
        ->where('in_evaluar_calificacion.id_unidad', '=', 4)
        ->select(DB::raw('max(in_carga_academica_ingles.id_carga_ingles) as id_carga'))
        ->get();
    $carga_anterior = $carga_anterior[0]->id_carga;
    $unidad1 = DB::table('in_evaluar_calificacion')
        ->where('in_evaluar_calificacion.id_carga_ingles', '=', $carga_anterior)
        ->where('in_evaluar_calificacion.id_unidad', '=', 1)
        ->select('in_evaluar_calificacion.calificacion as unidad1')
        ->get();
    $unidad1=$unidad1[0]->unidad1;
    $unidad2 = DB::table('in_evaluar_calificacion')
        ->where('in_evaluar_calificacion.id_carga_ingles', '=', $carga_anterior)
        ->where('in_evaluar_calificacion.id_unidad', '=', 2)
        ->select('in_evaluar_calificacion.calificacion as unidad2')
        ->get();
    $unidad2=$unidad2[0]->unidad2;
    $unidad3 = DB::table('in_evaluar_calificacion')
        ->where('in_evaluar_calificacion.id_carga_ingles', '=', $carga_anterior)
        ->where('in_evaluar_calificacion.id_unidad', '=', 3)
        ->select('in_evaluar_calificacion.calificacion as unidad3')
        ->get();
    $unidad3=$unidad3[0]->unidad3;
    $unidad4 = DB::table('in_evaluar_calificacion')
        ->where('in_evaluar_calificacion.id_carga_ingles', '=', $carga_anterior)
        ->where('in_evaluar_calificacion.id_unidad', '=', 4)
        ->select('in_evaluar_calificacion.calificacion as unidad4')
        ->get();
    $unidad4=$unidad4[0]->unidad4;
    $promedio=($unidad1+$unidad2+$unidad3+$unidad4)/4;
    $promedio=round($promedio);
    $cargas = DB::table('in_carga_academica_ingles')
        ->where('in_carga_academica_ingles.id_carga_ingles', '=', $carga_anterior)
        ->select('in_carga_academica_ingles.*')
        ->get();

    if($promedio < 80) {

        $id_estado_nivel = $cargas[0]->estado_nivel + 1;
        $eva_tipo_curso = DB::table('eva_tipo_curso')
            ->where('eva_tipo_curso.id_tipo_curso', '=', $id_estado_nivel)
            ->orderBy('eva_tipo_curso.id_tipo_curso', 'ASC')
            ->get();
    }
    else{
        $id_estado_nivel = $cargas[0]->estado_nivel;
        $eva_tipo_curso = DB::table('eva_tipo_curso')
            ->where('eva_tipo_curso.id_tipo_curso', '=',1)
            ->orderBy('eva_tipo_curso.id_tipo_curso', 'ASC')
            ->get();
    }
}

             $tipo_curso = DB::table('eva_tipo_curso')
                 ->where('eva_tipo_curso.id_tipo_curso','=',$carga_academica->estado_nivel)
                 ->orderBy('eva_tipo_curso.id_tipo_curso', 'ASC')
                 ->get();
            $tip_c= DB::table('eva_tipo_curso')
                ->where('eva_tipo_curso.id_tipo_curso','=',$carga_academica->estado_nivel)
                ->select(DB::raw('count(eva_tipo_curso.id_tipo_curso) as total'))
                ->get();
            $tip_c=$tip_c[0]->total;

if($tip_c == 0){
    $tipo_curso="";
}
else{
    $tipo_curso=$tipo_curso[0]->nombre_curso;
}


             return view('ingles.alumno_ingles.revision_carga_ingles',compact('registrado','profesor','array_ingles','semanas','carga_academica','enviado','comentario','eva_tipo_curso','tipo_curso','tip_c'));

         }
        //dd($profesor);

    }
    public function enviar_carga_academica_ingles($id_nivel,$id_grupo,$id_tipo_curso){

        $periodo_ingles=Session::get('periodo_ingles');
        $estado_grupo = DB::table('in_validar_carga')
            ->join('in_carga_academica_ingles', 'in_carga_academica_ingles.id_alumno', '=', 'in_validar_carga.id_alumno')
             ->where('in_validar_carga.id_estado', '=',2)
            ->where('in_carga_academica_ingles.id_grupo', '=', $id_grupo)
            ->where('in_carga_academica_ingles.id_nivel', '=', $id_nivel)
            ->where('in_carga_academica_ingles.id_periodo_ingles', '=', $periodo_ingles)
            ->where('in_validar_carga.id_periodo', '=', $periodo_ingles)
            ->select(DB::raw('count(in_validar_carga.id_validar_carga) as total'))
            ->get();
        $estado_grupo=$estado_grupo[0]->total;

        $numero_maximo_alumnos = DB::selectOne('SELECT * FROM in_maximo_grupo_ingles WHERE id_periodo_ingles = '.$periodo_ingles.'');

        if($estado_grupo <= $numero_maximo_alumnos->num_maximo_alumnos){



            $id_usuario = Session::get('usuario_alumno');
            $periodo_ingles = Session::get('periodo_ingles');
            $datosalumno = DB::table('gnral_alumnos')
                ->where('id_usuario', '=', $id_usuario)
                ->select('gnral_alumnos.*')
                ->get();
            $alumno = $datosalumno[0]->id_alumno;
            DB::table('in_validar_carga')
                ->where('id_alumno', $alumno)
                ->where('id_periodo', $periodo_ingles)
                ->update(['id_estado' => 2]);
            DB::table('in_carga_academica_ingles')
                ->where('id_alumno', $alumno)
                ->where('id_periodo_ingles', $periodo_ingles)
                ->update(['estado_nivel'=> $id_tipo_curso]);
        }
        else {


            $comentario="El grupo alcanzo su limite de estudiantes, debes elegir otro grupo";
            $id_usuario = Session::get('usuario_alumno');
            $periodo_ingles = Session::get('periodo_ingles');
            $datosalumno = DB::table('gnral_alumnos')
                ->where('id_usuario', '=', $id_usuario)
                ->select('gnral_alumnos.*')
                ->get();
            $alumno = $datosalumno[0]->id_alumno;
            DB::table('in_validar_carga')
                ->where('id_alumno', $alumno)
                ->where('id_periodo', $periodo_ingles)
                ->update(['id_estado' => 3,'comentario' => $comentario]);
        }
        return back();

    }
}
