<?php
namespace App\Http\Controllers;
use App\Tutorias_Canalizacion;
use App\Tutorias_Exp_generale;
use App\Tutorias_Plan_asigna_planeacion_tutor;
use Illuminate\Http\Request;
use App\Profesor;
use App\Alumno;
use App\AsignaExpediente;
use App\AsignaCoordinador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Array_;
class Tutorias_ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function alumnos(Request $request)
    {
        //dd($request);

        $datos=DB::table('gnral_alumnos')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_alumno','=','gnral_alumnos.id_alumno')
            ->select(DB::raw('UPPER(gnral_alumnos.nombre) as nombre, UPPER(gnral_alumnos.apaterno) as apaterno, UPPER(gnral_alumnos.amaterno) as amaterno, gnral_alumnos.id_alumno, gnral_alumnos.cuenta, exp_asigna_alumnos.estado, exp_asigna_alumnos.id_asigna_alumno'))
            ->where('exp_asigna_alumnos.id_asigna_generacion', '=', $request->id_asigna_generacion)
            ->where('gnral_alumnos.id_carrera','=',$request->id_carrera)
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->orderBy('gnral_alumnos.cuenta')
            ->get();


        $datos->map(function ($value, $key) {
            $gen=Tutorias_Exp_generale::where('id_alumno',$value->id_alumno)->count();
            $value->expediente=$gen>0?true:false;
            //$value->nombrec=$value->apaterno+" "+$value->amaterno+" "+$value->nombre;
            return $value;
        });
        $datos->map(function ($value, $key) {
            $can=Tutorias_Canalizacion::where('id_alumno',$value->id_alumno)->count();
            $value->canalizacion=$can>0?true:false;
            //$value->nombrec=$value->apaterno+" "+$value->amaterno+" "+$value->nombre;
            return $value;
        });


        // dd($nuevo);
        return $datos;

    }
    public function planeacion(Request $request)
    {
        $plan=DB::select('SELECT plan_asigna_planeacion_tutor.id_asigna_generacion,
       plan_asigna_planeacion_tutor.id_plan_actividad, plan_asigna_planeacion_tutor.id_asigna_planeacion_tutor,
       plan_actividades.desc_actividad,plan_actividades.objetivo_actividad,
       DATE_FORMAT(plan_actividades.fi_actividad,"%d-%m-%Y") as fi_actividad, 
       DATE_FORMAT(plan_actividades.ff_actividad,"%d-%m-%Y") as ff_actividad,
       plan_asigna_planeacion_tutor.boton FROM plan_actividades, plan_asigna_planeacion_tutor 
where plan_actividades.id_plan_actividad = plan_asigna_planeacion_tutor.id_plan_actividad 
  and plan_asigna_planeacion_tutor.id_asigna_generacion='.$request->id_asigna_generacion.' 
ORDER by plan_actividades.fi_actividad asc,plan_actividades.ff_actividad asc');

        return $plan;
    }
    public function enviados(Request $request)
    {
        $data['env']=DB::select('SELECT * FROM `plan_asigna_planeacion_tutor`
WHERE `id_asigna_planeacion_tutor` = '.$request->id_asigna_planeacion_tutor.' ORDER BY `id_asigna_planeacion_tutor` DESC');

        return $data;
    }
    public function selecciona(Request $request)
    {
        $id_generacion=DB::selectOne('SELECT * FROM `exp_asigna_generacion` WHERE `id_asigna_generacion` = '.$request->id_asigna_generacion.'');
        $id_generacion=$id_generacion->id_generacion;
        $periodo = Session::get('periodo_actual');
        $selecc=DB::select('SELECT * FROM `plan_actividades` 
WHERE `id_generacion` = '.$id_generacion.' AND `id_periodo` = '.$periodo.' AND `id_estado` = 1 
and id_plan_actividad NOT IN (SELECT id_plan_actividad FROM plan_asigna_planeacion_tutor 
where id_asigna_generacion = '.$request->id_asigna_generacion.')
ORDER BY `plan_actividades`.`fi_actividad` ASC ');
      /*  $selecc=DB::select('SELECT exp_asigna_generacion.id_asigna_generacion,
                          plan_asigna_planeacion_actividad.id_asigna_planeacion_actividad,
                          plan_actividades.desc_actividad,plan_actividades.objetivo_actividad,
                          DATE_FORMAT(plan_actividades.fi_actividad,"%d-%m-%Y") as fi_actividad,
                          DATE_FORMAT(plan_actividades.ff_actividad,"%d-%m-%Y") as ff_actividad
                          FROM exp_asigna_generacion,gnral_personales,exp_asigna_tutor,exp_generacion,plan_actividades,
                             plan_asigna_planeacion_actividad
                            WHERE gnral_personales.id_personal=exp_asigna_tutor.id_personal
                            AND exp_asigna_generacion.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                            AND exp_asigna_generacion.id_generacion=exp_generacion.id_generacion
                            AND plan_actividades.id_generacion=exp_asigna_generacion.id_generacion
                            AND plan_actividades.id_plan_actividad=plan_asigna_planeacion_actividad.id_plan_actividad
                            AND plan_asigna_planeacion_actividad.id_estado=1
                            AND plan_actividades.deleted_at is null
                            AND plan_asigna_planeacion_actividad.deleted_at is null
                            AND exp_asigna_tutor.deleted_at is null
                            AND exp_asigna_generacion.id_asigna_generacion='.$request->id_asigna_generacion);
      */

        return $selecc;
    }

    public  function grupos()
    {
        //dd(Session::get('id_periodo'));
        $datos=DB::select('select gnral_carreras.id_carrera, gnral_carreras.nombre,exp_generacion.generacion, 
                exp_asigna_generacion.grupo, exp_asigna_generacion.id_asigna_generacion,exp_asigna_tutor.id_asigna_tutor from gnral_jefes_periodos
                JOIN exp_asigna_tutor on exp_asigna_tutor.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo JOIN
                gnral_personales ON gnral_personales.id_personal=exp_asigna_tutor.id_personal JOIN gnral_carreras on
                gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera JOIN exp_asigna_generacion ON 
                exp_asigna_generacion.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion JOIN exp_generacion
                ON exp_generacion.id_generacion=exp_asigna_generacion.id_generacion where 
                gnral_jefes_periodos.id_periodo='.Session::get('periodo_actual').' and 
                exp_asigna_tutor.deleted_at is null and gnral_personales.tipo_usuario='.Auth::user()->id);
         $array_datos=array();
        foreach($datos as $dato){
            $dat['id_carrera']=$dato->id_carrera;
            $dat['nombre']=$dato->nombre;
            $dat['generacion']=$dato->generacion;
            $dat['grupo']=$dato->grupo;
            $dat['id_asigna_generacion']=$dato->id_asigna_generacion;
            $dat['id_asigna_tutor']=$dato->id_asigna_tutor;
            $estado_semestre=DB::selectOne('SELECT count(id_grupo_semestre)contar from tu_grupo_semestre where id_asigna_tutor ='.$dato->id_asigna_tutor.'');
            $estado_semestre=$estado_semestre->contar;
            if($estado_semestre == 0){
                $dat['estado_semestre']=0;
                $dat['nombre_semestre']="";
                $dat['id_grupo_semestre']="";
                $dat['id_grupo_tutorias']="";
            }else{
                $dat['estado_semestre']=1;
                $grupo=DB::selectOne('SELECT tu_grupo_tutorias.descripcion grupo_semestre,
       tu_grupo_semestre.id_grupo_semestre,tu_grupo_semestre.id_grupo_tutorias from tu_grupo_semestre, tu_grupo_tutorias where 
    tu_grupo_tutorias.id_grupo_tutorias = tu_grupo_semestre.id_grupo_tutorias 
    and tu_grupo_semestre.id_asigna_tutor='.$dato->id_asigna_tutor.'');
                $dat['nombre_semestre']=$grupo->grupo_semestre;
                $dat['id_grupo_semestre']=$grupo->id_grupo_semestre;
                $dat['id_grupo_tutorias']=$grupo->id_grupo_tutorias ;


            }
            array_push($array_datos,$dat);

        }


        return $array_datos;

    }
    public function cambio(Request $request)
    {
        DB::update('UPDATE exp_asigna_alumnos set estado='.$request->estado.' where id_asigna_alumno='.$request->id_asigna_alumno);
    }

    public function ev(Request $request)
    {
        $datos=DB::table('gnral_alumnos')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_alumno','=','gnral_alumnos.id_alumno')
            ->join('plan_asigna_evidencias','plan_asigna_evidencias.id_alumno','=','gnral_alumnos.id_alumno')
            ->select(DB::raw('UPPER(gnral_alumnos.nombre) as nombre, UPPER(gnral_alumnos.apaterno) as apaterno, UPPER(gnral_alumnos.amaterno) as amaterno, gnral_alumnos.id_alumno, gnral_alumnos.cuenta, exp_asigna_alumnos.estado, exp_asigna_alumnos.id_asigna_alumno'))
            ->where('exp_asigna_alumnos.id_asigna_generacion', '=', $request->id_asigna_generacion)
            ->where('gnral_alumnos.id_carrera','=',$request->id_carrera)
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->groupBy('gnral_alumnos.cuenta')
            ->orderBy('gnral_alumnos.cuenta')
            ->get();

        return $datos;
    }
    public function nuevoregistro(Request $request)
    {

        DB::table('plan_asigna_planeacion_tutor')
            ->where('id_asigna_planeacion_tutor', '=', $request->id_asigna_planeacion_tutor)
            ->update(array("estrategia"=>$request->estrategia,
                "requiere_evidencia"=>$request->requiere_evidencia));
    }
    public function actividad(Request $request)
    {

        $id_plan_actividad = $request->input('id_plan_actividad');
        $id_asigna_generacion = $request->input('id_asigna_generacion');
        DB:: table('plan_asigna_planeacion_tutor')->insert([
            'id_plan_actividad'=>$id_plan_actividad,
            'id_asigna_generacion'=>$id_asigna_generacion,

        ]);
    }
    public function upest(Request $request)
    {

        DB::table('plan_asigna_planeacion_tutor')
            ->where('id_asigna_planeacion_tutor','=',$request->id_asigna_planeacion_tutor)
            ->update(array("estrategia"=>$request->estrategia,
                "requiere_evidencia"=>$request->requiere_evidencia,
                "id_estrategia"=>1,
                "boton"=>1));
    }

    public function verestrategia(Request $request)
    {
        $data['planeacion']=DB::select('SELECT exp_asigna_generacion.id_asigna_generacion,
                                        plan_asigna_planeacion_actividad.id_asigna_planeacion_actividad
                          FROM exp_asigna_generacion,gnral_personales,exp_asigna_tutor,exp_generacion,plan_actividades,
                             plan_asigna_planeacion_actividad
                            WHERE gnral_personales.id_personal=exp_asigna_tutor.id_personal
                            AND exp_asigna_generacion.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                            AND exp_asigna_generacion.id_generacion=exp_generacion.id_generacion
                            AND plan_actividades.id_generacion=exp_asigna_generacion.id_generacion
                            AND plan_actividades.id_plan_actividad=plan_asigna_planeacion_actividad.id_plan_actividad
                            AND plan_asigna_planeacion_actividad.id_estado=1
                            AND plan_actividades.deleted_at is null
                            AND plan_asigna_planeacion_actividad.deleted_at is null
                            AND exp_asigna_tutor.deleted_at is null
                            AND exp_asigna_generacion.id_asigna_generacion='.$request->id_gen.'
                            AND plan_asigna_planeacion_actividad.id_asigna_planeacion_actividad='.$request->id_plan);

        return $data;
    }
    public function semestres_tesvb(){
        $semestres=DB::select('SELECT * FROM `tu_grupo_tutorias`');
        return $semestres;
    }
    public function registrar_semestre_grupo(Request $request){
        $id_asigna_tutor = $request->input('id_asigna_tutor');
        $id_grupo_tutoria = $request->input('id_grupo_tutoria');
        $fecha_actual = date("d-m-Y");
        DB:: table('tu_grupo_semestre')->insert([
            'id_asigna_tutor'=>$id_asigna_tutor,
            'id_grupo_tutorias'=>$id_grupo_tutoria,
            'fecha_registro'=>$fecha_actual

        ]);
    }
    public function modificar_semestre_grupo(Request $request){
        $id_semestre_grupo = $request->input('id_semestre_grupo');
        $id_grupo_tutoria = $request->input('id_grupo_tutoria');
        $fecha_actual = date("d-m-Y");
        DB::table('tu_grupo_semestre')
            ->where('id_grupo_semestre','=',$id_semestre_grupo)
            ->update(array("id_grupo_tutorias"=>$id_grupo_tutoria,
                "fecha_registro"=>$fecha_actual,
                ));
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
