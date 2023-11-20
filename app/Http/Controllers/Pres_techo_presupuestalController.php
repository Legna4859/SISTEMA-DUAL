<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class Pres_techo_presupuestalController extends Controller
{
    public function index(){
        $year = date('Y');
        $year = $year+1;

        $proyectos=DB::select('SELECT * FROM `pres_proyectos` 
        where   year = '.$year.' and id_estado = 1 and id_proyecto NOT in (SELECT id_proyecto from pres_presupuesto_anteproyecto where year ='.$year.')
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
//dd($presupuestos_anteproyectos);

//dd($capitulo1);
//dd($contar_f);
       return view('departamento_finanzas.techo_presupuestal_anteproyecto.techo_presupuestal_ante',compact('proyectos','year','presupuestos_anteproyectos','contar_f'));
    }
    public function agregar_proyecto_techo_presupuestal_ante(Request $request){
        $this->validate($request,[
            'id_proyecto' => 'required',
        ]);
        $id_proyecto= $request->input("id_proyecto");
        $year = date('Y');
        $year = $year+1;
        $fecha_actual = date("Y-m-d");
        DB:: table('pres_presupuesto_anteproyecto')->insert([
            'id_proyecto' => $id_proyecto,
            'year' => $year,
            'fecha_registro' => $fecha_actual,
        ]);

        return back();
    }
    public function agregar_fuentes_financiamiento_ante($id_presupuesto){
        $proyecto=DB::selectOne('SELECT pres_presupuesto_anteproyecto.*, pres_proyectos.nombre_proyecto 
        from pres_presupuesto_anteproyecto, pres_proyectos WHERE pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto
        and pres_presupuesto_anteproyecto.id_presupuesto ='.$id_presupuesto.' ');

        $capitulos=DB::select('SELECT pres_capitulos.* from pres_capitulos
      where pres_capitulos.id_capitulo NOT in (SELECT pres_fuentes_financiamiento.id_capitulo 
      from pres_fuentes_financiamiento WHERE pres_fuentes_financiamiento.id_presupuesto_ante='.$id_presupuesto.') ORDER BY pres_capitulos.id_capitulo ASC');

        return view('departamento_finanzas.techo_presupuestal_anteproyecto.partials_agregar_capitulo',compact('proyecto','capitulos'));
    }
    public function guardar_fuentes_financiamiento_ante(Request $request,$id_presupuesto){

        $this->validate($request,[
            'id_capitulo' => 'required',
            'presupuesto_estatal' => 'required',
            'presupuesto_federal' => 'required',
            'presupuesto_propios' => 'required',
        ]);
        $fecha_actual = date("Y-m-d");
        $id_capitulo= $request->input("id_capitulo");
        $presupuesto_estatal= $request->input("presupuesto_estatal");
        $presupuesto_federal= $request->input("presupuesto_federal");
        $presupuesto_propios= $request->input("presupuesto_propios");
        $total_presupuesto=$presupuesto_estatal+$presupuesto_federal+$presupuesto_propios;
        if($presupuesto_estatal == 0){
            $porcentaje_estatall = round($presupuesto_estatal,4);
        }else{
            $porcentaje_estatall = $presupuesto_estatal/$total_presupuesto;

        }
       if( $presupuesto_federal == 0){
           $porcentaje_federall = round($presupuesto_federal,4);
       }else{
           $porcentaje_federall = $presupuesto_federal/$total_presupuesto;

       }
        if( $presupuesto_propios == 0){
            $porcentaje_propioss = round($presupuesto_propios,4);
        }else{
            $porcentaje_propioss = $presupuesto_propios/$total_presupuesto;
        }
        $porcentaje_total=$porcentaje_estatall+$porcentaje_federall+$porcentaje_propioss;
        $porcentaje_total=round($porcentaje_total,2);

        DB:: table('pres_fuentes_financiamiento')->insert([
            'id_presupuesto_ante' => $id_presupuesto,
            'id_capitulo' => $id_capitulo,
            'presupuesto_estatal' => $presupuesto_estatal,
            'presupuesto_federal' => $presupuesto_federal,
            'presupuesto_propios' => $presupuesto_propios,
            'total_presupuesto' => $total_presupuesto,
            'financiamiento_estatal' => $porcentaje_estatall,
            'financiamiento_federal' => $porcentaje_federall,
            'financiamiento_propios' => $porcentaje_propioss,
            'total_financiamiento' => $porcentaje_total,
            'fecha_registro'=>$fecha_actual,
        ]);

        return back();

    }
    public function mod_fuentes_financiamiento($id_fuente_financiamiento){
        $capitulo=DB::selectOne('SELECT pres_fuentes_financiamiento.*, pres_proyectos.nombre_proyecto,
        pres_presupuesto_anteproyecto.year from pres_fuentes_financiamiento, pres_presupuesto_anteproyecto, pres_proyectos 
        where pres_fuentes_financiamiento.id_presupuesto_ante = pres_presupuesto_anteproyecto.id_presupuesto and
        pres_proyectos.id_proyecto =pres_presupuesto_anteproyecto.id_proyecto and
        pres_fuentes_financiamiento.id_fuente_financiamiento ='.$id_fuente_financiamiento.'');

        return view('departamento_finanzas.techo_presupuestal_anteproyecto.partials_modificar_capitulo',compact('capitulo'));

    }
    public function guardar_mod_capitulo(Request $request,$id_fuente_financiamiento){

        $this->validate($request,[
            'presupuesto_estatal_mod' => 'required',
            'presupuesto_federal_mod' => 'required',
            'presupuesto_propios_mod' => 'required',
        ]);
        $fecha_actual = date("Y-m-d");

        $presupuesto_estatal= $request->input("presupuesto_estatal_mod");
        $presupuesto_federal= $request->input("presupuesto_federal_mod");
        $presupuesto_propios= $request->input("presupuesto_propios_mod");
        $total_presupuesto=$presupuesto_estatal+$presupuesto_federal+$presupuesto_propios;
        if($presupuesto_estatal == 0){
            $porcentaje_estatal=round($presupuesto_estatal,4);
        }else{
            $porcentaje_estatal=$presupuesto_estatal/$total_presupuesto;
        }
        if( $presupuesto_federal == 0){
            $porcentaje_federal=round($presupuesto_federal,4);
        }else{
            $porcentaje_federal=$presupuesto_federal/$total_presupuesto;
        }
        if( $presupuesto_propios == 0){
            $porcentaje_propios=round($presupuesto_propios,4);
        }else{
            $porcentaje_propios=$presupuesto_propios/$total_presupuesto;
        }
        $porcentaje_total=$porcentaje_estatal+$porcentaje_federal+$porcentaje_propios;
        $porcentaje_total=round($porcentaje_total,2);


        DB::table('pres_fuentes_financiamiento')
            ->where('id_fuente_financiamiento', $id_fuente_financiamiento)
            ->update([
                'presupuesto_estatal' => $presupuesto_estatal,
                'presupuesto_federal' => $presupuesto_federal,
                'presupuesto_propios' => $presupuesto_propios,
                'total_presupuesto' => $total_presupuesto,
                'financiamiento_estatal' => $porcentaje_estatal,
                'financiamiento_federal' => $porcentaje_federal,
                'financiamiento_propios' => $porcentaje_propios,
                'total_financiamiento' => $porcentaje_total,
                'fecha_modificacion'=>$fecha_actual,
            ]);


        return back();

    }
    public function agregar_fuentes_f_ante($id_proyecto){
        $year = date('Y');
        $year = $year+1;



        $registro_proyectos=DB::select('SELECT pres_presupuesto_anteproyecto.*,pres_proyectos.nombre_proyecto 
        FROM pres_presupuesto_anteproyecto,pres_proyectos WHERE pres_presupuesto_anteproyecto.id_proyecto ='.$id_proyecto.' 
        and pres_presupuesto_anteproyecto.id_proyecto = pres_proyectos.id_proyecto and pres_presupuesto_anteproyecto.year='.$year.'');


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
                $total_presupuesto_estatal=$total_presupuesto_estatal/$total_presupuesto_proyecto;
            }
            $reg['total_financiamiento_estatal']=$total_presupuesto_estatal;
            if($total_presupuesto_federal == 0){
                $total_presupuesto_federal=$total_presupuesto_federal;

            }else{
                $total_presupuesto_federal=$total_presupuesto_federal/$total_presupuesto_proyecto;
            }
            $reg['total_financiamiento_federal']=$total_presupuesto_federal;
            if($total_presupuesto_propios == 0){
                $total_presupuesto_propios=$total_presupuesto_propios;

            }else{
                $total_presupuesto_propios=$total_presupuesto_propios/$total_presupuesto_proyecto;
            }
            $reg['total_financiamiento_propios']=$total_presupuesto_propios;
            $reg['total_gastos_operativos']=$gastos_operativos;
            $reg['total_total_financiamiento']=$total_presupuesto_estatal+$total_presupuesto_federal+$total_presupuesto_propios;

            array_push($presupuestos_anteproyectos,$reg);
        }

        return view('departamento_finanzas.techo_presupuestal_anteproyecto.agregar_capitulos_anteproyecto',compact('year','presupuestos_anteproyectos','contar_f'));

    }
    public function agregar_bienes_servicios_anteproyecto($id_actividades_req_ante){



        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante='.$id_actividades_req_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');
        //dd($requisiciones);

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
        and pres_actividades_req_ante.id_actividades_req_ante ='.$id_actividades_req_ante.'');


        return view('departamento_finanzas.jefe_departamento.ver_registroactividades', compact( 'requisiciones2','datos_req_envio','total_req','id_actividades_req_ante'));

    }
}
