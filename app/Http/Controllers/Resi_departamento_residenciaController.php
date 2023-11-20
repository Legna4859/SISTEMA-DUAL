<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpParser\Node\Stmt\While_;
use Session;
class Resi_departamento_residenciaController extends Controller
{
    public function index(){
        $periodo = Session::get('periodo_actual');

        /*$carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        */

return view('residencia.departamento_residencia.inicio_residencia');
    }
    public function institucional_proyectos(){
        $periodo = Session::get('periodo_actual');
         $anteproyectos=DB::table('resi_asesores')
             ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
             ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
             ->join('gnral_personales','gnral_personales.id_personal','=','resi_asesores.id_profesor')
             ->join('resi_proyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
             ->where('resi_asesores.id_periodo','=',$periodo)
             ->where('resi_anteproyecto.autorizacion_departamento','=',1)
             ->select('resi_proyecto.nom_proyecto','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_personales.nombre as profesor')
             ->get();
         //dd($anteproyectos);
       return view('residencia.departamento_residencia.anteproyectos_institucional',compact('anteproyectos'));

    }
    public function carreras_proyectos(){
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=0;
        return view('residencia.departamento_residencia.inicio_carrera',compact('carreras','mostrar'));

    }
    public function carreras_departamento_mostrar($id_carrera){
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;
        $periodo = Session::get('periodo_actual');
        $anteproyectos=DB::table('resi_asesores')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('gnral_personales','gnral_personales.id_personal','=','resi_asesores.id_profesor')
            ->join('resi_proyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
            ->where('resi_asesores.id_periodo','=',$periodo)
            ->where('resi_asesores.id_carrera','=',$id_carrera)
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->select('resi_anteproyecto.id_anteproyecto','resi_proyecto.nom_proyecto','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_personales.nombre as profesor')
            ->get();
        return view('residencia.departamento_residencia.inicio_carrera',compact('carreras','mostrar','id_carrera','anteproyectos'));
    }
public function estadisticas_residencia(){
        return view('residencia.departamento_residencia.inicio_estadisticas');
}
    public function institucional_estadisticas(){
        $periodo = Session::get('periodo_actual');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
       // dd($carreras);
        $total_anteproyecto=DB::table('resi_asesores')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->join('resi_proy_empresa','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('gnral_personales','gnral_personales.id_personal','=','resi_asesores.id_profesor')
            ->join('resi_proyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
            ->where('resi_asesores.id_periodo','=',$periodo)
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->select(DB::raw('count(resi_asesores.id_anteproyecto) as total'))
            ->get();
        $total_anteproyecto=$total_anteproyecto[0]->total;

        $array_carrera=array();
        foreach ($carreras as  $carrera){
            $anteproyectos=DB::table('resi_asesores')
                ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                ->join('resi_proy_empresa','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
                ->join('gnral_personales','gnral_personales.id_personal','=','resi_asesores.id_profesor')
                ->join('resi_proyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
                ->where('resi_asesores.id_periodo','=',$periodo)
                ->where('resi_asesores.id_carrera','=',$carrera->id_carrera)
                ->where('resi_anteproyecto.autorizacion_departamento','=',1)
                ->select(DB::raw('count(resi_asesores.id_anteproyecto) as total'))
                ->get();

            $dat_carrera['id_carrera']=$carrera->id_carrera;
            $dat_carrera['carrera']=$carrera->nombre;
            $dat_carrera['color']=$carrera->COLOR;
            $dat_carrera['total']=$anteproyectos[0]->total;
            $porcentaje=($anteproyectos[0]->total*100)/$total_anteproyecto;
            $dat_carrera['porcentaje']=number_format($porcentaje, 2, '.', '');
            array_push($array_carrera,$dat_carrera);
        }

return view('residencia.departamento_residencia.carreras_estadisticas',compact('array_carrera','total_anteproyecto'));
    }
    public function giro_estadisticas(){

        $periodo = Session::get('periodo_actual');
        //dd($periodo);
        $giros=DB::table('resi_giro')
            ->select('resi_giro.*')
            ->get();
        $total_giro=DB::table('resi_proy_empresa')
            ->join('resi_asesores','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->where('resi_asesores.id_periodo','=',$periodo)
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
            ->get();

        $total_giro=$total_giro[0]->total;
       // dd($total_giro);
        $array_giro=array();
        foreach ($giros as $giro){
            $anteproyectos=DB::table('resi_proy_empresa')
                ->join('resi_asesores','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                ->where('resi_anteproyecto.autorizacion_departamento','=',1)
                ->where('resi_asesores.id_periodo','=',$periodo)
                ->where('resi_proy_empresa.id_giro','=',$giro->id_giro)
                ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
                ->get();

            $dat_carrera['id_giro']=$giro->id_giro;
            $dat_carrera['giro']=$giro->descripcion;
            $porcentaje=($anteproyectos[0]->total*100)/$total_giro;
            $dat_carrera['porcentaje']=number_format($porcentaje, 2, '.', '');
            $dat_carrera['total']=$anteproyectos[0]->total;
            array_push($array_giro,$dat_carrera);
        }
//dd($array_giro);
        return view('residencia.departamento_residencia.giro_estadistica',compact('array_giro','total_giro'));

    }
    public function sector_estadisticas(){

        $periodo = Session::get('periodo_actual');
        //dd($periodo);
        $sectores=DB::table('resi_sector')
            ->select('resi_sector.*')
            ->get();
        $total_sector=DB::table('resi_proy_empresa')
            ->join('resi_asesores','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->where('resi_asesores.id_periodo','=',$periodo)
            ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
            ->get();

        $total_sector=$total_sector[0]->total;
        // dd($total_giro);
        $array_sector=array();
        foreach ($sectores as $sector){
            $anteproyectos=DB::table('resi_proy_empresa')
                ->join('resi_asesores','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                ->where('resi_anteproyecto.autorizacion_departamento','=',1)
                ->where('resi_asesores.id_periodo','=',$periodo)
                ->where('resi_proy_empresa.id_sector','=',$sector->id_sector)
                ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
                ->get();

            $dat_carrera['id_sector']=$sector->id_sector;
            $dat_carrera['sector']=$sector->descripcion;
            $porcentaje=($anteproyectos[0]->total*100)/$total_sector;
            $dat_carrera['porcentaje']=number_format($porcentaje, 2, '.', '');
            $dat_carrera['total']=$anteproyectos[0]->total;
            array_push($array_sector,$dat_carrera);
        }

        return view('residencia.departamento_residencia.sector_estadisticas',compact('array_sector','total_sector'));

    }
    public function carreras_estadisticas(){

        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=0;
        return view('residencia.departamento_residencia.estadisticas_carreras.inicio_estadisticas_carrera',compact('carreras','mostrar'));

    }
    public function carrera_giro_estadisticas($id_carrera){
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;
        $periodo = Session::get('periodo_actual');
        //dd($periodo);
        $giros=DB::table('resi_giro')
            ->select('resi_giro.*')
            ->get();
        $total_giro=DB::table('resi_proy_empresa')
            ->join('resi_asesores','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->where('resi_asesores.id_periodo','=',$periodo)
            ->where('resi_asesores.id_carrera','=',$id_carrera)
            ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
            ->get();

        $total_giro=$total_giro[0]->total;
        if($total_giro == 0){
            $no_hay_alumnos=0;
        }
            else{
                $no_hay_alumnos=1;
                $array_giro=array();
                foreach ($giros as $giro){
                    $anteproyectos=DB::table('resi_proy_empresa')
                        ->join('resi_asesores','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                        ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                        ->where('resi_anteproyecto.autorizacion_departamento','=',1)
                        ->where('resi_asesores.id_periodo','=',$periodo)
                        ->where('resi_proy_empresa.id_giro','=',$giro->id_giro)
                        ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
                        ->where('resi_asesores.id_carrera','=',$id_carrera)
                        ->get();
                    $dat_carrera['id_giro']=$giro->id_giro;
                    $dat_carrera['giro']=$giro->descripcion;
                    $porcentaje=($anteproyectos[0]->total*100)/$total_giro;
                    $dat_carrera['porcentaje']=number_format($porcentaje, 2, '.', '');
                    $dat_carrera['total']=$anteproyectos[0]->total;
                    array_push($array_giro,$dat_carrera);
                }
            }

        return view('residencia.departamento_residencia.estadisticas_carreras.inicio_estadisticas_carrera',compact('carreras','mostrar','array_giro','no_hay_alumnos','total_giro','id_carrera'));

    }
    public function carreras_sector_estadisticas(){

        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=0;
        return view('residencia.departamento_residencia.estadisticas_carreras.carrera_sector_estadisticas',compact('carreras','mostrar'));

    }
    public function carrera_sector($id_carrera){

        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;
        $periodo = Session::get('periodo_actual');
        //dd($periodo);

        $total_sector=DB::table('resi_proy_empresa')
            ->join('resi_asesores','resi_proy_empresa.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->where('resi_asesores.id_periodo','=',$periodo)
            ->where('resi_asesores.id_carrera','=',$id_carrera)
            ->select(DB::raw('count(resi_proy_empresa.id_sector) as total'))
            ->get();
        $total_sector=$total_sector[0]->total;
        if($total_sector== 0){
            $no_hay_alumnos=0;
        }
        else {
            $no_hay_alumnos=1;
            $periodo = Session::get('periodo_actual');
            //dd($periodo);
            $sectores = DB::table('resi_sector')
                ->select('resi_sector.*')
                ->get();


            // dd($total_giro);
            $array_sector = array();
            foreach ($sectores as $sector) {
                $anteproyectos = DB::table('resi_proy_empresa')
                    ->join('resi_asesores', 'resi_proy_empresa.id_anteproyecto', '=', 'resi_asesores.id_anteproyecto')
                    ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                    ->where('resi_anteproyecto.autorizacion_departamento','=',1)
                    ->where('resi_asesores.id_periodo', '=', $periodo)
                    ->where('resi_proy_empresa.id_sector', '=', $sector->id_sector)
                    ->where('resi_asesores.id_carrera', '=', $id_carrera)
                    ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
                    ->get();

                $dat_carrera['id_sector'] = $sector->id_sector;
                $dat_carrera['sector'] = $sector->descripcion;
                $porcentaje = ($anteproyectos[0]->total * 100) / $total_sector;
                $dat_carrera['porcentaje'] = number_format($porcentaje, 2, '.', '');
                $dat_carrera['total'] = $anteproyectos[0]->total;
                array_push($array_sector, $dat_carrera);
            }
        }
        return view('residencia.departamento_residencia.estadisticas_carreras.carrera_sector_estadisticas',compact('carreras','mostrar','array_sector','no_hay_alumnos','total_sector','id_carrera'));

    }
    public function  carrera_empresa(){
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=0;
  return view('residencia.departamento_residencia.estadisticas_carreras.empresa_carrera',compact('carreras','mostrar'));
    }
    public function carrera_empresa_mostrar($id_carrera){
       // dd($id_carrera);
        $periodo = Session::get('periodo_actual');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $si=DB::table('resi_empresa')
            ->join('resi_proy_empresa', 'resi_proy_empresa.id_empresa', '=', 'resi_empresa.id_empresa')
            ->join('resi_asesores', 'resi_proy_empresa.id_anteproyecto', '=', 'resi_asesores.id_anteproyecto')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->where('resi_asesores.id_periodo', '=', $periodo)
            ->where('resi_asesores.id_carrera', '=', $id_carrera)
            ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
            ->get();
        $si=$si[0]->total;
        if($si == 0){
            $no_hay_alumnos=0;
        }
        else{
            $no_hay_alumnos=1;
            $empresas=DB::table('resi_empresa')
                ->join('resi_proy_empresa', 'resi_proy_empresa.id_empresa', '=', 'resi_empresa.id_empresa')
                ->join('resi_asesores', 'resi_proy_empresa.id_anteproyecto', '=', 'resi_asesores.id_anteproyecto')
                ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                ->where('resi_anteproyecto.autorizacion_departamento','=',1)
                ->where('resi_asesores.id_periodo', '=', $periodo)
                ->where('resi_asesores.id_carrera', '=', $id_carrera)
                ->select('resi_empresa.*')
                ->orderBy('resi_empresa.nombre', 'DESC')
                ->groupBy('resi_empresa.id_empresa')
                ->get();
                        $array_empresa = array();
            foreach ($empresas as $empresa) {
                $anteproyectos = DB::table('resi_asesores')
                    ->join('resi_proy_empresa', 'resi_proy_empresa.id_anteproyecto', '=', 'resi_asesores.id_anteproyecto')
                    ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                    ->where('resi_anteproyecto.autorizacion_departamento','=',1)
                    ->where('resi_asesores.id_periodo', '=', $periodo)
                    ->where('resi_asesores.id_carrera', '=', $id_carrera)
                    ->where('resi_proy_empresa.id_empresa', '=',$empresa->id_empresa)
                    ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
                    ->get();

                $dat_carrera['id_empresa'] = $empresa->id_empresa;
                $dat_carrera['nombre'] = $empresa->nombre;
                $porcentaje = ($anteproyectos[0]->total * 100) / $si;
                $dat_carrera['porcentaje'] = number_format($porcentaje, 2, '.', '');
                $dat_carrera['total'] =$anteproyectos[0]->total ;
                array_push($array_empresa, $dat_carrera);

            }


        }
        $mostrar=1;
        return view('residencia.departamento_residencia.estadisticas_carreras.empresa_carrera',compact('carreras','mostrar','array_empresa','no_hay_alumnos','si','id_carrera'));

    }
    public function empresa_institucional(){
        $periodo = Session::get('periodo_actual');
        $empresas=DB::table('resi_empresa')
            ->join('resi_proy_empresa', 'resi_proy_empresa.id_empresa', '=', 'resi_empresa.id_empresa')
            ->join('resi_asesores', 'resi_proy_empresa.id_anteproyecto', '=', 'resi_asesores.id_anteproyecto')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->where('resi_asesores.id_periodo', '=', $periodo)
            ->select('resi_empresa.*')
            ->orderBy('resi_empresa.nombre', 'DESC')
            ->groupBy('resi_empresa.id_empresa')
            ->get();
       // dd($empresas);
        $si=DB::table('resi_empresa')
            ->join('resi_proy_empresa', 'resi_proy_empresa.id_empresa', '=', 'resi_empresa.id_empresa')
            ->join('resi_asesores', 'resi_proy_empresa.id_anteproyecto', '=', 'resi_asesores.id_anteproyecto')
            ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->where('resi_asesores.id_periodo', '=', $periodo)
            ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
            ->get();
        $si=$si[0]->total;
        $array_empresa = array();
        foreach ($empresas as $empresa) {
            $anteproyectos = DB::table('resi_asesores')
                ->join('resi_proy_empresa', 'resi_proy_empresa.id_anteproyecto', '=', 'resi_asesores.id_anteproyecto')
                ->join('resi_anteproyecto','resi_anteproyecto.id_anteproyecto','=','resi_asesores.id_anteproyecto')
                ->where('resi_anteproyecto.autorizacion_departamento','=',1)
                ->where('resi_asesores.id_periodo', '=', $periodo)
                ->where('resi_proy_empresa.id_empresa', '=',$empresa->id_empresa)
                ->select(DB::raw('count(resi_proy_empresa.id_giro) as total'))
                ->get();
            $total_alumnos = DB::select('SELECT COUNT(gnral_carreras.id_carrera)contar, gnral_carreras.nombre, gnral_carreras.id_carrera
            from gnral_carreras, resi_anteproyecto, resi_proy_empresa, resi_asesores WHERE
             resi_proy_empresa.id_anteproyecto=resi_anteproyecto.id_anteproyecto and 
             resi_anteproyecto.autorizacion_departamento=1 and
            resi_anteproyecto.id_anteproyecto = resi_asesores.id_anteproyecto and resi_asesores.id_periodo='.$periodo.' 
            and resi_asesores.id_carrera = gnral_carreras.id_carrera and resi_proy_empresa.id_empresa='.$empresa->id_empresa.' 
GROUP by gnral_carreras.id_carrera');
            $array_alumnos=array();
            foreach ( $total_alumnos as $total){
                $dat_al['carrera']=$total->nombre;
                $dat_al['total']=$total->contar;
                array_push($array_alumnos, $dat_al);
            }


            $dat_carrera['id_empresa'] = $empresa->id_empresa;
            $dat_carrera['nombre'] = $empresa->nombre;
            $porcentaje = ($anteproyectos[0]->total * 100) / $si;
            $dat_carrera['porcentaje'] = number_format($porcentaje, 2, '.', '');
            $dat_carrera['total'] =$anteproyectos[0]->total ;
            $dat_carrera['array_al'] =$array_alumnos ;
            array_push($array_empresa, $dat_carrera);

        }

       return view('residencia.departamento_residencia.empresa_institucional',compact('array_empresa','si'));
    }
    public function exportar_datos_alumnos_residencia()
    {
        Excel::create('DatosGeneralesdelosResidentes',function ($excel)
        {
            $periodo=Session::get('periodo_actual');

            $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera!=9 AND id_carrera!=11 AND id_carrera!=15 ORDER BY id_carrera ');
            $array_carreras=array();
            foreach ($carreras as $carrera)
            {

                $dat_carreras['id_carrera'] = $carrera->id_carrera;
                $dat_carreras['nom_carrera'] = $carrera->nombre;
                $dat_carreras['siglas'] = $carrera->siglas;
                $datos_generales=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.correo_al,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,resi_proyecto.nom_proyecto,resi_empresa.nombre empresa,resi_sector.descripcion sector,resi_giro.descripcion giro,resi_empresa.domicilio,resi_empresa.tel_empresa,
resi_empresa.correo,resi_empresa.dir_gral,resi_proy_empresa.asesor asesor_externo,gnral_carreras.nombre carrera,resi_proy_empresa.puesto,gnral_personales.nombre asesor_interno,abreviaciones.titulo from gnral_alumnos,resi_anteproyecto,resi_proy_empresa,resi_empresa,resi_giro,resi_sector,resi_proyecto,
resi_asesores,gnral_personales,abreviaciones_prof,abreviaciones,gnral_carreras
WHERE gnral_alumnos.id_carrera=gnral_carreras.id_carrera and gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto=resi_proy_empresa.id_anteproyecto 
and resi_proy_empresa.id_empresa=resi_empresa.id_empresa
and resi_proy_empresa.id_giro=resi_giro.id_giro and 
resi_proy_empresa.id_sector=resi_sector.id_sector and 
resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto
and resi_asesores.id_periodo='.$periodo.'
and resi_anteproyecto.autorizacion_departamento=1
and resi_anteproyecto.id_anteproyecto=resi_asesores.id_anteproyecto
and resi_asesores.id_carrera='.$carrera->id_carrera.'
and resi_asesores.id_profesor=gnral_personales.id_personal
and gnral_personales.id_personal=abreviaciones_prof.id_personal
and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre  ASC');


                $array_generales=array();
                foreach ($datos_generales as $dato)
                {
                    $dat_generales['cuenta']=$dato->cuenta;
                    $dat_generales['nombre']=mb_strtoupper($dato->apaterno,'utf-8')." ".mb_strtoupper($dato->amaterno,'utf-8')." ".mb_strtoupper($dato->nombre,'utf-8');
                    $dat_generales['correo_al']=$dato->correo_al;
                    $dat_generales['nom_proyecto']=mb_strtoupper($dato->nom_proyecto,'utf-8');
                    $dat_generales['empresa']=$dato->empresa;
                    $dat_generales['sector']=$dato->sector;
                    $dat_generales['giro']=$dato->giro;
                    $dat_generales['domicilio']=$dato->domicilio;
                    $dat_generales['tel_empresa']=$dato->tel_empresa;
                    $dat_generales['correo']=$dato->correo;
                    $dat_generales['dir_gral']=$dato->dir_gral;
                    $dat_generales['asesor_externo']=$dato->asesor_externo;
                    $dat_generales['carrera']=$dato->carrera;
                    $dat_generales['puesto']=$dato->puesto;
                    $dat_generales['asesor_interno']=$dato->titulo.' '.$dato->asesor_interno;

                    array_push($array_generales,$dat_generales);
                }
                $dat_carreras['dat_general']=$array_generales;
                array_push($array_carreras,$dat_carreras);
            }
            // dd($array_carreras);

            foreach ($array_carreras as $carrera)
            {
                $i=3;
                $excel->sheet($carrera['siglas'], function($sheet) use($carrera,$i)
                {
                    $sheet->mergeCells('A1:O1');

                    $sheet->row(1, [
                        $carrera['nom_carrera']
                    ]);
                    $sheet->row(3, [
                        'No. de Cuenta', 'Nombre del alumno','Correo del alumno','Nombre del proyecto',
                        'Nombre de la empresa','Sector de la empresa',
                        'Giro de la empresa','Domicilio de la empresa',
                        'Telefono de la empresa','Correo de la empresa',
                        'Representante de la empresa','Nombre del asesor externo',
                        'Puesto del asesor externo','Nombre del asesor interno','Carrera'
                    ]);
                    foreach ($carrera['dat_general'] as $generales)
                    {

                        $i++;
                        $sheet->row($i, [
                            $generales['cuenta'],$generales['nombre'],$generales['correo_al'],
                            $generales['nom_proyecto'],$generales['empresa'],
                            $generales['sector'],$generales['giro'],$generales['domicilio'],
                            $generales['tel_empresa'],$generales['correo'],$generales['dir_gral'],
                            $generales['asesor_externo'],$generales['puesto'],
                            $generales['asesor_interno'],$generales['carrera']
                        ]);
                    }

                });
            }
        })->export('xlsx');
    }
}
