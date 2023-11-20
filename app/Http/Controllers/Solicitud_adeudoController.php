<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class Solicitud_adeudoController extends Controller
{
    public function index()
    {


        $estado = 1;
        $carreras = DB::select('SELECT * FROM gnral_carreras WHERE gnral_carreras.id_carrera not in (9,11,15)
ORDER BY `gnral_carreras`.`id_carrera` ASC');
        /*$alumnos=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
        gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
        gnral_semestres.descripcion semestre from gnral_alumnos,gnral_carreras,gnral_semestres
        WHERE gnral_alumnos.id_carrera=gnral_carreras.id_carrera and
        gnral_alumnos.id_semestre=gnral_semestres.id_semestre
        ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC');*/
        return view('constancia_adeudo.registrar_alumnos_adeudo', compact('estado', 'carreras'));


    }

    public function ver_alumnos_reg($id_carrera)
    {

        $escolar = session()->has('escolar') ? session()->has('escolar') : false;
        $estado = 2;
        $id_unidad_admin = session()->has('id_unidad_admin') ? session()->has('id_unidad_admin') : false;

        $id_per = Session::get('usuario_alumno');
        if ($id_unidad_admin == true) {
            $unidad = Session::get('id_unidad_admin');

        } elseif ($id_per === 2630) {
            //centro de informacion no se encuentra en las unidades administrativas
            $unidad = 50;

        } elseif ($id_per === 2662) {
            //bolsa de trabajo y seguimiento de egresados no se encuentra en las unidades administrativas
            $unidad = 100;
        }elseif($escolar == true){
            $unidad = 16;
        }

        $alumnos = DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
            gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
            gnral_semestres.descripcion semestre from gnral_alumnos,gnral_carreras,gnral_semestres
            WHERE gnral_alumnos.id_carrera=gnral_carreras.id_carrera and
            gnral_alumnos.id_semestre=gnral_semestres.id_semestre and gnral_carreras.id_carrera=' . $id_carrera . '
             ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC  ');

        $alumnos_adeudo = DB::select('SELECT adeudo_departamento.fecha_registro,adeudo_departamento.comentario,adeudo_departamento.id_adeudo_departamento,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
            gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.id_carrera,gnral_carreras.siglas ,
            gnral_semestres.descripcion semestre  FROM 
            adeudo_departamento,gnral_alumnos,gnral_semestres,gnral_carreras WHERE 
            gnral_alumnos.id_alumno=adeudo_departamento.id_alumno and
            gnral_carreras.id_carrera=gnral_alumnos.id_carrera and
            gnral_semestres.id_semestre=gnral_alumnos.id_semestre
            and gnral_carreras.id_carrera=' . $id_carrera . '
            and adeudo_departamento.id_departamento = ' . $unidad . '  
            ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC ');


        $carreras = DB::select('SELECT * FROM gnral_carreras WHERE gnral_carreras.id_carrera not in (9,11,15)
ORDER BY `gnral_carreras`.`id_carrera` ASC');


//dd($alumnos);
        return view('constancia_adeudo.registrar_alumnos_adeudo', compact('estado', 'carreras', 'alumnos_adeudo', 'alumnos', 'id_carrera'));


    }

    public function registrar_alumno_adeudo($id_carrera, $id_alumno, $comentario)
    {

        $periodo = Session::get('periodo_actual');
        $escolar = session()->has('escolar') ? session()->has('escolar') : false;

        $id_unidad_admin = session()->has('id_unidad_admin') ? session()->has('id_unidad_admin') : false;
        $id_per = Session::get('usuario_alumno');
        if ($id_unidad_admin == true) {
            $unidad = Session::get('id_unidad_admin');

        } elseif ($id_per === 2630) {
            //centro de informacion no se encuentra en las unidades administrativas
            $unidad = 50;

        } elseif ($id_per === 2662) {
            //bolsa de trabajo y seguimiento de egresados no se encuentra en las unidades administrativas
            $unidad = 100;
        }elseif($escolar == true){
            $unidad = 16;
        }

        $fecha = date("d-m-Y");
        DB:: table('adeudo_departamento')->insert(['id_departamento' => $unidad, 'id_alumno' => $id_alumno, 'id_periodo' => $periodo, 'fecha_registro' => $fecha, 'comentario' => $comentario]);


        return back();

    }

    public function eliminar_alumno_adeudo(Request $request, $id_carrrera)
    {

        $id_adeudo_departamento = $request->input("id_adeudo_carrera");
        DB::delete('DELETE FROM `adeudo_departamento` WHERE `adeudo_departamento`.`id_adeudo_departamento` = ' . $id_adeudo_departamento . '');


        return back();
    }

    public function carrera_costancia()
    {
        $estado = 1;

        $carreras = DB::select('SELECT * FROM gnral_carreras WHERE gnral_carreras.id_carrera not in (9,11,15)
ORDER BY `gnral_carreras`.`id_carrera` ASC');

        return view('constancia_adeudo.constancias_carreras', compact('estado', 'carreras'));
    }

    public function ver_carrera_constancia($id_carrera)
    {
        $estado = 2;

        $carreras = DB::select('SELECT * FROM gnral_carreras WHERE gnral_carreras.id_carrera not in (9,11,15)
ORDER BY `gnral_carreras`.`id_carrera` ASC');

        $alumnos = DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
            gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
            gnral_semestres.descripcion semestre from gnral_alumnos,gnral_carreras,gnral_semestres
            WHERE gnral_alumnos.id_carrera=gnral_carreras.id_carrera and
            gnral_alumnos.id_semestre=gnral_semestres.id_semestre and gnral_carreras.id_carrera=' . $id_carrera . '  
ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC');

        return view('constancia_adeudo.constancias_carreras', compact('estado', 'carreras', 'alumnos', 'id_carrera'));

    }

    public function ver_estado_alumno($id_alumno)
    {
        $adeudo_departamento = DB::selectOne('SELECT COUNT(id_adeudo_departamento)adeudo  
                        FROM adeudo_departamento WHERE id_alumno = ' . $id_alumno . ' ');
        $adeudo_departamento = $adeudo_departamento->adeudo;

        if ($adeudo_departamento == 0) {
            $adeudo = 0;
            $departamento_carrera = "";
        } else {
            $adeudo = 1;

            $departamento_carrera = array();
            $adeudo_dep = DB::select('SELECT gnral_unidad_administrativa.nom_departamento,
                                adeudo_departamento.comentario FROM adeudo_departamento,
                                gnral_unidad_administrativa WHERE adeudo_departamento.id_alumno = ' . $id_alumno . ' 
                                and gnral_unidad_administrativa.id_unidad_admin=adeudo_departamento.id_departamento ');

            foreach ($adeudo_dep as $ade) {
                $nombrea['nombre'] = $ade->nom_departamento;
                $nombrea['comentario'] = $ade->comentario;
                array_push($departamento_carrera, $nombrea);
            }
            $adeudo_informacion = DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                from adeudo_departamento where id_alumno=' . $id_alumno . ' and id_departamento=50');
            if ($adeudo_informacion->contar > 0) {
                $informacion = DB::select('SELECT  *from adeudo_departamento where id_alumno=' . $id_alumno . ' and id_departamento=50');
                foreach ($informacion as $info) {
                    $nombre_info['nombre'] = "CENTRO DE INFORMACIÓN";
                    $nombre_info['comentario'] = $info->comentario;
                    array_push($departamento_carrera, $nombre_info);
                }

            }
            $adeudo_bolsa = DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                from adeudo_departamento where id_alumno=' . $id_alumno . ' and id_departamento=100');
            if ($adeudo_bolsa->contar > 0) {
                $bolsa = DB::select('SELECT  *from adeudo_departamento where id_alumno=' . $id_alumno . ' and id_departamento=100');
                foreach ($bolsa as $bolsa) {
                    $nombre_bolsa['nombre'] = "BOLSA DE TRABAJO Y SEGUIMIENTO DE EGRESADOS";
                    $nombre_bolsa['comentario'] = $bolsa->comentario;
                    array_push($departamento_carrera, $nombre_bolsa);
                }

            }

        }
        $alumno=DB::table('gnral_alumnos')
            ->where('gnral_alumnos.id_alumno','=',$id_alumno)
            ->select('gnral_alumnos.*')
            ->get();

        $nombre_alum="NÚMERO DE CUENTA".mb_strtoupper($alumno[0]->cuenta,'utf-8')." NOMBRE: ".mb_strtoupper($alumno[0]->apaterno,'utf-8')." ".mb_strtoupper($alumno[0]->amaterno,'utf-8')." ".mb_strtoupper($alumno[0]->nombre,'utf-8');
        $adeudo_encuesta = DB::selectOne('SELECT COUNT(id_adeudo_constancia) contar
                                from adeudo_constancia_departamento where id_alumno=' . $id_alumno . '');
        $adeudo_encuesta=$adeudo_encuesta->contar;
        if($adeudo_encuesta == 0){
            $adeudo_encuesta=0;

        }else{
            $adeudo_encuesta=1;
        }

        //dd($adeudo);
        return view('constancia_adeudo.ver_estado_alumno',compact('adeudo','departamento_carrera','id_alumno','nombre_alum','adeudo_encuesta'));

    }
    public function verificacion_adeudo_alumno()
    {
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno=DB::selectOne('select * FROM `gnral_alumnos` WHERE id_usuario='.$id_usuario.'');
        $id_alumno=$datosalumno->id_alumno;

        $adeudo_departamento = DB::selectOne('SELECT COUNT(id_adeudo_departamento)adeudo  
                        FROM adeudo_departamento WHERE id_alumno = ' . $id_alumno . ' ');
        $adeudo_departamento = $adeudo_departamento->adeudo;

        if ($adeudo_departamento == 0) {
            $adeudo = 0;
            $departamento_carrera = "";
        } else {
            $adeudo = 1;

            $departamento_carrera = array();
            $adeudo_dep = DB::select('SELECT gnral_unidad_administrativa.nom_departamento,
                                adeudo_departamento.comentario FROM adeudo_departamento,
                                gnral_unidad_administrativa WHERE adeudo_departamento.id_alumno = ' . $id_alumno . ' 
                                and gnral_unidad_administrativa.id_unidad_admin=adeudo_departamento.id_departamento ');

            foreach ($adeudo_dep as $ade) {
                $nombrea['nombre'] = $ade->nom_departamento;
                $nombrea['comentario'] = $ade->comentario;
                array_push($departamento_carrera, $nombrea);
            }
            $adeudo_informacion = DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                from adeudo_departamento where id_alumno=' . $id_alumno . ' and id_departamento=50');
            if ($adeudo_informacion->contar > 0) {
                $informacion = DB::select('SELECT  *from adeudo_departamento where id_alumno=' . $id_alumno . ' and id_departamento=50');
                foreach ($informacion as $info) {
                    $nombre_info['nombre'] = "CENTRO DE INFORMACIÓN";
                    $nombre_info['comentario'] = $info->comentario;
                    array_push($departamento_carrera, $nombre_info);
                }

            }
            $adeudo_bolsa = DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                from adeudo_departamento where id_alumno=' . $id_alumno . ' and id_departamento=100');
            if ($adeudo_bolsa->contar > 0) {
                $bolsa = DB::select('SELECT  *from adeudo_departamento where id_alumno=' . $id_alumno . ' and id_departamento=100');
                foreach ($bolsa as $bolsa) {
                    $nombre_bolsa['nombre'] = "BOLSA DE TRABAJO Y SEGUIMIENTO DE EGRESADOS";
                    $nombre_bolsa['comentario'] = $bolsa->comentario;
                    array_push($departamento_carrera, $nombre_bolsa);
                }

            }

        }
        //dd($departamento_carrera);
      return view('constancia_adeudo.estado_alumno_adeudo',compact('departamento_carrera','adeudo'));

    }
    public function constancia_alumno_editar($id_adeudo_departamento){
       $comentario=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,adeudo_departamento.* FROM  `adeudo_departamento`,gnral_alumnos 
WHERE  gnral_alumnos.id_alumno=adeudo_departamento.id_alumno and `id_adeudo_departamento` = '.$id_adeudo_departamento.'');
       return view('constancia_adeudo.editar_comentario_adeudo', compact('comentario'));
    }
    public function editado_alumno_deudor(Request$request,$id_adeudo_departamento){
        $this->validate($request,[
            'comentario' => 'required',
        ]);

        $comentario = $request->input("comentario");
       // dd($comentario);
        $periodo = Session::get('periodo_actual');
        $fecha = date("d-m-Y");
        DB::update("UPDATE adeudo_departamento SET id_periodo =$periodo,fecha_registro='$fecha',comentario ='$comentario'  WHERE adeudo_departamento.id_adeudo_departamento=$id_adeudo_departamento");

return back();
    }
    public function ver_carrera_encuestas_adeudo(){
        $estado = 1;

        $carreras = DB::select('SELECT * FROM gnral_carreras WHERE gnral_carreras.id_carrera not in (9,11,15)
ORDER BY `gnral_carreras`.`id_carrera` ASC');

        return view('constancia_adeudo.adeudo_encuestas_alumno', compact('estado', 'carreras'));

    }
    public function ver_alumnos_encuestas_adeudo($id_carrera){
        $estado = 2;
        $alumnos = DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
            gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
            gnral_semestres.descripcion semestre from gnral_alumnos,gnral_carreras,gnral_semestres
            WHERE gnral_alumnos.id_carrera=gnral_carreras.id_carrera and
            gnral_alumnos.id_semestre=gnral_semestres.id_semestre and gnral_carreras.id_carrera=' . $id_carrera . '
             ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC  ');

        $alumnos_adeudo = DB::select('SELECT adeudo_constancia_departamento.id_adeudo_constancia, adeudo_constancia_departamento.fecha_registro,adeudo_constancia_departamento.comentario,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
            gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.id_carrera,gnral_carreras.siglas ,
            gnral_semestres.descripcion semestre  FROM 
            adeudo_constancia_departamento,gnral_alumnos,gnral_semestres,gnral_carreras WHERE 
            gnral_alumnos.id_alumno=adeudo_constancia_departamento.id_alumno and
            gnral_carreras.id_carrera=gnral_alumnos.id_carrera and
            gnral_semestres.id_semestre=gnral_alumnos.id_semestre
            and gnral_carreras.id_carrera='.$id_carrera.'
            ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC');
        $carreras = DB::select('SELECT * FROM gnral_carreras WHERE gnral_carreras.id_carrera not in (9,11,15)
ORDER BY `gnral_carreras`.`id_carrera` ASC');


//dd($alumnos);
        return view('constancia_adeudo.adeudo_encuestas_alumno', compact('estado', 'carreras', 'alumnos_adeudo', 'alumnos', 'id_carrera'));

    }
    public function enviar_datos_encuesta($id_carrera,$id_alumno){
        $periodo = Session::get('periodo_actual');


        $fecha = date("d-m-Y");
        DB:: table('adeudo_constancia_departamento')->insert(['id_departamento' => 100, 'id_alumno' => $id_alumno, 'id_periodo' => $periodo, 'fecha_registro' => $fecha]);


        return back();
    }
    public function eliminar_datos_encuesta(Request $request,$id_carrera){
        $id_adeudo_encuestas = $request->input("id_adeudo_encuestas");
        DB::delete('DELETE FROM `adeudo_constancia_departamento` WHERE `adeudo_constancia_departamento`.`id_adeudo_constancia` = ' . $id_adeudo_encuestas . '');


        return back();
    }

}
