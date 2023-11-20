<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\carreras;
use App\materias;
use App\reticulas;
use Excel;
use Session;


class Prorroga_SolicitudController extends Controller
{
    public  function index()
    {
        $id_periodo = Session::get('periodo_actual');

        $fecha_hoy = date("Y-m-d ");
        $per = DB::selectOne('SELECT COUNT(id_prorroga_periodo)contar FROM `prorroga_periodo` WHERE id_periodo='.$id_periodo.'');
        $per = $per->contar;

        if ($per == 0) {
            $estado_periodo_prorroga=0;
            $periodo_p = DB::selectOne('SELECT  prorroga_periodo.*,gnral_periodos.periodo FROM prorroga_periodo,gnral_periodos WHERE prorroga_periodo.id_periodo=gnral_periodos.id_periodo');

            return view('prorroga.solicitud_prorroga', compact(  'estado_periodo_prorroga','periodo_p'));

        } else {
            $estado_periodo_prorroga=1;

            $fecha = DB::selectOne("SELECT count(id_prorroga_periodo)fecha  FROM prorroga_periodo WHERE '$fecha_hoy' BETWEEN 	fecha_inicial AND fecha_final and id_periodo='$id_periodo'");
            $fecha=$fecha->fecha;
            $id_usuario = Session::get('usuario_alumno');
            $datosalumno = DB::table('gnral_alumnos')
                ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
                ->join('gnral_semestres', 'gnral_semestres.id_semestre', '=', 'gnral_alumnos.id_semestre')
                ->select('gnral_alumnos.*', 'gnral_semestres.descripcion as semestre', 'gnral_carreras.nombre as carrera')
                ->where('id_usuario', '=', $id_usuario)
                ->get();
            $semestres = DB::table('gnral_semestres')->get();
            $nombre_alumno = mb_strtoupper($datosalumno[0]->nombre, 'utf-8') . " " . mb_strtoupper($datosalumno[0]->apaterno, 'utf-8') . " " . mb_strtoupper($datosalumno[0]->amaterno, 'utf-8');
            $carrera = $datosalumno[0]->carrera;
            $no_cuenta = $datosalumno[0]->cuenta;
            $id_alumno = $datosalumno[0]->id_alumno;
            $estado_solicitud = DB::selectOne('SELECT COUNT(id_prorroga_solicitudes)solicitud FROM `prorroga_solicitudes` WHERE `id_alumno` = ' . $id_alumno . ' AND `id_periodo` = ' . $id_periodo . '');
            $estado_solicitud = $estado_solicitud->solicitud;
            if ($estado_solicitud == 0) {
                $estado_solicitud = 0;
                $prorroga_solicitudes = 0;
            } else {
                $estado_solicitud = 1;
                $prorroga_solicitudes = DB::selectOne('SELECT prorroga_solicitudes.*,gnral_semestres.descripcion semestre FROM `prorroga_solicitudes`,gnral_semestres WHERE prorroga_solicitudes.id_semestre=gnral_semestres.id_semestre and  prorroga_solicitudes.id_alumno = ' . $id_alumno . ' AND prorroga_solicitudes.id_periodo = ' . $id_periodo . '');
            }
            $periodo_p = DB::selectOne('SELECT  prorroga_periodo.*,gnral_periodos.periodo FROM prorroga_periodo,gnral_periodos WHERE prorroga_periodo.id_periodo=gnral_periodos.id_periodo');

            return view('prorroga.solicitud_prorroga', compact('prorroga_solicitudes', 'estado_solicitud', 'semestres', 'nombre_alumno', 'carrera', 'no_cuenta', 'id_alumno','estado_periodo_prorroga','fecha','periodo_p'));
        }
    }
    public function registrar_solicitud(Request $request,$id_alumno){

        $this->validate($request,[
            'id_semestre' => 'required',
            'fecha_registrada' => 'required',
        ]);

        $id_periodo=Session::get('periodo_actual');
        $id_semestre = $request->input("id_semestre");
        $fecha_registrada = $request->input("fecha_registrada");
        $fecha= date("d-m-Y");
        DB:: table('prorroga_solicitudes')->insert(['id_alumno'=>$id_alumno,'id_semestre'=>$id_semestre,
            'fecha_efectuar'=>$fecha_registrada,'fecha_solicitud'=>$fecha,'id_periodo'=>$id_periodo]);
        return back();
    }
    public function autorizar_prorroga(){
        $id_periodo=Session::get('periodo_actual');
        $solicitudes_prorroga=DB::select('SELECT DISTINCT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.curp_al,gnral_alumnos.correo_al,gnral_semestres.descripcion semestre,
gnral_carreras.nombre carrera,prorroga_solicitudes.fecha_efectuar 
from gnral_alumnos,gnral_semestres,prorroga_solicitudes,gnral_carreras where
 gnral_carreras.id_carrera=gnral_alumnos.id_carrera 
and gnral_alumnos.id_alumno=prorroga_solicitudes.id_alumno and 
gnral_semestres.id_semestre=prorroga_solicitudes.id_semestre and 
prorroga_solicitudes.id_periodo='.$id_periodo.'');

        return view('prorroga.solicitudes_subdireccion',compact('solicitudes_prorroga'));

    }
    public function exportar_solicitudes_prorroga(){
        Excel::create('Solicitudes de prorroga',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {

                $dat_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_carreras['nom_carrera'] = $carrera->nombre;
                $dat_carreras['siglas'] = $carrera->siglas;
                $solicitudes_prorroga=DB::select('SELECT DISTINCT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.curp_al,gnral_alumnos.correo_al,gnral_semestres.descripcion semestre,
gnral_carreras.nombre carrera,prorroga_solicitudes.fecha_efectuar 
from gnral_alumnos,gnral_semestres,prorroga_solicitudes,gnral_carreras where
 gnral_carreras.id_carrera=gnral_alumnos.id_carrera 
and gnral_alumnos.id_alumno=prorroga_solicitudes.id_alumno and 
gnral_semestres.id_semestre=prorroga_solicitudes.id_semestre and 
gnral_alumnos.id_carrera='.$carrera->id_carrera.' and
prorroga_solicitudes.id_periodo='.$periodo.' ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC');

                $array_generales=array();
                foreach ($solicitudes_prorroga as $dato)
                {
                    $dat_generales['cuenta']=$dato->cuenta;
                    $dat_generales['nombre']=$dato->nombre;
                    $dat_generales['apaterno']=$dato->apaterno;
                    $dat_generales['amaterno']=$dato->amaterno;
                    $dat_generales['curp_al']=$dato->curp_al;
                    $dat_generales['correo_al']=$dato->correo_al;
                    $dat_generales['carrera']=$dato->carrera;
                    $dat_generales['semestre']=$dato->semestre;
                    $dat_generales['fecha_efectuar']=$dato->fecha_efectuar;
                    array_push($array_generales,$dat_generales);
                }
                $dat_carreras['dat_general']=$array_generales;
                array_push($array_carreras,$dat_carreras);
            }
          //  dd($array_carreras);

            foreach ($array_carreras as $carrera)
            {
                $i=2;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:E1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(2, [
                        'Cuenta','Apellido paterno','Apellido materno', 'Nombre','Curp','Correo electronico','Carrera','Semestre al que ingresará','Fecha efectuada para el pago de colegiatura semestral'
                    ]);
                    foreach ($carrera['dat_general'] as $generales)
                    {

                        $i++;
                        $sheet->row($i, [
                            $generales['cuenta'],$generales['apaterno'],$generales['amaterno'],$generales['nombre'],
                            $generales['curp_al'],$generales['correo_al'],$generales['carrera'],$generales['semestre'],
                           $generales['fecha_efectuar']
                        ]);
                    }

                });
            }
        })->export('xlsx');
        return back();

    }
    public function exportar_beca_cincuenta(){


        Excel::create('Solicitudes de beca aceptadas del 50 % de descuento',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {

                $dat_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_carreras['nom_carrera'] = $carrera->nombre;
                $dat_carreras['siglas'] = $carrera->siglas;
                $autorizados_profesionales=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,gnral_alumnos.correo_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$periodo.' and beca_autorizar.id_estado=5  
 and beca_descuento.id_descuento in (2,3)  and  gnral_carreras.id_carrera='.$carrera->id_carrera.'
 ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC');


                $array_generales=array();
                foreach ($autorizados_profesionales as $dato)
                {
                    $dat_generales['cuenta']=$dato->cuenta;
                    $dat_generales['nombre']=$dato->nombre;
                    $dat_generales['apaterno']=$dato->apaterno;
                    $dat_generales['amaterno']=$dato->amaterno;
                    $dat_generales['curp_al']=$dato->curp_al;
                    $dat_generales['correo_al']=$dato->correo_al;
                    $dat_generales['carrera']=$dato->carrera;
                    $dat_generales['semestre']=$dato->semestre;
                    $dat_generales['promedio']=$dato->promedio;
                    $dat_generales['descuento']=$dato->descuento." de descuento";
                    array_push($array_generales,$dat_generales);
                }
                $dat_carreras['dat_general']=$array_generales;
                array_push($array_carreras,$dat_carreras);
            }

            foreach ($array_carreras as $carrera)
            {
                $i=2;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:E1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(2, [
                        'Cuenta','Apellido paterno','Apellido materno', 'Nombre','Curp','Correo electronico','Carrera','Semestre','Promedio','descuento'
                    ]);
                    foreach ($carrera['dat_general'] as $generales)
                    {

                        $i++;
                        $sheet->row($i, [
                            $generales['cuenta'],$generales['apaterno'],$generales['amaterno'],$generales['nombre'],
                            $generales['curp_al'],$generales['correo_al'],$generales['carrera'],$generales['semestre'],
                            $generales['promedio'], $generales['descuento']
                        ]);
                    }

                });
            }
        })->export('xlsx');
        return back();
}
    public function exportar_beca_cien(){
        Excel::create('Solicitudes de beca aceptadas del 100 % de descuento',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {

                $dat_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_carreras['nom_carrera'] = $carrera->nombre;
                $dat_carreras['siglas'] = $carrera->siglas;
                $autorizados_profesionales=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,gnral_alumnos.correo_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$periodo.' and beca_autorizar.id_estado=5  
 and beca_descuento.id_descuento=1  and  gnral_carreras.id_carrera='.$carrera->id_carrera.'
 ORDER BY gnral_alumnos.apaterno ASC,gnral_alumnos.amaterno ASC,gnral_alumnos.nombre ASC');


                $array_generales=array();
                foreach ($autorizados_profesionales as $dato)
                {
                    $dat_generales['cuenta']=$dato->cuenta;
                    $dat_generales['nombre']=$dato->nombre;
                    $dat_generales['apaterno']=$dato->apaterno;
                    $dat_generales['amaterno']=$dato->amaterno;
                    $dat_generales['curp_al']=$dato->curp_al;
                    $dat_generales['correo_al']=$dato->correo_al;
                    $dat_generales['carrera']=$dato->carrera;
                    $dat_generales['semestre']=$dato->semestre;
                    $dat_generales['promedio']=$dato->promedio;
                    $dat_generales['descuento']=$dato->descuento." de descuento";
                    array_push($array_generales,$dat_generales);
                }
                $dat_carreras['dat_general']=$array_generales;
                array_push($array_carreras,$dat_carreras);
            }

            foreach ($array_carreras as $carrera)
            {
                $i=2;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:E1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(2, [
                        'Cuenta','Apellido paterno','Apellido materno', 'Nombre','Curp','Correo electronico','Carrera','Semestre','Promedio','descuento'
                    ]);
                    foreach ($carrera['dat_general'] as $generales)
                    {

                        $i++;
                        $sheet->row($i, [
                            $generales['cuenta'],$generales['apaterno'],$generales['amaterno'],$generales['nombre'],
                            $generales['curp_al'],$generales['correo_al'],$generales['carrera'],$generales['semestre'],
                            $generales['promedio'], $generales['descuento']
                        ]);
                    }

                });
            }
        })->export('xlsx');
        return back();
    }
    //
}
