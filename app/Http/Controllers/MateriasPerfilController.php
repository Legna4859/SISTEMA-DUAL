<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Gnral_Materias_Perfiles;
use Session;

use App\Http\Requests;

class MateriasPerfilController extends Controller
{

    public function index($id_profesor)
    {
        $id_carrera=Session::get('carrera');
        $reticulas= DB::select('select *from gnral_reticulas WHERE gnral_reticulas.id_carrera='.$id_carrera.'');
        $datos_reticulas=array();

        $materias_doc=DB::select('select gnral_materias_perfiles.id_materia_perfil, gnral_materias.id_materia, gnral_materias.nombre
            FROM gnral_materias_perfiles, gnral_reticulas, gnral_materias
            WHERE gnral_materias_perfiles.id_materia = gnral_materias.id_materia
            AND gnral_materias.id_reticula = gnral_reticulas.id_reticula
            AND gnral_reticulas.id_carrera ='.$id_carrera.'
            AND gnral_materias_perfiles.id_personal = '.$id_profesor.' AND
            gnral_materias_perfiles.mostrar=1');

        foreach($reticulas as $reticula)
        {
            $nombre['id_reticula']= $reticula->id_reticula;
            $nombre['reticula']= $reticula->clave;

            $semestres=DB::select('select DISTINCT gnral_materias.id_semestre,gnral_semestres.descripcion semestre FROM 
                gnral_reticulas,gnral_materias,gnral_semestres WHERE gnral_reticulas.id_reticula='.$reticula->id_reticula.' AND
                gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
                gnral_materias.id_semestre=gnral_semestres.id_semestre order by id_semestre');
            $datos_semestres=array();
                if($semestres!=null)
                {
                    foreach($semestres as $semes) 
                    { 
                        $semestres=array();
                        $semestres['semestre']= $semes->semestre;
                        $semestres['id_semestre']= $semes->id_semestre;
                         $materias=DB::select('select gnral_materias.id_materia,gnral_materias.nombre,gnral_materias.clave,
                        gnral_materias.id_semestre ,gnral_materias.id_reticula from 
                        gnral_materias,gnral_reticulas WHERE 
                        gnral_materias.id_reticula='.$reticula->id_reticula.' AND 
                        gnral_materias.id_semestre='.$semes->id_semestre.' AND 
                        gnral_materias.id_reticula=gnral_reticulas.id_reticula');
                        $nombre_materias=array();
                        if($materias!=null)
                        {
                            foreach($materias as $mates)
                            {
                                $nombrem=array();
                                $nombrem['id_materia']= $mates->id_materia;
                                $nombrem['materia']= $mates->nombre;
                                $nombrem['clave']= $mates->clave;
                                $nombrem['id_semestre']= $mates->id_semestre;
                                $nombrem['id_reticula']= $mates->id_reticula;
                                array_push($nombre_materias,$nombrem);
                            }
                            $semestres["materias"]=$nombre_materias;
                            array_push($datos_semestres,$semestres);
                        }
                        else
                        {
                                $nombrem="No existen materias";
                                array_push($nombre_materias,$nombrem);

                            $semestres["materias"]=$nombre_materias;
                            array_push($datos_semestres,$semestres);
                        }
                    }
                    $nombre["semestres"]=$datos_semestres;
                    array_push($datos_reticulas,$nombre);
                }       
        }
        //dd($datos_reticulas);

        return view('docentes.partials.materias_perfil',compact('materias_doc'))->with('reticulas',$datos_reticulas);

        }
    public function agrega_materias(Request $request)
    {
        //$lugar=Session::get('lugar');
        $id_carrera=Session::get('carrera');
        $materias_doc=DB::select('select gnral_materias_perfiles.id_materia_perfil, gnral_materias.id_materia, gnral_materias.nombre
            FROM gnral_materias_perfiles, gnral_reticulas, gnral_materias
            WHERE gnral_materias_perfiles.id_materia = gnral_materias.id_materia
            AND gnral_materias.id_reticula = gnral_reticulas.id_reticula
            AND gnral_reticulas.id_carrera ='.$id_carrera.'
            AND gnral_materias_perfiles.id_personal = '.$request->get('prof').' AND
            gnral_materias_perfiles.mostrar=1');

        $arr_mate=(explode(',', $request->get('materias')));
        $ciclo=count($arr_mate);

        for ($i=0; $i < $ciclo; $i++) 
        { 
            $mate_prof = DB::selectOne('select gnral_materias_perfiles.id_materia_perfil from 
                gnral_materias_perfiles WHERE gnral_materias_perfiles.id_personal='.$request->get('prof').' 
                AND gnral_materias_perfiles.id_materia='.$arr_mate[$i].' ');
            if ($mate_prof==null) 
            {
                $materias = array(
                    'id_personal' => $request->get('prof'),
                    'id_materia' => $arr_mate[$i],
                    'mostrar' => 1
                    );
               $agrega_materia=Gnral_Materias_Perfiles::create($materias);
            }
            else
            {
                $mate_prof1=($mate_prof->id_materia_perfil);
                $materias = array(
                    'id_personal' => $request->get('prof'),
                    'id_materia' => $arr_mate[$i],
                    'mostrar' => 1
                    );
                Gnral_Materias_Perfiles::find($mate_prof1)->update($materias);
            }
        }
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
