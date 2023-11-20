<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Pres_periodo_antController extends Controller
{
    public function index(){
       $periodos=DB::select('SELECT *from pres_periodo_anteproyecto order by id_peri_anteproyecto asc');

        $year= date('Y');
        $year= $year+1;
        $reg_periodo=DB::selectOne('SELECT count(id_peri_anteproyecto)contar from pres_periodo_anteproyecto WHERE year ='.$year.'');
        $activo_periodo=DB::selectOne('SELECT count(id_peri_anteproyecto)contar from pres_periodo_anteproyecto WHERE year ='.$year.' and  id_activacion = 1');
        $periodo_activo=DB::selectOne('SELECT *from pres_periodo_anteproyecto WHERE year ='.$year.'  ');
        $periodo_finalizado=DB::selectOne('SELECT count(id_peri_anteproyecto)contar from pres_periodo_anteproyecto WHERE id_activacion = 2 and year ='.$year.' ');

        return view('departamento_finanzas.requisicion_mat_anteproyecto.periodos_anteproyecto',compact('periodos','reg_periodo','activo_periodo','periodo_activo','periodo_finalizado','year'));

    }
    public function guardar_periodos_anteproyecto(Request $request){

        $this->validate($request, [
            'fecha_i' => 'required',
            'fecha_f' => 'required',
            'year_actual' => 'required',
        ]);
        $fecha_i = $request->input('fecha_i');
        $fecha_i = str_replace('/', '-', $fecha_i);
        $fecha_i= date('Y-m-d', strtotime($fecha_i));

        $fecha_f = $request->input('fecha_f');
        $fecha_f = str_replace('/', '-', $fecha_f);
        $fecha_f= date('Y-m-d', strtotime($fecha_f));
        $year_actual = $request->input('year_actual');
        $fecha_actual = date('d-m-Y');
        DB:: table('pres_periodo_anteproyecto')->insert([
            'fecha_inicio' => $fecha_i,
            'fecha_final' => $fecha_f,
            'year' => $year_actual,
            'fecha_registro' => $fecha_actual,
            'id_activacion' => 0,
        ]);
        return back();

    }
    public function modificar_periodos_anteproyecto($id_periodo){

       $periodo=DB::selectOne('SELECT * FROM `pres_periodo_anteproyecto` WHERE `id_peri_anteproyecto` = '.$id_periodo.'');
        $fecha_i= date('d-m-Y', strtotime($periodo->fecha_inicio));
        $fecha_f= date('d-m-Y', strtotime( $periodo->fecha_final));
       return view('departamento_finanzas.requisicion_mat_anteproyecto.partials_modificar_periodo',compact('periodo','fecha_i','fecha_f'));
    }
    public function guardar_modificacion_periodos_anteproyecto(Request $request,$id_periodo){

        $this->validate($request, [
            'fecha_inicial_mod' => 'required',
            'fecha_final_mod' => 'required',

        ]);

        $fecha_i = $request->input('fecha_inicial_mod');
        $fecha_i = str_replace('/', '-', $fecha_i);
        $fecha_i= date('Y-m-d', strtotime($fecha_i));

        $fecha_f = $request->input('fecha_final_mod');
        $fecha_f = str_replace('/', '-', $fecha_f);
        $fecha_f= date('Y-m-d', strtotime($fecha_f));

        $year_actual = $request->input('year_actual_mod');
        $fecha_actual = date('d-m-Y');

        DB::table('pres_periodo_anteproyecto')
            ->where('id_peri_anteproyecto', $id_periodo)
            ->update([
                'fecha_inicio' => $fecha_i,
                'fecha_final' => $fecha_f,
                'fecha_modificacion' => $fecha_actual,
            ]);

        return back();

    }
    public  function activar_periodo_anteproyecto($id_periodo){
        $periodo=DB::selectOne('SELECT * FROM `pres_periodo_anteproyecto` WHERE `id_peri_anteproyecto` = '.$id_periodo.'');
        $fecha_i= date('d-m-Y', strtotime($periodo->fecha_inicio));
        $fecha_f= date('d-m-Y', strtotime( $periodo->fecha_final));

        return view('departamento_finanzas.requisicion_mat_anteproyecto.partials_activar_periodo',compact('periodo','fecha_i','fecha_f'));
    }
    public function guardar_activacion_periodo_anteproyecto(Request $request,$id_periodo){
        $fecha_actual = date('d-m-Y');
        DB::table('pres_periodo_anteproyecto')
            ->where('id_peri_anteproyecto', $id_periodo)
            ->update([
                'fecha_activacion' => $fecha_actual,
                'id_activacion' => 1, //activaacion de periodo
            ]);
        return back();
    }
    public function guardar_finalizacion_periodos_anteproyecto(Request $request,$id_periodo){
        $fecha_actual = date('d-m-Y');
        DB::table('pres_periodo_anteproyecto')
            ->where('id_peri_anteproyecto', $id_periodo)
            ->update([
                'fecha_activacion' => $fecha_actual,
                'id_activacion' => 2, //des activaacion de periodo
            ]);
        return back();
    }
    public function partida_presupuestal(){

        $partidas=DB::select('SELECT * FROM `pres_partida_pres` ORDER BY `pres_partida_pres`.`clave_presupuestal` ASC ');
        return view('departamento_finanzas.catalogo.partidas_presupuestales',compact('partidas'));
    }
    public function guardar_partida_presupuestal(Request $request){
        $this->validate($request, [
            'clave_partida' => 'required',
            'nombre_partida' => 'required',
        ]);
        $clave_partida = $request->input('clave_partida');
        $nombre_partida = $request->input('nombre_partida');

        $fecha_actual = date('d-m-Y');
        DB:: table('pres_partida_pres')->insert([
            'nombre_partida' => $nombre_partida,
            'clave_presupuestal' => $clave_partida,
            'fecha_registro' => $fecha_actual,
        ]);
        return back();
    }
    public function modificar_partida_presupuestal($id_partida){
        $partida=DB::selectOne('SELECT * FROM `pres_partida_pres` WHERE `id_partida_pres` = '.$id_partida.'');
        return view('departamento_finanzas.catalogo.partials_modificar_partida',compact('partida'));
    }
    public function guardar_modificacion_partida(Request $request,$id_partida){
        $this->validate($request, [
            'clave_partida_mod' => 'required',
            'nombre_partida_mod' => 'required',
        ]);
        $clave_partida = $request->input('clave_partida_mod');
        $nombre_partida = $request->input('nombre_partida_mod');
        $fecha_actual = date('d-m-Y');
        DB::table('pres_partida_pres')
            ->where('id_partida_pres', $id_partida)
            ->update([
                'clave_presupuestal' => $clave_partida,
                'nombre_partida' =>$nombre_partida,
                'fecha_modificacion' =>$fecha_actual,
            ]);
        return back();
    }
    public function proyectos_presupuestales( ){
        $year= date('Y');
        $year= $year+1;
        $proyectos=DB::select('SELECT * FROM pres_proyectos where year='.$year.' ORDER BY pres_proyectos.nombre_proyecto ASC ');
        return view('departamento_finanzas.catalogo.proyectos',compact('proyectos','year'));
    }
    public function guardar_proyecto(Request $request){
        $this->validate($request, [
            'nombre_proyecto' => 'required',
        ]);
        $nombre_proyecto = $request->input('nombre_proyecto');

        $fecha_actual = date('d-m-Y');
        $year= date('Y');
        $year= $year+1;
        DB:: table('pres_proyectos')->insert([
            'nombre_proyecto' => $nombre_proyecto,
            'fecha_registro' => $fecha_actual,
            'year'=>$year,
        ]);
        return back();
    }
    public function modificar_proyecto($id_proyecto){
        $proyecto=DB::selectOne('SELECT * FROM `pres_proyectos` WHERE `id_proyecto` = '.$id_proyecto.' ORDER BY `nombre_proyecto` ASC ');
        return view('departamento_finanzas.catalogo.partials_modificar_proyecto',compact('proyecto'));
    }
    public function guardar_modificacion_proyecto(Request $request, $id_proyecto){
        $this->validate($request, [
            'nombre_proyecto_mod' => 'required',
        ]);
        $nombre_proyecto = $request->input('nombre_proyecto_mod');
        $fecha_actual = date('d-m-Y');
        DB::table('pres_proyectos')
            ->where('id_proyecto', $id_proyecto)
            ->update([
                'nombre_proyecto' => $nombre_proyecto,
                'fecha_modificacion' =>$fecha_actual,
            ]);
        return back();
    }
    public function proyectos_metas(Request $request){
        $year= date('Y');
        $year= $year+1;
        $proyectos=DB::select('SELECT * FROM pres_proyectos WHERE year = '.$year.' and id_estado = 1 ORDER BY nombre_proyecto ASC ');
        return view('departamento_finanzas.catalogo.inicio_proyectos',compact('proyectos','year'));
    }
    public function metas_presupuestales($id_proyecto){


       $metas=DB::select('SELECT * FROM `pres_metas` WHERE `id_proyecto` = '.$id_proyecto.'  ORDER BY `pres_metas`.`id_meta` ASC ');
        $proyecto=DB::selectOne('SELECT * FROM `pres_proyectos` WHERE `id_proyecto` = '.$id_proyecto.' ORDER BY `nombre_proyecto` ASC ');

        return view('departamento_finanzas.catalogo.metas',compact('metas','proyecto'));
    }
    public function guardar_meta(Request $request, $id_proyecto){
        $this->validate($request, [
            'nombre_meta' => 'required',
        ]);
        $year= date('Y');
        $year= $year+1;
        $nombre_meta = $request->input('nombre_meta');

        $fecha_actual = date('d-m-Y');
        DB:: table('pres_metas')->insert([
            'meta' => $nombre_meta,
            'fecha_registro' => $fecha_actual,
            'id_proyecto'=>$id_proyecto,
        ]);
        return back();
    }
    public function modificar_meta($id_meta){
        $meta=DB::selectOne('SELECT * FROM `pres_metas` WHERE `id_meta` = '.$id_meta.' ORDER BY `meta` ASC ');
        return view('departamento_finanzas.catalogo.partials_modificar_meta',compact('meta'));
    }
    public function guardar_modificacion_meta(Request $request, $id_meta){
        $this->validate($request, [
            'nombre_meta_mod' => 'required',
        ]);
        $nombre_meta = $request->input('nombre_meta_mod');
        $fecha_actual = date('d-m-Y');
        DB::table('pres_metas')
            ->where('id_meta', $id_meta)
            ->update([
                'meta' => $nombre_meta,
                'fecha_modificacion' =>$fecha_actual,
            ]);
        return back();
    }
    public function activar_proyecto($id_proyecto){
        $proyecto=DB::selectOne('SELECT * FROM `pres_proyectos` WHERE `id_proyecto` = '.$id_proyecto.'');
        return view('departamento_finanzas.catalogo.partials_activar_proyecto',compact('proyecto'));
    }
    public function guardar_activacion_proyecto(Request $request,$id_proyecto){
        DB::table('pres_proyectos')
            ->where('id_proyecto', $id_proyecto)
            ->update([
                'id_estado' =>1,
            ]);
        return back();
    }
    public function desactivar_proyecto($id_proyecto){
        $proyecto=DB::selectOne('SELECT * FROM `pres_proyectos` WHERE `id_proyecto` = '.$id_proyecto.'');
        return view('departamento_finanzas.catalogo.partials_desactivar_proyecto',compact('proyecto'));
    }
    public function guardar_desactivacion_proyecto(Request $request, $id_proyecto){
        DB::table('pres_proyectos')
            ->where('id_proyecto', $id_proyecto)
            ->update([
                'id_estado' =>0,
            ]);
        return back();
    }
}
