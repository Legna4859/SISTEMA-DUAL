<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Classes\PHPExcel;
class Pre_excel_anteController extends Controller
{
public function index($id_presupuesto){
    Session::put('id_presupuest',$id_presupuesto);
    $proyecto=DB::selectOne('SELECT pres_proyectos.nombre_proyecto, pres_presupuesto_anteproyecto.* 
    from pres_proyectos, pres_presupuesto_anteproyecto where pres_proyectos.id_proyecto = pres_presupuesto_anteproyecto.id_proyecto 
    and pres_presupuesto_anteproyecto.id_presupuesto='.$id_presupuesto.'');

    Session::put('nombre_proy',$proyecto->nombre_proyecto);
    Session::put('year_ante',$proyecto->year);
    Excel::create('Proyecto_'.$proyecto->year, function($excel)
    {

        $excel->sheet('Requisiciones', function($sheet)
        {

            $id_presupuesto=Session::get('id_presupuest');

            $proyecto= DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');
            $etiqueta=DB::selectOne('SELECT * FROM `etiqueta` WHERE `id_etiqueta` = 1');


            ///presupuesto del proyecto del anteproyecto
           /* $presupuesto_ante_proy=DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from
       pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo 
        and pres_fuentes_financiamiento.id_presupuesto_ante = '.$id_presupuesto.' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');
            */

          $capitulos=DB::select('SELECT * FROM `pres_capitulos` ORDER BY `pres_capitulos`.`id_capitulo` ASC ');
          $array_cap=array();
          foreach ($capitulos as $capitulo){
              $cap['id_capitulo']=$capitulo->id_capitulo;
              $cap['capitulo']=$capitulo->capitulo;
              $presupuesto_ante_proy=DB::selectOne('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
               pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo and
                pres_capitulos.id_capitulo='.$capitulo->id_capitulo.'
                and pres_fuentes_financiamiento.id_presupuesto_ante = '.$id_presupuesto.' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

              if($presupuesto_ante_proy == null){
                  $cap['id_fuente_financiamiento'] = 0;
                  $cap['id_presupuesto_ante'] = 0;
                  $cap['presupuesto_estatal'] = 0;
                  $cap['presupuesto_federal'] = 0;
                  $cap['presupuesto_propios'] = 0;
                  $cap['total_presupuesto'] = 0;
                  $cap['financiamiento_estatal'] = 0;
                  $cap['financiamiento_federal'] =0;
                  $cap['financiamiento_propios'] = 0;
                  $cap['total_financiamiento'] = 0;
              }else {
                  $cap['id_fuente_financiamiento'] = $presupuesto_ante_proy->id_fuente_financiamiento;
                  $cap['id_presupuesto_ante'] = $presupuesto_ante_proy->id_presupuesto_ante;
                  $cap['presupuesto_estatal'] = $presupuesto_ante_proy->presupuesto_estatal;
                  $cap['presupuesto_federal'] = $presupuesto_ante_proy->presupuesto_federal;
                  $cap['presupuesto_propios'] = $presupuesto_ante_proy->presupuesto_propios;
                  $cap['total_presupuesto'] = $presupuesto_ante_proy->total_presupuesto;
                  $cap['financiamiento_estatal'] = $presupuesto_ante_proy->financiamiento_estatal;
                  $cap['financiamiento_federal'] = $presupuesto_ante_proy->financiamiento_federal;
                  $cap['financiamiento_propios'] = $presupuesto_ante_proy->financiamiento_propios;
                  $cap['total_financiamiento'] = $presupuesto_ante_proy->total_financiamiento;
              }

              array_push($array_cap,$cap);

          }




/////////777///////7
            $presupuesto_proyecto=DB::select('SELECT *  FROM `pres_fuentes_financiamiento` 
        WHERE `id_presupuesto_ante` = '.$id_presupuesto.'  and total_presupuesto >0 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

            $array_capitulos=array();
            $suma_total_capitulo=0;
            $contar_numero_partida=0;
            foreach($presupuesto_proyecto as $presupuesto){

                $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$presupuesto->id_capitulo.'');

                if($contar_partida->contar == 0){

                }else{
                    $contar_partida=$contar_partida->contar;
                    $contar_numero_partida=$contar_numero_partida+1;
                    $dat_cap['contar_partidas']=$contar_partida;
                    $dat_cap['contar_numero_partida']=$contar_numero_partida;
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
            //////////////////
            $array_part_ant=array();
            foreach ( $array_capitulos as $cap){
                $dat['numero_partida']=$cap['contar_numero_partida'];

                $contar_part=0;
                foreach ($cap['array_partidas'] as $partida){
                        $contar_part=$contar_part+1;
                }
                $dat['conteo_partida']=$contar_part;
                array_push($array_part_ant,$dat);
            }
            ////////////////////////
            //dd($array_part_ant);


            //dd($array_capitulos);

            $obj1 = new \PHPExcel_Worksheet_Drawing;
            $obj1->setPath(public_path('img/residencia/logo_estado.jpg')); //your image path
            $obj1->setWidth(80);
            $obj1->setHeight(80);
            $obj1->setCoordinates('A1');
            $obj1->setWorksheet($sheet);
/*
            $obj2 = new \PHPExcel_Worksheet_Drawing();
            $obj2->setPath(public_path('img/logo3.PNG')); //your image path
            $obj2->setWidth(300);
            $obj2->setCoordinates('L4');
            $obj2->setWorksheet($sheet);
*/


// Set font with ->setStyle()`

/*
            $sheet->setWidth(array(
                'A' => 10,
                'B' => 20,
                'C' => 20,
                'D' => 50,
                'E' => 50,
                'F' => 50,
                'G' => 50,
                'H' => 50,
                'I' => 50,
                'J' => 50,
                'K' => 50,
                'L' => 50,
                'M' => 10,
            ));
            $sheet->setHeight(array(
                1     =>  50,
                2     =>  25
            ));
*/
            $sheet->setSize('A1', 10, 15);
            $sheet->setSize('B1', 65, 15);
            $sheet->setSize('C1', 10, 10);
            $sheet->setSize('D1', 10, 10);
            $sheet->setSize('E1', 10, 10);
            $sheet->setSize('F1', 10, 10);
            $sheet->setSize('G1', 10, 10);
            $sheet->setSize('H1', 10, 10);
            $sheet->setSize('I1', 10, 10);
            $sheet->setSize('J1', 10, 10);
            $sheet->setSize('K1', 10, 10);
            $sheet->setSize('L1', 10, 10);
            $sheet->cell('D4:L4', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('D5:L5', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D6:F6', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G6:L6', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A7:C7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D7:F7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G7:L7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A8:C8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D8:F8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G8:L8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A9:C9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D9:F9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G9:L9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A10:C10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D10:F10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G10:L10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A11:C11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D11:F11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G11:L11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A12:L12', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A14:CA14', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A15:BW15', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A16:BW16', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A17:BW17', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A18:BW18', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A19:BW19', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A20:BW20', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });

            /*

            $letras=DB::select('SELECT * FROM `pres_letras` ORDER BY `pres_letras`.`id_letra` ASC');

            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'21:'.$letra->letra.'83', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A84:CC84', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'85:'.$letra->letra.'182', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A183:CC183', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'184:'.$letra->letra.'187', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A188:CC188', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A189:CC189', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });

*/
            $letras=DB::select('SELECT * FROM `pres_letras` ORDER BY `pres_letras`.`id_letra` ASC');
            $numero_inicial=21;
            $numero_final=20;

            foreach ( $array_part_ant as $part){
                if($part['numero_partida'] == 1){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;

                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;


                    }

                }
                if($part['numero_partida'] == 2){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }
                if($part['numero_partida'] == 3){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }
                if($part['numero_partida'] == 4){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;

                    }

                }
                if($part['numero_partida'] == 5){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;

                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }


            }

            $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });

//dd($proyecto);
            //dd($presupuesto_ante_proy);
            $sheet->loadView('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.excel_req_proyecto_completo',compact('id_presupuesto','array_cap','array_capitulos','etiqueta','proyecto'));

        });

    })->export('xls');
    return back();
}
public function presupuesto_capitulo_ant_excel($id_fuente_financiamiento){
    Session::put('id_fuente_financiamiento',$id_fuente_financiamiento);
    Excel::create('Proyecto_capitulo', function($excel)
    {

        $excel->sheet('Requisiciones_capitulo', function($sheet)
        {
            $etiqueta=DB::selectOne('SELECT * FROM `etiqueta` WHERE `id_etiqueta` = 1');

            $id_fuente_financiamiento=Session::get('id_fuente_financiamiento');

            $fuente_financiamiento=DB::select('SELECT  pres_fuentes_financiamiento.* from 
     pres_fuentes_financiamiento where id_fuente_financiamiento ='.$id_fuente_financiamiento.'');



            $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $fuente_financiamiento[0]->id_presupuesto_ante . ' ');

            $id_presupuesto=$fuente_financiamiento[0]->id_presupuesto_ante;

            $capitulos=DB::select('SELECT * FROM `pres_capitulos` ORDER BY `pres_capitulos`.`id_capitulo` ASC ');
            $array_cap=array();
            foreach ($capitulos as $capitulo){
                $cap['id_capitulo']=$capitulo->id_capitulo;
                $cap['capitulo']=$capitulo->capitulo;
                $presupuesto_ante_proy=DB::selectOne('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
               pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo and
                pres_capitulos.id_capitulo='.$capitulo->id_capitulo.'
                and pres_fuentes_financiamiento.id_presupuesto_ante = '.$id_presupuesto.' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

                if($presupuesto_ante_proy == null){
                    $cap['id_fuente_financiamiento'] = 0;
                    $cap['id_presupuesto_ante'] = 0;
                    $cap['presupuesto_estatal'] = 0;
                    $cap['presupuesto_federal'] = 0;
                    $cap['presupuesto_propios'] = 0;
                    $cap['total_presupuesto'] = 0;
                    $cap['financiamiento_estatal'] = 0;
                    $cap['financiamiento_federal'] =0;
                    $cap['financiamiento_propios'] = 0;
                    $cap['total_financiamiento'] = 0;
                }else {
                    $cap['id_fuente_financiamiento'] = $presupuesto_ante_proy->id_fuente_financiamiento;
                    $cap['id_presupuesto_ante'] = $presupuesto_ante_proy->id_presupuesto_ante;
                    $cap['presupuesto_estatal'] = $presupuesto_ante_proy->presupuesto_estatal;
                    $cap['presupuesto_federal'] = $presupuesto_ante_proy->presupuesto_federal;
                    $cap['presupuesto_propios'] = $presupuesto_ante_proy->presupuesto_propios;
                    $cap['total_presupuesto'] = $presupuesto_ante_proy->total_presupuesto;
                    $cap['financiamiento_estatal'] = $presupuesto_ante_proy->financiamiento_estatal;
                    $cap['financiamiento_federal'] = $presupuesto_ante_proy->financiamiento_federal;
                    $cap['financiamiento_propios'] = $presupuesto_ante_proy->financiamiento_propios;
                    $cap['total_financiamiento'] = $presupuesto_ante_proy->total_financiamiento;
                }

                array_push($array_cap,$cap);

            }


            $array_capitulos=array();
            $suma_total_capitulo=0;
            $contar_numero_partida=0;
            foreach($fuente_financiamiento as $presupuesto){

                $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$fuente_financiamiento[0]->id_capitulo.'');

                if($contar_partida->contar == 0){
                    $contar_partida=0;
                }else{
                    $contar_partida=$contar_partida->contar;
                    $contar_numero_partida=$contar_numero_partida+1;
                    $dat_cap['contar_partidas']=$contar_partida;
                    $dat_cap['contar_numero_partida']=$contar_numero_partida;

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

                        $dat_p['contar_partida']= $partida->id_partida_pres;
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

            $array_part_ant=array();
            foreach ( $array_capitulos as $cap){
                $dat['numero_partida']=$cap['contar_numero_partida'];

                $contar_part=0;
                foreach ($cap['array_partidas'] as $partida){

                        $contar_part=$contar_part+1;
                }
                $dat['conteo_partida']=$contar_part;
                array_push($array_part_ant,$dat);
            }
           // dd($array_part_ant);
            $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');



            $obj1 = new \PHPExcel_Worksheet_Drawing;
            $obj1->setPath(public_path('img/residencia/logo_estado.jpg')); //your image path
            $obj1->setWidth(80);
            $obj1->setHeight(80);
            $obj1->setCoordinates('A1');
            $obj1->setWorksheet($sheet);
            /*
                        $obj2 = new \PHPExcel_Worksheet_Drawing();
                        $obj2->setPath(public_path('img/logo3.PNG')); //your image path
                        $obj2->setWidth(300);
                        $obj2->setCoordinates('L4');
                        $obj2->setWorksheet($sheet);
            */


// Set font with ->setStyle()`

            /*
                        $sheet->setWidth(array(
                            'A' => 10,
                            'B' => 20,
                            'C' => 20,
                            'D' => 50,
                            'E' => 50,
                            'F' => 50,
                            'G' => 50,
                            'H' => 50,
                            'I' => 50,
                            'J' => 50,
                            'K' => 50,
                            'L' => 50,
                            'M' => 10,
                        ));
                        $sheet->setHeight(array(
                            1     =>  50,
                            2     =>  25
                        ));
            */
            $sheet->setSize('A1', 10, 15);
            $sheet->setSize('B1', 65, 15);
            $sheet->setSize('C1', 10, 10);
            $sheet->setSize('D1', 10, 10);
            $sheet->setSize('E1', 10, 10);
            $sheet->setSize('F1', 10, 10);
            $sheet->setSize('G1', 10, 10);
            $sheet->setSize('H1', 10, 10);
            $sheet->setSize('I1', 10, 10);
            $sheet->setSize('J1', 10, 10);
            $sheet->setSize('K1', 10, 10);
            $sheet->setSize('L1', 10, 10);
            $sheet->cell('D4:L4', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('D5:L5', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D6:F6', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G6:L6', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A7:C7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '11',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D7:F7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G7:L7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A8:C8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D8:F8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G8:L8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A9:C9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D9:F9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G9:L9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A10:C10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D10:F10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G10:L10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A11:C11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D11:F11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G11:L11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A12:L12', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A14:CA14', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A15:BW15', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A16:BW16', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A17:BW17', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A18:BW18', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A19:BW19', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A20:BW20', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
/*
            $letras=DB::select('SELECT * FROM `pres_letras` ORDER BY `pres_letras`.`id_letra` ASC');
             if($contar_partida == 0){

             }else{
                 $numero_inicial=21;
                 $numero_final=20+$contar_partida;
                 foreach ($letras as $letra){
                     $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                         // Set font
                         $cell->setFont(array(
                             'family'     => 'Arial',
                             'size'       => '9',
                             'bold'       =>  false
                         ));

                     });
                 }
             }

            if($contar_partida == 0) {
                $sheet->cell('A21:CC21', function ($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '10',
                        'bold' => true
                    ));

                });
            }else{
                $numero_total=$numero_final+1;
                $sheet->cell('A'.$numero_total.':CC'.$numero_total, function ($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family' => 'Arial',
                        'size' => '10',
                        'bold' => true
                    ));

                });
            }


*/  $letras=DB::select('SELECT * FROM `pres_letras` ORDER BY `pres_letras`.`id_letra` ASC');
            $numero_inicial=21;
            $numero_final=20;

            foreach ( $array_part_ant as $part){
                if($part['numero_partida'] == 1){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;

                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;


                    }

                }
                if($part['numero_partida'] == 2){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }
                if($part['numero_partida'] == 3){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }
                if($part['numero_partida'] == 4){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;

                    }

                }
                if($part['numero_partida'] == 5){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;

                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }


            }

            $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });


            //dd($presupuesto_ante_proy);
            $sheet->loadView('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.excel_req_capitulo',compact('id_presupuesto','array_cap','array_capitulos','etiqueta','proyecto','fuente_financiamiento'));

        });

    })->export('xls');
    return back();

}
public function presupuesto_mes_ant_excel($id_presupuesto,$id_mes){
    Session::put('id_presupuesto',$id_presupuesto);
    Session::put('id_mes',$id_mes);
    Excel::create('Proyecto_mes', function($excel)
    {

        $excel->sheet('Requisiciones_mes', function($sheet)
        {

            $id_presupuesto=Session::get('id_presupuesto');
            $id_mes=Session::get('id_mes');

            $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto. ' ');

            $fuente_financiamiento=DB::select('SELECT * FROM `pres_fuentes_financiamiento` WHERE `id_presupuesto_ante` = '.$id_presupuesto.' 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');
            $capitulos=DB::select('SELECT * FROM `pres_capitulos` ORDER BY `pres_capitulos`.`id_capitulo` ASC ');
            $array_cap=array();
            foreach ($capitulos as $capitulo){
                $cap['id_capitulo']=$capitulo->id_capitulo;
                $cap['capitulo']=$capitulo->capitulo;
                $presupuesto_ante_proy=DB::selectOne('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
               pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo and
                pres_capitulos.id_capitulo='.$capitulo->id_capitulo.'
                and pres_fuentes_financiamiento.id_presupuesto_ante = '.$id_presupuesto.' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

                if($presupuesto_ante_proy == null){
                    $cap['id_fuente_financiamiento'] = 0;
                    $cap['id_presupuesto_ante'] = 0;
                    $cap['presupuesto_estatal'] = 0;
                    $cap['presupuesto_federal'] = 0;
                    $cap['presupuesto_propios'] = 0;
                    $cap['total_presupuesto'] = 0;
                    $cap['financiamiento_estatal'] = 0;
                    $cap['financiamiento_federal'] =0;
                    $cap['financiamiento_propios'] = 0;
                    $cap['total_financiamiento'] = 0;
                }else {
                    $cap['id_fuente_financiamiento'] = $presupuesto_ante_proy->id_fuente_financiamiento;
                    $cap['id_presupuesto_ante'] = $presupuesto_ante_proy->id_presupuesto_ante;
                    $cap['presupuesto_estatal'] = $presupuesto_ante_proy->presupuesto_estatal;
                    $cap['presupuesto_federal'] = $presupuesto_ante_proy->presupuesto_federal;
                    $cap['presupuesto_propios'] = $presupuesto_ante_proy->presupuesto_propios;
                    $cap['total_presupuesto'] = $presupuesto_ante_proy->total_presupuesto;
                    $cap['financiamiento_estatal'] = $presupuesto_ante_proy->financiamiento_estatal;
                    $cap['financiamiento_federal'] = $presupuesto_ante_proy->financiamiento_federal;
                    $cap['financiamiento_propios'] = $presupuesto_ante_proy->financiamiento_propios;
                    $cap['total_financiamiento'] = $presupuesto_ante_proy->total_financiamiento;
                }

                array_push($array_cap,$cap);

            }

            $array_capitulos=array();
            $suma_total_capitulo=0;
            $contar_numero_partida=0;
            foreach($fuente_financiamiento as $presupuesto){

                $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$presupuesto->id_capitulo.'');

                if($contar_partida->contar == 0){
                    $contar_partida=0;

                }else{

                    $contar_partida=$contar_partida->contar;
                    $contar_numero_partida=$contar_numero_partida+1;
                    $dat_cap['contar_partidas']=$contar_partida;
                    $dat_cap['contar_numero_partida']=$contar_numero_partida;

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
            $array_part_ant=array();
            foreach ( $array_capitulos as $cap){
                $dat['numero_partida']=$cap['contar_numero_partida'];

                $contar_part=0;
                foreach ($cap['array_partidas'] as $partida){

                        $contar_part=$contar_part+1;

                }
                $dat['conteo_partida']=$contar_part;
                array_push($array_part_ant,$dat);
            }


            $proyecto = DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto =' . $id_presupuesto . ' ');


            $obj1 = new \PHPExcel_Worksheet_Drawing;
            $obj1->setPath(public_path('img/residencia/logo_estado.jpg')); //your image path
            $obj1->setWidth(80);
            $obj1->setHeight(80);
            $obj1->setCoordinates('A1');
            $obj1->setWorksheet($sheet);
            /*
                        $obj2 = new \PHPExcel_Worksheet_Drawing();
                        $obj2->setPath(public_path('img/logo3.PNG')); //your image path
                        $obj2->setWidth(300);
                        $obj2->setCoordinates('L4');
                        $obj2->setWorksheet($sheet);
            */


// Set font with ->setStyle()`

            /*
                        $sheet->setWidth(array(
                            'A' => 10,
                            'B' => 20,
                            'C' => 20,
                            'D' => 50,
                            'E' => 50,
                            'F' => 50,
                            'G' => 50,
                            'H' => 50,
                            'I' => 50,
                            'J' => 50,
                            'K' => 50,
                            'L' => 50,
                            'M' => 10,
                        ));
                        $sheet->setHeight(array(
                            1     =>  50,
                            2     =>  25
                        ));
            */
            $sheet->setSize('A1', 10, 15);
            $sheet->setSize('B1', 65, 15);
            $sheet->setSize('C1', 10, 10);
            $sheet->setSize('D1', 10, 10);
            $sheet->setSize('E1', 10, 10);
            $sheet->setSize('F1', 10, 10);
            $sheet->setSize('G1', 10, 10);
            $sheet->setSize('H1', 10, 10);
            $sheet->setSize('I1', 10, 10);
            $sheet->setSize('J1', 10, 10);
            $sheet->setSize('K1', 10, 10);
            $sheet->setSize('L1', 10, 10);
            $sheet->cell('D4:L4', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('D5:L5', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D6:F6', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G6:L6', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A7:C7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D7:F7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G7:L7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A8:C8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D8:F8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G8:L8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A9:C9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D9:F9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G9:L9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A10:C10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D10:F10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G10:L10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A11:C11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D11:F11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G11:L11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A12:L12', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A14:CA14', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A15:BW15', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A16:BW16', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A17:BW17', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A18:BW18', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A19:BW19', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A20:BW20', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });

            /*
            $letras=DB::select('SELECT * FROM `pres_letras` ORDER BY `pres_letras`.`id_letra` ASC');

            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'21:'.$letra->letra.'83', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A84:CC84', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'85:'.$letra->letra.'182', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A183:CC183', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'184:'.$letra->letra.'187', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A188:CC188', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A189:CC189', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });*/
            $letras=DB::select('SELECT * FROM `pres_letras` ORDER BY `pres_letras`.`id_letra` ASC');
            $numero_inicial=21;
            $numero_final=20;

            foreach ( $array_part_ant as $part){
                if($part['numero_partida'] == 1){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;

                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;


                    }

                }
                if($part['numero_partida'] == 2){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }
                if($part['numero_partida'] == 3){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }
                if($part['numero_partida'] == 4){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;

                    }

                }
                if($part['numero_partida'] == 5){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;

                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }


            }

            $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $etiqueta=DB::selectOne('SELECT * FROM `etiqueta` WHERE `id_etiqueta` = 1');
            $mes=DB::selectOne('SELECT * FROM `pres_mes` WHERE `id_mes` = '.$id_mes.' ');

            //dd($presupuesto_ante_proy);
            $sheet->loadView('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.excel_req_mes',compact('id_presupuesto','array_cap','array_capitulos','id_mes','etiqueta','proyecto','mes'));

        });

    })->export('xls');
    return back();


}
public function presupuesto_metas_ant_excel($id_presupuesto, $id_meta){
    Session::put('id_presupuest',$id_presupuesto);
    Session::put('id_met',$id_meta);
    $proyecto=DB::selectOne('SELECT pres_proyectos.nombre_proyecto, pres_presupuesto_anteproyecto.* 
    from pres_proyectos, pres_presupuesto_anteproyecto where pres_proyectos.id_proyecto = pres_presupuesto_anteproyecto.id_proyecto 
    and pres_presupuesto_anteproyecto.id_presupuesto='.$id_presupuesto.'');

    Session::put('nombre_proy',$proyecto->nombre_proyecto);
    Session::put('year_ante',$proyecto->year);
    Excel::create('Proyecto_'.$proyecto->year, function($excel)
    {

        $excel->sheet('Requisiciones', function($sheet)
        {

            $id_presupuesto=Session::get('id_presupuest');
            $id_meta=Session::get('id_met');

            $proyecto= DB::selectOne('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto from pres_presupuesto_anteproyecto, pres_proyectos
       WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');
            $etiqueta=DB::selectOne('SELECT * FROM `etiqueta` WHERE `id_etiqueta` = 1');


            ///presupuesto del proyecto del anteproyecto
            /* $presupuesto_ante_proy=DB::select('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from
        pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo
         and pres_fuentes_financiamiento.id_presupuesto_ante = '.$id_presupuesto.' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');
             */

            $capitulos=DB::select('SELECT * FROM `pres_capitulos` ORDER BY `pres_capitulos`.`id_capitulo` ASC ');
            $array_cap=array();
            foreach ($capitulos as $capitulo){
                $cap['id_capitulo']=$capitulo->id_capitulo;
                $cap['capitulo']=$capitulo->capitulo;
                $presupuesto_ante_proy=DB::selectOne('SELECT pres_fuentes_financiamiento.*, pres_capitulos.capitulo from 
               pres_fuentes_financiamiento, pres_capitulos where pres_fuentes_financiamiento.id_capitulo = pres_capitulos.id_capitulo and
                pres_capitulos.id_capitulo='.$capitulo->id_capitulo.'
                and pres_fuentes_financiamiento.id_presupuesto_ante = '.$id_presupuesto.' ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

                if($presupuesto_ante_proy == null){
                    $cap['id_fuente_financiamiento'] = 0;
                    $cap['id_presupuesto_ante'] = 0;
                    $cap['presupuesto_estatal'] = 0;
                    $cap['presupuesto_federal'] = 0;
                    $cap['presupuesto_propios'] = 0;
                    $cap['total_presupuesto'] = 0;
                    $cap['financiamiento_estatal'] = 0;
                    $cap['financiamiento_federal'] =0;
                    $cap['financiamiento_propios'] = 0;
                    $cap['total_financiamiento'] = 0;
                }else {
                    $cap['id_fuente_financiamiento'] = $presupuesto_ante_proy->id_fuente_financiamiento;
                    $cap['id_presupuesto_ante'] = $presupuesto_ante_proy->id_presupuesto_ante;
                    $cap['presupuesto_estatal'] = $presupuesto_ante_proy->presupuesto_estatal;
                    $cap['presupuesto_federal'] = $presupuesto_ante_proy->presupuesto_federal;
                    $cap['presupuesto_propios'] = $presupuesto_ante_proy->presupuesto_propios;
                    $cap['total_presupuesto'] = $presupuesto_ante_proy->total_presupuesto;
                    $cap['financiamiento_estatal'] = $presupuesto_ante_proy->financiamiento_estatal;
                    $cap['financiamiento_federal'] = $presupuesto_ante_proy->financiamiento_federal;
                    $cap['financiamiento_propios'] = $presupuesto_ante_proy->financiamiento_propios;
                    $cap['total_financiamiento'] = $presupuesto_ante_proy->total_financiamiento;
                }

                array_push($array_cap,$cap);

            }




/////////777///////7
            $presupuesto_proyecto=DB::select('SELECT *  FROM `pres_fuentes_financiamiento` 
        WHERE `id_presupuesto_ante` = '.$id_presupuesto.'  and total_presupuesto >0 
        ORDER BY `pres_fuentes_financiamiento`.`id_capitulo` ASC');

            $array_capitulos=array();
            $suma_total_capitulo=0;
            $contar_numero_partida=0;
            foreach($presupuesto_proyecto as $presupuesto){

                $contar_partida=DB::selectOne('SELECT count(id_partida_pres)contar from pres_partida_pres WHERE id_capitulo ='.$presupuesto->id_capitulo.'');

                if($contar_partida->contar == 0){

                }else{
                    $contar_partida=$contar_partida->contar;
                    $contar_numero_partida=$contar_numero_partida+1;
                    $dat_cap['contar_partidas']=$contar_partida;
                    $dat_cap['contar_numero_partida']=$contar_numero_partida;
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
            //////////////////
            $array_part_ant=array();
            foreach ( $array_capitulos as $cap){
                $dat['numero_partida']=$cap['contar_numero_partida'];

                $contar_part=0;
                foreach ($cap['array_partidas'] as $partida){
                    $contar_part=$contar_part+1;
                }
                $dat['conteo_partida']=$contar_part;
                array_push($array_part_ant,$dat);
            }
            ////////////////////////
            //dd($array_part_ant);


            //dd($array_capitulos);

            $obj1 = new \PHPExcel_Worksheet_Drawing;
            $obj1->setPath(public_path('img/residencia/logo_estado.jpg')); //your image path
            $obj1->setWidth(80);
            $obj1->setHeight(80);
            $obj1->setCoordinates('A1');
            $obj1->setWorksheet($sheet);
            /*
                        $obj2 = new \PHPExcel_Worksheet_Drawing();
                        $obj2->setPath(public_path('img/logo3.PNG')); //your image path
                        $obj2->setWidth(300);
                        $obj2->setCoordinates('L4');
                        $obj2->setWorksheet($sheet);
            */


// Set font with ->setStyle()`

            /*
                        $sheet->setWidth(array(
                            'A' => 10,
                            'B' => 20,
                            'C' => 20,
                            'D' => 50,
                            'E' => 50,
                            'F' => 50,
                            'G' => 50,
                            'H' => 50,
                            'I' => 50,
                            'J' => 50,
                            'K' => 50,
                            'L' => 50,
                            'M' => 10,
                        ));
                        $sheet->setHeight(array(
                            1     =>  50,
                            2     =>  25
                        ));
            */
            $sheet->setSize('A1', 10, 15);
            $sheet->setSize('B1', 65, 15);
            $sheet->setSize('C1', 10, 10);
            $sheet->setSize('D1', 10, 10);
            $sheet->setSize('E1', 10, 10);
            $sheet->setSize('F1', 10, 10);
            $sheet->setSize('G1', 10, 10);
            $sheet->setSize('H1', 10, 10);
            $sheet->setSize('I1', 10, 10);
            $sheet->setSize('J1', 10, 10);
            $sheet->setSize('K1', 10, 10);
            $sheet->setSize('L1', 10, 10);
            $sheet->cell('D4:L4', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('D5:L5', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D6:F6', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G6:L6', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A7:C7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D7:F7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G7:L7', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A8:C8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D8:F8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G8:L8', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A9:C9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D9:F9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G9:L9', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A10:C10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D10:F10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G10:L10', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A11:C11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('D11:F11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  false
                ));

            });
            $sheet->cell('G11:L11', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A12:L12', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A14:CA14', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A15:BW15', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A16:BW16', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A17:BW17', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A18:BW18', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A19:BW19', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A20:BW20', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '9',
                    'bold'       =>  true
                ));

            });

            /*

            $letras=DB::select('SELECT * FROM `pres_letras` ORDER BY `pres_letras`.`id_letra` ASC');

            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'21:'.$letra->letra.'83', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A84:CC84', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'85:'.$letra->letra.'182', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A183:CC183', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            foreach ($letras as $letra){
                $sheet->cell($letra->letra.'184:'.$letra->letra.'187', function($cell) {

                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '9',
                        'bold'       =>  false
                    ));

                });
            }
            $sheet->cell('A188:CC188', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });
            $sheet->cell('A189:CC189', function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });

*/
            $letras=DB::select('SELECT * FROM `pres_letras` ORDER BY `pres_letras`.`id_letra` ASC');
            $numero_inicial=21;
            $numero_final=20;

            foreach ( $array_part_ant as $part){
                if($part['numero_partida'] == 1){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;

                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;


                    }

                }
                if($part['numero_partida'] == 2){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }
                if($part['numero_partida'] == 3){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }
                if($part['numero_partida'] == 4){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;
                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;

                    }

                }
                if($part['numero_partida'] == 5){
                    if($part['conteo_partida'] >0){

                        $numero_final=$numero_final+$part['conteo_partida'];
                        foreach ($letras as $letra){
                            $sheet->cell($letra->letra.''.$numero_inicial.':'.$letra->letra.''.$numero_final, function($cell) {

                                // Set font
                                $cell->setFont(array(
                                    'family'     => 'Arial',
                                    'size'       => '9',
                                    'bold'       =>  false
                                ));

                            });
                        }
                        $numero_inicial=$numero_final+1;

                        $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                            // Set font
                            $cell->setFont(array(
                                'family'     => 'Arial',
                                'size'       => '10',
                                'bold'       =>  true
                            ));

                        });
                        $numero_inicial=$numero_inicial+1;
                        $numero_final=$numero_final+1;

                    }

                }


            }

            $sheet->cell('A'.$numero_inicial.':CC'.$numero_inicial, function($cell) {

                // Set font
                $cell->setFont(array(
                    'family'     => 'Arial',
                    'size'       => '10',
                    'bold'       =>  true
                ));

            });

            $meta=DB::selectOne('SELECT * FROM `pres_metas` WHERE `id_meta` = '.$id_meta.'');

//dd($proyecto);
            //dd($presupuesto_ante_proy);
            $sheet->loadView('departamento_finanzas.jefe_finanazas.requisiciones_autorizadas_pro.excel_req_meta_proyecto_completo',compact('id_presupuesto','array_cap','array_capitulos','etiqueta','proyecto','meta'));

        });

    })->export('xls');
    return back();
}
}
