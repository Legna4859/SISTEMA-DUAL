<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eva_Tutor;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Storage;
use Session;

class Tu_Eva_TutorController extends Controller
{
    public function index()
    {
        $id_usuario = Session::get('usuario_alumno');
        //dd($id_usuario);
        $periodo=Session::get('periodo_actual');
        //dd($periodo);

        $tutores = DB::SELECT('SELECT tu_grupo_s.id_grupo_semestre,car.nombre carrera, tu_grupo_t.descripcion grupo FROM tu_grupo_tutorias tu_grupo_t
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

        return view('tutorias.eva_tutorias.tutores_index',compact('tutores') );
    }
    public function grafica($id_grupo_semestre)
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
    public function auto_evaluacion()
    {
        $id_usuario = Session::get('usuario_alumno');
        //dd($id_usuario);
        $periodo=Session::get('periodo_actual');
        //dd($periodo);

        $tutores = DB::SELECTONE('SELECT exp_asigna_t.id_asigna_tutor FROM tu_grupo_tutorias tu_grupo_t
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

        $query = "SELECT COUNT(*) x FROM tu_eva_autoevaluacion WHERE id_asigna_tutor = {$tutores->id_asigna_tutor}";
        
        //dd($query);
        $existencia = DB::SELECTONE($query);
        //dd($existencia);
        $estado1 = $existencia->x;
        if($estado1 == 0)
        {
            return view('tutorias.eva_autoeva_tutor.auto_evaluacion_tutor',compact('tutores') );
        }
        else
        {
            $datos = DB::SELECT('SELECT * FROM tu_eva_autoevaluacion where  id_asigna_tutor = '.$tutores->id_asigna_tutor.' ');

            $preguntas = DB::Select('SELECT * FROM tu_eva_formulario_tutor fo, tu_eva_cuestionario eva, tu_eva_calificacion_autoeva au WHERE fo.id_eva_cuestionario=eva.id_eva_cuestionario and au.id_calificacion = fo.calificacion  and fo.id_asigna_tutor = '.$tutores->id_asigna_tutor.' ');
            //dd('hola');
            return view('tutorias.eva_autoeva_tutor.auto_eva_grafica',compact('datos','preguntas'));

            //return view('tutorias.eva_tutorias.encuesta_realizada');
        }

        
    } 
    public function inserta_valor_uno(Request $request)
    {
        //dd($request);
        $this->validate($request,[
            'secion1_pregunta1'=>'required',
            'secion1_pregunta2'=>'required',
            'secion1_pregunta3'=>'required',
            'secion1_pregunta4'=>'required',
            'secion1_pregunta5'=>'required',
            'secion1_pregunta6'=>'required',
            'secion1_pregunta7'=>'required',
            'secion1_pregunta8'=>'required',
            'secion1_pregunta9'=>'required',
            'secion1_pregunta10'=>'required',
        ]);
        //dd($request);

        $satisfacion = $request->secion1_pregunta1 + $request->secion1_pregunta2 + $request->secion1_pregunta3 + $request->secion1_pregunta4  + $request->secion1_pregunta5 + $request->secion1_pregunta6 + $request->secion1_pregunta7 + $request->secion1_pregunta8 + $request->secion1_pregunta9 + $request->secion1_pregunta10; 
        $resultado_satisfacion = ($satisfacion * 4)/40;
        
        //dd($resultado_satisfacion);
        $query = "INSERT INTO tu_eva_autoevaluacion VALUES( NULL, now(),{$request->id_asigna_tutor},{$request->id_tiempo},{$resultado_satisfacion}, 0, 0,' ')";
        //dd($query);
        
        DB::INSERT($query);

        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '1', '{$request->secion1_pregunta1}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '2', '{$request->secion1_pregunta2}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '3', '{$request->secion1_pregunta3}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '4', '{$request->secion1_pregunta4}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '5', '{$request->secion1_pregunta5}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '6', '{$request->secion1_pregunta6}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '7', '{$request->secion1_pregunta7}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '8', '{$request->secion1_pregunta8}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '9', '{$request->secion1_pregunta9}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '10', '{$request->secion1_pregunta10}') ");

        return redirect('/tutoras_evaluacion/auto_eveluacion/dos/');
    }
    public function auto_evaluacion2()
    {
        
        $id_usuario = Session::get('usuario_alumno');
        //dd($id_usuario);
        $periodo=Session::get('periodo_actual');
        //dd($periodo);

        $tutores = DB::SELECTONE('SELECT exp_asigna_t.id_asigna_tutor FROM tu_grupo_tutorias tu_grupo_t
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

        return view('tutorias.eva_autoeva_tutor.auto_evaluacion2',compact('tutores') );
    }

    

    public function inserta_valor_dos(Request $request)
    {
        $this->validate($request,[
            'secion2_pregunta1'=>'required',
            'secion2_pregunta2'=>'required',
            'secion2_pregunta3'=>'required',
            'secion2_pregunta4'=>'required',
            'secion2_pregunta5'=>'required',
            'secion3_pregunta1'=>'required',
            'secion3_pregunta2'=>'required',
            'secion3_pregunta3'=>'required',
            'secion3_pregunta4'=>'required',
            'secion3_pregunta5'=>'required',
            'secion3_pregunta6'=>'required',
            'secion3_pregunta7'=>'required',
            'secion3_pregunta8'=>'required',
            'secion3_pregunta9'=>'required',
        ]);
        //dd($request);
        
        $necesidades = ($request->secion2_pregunta1 + $request->secion2_pregunta2 + $request->secion2_pregunta3 + $request->secion2_pregunta4 + $request->secion2_pregunta5);
        $resultado_necesidades = ($necesidades*4)/20;
        //dd($resultado_necesidades);
        $factores = ($request->secion3_pregunta1 + $request->secion3_pregunta2 + $request->secion3_pregunta3 + $request->secion3_pregunta4 + $request->secion3_pregunta5 + $request->secion3_pregunta6 + $request->secion3_pregunta7 + $request->secion3_pregunta8 + $request->secion3_pregunta9);
        $resultado_factores = ($factores*4)/36; 
        //dd($resultado_factores);
        //$query = " UPDATE tu_eva_autoevaluacion SET necesidades = {$resultado_necesidades} and factores = {$resultado_factores} and comentario = " {$request->comentarios} " WHERE id_asigna_tutor  =  {$request->id_asigna_tutor} ";
        $query2 = "UPDATE tu_eva_autoevaluacion SET necesidades = {$resultado_necesidades}, factores = {$resultado_factores}, comentario = '{$request->comentarios}' WHERE id_asigna_tutor  =  {$request->id_asigna_tutor} "; 
        //dd($query2);
        
        DB::UPDATE($query2);
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '11', '{$request->secion2_pregunta1}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '12', '{$request->secion2_pregunta2}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '13', '{$request->secion2_pregunta3}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '14', '{$request->secion2_pregunta4}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '15', '{$request->secion2_pregunta5}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '16', '{$request->secion3_pregunta1}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '17', '{$request->secion3_pregunta2}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '18', '{$request->secion3_pregunta3}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '19', '{$request->secion3_pregunta4}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '20', '{$request->secion3_pregunta5}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '21', '{$request->secion3_pregunta6}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '22', '{$request->secion3_pregunta7}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '23', '{$request->secion3_pregunta8}') ");
        DB::Insert("  INSERT INTO tu_eva_formulario_tutor VALUES (NULL, now(), '{$request->id_asigna_tutor}', '24', '{$request->secion3_pregunta9}') ");
        
       $estado_com = DB::Select(" Select * from tu_eva_formulario_tutor where id_asigna_tutor =  '{$request->id_asigna_tutor}' ");
       
       //dd($estado_com);
       
       //foreach
       
       
       $val = false;
       $preguntas_r = DB::select("select * from tu_eva_formulario_tutor where id_asigna_tutor = '{$request->id_asigna_tutor}' ");
       //dd($preguntas_r);
       foreach($preguntas_r as $pre)
       {
            if($pre->calificacion <= 2 )
            {
                $val = true;
            }
       }
        //dd($val);

       if($val === true){
        $id_usuario = Session::get('usuario_alumno');
        //dd($id_usuario);
        $periodo=Session::get('periodo_actual');
        //dd($periodo);

        $tutores = DB::SELECTONE('SELECT exp_asigna_t.id_asigna_tutor FROM tu_grupo_tutorias tu_grupo_t
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

        return view('tutorias.eva_autoeva_tutor.comentario',compact('tutores') );
       }
       else{
            return redirect('/tutorias/');
       } 
    }
    public function comentario(Request $request)
    {
        $this->validate($request,[
            'comentario'
        ]);
        //dd($request);
        $query2 = "UPDATE tu_eva_autoevaluacion SET comentario = '{$request->comentario}' WHERE id_asigna_tutor  =  {$request->id_asigna_tutor} "; 
        
        //dd($query2);
        DB::UPDATE($query2);

        return redirect('/tutorias/');
    }
}
