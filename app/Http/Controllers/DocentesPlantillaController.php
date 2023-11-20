<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Horarios;
use Session;

class DocentesPlantillaController extends Controller
{

    public function index()
    {
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera = DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$id_periodo.' AND
            id_carrera='.$id_carrera.'');
        $id_periodo_carrera=$id_periodo_carrera->id_periodo_carrera;

        $docentes = DB::select('select gnral_personales.id_personal,gnral_personales.clave, gnral_personales.nombre,
                                gnral_perfiles.descripcion,gnral_personales.fch_recontratacion FROM
                                gnral_personales,gnral_perfiles WHERE
                                gnral_personales.id_perfil=gnral_perfiles.id_perfil AND 
                                gnral_personales.id_personal NOT IN 
                                (select gnral_personales.id_personal FROM 
                                gnral_personales,gnral_horarios WHERE 
                                gnral_horarios.id_periodo_carrera='.$id_periodo_carrera.' AND 
                                gnral_horarios.id_personal=gnral_personales.id_personal)');

        $plantillas = DB::select('select gnral_personales.id_personal,gnral_personales.nombre FROM
                                gnral_personales, gnral_horarios WHERE
                                gnral_horarios.id_periodo_carrera='.$id_periodo_carrera.' AND
                                gnral_horarios.id_personal=gnral_personales.id_personal');

        return view('plantilla.docentes_plantilla',compact('docentes','plantillas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$id_periodo.' AND
            id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id_periodo_carrera);

            $this->validate($request,[
            'docente' => 'required'
        ]);

        $docentes = array(
            'id_periodo_carrera' => $id_periodo_carrera,
            'id_personal' => $request->get('docente'),
            'aprobado' => 0
        );
        $id_profesor=$request->get('docente');

        $comprobar = DB::selectOne('select id_horario_profesor from gnral_horarios WHERE 
            id_personal='.$id_profesor.' AND id_periodo_carrera ='.$id_periodo_carrera.'');

        $comprobar = isset($comprobar->id_horario_profesor)?$comprobar->id_horario_profesor:0;
        if($comprobar==0)
        {
            $agrega_docente=Horarios::create($docentes);
            return redirect('/plantilla/docentes');
        }
        else
        {
            return redirect('/plantilla/docentes');
        } 
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

    public function destroy($id_docente)
    {
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where id_periodo='.$id_periodo.' AND
            id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id_periodo_carrera);

        $comprobar = DB::selectOne('select id_horario_profesor from gnral_horarios WHERE 
            id_personal='.$id_docente.' AND id_periodo_carrera ='.$id_periodo_carrera.'');
        $comprobar = ($comprobar->id_horario_profesor);

        Horarios::destroy($comprobar);
        return redirect('/plantilla/docentes');
    }
}
