<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Preguntas;
use App\Alumnos;
use App\Personal;
use App\materias;
use App\materias_perfil;
use App\Horarios;
use App\horas_profesor;
use App\grupos;
use App\PeriodosCarreras;
use App\Carreras;
use App\Periodos;
use App\CargaAcademica;
use App\ValidacionCarga;
use App\alumno_materias;

class evaluacion_alumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodo=Session::get('periodo_actual');
        $usuario = Session::get('usuario');
        $carrera = Session::get('carrera');

        $id_alu=DB::selectOne("select gnral_alumnos.id_alumno 
                                from gnral_alumnos 
                                where gnral_alumnos.cuenta='$usuario'");
        $id_alu=($id_alu->id_alumno);


        $no_pregunta=DB::selectOne('select eva_validacion_de_cargas.id, eva_validacion_de_cargas.no_pregunta,eva_validacion_de_cargas.estado_validacion  
                                    from eva_validacion_de_cargas 
                                    WHERE eva_validacion_de_cargas.id_alumno='.$id_alu.' 
                                    AND eva_validacion_de_cargas.id_periodo='.$periodo.'');
        // dd($no_pregunta);
        if($no_pregunta==null)
        {
            $color=1;
            $mensage_carga='Tu carga academica no ha sido dada de alta';
            return view('evaluacion_docente.Alumnos.mensages',compact('mensage_carga','color'));

        }
        else
        {



            $no=($no_pregunta->no_pregunta);
            $id_tabla=($no_pregunta->id);
            $estado=($no_pregunta->estado_validacion);
            $num=10;
            // dd($id_tabla);

            if($no==0)
            {
                $id_pregunta=1;
                $pregunta=1;
                $pre=DB::selectOne('select eva_pregunta.no_pregunta, eva_pregunta.descripcion 
                                from eva_pregunta 
                                WHERE eva_pregunta.no_pregunta='.$pregunta.'');


                //consultar los maestros a los que se van a evaluar conforme a la carga del alumno
                $docentes=DB::select("select DISTINCT (gnral_personales.nombre),gnral_materias.nombre materias,gnral_horas_profesores.grupo,gnral_horas_profesores.id_hrs_profesor ,gnral_materias.id_semestre
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_carreras,gnral_periodos,eva_carga_academica,eva_validacion_de_cargas 
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_carreras.id_carrera=$carrera
                            and gnral_periodos.id_periodo=$periodo
                            and eva_carga_academica.id_status_materia=1
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_materias.especial=0
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                            and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.estado_validacion=2");

                $docentes_especial=DB::select("select DISTINCT(gnral_personales.nombre),gnral_materias.nombre materias,gnral_horas_profesores.grupo,gnral_horas_profesores.id_hrs_profesor, gnral_materias.id_materia id ,gnral_materias.id_semestre
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_carreras,gnral_periodos,eva_carga_academica,eva_validacion_de_cargas 
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_carreras.id_carrera=$carrera
                            and gnral_periodos.id_periodo=$periodo
                            and eva_carga_academica.id_status_materia=1
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_materias.especial=1
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                            and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.estado_validacion=2");

                $condicion=DB::select("select gnral_materias.nombre materias,gnral_materias.id_materia,gnral_horas_profesores.grupo
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_carreras,gnral_periodos,eva_carga_academica,eva_validacion_de_cargas 
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_carreras.id_carrera=$carrera
                            and gnral_periodos.id_periodo=$periodo
                            and eva_carga_academica.id_status_materia=1
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_materias.especial=1
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                               and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.estado_validacion=2");

                if ($docentes_especial!=null)
                {
                    $materiase=1;
                }
                else{
                    $materiase=0;
                }


                $profesores=DB::select("select DISTINCT(hrs_rhps.id_hrs_profesor), gnral_personales.id_personal,gnral_personales.id_personal indice,gnral_personales.nombre p,gnral_materias.id_materia,gnral_materias.nombre ma,gnral_grupos.grupo,eva_alumno_materias.id_alumno_materia 
                                FROM gnral_personales,gnral_horas_profesores,gnral_materias,gnral_carreras,gnral_horarios,gnral_materias_perfiles,gnral_grupos,gnral_periodo_carreras,gnral_periodos,hrs_rhps,eva_alumno_materias 
                                WHERE gnral_personales.id_personal=gnral_horarios.id_personal 
                                AND gnral_personales.id_personal=gnral_materias_perfiles.id_personal 
                                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                                AND gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor 
                                AND gnral_horas_profesores.grupo=gnral_grupos.id_grupo 
                                AND gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                                AND gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                                AND gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                                AND gnral_carreras.id_carrera=$carrera
                                AND gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                                AND gnral_periodo_carreras.id_periodo=$periodo
                                AND hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
                                AND eva_alumno_materias.cuenta='$usuario'
                                AND eva_alumno_materias.id_hrs_profesor=hrs_rhps.id_hrs_profesor 
                                AND eva_alumno_materias.id_hrs_profesor=hrs_rhps.id_hrs_profesor");


            }
            if($no<49 && $no>=1)
            {
                $pre=DB::selectOne('select eva_pregunta.no_pregunta, eva_pregunta.descripcion from eva_pregunta WHERE eva_pregunta.no_pregunta='.$no.'');
                $pregunta=($pre->descripcion);

                $id_pregunta=($pre->no_pregunta);

                $docentes=DB::select("select DISTINCT (gnral_personales.nombre),gnral_materias.nombre materias,gnral_horas_profesores.grupo,gnral_horas_profesores.id_hrs_profesor ,gnral_materias.id_semestre
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_carreras,gnral_periodos,eva_carga_academica,eva_validacion_de_cargas 
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_carreras.id_carrera=$carrera
                            and gnral_periodos.id_periodo=$periodo 
                            and eva_carga_academica.id_status_materia=1
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_materias.especial=0
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                            and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.estado_validacion=2");

                $docentes_especial=DB::select("select DISTINCT(gnral_personales.nombre),gnral_materias.nombre materias,gnral_horas_profesores.grupo,gnral_horas_profesores.id_hrs_profesor, gnral_materias.id_materia id ,gnral_materias.id_semestre
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_carreras,gnral_periodos,eva_carga_academica,eva_validacion_de_cargas 
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_carreras.id_carrera=$carrera
                            and gnral_periodos.id_periodo=$periodo
                            and eva_carga_academica.id_status_materia=1
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_materias.especial=1
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                            and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.estado_validacion=2");

                $condicion=DB::select("select gnral_materias.nombre materias,gnral_materias.id_materia,gnral_horas_profesores.grupo
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_carreras,gnral_periodos,eva_carga_academica,eva_validacion_de_cargas 
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_carreras.id_carrera=$carrera 
                            and gnral_periodos.id_periodo=$periodo
                            and eva_carga_academica.id_status_materia=1
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_materias.especial=1
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                               and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.estado_validacion=2");

                if ($docentes_especial!=null)
                {
                    $materiase=1;
                }



                $profesores=DB::select("select DISTINCT(hrs_rhps.id_hrs_profesor), gnral_personales.id_personal,gnral_personales.id_personal indice, gnral_personales.nombre p,gnral_materias.id_materia,gnral_materias.nombre ma,gnral_grupos.grupo,eva_alumno_materias.id_alumno_materia 
                                FROM gnral_personales,gnral_horas_profesores,gnral_materias,gnral_carreras,gnral_horarios,gnral_materias_perfiles,gnral_grupos,gnral_periodo_carreras,gnral_periodos,hrs_rhps,eva_alumno_materias 
                                WHERE gnral_personales.id_personal=gnral_horarios.id_personal 
                                AND gnral_personales.id_personal=gnral_materias_perfiles.id_personal 
                                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                                AND gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor 
                                AND gnral_horas_profesores.grupo=gnral_grupos.id_grupo 
                                AND gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                                AND gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                                AND gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                                AND gnral_carreras.id_carrera=$carrera 
                                AND gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                                AND gnral_periodo_carreras.id_periodo=$periodo 
                                AND hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
                                AND eva_alumno_materias.cuenta='$usuario'
                                AND eva_alumno_materias.id_hrs_profesor=hrs_rhps.id_hrs_profesor 
                                AND eva_alumno_materias.id_hrs_profesor=hrs_rhps.id_hrs_profesor");


                $num=count($profesores);

                for ($i=0; $i <$num ; $i++)
                {

                    $profesores[$i]->indice=$i+1;


                }
                //dd($profesores);

            }
            if($no==49)
            {

                $profesores=DB::select("select DISTINCT(hrs_rhps.id_hrs_profesor), gnral_personales.id_personal,gnral_personales.id_personal indice, gnral_personales.nombre p,gnral_materias.id_materia,gnral_materias.nombre ma,gnral_grupos.grupo,eva_alumno_materias.id_alumno_materia 
                                FROM gnral_personales,gnral_horas_profesores,gnral_materias,gnral_carreras,gnral_horarios,gnral_materias_perfiles,gnral_grupos,gnral_periodo_carreras,gnral_periodos,hrs_rhps,eva_alumno_materias 
                                WHERE gnral_personales.id_personal=gnral_horarios.id_personal 
                                AND gnral_personales.id_personal=gnral_materias_perfiles.id_personal 
                                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                                AND gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor 
                                AND gnral_horas_profesores.grupo=gnral_grupos.id_grupo 
                                AND gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                                AND gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                                AND gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                                AND gnral_carreras.id_carrera=$carrera 
                                AND gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                                AND gnral_periodo_carreras.id_periodo=$periodo 
                                AND hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
                                AND eva_alumno_materias.cuenta='$usuario'
                                AND eva_alumno_materias.id_hrs_profesor=hrs_rhps.id_hrs_profesor 
                                AND eva_alumno_materias.id_hrs_profesor=hrs_rhps.id_hrs_profesor");
                $condicion=DB::select("select gnral_materias.nombre materias,gnral_materias.id_materia,gnral_horas_profesores.grupo
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_carreras,gnral_periodos,eva_carga_academica,eva_validacion_de_cargas 
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_carreras.id_carrera=$carrera 
                            and gnral_periodos.id_periodo=$periodo 
                             and eva_carga_academica.id_status_materia=1
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.cuenta='$usuario'
                            and gnral_materias.especial=1
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                             and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.estado_validacion=2");


                $id_pregunta=49;
                $pregunta="Evaluacion Finalizada";



                $num=count($profesores);

                for ($i=0; $i <$num ; $i++)
                {

                    $profesores[$i]->indice=$i+1;


                }
            }





            return view('evaluacion_docente.Alumnos.evaluacion_docente',compact('condicion','materiase','docentes_especial','id_pregunta','pregunta','id_tabla','no','estado','docentes','profesores','indice','num'));
        }
    }
    public function insertar(Request $request, $arreglo)
    {



        $usuario = Session::get('usuario');
        $datos=(explode(',',$arreglo));//


        $num=count($datos);//obtiene el numero de elementos del arreglo
        $numm=$num-2;//
        $mitad=$numm/2;
        //  dd($mitad);
        $pregunta=$datos[0];//se obtiene el numero de la pregunta

        $tabla=$datos[1];//se obtiene el id_de la tabala para saber que elemento modificar


        $datoss=array(

            'no_pregunta'=>$pregunta,

        );

        ValidacionCarga::find($tabla)->update($datoss);//modificacion de la tabla en el campo no_pregunta

        $tabla_a_insertar=$pregunta-1;//al valor de la pregunta se le resta 1 para saber en que tabla insertara

        for ($i=0; $i<$mitad ; $i++) //ciclo conforme al numero de docentes evaluados
        {


            DB::insert('insert into p'.$tabla_a_insertar.' (id_alumno_materia, valor) values (?, ?)', [$datos[$i+2],$datos[$i+($mitad+2)]]);

        }


        return redirect()->route('evaluacion_alumno.index');
    }
    public function insertaralumno_materia(Request $request, $arreglo)
    {
        $usuario = Session::get('usuario');
        $datos=(explode(',',$arreglo));


        $num=count($datos);
        $numm=$num-2;
        // dd($numm);


        $pregunta=$datos[0];

        $tabla=$datos[1];
        //dd($tabla);

        $datoss=array(

            'no_pregunta'=>$pregunta,

        );

        ValidacionCarga::find($tabla)->update($datoss);


        for ($i=2; $i<$num ; $i++)
        {

            $arrayName = array('cuenta' =>$usuario,
                'id_hrs_profesor'=>$datos[$i],

            );
            $act=alumno_materias::create($arrayName);


        }



        //   validacion_de_cargas::find($id)->update($datos);
        return redirect()->route('evaluacion_alumno.index');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
