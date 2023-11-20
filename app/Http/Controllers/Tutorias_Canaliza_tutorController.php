<?php

namespace App\Http\Controllers;

use App\Tutorias_Canalizacion;
use App\Alumnos;
use App\Tutorias_asigna_tutor;
use App\Tutorias_areas_canalizacion;
use App\Carreras;
use App\Gnral_personales;
use App\Semestres;
use Illuminate\Http\Request;
use DB;
class Tutorias_Canaliza_tutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$alumnos= gnral_alumnos::getAlumnos();
        //$datos['alumnos']=Tutor::paginate(5);
        $carreras=Tutorias_asigna_tutor::getCarrera();
        $carreras1=Tutorias_asigna_tutor::getCarrera1();
        $datos= Tutorias_asigna_tutor::getDatos();
        //$alumnos=gnral_alumnos::getAlumnos();
        return view('tutorias.profesor.canalizacion',compact("carreras","datos","carreras1"));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$planea = array(
            "id_alumno"=>$request->id_alumno,
            "id_personal" => $request->id_personal,
            "fecha_canalizacion" => $request->fecha_canalizacion,
            "hora" => $request->hora,
            "aspectos_personales1"=> $request->aspectos_personales1,
            "aspectos_personales2"=> $request->aspectos_personales2,
            "aspectos_personales3"=> $request->aspectos_personales3,
            "aspectos_sociologicos1"=> $request->aspectos_sociologicos1,
            "aspectos_sociologicos2"=> $request->aspectos_sociologicos2,
            "aspectos_sociologicos3"=> $request->aspectos_sociologicos3,
            "aspectos_academicos1"=> $request->aspectos_academicos1,
            "aspectos_academicos2"=> $request->aspectos_academicos2,
            "aspectos_academicos3"=> $request->aspectos_academicos3,
            "observaciones"=>$request->observaciones,
            "otros"=>$request->otros,
            "notificacion"=>$request->notificacion,
            "id_area"=>$request->id_area
        );
        Canalizacion::create($planea);
        return redirect('profesor.canalizacion');*/
        //$datos=request()->all();
        $datos=request()->except('_token');
        Tutorias_Canalizacion::insert($datos);
        return redirect()->back();
        //return redirect('canalizacion');
        //return response()->json($datos);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $areas=Tutorias_areas_canalizacion::all();
        $carreras=DB::select('SELECT c.nombre FROM gnral_carreras as c,gnral_alumnos as a WHERE a.id_carrera= c.id_carrera and a.id_alumno ='.$id);
        $semestre=DB::select('SELECT s.descripcion FROM gnral_semestres as s,gnral_alumnos as a WHERE a.id_semestre= s.id_semestre and a.id_alumno ='.$id);
        $prof=DB::select('SELECT t.id_personal,t.nombre,t.correo FROM gnral_personales as t,asigna_tutor as ast,gnral_alumnos as a ,gnral_semestres as s,gnral_grupos as g, gnral_carreras as c WHERE a.grupo=g.id_grupo and a.id_semestre=s.id_semestre and a.id_carrera=c.id_carrera and ast.id_personal=t.id_personal and ast.id_semestre=a.id_semestre and ast.id_carrera=a.id_carrera and a.id_alumno='.$id);
        $grupo=DB::select('SELECT g.grupo FROM gnral_grupos as g,gnral_alumnos as a WHERE a.grupo= g.id_grupo and a.id_alumno ='.$id);
        //$datos=asigna_tutor::getDatosall();
        $alumno=Alumnos::find($id);
        //echo $carreras;
        //return $fecha;
        return view('tutorias.profesor.canaliza',compact('alumno',"areas",'carreras','semestre','prof','grupo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
