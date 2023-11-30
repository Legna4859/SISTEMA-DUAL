<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\CargaAcademica;
use App\Alumnos;
use App\Periodos;
use App\ValidacionCarga;
use PhpParser\Node\Stmt\DeclareDeclare;
use Session;

class Dual_Checar_Carga_Academica_Alumno extends Controller
{

    public function index($id_alumno)
    {
        //dd($id_alumno);
        //$id_alumno=0;
        $usuario = Session::get('usuario_alumno');
        $periodo=Session::get('periodo_actual');
        $usuario = Session::get('usuario');
        //dd($usuario);
        $id_alu=DB::selectOne('SELECT gnral_alumnos.id_alumno FROM gnral_alumnos WHERE gnral_alumnos.cuenta='.$usuario.'');
        //dd($id_alu);
        //
        $id_alu=($id_alu->id_alumno);
        //dd($id_alu);
        $usuario=1;
        $des=DB::selectOne('SELECT eva_validacion_de_cargas.descripcion FROM eva_validacion_de_cargas WHERE eva_validacion_de_cargas.id_alumno='.$id_alu.'
        AND eva_validacion_de_cargas.id_periodo='.$periodo.'');
        $datos_carga=array();
        if($des==null)
        {
            $color=1;
            $mensage_carga='Tu carga academica  no ha sido dada de alta';
            return view('duales.dual_mensages',compact('mensage_carga','color'));
        }
        else
        {
            $re=($des->descripcion);
            $validaciones=DB::select('SELECT eva_validacion_de_cargas.estado_validacion,eva_validacion_de_cargas.descripcion 
            FROM eva_validacion_de_cargas  WHERE eva_validacion_de_cargas.id_alumno='.$id_alu.'
            AND eva_validacion_de_cargas.id_periodo='.$periodo.'');
            // $si=isset($validaciones->descripcion)?$si->descripcion:0;
            $consulta1=DB::select('SELECT eva_carga_academica.id_carga_academica,gnral_materias.clave,gnral_materias.nombre,gnral_materias.id_materia,
                            gnral_materias.id_semestre,gnral_materias.creditos,eva_status_materia.nombre_status,
                            eva_tipo_curso.nombre_curso,eva_carga_academica.grupo
                            FROM gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos
                            WHERE eva_carga_academica.id_materia=gnral_materias.id_materia
                            AND eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                            AND eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                            AND eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                            AND eva_carga_academica.grupo=gnral_grupos.id_grupo
                            AND eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                            AND eva_status_materia.id_status_materia=1
                            AND gnral_periodos.id_periodo='.$periodo.'
                            AND eva_carga_academica.id_alumno='.$id_alu.'');
            foreach ($consulta1 as $cons) {
                $dat['id_carga_academica'] = $cons->id_carga_academica;
                $dat['clave'] = $cons->clave;
                $dat['nombre'] = $cons->nombre;
                $dat['id_materia'] = $cons->id_materia;
                $dat['id_semestre'] = $cons->id_semestre;
                $dat['creditos'] = $cons->creditos;
                $dat['nombre_status'] = $cons->nombre_status;
                $dat['nombre_curso'] = $cons->nombre_curso;
                $dat['grupo'] = $cons->grupo;
                $profesor=array();
                $profesores = DB::select('SELECT DISTINCT gnral_materias.id_materia, gnral_materias.nombre, gnral_horarios.id_horario_profesor,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales, gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof, abreviaciones 
            WHERE gnral_periodo_carreras.id_periodo='.$periodo.' 
            AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
            AND gnral_horarios.id_personal=gnral_personales.id_personal 
            AND gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
            AND gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
            AND gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
            AND gnral_materias.id_reticula = gnral_reticulas.id_reticula 
            AND gnral_horas_profesores.grupo = '.$cons->grupo.' 
            AND gnral_personales.id_personal = abreviaciones_prof.id_personal
            AND abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion 
            AND gnral_materias.id_materia = '.$cons->id_materia.'');
                foreach ($profesores as $prof){
                    $pro['nombre_profesor'] = $prof->docente;
                    $pro['titulo'] = $prof->titulo;
                    array_push($profesor,$pro);
                }
                $dat['profesores'] = $profesor;
                array_push($datos_carga, $dat);
            }
            //dd($datos_carga);
            $suma=0;
            $suma_materias=0;
            $mater=0;
            foreach ($consulta1 as $cons){
                $mater ++;
                //dd($mater);
                if($cons->id_materia != 2258) {
                    $suma = $suma + $cons->creditos;
                    $suma_materias++;
                }
            }
            $especial=DB::selectOne('SELECT count(eva_tipo_curso.id_tipo_curso) curso 
            FROM gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos
            WHERE eva_carga_academica.id_materia=gnral_materias.id_materia
            AND eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
            AND eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
            AND eva_carga_academica.id_periodo=gnral_periodos.id_periodo
            AND eva_carga_academica.grupo=gnral_grupos.id_grupo
            AND eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
            AND eva_tipo_curso.id_tipo_curso=3
            AND eva_status_materia.id_status_materia=1
            AND gnral_periodos.id_periodo='.$periodo.'
            AND eva_carga_academica.id_alumno='.$id_alu.'');
            //$especial=$especial->curso;
            $suma = $suma->suma;
                if ($suma > 38) {
                    $creditoss = 1;
                } else if ($suma < 0) {
                    $creditoss = 2;
                } else {
                    $creditoss = 3;
                }
                $cuenta_y_nom = " ";
             //dd($suma);
            if($mater == 0)
            {
                $color=1;
                $mensage_carga='Tu carga academica  no ha sido dada de alta';
                return view('duales.dual_mensages',compact('mensage_carga','color'));
            }
            return view('duales.checar_carga_academica',compact('validaciones','usuario','re', 'suma','cuenta_y_nom','creditoss','id_alu','datos_carga'));
        }

    }
    /////////REVISION CONTROL ESCOLAR////////

    public function revision_carga($id_alumno)
    {
        $creditoss = 0;
        $periodo=Session::get('periodo_actual');
        $usuario=2;
        $validaciones=DB::select('SELECT eva_validacion_de_cargas.estado_validacion, eva_validacion_de_cargas.id_alumno, eva_validacion_de_cargas.id 
                                    FROM eva_validacion_de_cargas 
                                    WHERE eva_validacion_de_cargas.id_alumno='.$id_alumno.' 
                                    AND eva_validacion_de_cargas.id_periodo='.$periodo.'');
        $alumno=($validaciones[0]->id_alumno);
        $id = $validaciones[0]->id;
        //dd($alumno);
        $ls=$validaciones[0]->estado_validacion;
       
        $datos_carga=array();
        $consulta1=DB::select('SELECT eva_carga_academica.id_carga_academica,gnral_materias.clave,gnral_materias.nombre,gnral_materias.id_materia,
                            gnral_materias.id_semestre,gnral_materias.creditos,eva_status_materia.nombre_status,
                            eva_tipo_curso.nombre_curso,eva_carga_academica.grupo
                            FROM gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos
                            WHERE eva_carga_academica.id_materia=gnral_materias.id_materia
                            AND eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                            AND eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                            AND eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                            AND eva_carga_academica.grupo=gnral_grupos.id_grupo
                            AND eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                            AND eva_status_materia.id_status_materia=1
                            AND gnral_periodos.id_periodo='.$periodo.'
                            AND eva_carga_academica.id_alumno='.$alumno.'');

        foreach ($consulta1 as $cons) {
            $dat['id_carga_academica'] = $cons->id_carga_academica;
            $dat['clave'] = $cons->clave;
            $dat['nombre'] = $cons->nombre;
            $dat['id_materia'] = $cons->id_materia;
            $dat['id_semestre'] = $cons->id_semestre;
            $dat['creditos'] = $cons->creditos;
            $dat['nombre_status'] = $cons->nombre_status;
            $dat['nombre_curso'] = $cons->nombre_curso;
            $dat['grupo'] = $cons->grupo;
            //dd($dat['creditos']);
            $profesor=array();
            //dd($profesor);
            $profesores = DB::select('SELECT DISTINCT gnral_materias.id_materia, gnral_materias.nombre, gnral_horarios.id_horario_profesor,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof, abreviaciones 
            WHERE gnral_periodo_carreras.id_periodo='.$periodo.' 
            AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
            AND gnral_horarios.id_personal=gnral_personales.id_personal 
            AND gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
            AND gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
            AND gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
            AND gnral_materias.id_reticula = gnral_reticulas.id_reticula 
            AND gnral_horas_profesores.grupo = '.$cons->grupo.' 
            AND gnral_personales.id_personal = abreviaciones_prof.id_personal
            AND abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion 
            AND gnral_materias.id_materia = '.$cons->id_materia.'');
            //dd($profesores);
            foreach ($profesores as $prof){
                $pro['nombre_profesor'] = $prof->docente;
                $pro['titulo'] = $prof->titulo;
                array_push($profesor,$pro);
            }
            $dat['profesores'] = $profesor;
            array_push($datos_carga, $dat);
        }
        $suma=0;
        foreach ($consulta1 as $cons){
            if($cons->id_materia != 2258) {
                $suma = $suma + $cons->creditos;
                //dd($suma);
            }
        }
        $cuenta_y_nom=DB::selectOne('SELECT gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno FROM gnral_alumnos WHERE gnral_alumnos.id_alumno= '.$alumno.'');
        $id_alumno=$id_alumno;
        $cuenta_y_nom="Número de cuenta:  ".$cuenta_y_nom->cuenta."     Nombre del alumno: ".$cuenta_y_nom->apaterno." ".$cuenta_y_nom->amaterno." ".$cuenta_y_nom->nombre;
        $cuenta_y_nom=mb_strtoupper($cuenta_y_nom);

        $adeudo_departamento=DB::selectOne('SELECT COUNT(id_adeudo_departamento)adeudo  
                        FROM adeudo_departamento WHERE id_alumno = '.$alumno.' ');
        $adeudo_departamento=$adeudo_departamento->adeudo;
        if( $adeudo_departamento ==0){
            $adeudo=0;
            $departamento_carrera="";
        }
        else{
            $adeudo=1;
            $departamento_carrera=array();
            $adeudo_dep=DB::select('SELECT gnral_unidad_administrativa.nom_departamento,
                                adeudo_departamento.comentario 
                                FROM adeudo_departamento, gnral_unidad_administrativa 
                                WHERE adeudo_departamento.id_alumno = '.$alumno.' 
                                AND gnral_unidad_administrativa.id_unidad_admin=adeudo_departamento.id_departamento ');

            foreach($adeudo_dep as $ade)
            {
                $nombrea['nombre']= $ade->nom_departamento;
                $nombrea['comentario']= $ade->comentario;
                array_push($departamento_carrera, $nombrea);
            }
            $adeudo_informacion=DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                FROM adeudo_departamento WHERE id_alumno='.$alumno.' AND id_departamento=50');
            if($adeudo_informacion->contar >0)
            {
                $informacion=DB::select('SELECT  * FROM adeudo_departamento WHERE id_alumno='.$alumno.' AND id_departamento=50');
                foreach ($informacion as $info) {
                    $nombre_info['nombre'] = "CENTRO DE INFORMACIÓN";
                    $nombre_info['comentario']=$info->comentario;
                    array_push($departamento_carrera, $nombre_info);
                }
            }
            $adeudo_bolsa=DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                FROM adeudo_departamento WHERE id_alumno='.$alumno.' AND id_departamento=100');
            if($adeudo_bolsa->contar >0)
            {
                $bolsa=DB::select('SELECT  * FROM adeudo_departamento WHERE id_alumno='.$alumno.' AND id_departamento=100');
                foreach ($bolsa as $bolsa) {
                    $nombre_bolsa['nombre'] = "BOLSA DE TRABAJO Y SEGUIMIENTO DE EGRESADOS";
                    $nombre_bolsa['comentario']=$bolsa->comentario;
                    array_push($departamento_carrera, $nombre_bolsa);
                }
            }
        }
        $estado_sem_act=DB::selectOne('SELECT count(id_semestres_al)contar FROM eva_semestre_alumno WHERE id_alumno='.$alumno.'');
        $estado_sem_act=$estado_sem_act->contar;
        $periodos=DB::select('SELECT *FROM gnral_periodos WHERE id_periodo >= 13  ORDER BY id_periodo ASC');
        $semestres=DB::select('SELECT * FROM `gnral_semestres` ORDER BY `gnral_semestres`.`id_semestre` ASC ');
        $datos_actu=DB::selectOne('SELECT gnral_semestres.descripcion semestre,gnral_periodos.periodo,
        eva_semestre_alumno.* FROM gnral_semestres, gnral_periodos,eva_semestre_alumno 
        WHERE eva_semestre_alumno.id_alumno = '.$alumno.' 
        AND eva_semestre_alumno.id_periodo = gnral_periodos.id_periodo 
        AND eva_semestre_alumno.id_semestre = gnral_semestres.id_semestre');
        //dd($datos_actu);
//dd($usuario);
        return view('duales.checar_carga_academica',
            compact('ls','datos_carga','validaciones','usuario','id_alumno','suma','cuenta_y_nom',
                'id_alumno','adeudo','departamento_carrera','estado_sem_act','periodos','semestres','alumno','datos_actu','creditoss','id'));
    }
    public function insertarvarios($arreglo)
    {
        //dd("entro");
        $usuario = Session::get('usuario');
        $periodo=Session::get('periodo_actual');
        $datos=(explode(',',$arreglo));
        $checks = array();
        $radios = array();
        $ciclos=count($datos)/2;
        $grupo=DB::selectOne('SELECT gnral_alumnos.grupo FROM gnral_alumnos WHERE gnral_alumnos.cuenta='.$usuario.'');
        $grupo=$grupo->grupo;
        $status=1;///////el estado es 2 porque el proceso de validacion se hara en automatico
        $id_alu=DB::selectOne('SELECT gnral_alumnos.id_alumno FROM gnral_alumnos WHERE gnral_alumnos.cuenta='.$usuario.'');
        $id_alu=($id_alu->id_alumno);
        for ($i=0; $i <count($datos)/2 ; $i++)
        {
            $checks [$i] =$datos[$i];
            $radios [$i]=$datos[$i+count($datos)/2];
        }
        //dd($checks);
        for ($i=0; $i <$ciclos ; $i++) {
         $verifica=DB::selectOne('SELECT * FROM eva_carga_academica WHERE id_materia='.$checks[$i].' AND id_periodo ='.$periodo.' AND eva_carga_academica.id_alumno='.$id_alu.'');
            if($verifica==null) {
                $incercion=array(
                    'id_alumno'=>$id_alu,
                    'id_materia'=>$checks[$i],
                    'id_status_materia'=>$status,
                    'id_tipo_curso'=>$radios[$i],
                    'id_periodo'=>$periodo,
                    'grupo'=>$grupo,
                );
                $act=CargaAcademica::create($incercion);
            }
            //dd($verifica);
        }

        $checar=DB::selectOne('SELECT * FROM eva_validacion_de_cargas WHERE id_alumno='.$id_alu.' AND eva_validacion_de_cargas.id_periodo='.$periodo.'');
        if($checar==null){
            $pregunta=0;
            $validacion=array(
                'id_alumno'=>$id_alu,
                'id_periodo'=>$periodo,
                'estado_validacion'=>0,
                'no_pregunta'=>$pregunta,
            );
            $asdfghj=ValidacionCarga::create($validacion);
            return redirect()->route('checar.index');
        }
        else{
            $upda=array(
                'id_alumno'=>$checar->id_alumno,
                'id_periodo'=>$checar->id_periodo,
                'estado_validacion'=>0,
                'descripcion'=>$checar->descripcion,
                'no_pregunta'=>$checar->no_pregunta,
            );
            ValidacionCarga::find($checar->id)->update($upda);
            return redirect()->route('checar.index');
        }
    }
    public function edit($id_carga_academica)
    {
        $id_alumno=0;
        $usuario=Session::get('usuario');
        $periodo=Session::get('periodo_actual');
        ////////////recargar los datos de la vista
        $id_alu=DB::selectOne('SELECT gnral_alumnos.id_alumno FROM gnral_alumnos WHERE gnral_alumnos.cuenta='.$usuario.' ');
        //$id_alu=($id_alu->id_alumno);
        //dd($id_alu);
        $usuarios=2;
        $des=DB::selectOne('SELECT eva_validacion_de_cargas.descripcion FROM eva_validacion_de_cargas WHERE eva_validacion_de_cargas.id_alumno='.$id_alumno.' 
        AND eva_validacion_de_cargas.id_periodo='.$periodo.' ');
        $datos_carga=array();
        if($des==null)
        {
            $color=1;
            $mensage_carga='Tu carga academica  no ha sido dada de alta';
            return view('duales.dual_mensages',compact('mensage_carga','color'));
        }
        else
        {
            $re=($des->descripcion);
            $validaciones=DB::select('SELECT eva_validacion_de_cargas.estado_validacion,eva_validacion_de_cargas.descripcion 
            FROM eva_validacion_de_cargas 
            WHERE eva_validacion_de_cargas.id_alumno='.$id_alumno.'
            AND eva_validacion_de_cargas.id_periodo='.$periodo.'');
            // $si=isset($validaciones->descripcion)?$si->descripcion:0;
            $consulta1=DB::select('SELECT eva_carga_academica.id_carga_academica,gnral_materias.clave,gnral_materias.nombre,gnral_materias.id_materia,
            gnral_materias.id_semestre,gnral_materias.creditos,eva_status_materia.nombre_status,
            eva_tipo_curso.nombre_curso,eva_carga_academica.grupo
            FROM gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos
            WHERE eva_carga_academica.id_materia=gnral_materias.id_materia
            AND eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
            AND eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
            AND eva_carga_academica.id_periodo=gnral_periodos.id_periodo
            AND eva_carga_academica.grupo=gnral_grupos.id_grupo
            AND eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
            AND eva_status_materia.id_status_materia=1
            AND gnral_periodos.id_periodo='.$periodo.'
            AND eva_carga_academica.id_alumno='.$id_alumno.'');
            //dd($consulta1);
            foreach ($consulta1 as $cons) {
                $dat['id_carga_academica'] = $cons->id_carga_academica;
                $dat['clave'] = $cons->clave;
                $dat['nombre'] = $cons->nombre;
                $dat['id_materia'] = $cons->id_materia;
                $dat['id_semestre'] = $cons->id_semestre;
                $dat['creditos'] = $cons->creditos;
                $dat['nombre_status'] = $cons->nombre_status;
                $dat['nombre_curso'] = $cons->nombre_curso;
                $dat['grupo'] = $cons->grupo;
                $profesor=array();
                $profesores = DB::select('SELECT DISTINCT gnral_materias.id_materia, gnral_materias.nombre, gnral_horarios.id_horario_profesor, 
                gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
                FROM gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
                gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof, abreviaciones 
                WHERE gnral_periodo_carreras.id_periodo='.$periodo.' 
                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                AND gnral_horarios.id_personal=gnral_personales.id_personal 
                AND gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                AND gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                AND gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                AND gnral_materias.id_reticula = gnral_reticulas.id_reticula 
                AND gnral_horas_profesores.grupo = '.$cons->grupo.' 
                AND gnral_personales.id_personal = abreviaciones_prof.id_personal
                AND abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion 
                AND gnral_materias.id_materia = '.$cons->id_materia.'');
                foreach ($profesores as $prof){
                    $pro['nombre_profesor'] = $prof->docente;
                    $pro['titulo'] = $prof->titulo;
                    array_push($profesor,$pro);
                }
                $dat['profesores'] = $profesor;
                array_push($datos_carga, $dat);
            }
            $suma=0;
            foreach ($consulta1 as $cons){
                if($cons->id_materia != 2258) {
                    $suma = $suma + $cons->creditos;
                }
            }
            $consultaedit=DB::selectOne('SELECT *FROM eva_carga_academica WHERE eva_carga_academica.id_carga_academica='.$id_carga_academica.'');
            $sem=$consultaedit->id_materia;
            //dd($sem);
            $semestre=DB::selectOne('SELECT gnral_materias.id_semestre FROM gnral_materias WHERE gnral_materias.id_materia='.$sem.'');
            $sss = CargaAcademica::find($id_carga_academica);
            $usuarios=2;
            return view('duales.checar_carga_academica',compact('datos_carga','usuario','re','validaciones','semestre','suma','id_alumno'))->with(['edit'=>true,'consultaedit'=>$sss]);
        }
    }
    public function enviarcarga($id){
        $periodo=Session::get('periodo_actual');
        DB::update('UPDATE eva_validacion_de_cargas SET estado_validacion = 1 WHERE id_alumno = '.$id.' AND id_periodo = '.$periodo.'');
        return redirect()->route('checar_carga_academica.index');
    }
    public function update(Request $request, $id)
    {
//dd('update');
        $datos = array(
            'id_status_materia'=>$request->get('status'),
            'id_tipo_curso'=>$request->get('tipo'),
            'grupo'=>$request->get('grupo')
        );
        CargaAcademica::find($id)->update($datos);
        return redirect()->route('checar_carga_academica.index');
    }
    public function destroy($id)
    {
//dd('destroy');
        CargaAcademica::destroy($id);
        return redirect()->route('checar_carga_academica.index');
    }
}
