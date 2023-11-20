<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\carreras;
use App\materias;
use App\reticulas;
use Session;

class carga_academicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carreras="";
        $carrera = Session::get('carrera');
        $periodo=Session::get('periodo_actual');
        $usuario = Session::get('usuario');

        $estado_periodo=DB::selectOne('SELECT count(id_periodo)periodo FROM `gnral_periodos` 
         WHERE `id_periodo` = '.$periodo.' AND `estado` = 1');
        $estado_periodo=$estado_periodo->periodo;
        if($estado_periodo == 0)
        {

        $status_per=0;
            return view('evaluacion_docente.Alumnos.carga_academica', compact('status_per'));

        }
        else {
            $status_per=1;

            $id_alu = DB::selectOne("select gnral_alumnos.id_alumno 
                                from gnral_alumnos 
                                where gnral_alumnos.cuenta='$usuario'");
            $id_alu = ($id_alu->id_alumno);


            $des = DB::selectOne('select eva_validacion_de_cargas.estado_validacion 
                            from eva_validacion_de_cargas 
                            WHERE eva_validacion_de_cargas.id_alumno=' . $id_alu . '
                            AND eva_validacion_de_cargas.id_periodo=' . $periodo . '');
            if ($des == null) {
                $des = 0;
            } else {
                $des = $des->estado_validacion;
            }
            $carre = DB::selectOne('select gnral_carreras.nombre from gnral_carreras where gnral_carreras.id_carrera=' . $carrera . '');
            $carre = $carre->nombre;
            $activar_periodo_carga = DB::selectOne('SELECT * FROM eva_validacion_carga WHERE id_validacion_carga=1');


            $materias=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=1 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia');

            $materias2=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=2 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia');

            $materias3=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=3 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia');

            $materias4=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=4 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia');

            $materias5=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=5 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia');

            $materias6=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=6 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia');

            $materias7=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=7 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia');

            $materias8=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=8 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia');
            /*
            $materias = DB::select('select DISTINCT gnral_materias.id_materia, gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo, gnral_personales.id_personal
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            hrs_rhps,gnral_periodo_carreras,hrs_semanas,gnral_reticulas, abreviaciones_prof, abreviaciones WHERE
            gnral_periodo_carreras.id_carrera=' . $carrera . ' AND
            gnral_periodo_carreras.id_periodo=' . $periodo . ' AND
            gnral_materias.id_semestre=1 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            hrs_rhps.id_semana=hrs_semanas.id_semana AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            and
            hrs_rhps.id_aula=0  GROUP by gnral_materias.id_materia
            UNION
            select DISTINCT gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo,gnral_personales.id_personal
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            hrs_rhps,gnral_periodo_carreras,hrs_semanas,hrs_aulas,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= ' . $carrera . ' AND
            gnral_periodo_carreras.id_periodo=' . $periodo . ' AND
            gnral_materias.id_semestre=1 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            hrs_rhps.id_semana=hrs_semanas.id_semana 
            and gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion and
            hrs_rhps.id_aula=hrs_aulas.id_aula GROUP by gnral_materias.id_materia');
            */
          //  dd($materias);



//dd($materias2);




            $materias9 = DB::select('select  gnral_materias.id_materia,gnral_materias.nombre,
            gnral_reticulas.clave,gnral_personales.nombre docente, abreviaciones.titulo
            FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            gnral_periodo_carreras,gnral_reticulas, abreviaciones_prof,abreviaciones WHERE
            gnral_periodo_carreras.id_carrera= '.$carrera.' AND
            gnral_periodo_carreras.id_periodo='.$periodo.' AND
            gnral_materias.id_semestre=9 AND
            gnral_horarios.aprobado = 1 and 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_materias.id_reticula = gnral_reticulas.id_reticula and 
            gnral_personales.id_personal = abreviaciones_prof.id_personal
            and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
            GROUP by gnral_materias.id_materia
            UNION select gnral_materias.id_materia,gnral_materias.nombre ,0 id_reticula,"" docente,"" titulo FROM `gnral_materias` WHERE `id_materia` = 1265 
            UNION select gnral_materias.id_materia,gnral_materias.nombre ,0 id_reticula,"" docente,"" titulo  FROM `gnral_materias` WHERE `id_materia` = 2258
            ');
//dd($materias9);
            $adeudo_departamento=DB::selectOne('SELECT COUNT(id_adeudo_departamento)adeudo  
                        FROM adeudo_departamento WHERE id_alumno = '.$id_alu.' ');
            $adeudo_departamento=$adeudo_departamento->adeudo;


            if( $adeudo_departamento ==0){
                $adeudo=0;
                $departamento_carrera="";
            }
            else{
                $adeudo=1;

                $departamento_carrera=array();
                $adeudo_dep=DB::select('SELECT gnral_unidad_administrativa.nom_departamento,
                                adeudo_departamento.comentario FROM adeudo_departamento,
                                gnral_unidad_administrativa WHERE adeudo_departamento.id_alumno = '.$id_alu.' 
                                and gnral_unidad_administrativa.id_unidad_admin=adeudo_departamento.id_departamento ');

                foreach($adeudo_dep as $ade)
                {
                    $nombrea['nombre']= $ade->nom_departamento;
                    $nombrea['comentario']= $ade->comentario;
                    array_push($departamento_carrera, $nombrea);
                }
                $adeudo_informacion=DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                from adeudo_departamento where id_alumno='.$id_alu.' and id_departamento=50');
                if($adeudo_informacion->contar >0)
                {
                    $informacion=DB::select('SELECT  *from adeudo_departamento where id_alumno='.$id_alu.' and id_departamento=50');
                    foreach ($informacion as $info) {
                        $nombre_info['nombre'] = "CENTRO DE INFORMACIÓN";
                        $nombre_info['comentario']=$info->comentario;
                        array_push($departamento_carrera, $nombre_info);
                    }
                }
                $adeudo_bolsa=DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                from adeudo_departamento where id_alumno='.$id_alu.' and id_departamento=100');
                if($adeudo_bolsa->contar >0)
                {
                    $bolsa=DB::select('SELECT  *from adeudo_departamento where id_alumno='.$id_alu.' and id_departamento=100');
                    foreach ($bolsa as $bolsa) {
                        $nombre_bolsa['nombre'] = "BOLSA DE TRABAJO Y SEGUIMIENTO DE EGRESADOS";
                        $nombre_bolsa['comentario']=$bolsa->comentario;
                        array_push($departamento_carrera, $nombre_bolsa);
                    }
                }
            }
                    return view('evaluacion_docente.Alumnos.carga_academica', compact('status_per','activar_periodo_carga',
                    'des', 'carre', 'carreras', 'materias', 'materias2', 'materias3', 'materias4', 'materias5', 'materias6', 'materias7',
                    'materias8', 'materias9','adeudo','departamento_carrera'));
        }
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
    public function store()
    {

      echo('hola');



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
    public function consultas($reti)
    {

     $carrera = Session::get('carrera');
     $carre=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where gnral_carreras.id_carrera='.$carrera.'');
     $carre=$carre->nombre;
     $id_reticula=$reti;
     $nom_reticula=DB::selectOne('select gnral_reticulas.clave from gnral_reticulas 
                            where gnral_reticulas.id_reticula='.$id_reticula.'');
     $nom_reticula=$nom_reticula->clave;

 
     $reticulas=DB::select('select gnral_reticulas.id_reticula, gnral_reticulas.clave from gnral_reticulas 
                            where gnral_reticulas.id_carrera='.$carrera.'');
    // dd($reticulas);


        $materias=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=1');
        $materias2=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=2');
        $materias3=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=3');
        $materias4=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=4');
        $materias5=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=5');
        $materias6=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=6');
        $materias7=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=7');
        $materias8=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=8');
        $materias9=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre from gnral_materias where id_reticula='.$id_reticula.' and id_semestre=9');

        $periodo=Session::get('periodo_actual');
        $usuario = Session::get('usuario');

        $id_alu=DB::selectOne("select gnral_alumnos.id_alumno 
                                from gnral_alumnos 
                                where gnral_alumnos.cuenta='$usuario'");
        $id_alu=($id_alu->id_alumno);

        $des=DB::selectOne('select eva_validacion_de_cargas.estado_validacion 
                            from eva_validacion_de_cargas 
                            WHERE eva_validacion_de_cargas.id_alumno='.$id_alu.'
                            AND eva_validacion_de_cargas.id_periodo='.$periodo.'');
        if($des == null){
            $des=0;
        }else {
            $des = $des->estado_validacion;
        }
        $activar_periodo_carga=DB::selectOne('SELECT * FROM eva_validacion_carga WHERE id_validacion_carga=1');
         return view('evaluacion_docente.Alumnos.carga_academica',compact('des','activar_periodo_carga','nom_reticula','carre','materias','materias2','materias3','materias4','materias5','materias6','materias7','materias8','materias9','reticulas'));
    }
}
