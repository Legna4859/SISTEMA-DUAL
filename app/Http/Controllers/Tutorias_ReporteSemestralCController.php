<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tutorias_Reporte_tutor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Tutorias_ReporteSemestralCController extends Controller
{
    public function index()
    {
        $id_asigna_coordinador = Session::get('id_asigna_coordinador');

       $carrera= DB::selectOne('SELECT exp_asigna_coordinador.*, gnral_jefes_periodos.id_carrera,
       gnral_jefes_periodos.id_periodo,
        gnral_carreras.nombre from exp_asigna_coordinador, gnral_jefes_periodos, gnral_carreras 
       WHERE exp_asigna_coordinador.id_jefe_periodo = gnral_jefes_periodos.id_jefe_periodo 
       and gnral_jefes_periodos.id_carrera = gnral_carreras.id_carrera and 
       exp_asigna_coordinador.id_asigna_coordinador ='.$id_asigna_coordinador.'');
       //dd($carrera);

        return view('tutorias.coordinadorc.reportecarrera.inicio_reporte_coordinador',
        compact('carrera','id_asigna_coordinador'));
    }

    public function inicio_reporte_coordinador($id_asigna_coordinador){
       // dd($id_asigna_coordinador);
    
    $carrera= DB::selectOne('SELECT exp_asigna_coordinador.*, gnral_jefes_periodos.id_carrera,
    gnral_jefes_periodos.id_periodo, gnral_carreras.nombre from exp_asigna_coordinador, 
    gnral_jefes_periodos, gnral_carreras 
    WHERE exp_asigna_coordinador.id_jefe_periodo = gnral_jefes_periodos.id_jefe_periodo 
    and gnral_jefes_periodos.id_carrera = gnral_carreras.id_carrera and 
    exp_asigna_coordinador.id_asigna_coordinador ='.$id_asigna_coordinador.'');

    //dd($carrera);

    $tutores = DB::SELECT('SELECT exp_asigna_t.id_asigna_generacion,tu_grupo_s.id_grupo_semestre,
    car.nombre carrera, car.id_carrera, tu_grupo_t.descripcion grupo, gnral_p.nombre nombre_tutor,
     gnral_p.tipo_usuario tipo FROM tu_grupo_tutorias tu_grupo_t
    INNER JOIN tu_grupo_semestre tu_grupo_s
    ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
    INNER JOIN exp_asigna_tutor exp_asigna_t 
    ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
    INNER JOIN gnral_personales gnral_p 
    ON gnral_p.id_personal = exp_asigna_t.id_personal 
    INNER JOIN gnral_jefes_periodos gnral_j 
    ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
    INNER JOIN gnral_carreras car
    ON car.id_carrera = gnral_j.id_carrera
    WHERE gnral_j.id_periodo = '.$carrera->id_periodo.' AND car.id_carrera = '.$carrera->id_carrera.'');

//dd($tutores);
$array_tutores = array();
$grupal = 0;
       $individual = 0;
       $beca = 0;
       $repeticion = 0;
       $especialidad = 0;
       $academico = 0;
       $medico = 0;
       $psicologico =0 ;
       $baja = 0;
       
foreach($tutores as $tutor){
    $data['id_asigna_generacion']=$tutor->id_asigna_generacion;
    $data['id_grupo_semestre']=$tutor->id_grupo_semestre;
    $data['carrera']=$tutor->id_asigna_generacion;
    $data['id_carrera']=$tutor->id_carrera;
    $data['grupo']=$tutor->grupo;
    $data['nombre_tutor']=$tutor->nombre_tutor;

    $estado_observacion = DB::selectOne('SELECT COUNT(id_repcarrera) contar from rep_carrera WHERE id_asigna_generacion='.$tutor->id_asigna_generacion.'');
if($estado_observacion->contar == 0){
    $data['estado_observacion']=1;
    $data['observacion']="";
}else{
    $observacion = DB::selectOne('SELECT *from rep_carrera WHERE id_asigna_generacion = '.$tutor->id_asigna_generacion.'');
    $data['estado_observacion'] = 2;
    $data['observacion']=$observacion->observaciones;
}

$tut_grupal=DB::select('SELECT COUNT(reporte_tutor.tutoria_grupal) as tutoria_grupal
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.tutoria_grupal="Si"
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);
$grupal = $grupal + $tut_grupal[0]->tutoria_grupal;
$data['tutoria_grupal'] = $tut_grupal[0]->tutoria_grupal;


$tut_ind=DB::select('SELECT COUNT(reporte_tutor.tutoria_individual) as tutoria_individual
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.tutoria_individual="Si"
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);

$individual = $individual + $tut_ind[0]->tutoria_individual;
$data['tutoria_individual'] = $tut_ind[0]->tutoria_individual;

$bec=DB::select('SELECT COUNT(reporte_tutor.beca) as beca
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.beca=1
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);
$beca = $beca + $bec[0]->beca;
$data['beca'] = $bec[0]->beca;

$rep=DB::select('SELECT COUNT(reporte_tutor.repeticion) as repeticion
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.repeticion = 1
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);
$repeticion = $repeticion + $rep[0]->repeticion;
$data['repeticion'] = $rep[0]->repeticion;

$esp=DB::select('SELECT COUNT(reporte_tutor.especial) as especial
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.especial = 1
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);
$especialidad = $especialidad + $esp[0]->especial;
$data['especial'] =  $esp[0]->especial;

$acad=DB::select('SELECT COUNT(reporte_tutor.academico) as academico
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.academico = "Si"
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);
$academico = $academico + $acad[0]->academico;
$data['academico'] =  $acad[0]->academico;

$med=DB::select('SELECT COUNT(reporte_tutor.medico) as medico
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.medico = "Si"
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);
$medico = $medico + $med[0]->medico;
$data['medico'] =  $med[0]->medico;

$psi=DB::select('SELECT COUNT(reporte_tutor.psicologico) as psicologico
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.psicologico = "Si"
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);
$psicologico = $psicologico + $psi[0]->psicologico;
$data['psicologico'] =  $psi[0]->psicologico;

$baj=DB::select('SELECT COUNT(reporte_tutor.baja) as baja
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
     reporte_tutor 
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null 
AND exp_asigna_generacion.deleted_at is null 
AND exp_asigna_alumnos.deleted_at is null 
AND reporte_tutor.baja > 1
AND reporte_tutor.id_asigna_generacion='.$tutor->id_asigna_generacion);
$baja = $baja + $baj[0]->baja;
$data['baja'] =  $baj[0]->baja;
array_push($array_tutores,$data);
}
return view('tutorias.coordinadorc.reportecarrera.reporte_tutores',compact('id_asigna_coordinador','array_tutores'));
  
    }


    public function alumc(Request $request)
    {
        $datos=DB::table('gnral_alumnos')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_alumno','=','gnral_alumnos.id_alumno')
            ->select(DB::raw('UPPER(gnral_alumnos.nombre) as nombre, UPPER(gnral_alumnos.apaterno) as apaterno, UPPER(gnral_alumnos.amaterno) as amaterno, gnral_alumnos.id_alumno, gnral_alumnos.cuenta, exp_asigna_alumnos.estado, exp_asigna_alumnos.id_asigna_generacion'))
            ->where('exp_asigna_alumnos.id_asigna_generacion', '=', $request->id_asigna_generacion)
            ->where('gnral_alumnos.id_carrera','=',$request->id_carrera)
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->orderBy('gnral_alumnos.cuenta')
            ->get();
        $datos->map(function ($value, $key) {
            $con=Tutorias_Reporte_tutor::where('n_cuenta',$value->cuenta)->count();
            $value->conteo=$con>0?true:false;
            return $value;
        });
        return $datos;    
    }

    public function verpararepoc(Request $request)
    {
        $data['ver']=DB::select('SELECT exp_asigna_tutor.id_asigna_generacion,UPPER(gnral_alumnos.nombre) as nombre,
            UPPER(gnral_alumnos.apaterno) as apaterno, UPPER(gnral_alumnos.amaterno) as amaterno,
            gnral_alumnos.cuenta,exp_generales.beca,exp_generales.materias_repeticion,exp_generales.materias_especial,
            exp_asigna_alumnos.estado
            FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion 
            WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
            AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
            AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
            AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
            AND gnral_alumnos.cuenta=exp_generales.no_cuenta
            AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
            AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
            AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
            AND exp_asigna_tutor.deleted_at is null 
            AND exp_asigna_generacion.deleted_at is null 
            AND exp_asigna_alumnos.deleted_at is null 
            AND exp_asigna_alumnos.id_alumno='.$request->id_alu.'
            AND exp_asigna_generacion.id_asigna_generacion='.$request->id);

        return $data;
    }

    public function enviareportec(Request $request)
    {
        $comp=DB::table('reporte_tutor')
                ->select(DB::raw('id_reporte_tutor'))
                ->where('id_asigna_generacion','=',$request->id_asigna_generacion)
                ->where('n_cuenta','=',$request->cuenta)
                ->first();

        $repo = array('id_asigna_generacion' =>$request->id_asigna_generacion, 
                    'alumno' =>$request->nombre,
                    'appaterno'=>$request->apaterno,
                    'apmaterno'=>$request->amaterno,
                    'n_cuenta'=>$request->cuenta,
                    'beca'=>$request->beca,
                    'repeticion'=>$request->materias_repeticion,
                    'especial'=>$request->materias_especial,
                    'tutoria_grupal'=>$request->tutoria_grupal,
                    'tutoria_individual'=>$request->tutoria_individual,
                    'academico'=>$request->academico,
                    'medico'=>$request->medico,
                    'psicologico'=>$request->psicologico,
                    'baja'=>$request->estado,
                    'observaciones'=>$request->observaciones,);

        if ($comp == 0) 
        {
            Tutorias_Reporte_tutor::create($repo);
        }
    }

    public function veractualizac(Request $request)
    {
        $data['otro']=DB::select('SELECT exp_asigna_tutor.id_asigna_generacion,UPPER(gnral_alumnos.nombre) as nombre,
                                UPPER(gnral_alumnos.apaterno) as apaterno, UPPER(gnral_alumnos.amaterno) as amaterno,
                                gnral_alumnos.cuenta,reporte_tutor.tutoria_grupal,reporte_tutor.tutoria_individual,
                                exp_generales.beca,exp_generales.materias_repeticion,exp_generales.materias_especial,
                                reporte_tutor.academico,reporte_tutor.medico,reporte_tutor.psicologico,exp_asigna_alumnos.estado,
                                reporte_tutor.observaciones
                                FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,reporte_tutor 
                                WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                                AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                                AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                                AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                                AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                                AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                                AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                                AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                                AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                                AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                                AND exp_asigna_tutor.deleted_at is null 
                                AND exp_asigna_generacion.deleted_at is null 
                                AND exp_asigna_alumnos.deleted_at is null 
                                AND exp_asigna_alumnos.id_alumno='.$request->id_alu.'
                                AND exp_asigna_generacion.id_asigna_generacion='.$request->id);

        return $data;
    }

    
public function guardar_observacion (Request $request){
    //dd($request);
    $hoy = date("Y-m-d H:i:s");
    DB::table('rep_carrera')
    ->insert (['id_asigna_generacion'=> $request->id_asigna_gen,
    "observaciones"=>$request->observacion,
    "fecha_registro"=>$hoy]);
    return back ();
   // dd($request);
}
public function editar_observacion_tutor($id_asigna_generacion){
//dd($id_asigna_generacion);
$observacion = DB::selectOne('SELECT *from rep_carrera WHERE id_asigna_generacion = '.$id_asigna_generacion.'');
return view('tutorias.coordinadorc.reportecarrera.mood_observacion',compact('observacion'));
 
}
public function guardar_mod_observacion(Request $request,$id_repcarrera){
    $hoy = date("Y-m-d H:i:s");
    DB::table('rep_carrera')
    ->where('id_repcarrera', $id_repcarrera)
    ->update ([
    "observaciones"=>$request->observacion_mod,
    "fecha_registro"=>$hoy]);
    return back ();
}
}
