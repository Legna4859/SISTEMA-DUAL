<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\FPDF as FPDF;
use Session;


class reportes_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_profesor)
    {
        $periodo=Session::get('periodo_actual');

            $solo_id_profesor=$id_profesor;

//////////////////////////////////////////////////////////////////////////GRAFICA GENERAL

$promedios=[];

          $cadena="[";
            //$datos=(explode(',',$id_profesor));
        //    dd($datos);
          //  $con_carrera=$datos[0];/////para consultar con id_hrs_pro
           // $solo_id_profesor=$datos[1];


            $arreglofinal=[];////////////////////////////////////////////////////////////////////////////////////////////

    $id_materias=DB::select('select gnral_horas_profesores.id_hrs_profesor,gnral_materias.nombre mat, gnral_carreras.nombre,
                            CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre 
                            from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                            where gnral_periodos.id_periodo='.$periodo.'
                            and gnral_horarios.id_personal='.$solo_id_profesor.' 
                            and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias.id_semestre=gnral_semestres.id_semestre');


$numero_de_materias_por_carrera=count($id_materias);
//dd($numero_de_materias_por_carrera);
 //dd($id_materias);

$calificaciones_por_materia=[];
$finall=[];

for ($m=0; $m <$numero_de_materias_por_carrera ; $m++)

 { 
        
        $id_profesor=($id_materias[$m]->id_hrs_profesor);
    //    dd($id_profesor);







          $cadena.="{name:'".($id_materias[$m]->mat)."',";
          
           
            $entre=[];
            $entre[0]=0;

            $consulta=DB::select('select eva_pregunta.id_criterio from eva_pregunta');//a2

            $crit=DB::select('select eva_criterio.id_criterio from eva_criterio');
            $criterios=DB::selectOne('select count(id_criterio) numero from eva_criterio');
            $numero_de_alumnos=DB::selectOne('select COUNT(eva_alumno_materias.id_hrs_profesor)alumnos 
                                              from eva_alumno_materias 
                                              where eva_alumno_materias.id_hrs_profesor='.$id_profesor.'');
            $numero_de_alumnos=($numero_de_alumnos->alumnos);
            //dd($numero_de_alumnos);
 
            $criterios=($criterios->numero);
            $ciclodiv=$criterios+1;

          //dd($crit);
            $valores=[];
           // dd($criterios);
            for ($i=0; $i <$criterios ; $i++) 
           { 

               
               
                $numero_de_preguntas[$i]=DB::selectOne('select count(id_criterio)pregunta 
                                                        from eva_pregunta 
                                                        where id_criterio='.$crit[$i]->id_criterio.'');
               // dd($numero_de_preguntas);
                $entre[]=($numero_de_preguntas[$i]->pregunta);
                //$promedios[$i]="";
            }           
            for ($i=0; $i <48 ; $i++) 
            { 

               $ii=$i+1;

                        $valor=DB::selectOne('select SUM(p'.$ii.'.valor) suma 
                                              FROM p'.$ii.', eva_alumno_materias,gnral_horas_profesores 
                                              WHERE gnral_horas_profesores.id_hrs_profesor='.$id_profesor.' 
                                              AND p'.$ii.'.id_alumno_materia=eva_alumno_materias.id_alumno_materia 
                                              AND eva_alumno_materias.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');//obtiene el valor de la primera prgunta
                        $p[$i]=($valor->suma);

                        if($numero_de_alumnos==0)
                        {
                            $p2[$i]=0;
                        }
                        else
                        {
                            $p2[$i]=($valor->suma/$numero_de_alumnos);
                         //   dd($numero_de_alumnos);
                            $p2[$i]=(round($p2[$i]*1000)/1000);
                        }
                        

                        
                    

            }


$solo_preguntas[$m]=$p2;//////lleva el promedio de la calificacion de cada materia por pregunta
                $suma=0;
dd($solo_preguntas);

  

    ///////////////////////////////////////////suma las p que pertenescan al mismo criterio

             for ($i=1; $i <$criterios+1; $i++) 
            { 
                //i==1
                 for ($j=0; $j<48 ; $j++) 
                { 
                    //si consulta en su posicion 0=1
                    if($consulta[($j)]->id_criterio==$i)
                    {
                          
                            $suma=$suma+$p[$j];

                    }
                }
            // dd($suma);
                $arreglofinal[$i]=$suma;
                $suma=0;
                
            }


            $cadena.="data:[";
            ////////////////////dividir entre numero de alumnos que evaluaron///////////

             for ($i=1; $i <$ciclodiv ; $i++) 
            {

                if($numero_de_alumnos==0)
                {
                  $arreglofinal[$i]=0;
                }
                else
                {
                  $arreglofinal[$i]=($arreglofinal[$i]/$numero_de_alumnos);

                }
                

            }


/////////////////dividir el total entre numero de criterios/////
$conta=0;
   
            
            for ($i=1; $i <$ciclodiv ; $i++) 
            {

                if($arreglofinal[$i]==0)
                {

                  $nu=0;
                 
                }
                else
                {

                   $arreglofinal[]=($arreglofinal[$i]/$entre[$i]);
                   //$finall[]=($arreglofinal[$i]/$entre[$i]);

                  $nu=($arreglofinal[$i]/$entre[$i]);
                  $nu=(round($nu*1000)/1000);////////////////////////redondea a tres digitos

                }
                

                $cadena.="$nu,";
                if(!isset($promedios[$conta]))
                  $promedios[$conta]=0;
              //  echo $promedios[$conta]."--";
                $promedios[$conta]+=$nu;
                //echo $promedios[$conta]."--";

                $conta=++$conta==10?0:$conta++;
               // echo $conta."--".$nu."</br>";

             
            }
           
             $cadena.="]},";

          
//$finall['name']=$id_materias[$m]->mat;

          
       


}

 //dd($criterios);  
for ($i=0; $i <$criterios ; $i++) 
{ 
  //dd($promedios[$i]);  
    $promedios[$i]=$promedios[$i]/$numero_de_materias_por_carrera;
    
}
 //dd($promedios);
             $cadena.="]";  
                // dd($cadena);          





////////////////////////////////////////////////////////////////////////////

$carreras=DB::select('select Distinct(gnral_carreras.nombre) carrera,gnral_carreras.id_carrera 
                      from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                      where gnral_periodos.id_periodo='.$periodo.'
                      and gnral_horarios.id_personal='.$solo_id_profesor.' 
                      and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                      and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                      and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                      and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                      and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                      and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                      and gnral_horarios.id_personal=gnral_personales.id_personal 
                      and gnral_materias.id_semestre=gnral_semestres.id_semestre');
   

$datos_carreras=array(
    );

foreach ($carreras as $carrera)
{

    $nombre['nombre_carrera']=$carrera->carrera;
     $nombre['id_carrera']=$carrera->id_carrera;

     $materias=DB::select('select gnral_horas_profesores.id_hrs_profesor,gnral_materias.nombre mat, gnral_carreras.nombre,gnral_carreras.id_carrera,
        CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre 
        from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
        where gnral_periodos.id_periodo='.$periodo.'
        and gnral_carreras.id_carrera='.$carrera->id_carrera.' 
        and gnral_horarios.id_personal='.$solo_id_profesor.' 
        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
        and gnral_horarios.id_personal=gnral_personales.id_personal 
        and gnral_materias.id_semestre=gnral_semestres.id_semestre');



      
    $nombre_materias=array();
    foreach ($materias as $materia)
    {
        $nombrem['nombre_materia']=$materia->mat;
        $nombrem['nombre_grupo']=$materia->grupo;
         $nombrem['id_hrs']=$materia->id_hrs_profesor;
         $nombrem['idcarrera']=$materia->id_carrera;

        array_push($nombre_materias,$nombrem);    
    }
    $nombre['materias']=$nombre_materias;
    array_push($datos_carreras, $nombre);


}
   

$rubros=DB::select('select eva_criterio.nombre_criterio rubros 
                    from eva_criterio');
$grafica_condicion="GRAFICA GENERAL";

///////////////////////////////////////////////////////////valor por cada pregunta/////////////////////////////////////////////////////////////

$preguntas=DB::select('select eva_pregunta.id_criterio cri,eva_pregunta.no_pregunta, eva_pregunta.descripcion,eva_pregunta.id_criterio,eva_pregunta.descripcion observacion from eva_pregunta');
//dd($solo_preguntas);
$sum=0;
for ($i=0; $i <count($preguntas) ; $i++) { 


     for ($j=0; $j <count($solo_preguntas) ; $j++) 
     { 
          
          $sum=$sum+$solo_preguntas[$j][$i];
         
     }
     $sum=$sum/count($solo_preguntas);
     $sum=(round($sum*1000)/1000);
     $preguntas[$i]->id_criterio=$sum;
    if($sum>=0 && $sum<3)
                {
                  $ii=$i+1;
                  $observacioncad=DB::selectOne('select eva_pregunta.recomendaciones from eva_pregunta where eva_pregunta.no_pregunta='.$ii.'');
               
                  $preguntas[$i]->observacion=$observacioncad->recomendaciones;
                          }
                else
                {
                  $ii=$i+1;
                  $observacioncad=DB::selectOne('select eva_pregunta.felicitaciones from eva_pregunta where eva_pregunta.no_pregunta='.$ii.'');
               
                  $preguntas[$i]->observacion=$observacioncad->felicitaciones;
                }
                $sum=0;
}
//dd($preguntas);

///////////////ordena prefuntas por el criterio 

$criterios=DB::select('select *from eva_criterio');
////////////////////////////////////////////////////llenar el arreglo con la calificacion del criterio

$cicloscri=count($criterios);
for ($i=0; $i <$cicloscri ; $i++) 
{ 

  $criterios[$i]->color=(round($promedios[$i]*1000)/1000);
}


///////////////////////////////////////////////////

$datos_preguntas=array(
    );
foreach ($criterios as $cri) 
{
     $nombrep['nombre_criterio']=$cri->nombre_criterio;


     $nombrep['calificacion']=$cri->color;
     if($cri->color>=0 && $cri->color<=1)
     {
          $observacioncri='No suficiente';
     }
     if($cri->color>=1.1 && $cri->color<=2)
     {
          $observacioncri='Suficiente';
     }
     if($cri->color>=2.1 && $cri->color<=3)
     {
          $observacioncri='Bien';
     }
        if($cri->color>=3.1 && $cri->color<=4)
     {
          $observacioncri='Muy Bien';
     }
     if($cri->color>=4.1 && $cri->color<=5)
     {
          $observacioncri='Excelente';
     }
     $nombrep['observacioncri']=$observacioncri;
     $cantidad=DB::selectOne('select count(id_criterio)pregunta 
                                                        from eva_pregunta 
                                                        where id_criterio='.$cri->id_criterio.'');
    
     $nombrep['cantidad']=$cantidad->pregunta+1;///////////////////calculando el numero de preguntas por criterio

     $preguntascri=DB::select('select eva_pregunta.descripcion, eva_pregunta.no_pregunta  FROM eva_criterio,eva_pregunta WHERE eva_criterio.id_criterio=eva_pregunta.id_criterio and 
      eva_criterio.id_criterio='.$cri->id_criterio.'');

$arrpreguntas=array(
    );
     foreach ($preguntascri as $precri)
    {
//dd($preguntas);
        $nombremp['pregunta']=$precri->descripcion;
        $buscarp=($precri->no_pregunta-1);
        $nombremp['calificacion']=$preguntas[$buscarp]->id_criterio;
        $nombremp['observacion']=$preguntas[$buscarp]->observacion;

        array_push($arrpreguntas,$nombremp);    
      //  dd($arrpreguntas);
    }
    
     $nombrep['preguntas']=$arrpreguntas;
     array_push($datos_preguntas, $nombrep);
      
}





      // return view('Admin.reportes',compact('solo_id_profesor','arreglofinal','finall'))->with('carreras',$datos_carreras,$finall);
return view('evaluacion_docente.Admin.reportes',compact('solo_id_profesor','rubros','finall','arreglofinal','cadena','promedios','grafica_condicion','preguntas'))->with(['grafica1'=>true,'carreras'=>$datos_carreras,'preguntas2'=>$datos_preguntas]);


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

      public function suma_evaluacion($id_profesor)
    {
        
            $periodo=Session::get('periodo_actual');
            $datos=(explode(',',$id_profesor));
          // dd($datos);
            $id_profesor=$datos[0];/////para consultar con id_hrs_pro
            $solo_id_profesor=$datos[1];
            $n_materias=$datos[2];
            $n_grupo=$datos[3];
            
            $idcarrera=$datos[4];

            $nombre_carrera=DB::selectOne('select gnral_carreras.nombre 
                                          from gnral_carreras 
                                          where gnral_carreras.id_carrera='.$idcarrera.'');
           // dd($nombre_carrera);
           
            $entre=[];
            $entre[0]=0;

            $consulta=DB::select('select eva_pregunta.id_criterio from eva_pregunta');//a2

            $crit=DB::select('select eva_criterio.id_criterio from eva_criterio');
            $criterios=DB::selectOne('select count(id_criterio) numero from eva_criterio ');
            $numero_de_alumnos=DB::selectOne('select COUNT(eva_alumno_materias.id_hrs_profesor)alumnos from eva_alumno_materias where eva_alumno_materias.id_hrs_profesor='.$id_profesor.'');
            $numero_de_alumnos=($numero_de_alumnos->alumnos);
            //dd($numero_de_alumnos);
            $criterios=($criterios->numero);
            $ciclodiv=$criterios+1;

          //dd($crit);
            $valores=[];

            for ($i=0; $i <$criterios ; $i++) 
           { 

               
                $numero_de_preguntas[$i]=DB::selectOne('select count(id_criterio)pregunta from eva_pregunta where id_criterio='.$crit[$i]->id_criterio.'');
                $entre[]=($numero_de_preguntas[$i]->pregunta);
            }

           
            for ($i=0; $i <48 ; $i++) 
            { 

               $ii=$i+1;

                        $valor=DB::selectOne('select SUM(p'.$ii.'.valor) suma 
                                              FROM p'.$ii.', eva_alumno_materias,gnral_horas_profesores 
                                              WHERE gnral_horas_profesores.id_hrs_profesor='.$id_profesor.' 
                                              AND p'.$ii.'.id_alumno_materia=eva_alumno_materias.id_alumno_materia 
                                              AND eva_alumno_materias.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');//obtiene el valor de la primera prgunta
                        $p[$i]=($valor->suma);
                    

            }

//dd($p);

                $suma=0;
//$con=0;

    ///////////////////////////////////////////suma las p que pertenescan al mismo criterio

             for ($i=1; $i <$criterios+1; $i++) 
            { 
                //i==1
                 for ($j=0; $j<48 ; $j++) 
                { 
                    //si consulta en su posicion 0=1
                    if($consulta[($j)]->id_criterio==$i)
                    {
                          
                            $suma=$suma+$p[$j];

                    }
                }
            // dd($suma);
                $arreglofinal[$i]=$suma;
                $suma=0;
                
            }

         //   dd($arreglofinal);



            ////////////////////dividir entre numero de alumnos que evaluaron///////////

             for ($i=1; $i <$ciclodiv ; $i++) 
            {
                if($numero_de_alumnos==0)
                {
                   $arreglofinal[$i]=0; 
                }
                else
                {
                 $arreglofinal[$i]=($arreglofinal[$i]/$numero_de_alumnos); 
                }
                
            }


/////////////////dividir el total entre numero de criterios/////

   
            
            for ($i=1; $i <$ciclodiv ; $i++) 
            {
                if($arreglofinal==0)
                {
                  $arreglofinal[$i]=0;
                }
                else
                {
                   $arreglofinal[$i]=($arreglofinal[$i]/$entre[$i]);
                   $arreglofinal[$i]=(round($arreglofinal[$i]*1000)/1000);
                

                }
               

                
            }
            //dd($arreglofinal);
           // dd($arreglofinal);

            /////////////////////////////////////////////////////////consultar para recargar pagina////////////////


 $carreras=DB::select('select Distinct(gnral_carreras.nombre) carrera,gnral_carreras.id_carrera 
                      from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                      where gnral_periodos.id_periodo='.$periodo.' 
                      and gnral_horarios.id_personal='.$solo_id_profesor.' 
                      and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                      and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                      and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                      and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                      and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                      and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                      and gnral_horarios.id_personal=gnral_personales.id_personal
                      and gnral_materias.id_semestre=gnral_semestres.id_semestre');
   

$datos_carreras=array(
    );

foreach ($carreras as $carrera)
{

    $nombre['nombre_carrera']=$carrera->carrera;
     $nombre['id_carrera']=$carrera->id_carrera;

     $materias=DB::select('select gnral_horas_profesores.id_hrs_profesor,gnral_materias.nombre mat, gnral_carreras.nombre,gnral_carreras.id_carrera,
        CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre 
        from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
        where gnral_periodos.id_periodo='.$periodo.' 
        and gnral_carreras.id_carrera='.$carrera->id_carrera.' 
        and gnral_horarios.id_personal='.$solo_id_profesor.' 
        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
        and gnral_horarios.id_personal=gnral_personales.id_personal 
        and gnral_materias.id_semestre=gnral_semestres.id_semestre');
      
    $nombre_materias=array();
    foreach ($materias as $materia)
    {
        $nombrem['nombre_materia']=$materia->mat;
        $nombrem['nombre_grupo']=$materia->grupo;
         $nombrem['id_hrs']=$materia->id_hrs_profesor;
         $nombrem['idcarrera']=$materia->id_carrera;

        array_push($nombre_materias,$nombrem);    
    }
    $nombre['materias']=$nombre_materias;
    array_push($datos_carreras, $nombre);


}



$rubros=DB::select('select eva_criterio.nombre_criterio rubros from eva_criterio');

//dd($rubros);
//dd($arreglofinal);

$finall="nada";
//$rubros=json_encode($rubros);

$grafica_condicion=$nombre_carrera->nombre."  ".$n_materias." ".$n_grupo;
//dd($grafica_condicion);



/////////////////////////////////////////////////////evaluacion de cada pregunta


            $preguntas=DB::select('select eva_pregunta.no_pregunta, eva_pregunta.descripcion,eva_pregunta.id_criterio,eva_pregunta.descripcion observacion from eva_pregunta');


            $ciclopreguntas=count($preguntas);


            for ($i=0; $i <48 ; $i++) 
            { 

              $ii=$i+1;
               // dd($id_profesor);
                $suma_pregunta=DB::selectOne('select SUM(p'.$ii.'.valor) suma FROM p'.$ii.', eva_alumno_materias,gnral_horas_profesores WHERE gnral_horas_profesores.id_hrs_profesor='.$id_profesor.' 
                                              AND p'.$ii.'.id_alumno_materia=eva_alumno_materias.id_alumno_materia 
                                              AND eva_alumno_materias.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');//obtiene el valor de la primera prgunta
                  // dd($suma_pregunta);
                $numero_de_alumnos_eva=DB::selectOne('select COUNT(eva_alumno_materias.id_hrs_profesor)alumnos 
                                                      from eva_alumno_materias 
                                                      where eva_alumno_materias.id_hrs_profesor='.$id_profesor.'');
            // dd($numero_de_alumnos_eva->alumnos);
             if($numero_de_alumnos_eva->alumnos==0)
             {
                  $numero_de_alumnos_eva->alumnos=1;
             }
                $total=$suma_pregunta->suma/$numero_de_alumnos_eva->alumnos;
              //  dd($total);
                $total=(round($total*1000)/1000);

                $preguntas[$i]->id_criterio=$total;
                if($total>=0 && $total<3)
                {
                   $ii=$i+1;
                  $observacioncad=DB::selectOne('select eva_pregunta.recomendaciones from eva_pregunta where eva_pregunta.no_pregunta='.$ii.'');
               
                  $preguntas[$i]->observacion=$observacioncad->recomendaciones;
                 // $preguntas[$i]->observacion="se le exorta a dar cumplimiento con los requerimientos minimos necesarios";
                }
                else
                {
                  $ii=$i+1;
                  $observacioncad=DB::selectOne('select eva_pregunta.felicitaciones from eva_pregunta where eva_pregunta.no_pregunta='.$ii.'');
               
                  $preguntas[$i]->observacion=$observacioncad->felicitaciones;
                  //$preguntas[$i]->observacion="Felicidades";
                }
                
            }

//dd($arreglofinal);
//dd($arreglofinal);

//dd($arreglofinal);
for ($i=0; $i <count($rubros) ; $i++) 
{ 
    $promedios[$i]=0;
}
for ($i=1; $i <(count($rubros)+1) ; $i++) 
{ 
  
    $promedios[$i-1]=(($promedios[$i-1]+$arreglofinal[$i]));
}

///////////////ordena prefuntas por el criterio 

$criterios=DB::select('select *from eva_criterio');
////////////////////////////////////////////////////llenar el arreglo con la calificacion del criterio

$cicloscri=count($criterios);
for ($i=0; $i <$cicloscri ; $i++) 
{ 

  $criterios[$i]->color=(round($promedios[$i]*1000)/1000);
}


///////////////////////////////////////////////////

$datos_preguntas=array(
    );
foreach ($criterios as $cri) 
{
     $nombrep['nombre_criterio']=$cri->nombre_criterio;


     $nombrep['calificacion']=$cri->color;

     if($cri->color>=0 && $cri->color<=1)
     {
          $observacioncri='No suficiente';
     }
     if($cri->color>=1.1 && $cri->color<=2)
     {
          $observacioncri='Suficiente';
     }
     if($cri->color>=2.1 && $cri->color<=3)
     {
          $observacioncri='Bien';
     }
        if($cri->color>=3.1 && $cri->color<=4)
     {
          $observacioncri='Muy Bien';
     }
     if($cri->color>=4.1 && $cri->color<=5)
     {
          $observacioncri='Excelente';
     }
     $nombrep['observacioncri']=$observacioncri;
     $cantidad=DB::selectOne('select count(id_criterio)pregunta 
                                                        from eva_pregunta 
                                                        where id_criterio='.$cri->id_criterio.'');
    
     $nombrep['cantidad']=$cantidad->pregunta+1;///////////////////calculando el numero de preguntas por criterio

     $preguntascri=DB::select('select eva_pregunta.descripcion, eva_pregunta.no_pregunta  FROM eva_criterio,eva_pregunta WHERE eva_criterio.id_criterio=eva_pregunta.id_criterio and 
      eva_criterio.id_criterio='.$cri->id_criterio.'');

$arrpreguntas=array(
    );
     foreach ($preguntascri as $precri)
    {
//dd($preguntas);
        $nombremp['pregunta']=$precri->descripcion;
        $buscarp=($precri->no_pregunta-1);
        $nombremp['calificacion']=$preguntas[$buscarp]->id_criterio;
        $nombremp['observacion']=$preguntas[$buscarp]->observacion;

        array_push($arrpreguntas,$nombremp);    
      //  dd($arrpreguntas);
    }
    
     $nombrep['preguntas']=$arrpreguntas;
     array_push($datos_preguntas, $nombrep);
      
}







       return view('evaluacion_docente.Admin.reportes',compact('solo_id_profesor','arreglofinal','rubros','n_materias','n_grupo','grafica_condicion','preguntas'))->with(['grafica2'=>true,'carreras'=>$datos_carreras,$finall,'preguntas2'=>$datos_preguntas]);




        


    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////POR CARRERA



 public function suma_evaluacion_por_carrera($id_profesor)


    {
             $periodo=Session::get('periodo_actual');

          $cadena="[";
            $datos=(explode(',',$id_profesor));
        //    dd($datos);
            $con_carrera=$datos[0];/////para consultar con id_hrs_pro
            $solo_id_profesor=$datos[1];



          $nombre_de_carrea=DB::selectOne('select  gnral_carreras.nombre 
                                            from gnral_carreras 
                                            where gnral_carreras.id_carrera='.$con_carrera.'');




            $arreglofinal=[];////////////////////////////////////////////////////////////////////////////////////////////

    $id_materias=DB::select('select gnral_horas_profesores.id_hrs_profesor,gnral_materias.nombre mat, gnral_carreras.nombre,
        CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre from gnral_materias,gnral_materias_perfiles,
        gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres where gnral_periodos.id_periodo='.$periodo.' and 
        gnral_carreras.id_carrera='.$con_carrera.' and gnral_horarios.id_personal='.$solo_id_profesor.' and 
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera and 
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
        and gnral_horarios.id_personal=gnral_personales.id_personal and gnral_materias.id_semestre=gnral_semestres.id_semestre');

$numero_de_materias_por_carrera=count($id_materias);
//dd($numero_de_materias_por_carrera);
 //dd($id_materias);

$calificaciones_por_materia=[];
$finall=[];

for ($m=0; $m <$numero_de_materias_por_carrera ; $m++)

 {
        
        $id_profesor=($id_materias[$m]->id_hrs_profesor);
    //    dd($id_profesor);







          $cadena.="{name:'".($id_materias[$m]->mat)."',";
          
           
            $entre=[];
            $entre[0]=0;

            $consulta=DB::select('select eva_pregunta.id_criterio from eva_pregunta');//a2

            $crit=DB::select('select eva_criterio.id_criterio from eva_criterio');
            $criterios=DB::selectOne('select count(id_criterio) numero from eva_criterio ');
            $numero_de_alumnos=DB::selectOne('select COUNT(eva_alumno_materias.id_hrs_profesor)alumnos from eva_alumno_materias where eva_alumno_materias.id_hrs_profesor='.$id_profesor.'');
            $numero_de_alumnos=($numero_de_alumnos->alumnos);
           // dd($numero_de_alumnos);
 
            $criterios=($criterios->numero);
            $ciclodiv=$criterios+1;

          //dd($crit);
            $valores=[];

            for ($i=0; $i <$criterios ; $i++) 
           { 

               
                $numero_de_preguntas[$i]=DB::selectOne('select count(id_criterio)pregunta from eva_pregunta where id_criterio='.$crit[$i]->id_criterio.'');
                $entre[]=($numero_de_preguntas[$i]->pregunta);
            }

           
            for ($i=0; $i <48 ; $i++) 
            { 

               $ii=$i+1;

                        $valor=DB::selectOne('select SUM(p'.$ii.'.valor) suma FROM p'.$ii.', eva_alumno_materias,gnral_horas_profesores WHERE gnral_horas_profesores.id_hrs_profesor='.$id_profesor.' AND p'.$ii.'.id_alumno_materia=eva_alumno_materias.id_alumno_materia AND eva_alumno_materias.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');//obtiene el valor de la primera prgunta
                        $p[$i]=($valor->suma);
                         if($numero_de_alumnos==0)
                        {
                            $p2[$i]=0;
                        }
                        else
                        {
                            $p2[$i]=($valor->suma/$numero_de_alumnos);
                            $p2[$i]=(round($p2[$i]*1000)/1000);
                        }

            }
$solo_preguntas[$m]=$p2;//////lleva el promedio de la calificacion de cada materia por pregunta

//dd($p);

                $suma=0;
//$con=0;

     for ($i=1; $i <$criterios+1; $i++) 
            { 
                //i==1
                 for ($j=0; $j<48 ; $j++) 
                { 
                    //si consulta en su posicion 0=1
                    if($consulta[($j)]->id_criterio==$i)
                    {
                          
                            $suma=$suma+$p[$j];

                    }
                }
            // dd($suma);
                $arreglofinal[$i]=$suma;
                $suma=0;
                
            }

         //   dd($arreglofinal);


            $cadena.="data:[";
            ////////////////////dividir entre numero de alumnos que evaluaron///////////

             for ($i=1; $i <$ciclodiv ; $i++) 
            {

                if($numero_de_alumnos==0)
                {
                  $arreglofinal[$i]=0;
                }
                else
                {
                  $arreglofinal[$i]=($arreglofinal[$i]/$numero_de_alumnos);

                }
                

            }


/////////////////dividir el total entre numero de criterios/////

   
            
            for ($i=1; $i <$ciclodiv ; $i++) 
            {

                if($arreglofinal[$i]==0)
                {

                  $nu=0;
                 
                }
                else
                {
                  //dd($arreglofinal[$i]/6);

                   $arreglofinal[]=($arreglofinal[$i]/$entre[$i]);
                   $finall[]=($arreglofinal[$i]/$entre[$i]);

                  $nu=($arreglofinal[$i]/$entre[$i]);
                  $nu=(round($nu*1000)/1000);
                }
                

                $cadena.="$nu,";
             
            }
           
             $cadena.="]},";

          
//$finall['name']=$id_materias[$m]->mat;

}
  
             $cadena.="]";



            /////////////////////////////////////////////////////////consultar para recargar pagina////////////////
// dd($cadena);
//$finall=(json_encode($finall));
//$finall=(json_encode($finall,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
 $carreras=DB::select('select Distinct(gnral_carreras.nombre) carrera,gnral_carreras.id_carrera from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres where gnral_periodos.id_periodo='.$periodo.' and gnral_horarios.id_personal='.$solo_id_profesor.' and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera and gnral_materias_perfiles.id_materia=gnral_materias.id_materia and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil and gnral_horarios.id_personal=gnral_personales.id_personal and gnral_materias.id_semestre=gnral_semestres.id_semestre');
   

$datos_carreras=array(
    );

foreach ($carreras as $carrera)
{

    $nombre['nombre_carrera']=$carrera->carrera;
     $nombre['id_carrera']=$carrera->id_carrera;

     $materias=DB::select('select gnral_horas_profesores.id_hrs_profesor,gnral_materias.nombre mat, gnral_carreras.nombre,gnral_carreras.id_carrera,
        CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre from gnral_materias,gnral_materias_perfiles,
        gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres where gnral_periodos.id_periodo='.$periodo.' and 
        gnral_carreras.id_carrera='.$carrera->id_carrera.' and gnral_horarios.id_personal='.$solo_id_profesor.' and 
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera and 
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
        and gnral_horarios.id_personal=gnral_personales.id_personal and gnral_materias.id_semestre=gnral_semestres.id_semestre');
      
    $nombre_materias=array();
    foreach ($materias as $materia)
    {
        $nombrem['nombre_materia']=$materia->mat;
        $nombrem['nombre_grupo']=$materia->grupo;
         $nombrem['id_hrs']=$materia->id_hrs_profesor;
         $nombrem['idcarrera']=$materia->id_carrera;

        array_push($nombre_materias,$nombrem);    
    }
    $nombre['materias']=$nombre_materias;
    array_push($datos_carreras, $nombre);


}



$rubros=DB::select('select eva_criterio.nombre_criterio rubros from eva_criterio');

//dd($rubros);
//dd($datos_carreras);
$grafica_condicion=$nombre_de_carrea->nombre;

///////////////////////////////////////////////////////////valor por cada pregunta/////////////////////////////////////////////////////////////

$preguntas=DB::select('select eva_pregunta.no_pregunta, eva_pregunta.descripcion,eva_pregunta.id_criterio,eva_pregunta.descripcion observacion from eva_pregunta');
//dd($solo_preguntas);
$sum=0;
for ($i=0; $i <count($preguntas) ; $i++) { 


     for ($j=0; $j <count($solo_preguntas) ; $j++) 
     { 
          
          $sum=$sum+$solo_preguntas[$j][$i];
         
     }
     $sum=$sum/count($solo_preguntas);
     $sum=(round($sum*1000)/1000);
     $preguntas[$i]->id_criterio=$sum;
    if($sum>=0 && $sum<3)
                {
                   $ii=$i+1;
                  $observacioncad=DB::selectOne('select eva_pregunta.recomendaciones from eva_pregunta where eva_pregunta.no_pregunta='.$ii.'');
               
                  $preguntas[$i]->observacion=$observacioncad->recomendaciones;
                 // $preguntas[$i]->observacion="se le exorta a dar cumplimiento con los requerimientos minimos necesarios";
                }
                else
                {
                  $ii=$i+1;
                  $observacioncad=DB::selectOne('select eva_pregunta.felicitaciones from eva_pregunta where eva_pregunta.no_pregunta='.$ii.'');
               
                  $preguntas[$i]->observacion=$observacioncad->felicitaciones;
                 // $preguntas[$i]->observacion="Felicidades";
                }
                $sum=0;
}

//
$condi=count($finall);
if($condi==0)
{
  
  for ($i=0; $i <count($rubros) ; $i++) 
{ 
    $finall[$i]=0;
}
}

for ($i=0; $i <count($rubros) ; $i++) 
{ 
    $promedios[$i]=0;
}
//dd($promedios);
for ($i=1; $i <(count($rubros)+1) ; $i++) 
{ 
    
    $promedios[$i-1]=(($promedios[$i-1]+$finall[$i-1])/$numero_de_materias_por_carrera);
}


//dd($promedios);
///////////////ordena prefuntas por el criterio 

$criterios=DB::select('select *from eva_criterio');
////////////////////////////////////////////////////llenar el arreglo con la calificacion del criterio

$cicloscri=count($criterios);
for ($i=0; $i <$cicloscri ; $i++) 
{ 

  $criterios[$i]->color=(round($promedios[$i]*1000)/1000);
}


///////////////////////////////////////////////////

$datos_preguntas=array(
    );
foreach ($criterios as $cri) 
{
     $nombrep['nombre_criterio']=$cri->nombre_criterio;


     $nombrep['calificacion']=$cri->color;
     if($cri->color>=0 && $cri->color<=1)
     {
          $observacioncri='No suficiente';
     }
     if($cri->color>=1.1 && $cri->color<=2)
     {
          $observacioncri='Suficiente';
     }
     if($cri->color>=2.1 && $cri->color<=3)
     {
          $observacioncri='Bien';
     }
        if($cri->color>=3.1 && $cri->color<=4)
     {
          $observacioncri='Muy Bien';
     }
     if($cri->color>=4.1 && $cri->color<=5)
     {
          $observacioncri='Excelente';
     }
     $nombrep['observacioncri']=$observacioncri;
     $cantidad=DB::selectOne('select count(id_criterio)pregunta 
                                                        from eva_pregunta 
                                                        where id_criterio='.$cri->id_criterio.'');
    
     $nombrep['cantidad']=$cantidad->pregunta+1;///////////////////calculando el numero de preguntas por criterio

     $preguntascri=DB::select('select eva_pregunta.descripcion, eva_pregunta.no_pregunta  FROM eva_criterio,eva_pregunta WHERE eva_criterio.id_criterio=eva_pregunta.id_criterio and 
      eva_criterio.id_criterio='.$cri->id_criterio.'');

$arrpreguntas=array(
    );
     foreach ($preguntascri as $precri)
    {
//dd($preguntas);
        $nombremp['pregunta']=$precri->descripcion;
        $buscarp=($precri->no_pregunta-1);
        $nombremp['calificacion']=$preguntas[$buscarp]->id_criterio;
        $nombremp['observacion']=$preguntas[$buscarp]->observacion;

        array_push($arrpreguntas,$nombremp);    
      //  dd($arrpreguntas);
    }
    
     $nombrep['preguntas']=$arrpreguntas;
     array_push($datos_preguntas, $nombrep);
      
}







//$rubros=json_encode($rubros);
return view('evaluacion_docente.Admin.reportes',compact('solo_id_profesor','rubros','finall','arreglofinal','cadena','grafica_condicion','preguntas'))->with(['grafica3'=>true,'carreras'=>$datos_carreras,'preguntas2'=>$datos_preguntas]);




        


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
