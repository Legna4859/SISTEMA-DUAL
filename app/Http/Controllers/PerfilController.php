<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Gnral_Perfiles;

class PerfilController extends Controller
{

    public function index()
    {
        $perfiles = DB::table('gnral_perfiles')
        ->orderBy('descripcion', 'asc')
        ->get();
        return view('generales.perfiles',compact('perfiles'));
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

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre_perfil' => 'required',
        ]);

        $perfiles = array(
            'descripcion' => mb_strtoupper($request->get('nombre_perfil'),'utf-8')
        );

        $agrega_perfil=Gnral_Perfiles::create($perfiles);
        //flash('Los datos se han guardado correctamente','success');
        return redirect('/generales/perfiles');
    }

    public function show($id)
    {
        //
    }

    public function edit($id_perfil)
    {
        $perfiles = DB::table('gnral_perfiles')
        ->orderBy('descripcion', 'asc')
        ->get();
        $perfil_edit = Gnral_Perfiles::find($id_perfil);
        return view('generales.perfiles',compact('perfiles'))->with(['edit' => true, 'perfil_edit' => $perfil_edit]);
    
    }

    public function update(Request $request, $id_perfil)
    {
        $this->validate($request,[
            'nombre_perfil' => 'required',
            ]);

        $perfiles = array(
                    'descripcion' => mb_strtoupper($request->get('nombre_perfil'),'utf-8')
                    );

        Gnral_Perfiles::find($id_perfil)->update($perfiles);
        //flash('Los datos se han modificado correctamente','success');
        return redirect('/generales/perfiles');
    }

    public function destroy($id_perfil)
    {
        Gnral_Perfiles::destroy($id_perfil);
        //flash('Los datos se han eliminado correctamente','success');
        return redirect('/generales/perfiles');
    }
}
