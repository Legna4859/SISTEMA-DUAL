<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Activa_evaluacion;
class Buscar_alumnos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $periodo=Session::get('periodo_actual');

        $carreras=DB::select('select gnral_carreras.id_carrera, gnral_carreras.nombre,gnral_carreras.COLOR ya, gnral_carreras.COLOR no, gnral_carreras.COLOR por,gnral_carreras.COLOR total from gnral_carreras;');
        $carreras2=DB::select('select*from gnral_carreras');
        $numerop=DB::select('select*from eva_pregunta');
        $alumnos=DB::select('select gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno ,gnral_semestres.id_semestre,eva_validacion_de_cargas.no_pregunta,gnral_alumnos.id_carrera 
from eva_validacion_de_cargas,gnral_alumnos,gnral_carreras,gnral_semestres,eva_carga_academica 
WHERE gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
and gnral_alumnos.id_semestre=gnral_semestres.id_semestre 
and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno 
and eva_validacion_de_cargas.id_periodo='.$periodo.'
and eva_validacion_de_cargas.estado_validacion=2
and eva_carga_academica.id_alumno=eva_validacion_de_cargas.id_alumno
and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo
and eva_carga_academica.id_materia  NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
GROUP by gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno ORDER by gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre
');

        /* $alumnoss=DB::select('select gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno ,gnral_semestres.id_semestre,eva_validacion_de_cargas.no_pregunta,gnral_alumnos.id_carrera from eva_validacion_de_cargas,gnral_alumnos,gnral_carreras,gnral_semestres WHERE
gnral_alumnos.id_carrera=gnral_carreras.id_carrera and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and eva_validacion_de_cargas.id_periodo='.$periodo.'');
*/
$total=count($numerop)+1;


foreach ($carreras as $carre)
 {
     $alumnostodos=DB::select('select gnral_alumnos.cuenta,gnral_alumnos.nombre,
gnral_alumnos.apaterno,gnral_alumnos.amaterno ,gnral_semestres.id_semestre,eva_validacion_de_cargas.no_pregunta,
gnral_alumnos.id_carrera 
from eva_validacion_de_cargas,gnral_alumnos,gnral_carreras,gnral_semestres,eva_carga_academica 
WHERE gnral_alumnos.id_carrera=gnral_carreras.id_carrera and gnral_alumnos.id_semestre=gnral_semestres.id_semestre 
and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and gnral_alumnos.id_carrera='.$carre->id_carrera.' 
and eva_validacion_de_cargas.id_periodo='.$periodo.' 
and eva_validacion_de_cargas.estado_validacion=2 
AND
eva_carga_academica.id_status_materia=1
and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
and eva_carga_academica.id_periodo='.$periodo.'
and eva_carga_academica.id_materia NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
 AND eva_carga_academica.id_status_materia=1 GROUP by eva_validacion_de_cargas.id_alumno');


    $alumnostodos=count($alumnostodos);


     $alumnosya=DB::select('select gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno ,gnral_semestres.id_semestre,eva_validacion_de_cargas.no_pregunta,gnral_alumnos.id_carrera 
from eva_validacion_de_cargas,gnral_alumnos,gnral_carreras,gnral_semestres,eva_carga_academica WHERE
gnral_alumnos.id_carrera=gnral_carreras.id_carrera and gnral_alumnos.id_semestre=gnral_semestres.id_semestre
and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno and gnral_alumnos.id_carrera='.$carre->id_carrera.' and 
eva_validacion_de_cargas.no_pregunta='.$total.' and eva_validacion_de_cargas.id_periodo='.$periodo.'
and eva_validacion_de_cargas.estado_validacion=2 and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
and eva_carga_academica.id_periodo='.$periodo.' 
and eva_carga_academica.id_materia  NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571) AND
eva_carga_academica.id_status_materia=1 GROUP by eva_validacion_de_cargas.id_alumno');



    $alumnosya=count($alumnosya);

if($alumnostodos==null)
{

    $carre->total=0;
    $carre->ya=0;
$carre->no=0;
$carre->por=0;
}
else{
 
$carre->total=$alumnostodos;
$carre->ya=$alumnosya;
$carre->no=$alumnostodos-$alumnosya;
$por=$alumnosya*100;
$por=$por/$alumnostodos;
$por=(round($por*10)/10);
$carre->por=$por;

}


  
}
//dd($alumnos);

foreach ($alumnos as $alu) 
{
    if($alu->no_pregunta==count($numerop)+1)
    {

        $alu->no_pregunta=1000;
    }
//dd($alu->no_pregunta);


    if($alu->no_pregunta>=1 &&  $alu->no_pregunta<count($numerop)+1)
    {
        $porcentaje=($alu->no_pregunta*100);
      //  dd($porcentaje);
        $porcentaje=$porcentaje/(count($numerop)+1);
        $porcentaje=$nu=(round($porcentaje*10)/10);

        $alu->no_pregunta=$porcentaje;
       

    }
    if($alu->no_pregunta==0)
    {

        $alu->no_pregunta=0;
    }

}

$alumnoss=$alumnos;
$activa_eva=DB::selectOne('select eva_activa_evaluacion.estado from eva_activa_evaluacion WHERE eva_activa_evaluacion.id=1');
$activa_eva=$activa_eva->estado;



$evaluar=DB::selectOne('select*from eva_calificaciones_pre where eva_calificaciones_pre.id_periodo='.$periodo.'');

if($evaluar==null)
{
    $evaluar=1;
}
else
{
    $evaluar=2;
}
    // dd($alumnoss);
        return view('evaluacion_docente.Alumnos.buscar',compact('evaluar','carreras','carreras2','alumnos','alumnoss','activa_eva'));
 

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
    public function activar()
    {
        $activa_eva=DB::selectOne('select eva_activa_evaluacion.estado, eva_activa_evaluacion.id from eva_activa_evaluacion WHERE eva_activa_evaluacion.id=1');
        $estado=$activa_eva->estado;
        $id=$activa_eva->id;

        if ($estado==1)
         {
            
            $datos=array('estado'=>2);
            Activa_evaluacion::find($id)->update($datos);
            return $this->index();

         }
         if($estado==2)
         {
    
            $datos=array('estado'=>1);
            Activa_evaluacion::find($id)->update($datos);
            
            return $this->index();
         }

        



    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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
