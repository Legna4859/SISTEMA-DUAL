<?php

namespace App\Http\Controllers;

use App\calBitacoraEvaluaciones;
use App\CalBitacoraEvaluacionesSumativas;
use App\calEvaluaciones;
use App\calperiodosSumativas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Gnral_Personales;
use App\Gnral_Cargos;
use App\Gnral_Perfiles;
use App\Hrs_Situaciones;
use App\Abreviaciones;
use App\Abreviaciones_prof;
use App\calPeriodos;
use Session;

class SEscolaresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('servicios_escolares.index');
    }
    public function bitacoraPeriodos()
    {
        $bt_periodos=DB::select('SELECT cal_bitacora_periodos.docente,cal_bitacora_periodos.id_grupo,cal_bitacora_periodos.fecha_antigua,cal_bitacora_periodos.fecha_nueva,cal_bitacora_periodos.observaciones,cal_unidades.abreviacion unidad,
                                  gnral_materias.nombre materia, gnral_materias.id_semestre semestre,cal_bitacora_periodos.created_at, gnral_carreras.nombre as carrera
                                  FROM cal_bitacora_periodos, cal_unidades,gnral_materias,gnral_reticulas,gnral_carreras
                                  WHERE cal_bitacora_periodos.id_unidad=cal_unidades.id_unidad
                                  and id_periodo='.Session::get('periodo_actual').'
                                  and cal_bitacora_periodos.id_materia=gnral_materias.id_materia  
                                  and gnral_materias.id_reticula=gnral_reticulas.id_reticula 
                                  and gnral_reticulas.id_carrera=gnral_carreras.id_carrera');
        return view("servicios_escolares.bitacora_periodos")->with(['array_periodos' => $bt_periodos]);
    }
    public function bitacoraEvaluaciones()
    {
        $bt_evaluaciones=DB::select('SELECT cal_bitacora_evaluaciones.docente,cal_bitacora_evaluaciones.cal_antigua,cal_bitacora_evaluaciones.cal_nueva,cal_unidades.abreviacion unidad,gnral_materias.nombre materia, gnral_materias.id_semestre semestre
																FROM cal_bitacora_evaluaciones, cal_unidades,gnral_materias
																WHERE cal_bitacora_evaluaciones.id_unidad=cal_unidades.id_unidad
																and id_periodo='.Session::get('periodo_actual').'
																and cal_bitacora_evaluaciones.id_materia=gnral_materias.id_materia');
        return view("servicios_escolares.bitacora_calificaciones")->with(['array_evaluaciones' => $bt_evaluaciones]);
    }
    public function bitacoraEvaluaciones_sumativas()
    {
        $bt_evaluaciones=DB::select('SELECT cal_bitacoras_sumativas.docente,cal_bitacoras_sumativas.cal_antigua,cal_bitacoras_sumativas.cal_nueva,
cal_unidades.abreviacion unidad,gnral_materias.nombre materia, gnral_materias.id_semestre semestre
																FROM cal_bitacoras_sumativas, cal_unidades,gnral_materias
																WHERE cal_bitacoras_sumativas.id_unidad=cal_unidades.id_unidad
																and id_periodo='.Session::get('periodo_actual').'
																and cal_bitacoras_sumativas.id_materia=gnral_materias.id_materia');
        return view("servicios_escolares.bitacora_sumativas")->with(['array_evaluaciones' => $bt_evaluaciones]);
    }
    public function carreras_calificaciones(){
        $fsum_inicio="";
        $fsum_fin="";
        $id_periodo_sum=0;
        $periodo=Session::get('periodo_actual');
        $periodo_sumativas=calperiodosSumativas::where("id_periodo" ,"=", $periodo)->get()->toArray();
        if ($periodo_sumativas == null )
        {
            $periodo_sumativas=0;
        }
        else
        {
            $fsum_inicio=$periodo_sumativas[0]['fecha_inicio'];
            $fsum_fin=$periodo_sumativas[0]['fecha_fin'];
            $id_periodo_sum=$periodo_sumativas[0]['id_periodo_sum'];
            $periodo_sumativas=1;
        }
        $carreras=DB::select('select gnral_carreras.nombre carrera,gnral_carreras.id_carrera,gnral_carreras.color
                      from gnral_carreras where id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera');
        // dd($carreras);
        return view('servicios_escolares.carreras_calificaciones',compact('carreras','periodo_sumativas','fsum_inicio','fsum_fin','id_periodo_sum'));
    }
    public function evaluaciones($id_carrera)
    {
        $fsum_inicio="";
        $fsum_fin="";
        $id_periodo_sum=0;
        $periodo=Session::get('periodo_actual');
        $periodo_sumativas=calperiodosSumativas::where("id_periodo" ,"=", $periodo)->get()->toArray();
        if ($periodo_sumativas == null )
        {
            $periodo_sumativas=0;
        }
        else
        {
            $fsum_inicio=$periodo_sumativas[0]['fecha_inicio'];
            $fsum_fin=$periodo_sumativas[0]['fecha_fin'];
            $id_periodo_sum=$periodo_sumativas[0]['id_periodo_sum'];
            $periodo_sumativas=1;
        }
        //dd($periodo_sumativas);
        $carreras=DB::select('select gnral_carreras.nombre carrera,gnral_carreras.id_carrera,gnral_carreras.color
                      from gnral_carreras where id_carrera='.$id_carrera.'');

        $datos=array();
        foreach ($carreras as $carrera)
        {
            $dat_carreras['nombre_carrera']=$carrera->carrera;
            $dat_carreras['id_carrera']=$carrera->id_carrera;
            $dat_carreras['color']=$carrera->color;
            $docentes=DB::select('select DISTINCT(gnral_personales.nombre),gnral_personales.id_personal
                                from gnral_personales, gnral_horarios,gnral_periodos,gnral_periodo_carreras,gnral_carreras
                                where gnral_periodos.id_periodo='.$periodo.'
                                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_horarios.id_personal=gnral_personales.id_personal
                                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera ORDER BY gnral_carreras.id_carrera');
            $array_docentes=array();
            foreach ($docentes as $docente)
            {
                $dat_docente['id_personal']=$docente->id_personal;
                $dat_docente['nombre']=$docente->nombre;
                $materias=DB::select('select  DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.id_materia,gnral_materias.nombre mat, gnral_semestres.id_semestre idsem,gnral_carreras.nombre,gnral_carreras.id_carrera,gnral_semestres.descripcion semestre,
                CONCAT(gnral_semestres.id_semestre,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                and gnral_horarios.id_personal='.$docente->id_personal.'
                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                and gnral_horarios.id_personal=gnral_personales.id_personal
             /*   and gnral_materias.id_materia=eva_carga_academica.id_materia*/
                and gnral_materias.id_semestre=gnral_semestres.id_semestre GROUP BY gnral_materias.id_materia');
                $array_materias=array();
                $cont=0;
                foreach ($materias as $materia)
                {
                    $cont++;
                    $dat_materias['id_materia']=$materia->id_materia;
                    $dat_materias['nombre_materia']=$materia->mat;
                    $dat_materias['id_semestre']=$materia->idsem;
                    $dat_materias['nombre_semestre']=$materia->semestre;
                    $dat_materias['contador']=$cont;
                    $dat_materias['idcarrera']=$materia->id_carrera;
                    $grupos=DB::select('select gnral_horas_profesores.grupo id_grupo,CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                        from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                        where gnral_periodos.id_periodo='.$periodo.'
                        and gnral_materias.id_materia='.$materia->id_materia.'
                        and gnral_horarios.id_personal='.$docente->id_personal.'
                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                        and gnral_horarios.id_personal=gnral_personales.id_personal
                        and gnral_materias.id_semestre=gnral_semestres.id_semestre ORDER BY grupo');
                    $array_grupos=array();
                    foreach ($grupos as $grupo)
                    {
                        $dat_grupos['id_grupo']=$grupo->id_grupo;
                        $dat_grupos['grupos']=$grupo->grupo;
                        array_push($array_grupos,$dat_grupos);
                    }
                    $dat_materias['grupos']=$array_grupos;
                    array_push($array_materias,$dat_materias);
                }
                $dat_docente['materias']=$array_materias;
                array_push($array_docentes,$dat_docente);
            }
            $dat_carreras['docentes']=$array_docentes;
            array_push($datos, $dat_carreras);
            //dd($datos);
        }
        //dd($datos);
        return view('servicios_escolares.evaluaciones',compact('periodo_sumativas','fsum_inicio','fsum_fin','id_periodo_sum'))->with(['carreras'=>$datos]);
    }
    public function estadisticas()
    {

        return view('servicios_escolares.estadisticas');

        // return view('servicios_escolares.estadisticas')->with(['carreras'=>$array_carreras, 'municipios'=>$array_mpios,'edades'=>$array_edad]);
    }
    public function estadisticas_genero(){
        $periodo=Session::get('periodo_actual');

        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15  ORDER BY id_carrera ');
        $semestres=DB::select('SELECT * FROM gnral_semestres');
        $array_carreras=array();
        foreach ($carreras as $carrera)
        {
            $tot_masc=0; $tot_fem=0;
            $dat_carreras['id_carrera']=$carrera->id_carrera;
            $dat_carreras['nom_carrera']=$carrera->nombre;
            $dat_carreras['siglas']=$carrera->siglas;
            $array_semestres=array();
            $total_gral=0;
            foreach ($semestres as $semestre)
            {
                $dat_semestres['id_semestre']=$semestre->id_semestre;
                $dat_semestres['nom_semestre']=$semestre->descripcion;
                $datos_inscritos=DB::select("SELECT * FROM (SELECT COUNT(gnral_alumnos.id_alumno)Masculino FROM 
                                    gnral_alumnos,eva_validacion_de_cargas WHERE
                                      gnral_alumnos.id_carrera=$carrera->id_carrera AND
                                      gnral_alumnos.id_semestre=$semestre->id_semestre AND
                                      eva_validacion_de_cargas.id_periodo=$periodo AND
                                      eva_validacion_de_cargas.estado_validacion IN (2,8,9) and 
               eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                                      gnral_alumnos.genero='M') t1,
                                  (SELECT COUNT(gnral_alumnos.id_alumno)Femenino FROM
                                      gnral_alumnos,eva_validacion_de_cargas WHERE
                                      gnral_alumnos.id_carrera=$carrera->id_carrera AND
                                      gnral_alumnos.id_semestre=$semestre->id_semestre AND
                                      eva_validacion_de_cargas.id_periodo=$periodo AND
                                      eva_validacion_de_cargas.estado_validacion IN (2,8,9) and 
                                     eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                                      gnral_alumnos.genero='F') t2");
                $array_datos=array();
                foreach ($datos_inscritos as $dato)
                {
                    $dat_alumno['masculino']=$dato->Masculino;
                    $dat_alumno['femenino']=$dato->Femenino;
                    $tot_masc+=($dato->Masculino);
                    $tot_fem+=($dato->Femenino);
                    $dat_alumno['total']=($dato->Masculino)+($dato->Femenino);
                    $total_gral= $total_gral+($dato->Masculino)+($dato->Femenino);
                    array_push($array_datos, $dat_alumno);
                }
                $dat_semestres['datos']=$array_datos;
                array_push($array_semestres,$dat_semestres);
            }
            $dat_carreras['tot_gral']=$total_gral;
            $dat_carreras['tot_masculino']=$tot_masc;
            $dat_carreras['tot_femenino']=$tot_fem;
            $dat_carreras['semestres']=$array_semestres;
            array_push($array_carreras,$dat_carreras);
        }
        return view('servicios_escolares.partials.alumnos')->with(['carreras'=>$array_carreras]);

    }
    public function estadisticas_edad(){
        $periodo=Session::get('periodo_actual');
        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
        $semestres=DB::select('SELECT * FROM gnral_semestres');
        /*Numero de alumnos inscritos por carrera*/
        $array_carreras=array();
        $totg=0;
        foreach ($carreras as $carrera)
        {
            $tot_municipio=0;
            $tot_edades=0;
            $tot_masc=0; $tot_fem=0;
            $dat_carreras['id_carrera']=$carrera->id_carrera;
            $dat_carreras['nom_carrera']=$carrera->nombre;
            $datos_edades=DB::select('SELECT COUNT(gnral_alumnos.id_alumno) cantidad,edad
            FROM gnral_alumnos,eva_validacion_de_cargas WHERE  
                                      eva_validacion_de_cargas.estado_validacion IN (2,8,9) and 
               eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                eva_validacion_de_cargas.id_periodo='.$periodo.'  AND
            id_carrera='.$carrera->id_carrera.' AND edad!=\'\'GROUP BY edad');
            $array_edades=array();
            foreach ($datos_edades as $dato)
            {
                $dat_edades['edad']=$dato->edad;
                $dat_edades['cantidad']=$dato->cantidad;
                $tot_edades+=$dato->cantidad;
                array_push($array_edades,$dat_edades);
            }
            $datos_municipios=DB::select('SELECT COUNT(gnral_alumnos.id_municipio) cantidad,gnral_municipios.nombre_municipio municipio
            FROM gnral_alumnos,gnral_municipios,eva_validacion_de_cargas  WHERE
           eva_validacion_de_cargas.estado_validacion IN (2,8,9) and 
               eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                eva_validacion_de_cargas.id_periodo='.$periodo.'  AND
            gnral_alumnos.id_municipio=gnral_municipios.id_municipio AND
            id_carrera='.$carrera->id_carrera.' GROUP BY gnral_municipios.id_municipio ORDER BY cantidad DESC');
            $array_municipios=array();
            foreach ($datos_municipios as $dato)
            {
                $dat_mpios['municipio']=$dato->municipio;
                $dat_mpios['cantidad']=$dato->cantidad;
                array_push($array_municipios,$dat_mpios);
                $tot_municipio+=$dato->cantidad;
            }
            $array_semestres=array();
            foreach ($semestres as $semestre)
            {
                $dat_semestres['id_semestre']=$semestre->id_semestre;
                $dat_semestres['nom_semestre']=$semestre->descripcion;

                $array_datos=array();

                $dat_semestres['datos']=$array_datos;
                array_push($array_semestres,$dat_semestres);
            }
            $dat_carreras['tot_masculino']=$tot_masc;
            $dat_carreras['tot_femenino']=$tot_fem;
            $dat_carreras['semestres']=$array_semestres;
            $dat_carreras['municipios']=$array_municipios;
            $dat_carreras['edades']=$array_edades;
            $dat_carreras['tot_municipio']=$tot_municipio;
            $dat_carreras['tot_edades']=$tot_edades;
            array_push($array_carreras,$dat_carreras);
            $totg+=$tot_municipio;
        }


        $edad_general=DB::select('SELECT COUNT(gnral_alumnos.id_alumno) cantidad,edad FROM gnral_alumnos, eva_validacion_de_cargas WHERE 
 eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and eva_validacion_de_cargas.id_periodo='.$periodo.' 
  and eva_validacion_de_cargas.estado_validacion IN (2,8,9) and   edad!=\'\'GROUP BY edad');
        $array_edad=array();
        foreach ($edad_general as $datoed)
        {
            $dat_edad['edad']=$datoed->edad;
            $dat_edad['cantidad']=$datoed->cantidad;
            $dat_edad['tot_edad']=$totg;
            array_push($array_edad,$dat_edad);
        }

        return view('servicios_escolares.partials.edad')->with(['edades'=>$array_edad,'carreras'=>$array_carreras]);

    }
    public function estadisticas_municipios()
    {
        $periodo=Session::get('periodo_actual');

        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
        $semestres=DB::select('SELECT * FROM gnral_semestres');
        /*Numero de alumnos inscritos por carrera*/
        $array_carreras=array();
        $totg=0;
        foreach ($carreras as $carrera)
        {
            $tot_municipio=0;
            $tot_edades=0;
            $tot_masc=0; $tot_fem=0;
            $dat_carreras['id_carrera']=$carrera->id_carrera;
            $dat_carreras['nom_carrera']=$carrera->nombre;

            $datos_municipios=DB::select('SELECT COUNT(gnral_alumnos.id_municipio) cantidad,gnral_municipios.nombre_municipio municipio
            FROM gnral_alumnos,gnral_municipios,eva_validacion_de_cargas  WHERE
           eva_validacion_de_cargas.estado_validacion IN (2,8,9) and 
               eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                eva_validacion_de_cargas.id_periodo='.$periodo.'  AND
            gnral_alumnos.id_municipio=gnral_municipios.id_municipio AND
            id_carrera='.$carrera->id_carrera.' GROUP BY gnral_municipios.id_municipio ORDER BY cantidad DESC');
            $array_municipios=array();
            foreach ($datos_municipios as $dato)
            {
                $dat_mpios['municipio']=$dato->municipio;
                $dat_mpios['cantidad']=$dato->cantidad;
                array_push($array_municipios,$dat_mpios);
                $tot_municipio+=$dato->cantidad;
            }
            $array_semestres=array();
            foreach ($semestres as $semestre)
            {
                $dat_semestres['id_semestre']=$semestre->id_semestre;
                $dat_semestres['nom_semestre']=$semestre->descripcion;
                $array_datos=array();


                array_push($array_semestres,$dat_semestres);
            }
            $dat_carreras['tot_masculino']=$tot_masc;
            $dat_carreras['tot_femenino']=$tot_fem;
            $dat_carreras['semestres']=$array_semestres;
            $dat_carreras['municipios']=$array_municipios;
            $dat_carreras['tot_municipio']=$tot_municipio;
            $dat_carreras['tot_edades']=$tot_edades;
            array_push($array_carreras,$dat_carreras);
            $totg+=$tot_municipio;
        }

        $mpios_general=DB::select('SELECT COUNT(gnral_alumnos.id_municipio) cantidad,gnral_municipios.nombre_municipio municipio FROM
 gnral_alumnos,gnral_municipios,eva_validacion_de_cargas WHERE gnral_alumnos.id_municipio=gnral_municipios.id_municipio
  and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and eva_validacion_de_cargas.id_periodo='.$periodo.' 
  and eva_validacion_de_cargas.estado_validacion in (2,8,9) 
GROUP BY gnral_municipios.id_municipio ORDER BY cantidad DESC  ');
        $array_mpios=array();
        foreach ($mpios_general as $datom)
        {
            $dat_mpio['municipio']=$datom->municipio;
            $dat_mpio['cantidad']=$datom->cantidad;
            $dat_mpio['total']=$totg;
            array_push($array_mpios,$dat_mpio);
        }

        return view('servicios_escolares.partials.municipio')->with(['carreras'=>$array_carreras,'municipios'=>$array_mpios]);

    }
    public function carreras_indice_reprobacion(){
        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
        //  dd($carreras);
        return view('servicios_escolares.indice_reprobacion_carreras',compact('carreras'));

    }
    public function estadisticas_indice_reprobacion($id_carrera){

        $periodo=Session::get('periodo_actual');

        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera='.$id_carrera.'');
        $semestres=DB::select('SELECT * FROM gnral_semestres');
        /*indices de reprobacion*/
        $array_ind_carreras=array();
        foreach ($carreras as $carrera)
        {
            $dat_ind_carreras['id_carrera']=$carrera->id_carrera;
            $dat_ind_carreras['nom_carrera']=$carrera->nombre;
            $array_ind_semestres=array();
            foreach ($semestres as $semestre)
            {
                $dat_ind_semestres['id_semestre']=$semestre->id_semestre;
                $dat_ind_semestres['nom_semestre']=$semestre->descripcion;
                $materias_ind=DB::select('select  DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.id_materia,gnral_materias.nombre mat, gnral_semestres.id_semestre idsem,gnral_carreras.nombre,gnral_carreras.id_carrera,gnral_semestres.descripcion semestre,
                gnral_horas_profesores.grupo grupo, gnral_personales.nombre nombrepro, gnral_personales.id_personal
                from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                and gnral_semestres.id_semestre='.$semestre->id_semestre.'
                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                and gnral_horarios.id_personal=gnral_personales.id_personal
                and gnral_materias.id_semestre=gnral_semestres.id_semestre ORDER BY gnral_materias.nombre');
//dd($materias_ind);
                //hasta aqui va bien
                $array_ind_materias=array();
                foreach ($materias_ind as $materia_ind)
                {
                    $dat_ind_materias['id_materia']=$materia_ind->id_materia;
                    $dat_ind_materias['mat']=$materia_ind->mat;
                    $dat_ind_materias['docente']=$materia_ind->nombrepro;
                    $dat_ind_materias['grupo']=$materia_ind->grupo;
                    $alumnos=DB::select('SELECT count(gnral_alumnos.id_alumno) totAlumnos
                            from gnral_alumnos,eva_carga_academica,gnral_periodos,gnral_materias,eva_validacion_de_cargas
                            where gnral_periodos.id_periodo='.$periodo.'
                            and gnral_materias.id_materia='.$materia_ind->id_materia.'
                            and eva_carga_academica.grupo='.$materia_ind->grupo.'
                          and gnral_alumnos.id_alumno=eva_carga_academica.id_alumno
                          and eva_carga_academica.id_materia=gnral_materias.id_materia
                          and eva_carga_academica.id_status_materia=1
                          and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                          and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                          and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                          and eva_validacion_de_cargas.estado_validacion in (2,9) ');
                    $alReprobados=DB::select('SELECT COUNT(*) AS reprobados FROM (select DISTINCT(cal_evaluaciones.id_carga_academica) porcentaje
                        from eva_carga_academica,cal_evaluaciones, gnral_materias,gnral_periodos,eva_validacion_de_cargas
                        where gnral_periodos.id_periodo='.$periodo.'
                        and gnral_materias.id_materia='.$materia_ind->id_materia.'
                        and eva_carga_academica.grupo='.$materia_ind->grupo.'
                        and cal_evaluaciones.calificacion<70
                        and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                        and eva_carga_academica.id_carga_academica=cal_evaluaciones.id_carga_academica
                        and eva_carga_academica.id_materia=gnral_materias.id_materia
                                     and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
                          and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo
                          and eva_validacion_de_cargas.estado_validacion in (2,9) 
                        GROUP BY id_evaluacion ORDER BY `id_evaluacion` ASC) as rep');

                    /*
                                        $alReprobados=DB::select('SELECT COUNT(*) AS reprobados FROM (select DISTINCT(cal_evaluaciones.id_carga_academica) porcentaje
                                            from eva_carga_academica,cal_evaluaciones, cal_periodos_califica,gnral_materias,gnral_materias_perfiles,gnral_horas_profesores, gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_personales
                                            where gnral_periodos.id_periodo='.$periodo.'
                                            and gnral_materias.id_materia='.$materia_ind->id_materia.'
                                            and gnral_horarios.id_personal='.$materia_ind->id_personal.'
                                            and gnral_horas_profesores.grupo='.$materia_ind->grupo.'
                                            and eva_carga_academica.grupo='.$materia_ind->grupo.'
                                            and cal_evaluaciones.calificacion<70
                                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                            and eva_carga_academica.id_carga_academica=cal_evaluaciones.id_carga_academica
                                            and eva_carga_academica.id_materia=gnral_materias.id_materia
                                            and cal_periodos_califica.id_periodos=gnral_periodos.id_periodo
                                            and gnral_materias.id_materia=cal_periodos_califica.id_materia
                                            and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                                            and gnral_horarios.id_personal=gnral_personales.id_personal GROUP BY id_evaluacion ORDER BY `id_evaluacion` ASC) as rep');
                                     */
                    $dat_ind_materias['matricula']=$alumnos[0]->totAlumnos;
                    $dat_ind_materias['reprobados']=$alReprobados[0]->reprobados;
                    $dat_ind_materias['ind_rep']=($alumnos[0]->totAlumnos!=0 && $alReprobados[0]->reprobados!=0 ? (round(($alReprobados[0]->reprobados*100)/$alumnos[0]->totAlumnos,2)) :'0');
                    $cargas_academicas=DB::select('SELECT eva_carga_academica.id_carga_academica
 from eva_carga_academica,eva_validacion_de_cargas WHERE 
 eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno and 
 eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo
  and eva_carga_academica.id_status_materia=1
 and eva_carga_academica.id_materia='.$materia_ind->id_materia.' and 
 eva_carga_academica.grupo='.$materia_ind->grupo.' and eva_carga_academica.id_periodo='.$periodo.' 
 and eva_validacion_de_cargas.estado_validacion in (2,9) ');
                    $suma=0;
                    $contar=0;
                    foreach ($cargas_academicas as $academica)
                    {
                        $suma_promedio=DB::selectOne('SELECT SUM(cal_evaluaciones.calificacion) suma 
FROM `cal_evaluaciones` WHERE `id_carga_academica` = '.$academica->id_carga_academica.'');
                        $contar_promedio=DB::selectOne('SELECT count(cal_evaluaciones.calificacion)contar 
FROM `cal_evaluaciones` WHERE `id_carga_academica` = '.$academica->id_carga_academica.'');
                        $suma+=$suma_promedio->suma;
                        $contar+=$contar_promedio->contar;
                    }
                    $suma=$suma;
                    $total=$contar;



                    /* $promedio_grupo=DB::select('SELECT SUM(calificacion) suma,COUNT(calificacion) total FROM (select cal_evaluaciones.calificacion
                         from eva_carga_academica,cal_evaluaciones, cal_periodos_califica,gnral_materias,gnral_materias_perfiles,gnral_horas_profesores, gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_personales
                         where gnral_periodos.id_periodo='.$periodo.'
                         and gnral_materias.id_materia='.$materia_ind->id_materia.'
                         and gnral_horarios.id_personal='.$materia_ind->id_personal.'
                         and gnral_horas_profesores.grupo='.$materia_ind->grupo.'
                         and eva_carga_academica.grupo='.$materia_ind->grupo.'
                         and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                         and eva_carga_academica.id_carga_academica=cal_evaluaciones.id_carga_academica
                         and eva_carga_academica.id_materia=gnral_materias.id_materia
                         and cal_periodos_califica.id_periodos=gnral_periodos.id_periodo
                         and gnral_materias.id_materia=cal_periodos_califica.id_materia
                         and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                         and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                         and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                         and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                         and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                         and gnral_horarios.id_personal=gnral_personales.id_personal GROUP BY id_evaluacion ORDER BY `id_evaluacion` ASC) as prom');*/
                    $dat_ind_materias['promedio']= ($suma!=0 && $total!=0) ? (round($suma/$total,2)) : '0';
                    array_push($array_ind_materias,$dat_ind_materias);
                }
                $dat_ind_semestres['materias']=$array_ind_materias;
                array_push($array_ind_semestres,$dat_ind_semestres);
            }
            $dat_ind_carreras['semestres']=$array_ind_semestres;
            array_push($array_ind_carreras,$dat_ind_carreras);
        }
        //dd($array_ind_carreras);

        //dd($array_mpios);
        return view('servicios_escolares.partials.ind_reprobacion')->with(['ind_rep'=>$array_ind_carreras]);


    }
    public function periodos_profesores($id_docente,$id_materia,$id_grupo,$id_carrera)
    {

        $periodo = Session::get('periodo_actual');
        $tot_unidades = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');
        $uni_asignadas = DB::select('SELECT * FROM cal_periodos_califica WHERE id_periodos = '.$periodo.' AND id_materia = '.$id_materia.' AND id_grupo = '.$id_grupo.'');
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $asignadas = DB::selectOne('select max(cal_periodos_califica.id_unidad)maxima  FROM cal_periodos_califica WHERE id_periodos = '.$periodo.' AND id_materia = '.$id_materia.' AND id_grupo = '.$id_grupo.'');

        $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
        $nom_docente = $nom_docente->{'nombre'};
        $array_periodos = array();
        foreach ($uni_asignadas as $asignada) {
            $array_alumnos['id_unidad'] = $asignada->id_unidad;
            $array_alumnos['fecha'] = $asignada->fecha;
            $array_alumnos['id_materia'] = $asignada->id_materia;
            $array_alumnos['evaluada'] = $asignada->evaluada;
            $array_alumnos['status'] = 1;
            array_push($array_periodos, $array_alumnos);

        }
        $ultima_unidad = $asignadas->maxima + 1;
        $total = $tot_unidades->unidades + 1;
        // dd($array_periodos);
        $array_peri = array();
        for ($i = $ultima_unidad; $i < $total; $i++) {
            $array_periodo['id_unidad'] = $i;
            $array_periodo['fecha'] = "";
            $array_periodo['id_materia'] = $id_materia;
            $array_periodo['evaluada'] = 0;
            $array_periodo['status'] = 3;


            array_push($array_peri, $array_periodo);
        }
        $array_perio = array_merge($array_periodos, $array_peri);
        $nom_carrera=$carrera->nombre;;
        $grupo=$tot_unidades->id_semestre.'0'.$id_grupo;






        return view('servicios_escolares.periodos',compact('grupo','nom_docente','nom_carrera','id_grupo','array_perio','tot_unidades','id_carrera'));
    }
    public function acciones($id_docente,$id_materia,$id_grupo,$id_carrera)
    {
        //dd($id_docente);
        $periodo = Session::get('periodo_actual');
        $mat = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');

        $grupo = $mat->id_semestre.'0'.$id_grupo ;
        $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
        $nom_docente = $nom_docente->{'nombre'};
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $nom_carrera=$carrera->nombre;
        //accion 1 = periodos
        //accion 2 = calificaciones

        $esc_alumno=false;
        $calificar_sumativa=DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = '.$id_materia.' AND `id_grupo` = '.$id_grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$periodo.'');
        $calificar_sumativa=$calificar_sumativa->sumativa;
        if($calificar_sumativa == 0) {

            $alumnos = DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo=' . $periodo . '
                and gnral_materias.id_materia=' . $id_materia . '
                and eva_carga_academica.grupo=' . $id_grupo . '
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');
//dd($alumnos);
            $array_alumnos = array();
            $num_alumnos = 0;
            $num_duales = 0;
            $numer_al = 0;
            $promed = 0;
            foreach ($alumnos as $alumno) {
                if ($alumno->estado_validacion != 10) {
                    $numer_al++;
                }
                if ($alumno->estado_validacion == 9) {
                    $num_duales++;
                }
                if ($alumno->estado_validacion == 10) {
                    $dat_alumnos["baja"] = 1;
                } else {
                    $dat_alumnos["baja"] = 0;
                }
                $sumativas = false;
                $esc_alumno = false;
                $num_alumnos++;
                $nom_materia = $alumno->materia;
                $clave_m = $alumno->clave;
                $unidades = $alumno->unidades;
                $dat_alumnos['np'] = $num_alumnos;
                $dat_alumnos['id_alumno'] = $alumno->id_alumno;
                $dat_alumnos['id_carga_academica'] = $alumno->id_carga_academica;
                $dat_alumnos['cuenta'] = $alumno->cuenta;
                $dat_alumnos['estado_validacion'] = $alumno->estado_validacion;
                $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                $array_calificaciones = array();
                $calificaciones = DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica=' . $alumno->id_carga_academica . '
                      ORDER BY cal_evaluaciones.id_unidad');
                $suma_unidades = 0;
                $calificaciones != null ? $numero_unidades = 0 : $numero_unidades = 1;
                $cont_unievaluadas = 0;
                foreach ($calificaciones as $calificacion) {
                    $bitacora_modificacion = DB::select('SELECT id_carga_academica FROM cal_bitacora_evaluaciones
                      WHERE id_evaluacion=' . $calificacion->id_evaluacion . '
                      GROUP BY cal_bitacora_evaluaciones.id_carga_academica');
                    $dat_calificaciones['id_evaluacion'] = $calificacion->id_evaluacion;
                    $dat_calificaciones['calificacion'] = $calificacion->calificacion;
                    $dat_calificaciones['modificado'] = $bitacora_modificacion != null ? '1' : '2';
                    $dat_calificaciones['id_unidad'] = $calificacion->id_unidad;
                    $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                    if ($calificacion->calificacion < 70) {
                        $esc_alumno = true;
                    }
                    if ($calificacion->esc == 1) {
                        $esc_alumno = true;
                        $esc_pormateria = true;
                    }
                    if ($calificacion->calificacion < 70) {
                        $sumativas = true;

                    }


                    $numero_unidades++;
                    $cont_unievaluadas++;
                    array_push($array_calificaciones, $dat_calificaciones);
                }
                if ($alumno->estado_validacion == 10) {
                    $esc_alumno = true;
                }
                $dat_alumnos['sumativa'] = $sumativas;
                $dat_alumnos['esc_alumno'] = $esc_alumno;
                $dat_alumnos["especial_bloq"] = $esc_alumno == 1 && $alumno->nombre_curso == "ESPECIAL" ? 1 : 0;
                if ($alumno->estado_validacion == 10) {
                    $dat_alumnos['promedio'] = 0;

                } else {
                    $prome = intval(round($suma_unidades / $numero_unidades) + 0);
                    if ($prome >= 70) {
                        $promed++;
                    }
                    $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);

                }
                $dat_alumnos['calificaciones'] = $array_calificaciones;
                $dat_alumnos['curso'] = $alumno->nombre_curso;
                //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
                array_push($array_alumnos, $dat_alumnos);
            }
            if ($promed > 0 and $numer_al > 0) {
                $imp_porcentaje = ($promed * 100) / $numer_al;
            } else {
                $imp_porcentaje = 0;
            }

            $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
            $array_porcentajes = array();
            $porcent = 0;

            for ($i = 1; $i <= $no_unidades[0]->unidades; $i++) {
                $contar_alumnos = 0;
                $aprobados = 0;

                foreach ($array_alumnos as $alumnoss) {
                    foreach ($alumnoss['calificaciones'] as $cal) {
                        if ($cal['id_unidad'] == $i) {
                            if ($cal['calificacion'] >= 70) {
                                $contar_alumnos++;
                                $aprobados++;

                            } else {
                                $contar_alumnos++;

                            }
                            $esta = true;
                            break;
                        } // esta es la que se me olvidaba
                    }


                }

                $dat_porcentajes['id_unidad'] = $i;
                $dat_porcentajes['contar'] = $contar_alumnos;
                if ($contar_alumnos > 0 and $aprobados > 0) {
                    $porcentaje = ($aprobados * 100) / $contar_alumnos;

                } else {
                    $porcentaje = 0;
                }
                $porcent += $porcentaje;
                $dat_porcentajes['porcentaje'] = $porcentaje;
                array_push($array_porcentajes, $dat_porcentajes);
            }
        }
        else{
            $alumnos=DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_materias.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');
//dd($alumnos);
            $array_alumnos=array();
            $num_alumnos=0;
            $num_duales=0;
            $numer_al=0;
            $promed=0;
            foreach ($alumnos as $alumno)
            {
                if($alumno->estado_validacion != 10)
                {
                    $numer_al++;
                }
                if($alumno->estado_validacion ==9)
                {
                    $num_duales++;
                }
                if($alumno->estado_validacion ==10)
                {
                    $dat_alumnos["baja"]=1;
                }
                else{
                    $dat_alumnos["baja"]=0;
                }
                $sumativas = false;
                $esc_alumno=false;
                $num_alumnos++;
                $nom_materia=$alumno->materia;
                $clave_m=$alumno->clave;
                $unidades=$alumno->unidades;
                $dat_alumnos['np']=$num_alumnos;
                $dat_alumnos['id_alumno']=$alumno->id_alumno;
                $dat_alumnos['id_carga_academica']=$alumno->id_carga_academica;
                $dat_alumnos['cuenta']=$alumno->cuenta;
                $dat_alumnos['estado_validacion']=$alumno->estado_validacion;
                $dat_alumnos['nombre']=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
                $array_calificaciones=array();
                $calificaciones=DB::select('SELECT * FROM cal_evaluaciones_sumativa
                      WHERE id_carga_academica='.$alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones_sumativa.id_unidad');
                $suma_unidades=0;
                $calificaciones!= null ? $numero_unidades=0 : $numero_unidades=1;
                $cont_unievaluadas=0;
                foreach ($calificaciones as $calificacion)
                {
                    $bitacora_modificacion=DB::select('SELECT id_carga_academica FROM cal_bitacora_evaluaciones
                      WHERE id_evaluacion='.$calificacion->id_evaluacion.'
                      GROUP BY cal_bitacora_evaluaciones.id_carga_academica');
                    $dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
                    $dat_calificaciones['calificacion']=$calificacion->calificacion;
                    $dat_calificaciones['modificado']=$bitacora_modificacion != null ? '1' : '2';
                    $dat_calificaciones['id_unidad']=$calificacion->id_unidad;
                    $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                    if ($calificacion->calificacion<70)
                    {
                        $esc_alumno=true;
                    }
                    if ($calificacion->esc==1)
                    {
                        $esc_alumno=true;
                        $esc_pormateria=true;
                    }
                    if ($calificacion->calificacion < 70) {
                        $sumativas = true;

                    }


                    $numero_unidades++;
                    $cont_unievaluadas++;
                    array_push($array_calificaciones,$dat_calificaciones);
                }
                if($alumno->estado_validacion ==10) {
                    $esc_alumno=true;
                }
                $dat_alumnos['sumativa'] = $sumativas;
                $dat_alumnos['esc_alumno']=$esc_alumno;
                $dat_alumnos["especial_bloq"]= $esc_alumno==1 && $alumno->nombre_curso=="ESPECIAL" ? 1: 0;
                if($alumno->estado_validacion ==10) {
                    $dat_alumnos['promedio']=0;

                }
                else{
                    $prome=intval(round($suma_unidades/$numero_unidades)+0);
                    if($prome >=70){
                        $promed++;
                    }
                    $dat_alumnos['promedio']=intval(round($suma_unidades/$numero_unidades)+0);

                }
                $dat_alumnos['calificaciones']=$array_calificaciones;
                $dat_alumnos['curso']=$alumno->nombre_curso;
                //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
                array_push($array_alumnos,$dat_alumnos);
            }
            if($promed >0 and $numer_al >0){
                $imp_porcentaje=($promed*100)/$numer_al;
            }else{
                $imp_porcentaje=0;
            }
            //dd($array_alumnos);
            $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
            $array_porcentajes=array();
            $porcent=0;

            for (   $i = 1 ; $i <= $no_unidades[0]->unidades ; $i++) {
                $contar_alumnos = 0;
                $aprobados=0;

                foreach ($array_alumnos as $alumnoss) {
                    foreach ($alumnoss['calificaciones'] as $cal) {
                        if ($cal['id_unidad'] == $i) {
                            if ($cal['calificacion'] >= 70) {
                                $contar_alumnos++;
                                $aprobados++;

                            } else {
                                $contar_alumnos++;

                            }
                            $esta = true;
                            break;
                        } // esta es la que se me olvidaba
                    }


                }

                $dat_porcentajes['id_unidad']=$i;
                $dat_porcentajes['contar']=$contar_alumnos;
                if($contar_alumnos >0 and $aprobados >0)
                {
                    $porcentaje=($aprobados*100)/$contar_alumnos;

                }
                else{
                    $porcentaje=0;
                }
                $porcent+=$porcentaje;
                $dat_porcentajes['porcentaje']=$porcentaje;
                array_push($array_porcentajes,$dat_porcentajes);
            }
        }
        //dd($array_porcentajes);
        return view('servicios_escolares.calificaciones',compact('calificar_sumativa','id_docente','id_grupo','id_materia','grupo','nom_docente','nom_carrera','nom_materia','clave_m','unidades','id_carrera','imp_porcentaje'))->with(['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes]);

    }
    public function generaPeriodo()
    {
        $periodo_eval = array(
            'fecha' => $_GET['fecha_nueva'],
            'id_unidad' => $_GET['id_unidad'],
            'id_periodos' => Session::get('periodo_actual'),
            'id_materia' => $_GET['id_materia'],
            'id_grupo' => $_GET['id_grupo'],);
        $generar_fecha=calPeriodos::create($periodo_eval);
        return $generar_fecha;
    }
    public function genperiodoSumativas()
    {
        $periodo_sumativa = array(
            'fecha_inicio' => $_GET['finicio'],
            'fecha_fin' => $_GET['ffin'],
            'id_periodo' => Session::get('periodo_actual'));
        $generar_periodo=calperiodosSumativas::create($periodo_sumativa);
        return $generar_periodo;
    }
    public function modperiodoSumativas($id_periodo_sum)
    {
        calperiodosSumativas::find($id_periodo_sum)->update(['fecha_inicio' => $_GET['finicio'], 'fecha_fin' => $_GET['ffin']]);
    }
    public function modificaCalificacion()
    {
        $datCalificacion=calEvaluaciones::find($_GET['id_evaluacion']);
        $bitacora= array(
            'id_evaluacion' => $datCalificacion->id_evaluacion,
            'id_unidad' => $datCalificacion->id_unidad,
            'id_carga_academica' => $datCalificacion->id_carga_academica,
            'id_materia' => $_GET['id_materia'],
            'docente' => $_GET['docente'],
            'cal_antigua' => $datCalificacion->calificacion,
            'cal_nueva' => $_GET['calificacion'],
            'id_periodo' => Session::get('periodo_actual')
        );
        $carga_academica=DB::selectOne('SELECT * FROM `eva_carga_academica` WHERE `id_carga_academica` = '.$datCalificacion->id_carga_academica.'');
        $calificar_sumativa=DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = '.$carga_academica->id_materia.' AND `id_grupo` = '.$carga_academica->grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$carga_academica->id_periodo.'');
        if($calificar_sumativa->sumativa == 0) {
            DB::table('cal_evaluaciones_sumativa')
                ->where('id_evaluacion',$datCalificacion->id_evaluacion)
                ->where('id_carga_academica',$datCalificacion->id_carga_academica)
                ->update(['calificacion' => $_GET['calificacion']]);
        }
        calEvaluaciones::find($_GET['id_evaluacion'])->update(['calificacion' => $_GET['calificacion']]);
        calBitacoraEvaluaciones::create($bitacora);
    }
    public function modificaCalificacionSumativa()
    {
        $datCalificacion=calEvaluaciones::find($_GET['id_evaluacion']);
        $bitacora= array(
            'id_evaluacion' => $datCalificacion->id_evaluacion,
            'id_unidad' => $datCalificacion->id_unidad,
            'id_carga_academica' => $datCalificacion->id_carga_academica,
            'id_materia' => $_GET['id_materia'],
            'docente' => $_GET['docente'],
            'cal_antigua' => $datCalificacion->calificacion,
            'cal_nueva' => $_GET['calificacion'],
            'id_periodo' => Session::get('periodo_actual')
        );

        calEvaluaciones::find($_GET['id_evaluacion'])->update(['calificacion' => $_GET['calificacion']]);
        CalBitacoraEvaluacionesSumativas::create($bitacora);
    }
    public function destroy($id)
    {
        //
    }
    public function evaluaciones_academicas()
    {
        //dd('hola');
        $fsum_inicio="";
        $fsum_fin="";
        $id_periodo_sum=0;
        $periodo=Session::get('periodo_actual');
        $periodo_sumativas=calperiodosSumativas::where("id_periodo" ,"=", $periodo)->get()->toArray();
        if ($periodo_sumativas == null )
        {
            $periodo_sumativas=0;
        }
        else
        {
            $fsum_inicio=$periodo_sumativas[0]['fecha_inicio'];
            $fsum_fin=$periodo_sumativas[0]['fecha_fin'];
            $id_periodo_sum=$periodo_sumativas[0]['id_periodo_sum'];
            $periodo_sumativas=1;
        }
        //dd($periodo_sumativas);
        $carreras=DB::select('select gnral_carreras.nombre carrera,gnral_carreras.id_carrera,gnral_carreras.color
                      from gnral_carreras where id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera');

        $datos=array();
        foreach ($carreras as $carrera)
        {
            $dat_carreras['nombre_carrera']=$carrera->carrera;
            $dat_carreras['id_carrera']=$carrera->id_carrera;
            $dat_carreras['color']=$carrera->color;
            $docentes=DB::select('select DISTINCT(gnral_personales.nombre),gnral_personales.id_personal
                                from gnral_personales, gnral_horarios,gnral_periodos,gnral_periodo_carreras,gnral_carreras
                                where gnral_periodos.id_periodo='.$periodo.'
                                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_horarios.id_personal=gnral_personales.id_personal
                                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera ORDER BY gnral_carreras.id_carrera');
            $array_docentes=array();
            foreach ($docentes as $docente)
            {
                $dat_docente['id_personal']=$docente->id_personal;
                $dat_docente['nombre']=$docente->nombre;
                $materias=DB::select('select  DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.id_materia,gnral_materias.nombre mat, gnral_semestres.id_semestre idsem,gnral_carreras.nombre,gnral_carreras.id_carrera,gnral_semestres.descripcion semestre,
                CONCAT(gnral_semestres.id_semestre,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                from gnral_materias,gnral_materias_perfiles,eva_carga_academica,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                and gnral_horarios.id_personal='.$docente->id_personal.'
                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                and gnral_horarios.id_personal=gnral_personales.id_personal
                and gnral_materias.id_materia=eva_carga_academica.id_materia
                and gnral_materias.id_semestre=gnral_semestres.id_semestre GROUP BY gnral_materias.id_materia');
                $array_materias=array();
                $cont=0;
                foreach ($materias as $materia)
                {
                    $cont++;
                    $dat_materias['id_materia']=$materia->id_materia;
                    $dat_materias['nombre_materia']=$materia->mat;
                    $dat_materias['id_semestre']=$materia->idsem;
                    $dat_materias['nombre_semestre']=$materia->semestre;
                    $dat_materias['contador']=$cont;
                    $dat_materias['idcarrera']=$materia->id_carrera;
                    $grupos=DB::select('select gnral_horas_profesores.grupo id_grupo,CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                        from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                        where gnral_periodos.id_periodo='.$periodo.'
                        and gnral_materias.id_materia='.$materia->id_materia.'
                        and gnral_horarios.id_personal='.$docente->id_personal.'
                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                        and gnral_horarios.id_personal=gnral_personales.id_personal
                        and gnral_materias.id_semestre=gnral_semestres.id_semestre ORDER BY grupo');
                    $array_grupos=array();
                    foreach ($grupos as $grupo)
                    {
                        $dat_grupos['id_grupo']=$grupo->id_grupo;
                        $dat_grupos['grupos']=$grupo->grupo;
                        array_push($array_grupos,$dat_grupos);
                    }
                    $dat_materias['grupos']=$array_grupos;
                    array_push($array_materias,$dat_materias);
                }
                $dat_docente['materias']=$array_materias;
                array_push($array_docentes,$dat_docente);
            }
            $dat_carreras['docentes']=$array_docentes;
            array_push($datos, $dat_carreras);
            //dd($datos);
        }
        //dd($datos);
        return view('servicios_escolares.evaluaciones_academico',compact('periodo_sumativas','fsum_inicio','fsum_fin','id_periodo_sum'))->with(['carreras'=>$datos]);
    }
    public function evaluaciones_cc_academicas()
    {
        //dd('hola');
        $fsum_inicio="";
        $fsum_fin="";
        $id_periodo_sum=0;
        $periodo=Session::get('periodo_actual');
        $periodo_sumativas=calperiodosSumativas::where("id_periodo" ,"=", $periodo)->get()->toArray();
        if ($periodo_sumativas == null )
        {
            $periodo_sumativas=0;
        }
        else
        {
            $fsum_inicio=$periodo_sumativas[0]['fecha_inicio'];
            $fsum_fin=$periodo_sumativas[0]['fecha_fin'];
            $id_periodo_sum=$periodo_sumativas[0]['id_periodo_sum'];
            $periodo_sumativas=1;
        }
        //dd($periodo_sumativas);
        $carreras=DB::select('select gnral_carreras.nombre carrera,gnral_carreras.id_carrera,gnral_carreras.color
                      from gnral_carreras where id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera');

        $datos=array();
        foreach ($carreras as $carrera)
        {
            $dat_carreras['nombre_carrera']=$carrera->carrera;
            $dat_carreras['id_carrera']=$carrera->id_carrera;
            $dat_carreras['color']=$carrera->color;
            $docentes=DB::select('select DISTINCT(gnral_personales.nombre),gnral_personales.id_personal
                                from gnral_personales, gnral_horarios,gnral_periodos,gnral_periodo_carreras,gnral_carreras
                                where gnral_periodos.id_periodo='.$periodo.'
                                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_horarios.id_personal=gnral_personales.id_personal
                                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera ORDER BY gnral_carreras.id_carrera');
            $array_docentes=array();
            foreach ($docentes as $docente)
            {
                $dat_docente['id_personal']=$docente->id_personal;
                $dat_docente['nombre']=$docente->nombre;
                $materias=DB::select('select  DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.id_materia,gnral_materias.nombre mat, gnral_semestres.id_semestre idsem,gnral_carreras.nombre,gnral_carreras.id_carrera,gnral_semestres.descripcion semestre,
                CONCAT(gnral_semestres.id_semestre,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                from gnral_materias,gnral_materias_perfiles,eva_carga_academica,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                and gnral_horarios.id_personal='.$docente->id_personal.'
                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                and gnral_horarios.id_personal=gnral_personales.id_personal
                and gnral_materias.id_materia=eva_carga_academica.id_materia
                and gnral_materias.id_semestre=gnral_semestres.id_semestre GROUP BY gnral_materias.id_materia');
                $array_materias=array();
                $cont=0;
                foreach ($materias as $materia)
                {
                    $cont++;
                    $dat_materias['id_materia']=$materia->id_materia;
                    $dat_materias['nombre_materia']=$materia->mat;
                    $dat_materias['id_semestre']=$materia->idsem;
                    $dat_materias['nombre_semestre']=$materia->semestre;
                    $dat_materias['contador']=$cont;
                    $dat_materias['idcarrera']=$materia->id_carrera;
                    $grupos=DB::select('select gnral_horas_profesores.grupo id_grupo,CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                        from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                        where gnral_periodos.id_periodo='.$periodo.'
                        and gnral_materias.id_materia='.$materia->id_materia.'
                        and gnral_horarios.id_personal='.$docente->id_personal.'
                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                        and gnral_horarios.id_personal=gnral_personales.id_personal
                        and gnral_materias.id_semestre=gnral_semestres.id_semestre ORDER BY grupo');
                    $array_grupos=array();
                    foreach ($grupos as $grupo)
                    {
                        $dat_grupos['id_grupo']=$grupo->id_grupo;
                        $dat_grupos['grupos']=$grupo->grupo;
                        array_push($array_grupos,$dat_grupos);
                    }
                    $dat_materias['grupos']=$array_grupos;
                    array_push($array_materias,$dat_materias);
                }
                $dat_docente['materias']=$array_materias;
                array_push($array_docentes,$dat_docente);
            }
            $dat_carreras['docentes']=$array_docentes;
            array_push($datos, $dat_carreras);
            //dd($datos);
        }
        //dd($datos);
        return view('servicios_escolares.evaluaciones_cc_academico',compact('periodo_sumativas','fsum_inicio','fsum_fin','id_periodo_sum'))->with(['carreras'=>$datos]);
    }
    public function acciones_academico($id_docente,$id_materia,$id_grupo)
    { dd($id_materia);
        $periodo = Session::get('periodo_actual');
        $mat = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');

        $grupo = $mat->id_semestre.'0'.$id_grupo ;
        $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
        $nom_docente = $nom_docente->{'nombre'};
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $nom_carrera=$carrera->nombre;
        //accion 1 = periodos
        //accion 2 = calificaciones

        $esc_alumno=false;
        /*
                $alumnos=DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,  eva_tipo_curso.nombre_curso
                        from gnral_alumnos,eva_carga_academica,gnral_materias,gnral_materias_perfiles,gnral_horas_profesores, gnral_horarios,gnral_periodo_carreras, gnral_periodos,eva_tipo_curso,gnral_personales,gnral_semestres,eva_validacion_de_cargas
                        where gnral_periodos.id_periodo='.$periodo.'
                        and gnral_materias.id_materia='.$id_materia.'
                        and gnral_horarios.id_personal='.$id_docente.'
                        and gnral_horas_profesores.grupo='.$id_grupo.'
                        and eva_carga_academica.grupo='.$id_grupo.'
                        and eva_carga_academica.id_status_materia=1
                        and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                        and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                        and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                        and gnral_materias_perfiles.id_personal=gnral_personales.id_personal
                        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                        and gnral_horarios.id_personal=gnral_personales.id_personal
                        and gnral_materias.id_materia=eva_carga_academica.id_materia
                        and gnral_materias.id_semestre=gnral_semestres.id_semestre
                          and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
                        and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and
                        eva_validacion_de_cargas.estado_validacion=2 and eva_validacion_de_cargas.id_periodo= gnral_periodos.id_periodo
                         ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');
        */
        $alumnos=DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_materias.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion=2 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');
        $array_alumnos=array();
        $num_alumnos=0;
        foreach ($alumnos as $alumno)
        {
            $esc_alumno=false;
            $num_alumnos++;
            $nom_materia=$alumno->materia;
            $clave_m=$alumno->clave;
            $unidades=$alumno->unidades;
            $dat_alumnos['np']=$num_alumnos;
            $dat_alumnos['id_alumno']=$alumno->id_alumno;
            $dat_alumnos['id_carga_academica']=$alumno->id_carga_academica;
            $dat_alumnos['cuenta']=$alumno->cuenta;
            $dat_alumnos['nombre']=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
            $array_calificaciones=array();
            $calificaciones=DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica='.$alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones.id_unidad');
            $suma_unidades=0;
            $calificaciones!= null ? $numero_unidades=0 : $numero_unidades=1;
            foreach ($calificaciones as $calificacion)
            {
                $bitacora_modificacion=DB::select('SELECT id_carga_academica FROM cal_bitacora_evaluaciones
                      WHERE id_evaluacion='.$calificacion->id_evaluacion.'
                      GROUP BY cal_bitacora_evaluaciones.id_carga_academica');
                $dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
                $dat_calificaciones['calificacion']=$calificacion->calificacion;
                $dat_calificaciones['modificado']=$bitacora_modificacion != null ? '1' : '2';
                $dat_calificaciones['id_unidad']=$calificacion->id_unidad;
                $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                if ($calificacion->calificacion<70 || $calificacion->esc==1)
                {
                    $esc_alumno=true;
                }
                $numero_unidades++;
                array_push($array_calificaciones,$dat_calificaciones);
            }
            $dat_alumnos['esc_alumno']=$esc_alumno;
            $dat_alumnos['promedio']=intval(round($suma_unidades/$numero_unidades)+0);
            $dat_alumnos['calificaciones']=$array_calificaciones;
            $dat_alumnos['curso']=$alumno->nombre_curso;
            //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
            array_push($array_alumnos,$dat_alumnos);
        }
        //dd($array_alumnos);
        $no_unidades=DB::select('SELECT * FROM `gnral_materias` WHERE `id_materia` = '.$id_materia.' ');
        /*  $no_unidades=DB::select('select gnral_materias.unidades
                  from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores, gnral_horarios,gnral_periodo_carreras, gnral_periodos,gnral_carreras,gnral_personales
                  where gnral_periodos.id_periodo='.$periodo.'
                  and gnral_materias.id_materia='.$id_materia.'
                  and gnral_horarios.id_personal='.$id_docente.'
                  and gnral_horas_profesores.grupo='.$id_grupo.'
                  and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                  and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                  and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                  and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                  and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                  and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                  and gnral_horarios.id_personal=gnral_personales.id_personal');*/
        $array_porcentajes=array();
        for (   $i = 0 ; $i < $no_unidades[0]->unidades ; $i++)
        {
            $porcentaje=DB::select('SELECT COUNT(*) AS porcentaje FROM (select COUNT(cal_evaluaciones.id_evaluacion) porcentaje,id_evaluacion
                from eva_carga_academica,cal_evaluaciones,gnral_periodos,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and eva_carga_academica.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and cal_evaluaciones.id_unidad='.($i+1).'
                and cal_evaluaciones.calificacion>=70
                and eva_carga_academica.id_carga_academica=cal_evaluaciones.id_carga_academica               
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                and eva_carga_academica.id_alumno=eva_validacion_de_cargas.id_alumno and 
                                    eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                                    and 
                                    eva_validacion_de_cargas.estado_validacion=2
                                    GROUP BY id_evaluacion ORDER BY `id_evaluacion` ASC) AS porcentaje');

            $dat_porcentajes['porcentaje']="".($porcentaje[0]->porcentaje!=null) ? round((($porcentaje[0]->porcentaje*100)/$num_alumnos), 2) : round(0 , 2);
            array_push($array_porcentajes,$dat_porcentajes);
            //dd($id_materia);
        }
        //dd($array_porcentajes);
        return view('servicios_escolares.calificaciones_academico',compact('id_materia','grupo','nom_docente','nom_carrera','nom_materia','clave_m','unidades'))->with(['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes]);

    }
    public function acciones_cc_academico($id_docente,$id_materia,$id_grupo)
    {

        $periodo =Session::get('periodotrabaja');
        $tot_unidades = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');
        $uni_asignadas = DB::select('SELECT * FROM cal_periodos_califica WHERE id_periodos = '.$periodo.' AND id_materia = '.$id_materia.' AND id_grupo = '.$id_grupo.'');
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $asignadas = DB::selectOne('select max(cal_periodos_califica.id_unidad)maxima  FROM cal_periodos_califica WHERE id_periodos = '.$periodo.' AND id_materia = '.$id_materia.' AND id_grupo = '.$id_grupo.'');


        $array_periodos = array();
        foreach ($uni_asignadas as $asignada) {
            $array_alumnos['id_unidad'] = $asignada->id_unidad;
            $array_alumnos['fecha'] = $asignada->fecha;
            $array_alumnos['id_materia'] = $asignada->id_materia;
            $array_alumnos['evaluada'] = $asignada->evaluada;
            $array_alumnos['status'] = 1;
            array_push($array_periodos, $array_alumnos);

        }
        $ultima_unidad = $asignadas->maxima + 1;
        $total = $tot_unidades->unidades + 1;
       // dd($array_periodos);
        $array_peri = array();
        for ($i = $ultima_unidad; $i < $total; $i++) {
            $calificar = $asignadas->maxima + 1;
            if ($i == $calificar) {
                $array_periodo['id_unidad'] = $i;
                $array_periodo['fecha'] = "";
                $array_periodo['id_materia'] = $id_materia;
                $array_periodo['evaluada'] = 2;
                $array_periodo['status'] = 2;

            } else {
                $array_periodo['id_unidad'] = $i;
                $array_periodo['fecha'] = "";
                $array_periodo['id_materia'] = $id_materia;
                $array_periodo['evaluada'] = 2;
                $array_periodo['status'] = 3;

            }
            array_push($array_peri, $array_periodo);
        }
        $array_perio = array_merge($array_periodos, $array_peri);
        $nom_carrera=$carrera->nombre;;
        $grupo=$tot_unidades->id_semestre.'0'.$id_grupo;
        return view('jefe_carrera.jefe_cc_periodos',compact('id_docente','id_materia','id_grupo','grupo','nom_carrera','id_grupo','array_perio','tot_unidades'));

    }
    public function acciones_sumativas($id_docente,$id_materia,$id_grupo,$id_carrera)
    {

        $periodo = Session::get('periodo_actual');
        $mat = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');

        $grupo = $mat->id_semestre.'0'.$id_grupo ;
        $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
        $nom_docente = $nom_docente->{'nombre'};
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $nom_carrera=$carrera->nombre;
        $calificar_sumativa=DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = '.$id_materia.' AND `id_grupo` = '.$id_grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$periodo.'');
        $calificar_sumativa=$calificar_sumativa->sumativa;
       if($calificar_sumativa == 0){
           $estado_sumativa=0;
           return view ('servicios_escolares.evaluaciones_sumativas',compact('estado_sumativa','nom_docente','nom_carrera','grupo','mat','id_carrera'));

       }else{
           $estado_sumativa=1;
           $alumnos=DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_materias.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');
//dd($alumnos);
           $array_alumnos=array();
           $num_alumnos=0;
           $numer_al=0;
           $promed=0;
           foreach ($alumnos as $alumno)
           {
               $sumativas = false;
               $esc_alumno=false;
               $num_alumnos++;
               $nom_materia=$alumno->materia;
               $clave_m=$alumno->clave;
               $unidades=$alumno->unidades;
               if($alumno->estado_validacion != 10)
               {
                   $numer_al++;
               }
               if($alumno->estado_validacion ==10)
               {
                   $dat_alumnos["baja"]=1;
               }
               else{
                   $dat_alumnos["baja"]=0;
               }
               $dat_alumnos['np']=$num_alumnos;
               $dat_alumnos['id_alumno']=$alumno->id_alumno;
               $dat_alumnos['id_carga_academica']=$alumno->id_carga_academica;
               $dat_alumnos['cuenta']=$alumno->cuenta;
               $dat_alumnos['estado_validacion']=$alumno->estado_validacion;
               $dat_alumnos['nombre']=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
               $array_calificaciones=array();
               $calificaciones=DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica='.$alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones.id_unidad');
               $suma_unidades=0;
               $calificaciones!= null ? $numero_unidades=0 : $numero_unidades=1;
               $cont_unievaluadas=0;
               foreach ($calificaciones as $calificacion)
               {
                   $esc_cal=false;
                   $bitacora_modificacion=DB::select('SELECT id_carga_academica FROM cal_bitacoras_sumativas
                      WHERE id_evaluacion='.$calificacion->id_evaluacion.'
                      GROUP BY cal_bitacoras_sumativas.id_carga_academica');
                   $dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
                   $dat_calificaciones['calificacion']=$calificacion->calificacion;
                   $dat_calificaciones['modificado']=$bitacora_modificacion != null ? '1' : '2';
                   $dat_calificaciones['id_unidad']=$calificacion->id_unidad;
                   $dat_calificaciones['esc']= $calificacion->esc;
                   if ($calificacion->esc==1)
                   {
                       $esc_alumno=true;
                       $esc_pormateria=true;
                   }
                   if ($calificacion->calificacion<70)
                   {
                       $esc_cal=true;
                       $esc_alumno=true;
                   }
                   if ($calificacion->calificacion < 70) {
                       $sumativas = true;

                   }

                   $dat_calificaciones['esc']= $esc_cal;
                   $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                   $numero_unidades++;
                   $cont_unievaluadas++;
                   array_push($array_calificaciones,$dat_calificaciones);
               }
               if($alumno->estado_validacion ==10) {
                   $esc_alumno=true;
               }
               $dat_alumnos['sumativa'] = $sumativas;
               $dat_alumnos['esc_alumno']=$esc_alumno;
               $dat_alumnos["especial_bloq"]= $esc_alumno==1 && $alumno->nombre_curso=="ESPECIAL" ? 1: 0;
               if($alumno->estado_validacion ==10) {
                   $dat_alumnos['promedio']=0;

               }
               else{
                   $prome=intval(round($suma_unidades/$numero_unidades)+0);
                   if($prome >=70 and $sumativas == false){
                       $promed++;
                   }
                   $dat_alumnos['promedio']=intval(round($suma_unidades/$numero_unidades)+0);

               }
               $dat_alumnos['calificaciones']=$array_calificaciones;
               $dat_alumnos['curso']=$alumno->nombre_curso;
               //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
               array_push($array_alumnos,$dat_alumnos);
           }

           if($promed >0 and $numer_al >0){
               $imp_porcentaje=($promed*100)/$numer_al;
           }else{
               $imp_porcentaje=0;
           }
           //dd($array_alumnos);
           $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
           $array_porcentajes=array();
           $porcent=0;

           for (   $i = 1 ; $i <= $no_unidades[0]->unidades ; $i++) {
               $contar_alumnos = 0;
               $aprobados=0;

               foreach ($array_alumnos as $alumnoss) {
                   foreach ($alumnoss['calificaciones'] as $cal) {
                       if ($cal['id_unidad'] == $i) {
                           if ($cal['calificacion'] >= 70) {
                               $contar_alumnos++;
                               $aprobados++;

                           } else {
                               $contar_alumnos++;

                           }
                           $esta = true;
                           break;
                       } // esta es la que se me olvidaba
                   }


               }

               $dat_porcentajes['id_unidad']=$i;
               $dat_porcentajes['contar']=$contar_alumnos;
               if($contar_alumnos >0 and $aprobados >0)
               {
                   $porcentaje=($aprobados*100)/$contar_alumnos;

               }
               else{
                   $porcentaje=0;
               }
               $porcent+=$porcentaje;
               $dat_porcentajes['porcentaje']=$porcentaje;
               array_push($array_porcentajes,$dat_porcentajes);
           }
       }
       return view ('servicios_escolares.evaluaciones_sumativas',compact('estado_sumativa','nom_docente','nom_carrera','grupo','mat','id_carrera','imp_porcentaje','id_grupo','id_docente','id_materia'))->with(['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes]);
    }
}
