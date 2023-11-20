<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Hrs_Aulas;
use App\Hrs_Edificios;
use App\Carreras;
use Session;

class AulaController extends Controller
{

    public function index()
    {
        $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
        $directivo=session()->has('directivo')?session()->has('directivo'):false;
        if($jefe_division==true)
        {
            $id_carrera=Session::get('carrera');

            $carreras =DB::select('select * from gnral_carreras order by nombre');
            $edificios = DB::select('select * from hrs_edificios order by nombre');

            $aulas = DB::select('select hrs_aulas.id_aula,hrs_aulas.id_aula,hrs_aulas.nombre aula,hrs_edificios.nombre edificio,
                hrs_aulas.comp estado,gnral_carreras.nombre carrera FROM 
                hrs_aulas,hrs_edificios,gnral_carreras where
                hrs_aulas.id_carrera='.$id_carrera.' and
                hrs_aulas.id_edificio=hrs_edificios.id_edificio and
               hrs_aulas.id_carrera=gnral_carreras.id_carrera order by hrs_aulas.id_aula desc');

            return view('generales.aulas',compact('aulas','carreras','edificios'));
        }
        else
        {
           $carreras =DB::select('select * from gnral_carreras order by nombre');
            $edificios = DB::select('select * from hrs_edificios order by nombre');
            $aulas = DB::select('select hrs_aulas.id_aula,hrs_aulas.id_aula,hrs_aulas.nombre aula,hrs_edificios.nombre edificio,
                hrs_aulas.comp estado,gnral_carreras.nombre carrera FROM 
                hrs_aulas,hrs_edificios,gnral_carreras where
                hrs_aulas.id_edificio=hrs_edificios.id_edificio and
               hrs_aulas.id_carrera=gnral_carreras.id_carrera order by hrs_aulas.id_aula desc');

            return view('generales.aulas',compact('aulas','carreras','edificios'));
        }
    }
    public function estado($id_aula)
    {
        $estado= DB::selectOne('select comp from hrs_aulas where id_aula='.$id_aula.'');
        $estado= ($estado->comp);

    if($estado==1)
        {
            //cambiar estado a 0
            $aulas_estado=DB::update('update hrs_aulas SET comp=0 where id_aula='.$id_aula.'');
            return redirect('/generales/aulas');
        }
        else
        {
            //cambiar estado a 1
            $aulas_estado=DB::update('update hrs_aulas SET comp=1 where id_aula='.$id_aula.'');
            return redirect('/generales/aulas');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre_aula' => 'required',
            'selectEstado' => 'required',
            'selectCarrera' => 'required',
            'selectEdificio' => 'required'
        ]);

        $aulas = array(
            'id_carrera' => $request->get('selectCarrera'),
            'nombre' => mb_strtoupper($request->get('nombre_aula'),'utf-8'),
            'id_edificio' => $request->get('selectEdificio'),
            'comp' => $request->get('selectEstado')
        );

        $agrega_aula=Hrs_Aulas::create($aulas);
        //flash('Los datos se han guardado correctamente','success');
        return redirect('/generales/aulas');
    }

    public function show($id)
    {
        //
    }

    public function edit($id_aula)
    {
        $carreras =DB::select('select * from gnral_carreras order by nombre');
            $edificios = DB::select('select * from hrs_edificios order by nombre');
        $aulas = DB::select('select hrs_aulas.id_aula,hrs_aulas.id_aula,hrs_aulas.nombre aula,hrs_edificios.nombre edificio,
            hrs_aulas.comp estado,gnral_carreras.nombre carrera FROM 
            hrs_aulas,hrs_edificios,gnral_carreras where
            hrs_aulas.id_edificio=hrs_edificios.id_edificio and
           hrs_aulas.id_carrera=gnral_carreras.id_carrera order by hrs_aulas.id_aula desc');
        $aula_edit = Hrs_Aulas::find($id_aula);
        return view('generales.aulas',compact('aulas','carreras','edificios'))->with(['edit' => true, 'aula_edit' => $aula_edit]);

    }

    public function update(Request $request, $id_aula)
    {
        $this->validate($request,[
            'nombre_aula' => 'required',
            'selectEstado' => 'required',
            'selectCarrera' => 'required',
            'selectEdificio' => 'required'
        ]);

        $aulas = array(
            'id_carrera' => $request->get('selectCarrera'),
            'nombre' => mb_strtoupper($request->get('nombre_aula'),'utf-8'),
            'id_edificio' => $request->get('selectEdificio'),
            'comp' => $request->get('selectEstado')
        );

        Hrs_Aulas::find($id_aula)->update($aulas);
        //flash('Los datos se han modificado correctamente','success');
        return redirect('/generales/aulas');
    }

    public function destroy($id_aula)
    {
        Hrs_Aulas::destroy($id_aula);
        //flash('Los datos se han eliminado correctamente','danger');
        return redirect('/generales/aulas');
    }
}
