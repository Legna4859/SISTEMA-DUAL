<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eva_Tutor;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Storage;
use Session;

class Tu_Eva_AlumnosController extends Controller
{
    public function index()
    {
        $usuario = Session::get('usuario');
        //dd($usuario);
        $periodo=Session::get('periodo_actual');
        //dd($periodo);
        $id_usuario = Session::get('usuario_alumno');

        $alumno = DB::selectOne('SELECT gnral_a.id_alumno,gnral_a.nombre nombre_alumno,gnral_a.apaterno,gnral_a.amaterno,gnral_a.cuenta, gnral_p.id_personal,gnral_p.nombre nombre_profesor,exp_asigna_t.id_asigna_tutor, exp_as_a.id_asigna_alumno,exp_asigna_gen.id_asigna_generacion
                                FROM gnral_alumnos gnral_a
                                INNER JOIN exp_asigna_alumnos exp_as_a
                                ON gnral_a.id_alumno=exp_as_a.id_alumno
                                INNER JOIN exp_asigna_generacion exp_asigna_gen
                                ON exp_asigna_gen.id_asigna_generacion = exp_as_a.id_asigna_generacion
                                INNER JOIN exp_asigna_tutor exp_asigna_t
                                ON exp_asigna_t.id_asigna_generacion=exp_asigna_gen.id_asigna_generacion
                                INNER JOIN gnral_jefes_periodos gnral_je
                                ON gnral_je.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_personales gnral_p
                                ON gnral_p.id_personal = exp_asigna_t.id_personal
                                WHERE gnral_je.id_periodo = '.$periodo.' AND gnral_a.id_usuario = '.$id_usuario.' ');
        //dd($alumno);

        $estado_eva = DB::selectOne('SELECT COUNT(id_asigna_alumno) x FROM tu_eva_resultados_formulario WHERE id_asigna_alumno = '.$alumno->id_asigna_alumno.' AND id_asigna_tutor = '.$alumno->id_asigna_tutor.' ');
        //dd($estado_eva );
        $estado1 = 0;
        foreach($estado_eva as $estado):

            $estado1 =  $estado;

            endforeach;
        //dd($estado1);

        //dd($estado1);
        switch ($estado1)
        {
            case 0:
                return view('tutorias.eva_tutorias.alumnos_index',compact('alumno','estado_eva'));
                break;
            case 1:
                return view('tutorias.eva_tutorias.encuesta_realizada');
                $message = "Evaluacion realizada";
               /* echo "<script type='text/javascript'>
                            alert('$message');
                            window.location.href ='http://127.0.0.1:8000/tutorias/inicioalu';//cambiar a la pagina del tec 
                      </script>" ;*/
                break;
        }

        /*if ($estado_eva == 1)
        {

            //return back();
        }
        else
        {
            return view('tutorias.eva_tutorias.alumnos_index',compact('alumno','estado_eva'));
            //return view('/home');
        }*/

    }
    public function inserta_valor(Request $request)
    {
        $this->validate($request,[

            'secion1_pregunta1'=>'required',
            'secion1_pregunta2'=>'required',
            'secion1_pregunta3'=>'required',
            'secion1_pregunta4'=>'required',
            'secion2_pregunta1'=>'required',
            'secion2_pregunta2'=>'required',
            'secion2_pregunta3'=>'required',
            'secion2_pregunta4'=>'required',
            'secion2_pregunta5'=>'required',
            'secion2_pregunta6'=>'required',
            'secion2_pregunta7'=>'required',
            'secion3_pregunta1'=>'required',
            'secion3_pregunta2'=>'required',
            'secion3_pregunta4'=>'required',
            'secion3_pregunta5'=>'required',
            'secion4_pregunta1'=>'required',
            'secion4_pregunta2'=>'required',
            'secion4_pregunta3'=>'required',
            'secion4_pregunta4'=>'required',
            'secion4_pregunta5'=>'required',
            'secion4_pregunta6'=>'required',
            'secion5_pregunta1'=>'required',
            'secion5_pregunta2'=>'required',
            'secion5_pregunta3'=>'required',
            'secion5_pregunta4'=>'required',
            'secion5_pregunta5'=>'required',
            'secion5_pregunta6'=>'required',
            'secion5_pregunta7'=>'required',
            'secion5_pregunta8'=>'required',
            'secion5_pregunta9'=>'required',
        ]);
        ///Tabla tu_eva_resultados_formulario
        $gestion = $request->secion1_pregunta1 + $request->secion1_pregunta2 + $request->secion1_pregunta3 + $request->secion1_pregunta4;
        $actitud = $request->secion2_pregunta1 + $request->secion2_pregunta2 + $request->secion2_pregunta3 + $request->secion2_pregunta4 + $request->secion2_pregunta5 + $request->secion2_pregunta6 + $request->secion2_pregunta7;
        $disponibilidad_confianza = $request->secion3_pregunta1 + $request->secion3_pregunta2 + $request->secion3_pregunta3 + $request->secion3_pregunta4 + $request->secion3_pregunta5;
        $servicios_del_programa_de_tutoria = $request->secion4_pregunta1 + $request->secion4_pregunta2 + $request->secion4_pregunta3 + $request->secion4_pregunta4 + $request->secion4_pregunta5 + $request->secion4_pregunta6;
        $tus_logros_y_avances = $request->secion5_pregunta1 + $request->secion5_pregunta2 + $request->secion5_pregunta3 + $request->secion5_pregunta4 + $request->secion5_pregunta5 + $request->secion5_pregunta6 + $request->secion5_pregunta7 + $request->secion5_pregunta8 + $request->secion5_pregunta9;

        DB::INSERT('INSERT INTO tu_eva_resultados_formulario VALUES(0,'.$request->id_asigna_alumno.','.$request->id_asigna_tutor.',now(),'.$gestion.','.$actitud.', '.$disponibilidad_confianza.', '.$servicios_del_programa_de_tutoria.','.$tus_logros_y_avances.',"'.$request->comentarios.'")');
        //dd('hola1');
        //return view('/tutoras_evaluacion/evaluacion_al_tutor_dos/');
        return redirect('/tutoras_evaluacion/evaluacion_al_tutor');
        ///echo "<script type='text/javascript'>
           ///          window.location.href ='http://127.0.0.1:8000/tutorias/inicioalu';//cambiar a la pagina del tec
              ///</script>" ;
        //dd($request);

        //DB::update('');
    }

    /*public function index_uno()
    {
        $usuario = Session::get('usuario');
        //dd($usuario);
        $periodo=Session::get('periodo_actual');
        //dd($periodo);
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::selectOne('SELECT gnral_a.id_alumno,gnral_a.nombre nombre_alumno,gnral_a.apaterno,gnral_a.amaterno,gnral_a.cuenta, gnral_p.id_personal,gnral_p.nombre nombre_profesor,exp_asigna_t.id_asigna_tutor, exp_as_a.id_asigna_alumno,exp_asigna_gen.id_asigna_generacion
                                FROM gnral_alumnos gnral_a
                                INNER JOIN exp_asigna_alumnos exp_as_a
                                ON gnral_a.id_alumno=exp_as_a.id_alumno
                                INNER JOIN exp_asigna_generacion exp_asigna_gen
                                ON exp_asigna_gen.id_asigna_generacion = exp_as_a.id_asigna_generacion
                                INNER JOIN exp_asigna_tutor exp_asigna_t
                                ON exp_asigna_t.id_asigna_generacion=exp_asigna_gen.id_asigna_generacion
                                INNER JOIN gnral_jefes_periodos gnral_je
                                ON gnral_je.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_personales gnral_p
                                ON gnral_p.id_personal = exp_asigna_t.id_personal
                                WHERE gnral_je.id_periodo = '.$periodo.' AND gnral_a.id_usuario = '.$id_usuario.' ');
        //dd($alumno);

        $estado_eva = DB::selectOne('SELECT COUNT(id_asigna_alumno) x FROM tu_eva_resultados_formulario WHERE id_asigna_alumno = '.$alumno->id_asigna_alumno.' AND id_asigna_tutor = '.$alumno->id_asigna_tutor.' ');

        $estado1 = $estado_eva->x;

       if($estado1 ==0){
           return view('tutorias.eva_tutorias.alumnos_index_uno',compact('alumno'));

       }
            else{
                $message = "Evaluacion realizada";

                return view('tutorias.eva_tutorias.encuesta_realizada');
            }



        return redirect('/tutorias/');
    }

   */ public function inserta_valor_uno(Request $request)
    {
        $this->validate($request,[
            'secion1_pregunta1'=>'required',
            'secion1_pregunta2'=>'required',
            'secion1_pregunta3'=>'required',
            'secion1_pregunta4'=>'required',
            'secion2_pregunta1'=>'required',
            'secion2_pregunta2'=>'required',
            'secion2_pregunta3'=>'required',
            'secion2_pregunta4'=>'required',
            'secion2_pregunta5'=>'required',
            'secion2_pregunta6'=>'required',
            'secion2_pregunta7'=>'required',
        ]);
        //dd($request);
        $gestion = $request->secion1_pregunta1 + $request->secion1_pregunta2 + $request->secion1_pregunta3 + $request->secion1_pregunta4;
        $actitud = $request->secion2_pregunta1 + $request->secion2_pregunta2 + $request->secion2_pregunta3 + $request->secion2_pregunta4 + $request->secion2_pregunta5 + $request->secion2_pregunta6 + $request->secion2_pregunta7;
        $disponibilidad_confianza = 0;
        $servicios_del_programa_de_tutoria = 0;
        $tus_logros_y_avances = 0;
        //dd($gestion);

        DB::INSERT('INSERT INTO tu_eva_resultados_formulario VALUES(0,'.$request->id_asigna_alumno.','.$request->id_asigna_tutor.',now(),'.$gestion.','.$actitud.','.$disponibilidad_confianza.', '.$servicios_del_programa_de_tutoria.','.$tus_logros_y_avances.',"'.$request->comentarios.'")');

        return redirect('/tutoras_evaluacion/evaluacion_al_tutor/dos/');
    }

    public function index_dos()
    {
        $usuario = Session::get('usuario');
        //dd($usuario);
        $periodo=Session::get('periodo_actual');
        //dd($periodo);
        $id_usuario = Session::get('usuario_alumno');

        $alumno = DB::selectOne('SELECT gnral_a.id_alumno,gnral_a.nombre nombre_alumno,gnral_a.apaterno,gnral_a.amaterno,gnral_a.cuenta, gnral_p.id_personal,gnral_p.nombre nombre_profesor,exp_asigna_t.id_asigna_tutor, exp_as_a.id_asigna_alumno,exp_asigna_gen.id_asigna_generacion
                                FROM gnral_alumnos gnral_a
                                INNER JOIN exp_asigna_alumnos exp_as_a
                                ON gnral_a.id_alumno=exp_as_a.id_alumno
                                INNER JOIN exp_asigna_generacion exp_asigna_gen
                                ON exp_asigna_gen.id_asigna_generacion = exp_as_a.id_asigna_generacion
                                INNER JOIN exp_asigna_tutor exp_asigna_t
                                ON exp_asigna_t.id_asigna_generacion=exp_asigna_gen.id_asigna_generacion
                                INNER JOIN gnral_jefes_periodos gnral_je
                                ON gnral_je.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_personales gnral_p
                                ON gnral_p.id_personal = exp_asigna_t.id_personal
                                WHERE gnral_je.id_periodo = '.$periodo.' AND gnral_a.id_usuario = '.$id_usuario.' ');
        //dd($alumno);

        return view('tutorias.eva_tutorias.alumnos_index_dos',compact('alumno'));
    }

    public function inserta_valor_dos(Request $request)
    {
        $this->validate($request,[
            'secion3_pregunta1'=>'required',
            'secion3_pregunta2'=>'required',
            'secion3_pregunta4'=>'required',
            'secion3_pregunta5'=>'required',
            'secion4_pregunta1'=>'required',
            'secion4_pregunta2'=>'required',
            'secion4_pregunta3'=>'required',
            'secion4_pregunta4'=>'required',
            'secion4_pregunta5'=>'required',
            'secion4_pregunta6'=>'required',
        ]);
        //dd($request);
        $disponibilidad_confianza = $request->secion3_pregunta1 + $request->secion3_pregunta2 + $request->secion3_pregunta3 + $request->secion3_pregunta4 + $request->secion3_pregunta5;
        $servicios_del_programa_de_tutoria = $request->secion4_pregunta1 + $request->secion4_pregunta2 + $request->secion4_pregunta3 + $request->secion4_pregunta4 + $request->secion4_pregunta5 + $request->secion4_pregunta6;
        //dd($disponibilidad_confianza);

        DB::update('UPDATE tu_eva_resultados_formulario SET disponibilidad_confianza = '.$disponibilidad_confianza.', servicios_del_programa_de_tutoria = '.$servicios_del_programa_de_tutoria.' WHERE id_asigna_alumno = '.$request->id_asigna_alumno.' and id_asigna_tutor = '.$request->id_asigna_tutor.'; ');//primer modificacion

        return redirect('/tutoras_evaluacion/evaluacion_al_tutor/tres/');
    }

    public function index_tres()
    {
        $usuario = Session::get('usuario');
        //dd($usuario);
        $periodo=Session::get('periodo_actual');
        //dd($periodo);
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::selectOne('SELECT gnral_a.id_alumno,gnral_a.nombre nombre_alumno,gnral_a.apaterno,gnral_a.amaterno,gnral_a.cuenta, gnral_p.id_personal,gnral_p.nombre nombre_profesor,exp_asigna_t.id_asigna_tutor, exp_as_a.id_asigna_alumno,exp_asigna_gen.id_asigna_generacion
                                FROM gnral_alumnos gnral_a
                                INNER JOIN exp_asigna_alumnos exp_as_a
                                ON gnral_a.id_alumno=exp_as_a.id_alumno
                                INNER JOIN exp_asigna_generacion exp_asigna_gen
                                ON exp_asigna_gen.id_asigna_generacion = exp_as_a.id_asigna_generacion
                                INNER JOIN exp_asigna_tutor exp_asigna_t
                                ON exp_asigna_t.id_asigna_generacion=exp_asigna_gen.id_asigna_generacion
                                INNER JOIN gnral_jefes_periodos gnral_je
                                ON gnral_je.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_personales gnral_p
                                ON gnral_p.id_personal = exp_asigna_t.id_personal
                                WHERE gnral_je.id_periodo = '.$periodo.' AND gnral_a.id_usuario = '.$id_usuario.' ');
        //dd($alumno);

        return view('tutorias.eva_tutorias.alumnos_index_tres',compact('alumno'));
    }

    public function inserta_valor_tres(Request $request)
    {
        $this->validate($request,[
            'secion5_pregunta1'=>'required',
            'secion5_pregunta2'=>'required',
            'secion5_pregunta3'=>'required',
            'secion5_pregunta4'=>'required',
            'secion5_pregunta5'=>'required',
            'secion5_pregunta6'=>'required',
            'secion5_pregunta7'=>'required',
            'secion5_pregunta8'=>'required',
            'secion5_pregunta9'=>'required',
        ]);
        //dd($request);
        $tus_logros_y_avances = $request->secion5_pregunta1 + $request->secion5_pregunta2 + $request->secion5_pregunta3 + $request->secion5_pregunta4 + $request->secion5_pregunta5 + $request->secion5_pregunta6 + $request->secion5_pregunta7 + $request->secion5_pregunta8 + $request->secion5_pregunta9;
        //dd($tus_logros_y_avances);

        DB::update('UPDATE tu_eva_resultados_formulario SET tus_logros_y_avances = '.$tus_logros_y_avances.', comentario = "'.$request->comentarios.'" WHERE id_asigna_alumno = '.$request->id_asigna_alumno.' and id_asigna_tutor = '.$request->id_asigna_tutor.' ');

       return redirect('/tutorias/');
    }

}
