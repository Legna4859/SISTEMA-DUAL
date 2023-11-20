<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;
class Pres_reg_req_mat_antController extends Controller
{
    public function index()
    {
        $id_unidad = Session::get('id_unidad_admin');
        $year = date('Y');
        $year = $year+1;
        $fecha_actual = date("Y-m-d");
        $periodo = DB::selectOne('SELECT * FROM `pres_periodo_anteproyecto` WHERE `year` =' . $year . '');


        $estado_periodo = 0;
        $estado_fecha = 0;
        $registros = 0;
        if ($periodo == null) {
            $estado_periodo = 0;
            $estado_fecha = 0;
            $registros = 0;
        } else {
            $fecha_inicial = $periodo->fecha_inicio;
            $fecha_final = $periodo->fecha_final;
            if ($periodo->id_activacion == 1) {
                $estado_periodo = 1;

                if ($fecha_actual <= $fecha_final and $fecha_actual >= $fecha_inicial) {

                    $estado_fecha = 1;
                    $registros = DB::selectOne('SELECT  *from pres_req_mat_ante where id_unidad_admin = ' . $id_unidad . ' and year_requisicion = ' . $year . '');

                } else {
                    $estado_fecha = 2;
                    $registros = 0;

                }
            }
            if ($periodo->id_activacion == 2) {
                $estado_periodo = 2;
                $estado_fecha = 3;
                $registros = 0;
            }

        }

        return view('departamento_finanzas.jefe_departamento.reg_envio_requisicion', compact('estado_periodo', 'estado_fecha', 'periodo', 'registros','year'));
    }

    public function inicio_re_ant()
    {
        $year = date('Y');
        $year = $year+1;
        $fecha_actual = date("Y-m-d");
        $periodo = DB::selectOne('SELECT * FROM `pres_periodo_anteproyecto` WHERE `year` =' . $year . ' and id_activacion=1');
        $id_unidad = Session::get('id_unidad_admin');
        $maxima_requesicion = DB::selectOne('SELECT max(numero_requisicion) numero FROM pres_req_mat_ante
        WHERE id_unidad_admin=' . $id_unidad . ' and year_requisicion =' . $year . '');
        if ($maxima_requesicion == null) {
            $maxima_requesicion = 1;
        } else {
            $maxima_requesicion = $maxima_requesicion->numero + 1;
        }


        DB:: table('pres_req_mat_ante')->insert([
            'id_unidad_admin' => $id_unidad,
            'year_requisicion' => $periodo->year,
            'id_estado_requisicion' => 0,
            'numero_requisicion' => $maxima_requesicion,
            'fecha_registro' => $fecha_actual,
        ]);
        return back();
    }

    public function registro_inicio_req_ant($id_req_mat_ante)
    {
        $datos_req_envio = DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` = ' . $id_req_mat_ante . '');

        $meses = DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC ');
        $proyectos = DB::select('SELECT pres_proyectos.* from pres_presupuesto_anteproyecto, pres_proyectos 
        where pres_proyectos.id_proyecto = pres_presupuesto_anteproyecto.id_proyecto 
        and pres_presupuesto_anteproyecto.year='.$datos_req_envio->year_requisicion.'  ORDER BY `pres_proyectos`.`nombre_proyecto` ASC ');
        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_req_mat_ante  = '.$id_req_mat_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');
      //  dd($requisiciones);
        //dd($requisiciones);
        $partidas_presupuestales=DB::select('SELECT * FROM `pres_partida_pres` ORDER BY `pres_partida_pres`.`clave_presupuestal` ASC');
//dd($partidas_presupuestales);

        $requisiciones2=array();
        $estado_material=false;
        $estado_documentacion=false;
        $contar_req=0;
        $total_req=0;
        foreach ($requisiciones as $requisicion){
            $contar_req++;
            $req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
            $req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
            $req['id_partida_pres']=$requisicion->id_partida_pres;
            $req['nombre_partida']=$requisicion->clave_presupuestal.' '.$requisicion->nombre_partida;
            $req['id_mes']=$requisicion->id_mes;
            $req['justificacion']=$requisicion->justificacion;
            $req['id_proyecto']=$requisicion->id_proyecto;
            $req['id_meta']=$requisicion->id_meta;
            $req['numero_requisicion']=$requisicion->numero_requisicion;
            $req['justificacion']=$requisicion->justificacion;
            $req['id_autorizacion']=$requisicion->id_autorizacion;
            $req['comentario']=$requisicion->comentario;
            $req['requisicion_pdf']=$requisicion->requisicion_pdf;
            $req['cotizacion_pdf']=$requisicion->cotizacion_pdf;
            if($requisicion->requisicion_pdf == ''){
                $estado_documentacion=true;
            }
            $req['anexo_1_pdf']=$requisicion->anexo_1_pdf;
            if($requisicion->anexo_1_pdf == ''){

            }
            $req['oficio_suficiencia_presupuestal_pdf']=$requisicion->oficio_suficiencia_presupuestal_pdf;
            if($requisicion->oficio_suficiencia_presupuestal_pdf == ''){

            }
            $req['id_estado_justificacion']=$requisicion->id_estado_justificacion;
            if($requisicion->id_estado_justificacion ==  0){
                $estado_documentacion=true;
            }
            if($requisicion->cotizacion_pdf == ''){
                $estado_documentacion=true;
            }
            $req['justificacion_pdf']=$requisicion->justificacion_pdf;
            $req['fecha_reg']=$requisicion->fecha_reg;
            $req['fecha_mod']=$requisicion->fecha_mod;
            $req['mes']=$requisicion->mes;
            $req['nombre_proyecto']=$requisicion->nombre_proyecto;
            $req['meta']=$requisicion->meta;
            $bienes=array();

            $bienes_servicios=DB::select('SELECT * FROM `pres_reg_material_req_ante` 
             WHERE `id_actividades_req_ante` = '.$requisicion->id_actividades_req_ante.' ');
            $contar=DB::selectOne('SELECT count(id_reg_material_ant) contar from pres_reg_material_req_ante
            where id_actividades_req_ante =  '.$requisicion->id_actividades_req_ante.' ');
            if($contar->contar == 0){
                $estado_material=true;
            }
            $total_req=0;
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
            $req['total_importe']=$total_req;
            array_push($requisiciones2, $req);
        }



        return view('departamento_finanzas.jefe_departamento.reg_actividades_requerimientos', compact('datos_req_envio', 'meses', 'proyectos', 'requisiciones2','partidas_presupuestales','total_req','id_req_mat_ante','estado_material','estado_documentacion','contar_req','total_req'));

    }

    public function registrar_nueva_requisicion_mat(Request $request, $id_req_mat_ante)
    {
        $datos_requesicion_admin = DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` =' . $id_req_mat_ante . '');
        dd($datos_requesicion_admin);
    }

    public function ver_meta($id_anteproyecto)
    {
        $metas = DB::select('SELECT * FROM `pres_metas` WHERE `id_proyecto` = ' . $id_anteproyecto . ' ORDER BY `meta` ASC ');
        return $metas;
    }
    public function ver_partida_presupuestal($id_proyecto){
        $year = date('Y');
        $year = $year+1;
        $anteproyecto=DB::selectOne('SELECT pres_presupuesto_anteproyecto.* from pres_presupuesto_anteproyecto, pres_proyectos 
        where pres_proyectos.id_proyecto = pres_presupuesto_anteproyecto.id_proyecto and pres_presupuesto_anteproyecto.year='.$year.'
        and pres_presupuesto_anteproyecto.id_proyecto='.$id_proyecto.' ');
/*
        $capitulos=DB::select('SELECT pres_fuentes_financiamiento.* from pres_fuentes_financiamiento 
where total_presupuesto > 0 and id_presupuesto_ante ='.$anteproyecto->id_presupuesto.' order by id_capitulo');
*/
        $capitulos=DB::select('SELECT pres_fuentes_financiamiento.* from pres_fuentes_financiamiento 
where  id_presupuesto_ante ='.$anteproyecto->id_presupuesto.' order by id_capitulo');
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
        return $partidas;

    }

    public function guardar_requisicion_materiales(Request $request, $id_req_mat_ante)
    {


        $fecha_actual = date('d-m-Y');
        $this->validate($request, [
            'partida_presupuestal' => 'required',
            'mes' => 'required',
            'proyecto' => 'required',
            'meta1' => 'required',
            'justificacion'=> 'required',
        ]);
        $partida_presupuestal = $request->input('partida_presupuestal');
        $mes = $request->input('mes');
        $proyecto = $request->input('proyecto');
        $meta1 = $request->input('meta1');
        $justificacion= $request->input('justificacion');

        DB:: table('pres_actividades_req_ante')->insert([
            'id_req_mat_ante' => $id_req_mat_ante,
            'id_partida_pres' => $partida_presupuestal,
            'id_mes' => $mes,
            'justificacion'=>$justificacion,
            'id_proyecto' => $proyecto,
            'id_meta' => $meta1,
            'fecha_reg' => $fecha_actual,
        ]);
        return back();

    }

    public function modificar_requisicion_material($id_actividades_req_ante,$year)
    {


        $requsicion_material = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');


        $anteproyecto=DB::selectOne('SELECT pres_presupuesto_anteproyecto.* from pres_presupuesto_anteproyecto, pres_proyectos 
        where pres_proyectos.id_proyecto = pres_presupuesto_anteproyecto.id_proyecto and pres_presupuesto_anteproyecto.year='.$year.'
        and pres_presupuesto_anteproyecto.id_proyecto='.$requsicion_material->id_proyecto.' ');

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
        $proyectos = DB::select('SELECT * FROM `pres_proyectos` ORDER BY `pres_proyectos`.`nombre_proyecto` ASC ');
        $metas = DB::select('SELECT * FROM `pres_metas` WHERE `id_proyecto` = ' . $requsicion_material->id_proyecto . ' ORDER BY `meta` ASC');

        return view('departamento_finanzas.jefe_departamento.partials_modificar_req_mat', compact('requsicion_material', 'meses', 'proyectos', 'metas','partidas_presupuestales'));

    }

    public function guardar_modificacion_requisicion_materiales(Request $request, $id_actividades_req_ante)
    {
        $this->validate($request, [
            'partida_presupuestal_mod' => 'required',
            'mes_mod' => 'required',
            'proyecto_mod' => 'required',
            'meta_mod' => 'required',
            'justificacion_mod' => 'required',
        ]);
        $partida_presupuestal = $request->input('partida_presupuestal_mod');
        $mes = $request->input('mes_mod');
        $justificacion_mod = $request->input('justificacion_mod');
        $proyecto = $request->input('proyecto_mod');
        $meta1 = $request->input('meta_mod');
        $fecha_actual = date('d-m-Y');
        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update([
                'id_partida_pres' => $partida_presupuestal,
                'id_mes' => $mes,
                'justificacion' => $justificacion_mod,
                'id_proyecto' => $proyecto,
                'id_meta' => $meta1,
                'fecha_mod' => $fecha_actual,
            ]);

        return back();
    }

    public function eliminar_requisicion_material($id_actividades_req_ante)
    {
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        return view('departamento_finanzas.jefe_departamento.partials_eliminar_req_mat', compact('requisicion'));

    }

    public function guardar_eliminacion_requisicion_materiales(Request $request, $id_actividades_req_ante)
    {

        DB::table('pres_actividades_req_ante')->
        where('id_actividades_req_ante', $id_actividades_req_ante)->delete();
        return back();
    }

    public function agregar_requisicion_pdf($id_actividades_req_ante)
    {
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        return view('departamento_finanzas.jefe_departamento.partials_agregar_req_pdf', compact('requisicion'));

    }

    public function guardar_requisicion_pdf(Request $request, $id_actividades_req_ante)
    {
        $file = $request->file('requisicion_pdf');

        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        //dd($requisicion);

        $name = "requisicion_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/requisiciones/', $name);

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update(['requisicion_pdf' => $name]);
        return back();
    }

    public function agregar_anexo1_pdf($id_actividades_req_ante)
    {
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        return view('departamento_finanzas.jefe_departamento.partials_agregar_anexo1', compact('requisicion'));

    }

    public function guardar_anexo1_pdf(Request $request, $id_actividades_req_ante)
    {
        $file = $request->file('anexo1_pdf');

        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        //dd($requisicion);

        $name = "anexo1_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/anexo1/', $name);

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update(['anexo_1_pdf' => $name]);
        return back();
    }

    public function agregar_suficiencia_pdf($id_actividades_req_ante)
    {
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        return view('departamento_finanzas.jefe_departamento.partials_agregar_suficiencia_pdf', compact('requisicion'));
    }

    public function guardar_suficiencia_pdf(Request $request, $id_actividades_req_ante)
    {

        $file = $request->file('suficiencia_pdf');

        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        //dd($requisicion);

        $name = "oficio_suficiencia_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/oficio_suficiencia/', $name);

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update(['oficio_suficiencia_presupuestal_pdf' => $name]);
        return back();
    }

    public function agregar_justificacion_pdf($id_actividades_req_ante)
    {
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        $respuestas = DB::select('SELECT * FROM `ti_respuesta` ');
        return view('departamento_finanzas.jefe_departamento.partials_justificacionpdf', compact('requisicion', 'respuestas'));

    }

    public function guardar_justificacion_pdf(Request $request, $id_actividades_req_ante)
    {

        $justififcacion_pdf = $request->input('justififcacion_pdf');
        if ($justififcacion_pdf == 1) {
            DB::table('pres_actividades_req_ante')
                ->where('id_actividades_req_ante', $id_actividades_req_ante)
                ->update(['id_estado_justificacion' => 1]);
            return back();
        } else {
            $file = $request->file('doc_justificacion_pdf');

            $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

            //dd($requisicion);

            $name = "justificacion_doc_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/justificacion/', $name);

            DB::table('pres_actividades_req_ante')
                ->where('id_actividades_req_ante', $id_actividades_req_ante)
                ->update(['id_estado_justificacion' => 2,
                    'justificacion_pdf' => $name
                ]);
            return back();
        }
    }

    public function modificar_req_mat_pdf($id_actividades_req_ante)
    {
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        return view('departamento_finanzas.jefe_departamento.partials_mod_req_mat', compact('requisicion'));

    }

    public function guardar_mod_requisicion_pdf(Request $request, $id_actividades_req_ante)
    {
        $file = $request->file('requisicion_pdf_mod');

        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        //dd($requisicion);

        $name = "requisicion_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/requisiciones/', $name);

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update(['requisicion_pdf' => $name]);
        return back();
    }

    public function mod_anexo1_pdf($id_actividades_req_ante)
    {
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        return view('departamento_finanzas.jefe_departamento.partials_mod_anexo1', compact('requisicion'));

    }

    public function guardar_mod_anexo1_pdf(Request $request, $id_actividades_req_ante)
    {

        $file = $request->file('mod_anexo1_pdf');

        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        //dd($requisicion);

        $name = "anexo1_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/anexo1/', $name);

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update(['anexo_1_pdf' => $name]);
        return back();
    }
    public function mod_suficiencia_pdf($id_actividades_req_ante){
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        return view('departamento_finanzas.jefe_departamento.partials_mod_suficiencia', compact('requisicion'));

    }
    public function guardar_mod_suficiencia_pdf(Request $request, $id_actividades_req_ante)
    {

        $file = $request->file('mod_suficiencia_pdf');

        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        //dd($requisicion);

        $name = "oficio_suficiencia_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/oficio_suficiencia/', $name);

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update(['oficio_suficiencia_presupuestal_pdf' => $name]);
        return back();
    }
    public function mod_justificacion_pdf($id_actividades_req_ante){
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        $respuestas = DB::select('SELECT * FROM `ti_respuesta` ');
        return view('departamento_finanzas.jefe_departamento.partials_mod_justificacion_pdf', compact('requisicion', 'respuestas'));

    }
    public function guardar_mod_justificacion_pdf(Request $request,$id_actividades_req_ante)
    {

        $justififcacion_pdf = $request->input('mod_justififcacion_pdf');
        if ($justififcacion_pdf == 1) {
            DB::table('pres_actividades_req_ante')
                ->where('id_actividades_req_ante', $id_actividades_req_ante)
                ->update(['id_estado_justificacion' => 1,
                    'justificacion_pdf' => " "
                ]);
            return back();
        } else {
            $file = $request->file('doc_justificacion_pdf');

            $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

            //dd($requisicion);

            $name = "justificacion_doc_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/justificacion/', $name);

            DB::table('pres_actividades_req_ante')
                ->where('id_actividades_req_ante', $id_actividades_req_ante)
                ->update(['id_estado_justificacion' => 2,
                    'justificacion_pdf' => $name
                ]);
            return back();
        }
    }
        public function guardar_bien(Request $request,$id_actividades_req_ante){

            $fecha_actual = date('d-m-Y');
            $this->validate($request, [
                'id_act_req_ante' => 'required',
                'bien_servicio' => 'required',
                'unidad_medida' => 'required',
                'cantidad' => 'required',
                'precio' => 'required',
            ]);
            $id_act_req_ante = $request->input('id_act_req_ante');
            $bien_servicio = $request->input('bien_servicio');
            $unidad_medida = $request->input('unidad_medida');
            $cantidad = $request->input('cantidad');
            $precio = $request->input('precio');
             $importe=$precio*$cantidad;
            DB:: table('pres_reg_material_req_ante')->insert([
                'id_actividades_req_ante' => $id_act_req_ante,
                'descripcion' => $bien_servicio,
                'unidad_medida' => $unidad_medida,
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'importe' => $importe,
                'fecha_registro' => $fecha_actual,
            ]);
            return back();

    }
    public function modificar_servicio($id_reg_material_ant){
       $servicio=DB::selectOne('SELECT * FROM `pres_reg_material_req_ante` WHERE `id_reg_material_ant` ='.$id_reg_material_ant.'');
       return view('departamento_finanzas.jefe_departamento.partials_mod_servicio',compact('servicio'));
    }
    public function guardar_mod_bien(Request $request,$id_reg_material_ant){
        $fecha_actual = date('d-m-Y');
        $this->validate($request, [
            'bien_servicio_mod' => 'required',
            'unidad_medida_mod' => 'required',
            'cantidad_mod' => 'required',
            'precio_mod' => 'required',
        ]);

        $bien_servicio = $request->input('bien_servicio_mod');
        $unidad_medida = $request->input('unidad_medida_mod');
        $cantidad = $request->input('cantidad_mod');
        $precio = $request->input('precio_mod');
        $importe=$precio*$cantidad;

        DB::table('pres_reg_material_req_ante')
            ->where('id_reg_material_ant', $id_reg_material_ant)
            ->update([
                'descripcion' => $bien_servicio,
                'unidad_medida' => $unidad_medida,
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'importe' => $importe,
                'fecha_modificacion' => $fecha_actual,
            ]);
        return back();
    }
    public function eliminar_servicio($id_reg_material_ant){
        $servicio=DB::selectOne('SELECT * FROM `pres_reg_material_req_ante` WHERE `id_reg_material_ant` ='.$id_reg_material_ant.'');
        return view('departamento_finanzas.jefe_departamento.partial_eliminar_servicio',compact('servicio'));
    }
    public function guardar_eliminar_bien(Request $request,$id_reg_material_ant){

        DB::table('pres_reg_material_req_ante')->
        where('id_reg_material_ant', $id_reg_material_ant)->delete();
        return back();
    }
    public function enviar_requisiciones(Request $request){
        $fecha_actual = date('d-m-Y');
        $this->validate($request, [
            'id_req_mat_ante' => 'required',
        ]);
        $id_req_mat_ante = $request->input('id_req_mat_ante');

        $requisiciones=DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` = '.$id_req_mat_ante.'');
        $year=$requisiciones->year_requisicion;


        //// jefe de direccion
        $jefe_finanzas=DB::selectOne('SELECT gnral_unidad_administrativa.nom_departamento, gnral_unidad_personal.id_unidad_persona, 
        gnral_unidad_personal.id_personal, gnral_unidad_personal.id_unidad_admin, gnral_personales.nombre,gnral_personales.correo, abreviaciones.titulo 
        from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones 
        where gnral_unidad_administrativa.id_unidad_admin = 22 and gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin
        and gnral_unidad_personal.id_personal = gnral_personales.id_personal and abreviaciones_prof.id_personal = gnral_personales.id_personal 
          and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        /// ...............................////

        $nombre_jefe_finan=$jefe_finanzas->titulo." ".$jefe_finanzas->nombre;
        $correo_jefe_finan=$jefe_finanzas->correo;
        ///
        //// jefe de departamento
        $jefe_departamento=DB::selectOne('SELECT gnral_unidad_administrativa.nom_departamento, gnral_unidad_personal.id_unidad_persona, 
        gnral_unidad_personal.id_personal, gnral_unidad_personal.id_unidad_admin, gnral_personales.nombre,gnral_personales.correo, abreviaciones.titulo 
        from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones 
        where gnral_unidad_administrativa.id_unidad_admin = '.$requisiciones->id_unidad_admin.' and gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin
        and gnral_unidad_personal.id_personal = gnral_personales.id_personal and abreviaciones_prof.id_personal = gnral_personales.id_personal 
          and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        /// ...............................////
        $nombre_jefe_dep=$jefe_departamento->titulo." ".$jefe_departamento->nombre;
        $correo_jefe_dep=$jefe_departamento->correo;

        ///
        Mail::send('departamento_finanzas.jefe_departamento.notificacion_envio_requsiciones',["nombre_jefe_dep"=>$nombre_jefe_dep,"correo_jefe_dep"=>$correo_jefe_dep,"year"=>$year], function($message)use($nombre_jefe_dep,$correo_jefe_dep,$correo_jefe_finan,$year)
        {
            $message->from(Auth::user()->email, 'Jefe(a) de división o de departamento: '.$nombre_jefe_dep);
            $message->to($correo_jefe_finan,"")->subject('Notificación de envió de requisiciones del anteproyecto');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });

        DB::table('pres_req_mat_ante')
            ->where('id_req_mat_ante', $id_req_mat_ante)
            ->update([
                'id_estado_requisicion' =>1,
                'fecha_envio'=>$fecha_actual,
            ]);

        return redirect('/presupuesto_anteproyecto/registrar_requerimientos_anteproyecto');
    }
    public  function modificar_requisicones($id_req_mat_ante){
        $datos_req_envio = DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` = ' . $id_req_mat_ante . '');
        $meses = DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC ');
        $proyectos = DB::select('SELECT * FROM `pres_proyectos` ORDER BY `pres_proyectos`.`nombre_proyecto` ASC ');
        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_req_mat_ante  = '.$id_req_mat_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');
        $partidas_presupuestales=DB::select('SELECT * FROM `pres_partida_pres` ORDER BY `pres_partida_pres`.`clave_presupuestal` ASC');
//dd($partidas_presupuestales);

        $requisiciones2=array();
        $estado_material=false;
        $estado_documentacion=false;
        $contar_req=0;
        foreach ($requisiciones as $requisicion){
            $contar_req++;
            $req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
            $req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
            $req['id_partida_pres']=$requisicion->id_partida_pres;
            $req['nombre_partida']=$requisicion->clave_presupuestal.' '.$requisicion->nombre_partida;
            $req['id_mes']=$requisicion->id_mes;
            $req['justificacion']=$requisicion->justificacion;
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
            if($requisicion->requisicion_pdf == ''){
                $estado_documentacion=true;
            }
            if($requisicion->anexo_1_pdf == ''){

            }
            if($requisicion->oficio_suficiencia_presupuestal_pdf == ''){

            }
            if($requisicion->id_estado_justificacion ==  0){
                $estado_documentacion=true;
            }
            if($requisicion->cotizacion_pdf == ''){
                $estado_documentacion=true;
            }
            $req['fecha_reg']=$requisicion->fecha_reg;
            $req['fecha_mod']=$requisicion->fecha_mod;
            $req['mes']=$requisicion->mes;
            $req['nombre_proyecto']=$requisicion->nombre_proyecto;
            $req['meta']=$requisicion->meta;
            $bienes=array();
            $total_req=0;
            $bienes_servicios=DB::select('SELECT * FROM `pres_reg_material_req_ante` 
             WHERE `id_actividades_req_ante` = '.$requisicion->id_actividades_req_ante.'');

            $contar=DB::selectOne('SELECT count(id_reg_material_ant) contar from pres_reg_material_req_ante
            where id_actividades_req_ante =  '.$requisicion->id_actividades_req_ante.' ');
            if($contar->contar == 0){
                $estado_material=true;
            }

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
            $req['total_importe']=$total_req;
            array_push($requisiciones2, $req);
        }


        return view('departamento_finanzas.jefe_departamento.modificaciones_requisiciones', compact('contar_req','estado_documentacion','estado_material','datos_req_envio', 'meses', 'proyectos', 'requisiciones2','partidas_presupuestales','total_req','id_req_mat_ante'));

    }
    public function modificar_bienes_servicios_anteproyecto($id_actividades_req_ante){
        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante='.$id_actividades_req_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');

        $requisiciones2=array();
        $total_req=0;
        $id_autorizacion=0;

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
            $id_autorizacion=$requisicion->id_autorizacion;
            $req['comentario']=$requisicion->comentario;
            $req['requisicion_pdf']=$requisicion->requisicion_pdf;
            $req['anexo_1_pdf']=$requisicion->anexo_1_pdf;
            $req['oficio_suficiencia_presupuestal_pdf']=$requisicion->oficio_suficiencia_presupuestal_pdf;
            $req['id_estado_justificacion']=$requisicion->id_estado_justificacion;
            $req['justificacion_pdf']=$requisicion->justificacion_pdf;
            $req['fecha_reg']=$requisicion->fecha_reg;
            $req['fecha_mod']=$requisicion->fecha_mod;
            $req['mes']=$requisicion->mes;
            $req['nombre_proyecto']=$requisicion->nombre_proyecto;
            $req['meta']=$requisicion->meta;
            $req['cotizacion_pdf']=$requisicion->cotizacion_pdf;
            $bienes=array();
            $total_req=0;
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
        and pres_actividades_req_ante.id_actividades_req_ante ='.$id_actividades_req_ante.'');


        return view('departamento_finanzas.jefe_departamento.modificaciones_material_documentos', compact( 'id_autorizacion','requisiciones2','datos_req_envio','total_req','id_actividades_req_ante'));

    }
    public function enviar_modificaciones_requisiciones(Request $request){
        $fecha_actual = date('d-m-Y');
        $this->validate($request, [
            'id_req_mat_ante' => 'required',
        ]);

        $id_req_mat_ante = $request->input('id_req_mat_ante');

        $requisiciones=DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` = '.$id_req_mat_ante.'');
        $year=$requisiciones->year_requisicion;


        //// jefe de direccion
        $jefe_finanzas=DB::selectOne('SELECT gnral_unidad_administrativa.nom_departamento, gnral_unidad_personal.id_unidad_persona, 
        gnral_unidad_personal.id_personal, gnral_unidad_personal.id_unidad_admin, gnral_personales.nombre,gnral_personales.correo, abreviaciones.titulo 
        from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones 
        where gnral_unidad_administrativa.id_unidad_admin = 22 and gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin
        and gnral_unidad_personal.id_personal = gnral_personales.id_personal and abreviaciones_prof.id_personal = gnral_personales.id_personal 
          and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        /// ...............................////

        $nombre_jefe_finan=$jefe_finanzas->titulo." ".$jefe_finanzas->nombre;
        $correo_jefe_finan=$jefe_finanzas->correo;
        ///
        //// jefe de departamento
        $jefe_departamento=DB::selectOne('SELECT gnral_unidad_administrativa.nom_departamento, gnral_unidad_personal.id_unidad_persona, 
        gnral_unidad_personal.id_personal, gnral_unidad_personal.id_unidad_admin, gnral_personales.nombre,gnral_personales.correo, abreviaciones.titulo 
        from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones 
        where gnral_unidad_administrativa.id_unidad_admin = '.$requisiciones->id_unidad_admin.' and gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin
        and gnral_unidad_personal.id_personal = gnral_personales.id_personal and abreviaciones_prof.id_personal = gnral_personales.id_personal 
          and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        /// ...............................////
        $nombre_jefe_dep=$jefe_departamento->titulo." ".$jefe_departamento->nombre;
        $correo_jefe_dep=$jefe_departamento->correo;

        ///
        Mail::send('departamento_finanzas.jefe_departamento.notificacion_envio_correcciones_req',["nombre_jefe_dep"=>$nombre_jefe_dep,"correo_jefe_dep"=>$correo_jefe_dep,"year"=>$year], function($message)use($nombre_jefe_dep,$correo_jefe_dep,$correo_jefe_finan,$year)
        {
            $message->from(Auth::user()->email, 'Jefe(a) de división o de departamento: '.$nombre_jefe_dep);
            $message->to($correo_jefe_finan,"")->subject('Notificación de envió de correcciones  de las requisiciones del anteproyecto');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });

        $actividades=DB::select('SELECT *from pres_actividades_req_ante WHERE id_req_mat_ante= '.$id_req_mat_ante.' and id_autorizacion = 2');
        foreach ($actividades as $actividad){
            DB::table('pres_actividades_req_ante')
                ->where('id_actividades_req_ante', $actividad->id_actividades_req_ante)
                ->update([
                    'id_autorizacion' =>0,
                ]);
        }
        DB::table('pres_req_mat_ante')
            ->where('id_req_mat_ante', $id_req_mat_ante)
            ->update([
                'id_estado_requisicion' =>3,
                'fecha_envio'=>$fecha_actual,
            ]);
        return redirect('/presupuesto_anteproyecto/registrar_requerimientos_anteproyecto');
    }
    public function agregar_cotizacion_pdf($id_actividades_req_ante){
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        return view('departamento_finanzas.jefe_departamento.partials_cotizacion', compact('requisicion'));

    }
    public  function guardar_cotizacion_pdf(Request $request,$id_actividades_req_ante)
    {
        $file = $request->file('cotizacion_pdf');

        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        //dd($requisicion);

        $name = "cotizacion_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/cotizaciones/',$name);

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update(['cotizacion_pdf' => $name]);
        return back();
    }
    public function modificar_cotizacion_pdf($id_actividades_req_ante){
        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');
//dd($requisicion);
        return view('departamento_finanzas.jefe_departamento.partials_mod_cotizacion', compact('requisicion'));

    }
    public function guardar_mod_cotizacion_pdf(Request $request,$id_actividades_req_ante){

        $file = $request->file('mod_cotizacion_pdf');

        $requisicion = DB::selectOne('SELECT pres_actividades_req_ante.*,pres_mes.mes,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal,
       pres_proyectos.nombre_proyecto, pres_metas.meta from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,
       pres_partida_pres
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and 
       pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_partida_pres.id_partida_pres = pres_actividades_req_ante.id_partida_pres
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante =' . $id_actividades_req_ante . '');

        //dd($requisicion);

        $name = "cotizacion_" . $requisicion->id_actividades_req_ante . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/cotizaciones/', $name);

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_actividades_req_ante)
            ->update(['cotizacion_pdf' => $name]);
        return back();
    }
}
