<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Tutorias_Planeacion;
class Tutorias_Coordina_peticionesController extends Controller
{
    public function index(Request $request)
    {
        $s1=DB::select('SELECT gnral_semestres.descripcion, gnral_carreras.nombre, planeacion.desc_actividad,planeacion.sugerencia,planeacion.id_planeacion
                        FROM gnral_semestres,gnral_carreras,planeacion,asigna_tutor
                        WHERE asigna_tutor.id_semestre=gnral_semestres.id_semestre
                        and asigna_tutor.id_carrera=gnral_carreras.id_carrera
                        and planeacion.id_semestre=asigna_tutor.id_semestre
                        and planeacion.id_sugerencia=0
                        and planeacion.id_semestre=1;');
        $s2=DB::select('SELECT gnral_semestres.descripcion, gnral_carreras.nombre, planeacion.desc_actividad,planeacion.sugerencia,planeacion.id_planeacion
                        FROM gnral_semestres,gnral_carreras,planeacion,asigna_tutor
                        WHERE asigna_tutor.id_semestre=gnral_semestres.id_semestre
                        and asigna_tutor.id_carrera=gnral_carreras.id_carrera
                        and planeacion.id_semestre=asigna_tutor.id_semestre
                        and planeacion.id_sugerencia=0
                        and planeacion.id_semestre=2;');
        $s3=DB::select('SELECT gnral_semestres.descripcion, gnral_carreras.nombre, planeacion.desc_actividad,planeacion.sugerencia,planeacion.id_planeacion
                        FROM gnral_semestres,gnral_carreras,planeacion,asigna_tutor
                        WHERE asigna_tutor.id_semestre=gnral_semestres.id_semestre
                        and asigna_tutor.id_carrera=gnral_carreras.id_carrera
                        and planeacion.id_semestre=asigna_tutor.id_semestre
                        and planeacion.id_sugerencia=0
                        and planeacion.id_semestre=3;');
        $s4=DB::select('SELECT gnral_semestres.descripcion, gnral_carreras.nombre, planeacion.desc_actividad,planeacion.sugerencia,planeacion.id_planeacion
                        FROM gnral_semestres,gnral_carreras,planeacion,asigna_tutor
                        WHERE asigna_tutor.id_semestre=gnral_semestres.id_semestre
                        and asigna_tutor.id_carrera=gnral_carreras.id_carrera
                        and planeacion.id_semestre=asigna_tutor.id_semestre
                        and planeacion.id_sugerencia=0
                        and planeacion.id_semestre=4;');
        $s5=DB::select('SELECT gnral_semestres.descripcion, gnral_carreras.nombre, planeacion.desc_actividad,planeacion.sugerencia,planeacion.id_planeacion
                        FROM gnral_semestres,gnral_carreras,planeacion,asigna_tutor
                        WHERE asigna_tutor.id_semestre=gnral_semestres.id_semestre
                        and asigna_tutor.id_carrera=gnral_carreras.id_carrera
                        and planeacion.id_semestre=asigna_tutor.id_semestre
                        and planeacion.id_sugerencia=0
                        and planeacion.id_semestre=5;');
        $s6=DB::select('SELECT gnral_semestres.descripcion, gnral_carreras.nombre, planeacion.desc_actividad,planeacion.sugerencia,planeacion.id_planeacion
                        FROM gnral_semestres,gnral_carreras,planeacion,asigna_tutor
                        WHERE asigna_tutor.id_semestre=gnral_semestres.id_semestre
                        and asigna_tutor.id_carrera=gnral_carreras.id_carrera
                        and planeacion.id_semestre=asigna_tutor.id_semestre
                        and planeacion.id_sugerencia=0
                        and planeacion.id_semestre=6;');
        $s7=DB::select('SELECT gnral_semestres.descripcion, gnral_carreras.nombre, planeacion.desc_actividad,planeacion.sugerencia,planeacion.id_planeacion
                        FROM gnral_semestres,gnral_carreras,planeacion,asigna_tutor
                        WHERE asigna_tutor.id_semestre=gnral_semestres.id_semestre
                        and asigna_tutor.id_carrera=gnral_carreras.id_carrera
                        and planeacion.id_semestre=asigna_tutor.id_semestre
                        and planeacion.id_sugerencia=0
                        and planeacion.id_semestre=7;');
        $s8=DB::select('SELECT gnral_semestres.descripcion, gnral_carreras.nombre, planeacion.desc_actividad,planeacion.sugerencia,planeacion.id_planeacion
                        FROM gnral_semestres,gnral_carreras,planeacion,asigna_tutor
                        WHERE asigna_tutor.id_semestre=gnral_semestres.id_semestre
                        and asigna_tutor.id_carrera=gnral_carreras.id_carrera
                        and planeacion.id_semestre=asigna_tutor.id_semestre
                        and planeacion.id_sugerencia=0
                        and planeacion.id_semestre=8;');
        return view('tutorias.peticiones.peticiones',compact("s1","s2","s3","s4","s5","s6","s7","s8"));
    }

    public function update(Request $request, $id)
    {
        $plan = Tutorias_Planeacion::find($id);
        $plan->id_sugerencia = $request->id_sugerencia;
        $plan->save();
        return redirect()->back();
    }
}
