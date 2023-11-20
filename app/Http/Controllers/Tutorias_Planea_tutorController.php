<?php
namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tutorias_Planeacion;
use App\Tutorias_Exp_asigna_generacion;

class Tutorias_Planea_tutorController extends Controller
{
    public function index()
    {
        $tabla=Tutorias_Exp_asigna_generacion::getDatosTut();
        $tabla1=Tutorias_Exp_asigna_generacion::getDatosAct();
//dd($tabla1);
        return view('tutorias.profesor.planeacion',compact('tabla','tabla1'));
    }


    public function update(Request $request, $id)
    {
        $plan = Tutorias_Planeacion::find($id);
        $plan->id_estado = $request->id_estado;
        $plan->comentarios = $request->get('comentarios');
        $plan->sugerencia = $request->get('sugerencia');
        $plan->id_sugerencia = $request->get('id_sugerencia');
        $plan->id_estrategia = $request->id_estrategia;
        $plan->estrategia = $request->estrategia;
        $plan->id_evidencia = $request->id_evidencia;
        $plan->save();
        //return redirect()->back();
        //return('ok');
    }

}
