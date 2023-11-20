<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Utils;

class Pres_autorizadas_req_proController extends Controller
{
    public function index(){
        $year = date('Y');
        $year = $year+1;


        $registro_proyectos=DB::select('SELECT pres_presupuesto_anteproyecto.*, pres_proyectos.nombre_proyecto 
        from pres_presupuesto_anteproyecto, pres_proyectos WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto
        and pres_presupuesto_anteproyecto.year='.$year.' ORDER BY pres_proyectos.nombre_proyecto ASC');
        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.inicio_req_aut_proy',compact('year','registro_proyectos'));

    }
    public function presupuesto_total_anteproyecto($id_presupuesto){
        $year = date('Y');
        $year = $year+1;
       $proyecto= DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');


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
        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.req_proyecto',compact('year','array_capitulos','proyecto','presupuesto_ante_proy','id_presupuesto'));

    }
    public function presupuesto_total_anteproyecto_inc($id_presupuesto){
        $year = date('Y');
        $year = $year+1;
        $proyecto= DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');


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
        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.req_proyecto_aut_inc',compact('year','array_capitulos','proyecto','presupuesto_ante_proy','id_presupuesto'));

    }
    public function proyecto_inicio_anteproyecto($id_presupuesto){

         $proyecto= DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
         WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');
        $presupueto=DB::selectOne('SELECT * FROM `pres_presupuesto_anteproyecto` WHERE `id_presupuesto` ='.$id_presupuesto.'');
        $year=$presupueto->year;

         return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.inicio_proyecto_anteproyecto',compact('proyecto','id_presupuesto','year'));


    }
    public function proyecto_capitulo_anteproyecto($id_presupuesto)
    {

        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 0;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');


        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.proyecto_capitulos_anteproyecto', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto'));
    }
    public function proyecto_capitulo_anteproyecto_inc($id_presupuesto)
    {

        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

        ///presupuesto del proyecto del anteproyecto
        $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

        $mostrar = 0;
        $presupuesto_proyecto = DB::select('SELECT pres_fuentes_financiamiento.*,pres_capitulos.capitulo FROM
        `pres_fuentes_financiamiento`,pres_capitulos WHERE pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . '
        and pres_fuentes_financiamiento.total_presupuesto >0 and pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');


        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.proyecto_cap_ante_inc', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto'));
    }
     public function ver_proyecto_capitulo_anteproyecto($id_fuente_financiamiento){

     $fuente_financiamiento=DB::select('SELECT  pres_fuentes_financiamiento.* from 
     pres_fuentes_financiamiento where id_fuente_financiamiento ='.$id_fuente_financiamiento.'');

         $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $fuente_financiamiento[0]->id_presupuesto_ante . ' ');

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

         return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.proyecto_capitulos_anteproyecto', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','id_fuente_financiamiento','fuente_financiamiento','array_capitulos'));

     }
    public function ver_proyecto_capitulo_anteproyecto_inc($id_fuente_financiamiento){

        $fuente_financiamiento=DB::select('SELECT  pres_fuentes_financiamiento.* from 
     pres_fuentes_financiamiento where id_fuente_financiamiento ='.$id_fuente_financiamiento.'');

        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $fuente_financiamiento[0]->id_presupuesto_ante . ' ');

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

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.proyecto_cap_ante_inc', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','id_fuente_financiamiento','fuente_financiamiento','array_capitulos'));

    }
     public function proyecto_meses_anteproyecto($id_presupuesto){
         $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

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

         return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.requ_por_mes_anteproyecto', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','meses'));
     }
    public function proyecto_meses_anteproyecto_inc($id_presupuesto){
        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

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

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.reque_mes_anteproyecto_inc', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','meses'));
    }
     public function ver_proyecto_mes_anteproyecto($id_mes,$id_presupuesto)
     {

         $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

         $fuente_financiamiento = DB::select('SELECT * FROM `pres_fuentes_financiamiento` WHERE `id_presupuesto_ante` = ' . $id_presupuesto . ' 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');
     //dd($fuente_financiamiento);

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

         return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.requ_por_mes_anteproyecto', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','fuente_financiamiento','array_capitulos','id_mes','meses'));

     }
    public function ver_proyecto_mes_anteproyecto_inc($id_mes,$id_presupuesto){

        $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto. ' ');

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

        return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.reque_mes_anteproyecto_inc', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','fuente_financiamiento','array_capitulos','id_mes','meses'));

    }
     public function ver_requisiciones_autorizadas($id_req_mat_ante){
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

         foreach ($requisiciones as $requisicion){
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

         return view('departamento_finanzas.jefe_departamento.ver_requisiciones_autorizadas', compact('datos_req_envio', 'meses', 'proyectos', 'requisiciones2','partidas_presupuestales','total_req','id_req_mat_ante'));
     }
     public function proyecto_meta_anteproyecto($id_presupuesto){
         $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

         ///presupuesto del proyecto del anteproyecto
         $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

         $mostrar = 0;
         $metas =DB::select('SELECT pres_metas.meta, pres_actividades_req_ante.* from pres_metas, pres_actividades_req_ante, pres_req_mat_ante
         where pres_metas.id_meta = pres_actividades_req_ante.id_meta and pres_actividades_req_ante.id_req_mat_ante = pres_req_mat_ante.id_req_mat_ante
         and pres_req_mat_ante.year_requisicion ='.$proyecto->year.'  and pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' group by pres_metas.id_meta');



         return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.requ_por_metas_anteproyecto', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'metas'));

     }
     public function ver_proyecto_meta_anteproyecto($id_meta,$id_presupuesto){

         $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

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



         return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.requ_por_metas_anteproyecto', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','fuente_financiamiento','array_capitulos','id_meta','metas'));


     }
     public function proyecto_metas_anteproyecto_inc($id_presupuesto){
         $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

         ///presupuesto del proyecto del anteproyecto
         $presupuesto_ante_proy = DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = ' . $id_presupuesto . ' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

         $mostrar = 0;
         $metas =DB::select('SELECT pres_metas.meta, pres_actividades_req_ante.* from pres_metas, pres_actividades_req_ante, pres_req_mat_ante
         where pres_metas.id_meta = pres_actividades_req_ante.id_meta and pres_actividades_req_ante.id_req_mat_ante = pres_req_mat_ante.id_req_mat_ante
         and pres_req_mat_ante.year_requisicion ='.$proyecto->year.'  and pres_actividades_req_ante.id_proyecto = '.$proyecto->id_proyecto.' group by pres_metas.id_meta');



         return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.requ_por_metas_inc_ante', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'metas'));

     }
     public function ver_proyecto_meta_ante_inc($id_meta,$id_presupuesto){
         $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');

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



         return view('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.requ_por_metas_inc_ante', compact('proyecto', 'id_presupuesto', 'presupuesto_ante_proy', 'mostrar', 'presupuesto_proyecto','fuente_financiamiento','array_capitulos','id_meta','metas'));

     }

}
