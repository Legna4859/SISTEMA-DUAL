<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eva_Tutor;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Storage;
use Session;

class Tu_Eva_CordinadorInstitucionalController extends Controller
{
    public function index()
    {
        $carreras = DB::select('SELECT car.id_carrera, car.nombre FROM gnral_carreras car
                                /* Trae las carreras excepto ingles y clturales */
                                WHERE car.id_carrera NOT IN (9) 
                                AND car.id_carrera NOT IN (11) 
                                AND car.id_carrera NOT IN (15)');
        //dd($carreras);
        return view('tutorias.eva_tutorias.carreras_index',compact('carreras'));
    }

    public function estado()
    {
        $periodo=Session::get('periodo_actual');
        $per = DB::selectOne('SELECT p.estado FROM tu_eva_periodo p INNER JOIN gnral_periodos per ON per.id_periodo = p.id_periodo WHERE per.id_periodo = '.$periodo.' ');

        if ($per == null)
        {
            DB::insert('INSERT INTO tu_eva_periodo VALUES ( NULL, '.$periodo.' , 0, now() ) ');

            return redirect('/tutorias/evaluacion_tutor/estado/');
        }
        else if ($per->estado == 0)
        {
            $estado = 'Activar evaluación';
        }
        else if ($per->estado == 1)
        {
            $estado = 'Estado de Evaluacion al Tutor: Activo';
        }
        else
        {
            $estado = 'Estado de Evaluacion al Tutor: Finalizado';
        }

        return view('tutorias.eva_tutorias.activacion_index', compact('per', 'estado'));
    }

    public  function activa()
    {
        $periodo=Session::get('periodo_actual');
        //dd("activa");
        $con = DB::selectOne('SELECT COUNT(p.id_eva_periodo) con FROM tu_eva_periodo p INNER JOIN gnral_periodos per ON per.id_periodo = p.id_periodo WHERE per.id_periodo = '.$periodo.'  ');
        if ($con->con == 0)
        {
            DB::insert('INSERT INTO tu_eva_periodo VALUES ( NULL, '.$periodo.' , true, now() ) ');
            return redirect('/tutorias/evaluacion_tutor/estado/');
        }
        else{
            DB::update('UPDATE tu_eva_periodo SET estado = 1 WHERE id_periodo = '.$periodo.' ');
            return redirect('/tutorias/evaluacion_tutor/estado/');
        }
    }

    public  function desactiva()
    {
        $periodo=Session::get('periodo_actual');
        //dd("desactiva");
        DB::update('UPDATE tu_eva_periodo SET estado = 2 WHERE id_periodo = '.$periodo.' ');
        DB::update('UPDATE tu_eva_periodo SET fecha_final_eva = now() WHERE id_periodo = '.$periodo.' ');
        return redirect('/tutorias/evaluacion_tutor/estado/');
    }

    public function carreras($id_carrera)
    {
        //dd($id_carrera);
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` ='.$id_carrera.'');
        $periodo=Session::get('periodo_actual');
        //dd($periodo);

        $tutores = DB::SELECT('SELECT exp_asigna_t.id_asigna_generacion,tu_grupo_s.id_grupo_semestre,
       car.nombre carrera, car.id_carrera, tu_grupo_t.descripcion grupo, gnral_p.nombre nombre_tutor,
       gnral_p.tipo_usuario tipo FROM tu_grupo_tutorias tu_grupo_t
                              INNER JOIN tu_grupo_semestre tu_grupo_s
                              ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                              INNER JOIN exp_asigna_tutor exp_asigna_t 
                              ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                              INNER JOIN gnral_personales gnral_p 
                              ON gnral_p.id_personal = exp_asigna_t.id_personal 
                              INNER JOIN gnral_jefes_periodos gnral_j 
                              ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                              INNER JOIN gnral_carreras car
                              ON car.id_carrera = gnral_j.id_carrera
                              WHERE gnral_j.id_periodo = '.$periodo.' AND car.id_carrera = '.$id_carrera.' ');

       return view('tutorias.eva_tutorias.cordinador_index',compact('tutores','id_carrera','carrera'));
    }

    public function resultados($id_grupo_semestre,$grupo,$carrera)
    {
        $periodo=Session::get('periodo_actual');

        $datos = DB::SELECT('SELECT exp_asigna_t.id_asigna_tutor,  tu_grupo_s.id_grupo_semestre,car.nombre carrera,car.id_carrera, tu_grupo_t.descripcion grupo, gnral_p.nombre nombre_tutor, gnral_p.tipo_usuario, 
                                ( (sum(gestion)*4)/ (COUNT(form.id_eva_resultado)*16) ) gestion , 
                                ( (sum(actitud)*4)/ (COUNT(form.id_eva_resultado)*28) ) actitud, 
                                ( (sum(disponibilidad_confianza)*4)/(COUNT(form.id_eva_resultado)*20) ) disponibilidad_confianza,
                                ( (sum(servicios_del_programa_de_tutoria)*4 )/( COUNT(form.id_eva_resultado)*24 ) )servicios_del_programa_de_tutoria,
                                ( (sum(tus_logros_y_avances)*4 )/( COUNT(form.id_eva_resultado)*36 ) ) tus_logros_y_avances
                                FROM tu_grupo_tutorias tu_grupo_t
                                INNER JOIN tu_grupo_semestre tu_grupo_s
                                ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                                INNER JOIN exp_asigna_tutor exp_asigna_t 
                                ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                                INNER JOIN gnral_personales gnral_p 
                                ON gnral_p.id_personal = exp_asigna_t.id_personal 
                                INNER JOIN gnral_jefes_periodos gnral_j 
                                ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_carreras car
                                ON car.id_carrera = gnral_j.id_carrera
                                INNER JOIN tu_eva_resultados_formulario form
                                ON form.id_asigna_tutor=exp_asigna_t.id_asigna_tutor
                                WHERE tu_grupo_s.id_grupo_semestre = '.$id_grupo_semestre.' and gnral_j.id_periodo ='.$periodo.' ');

        return view('tutorias.eva_tutorias.grafica_index',compact('datos') );
        //dd($datos);

    }

    public function resultados_cuestionario($id_grupo_semestre,$grupo,$carrera)
    {
        //dd($id_grupo_semestre);
        $periodo=Session::get('periodo_actual');

        $datos1 = DB::SELECTONE('SELECT exp_asigna_t.id_asigna_tutor
                                FROM tu_grupo_tutorias tu_grupo_t
                                INNER JOIN tu_grupo_semestre tu_grupo_s
                                ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                                INNER JOIN exp_asigna_tutor exp_asigna_t 
                                ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                                INNER JOIN gnral_personales gnral_p 
                                ON gnral_p.id_personal = exp_asigna_t.id_personal 
                                INNER JOIN gnral_jefes_periodos gnral_j 
                                ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_carreras car
                                ON car.id_carrera = gnral_j.id_carrera
                                WHERE tu_grupo_s.id_grupo_semestre = '.$id_grupo_semestre.' and gnral_j.id_periodo ='.$periodo.' ');

        $datos = DB::SELECT('SELECT * FROM tu_eva_autoevaluacion where  id_asigna_tutor = '.$datos1->id_asigna_tutor.' ');


        //$preguntas = DB::Select('SELECT * FROM tu_eva_formulario_tutor fo, tu_eva_cuestionario eva WHERE fo.id_eva_cuestionario=eva.id_eva_cuestionario and fo.id_asigna_tutor = '.$datos1->id_asigna_tutor.' ');
        $preguntas = DB::Select('SELECT * FROM tu_eva_formulario_tutor fo, tu_eva_cuestionario eva, tu_eva_calificacion_autoeva au WHERE fo.id_eva_cuestionario=eva.id_eva_cuestionario and au.id_calificacion = fo.calificacion  and fo.id_asigna_tutor = '.$datos1->id_asigna_tutor.' ');
        $con = DB::Selectone('SELECT count(*)  x FROM tu_eva_formulario_tutor fo, tu_eva_cuestionario eva, tu_eva_calificacion_autoeva au WHERE fo.id_eva_cuestionario=eva.id_eva_cuestionario and au.id_calificacion = fo.calificacion  and fo.id_asigna_tutor = '.$datos1->id_asigna_tutor.' ');

        //dd($preguntas);
        //dd($datos);
        //dd($con);
        if($con->x == 0)
        {
            return view('tutorias.eva_autoeva_tutor.sin_registro');
        }
        else
        {
            return view('tutorias.eva_autoeva_tutor.auto_eva_grafica',compact('datos','preguntas'));
        }

    }

    public function registro($id_asigna_generacion,$id_carrera)
    {
        $periodo=Session::get('periodo_actual');
        $alumnos_registro = DB::select('SELECT CONCAT(alumno.nombre," ",alumno.apaterno," ",alumno.amaterno) nombre, alumno.cuenta FROM gnral_alumnos alumno
                                        INNER JOIN exp_asigna_alumnos asigna
                                        ON asigna.id_alumno = alumno.id_alumno
                                        WHERE asigna.id_asigna_generacion = '.$id_asigna_generacion.' AND asigna.id_asigna_alumno NOT IN (SELECT id_asigna_alumno FROM tu_eva_resultados_formulario)');

        //dd($alumnos_registro);
        $tutor=DB::selectOne('SELECT gnral_personales.nombre, tu_grupo_tutorias.descripcion semestre 
                            from gnral_personales, exp_asigna_tutor, tu_grupo_semestre, tu_grupo_tutorias WHERE
                            gnral_personales.id_personal = exp_asigna_tutor.id_personal  and tu_grupo_semestre.id_asigna_tutor = exp_asigna_tutor.id_asigna_tutor 
                            and tu_grupo_semestre.id_grupo_tutorias = tu_grupo_tutorias.id_grupo_tutorias and exp_asigna_tutor.id_asigna_generacion='.$id_asigna_generacion.'');
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` ='.$id_carrera.'');
        return view('tutorias.eva_tutorias.registro_index',compact('alumnos_registro','tutor','carrera','id_carrera') );
    }

    public function tutores_sin_registro()
    {
        $periodo = Session::get('periodo_actual');

        $tutores = DB::SELECT('SELECT gnral_p.nombre nombre_tutor  FROM tu_grupo_tutorias tu_grupo_t
                                INNER JOIN tu_grupo_semestre tu_grupo_s
                                ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                                INNER JOIN exp_asigna_tutor exp_asigna_t 
                                ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                                INNER JOIN gnral_personales gnral_p 
                                ON gnral_p.id_personal = exp_asigna_t.id_personal 
                                INNER JOIN gnral_jefes_periodos gnral_j 
                                ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_carreras car
                                ON car.id_carrera = gnral_j.id_carrera
                                where gnral_j.id_periodo = '.$periodo.'  and exp_asigna_t.id_asigna_tutor  not in (Select id_asigna_tutor from tu_eva_autoevaluacion )
                                GROUP BY gnral_p.nombre');
        //dd($tutores);

        return view('tutorias.eva_autoeva_tutor.tutores_sin_registro',compact('tutores'));

    }


    public function periodos($id_grupo_semestre,$grupo,$carrera)
    {

        $periodo = Session::get('periodo_actual');

        $datos1 = DB::SELECTONE('SELECT tu_grupo_s.id_grupo_semestre,exp_asigna_t.id_personal, exp_asigna_t.id_asigna_tutor, gnral_p.nombre nombre_tutor, car.nombre carrera,tu_grupo_t.descripcion grupo, now() fecha, gnral_p.tipo_usuario
                                FROM tu_grupo_tutorias tu_grupo_t
                                INNER JOIN tu_grupo_semestre tu_grupo_s
                                ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                                INNER JOIN exp_asigna_tutor exp_asigna_t 
                                ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                                INNER JOIN gnral_personales gnral_p 
                                ON gnral_p.id_personal = exp_asigna_t.id_personal 
                                INNER JOIN gnral_jefes_periodos gnral_j 
                                ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_carreras car
                                ON car.id_carrera = gnral_j.id_carrera
                                WHERE tu_grupo_s.id_grupo_semestre = '.$id_grupo_semestre.' and gnral_j.id_periodo ='.$periodo.' ');
        $con_q = 'select count(*) con from tu_eva_fo17 where id_asigna_tutor = '.$datos1->id_asigna_tutor.' and per = 1 ';

        $con = DB::selectone($con_q);
        $con1 = $con->con;

        $id_usuario = Session::get('usuario_alumno');

        $id_usuario = Session::get('usuario_alumno');
        if ($id_usuario == $datos1->tipo_usuario )
            $igual = true;
        else
            $igual = false;

        return view('tutorias.eva_seguimiento_tu.periodos',compact('datos1','con1','igual'));


        //dd($grupo);
     /*   $periodo = Session::get('periodo_actual');
        //dd($periodo);

        $datos1 = DB::SELECTONE('SELECT tu_grupo_s.id_grupo_semestre,exp_asigna_t.id_personal, exp_asigna_t.id_asigna_tutor, gnral_p.nombre nombre_tutor, car.nombre carrera,tu_grupo_t.descripcion grupo, now() fecha
                                FROM tu_grupo_tutorias tu_grupo_t
                                INNER JOIN tu_grupo_semestre tu_grupo_s
                                ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                                INNER JOIN exp_asigna_tutor exp_asigna_t 
                                ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                                INNER JOIN gnral_personales gnral_p 
                                ON gnral_p.id_personal = exp_asigna_t.id_personal 
                                INNER JOIN gnral_jefes_periodos gnral_j 
                                ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_carreras car
                                ON car.id_carrera = gnral_j.id_carrera
                                WHERE tu_grupo_s.id_grupo_semestre = '.$id_grupo_semestre.' and gnral_j.id_periodo ='.$periodo.' ');

        $con_q = 'select count(*) con from tu_eva_fo17 where id_asigna_tutor = '.$datos1->id_asigna_tutor.' and per = 1 ';
        //dd($con_q);
        $con = DB::selectone($con_q);
        $con1 = $con->con;
        //dd($con1);

        $id_usuario = Session::get('usuario_alumno');
        //dd($id_usuario);

        $tutores = DB::SELECTONE('SELECT exp_asigna_t.id_asigna_tutor,exp_asigna_t.id_personal FROM tu_grupo_tutorias tu_grupo_t
                              INNER JOIN tu_grupo_semestre tu_grupo_s
                              ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                              INNER JOIN exp_asigna_tutor exp_asigna_t 
                              ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                              INNER JOIN gnral_personales gnral_p 
                              ON gnral_p.id_personal = exp_asigna_t.id_personal 
                              INNER JOIN gnral_jefes_periodos gnral_j 
                              ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                              INNER JOIN gnral_carreras car
                              ON car.id_carrera = gnral_j.id_carrera
                              WHERE gnral_j.id_periodo = '.$periodo.' AND gnral_p.tipo_usuario =  '.$id_usuario.'  ');

        //dd($tutores);

        if ($tutores->id_personal == $datos1->id_personal )
            $igual = true;
        else
            $igual = false;

        //dd($igual);


        //$igual = DB::Selectone('Select * from');

        //dd($datos1);
        return view('tutorias.eva_seguimiento_tu.periodos',compact('datos1','con1','igual'));
        //dd($id_grupo_semestre);*/
    }

    public function seguimiento($per,$id_grupo_semestre)
    {
        $id_usuario = Session::get('usuario_alumno');
        //dd($per);
        $periodo = Session::get('periodo_actual');
        //dd($periodo);
        //dd($id_grupo_semestre);

        // try {
        //     // $per_c = DB::SELECTONE('SELECT id_personal FROM `gnral_personales` WHERE tipo_usuario = '.$id_usuario.' ');
        //     // //dd($per_c);
        //     // $persona = DB::SELECTONE('SELECT cor.id_asigna_coordinador FROM tu_grupo_tutorias tu_grupo_t
        //     //                         INNER JOIN tu_grupo_semestre tu_grupo_s
        //     //                         ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
        //     //                         INNER JOIN exp_asigna_tutor exp_asigna_t
        //     //                         ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
        //     //                         INNER JOIN gnral_personales gnral_p
        //     //                         ON gnral_p.id_personal = exp_asigna_t.id_personal
        //     //                         INNER JOIN gnral_jefes_periodos gnral_j
        //     //                         ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
        //     //                         INNER JOIN gnral_carreras car
        //     //                         ON car.id_carrera = gnral_j.id_carrera
        //     //                         INNER JOIN 	exp_asigna_coordinador cor
        //     //                         ON cor.id_personal = gnral_p.id_personal
        //     //                         WHERE gnral_j.id_periodo = '.$periodo.' AND cor.id_personal = '.$per_c->id_personal.' ');
        //     // //dd($persona);
        //     $persona1 = $persona -> id_asigna_coordinador;
        // } catch (\Throwable $th) {
        //     $persona1 = 0;
        // }
        // $per_c = DB::SELECTONE('SELECT id_personal FROM `gnral_personales` WHERE tipo_usuario = '.$id_usuario.' ');
        // //dd($per_c);
        // $persona = DB::SELECTONE('SELECT cor.id_asigna_coordinador FROM tu_grupo_tutorias tu_grupo_t
        //                         INNER JOIN tu_grupo_semestre tu_grupo_s
        //                         ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
        //                         INNER JOIN exp_asigna_tutor exp_asigna_t
        //                         ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
        //                         INNER JOIN gnral_personales gnral_p
        //                         ON gnral_p.id_personal = exp_asigna_t.id_personal
        //                         INNER JOIN gnral_jefes_periodos gnral_j
        //                         ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
        //                         INNER JOIN gnral_carreras car
        //                         ON car.id_carrera = gnral_j.id_carrera
        //                         INNER JOIN 	exp_asigna_coordinador cor
        //                         ON cor.id_personal = gnral_p.id_personal
        //                         WHERE gnral_j.id_periodo = '.$periodo.' AND cor.id_personal = '.$per_c->id_personal.' ');
        // //dd($persona);

        $datos1 = DB::SELECTONE('SELECT exp_asigna_t.id_asigna_tutor, gnral_p.nombre nombre_tutor, car.nombre carrera,tu_grupo_t.descripcion grupo, now() fecha, year(now()) ano, month(now()) mes, day(now()) dia
                                FROM tu_grupo_tutorias tu_grupo_t
                                INNER JOIN tu_grupo_semestre tu_grupo_s
                                ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                                INNER JOIN exp_asigna_tutor exp_asigna_t 
                                ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                                INNER JOIN gnral_personales gnral_p 
                                ON gnral_p.id_personal = exp_asigna_t.id_personal 
                                INNER JOIN gnral_jefes_periodos gnral_j 
                                ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_carreras car
                                ON car.id_carrera = gnral_j.id_carrera
                                WHERE tu_grupo_s.id_grupo_semestre = '.$id_grupo_semestre.' and gnral_j.id_periodo ='.$periodo.' ');
        //dd($datos1);
        $con_q = 'select count(*) con from tu_eva_fo17 where id_asigna_tutor = '.$datos1->id_asigna_tutor.' and per = '.$per.' ';
        //dd($con_q);
        $con = DB::selectone($con_q);
        //dd($con);
        //dd("hola 1");
        if ($con->con == 0) {
            //dd('0');
            return view('tutorias.eva_seguimiento_tu.formato17',compact('datos1','per'));
        }
        else
        {
            //dd('2');
            $res = DB::selectone('select  id_fo17,id_asigna_tutor,per,IF(experiencia=1,"Si","No") experiencia,anos_tutor, IF(planeacion=1,"Si","No") planeacion,com_planeacion,fecha_establecida,fecha_final,(
                CASE 
                    WHEN tu.pregunta1 = 1 THEN "Mala"
                    WHEN tu.pregunta1 = 2 THEN "Regular"
                    WHEN tu.pregunta1 = 3 THEN "Buena"
                    WHEN tu.pregunta1 = 4 THEN "Muy buena"
                    WHEN tu.pregunta1 = 5 THEN "Excelente"
                END) pregunta1,
                (CASE 
                    WHEN tu.pregunta2 = 1 THEN "Mala"
                    WHEN tu.pregunta2 = 2 THEN "Regular"
                    WHEN tu.pregunta2 = 3 THEN "Buena"
                    WHEN tu.pregunta2 = 4 THEN "Muy buena"
                    WHEN tu.pregunta2 = 5 THEN "Excelente"
                END)pregunta2,
                (CASE 
                    WHEN tu.pregunta3 = 1 THEN "Mala"
                    WHEN tu.pregunta3 = 2 THEN "Regular"
                    WHEN tu.pregunta3 = 3 THEN "Buena"
                    WHEN tu.pregunta3 = 4 THEN "Muy buena"
                    WHEN tu.pregunta3 = 5 THEN "Excelente"
                END)pregunta3,
                (CASE 
                    WHEN tu.pregunta4 = 1 THEN "Mala"
                    WHEN tu.pregunta4 = 2 THEN "Regular"
                    WHEN tu.pregunta4 = 3 THEN "Buena"
                    WHEN tu.pregunta4 = 4 THEN "Muy buena"
                    WHEN tu.pregunta4 = 5 THEN "Excelente"
                END)pregunta4,
                (CASE
                    WHEN tu.pregunta5 = 1 THEN "Mala"
                    WHEN tu.pregunta5 = 2 THEN "Regular"
                    WHEN tu.pregunta5 = 3 THEN "Buena"
                    WHEN tu.pregunta5 = 4 THEN "Muy buena"
                    WHEN tu.pregunta5 = 5 THEN "Excelente"
                END)pregunta5,
                (CASE 
                    WHEN tu.pregunta6 = 1 THEN "Mala"
                    WHEN tu.pregunta6 = 2 THEN "Regular"
                    WHEN tu.pregunta6 = 3 THEN "Buena"
                    WHEN tu.pregunta6 = 4 THEN "Muy buena"
                    WHEN tu.pregunta6 = 5 THEN "Excelente"
                END)pregunta6,
                (CASE 
                    WHEN tu.pregunta7 = 1 THEN "Mala"
                    WHEN tu.pregunta7 = 2 THEN "Regular"
                    WHEN tu.pregunta7 = 3 THEN "Buena"
                    WHEN tu.pregunta7 = 4 THEN "Muy buena"
                    WHEN tu.pregunta7 = 5 THEN "Excelente"
                END)pregunta7,
                (CASE 
                    WHEN tu.pregunta8 = 1 THEN "Mala"
                    WHEN tu.pregunta8 = 2 THEN "Regular"
                    WHEN tu.pregunta8 = 3 THEN "Buena"
                    WHEN tu.pregunta8 = 4 THEN "Muy buena"
                    WHEN tu.pregunta8 = 5 THEN "Excelente"
                END)pregunta8,
                (CASE 
                    WHEN tu.pregunta9 = 1 THEN "Mala"
                    WHEN tu.pregunta9 = 2 THEN "Regular"
                    WHEN tu.pregunta9 = 3 THEN "Buena"
                    WHEN tu.pregunta9 = 4 THEN "Muy buena"
                    WHEN tu.pregunta9 = 5 THEN "Excelente"
                END)pregunta9,
                (CASE 
                    WHEN tu.pregunta10= 1 THEN "Mala"
                    WHEN tu.pregunta10 = 2 THEN "Regular"
                    WHEN tu.pregunta10 = 3 THEN "Buena"
                    WHEN tu.pregunta10 = 4 THEN "Muy buena"
                    WHEN tu.pregunta10 = 5 THEN "Excelente"
                END)pregunta10,
                comentario,fecha_registro  from tu_eva_fo17 tu where id_asigna_tutor = '.$datos1->id_asigna_tutor.' and per = '.$per.' ');
            /// id_fo17,id_asigna_tutor,id_asigna_cordinador,per,IF(experiencia=1,"Si","No") experiencia,anos_tutor, IF(planeacion=1,"Si","No") planeacion,com_planeacion,fecha_establecida,fecha_final,pregunta1,pregunta2,pregunta3,pregunta4,pregunta5,pregunta6,pregunta7,pregunta8,pregunta9,pregunta10,comentario,fecha_registro

            //dd($res);

            return view('tutorias.eva_seguimiento_tu.resultado',compact('res','datos1'));
        }
        //dd($datos1);

    }
    public function seguimiento_guarda(Request $request)
    {

        //dd($request);
        $this->validate($request,[
            "id_tiempo" => 'required',
            "anos" => 'required',
            "planeacion" => 'required',
            "ano_es" => 'required',
            "mes_es" => 'required',
            "dia_es" => 'required',
            "ano_re" => 'required',
            "mes_re" => 'required',
            "dia_re" => 'required',
            "pregunta1" => 'required',
            "pregunta2" => 'required',
            "pregunta3" => 'required',
            "pregunta4" => 'required',
            "pregunta5" => 'required',
            "pregunta6" => 'required',
            "pregunta7" => 'required',
            "pregunta8" => 'required',
            "pregunta9" => 'required',
            "pregunta10" => 'required',
        ]);

        // INSERT INTO tu_eva_fo17 VALUES
        // (NULL, {$request->id_asigna_tutor}, {$request->id_cordinador},
        // $request->per}, {$request->id_tiempo}, {$request->anos} ,
        // {$request->planeacion}, ' ' ,
        //  STR_TO_DATE('10 1 1000', '%d %m %Y'),
        //  STR_TO_DATE('20 2 2000', '%d %m %Y') ,
        // '5' , '5',
        // '5' , '5','5' ,
        // '5','5' , '5',
        // '5' , '5','com',now() )

        $query = ("  INSERT INTO tu_eva_fo17 VALUES 
        (NULL, {$request->id_asigna_tutor}, 
        '{$request->per}', '{$request->id_tiempo}', '{$request->anos}' , 
        '{$request->planeacion}', ' ' , 
        STR_TO_DATE('{$request->dia_es} {$request->mes_es} {$request->ano_es}','%d %m %Y'),
        STR_TO_DATE('{$request->dia_re} {$request->mes_re} {$request->ano_re}','%d %m %Y') , 
        '{$request->pregunta1}' , '{$request->pregunta2}',
        '{$request->pregunta3}' , '{$request->pregunta4}','{$request->pregunta5}' , 
        '{$request->pregunta6}','{$request->pregunta7}' , '{$request->pregunta8}',
        '{$request->pregunta9}' , '{$request->pregunta10}','{$request->comentarios}',now() ) ");

        //dd($query);

        DB::Insert($query);

        $con_q = 'select planeacion from tu_eva_fo17 where id_asigna_tutor = '.$request->id_asigna_tutor.' and per = '.$request->per.' ';
        //dd($con_q);
        $con = DB::selectone($con_q);
        //dd($con->planeacion);

        if ( $con->planeacion == 1 ) {
            //dd('1');
            return redirect()->back();
        }
        else
        {
            $come = DB::selectone('select * from tu_eva_fo17 where id_asigna_tutor = '.$request->id_asigna_tutor.' and per = '.$request->per.' ');
            return view('tutorias.eva_seguimiento_tu.com',compact('come'));
        }


    }
    public function com(Request $request)
    {
        $this->validate($request,[
            "comentarios" => 'required',
        ]);
        //dd($request);
        $query = "UPDATE tu_eva_fo17 SET com_planeacion = '{$request->comentarios}' WHERE per = {$request->per} and id_asigna_tutor = {$request->id_asigna_tutor} ";
        //dd($query);
        DB::UPDATE($query);

        return redirect('/tutoras_evaluacion/resultado_tutorias_jefe/');
    }

    public function imprime($per,$id_grupo_semestre)
    {
        dd($per);
    }

}

