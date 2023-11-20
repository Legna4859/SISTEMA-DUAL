<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
class Pres_aut_agregar_presuController extends Controller
{
    public function index(){
        $year= date('Y');
        $partidas=DB::select('SELECT pres_partida_pres.* from pres_partida_pres where pres_partida_pres.id_partida_pres
        NOT in( SELECT pres_aut_presupuesto_aut.id_partida FROM pres_aut_presupuesto_aut WHERE pres_aut_presupuesto_aut.year_presupuesto = '.$year.')');
       // dd($partidas);

        $partidas_reg=DB::select('SELECT pres_aut_presupuesto_aut.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
        from pres_aut_presupuesto_aut, pres_partida_pres where pres_aut_presupuesto_aut.id_partida = pres_partida_pres.id_partida_pres 
        and pres_aut_presupuesto_aut.year_presupuesto ='.$year.'');

        $array_partidas= array();

        $total_enero=0;
        $total_febrero=0;
        $total_marzo=0;
        $total_abril=0;
        $total_mayo=0;
        $total_junio=0;
        $total_julio=0;
        $total_agosto=0;
        $total_septiembre=0;
        $total_octubre=0;
        $total_noviembre=0;
        $total_diciembre=0;
        foreach ($partidas_reg as $partida)
        {
            $dat['id_presupuesto_aut']=$partida->id_presupuesto_aut;
            $dat['year_presupuesto']=$partida->year_presupuesto;
            $dat['id_partida']=$partida->id_partida;
            $dat['total_presupuesto']=$partida->total_presupuesto;
            $dat['enero_pres']=$partida->enero_pres;
            $total_enero=$total_enero+$partida->enero_pres;
            $dat['febrero_pres']=$partida->febrero_pres;
            $total_febrero=$total_febrero+$partida->febrero_pres;
            $dat['marzo_pres']=$partida->marzo_pres;
            $total_marzo=$total_marzo+$partida->marzo_pres;
            $dat['abril_pres']=$partida->abril_pres;
            $total_abril=$total_abril+$partida->abril_pres;
            $dat['mayo_pres']=$partida->mayo_pres;
            $total_mayo=$total_mayo+$partida->mayo_pres;
            $dat['junio_pres']=$partida->junio_pres;
            $total_junio=$total_junio+$partida->junio_pres;
            $dat['julio_pres']=$partida->julio_pres;
            $total_julio=$total_julio+$partida->julio_pres;
            $dat['agosto_pres']=$partida->agosto_pres;
            $total_agosto=$total_agosto+$partida->agosto_pres;
            $dat['septiembre_pres']=$partida->septiembre_pres;
            $total_septiembre=$total_septiembre+$partida->septiembre_pres;
            $dat['octubre_pres']=$partida->octubre_pres;
            $total_octubre=$total_octubre+$partida->octubre_pres;
            $dat['noviembre_pres']=$partida->noviembre_pres;
            $total_noviembre=$total_noviembre+$partida->noviembre_pres;
            $dat['diciembre_pres']=$partida->diciembre_pres;
            $total_diciembre=$total_diciembre+$partida->diciembre_pres;
            $dat['nombre_partida']=$partida->nombre_partida;
            $dat['clave_presupuestal']=$partida->clave_presupuestal;

            array_push($array_partidas,$dat);

        }

        $total_presupuesto=$total_enero+$total_febrero+$total_marzo+$total_abril+$total_mayo+$total_junio+$total_julio+$total_agosto+$total_septiembre+$total_octubre+$total_noviembre+$total_diciembre;

        $estado_presupuesto=DB::selectOne('SELECT pres_aut_estado_presupuesto.* from pres_aut_estado_presupuesto where year_estado = '.$year.'');
       if($estado_presupuesto == null)
       {
           $estado_presupuesto =0;
       }else{
           $estado_presupuesto =1;
       }

        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.agregar_partida_presupuesto',compact('estado_presupuesto','total_presupuesto','year','partidas','array_partidas','total_enero',
        'total_febrero','total_febrero','total_marzo','total_abril','total_mayo','total_junio','total_julio','total_agosto','total_septiembre','total_octubre','total_noviembre','total_diciembre'));
    }
    public function guardar_presupesto_partida(Request $request){
        $year= date('Y');
        $id_partida = $request->input('id_partida');
        $enero_pres = $request->input('enero_pres');
        $febrero_pres = $request->input('febrero_pres');
        $marzo_pres = $request->input('marzo_pres');
        $abril_pres = $request->input('abril_pres');
        $mayo_pres = $request->input('mayo_pres');
        $junio_pres = $request->input('junio_pres');
        $julio_pres = $request->input('julio_pres');
        $agosto_pres = $request->input('agosto_pres');
        $septiembre_pres = $request->input('septiembre_pres');
        $octubre_pres = $request->input('octubre_pres');
        $noviembre_pres = $request->input('noviembre_pres');
        $diciembre_pres = $request->input('diciembre_pres');

        $total_presupuesto=$enero_pres+$febrero_pres+$marzo_pres+$abril_pres+$mayo_pres+$junio_pres+$julio_pres+$agosto_pres+$septiembre_pres+$octubre_pres+$noviembre_pres+$diciembre_pres;
        $hoy = date("Y-m-d H:i:s");

        DB:: table('pres_aut_presupuesto_aut')->insert([
            'year_presupuesto' => $year,
            'id_partida' => $id_partida,
            'total_presupuesto' => $total_presupuesto,
            'enero_pres' => $enero_pres,
            'febrero_pres' => $febrero_pres,
            'marzo_pres' => $marzo_pres,
            'abril_pres' => $abril_pres,
            'mayo_pres' => $mayo_pres,
            'junio_pres' => $junio_pres,
            'julio_pres' => $julio_pres,
            'agosto_pres' => $agosto_pres,
            'septiembre_pres' => $septiembre_pres,
            'octubre_pres' => $octubre_pres,
            'noviembre_pres' => $noviembre_pres,
            'diciembre_pres' => $diciembre_pres,
            'fecha_registro' => $hoy,
        ]);

        DB:: table('pres_aut_presupuesto_aut_copia')->insert([
            'year_presupuesto' => $year,
            'id_partida' => $id_partida,
            'total_presupuesto' => $total_presupuesto,
            'enero_pres' => $enero_pres,
            'febrero_pres' => $febrero_pres,
            'marzo_pres' => $marzo_pres,
            'abril_pres' => $abril_pres,
            'mayo_pres' => $mayo_pres,
            'junio_pres' => $junio_pres,
            'julio_pres' => $julio_pres,
            'agosto_pres' => $agosto_pres,
            'septiembre_pres' => $septiembre_pres,
            'octubre_pres' => $octubre_pres,
            'noviembre_pres' => $noviembre_pres,
            'diciembre_pres' => $diciembre_pres,
            'fecha_registro' => $hoy,
        ]);
        return back();
    }
    public function modificar_presupesto_partida($id_presupuesto_aut){
        $partida_reg=DB::selectOne('SELECT pres_aut_presupuesto_aut.*,pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
        FROM pres_aut_presupuesto_aut, pres_partida_pres WHERE pres_aut_presupuesto_aut.id_presupuesto_aut = '.$id_presupuesto_aut.' 
        and pres_aut_presupuesto_aut.id_partida = pres_partida_pres.id_partida_pres');

        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.modificar_partida_presupuestal',compact('partida_reg'));
    }
    public function guardar_mod_presupesto_partida(Request $request, $id_presupuesto_aut){

        $enero_pres = $request->input('enero_pres_mod');
        $febrero_pres = $request->input('febrero_pres_mod');
        $marzo_pres = $request->input('marzo_pres_mod');
        $abril_pres = $request->input('abril_pres_mod');
        $mayo_pres = $request->input('mayo_pres_mod');
        $junio_pres = $request->input('junio_pres_mod');
        $julio_pres = $request->input('julio_pres_mod');
        $agosto_pres = $request->input('agosto_pres_mod');
        $septiembre_pres = $request->input('septiembre_pres_mod');
        $octubre_pres = $request->input('octubre_pres_mod');
        $noviembre_pres = $request->input('noviembre_pres_mod');
        $diciembre_pres = $request->input('diciembre_pres_mod');

        $total_presupuesto=$enero_pres+$febrero_pres+$marzo_pres+$abril_pres+$mayo_pres+$junio_pres+$julio_pres+$agosto_pres+$septiembre_pres+$octubre_pres+$noviembre_pres+$diciembre_pres;
        $hoy = date("Y-m-d H:i:s");


        DB::table('pres_aut_presupuesto_aut')
            ->where('id_presupuesto_aut', $id_presupuesto_aut)
            ->update([
                'total_presupuesto' => $total_presupuesto,
                'enero_pres' => $enero_pres,
                'febrero_pres' => $febrero_pres,
                'marzo_pres' => $marzo_pres,
                'abril_pres' => $abril_pres,
                'mayo_pres' => $mayo_pres,
                'junio_pres' => $junio_pres,
                'julio_pres' => $julio_pres,
                'agosto_pres' => $agosto_pres,
                'septiembre_pres' => $septiembre_pres,
                'octubre_pres' => $octubre_pres,
                'noviembre_pres' => $noviembre_pres,
                'diciembre_pres' => $diciembre_pres,
                'fecha_modificacion' => $hoy,
                ]);

        DB::table('pres_aut_presupuesto_aut_copia')
            ->where('id_presupuesto_aut_copia', $id_presupuesto_aut)
            ->update([
                'total_presupuesto' => $total_presupuesto,
                'enero_pres' => $enero_pres,
                'febrero_pres' => $febrero_pres,
                'marzo_pres' => $marzo_pres,
                'abril_pres' => $abril_pres,
                'mayo_pres' => $mayo_pres,
                'junio_pres' => $junio_pres,
                'julio_pres' => $julio_pres,
                'agosto_pres' => $agosto_pres,
                'septiembre_pres' => $septiembre_pres,
                'octubre_pres' => $octubre_pres,
                'noviembre_pres' => $noviembre_pres,
                'diciembre_pres' => $diciembre_pres,
                'fecha_modificacion' => $hoy,
            ]);

        return back();

    }
    public function eliminar_presupesto_partida($id_presupuesto_aut){
        $partida_reg=DB::selectOne('SELECT pres_aut_presupuesto_aut.*,pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
        FROM pres_aut_presupuesto_aut, pres_partida_pres WHERE pres_aut_presupuesto_aut.id_presupuesto_aut = '.$id_presupuesto_aut.' 
        and pres_aut_presupuesto_aut.id_partida = pres_partida_pres.id_partida_pres');


        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.eliminar_partida_presupuesto', compact('partida_reg'));

    }
    public function guardar_eliminar_presupesto_partida(Request $request,$id_presupuesto_aut){
        $partida=DB::selectOne('SELECT * FROM `pres_aut_presupuesto_aut` WHERE `id_presupuesto_aut` ='.$id_presupuesto_aut.'');

        DB::delete('DELETE FROM pres_aut_presupuesto_aut WHERE id_presupuesto_aut='.$id_presupuesto_aut.'');

        DB::delete('DELETE FROM pres_aut_presupuesto_aut_copia WHERE `year_presupuesto` = '.$partida->year_presupuesto.' AND `id_partida` ='.$partida->id_partida.'');

        return back();
    }
    public function guardar_terminar_presupuesto(Request $request,$year){
        $hoy = date("Y-m-d H:i:s");

        DB:: table('pres_aut_estado_presupuesto')->insert([
            'year_estado' => $year,
            'status' => 1,
            'fecha_registro' => $hoy,
        ]);

       return back();

    }
    public function departamentos_presupesto_partida(){
        $year= date('Y');
        $departamentos=DB::select('SELECT pres_req_mat_ante.id_unidad_admin, gnral_unidad_administrativa.nom_departamento, gnral_personales.nombre, abreviaciones.titulo,1  estado 
        from pres_req_mat_ante, abreviaciones_prof, abreviaciones, gnral_personales, gnral_unidad_personal, gnral_unidad_administrativa
        WHERE pres_req_mat_ante.year_requisicion = '.$year.'  and pres_req_mat_ante.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin and
        gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin and gnral_unidad_personal.id_personal = gnral_personales.id_personal 
        and gnral_personales.id_personal = abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
        UNION SELECT gnral_unidad_administrativa.id_unidad_admin, gnral_unidad_administrativa.nom_departamento, gnral_personales.nombre, abreviaciones.titulo,2 estado
        from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones where 
        gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin and gnral_unidad_personal.id_personal = gnral_personales.id_personal 
        and gnral_personales.id_personal = abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion 
        and gnral_unidad_administrativa.id_unidad_admin NOT in (SELECT id_unidad_admin from pres_req_mat_ante where year_requisicion = '.$year.') ORDER by nom_departamento asc');



        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.departamentos_presupuesto', compact('year','departamentos'));

    }
    public function departamentos_agregar_presupuesto($id_unidad_admin){
        $year= date('Y');
        $proyectos= DB::select('SELECT * FROM `pres_proyectos` WHERE `year` = '.$year.' ORDER BY `pres_proyectos`.`nombre_proyecto` ASC');

        $unidad=DB::selectOne('SELECT gnral_unidad_administrativa.*, gnral_personales.id_personal,
       gnral_personales.nombre, abreviaciones.titulo FROM gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales,
       abreviaciones_prof, abreviaciones where gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin 
        and gnral_unidad_personal.id_personal = gnral_personales.id_personal and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion and gnral_unidad_administrativa.id_unidad_admin ='.$id_unidad_admin.'');

        $array_requisiciones=array();

       $administrativa=DB::selectOne('SELECT pres_req_mat_ante.*, gnral_unidad_administrativa.nom_departamento, gnral_personales.nombre, abreviaciones.titulo
        from pres_req_mat_ante, abreviaciones_prof, abreviaciones, gnral_personales, gnral_unidad_personal, gnral_unidad_administrativa
        WHERE pres_req_mat_ante.year_requisicion = '.$year.'  and pres_req_mat_ante.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin and
        gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin and gnral_unidad_personal.id_personal = gnral_personales.id_personal 
        and gnral_personales.id_personal = abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
        and  gnral_unidad_administrativa.id_unidad_admin ='.$id_unidad_admin.'');


        if($administrativa  == null)
        {
            //sin requisiciones de anteproyecto
            $estado_anteproyecto = 1;

        }else {
            //con requisiciones de anteproyecto
            $estado_anteproyecto = 2;
            $requiciones = DB::select('SELECT pres_actividades_req_ante.*, pres_partida_pres.clave_presupuestal, pres_partida_pres.nombre_partida 
       from pres_actividades_req_ante, pres_partida_pres where pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       and pres_actividades_req_ante.id_req_mat_ante =' . $administrativa->id_req_mat_ante . ' and pres_actividades_req_ante.id_autorizacion =4 ORDER by pres_partida_pres.clave_presupuestal asc ');


            foreach ($requiciones as $requicion) {
                $contar_reg = DB::selectOne('SELECT COUNT(id_solicitud_partida)contar from pres_aut_solicitudes_partidas
            where id_tipo_requisicion = 1 and id_actividades_req_ante =' . $requicion->id_actividades_req_ante . '');


                if ($contar_reg->contar == 0) {

                    $dat['id_actividades_req_ante'] = $requicion->id_actividades_req_ante;
                    $dat['id_req_mat_ante'] = $requicion->id_req_mat_ante;
                    $dat['id_partida_pres'] = $requicion->id_partida_pres;
                    $dat['id_mes'] = $requicion->id_mes;
                    $dat['id_proyecto'] = $requicion->id_proyecto;
                    $dat['id_meta'] = $requicion->id_meta;
                    $dat['clave_presupuestal'] = $requicion->clave_presupuestal;
                    $dat['nombre_partida'] = $requicion->nombre_partida;

                    $materiales = DB::select('SELECT * FROM `pres_reg_material_req_ante` WHERE `id_actividades_req_ante` =' . $requicion->id_actividades_req_ante . '');

                    $array_materiales = array();
                    foreach ($materiales as $material) {
                        $mat['id_reg_material_ant'] = $material->id_reg_material_ant;
                        $mat['descripcion'] = $material->descripcion;
                        $mat['unidad_medida'] = $material->unidad_medida;
                        $mat['cantidad'] = $material->cantidad;
                        $mat['precio_unitario'] = $material->importe;
                        array_push($array_materiales, $mat);
                    }
                    $dat['materiales'] = $array_materiales;
                    array_push($array_requisiciones, $dat);
                }
            }
        }

        /////////////////////*******************solicitudes
        $solicitudes=DB::select('SELECT pres_aut_solicitudes.*,pres_mes.mes, pres_proyectos.nombre_proyecto, pres_metas.meta 
        FROM pres_aut_solicitudes, pres_proyectos, pres_metas, pres_mes
        where pres_aut_solicitudes.year_presupuesto = '.$year.' and pres_aut_solicitudes.id_unidad_admin =  '.$id_unidad_admin.' 
        and pres_aut_solicitudes.id_proyecto = pres_proyectos.id_proyecto  
        and pres_aut_solicitudes.id_meta = pres_metas.id_meta
        and pres_aut_solicitudes.id_estado_enviado in(0,1)
        and pres_aut_solicitudes.id_mes = pres_mes.id_mes order by pres_mes.mes ASC ');


         $array_solicitudes= array();
        foreach ($solicitudes as $solicitud){
            $sol['id_solicitud']= $solicitud->id_solicitud;
            $sol['year_presupuesto']= $solicitud->year_presupuesto;
            $sol['id_unidad_admin']= $solicitud->id_unidad_admin;
            $sol['id_estado_enviado']= $solicitud->id_estado_enviado;
            $sol['numero_solicitud']= $solicitud->numero_solicitud;
            $sol['id_proyecto']= $solicitud->id_proyecto;
            $sol['descripcion_solicitud']= $solicitud->descripcion_solicitud;
            $sol['nombre_proyecto']= $solicitud->nombre_proyecto;
            $sol['meta']= $solicitud->meta;
            $sol['mes']= $solicitud->mes;

            $partidas=DB::select('SELECT pres_aut_solicitudes_partidas.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal
            FROM pres_aut_solicitudes_partidas, pres_partida_pres
               where pres_aut_solicitudes_partidas.id_solicitud ='.$solicitud->id_solicitud.'
               and pres_aut_solicitudes_partidas.id_partida_pres = pres_partida_pres.id_partida_pres  ');



            $array_partidas= array();
            $contar_partidas=0;
            foreach ($partidas as $partida){
                $contar_partidas=$contar_partidas+1;
                $part['id_solicitud_partida']=$partida->id_solicitud_partida;
                $part['id_partida_pres']=$partida->id_partida_pres;
                $part['justificacion']="";
                $part['numero_requisicion']=$partida->numero_requisicion;
                $part['id_autorizacion']=$partida->id_autorizacion;
                $part['presupuesto_dado']=$partida->presupuesto_dado;
                $part['importe_total']=$partida->importe_total;
                $part['id_tipo_requisicion']=$partida->id_tipo_requisicion;
                $part['id_actividades_req_ante']=$partida->id_actividades_req_ante;
                $part['nombre_partida']=$partida->nombre_partida;
                $part['clave_presupuestal']=$partida->clave_presupuestal;


              array_push($array_partidas, $part);
            }
            $sol['partidas']= $array_partidas;
            $sol['contar_partidas']= $contar_partidas;

            array_push($array_solicitudes,$sol);
        }

        $meses = DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC');

        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.registrar_presupuesto_departamento', compact('meses','unidad','year','administrativa','array_requisiciones','id_unidad_admin','array_solicitudes','proyectos','estado_anteproyecto'));

    }
    public function departamento_ver_pres_autorizar($id_actividades_req_ante){
        $requiciones=DB::select('SELECT pres_actividades_req_ante.*, pres_partida_pres.clave_presupuestal,
        pres_partida_pres.nombre_partida, pres_mes.mes from pres_actividades_req_ante, pres_partida_pres, pres_mes
        where pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres and pres_mes.id_mes = pres_actividades_req_ante.id_mes 
          and pres_actividades_req_ante.id_actividades_req_ante ='.$id_actividades_req_ante.' ');

        $array_requisiciones=array();

        foreach($requiciones as $requicion)
        {
            $contar_reg=DB::selectOne('SELECT count(id_actividades_req_ante) contar from pres_aut_solicitudes_partidas 
            where id_tipo_requisicion = 1 and id_actividades_req_ante = '.$requicion->id_actividades_req_ante.'');


            if($contar_reg->contar == 0) {

                $dat['id_actividades_req_ante'] = $requicion->id_actividades_req_ante;
                $dat['id_req_mat_ante'] = $requicion->id_req_mat_ante;
                $dat['id_partida_pres'] = $requicion->id_partida_pres;
                $dat['id_mes'] = $requicion->id_mes;
                $dat['mes'] = $requicion->mes;
                $dat['id_proyecto'] = $requicion->id_proyecto;
                $dat['id_meta'] = $requicion->id_meta;
                $dat['clave_presupuestal'] = $requicion->clave_presupuestal;
                $dat['nombre_partida'] = $requicion->nombre_partida;

                $materiales = DB::select('SELECT * FROM `pres_reg_material_req_ante` WHERE `id_actividades_req_ante` =' . $requicion->id_actividades_req_ante . '');

                $array_materiales = array();
                foreach ($materiales as $material) {
                    $mat['id_reg_material_ant'] = $material->id_reg_material_ant;
                    $mat['descripcion'] = $material->descripcion;
                    $mat['unidad_medida'] = $material->unidad_medida;
                    $mat['cantidad'] = $material->cantidad;
                    $mat['precio_unitario'] = $material->importe;
                    array_push($array_materiales, $mat);
                }
                $dat['materiales'] = $array_materiales;
                array_push($array_requisiciones, $dat);
            }
        }


        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.revisar_requisicion_autorizar', compact('array_requisiciones'));


    }
    public function guardar_aut_requisicion(Request $request,$id_actividades_req_ante){

        $des_solicitud = $request->input('des_solicitud');

        $numero_max_solicitud=DB::selectOne('SELECT max(id_solicitud)numero FROM pres_aut_solicitudes');
        if($numero_max_solicitud == null){
            $numero_act_solicitud=1;
        }else{

            $numero_act_solicitud=$numero_max_solicitud->numero+1;
        }

       $numero_max_partidas=DB::selectOne('SELECT max(id_solicitud_partida)numero FROM pres_aut_solicitudes_partidas');

       if($numero_max_partidas == null){
           $numero_act_partida=1;
       }else{

           $numero_act_partida=$numero_max_partidas->numero+1;
       }
         $req=DB::selectOne('SELECT pres_actividades_req_ante.*, pres_partida_pres.clave_presupuestal, pres_partida_pres.nombre_partida 
       from pres_actividades_req_ante, pres_partida_pres where pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       and pres_actividades_req_ante.id_actividades_req_ante ='.$id_actividades_req_ante.'');

       $proy=DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` ='.$req->id_req_mat_ante.'');

        $requiciones=DB::select('SELECT pres_actividades_req_ante.*, pres_partida_pres.clave_presupuestal, pres_partida_pres.nombre_partida 
       from pres_actividades_req_ante, pres_partida_pres where pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       and pres_actividades_req_ante.id_actividades_req_ante ='.$id_actividades_req_ante.' ');

        $array_requisiciones=array();

        foreach($requiciones as $requicion)
        {
            $contar_reg=DB::selectOne('SELECT count(id_actividades_req_ante) contar from pres_aut_solicitudes_partidas 
            where id_tipo_requisicion = 1 and id_actividades_req_ante = '.$requicion->id_actividades_req_ante.'');

            if($contar_reg->contar == 0) {

                $dat['id_actividades_req_ante'] = $requicion->id_actividades_req_ante;
                $dat['id_req_mat_ante'] = $requicion->id_req_mat_ante;
                $dat['id_partida_pres'] = $requicion->id_partida_pres;
                $dat['id_mes'] = $requicion->id_mes;
                $dat['id_proyecto'] = $requicion->id_proyecto;
                $dat['id_meta'] = $requicion->id_meta;
                $dat['clave_presupuestal'] = $requicion->clave_presupuestal;
                $dat['nombre_partida'] = $requicion->nombre_partida;

                $materiales = DB::select('SELECT * FROM `pres_reg_material_req_ante` WHERE `id_actividades_req_ante` =' . $requicion->id_actividades_req_ante . '');

                $array_materiales = array();
                $total_importe=0;
                foreach ($materiales as $material) {
                    $mat['id_reg_material_ant'] = $material->id_reg_material_ant;
                    $mat['descripcion'] = $material->descripcion;
                    $mat['unidad_medida'] = $material->unidad_medida;
                    $mat['cantidad'] = $material->cantidad;
                    $mat['precio_unitario'] = $material->importe;
                    $importe=$material->cantidad*$material->importe;
                    $mat['importe'] = $importe;
                    $total_importe=$total_importe+$importe;
                    array_push($array_materiales, $mat);
                }
                $dat['materiales'] = $array_materiales;
                $dat['total_importe'] = $total_importe;
                array_push($array_requisiciones, $dat);
            }
        }

        $fecha_actual = date('d-m-Y');
        $year= date('Y');
        foreach ($array_requisiciones as $req) {
            $requi=DB::selectOne('SELECT * FROM `pres_req_mat_ante` WHERE `id_req_mat_ante` ='.$req['id_req_mat_ante'].'');

            $numero_max=DB::selectOne('SELECT max(numero_solicitud) numero from pres_aut_solicitudes 
            where year_presupuesto = '.$requi->year_requisicion.' and id_unidad_admin = '.$requi->id_unidad_admin.'');

            if($numero_max == null) {
                $numero_solicitud=1;
            }
            else{
                $numero_solicitud= $numero_max->numero+1;
            }


            DB:: table('pres_aut_solicitudes')->insert([
                'id_solicitud' => $numero_act_solicitud,
                'year_presupuesto' => $requi->year_requisicion,
                'id_unidad_admin' => $requi->id_unidad_admin,
                'descripcion_solicitud' => $des_solicitud,
                'id_estado_enviado' => 0,
                'numero_solicitud' => $numero_solicitud,
                'id_proyecto' => $req['id_proyecto'],
                'id_meta' => $req['id_meta'],
                'id_mes' => $req['id_mes'],
                'fecha_registro' => $fecha_actual,


            ]);

            DB:: table('pres_aut_solicitudes_partidas')->insert([
                'id_solicitud_partida' => $numero_act_partida,
                'id_solicitud' => $numero_act_solicitud,
                'id_partida_pres' => $req['id_partida_pres'],
                'fecha_registro' => $fecha_actual,
                'id_tipo_requisicion' => 1,
                'id_actividades_req_ante' => $req['id_actividades_req_ante'],
                'importe_total' => $req['total_importe'],


            ]);
            foreach ($req['materiales'] as $material){

                DB:: table('pres_aut_materiales_partidas')->insert([
                    'id_solicitud_partida' => $numero_act_partida,
                    'descripcion' => $material['descripcion'],
                    'unidad_medida' => $material['unidad_medida'],
                    'cantidad' => $material['cantidad'],
                    'precio_unitario' => $material['precio_unitario'],
                    'importe' => $material['importe'],
                    'fecha_registro' => $fecha_actual,
                ]);
            }
        }
        return back();
    }
    public function presupesto_partida_copia()
    {
        $year= date('Y');

        $partidas_reg=DB::select('SELECT pres_aut_presupuesto_aut_copia.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
        from pres_aut_presupuesto_aut_copia, pres_partida_pres where pres_aut_presupuesto_aut_copia.id_partida = pres_partida_pres.id_partida_pres
        and pres_aut_presupuesto_aut_copia.year_presupuesto ='.$year.'');



        $array_partidas= array();

        $total_enero=0;
        $total_febrero=0;
        $total_marzo=0;
        $total_abril=0;
        $total_mayo=0;
        $total_junio=0;
        $total_julio=0;
        $total_agosto=0;
        $total_septiembre=0;
        $total_octubre=0;
        $total_noviembre=0;
        $total_diciembre=0;
        foreach ($partidas_reg as $partida)
        {

            $dat['id_presupuesto_aut_copia']=$partida->id_presupuesto_aut_copia;
            $dat['year_presupuesto']=$partida->year_presupuesto;
            $dat['id_partida']=$partida->id_partida;
            $dat['total_presupuesto']=$partida->total_presupuesto;
            $dat['enero_pres']=$partida->enero_pres;

            $soli_enero=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =1');

           if($soli_enero == null){
               $suma_soli_enero=0;
           }else{
               $suma_soli_enero=0;
               foreach ($soli_enero as $soli_enero){
                   $suma_soli_enero=$suma_soli_enero+$soli_enero->presupuesto_dado;
               }
           }
            $dat['enero_utilizado']=$suma_soli_enero;
            $dat['enero_pres_total']=$partida->enero_pres-$suma_soli_enero;

            $total_enero=$total_enero+$partida->enero_pres;
            $dat['febrero_pres']=$partida->febrero_pres;

            $soli_febrero=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =2');

            if($soli_febrero == null){
                $suma_soli_febrero=0;
            }else{
                $suma_soli_febrero=0;
                foreach ($soli_febrero as $soli_febrero){
                    $suma_soli_febrero=$suma_soli_febrero+$soli_febrero->presupuesto_dado;
                }
            }
            $dat['febrero_utilizado']=$suma_soli_febrero;
            $dat['febrero_pres_total']=$partida->febrero_pres-$suma_soli_febrero;

            $total_febrero=$total_febrero+$partida->febrero_pres;
            $dat['marzo_pres']=$partida->marzo_pres;

            $soli_marzo=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =3');

            if($soli_marzo == null){
                $suma_soli_marzo=0;
            }else{
                $suma_soli_marzo=0;
                foreach ($soli_marzo as $soli_marzo){
                    $suma_soli_marzo=$suma_soli_marzo+$soli_marzo->presupuesto_dado;
                }
            }
            $dat['marzo_utilizado']=$suma_soli_marzo;
            $dat['marzo_pres_total']=$partida->marzo_pres-$suma_soli_marzo;

            $total_marzo=$total_marzo+$partida->marzo_pres;
            $dat['abril_pres']=$partida->abril_pres;

            $soli_abril=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =4');

            if($soli_abril == null){
                $suma_soli_abril=0;
            }else{
                $suma_soli_abril=0;
                foreach ($soli_abril as $soli_abril){
                    $suma_soli_abril=$suma_soli_abril+$soli_abril->presupuesto_dado;
                }
            }
            $dat['abril_utilizado']=$suma_soli_abril;
            $dat['abril_pres_total']=$partida->abril_pres-$suma_soli_abril;

            $total_abril=$total_abril+$partida->abril_pres;
            $dat['mayo_pres']=$partida->mayo_pres;

            $soli_mayo=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =5');

            if($soli_mayo == null){
                $suma_soli_mayo=0;
            }else{
                $suma_soli_mayo=0;
                foreach ($soli_mayo as $soli_mayo){
                    $suma_soli_mayo=$suma_soli_mayo+$soli_mayo->presupuesto_dado;
                }
            }
            $dat['mayo_utilizado']=$suma_soli_mayo;
            $dat['mayo_pres_total']=$partida->mayo_pres-$suma_soli_mayo;

            $total_mayo=$total_mayo+$partida->mayo_pres;
            $dat['junio_pres']=$partida->junio_pres;

            $soli_junio=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =6');

            if($soli_junio == null){
                $suma_soli_junio=0;
            }else{
                $suma_soli_junio=0;
                foreach ($soli_junio as $soli_junio){
                    $suma_soli_junio=$suma_soli_junio+$soli_junio->presupuesto_dado;
                }
            }
            $dat['junio_utilizado']=$suma_soli_junio;
            $dat['junio_pres_total']=$partida->junio_pres-$suma_soli_junio;

            $total_junio=$total_junio+$partida->junio_pres;
            $dat['julio_pres']=$partida->julio_pres;

            $soli_julio=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =7');

            if($soli_julio == null){
                $suma_soli_julio=0;
            }else{
                $suma_soli_julio=0;
                foreach ($soli_julio as $soli_julio){
                    $suma_soli_julio=$suma_soli_julio+$soli_julio->presupuesto_dado;
                }
            }
            $dat['julio_utilizado']=$suma_soli_julio;
            $dat['julio_pres_total']=$partida->julio_pres-$suma_soli_julio;


            $total_julio=$total_julio+$partida->julio_pres;
            $dat['agosto_pres']=$partida->agosto_pres;

            $soli_agosto=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =8');

            if($soli_agosto == null){
                $suma_soli_agosto=0;
            }else{
                $suma_soli_agosto=0;
                foreach ($soli_agosto as $soli_agosto){
                    $suma_soli_agosto=$suma_soli_agosto+$soli_agosto->presupuesto_dado;
                }
            }
            $dat['agosto_utilizado']=$suma_soli_agosto;
            $dat['agosto_pres_total']=$partida->agosto_pres-$suma_soli_agosto;

            $total_agosto=$total_agosto+$partida->agosto_pres;
            $dat['septiembre_pres']=$partida->septiembre_pres;

            $soli_septiembre=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =9');

            if($soli_septiembre == null){
                $suma_soli_septiembre=0;
            }else{
                $suma_soli_septiembre=0;
                foreach ($soli_septiembre as $soli_septiembre){
                    $suma_soli_septiembre=$suma_soli_septiembre+$soli_septiembre->presupuesto_dado;
                }
            }
            $dat['septiembre_utilizado']=$suma_soli_septiembre;
            $dat['septiembre_pres_total']=$partida->septiembre_pres-$suma_soli_septiembre;

            $total_septiembre=$total_septiembre+$partida->septiembre_pres;
            $dat['octubre_pres']=$partida->octubre_pres;

            $soli_octubre=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =10');

            if($soli_octubre == null){
                $suma_soli_octubre=0;
            }else{
                $suma_soli_octubre=0;
                foreach ($soli_octubre as $soli_octubre){
                    $suma_soli_octubre=$suma_soli_octubre+$soli_octubre->presupuesto_dado;
                }
            }
            $dat['octubre_utilizado']=$suma_soli_octubre;
            $dat['octubre_pres_total']=$partida->octubre_pres-$suma_soli_octubre;

            $total_octubre=$total_octubre+$partida->octubre_pres;
            $dat['noviembre_pres']=$partida->noviembre_pres;

            $soli_noviembre=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =11');

            if($soli_noviembre == null){
                $suma_soli_noviembre=0;
            }else{
                $suma_soli_noviembre=0;
                foreach ($soli_noviembre as $soli_noviembre){
                    $suma_soli_noviembre=$suma_soli_noviembre+$soli_noviembre->presupuesto_dado;
                }
            }
            $dat['noviembre_utilizado']=$suma_soli_noviembre;
            $dat['noviembre_pres_total']=$partida->noviembre_pres-$suma_soli_noviembre;

            $total_noviembre=$total_noviembre+$partida->noviembre_pres;
            $dat['diciembre_pres']=$partida->diciembre_pres;

            $soli_diciembre=DB::select('SELECT pres_aut_solicitudes.*, pres_aut_solicitudes_partidas.id_partida_pres, pres_aut_solicitudes_partidas.presupuesto_dado
            from pres_aut_solicitudes, pres_aut_solicitudes_partidas where pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud
            and pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' and
            pres_aut_solicitudes.year_presupuesto = '.$partida->year_presupuesto.' and pres_aut_solicitudes.id_mes =12');

            if($soli_diciembre == null){
                $suma_soli_diciembre=0;
            }else{
                $suma_soli_diciembre=0;
                foreach ($soli_diciembre as $soli_diciembre){
                    $suma_soli_diciembre=$suma_soli_diciembre+$soli_diciembre->presupuesto_dado;
                }
            }
            $dat['diciembre_utilizado']=$suma_soli_diciembre;
            $dat['diciembre_pres_total']=$partida->diciembre_pres-$suma_soli_diciembre;

            $total_diciembre=$total_diciembre+$partida->diciembre_pres;
            $dat['nombre_partida']=$partida->nombre_partida;
            $dat['clave_presupuestal']=$partida->clave_presupuestal;

            array_push($array_partidas,$dat);

        }
       // dd($array_partidas);

        $total_presupuesto=$total_enero+$total_febrero+$total_marzo+$total_abril+$total_mayo+$total_junio+$total_julio+$total_agosto+$total_septiembre+$total_octubre+$total_noviembre+$total_diciembre;

        $estado_presupuesto=DB::selectOne('SELECT pres_aut_estado_presupuesto.* from pres_aut_estado_presupuesto where year_estado = '.$year.'');
        if($estado_presupuesto == null)
        {
            $estado_presupuesto =0;
        }else{
            $estado_presupuesto =1;
        }



        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.presupuesto_autorizado_copia',compact('estado_presupuesto','total_presupuesto','year','array_partidas','total_enero',
            'total_febrero','total_febrero','total_marzo','total_abril','total_mayo','total_junio','total_julio','total_agosto','total_septiembre','total_octubre','total_noviembre','total_diciembre'));

    }
    public function guardar_nueva_solicitud(Request $request, $year,$id_unidad_admin){

        $id_proyecto = $request->input("id_proyecto");
        $descripcion_solicitud = $request->input("descripcion_solicitud");
        $meta = $request->input("meta1");
        $id_mes = $request->input("id_mes");

        $fecha_actual = date('d-m-Y');

        $numero_solicitud=DB::selectOne('SELECT max(numero_solicitud) numero from pres_aut_solicitudes 
        where id_unidad_admin = '.$id_unidad_admin.' and year_presupuesto = '.$year.'');

        if($numero_solicitud == null)
        {
            $numero_solicitud=1;

        }else{
            $numero_solicitud=$numero_solicitud->numero+1;
        }

        DB:: table('pres_aut_solicitudes')->insert([
            'year_presupuesto' => $year,
            'id_unidad_admin' => $id_unidad_admin,
            'numero_solicitud' => $numero_solicitud,
            'id_proyecto' => $id_proyecto,
            'id_meta' => $meta,
            'id_mes' => $id_mes,
            'fecha_registro' => $fecha_actual,
            'descripcion_solicitud' => $descripcion_solicitud
        ]);
        return back();

    }
    public function agregar_partida_solicitud($id_solicitud){
       $meses = DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` DESC');

       $solicitud=DB::selectOne('SELECT pres_aut_solicitudes.*, pres_proyectos.nombre_proyecto, pres_mes.mes FROM pres_aut_solicitudes, pres_proyectos, 
        pres_mes WHERE pres_aut_solicitudes.id_proyecto = pres_proyectos.id_proyecto and pres_aut_solicitudes.id_mes = pres_mes.id_mes
        and pres_aut_solicitudes.id_solicitud = '.$id_solicitud.'');


        $metas=DB::select('SELECT * FROM `pres_metas` WHERE `id_proyecto` = '.$solicitud->id_proyecto.' ORDER BY `pres_metas`.`meta` ASC');


       $partidas=DB::select('SELECT pres_aut_presupuesto_aut_copia.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
       from pres_aut_presupuesto_aut_copia, pres_partida_pres WHERE pres_aut_presupuesto_aut_copia.id_partida = pres_partida_pres.id_partida_pres 
       and pres_aut_presupuesto_aut_copia.year_presupuesto = '.$solicitud->year_presupuesto.'');


       return  view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.agregar_partida_solicitud', compact('meses','solicitud','partidas','id_solicitud','metas'));

    }
    public function ver_presupuesto_partida($id_presupuesto,$id_mes){

        $partida=DB::selectOne('SELECT * FROM `pres_aut_presupuesto_aut_copia` WHERE `id_presupuesto_aut_copia` = '.$id_presupuesto.'');

        $suma_presupuesto_dato=DB::selectOne('SELECT SUM(pres_aut_solicitudes_partidas.presupuesto_dado)suma 
          from pres_aut_solicitudes_partidas, pres_aut_solicitudes where pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida.' 
          and pres_aut_solicitudes.id_mes = '.$id_mes.' and pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud 
          and pres_aut_solicitudes.year_presupuesto ='.$partida->year_presupuesto.'');



        if($suma_presupuesto_dato == null){
            $suma_presupuesto_dato = 0;
        }else{
            $suma_presupuesto_dato = $suma_presupuesto_dato->suma;
        }

        if($id_mes == 1){
          $presupuesto_partida= $partida->enero_pres;
        }
        if($id_mes == 2){
            $presupuesto_partida= $partida->febrero_pres;
        }
        if($id_mes == 3){
            $presupuesto_partida= $partida->marzo_pres;
        }
        if($id_mes == 4){
            $presupuesto_partida= $partida->abril_pres;
        }
        if($id_mes == 5){
            $presupuesto_partida= $partida->mayo_pres;
        }
        if($id_mes == 6){
            $presupuesto_partida= $partida->junio_pres;
        }
        if($id_mes == 7){
            $presupuesto_partida= $partida->julio_pres;
        }
        if($id_mes == 8){
            $presupuesto_partida= $partida->agosto_pres;
        }
        if($id_mes == 9){
            $presupuesto_partida= $partida->septiembre_pres;
        }
        if($id_mes == 10){
            $presupuesto_partida= $partida->octubre_pres;
        }
        if($id_mes == 11){
            $presupuesto_partida= $partida->noviembre_pres;
        }
        if($id_mes == 12){
            $presupuesto_partida= $partida->diciembre_pres;
        }

        $resto_presupuesto= $presupuesto_partida -$suma_presupuesto_dato;


        return $resto_presupuesto;
    }
    public function guardar_partida_solicitud(Request $request){
        $id_solicitud = $request->input('id_solicitud');
        $solicitud= DB::selectOne('SELECT * FROM `pres_aut_solicitudes` WHERE `id_solicitud` ='.$id_solicitud.'');

        $id_presupuesto_aut_copia = $request->input('id_presupuesto_aut_copia');
        $id_estado_sobrante = $request->input('id_estado_sobrante');
        $presupuesto_s = $request->input('presupuesto_s');
        $presupuesto_dar = $request->input('presupuesto_dar');

        $presupuesto_copia=DB::selectOne('SELECT * FROM `pres_aut_presupuesto_aut_copia` WHERE `id_presupuesto_aut_copia` ='.$id_presupuesto_aut_copia.'');


        DB:: table('pres_aut_solicitudes_partidas')->insert([
            'id_solicitud' => $id_solicitud,
            'id_partida_pres' => $presupuesto_copia->id_partida,
            'presupuesto_dado' => $presupuesto_dar,
            'id_tipo_requisicion' => 2,
        ]);
        return back();
    }
    public function enviar_solicitud_departamento($id_solicitud){
        $contar_requisiciones= DB::selectOne('SELECT count(id_solicitud_partida) contar 
        from pres_aut_solicitudes_partidas where id_solicitud ='.$id_solicitud.'');

        $contar_req=0;
        $presupuesto_dado=0;
        if($contar_requisiciones->contar == 0)
        {
            $contar_req=0;
            $presupuesto_dado=0;
        }else{
            $contar_req=1;

            $requisiciones= DB::select('SELECT * FROM `pres_aut_solicitudes_partidas` WHERE `id_solicitud` ='.$id_solicitud.'');
            foreach($requisiciones as $requisicion){
                if($requisicion->presupuesto_dado == 0){
                    $presupuesto_dado=$presupuesto_dado+1;
                }
                else{
                    $presupuesto_dado=$presupuesto_dado+0;
                }
            }

        }


       $solicitud=DB::selectOne('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento, pres_proyectos.nombre_proyecto,
       pres_proyectos.year from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos where
       pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin and pres_aut_solicitudes.id_proyecto = pres_proyectos.id_proyecto 
       and pres_aut_solicitudes.id_solicitud = '.$id_solicitud.'');


        return  view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.partials_enviar_solicitud', compact('solicitud','presupuesto_dado','contar_req'));

    }
    public function guardar_enviar_solicitud(Request $request,$id_solicitud){
        $solicitud= DB::selectOne('SELECT * FROM `pres_aut_solicitudes` WHERE `id_solicitud` ='.$id_solicitud.'');

        //// jefe de direccion
        $jefe_finanzas=DB::selectOne('SELECT gnral_unidad_administrativa.nom_departamento, gnral_unidad_personal.id_unidad_persona, 
        gnral_unidad_personal.id_personal, gnral_unidad_personal.id_unidad_admin, gnral_personales.nombre,gnral_personales.correo, abreviaciones.titulo 
        from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones 
        where gnral_unidad_administrativa.id_unidad_admin = 22 and gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin
        and gnral_unidad_personal.id_personal = gnral_personales.id_personal and abreviaciones_prof.id_personal = gnral_personales.id_personal 
          and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        $year=$solicitud->year_presupuesto;

        /// ...............................////

        $nombre_jefe_finan=$jefe_finanzas->titulo." ".$jefe_finanzas->nombre;
        $correo_jefe_finan=$jefe_finanzas->correo;
        ///
        //// jefe de departamento
        $jefe_departamento=DB::selectOne('SELECT gnral_unidad_administrativa.nom_departamento, gnral_unidad_personal.id_unidad_persona, 
        gnral_unidad_personal.id_personal, gnral_unidad_personal.id_unidad_admin, gnral_personales.nombre,gnral_personales.correo, abreviaciones.titulo 
        from gnral_unidad_administrativa, gnral_unidad_personal, gnral_personales, abreviaciones_prof, abreviaciones 
        where gnral_unidad_administrativa.id_unidad_admin = '.$solicitud->id_unidad_admin.' and gnral_unidad_administrativa.id_unidad_admin = gnral_unidad_personal.id_unidad_admin
        and gnral_unidad_personal.id_personal = gnral_personales.id_personal and abreviaciones_prof.id_personal = gnral_personales.id_personal 
          and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        /// ...............................////
        $nombre_jefe_dep=$jefe_departamento->titulo." ".$jefe_departamento->nombre;
        $correo_jefe_dep=$jefe_departamento->correo;

        ///
        Mail::send('departamento_finanzas.presupuesto_autorizado.notificaciones.notificacion_envio_solicitud',["nombre_jefe_finan"=>$nombre_jefe_finan,"correo_jefe_finan"=>$correo_jefe_finan,"year"=>$year], function($message)use($nombre_jefe_finan,$correo_jefe_dep,$year)
        {
            $message->from(Auth::user()->email, 'Jefa de la Dirección de Administracción y Finanzas: '.$nombre_jefe_finan);
            $message->to($correo_jefe_dep,"")->subject('Notificación de solicitud presupuesto autorizado del '.$year);
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });

        $fecha_actual = date('d-m-Y');


        DB::table('pres_aut_solicitudes')
            ->where('id_solicitud', $id_solicitud)
            ->update([
                'id_estado_enviado' => 1,
                'fecha_enviado' => $fecha_actual,
            ]);

        return back();
    }
    public function editar_presupuesto_partida_dep($id_solicitud_partida){
     $partida=DB::selectOne('SELECT pres_aut_solicitudes_partidas.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
     from pres_aut_solicitudes_partidas, pres_partida_pres where pres_aut_solicitudes_partidas.id_partida_pres = pres_partida_pres.id_partida_pres 
     and pres_aut_solicitudes_partidas.id_solicitud_partida ='.$id_solicitud_partida.'');



     $solicitud=DB::selectOne('SELECT * FROM `pres_aut_solicitudes` WHERE `id_solicitud` ='.$partida->id_solicitud.'');

        $suma_presupuesto_dato=DB::selectOne('SELECT SUM(pres_aut_solicitudes_partidas.presupuesto_dado)suma 
          from pres_aut_solicitudes_partidas, pres_aut_solicitudes where pres_aut_solicitudes_partidas.id_partida_pres = '.$partida->id_partida_pres.' 
          and pres_aut_solicitudes.id_mes = '.$solicitud->id_mes.' and pres_aut_solicitudes.id_solicitud = pres_aut_solicitudes_partidas.id_solicitud 
          and pres_aut_solicitudes.year_presupuesto ='.$solicitud->year_presupuesto.'');


        $presupuesto=DB::selectOne('SELECT * FROM `pres_aut_presupuesto_aut_copia` WHERE `year_presupuesto` = '.$solicitud->year_presupuesto.' AND `id_partida` ='.$partida->id_partida_pres.'');

        if($suma_presupuesto_dato == null){
            $suma_presupuesto_dato = 0;
        }else{
            $suma_presupuesto_dato = $suma_presupuesto_dato->suma;
        }

        if($presupuesto == null){
            $presupuesto_partida = 0;
        }else {

            if ($solicitud->id_mes == 1) {
                $presupuesto_partida = $presupuesto->enero_pres;
            }
            if ($solicitud->id_mes == 2) {
                $presupuesto_partida = $presupuesto->febrero_pres;
            }
            if ($solicitud->id_mes == 3) {
                $presupuesto_partida = $presupuesto->marzo_pres;
            }
            if ($solicitud->id_mes == 4) {
                $presupuesto_partida = $presupuesto->abril_pres;
            }
            if ($solicitud->id_mes == 5) {
                $presupuesto_partida = $presupuesto->mayo_pres;
            }
            if ($solicitud->id_mes == 6) {
                $presupuesto_partida = $presupuesto->junio_pres;
            }
            if ($solicitud->id_mes == 7) {
                $presupuesto_partida = $presupuesto->julio_pres;
            }
            if ($solicitud->id_mes == 8) {
                $presupuesto_partida = $presupuesto->agosto_pres;
            }
            if ($solicitud->id_mes == 9) {
                $presupuesto_partida = $presupuesto->septiembre_pres;
            }
            if ($solicitud->id_mes == 10) {
                $presupuesto_partida = $presupuesto->octubre_pres;
            }
            if ($solicitud->id_mes == 11) {
                $presupuesto_partida = $presupuesto->noviembre_pres;
            }
            if ($solicitud->id_mes == 12) {
                $presupuesto_partida = $presupuesto->diciembre_pres;
            }
        }




        $resto_presupuesto= $presupuesto_partida -$suma_presupuesto_dato;

        $resto_presupuesto = $resto_presupuesto+$partida->presupuesto_dado;







        return  view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.partials_agregar_presupuesto_partida', compact('partida','resto_presupuesto'));

    }
    public function guardar_presupuesto_dado(Request $request, $id_solicitud_partida){
        $fecha_actual = date('d-m-Y');
        $pres_dar = $request->input('pres_dar');

        DB::table('pres_aut_solicitudes_partidas')
            ->where('id_solicitud_partida', $id_solicitud_partida)
            ->update([
                'presupuesto_dado' => $pres_dar,
                'fecha_modificacion' => $fecha_actual,
            ]);

        return back();

    }
    public function eliminacion_partida_solicitud($id_solicitud_partida){

        $partida=DB::selectOne('SELECT pres_aut_solicitudes_partidas.*, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal 
     from pres_aut_solicitudes_partidas, pres_partida_pres where pres_aut_solicitudes_partidas.id_partida_pres = pres_partida_pres.id_partida_pres 
     and pres_aut_solicitudes_partidas.id_solicitud_partida ='.$id_solicitud_partida.'');

        return view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.eliminar_partida_solicitud', compact('partida'));
    }
    public function guardar_eliminacion_partida($id_solicitud_partida){
        DB::delete('DELETE FROM pres_aut_materiales_partidas WHERE 	id_solicitud_partida='.$id_solicitud_partida.'');
        DB::delete('DELETE FROM pres_aut_solicitudes_partidas WHERE 	id_solicitud_partida='.$id_solicitud_partida.'');
        return back();

    }
    public function  eliminacion_solicitud($id_solicitud){
        $solicitud=DB::selectOne('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento, pres_proyectos.nombre_proyecto,
       pres_proyectos.year from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos where
       pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin and pres_aut_solicitudes.id_proyecto = pres_proyectos.id_proyecto 
       and pres_aut_solicitudes.id_solicitud = '.$id_solicitud.'');

        return  view('departamento_finanzas.presupuesto_autorizado.agregar_presupuesto.eliminar_solicitud', compact('solicitud'));

    }
    public function  guardar_eliminacion_solicitud($id_solicitud){

        $solicitud_partida= DB::select('SELECT * FROM `pres_aut_solicitudes_partidas` WHERE `id_solicitud` ='.$id_solicitud.'');

        foreach ($solicitud_partida as $solicitud) {
            DB::delete('DELETE FROM pres_aut_materiales_partidas WHERE 	id_solicitud_partida='.$solicitud->id_solicitud_partida.'');

        }
        DB::delete('DELETE FROM pres_aut_solicitudes_partidas WHERE 	id_solicitud='.$id_solicitud.'');
        DB::delete('DELETE FROM pres_aut_solicitudes WHERE 	id_solicitud='.$id_solicitud.'');
        return back();


    }


}
