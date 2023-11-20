<?php

namespace App\Http\Controllers;

use App\CalCanalizacion;
use App\calEvaluaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Gnral_Personales;
use App\Gnral_Cargos;
use App\Gnral_Perfiles;
use App\Hrs_Situaciones;
use App\Abreviaciones;
use App\Abreviaciones_prof;
use App\calPeriodos;
use App\calBitacoraEvaluaciones;
use App\calBitacoraPeriodos;
use App\calperiodosSumativas;
use Session;

class DocentesAgController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jefe_division = session()->has('jefe_division') ? session()->has('jefe_division') : false;
        if ($jefe_division == false) {
            $usuario = Session::get('usuario_alumno');
            $correo = DB::selectOne('select email from users where id=' . $usuario . '');
            $correo = ($correo->email);
        } else {
            $correo = " ";
        }

        $cargos = DB::select('select *from gnral_cargos order by cargo');
        $perfiles = DB::select('select *from gnral_perfiles order by descripcion');
        $situaciones = DB::select('select *from hrs_situaciones order by situacion');
        $abreviaciones = DB::select('select *from abreviaciones order by titulo');
        return view('docentes.docentes_create', compact('cargos', 'perfiles', 'situaciones', 'abreviaciones', 'correo'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $clave2 = $request->get('clave_docente');
        $menos = strlen($clave2);

        if ($menos < 8) {
            $cadena1 = 0;
            $cadena = 0;
            for ($i = 0; $i < 8 - $menos; $i++) {
                $cadena1 .= 0;
            }
            $cadena .= $cadena1 . $request->get('clave_docente');
            $clave = $cadena;
        } else {
            $clave = $request->get('clave_docente');
        }

        $jefe_division = session()->has('jefe_division') ? session()->has('jefe_division') : false;
        if ($jefe_division == false) {
            $usuario = Session::get('usuario_alumno');
            $correo = DB::selectOne('select email from users where id=' . $usuario . '');
            $correo = ($correo->email);
        } else {
            $correo = $request->get('correo');
        }

        $id_abreviacion = $request->get('abrevia');

        $this->validate($request, [
            'nombre_docente' => 'required',
            'clave_docente' => 'required',
            'rfc' => 'required',
            'esc_p' => 'required',
            'dir' => 'required',
            'selectPerfil' => 'required',
            'selectSituacion' => 'required',
            'o_nac' => 'required',
            'f_nac' => 'required',
            'f_ingreso' => 'required',
            'selectNombra' => 'required',
            'f_contrata' => 'required',
            'selectEsc' => 'required',
            'telefono' => 'required',
            'celular' => 'required',
            'cedula' => 'required',
            'selectSexo' => 'required',
            'abrevia' => 'required'
        ]);
        $personales = array(
            'nombre' => mb_strtoupper($request->get('nombre_docente'), 'utf-8'),
            'clave' => $clave,
            'rfc' => mb_strtoupper($request->get('rfc'), 'utf-8'),
            'esc_procedencia' => mb_strtoupper($request->get('esc_p'), 'utf-8'),
            'direccion' => mb_strtoupper($request->get('dir'), 'utf-8'),
            'correo' => mb_strtoupper($correo, 'utf-8'),
            'id_perfil' => $request->get('selectPerfil'),
            'id_situacion' => $request->get('selectSituacion'),
            'origen_nac' => mb_strtoupper($request->get('o_nac'), 'utf-8'),
            'fch_nac' => $request->get('f_nac'),
            'fch_ingreso_tesvb' => $request->get('f_ingreso'),
            'nombramiento' => $request->get('selectNombra'),
            'fch_recontratacion' => $request->get('f_contrata'),
            'escolaridad' => mb_strtoupper($request->get('selectEsc'), 'utf-8'),
            'id_cargo' => 0,
            'horas_maxima' => 0,
            'telefono' => $request->get('telefono'),
            'celular' => $request->get('celular'),
            'cedula' => $request->get('cedula'),
            'sexo' => $request->get('selectSexo'),
            'tipo_usuario' => $usuario,
            'maximo_horas_ingles' => 0,
            'id_departamento' => 0
        );

        $cadena = "";
        $cadena .= $clave;
        $cadena1 = "";
        $cadena1 .= $request->get('rfc');

        $agrega_docente = Gnral_Personales::create($personales);

        if ($jefe_division == false) {
            $actualiza = DB::select('update users set info_ok=2 where id=' . $usuario . ' ');
            $personal = DB::selectOne('select gnral_personales.id_personal from gnral_personales where tipo_usuario=' . $usuario . '');
            $personal = ($personal->id_personal);
        } else {
            $personal = DB::selectOne('select id_personal from gnral_personales where
                        rfc=' . $cadena1 . ' and clave=' . $cadena . '');
            $personal = ($personal->id_personal);
        }

        $checa = DB::selectOne('select id_abreviacion_prof from abreviaciones_prof where
            id_personal=' . $personal . '');
//si ya existe un docente en la tabla abreviaciones_prof se actualizará con el nuevo
        $checa2 = isset($checa->id_abreviacion_prof) ? $checa->id_abreviacion_prof : 0;
        if ($checa2 == 0) {
            $abreviacion = array(
                'id_abreviacion' => $id_abreviacion,
                'id_personal' => $personal);

            $agrega_abrev = Abreviaciones_prof::create($abreviacion);
        } else {
            $abreviacion = array(
                'id_abreviacion' => $id_abreviacion,
                'id_personal' => $personal);

            Abreviaciones_prof::find($checa->id_abreviacion_prof)->update($abreviacion);
        }

        return redirect('/home');

    }

    public function perfiles($perfil)
    {
        $a_perfiles = array(
            'descripcion' => $perfil
        );
        $agrega_perfil = Gnral_Perfiles::create($a_perfiles);
        $perfiles = DB::select('select *from gnral_perfiles order by descripcion');
        return compact('perfiles');
    }

    public function situaciones($situacion, $abre)
    {
        $a_situaciones = array(
            'situacion' => $situacion,
            'abrevia' => $abre
        );
        $agrega_situacion = Hrs_Situaciones::create($a_situaciones);
        $situaciones = DB::select('select *from hrs_situaciones order by situacion');
        return compact('situaciones');
    }

    public function abreviaciones($abreviacion)
    {
        $a_abreviaciones = array(
            'titulo' => $abreviacion
        );
        $agrega_abrevia = Abreviaciones::create($a_abreviaciones);
        $abreviaciones = DB::select('select *from abreviaciones order by titulo');
        return compact('abreviaciones');
    }

    public function cargos($cargo, $abre)
    {
        $a_cargos = array(
            'cargo' => $cargo,
            'abre' => $abre
        );
        $agrega_cargo = Gnral_Cargos::create($a_cargos);
        $cargos = DB::select('select *from gnral_cargos order by cargo');
        return compact('cargos');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    ///////HS777///////
    public function carreras($id_docente)
    {
        $periodo = Session::get('periodo_actual');
        $periodo_sumativas = calperiodosSumativas::where("id_periodo", "=", $periodo)->get()->toArray();
        if ($periodo_sumativas == null) {
            $periodo_sumativas = 0;
        } else {
            $f_inicio = $periodo_sumativas[0]["fecha_inicio"];
            $f_fin = $periodo_sumativas[0]["fecha_fin"];
            $f_actual = date("Y") . "-" . date("m") . "-" . date("d");
            if ($f_inicio <= $f_actual && $f_actual <= $f_fin) {
                $periodo_sumativas = 1;
            } else {
                $periodo_sumativas = 0;
            }
        }
        $carreras = DB::select('select Distinct(gnral_carreras.nombre) carrera,gnral_carreras.id_carrera
                      from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                      where gnral_periodos.id_periodo=' . $periodo . '
                      and gnral_horarios.id_personal=' . $id_docente . '
                      and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                      and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                      and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                      and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                      and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                      and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                      and gnral_horarios.id_personal=gnral_personales.id_personal
                      and gnral_materias.id_semestre=gnral_semestres.id_semestre');
        $datos = array();
        foreach ($carreras as $carrera) {
            $dat_carreras['nombre_carrera'] = $carrera->carrera;
            $dat_carreras['id_carrera'] = $carrera->id_carrera;
            $materias = DB::select('select  DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.id_materia,gnral_materias.nombre mat, gnral_semestres.id_semestre idsem,gnral_carreras.nombre,gnral_carreras.id_carrera,gnral_semestres.descripcion semestre,
                CONCAT(gnral_semestres.id_semestre,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                where gnral_periodos.id_periodo=' . $periodo . '
                and gnral_carreras.id_carrera=' . $carrera->id_carrera . '
                and gnral_horarios.id_personal=' . $id_docente . '
                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                and gnral_horarios.id_personal=gnral_personales.id_personal
                /*and gnral_materias.id_materia=eva_carga_academica.id_materia*/
                and gnral_materias.id_semestre=gnral_semestres.id_semestre GROUP BY gnral_materias.id_materia');

            $array_materias = array();
            $cont = 0;
            foreach ($materias as $materia) {
                $cont++;
                $dat_materias['id_materia'] = $materia->id_materia;
                $dat_materias['nombre_materia'] = $materia->mat;
                $dat_materias['id_semestre'] = $materia->idsem;
                $dat_materias['nombre_semestre'] = $materia->semestre;
                $dat_materias['contador'] = $cont;
                $dat_materias['idcarrera'] = $materia->id_carrera;
                $grupos = DB::select('select gnral_horas_profesores.grupo id_grupo,CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                where gnral_periodos.id_periodo=' . $periodo . '
                and gnral_materias.id_materia=' . $materia->id_materia . '
                and gnral_horarios.id_personal=' . $id_docente . '
                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                and gnral_horarios.id_personal=gnral_personales.id_personal
                and gnral_materias.id_semestre=gnral_semestres.id_semestre ORDER BY grupo');
                $array_grupos = array();
                foreach ($grupos as $grupo) {
                    $dat_grupos['id_grupo'] = $grupo->id_grupo;
                    $dat_grupos['grupos'] = $grupo->grupo;
                    array_push($array_grupos, $dat_grupos);
                }
                $dat_materias['grupos'] = $array_grupos;
                array_push($array_materias, $dat_materias);
            }
            $dat_carreras['materias'] = $array_materias;
            array_push($datos, $dat_carreras);
        }
        //dd($datos);
        return view('docentes.docentes_carreras', compact('id_docente', 'periodo_sumativas'))->with(['carreras' => $datos]);
    }

    public function periodos_materia($id_docente, $id_materia, $id_grupo)
    {

        $periodo = Session::get('periodotrabaja');
        $tot_unidades = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = ' . $id_materia . '');
        $uni_asignadas = DB::select('SELECT * FROM cal_periodos_califica WHERE id_periodos = ' . $periodo . ' AND id_materia = ' . $id_materia . ' AND id_grupo = ' . $id_grupo . '');
        $carrera = DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= ' . $id_materia . '');
        $asignadas = DB::selectOne('select max(cal_periodos_califica.id_unidad)maxima  FROM cal_periodos_califica WHERE id_periodos = ' . $periodo . ' AND id_materia = ' . $id_materia . ' AND id_grupo = ' . $id_grupo . '');


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
        $nom_carrera = $carrera->nombre;;
        $grupo = $tot_unidades->id_semestre . '0' . $id_grupo;

        $nom_materia = $tot_unidades->nombre;
        $clave_m = $tot_unidades->clave;
        $unidades = $tot_unidades->unidades;
        return view('docentes.docentes_periodos', compact('id_docente', 'id_materia', 'id_grupo', 'grupo', 'nom_carrera', 'nom_materia', 'clave_m', 'unidades', 'id_grupo', 'array_perio', 'tot_unidades'));
    }

    public function calificarunidad($id_docente, $id_materia, $id_grupo)
    {
        $canalizaciones = CalCanalizacion::all();

        $periodo = Session::get('periodotrabaja');

        $per=DB::selectOne('SELECT * FROM `gnral_periodos` WHERE `id_periodo` = '.$periodo.'');
        $fecha_fech= $per->fecha_inicio;


        $fecha_dia=date("Y-m-d",strtotime($fecha_fech."+ 20 days"));


        $fecha_hoy = date("Y-m-d");

      if($fecha_dia >= $fecha_hoy){
          $mostrar_mensaje=1;
      }else{
          $mostrar_mensaje=2;
      }
    // dd($mostrar_mensaje);
        $mat = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = ' . $id_materia . '');
        $grupo = $mat->id_semestre . '0' . $id_grupo;
        $carrera = DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= ' . $id_materia . '');
        $nom_carrera = $carrera->nombre;
        //accion 1 = periodos
        //accion 2 = calificaciones
        //dd($tipo_accion);

        $cont_unievaluadas = 0;
        $unidades = 0;
        $esc_alumno = false;
        $esc_pormateria = 0;
        $estado_reprobado=0;
        $uni_asignadas = DB::select('select cal_periodos_califica.id_periodo_cal,cal_periodos_califica.id_unidad,cal_periodos_califica.fecha,cal_periodos_califica.id_materia from cal_periodos_califica 
where id_materia=' . $id_materia . ' and id_grupo=' . $id_grupo . ' and id_periodos=' . $periodo . '');
        $calificar_sumativa = DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = ' . $id_materia . ' AND `id_grupo` = ' . $id_grupo . ' AND `id_estado` = 1 AND `id_periodo` = ' . $periodo . '');
        if ($calificar_sumativa->sumativa == 0) {
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
                $dat_alumnos['repeticion'] = $sumativas;
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
                $imp_porcentaje = ($promed * 100 / $numer_al);
            } else {
                $imp_porcentaje = 0;
            }
            //dd($array_alumnos);
            $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
            $array_porcentajes = array();
            $porcent = 0;
            $alumno_rep=0;
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

                    if($alumnoss['repeticion'] == true){
                        $alumno_rep++;
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

            //dd($array_alumnos);
//dd($alumno_rep);
//dd($aprobados);

            if ($cont_unievaluadas == $no_unidades[0]->unidades) {


                $calf_duales = DB::selectOne('SELECT COUNT(id_duales) total from gnral_calificar_duales where id_materia=' . $id_materia . ' and status=1 and id_periodo=' . $periodo . ' and id_grupo=' . $id_grupo . '');
                $calf_duales = $calf_duales->total;
                if ($num_duales == 0) {
                    $habilitaPDF = 2;
                    if($alumno_rep == 0){
                        $estado_reprobado=1;
                    }
                } else {
                    if ($calf_duales == 0) {
                        $habilitaPDF = 1;
                    } else {
                        $habilitaPDF = 2;
                        if($alumno_rep == 0){
                            $estado_reprobado=1;
                        }
                    }
                }
            } else {
                $habilitaPDF = 0;
            }
//dd($alumno_rep);
        } else {
            ///////////////cuando ya se califico sumativas
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
                $calificaciones = DB::select('SELECT * FROM cal_evaluaciones_sumativa
                      WHERE id_carga_academica=' . $alumno->id_carga_academica . '
                      ORDER BY cal_evaluaciones_sumativa.id_unidad');
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
                $dat_alumnos['repeticion'] = $sumativas;
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
            //dd($array_alumnos);
            $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
            $array_porcentajes = array();
            $porcent = 0;
             $alumno_rep=0;
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
                   if($alumnoss['repeticion'] == true){
                       $alumno_rep++;
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
            //dd($alumno_rep);


            if ($cont_unievaluadas == $no_unidades[0]->unidades) {


                $calf_duales = DB::selectOne('SELECT COUNT(id_duales) total from gnral_calificar_duales where id_materia=' . $id_materia . ' and status=1 and id_periodo=' . $periodo . ' and id_grupo=' . $id_grupo . '');
                $calf_duales = $calf_duales->total;
                if ($num_duales == 0) {
                    $habilitaPDF = 2;
                } else {
                    if ($calf_duales == 0) {
                        $habilitaPDF = 1;
                    } else {
                        $habilitaPDF = 2;
                    }
                }
            } else {
                $habilitaPDF = 0;
            }
        }
       /// dd($estado_reprobado);
         //dd($array_alumnos);
        //dd($uni_asignadas);
        /////$habilitaPDF = $cont_unievaluadas == $no_unidades[0]->unidades ? "1" : "0";
        ///
       // dd($array_alumnos);

        if ($carrera->nombre == "INGENIERIA EN SISTEMAS COMPUTACIONALES")
            return view('docentes.partials.docentes_evaluaciones_reportes', compact('mostrar_mensaje','esc_pormateria', 'habilitaPDF', 'id_grupo',
                'grupo', 'id_docente', 'id_materia', 'nom_carrera', 'nom_materia', 'clave_m', 'unidades', 'canalizaciones','estado_reprobado'))
                ->with(['alumnos' => $array_alumnos, 'porcentajes' => $array_porcentajes, 'uni_asignadas' => $uni_asignadas]);

        return view('docentes.partials.docentes_evaluaciones', compact('mostrar_mensaje','imp_porcentaje', 'esc_pormateria',
            'habilitaPDF', 'id_grupo', 'grupo', 'id_docente', 'id_materia', 'nom_carrera', 'nom_materia', 'clave_m','estado_reprobado',
            'unidades'))->with(['alumnos' => $array_alumnos, 'porcentajes' => $array_porcentajes, 'uni_asignadas' => $uni_asignadas]);

    }
    public function guardar_sin_alumnos_ensumativa(Request $request, $id_docente, $id_materia, $id_grupo){
        $periodo = Session::get('periodotrabaja');
        $fechass=date("Y-m-d H:i");
        DB:: table('gnral_calificar_sumativas')
            ->insert([
                'id_materia' => $id_materia,
                'id_grupo' => $id_grupo,
                'id_estado' => 1,
                'id_periodo' => $periodo,
                'fecha' => $fechass]);
        return back();
    }
    public function evaluacionSumativa($id_docente, $id_materia, $id_semestre, $id_grupo, $nom_carrera)
    {
        $periodo = Session::get('periodo_actual');
        $grupo = $id_semestre . "0" . $id_grupo;
        $cont_unievaluadas = 0;
        $unidades = 0;
        $esc_pormateria = 0;
        $esc_alumno = false;
        $uni_asignadas = DB::select('select cal_periodos_califica.id_periodo_cal,cal_periodos_califica.id_unidad,cal_periodos_califica.fecha,cal_periodos_califica.id_materia from cal_periodos_califica 
where id_materia=' . $id_materia . ' and id_grupo=' . $id_grupo . ' and id_periodos=' . $periodo . '');

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
        $numer_al = 0;
        $promed = 0;
        $num_duales = 0;
        foreach ($alumnos as $alumno) {
            $sumativas = false;
            $esc_alumno = false;
            $num_alumnos++;
            $nom_materia = $alumno->materia;
            $clave_m = $alumno->clave;
            $unidades = $alumno->unidades;
            if ($alumno->estado_validacion == 9) {
                $num_duales++;
            }

            if ($alumno->estado_validacion != 10) {
                $numer_al++;
            }
            if ($alumno->estado_validacion == 10) {
                $dat_alumnos["baja"] = 1;
            } else {
                $dat_alumnos["baja"] = 0;
            }
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
                $esc_cal = false;
                $bitacora_modificacion = DB::select('SELECT id_carga_academica FROM cal_bitacora_evaluaciones
                      WHERE id_evaluacion=' . $calificacion->id_evaluacion . '
                      GROUP BY cal_bitacora_evaluaciones.id_carga_academica');
                $dat_calificaciones['id_evaluacion'] = $calificacion->id_evaluacion;
                $dat_calificaciones['calificacion'] = $calificacion->calificacion;
                $dat_calificaciones['modificado'] = $bitacora_modificacion != null ? '1' : '2';
                $dat_calificaciones['id_unidad'] = $calificacion->id_unidad;
                $dat_calificaciones['esc'] = $calificacion->esc;
                if ($calificacion->esc == 1) {
                    $esc_alumno = true;
                    $esc_pormateria = true;
                }
                if ($calificacion->calificacion < 70) {
                    $esc_cal = true;
                    $esc_alumno = true;
                }
                if ($calificacion->calificacion < 70) {
                    $sumativas = true;

                }

                $dat_calificaciones['esc'] = $esc_cal;
                $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                $numero_unidades++;
                $cont_unievaluadas++;
                array_push($array_calificaciones, $dat_calificaciones);
            }
            if ($alumno->estado_validacion == 10) {
                $esc_alumno = true;
            }
            $dat_alumnos['repeticion'] = $sumativas;
            $dat_alumnos['esc_alumno'] = $esc_alumno;
            $dat_alumnos["especial_bloq"] = $esc_alumno == 1 && $alumno->nombre_curso == "ESPECIAL" ? 1 : 0;
            if ($alumno->estado_validacion == 10) {
                $dat_alumnos['promedio'] = 0;

            } else {
                $prome = intval(round($suma_unidades / $numero_unidades) + 0);
                if ($prome >= 70 and $sumativas == false) {
                    $promed++;
                }
                $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);

            }

            $dat_alumnos['calificaciones'] = $array_calificaciones;
            $dat_alumnos['curso'] = $alumno->nombre_curso;
            //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
            array_push($array_alumnos, $dat_alumnos);
        }
//dd($numer_al);
        if ($promed > 0 and $numer_al > 0) {
            $imp_porcentaje = ($promed * 100) / $numer_al;
            //dd($imp_porcentaje);
        } else {
            $imp_porcentaje = 0;
        }
        //dd($array_alumnos);
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
        if ($cont_unievaluadas == $no_unidades[0]->unidades) {


            $calf_duales = DB::selectOne('SELECT COUNT(id_duales) total from gnral_calificar_duales where id_materia=' . $id_materia . ' and status=1 and id_periodo=' . $periodo . ' and id_grupo=' . $id_grupo . '');
            $calf_duales = $calf_duales->total;
            if ($num_duales == 0) {
                $habilitaPDF = 2;
            } else {
                if ($calf_duales == 0) {
                    $habilitaPDF = 1;
                } else {
                    $habilitaPDF = 2;
                }
            }
        } else {
            $habilitaPDF = 0;
        }

        $calificar_sumativa = DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = ' . $id_materia . ' AND `id_grupo` = ' . $id_grupo . ' AND `id_estado` = 1 AND `id_periodo` = ' . $periodo . '');


        //dd($array_alumnos);
        //dd($esc_pormateria);
        //$habilitaPDF=$cont_unievaluadas==$no_unidades[0]->unidades ? "1" : "0";
        return view('docentes.docentes_sumativas', compact('calificar_sumativa', 'imp_porcentaje', 'esc_pormateria', 'habilitaPDF', 'id_grupo', 'grupo', 'id_docente', 'id_materia', 'nom_carrera', 'nom_materia', 'clave_m', 'unidades'))->with(['alumnos' => $array_alumnos, 'porcentajes' => $array_porcentajes, 'uni_asignadas' => $uni_asignadas]);
    }

    public function generaPeriodo(Request $request)
    {
        //  dd($request);

        $fechass = $request->input("fecha_s");
        // dd($fechass);
        $id_unidad = $request->input("id_unidad");
        $id_materia = $request->input("id_materia");
        $id_grupo = $request->input("id_grupo");
        $date = str_replace('/', '-', $fechass);
        $fecha_hora = date("Y-m-d", strtotime($date));
        // dd($fecha_hora);
        $id_periodo = Session::get('periodo_actual');
        DB:: table('cal_periodos_califica')->insert(['fecha' => $fecha_hora, 'id_unidad' => $id_unidad, 'id_periodos' => $id_periodo, 'id_materia' => $id_materia, 'id_grupo' => $id_grupo, 'evaluada' => 0]);
        return back();
    }

    public function modificaPeriodo(Request $request)
    {
        $fechas = $request->get('fecha_s');
        $date = str_replace('/', '-', $fechas);
        $fecha_hora = date("Y-m-d", strtotime($date));
        $id_periodo_cal = $request->get('id_periodo_cal');
        $id_docente = $request->get('id_docente');
        $personal = DB::selectOne('SELECT nombre FROM gnral_personales WHERE id_personal =' . $id_docente . '');
        $bitacora_periodo = DB::selectOne('SELECT * FROM cal_periodos_califica WHERE cal_periodos_califica.id_periodo_cal = ' . $id_periodo_cal . '');
        // dd($request);
        $bitacora = array(
            'id_periodo_cal' => $bitacora_periodo->id_periodo_cal,
            'id_unidad' => $bitacora_periodo->id_unidad,
            'id_grupo' => $bitacora_periodo->id_grupo,
            'id_materia' => $bitacora_periodo->id_materia,
            'docente' => $personal->nombre,
            'fecha_antigua' => $bitacora_periodo->fecha,
            'fecha_nueva' => $fecha_hora,
            'id_periodo' => Session::get('periodo_actual')
        );
        $bt = calBitacoraPeriodos::create($bitacora);
        calPeriodos::find($id_periodo_cal)->update(['fecha' => $fecha_hora]);
        return back();
    }
    public function modifica_cc_Periodo(Request $request)
    {
        $fechas = $request->get('fecha_s');
        $date = str_replace('/', '-', $fechas);
        $fecha_hora = date("Y-m-d", strtotime($date));
        $id_periodo_cal = $request->get('id_periodo_cal');
        $id_docente = $request->get('id_docente');
        $personal = DB::selectOne('SELECT nombre FROM gnral_personales WHERE id_personal =' . $id_docente . '');
        $bitacora_periodo = DB::selectOne('SELECT * FROM cal_periodos_califica WHERE cal_periodos_califica.id_periodo_cal = ' . $id_periodo_cal . '');
        // dd($request);
        $bitacora = array(
            'id_periodo_cal' => $bitacora_periodo->id_periodo_cal,
            'id_unidad' => $bitacora_periodo->id_unidad,
            'id_grupo' => $bitacora_periodo->id_grupo,
            'id_materia' => $bitacora_periodo->id_materia,
            'docente' => $personal->nombre,
            'fecha_antigua' => $bitacora_periodo->fecha,
            'fecha_nueva' => $fecha_hora,
            'id_periodo' => Session::get('periodo_actual')
        );
        $bt = calBitacoraPeriodos::create($bitacora);
        calPeriodos::find($id_periodo_cal)->update(['fecha' => $fecha_hora]);
        return back();
    }

    public function inserta($id_docente, $id_materia, $id_grupo, $id_unidad, Request $request)
    {
        $carrera = DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= ' . $id_materia . '');

        $cal = json_decode($_POST['calificaciones']);
        $all_cal = $cal->alumno;
        foreach ($all_cal as $alumno) {

            if ($carrera->nombre == "INGENIERIA EN SISTEMAS COMPUTACIONALES") {
                $dat_evaluacion = array(
                    'id_unidad' => $alumno->id_unidad,
                    'id_carga_academica' => $alumno->id_carga_academica,
                    'calificacion' => $alumno->calificacion,
                    "observaciones" => $alumno->opcion == 3 ? $alumno->otro : ($alumno->opcion == 1 ? "Faltas" : ($alumno->opcion == 2 ? "Responsabilidad" : "")),
                    "id_canalizacion" => $alumno->canaliza);
            } else {
                $dat_evaluacion = array(
                    'id_unidad' => $alumno->id_unidad,
                    'id_carga_academica' => $alumno->id_carga_academica,
                    'calificacion' => $alumno->calificacion);
            }
            $inserta_calificacion = calEvaluaciones::create($dat_evaluacion);
        }
        $periodo = Session::get('periodo_actual');
        if ($carrera->nombre == "INGENIERIA EN SISTEMAS COMPUTACIONALES") {
            DB::update('UPDATE cal_periodos_califica SET evaluada = 1, acciones_preventivas="' . $request->acciones . '"
WHERE cal_periodos_califica.id_materia=' . $id_materia . ' 
and cal_periodos_califica.id_periodos=' . $periodo . ' and
 cal_periodos_califica.id_unidad=' . $id_unidad . ' and cal_periodos_califica.id_grupo=' . $id_grupo . '
      ');
        } else {
            DB::update('UPDATE cal_periodos_califica SET evaluada = 1 
WHERE cal_periodos_califica.id_materia=' . $id_materia . ' 
and cal_periodos_califica.id_periodos=' . $periodo . ' and
 cal_periodos_califica.id_unidad=' . $id_unidad . ' and cal_periodos_califica.id_grupo=' . $id_grupo . '
      ');
        }

        return $inserta_calificacion;
    }

    public function Sumativas($id_docente, $id_materia, $id_grupo)
    {
        $cal = json_decode($_POST['calificaciones']);
        $all_cal = $cal->alumno;
        foreach ($all_cal as $alumno) {
            calEvaluaciones::find($alumno->id_eval)->update(['calificacion' => $alumno->calificacion, 'esc' => 1]);
        }
        $periodo = Session::get('periodo_actual');
        $fech = date("Y-m-d H:i:s");
        DB:: table('gnral_calificar_sumativas')->insert(['id_materia' => $id_materia, 'id_grupo' => $id_grupo, 'id_estado' => 1, 'id_periodo' => $periodo, 'fecha' => $fech]);

    }

    public function registro_periodo($id_unidad, $id_materia, $id_grupo)
    {
        // dd($id_unidad,$id_materia,$id_grupo);
        if ($id_unidad == 1) {
            $dias = 0;
            $di = 1;

        } else {

            $periodo = Session::get('periodo_actual');
            $id_unidad_pasada = $id_unidad - 1;
            $fecha_f = DB::selectOne('SELECT fecha FROM cal_periodos_califica where cal_periodos_califica.id_unidad=' . $id_unidad_pasada . ' and cal_periodos_califica.id_periodos=' . $periodo . ' and cal_periodos_califica.id_materia=' . $id_materia . ' and cal_periodos_califica.id_grupo=' . $id_grupo . '');
            $fecha_f = $fecha_f->fecha;
            //dd($id_unidad_pasada);
            $fecha_i = date("Y-m-d");

            if ($fecha_f >= $fecha_i) {
                // $fecha_f = $fecha_f->fecha;
                $dias = (strtotime($fecha_f) - strtotime($fecha_i)) / 86400;
                $dias = abs($dias);
                $dias = floor($dias);
                $dias = $dias + 1;
                $di = 2;
            } else {
                // dd('hola');
                // $fecha_f = $fecha_f->fecha;
                $dias = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
                $dias = abs($dias);
                $dias = floor($dias);
                $dias = $dias + 1;
                $di = 3;

            }
        }

        //dd($id_unidad, $id_materia, $id_grupo, $di, $dias);
        return view('docentes.partials.insertar_periodo', compact('id_unidad', 'id_materia', 'id_grupo', 'di', 'dias'));
    }


    public function modificacionPeriodo($id_unidad, $id_materia, $id_grupo, $id_docente)
    {
        $periodo = Session::get('periodo_actual');
        $fecha_f = DB::selectOne('SELECT fecha,id_periodo_cal FROM cal_periodos_califica where cal_periodos_califica.id_unidad=' . $id_unidad . ' and cal_periodos_califica.id_periodos=' . $periodo . ' and cal_periodos_califica.id_materia=' . $id_materia . ' and cal_periodos_califica.id_grupo=' . $id_grupo . '');
        $fecha_final = $fecha_f->fecha;
        $id_periodo_cal = $fecha_f->id_periodo_cal;
        $id_unidad_pasada = ($id_unidad) + (1);
        $fecha_seguida = DB::selectOne('SELECT fecha FROM cal_periodos_califica where cal_periodos_califica.id_unidad=' . $id_unidad_pasada . ' and cal_periodos_califica.id_periodos=' . $periodo . ' and cal_periodos_califica.id_materia=' . $id_materia . ' and cal_periodos_califica.id_grupo=' . $id_grupo . '');

        if ($fecha_seguida == null) {
            $unidad = 0;
            $fecha_superior = "no";
            $di = 1;
            $dias1 = 0;
            $dias_p = 0;
        } else {
            $unidad = 1;
            $fecha_superior = $fecha_seguida->fecha;
            $fecha_s = date("Y-m-d");

            if ($fecha_superior > $fecha_s) {

                $dias1 = (strtotime($fecha_superior) - strtotime($fecha_s)) / 86400;
                $dias1 = abs($dias1);
                $dias1 = floor($dias1);
                $dias_p = 1;


            } elseif ($fecha_superior == $fecha_s) {
                $dias1 = 0;
                $dias_p = 1;

            } else {

                $dias1 = (strtotime($fecha_s) - strtotime($fecha_superior)) / 86400;
                $dias1 = abs($dias1);
                $dias1 = floor($dias1);
                $dias_p = 2;


            }

        }
        $fecha_i = date("Y-m-d");
        if ($fecha_final > $fecha_i) {
            $fecha_f = $fecha_f->fecha;
            $dias = (strtotime($fecha_f) - strtotime($fecha_i)) / 86400;
            $dias = abs($dias);
            $dias = floor($dias);
            $di = 1;

        } elseif ($fecha_final == $fecha_i) {
            $dias = 0;
            $di = 1;
        } else {
            $fecha_f = $fecha_f->fecha;
            $dias = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
            $dias = abs($dias);
            $dias = floor($dias);
            $di = 2;

        }

        $numero = $dias1;
        $dias_p = $dias_p;

        return view('jefe_carrera.modificar_periodo', compact('id_docente', 'unidad', 'fecha_superior', 'dias', 'di', 'id_periodo_cal', 'fecha_final', 'fecha_i', 'numero', 'dias_p'));


    } public function modificacion_cc_Periodo($id_unidad, $id_materia, $id_grupo, $id_docente)
{
    $periodo = Session::get('periodo_actual');
    $fecha_f = DB::selectOne('SELECT fecha,id_periodo_cal FROM cal_periodos_califica where cal_periodos_califica.id_unidad=' . $id_unidad . ' and cal_periodos_califica.id_periodos=' . $periodo . ' and cal_periodos_califica.id_materia=' . $id_materia . ' and cal_periodos_califica.id_grupo=' . $id_grupo . '');
    $fecha_final = $fecha_f->fecha;
    $id_periodo_cal = $fecha_f->id_periodo_cal;
    $id_unidad_pasada = ($id_unidad) + (1);
    $fecha_seguida = DB::selectOne('SELECT fecha FROM cal_periodos_califica where cal_periodos_califica.id_unidad=' . $id_unidad_pasada . ' and cal_periodos_califica.id_periodos=' . $periodo . ' and cal_periodos_califica.id_materia=' . $id_materia . ' and cal_periodos_califica.id_grupo=' . $id_grupo . '');

    if ($fecha_seguida == null) {
        $unidad = 0;
        $fecha_superior = "no";
        $di = 1;
        $dias1 = 0;
        $dias_p = 0;
    } else {
        $unidad = 1;
        $fecha_superior = $fecha_seguida->fecha;
        $fecha_s = date("Y-m-d");

        if ($fecha_superior > $fecha_s) {

            $dias1 = (strtotime($fecha_superior) - strtotime($fecha_s)) / 86400;
            $dias1 = abs($dias1);
            $dias1 = floor($dias1);
            $dias_p = 1;


        } elseif ($fecha_superior == $fecha_s) {
            $dias1 = 0;
            $dias_p = 1;

        } else {

            $dias1 = (strtotime($fecha_s) - strtotime($fecha_superior)) / 86400;
            $dias1 = abs($dias1);
            $dias1 = floor($dias1);
            $dias_p = 2;


        }

    }
    $fecha_i = date("Y-m-d");
    if ($fecha_final > $fecha_i) {
        $fecha_f = $fecha_f->fecha;
        $dias = (strtotime($fecha_f) - strtotime($fecha_i)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);
        $di = 1;

    } elseif ($fecha_final == $fecha_i) {
        $dias = 0;
        $di = 1;
    } else {
        $fecha_f = $fecha_f->fecha;
        $dias = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);
        $di = 2;

    }

    $numero = $dias1;
    $dias_p = $dias_p;

    return view('jefe_carrera.modificar_periodo', compact('id_docente', 'unidad', 'fecha_superior', 'dias', 'di', 'id_periodo_cal', 'fecha_final', 'fecha_i', 'numero', 'dias_p'));


}}

