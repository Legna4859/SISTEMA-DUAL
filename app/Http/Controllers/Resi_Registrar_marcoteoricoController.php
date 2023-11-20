<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class Resi_Registrar_marcoteoricoController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');

        $sin_marco_teorico=DB::selectOne('SELECT count(resi_marco_teorico.id_marco_teorico) numero from resi_marco_teorico WHERE resi_marco_teorico.id_anteproyecto='.$anteproyecto->id_anteproyecto.'');

        $sin_marco_teorico=$sin_marco_teorico->numero;
        if($sin_marco_teorico ==0){
            $marco_teorico=" ";


        }
        if($sin_marco_teorico ==1){
            $marc_te=DB::selectOne('SELECT *from resi_marco_teorico WHERE resi_marco_teorico.id_anteproyecto='.$anteproyecto->id_anteproyecto.'');
            $marco_teorico=$marc_te->marco_teorico;



        }
        $enviado_anteproyecto=DB::selectOne('select resi_anteproyecto.estado_enviado proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $enviado_anteproyecto=$enviado_anteproyecto->proy;
        return view('residencia.partials.marco_teorico',compact('sin_marco_teorico','marco_teorico','enviado_anteproyecto'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'sin_marco_teorico' => 'required',
            'marco_teorico' => 'required',
        ]);

        $sin_marco_teorico = $request->input("sin_marco_teorico");
        $marco_teorico = $request->input("marco_teorico");
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $periodo = Session::get('periodo_actual');
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $id_anteproyecto=$anteproyecto->id_anteproyecto;
        if($sin_marco_teorico== 0) {
            DB:: table('resi_marco_teorico')->insert(['id_anteproyecto' => $id_anteproyecto, 'marco_teorico' => $marco_teorico]);
        }
        if($sin_marco_teorico == 1){

            DB::update("UPDATE resi_marco_teorico SET marco_teorico = '$marco_teorico' WHERE resi_marco_teorico.id_anteproyecto=$id_anteproyecto");
        }
        return back();
    }
}
