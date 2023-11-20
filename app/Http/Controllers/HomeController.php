<?php

namespace App\Http\Controllers;

use App\AudAuditorAuditoria;
use App\AudAuditorias;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // sistema de tutorias
        Session::put('sistemas_tutorias',false);
        //
        $ip=url("/");
        //$ip=$ip="127.0.0.1:800"?"localhost"
        Session::put('ip',$ip);
        Session::put('usuario_alumno',Auth::user()->id);

        $id_usuario = Session::get('usuario_alumno');

        $tipo = Auth::user()->tipo_usuario;
        $info = Auth::user()->info_ok;
        $id_alumno = Auth::user()->id;

        $correo = Auth::user()->email;

        $añoactual=DB::selectOne('select year(now()) year');
        $año=$añoactual->year;
        $mesactual=DB::selectOne('select month(now()) mes');
        $mes=$mesactual->mes;

        if($mes==1||$mes==2)
        {
            $año=($año-1);
        }
        if($mes==1||$mes==2||$mes==9||$mes==10||$mes==11||$mes==12)
        {

            $mes=9;

        }
        else
        {

            $mes=3;
        }
        ////periodos de ingles
        $fecha_hoy=date("Y-m-d ");
        Session::put('periodos_ingles',$periodos_ingles=DB::select('SELECT * FROM in_periodos'));
        $periodo_ingles=DB::selectOne("SELECT * FROM in_periodos WHERE '$fecha_hoy' BETWEEN 	fecha_inicial_periodo AND fecha_final_periodo");
        Session::put('periodo_ingles',$periodo_ingles->id_periodo_ingles);
        Session::put('nombre_periodo_ingles',$periodo_ingles->periodo_ingles);

        /// fin de periodos de ingles
        Session::put('arre_periodos',$arre_periodos=DB::select('select *from gnral_periodos'));
        Session::put('periodos',$periodos=DB::selectOne('select gnral_periodos.id_periodo from gnral_periodos WHERE YEAR(fecha_inicio) ='.$año.' and month(fecha_inicio)='.$mes.''));
        Session::put('periodo_anterior',$periodo_anterior=($periodos->id_periodo-1));
        Session::put('periodo_actual',$periodo_actual=$periodos->id_periodo);
        Session::put('periodo_siguiente',$periodo_siguiente=($periodos->id_periodo+1));
        Session::put('p1',$p1=DB::selectOne('select * from gnral_periodos where id_periodo='.$periodo_anterior.''));
        Session::put('p2',$p2=DB::selectOne('select * from gnral_periodos where id_periodo='.$periodo_actual.''));
        Session::put('p3',$p3=DB::selectOne('select * from gnral_periodos where id_periodo='.$periodo_siguiente.''));
        Session::put('periodotrabaja',$periodo_actual);
        $periodon=DB::selectOne('select periodo from gnral_periodos where id_periodo='.$periodo_actual.' ');
        Session::put('nombre_periodo',$periodon->periodo);

        Session::put('tipo_persona',Auth::user()->tipo_usuario);
        if($tipo==1)
        {
            $alumno_existe=DB::selectOne('select gnral_alumnos.id_alumno from gnral_alumnos where gnral_alumnos.id_usuario='.$id_usuario.'');
           // dd($id_usuario);
            if($alumno_existe==null)
            {

                $permiso=1;

                Session::put('permiso',$permiso);
                Session::put('personal_noregis',true);
                $nombre="";
                Session::put('nombre',$nombre);
                return redirect('datos_alumno');
            }
            else
            {
                if ($info==0) {
                   $permiso=1;
                 Session::put('permiso',$permiso);
                 Session::put('personal_noregis',true);
                 return redirect('datos_alumno');

                }
            $dat=DB::selectOne('select gnral_alumnos.id_carrera,gnral_alumnos.cuenta,gnral_alumnos.id_alumno,gnral_alumnos.id_semestre from gnral_alumnos where gnral_alumnos.id_usuario='.$id_usuario.'');  //////////////////////PERIODO///////////////////
            $nombre=DB::selectOne('select gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.id_alumno from gnral_alumnos where gnral_alumnos.id_usuario='.$id_usuario.'');
            $nombre=$nombre->nombre." ".$nombre->apaterno." ".$nombre->amaterno;
            //dd($nombre);
                $carrera=($dat->id_carrera);
                //dd($nombre);
                $cuenta=($dat->cuenta);
                $semestre=($dat->id_semestre);
                if($semestre>=8){

                    $fecha = date("Y-m-d ");


                    $registrar=DB::selectOne("SELECT count(id_periodo_eval_anteproyecto) numero 
               FROM resi_periodo_eval_anteproyecto WHERE fecha_inicio <= '$fecha'
    AND fecha_final >= '$fecha' and estado_periodo = 1 and id_periodo = $periodo_actual
       ");
                    $registrar=$registrar->numero;
                    // dd($registrar);
                    if($registrar == 0)
                    {
                    }
                    else{
                        Session::put('registrar_residencia',true);
                    }
                    $alumno=$dat->id_alumno;
                    $estado_reg_anteproyecto=DB::selectOne('SELECT *from resi_anteproyecto WHERE id_alumno='.$alumno.' and id_periodo = '.$periodo_actual.'');
                    if($estado_reg_anteproyecto == null)
                    {

                    }else{
                        Session::put('estado_reg_anteproyecto',true);
                    }


                    $anteproyecto=DB::selectOne('SELECT id_anteproyecto FROM resi_anteproyecto WHERE id_alumno ='.$alumno.' AND id_periodo = '.$periodo_actual.' AND estado_enviado = 3 ');

                    $anteproyecto_aceptado=DB::selectOne('SELECT count(id_anteproyecto) aceptado FROM resi_anteproyecto WHERE id_alumno ='.$alumno.' AND id_periodo = '.$periodo_actual.' AND estado_enviado = 3 ');
                    $anteproyecto_aceptado=$anteproyecto_aceptado->aceptado;
                    if($anteproyecto == null)
                    {

                    }
                    else {
                        $registro_empresa = DB::selectOne('SELECT count(id_proy_empresa) registro FROM resi_proy_empresa WHERE id_anteproyecto =' . $anteproyecto->id_anteproyecto . '');
                        $registro_empresa = $registro_empresa->registro;

                        if ($registro_empresa == 1) {
                            Session::put('registro_empresa', true);
                        }
                    }
                    if($anteproyecto_aceptado ==1)
                    {
                        Session::put('anteproyecto_aceptado',true);


                    }
                    // dd($anteproyecto_aceptado);

                }
            $id_alumno=$dat->id_alumno;
                $seguimiento= DB::selectOne('SELECT COUNT(resi_anteproyecto.id_alumno) id_alumno from resi_anteproyecto,resi_asesores where resi_anteproyecto.id_anteproyecto=resi_asesores.id_anteproyecto and resi_asesores.id_periodo='.$periodo_actual.' and resi_anteproyecto.id_alumno='.$id_alumno.' ');
             $seguimiento=$seguimiento->id_alumno;
//dd($seguimiento);
            if($seguimiento ==0)
            {

            }
            else{
                Session::put('seguimiento_alumno',true);
            }
            $men=DB::selectOne('select men.des from men where men.id=1');
            $men=$men->des;

            Session::put('men',$men);

            Session::put('carrera',$carrera);
            Session::put('usuario',$cuenta);
            Session::put('semestre',$semestre);
            Session::put('palumno',true);
            Session::put('entra',0);
            Session::put('nombre',$nombre);
            $permiso=0;
            Session::put('permiso',$permiso);
            $activa_eva=DB::selectOne('select eva_activa_evaluacion.estado, eva_activa_evaluacion.id from eva_activa_evaluacion WHERE eva_activa_evaluacion.id=1');
            $estado=$activa_eva->estado;

                  if($estado==2)
                    {
                         Session::put('ver_eva',true);
                    }


            $activa_eva=DB::selectOne('select eva_activa_evaluacion.estado, eva_activa_evaluacion.id from eva_activa_evaluacion WHERE eva_activa_evaluacion.id=2');
            $estado=$activa_eva->estado;
            if($estado==2)
                    {
                         Session::put('ver_carga',true);
                    }
            ////////////Titulacion///////////
                $alumno_reg_ti=DB::selectOne('SELECT count(id_descuento_alum)registrado
               FROM `ti_descuentos_alum` WHERE `id_alumno` = '.$id_alumno.' ');

            if($alumno_reg_ti->registrado != 0){

                Session::put('reg_alum_ti',true);
            }else{
                Session::put('reg_alum_ti',false);
            }
            ///////registro 2 etapa///////////////
                $reg_segunda=DB::selectOne('SELECT count(id_requisitos) validacion_primer_titulacion
FROM `ti_requisitos_titulacion` WHERE `id_alumno` = '.$id_alumno.' AND `id_estado_enviado` = 4 '); // autorización de la primera etapa el alumno
                //entrego su documentación
                if($reg_segunda->validacion_primer_titulacion != 0){

                    Session::put('ti_segunda_etapa',true);

                    ///////registro 3 etapa///////////////
                    $reg_tercera=DB::selectOne('SELECT  COUNT(id_fecha_jurado_alumn) contar FROM `ti_fecha_jurado_alumn` WHERE `id_alumno` = '.$id_alumno.' AND `id_autorizar_agendar_jurado` = 1 ');

                    if($reg_tercera->contar != 0){
                        Session::put('ti_tercera_parte',true);
                    }else{
                        Session::put('ti_tercera_parte',false);
                    }

                }else{
                    Session::put('ti_segunda_etapa',false);
                }

                     return view('home');
            }
        }

        else if($tipo==2)
        {



            $datesAudtoria=AudAuditorias::whereRaw('(datediff(fecha_i, now()) < 15 and datediff(fecha_i, now()) >0) or (date(now()) between fecha_i and fecha_f)')
                ->selectRaw('*, datediff(fecha_i, now())')->first();
         //   dd($datesAudtoria);
            $isAuditor=AudAuditorAuditoria::join("aud_auditoria","aud_auditoria.id_auditoria","=","aud_auditor_auditoria.id_auditoria")
                ->join("gnral_personales","gnral_personales.id_personal","aud_auditor_auditoria.id_personal")
                ->join("users","users.id","gnral_personales.tipo_usuario")
                ->where("users.id",$id_usuario)
                ->where("aud_auditoria.id_auditoria",(isset($datesAudtoria->id_auditoria)?$datesAudtoria->id_auditoria:0));

            if($isAuditor->count()>0){
                Session::put('isAuditor',true);
            }

            $persona=DB::selectOne('select gnral_personales.id_personal
                                    from gnral_personales,users
                                    where gnral_personales.tipo_usuario=users.id
                                    and gnral_personales.tipo_usuario='.$id_usuario.'');
            //dd($persona);

            if ($persona==null)
            {
                Session::put('id_usuario',$id_usuario);
                //dd();
                Session::put('info',$info);
                $permiso=1;
                Session::put('permiso',$permiso);
                Session::put('personal_noregis',true);
                $nombre="";
                Session::put('nombre',$nombre);
                return redirect('/docentes/create');
            }
            else
            {
                Session::put('personal_tesvb',true);


                /** Riegos **/

                $unidad_personal=DB::selectOne('select gnral_unidad_personal.id_unidad_persona,id_unidad_admin from gnral_unidad_personal
                                    where gnral_unidad_personal.id_personal='.$persona->id_personal.'');

//                $revisores=DB::selectOne('SELECT count(resi_revisores.id_revisores) revisores FROM resi_revisores WHERE id_profesor ='.$persona->id_personal.' and id_periodo='.$periodo_actual.'');
//
//                   if($revisores->revisores >0)
//                   {
//                       Session::put('revisor',true);
//                   }


//                $academia= DB::selectOne('SELECT count(id_academia) academia FROM resi_academia WHERE id_profesor ='.$persona->id_personal.'');
//                if($academia->academia==1)
//                {
//                    Session::put('personal_academia',true);
//                }

                ///residencia
                $revisores=DB::selectOne('SELECT count(resi_revisores.id_revisores) revisores FROM resi_revisores WHERE id_profesor ='.$persona->id_personal.' and id_periodo='.$periodo_actual.'');

                   if($revisores->revisores >0)
                   {
                       Session::put('revisor',true);
                   }
                  $seguimiento_asesor=DB::selectOne('SELECT count(id_asesores)asesor FROM resi_asesores WHERE id_profesor = '.$persona->id_personal.' AND id_periodo = '.$periodo_actual.'');
                   $seguimiento_asesor=$seguimiento_asesor->asesor;

                   if($seguimiento_asesor == 0 )
                   {

                   }
                   else{
                       Session::put('seguimiento_asesor',true);
                   }


                $academia= DB::selectOne('SELECT count(id_academia) academia FROM resi_academia WHERE id_profesor ='.$persona->id_personal.' and id_cargo_academia=1');
                if($academia->academia==1)
                {
                    Session::put('personal_academia',true);
                }

              //residencia
                if(isset($unidad_personal->id_unidad_admin)) {
                    session()->put('id_unidad_admin', $unidad_personal->id_unidad_admin);



                }
                Session::put('id_perso',$persona->id_personal);
                ///////////// verificacion de encargado de un procedimiento de ambiental /////
                $encargado_ambiental=DB::selectOne('SELECT COUNT(id_encargado) encargado 
               FROM `amb_encargados` WHERE `id_personal` = '.$persona->id_personal.' ');
                $encargado_ambiental=$encargado_ambiental->encargado;
                if($encargado_ambiental >=1){

                    Session::put('encargado_ambiental',true);
                }

                $nombre=DB::selectOne('select gnral_personales.nombre
                                        from gnral_personales
                                        where gnral_personales.id_personal='.$persona->id_personal.'');
                $nombre=$nombre->nombre;
                Session::put('nombre',$nombre);

                $departamento=DB::selectOne('select gnral_personales.id_departamento
                    from gnral_personales,users,gnral_departamentos where
                    gnral_personales.tipo_usuario=users.id and gnral_personales.tipo_usuario='.$id_usuario.' ');

                if($departamento->id_departamento==0)
                {
                     $personal=DB::selectOne('select gnral_horarios.id_horario_profesor
                                        from gnral_horarios,gnral_periodo_carreras,gnral_personales,gnral_periodos
                                        where gnral_horarios.id_personal=gnral_personales.id_personal
                                        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                        and gnral_periodos.id_periodo='.$periodo_actual.'
                                        and gnral_personales.tipo_usuario='.$id_usuario.'');


                     if($personal!=null) /////CONDICION PARA SABER SI ES PROFESOR
                        {

                            $actividad_extra=DB::selectOne('select hrs_act_extra_clases.id_act_extra_clase from gnral_personales,gnral_horarios,gnral_periodos,gnral_periodo_carreras,gnral_carreras,hrs_actividades_extras,hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase
                                where gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_personales.id_personal=gnral_horarios.id_personal
                                and hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra
                                and hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase
                                and  hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor
                                and hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase
                                and gnral_personales.id_personal='.$persona->id_personal.'
                                and gnral_periodos.id_periodo='.$periodo_actual.'');

                            if($actividad_extra!=null)
                            {
                                //dd($actividad_extra);
                                $actividad_comple=DB::selectOne('select gnral_personales.id_personal,gnral_carreras.id_carrera
                                                    from gnral_personales,hrs_actividades_extras,hrs_act_extra_clases,gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodo_carreras,gnral_periodos,gnral_carreras
                                                    where hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra
                                                    and hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase and hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor
                                                    and hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase
                                                    and gnral_personales.id_personal=gnral_horarios.id_personal
                                                    and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                                    and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                                    and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                                    and gnral_personales.tipo_usuario='.$id_usuario.'
                                                    and hrs_act_extra_clases.id_act_extra_clase='.$actividad_extra->id_act_extra_clase.'
                                                    and gnral_periodos.id_periodo='.$periodo_actual.'');
                                //dd($periodo_actual);

                                //dd($actividad_comple);
                            }
                            else
                            {
                                $actividad_comple=null;
                               // dd("ok");
                            }
                          //  dd("ok");
                        if($actividad_comple!=null ) ////condicion para saber si es un docente con actividad complementaria
                        {

                                $permiso=5;
                                $carrera=$actividad_comple->id_carrera;
                                Session::put('permiso',$permiso);
                                //Session::put('carrera',$carrera);
                                $men=DB::selectOne('select men.des from men where men.id=1');
                                $men=$men->des;
                                 Session::put('men',$men);
                                 Session::put('profesor_men',true);
                                Session::put('profesor_conact',true);
                                Session::put('entra',0);

////////////MENSAJE DE FECHA PARA LIBERAR ACTIVIDADES COMPLEMENTARIAS////////////////////////////////
                                $periodo=Session::get('periodo_actual');

                                $fecha_prueba=DB::selectOne('select gnral_periodos.fecha_termino from gnral_periodos WHERE gnral_periodos.id_periodo='.$periodo.'');
                                $fecha=$fecha_prueba->fecha_termino;
                                $fecha= explode("-", $fecha);
                                $año=$fecha[0];
                                $mes=$fecha[1];
                                $dia=$fecha[2]-10;
                                if($mes==2)
                                {
                                    $mes='Febrero';
                                    $fecha=$dia." de ".$mes." del ".$año;
                                    Session::put('fecha',$fecha);
                                }
                                else
                                {
                                    if ($mes==8)
                                    {
                                        $mes='Agosto';
                                        $fecha=$dia." de ".$mes." del ".$año;
                                        Session::put('fecha',$fecha);
                                    }
                                }

                                return view('home');
                            }
                            else
                            {
                                //dd("soloprof");
                              $men=DB::selectOne('select men.des from men where men.id=1');
                                $men=$men->des;
                                 Session::put('men',$men);
                                Session::put('profesor_sinact',true);
                                return view('home');
                            }

                        }
                        else
                        {

                                //dd("no tienes permisos");

                                    $permiso=6;
                                    Session::put('permiso',$permiso);
                                    Session::put('profesor_sinact',true);
                                  //  dd("hola");
                                    $mensaje_evidencias="NO TIENES NINGUNA ACCION";
                                    return view('actividades_complementarias.alumnos.mensajes',compact('mensaje_evidencias'));

                        }


                }//termina 0

                if($departamento->id_departamento==1)
                {
                    $permiso=2;
                    Session::put('permiso',$permiso);
                    Session::put('directivo.',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }
                if($departamento->id_departamento==2)
                {

                         $jefe_division=DB::selectOne('select DISTINCT gnral_personales.id_personal,gnral_carreras.id_carrera, gnral_carreras.nombre
                                                    from gnral_jefes_periodos,gnral_personales,gnral_periodos,gnral_carreras
                                                    where gnral_personales.id_personal=gnral_jefes_periodos.id_personal
                                                    and gnral_jefes_periodos.id_periodo=gnral_periodos.id_periodo
                                                    and gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera
                                                    and gnral_personales.tipo_usuario='.$id_usuario.'
                                                    and gnral_periodos.id_periodo='.$periodo_actual.'');

                         $num_carreras=DB::selectOne('select COUNT(gnral_jefes_periodos.id_personal)num
                                                    from gnral_jefes_periodos,gnral_personales
                                                    where gnral_personales.tipo_usuario='.$id_usuario.'
                                                    and gnral_jefes_periodos.id_periodo='.$periodo_actual.' AND
                                                    gnral_jefes_periodos.id_personal=gnral_personales.id_personal');
                         if($num_carreras->num==2)
                         {
                            Session::put('cambio_carreras',1);
                            $carreras=DB::select('select gnral_carreras.id_carrera,gnral_carreras.nombre from
                                gnral_carreras,gnral_jefes_periodos,gnral_personales WHERE
                                gnral_personales.tipo_usuario='.$id_usuario.' AND
                                gnral_jefes_periodos.id_periodo='.$periodo_actual.' AND
                                gnral_jefes_periodos.id_personal=gnral_personales.id_personal AND
                                gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera ');
                         }
                         else
                         {
                            Session::put('cambio_carreras',0);
                            $carreras=0;
                         }
                                    $permiso=3;
                                    Session::put('carreras',$carreras);
                                    $carrera=$jefe_division->id_carrera;
                                    $nombre_carrera=$jefe_division->nombre;
                                    Session::put('permiso',$permiso);
                                    Session::put('carrera',$carrera);
                                    Session::put('usuario',$id_usuario);
                                    Session::put('nombre_carrera',$nombre_carrera);
                                    Session::put('id_carrera', $jefe_division->id_carrera);
                                    $men=DB::selectOne('select men.des from men where men.id=1');
                                    $men=$men->des;
                                     Session::put('men',$men);
                                    Session::put('jefe_division',true);
                                    return view('home');
                }
                if($departamento->id_departamento==3)
                {
                    $nombre_departamento=$departamento->nombre_departamento;
                    Session::put('nombre_carrera',$nombre_departamento);
                    Session::put('consultas',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }
                if($departamento->id_departamento==4)
                {
                   Session::put('desa',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }
                // subdireccion de servicios escolares
                if($departamento->id_departamento==5)
                {
                    Session::put('escolar',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }
                // departamento de administracion_personal
                if($departamento->id_departamento==6)
                {
                    Session::put('personal',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }
                //departamento_computo
                if($departamento->id_departamento==7)
                {
                    Session::put('computo',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }
                //departamento de residencia
                if($departamento->id_departamento==8)
                {
                    Session::put('residencia',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }
                //departameento de titulacion
                if($departamento->id_departamento==9)
                {
                    Session::put('titulacion',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }
                //departamento de direccion de administreacion  y finanzas
                if($departamento->id_departamento==10)
                {

                    Session::put('finanzas',true);
                    $men=DB::selectOne('select men.des from men where men.id=1');
                    $men=$men->des;
                    Session::put('men',$men);
                    return view('home');
                }



            }


        }
        else if($tipo==3){
            $profesores_ingles=DB::selectOne('select in_profesores_ingles.id_profesores from in_profesores_ingles,users 
where in_profesores_ingles.id_tipo_usuario=users.id and in_profesores_ingles.id_tipo_usuario='.$id_usuario.'');

            if ($profesores_ingles==null)
            {
                Session::put('id_usuario',$id_usuario);
                //dd();
                Session::put('info',$info);
                $permiso=1;
                Session::put('permiso',$permiso);
                Session::put('profesor_ingles_noregis',true);
                $nombre="";
                Session::put('nombre',$nombre);
                return redirect('/profesores_ingles/create');
            }
            else
            {

                Session::put('profesor_ingles',true);
                Session::put('id_usuario',$id_usuario);
                $nombre_profesor=DB::selectOne('SELECT * FROM in_profesores_ingles WHERE id_tipo_usuario = '.$id_usuario.'');
                $nombre=$nombre_profesor->nombre.' '.$nombre_profesor->apellido_paterno.' '.$nombre_profesor->apellido_materno;
                Session::put('nombre_ingles',$nombre);
                Session::put('id_profesor_ingles',$nombre_profesor->id_profesores);
               /// $nombre=$nombre->nombre;
                //Session::put('nombre',$nombre);
                $men=DB::selectOne('select men.des from men where men.id=1');
                $men=$men->des;
                Session::put('men',$men);

                //dd($men);
                return redirect('/ingles/');
                //return view('ingles/');

            }
        }


    }
    public function recargaperiodo($id_periodo)
    {
        //dd("holaaa");
        Session::put('periodo_anterior',$periodo_anterior=($id_periodo-1));
        Session::put('periodo_actual',$periodo_actual=intval($id_periodo));
        Session::put('periodo_siguiente',$periodo_siguiente=($id_periodo+1));
        Session::put('p1',$p1=DB::selectOne('select * from gnral_periodos where id_periodo='.$periodo_anterior.''));
        Session::put('p2',$p2=DB::selectOne('select * from gnral_periodos where id_periodo='.$periodo_actual.''));
        Session::put('p3',$p3=DB::selectOne('select * from gnral_periodos where id_periodo='.$periodo_siguiente.''));
        Session::put('periodotrabaja',$periodo_actual);

        $periodon=DB::selectOne('select periodo from gnral_periodos where id_periodo='.$periodo_actual.' ');
        Session::put('nombre_periodo',$periodon->periodo);

        $id_usuario = Session::get('usuario_alumno');
        $dat=DB::selectOne('select gnral_alumnos.id_carrera,gnral_alumnos.cuenta,gnral_alumnos.id_alumno,gnral_alumnos.id_semestre from gnral_alumnos where gnral_alumnos.id_usuario='.$id_usuario.'');  //////////////////////PERIODO///////////////////
         if($dat == null){
             $per=DB::selectOne('SELECT count(id_personal)per FROM `gnral_personales` WHERE `tipo_usuario` = '.$id_usuario.'');
             if($per->per == 0){

             }
                 else
                 {
                     $persona=DB::selectOne('SELECT * FROM `gnral_personales` WHERE `tipo_usuario` = '.$id_usuario.'');
                     $revisores=DB::selectOne('SELECT count(resi_revisores.id_revisores) revisores FROM resi_revisores WHERE id_profesor ='.$persona->id_personal.' and id_periodo='.$periodo_actual.'');

                     if($revisores->revisores >0)
                     {
                         Session::put('revisor',true);
                     }
                     $seguimiento_asesor=DB::selectOne('SELECT count(id_asesores)asesor FROM resi_asesores WHERE id_profesor = '.$persona->id_personal.' AND id_periodo = '.$periodo_actual.'');
                     $seguimiento_asesor=$seguimiento_asesor->asesor;

                     if($seguimiento_asesor == 0 )
                     {

                     }
                     else{
                         Session::put('seguimiento_asesor',true);
                     }

                 }

         }
         else{
             $alumno=$dat->id_alumno;
             $anteproyecto=DB::selectOne('SELECT id_anteproyecto FROM resi_anteproyecto WHERE id_alumno ='.$alumno.' AND id_periodo = '.$periodo_actual.' AND estado_enviado = 3 ');

             $anteproyecto_aceptado=DB::selectOne('SELECT count(id_anteproyecto) aceptado FROM resi_anteproyecto WHERE id_alumno ='.$alumno.' AND id_periodo = '.$periodo_actual.' AND estado_enviado = 3 ');
             $anteproyecto_aceptado=$anteproyecto_aceptado->aceptado;
             if($anteproyecto == null)
             {
                 Session::put('registro_empresa', false);
                 Session::put('anteproyecto_aceptado',false);
             }
             else {
                 $registro_empresa = DB::selectOne('SELECT count(id_proy_empresa) registro FROM resi_proy_empresa WHERE id_anteproyecto =' . $anteproyecto->id_anteproyecto . '');
                 $registro_empresa = $registro_empresa->registro;

                 if ($registro_empresa == 1) {
                     Session::put('registro_empresa', true);
                 }
             }
             if($anteproyecto_aceptado ==1)
             {
                 Session::put('anteproyecto_aceptado',true);

             }
             $seguimiento_al=DB::selectOne('SELECT count(id_alumno) contar from resi_asesores,resi_anteproyecto where resi_asesores.id_anteproyecto=resi_anteproyecto.id_anteproyecto and resi_asesores.id_periodo='.$periodo_actual.' and resi_anteproyecto.id_alumno='.$alumno.'');
              $seguimiento_al=$seguimiento_al->contar;
              if($seguimiento_al == 0){

              }else{
                  Session::put('seguimiento_alumno',true);
              }
             $fecha = date("Y-m-d ");
             $registrar=DB::selectOne("SELECT count(id_periodo_eval_anteproyecto) numero 
               FROM resi_periodo_eval_anteproyecto WHERE fecha_inicio <= '$fecha'
    AND fecha_final >= '$fecha' and estado_periodo = 1 and id_periodo = $periodo_actual
       ");
             $registrar=$registrar->numero;
             // dd($registrar);
             if($registrar == 0)
             {
                 Session::put('registrar_residencia',false);

             }
             else{


                 Session::put('registrar_residencia',true);

             }
             $estado_reg_anteproyecto=DB::selectOne('SELECT *from resi_anteproyecto WHERE id_alumno='.$alumno.' and id_periodo = '.$periodo_actual.'');
             if($estado_reg_anteproyecto == null)
             {
                 Session::put('estado_reg_anteproyecto',false);
             }else{
                 Session::put('estado_reg_anteproyecto',true);
             }


         }
        $sistema_tut = Session::get('sistemas_tutorias');

         if($sistema_tut == true){
             $persona=DB::selectOne('SELECT * FROM `gnral_personales` WHERE `tipo_usuario` = '.$id_usuario.'');
             $jef=DB::selectOne('SELECT *  FROM `gnral_jefes_periodos` WHERE `id_personal` = '.$persona->id_personal.' AND `id_periodo` = '.$periodo_actual.'');
             if($jef != null){


             $jefe = DB::table('gnral_personales')
            ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_personal', '=', 'gnral_personales.id_personal')
            ->join('gnral_carreras', 'gnral_jefes_periodos.id_carrera', '=', 'gnral_carreras.id_carrera')
            ->where('gnral_jefes_periodos.id_periodo', '=',$periodo_actual)
            ->where('gnral_personales.tipo_usuario', '=', $id_usuario)
            ->select('gnral_personales.nombre', 'gnral_personales.id_departamento', 'gnral_jefes_periodos.id_carrera', 'gnral_jefes_periodos.id_personal',
                'gnral_carreras.nombre as carrera', 'gnral_jefes_periodos.id_periodo', 'gnral_jefes_periodos.id_jefe_periodo')
            ->get();



             Session::put('id_jefe_periodo', $jefe[0]->id_jefe_periodo);
         }
         return redirect('/tutorias/');
         }

        return back();
    }
    public function recargapersonal($idcarr)
    {
        Session::put('carrera',$idcarr);
        $nombre_carrera=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$idcarr.'');
//dd($nombre_carrera->nombre);
        Session::put('nombre_carrera',$nombre_carrera->nombre);
        return back();
    }

}
