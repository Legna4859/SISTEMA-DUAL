<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\Carreras;
use App\Hrs_Distribucion_Horas;
use Session;

class DistribucionController extends Controller
{

    public function index()
    {
        $id_periodo=Session::get('periodotrabaja');
        $periodo=DB::selectOne('select gnral_periodos.periodo from gnral_periodos where gnral_periodos.id_periodo='.$id_periodo.'');
        $periodo=($periodo->periodo);

        $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
        $directivo=session()->has('directivo')?session()->has('directivo'):false;
        if($directivo==true)
        {
        $id_carrera=0;
        $carreras = DB::select('select *from gnral_carreras order by nombre');
        return view('formatos.distribucion_admin',compact('carreras','id_carrera','periodo'));
        }
        else if($jefe_division==true)
        {
            $id_carrera=Session::get('carrera');
            return $this->show($id_carrera);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id_carrera)
    {
        $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
        $directivo=session()->has('directivo')?session()->has('directivo'):false;
        Session::put('carrera_s',$id_carrera);

        $total_matr=0;
        $t_tr=0;
        $id_periodo=Session::get('periodotrabaja');
        $periodo=DB::selectOne('select gnral_periodos.periodo from gnral_periodos where gnral_periodos.id_periodo='.$id_periodo.'');
        $periodo=($periodo->periodo);

        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera id FROM gnral_periodo_carreras
            WHERE id_periodo='.$id_periodo.' AND id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id);

        $carreras = Carreras::all();

        $fecha_nuevo = DB::selectOne('select gnral_periodos.periodo from gnral_periodos where gnral_periodos.id_periodo='.$id_periodo.'');

        $resi_hrs=DB::selectOne('select COUNT(hrs_act_extra_clases.id_act_extra_clase) hrs_resi FROM 
            gnral_horarios,hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase, hrs_actividades_extras,
            gnral_periodo_carreras,gnral_carreras,gnral_periodos WHERE 
            hrs_actividades_extras.id_hrs_actividad_extra=20001 AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND gnral_carreras.id_carrera='.$id_carrera.' AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
            hrs_horario_extra_clase.id_cargo<>5 AND hrs_horario_extra_clase.id_cargo<>6 AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra ');
        $resi_hrs=($resi_hrs->hrs_resi);

                $resi_direc=DB::selectOne('select COUNT(hrs_act_extra_clases.id_act_extra_clase) hrs_resi FROM 
            gnral_horarios,hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase, hrs_actividades_extras,
            gnral_periodo_carreras,gnral_carreras,gnral_periodos WHERE 
            hrs_actividades_extras.id_hrs_actividad_extra=20001 AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND gnral_carreras.id_carrera='.$id_carrera.' AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
            hrs_horario_extra_clase.id_cargo BETWEEN 5 AND 6');
        $resi_direc=($resi_direc->hrs_resi);

        $claves_resi=DB::select('select DISTINCT gnral_personales.clave FROM 
            gnral_horarios,hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase, hrs_actividades_extras, 
            gnral_periodo_carreras,gnral_carreras,gnral_periodos,gnral_personales WHERE 
            hrs_actividades_extras.id_hrs_actividad_extra=20001 AND gnral_periodos.id_periodo='.$id_periodo.' AND 
            gnral_carreras.id_carrera='.$id_carrera.' AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
            gnral_horarios.id_personal=gnral_personales.id_personal');

        $datos_resi=array();

foreach($claves_resi as $clr)
{
    $nombrer['claver']= $clr->clave;
    array_push($datos_resi, $nombrer);
}

        $materias= DB::select('select DISTINCT gnral_materias_perfiles.id_materia_perfil mpf, 
            gnral_personales.clave,hrs_rhps.id_cargo,
            gnral_materias.id_materia idm,gnral_materias.nombre,
            gnral_materias.id_semestre,gnral_materias.hrs_practicas hrs_p, gnral_materias.hrs_teoria hrs_t,
            gnral_materias_perfiles.id_materia_perfil totales 
            FROM 
            gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,
            gnral_periodos,gnral_carreras,hrs_rhps,gnral_personales WHERE 
            gnral_carreras.id_carrera='.$id_carrera.'
            AND gnral_periodos.id_periodo='.$id_periodo.' AND 
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera ORDER BY id_semestre,idm');

            $nombre_materias=array();

            $cuenta=count($materias);
            for ($i=0; $i < $cuenta; $i++) 
            { 
                $materias[$i]->totales=($materias[$i]->hrs_p+$materias[$i]->hrs_t);
            }
            $total_mat=0;
            $t_t=0;
            $t_alum=0;
            $tru=0;
            $fals=0;
            $t_di=0;
            foreach($materias as $materia)
            {
                $idmateria=$materia->idm;

                $checar=DB::selectOne('select hrs_distribucion_horas.id_distribucion_hora id from hrs_distribucion_horas
                                WHERE hrs_distribucion_horas.id_periodo_carrera='.$id_periodo_carrera.' AND
                                hrs_distribucion_horas.id_materia='.$idmateria.'');
                $checar2= isset($checar->id)?$checar->id:0;

                if($checar2==0)
                {
                    $datos = array(
                    'no_alum' => 0,
                    'alum_otras_carreras' => 0,
                    'hrs_docente' => 0,
                    'hrs_dir_atm_hono' => 0,
                    'directivo' => 0,
                    'atm' => 0,
                    'honorarios' => 0,
                    'id_periodo_carrera' => $id_periodo_carrera,
                    'id_materia' => $idmateria
                    );

                    $agrega_distribucion=Hrs_Distribucion_Horas::create($datos);
                }
               $cantidad=DB::selectOne('select hrs_distribucion_horas.id_distribucion_hora,hrs_distribucion_horas.no_alum from hrs_distribucion_horas,gnral_periodo_carreras,
                gnral_carreras,gnral_periodos WHERE
                hrs_distribucion_horas.id_materia='.$idmateria.' AND
                gnral_carreras.id_carrera='.$id_carrera.' AND
                gnral_periodos.id_periodo='.$id_periodo.' AND
                hrs_distribucion_horas.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');
                //$cantidad=($cantidad->no_alum);

                    $grupos=DB::select('select DISTINCT gnral_horas_profesores.grupo 
                    FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,
                    gnral_periodo_carreras,gnral_periodos 
                    WHERE
                    gnral_materias_perfiles.id_materia_perfil='.$materia->mpf.' AND
                    gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                    gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                    gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                    gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

                    $no_grupos=count($grupos);
                    if($materia->id_cargo==5 || $materia->id_cargo==6)
                    {
                        $total_direc=$no_grupos*$materia->totales;
                        $total=0;
                    }
                    else
                    {
                        $total_direc=0;
                        $total=$no_grupos*$materia->totales;
                    }

                    $total_mat=$total_mat+$materia->totales;
                    $t_t=$t_t+$total;
                    $t_alum=$t_alum+$cantidad->no_alum;
                    $t_di=$t_di+$total_direc;

                    $nombrem['nombre_materia']= $materia->nombre;
                    $nombrem['id_materia']= $materia->idm;
                    $nombrem['id_semestre']= $materia->id_semestre;
                    $nombrem['no_grupos']=$no_grupos;
                    $nombrem['horas_totales']=$materia->totales;
                    $nombrem['id_distribucion']=$cantidad->id_distribucion_hora;
                    $nombrem['cantidad']=$cantidad->no_alum;
                    $nombrem['total']=$total;
                    $nombrem['total_direc']=$total_direc;
                    $nombrem['clave']=$materia->clave;

               /* $claves=DB::select('select distinct gnral_personales.clave from gnral_personales,gnral_horarios,gnral_horas_profesores,
                                    gnral_materias_perfiles, gnral_periodo_carreras, gnral_carreras,
                                    gnral_periodos where 
                                    gnral_materias_perfiles.id_materia='.$idmateria.' AND
                                    gnral_carreras.id_carrera='.$id_carrera.' AND
                                    gnral_periodos.id_periodo='.$id_periodo.' AND
                                    gnral_materias_perfiles.id_personal=gnral_personales.id_personal AND
                                    gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                                    gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                                    gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');
                $nombre_claves=array();
                    foreach($claves as $clave)
                    {
                         $nombrec['clave']= $clave->clave;
                         array_push($nombre_claves, $nombrec);
                    }
                    $nombrem['claves']=$nombre_claves;*/
                    array_push($nombre_materias, $nombrem);
            }
            $total_matr=$total_mat+$resi_hrs;
            $t_tr=$t_t+$resi_hrs;

if($jefe_division==true)
{
    return view('formatos.distribucion',compact('carreras','id_carrera',
                'fecha_nuevo','resi_hrs','total_matr','t_tr','t_alum','periodo','fals','t_di'))->with(['ver' => true, 'materiass' => $nombre_materias,'residencia' =>$datos_resi]); 
}
else if($directivo==true)
{
    return view('formatos.distribucion_admin',compact('carreras','id_carrera',
                'fecha_nuevo','resi_hrs','total_matr','t_tr','t_alum','periodo','t_di'))->with(['ver' => true, 'materiass' => $nombre_materias,'residencia' =>$datos_resi]); 
}
            
    }
    public function agregar_cantidad($id_distribucion,$cantidad)
    {
       $modi_cantdad=DB::select('update hrs_distribucion_horas SET no_alum='.$cantidad.' WHERE 
        hrs_distribucion_horas.id_distribucion_hora='.$id_distribucion.'');
       return back();
    }

    public function excel()
    {
        $id_carrera=Session::get('carrera_s');
        $carreran=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$id_carrera.'');

        Excel::create('Distribución de hrs.-', function($excel) 
        {
            $excel->sheet('DISTRIBUCION', function($sheet) 
            {
                            $id_carrera=Session::get('carrera_s');
            $carreran=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$id_carrera.'');
            $carreran=($carreran->nombre);
            
            $id_periodo=Session::get('periodotrabaja');
            $periodo=DB::selectOne('select gnral_periodos.periodo from gnral_periodos where gnral_periodos.id_periodo='.$id_periodo.'');
            $periodo=($periodo->periodo);

                $resi_hrs=DB::selectOne('select COUNT(hrs_act_extra_clases.id_act_extra_clase) hrs_resi FROM 
            gnral_horarios,hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase, hrs_actividades_extras,
            gnral_periodo_carreras,gnral_carreras,gnral_periodos WHERE 
            hrs_actividades_extras.id_hrs_actividad_extra=20001 AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND gnral_carreras.id_carrera='.$id_carrera.' AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra ');
        $resi_hrs=($resi_hrs->hrs_resi);

        $claves_resi=DB::select('select DISTINCT gnral_personales.clave FROM 
            gnral_horarios,hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase, hrs_actividades_extras, 
            gnral_periodo_carreras,gnral_carreras,gnral_periodos,gnral_personales WHERE 
            hrs_actividades_extras.id_hrs_actividad_extra=20001 AND gnral_periodos.id_periodo='.$id_periodo.' AND 
            gnral_carreras.id_carrera='.$id_carrera.' AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
            gnral_horarios.id_personal=gnral_personales.id_personal');

        $datos_resi=array();

foreach($claves_resi as $clr)
{
    $nombrer['claver']= $clr->clave;
    array_push($datos_resi, $nombrer);
}

        $materias= DB::select('select DISTINCT gnral_materias_perfiles.id_materia_perfil mpf,
            gnral_materias.id_materia idm,gnral_materias.nombre,
            gnral_materias.id_semestre,gnral_materias.hrs_practicas hrs_p, gnral_materias.hrs_teoria hrs_t,
            gnral_materias_perfiles.id_materia_perfil totales 
            FROM 
            gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,
            gnral_periodos,gnral_carreras WHERE 
            gnral_carreras.id_carrera='.$id_carrera.' 
            AND gnral_periodos.id_periodo='.$id_periodo.' AND 
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera ORDER BY id_semestre');

            $nombre_materias=array();

            $cuenta=count($materias);
            for ($i=0; $i < $cuenta; $i++) 
            { 
                $materias[$i]->totales=($materias[$i]->hrs_p+$materias[$i]->hrs_t);
            }
            $total_mat=0;
            $t_t=0;
            $t_alum=0;
            $tru=0;
            $fals=0;
            foreach($materias as $materia)
            {
                $idmateria=$materia->idm;

               $cantidad=DB::selectOne('select hrs_distribucion_horas.id_distribucion_hora,hrs_distribucion_horas.no_alum from hrs_distribucion_horas,gnral_periodo_carreras,
                gnral_carreras,gnral_periodos WHERE
                hrs_distribucion_horas.id_materia='.$idmateria.' AND
                gnral_carreras.id_carrera='.$id_carrera.' AND
                gnral_periodos.id_periodo='.$id_periodo.' AND
                hrs_distribucion_horas.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');
                //$cantidad=($cantidad->no_alum);

                    $grupos=DB::select('select DISTINCT gnral_horas_profesores.grupo 
                    FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,
                    gnral_periodo_carreras,gnral_periodos 
                    WHERE
                    gnral_materias_perfiles.id_materia_perfil='.$materia->mpf.' AND
                    gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                    gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                    gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                    gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

                    $no_grupos=count($grupos);
                    $total=$no_grupos*$materia->totales;

                    $total_mat=$total_mat+$materia->totales;
                    $t_t=$t_t+$total;
                    $t_alum=$t_alum+$cantidad->no_alum;

                    $nombrem['nombre_materia']= $materia->nombre;
                    $nombrem['id_materia']= $materia->idm;
                    $nombrem['id_semestre']= $materia->id_semestre;
                    $nombrem['no_grupos']=$no_grupos;
                    $nombrem['horas_totales']=$materia->totales;
                    $nombrem['id_distribucion']=$cantidad->id_distribucion_hora;
                    $nombrem['cantidad']=$cantidad->no_alum;
                    $nombrem['total']=$total;


                $claves=DB::select('select distinct gnral_personales.clave from gnral_personales,gnral_horarios,gnral_horas_profesores,
                                    gnral_materias_perfiles, gnral_periodo_carreras, gnral_carreras,
                                    gnral_periodos where 
                                    gnral_materias_perfiles.id_materia='.$idmateria.' AND
                                    gnral_carreras.id_carrera='.$id_carrera.' AND
                                    gnral_periodos.id_periodo='.$id_periodo.' AND
                                    gnral_materias_perfiles.id_personal=gnral_personales.id_personal AND
                                    gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                                    gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                                    gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');
                $nombre_claves=array();
                    foreach($claves as $clave)
                    {
                         $nombrec['clave']= $clave->clave;
                         array_push($nombre_claves, $nombrec);
                    }
                    $nombrem['claves']=$nombre_claves;
                    array_push($nombre_materias, $nombrem);
            }
            $total_matr=$total_mat+$resi_hrs;
            $t_tr=$t_t+$resi_hrs;

            $sheet->setWidth(array(
                    'A' => 12,
                    'B' => 65,
                    'C' => 34,
                    'D' => 29,
                    'E' => 46,
                    'F' => 65,
                    'G' => 31,
                    'H' => 24,
                    'I' => 19,
                    'J' => 14,
                    'K' => 22
                ));
                $sheet->loadView('formatos.partials.distribucion_admin',compact('resi_hrs','total_matr','t_tr',
                    't_alum','periodo','carreran'))->with(['materiass' => $nombre_materias,'residencia' =>$datos_resi]); 
            });

        })->export('xls');

        return back();
    }

    public function destroy($id)
    {
        //
    }
}
