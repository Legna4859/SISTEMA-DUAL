<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Session;

class Migrar extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      set_time_limit(72000);
        $periodo=Session::get('periodo_actual');

    $id_materias=DB::select('select gnral_horas_profesores.id_hrs_profesor,gnral_materias.nombre mat, gnral_carreras.nombre,
                            CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre 
                            from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                            where gnral_periodos.id_periodo='.$periodo.'
                            and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias.id_semestre=gnral_semestres.id_semestre');


$numero_de_materias_por_carrera=count($id_materias);

foreach ($id_materias as $m) 
{
      $id_profesor=($m->id_hrs_profesor);

       $consulta=DB::select('select eva_pregunta.id_criterio from eva_pregunta');///numero de preguntas con su criterio que corresponde

       $crit=DB::select('select eva_criterio.id_criterio from eva_criterio');//criterios

      $criterios=DB::selectOne('select count(id_criterio) numero from eva_criterio');//obtener el numero de criterios

            //$numero_de_alumnos=DB::selectOne('select COUNT(eva_alumno_materias.id_hrs_profesor)alumnos 
                      //                        from eva_alumno_materias 
                        //                      where eva_alumno_materias.id_hrs_profesor='.$id_profesor.'');


            $criterios=($criterios->numero);//trae el numero de criterios total
            $ciclodiv=$criterios+1;

            for ($i=0; $i <$criterios ; $i++) 
           { 

               
               
                $numero_de_preguntas[$i]=DB::selectOne('select count(id_criterio)pregunta 
                                                        from eva_pregunta 
                                                        where id_criterio='.$crit[$i]->id_criterio.'');
                //dd($numero_de_preguntas);
              
                $entre[]=($numero_de_preguntas[$i]->pregunta);
          
            }

           //////////////////////////////////
  $sumacondicion=0;
            for ($i=0; $i <count($consulta); $i++) 
            { 

               $ii=$i+1;
               $cambio=0;
              
                        if($ii==26||$ii==35)
                         {   
                          $valor=DB::select('select p'.$ii.'.valor suma 
                                              FROM p'.$ii.', eva_alumno_materias,gnral_horas_profesores 
                                              WHERE gnral_horas_profesores.id_hrs_profesor='.$id_profesor.' 
                                              AND p'.$ii.'.id_alumno_materia=eva_alumno_materias.id_alumno_materia 
                                              AND eva_alumno_materias.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');//obtiene el valor de la primera prgunta
                       
//dd($valor);
                            foreach ($valor as $val)
                           {
                                if($val->suma==5)
                                {
                                    $cambio=1;
                                }
                                if($val->suma==4)
                                {
                                    $cambio=2;
                                }
                                if($val->suma==3)
                                {
                                    $cambio=3;
                                }
                                if($val->suma==2)
                                {
                                    $cambio=4;
                                }
                                if($val->suma==1)
                                {
                                    $cambio=5;
                                }
                                $sumacondicion=$sumacondicion+$cambio;
                            }
                            //  $p[$i]=($sumacondicion);
                             // $sumacondicion=0;
                        }
                        else
                        {
                             $valor=DB::selectOne('select SUM(p'.$ii.'.valor) suma 
                                              FROM p'.$ii.', eva_alumno_materias,gnral_horas_profesores 
                                              WHERE gnral_horas_profesores.id_hrs_profesor='.$id_profesor.' 
                                              AND p'.$ii.'.id_alumno_materia=eva_alumno_materias.id_alumno_materia 
                                              AND eva_alumno_materias.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');//obtiene el valor de la primera prgunta
                          $sumacondicion=$valor->suma;
                        }


            $numero_de_alumnos=DB::SelectOne('select COUNT(p'.$ii.'.valor) suma 
                                              FROM p'.$ii.', eva_alumno_materias,gnral_horas_profesores 
                                              WHERE gnral_horas_profesores.id_hrs_profesor='.$id_profesor.' 
                                              AND p'.$ii.'.id_alumno_materia=eva_alumno_materias.id_alumno_materia 
                                              AND eva_alumno_materias.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');

            $numero_de_alumnos=($numero_de_alumnos->suma);
                       // $p[$i]=($valor->suma);

                        if($numero_de_alumnos==0)
                        {
                            $p2[$i]=0;
                        }
                        else
                        {
                            $p2[$i]=($sumacondicion/$numero_de_alumnos);
                         //   dd($numero_de_alumnos);
                            $p2[$i]=(round($p2[$i]*1000)/1000);
                        }
$criterio_p=DB::selectOne('select eva_pregunta.id_criterio from eva_pregunta WHERE eva_pregunta.no_pregunta='.$ii.'');
$criterio_p=$criterio_p->id_criterio;
DB::insert('insert into eva_calificaciones_pre(id_periodo,no_pregunta,calificacion_p,id_hrs_profesor,id_criterio) values (?,?,?,?,?)', [$periodo,$ii,$p2[$i],$id_profesor,$criterio_p]);

$sumacondicion=0;

            }

            

           
}
$mensage_carga="Los resultados de la Evaluacion estan listos para consultarse";
$color=2;
       return view('evaluacion_docente.Admin.mensages2',compact('mensage_carga','color'));
  

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

     


    public function imprecion()
    {
          

          $pdf=new impresion($orientation='P',$unit='mm',$format='Letter');
            $pdf->SetMargins(20, 25 , 20);
            $pdf->SetAutoPageBreak(true,25);
            $pdf->AddPage();
            $pdf->SetFont('Arial','','11');

            $pdf->Output();
            exit();






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


class impresion extends FPDF
{

    function Header()
{
    $this->Image('img/gem.png',20,10,32);

}


}
