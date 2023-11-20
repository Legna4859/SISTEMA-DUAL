<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;
class Pres_revision_req_anteController extends Controller
{
    public function index(){
        $year = date('Y');
        $year = $year+1;

        $registros_envio=DB::select('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin and
        pres_req_mat_ante.year_requisicion = '.$year.' and pres_req_mat_ante.id_estado_requisicion in( 1,3)  ORDER BY `pres_req_mat_ante`.`fecha_envio` DESC ');

        /*
        $proyectos=DB::select('SELECT pres_proyectos.*, pres_presupuesto_anteproyecto.year from
        pres_proyectos, pres_presupuesto_anteproyecto where pres_proyectos.id_proyecto = pres_presupuesto_anteproyecto.id_proyecto 
        and pres_presupuesto_anteproyecto.year = '.$year.' ORDER BY `pres_proyectos`.`nombre_proyecto` ASC ');

        $datos_proyectos=array();
        foreach ($proyectos as $proyecto){
           $proy['id_proyecto']=$proyecto->id_proyecto;
           $proy['nombre_proyecto']=$proyecto->nombre_proyecto;
           $contar_proy=DB::selectOne('SELECT count(pres_actividades_req_ante.id_actividades_req_ante) contar 
           from pres_actividades_req_ante, pres_req_mat_ante WHERE pres_actividades_req_ante.id_req_mat_ante = pres_req_mat_ante.id_req_mat_ante 
           and pres_req_mat_ante.year_requisicion = '.$year.' and pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' 
          and pres_req_mat_ante.id_estado_requisicion =1');
            $proy['contar_envio']=$contar_proy->contar;
            array_push($datos_proyectos, $proy);
        }
        */


       return view('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.revision_requisiciones',compact('registros_envio','year'));

    }
    public  function revicion_req_departamento($id_req_mat_ante){
        $datos_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin
        and pres_req_mat_ante.id_req_mat_ante ='.$id_req_mat_ante.'');


          $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_req_mat_ante  = '.$id_req_mat_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');


        $requisiciones2=array();
        $numero_requisicion=0;
        $total_mod=0;
        $total_autorizado=0;
        $total_rechazado=0;



        foreach ($requisiciones as $requisicion){
            $numero_requisicion++;
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
            if($requisicion->id_autorizacion == 2 ){
                $total_mod++;
            }
            if($requisicion->id_autorizacion == 3){
                $total_rechazado++;
            }
            if($requisicion->id_autorizacion == 4 ){
                $total_autorizado++;
            }
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
            $req['total_importe']=$total_req;
            array_push($requisiciones2, $req);
        }
        $total_req_cal=$total_autorizado+$total_mod+$total_rechazado;




     return view('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.revision_departamento', compact('requisiciones2','datos_jefe','numero_requisicion','total_mod','total_autorizado','total_req_cal','id_req_mat_ante','total_rechazado'));


    }
    public function revisicion_bienes_servicios_departamento($id_actividades_req_ante,$id_req_mat_ante){
        $datos_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin
        and pres_req_mat_ante.id_req_mat_ante ='.$id_req_mat_ante.'');

        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante='.$id_actividades_req_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');





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


         if($presupuesto_cap == null)
         {
             $financiamiento_estatal =0;
             $financiamiento_federal=0;
             $financiamiento_propios=0;
             $id_capitulo =0;

         }else{
             $financiamiento_estatal =$presupuesto_cap->financiamiento_estatal;
             $financiamiento_federal=$presupuesto_cap->financiamiento_federal;
             $financiamiento_propios=$presupuesto_cap->financiamiento_propios;
             $id_capitulo = $presupuesto_cap->id_capitulo;
         }

        foreach ($requisiciones as $requisicion){
            $dat['clave_partida']= $requisicion->clave_presupuestal;
            $dat['nombre_partida']=$requisicion->nombre_partida;

            $dat['financimiento_estatal']=$total_req*$financiamiento_estatal;
            $total_financiamiento_estatal=$total_req*$financiamiento_estatal;
            $dat['financiamiento_federal']=$total_req*$financiamiento_federal;
            $total_financiamiento_federal=$total_req*$financiamiento_federal;
            $dat['financiamiento_propios']=$total_req*$financiamiento_propios;
            $total_financiamiento_propios=$total_req*$financiamiento_propios;
            $total_finaciamiento_total =$total_financiamiento_estatal+$total_financiamiento_federal+$total_financiamiento_propios;
            $dat['total_finaciamiento_total']=$total_finaciamiento_total;
        }


        $req=DB::select('SELECT pres_actividades_req_ante.* from pres_req_mat_ante, pres_actividades_req_ante,pres_partida_pres 
        WHERE pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and pres_req_mat_ante.year_requisicion = '.$reg_envio_ante->year_requisicion.'
        and pres_actividades_req_ante.id_proyecto = '.$requisiciones[0]->id_proyecto.' and pres_actividades_req_ante.id_autorizacion = 4 AND
        pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres and pres_partida_pres.id_capitulo='.$id_capitulo.'');

         $total_proyecto=0;
        foreach ($req as $req){
            $materiales=DB::selectOne('SELECT SUM(importe) suma FROM pres_reg_material_req_ante WHERE id_actividades_req_ante ='.$req->id_actividades_req_ante.' ');

                $total_proyecto=$total_proyecto+$materiales->suma;
        }




        return view('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.revision_proy_departamento', compact( 'requisiciones2','datos_req_envio','total_req','id_actividades_req_ante','presupuesto_cap','requisiciones','total_proyecto','dat','datos_jefe'));

    }
    public function guardar_modificaciones(Request $request){

        $fecha_actual = date('d-m-Y');
        $this->validate($request, [
            'id_act_requisicion_ante' => 'required',
            'comentario' =>'required',
        ]);
        $id_act_requisicion_ante = $request->input('id_act_requisicion_ante');
        $comentario = $request->input('comentario');
        $dat_requisicion=DB::selectOne('SELECT * FROM `pres_actividades_req_ante` WHERE `id_actividades_req_ante` ='.$id_act_requisicion_ante.' ');
        $id_req_mat_ante=$dat_requisicion->id_req_mat_ante;

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_act_requisicion_ante)
            ->update([
                'comentario' => $comentario,
                'id_autorizacion' =>2
                ]);
        return redirect('/presupuesto_anteproyecto/revicion_req_departamento/'.$id_req_mat_ante);

    }
    public function guardar_autorizacion_requisicion(Request $request){
        $this->validate($request, [
            'id_act_requisicion_antep' => 'required',
        ]);
        $id_act_requisicion_ante = $request->input('id_act_requisicion_antep');
        $dat_requisicion=DB::selectOne('SELECT * FROM `pres_actividades_req_ante` WHERE `id_actividades_req_ante` ='.$id_act_requisicion_ante.' ');
        $id_req_mat_ante=$dat_requisicion->id_req_mat_ante;

        $contar=DB::selectOne('SELECT max(numero_requisicion) numero_requisicion FROM pres_actividades_req_ante WHERE  id_autorizacion = 4');

        if($contar->numero_requisicion == null){
            $numero_reuqisicion=1;
       }else{
            $numero_reuqisicion=$contar->numero_requisicion+1;
       }

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_act_requisicion_ante)
            ->update([
                'numero_requisicion' =>$numero_reuqisicion,
                'comentario' => "",
                'id_autorizacion' =>4
            ]);

        return redirect('/presupuesto_anteproyecto/revicion_req_departamento/'.$id_req_mat_ante);
    }
    public function guardar_rechazo_requisicion(Request $request){

        $this->validate($request, [
            'id_act_requisicion_antepr' => 'required',
            'comentarios'=>'required'
        ]);
        $id_act_requisicion_ante = $request->input('id_act_requisicion_antepr');
        $comentario=$request->input('comentarios');
        $dat_requisicion=DB::selectOne('SELECT * FROM `pres_actividades_req_ante` WHERE `id_actividades_req_ante` ='.$id_act_requisicion_ante.' ');
        $id_req_mat_ante=$dat_requisicion->id_req_mat_ante;

        DB::table('pres_actividades_req_ante')
            ->where('id_actividades_req_ante', $id_act_requisicion_ante)
            ->update([
                'comentario' => $comentario,
                'id_autorizacion' =>3
            ]);

        return redirect('/presupuesto_anteproyecto/revicion_req_departamento/'.$id_req_mat_ante);
    }
    public function enviar_modificaciones_depart(Request $request){
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
        Mail::send('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.notificacion_modificacion_requisicion',["nombre_jefe_finan"=>$nombre_jefe_finan,"correo_jefe_finan"=>$correo_jefe_finan,"year"=>$year], function($message)use($nombre_jefe_finan,$correo_jefe_dep,$year)
        {
            $message->from(Auth::user()->email, 'Jefa de la Dirección de Administracción y Finanzas: '.$nombre_jefe_finan);
            $message->to($correo_jefe_dep,"")->subject('Notificación de envió de correcciones de las requisiciones del anteproyecto del '.$year);
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        DB::table('pres_req_mat_ante')
            ->where('id_req_mat_ante', $id_req_mat_ante)
            ->update([
                'id_estado_requisicion' => 2,
                'fecha_envio' => $fecha_actual,
            ]);
        return redirect('/presupuesto_anteproyecto/revicion_requisiciones_anteproyecto');

    }
    public function permiso_mod_jefe_depart(){
        $year = date('Y');
        $year = $year+1;

        $registros_modificaciones=DB::select('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin and
        pres_req_mat_ante.year_requisicion = '.$year.' and pres_req_mat_ante.id_estado_requisicion = 2  ORDER BY `pres_req_mat_ante`.`fecha_envio` DESC ');

        return view('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.proceso_modificacion_departamento',compact('registros_modificaciones','year'));
    }
    public function autorizados_mod_jefe_depart(){
        $year = date('Y');
        $year = $year+1;

        $registros_atorizados=DB::select('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin and
        pres_req_mat_ante.year_requisicion = '.$year.' and pres_req_mat_ante.id_estado_requisicion = 4  ORDER BY `pres_req_mat_ante`.`fecha_envio` DESC ');

        return view('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.autorizacion_req_departamento',compact('registros_atorizados','year'));

    }
    public  function revicion_mod_req_departamento($id_req_mat_ante){
        $datos_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin
        and pres_req_mat_ante.id_req_mat_ante ='.$id_req_mat_ante.'');


        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_req_mat_ante  = '.$id_req_mat_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');


        $requisiciones2=array();
        $numero_requisicion=0;
        $total_mod=0;
        $total_autorizado=0;



        foreach ($requisiciones as $requisicion){
            $numero_requisicion++;
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
            if($requisicion->id_autorizacion == 2){
                $total_mod++;
            }
            if($requisicion->id_autorizacion == 4){
                $total_autorizado++;
            }
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
            $req['total_importe']=$total_req;
            array_push($requisiciones2, $req);
        }
        $total_req_cal=$total_autorizado+$total_mod;
        return view('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.revision_departamento', compact('requisiciones2','datos_jefe','numero_requisicion','total_mod','total_autorizado','total_req_cal','id_req_mat_ante'));

    }
    public function enviar_autorizacion_depart(Request $request){
        $fecha_actual = date('d-m-Y');
        $this->validate($request, [
            'id_req_mat_antep' => 'required',
        ]);


        $id_req_mat_ante = $request->input('id_req_mat_antep');

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
        Mail::send('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.notificacion_revision_todas_req',["nombre_jefe_finan"=>$nombre_jefe_finan,"correo_jefe_finan"=>$correo_jefe_finan,"year"=>$year], function($message)use($nombre_jefe_finan,$correo_jefe_dep,$year)
        {
            $message->from(Auth::user()->email, 'Jefa de la Dirección de Administracción y Finanzas: '.$nombre_jefe_finan);
            $message->to($correo_jefe_dep,"")->subject('Notificación de envió de revisión de todas sus requisiciones del anteproyecto del '.$year);
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });

        DB::table('pres_req_mat_ante')
            ->where('id_req_mat_ante', $id_req_mat_ante)
            ->update([
                'id_estado_requisicion' => 4,
                'fecha_envio' => $fecha_actual,
            ]);
        return redirect('/presupuesto_anteproyecto/revicion_requisiciones_anteproyecto');
    }
    public function ver_autorizacion_bienes_servicios_departamento($id_actividades_req_ante,$id_req_mat_ante ){
        $datos_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin
        and pres_req_mat_ante.id_req_mat_ante ='.$id_req_mat_ante.'');

        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante='.$id_actividades_req_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');





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
            $req['cotizacion_pdf']=$requisicion->cotizacion_pdf;
            $req['oficio_suficiencia_presupuestal_pdf']=$requisicion->oficio_suficiencia_presupuestal_pdf;
            $req['id_estado_justificacion']=$requisicion->id_estado_justificacion;
            $req['justificacion_pdf']=$requisicion->justificacion_pdf;
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




        return view('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.req_autorizada_departamento', compact( 'requisiciones2','datos_req_envio','total_req','id_actividades_req_ante','presupuesto_cap','requisiciones','total_proyecto','dat','datos_jefe','id_req_mat_ante'));


    }
    public function autorizados_req_departamento($id_req_mat_ante){
        $datos_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin
        and pres_req_mat_ante.id_req_mat_ante ='.$id_req_mat_ante.'');
        $datos_req_envio = DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` = ' . $id_req_mat_ante . '');

        $meses = DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC ');
        $proyectos = DB::select('SELECT pres_proyectos.* from pres_presupuesto_anteproyecto, pres_proyectos 
        where pres_proyectos.id_proyecto = pres_presupuesto_anteproyecto.id_proyecto 
        and pres_presupuesto_anteproyecto.year='.$datos_req_envio->year_requisicion.'  ORDER BY `pres_proyectos`.`nombre_proyecto` ASC ');
        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,
        pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_req_mat_ante  = '.$id_req_mat_ante.' 
       and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       and pres_actividades_req_ante.id_autorizacion = 4
       ORDER BY `pres_mes`.`id_mes` ASC');

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
                $estado_documentacion=true;
            }
            $req['oficio_suficiencia_presupuestal_pdf']=$requisicion->oficio_suficiencia_presupuestal_pdf;
            if($requisicion->oficio_suficiencia_presupuestal_pdf == ''){
                $estado_documentacion=true;
            }
            $req['id_estado_justificacion']=$requisicion->id_estado_justificacion;
            if($requisicion->id_estado_justificacion ==  0){
                $estado_documentacion=true;
            }
            $req['justificacion_pdf']=$requisicion->justificacion_pdf;
            $req['fecha_reg']=$requisicion->fecha_reg;
            $req['fecha_mod']=$requisicion->fecha_mod;
            $req['mes']=$requisicion->mes;
            $req['nombre_proyecto']=$requisicion->nombre_proyecto;
            $req['meta']=$requisicion->meta;
            $bienes=array();
            $total_req=0;
            $bienes_servicios=DB::select('SELECT * FROM `pres_reg_material_req_ante` 
             WHERE `id_actividades_req_ante` = '.$requisicion->id_actividades_req_ante.' ');
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



        return view('departamento_finanzas.jefe_finanazas.evaluacion_requisiciones.requisiciones_autorizadas_dep', compact('datos_req_envio', 'meses', 'proyectos', 'requisiciones2','partidas_presupuestales','total_req','id_req_mat_ante','estado_material','estado_documentacion','contar_req','datos_jefe'));


    }

}
