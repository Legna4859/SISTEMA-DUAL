<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tutorias_Reporte_tutor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class Tutorias_ReporteSemestralController extends Controller
{
    public function index()
    {
        return view('tutorias.profesor.repsemestral');
    }

    public function alum(Request $request)
    {
        $datos=DB::table('gnral_alumnos')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_alumno','=','gnral_alumnos.id_alumno')
            ->select(DB::raw('UPPER(gnral_alumnos.nombre) as nombre, UPPER(gnral_alumnos.apaterno) as apaterno, UPPER(gnral_alumnos.amaterno) as amaterno, gnral_alumnos.id_alumno, gnral_alumnos.cuenta, exp_asigna_alumnos.estado, exp_asigna_alumnos.id_asigna_generacion'))
            ->where('exp_asigna_alumnos.id_asigna_generacion', '=', $request->id_asigna_generacion)
            ->where('gnral_alumnos.id_carrera','=',$request->id_carrera)
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->orderBy('gnral_alumnos.cuenta')
            ->get();
        Session::put('asigna_gen',$request->id_asigna_generacion);
        $datoss=array();
        foreach ($datos as $dato){
            $dat['nombre']=$dato->nombre;
            $dat['apaterno']=$dato->apaterno;
            $dat['amaterno']=$dato->amaterno;
            $dat['id_alumno']=$dato->id_alumno;
            $dat['cuenta']=$dato->cuenta;
            $dat['estado']=$dato->estado;
            $dat['id_asigna_generacion']=$dato->id_asigna_generacion;
            $con=DB::selectOne("SELECT count(id_reporte_tutor) contar FROM reporte_tutor WHERE id_asigna_generacion = $dato->id_asigna_generacion AND n_cuenta = '$dato->cuenta'");
             if($con->contar == 0){
                 $dat['conteo']=false;
             }
             else{
                 $dat['conteo']=true;
             }

            array_push($datoss,$dat);
        }
       return $datoss;

    }

    public function verpararepo(Request $request)
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

    public function enviareporte(Request $request)
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

    public function veractualiza(Request $request)
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

    public function envreporteact(Request $request)
    {
        DB::table('reporte_tutor')
            ->where('id_asigna_generacion', '=', $request->id_asigna_generacion)
            ->where('n_cuenta','=',$request->cuenta)
            ->update(array("tutoria_grupal"=>$request->tutoria_grupal,
                            "tutoria_individual"=>$request->tutoria_individual,
                            "beca"=>$request->beca,
                            "repeticion"=>$request->materias_repeticion,
                            "especial"=>$request->materias_especial,
                            "academico"=>$request->academico,
                            "medico"=>$request->medico,
                            "psicologico"=>$request->psicologico,
                            "baja"=>$request->estado,
                            "observaciones"=>$request->observaciones,));
    }

}
