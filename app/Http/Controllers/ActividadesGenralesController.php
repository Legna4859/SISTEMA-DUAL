<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\RegistroAlumnos;
use Session;

class ActividadesGenralesController extends Controller
{

    public function index()
    {

        $carreras = Session::get('carreras');
        $periodo=Session::get('periodo_actual');

        $cinco_creditos=DB::select('select gnral_alumnos.cuenta, gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno, SUM(creditos_finales.creditos) creditos,ROUND(AVG(creditos_finales.promedio)) promedio 
                                    FROM gnral_alumnos,actcomple_registro_alumnos,creditos_finales,gnral_periodos 
                                    WHERE gnral_alumnos.cuenta=actcomple_registro_alumnos.cuenta 
                                    and gnral_periodos.id_periodo=actcomple_registro_alumnos.id_periodo 
                                    and actcomple_registro_alumnos.id_registro_alumno=creditos_finales.id_registro_alumno 
                                    and gnral_periodos.id_periodo='.$periodo.'
                                    group by gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno');
        //elimino la variable creditos_finales
        return view('actividades_complementarias.jefatura.constancia_general',compact('cinco_creditos'));

        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //


    }

    public function show($id)
    {
        //
    }

    public function edit($cuenta)
    {
       
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
