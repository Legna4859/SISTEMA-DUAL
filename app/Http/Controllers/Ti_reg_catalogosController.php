<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_reg_catalogosController extends Controller
{
    public function reg_catalogo_tomos_titulo(){
        $catalogos=DB::select('SELECT * FROM `ti_reg_domo_titulos`');
        $estado_activo=DB::selectOne('SELECT count(id_reg_domo) contar FROM ti_reg_domo_titulos where id_estado_tomo = 1');
        $estado_activo=$estado_activo->contar;
        return view('titulacion.jefe_titulacion.catalogos_titulacion.reg_domo_titulacion',compact('catalogos','estado_activo'));
    }
    public function guardar_domo_titulacion(Request $request){
        $abreviacion = $request->input("abreviacion");
        $numero_inicial = $request->input("numero_inicial");
        $numero_final = $request->input("numero_final");

        $hoy = date("Y-m-d H:i:s");

        DB::table('ti_reg_domo_titulos')->insert([
            'abreviacion'=>$abreviacion,
            'numero_inicial'=>$numero_inicial,
            'numero_final'=>$numero_final,
            'fecha_reg'=>$hoy,
        ]);

        return back();

    }
    public function agregar_numeros_titulos_domo(Request $request){
        $id_reg_domo = $request->input("id_reg_domo");
        $reg_domo=DB::selectOne('SELECT * FROM `ti_reg_domo_titulos` WHERE `id_reg_domo` ='.$id_reg_domo.'');
        $numero_inicial=$reg_domo->numero_inicial;
        $numero_final=$reg_domo->numero_final;
        $abreviacion=$reg_domo->abreviacion;
        $hoy = date("Y-m-d H:i:s");
         for( $i=$numero_inicial; $i<=$numero_final; $i++){

             DB::table('ti_numeros_titulos')->insert([
                 'id_reg_domo'=>$id_reg_domo,
                 'numero_titulo'=>$i,
                 'fecha_reg'=>$hoy,
                 'abreviatura_folio_titulo'=>$abreviacion."".$i,

             ]);

         }
        DB::table('ti_reg_domo_titulos')
            ->where('id_reg_domo', $id_reg_domo)
            ->update([
                'id_registrado'=>1,
                'fecha_reg'=>$hoy,
            ]);
         return back();
    }
    public function consultar_domos_numeros_titulos($id_reg_domo){
        $catalogo=DB::selectOne('SELECT * FROM `ti_reg_domo_titulos` WHERE `id_reg_domo` ='.$id_reg_domo.'');
        $tipo_titulacion=DB::select('SELECT * FROM `ti_tipo_titulacion` ');

        $titulos=DB::select('SELECT * FROM `ti_numeros_titulos` WHERE `id_reg_domo` ='.$catalogo->id_reg_domo.'');

        $array_titulos=array();
        foreach ($titulos as $titulo) {
            $dat['id_numero_titulo']=$titulo->id_numero_titulo;
            $dat['numero_titulo']=$titulo->numero_titulo;
            $dat['abreviatura_folio_titulo']=$titulo->abreviatura_folio_titulo;
            $dat['id_estado_numero_titulo']=$titulo->id_estado_numero_titulo;

                if($titulo->id_estado_numero_titulo == 0){
                    $dat['nombre_alumno']="";
                    $dat['id_alumno']="";
                    $dat['comentario']="";
                    $dat['cuenta']="";
                    $dat['estado_numero_titulo']="";
                    $dat['id_tipo_titulacion']=0;
                }
                elseif($titulo->id_estado_numero_titulo == 1){
                  if($titulo->id_tipo_titulacion == 1){
                      $datos_alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` ='.$titulo->id_alumno.'');

                      $dat['nombre_alumno']=$datos_alumno->nombre_al." ".$datos_alumno->apaterno." ".$datos_alumno->amaterno;
                      $dat['id_alumno']=$datos_alumno->id_alumno;
                      $dat['comentario']="";
                      $dat['cuenta']=$datos_alumno->no_cuenta;
                      $dat['estado_numero_titulo']="AUTORIZADO";
                      $dat['id_tipo_titulacion']=1;
                  }else{
                      $dat_alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` ='.$titulo->id_alumno.'');

                      $dat['nombre_alumno']=$dat_alumno->nombre." ".$dat_alumno->apaterno." ".$dat_alumno->amaterno;
                      $dat['id_alumno']=$dat_alumno->id_alumno;
                      $dat['comentario']="";
                      $dat['cuenta']=$dat_alumno->cuenta;
                      $dat['estado_numero_titulo']="AUTORIZADO";
                      $dat['id_tipo_titulacion']=2;
                  }

                }
                elseif($titulo->id_estado_numero_titulo == 2 || $titulo->id_estado_numero_titulo == 3 || $titulo->id_estado_numero_titulo == 4
                || $titulo->id_estado_numero_titulo == 5 || $titulo->id_estado_numero_titulo == 6  ){
                    if($titulo->id_tipo_titulacion == 1) {
                        $datos_alumno = DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` =' . $titulo->id_alumno . '');
                        $estado_numero_titulo = DB::selectOne('SELECT * FROM `ti_estado_numeros_titulos` WHERE `id_estado_numero_titulo` =' . $titulo->id_estado_numero_titulo . '');
                        $dat['nombre_alumno'] = $datos_alumno->nombre_al . " " . $datos_alumno->apaterno . " " . $datos_alumno->amaterno;
                        $dat['id_alumno'] = $datos_alumno->id_alumno;
                        $dat['comentario'] = $titulo->comentario;
                        $dat['cuenta'] = $datos_alumno->no_cuenta;
                        $dat['estado_numero_titulo'] = $estado_numero_titulo->estado_numero_titulo;
                        $dat['id_tipo_titulacion']=1;
                    }else{
                        $dat_alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` ='.$titulo->id_alumno.'');
                        $estado_numero_titulo = DB::selectOne('SELECT * FROM `ti_estado_numeros_titulos` WHERE `id_estado_numero_titulo` =' . $titulo->id_estado_numero_titulo . '');
                        $dat['nombre_alumno']=$dat_alumno->nombre." ".$dat_alumno->apaterno." ".$dat_alumno->amaterno;
                        $dat['id_alumno']=$dat_alumno->id_alumno;
                        $dat['comentario']="";
                        $dat['cuenta']=$dat_alumno->cuenta;
                        $dat['estado_numero_titulo']=$estado_numero_titulo->estado_numero_titulo;
                        $dat['id_tipo_titulacion']=2;
                    }
                }

                array_push($array_titulos,$dat);
            }



        return view('titulacion.jefe_titulacion.catalogos_titulacion.ver_domos_titulacion',compact('array_titulos','catalogo'));
    }
    public function agregar_escuelas_preparatorias(){
      $preparatorias = DB::select('SELECT ti_preparatatoria.*, ti_entidades_federativas.nom_entidad,ti_entidades_federativas.clave_entidad,ti_tipo_estudio_antecedente.tipo_estudio_antecedente,ti_tipo_estudio_antecedente.tipo_educativo_atecedente 
from ti_preparatatoria, ti_entidades_federativas,ti_tipo_estudio_antecedente where ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa  and ti_preparatatoria.id_tipo_estudio_antecedente = ti_tipo_estudio_antecedente.id_tipo_estudio_antecedente
ORDER BY `ti_preparatatoria`.`preparatoria` ASC ');

      $estados=DB::select('SELECT * FROM `ti_entidades_federativas` ');
        $tipo_estudio_antecedente = DB::select('SELECT * FROM `ti_tipo_estudio_antecedente` ');
      return view('titulacion.jefe_titulacion.catalogos_titulacion.reg_preparatoria',compact('preparatorias','estados','tipo_estudio_antecedente'));
    }
    public function guardar_nueva_preparatoria(Request $request){

        $nombre_preparatoria = $request->input("nombre_preparatoria");
        $id_entidad_federativa = $request->input("id_entidad_federativa");
        $id_tipo_estudio_antecedente = $request->input("id_tipo_estudio_antecedente");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_preparatatoria')->insert([
            'preparatoria'=>$nombre_preparatoria,
            'id_entidad_federativa'=>$id_entidad_federativa,
            'id_tipo_estudio_antecedente'=>$id_tipo_estudio_antecedente,
            'fecha_registro'=>$hoy,
        ]);
        return back();

    }
    public function modificar_preparatoria($id_preparatoria){
        $preparatoria=DB::selectOne('SELECT * FROM `ti_preparatatoria` WHERE `id_preparatoria` = '.$id_preparatoria.' ORDER BY `preparatoria` ASC ');
         //dd($preparatoria);
        $estados=DB::select('SELECT * FROM `ti_entidades_federativas` ');
        $tipo_estudio_antecedente = DB::select('SELECT * FROM `ti_tipo_estudio_antecedente` ');
        return view('titulacion.jefe_titulacion.catalogos_titulacion.partials_modificar_preparatoria',compact('preparatoria','estados','tipo_estudio_antecedente'));

    }
    public function guardar_modificacion_preparatoria(Request $request){

        $id_preparatoria = $request->input("id_preparatoria");
        $nombre_preparatoria = $request->input("nombre_preparatoria");
        $estados = $request->input("estados");
        $id_tipo_estudio_antecedente = $request->input("id_tipo_estudio_antecedente");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_preparatatoria')
            ->where('id_preparatoria', $id_preparatoria)
            ->update([
                'preparatoria'=>$nombre_preparatoria,
                'preparatoria'=>$nombre_preparatoria,
                'id_entidad_federativa'=>$estados,
                'id_tipo_estudio_antecedente'=>$id_tipo_estudio_antecedente,
                'fecha_registro'=>$hoy,
            ]);
        return back();
    }
    public function estado_folio_titulo_editar($id_numero_titulo){
        $datos_numero_titulos=DB::selectOne('SELECT ti_numeros_titulos.*,ti_tipo_titulacion.tipo_titulacion 
        from ti_numeros_titulos, ti_tipo_titulacion WHERE ti_numeros_titulos.id_tipo_titulacion = ti_tipo_titulacion.id_tipo_titulacion
        and ti_numeros_titulos.id_numero_titulo ='.$id_numero_titulo.'');
        if($datos_numero_titulos->id_tipo_titulacion == 1){
            $reg =DB::selectOne('SELECT ti_numeros_titulos.id_alumno, ti_reg_datos_alum.no_cuenta,
       ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno 
from ti_numeros_titulos,ti_reg_datos_alum WHERE ti_numeros_titulos.id_alumno = ti_reg_datos_alum.id_alumno
                                            and ti_numeros_titulos.id_numero_titulo = '.$id_numero_titulo.'');
        }
        if($datos_numero_titulos->id_tipo_titulacion == 2){
            $reg= DB::selectOne('SELECT gnral_alumnos.id_alumno, gnral_alumnos.cuenta no_cuenta, 
            gnral_alumnos.nombre nombre_al, gnral_alumnos.apaterno, gnral_alumnos.amaterno from ti_numeros_titulos, gnral_alumnos
            WHERE ti_numeros_titulos.id_alumno = gnral_alumnos.id_alumno and ti_numeros_titulos.id_numero_titulo ='.$id_numero_titulo.'');
        }




       $estados_folio_titulo=DB::select('SELECT * FROM `ti_estado_numeros_titulos` ');

       return view('titulacion.jefe_titulacion.catalogos_titulacion.modificar_estado_folio_titulo',compact('reg','estados_folio_titulo','datos_numero_titulos'));
    }
    public function guardar_modificacion_estado_titulo(Request $request){


        $estados = $request->input("estados");
        $id_numero_titulo = $request->input("id_numero_titulo");
        $comentario_modificacion= $request->input("comentario_modificacion");

        $datos_numero_titulo=DB::selectOne('SELECT ti_numeros_titulos.*,ti_tipo_titulacion.tipo_titulacion 
        from ti_numeros_titulos, ti_tipo_titulacion WHERE ti_numeros_titulos.id_tipo_titulacion = ti_tipo_titulacion.id_tipo_titulacion
        and ti_numeros_titulos.id_numero_titulo ='.$id_numero_titulo.'');
        if($datos_numero_titulo->id_tipo_titulacion == 1){
            $reg =DB::selectOne('SELECT ti_numeros_titulos.id_alumno, ti_reg_datos_alum.no_cuenta,
       ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno 
from ti_numeros_titulos,ti_reg_datos_alum WHERE ti_numeros_titulos.id_alumno = ti_reg_datos_alum.id_alumno
                                            and ti_numeros_titulos.id_numero_titulo = '.$id_numero_titulo.'');
        }
        if($datos_numero_titulo->id_tipo_titulacion == 2){
            $reg= DB::selectOne('SELECT gnral_alumnos.id_alumno, gnral_alumnos.cuenta no_cuenta, 
            gnral_alumnos.nombre nombre_al, gnral_alumnos.apaterno, gnral_alumnos.amaterno from ti_numeros_titulos, gnral_alumnos
            WHERE ti_numeros_titulos.id_alumno = gnral_alumnos.id_alumno and ti_numeros_titulos.id_numero_titulo ='.$id_numero_titulo.'');
        }
        if($estados == 0){
            if($datos_numero_titulo->id_tipo_titulacion == 1) {
                DB::table('ti_datos_alumno_reg_dep')
                    ->where('id_alumno', $reg->id_alumno)
                    ->update([
                        'id_numero_titulo' => 0,
                    ]);
            }
            $hoy = date("Y-m-d H:i:s");
            DB::table('ti_numeros_titulos')
                ->where('id_numero_titulo', $id_numero_titulo)
                ->update([
                    'id_estado_numero_titulo'=>0,
                    'comentario'=>$comentario_modificacion,
                    'fecha_modificacion'=>$hoy,
                ]);

        }

        if($estados == 2 || $estados == 3 || $estados == 4 || $estados == 5 || $estados == 6){
            if($datos_numero_titulo->id_tipo_titulacion == 1) {
                DB::table('ti_datos_alumno_reg_dep')
                    ->where('id_alumno', $reg->id_alumno)
                    ->update([
                        'id_numero_titulo' => 0,
                    ]);
            }
            $hoy = date("Y-m-d H:i:s");
            DB::table('ti_numeros_titulos')
                ->where('id_numero_titulo', $id_numero_titulo)
                ->update([
                    'id_estado_numero_titulo'=>$estados,
                    'comentario'=>$comentario_modificacion,
                    'fecha_modificacion'=>$hoy,
                ]);
        }
        return back();
    }
    public function agregar_estudiante_folio_titulacion($id_numero_titulo){
        $datos_folio=DB::selectOne('SELECT * FROM `ti_numeros_titulos` WHERE `id_numero_titulo` = '.$id_numero_titulo.' ORDER BY `abreviatura_folio_titulo` ASC ');
        $tipos_titulacion=DB::select('SELECT * FROM `ti_tipo_titulacion` ');

        $estudiantes_integrales=DB::select('SELECT ti_datos_alumno_reg_dep.id_alumno,ti_reg_datos_alum.no_cuenta,
       ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno 
FROM `ti_datos_alumno_reg_dep`, ti_reg_datos_alum WHERE ti_datos_alumno_reg_dep.id_numero_titulo = 0 
    AND ti_datos_alumno_reg_dep.id_autorizacion in (3,4) and ti_reg_datos_alum.id_alumno = ti_datos_alumno_reg_dep.id_alumno
ORDER BY `ti_reg_datos_alum`.`apaterno` ASC, 
        `ti_reg_datos_alum`.`amaterno` ASC, `ti_reg_datos_alum`.`nombre_al` ASC ');



        $alumnos=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.id_carrera, gnral_alumnos.apaterno,
        gnral_alumnos.amaterno from gnral_alumnos where id_semestre > 8 and id_alumno not in(SELECT id_alumno 
        from ti_numeros_titulos where id_estado_numero_titulo= 1) ORDER BY `gnral_alumnos`.`apaterno` ASC, 
        `gnral_alumnos`.`amaterno` ASC, `gnral_alumnos`.`nombre` ASC  ');


        $array_alumnos=array();
        foreach ($alumnos as $alumno) {
                $year_cuenta = substr($alumno->cuenta, 0, 4);

            if ($year_cuenta < 2010) {
                $alum['id_alumno']=$alumno->id_alumno;
                $alum['cuenta']=$alumno->cuenta;
                $alum['nombre']=$alumno->apaterno." ".$alumno->amaterno." ".$alumno->nombre;
                array_push($array_alumnos,$alum);
            }
        }

        return view('titulacion.jefe_titulacion.catalogos_titulacion.agregar_estudiante_folio_titulo',compact('tipos_titulacion','datos_folio','array_alumnos','estudiantes_integrales'));

    }
    public function agregar_estudiante_folio_titulacion1($id_numero_titulo){
        $datos_folio=DB::selectOne('SELECT * FROM `ti_numeros_titulos` WHERE `id_numero_titulo` = '.$id_numero_titulo.' ORDER BY `abreviatura_folio_titulo` ASC ');

        $estudiantes=DB::select('SELECT ti_datos_alumno_reg_dep.*,ti_reg_datos_alum.no_cuenta,
       ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno 
FROM `ti_datos_alumno_reg_dep`, ti_reg_datos_alum WHERE ti_datos_alumno_reg_dep.id_numero_titulo = 0 
    AND ti_datos_alumno_reg_dep.id_autorizacion = 4 and ti_reg_datos_alum.id_alumno = ti_datos_alumno_reg_dep.id_alumno ');

        return view('titulacion.jefe_titulacion.catalogos_titulacion.agregar_estudiante_folio_titulo',compact('datos_folio','estudiantes'));

    }
    public function guardar_agregar_folio_titulo(Request $request){

        $id_numero_titulo = $request->input("id_numero_titulo");
        $id_tipo_titulacion = $request->input("id_tipo_titulacion");
        if($id_tipo_titulacion == 1){
            $id_alumno_integral = $request->input("id_alumno_integral");
            $reg_alumno=DB::selectOne('SELECT * FROM `ti_datos_alumno_reg_dep` WHERE `id_alumno` ='.$id_alumno_integral.'');
            $hoy = date("Y-m-d H:i:s");
            DB::table('ti_numeros_titulos')
                ->where('id_numero_titulo', $id_numero_titulo)
                ->update([
                    'id_estado_numero_titulo'=>1,
                    'id_alumno'=>$reg_alumno->id_alumno,
                    'id_tipo_titulacion'=>$id_tipo_titulacion,
                    'fecha_modificacion'=>$hoy,
                ]);
            DB::table('ti_datos_alumno_reg_dep')
                ->where('id_alumno', $reg_alumno->id_alumno)
                ->update([
                    'id_numero_titulo'=>$id_numero_titulo,
                ]);
        }
        if($id_tipo_titulacion == 2){
            $id_alumno_anterior = $request->input("id_alumno_anterior");
            $hoy = date("Y-m-d H:i:s");
            DB::table('ti_numeros_titulos')
                ->where('id_numero_titulo', $id_numero_titulo)
                ->update([
                    'id_estado_numero_titulo'=>1,
                    'id_alumno'=>$id_alumno_anterior,
                    'id_tipo_titulacion'=>$id_tipo_titulacion,
                    'fecha_modificacion'=>$hoy,
                ]);
        }

        return back();
    }
    public function editar_folio_titulo($id_numero_titulo){
        $folio_titulo=DB::selectOne('SELECT * FROM `ti_numeros_titulos` 
WHERE `id_numero_titulo` = '.$id_numero_titulo.' ORDER BY `abreviatura_folio_titulo` ASC ');
        return view('titulacion.jefe_titulacion.catalogos_titulacion.editar_folio_titulacion',compact('folio_titulo'));

    }
    public function guardar_modificacion_folio_titulo(Request $request){

        $id_numero_titulo = $request->input("id_numero_titulo");
        $folio_titulo = $request->input("folio_titulo");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_numeros_titulos')
            ->where('id_numero_titulo',$id_numero_titulo )
            ->update([
                'abreviatura_folio_titulo'=>$folio_titulo,
                'fecha_modificacion'=>$hoy,
            ]);
        return back();

    }
    public  function activar_folios_titulos(Request $request){
        $id_reg_domo = $request->input("id_reg_domo1");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_reg_domo_titulos')
            ->where('id_reg_domo',$id_reg_domo )
            ->update([
                'id_estado_tomo'=>1,
                'fecha_activacion'=>$hoy,
            ]);
        return back();

    }
    public  function finalizar_folios_titulos(Request $request){
        $id_reg_domo = $request->input("id_reg_domo2");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_reg_domo_titulos')
            ->where('id_reg_domo',$id_reg_domo )
            ->update([
                'id_estado_tomo'=>2,
                'fecha_activacion'=>$hoy,
            ]);
        return back();

    }


}
