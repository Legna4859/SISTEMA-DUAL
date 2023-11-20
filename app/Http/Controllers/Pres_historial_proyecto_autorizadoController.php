<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Pres_historial_proyecto_autorizadoController extends Controller
{
    public function index(){
        $year = date('Y');
        //  $years=DB::select('SELECT * FROM `pres_year` WHERE `descripcion` <='.$year.'');
        $years=DB::select('SELECT * FROM `pres_year` ');
        return view('departamento_finanzas.jefe_finanazas.historial_proyecto.inicio_presupuesto_autorizado_historial',compact('years'));
    }
    public function menu_presupuesto_autorizado_historial($id_year){
        $year=DB::selectOne('SELECT * FROM `pres_year` WHERE `id_year` = '.$id_year.'');

        return view('departamento_finanzas.jefe_finanazas.historial_proyecto.menu_presupuesto_autorizado_historial',compact('year','id_year'));
    }
    public function presupesto_partida_historial($id_year){

        $years=DB::selectOne('SELECT * FROM `pres_year` WHERE `id_year` = '.$id_year.'');

        $year=$years->descripcion;
        $id_year=$years->id_year;

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

        return view('departamento_finanzas.jefe_finanazas.historial_proyecto.partidas_presupuesto_historial',compact('id_year','estado_presupuesto','total_presupuesto','year','partidas','array_partidas','total_enero',
            'total_febrero','total_febrero','total_marzo','total_abril','total_mayo','total_junio','total_julio','total_agosto','total_septiembre','total_octubre','total_noviembre','total_diciembre'));

    }
    public function presupesto_partida_copia_historial($id_year)
    {
        $years=DB::selectOne('SELECT * FROM `pres_year` WHERE `id_year` = '.$id_year.'');

        $year=$years->descripcion;
        $id_year=$years->id_year;

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



        return view('departamento_finanzas.jefe_finanazas.historial_proyecto.presupuesto_autorizado_copia_historial',compact('id_year','estado_presupuesto','total_presupuesto','year','array_partidas','total_enero',
            'total_febrero','total_febrero','total_marzo','total_abril','total_mayo','total_junio','total_julio','total_agosto','total_septiembre','total_octubre','total_noviembre','total_diciembre'));

    }
    public function solicitudes_autorizadas_departamentos_historial($id_year){
        $years=DB::selectOne('SELECT * FROM `pres_year` WHERE `id_year` = '.$id_year.'');

        $year=$years->descripcion;
        $id_year=$years->id_year;


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

        return view('departamento_finanzas.jefe_finanazas.historial_proyecto.solicitudes_autorizadas_dep_historial',compact('departamentos','id_year','year'));

    }
    public function solicitudes_ver_departamento_historial($id_unidad_admin,$id_year){
        $years=DB::selectOne('SELECT * FROM `pres_year` WHERE `id_year` = '.$id_year.'');

        $year=$years->descripcion;
        $id_year=$years->id_year;

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

        return view('departamento_finanzas.jefe_finanazas.historial_proyecto.ver_solicitudes_departamento_historial',compact('solicitudes','departamento','id_unidad_admin','id_year','year'));

    }
    public function mostrar_doc_solicitud_historial($id_solicitud,$id_unidad_admin){



        $solicitud=DB::selectOne('SELECT pres_aut_solicitudes.*, gnral_unidad_administrativa.nom_departamento,
        pres_proyectos.nombre_proyecto, pres_metas.meta, pres_mes.mes from pres_aut_solicitudes, gnral_unidad_administrativa, pres_proyectos, 
        pres_metas, pres_mes where pres_aut_solicitudes.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin 
        and pres_proyectos.id_proyecto = pres_aut_solicitudes.id_proyecto and pres_aut_solicitudes.id_meta = pres_metas.id_meta and 
        pres_aut_solicitudes.id_mes = pres_mes.id_mes and pres_aut_solicitudes.id_solicitud = '.$id_solicitud.'');

        $years=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` = '.$solicitud->year_presupuesto.'');
        $year=$years->descripcion;
        $id_year=$years->id_year;

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
        return view('departamento_finanzas.jefe_finanazas.historial_proyecto.solicitudes_autorizadas_historial',compact('id_year','year','estado_solicitud','solicitud','documentos','partidas','id_solicitud','departamento','id_unidad_admin'));


    }


}
