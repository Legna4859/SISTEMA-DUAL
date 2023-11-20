<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class Pre_reg_req_adminController extends Controller
{
    public function index($id_presupuesto){
       $proyecto=DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto 
       from pres_presupuesto_anteproyecto, pres_proyectos where pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto 
       and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');



       $estado_registro=DB::selectOne('SELECT count(id_req_mat_ante)contar from pres_req_mat_ante 
       where year_requisicion = '.$proyecto->year.' and id_unidad_admin =100');
       $estado_registro=$estado_registro->contar;

       $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `id_mes` ASC');

        $capitulos=DB::select('SELECT pres_fuentes_financiamiento.* from pres_fuentes_financiamiento 
        where  id_presupuesto_ante ='.$id_presupuesto.' order by id_capitulo');
        $partidas= array();
        foreach ($capitulos as $capitulo){
            $partidas_pres=DB::select('SELECT * FROM `pres_partida_pres` WHERE `id_capitulo` = '.$capitulo->id_capitulo.' 
            ORDER BY `pres_partida_pres`.`clave_presupuestal` ASC');
            foreach ($partidas_pres as $partidas_pre) {
                $dat['id_partida_pres'] = $partidas_pre->id_partida_pres;
                $dat['id_capitulo'] = $partidas_pre->id_capitulo;
                $dat['nombre_partida'] = $partidas_pre->nombre_partida;
                $dat['clave_presupuestal'] = $partidas_pre->clave_presupuestal;
                array_push($partidas,$dat);
            }
        }
        $metas = DB::select('SELECT * FROM `pres_metas` WHERE `id_proyecto` = ' . $proyecto->id_proyecto . ' ORDER BY `meta` ASC ');
        $requerimiento_material=DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_unidad_admin` = 100 AND `year_requisicion` = '.$proyecto->year.'');

        if($requerimiento_material != null){
            $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_req_mat_ante  = '.$requerimiento_material->id_req_mat_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');
            //dd($requisiciones);
            $partidas_presupuestales=DB::select('SELECT * FROM `pres_partida_pres` ORDER BY `pres_partida_pres`.`clave_presupuestal` ASC');
//dd($partidas_presupuestales);

            $requisiciones2=array();
            $estado_material=false;
            $estado_documentacion=false;
            $contar_req=0;
            $total_req=0;
            foreach ($requisiciones as $requisicion) {
                $contar_req++;
                $req['id_actividades_req_ante'] = $requisicion->id_actividades_req_ante;
                $req['id_req_mat_ante'] = $requisicion->id_req_mat_ante;
                $req['id_partida_pres'] = $requisicion->id_partida_pres;
                $req['nombre_partida'] = $requisicion->clave_presupuestal . ' ' . $requisicion->nombre_partida;
                $req['id_mes'] = $requisicion->id_mes;
                $req['justificacion'] = $requisicion->justificacion;
                $req['id_proyecto'] = $requisicion->id_proyecto;
                $req['id_meta'] = $requisicion->id_meta;
                $req['numero_requisicion'] = $requisicion->numero_requisicion;
                $req['justificacion'] = $requisicion->justificacion;
                $req['id_autorizacion'] = $requisicion->id_autorizacion;
                $req['comentario'] = $requisicion->comentario;
                $req['requisicion_pdf'] = $requisicion->requisicion_pdf;
                $req['cotizacion_pdf'] = $requisicion->cotizacion_pdf;
                if ($requisicion->requisicion_pdf == '') {
                    $estado_documentacion = true;
                }
                $req['anexo_1_pdf'] = $requisicion->anexo_1_pdf;
                if ($requisicion->anexo_1_pdf == '') {
                    $estado_documentacion = true;
                }
                $req['oficio_suficiencia_presupuestal_pdf'] = $requisicion->oficio_suficiencia_presupuestal_pdf;
                if ($requisicion->oficio_suficiencia_presupuestal_pdf == '') {
                    $estado_documentacion = true;
                }
                $req['id_estado_justificacion'] = $requisicion->id_estado_justificacion;
                if ($requisicion->id_estado_justificacion == 0) {
                    $estado_documentacion = true;
                }
                if ($requisicion->cotizacion_pdf == '') {
                    $estado_documentacion = true;
                }
                $req['justificacion_pdf'] = $requisicion->justificacion_pdf;
                $req['fecha_reg'] = $requisicion->fecha_reg;
                $req['fecha_mod'] = $requisicion->fecha_mod;
                $req['mes'] = $requisicion->mes;
                $req['nombre_proyecto'] = $requisicion->nombre_proyecto;
                $req['meta'] = $requisicion->meta;
                $bienes = array();

                $bienes_servicios = DB::select('SELECT * FROM `pres_reg_material_req_ante` 
             WHERE `id_actividades_req_ante` = ' . $requisicion->id_actividades_req_ante . ' ');
                $contar = DB::selectOne('SELECT count(id_reg_material_ant) contar from pres_reg_material_req_ante
            where id_actividades_req_ante =  ' . $requisicion->id_actividades_req_ante . ' ');
                if ($contar->contar == 0) {
                    $estado_material = true;
                }
                foreach ($bienes_servicios as $servicio) {
                    $serv['id_reg_material_ant'] = $servicio->id_reg_material_ant;
                    $serv['descripcion'] = $servicio->descripcion;
                    $serv['unidad_medida'] = $servicio->unidad_medida;
                    $serv['cantidad'] = $servicio->cantidad;
                    $serv['precio_unitario'] = $servicio->precio_unitario;
                    $serv['importe'] = $servicio->importe;
                    $total_req = $total_req + $servicio->importe;

                    array_push($bienes, $serv);
                }
                $req['servicios'] = $bienes;
                $req['total_importe'] = $total_req;
                array_push($requisiciones2, $req);
            }


        }else{
            $requisiciones2=0;
        }



      return view('departamento_finanzas.jefe_finanazas.reg_requisiciones_admin.iniciar_reg_req_admin', compact('estado_registro','proyecto','meses','partidas','metas','requerimiento_material','requisiciones2'));
    }
    public function registrar_inicio_req_ant_admin(Request $request,$id_presupuesto){

        $proyecto=DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto 
       from pres_presupuesto_anteproyecto, pres_proyectos where pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto 
       and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');

        $fecha_actual = date("Y-m-d");
        $periodo = DB::selectOne('SELECT * FROM `pres_periodo_anteproyecto` WHERE `year` =' .$proyecto->year. ' and id_activacion=1');
        $id_unidad = 100;

        $maxima_requesicion = DB::selectOne('SELECT max(numero_requisicion) numero FROM pres_req_mat_ante
        WHERE id_unidad_admin='.$id_unidad. ' and year_requisicion =' .$proyecto->year. '');
        if ($maxima_requesicion == null) {
            $maxima_requesicion = 1;
        } else {
            $maxima_requesicion = $maxima_requesicion->numero + 1;
        }

        DB:: table('pres_req_mat_ante')->insert([
            'id_unidad_admin' => $id_unidad,
            'year_requisicion' => $periodo->year,
            'id_estado_requisicion' => 4,
            'numero_requisicion' => $maxima_requesicion,
            'fecha_registro' => $fecha_actual,
        ]);
        return back();
    }
    public function guardar_req_mat_admin(Request $request,$id_req_mat_ante){
        $fecha_actual = date('d-m-Y');
        $this->validate($request, [
            'id_presupuesto' => 'required',
            'id_mes' => 'required',
            'justificacion' => 'required',
            'id_partida_pres' => 'required',
            'id_meta'=> 'required',
        ]);
        $id_presupuesto = $request->input('id_presupuesto');
        $proyecto=DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto 
       from pres_presupuesto_anteproyecto, pres_proyectos where pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto 
       and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');
        $id_mes = $request->input('id_mes');
        $justificacion = $request->input('justificacion');
        $id_partida_pres = $request->input('id_partida_pres');
        $id_meta = $request->input('id_meta');

        DB:: table('pres_actividades_req_ante')->insert([
            'id_req_mat_ante' => $id_req_mat_ante,
            'id_partida_pres' => $id_partida_pres,
            'id_mes' => $id_mes,
            'justificacion'=>$justificacion,
            'id_proyecto' => $proyecto->id_proyecto,
            'id_meta' => $id_meta,
            'fecha_reg' => $fecha_actual,
        ]);
        return back();
    }
    public function mod_requisicion_mat_admin($id_actividades_req_ante,$id_presupuesto){
        $requsicion_material = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');


        $anteproyecto=DB::selectOne('SELECT pres_presupuesto_anteproyecto.* from pres_presupuesto_anteproyecto, pres_proyectos 
        where pres_proyectos.id_proyecto = pres_presupuesto_anteproyecto.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto='.$id_presupuesto.' ');


        $capitulos=DB::select('SELECT pres_fuentes_financiamiento.* from pres_fuentes_financiamiento 
where total_presupuesto > 0 and id_presupuesto_ante ='.$anteproyecto->id_presupuesto.' order by id_capitulo');
        $partidas_presupuestales= array();
        foreach ($capitulos as $capitulo){
            $partidas_pres=DB::select('SELECT * FROM `pres_partida_pres` WHERE `id_capitulo` = '.$capitulo->id_capitulo.' 
            ORDER BY `pres_partida_pres`.`clave_presupuestal` ASC');
            foreach ($partidas_pres as $partidas_pre) {
                $dat['id_partida_pres'] = $partidas_pre->id_partida_pres;
                $dat['id_capitulo'] = $partidas_pre->id_capitulo;
                $dat['nombre_partida'] = $partidas_pre->nombre_partida;
                $dat['clave_presupuestal'] = $partidas_pre->clave_presupuestal;
                array_push($partidas_presupuestales,$dat);
            }
        }
        //dd($requsicion_material);
        $meses = DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC ');
        $metas = DB::select('SELECT * FROM `pres_metas` WHERE `id_proyecto` = ' . $requsicion_material->id_proyecto . ' ORDER BY `meta` ASC');

return view('departamento_finanzas.jefe_finanazas.reg_requisiciones_admin.partials_modificar_req_admin', compact('requsicion_material', 'meses', 'metas','partidas_presupuestales'));

    }
    public function guardar_mod_req_mat_admin(Request $request, $id_actividades_req_ante){
        $this->validate($request, [
            'mes_mod' => 'required',
            'justificacion_mod' => 'required',
            'partida_presupuestal_mod' => 'required',
            'meta_mod' => 'required'
        ]);
        $mes_mod = $request->input('mes_mod');
        $justificacion_mod = $request->input('justificacion_mod');
        $partida_presupuestal_mod = $request->input('partida_presupuestal_mod');
        $meta_mod = $request->input('meta_mod');

        $fecha_actual = date('d-m-Y');
        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update([
                'id_partida_pres' => $partida_presupuestal_mod,
                'id_mes' => $mes_mod,
                'justificacion' => $justificacion_mod,
                'id_meta' => $meta_mod,
                'fecha_mod' => $fecha_actual,
            ]);

        return back();
    }
    public function agregar_bienes_servicios_ant_admin($id_actividades_req_ante){
        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante='.$id_actividades_req_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');

        $req_act=DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` ='.$requisiciones[0]->id_req_mat_ante.'');;
        $presupuesto=DB::selectOne('SELECT * FROM pres_presupuesto_anteproyecto WHERE id_proyecto = '.$requisiciones[0]->id_proyecto.' AND year = '.$req_act->year_requisicion.'');

        $proyecto=DB::selectOne('SELECT * FROM `pres_proyectos` WHERE `id_proyecto` = '.$requisiciones[0]->id_proyecto.'');







        $requisiciones2=array();
        $total_req=0;
        foreach ($requisiciones as $requisicion){
            $req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
            $req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
            $req['id_partida_pres']=$requisicion->id_partida_pres;
            $req['nombre_partida']=$requisicion->clave_presupuestal.' '.$requisicion->nombre_partida;
            $req['id_mes']=$requisicion->id_mes;
            $req['id_proyecto']=$requisicion->id_proyecto;
            $req['id_meta']=$requisicion->id_meta;
            $req['numero_requisicion']=$requisicion->numero_requisicion;
            $req['justificacion']=$requisicion->justificacion;
            $req['id_autorizacion']=$requisicion->id_autorizacion;
            $req['comentario']=$requisicion->comentario;
            $req['requisicion_pdf']=$requisicion->requisicion_pdf;
            $req['anexo_1_pdf']=$requisicion->anexo_1_pdf;
            $req['oficio_suficiencia_presupuestal_pdf']=$requisicion->oficio_suficiencia_presupuestal_pdf;
            $req['id_estado_justificacion']=$requisicion->id_estado_justificacion;
            $req['justificacion_pdf']=$requisicion->justificacion_pdf;
            $req['cotizacion_pdf']=$requisicion->cotizacion_pdf;
            $req['fecha_reg']=$requisicion->fecha_reg;
            $req['fecha_mod']=$requisicion->fecha_mod;
            $req['mes']=$requisicion->mes;
            $req['nombre_proyecto']=$requisicion->nombre_proyecto;
            $req['meta']=$requisicion->meta;
            $bienes=array();
            $bienes_servicios=DB::select('SELECT * FROM `pres_reg_material_req_ante` 
             WHERE `id_actividades_req_ante` = '.$requisicion->id_actividades_req_ante.'');
            foreach ( $bienes_servicios as $servicio) {
                $serv['id_reg_material_ant']=$servicio->id_reg_material_ant;
                $serv['descripcion']=$servicio->descripcion;
                $serv['unidad_medida']=$servicio->unidad_medida;
                $serv['cantidad']=$servicio->cantidad;
                $serv['precio_unitario']=$servicio->precio_unitario;
                $serv['importe']=$servicio->importe;
                $total_req=$total_req+$servicio->importe;

                array_push($bienes, $serv);
            }
            $req['servicios']=$bienes;
            array_push($requisiciones2, $req);
        }
        $datos_req_envio = DB::selectOne('SELECT pres_req_mat_ante.* from pres_req_mat_ante, 
        pres_actividades_req_ante WHERE  pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante 
        and pres_actividades_req_ante.id_actividades_req_ante ='.$id_actividades_req_ante.' ');

        ///////// presupuesto de proyecto del anteproyecto
        $reg_envio_ante=DB::selectOne('SELECT *from pres_req_mat_ante where id_req_mat_ante = '.$requisiciones[0]->id_req_mat_ante.' ');


        //dd($presupuestos_anteproyectos);

        $partida_presupuestal=DB::selectOne('SELECT * FROM `pres_partida_pres` WHERE `id_partida_pres` = '.$requisiciones[0]->id_partida_pres.' ');
        $presupuesto_cap=0;

        if($partida_presupuestal->clave_presupuestal >1000 and  $partida_presupuestal->clave_presupuestal < 2000){

            $presupuesto_cap=DB::selectOne('SELECT  pres_presupuesto_anteproyecto.id_proyecto, pres_presupuesto_anteproyecto.year, pres_fuentes_financiamiento.*
            from pres_presupuesto_anteproyecto, pres_fuentes_financiamiento where pres_presupuesto_anteproyecto.id_presupuesto = pres_fuentes_financiamiento.id_presupuesto_ante
            and pres_presupuesto_anteproyecto.id_proyecto = '.$requisiciones[0]->id_proyecto.' and pres_presupuesto_anteproyecto.year = '.$reg_envio_ante->year_requisicion.'
             and pres_fuentes_financiamiento.id_capitulo = 1');

        }elseif($partida_presupuestal->clave_presupuestal >=2000 and  $partida_presupuestal->clave_presupuestal < 3000)
        {
            $presupuesto_cap=DB::selectOne('SELECT  pres_presupuesto_anteproyecto.id_proyecto, pres_presupuesto_anteproyecto.year, pres_fuentes_financiamiento.*
            from pres_presupuesto_anteproyecto, pres_fuentes_financiamiento where pres_presupuesto_anteproyecto.id_presupuesto = pres_fuentes_financiamiento.id_presupuesto_ante
            and pres_presupuesto_anteproyecto.id_proyecto = '.$requisiciones[0]->id_proyecto.' and pres_presupuesto_anteproyecto.year = '.$reg_envio_ante->year_requisicion.'
             and pres_fuentes_financiamiento.id_capitulo = 2');



        }elseif($partida_presupuestal->clave_presupuestal >=3000 and  $partida_presupuestal->clave_presupuestal < 4000)
        {
            $presupuesto_cap=DB::selectOne('SELECT  pres_presupuesto_anteproyecto.id_proyecto, pres_presupuesto_anteproyecto.year, pres_fuentes_financiamiento.*
            from pres_presupuesto_anteproyecto, pres_fuentes_financiamiento where pres_presupuesto_anteproyecto.id_presupuesto = pres_fuentes_financiamiento.id_presupuesto_ante
            and pres_presupuesto_anteproyecto.id_proyecto = '.$requisiciones[0]->id_proyecto.' and pres_presupuesto_anteproyecto.year = '.$reg_envio_ante->year_requisicion.'
             and pres_fuentes_financiamiento.id_capitulo = 3');

        }
        elseif($partida_presupuestal->clave_presupuestal >=4000 and  $partida_presupuestal->clave_presupuestal < 5000)
        {
            $presupuesto_cap=DB::selectOne('SELECT  pres_presupuesto_anteproyecto.id_proyecto, pres_presupuesto_anteproyecto.year, pres_fuentes_financiamiento.*
            from pres_presupuesto_anteproyecto, pres_fuentes_financiamiento where pres_presupuesto_anteproyecto.id_presupuesto = pres_fuentes_financiamiento.id_presupuesto_ante
            and pres_presupuesto_anteproyecto.id_proyecto = '.$requisiciones[0]->id_proyecto.' and pres_presupuesto_anteproyecto.year = '.$reg_envio_ante->year_requisicion.'
             and pres_fuentes_financiamiento.id_capitulo = 4');

        }
        elseif($partida_presupuestal->clave_presupuestal >=5000 and  $partida_presupuestal->clave_presupuestal < 6000)
        {
            $presupuesto_cap=DB::selectOne('SELECT  pres_presupuesto_anteproyecto.id_proyecto, pres_presupuesto_anteproyecto.year, pres_fuentes_financiamiento.*
            from pres_presupuesto_anteproyecto, pres_fuentes_financiamiento where pres_presupuesto_anteproyecto.id_presupuesto = pres_fuentes_financiamiento.id_presupuesto_ante
            and pres_presupuesto_anteproyecto.id_proyecto = '.$requisiciones[0]->id_proyecto.' and pres_presupuesto_anteproyecto.year = '.$reg_envio_ante->year_requisicion.'
             and pres_fuentes_financiamiento.id_capitulo = 5');
        }
        elseif($partida_presupuestal->clave_presupuestal >=6000 and  $partida_presupuestal->clave_presupuestal < 7000)
        {
            $presupuesto_cap=DB::selectOne('SELECT  pres_presupuesto_anteproyecto.id_proyecto, pres_presupuesto_anteproyecto.year, pres_fuentes_financiamiento.*
            from pres_presupuesto_anteproyecto, pres_fuentes_financiamiento where pres_presupuesto_anteproyecto.id_presupuesto = pres_fuentes_financiamiento.id_presupuesto_ante
            and pres_presupuesto_anteproyecto.id_proyecto = '.$requisiciones[0]->id_proyecto.' and pres_presupuesto_anteproyecto.year = '.$reg_envio_ante->year_requisicion.'
             and pres_fuentes_financiamiento.id_capitulo = 6');

        }





        foreach ($requisiciones as $requisicion){
            $dat['clave_partida']= $requisicion->clave_presupuestal;
            $dat['nombre_partida']=$requisicion->nombre_partida;
            $dat['financimiento_estatal']=$total_req*$presupuesto_cap->financiamiento_estatal;
            $total_financiamiento_estatal=$total_req*$presupuesto_cap->financiamiento_estatal;
            $dat['financiamiento_federal']=$total_req*$presupuesto_cap->financiamiento_federal;
            $total_financiamiento_federal=$total_req*$presupuesto_cap->financiamiento_federal;
            $dat['financiamiento_propios']=$total_req*$presupuesto_cap->financiamiento_propios;
            $total_financiamiento_propios=$total_req*$presupuesto_cap->financiamiento_propios;
            $total_finaciamiento_total =$total_financiamiento_estatal+$total_financiamiento_federal+$total_financiamiento_propios;
            $dat['total_finaciamiento_total']=$total_finaciamiento_total;
        }


        $req=DB::select('SELECT pres_actividades_req_ante.* from pres_req_mat_ante, pres_actividades_req_ante,pres_partida_pres 
        WHERE pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and pres_req_mat_ante.year_requisicion = '.$reg_envio_ante->year_requisicion.'
        and pres_actividades_req_ante.id_proyecto = '.$requisiciones[0]->id_proyecto.' and pres_actividades_req_ante.id_autorizacion = 4 AND
        pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres and pres_partida_pres.id_capitulo='.$presupuesto_cap->id_capitulo.'');

        $total_proyecto=0;
        foreach ($req as $req){
            $materiales=DB::selectOne('SELECT SUM(importe) suma FROM pres_reg_material_req_ante WHERE id_actividades_req_ante ='.$req->id_actividades_req_ante.' ');

            $total_proyecto=$total_proyecto+$materiales->suma;
        }

      return view('departamento_finanzas.jefe_finanazas.reg_requisiciones_admin.ver_reg_act_admin', compact( 'presupuesto','requisiciones2','datos_req_envio','total_req','id_actividades_req_ante','presupuesto_cap','requisiciones','total_proyecto','dat','proyecto'));

    }
    public function guardar_autorizacion_req_admin(Request $request){
        $this->validate($request, [
            'id_act_requisicion_antep' => 'required',
        ]);
        $id_act_requisicion_ante = $request->input('id_act_requisicion_antep');
        $dat_requisicion=DB::selectOne('SELECT * FROM `pres_actividades_req_ante` WHERE `id_actividades_req_ante` ='.$id_act_requisicion_ante.' ');
        $requisicion=DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` ='.$dat_requisicion->id_req_mat_ante.'');


        $anteproyecto=DB::selectOne('SELECT *  FROM pres_presupuesto_anteproyecto WHERE id_proyecto = '.$dat_requisicion->id_proyecto.' AND year = '.$requisicion->year_requisicion.'');

        $id_req_mat_ante=$dat_requisicion->id_req_mat_ante;

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_act_requisicion_ante)
            ->update([
                'comentario' => "",
                'id_autorizacion' =>4
            ]);

        return redirect('/presupuesto_anteproyecto/agregar_requisiciones_admin/'.$anteproyecto->id_presupuesto);
    }
}
