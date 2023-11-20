<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Excel;
use Session;

class In_historial_alumController extends Controller
{
    public function  index(){
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
           /* ->where('gnral_carreras.id_carrera','!=',11)*/
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
       return view('ingles.departamento.carreras_historial',compact('carreras'));
    }
    public function ver_alumnos_carrera($id_carrera){
        $alumnos=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta, 
       gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno 
from gnral_alumnos,in_validar_carga where gnral_alumnos.id_alumno = in_validar_carga.id_alumno 
AND gnral_alumnos.id_carrera = '.$id_carrera.'
GROUP BY gnral_alumnos.id_alumno ORDER BY `gnral_alumnos`.`apaterno`,
                                          `gnral_alumnos`.`amaterno`, `gnral_alumnos`.`nombre` DESC 
');
        $periodo_actual=DB::selectOne('SELECT in_periodos.* from in_periodos where estado_historial=1 ');

        $array_alumnos = array();
        $numero=0;
        foreach ($alumnos as $alumno){
            $numero++;
            $dat_alumnos['numero'] = $numero;
            $dat_alumnos['id_alumno'] = $alumno->id_alumno;
            $dat_alumnos['cuenta'] = $alumno->cuenta;
            $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
            $periodos=DB::select('SELECT in_periodos.* from in_periodos where id_periodo_ingles <'.$periodo_actual->id_periodo_ingles.' and id_periodo_ingles >1');

            $array_periodo=array();
            foreach ($periodos as $periodo){
                $validacion_carga= DB::selectOne('SELECT count(in_validar_carga.id_validar_carga) validacion
              from in_validar_carga where id_alumno='.$alumno->id_alumno.' 
              and id_periodo='.$periodo->id_periodo_ingles.' and id_estado=2 ');
                if($validacion_carga->validacion == 0)
                {
                    $cal['id_periodo'] = $periodo->id_periodo_ingles;
                    $cal['estado_periodo']=0;
                    $cal['calificacion']=0;
                    $cal['descripcion']="";
                }else{
                    $carga=DB::selectOne('SELECT * FROM `in_carga_academica_ingles` 
                   WHERE `id_alumno` = '.$alumno->id_alumno.' AND `id_periodo_ingles` = '.$periodo->id_periodo_ingles.' ');
                    $nivel=DB::selectOne('SELECT * FROM `in_niveles_ingles` WHERE `id_niveles_ingles` = '.$carga->id_nivel.' ');
                    $nivel=$nivel->descripcion;
                    $calificacion=DB::selectOne('SELECT SUM(calificacion) calificacion 
                  from in_evaluar_calificacion where id_carga_ingles='.$carga->id_carga_ingles.'');
                    if($calificacion->calificacion == 0){
                        $cali=0;
                    }else{
                        $cali=($calificacion->calificacion)/4;
                        $cali=round($cali,0);
                    }
                    $cal['id_periodo'] = $periodo->id_periodo_ingles;
                    $cal['estado_periodo']=1;
                    $cal['calificacion']=$cali;
                    $cal['descripcion']="Nivel: ".$nivel." Grupo: ".$carga->id_grupo;

                }
                array_push($array_periodo, $cal);



            }
            $dat_alumnos['calificaciones']=$array_periodo;

            array_push($array_alumnos, $dat_alumnos);
            $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.' ORDER BY `id_carrera` ASC ');

        }
        return view('ingles.departamento.mostrar_calificaciones',compact('array_alumnos','periodos','carrera','id_carrera'));
    }
    public function historial_calificaciones_excel($id_carrera){
        Session::put('historial_id_carrera',$id_carrera);

        $carr=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        if($carr->id_carrera == 2){
            $carrer="I S C";
        }
        else {
            $carrer = $carr->nombre;
        }

        Excel::create($carrer,function ($excel)
        {

            $id_carrera=Session::get('historial_id_carrera');

            $carr=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
            if($carr->id_carrera == 2){
                $carrer="I S C";
            }
            else {
                $carrer = $carr->nombre;
            }

            $excel->sheet(''.$carrer, function($sheet) use($id_carrera)
            {
                $alumnos=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta, 
       gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno 
from gnral_alumnos,in_validar_carga where gnral_alumnos.id_alumno = in_validar_carga.id_alumno 
AND gnral_alumnos.id_carrera = '.$id_carrera.'
GROUP BY gnral_alumnos.id_alumno ORDER BY `gnral_alumnos`.`apaterno`,
                                          `gnral_alumnos`.`amaterno`, `gnral_alumnos`.`nombre` DESC 
');
                $periodo_actual=DB::selectOne('SELECT in_periodos.* from in_periodos where estado_historial=1 ');

                $array_alumnos = array();
                $numero=0;
                foreach ($alumnos as $alumno) {
                    $numero++;
                    $dat_alumnos['numero'] = $numero;
                    $dat_alumnos['id_alumno'] = $alumno->id_alumno;
                    $dat_alumnos['cuenta'] = $alumno->cuenta;
                    $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                    $periodos = DB::select('SELECT in_periodos.* from in_periodos where id_periodo_ingles <' . $periodo_actual->id_periodo_ingles . ' and id_periodo_ingles >1');

                    $array_periodo = array();
                    foreach ($periodos as $periodo) {
                        $validacion_carga = DB::selectOne('SELECT count(in_validar_carga.id_validar_carga) validacion
              from in_validar_carga where id_alumno=' . $alumno->id_alumno . ' 
              and id_periodo=' . $periodo->id_periodo_ingles . ' and id_estado=2 ');
                        if ($validacion_carga->validacion == 0) {
                            $cal['id_periodo'] = $periodo->id_periodo_ingles;
                            $cal['estado_periodo'] = 0;
                            $cal['calificacion'] = 0;
                            $cal['descripcion'] = "";
                        } else {
                            $carga = DB::selectOne('SELECT * FROM `in_carga_academica_ingles` 
                   WHERE `id_alumno` = ' . $alumno->id_alumno . ' AND `id_periodo_ingles` = ' . $periodo->id_periodo_ingles . ' ');
                            $nivel = DB::selectOne('SELECT * FROM `in_niveles_ingles` WHERE `id_niveles_ingles` = ' . $carga->id_nivel . ' ');
                            $nivel = $nivel->descripcion;
                            $calificacion = DB::selectOne('SELECT SUM(calificacion) calificacion 
                  from in_evaluar_calificacion where id_carga_ingles=' . $carga->id_carga_ingles . '');
                            if ($calificacion->calificacion == 0) {
                                $cali = 0;
                            } else {
                                $cali = ($calificacion->calificacion) / 4;
                                $cali = round($cali, 0);
                            }
                            $cal['id_periodo'] = $periodo->id_periodo_ingles;
                            $cal['estado_periodo'] = 1;
                            $cal['calificacion'] = $cali;
                            $cal['descripcion'] = "Nivel: " . $nivel . " Grupo: " . $carga->id_grupo;

                        }
                        array_push($array_periodo, $cal);


                    }
                    $dat_alumnos['calificaciones'] = $array_periodo;

                    array_push($array_alumnos, $dat_alumnos);
                }
                $sheet->loadView('ingles.departamento.concentrado_historial_cal',compact('array_alumnos','periodos'))
                ;
                $sheet->setOrientation('landscape');


            });



            //dd($array_carreras);

        })->export('xlsx');

    }
}
