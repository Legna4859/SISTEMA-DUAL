<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;
class Pres_aut_req_solicitudes_autController extends Controller
{
    public function index(){
        $year = date('Y');
        $id_unidad = Session::get('id_unidad_admin');

        $solicitudes = DB::select('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.id_unidad_admin = '.$id_unidad.' and pres_aut_solicitudes.year_presupuesto = '.$year.' 
        and pres_aut_solicitudes.id_estado_enviado in(1,2,3) 
        order by pres_aut_solicitudes.id_mes asc');



        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.solicitudes_departamento', compact('solicitudes'));


    }
    public function registrar_documentacion_solicitud($id_solicitud)
    {
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




            $array_partidas=array();
           /*foreach ($partidas as $partida)
           {
               $part['id_solicitud_partida'] = $partida->id_solicitud_partida;
               $part['id_partida_pres'] = $partida->id_partida_pres;
               $part['presupuesto_dado'] = $partida->presupuesto_dado;
               $part['importe_total'] = $partida->importe_total;
               $part['id_tipo_requisicion'] = $partida->id_tipo_requisicion;
               $part['nombre_partida'] = $partida->nombre_partida;
               $part['clave_presupuestal'] = $partida->clave_presupuestal;

               $array_materiales=array();

               $materiales=DB::select('SELECT * FROM `pres_aut_materiales_partidas` WHERE `id_solicitud_partida` ='.$partida->id_solicitud_partida.'');

               $total_partida=0;
               foreach($materiales as $material) {
               $mat['id_material_partida'] = $material->id_material_partida;
               $mat['descripcion']=$material->descripcion;
               $mat['unidad_medida']= $material->unidad_medida;
               $mat['cantidad']= $material->cantidad;
               $mat['precio_unitario']=$material->precio_unitario;
               $mat['importe'] = $material->importe;
               $total_partida=$total_partida+$material->importe;
               array_push($array_materiales,$mat);
               }
               if($total_partida <= $partida->presupuesto_dado){
                   $estado_presupuesto = 1;
               }else{
                   $estado_presupuesto = 2;
               }
               $part['materiales'] = $array_materiales;
               $part['estado_presupuesto'] = $estado_presupuesto;
               $part['total_partida'] = $total_partida;
               array_push($array_partidas,$part);
           }
*/
       }
       //dd($array_partidas);
        //dd($documentos);
       // dd($solicitud);
        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.registro_solicitud_documentos', compact('estado_solicitud','solicitud','documentos','id_solicitud','partidas'));

    }
    public function registrar_requisicion($id_solicitud){
        $estado_solicitud=DB::selectOne('SELECT COUNT(id_solicitud) contar from pres_aut_solicitudes_documentos WHERE id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=$estado_solicitud->contar;
        if($estado_solicitud == 0){
            $estado_solicitud =0;
        }else{
            $estado_solicitud=1;
        }
        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_agregar_requisicion', compact('estado_solicitud','id_solicitud'));

    }
    public function guardar_requisicion(Request $request,$id_solicitud){
        $estado_solicitud = $request->input('estado_solicitud');

        if($estado_solicitud == 0){
            $file = $request->file('requisicion_pdf');
            $fecha_actual = date('d-m-Y');

            $name = "requisicion_" . $id_solicitud. "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/requisicion_pres_aut/',$name);
            DB:: table('pres_aut_solicitudes_documentos')->insert([
                'id_solicitud' => $id_solicitud,
                'requisicion_pdf' => $name,
                'fecha_registro' => $fecha_actual,
            ]);

        }else{

            $id_solicitud_documento = $request->input('id_solicitud_documento');
            if($id_solicitud_documento == null)
            {
                $file = $request->file('requisicion_pdf');
            }else{
                $file = $request->file('requisicion_mod_pdf');
            }

            $fecha_actual = date('d-m-Y');

            $name = "requisicion_" . $id_solicitud. "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/requisicion_pres_aut/',$name);
            DB::table('pres_aut_solicitudes_documentos')
                ->where('id_solicitud', $id_solicitud)
                ->update([
                    'requisicion_pdf' => $name,
                    'fecha_modificacion' => $fecha_actual
                ]);
        }

        return back();
    }
    public function registrar_agregar_anexo1($id_solicitud){
        $estado_solicitud=DB::selectOne('SELECT COUNT(id_solicitud) contar from pres_aut_solicitudes_documentos WHERE id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=$estado_solicitud->contar;
        if($estado_solicitud == 0){
            $estado_solicitud =0;
        }else{
            $estado_solicitud=1;
        }
        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_agregar_anexo_1', compact('estado_solicitud','id_solicitud'));

    }
    public function guardar_anexo1(Request $request,$id_solicitud){

        $estado_solicitud = $request->input('estado_solicitud');

        if($estado_solicitud == 0 ){
            $file = $request->file('anexo_pdf');
            $fecha_actual = date('d-m-Y');
            $name = "anexo1_" . $id_solicitud. "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/anexo1_pres_aut/',$name);

            DB:: table('pres_aut_solicitudes_documentos')->insert([
                'id_solicitud' => $id_solicitud,
                'anexo_1_pdf' => $name,
                'fecha_registro' => $fecha_actual,
            ]);

        }else{
            $id_solicitud_documento = $request->input('id_solicitud_documento');
            if($id_solicitud_documento == null){
                $file = $request->file('anexo_pdf');
            }else{
                $file = $request->file('anexo_mod_pdf');
            }

            $fecha_actual = date('d-m-Y');
            $name = "anexo1_" . $id_solicitud. "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/anexo1_pres_aut/',$name);

            DB::table('pres_aut_solicitudes_documentos')
                ->where('id_solicitud', $id_solicitud)
                ->update([
                    'anexo_1_pdf' => $name,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }

        return back();
    }
    public function registrar_oficio_suficiencia($id_solicitud){
        $estado_solicitud=DB::selectOne('SELECT COUNT(id_solicitud) contar from pres_aut_solicitudes_documentos WHERE id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=$estado_solicitud->contar;
        if($estado_solicitud == 0){
            $estado_solicitud =0;
        }else{
            $estado_solicitud=1;
        }
        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_agregar_oficio_suficiencia', compact('estado_solicitud','id_solicitud'));

    }
    public function guardar_suficiencia(Request $request,$id_solicitud){
        $estado_solicitud = $request->input('estado_solicitud');

        if($estado_solicitud == 0){
            $file = $request->file('suficiencia_pdf');
            $fecha_actual = date('d-m-Y');
            $name = "suficiencia_" . $id_solicitud. "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/suficiencia_pres_aut/',$name);
            DB:: table('pres_aut_solicitudes_documentos')->insert([
                'id_solicitud' => $id_solicitud,
                'oficio_suficiencia_presupuestal_pdf' => $name,
                'fecha_registro' => $fecha_actual,
            ]);

        }else{
            $id_solicitud_documento = $request->input('id_solicitud_documento');

            if($id_solicitud_documento == null){
                $file = $request->file('suficiencia_pdf');
            }else{
                $file = $request->file('suficiencia_mod_pdf');
            }


            $fecha_actual = date('d-m-Y');
            $name = "suficiencia_" . $id_solicitud. "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/suficiencia_pres_aut/',$name);

            DB::table('pres_aut_solicitudes_documentos')
                ->where('id_solicitud', $id_solicitud)
                ->update([
                    'oficio_suficiencia_presupuestal_pdf' => $name,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }

        return back();
    }
    public function registrar_justificacion($id_solicitud){
        $estado_solicitud=DB::selectOne('SELECT COUNT(id_solicitud) contar from pres_aut_solicitudes_documentos WHERE id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=$estado_solicitud->contar;
        if($estado_solicitud == 0){
            $estado_solicitud =0;
        }else{
            $estado_solicitud=1;
        }
        //dd($estado_solicitud);
        $respuestas = DB::select('SELECT * FROM `ti_respuesta` ');
        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_agregar_justificacion', compact('estado_solicitud','id_solicitud','respuestas'));

    }
    public function guardar_justificacion(Request $request, $id_solicitud){

        $estado_solicitud = $request->input('estado_solicitud');
        $fecha_actual = date('d-m-Y');

        if($estado_solicitud == 0){
            $justififcacion = $request->input('justififcacion');
            if($justififcacion == 1) {
                DB:: table('pres_aut_solicitudes_documentos')->insert([
                    'id_solicitud' => $id_solicitud,
                    'id_estado_justificacion' => 1,
                    'fecha_registro' => $fecha_actual,
                ]);
            }else{

                $file = $request->file('doc_justificacion');
                $name = "justificacion_doc_" . $id_solicitud. "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/finanzas/justificacion_pres_aut/', $name);

                DB:: table('pres_aut_solicitudes_documentos')->insert([
                    'id_solicitud' => $id_solicitud,
                    'id_estado_justificacion' => 2,
                    'oficio_justificacion' => $name,
                    'fecha_registro' => $fecha_actual,
                ]);
            }
        }else{
            $id_solicitud_documento = $request->input('id_solicitud_documento');
            $justififcacion = $request->input('justififcacion');
        if($id_solicitud_documento == null) {
            if ($justififcacion == 1) {
                DB::table('pres_aut_solicitudes_documentos')
                    ->where('id_solicitud', $id_solicitud)
                    ->update([
                        'id_estado_justificacion' => 1,
                        'fecha_modificacion' => $fecha_actual,
                    ]);
            } else {
                $file = $request->file('doc_justificacion');
                $name = "justificacion_doc_" . $id_solicitud . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/finanzas/justificacion_pres_aut/', $name);

                DB::table('pres_aut_solicitudes_documentos')
                    ->where('id_solicitud', $id_solicitud)
                    ->update([
                        'id_estado_justificacion' => 2,
                        'oficio_justificacion' => $name,
                        'fecha_modificacion' => $fecha_actual,
                    ]);
            }
        }else{
            if ($justififcacion == 1) {
                DB::table('pres_aut_solicitudes_documentos')
                    ->where('id_solicitud', $id_solicitud)
                    ->update([
                        'id_estado_justificacion' => 1,
                        'fecha_modificacion' => $fecha_actual,
                    ]);
            } else {
                $file = $request->file('doc_justificacion_mod');
                $name = "justificacion_doc_" . $id_solicitud . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/finanzas/justificacion_pres_aut/', $name);

                DB::table('pres_aut_solicitudes_documentos')
                    ->where('id_solicitud', $id_solicitud)
                    ->update([
                        'id_estado_justificacion' => 2,
                        'oficio_justificacion' => $name,
                        'fecha_modificacion' => $fecha_actual,
                    ]);
            }
        }
        }

        return back();

    }
    public function registrar_cotizacion($id_solicitud){
        $estado_solicitud=DB::selectOne('SELECT COUNT(id_solicitud) contar from pres_aut_solicitudes_documentos WHERE id_solicitud ='.$id_solicitud.'');
        $estado_solicitud=$estado_solicitud->contar;
        if($estado_solicitud == 0){
            $estado_solicitud =0;
        }else{
            $estado_solicitud=1;
        }

         return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_agregar_cotizacion', compact('estado_solicitud','id_solicitud'));

    }
    public function guardar_cotizacion(Request $request, $id_solicitud){

        $estado_solicitud = $request->input('estado_solicitud');



        if($estado_solicitud == 0){
            $file = $request->file('cotizacion_pdf');
            $fecha_actual = date('d-m-Y');
            $name = "cotizacion_" . $id_solicitud. "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/cotizacion_pres_aut/',$name);
            DB:: table('pres_aut_solicitudes_documentos')->insert([
                'id_solicitud' => $id_solicitud,
                'cotizacion_pdf' => $name,
                'fecha_registro' => $fecha_actual,
            ]);

        }else{
            $id_solicitud_documento = $request->input('id_solicitud_documento');

            if($id_solicitud_documento == null){
                $file = $request->file('cotizacion_pdf');
            }else{
                $file = $request->file('cotizacion_mod_pdf');
            }
            $fecha_actual = date('d-m-Y');
            $name = "cotizacion_" . $id_solicitud. "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/finanzas/cotizacion_pres_aut/',$name);



            DB::table('pres_aut_solicitudes_documentos')
                ->where('id_solicitud', $id_solicitud)
                ->update([
                    'cotizacion_pdf' => $name,
                    'fecha_modificacion' => $fecha_actual,
                ]);
        }

        return back();
    }
    public  function modificar_requisicion($id_solicitud_documento){
            $estado_solicitud=1;
            $documento=DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');
            $id_solicitud=$documento->id_solicitud;

        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_modificar_requisicion', compact('estado_solicitud','id_solicitud_documento','id_solicitud'));

    }
    public function modificar_anexo1($id_solicitud_documento){
        $estado_solicitud=1;
        $documento=DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');
        $id_solicitud=$documento->id_solicitud;

        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_modificar_anexo1', compact('estado_solicitud','id_solicitud_documento','id_solicitud'));
    }
    public function modificar_oficio_suficiencia($id_solicitud_documento){
        $estado_solicitud=1;
        $documento=DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');
        $id_solicitud=$documento->id_solicitud;

        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_modificar_suficiencia', compact('estado_solicitud','id_solicitud_documento','id_solicitud'));


    }
    public function modificar_justificacion($id_solicitud_documento){

        $estado_solicitud=1;
        $documento=DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');

        $id_solicitud=$documento->id_solicitud;
        $respuestas = DB::select('SELECT * FROM `ti_respuesta` ');

        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_modificar_justificacion', compact('estado_solicitud','id_solicitud_documento','id_solicitud','respuestas','documento'));

    }
    public function modificar_cotizacion_pdf($id_solicitud_documento){
        $estado_solicitud=1;
        $documento=DB::selectOne('SELECT * FROM `pres_aut_solicitudes_documentos` WHERE `id_solicitud_documento` ='.$id_solicitud_documento.'');
        $id_solicitud=$documento->id_solicitud;

        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_modificar_cotizacion', compact('estado_solicitud','id_solicitud_documento','id_solicitud'));
    }
    public function agregar_material_partida_solicitud($id_solicitud_partida){

        $partida_solicitud=DB::selectOne('SELECT pres_aut_solicitudes_partidas.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal
        from pres_aut_solicitudes_partidas, pres_partida_pres where pres_aut_solicitudes_partidas.id_partida_pres = pres_partida_pres.id_partida_pres 
        and pres_aut_solicitudes_partidas.id_solicitud_partida ='.$id_solicitud_partida.'');


        $total_partida=DB::selectOne('SELECT SUM(pres_aut_materiales_partidas.importe) total_partida 
        from pres_aut_materiales_partidas where id_solicitud_partida='.$id_solicitud_partida.'');

        if($total_partida->total_partida == null){

            $total_part=0;
        }else{

            $total_part=$total_partida->total_partida;
        }
       $resto_presupuesto=$partida_solicitud->presupuesto_dado-$total_part;



        return view('departamento_finanzas.jefe_departamento.solicitudes_presupuesto.partials_agregar_material_partida', compact('partida_solicitud','id_solicitud_partida','resto_presupuesto'));

    }
    public function guardar_material_partida_solicitud(Request  $request, $id_solicitud_partida){

        $bien_servicio = $request->input('bien_servicio');
        $unidad_medida = $request->input('unidad_medida');
        $cantidad = $request->input('cantidad');
        $precio=$request->input('precio');
        $importe = $cantidad * $precio;
        $fecha_actual = date('d-m-Y');

        DB:: table('pres_aut_materiales_partidas')->insert([
            'id_solicitud_partida' => $id_solicitud_partida,
            'descripcion' => $bien_servicio,
            'unidad_medida' => $unidad_medida,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'importe' => $importe,
            'fecha_registro' => $fecha_actual,
        ]);
        return back();


    }
    public function enviar_solicitud(Request $request, $id_solicitud){
        $fecha_actual = date('d-m-Y');
        DB::table('pres_aut_solicitudes')
            ->where('id_solicitud', $id_solicitud)
            ->update([
                'id_estado_enviado' => 2,
                'fecha_enviado' => $fecha_actual,
            ]);
        return redirect('/presupuesto_autorizado/agregar_req_solicitud_autorizadas');
    }


}
