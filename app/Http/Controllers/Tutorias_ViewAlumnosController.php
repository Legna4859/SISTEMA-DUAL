<?php

namespace App\Http\Controllers;
use App\Alumnos;
use App\Tutorias_areas_canalizacion;
use App\AsignaExpediente;
use App\Tutorias_Exp_antecedentes_academico;
use App\Tutorias_Exp_area_psicopedagogica;
use App\Exp_asigna_expediente;
use App\Tutorias_Exp_bachillerato;
use App\Tutorias_Exp_bebidas;
use App\Tutorias_Exp_beca;
use App\Tutorias_Exp_civil_estado;
use App\Tutorias_Exp_datos_familiare;
use App\Tutorias_Exp_escalas;
use App\Tutorias_Exp_familia_union;
use App\Tutorias_Exp_formacion_integral;
use App\Exp_formatrabajo;
use App\Tutorias_Exp_generale;
use App\Tutorias_Exp_habitos_estudio;
use App\Tutorias_Exp_opc_intelectual;
use App\Tutorias_Exp_opc_tiempo;
use App\Tutorias_Exp_opc_vives;
use App\Tutorias_Exp_parentesco;
use App\Exp_tiempoestudia;
use App\Tutorias_Exp_turno;
use App\Tutorias_Plan_actividades;
use App\Tutorias_Plan_asigna_planeacion_tutor;
use App\Tutorias_subareas_canalizacion;
use Illuminate\Support\Carbon;
use App\gnral_alumnos;
use App\Carreras;
use App\Periodos;
use App\Semestres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\VarDumper\Dumper\esc;

class Tutorias_ViewAlumnosController extends Controller
{
    public function llenar()
    {
        return view('tutorias.alumnos.expediente');
    }
    public function actualizar()
    {
        return view('tutorias.alumnos.expedienteUpdate');

    }
    public function create()
    {
        //
    }
    public function guardarImagen(Request $request)
    {


        if($request->hasFile('imagen')){

            $extension="";
            switch ($request->ext){
                case 'image/jpeg':
                    $extension='.jpeg';
                    break;
                case 'image/png':
                    $extension='.png';
                    break;
                case 'image/jpg':
                    $extension='.jpg';
                    break;
            }
            $file = $request->file('imagen');
            $name = $request->nombre.$extension;
            $file->move(public_path().'/Fotografias/', $name);
        }
        return $request->nombre;
    }
    public function store(Request $request)
    {
        //dd($request);
        //dd($request->hasFile('imagen'));


         Tutorias_Exp_generale::create($request->alu['generales']);
        Tutorias_Exp_antecedentes_academico::create($request->alu['academicos']);
        Tutorias_Exp_datos_familiare::create($request->alu['familiares']);
        Tutorias_Exp_habitos_estudio::create($request->alu['estudio']);
        Tutorias_Exp_formacion_integral::create($request->alu['integral']);
        $area=Tutorias_Exp_area_psicopedagogica::create($request->alu['area']);

        return $area;
    }

    public  function veralumno(Request $request)
    {
        $data['datos_alumn']=Alumnos::where('id_alumno',$request->id)->get();
        $data['generales']=Tutorias_Exp_generale::where('id_alumno',$request->id)->get();
        $data['academicos']=Tutorias_Exp_antecedentes_academico::where('id_alumno',$request->id)->get();
        $data['familiares']=Tutorias_Exp_datos_familiare::where('id_alumno',$request->id)->get();
        $data['estudio']=Tutorias_Exp_habitos_estudio::where('id_alumno',$request->id)->get();
        $data['integral']=Tutorias_Exp_formacion_integral::where('id_alumno',$request->id)->get();
        $data['area']=Tutorias_Exp_area_psicopedagogica::where('id_alumno',$request->id)->get();

        $data['carreras']= Carreras::all();
        $data['grupos']=DB::select('SELECT * FROM `gnral_grupos`');
        $data['periodos'] = Periodos::all();
        $data['semestres']= Semestres::all();
        $data['estadocivil'] = Tutorias_Exp_civil_estado::all();
        /*$data['nivel']= Exp_opc_nivel_socio::all();*/
        $data['bachillerato'] = Tutorias_Exp_bachillerato::all();
        $data['vive'] = Tutorias_Exp_opc_vives::all();
        $data['unionfam'] = Tutorias_Exp_familia_union::all();
        $data['turno'] = Tutorias_Exp_turno::all();
        $data['tiempoestudia']= Tutorias_Exp_opc_tiempo::all();
        $data['intelectual']= Tutorias_Exp_opc_intelectual::all();
        $data['parentesco']=Tutorias_Exp_parentesco::all();
        $data['escala']=Tutorias_Exp_escalas::all();
        $data['bebidas']=Tutorias_Exp_bebidas::all();
        $data['becas']=Tutorias_Exp_beca::all();
        return $data;
    }

    public  function veralumno1(Request $request)
    {
        $data['valores']=DB::select('SELECT exp_asigna_generacion.grupo,gnral_alumnos.id_alumno,gnral_alumnos.nombre,gnral_alumnos.apaterno,
            gnral_alumnos.amaterno,gnral_carreras.nombre as carrera,gnral_semestres.descripcion as semestre,gnral_personales.nombre as nombre_tut,gnral_personales.id_personal
            FROM exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,gnral_carreras,
            gnral_semestres,gnral_personales,exp_asigna_tutor
            WHERE exp_asigna_generacion.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
            AND gnral_alumnos.id_alumno=exp_asigna_alumnos.id_alumno
            AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera
            AND gnral_alumnos.id_semestre=gnral_semestres.id_semestre
            AND gnral_personales.id_personal=exp_asigna_tutor.id_personal
            AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
            AND exp_asigna_alumnos.id_alumno='.$request->id);

        $data['areas']= Tutorias_areas_canalizacion::all();
       // $data['subareas']= Tutoriassubareas_canalizacion::all();
        return $data;
    }
    public  function verestrategia(Request $request)
    {
        $data['planeacion']=Tutorias_Plan_asigna_planeacion_tutor::where('id_asigna_planeacion_tutor',$request->id)->get();
        return $data;
    }
    public  function versugerencia(Request $request)
    {
        $data['sugerencia']=Tutorias_Plan_asigna_planeacion_tutor::where('id_asigna_planeacion_tutor',$request->id)->get();
        $data['actividad']=Tutorias_Plan_actividades::where('id_plan_actividad',$request->id_actividad)->get();
        return $data;
    }

    public function actualiza(Request $request)
    {

        $generales = Tutorias_Exp_generale::find($request->alu['generales']['id_exp_general']);
        $generales->update($request->alu['generales']);
        $academicos = Tutorias_Exp_antecedentes_academico::find($request->alu['academicos']['id_exp_antecedentes_academicos']);
        $academicos->update($request->alu['academicos']);
        $familiares = Tutorias_Exp_datos_familiare::find($request->alu['familiares']['id_exp_datos_familiares']);
        $familiares->update($request->alu['familiares']);
        $estudio = Tutorias_Exp_habitos_estudio::find($request->alu['estudio']['id_exp_habitos_estudio']);
        $estudio->update($request->alu['estudio']);
        $integral = Tutorias_Exp_formacion_integral::find($request->alu['integral']['id_exp_formacion_integral']);
        $integral->update($request->alu['integral']);
        $area = Tutorias_Exp_area_psicopedagogica::find($request->alu['area']['id_exp_area_psicopedagogica']);
        $area->update($request->alu['area']);

        return('ok');
    }
    public function actualizaestrategia(Request $request)
    {

        $planeacion = Tutorias_Plan_asigna_planeacion_tutor::find($request->estra['planeacion']['id_asigna_planeacion_tutor']);

        $planeacion->update($request->estra['planeacion']);

        return('ok');
    }
    public function actualizasugerencia(Request $request)
    {
        $sugerencia = Tutorias_Plan_asigna_planeacion_tutor::find($request->suge['sugerencia']['id_asigna_planeacion_tutor']);
        $sugerencia->update($request->suge['sugerencia']);
        return('ok');
    }

    public function show($id)
    {

    }
    public function edit($id)
    {

    }
    public function cerrar()
    {
        //
        Session::flush();
    }
    public function update(Request $request, $id)
    {

    }
    public function destroy($id)
    {

    }
}
