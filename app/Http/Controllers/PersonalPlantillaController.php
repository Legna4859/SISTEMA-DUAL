<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Gnral_Personales;
use Session;
use App\adscripcion_personal;
class PersonalPlantillaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $unidades= DB::select('SELECT * FROM gnral_unidad_administrativa order by nom_departamento');
        $id_periodo = Session::get('periodotrabaja');
       // dd($id_periodo);
        $personal = DB::select('select gnral_personales.id_personal,gnral_personales.clave, gnral_personales.nombre, gnral_perfiles.descripcion,gnral_personales.fch_recontratacion FROM gnral_personales,gnral_perfiles WHERE gnral_personales.id_perfil=gnral_perfiles.id_perfil AND gnral_personales.id_personal NOT IN (select gnral_personales.id_personal FROM gnral_personales,adscripcion_personal WHERE gnral_personales.id_personal=adscripcion_personal.id_personal) and gnral_personales.id_personal NOT IN (SELECT gnral_personales.id_personal FROM gnral_personales,gnral_horarios, gnral_periodo_carreras,gnral_periodos WHERE gnral_horarios.id_personal=gnral_personales.id_personal and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo and gnral_periodos.id_periodo='.$id_periodo.')');
      //dd($personal);
        $plantillas = DB::select('select gnral_personales.id_personal,gnral_personales.nombre,gnral_unidad_administrativa.nom_departamento FROM gnral_personales, adscripcion_personal,gnral_unidad_personal,gnral_unidad_administrativa WHERE gnral_personales.id_personal=adscripcion_personal.id_personal and gnral_unidad_personal.id_unidad_persona=adscripcion_personal.id_unidad_persona and gnral_unidad_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin');
        return view('plantilla_personal.personal_plantilla',compact('personal','plantillas','unidades'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'unidad' => 'required'
        ]);
        $idpersonal = $request->input("idpersonal");
        $unidad = $request->input("unidad");
        $unidades = DB::selectOne('SELECT gnral_unidad_personal.id_unidad_persona FROM gnral_unidad_personal,gnral_unidad_administrativa WHERE gnral_unidad_administrativa.id_unidad_admin=gnral_unidad_personal.id_unidad_admin and gnral_unidad_administrativa.id_unidad_admin='.$unidad.'');

       $uni=$unidades->id_unidad_persona;
        DB:: table('adscripcion_personal')->insert(['id_personal'=>$idpersonal,'id_unidad_persona'=>$uni]);



           return redirect('/departamento/plantilla');

    }
 public  function personaldepartamento($departamento){
     $plantillas = DB::select('select abreviaciones.titulo,gnral_personales.id_personal,gnral_personales.nombre FROM gnral_personales, adscripcion_personal,gnral_unidad_personal,abreviaciones_prof,abreviaciones WHERE gnral_personales.id_personal=adscripcion_personal.id_personal and gnral_unidad_personal.id_unidad_persona=adscripcion_personal.id_unidad_persona and abreviaciones_prof.id_personal=gnral_personales.id_personal AND abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion  and gnral_unidad_personal.id_unidad_admin=' . $departamento . '');
     $jefaturas= DB::select('select *from gnral_unidad_administrativa order by nom_departamento');
     $ver=1;
     $departamento;
     return view('plantilla_personal.consultar_personal',compact('plantillas','jefaturas','ver','departamento'));
    }
    public function destroy($id_personal)
    {


        $comprobar = DB::selectOne('SELECT adscripcion_personal.id_adscripcion FROM adscripcion_personal WHERE id_personal='.$id_personal.' ');
        $comprobar = ($comprobar->id_adscripcion);
        //dd($comprobar);

        adscripcion_personal::destroy($comprobar);
        return back();
    }
    public function eliminar($id){
        Gnral_Personales::find($id)-> delete();
        return back();

    }


}
