<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Pres_historial_anteproyectosController extends Controller
{
    public function index(){
        $year = date('Y');
      //  $years=DB::select('SELECT * FROM `pres_year` WHERE `descripcion` <='.$year.'');
        $years=DB::select('SELECT * FROM `pres_year` ');
        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.inicio_historial_anteproyecto',compact('years'));
    }
    public function inicio_historial_anteproyecto_year($id_year){
        $year=DB::selectOne('SELECT * FROM `pres_year` WHERE `id_year` = '.$id_year.'');

        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.menu_year_anteproyecto',compact('year','id_year'));

    }
    public function historial_anteproyecto_techo($id_year){
        $years=DB::selectOne('SELECT * FROM `pres_year` WHERE `id_year` = '.$id_year.'');

        $year = $years->descripcion;

        $proyectos=DB::select('SELECT * FROM `pres_proyectos` 
        where   year = '.$year.' and id_estado = 1 and id_proyecto 
        NOT in (SELECT id_proyecto from pres_presupuesto_anteproyecto where year ='.$year.')
        ORDER BY `nombre_proyecto` ASC');

        $registro_proyectos=DB::select('SELECT pres_presupuesto_anteproyecto.*, pres_proyectos.nombre_proyecto 
        from pres_presupuesto_anteproyecto, pres_proyectos WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto
        and pres_presupuesto_anteproyecto.year='.$year.' ORDER BY pres_proyectos.nombre_proyecto ASC');

        $presupuestos_anteproyectos=array();
        $contar_f=0;

        foreach ($registro_proyectos as $registro_proyecto) {
            $reg['id_presupuesto']=$registro_proyecto->id_presupuesto;
            $reg['id_proyecto']=$registro_proyecto->id_proyecto;
            $reg['year']=$registro_proyecto->year;
            $reg['nombre_proyecto']=$registro_proyecto->nombre_proyecto;

            $reg_fuentes=array();
            $fuentes_financiamiento=DB::select('SELECT pres_fuentes_financiamiento.* 
            from pres_fuentes_financiamiento where id_presupuesto_ante ='.$registro_proyecto->id_presupuesto.' ORDER BY id_capitulo ASC');
            $total_presupuesto_estatal=0;
            $total_presupuesto_federal=0;
            $total_presupuesto_propios=0;
            $total_total_presupuesto=0;
            $total_porcentaje_proyecto=0;
            $total_presupuesto_proyecto=0;
            $total_financiamiento_estatal=0;
            $total_financiamiento_federal=0;
            $total_financiamiento_propios=0;
            $total_total_financiamiento=0;
            $gastos_operativos=0;
            foreach ($fuentes_financiamiento as $fuente){
                $contar_f++;
                $fuent['id_fuente_financiamiento']=$fuente->id_fuente_financiamiento;
                $fuent['id_capitulo']=$fuente->id_capitulo;
                if($fuente->id_capitulo == 1){
                    $fuent['nombre_capitulo']=1000;
                }elseif($fuente->id_capitulo == 2){
                    $fuent['nombre_capitulo']=2000;
                    $gastos_operativos=$gastos_operativos+$fuente->total_presupuesto;
                }elseif($fuente->id_capitulo == 3){
                    $fuent['nombre_capitulo']=3000;
                    $gastos_operativos=$gastos_operativos+$fuente->total_presupuesto;
                }elseif($fuente->id_capitulo == 4){
                    $fuent['nombre_capitulo']=4000;
                    $gastos_operativos=$gastos_operativos+$fuente->total_presupuesto;
                }elseif($fuente->id_capitulo == 5){
                    $fuent['nombre_capitulo']=5000;
                    $gastos_operativos=$gastos_operativos+$fuente->total_presupuesto;
                }elseif($fuente->id_capitulo == 6){
                    $fuent['nombre_capitulo']=6000;
                    $gastos_operativos=$gastos_operativos+$fuente->total_presupuesto;
                }
                $fuent['presupuesto_estatal']=$fuente->presupuesto_estatal;
                $total_presupuesto_estatal=$total_presupuesto_estatal+$fuente->presupuesto_estatal;
                $fuent['presupuesto_federal']=$fuente->presupuesto_federal;
                $total_presupuesto_federal=$total_presupuesto_federal+$fuente->presupuesto_federal;
                $fuent['presupuesto_propios']=$fuente->presupuesto_propios;
                $total_presupuesto_propios= $total_presupuesto_propios+$fuente->presupuesto_propios;
                $fuent['total_presupuesto']=$fuente->total_presupuesto;
                $total_total_presupuesto= $total_total_presupuesto+$fuente->total_presupuesto;
                $fuent['financiamiento_estatal']=$fuente->financiamiento_estatal;

                $fuent['financiamiento_federal']=$fuente->financiamiento_federal;

                $fuent['financiamiento_propios']=$fuente->financiamiento_propios;

                $fuent['total_financiamiento']=$fuente->total_financiamiento;

                array_push($reg_fuentes,$fuent);
            }
            $reg['fuentes_f']=$reg_fuentes;
            $reg['total_presupuesto_estatal']=$total_presupuesto_estatal;
            $reg['total_presupuesto_federal']=$total_presupuesto_federal;
            $reg['total_presupuesto_propios']=$total_presupuesto_propios;
            $reg['total_total_presupuesto']=$total_presupuesto_estatal+$total_presupuesto_federal+$total_presupuesto_propios;
            $total_presupuesto_proyecto=$total_presupuesto_estatal+$total_presupuesto_federal+$total_presupuesto_propios;
            if($total_presupuesto_estatal == 0){
                $total_presupuesto_estatal=$total_presupuesto_estatal;

            }else{
                $total_presupuesto_estatal=round($total_presupuesto_estatal/$total_presupuesto_proyecto,4);
            }
            $reg['total_financiamiento_estatal']=$total_presupuesto_estatal;
            if($total_presupuesto_federal == 0){
                $total_presupuesto_federal=$total_presupuesto_federal;

            }else{
                $total_presupuesto_federal=round($total_presupuesto_federal/$total_presupuesto_proyecto,4);
            }
            $reg['total_financiamiento_federal']=$total_presupuesto_federal;
            if($total_presupuesto_propios == 0){
                $total_presupuesto_propios=$total_presupuesto_propios;

            }else{
                $total_presupuesto_propios=round($total_presupuesto_propios/$total_presupuesto_proyecto,4);
            }
            $reg['total_financiamiento_propios']=$total_presupuesto_propios;
            $reg['total_gastos_operativos']=$gastos_operativos;
            $reg['total_total_financiamiento']=$total_presupuesto_estatal+$total_presupuesto_federal+$total_presupuesto_propios;

            array_push($presupuestos_anteproyectos,$reg);
        }
        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.techo_presupuestal_historial',compact('proyectos','year','presupuestos_anteproyectos','contar_f','years','id_year'));

    }
    public function historial_anteproyecto_proyectos($id_year){
        $years=DB::selectOne('SELECT * FROM `pres_year` WHERE `id_year` = '.$id_year.'');
        $year = $years->descripcion;


        $registro_proyectos=DB::select('SELECT pres_presupuesto_anteproyecto.*, pres_proyectos.nombre_proyecto 
        from pres_presupuesto_anteproyecto, pres_proyectos WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto
        and pres_presupuesto_anteproyecto.year='.$year.' ORDER BY pres_proyectos.nombre_proyecto ASC');
        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.inicio_req_aut_proy_historial',compact('year','registro_proyectos','id_year'));

    }
    public function proyecto_inicio_anteproyecto_historial($id_presupuesto){
        $proyecto= DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
         WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');

        $presupueto=DB::selectOne('SELECT * FROM `pres_presupuesto_anteproyecto` WHERE `id_presupuesto` ='.$id_presupuesto.'');

        $year=$presupueto->year;
        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` = '.$year.'');
        $id_year = $id_year->id_year;

        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.inicio_proyecto_anteproyecto_historial',compact('proyecto','id_presupuesto','year','id_year'));
    }
    public function presupuesto_total_anteproyecto_historial($id_presupuesto){

        $proyecto= DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');

        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` = '.$proyecto->year.'');
        $id_year=$id_year->id_year;
        $year=$proyecto->year;
        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy=DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = '.$id_presupuesto.' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');



/////////777///////7
        $presupuesto_proyecto=DB::select('SELECT *  FROM `pres_fuentes_financiamiento` 
        WHERE `id_presupuesto_ante` = '.$id_presupuesto.'  and total_presupuesto >0 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $array_capitulos=array();
        $suma_total_capitulo=0;
        foreach($presupuesto_proyecto as $presupuesto){

            $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$presupuesto->id_capitulo.'');

            if($contar_partida->contar == 0){

            }else{
                $dat_cap['id_fuente_financiamiento']=$presupuesto->id_fuente_financiamiento;
                $dat_cap['id_presupuesto_ante']=$presupuesto->id_presupuesto_ante;
                $dat_cap['id_capitulo']=$presupuesto->id_capitulo;
                $dat_cap['presupuesto_estatal']=$presupuesto->presupuesto_estatal;
                $dat_cap['presupuesto_federal']=$presupuesto->presupuesto_federal;
                $dat_cap['presupuesto_propios']=$presupuesto->presupuesto_propios;
                $dat_cap['total_presupuesto']=$presupuesto->total_presupuesto;
                $dat_cap['financiamiento_estatal']=$presupuesto->financiamiento_estatal;
                $dat_cap['financiamiento_federal']=$presupuesto->financiamiento_federal;
                $dat_cap['financiamiento_propios']=$presupuesto->financiamiento_propios;
                $dat_cap['total_financiamiento']=$presupuesto->total_financiamiento;

                $partidas=DB::select('SELECT pres_partida_pres.* from pres_partida_pres 
               WHERE id_capitulo = '.$presupuesto->id_capitulo.' ORDER BY `clave_presupuestal` ASC');


                $array_partidas=array();
                foreach ($partidas as $partida){
                    $dat_p['id_partida_pres']= $partida->id_partida_pres;
                    $dat_p['id_capitulo']= $partida->id_capitulo;
                    $dat_p['nombre_partida']= $partida->nombre_partida;
                    $dat_p['clave_presupuestal']= $partida->clave_presupuestal;

                    $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `id_mes` ASC');
                    $array_meses=array();
                    $suma_total_mes=0;
                    foreach ($meses as $mes){
                        $dat_meses['id_mes']=$mes->id_mes;
                        $dat_meses['mes']=$mes->mes;
                        $requisiciones=DB::select('SELECT pres_actividades_req_ante.* from pres_actividades_req_ante,
                       pres_req_mat_ante where pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' and pres_actividades_req_ante.id_partida_pres = '.$partida->id_partida_pres.' 
                       and pres_actividades_req_ante.id_mes  = '.$mes->id_mes.' and pres_actividades_req_ante.id_autorizacion= 4
                        and pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and  pres_req_mat_ante.year_requisicion= '.$proyecto->year.' ');

                        $suma_req1=0;
                        $array_req=array();
                        foreach ($requisiciones as $requisicion){
                            $suma_req=DB::selectOne('SELECT SUM(importe) suma_material from pres_reg_material_req_ante WHERE id_actividades_req_ante = '.$requisicion->id_actividades_req_ante.'');

                            if($suma_req== null ){
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;

                                $dat_req['suma_importe_material']=0;
                            }else{
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;
                                $dat_req['suma_importe_material']=$suma_req->suma_material;

                                $suma_req1=$suma_req1+$suma_req->suma_material;
                            }
                            array_push($array_req,$dat_req);

                        }


                        $dat_meses['requisiciones']=$array_req;
                        $dat_meses['suma_req_mes']=$suma_req1;
                        $suma_total_mes=$suma_total_mes+$suma_req1;
                        array_push($array_meses,$dat_meses);
                    }

                    $dat_p['array_meses']=$array_meses;
                    $dat_p['suma_presupuestal_year']=$suma_total_mes;
                    $suma_total_capitulo=$suma_total_capitulo+$suma_total_mes;
                    array_push($array_partidas,$dat_p);

                }
                $dat_cap['array_partidas']=$array_partidas;
                $dat_cap['suma_total_capitulo']=$suma_total_capitulo;
                array_push($array_capitulos,$dat_cap);
            }
        }



//dd($proyecto);
        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.req_proyecto_historial',compact('id_year','year','array_capitulos','proyecto','presupuesto_ante_proy','id_presupuesto'));

    }
    public function proyecto_capitulo_anteproyecto_historial($id_presupuesto){
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` = '.$proyecto->year.'');
        $id_year=$id_year->id_year;

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 0;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');


        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.proyecto_capitulos_anteproyecto_historial', compact('id_year','proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto'));


    }
    public function ver_proyecto_capitulo_anteproyecto_historial($id_fuente_financiamiento){
        $fuente_financiamiento=DB::select('SELECT  pres_fuentes_financiamiento.* from 
     pres_fuentes_financiamiento where id_fuente_financiamiento ='.$id_fuente_financiamiento.'');

        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $fuente_financiamiento[0]->id_presupuesto_ante . ' ');

        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` = '.$proyecto->year.'');
        $id_year=$id_year->id_year;

        $id_presupuesto=$fuente_financiamiento[0]->id_presupuesto_ante;


        $array_capitulos=array();
        $suma_total_capitulo=0;
        foreach($fuente_financiamiento as $presupuesto){

            $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$fuente_financiamiento[0]->id_capitulo.'');

            if($contar_partida->contar == 0){

            }else{
                $dat_cap['id_fuente_financiamiento']=$presupuesto->id_fuente_financiamiento;
                $dat_cap['id_presupuesto_ante']=$presupuesto->id_presupuesto_ante;
                $dat_cap['id_capitulo']=$presupuesto->id_capitulo;
                $dat_cap['presupuesto_estatal']=$presupuesto->presupuesto_estatal;
                $dat_cap['presupuesto_federal']=$presupuesto->presupuesto_federal;
                $dat_cap['presupuesto_propios']=$presupuesto->presupuesto_propios;
                $dat_cap['total_presupuesto']=$presupuesto->total_presupuesto;
                $dat_cap['financiamiento_estatal']=$presupuesto->financiamiento_estatal;
                $dat_cap['financiamiento_federal']=$presupuesto->financiamiento_federal;
                $dat_cap['financiamiento_propios']=$presupuesto->financiamiento_propios;
                $dat_cap['total_financiamiento']=$presupuesto->total_financiamiento;

                $partidas=DB::select('SELECT pres_partida_pres.* from pres_partida_pres 
               WHERE id_capitulo = '.$presupuesto->id_capitulo.' ORDER BY `clave_presupuestal` ASC');


                $array_partidas=array();
                foreach ($partidas as $partida){
                    $dat_p['id_partida_pres']= $partida->id_partida_pres;
                    $dat_p['id_capitulo']= $partida->id_capitulo;
                    $dat_p['nombre_partida']= $partida->nombre_partida;
                    $dat_p['clave_presupuestal']= $partida->clave_presupuestal;

                    $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `id_mes` ASC');
                    $array_meses=array();
                    $suma_total_mes=0;
                    foreach ($meses as $mes){
                        $dat_meses['id_mes']=$mes->id_mes;
                        $dat_meses['mes']=$mes->mes;
                        $requisiciones=DB::select('SELECT pres_actividades_req_ante.* from pres_actividades_req_ante,
                       pres_req_mat_ante where pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' and pres_actividades_req_ante.id_partida_pres = '.$partida->id_partida_pres.' 
                       and pres_actividades_req_ante.id_mes  = '.$mes->id_mes.' and pres_actividades_req_ante.id_autorizacion= 4
                        and pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and  pres_req_mat_ante.year_requisicion= '.$proyecto->year.' ');

                        $suma_req1=0;
                        $array_req=array();
                        foreach ($requisiciones as $requisicion){
                            $suma_req=DB::selectOne('SELECT SUM(importe) suma_material from pres_reg_material_req_ante WHERE id_actividades_req_ante = '.$requisicion->id_actividades_req_ante.'');

                            if($suma_req== null ){
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;

                                $dat_req['suma_importe_material']=0;
                            }else{
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;
                                $dat_req['suma_importe_material']=$suma_req->suma_material;

                                $suma_req1=$suma_req1+$suma_req->suma_material;
                            }
                            array_push($array_req,$dat_req);

                        }


                        $dat_meses['requisiciones']=$array_req;
                        $dat_meses['suma_req_mes']=$suma_req1;
                        $suma_total_mes=$suma_total_mes+$suma_req1;
                        array_push($array_meses,$dat_meses);
                    }

                    $dat_p['array_meses']=$array_meses;
                    $dat_p['suma_presupuestal_year']=$suma_total_mes;
                    $suma_total_capitulo=$suma_total_capitulo+$suma_total_mes;
                    array_push($array_partidas,$dat_p);

                }
                $dat_cap['array_partidas']=$array_partidas;
                $dat_cap['suma_total_capitulo']=$suma_total_capitulo;
                array_push($array_capitulos,$dat_cap);
            }
        }
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 1;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.proyecto_capitulos_anteproyecto_historial', compact('id_year','proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','id_fuente_financiamiento','fuente_financiamiento','array_capitulos'));


    }
    public function proyecto_meses_anteproyecto_historial($id_presupuesto){
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
        $id_year=$id_year->id_year;

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 0;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC');

        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.requ_por_mes_anteproyecto_historial', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','meses','id_year'));

    }
    public function proyecto_meta_anteproyecto_historial($id_presupuesto){
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');
        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
        $id_year=$id_year->id_year;
        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 0;
        $metas =DB::select('SELECT pres_metas.meta, pres_actividades_req_ante.* from pres_metas, pres_actividades_req_ante, pres_req_mat_ante
         where pres_metas.id_meta = pres_actividades_req_ante.id_meta and pres_actividades_req_ante.id_req_mat_ante = pres_req_mat_ante.id_req_mat_ante
         and pres_req_mat_ante.year_requisicion ='.$proyecto->year.'  and pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' group by pres_metas.id_meta');



        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.requ_por_metas_anteproyecto_historial', compact('id_year','proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'metas'));


    }
    public function ver_proyecto_meta_anteproyecto_historial($id_meta,$id_presupuesto){
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
        $id_year=$id_year->id_year;

        $fuente_financiamiento = DB::select('SELECT * FROM `pres_fuentes_financiamiento` WHERE `id_presupuesto_ante` = ' . $id_presupuesto . ' 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $metas =DB::select('SELECT pres_metas.meta, pres_actividades_req_ante.* from pres_metas, pres_actividades_req_ante, pres_req_mat_ante
         where pres_metas.id_meta = pres_actividades_req_ante.id_meta and pres_actividades_req_ante.id_req_mat_ante = pres_req_mat_ante.id_req_mat_ante
         and pres_req_mat_ante.year_requisicion ='.$proyecto->year.'  and pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' group by pres_metas.id_meta');


        $array_capitulos=array();
        $suma_total_capitulo=0;
        foreach($fuente_financiamiento as $presupuesto){

            $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$presupuesto->id_capitulo.'');

            if($contar_partida->contar == 0){

            }else{
                $dat_cap['id_fuente_financiamiento']=$presupuesto->id_fuente_financiamiento;
                $dat_cap['id_presupuesto_ante']=$presupuesto->id_presupuesto_ante;
                $dat_cap['id_capitulo']=$presupuesto->id_capitulo;
                $dat_cap['presupuesto_estatal']=$presupuesto->presupuesto_estatal;
                $dat_cap['presupuesto_federal']=$presupuesto->presupuesto_federal;
                $dat_cap['presupuesto_propios']=$presupuesto->presupuesto_propios;
                $dat_cap['total_presupuesto']=$presupuesto->total_presupuesto;
                $dat_cap['financiamiento_estatal']=$presupuesto->financiamiento_estatal;
                $dat_cap['financiamiento_federal']=$presupuesto->financiamiento_federal;
                $dat_cap['financiamiento_propios']=$presupuesto->financiamiento_propios;
                $dat_cap['total_financiamiento']=$presupuesto->total_financiamiento;

                $partidas=DB::select('SELECT pres_partida_pres.* from pres_partida_pres 
               WHERE id_capitulo = '.$presupuesto->id_capitulo.' ORDER BY `clave_presupuestal` ASC');


                $array_partidas=array();
                foreach ($partidas as $partida){
                    $dat_p['id_partida_pres']= $partida->id_partida_pres;
                    $dat_p['id_capitulo']= $partida->id_capitulo;
                    $dat_p['nombre_partida']= $partida->nombre_partida;
                    $dat_p['clave_presupuestal']= $partida->clave_presupuestal;

                    $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC  ');
                    $array_meses=array();
                    $suma_total_mes=0;
                    foreach ($meses as $mes){
                        $dat_meses['id_mes']=$mes->id_mes;
                        $dat_meses['mes']=$mes->mes;
                        $requisiciones=DB::select('SELECT pres_actividades_req_ante.* from pres_actividades_req_ante,
                       pres_req_mat_ante where pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' and pres_actividades_req_ante.id_partida_pres = '.$partida->id_partida_pres.' 
                       and pres_actividades_req_ante.id_mes  = '.$mes->id_mes.' and pres_actividades_req_ante.id_autorizacion= 4 and pres_actividades_req_ante.id_meta = '.$id_meta.'
                        and pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and  pres_req_mat_ante.year_requisicion= '.$proyecto->year.' ');

                        $suma_req1=0;
                        $array_req=array();
                        foreach ($requisiciones as $requisicion){
                            $suma_req=DB::selectOne('SELECT SUM(importe) suma_material from pres_reg_material_req_ante WHERE id_actividades_req_ante = '.$requisicion->id_actividades_req_ante.'');

                            if($suma_req== null ){
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;

                                $dat_req['suma_importe_material']=0;
                            }else{
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;
                                $dat_req['suma_importe_material']=$suma_req->suma_material;

                                $suma_req1=$suma_req1+$suma_req->suma_material;
                            }
                            array_push($array_req,$dat_req);

                        }


                        $dat_meses['requisiciones']=$array_req;
                        $dat_meses['suma_req_mes']=$suma_req1;
                        $suma_total_mes=$suma_total_mes+$suma_req1;
                        array_push($array_meses,$dat_meses);
                    }

                    $dat_p['array_meses']=$array_meses;
                    $dat_p['suma_presupuestal_year']=$suma_total_mes;
                    $suma_total_capitulo=$suma_total_capitulo+$suma_total_mes;
                    array_push($array_partidas,$dat_p);

                }
                $dat_cap['array_partidas']=$array_partidas;
                $dat_cap['suma_total_capitulo']=$suma_total_capitulo;
                array_push($array_capitulos,$dat_cap);
            }
        }


        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 1;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');



        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.requ_por_metas_anteproyecto_historial', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','fuente_financiamiento','array_capitulos','id_meta','metas','id_year'));

    }
    public function presupuesto_total_anteproyecto_inc_historial($id_presupuesto){

        $proyecto= DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');

        $year=$proyecto->year;
        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
        $id_year=$id_year->id_year;

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy=DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = '.$id_presupuesto.' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');



/////////777///////7
        $presupuesto_proyecto=DB::select('SELECT *  FROM `pres_fuentes_financiamiento` 
        WHERE `id_presupuesto_ante` = '.$id_presupuesto.'  and total_presupuesto >0 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $array_capitulos=array();
        $suma_total_capitulo=0;
        foreach($presupuesto_proyecto as $presupuesto){

            $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$presupuesto->id_capitulo.'');

            if($contar_partida->contar == 0){

            }else{
                $dat_cap['id_fuente_financiamiento']=$presupuesto->id_fuente_financiamiento;
                $dat_cap['id_presupuesto_ante']=$presupuesto->id_presupuesto_ante;
                $dat_cap['id_capitulo']=$presupuesto->id_capitulo;
                $dat_cap['presupuesto_estatal']=$presupuesto->presupuesto_estatal;
                $dat_cap['presupuesto_federal']=$presupuesto->presupuesto_federal;
                $dat_cap['presupuesto_propios']=$presupuesto->presupuesto_propios;
                $dat_cap['total_presupuesto']=$presupuesto->total_presupuesto;
                $dat_cap['financiamiento_estatal']=$presupuesto->financiamiento_estatal;
                $dat_cap['financiamiento_federal']=$presupuesto->financiamiento_federal;
                $dat_cap['financiamiento_propios']=$presupuesto->financiamiento_propios;
                $dat_cap['total_financiamiento']=$presupuesto->total_financiamiento;

                $partidas=DB::select('SELECT pres_partida_pres.* from pres_partida_pres 
               WHERE id_capitulo = '.$presupuesto->id_capitulo.' ORDER BY `clave_presupuestal` ASC');


                $array_partidas=array();
                foreach ($partidas as $partida){
                    $dat_p['id_partida_pres']= $partida->id_partida_pres;
                    $dat_p['id_capitulo']= $partida->id_capitulo;
                    $dat_p['nombre_partida']= $partida->nombre_partida;
                    $dat_p['clave_presupuestal']= $partida->clave_presupuestal;

                    $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `id_mes` ASC');
                    $array_meses=array();
                    $suma_total_mes=0;
                    foreach ($meses as $mes){
                        $dat_meses['id_mes']=$mes->id_mes;
                        $dat_meses['mes']=$mes->mes;
                        $requisiciones=DB::select('SELECT pres_actividades_req_ante.* from pres_actividades_req_ante,
                       pres_req_mat_ante where pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' and pres_actividades_req_ante.id_partida_pres = '.$partida->id_partida_pres.' 
                       and pres_actividades_req_ante.id_mes  = '.$mes->id_mes.' and pres_actividades_req_ante.id_autorizacion= 4
                        and pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and  pres_req_mat_ante.year_requisicion= '.$proyecto->year.' ');

                        $suma_req1=0;
                        $array_req=array();
                        foreach ($requisiciones as $requisicion){
                            $suma_req=DB::selectOne('SELECT SUM(importe) suma_material from pres_reg_material_req_ante WHERE id_actividades_req_ante = '.$requisicion->id_actividades_req_ante.'');

                            if($suma_req== null ){
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;

                                $dat_req['suma_importe_material']=0;
                            }else{
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;
                                $dat_req['suma_importe_material']=$suma_req->suma_material;

                                $suma_req1=$suma_req1+$suma_req->suma_material;
                            }
                            array_push($array_req,$dat_req);

                        }


                        $dat_meses['requisiciones']=$array_req;
                        $dat_meses['suma_req_mes']=$suma_req1;
                        $suma_total_mes=$suma_total_mes+$suma_req1;
                        array_push($array_meses,$dat_meses);
                    }

                    $dat_p['array_meses']=$array_meses;
                    $dat_p['suma_presupuestal_year']=$suma_total_mes;
                    $suma_total_capitulo=$suma_total_capitulo+$suma_total_mes;
                    array_push($array_partidas,$dat_p);

                }
                $dat_cap['array_partidas']=$array_partidas;
                $dat_cap['suma_total_capitulo']=$suma_total_capitulo;
                array_push($array_capitulos,$dat_cap);
            }
        }

        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.req_proyecto_aut_inc_historial',compact('year','array_capitulos','proyecto','presupuesto_ante_proy','id_presupuesto','id_year'));

    }
    public function proyecto_capitulo_anteproyecto_inc_historial($id_presupuesto){
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        $year=$proyecto->year;
        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
        $id_year=$id_year->id_year;

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 0;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');


        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.proyecto_cap_ante_inc_historial', compact('id_year','year','proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto'));

    }
    public function ver_proyecto_capitulo_anteproyecto_inc_historial($id_fuente_financiamiento){
        $fuente_financiamiento=DB::select('SELECT  pres_fuentes_financiamiento.* from 
     pres_fuentes_financiamiento where id_fuente_financiamiento ='.$id_fuente_financiamiento.'');

        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $fuente_financiamiento[0]->id_presupuesto_ante . ' ');

        $year=$proyecto->year;
        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
        $id_year=$id_year->id_year;

        $id_presupuesto=$fuente_financiamiento[0]->id_presupuesto_ante;


        $array_capitulos=array();
        $suma_total_capitulo=0;
        foreach($fuente_financiamiento as $presupuesto){

            $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$fuente_financiamiento[0]->id_capitulo.'');

            if($contar_partida->contar == 0){

            }else{
                $dat_cap['id_fuente_financiamiento']=$presupuesto->id_fuente_financiamiento;
                $dat_cap['id_presupuesto_ante']=$presupuesto->id_presupuesto_ante;
                $dat_cap['id_capitulo']=$presupuesto->id_capitulo;
                $dat_cap['presupuesto_estatal']=$presupuesto->presupuesto_estatal;
                $dat_cap['presupuesto_federal']=$presupuesto->presupuesto_federal;
                $dat_cap['presupuesto_propios']=$presupuesto->presupuesto_propios;
                $dat_cap['total_presupuesto']=$presupuesto->total_presupuesto;
                $dat_cap['financiamiento_estatal']=$presupuesto->financiamiento_estatal;
                $dat_cap['financiamiento_federal']=$presupuesto->financiamiento_federal;
                $dat_cap['financiamiento_propios']=$presupuesto->financiamiento_propios;
                $dat_cap['total_financiamiento']=$presupuesto->total_financiamiento;

                $partidas=DB::select('SELECT pres_partida_pres.* from pres_partida_pres 
               WHERE id_capitulo = '.$presupuesto->id_capitulo.' ORDER BY `clave_presupuestal` ASC');


                $array_partidas=array();
                foreach ($partidas as $partida){
                    $dat_p['id_partida_pres']= $partida->id_partida_pres;
                    $dat_p['id_capitulo']= $partida->id_capitulo;
                    $dat_p['nombre_partida']= $partida->nombre_partida;
                    $dat_p['clave_presupuestal']= $partida->clave_presupuestal;

                    $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `id_mes` ASC');
                    $array_meses=array();
                    $suma_total_mes=0;
                    foreach ($meses as $mes){
                        $dat_meses['id_mes']=$mes->id_mes;
                        $dat_meses['mes']=$mes->mes;
                        $requisiciones=DB::select('SELECT pres_actividades_req_ante.* from pres_actividades_req_ante,
                       pres_req_mat_ante where pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' and pres_actividades_req_ante.id_partida_pres = '.$partida->id_partida_pres.' 
                       and pres_actividades_req_ante.id_mes  = '.$mes->id_mes.' and pres_actividades_req_ante.id_autorizacion= 4
                        and pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and  pres_req_mat_ante.year_requisicion= '.$proyecto->year.' ');

                        $suma_req1=0;
                        $array_req=array();
                        foreach ($requisiciones as $requisicion){
                            $suma_req=DB::selectOne('SELECT SUM(importe) suma_material from pres_reg_material_req_ante WHERE id_actividades_req_ante = '.$requisicion->id_actividades_req_ante.'');

                            if($suma_req== null ){
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;

                                $dat_req['suma_importe_material']=0;
                            }else{
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;
                                $dat_req['suma_importe_material']=$suma_req->suma_material;

                                $suma_req1=$suma_req1+$suma_req->suma_material;
                            }
                            array_push($array_req,$dat_req);

                        }


                        $dat_meses['requisiciones']=$array_req;
                        $dat_meses['suma_req_mes']=$suma_req1;
                        $suma_total_mes=$suma_total_mes+$suma_req1;
                        array_push($array_meses,$dat_meses);
                    }

                    $dat_p['array_meses']=$array_meses;
                    $dat_p['suma_presupuestal_year']=$suma_total_mes;
                    $suma_total_capitulo=$suma_total_capitulo+$suma_total_mes;
                    array_push($array_partidas,$dat_p);

                }
                $dat_cap['array_partidas']=$array_partidas;
                $dat_cap['suma_total_capitulo']=$suma_total_capitulo;
                array_push($array_capitulos,$dat_cap);
            }
        }
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 1;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.proyecto_cap_ante_inc_historial', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','id_fuente_financiamiento','fuente_financiamiento','array_capitulos','year','id_year'));

    }
    public function proyecto_meses_anteproyecto_inc_historial($id_presupuesto){
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        $year=$proyecto->year;
        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
        $id_year=$id_year->id_year;

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 0;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC');

        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.reque_mes_anteproyecto_inc_historial', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','meses','year','id_year'));

    }
    public function ver_proyecto_mes_anteproyecto_inc_historial($id_mes,$id_presupuesto){
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto. ' ');

        $year=$proyecto->year;
        $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
        $id_year=$id_year->id_year;

        $fuente_financiamiento=DB::select('SELECT * FROM `pres_fuentes_financiamiento` WHERE `id_presupuesto_ante` = '.$id_presupuesto.' 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $array_capitulos=array();
        $suma_total_capitulo=0;
        foreach($fuente_financiamiento as $presupuesto){

            $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$presupuesto->id_capitulo.'');

            if($contar_partida->contar == 0){

            }else{
                $dat_cap['id_fuente_financiamiento']=$presupuesto->id_fuente_financiamiento;
                $dat_cap['id_presupuesto_ante']=$presupuesto->id_presupuesto_ante;
                $dat_cap['id_capitulo']=$presupuesto->id_capitulo;
                $dat_cap['presupuesto_estatal']=$presupuesto->presupuesto_estatal;
                $dat_cap['presupuesto_federal']=$presupuesto->presupuesto_federal;
                $dat_cap['presupuesto_propios']=$presupuesto->presupuesto_propios;
                $dat_cap['total_presupuesto']=$presupuesto->total_presupuesto;
                $dat_cap['financiamiento_estatal']=$presupuesto->financiamiento_estatal;
                $dat_cap['financiamiento_federal']=$presupuesto->financiamiento_federal;
                $dat_cap['financiamiento_propios']=$presupuesto->financiamiento_propios;
                $dat_cap['total_financiamiento']=$presupuesto->total_financiamiento;

                $partidas=DB::select('SELECT pres_partida_pres.* from pres_partida_pres 
               WHERE id_capitulo = '.$presupuesto->id_capitulo.' ORDER BY `clave_presupuestal` ASC');


                $array_partidas=array();
                foreach ($partidas as $partida){
                    $dat_p['id_partida_pres']= $partida->id_partida_pres;
                    $dat_p['id_capitulo']= $partida->id_capitulo;
                    $dat_p['nombre_partida']= $partida->nombre_partida;
                    $dat_p['clave_presupuestal']= $partida->clave_presupuestal;

                    $meses=DB::select('SELECT * FROM `pres_mes` WHERE `id_mes` = '.$id_mes.' ');
                    $array_meses=array();
                    $suma_total_mes=0;
                    foreach ($meses as $mes){
                        $dat_meses['id_mes']=$mes->id_mes;
                        $dat_meses['mes']=$mes->mes;
                        $requisiciones=DB::select('SELECT pres_actividades_req_ante.* from pres_actividades_req_ante,
                       pres_req_mat_ante where pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' and pres_actividades_req_ante.id_partida_pres = '.$partida->id_partida_pres.' 
                       and pres_actividades_req_ante.id_mes  = '.$mes->id_mes.' and pres_actividades_req_ante.id_autorizacion= 4
                        and pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and  pres_req_mat_ante.year_requisicion= '.$proyecto->year.' ');

                        $suma_req1=0;
                        $array_req=array();
                        foreach ($requisiciones as $requisicion){
                            $suma_req=DB::selectOne('SELECT SUM(importe) suma_material from pres_reg_material_req_ante WHERE id_actividades_req_ante = '.$requisicion->id_actividades_req_ante.'');

                            if($suma_req== null ){
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;

                                $dat_req['suma_importe_material']=0;
                            }else{
                                $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                                $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                                $dat_req['id_partida_pres']=$requisicion->id_partida_pres;
                                $dat_req['suma_importe_material']=$suma_req->suma_material;

                                $suma_req1=$suma_req1+$suma_req->suma_material;
                            }
                            array_push($array_req,$dat_req);

                        }


                        $dat_meses['requisiciones']=$array_req;
                        $dat_meses['suma_req_mes']=$suma_req1;
                        $suma_total_mes=$suma_total_mes+$suma_req1;
                        array_push($array_meses,$dat_meses);
                    }

                    $dat_p['array_meses']=$array_meses;
                    $dat_p['suma_presupuestal_year']=$suma_total_mes;
                    $suma_total_capitulo=$suma_total_capitulo+$suma_total_mes;
                    array_push($array_partidas,$dat_p);

                }
                $dat_cap['array_partidas']=$array_partidas;
                $dat_cap['suma_total_capitulo']=$suma_total_capitulo;
                array_push($array_capitulos,$dat_cap);
            }
        }

        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 1;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC');

        return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.reque_mes_anteproyecto_inc_historial', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','fuente_financiamiento','array_capitulos','id_mes','meses','id_year','year'));


    }
public function proyecto_metas_anteproyecto_inc_historial($id_presupuesto){
    $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

    $year=$proyecto->year;
    $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
    $id_year=$id_year->id_year;

    ///presupuesto del proyecto del anteproyecto
    $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

    $mostrar = 0;
    $metas =DB::select('SELECT pres_metas.meta, pres_actividades_req_ante.* from pres_metas, pres_actividades_req_ante, pres_req_mat_ante
         where pres_metas.id_meta = pres_actividades_req_ante.id_meta and pres_actividades_req_ante.id_req_mat_ante = pres_req_mat_ante.id_req_mat_ante
         and pres_req_mat_ante.year_requisicion ='.$proyecto->year.'  and pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' group by pres_metas.id_meta');



    return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.requ_por_metas_inc_ante_historial', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'metas','year','id_year'));

}
public function ver_proyecto_meta_ante_inc_historial($id_meta, $id_presupuesto){
    $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');
    $year=$proyecto->year;
    $id_year=DB::selectOne('SELECT * FROM `pres_year` WHERE `descripcion` ='.$proyecto->year.'');
    $id_year=$id_year->id_year;
    $fuente_financiamiento = DB::select('SELECT * FROM `pres_fuentes_financiamiento` WHERE `id_presupuesto_ante` = ' . $id_presupuesto . ' 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

    $metas =DB::select('SELECT pres_metas.meta, pres_actividades_req_ante.* from pres_metas, pres_actividades_req_ante, pres_req_mat_ante
         where pres_metas.id_meta = pres_actividades_req_ante.id_meta and pres_actividades_req_ante.id_req_mat_ante = pres_req_mat_ante.id_req_mat_ante
         and pres_req_mat_ante.year_requisicion ='.$proyecto->year.'  and pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' group by pres_metas.id_meta');


    $array_capitulos=array();
    $suma_total_capitulo=0;
    foreach($fuente_financiamiento as $presupuesto){

        $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$presupuesto->id_capitulo.'');

        if($contar_partida->contar == 0){

        }else{
            $dat_cap['id_fuente_financiamiento']=$presupuesto->id_fuente_financiamiento;
            $dat_cap['id_presupuesto_ante']=$presupuesto->id_presupuesto_ante;
            $dat_cap['id_capitulo']=$presupuesto->id_capitulo;
            $dat_cap['presupuesto_estatal']=$presupuesto->presupuesto_estatal;
            $dat_cap['presupuesto_federal']=$presupuesto->presupuesto_federal;
            $dat_cap['presupuesto_propios']=$presupuesto->presupuesto_propios;
            $dat_cap['total_presupuesto']=$presupuesto->total_presupuesto;
            $dat_cap['financiamiento_estatal']=$presupuesto->financiamiento_estatal;
            $dat_cap['financiamiento_federal']=$presupuesto->financiamiento_federal;
            $dat_cap['financiamiento_propios']=$presupuesto->financiamiento_propios;
            $dat_cap['total_financiamiento']=$presupuesto->total_financiamiento;

            $partidas=DB::select('SELECT pres_partida_pres.* from pres_partida_pres 
               WHERE id_capitulo = '.$presupuesto->id_capitulo.' ORDER BY `clave_presupuestal` ASC');


            $array_partidas=array();
            foreach ($partidas as $partida){
                $dat_p['id_partida_pres']= $partida->id_partida_pres;
                $dat_p['id_capitulo']= $partida->id_capitulo;
                $dat_p['nombre_partida']= $partida->nombre_partida;
                $dat_p['clave_presupuestal']= $partida->clave_presupuestal;

                $meses=DB::select('SELECT * FROM `pres_mes` ORDER BY `pres_mes`.`id_mes` ASC  ');
                $array_meses=array();
                $suma_total_mes=0;
                foreach ($meses as $mes){
                    $dat_meses['id_mes']=$mes->id_mes;
                    $dat_meses['mes']=$mes->mes;
                    $requisiciones=DB::select('SELECT pres_actividades_req_ante.* from pres_actividades_req_ante,
                       pres_req_mat_ante where pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' and pres_actividades_req_ante.id_partida_pres = '.$partida->id_partida_pres.' 
                       and pres_actividades_req_ante.id_mes  = '.$mes->id_mes.' and pres_actividades_req_ante.id_autorizacion= 4 and pres_actividades_req_ante.id_meta = '.$id_meta.'
                        and pres_req_mat_ante.id_req_mat_ante = pres_actividades_req_ante.id_req_mat_ante and  pres_req_mat_ante.year_requisicion= '.$proyecto->year.' ');

                    $suma_req1=0;
                    $array_req=array();
                    foreach ($requisiciones as $requisicion){
                        $suma_req=DB::selectOne('SELECT SUM(importe) suma_material from pres_reg_material_req_ante WHERE id_actividades_req_ante = '.$requisicion->id_actividades_req_ante.'');

                        if($suma_req== null ){
                            $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                            $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                            $dat_req['id_partida_pres']=$requisicion->id_partida_pres;

                            $dat_req['suma_importe_material']=0;
                        }else{
                            $dat_req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
                            $dat_req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
                            $dat_req['id_partida_pres']=$requisicion->id_partida_pres;
                            $dat_req['suma_importe_material']=$suma_req->suma_material;

                            $suma_req1=$suma_req1+$suma_req->suma_material;
                        }
                        array_push($array_req,$dat_req);

                    }


                    $dat_meses['requisiciones']=$array_req;
                    $dat_meses['suma_req_mes']=$suma_req1;
                    $suma_total_mes=$suma_total_mes+$suma_req1;
                    array_push($array_meses,$dat_meses);
                }

                $dat_p['array_meses']=$array_meses;
                $dat_p['suma_presupuestal_year']=$suma_total_mes;
                $suma_total_capitulo=$suma_total_capitulo+$suma_total_mes;
                array_push($array_partidas,$dat_p);

            }
            $dat_cap['array_partidas']=$array_partidas;
            $dat_cap['suma_total_capitulo']=$suma_total_capitulo;
            array_push($array_capitulos,$dat_cap);
        }
    }


    $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

    ///presupuesto del proyecto del anteproyecto
    $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

    $mostrar = 1;
    $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');



    return view('departamento_finanzas.jefe_finanazas.historial_anteproyecto.requ_por_metas_inc_ante_historial', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','fuente_financiamiento','array_capitulos','id_meta','metas','id_year','year'));

}


}
