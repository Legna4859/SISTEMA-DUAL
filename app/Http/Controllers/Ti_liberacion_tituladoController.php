<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use Session;
class Ti_liberacion_tituladoController extends Controller
{
    public function index(){
        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera != 9 and id_carrera != 11 and id_carrera != 15');
        return view('titulacion.jefe_titulacion.liberacion_titulacion.libera_carrera',compact('carreras'));
    }
    public function registro_titulados_carrera($id_carrera){
        $alumnos=DB::select('SELECT ti_reg_datos_alum.no_cuenta, ti_reg_datos_alum.nombre_al,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_reg_datos_alum.id_alumno 
from ti_reg_datos_alum, ti_datos_alumno_reg_dep WHERE ti_reg_datos_alum.id_alumno = ti_datos_alumno_reg_dep.id_alumno 
and ti_datos_alumno_reg_dep.id_liberado_titulado=1 and ti_reg_datos_alum.id_carrera ='.$id_carrera.'');


        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` ='.$id_carrera.'');

        return view('titulacion.jefe_titulacion.liberacion_titulacion.titulados_carrera',compact('alumnos','carrera','id_carrera'));
    }
    public function ver_datos_titulado($id_alumno){
                $registro1= DB::selectOne('SELECT ti_tipos_desc.tipo_desc,ti_descuentos_alum.*,
               ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.id_carrera,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.amaterno
               FROM ti_descuentos_alum, ti_tipos_desc,ti_reg_datos_alum WHERE ti_reg_datos_alum.id_alumno=ti_descuentos_alum.id_alumno 
               and ti_tipos_desc.id_tipo_desc=ti_descuentos_alum.id_tipo_desc and ti_reg_datos_alum.id_alumno='.$id_alumno.'');

                   $preparatoria=DB::selectOne('SELECT ti_preparatatoria.*,ti_tipo_estudio_antecedente.tipo_estudio_antecedente,
                   ti_tipo_estudio_antecedente.tipo_educativo_atecedente,ti_entidades_federativas.nom_entidad,
                   ti_entidades_federativas.clave_entidad from ti_preparatatoria,ti_tipo_estudio_antecedente,
                   ti_entidades_federativas WHERE ti_preparatatoria.id_entidad_federativa= ti_entidades_federativas.id_entidad_federativa 
                   and ti_tipo_estudio_antecedente.id_tipo_estudio_antecedente=ti_preparatatoria.id_tipo_estudio_antecedente and
                   ti_preparatatoria.id_preparatoria='.$registro1->id_preparatoria.'');

                   $documentacion_requisitos=DB::selectOne('SELECT ti_requisitos_titulacion.*,
                   ti_opciones_titulacion.opcion_titulacion  FROM ti_requisitos_titulacion, ti_opciones_titulacion 
                   WHERE ti_requisitos_titulacion.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion 
                   and ti_requisitos_titulacion.id_alumno= '.$id_alumno.'');

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.'');
        $cuenta=$alumno->cuenta;
        $id_carrera=$alumno->id_carrera;
        if($id_carrera == 14){
            $sem_cero= substr($cuenta, 0, 2);
            if($sem_cero == "SC"){
                $year_cuenta= substr($cuenta, 2, 4);

            }else{
                $year_cuenta= substr($cuenta, 0, 4);
            }
        }else{
            $year_cuenta= substr($cuenta, 0, 4);
        }
        if($year_cuenta < 2010 || $id_carrera == 6 || $id_carrera == 8){
            $estado_al=0;
        }else{
            $estado_al=1;
        }
       $estado_egel=$estado_al;
        $certificado_ingles=DB::selectOne('SELECT * FROM `in_certificado_acreditacion` WHERE `id_alumno` = '.$id_alumno.'');

        $datos_personales=DB::selectOne('SELECT ti_reg_datos_alum.*, gnral_semestres.descripcion semestre,
       ti_tipo_estudiante.tipo_estudiante,gnral_carreras.nombre carrera, ti_planes_estudios.plan_estudio, 
       gnral_municipios.nombre_municipio, gnral_estados.nombre_estado, ti_redes_sociales.red_social,
       ti_tipos_donacion.tipo_donacion, ti_nacionalidad.nacionalidad from ti_reg_datos_alum, gnral_semestres, 
       ti_tipo_estudiante, gnral_carreras, ti_planes_estudios, gnral_municipios, gnral_estados, ti_redes_sociales,
      ti_tipos_donacion, ti_nacionalidad where ti_reg_datos_alum.id_semestre = gnral_semestres.id_semestre 
    and ti_reg_datos_alum.id_tipo_estudiante = ti_tipo_estudiante.id_tipo_estudiante and 
    ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and ti_planes_estudios.id_plan_estudio= ti_reg_datos_alum.id_plan_estudio
    and gnral_municipios.id_municipio = ti_reg_datos_alum.municipio_domicilio and gnral_municipios.id_estado = gnral_estados.id_estado 
    and ti_redes_sociales.id_red_social = ti_reg_datos_alum.id_red_social and ti_tipos_donacion.id_tipo_donacion = ti_reg_datos_alum.id_tipo_donacion 
    and ti_nacionalidad.id_nacionalidad = ti_reg_datos_alum.id_nacionalidad and ti_reg_datos_alum.id_alumno ='.$id_alumno.'');

        $libros=DB::select('SELECT * FROM `ti_titulos_libros` WHERE `id_reg_dato_alumno` = '.$datos_personales->id_reg_dato_alum.'');
        $equipos_computo=DB::select('SELECT *FROM ti_equipos_computo where id_reg_dato_alum = '.$datos_personales->id_reg_dato_alum.'');

        //JURDO DEL ESTUDIANTE
        $datos_jurado=DB::selectOne('SELECT ti_reg_datos_alum.mencion_honorifica honorifica,
       ti_reg_datos_alum.correo_electronico, ti_reg_datos_alum.telefono, 
       ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.id_carrera, gnral_carreras.nombre carrera,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_fecha_jurado_alumn.*,ti_sala.nombre_sala
from ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras,ti_sala where 
ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
        and gnral_carreras.id_carrera = ti_reg_datos_alum.id_carrera 
                    and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'
                    and ti_sala.id_sala=ti_fecha_jurado_alumn.id_sala');

        $dato_presidente=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 1 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
        $dato_secretario=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 2 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
        $dato_vocal=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
        $dato_suplente=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 4 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');

        $hora=DB::selectOne('SELECT *from ti_horarios_dias where id_horarios_dias='.$datos_jurado->id_horarios_dias.'');
        $datos_reg_dep=DB::selectOne('SELECT ti_datos_alumno_reg_dep.*, ti_clave_carrera.clave,
       ti_nacionalidad.nacionalidad, ti_genero.genero, ti_sexo.sexo, ti_preparatatoria.preparatoria,   ti_entidades_federativas.nom_entidad,
       ti_numeros_titulos.abreviatura_folio_titulo, ti_tipo_titulo_obtenido.tipo_titulo, ti_decisiones_jurado.decision,
       ti_fundamento_legal_s_s.fundamento_legal, ti_autorizacion_reconocimiento.autorizacion_reconocimiento,
       ti_reg_datos_alum.fecha_ingreso_preparatoria,ti_reg_datos_alum.fecha_egreso_preparatoria,
        ti_reg_datos_alum.fecha_ingreso_tesvb,ti_reg_datos_alum.fecha_egreso_tesvb,ti_reg_datos_alum.id_nacionalidad,
ti_descuentos_alum.id_preparatoria,ti_reg_datos_alum.mencion_honorifica

FROM ti_datos_alumno_reg_dep,ti_clave_carrera, ti_nacionalidad, ti_genero, ti_sexo,ti_preparatatoria,ti_entidades_federativas, 
     ti_tipo_titulo_obtenido, ti_numeros_titulos,ti_autorizacion_reconocimiento, ti_fundamento_legal_s_s, ti_reg_datos_alum,ti_decisiones_jurado,ti_descuentos_alum
     WHERE ti_reg_datos_alum.id_carrera= ti_clave_carrera.id_carrera and  ti_reg_datos_alum.id_nacionalidad = ti_nacionalidad.id_nacionalidad and
ti_datos_alumno_reg_dep.id_genero = ti_genero.id_genero and ti_datos_alumno_reg_dep.id_sexo = ti_sexo.id_sexo 
and ti_descuentos_alum.id_preparatoria = ti_preparatatoria.id_preparatoria and
                ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa and 
                ti_datos_alumno_reg_dep.id_numero_titulo =ti_numeros_titulos.id_numero_titulo and
ti_datos_alumno_reg_dep.id_tipo_titulo = ti_tipo_titulo_obtenido.id_tipo_titulo and 
    ti_datos_alumno_reg_dep.id_decision = ti_decisiones_jurado.id_decision and 
    ti_fundamento_legal_s_s.id_fundamento_legal = ti_datos_alumno_reg_dep.id_fundamento_legal AND
    ti_reg_datos_alum.id_alumno=ti_datos_alumno_reg_dep.id_alumno and 
     ti_reg_datos_alum.id_alumno=ti_descuentos_alum.id_alumno  and 
    ti_autorizacion_reconocimiento.id_autorizacion_reconocimiento =ti_datos_alumno_reg_dep.id_autorizacion_reconocimiento
    and      ti_datos_alumno_reg_dep.id_alumno ='.$id_alumno.'');


        $estado_titulo= DB::selectOne('SELECT *FROM ti_datos_alumno_reg_dep where id_alumno ='.$id_alumno.'');


        $oficio_recursos=DB::selectOne('SELECT *FROM ti_oficio_recursos WHERE id_alumno = '.$id_alumno.'');


        $acta_titulacion= DB::selectOne('SELECT *from ti_acta_titulaciones WHERE id_alumno ='.$id_alumno.'');


        $datos_mencion_honorifica=DB::selectOne('SELECT * FROM `ti_mencion_honorifica` WHERE id_alumno = '.$id_alumno.'');


        return view('titulacion.jefe_titulacion.liberacion_titulacion.datos_titulado_liberado',
                    compact('registro1','preparatoria','documentacion_requisitos','estado_egel',
                        'certificado_ingles','datos_personales','libros','equipos_computo','datos_jurado','dato_presidente',
                    'dato_secretario','dato_vocal','dato_suplente','hora','datos_reg_dep','oficio_recursos',
                    'acta_titulacion','datos_mencion_honorifica','estado_titulo'));
    }
    public function exportar_alumnos_liberados(){

        Excel::create('Estudiantes titulados',function ($excel)
        {
            $alumnos=DB::select('SELECT ti_datos_alumno_reg_dep.id_alumno,ti_fecha_jurado_alumn.fecha_titulacion,ti_fecha_jurado_alumn.id_horarios_dias FROM ti_datos_alumno_reg_dep,ti_fecha_jurado_alumn WHERE ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno and ti_datos_alumno_reg_dep.id_liberado_titulado=1 ORDER by ti_fecha_jurado_alumn.fecha_titulacion asc, ti_fecha_jurado_alumn.id_horarios_dias asc');
            //dd($alumnos);
            $array_alumnos= array();
            $numero=0;
            foreach ($alumnos as $alumno){
                $registro1= DB::selectOne('SELECT ti_tipos_desc.tipo_desc,ti_descuentos_alum.*,
               ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.id_carrera,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.amaterno
               FROM ti_descuentos_alum, ti_tipos_desc,ti_reg_datos_alum WHERE ti_reg_datos_alum.id_alumno=ti_descuentos_alum.id_alumno 
               and ti_tipos_desc.id_tipo_desc=ti_descuentos_alum.id_tipo_desc and ti_reg_datos_alum.id_alumno='.$alumno->id_alumno.'');
                $numero++;
                $dat_alum['np']=$numero;
                $dat_alum['numero_cuenta']=$registro1->no_cuenta;
                $datos_personales=DB::selectOne('SELECT ti_reg_datos_alum.*, gnral_semestres.descripcion semestre,
       ti_tipo_estudiante.tipo_estudiante,gnral_carreras.nombre carrera, ti_planes_estudios.plan_estudio, 
       gnral_municipios.nombre_municipio, gnral_estados.nombre_estado, ti_redes_sociales.red_social,
       ti_tipos_donacion.tipo_donacion, ti_nacionalidad.nacionalidad from ti_reg_datos_alum, gnral_semestres, 
       ti_tipo_estudiante, gnral_carreras, ti_planes_estudios, gnral_municipios, gnral_estados, ti_redes_sociales,
      ti_tipos_donacion, ti_nacionalidad where ti_reg_datos_alum.id_semestre = gnral_semestres.id_semestre 
    and ti_reg_datos_alum.id_tipo_estudiante = ti_tipo_estudiante.id_tipo_estudiante and 
    ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and ti_planes_estudios.id_plan_estudio= ti_reg_datos_alum.id_plan_estudio
    and gnral_municipios.id_municipio = ti_reg_datos_alum.municipio_domicilio and gnral_municipios.id_estado = gnral_estados.id_estado 
    and ti_redes_sociales.id_red_social = ti_reg_datos_alum.id_red_social and ti_tipos_donacion.id_tipo_donacion = ti_reg_datos_alum.id_tipo_donacion 
    and ti_nacionalidad.id_nacionalidad = ti_reg_datos_alum.id_nacionalidad and ti_reg_datos_alum.id_alumno ='.$alumno->id_alumno.'');
                $dat_alum['tipo_estudiante']=$datos_personales->tipo_estudiante;
                $datos_reg_dep=DB::selectOne('SELECT ti_datos_alumno_reg_dep.*, ti_clave_carrera.clave,ti_clave_carrera.carrera_cedula,
       ti_nacionalidad.nacionalidad, ti_genero.genero, ti_sexo.sexo, ti_preparatatoria.preparatoria,   ti_entidades_federativas.nom_entidad,
       ti_numeros_titulos.abreviatura_folio_titulo, ti_tipo_titulo_obtenido.tipo_titulo, ti_decisiones_jurado.decision,
       ti_fundamento_legal_s_s.fundamento_legal, ti_autorizacion_reconocimiento.autorizacion_reconocimiento,
       ti_reg_datos_alum.fecha_ingreso_preparatoria,ti_reg_datos_alum.fecha_egreso_preparatoria,
        ti_reg_datos_alum.fecha_ingreso_tesvb,ti_reg_datos_alum.fecha_egreso_tesvb,ti_reg_datos_alum.id_nacionalidad,
ti_descuentos_alum.id_preparatoria,ti_reg_datos_alum.mencion_honorifica

FROM ti_datos_alumno_reg_dep,ti_clave_carrera, ti_nacionalidad, ti_genero, ti_sexo,ti_preparatatoria,ti_entidades_federativas, 
     ti_tipo_titulo_obtenido, ti_numeros_titulos,ti_autorizacion_reconocimiento, ti_fundamento_legal_s_s, ti_reg_datos_alum,ti_decisiones_jurado,ti_descuentos_alum
     WHERE ti_reg_datos_alum.id_carrera= ti_clave_carrera.id_carrera and  ti_reg_datos_alum.id_nacionalidad = ti_nacionalidad.id_nacionalidad and
ti_datos_alumno_reg_dep.id_genero = ti_genero.id_genero and ti_datos_alumno_reg_dep.id_sexo = ti_sexo.id_sexo 
and ti_descuentos_alum.id_preparatoria = ti_preparatatoria.id_preparatoria and
                ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa and 
                ti_datos_alumno_reg_dep.id_numero_titulo =ti_numeros_titulos.id_numero_titulo and
ti_datos_alumno_reg_dep.id_tipo_titulo = ti_tipo_titulo_obtenido.id_tipo_titulo and 
    ti_datos_alumno_reg_dep.id_decision = ti_decisiones_jurado.id_decision and 
    ti_fundamento_legal_s_s.id_fundamento_legal = ti_datos_alumno_reg_dep.id_fundamento_legal AND
    ti_reg_datos_alum.id_alumno=ti_datos_alumno_reg_dep.id_alumno and 
     ti_reg_datos_alum.id_alumno=ti_descuentos_alum.id_alumno  and 
    ti_autorizacion_reconocimiento.id_autorizacion_reconocimiento =ti_datos_alumno_reg_dep.id_autorizacion_reconocimiento
    and      ti_datos_alumno_reg_dep.id_alumno ='.$alumno->id_alumno.'');
                //dd($datos_reg_dep);

                $datos_jurado=DB::selectOne('SELECT ti_reg_datos_alum.mencion_honorifica honorifica,
       ti_reg_datos_alum.correo_electronico, ti_reg_datos_alum.telefono, 
       ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.id_carrera, gnral_carreras.nombre carrera,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_fecha_jurado_alumn.*,ti_sala.nombre_sala
from ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras,ti_sala where 
ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
        and gnral_carreras.id_carrera = ti_reg_datos_alum.id_carrera 
                    and ti_fecha_jurado_alumn.id_alumno='.$alumno->id_alumno.'
                    and ti_sala.id_sala=ti_fecha_jurado_alumn.id_sala');

                $acta_titulacion= DB::selectOne('SELECT *from ti_acta_titulaciones WHERE id_alumno ='.$alumno->id_alumno.'');

                $preparatoria=DB::selectOne('SELECT ti_preparatatoria.*,ti_tipo_estudio_antecedente.tipo_estudio_antecedente,
                   ti_tipo_estudio_antecedente.tipo_educativo_atecedente,ti_entidades_federativas.nom_entidad,
                   ti_entidades_federativas.clave_entidad from ti_preparatatoria,ti_tipo_estudio_antecedente,
                   ti_entidades_federativas WHERE ti_preparatatoria.id_entidad_federativa= ti_entidades_federativas.id_entidad_federativa 
                   and ti_tipo_estudio_antecedente.id_tipo_estudio_antecedente=ti_preparatatoria.id_tipo_estudio_antecedente and
                   ti_preparatatoria.id_preparatoria='.$registro1->id_preparatoria.'');
                $documentacion_requisitos=DB::selectOne('SELECT ti_requisitos_titulacion.*,
                   ti_opciones_titulacion.opcion_titulacion  FROM ti_requisitos_titulacion, ti_opciones_titulacion 
                   WHERE ti_requisitos_titulacion.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion 
                   and ti_requisitos_titulacion.id_alumno= '.$alumno->id_alumno.'');
                $dato_presidente=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$alumno->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 1 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
                $dato_secretario=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$alumno->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 2 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
                $dato_vocal=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$alumno->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
                $dato_suplente=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$alumno->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 4 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
                $oficio_recursos=DB::selectOne('SELECT *FROM ti_oficio_recursos WHERE id_alumno = '.$alumno->id_alumno.'');

                $dat_alum['clave_carrera']=$datos_reg_dep->clave;
                $dat_alum['carrera_cedula']=$datos_reg_dep->carrera_cedula;
                $dat_alum['carrera']=$datos_personales->carrera;

                $dat_alum['tipo_estudiante']=$datos_personales->tipo_estudiante;

                $dat_alum['nombre_egresado']=$registro1->nombre_al." ".$registro1->apaterno." ".$registro1->amaterno;
                $dat_alum['fecha_certificado']=$datos_personales->fecha_emision_certificado;
                $dat_alum['fecha_certificado']=$datos_personales->fecha_emision_certificado;
                $dat_alum['nombre_estudiante']=$registro1->nombre_al;
                $dat_alum['apaterno_estudiante']=$registro1->apaterno;
                $dat_alum['amaterno_estudiante']=$registro1->amaterno;
                $dat_alum['folio_titulo']= $datos_reg_dep->abreviatura_folio_titulo;
                $dat_alum['numer_foja_reg_titulo']= "0".$datos_reg_dep->numero_foja_titulo."FTE";
                $dat_alum['numer_libro_reg_titulo']= "0".$datos_reg_dep->numero_libro_titulo;
                $dat_alum['nacionalidad']=$datos_personales->nacionalidad;
                $dat_alum['genero']=$datos_reg_dep->genero;
                $dat_alum['sexo']=$datos_reg_dep->sexo;
                $dat_alum['fecha_titulacion']=$datos_jurado->fecha_titulacion;
                $dat_alum['hora_inicio']=$acta_titulacion->hora_conformidad_acta;
                $dat_alum['hora_termino']=$acta_titulacion->hora_levantamiento_acta;
                $dat_alum['titulo_obtenido']=$datos_reg_dep->tipo_titulo;
                $dat_alum['desicion_jurado']=$datos_reg_dep->decision;
                $dat_alum['curp']=$datos_personales->curp_al;
                $rfc= substr($datos_personales->curp_al, 0, 9);
                $dat_alum['rfc']=$rfc;
                $dat_alum['edad']=$datos_reg_dep->edad;
                $dat_alum['fecha_nacimiento']=$datos_reg_dep->fecha_nacimiento;
                $dat_alum['preparatoria']=$preparatoria->preparatoria;
                $fecha_inicio_prep=$datos_personales->fecha_ingreso_preparatoria;
                $fecha_inicio_prep= substr($fecha_inicio_prep, 0, 4);
                $fecha_final_prep=$datos_personales->fecha_egreso_preparatoria;
                $fecha_final_prep= substr($fecha_final_prep, 0, 4);
                $dat_alum['periodo_prepa']=$fecha_inicio_prep."-".$fecha_final_prep;
                $dat_alum['entidad_federativa_prepa']=$preparatoria->nom_entidad;
                $dat_alum['nombre_tec']="Tecnológico de Estudios Superiores de Valle de Bravo";
                $periodo_inicio_tesvb=$datos_personales->fecha_ingreso_tesvb;
                $periodo_inicio_tesvb= substr($periodo_inicio_tesvb, 0, 4);
                $periodo_final_tesvb=$datos_personales->fecha_egreso_tesvb;
                $periodo_final_tesvb= substr($periodo_final_tesvb, 0, 4);
                $dat_alum['periodo_tesvb']=$periodo_inicio_tesvb."-".$periodo_final_tesvb;
                $dat_alum['inicio_carrera']=$datos_personales->fecha_ingreso_tesvb;
                $dat_alum['final_carrera']=$datos_personales->fecha_egreso_tesvb;
                $dat_alum['entidad_tec']="México";
                if($documentacion_requisitos->id_opcion_titulacion == 1) {
                    $opcion = "I. Informe de residencia";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 2) {
                    $opcion = "II. Proyecto de Innovación";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 3) {
                    $opcion = "III. Proyecto de investigación";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 4) {
                    $opcion = "IV. Informe de Estancia";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 5) {
                    $opcion = "V. Tesis";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 6) {
                    $opcion = "VI. Tesina";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 7) {
                    $opcion = "VII. Otros : Ceneval";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 8) {
                    $opcion = "VII. Otros : Examen por área del conocimiento";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 9) {
                    $opcion = "VII. Otros : Experiencia Profesional";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 10) {
                    $opcion = "VII. Otros : Incubación de negocio";
                }
                elseif($documentacion_requisitos->id_opcion_titulacion == 11) {
                    $opcion = "VII. Otros : Modalidad dual";
                }
                else{

                }


                $dat_alum['opcion_titulacion']=$opcion;
                $dat_alum['tipo_titulacion']="Titulación Integral";
                $dat_alum['director']=$datos_personales->nombre_director_general;
                $dat_alum['servicios_escolares']=$datos_personales->nombre_subdirector_servicios;
                $dat_alum['jefe_titulacion']=$datos_personales->nombre_jefe_titulacion;
                $dat_alum['presidente']=$dato_presidente->nombre;
                $dat_alum['cedula_presidente']=$dato_presidente->cedula;
                $dat_alum['secretario']=$dato_secretario->nombre;
                $dat_alum['cedula_secretario']=$dato_secretario->cedula;
                $dat_alum['vocal']=$dato_vocal->nombre;
                $dat_alum['cedula_vocal']=$dato_vocal->cedula;
                $dat_alum['numero_acta']=$acta_titulacion->numero_acta_titulacion;
                $dat_alum['foja_libro_acta']=$acta_titulacion->foja_acta_titulacion;
                $dat_alum['libro_acta']=$acta_titulacion->numero_libro_acta_titulacion;
                $dat_alum['fecha_solicitud_recurso']=$oficio_recursos->fecha_oficio_recursos;

                $year_fecha=substr($datos_jurado->fecha_titulacion, 6, 10);

                $dat_alum['numero_oficio']=$oficio_recursos->numero_oficio_recursos."/".$year_fecha;
                $dat_alum['nombre_jefe_division']=$datos_personales->nombre_jefe_division;

                array_push($array_alumnos,$dat_alum);

            }


                $i=1;
                $excel->sheet("estudiantes", function($sheet) use($array_alumnos,$i)
                {

                    $sheet->row(1, [
                        'N. P.','NUMERO DE CUENTA', 'REGULAR O REVALIDACIÓN', 'CVE_CARRERA','CARRERA_CEDULA', 'CARRERA',
                        'NOMBRE DEL EGRESADO TITULADO','FECHA DE EMISIÓN DE CRETIFICADO','NOMBRE(S)','APAT','A_MAT',
                        'FOLIO DEL TÍTULO','foja_Registro_titulo','libroReg_titulos','NACIONALIDAD',
                        'GENERO','SEXO','FECHA TIT','HORA INICIO TIT','HORA TERMINO TIT','TÍTULO OBTENIDO',
                        'decisión del jurado','CURP','RFC','EDAD','FECHA DE NACIMIENTO','NOMBRE DE LA PREPARATORIA','PERIODO',
                        'ENTIDAD FEDERATIVA','ESTUDIOS PROFESIONALES','PERIODO (GENERACIÓN)','INICIO DE CARRERA','FIN DE CARRERA','ENTIDAD FEDERATIVA2',
                        'OPCION DE TITULACIÓN','REGLAMENTO','DIRECTOR','SUBDIRECTOR DE SERVICIOS ESCOLARES','JEFE DE TITULACIÓN','PRESIDENTE','CÉDULA PRESIDENTE',
                        'SECRETARIO','CÉDULA SEC','VOCAL','CÉDULA VOC','ACTA','LIBRO ACTA','FOJA LIBRO',
                        'fecha Solicitud recursos','oficio Recursos','JEFE DE DIVISION'
                    ]);
                    foreach ($array_alumnos as $alumno)
                    {

                            $i++;
                            $sheet->row($i, [
                                $alumno['np'], $alumno['numero_cuenta'],$alumno['tipo_estudiante'],$alumno['clave_carrera'],$alumno['carrera_cedula'],$alumno['carrera'],
                                $alumno['nombre_egresado'],$alumno['fecha_certificado'],$alumno['nombre_estudiante'],$alumno['apaterno_estudiante'],$alumno['amaterno_estudiante'],
                                $alumno['folio_titulo'], $alumno['numer_foja_reg_titulo'],$alumno['numer_libro_reg_titulo'],$alumno['nacionalidad'],
                                $alumno['genero'],$alumno['sexo'],$alumno['fecha_titulacion'],$alumno['hora_inicio'],$alumno['hora_termino'],$alumno['titulo_obtenido'],
                                $alumno['desicion_jurado'],$alumno['curp'],$alumno['rfc'],$alumno['edad'],$alumno['fecha_nacimiento'],$alumno['preparatoria'],$alumno['periodo_prepa'],
                                $alumno['entidad_federativa_prepa'],$alumno['nombre_tec'],$alumno['periodo_tesvb'],$alumno['inicio_carrera'],$alumno['final_carrera'], $alumno['entidad_tec'],
                                $alumno['opcion_titulacion'],$alumno['tipo_titulacion'],$alumno['director'],$alumno['servicios_escolares'],$alumno['jefe_titulacion'],$alumno['presidente'],$alumno['cedula_presidente'],
                                $alumno['secretario'], $alumno['cedula_secretario'],$alumno['vocal'], $alumno['cedula_vocal'],$alumno['numero_acta'],$alumno['libro_acta'],$alumno['foja_libro_acta'],
                                $alumno['fecha_solicitud_recurso'],$alumno['numero_oficio'],$alumno['nombre_jefe_division'],
                                ]);





                    }
                });

        })->export('xlsx');

    }
}
