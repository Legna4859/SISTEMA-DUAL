<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;
class Pres_aut_revisionController extends Controller
{
    public function revisar_solicitudes(){
        $year= date('Y');

        $solicitudes = DB::select('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,abreviaciones.titulo, gnral_personales.nombre nombre_personal,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.year_presupuesto = '.$year.' 
        and pres_aut_solicitudes.id_estado_enviado = 2 
        and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin AND
        gnral_unidad_personal.id_personal = gnral_personales.id_personal and 
        gnral_personales.id_personal = abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
        order by pres_aut_solicitudes.fecha_enviado desc');



        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.revisar_solicitudes',compact('solicitudes'));

    }
    public function revisar_documentacion_solicitud($id_solicitud){
        $solicitud=DB::selectOne('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.id_solicitud = '.$id_solicitud.'');

        $partidas=DB::select('SELECT pres_aut_solicitudes_partidas.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
           from pres_aut_solicitudes_partidas, pres_partida_pres WHERE pres_aut_solicitudes_partidas.id_partida_pres = pres_partida_pres.id_partida_pres 
           and pres_aut_solicitudes_partidas.id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=DB::selectOne('SELECT COUNT(id_solicitud) contar from pres_aut_solicitudes_documentos WHERE id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=$estado_solicitud->contar;
        if($estado_solicitud == 0){
            $estado_solicitud =0;
            $documentos=0;
        }else{
            $estado_solicitud=1;
            $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud` ='.$id_solicitud.'');
        }
        //dd($partidas);
        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.revision_documentacion_solicitud',compact('estado_solicitud','solicitud','documentos','partidas','id_solicitud'));
    }
    public function enviar_modificaciones_departamento(Request $request, $id_solicitud){
        $comentario = $request->input('comentario');
        $fecha_actual = date('d-m-Y');

        DB::table('pres_aut_solicitudes')
            ->where('id_solicitud', $id_solicitud)
            ->update([
                'comentario_solicitud' => $comentario,
                'id_Estado_enviado' => 3,
                'fecha_enviado' => $fecha_actual
            ]);
          return redirect('/presupuesto_autorizado/revisar_solicitudes');
    }
    public function proceso_mod_solicitudes(){
        $year= date('Y');

        $solicitudes = DB::select('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,abreviaciones.titulo, gnral_personales.nombre nombre_personal,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.year_presupuesto = '.$year.' 
        and pres_aut_solicitudes.id_estado_enviado = 3 
        and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin AND
        gnral_unidad_personal.id_personal = gnral_personales.id_personal and 
        gnral_personales.id_personal = abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
        order by pres_aut_solicitudes.fecha_enviado desc');



        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.proceso_modificar_solicitudes',compact('solicitudes'));

    }
    public function solicitudes_autorizadas_departamentos(){
        $year= date('Y');
       $departamentos=DB::select('SELECT gnral_unidad_administrativa.id_unidad_admin,gnral_unidad_administrativa.nom_departamento,abreviaciones.titulo, gnral_personales.nombre nombre_personal from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.year_presupuesto = '.$year.'
        and pres_aut_solicitudes.id_estado_enviado = 4 
        and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin AND
        gnral_unidad_personal.id_personal = gnral_personales.id_personal and 
        gnral_personales.id_personal = abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion GROUP by gnral_unidad_administrativa.id_unidad_admin
        order by gnral_unidad_administrativa.id_unidad_admin asc');


        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.inicio_departamento_solicitudes_aut',compact('departamentos'));

    }
    public function solicitudes_ver_departamento($id_unidad_admin){
        $year= date('Y');

        $solicitudes = DB::select('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,abreviaciones.titulo, gnral_personales.nombre nombre_personal,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.year_presupuesto = '.$year.' 
        and pres_aut_solicitudes.id_estado_enviado = 4 
        and gnral_unidad_administrativa.id_unidad_admin ='.$id_unidad_admin.'
        and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin AND
        gnral_unidad_personal.id_personal = gnral_personales.id_personal and 
        gnral_personales.id_personal = abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
        order by pres_aut_solicitudes.id_mes asc');

        $departamento=DB::selectOne('SELECT gnral_unidad_administrativa.*, gnral_personales.nombre, abreviaciones.titulo
        from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones 
        WHERE gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin and 
              gnral_unidad_personal.id_personal = gnral_personales.id_personal and gnral_personales.id_personal = abreviaciones_prof.id_personal 
          and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion and gnral_unidad_administrativa.id_unidad_admin ='.$id_unidad_admin.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.ver_solicitudes_departamento',compact('solicitudes','departamento'));

    }
    public function solicitudes_autorizadas_departamentos12(){
        $year= date('Y');

        $solicitudes = DB::select('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,abreviaciones.titulo, gnral_personales.nombre nombre_personal,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.year_presupuesto = '.$year.' 
        and pres_aut_solicitudes.id_estado_enviado = 4 
        and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin AND
        gnral_unidad_personal.id_personal = gnral_personales.id_personal and 
        gnral_personales.id_personal = abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
        order by pres_aut_solicitudes.id_mes asc');
        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.solicitudes_autorizadas',compact('solicitudes'));

    }
    public function modificar_servicio_solicitud($id_material_partida){

        $servicio=DB::selectOne('SELECT * FROM `pres_aut_materiales_partidas` WHERE `id_material_partida` ='.$id_material_partida.'');

        $partida_solicitud=DB::selectOne('SELECT pres_aut_solicitudes_partidas.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal
        from pres_aut_solicitudes_partidas, pres_partida_pres where pres_aut_solicitudes_partidas.id_partida_pres = pres_partida_pres.id_partida_pres 
        and pres_aut_solicitudes_partidas.id_solicitud_partida ='.$servicio->id_solicitud_partida.'');

        $total_partida=DB::selectOne('SELECT SUM(pres_aut_materiales_partidas.importe) total_partida 
        from pres_aut_materiales_partidas where id_solicitud_partida='.$servicio->id_solicitud_partida.'');


        if($total_partida->total_partida == null){

            $total_part=0;
        }else{

            $total_part=$total_partida->total_partida-$servicio->importe;
        }
        $resto_presupuesto=$partida_solicitud->presupuesto_dado-$total_part;
        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partial_modificar_servicio',compact('servicio','id_material_partida','resto_presupuesto','id_material_partida'));


    }
    public function guardar_mod_material_solicitud(Request $request, $id_material_partida){
        $bien_servicio = $request->input('bien_servicio');
        $unidad_medida = $request->input('unidad_medida');
        $cantidad = $request->input('cantidad');
        $precio = $request->input('precio');
        $fecha_actual = date('d-m-Y');

        $importe= $cantidad * $precio;

        DB::table('pres_aut_materiales_partidas')
            ->where('id_material_partida', $id_material_partida)
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
    public function eliminar_material_solicitud(Request $request){
        $id_material_part = $request->input('id_material_part');

        DB::delete('DELETE FROM pres_aut_materiales_partidas WHERE id_material_partida='.$id_material_part.'');

        return back();
    }
    public function enviar_autorizacion_departamento(Request $request, $id_solicitud){
        $fecha_actual = date('d-m-Y');

        DB::table('pres_aut_solicitudes')
            ->where('id_solicitud', $id_solicitud)
            ->update([
                'id_Estado_enviado' => 4,
                'fecha_enviado' => $fecha_actual
            ]);
        return redirect('/presupuesto_autorizado/revisar_solicitudes');
    }
    public function mostrar_documentacion_solicitud($id_solicitud){
        $solicitud=DB::selectOne('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.id_solicitud = '.$id_solicitud.'');

       $departamento=DB::selectOne('SELECT gnral_unidad_administrativa.*, gnral_personales.nombre, abreviaciones.titulo 
       from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones WHERE
        gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin and gnral_unidad_personal.id_personal = gnral_personales.id_personal 
       and gnral_personales.id_personal = abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion 
       and gnral_unidad_administrativa.id_unidad_admin ='.$solicitud->id_unidad_admin.'');

        $partidas=DB::select('SELECT pres_aut_solicitudes_partidas.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
           from pres_aut_solicitudes_partidas, pres_partida_pres WHERE pres_aut_solicitudes_partidas.id_partida_pres = pres_partida_pres.id_partida_pres 
           and pres_aut_solicitudes_partidas.id_solicitud ='.$id_solicitud.'');

        $estado_solicitud=DB::selectOne('SELECT COUNT(id_solicitud) contar from pres_aut_solicitudes_documentos WHERE id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=$estado_solicitud->contar;
        if($estado_solicitud == 0){
            $estado_solicitud =0;
            $documentos=0;
        }else{
            $estado_solicitud=1;
            $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud` ='.$id_solicitud.'');




        }
       // dd($documentos);
        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.mostrar_documentacion_solicitud',compact('estado_solicitud','solicitud','documentos','partidas','id_solicitud','departamento'));

    }
    public function agregar_contrato_solicitud($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        $tipos_contratos= DB::select('SELECT * FROM `pres_aut_tipo_contrato`');
        //dd($tipos_contratos);
        $estado_contrato=1; // agregar  contrato

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partial_agregar_contrato',compact('documentos','tipos_contratos','estado_contrato'));

    }
    public function guardar_contrato(Request $request,$id_solicitud_documento){
        $id_tipo_contrato = $request->input('id_tipo_contrato');
        $file = $request->file('doc_contrato');

        $name = "contrato_" . $id_solicitud_documento. "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/contrato_pres_aut/',$name);

        DB::table('pres_aut_solicitudes_documentos')
            ->where('id_solicitud_documento', $id_solicitud_documento)
            ->update([
                'id_tipo_contrato' => $id_tipo_contrato,
                'pdf_tipo_contrato' => $name]);

        return back();
    }
    public function modificar_contrato_solicitud($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        $tipos_contratos= DB::select('SELECT * FROM `pres_aut_tipo_contrato`');
        //dd($tipos_contratos);
        $estado_contrato=2; // modificar  contrato
        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partial_modificar_contrato',compact('documentos','tipos_contratos','estado_contrato'));

    }
    public function agregar_factura_solicitud($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partial_agregar_factura',compact('documentos'));

    }
    public function agregar_solicitud_pago($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partials_agregar_solicitud_pago',compact('documentos'));

    }
    public function guardar_solicitud_pago(Request $request,$id_solicitud_documento){
        $file = $request->file('doc_solicitud_pago');

        $name = "solicitud_pago_" . $id_solicitud_documento. "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/solicitud_pago_pres_aut/',$name);

        DB::table('pres_aut_solicitudes_documentos')
            ->where('id_solicitud_documento', $id_solicitud_documento)
            ->update([
                'pdf_solicitud_pago' => $name]);

        return back();

    }
    public function modificar_solicitud_pago($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partials_modificar_solicitud_pago',compact('documentos'));

    }
    public function guardar_factura(Request $request,$id_solicitud_documento){
        $file = $request->file('doc_factura');

        $name = "factura_" . $id_solicitud_documento. "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/factura_pres_aut/',$name);

        DB::table('pres_aut_solicitudes_documentos')
            ->where('id_solicitud_documento', $id_solicitud_documento)
            ->update([
                'pdf_factura_comprado' => $name]);

        return back();
    }
    public function modificar_factura_solicitud($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partial_mod_factura',compact('documentos'));

    }
    public function agregar_pago_solicitud($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partial_agregar_pago',compact('documentos'));

    }
    public function guardar_pago(Request $request,$id_solicitud_documento){
        $file = $request->file('doc_pago');

        $name = "pago_" . $id_solicitud_documento. "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/finanzas/pago_pres_aut/',$name);

        DB::table('pres_aut_solicitudes_documentos')
            ->where('id_solicitud_documento', $id_solicitud_documento)
            ->update([
                'pdf_pago_material_comprado' => $name]);

        return back();

    }
    public function modificar_pago_solicitud($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partial_mod_pago',compact('documentos'));

    }
    public function agregar_oficio_solicitud($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partial_agregar_oficio',compact('documentos'));

    }
    public function guardar_oficio(Request $request,$id_solicitud_documento){
        $file = $request->file('doc_oficio');

        $name = "oficio_" . $id_solicitud_documento. "." . $file->getClientOriginalExtension();
        $file->move(public_path() .'/finanzas/oficio_pres_aut/',$name);

        DB::table('pres_aut_solicitudes_documentos')
            ->where('id_solicitud_documento', $id_solicitud_documento)
            ->update([
                'pdf_oficio_entrega' => $name]);

        return back();
    }
    public function modificar_oficio_solicitud($id_solicitud_documento){
        $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.revision_solicitudes.partial_mod_oficio',compact('documentos'));

    }
    public function solicitudes_aut_departamento()
    {
        $year = date('Y');
        $id_unidad = Session::get('id_unidad_admin');

        $solicitudes = DB::select('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.id_unidad_admin = '.$id_unidad.' and pres_aut_solicitudes.year_presupuesto = '.$year.' 
        and pres_aut_solicitudes.id_estado_enviado=4 
        order by pres_aut_solicitudes.id_mes asc');



        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.ver_solicitudes_dep_aceptadas', compact('solicitudes'));

    }
    public function ver_docu_solicitud_aut_departamento($id_solicitud){
        $solicitud=DB::selectOne('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.id_solicitud = '.$id_solicitud.'');

        $partidas=DB::select('SELECT pres_aut_solicitudes_partidas.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
           from pres_aut_solicitudes_partidas, pres_partida_pres WHERE pres_aut_solicitudes_partidas.id_partida_pres = pres_partida_pres.id_partida_pres 
           and pres_aut_solicitudes_partidas.id_solicitud ='.$id_solicitud.'');


        $estado_solicitud=DB::selectOne('SELECT COUNT(id_solicitud) contar from pres_aut_solicitudes_documentos WHERE id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=$estado_solicitud->contar;

        if($estado_solicitud == 0){
            $estado_solicitud =0;
            $documentos=0;
        }else{
            $estado_solicitud=1;
            $documentos= DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud` ='.$id_solicitud.'');
        }
        //dd($array_partidas);
        //dd($documentos);
        // dd($solicitud);
        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.mostrar_documento_autorizado', compact('estado_solicitud','solicitud','documentos','partidas','id_solicitud'));

    }
    public function modificar_mes_requisicion($id_presupuesto_aut_copia,$id_mes){

        $requisicion=DB::selectOne('SELECT pres_aut_presupuesto_aut_copia.*,pres_partida_pres.nombre_partida,pres_partida_pres.clave_presupuestal 
        from pres_aut_presupuesto_aut_copia, pres_partida_pres where pres_aut_presupuesto_aut_copia.id_partida = pres_partida_pres.id_partida_pres
        and pres_aut_presupuesto_aut_copia.id_presupuesto_aut_copia ='.$id_presupuesto_aut_copia.'');
       //dd($requisicion);
        $id_partida=$requisicion->id_partida;
        $year_presupuesto=$requisicion->year_presupuesto;

        if($id_mes == 1){
            $nombre_mes="enero";
            $presupuesto_mes= $requisicion->enero_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =1');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 2){
            $nombre_mes="febrero";
            $presupuesto_mes= $requisicion->febrero_pres;
            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =2');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;

        }
        if($id_mes == 3){
            $nombre_mes="marzo";
            $presupuesto_mes= $requisicion->marzo_pres;
            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =3');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 4){
            $nombre_mes="abril";
            $presupuesto_mes= $requisicion->abril_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =4');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 5){
            $nombre_mes="mayo";
            $presupuesto_mes= $requisicion->mayo_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =5');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 6){
            $nombre_mes="junio";
            $presupuesto_mes= $requisicion->junio_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =6');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 7){
            $nombre_mes="julio";
            $presupuesto_mes= $requisicion->julio_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =7');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 8){
            $nombre_mes="agosto";
            $presupuesto_mes= $requisicion->agosto_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =8');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 9){
            $nombre_mes="septiembre";
            $presupuesto_mes= $requisicion->septiembre_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =9');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 10){
            $nombre_mes="octubre";
            $presupuesto_mes= $requisicion->octubre_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =10');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 11){
            $nombre_mes="noviembre";
            $presupuesto_mes= $requisicion->noviembre_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =11');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        if($id_mes == 12){
            $nombre_mes="diciembre";
            $presupuesto_mes= $requisicion->diciembre_pres;

            $soli_mes=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$year_presupuesto.' and pres_aut_solicitudes.id_mes =12');

            if($soli_mes == null){
                $suma_soli=0;
            }else{
                $suma_soli=0;
                foreach ($soli_mes as $soli_mes){
                    $suma_soli=$suma_soli+$soli_mes->presupuesto_dado;
                }
            }
            $presupuesto_sobrante=$presupuesto_mes-$suma_soli;
        }
        //dd($presupuesto_sobrante);
        $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC');
//dd($requisicion);
        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.partials_modificar_presupuesto_autorizar', compact('nombre_mes','presupuesto_sobrante','id_presupuesto_aut_copia','id_mes','requisicion','meses'));

    }
    public function guardar_mod_partida_mes_presupuesto(Request $request,$id_presupuesto_aut_copia,$id_mes){

        $dato_presupuesto=DB::selectOne('SELECT * FROM `pres_aut_presupuesto_aut_copia` WHERE `id_presupuesto_aut_copia` ='.$id_presupuesto_aut_copia.' ');

        $id_partida=$dato_presupuesto->id_partida;


        $presupuesto_sobrante = $request->input('presupuesto_sobrante');
        $id_mes_dado = $request->input('id_mes');
        $presupuesto_dado = $request->input('presupuesto_dado');
        $fecha_actual = date('d-m-Y');
        DB:: table('pres_aut_mes_pres_cambio')->insert([
            'id_presupuesto_aut_copia' => $id_presupuesto_aut_copia,
            'id_partida' => $id_partida,
            'id_mes' => $id_mes,
            'cambio_presupuesto' => $presupuesto_dado,
            'id_mes_cambio' => $id_mes_dado,
            'fecha_registro' => $fecha_actual,
        ]);

        ///restado del mes que se hagarra el presupuesto
        if($id_mes == 1){
            //enero
            $presupuesto_mes=$dato_presupuesto->enero_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'enero_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                    ]);

        }elseif($id_mes == 2){
            //febrero
            $presupuesto_mes=$dato_presupuesto->febrero_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'febrero_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 3){
            //marzo
            $presupuesto_mes=$dato_presupuesto->marzo_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'marzo_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 4){
            //abril
            $presupuesto_mes=$dato_presupuesto->abril_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'abril_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 5){
            //mayo
            $presupuesto_mes=$dato_presupuesto->mayo_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'mayo_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 6){
            //junio
            $presupuesto_mes=$dato_presupuesto->junio_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'junio_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 7){
            //julio
            $presupuesto_mes=$dato_presupuesto->julio_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'julio_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 8){
            //agosto
            $presupuesto_mes=$dato_presupuesto->agosto_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'agosto_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 9){
            //septiembre
            $presupuesto_mes=$dato_presupuesto->septiembre_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'septiembre_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 10){
            //octubre
            $presupuesto_mes=$dato_presupuesto->octubre_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'octubre_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 11){
            //noviembre
            $presupuesto_mes=$dato_presupuesto->noviembre_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'noviembre_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes == 12){
            //diciembre
            $presupuesto_mes=$dato_presupuesto->diciembre_pres-$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'diciembre_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }

        ///sumando en el mes que se va a dar el presupuesto
        if($id_mes_dado == 1){
            //enero
            $presupuesto_mes=$dato_presupuesto->enero_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'enero_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);

        }elseif($id_mes_dado == 2){
            //febrero
            $presupuesto_mes=$dato_presupuesto->febrero_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'febrero_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 3){
            //marzo
            $presupuesto_mes=$dato_presupuesto->marzo_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'marzo_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 4){
            //abril
            $presupuesto_mes=$dato_presupuesto->abril_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'abril_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 5){
            //mayo
            $presupuesto_mes=$dato_presupuesto->mayo_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'mayo_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 6){
            //junio
            $presupuesto_mes=$dato_presupuesto->junio_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'junio_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 7){
            //julio
            $presupuesto_mes=$dato_presupuesto->julio_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'julio_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 8){
            //agosto
            $presupuesto_mes=$dato_presupuesto->agosto_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'agosto_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 9){
            //septiembre
            $presupuesto_mes=$dato_presupuesto->septiembre_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'septiembre_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 10){
            //octubre
            $presupuesto_mes=$dato_presupuesto->octubre_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'octubre_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 11){
            //noviembre
            $presupuesto_mes=$dato_presupuesto->noviembre_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'noviembre_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        elseif($id_mes_dado == 12){
            //diciembre
            $presupuesto_mes=$dato_presupuesto->diciembre_pres+$presupuesto_dado;

            DB::table('pres_aut_presupuesto_aut_copia')
                ->where('id_presupuesto_aut_copia', $id_presupuesto_aut_copia)
                ->update([
                    'diciembre_pres' =>$presupuesto_mes,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }
        return back();
    }
}
