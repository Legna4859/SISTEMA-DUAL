<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Gnral_Personales;
use App\Gnral_Materias;
use App\Gnral_Cargos;
use App\Gnral_Perfiles;
use App\Hrs_Situaciones;
use App\Gnral_Materias_Perfiles;
use App\Abreviaciones;
use App\Abreviaciones_prof;
use Session;


class DocentesController extends Controller
{
     
    public function index()
    {   
        $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
        $directivo=session()->has('directivo')?session()->has('directivo'):false;

        $docentes= DB::select('select gnral_personales.id_personal,gnral_personales.nombre,gnral_personales.esc_procedencia,
        gnral_personales.origen_nac,gnral_personales.fch_nac,gnral_personales.direccion,
        gnral_personales.fch_ingreso_tesvb,gnral_personales.nombramiento,
        gnral_personales.rfc,gnral_personales.fch_recontratacion,gnral_personales.escolaridad,
        gnral_personales.clave,gnral_personales.horas_maxima,gnral_personales.correo,
        gnral_personales.telefono,gnral_personales.celular,gnral_personales.cedula,gnral_personales.sexo
        ,gnral_personales.maximo_horas_ingles,hrs_situaciones.situacion,gnral_perfiles.descripcion,gnral_cargos.cargo,
        gnral_personales.id_cargo
        FROM 
        gnral_personales,gnral_perfiles,hrs_situaciones,gnral_cargos WHERE
        gnral_personales.id_perfil=gnral_perfiles.id_perfil AND
        gnral_personales.id_situacion=hrs_situaciones.id_situacion AND
        gnral_personales.id_cargo=gnral_cargos.id_cargo 
        UNION
        select gnral_personales.id_personal,gnral_personales.nombre,gnral_personales.esc_procedencia,
        gnral_personales.origen_nac,gnral_personales.fch_nac,gnral_personales.direccion,
        gnral_personales.fch_ingreso_tesvb,gnral_personales.nombramiento,
        gnral_personales.rfc,gnral_personales.fch_recontratacion,gnral_personales.escolaridad,
        gnral_personales.clave,gnral_personales.horas_maxima,gnral_personales.correo,
        gnral_personales.telefono,gnral_personales.celular,gnral_personales.cedula,gnral_personales.sexo
        ,gnral_personales.maximo_horas_ingles,hrs_situaciones.situacion,gnral_perfiles.descripcion,"AUN NO ASIGNADO",
        "0" id_cargo
        FROM 
        gnral_personales,gnral_perfiles,hrs_situaciones,gnral_cargos WHERE
        gnral_personales.id_perfil=gnral_perfiles.id_perfil AND
        gnral_personales.id_situacion=hrs_situaciones.id_situacion AND
        gnral_personales.id_cargo NOT IN (SELECT gnral_cargos.id_cargo FROM gnral_cargos) ORDER BY clave');

        if($jefe_division==true)
        {
            $id_carrera=Session::get('carrera');
        $reticulas= DB::select('select *from gnral_reticulas WHERE gnral_reticulas.id_carrera='.$id_carrera.'');
       $datos_docente=array();

            foreach($docentes as $docent)
            {
                $nombre['nombre']= $docent->nombre;
                $nombre['id_personal']= $docent->id_personal;
                $nombre['clave']= $docent->clave;
                $nombre['situacion']= $docent->situacion;
                $nombre['origen_nac']= $docent->origen_nac;
                $nombre['fch_ingreso_tesvb']= $docent->fch_ingreso_tesvb;
                $nombre['rfc']= $docent->rfc;
                $nombre['id_cargo']= $docent->id_cargo;
                $nombre['cargo']= $docent->cargo;
                $nombre['fch_recontratacion']=$docent->fch_recontratacion;

                $materias = DB::select('select gnral_materias_perfiles.id_materia_perfil, gnral_materias.id_materia, gnral_materias.nombre,
                gnral_reticulas.clave
                FROM gnral_materias_perfiles, gnral_reticulas, gnral_materias
                WHERE gnral_materias_perfiles.id_materia = gnral_materias.id_materia
                AND gnral_materias.id_reticula = gnral_reticulas.id_reticula
                AND gnral_reticulas.id_carrera ='.$id_carrera.'
                AND gnral_materias_perfiles.id_personal = '.$docent->id_personal.' AND
                gnral_materias_perfiles.mostrar=1');

                $nombre_materias=array();
                foreach($materias as $materia)
                {
                    $nombrem['nombre_materia']= $materia->nombre;
                    $nombrem['id_materia']= $materia->id_materia;
                    $nombrem['id_materia_perfil']= $materia->id_materia_perfil;
                    array_push($nombre_materias, $nombrem);

                }
                $nombre['materias']=$nombre_materias;
                array_push($datos_docente,$nombre);
            }
        
    //$datos_docente=(json_encode($datos_docente,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
   // dd($datos_docente);
            return view('docentes.mostrar_docentes',compact('reticulas'))->with('docentesss',$datos_docente);
        }
        else
        {
            return view('docentes.mostrar_docentes',compact('docentes'));
        }
        
    }

    public function editar($id_personal)
    {
        Session::put('id_personal',$id_personal);
         $cargos = DB::select('select *from gnral_cargos order by cargo');
         $docente_edit = Gnral_Personales::find($id_personal);
         return view('docentes.partials.partial_mo_docente',compact('cargos'))->with(['edit' => true, 'docente_edit' => $docente_edit]);
    }

    public function actualizar($cargo,$hrs_max,$hrs_m_i)
    {
        $id_personal=Session::get('id_personal');
       $docentes=array(
        'id_cargo' => $cargo,
        'horas_maxima' => $hrs_max,
        'maximo_horas_ingles' => $hrs_m_i
        );
        Gnral_Personales::find($id_personal)->update($docentes);
        return redirect('/docente');
    }

    public function show($id)
    {
        //
    }

    public function edit($usuario)
    {
        Session::put('id_usuario',$usuario);
        $var_error=Session::get("error"); 
        $ok = !empty($var_error)?"true":"false"; 

        $id_doc=DB::selectOne('select gnral_personales.id_personal from gnral_personales where tipo_usuario='.$usuario.' ');
        $id_docente=($id_doc->id_personal);

        $cargos = DB::select('select *from gnral_cargos order by cargo');
        $perfiles = DB::select('select *from gnral_perfiles order by descripcion');
        $situaciones = DB::select('select *from hrs_situaciones order by situacion');
        $abreviaciones= DB::select('select *from abreviaciones order by titulo');
        $docente_edit = Gnral_Personales::find($id_docente);
        $abre_doc1=DB::selectOne('select abreviaciones_prof.id_abreviacion from abreviaciones_prof WHERE 
            abreviaciones_prof.id_personal='.$id_docente.'');
        $abre_doc = isset($abre_doc1->id_abreviacion)?$abre_doc1->id_abreviacion:0;
 //se elimino la variable personales
        return view('docentes.docentes_edit',compact('cargos','perfiles','situaciones','abreviaciones','abre_doc','ok'))->with(['edit' => true, 'docente_edit' => $docente_edit]);
    }

    public function update(Request $request, $id_docente)
    {
        $usuario=Session::get('id_usuario');
        $depto=DB::selectOne('select gnral_personales.id_departamento,gnral_personales.horas_maxima,
        gnral_personales.id_cargo,gnral_personales.maximo_horas_ingles from gnral_personales 
            where gnral_personales.tipo_usuario='.$usuario.' ');

        $id_abreviacion=$request->get('selectAbreviacion');

        $clave2=$request->get('clave_docente');
        $menos=strlen($clave2);

        if($menos<8)
        {
            $cadena1="";
            $cadena="";
            $tam=8-$menos;
            for ($i=0; $i < $tam; $i++) 
            { 
                 $cadena1.="0";
            }
            $cadena.=$cadena1.$request->get('clave_docente'); 
            $clave=$cadena;
        }

        else
        {
            $clave=$request->get('clave_docente'); 
        }

        $this->validate($request,[
                'nombre_docente' => 'required',
                'clave_docente' => 'required',
                'rfc'=> 'required',
                'esc_p'=> 'required',
                'dir'=> 'required',
                'correo' => 'required',
                'selectPerfil' => 'required',
                'selectSituacion' => 'required',
                'o_nac' => 'required',
                'f_nac' => 'required',
                'f_ingreso' => 'required',
                'selectNombra' => 'required',
                'f_contrata' => 'required',
                'selectEsc' => 'required',
                'telefono' => 'required',
                'celular' => 'required',
                'cedula' => 'required',
                'selectSexo' => 'required',
                'selectAbreviacion' => 'required'
            ]);
                
                $personales = array(
                'nombre' => mb_strtoupper($request->get('nombre_docente'),'utf-8'),
                'clave' => $clave,
                'rfc' => mb_strtoupper($request->get('rfc'),'utf-8'),
                'esc_procedencia' => mb_strtoupper($request->get('esc_p'),'utf-8'),
                'direccion' => mb_strtoupper($request->get('dir'),'utf-8'),
                'correo' => mb_strtoupper($request->get('correo'),'utf-8'),
                'id_perfil' => $request->get('selectPerfil'),
                'id_situacion' => $request->get('selectSituacion'),
                'origen_nac' => mb_strtoupper($request->get('o_nac'),'utf-8'),
                'fch_nac' => $request->get('f_nac'),
                'fch_ingreso_tesvb' => $request->get('f_ingreso'),
                'nombramiento' => $request->get('selectNombra'),
                'fch_recontratacion' => $request->get('f_contrata'),
                'escolaridad' => mb_strtoupper($request->get('selectEsc'),'utf-8'),
                'id_cargo' => $depto->id_cargo,
                'horas_maxima' => $depto->horas_maxima,
                'telefono' => $request->get('telefono'),
                'celular' => $request->get('celular'),
                'cedula' => $request->get('cedula'),
                'sexo' => $request->get('selectSexo'),
                'maximo_horas_ingles' => $depto->maximo_horas_ingles,
                'id_abreviacion' => $request->get('selectAbreviacion'),
                'id_departamento' => $depto->id_departamento
                );
        
        $cadena="";
                $cadena.=$clave;
                $cadena1="";
                $cadena1.=$request->get('rfc');

        Gnral_Personales::find($id_docente)->update($personales);

        $personal=DB::selectOne('select id_personal from gnral_personales where
                        rfc="'.$cadena1.'" and clave="'.$cadena.'"');
        $personal=($personal->id_personal);

        $checa=DB::selectOne('select id_abreviacion_prof from abreviaciones_prof where
            id_personal='.$personal.'');
        $checa2=isset($checa->id_abreviacion_prof)?$checa->id_abreviacion_prof:0;
        if($checa2==0)
        {
            $abreviacion=array(
                        'id_abreviacion' => $id_abreviacion,
                        'id_personal' => $personal);

            $agrega_abrev=Abreviaciones_prof::create($abreviacion);
        }
        else
        {
            $abreviacion=array(
                        'id_abreviacion' => $id_abreviacion,
                        'id_personal' => $personal);

            Abreviaciones_prof::find($checa->id_abreviacion_prof)->update($abreviacion);
        }
        $mensage_carga='DATOS GUARDADOS EXITOSAMENTE';
        $color=2;
        return view('evaluacion_docente.Alumnos.mensages',compact('mensage_carga','color'));
    }
    
    public function destroy($id_materia)
    {
        $materias = array(
                    'mostrar' => 0
                    );
        Gnral_Materias_Perfiles::find($id_materia)->update($materias);
        return redirect('/docente');
    }
    public function eliminar($id)
    {
        Gnral_Personales::find($id)-> delete();
        return redirect('/docente');
    }
}

?>
