<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exp_asigna_expediente extends Model
{
    protected $table ="exp_asigna_expediente";
    protected $primaryKey="id_asigna_expediente";
    public $timestamps = false;
    protected $fillable=["id_alumno", "id_exp_general","id_exp_antecedentes_academicos","id_exp_datos_familiares",
        "id_exp_habitos_estudio","id_exp_formacion_integral","id_exp_area_psicopedagogica"];

    public static function getExpediente($id)
    {
        $sql="SELECT DISTINCT gnral_carreras.nombre as a,gnral_periodos.periodo,gnral_grupos.grupo,exp_generales.nombre,edad,sexo,fecha_nacimientos,
lugar_nacimientos,gnral_semestres.descripcion,exp_civil_estados.desc_ec,no_hijos,direccion,correo,tel_casa,cel,exp_opc_nivel_socio.desc_opc,
trabaja,ocupacion,horario,no_cuenta,beca,tipo_beca,estado,turno,poblacion,ant_inst,satisfaccion_c,materias_repeticion,tot_repe,materias_especial,
tot_espe,gen_espe, 

exp_bachillerato.desc_bachillerato,otros_estudios,anos_curso_bachillerato,ano_terminacion,escuela_procedente,promedio,materias_reprobadas,
otra_carrera_ini,institucion,semestres_cursados,interrupciones_estudios,razones_interrupcion,razon_descide_estudiar_tesvb,sabedel_perfil_profesional,
otras_opciones_vocales,cuales_otras_opciones_vocales,tegusta_carrera_elegida,porque_carrera_elegida,
suspension_estudios_bachillerato,razones_suspension_estudios,teestimula_familia,


nombre_padre,edad_padre,ocupacion_padre,lugar_residencia_padre,nombre_madre,edad_madre,ocupacion_madre,
lugar_residencia_madre,no_hermanos,lugar_ocupas,exp_opc_vives.desc_opc,no_personas,etnia_indigena,cual_etnia,
hablas_lengua_indigena,sostiene_economia_hogar,exp_familia_union.desc_union,nombre_tutor,exp_parentescos.desc_parentesco,

tiempo_empelado_estudiar,id_opc_intelectual,forma_estudio,tiempo_libre,asignatura_preferida,porque_asignatura,asignatura_dificil,
porque_asignatura_dificil,opinion_tu_mismo_estudiante,

practica_deporte,especifica_deporte,practica_artistica,especifica_artistica,pasatiempo,
actividades_culturales,cuales_act,estado_salud,enfermedad_cronica,especifica_enf_cron,enf_cron_padre,
especifica_enf_cron_padres,operacion,deque_operacion,enfer_visual,especifica_enf,usas_lentes,
medicamento_controlado,especifica_medicamento,estatura,peso,accidente_grave,relata_breve,exp_escalas.desc_escala,
        
rendimiento_escolar,dominio_idioma,otro_idioma,conocimiento_compu,aptitud_especial,
comprension,preparacion,estrategias_aprendizaje,organizacion_actividades,concentracion,solucion_problemas,
condiciones_ambientales,busqueda_bibliografica,trabajo_equipo        

from exp_generales, gnral_carreras, gnral_periodos, gnral_grupos, gnral_semestres, exp_civil_estados, exp_opc_nivel_socio,exp_antecedentes_academicos, 
exp_bachillerato, exp_datos_familiares, exp_opc_vives, exp_familia_union, exp_parentescos, exp_habitos_estudio,exp_formacion_integral, exp_escalas, exp_area_psicopedagogica, exp_asigna_expediente

where id_alumno=".$id."
and exp_generales.id_carrera=gnral_carreras.id_carrera 
and exp_generales.id_periodo=gnral_periodos.id_periodo 
and exp_generales.id_grupo=gnral_grupos.id_grupo and exp_generales.id_semestre=gnral_semestres.id_semestre 
and exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil 
and exp_generales.id_nivel_economico=exp_opc_nivel_socio.id_nivel_economico
GROUP by id_alumno
and exp_antecedentes_academicos.id_bachillerato=exp_bachillerato.id_bachillerato 
and exp_datos_familiares.id_opc_vives=exp_opc_vives.id_opc_vives 
and exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union 
and exp_datos_familiares.id_parentesco=exp_parentescos.id_parentesco 
and exp_formacion_integral.id_escala=exp_escalas.id_escala";
        return DB::select($sql);
    }

    public function exp_generales (){
        return $this->hasMany('App\Tutorias_Exp_generale','id_exp_general','id_exp_general');


    }
    public function exp_antecedentes_academicos (){
        return $this->hasMany('App\Tutorias_Exp_antecedentes_academico',
            'id_exp_antecedentes_academicos','id_exp_antecedentes_academicos');


    }
    public function exp_datos_familiares (){
        return $this->hasMany('App\Tutorias_Exp_datos_familiare',
            'id_exp_datos_familiares','id_exp_datos_familiares');


    }
    public function exp_habitos_estudio (){
        return $this->hasMany('App\Tutorias_Exp_habitos_estudio',
            'id_exp_habitos_estudio','id_exp_habitos_estudio');


    }
    public function exp_formacion_integral (){
        return $this->hasMany('App\Tutorias_Exp_formacion_integral',
            'id_exp_formacion_integral','id_exp_formacion_integral');


    }
    public function exp_area_psicopedagogica(){
        return $this->hasMany('App\Tutorias_Exp_area_psicopedagogica',
            'id_exp_area_psicopedagogica','id_exp_area_psicopedagogica');


    }


}

