<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_reg_datos_alumnosController extends Controller
{
    public function reg_datos_personales(){
        $id_usuario = Session::get('usuario_alumno');
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_usuario` = '.$id_usuario.'');
        $id_alumno=$alumno->id_alumno;
        return view('titulacion.alumno_titulacion.segunda_etapa.registro_datos_personales',compact('id_alumno'));
    }
    public function estado_reg_personales($id_alumno){
        $contar=DB::selectOne('SELECT count(id_reg_dato_alum) contar from ti_reg_datos_alum WHERE id_alumno='.$id_alumno.'');
        $contar=$contar->contar;
        return $contar;
    }
    public function datos_personales($id_alumno){
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` = '.$id_alumno.'');
        $titulacion=DB::selectOne('SELECT * FROM `ti_requisitos_titulacion` WHERE `id_alumno` = '.$id_alumno.' ');
        $correo_electronico=$titulacion->correo_electronico;
        $curp=$alumno->curp_al;
        $id_carrera=$alumno->id_carrera;
        $id_semestre=$alumno->id_semestre;
        $reg_descuento=DB::selectOne('SELECT * FROM `ti_descuentos_alum` WHERE `id_alumno` = '.$id_alumno.' ');
        $id_tipo_descuento=$reg_descuento->id_tipo_desc;
        $telefono=$reg_descuento->telefono;
        $id_opcion_titulacion=$titulacion->id_opcion_titulacion;
        $id_periodo = Session::get('periodo_actual');
         $id_unidad_admin=0;
        if($id_carrera == 1){
            $id_unidad_admin=7;
        }
        if($id_carrera == 2){
            $id_unidad_admin=6;
        }
        if($id_carrera == 3){
            $id_unidad_admin=8;
        }
        if($id_carrera == 4){
            $id_unidad_admin=9;
        }
        if($id_carrera == 5){
            $id_unidad_admin=10;
        }
        if($id_carrera == 6){
            $id_unidad_admin=11;
        }
        if($id_carrera == 7){
            $id_unidad_admin=12;
        }
        if($id_carrera == 8){
            $id_unidad_admin=29;
        }
        if($id_carrera == 13){
            $id_unidad_admin=33;
        }
        if($id_carrera == 14){
            $id_unidad_admin=41;

        }
        $jefe_division=DB::selectOne('SELECT gnral_personales.id_personal,gnral_personales.nombre FROM
        gnral_unidad_personal,gnral_personales WHERE gnral_unidad_personal.id_personal=gnral_personales.id_personal
                                                 and gnral_unidad_personal.id_unidad_admin='.$id_unidad_admin.'');
       $id_personal= $jefe_division->id_personal;
        $nombre_jefe=$jefe_division->nombre;
        $datos_personales=array();
        $datos_personales['id_alumno']=$id_alumno;
        $datos_personales['correo_electronico']=$correo_electronico;
        $datos_personales['curp']=$curp;
        $datos_personales['id_carrera']=$id_carrera;
        $datos_personales['id_semestre']=$id_semestre;
        $datos_personales['id_tipo_descuento']=$id_tipo_descuento;
        $datos_personales['id_opcion_titulacion']=$id_opcion_titulacion;
        $datos_personales['id_personal']=$id_personal;
        $datos_personales['nombre_jefe']=$nombre_jefe;
        $datos_personales['telefono']=$telefono;
        return $datos_personales;


    }
    public function careras_tesvb(){
        $carreras= DB::select('SELECT * FROM `gnral_carreras` ORDER BY `id_carrera` ASC ');
        return $carreras;
    }
    public function planes_estudio_tesvb(){
        $planes_estudios= DB::select('SELECT * FROM `ti_planes_estudios`');
        return $planes_estudios;
    }
    public function respuestas_tesvb(){
        $respuestas=DB::select('SELECT * FROM `ti_respuesta` ');
        return $respuestas;
    }
    public function numeros_semestres_tesvb(){
        $numero_semestres=DB::select('SELECT * FROM `gnral_semestres` ');
        return $numero_semestres;
    }
    public function opciones_titulacion_tesvb(){
        $opciones_titulacion=DB::select('SELECT * FROM `ti_opciones_titulacion` ');
        return $opciones_titulacion;
    }
    public function entidades_federativas(){
        $estados=DB::select('SELECT * FROM `gnral_estados` ');
        return $estados;
    }
    public function municipios($id_estado){
        $municipios=DB::select('SELECT * FROM `gnral_municipios` WHERE `id_estado` = '.$id_estado.' ');
        return $municipios;
    }
    public function tipo_donaciones($id_tipo_descuento){
        if($id_tipo_descuento == 3){
            $tipos_donaciones=DB::select('SELECT * FROM `ti_tipos_donacion` WHERE `id_tipo_donacion` = 3   ');
        }
        if($id_tipo_descuento == 2 || $id_tipo_descuento == 1){
            $tipos_donaciones=DB::select('SELECT * FROM `ti_tipos_donacion` WHERE `id_tipo_donacion` != 3   ');
        }

        return  $tipos_donaciones;
    }
    public function nacionalidades(){
        $nacionalidades=DB::select('SELECT * FROM `ti_nacionalidad` ');
        return $nacionalidades;
    }
    public function registrar_datos_alumno(Request $request){

        $id_alumno = $request->input("id_alumno");
        $correo_electronico = $request->input("correo_electronico");
        $no_cuenta = $request->input("no_cuenta");
        $id_tipo_estudiante = $request->input("id_tipo_estudiante");
        $fecha_emision_certificado = $request->input("fecha_emision_certificado");
        $fecha_reg_tramite_titulacion = $request->input("fecha_reg_tramite_titulacion");
        $fecha_pag_derechos_titulacion = $request->input("fecha_pag_derechos_titulacion");
        $nombre_al = $request->input("nombre_al");
        $apaterno = $request->input("apaterno");
        $amaterno = $request->input("amaterno");
        $curp_al = $request->input("curp_al");
        $id_carrera = $request->input("id_carrera");
        $id_plan_estudio = $request->input("id_plan_estudio");
        $promedio_general_tesvb = $request->input("promedio_general_tesvb");
        $reprobacion_mat = $request->input("reprobacion_mat");
        $fecha_ingreso_tesvb = $request->input("fecha_ingreso_tesvb");
        $fecha_egreso_tesvb = $request->input("fecha_egreso_tesvb");
        $id_semestre = $request->input("id_semestre");
        $id_opcion_titulacion = $request->input("id_opcion_titulacion");
        $mension_honorifica=0;
        if($promedio_general_tesvb >= 95 and $reprobacion_mat == 2 and $id_opcion_titulacion != 7){
            $mension_honorifica=1;
        }else{
            $mension_honorifica=2;
        }
        $nom_proyecto = $request->input("nom_proyecto");
        $calle_domicilio = $request->input("calle_domicilio");
        $numero_domicilio = $request->input("numero_domicilio");
        $colonia_domicilio = $request->input("colonia_domicilio");
        $municipio_domicilio = $request->input("municipio_domicilio");
        $entidad_federativa = $request->input("entidad_federativa");
        $telefono = $request->input("telefono");
        $id_jefe_division = $request->input("id_jefe_division");
        $nom_empresa = $request->input("nom_empresa");

        $id_red_social = $request->input("id_red_social");
        $nombre_usuario_red = $request->input("nombre_usuario_red");
        $id_tipo_donacion = $request->input("id_tipo_donacion");
        $presenta_discapacidad = $request->input("presenta_discapacidad");
        if($presenta_discapacidad == 2){
            $discapacidad_que_presenta = "";
        }else{
            $discapacidad_que_presenta = $request->input("discapacidad_que_presenta");
        }
        $lengua_indigena = $request->input("lengua_indigena");

        if($lengua_indigena == 2){
            $habla_lengua_indigena ="";
        }else{
            $habla_lengua_indigena = $request->input("habla_lengua_indigena");
        }

        $id_nacionalidad = $request->input("id_nacionalidad");
        $fecha_egreso_preparatoria = $request->input("fecha_egreso_preparatoria");
        $fecha_ingreso_preparatoria = $request->input("fecha_ingreso_preparatoria");

        $hoy = date("Y-m-d H:i:s");

        DB:: table('ti_reg_datos_alum')->insert([
            'correo_electronico' => $correo_electronico,
            'id_alumno' => $id_alumno,
            'fecha_emision_certificado' => $fecha_emision_certificado,
            'fecha_reg_tramite_titulacion' => $fecha_reg_tramite_titulacion,
            'fecha_pag_derechos_titulacion' => $fecha_pag_derechos_titulacion,
            'no_cuenta' => $no_cuenta,
            'id_tipo_estudiante' => $id_tipo_estudiante,
            'nombre_al' => $nombre_al,
            'apaterno' => $apaterno,
            'amaterno' => $amaterno,
            'curp_al' => $curp_al,
             'id_carrera' => $id_carrera,
             'id_semestre' => $id_semestre,
             'id_plan_estudio' => $id_plan_estudio,
             'promedio_general_tesvb' => $promedio_general_tesvb,
             'reprobacion_mat' => $reprobacion_mat,
             'fecha_ingreso_tesvb' => $fecha_ingreso_tesvb,
             'fecha_egreso_tesvb' => $fecha_egreso_tesvb,
             'id_opcion_titulacion' => $id_opcion_titulacion,
             'nom_proyecto' => $nom_proyecto,
             'calle_domicilio' => $calle_domicilio,
             'numero_domicilio' => $numero_domicilio,
             'colonia_domicilio' => $colonia_domicilio,
             'municipio_domicilio' => $municipio_domicilio,
             'entidad_federativa' => $entidad_federativa,
             'telefono' => $telefono,
             'id_jefe_division' => $id_jefe_division,
             'nom_empresa' => $nom_empresa,
             'id_red_social' => $id_red_social,
            'nombre_usuario_red' => $nombre_usuario_red,
             'id_tipo_donacion' => $id_tipo_donacion,
             'presenta_discapacidad' => $presenta_discapacidad,
             'discapacidad_que_presenta' => $discapacidad_que_presenta,
            'lengua_indigena' => $lengua_indigena,
             'habla_lengua_indigena' => $habla_lengua_indigena,
            'fecha_registro' => $hoy,
            'mencion_honorifica' => $mension_honorifica,
            'id_nacionalidad' => $id_nacionalidad,
            'fecha_egreso_preparatoria' => $fecha_egreso_preparatoria,
            'fecha_ingreso_preparatoria' => $fecha_ingreso_preparatoria,


        ]);


    }
    public function ver_datos_alumno_registrados($id_alumno){
       $datos_reg=DB::select('SELECT ti_reg_datos_alum.*, gnral_personales.nombre FROM
                                                         ti_reg_datos_alum, gnral_personales 
where ti_reg_datos_alum.id_jefe_division=gnral_personales.id_personal and ti_reg_datos_alum.id_alumno='.$id_alumno.' ');
       return $datos_reg;
    }
    public function modificar_datos_alumno(Request $request){
        $id_reg_dato_alum = $request->input("id_reg_dato_alum");
        $correo_electronico = $request->input("correo_electronico");
        $no_cuenta = $request->input("no_cuenta");
        $id_tipo_estudiante = $request->input("id_tipo_estudiante");
        $fecha_emision_certificado = $request->input("fecha_emision_certificado");
        $fecha_reg_tramite_titulacion = $request->input("fecha_reg_tramite_titulacion");
        $fecha_pag_derechos_titulacion = $request->input("fecha_pag_derechos_titulacion");
        $nombre_al = $request->input("nombre_al");
        $apaterno = $request->input("apaterno");
        $amaterno = $request->input("amaterno");
        $curp_al = $request->input("curp_al");
        $id_carrera = $request->input("id_carrera");
        $id_plan_estudio = $request->input("id_plan_estudio");
        $promedio_general_tesvb = $request->input("promedio_general_tesvb");
        $reprobacion_mat = $request->input("reprobacion_mat");
        $fecha_ingreso_tesvb = $request->input("fecha_ingreso_tesvb");
        $fecha_egreso_tesvb = $request->input("fecha_egreso_tesvb");
        $id_semestre = $request->input("id_semestre");
        $id_opcion_titulacion = $request->input("id_opcion_titulacion");
        $mension_honorifica=0;
        if($promedio_general_tesvb >= 95 and $reprobacion_mat == 2 and $id_opcion_titulacion != 7){
            $mension_honorifica=1;
        }else{
            $mension_honorifica=2;
        }
        $nom_proyecto = $request->input("nom_proyecto");
        $calle_domicilio = $request->input("calle_domicilio");
        $numero_domicilio = $request->input("numero_domicilio");
        $colonia_domicilio = $request->input("colonia_domicilio");
        $municipio_domicilio = $request->input("municipio_domicilio");
        $entidad_federativa = $request->input("entidad_federativa");
        $telefono = $request->input("telefono");
        $id_jefe_division = $request->input("id_jefe_division");
        $nom_empresa = $request->input("nom_empresa");
        $id_red_social = $request->input("id_red_social");
        $nombre_usuario_red = $request->input("nombre_usuario_red");
        $red_social = $request->input("red_social");
        $id_tipo_donacion = $request->input("id_tipo_donacion");
        $presenta_discapacidad = $request->input("presenta_discapacidad");
        if($presenta_discapacidad == 2){
            $discapacidad_que_presenta = "";
        }else{
            $discapacidad_que_presenta = $request->input("discapacidad_que_presenta");
        }
        $lengua_indigena = $request->input("lengua_indigena");

        if($lengua_indigena == 2){
            $habla_lengua_indigena ="";
        }else{
            $habla_lengua_indigena = $request->input("habla_lengua_indigena");
        }
        $id_nacionalidad = $request->input("id_nacionalidad");
        $fecha_ingreso_preparatoria = $request->input("fecha_ingreso_preparatoria");
        $fecha_egreso_preparatoria = $request->input("fecha_egreso_preparatoria");



        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_reg_datos_alum')
            ->where('id_reg_dato_alum', $id_reg_dato_alum)
            ->update([
                'correo_electronico' => $correo_electronico,
                'fecha_emision_certificado' => $fecha_emision_certificado,
                'fecha_reg_tramite_titulacion' => $fecha_reg_tramite_titulacion,
                'fecha_pag_derechos_titulacion' => $fecha_pag_derechos_titulacion,
                'no_cuenta' => $no_cuenta,
                'id_tipo_estudiante' => $id_tipo_estudiante,
                'nombre_al' => $nombre_al,
                'apaterno' => $apaterno,
                'amaterno' => $amaterno,
                'curp_al' => $curp_al,
                'id_carrera' => $id_carrera,
                'id_semestre' => $id_semestre,
                'id_plan_estudio' => $id_plan_estudio,
                'promedio_general_tesvb' => $promedio_general_tesvb,
                'reprobacion_mat' => $reprobacion_mat,
                'fecha_ingreso_tesvb' => $fecha_ingreso_tesvb,
                'fecha_egreso_tesvb' => $fecha_egreso_tesvb,
                'id_opcion_titulacion' => $id_opcion_titulacion,
                'nom_proyecto' => $nom_proyecto,
                'calle_domicilio' => $calle_domicilio,
                'numero_domicilio' => $numero_domicilio,
                'colonia_domicilio' => $colonia_domicilio,
                'municipio_domicilio' => $municipio_domicilio,
                'entidad_federativa' => $entidad_federativa,
                'telefono' => $telefono,
                'id_jefe_division' => $id_jefe_division,
                'nom_empresa' => $nom_empresa,
                'id_red_social' => $id_red_social,
                'nombre_usuario_red' => $nombre_usuario_red,
                'id_tipo_donacion' => $id_tipo_donacion,
                'presenta_discapacidad' => $presenta_discapacidad,
                'discapacidad_que_presenta' => $discapacidad_que_presenta,
                'lengua_indigena' => $lengua_indigena,
                'habla_lengua_indigena' => $habla_lengua_indigena,
                'fecha_registro' => $hoy,
                'mencion_honorifica' => $mension_honorifica,
                'id_nacionalidad' => $id_nacionalidad,
                'fecha_ingreso_preparatoria' => $fecha_ingreso_preparatoria,
                'fecha_egreso_preparatoria' => $fecha_egreso_preparatoria,

            ]);
    }
    public function registrar_libro(Request $request, $id_reg_dato_alum){
        $autor = $request->input("autor");
        $editorial = $request->input("editorial");
        $titulo = $request->input("titulo");
        $hoy = date("Y-m-d H:i:s");
        DB:: table('ti_titulos_libros')->insert([
            'id_reg_dato_alumno' => $id_reg_dato_alum,
            'titulo' => $titulo,
            'autor' => $autor,
            'editorial' => $editorial,
            'fecha_registro' => $hoy,
        ]);
    }
    public function registrar_computo(Request $request, $id_reg_dato_alum){
        $nombre_equipo = $request->input("nombre_equipo");
        $descripcion = $request->input("descripcion");
        $folio_fiscal = $request->input("folio_fiscal");
        $nombre_tienda = $request->input("nombre_tienda");
        $hoy = date("Y-m-d H:i:s");
        DB:: table('ti_equipos_computo')->insert([
            'id_reg_dato_alum' => $id_reg_dato_alum,
            'nombre_equipo' => $nombre_equipo,
            'descripcion' => $descripcion,
            'folio_fiscal' => $folio_fiscal,
            'nombre_tienda' => $nombre_tienda,
            'fecha_registro' => $hoy,
        ]);
    }
    public function ver_libros($id_reg_dato_alum){
        $registro_libros=DB::select('SELECT * FROM `ti_titulos_libros` WHERE `id_reg_dato_alumno` = '.$id_reg_dato_alum.' ');
        return $registro_libros;
    }
    public function modificacion_libro(Request $request){
        $id_titulo_libro = $request->input("id_titulo_libro");
        $autor = $request->input("autor");
        $editorial = $request->input("editorial");
        $titulo = $request->input("titulo");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_titulos_libros')
            ->where('id_titulo_libro', $id_titulo_libro)
            ->update([
                'autor' => $autor,
                'editorial' => $editorial,
                'titulo' => $titulo,
                'fecha_registro' => $hoy,
                ]);
    }
    public function eliminacion_libro(Request $request){
        $id_titulo_libro = $request->input("id_titulo_libro");
        DB::delete('DELETE FROM ti_titulos_libros WHERE id_titulo_libro='.$id_titulo_libro.'');

    }
    public function ver_material_computo($id_reg_dato_alum){
        $material_computo=DB::select('SELECT * FROM `ti_equipos_computo` WHERE `id_reg_dato_alum` = '.$id_reg_dato_alum.'');
        return $material_computo;
    }
    public function modificar_computo(Request $request){
        $id_equipo_computo = $request->input("id_equipo_computo");
        $nombre_equipo = $request->input("nombre_equipo");
        $descripcion = $request->input("descripcion");
        $folio_fiscal = $request->input("folio_fiscal");
        $nombre_tienda = $request->input("nombre_tienda");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_equipos_computo')
            ->where('id_equipo_computo', $id_equipo_computo)
            ->update([
                'nombre_equipo' => $nombre_equipo,
                'descripcion' => $descripcion,
                'folio_fiscal' => $folio_fiscal,
                'nombre_tienda' => $nombre_tienda,
                'fecha_registro' => $hoy,
            ]);
    }
    public function eliminacion_computo(Request $request){
        $id_equipo_computo = $request->input("id_equipo_computo");
        DB::delete('DELETE FROM ti_equipos_computo WHERE id_equipo_computo='.$id_equipo_computo.'');
    }
    public function contar_libros($id_reg_dato_alum){
        $contar_libro=DB::selectOne('SELECT COUNT(id_titulo_libro)contar  FROM `ti_titulos_libros` WHERE `id_reg_dato_alumno` = '.$id_reg_dato_alum.'');
    $contar_libro=$contar_libro->contar;
    return $contar_libro;
    }
    public function contar_computo($id_reg_dato_alum){
        $contar_computo=DB::selectOne('SELECT COUNT(id_equipo_computo)contar  FROM `ti_equipos_computo` WHERE `id_reg_dato_alum` = '.$id_reg_dato_alum.'');
        $contar_computo=$contar_computo->contar;
        return $contar_computo;
    }
    public function enviar_datos_alumno(Request $request,$id_reg_dato_alum){
        $fecha_actual =  date("Y-m-d H:i:s");
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,
       gnral_alumnos.amaterno,ti_reg_datos_alum.correo_electronico from
    gnral_alumnos,ti_reg_datos_alum where gnral_alumnos.id_alumno = ti_reg_datos_alum.id_alumno 
                                      and ti_reg_datos_alum.id_reg_dato_alum='.$id_reg_dato_alum.'');
        $nombre_alumno=$alumno->cuenta.' '.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.alumno_titulacion.segunda_etapa.notificacion_envio_reg_datos',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($correo_alumno,$nombre_alumno);
            $message->to($jefe_correo,"")->subject('Notificación de envio de los datos personales de titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        DB::table('ti_reg_datos_alum')
            ->where('id_reg_dato_alum', $id_reg_dato_alum)
            ->update([
                'id_estado_enviado' => 1,
                'fecha_envio' => $fecha_actual,
                ]);
    }
    public function enviar_datos_alumno_mod(Request $request,$id_reg_dato_alum){
        $fecha_actual =  date("Y-m-d H:i:s");
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,
       gnral_alumnos.amaterno,ti_reg_datos_alum.correo_electronico from
    gnral_alumnos,ti_reg_datos_alum where gnral_alumnos.id_alumno = ti_reg_datos_alum.id_alumno 
                                      and ti_reg_datos_alum.id_reg_dato_alum='.$id_reg_dato_alum.'');
        $nombre_alumno=$alumno->cuenta.' '.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.alumno_titulacion.segunda_etapa.notificacion_envio_correciones',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($correo_alumno,$nombre_alumno);
            $message->to($jefe_correo,"")->subject('Notificación de envio de las correcciones de los datos personales de titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        DB::table('ti_reg_datos_alum')
            ->where('id_reg_dato_alum', $id_reg_dato_alum)
            ->update([
                'id_estado_enviado' => 3,
                'fecha_envio' => $fecha_actual,
            ]);
    }
    public function tipos_estudiantes(){
        $tipos_estudiantes=DB::select('SELECT * FROM `ti_tipo_estudiante` ');
        return $tipos_estudiantes;
    }
    public function tipos_redes_sociales(){
        $tipos_redes_sociales=DB::select('SELECT * FROM `ti_redes_sociales` ');
        return $tipos_redes_sociales;

    }
    public function antecedentes_estudios(){
        $antecedentes_estudios=DB::select('SELECT * FROM `ti_tipo_estudio_antecedente` ');
        return $antecedentes_estudios;
    }

}
