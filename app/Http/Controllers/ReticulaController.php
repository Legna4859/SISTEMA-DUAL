<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Carreras;
use App\Gnral_Materias;
use App\Semestres;
use App\Gnral_Reticulas;
use Session;

class ReticulaController extends Controller
{

    public function index()
    {
        $id_carrera=Session::get('carrera');
        $id_carrera2=$id_carrera;
        $semestres = DB::select('select *from gnral_semestres order by id_semestre');
        $carreras = DB::select('select *from gnral_carreras order by nombre');

        $reticulas = DB::table('gnral_reticulas')->where('id_carrera', $id_carrera)->get();
        $id_reticula2 =0;
    
        return view('reticulas.materias',compact('semestres','reticulas','id_reticula2','carreras','id_carrera2'));

    }
    public function mostrar_reticulasd($id_carrera)
    {
        $reticulas = DB::select('select *from gnral_reticulas where id_carrera='.$id_carrera.'');
    
        return compact('reticulas');
    }
    public function agrega_reticulas($nombre_reticula)
    {
        $id_carrera=Session::get('carrera');
        $reticulass = array(
            'clave' => mb_strtoupper($nombre_reticula,'utf-8'),
            'id_carrera' => $id_carrera
        );
        $agrega_reti=Gnral_Reticulas::create($reticulass);

        return redirect('/reticulass');
    }
    public function mostrar_reticulas($id_reticula)
    {
        $id_carrera=Session::get('carrera');
        Session::put('id_reticulass',$id_reticula);
        $semestres=DB::select('select DISTINCT gnral_materias.id_semestre,gnral_semestres.descripcion semestre FROM 
            gnral_reticulas,gnral_materias,gnral_semestres WHERE gnral_reticulas.id_reticula='.$id_reticula.' AND
            gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
            gnral_materias.id_semestre=gnral_semestres.id_semestre order by gnral_semestres.id_semestre');
        $datos_semestres=array();

        if($semestres!=null)
        {
            foreach($semestres as $semes) 
            { 
                $nombre['semestre']= $semes->semestre;
                $nombre['id_semestre']= $semes->id_semestre;

                $materias=DB::select('select gnral_materias.id_materia,gnral_materias.nombre,
                gnral_materias.clave,gnral_materias.hrs_practicas,gnral_materias.hrs_teoria,gnral_materias.creditos,
                gnral_materias.id_semestre ,gnral_materias.id_reticula from 
                gnral_materias,gnral_reticulas WHERE 
                gnral_materias.id_reticula='.$id_reticula.' AND 
                gnral_materias.id_semestre='.$semes->id_semestre.' AND 
                gnral_materias.id_reticula=gnral_reticulas.id_reticula');
                $nombre_materias=array();

                foreach($materias as $mates)
                {
                    $nombrem['id_materia']= $mates->id_materia;
                    $nombrem['materia']= $mates->nombre;
                    $nombrem['clave']= $mates->clave;
                    $nombrem['hrs_p']= $mates->hrs_practicas;
                    $nombrem['hrs_t']= $mates->hrs_teoria;
                    $nombrem['creditos']= $mates->creditos;
                    $nombrem['id_semestre']= $mates->id_semestre;
                    $nombrem['id_reticula']= $mates->id_reticula;
                    array_push($nombre_materias,$nombrem);
                }
                $nombre["materias"]=$nombre_materias;
                array_push($datos_semestres,$nombre);
            }
        }
        return view('reticulas.partialsg.partial_materias')->with('semestres', $datos_semestres);
    }
    public function mostrar_reticulas_direc($id_carrera,$id_reticula)
    {
        $semestres=DB::select('select DISTINCT gnral_materias.id_semestre,gnral_semestres.descripcion semestre FROM 
            gnral_reticulas,gnral_materias,gnral_semestres WHERE gnral_reticulas.id_reticula='.$id_reticula.' AND
            gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
            gnral_materias.id_semestre=gnral_semestres.id_semestre order by gnral_semestres.id_semestre');
        $datos_semestres=array();

        if($semestres!=null)
        {
            foreach($semestres as $semes) 
            { 
                $nombre['semestre']= $semes->semestre;
                $nombre['id_semestre']= $semes->id_semestre;

                $materias=DB::select('select gnral_materias.id_materia,gnral_materias.nombre,
                gnral_materias.clave,gnral_materias.hrs_practicas,gnral_materias.hrs_teoria,gnral_materias.creditos,
                gnral_materias.id_semestre ,gnral_materias.id_reticula from 
                gnral_materias,gnral_reticulas WHERE 
                gnral_materias.id_reticula='.$id_reticula.' AND 
                gnral_materias.id_semestre='.$semes->id_semestre.' AND 
                gnral_materias.id_reticula=gnral_reticulas.id_reticula');
                $nombre_materias=array();

                foreach($materias as $mates)
                {
                    $nombrem['id_materia']= $mates->id_materia;
                    $nombrem['materia']= $mates->nombre;
                    $nombrem['clave']= $mates->clave;
                    $nombrem['hrs_p']= $mates->hrs_practicas;
                    $nombrem['hrs_t']= $mates->hrs_teoria;
                    $nombrem['creditos']= $mates->creditos;
                    $nombrem['id_semestre']= $mates->id_semestre;
                    $nombrem['id_reticula']= $mates->id_reticula;
                    array_push($nombre_materias,$nombrem);
                }
                $nombre["materias"]=$nombre_materias;
                array_push($datos_semestres,$nombre);
            }
        }
        return view('reticulas.partialsg.partial_materias')->with('semestres', $datos_semestres);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre_materia' => 'required',
            'clave_materia' => 'required',
            'semestre' => 'required',
            'hrs_p' => 'required',
            'hrs_t' => 'required',
            'hrs_p' => 'required',
            'uni' => 'required',
            'especial' => 'required',
            'creditos' => 'required',
        ]);

        $hrsp=$request->get('hrs_p');
        $hrst=$request->get('hrs_t');

        if ($hrst==0 && $hrsp==0) 
        {
           Session::put('id_reticulas', $request->get('reticula'));
            $id_reticula = Session::get('id_reticulas');
            //flash('El número de horas es incorrecto','danger');
            return $this->mostrar_reticulas($id_reticula);
        }
        else
        {
            $materias = array(
            'nombre' => mb_strtoupper($request->get('nombre_materia'),'utf-8'),
            'clave' => mb_strtoupper($request->get('clave_materia'),'utf-8'),
            'hrs_practicas' => $request->get('hrs_p'),
            'hrs_teoria' => $request->get('hrs_t'),
            'id_reticula' => $request->get('reticula'),
            'id_semestre' => $request->get('semestre'),
            'creditos' => $request->get('creditos'),
            'unidades' => $request->get('uni'),
            'especial' => $request->get('especial')
        );

            Session::put('id_reticulas', $request->get('reticula'));
            $id_reticula = Session::get('id_reticulas');
            $agrega_materia=Gnral_Materias::create($materias);

            return $this->mostrar_reticulas($id_reticula);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id_materia)
    {
        $id_carrera=Session::get('carrera');
        $semestres = DB::select('select *from gnral_semestres order by id_semestre');

        $id_reticula1 = Session::get('id_reticulass');
        $comprueba = DB::selectOne('select DISTINCT gnral_materias.nombre FROM
                                hrs_rhps,gnral_materias,gnral_materias_perfiles,gnral_horas_profesores WHERE
                                gnral_materias_perfiles.id_materia='.$id_materia.' AND
                                gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                                gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                                hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');
        if ($comprueba==null) 
        {
            $no_ver=0;
            Session::put('no_ver',$no_ver);
        }
        else
        {
            $no_ver=1;
            Session::put('no_ver',$no_ver);
        }
        //echo($no_ver);
        $materia_edit = Gnral_Materias::find($id_materia);
        return view('reticulas.partialsg.partial_mo_reticula',compact('semestres'))->with(['materia_edit' => $materia_edit,'no_ver' => $no_ver]);
        //return $this->mostrar_reticulas($id_reticula1)->with(['edit' => true, 'materia_edit' => $materia_edit,'no_ver' => $no_ver]);
    }

    public function update(Request $request, $id_materia)
    {
        //dd($request);
        $this->validate($request,[
            'nombre_materia' => 'required',
            'clave_materia' => 'required',
            'hrs_p' => 'required',
            'hrs_t' => 'required',
            'uni' => 'required',
            'especial' => 'required',
            'creditos' => 'required'
        ]);
        $no_ver = Session::get('no_ver');
        if ($no_ver==0) 
        {
            $materias = array(
            'nombre' => mb_strtoupper($request->get('nombre_materia'),'utf-8'),
            'clave' => mb_strtoupper($request->get('clave_materia'),'utf-8'),
            'hrs_practicas' => $request->get('hrs_p'),
            'hrs_teoria' => $request->get('hrs_t'),
            'id_reticula' => Session::get('id_reticulass'),
            'id_semestre' => $request->get('semestre'),
            'creditos' => $request->get('creditos'),
            'unidades' => $request->get('uni'),
            'especial' => $request->get('especial')
            );
        }
        else
        {
            $materias = array(
            'nombre' => mb_strtoupper($request->get('nombre_materia'),'utf-8'),
            'clave' => mb_strtoupper($request->get('clave_materia'),'utf-8'),
            'hrs_practicas' => $request->get('hrs_p'),
            'hrs_teoria' => $request->get('hrs_t'),
            'id_reticula' => Session::get('id_reticulass'),
            'creditos' => $request->get('creditos'),
            'unidades' => $request->get('uni'),
            'especial' => $request->get('especial')
            );
        }
        Gnral_Materias::find($id_materia)->update($materias);
        $id_carrera=Session::get('carrera');
        $id_reticula2 = Session::get('id_reticulass');
        $semestres = DB::select('select *from gnral_semestres order by id_semestre');
        $reticulas = DB::table('gnral_reticulas')->where('id_carrera', $id_carrera)->get();
    
        return view('reticulas.materias',compact('semestres','reticulas','id_reticula2'));
    }

    public function destroy($id_materia,Request $request)
    {
        Gnral_Materias::destroy($id_materia);
        $id_carrera=Session::get('carrera');
        $id_reticula2 = Session::get('id_reticulass');
        $semestres = DB::select('select *from gnral_semestres order by id_semestre');
        $reticulas = DB::table('gnral_reticulas')->where('id_carrera', $id_carrera)->get();
    
        return view('reticulas.materias',compact('semestres','reticulas','id_reticula2'));
    }
}
