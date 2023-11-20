<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Hrs_Actividades_Extras;

class ExtraClaseController extends Controller
{

    public function index()
    {
        $act_extras = DB::table('hrs_actividades_extras')->orderBy('id_hrs_actividad_extra', 'desc')->get();
        return view('generales.extra_clase',compact('act_extras'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
                $this->validate($request,[
            'nombre_act' => 'required',
        ]);

        $act_extras = array(
            'descripcion' => mb_strtoupper($request->get('nombre_act'),'utf-8')
        );

        $agrega_act=Hrs_Actividades_Extras::create($act_extras);
        //flash('Los datos se han guardado correctamente','success');
        return redirect('/generales/extra_clases');
    }

    public function show($id)
    {
        //
    }

    public function edit($id_extrac)
    {
        $act_extras = DB::table('hrs_actividades_extras')->orderBy('id_hrs_actividad_extra', 'desc')->get();
        $extrac_edit = Hrs_Actividades_Extras::find($id_extrac);
        return view('generales.extra_clase',compact('act_extras'))->with(['edit' => true, 'extrac_edit' => $extrac_edit]);
    }

    public function update(Request $request, $id_extrac)
    {
            $this->validate($request,[
            'nombre_act' => 'required',
        ]);

        $act_extras = array(
        'descripcion' => mb_strtoupper($request->get('nombre_act'),'utf-8')
        );

        Hrs_Actividades_Extras::find($id_extrac)->update($act_extras);
        //flash('Los datos se han modificado correctamente','success');
        return redirect('/generales/extra_clases');
    }

    public function destroy($id_act)
    {
        Hrs_Actividades_Extras::destroy($id_act);
        //flash('Los datos se han eliminado correctamente','danger');
        return redirect('/generales/extra_clases');
    }
}
