<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Session;

class Cal_concentrado_calificacionesController extends Controller
{
    public function index()
    {

        $carreras = DB::table('gnral_carreras')
            ->where('id_carrera', '!=', 9)
            ->where('id_carrera', '!=', 11)
            ->where('id_carrera', '!=', 15)
            ->get();
        return view('servicios_escolares.concentrado_calificaciones.concentrado_carreras', compact('carreras'));
    }

    public function concentrado_calificaciones($id_carrera)
    {
        $carrera = $id_carrera;
        $periodo = Session::get('periodo_actual');
        $grupos = DB::select('select DISTINCT m.id_semestre, hp.grupo ,c.id_carrera FROM 
                gnral_periodos pe, gnral_carreras c, gnral_periodo_carreras pc, gnral_horarios h, gnral_materias m, 
                gnral_personales p, gnral_materias_perfiles mf, gnral_horas_profesores hp,gnral_grupos g WHERE 
                mf.id_personal = p.id_personal AND 
                mf.id_materia = m.id_materia AND 
                mf.id_materia_perfil = hp.id_materia_perfil AND 
                hp.id_horario_profesor = h.id_horario_profesor AND 
                h.id_periodo_carrera = pc.id_periodo_carrera AND 
                pc.id_periodo = pe.id_periodo AND 
                pe.id_periodo =' . $periodo . ' AND 
                pc.id_carrera = c.id_carrera AND 
                c.id_carrera =' . $carrera . '
                ORDER BY m.id_semestre ASC ');
        $carr=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        $nombre_carrera=$carr->nombre;
        return view('servicios_escolares.concentrado_calificaciones.concentrado_semestres', compact('grupos','nombre_carrera'));

    }

    public function concentrado_materias($id_carrera, $id_semestre, $grupo)
    {
        $id_periodo = Session::get('periodo_actual');
        $carr=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        $nombre_carrera=$carr->nombre;

        $alumnos = DB::select('SELECT  gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_validacion_de_cargas.estado_validacion FROM eva_carga_academica,gnral_materias, gnral_alumnos,
eva_validacion_de_cargas,gnral_reticulas WHERE  gnral_materias.id_semestre=' . $id_semestre . ' 
and gnral_reticulas.id_carrera=' . $id_carrera . ' and gnral_materias.id_reticula=gnral_reticulas.id_reticula and 
eva_carga_academica.id_materia = gnral_materias.id_materia AND eva_carga_academica.id_status_materia = 1 
AND eva_carga_academica.id_periodo = ' . $id_periodo . ' AND eva_carga_academica.grupo = ' . $grupo . ' 
and gnral_alumnos.id_alumno=eva_carga_academica.id_alumno and
  eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and 
eva_validacion_de_cargas.estado_validacion in (2,9,10) GROUP by gnral_alumnos.id_alumno  
ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre  ASC');
       // dd($alumnos);

        $materias = DB::select('select DISTINCT  gnral_periodo_carreras.id_carrera,gnral_horas_profesores.grupo,gnral_materias.creditos,gnral_materias.id_semestre,gnral_materias.unidades,gnral_materias.id_materia, gnral_materias.clave,gnral_materias.nombre materia,abreviaciones.titulo,gnral_personales.nombre,gnral_horarios.aprobado FROM 
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales, 
            hrs_rhps,gnral_periodo_carreras,abreviaciones_prof,abreviaciones WHERE 
            gnral_periodo_carreras.id_carrera=' . $id_carrera . ' AND 
            gnral_periodo_carreras.id_periodo=' . $id_periodo . ' AND 
            gnral_materias.id_semestre=' . $id_semestre . ' AND 
            gnral_horas_profesores.grupo=' . $grupo . ' AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND  
            gnral_horarios.id_personal=gnral_personales.id_personal AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND 
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor and abreviaciones_prof.id_personal=gnral_personales.id_personal 
            and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion  order by gnral_materias.nombre ASC ');

        $array_mat=array();
        $array_mat_sin=array();
        $mat_calificada=0;
        $mat_sin_cal=0;
        foreach ($materias as $materia) {
            $calificada=DB::selectOne('SELECT count(id_calificar_sumativas) contar_sumativas FROM `gnral_calificar_sumativas` 
           WHERE `id_materia` = '.$materia->id_materia.' AND `id_grupo` = '.$materia->grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$id_periodo.'');
            $calificada=$calificada->contar_sumativas;



            if($calificada == 0) {
                $mat_sin_cal++;
                $dat_mater['id_materia'] = $materia->id_materia;
                $dat_mater['clave'] = $materia->clave;
                $dat_mater['nombre'] =$materia->titulo.' '.$materia->nombre;
                $dat_mater['nombre_materia'] = $materia->materia;

                array_push($array_mat_sin,$dat_mater);
            }
            else{
                $dat_materiass['id_materia'] = $materia->id_materia;
                $dat_materiass['clave'] = $materia->clave;
                $dat_materiass['nombre'] =$materia->titulo.' '.$materia->nombre;
                $dat_materiass['nombre_materia'] = $materia->materia;
                $dat_materiass['creditos'] = $materia->creditos;
                $dat_materiass['te'] = 'TE';
                $dat_materiass['unidades'] = $materia->unidades;
                $mat_calificada++;
                $dat_materiass['status'] =1;
                array_push($array_mat,$dat_materiass);
            }

        }

        if($mat_calificada ==0){
            return view('servicios_escolares.concentrado_calificaciones.concentrado_materias', compact('mat_calificada','nombre_carrera','id_semestre','grupo'));

        }
      else{

          $numero=0;
          $materias_calificaciones=array();
          $estado_materias=0;
          $numero_alumno=0;
          $promedio_general=0;
          $numero_promedio_aprobado=0;
          $numero_promedio_reprobado=0;
          $porcentaje_final_aprobado=0;
          $porcentaje_final_reprobado=0;
          foreach ($alumnos as $alumno) {
              $numero++;
              $dat_l['numero'] = $numero;
              $dat_l['id_alumno'] = $alumno->id_alumno;
              $dat_l['cuenta'] = $alumno->cuenta;
              $dat_l['estado_validacion'] = $alumno->estado_validacion;
              $dat_l['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
              $cal_al=array();
              $suma_promedio_final=0;
              $suma_materia=0;
              $estado_materia=0;
              foreach ($array_mat as $materiass) {

                $inscrito = DB::selectOne('SELECT * FROM `eva_carga_academica` 
                  WHERE `id_materia` = '.$materiass['id_materia'].' AND `id_status_materia` = 1 
                  AND `id_periodo` = '.$id_periodo. ' AND `grupo` = ' . $grupo . ' and id_alumno='.$alumno->id_alumno.'');
//dd($inscrito);
                      if ($inscrito == null) {
                          $datos_alumnos['id_carga_academica'] = 0;
                          $datos_alumnos['id_materia'] = $materiass['id_materia'];
                          $datos_alumnos['nombre_materia'] = '';
                          $datos_alumnos['estado'] = 1;
                          $datos_alumnos['promedio'] = '';
                          $datos_alumnos['te'] = '';
                      } else {
                          $suma_materia++;
                          $datos_alumnos['id_carga_academica'] = $inscrito->id_carga_academica;
                          $datos_alumnos['id_materia'] = $inscrito->id_materia;
                          $datos_alumnos['nombre_materia'] = $materiass['nombre_materia'];
                          $datos_alumnos['estado'] = 2;


                          $materia_promedio = DB::selectOne('SELECT SUM(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` =' . $inscrito->id_carga_academica . ' and calificacion >=70');
                          $materia_promedio = $materia_promedio->suma;

                          $contar_unidades_pasadas = DB::selectOne('SELECT count(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` = ' . $inscrito->id_carga_academica . ' and calificacion >=70');
                          $contar_unidades_pasadas = $contar_unidades_pasadas->suma;

                          $contar_unidades_sumativas = DB::selectOne('SELECT count(calificacion) num FROM `cal_evaluaciones` WHERE `id_carga_academica` = ' . $inscrito->id_carga_academica . ' and esc=1');
                          $contar_unidades_sumativas = $contar_unidades_sumativas->num;
                          if ($contar_unidades_pasadas == $materiass['unidades']) {
                              if ($materia_promedio == 0) {
                                  $promedio = 0;
                              } else {
                                  $promedio = round($materia_promedio / $materiass['unidades']);
                              }
                              if ($inscrito->id_tipo_curso == 1 and $contar_unidades_sumativas == 0) {
                                  $te = 'O';
                                  $valor=10;
                                  $estado_materia+=$valor;
                              }
                              elseif($inscrito->id_tipo_curso == 1 and $contar_unidades_sumativas > 0) {
                              $te = 'ESC';
                                  $valor=10;
                                  $estado_materia+=$valor;
                              }

                              elseif ($inscrito->id_tipo_curso == 2 and $contar_unidades_sumativas == 0) {
                                  $te = 'O2';
                                  $valor=100;
                                  $estado_materia+=$valor;
                              }
                              elseif ($inscrito->id_tipo_curso == 2 and $contar_unidades_sumativas > 0) {
                                  $te = 'ESC2';
                                  $valor=100;
                                  $estado_materia+=$valor;
                              }
                              if ($inscrito->id_tipo_curso == 3 and $contar_unidades_sumativas == 0) {
                                  $te = 'CE';
                                  $valor=1000;
                                  $estado_materia+=$valor;
                              }
                              if ($inscrito->id_tipo_curso == 3 and $contar_unidades_sumativas > 0) {
                                  $te = 'EG';
                                  $valor=1000;
                                  $estado_materia+=$valor;
                              }
                              if ($inscrito->id_tipo_curso == 4) {
                                  $te = 'EG';
                                  $valor=10000;
                                  $estado_materia+=$valor;
                              }
                          } else {

                              if ($materia_promedio == 0) {
                                  $promedio = 0;
                              } else {
                                  $promedio = 0;
                              }
                              if ($inscrito->id_tipo_curso == 1) {
                                  $te = 'ESC';
                                  $valor=10;
                                  $estado_materia+=$valor;
                              }
                              if ($inscrito->id_tipo_curso == 2) {
                                  $te = 'ESC2';
                                  $valor=100;
                                  $estado_materia+=$valor;
                              }
                              if ($inscrito->id_tipo_curso == 3) {
                                  $valor=1000;
                                  $estado_materia+=$valor;
                                  $te = 'EG';
                              }
                              if ($inscrito->id_tipo_curso == 4) {
                                  $valor=10000;
                                  $estado_materia+=$valor;
                                  $te = 'EG';
                              }


                          }

                          $datos_alumnos['promedio'] = $promedio;
                          $datos_alumnos['te'] = $te;
                          $suma_promedio_final += $promedio;

                      }

                      array_push($cal_al, $datos_alumnos);
                  }
              $estado_materias=$estado_materia;
              if($estado_materias <100){
                  $estado_al=1;

              }
              elseif ($estado_materias <1000)
              {
                  $estado_al=2;
              }
              elseif ($estado_materias <10000)
              {
                  $estado_al=3;
              }
              elseif ($estado_materias <100000)
              {
                  $estado_al=4;
              }
              if($suma_promedio_final ==0 )
              {
                  $promedio_f=0;
              }
                  else{
                     $promedio_f=$suma_promedio_final/$suma_materia;
                  }
                  if($alumno->estado_validacion != 10)
                  {
                      $numero_alumno++;
                      $promedio_general+=number_format($promedio_f, 2, '.', ' ');
                     $pro_al=number_format($promedio_f, 2, '.', ' ');
                      if($pro_al >= 70){
                          $numero_promedio_aprobado++;
                      }
                      else{
                          $numero_promedio_reprobado++;
                      }

                  }
              $dat_l['promedio_f']=number_format($promedio_f, 2, '.', ' ');
              $dat_l['l']=$cal_al;
              $dat_l['estado_alumno']=$estado_al;
              array_push($materias_calificaciones, $dat_l);
          }
          if($promedio_general == 0 || $numero_alumno == 0)
          {
              $promedio_general=0;

          }
          else{
              $promedio_general=$promedio_general/$numero_alumno;

          }

//dd($materias_calificaciones);
          $com=array();
          foreach ($array_mat as $mater) {
              $esta=false;

              $contar_alumnos=0;
              $contar_reprobados=0;
              $contar_aprobados=0;
              $suma_promedioss=0;
              $bajas=0;

              foreach ($materias_calificaciones as $cal) {

                      foreach ($cal['l'] as $mate) {
                          if ($mater['id_materia'] == $mate['id_materia']) {
                              if ($mate['estado'] == 2 and $cal['estado_validacion'] != 10) {
                                  $contar_alumnos++;
                                  if ($mate['promedio'] < 70) {
                                      $contar_reprobados++;
                                  } else {
                                      $contar_aprobados++;
                                  }
                                  $suma_promedioss += $mate['promedio'];
                                  if ($mate['te'] == 'EG') {
                                      $bajas++;
                                  }
                              }
                              elseif($mate['estado'] == 2 and $cal['estado_validacion'] == 10){
                                  $bajas++;
                              }
                              $esta = true;
                              break;
                          } // esta es la que se me olvidaba
                      }


              }
              $compra['id_materia']=$mater['id_materia'];
              $compra['nombre_materia'] = $mater['nombre_materia'];
              $compra['creditos'] = $mater['creditos'];
              $compra['aprobados']=$contar_aprobados;
              $compra['reprobados']=$contar_reprobados;
              $compra['suma_promedios']=$suma_promedioss;
              $compra['bajas']=$bajas;
              $compra['total']=$contar_alumnos;
              array_push($com, $compra);
          }

          //dd($com);
         // dd($materias_calificaciones);
        //  dd($com);
          return view('servicios_escolares.concentrado_calificaciones.concentrado_materias',
              compact('nombre_carrera','id_semestre','grupo','id_carrera',
                  'numero_promedio_reprobado','numero_promedio_aprobado','numero_alumno','promedio_general',
                  'mat_sin_cal','array_mat_sin','com','array_mat','mat_calificada','materias_calificaciones','bajas'));
       //   return view('servicios_escolares.concentrado_calificaciones.concentrado_materias', compact('materias'));

        }



    }
    public function modificaciones_cargas_cademicas(){
        $id_periodo = Session::get('periodo_actual');
       $historial=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre alumno, 
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_personales.nombre ,
       cal_usuario_estado.* from gnral_alumnos,gnral_personales,cal_usuario_estado,
    eva_validacion_de_cargas where gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno 
                and eva_validacion_de_cargas.id=cal_usuario_estado.id_validacion_carga and
        gnral_personales.tipo_usuario=cal_usuario_estado.id_usuario and 
        eva_validacion_de_cargas.id_periodo='.$id_periodo.' ORDER BY `cal_usuario_estado`.`fecha` DESC ');
       return view('servicios_escolares.historial_modificaciones_carga',compact('historial'));
    }


}
