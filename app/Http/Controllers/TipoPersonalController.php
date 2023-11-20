<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Gnral_Tipos_Personales;

class TipoPersonalController extends Controller
{

    public function index()
    {
        $personales = DB::table('gnral_tipos_personales')
                ->orderBy('id_tipo_personal', 'desc')
                ->get();
        return view('generales.tipo_personales',compact('personales'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
                'nombre_personal' => 'required'
                ]);

                $personales = array(
                    'descripcion' => mb_strtoupper($request->get('nombre_personal'),'utf-8')
                    );

                $agrega_personal=Gnral_Tipos_Personales::create($personales);
                flash('Los datos se han guardado correctamente','success');
                return redirect('/generales/personales');
    }

    public function show($id)
    {
        //
    }

    public function edit($id_personal)
    {
        $personales = DB::table('gnral_tipos_personales')
                ->orderBy('id_tipo_personal', 'desc')
                ->get();
        $personal_edit = Gnral_Tipos_Personales::find($id_personal);
        return view('generales.tipo_personales',compact('personales'))->with(['edit' => true, 'personal_edit' => $personal_edit]);
    }

    public function update(Request $request, $id_personal)
    {
        $this->validate($request,[
                'nombre_personal' => 'required'
                ]);

        $personales = array(
                'descripcion' => mb_strtoupper($request->get('nombre_personal'),'utf-8')
                    );

        Gnral_Tipos_Personales::find($id_personal)->update($personales);
        flash('Los datos se han modificado correctamente','success');
        return redirect('/generales/personales');
    }

    public function destroy($id_personal)
    {
        Gnral_Tipos_Personales::destroy($id_personal);
        flash('Los datos se han eliminado correctamente','success');
        return redirect('/generales/personales');
    }
}
