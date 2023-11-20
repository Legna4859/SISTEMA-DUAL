<?php

namespace App\Http\Controllers;

//use Anouar\Fpdf\Fpdf;

use Illuminate\Http\Request;


use Codedge\Fpdf\Fpdf\Fpdf as FPDF;

use Illuminate\Support\Facades\DB;
use Session;


class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {
        // $this->Image('img/gobi.png',132,10,29);
        $this->Image('img/secretaria.jpg',30,10,50,17);
        $this->Image('img/pais.PNG',90,10,30,17);
        $this->Image('img/letras.PNG',130,15,52,10);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-22);
        $this->SetFont('Arial','',7);
        $this->Image('img/empresa.PNG',150,250,40,17);
        //  $this->Image('img/logos/Mesquina.jpg',0,251,30);
        //   $this->Image('img/caliam.jpg',40,250,30);
        $this->Cell(50);
        $this->Cell(60,-2,utf8_decode('Km_30, Carretera Federal Monumento Valle de Bravo, San Antonio de la '),0,0,'C');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(60,-2,utf8_decode('Laguna, 51200, Valle de Bravo, Méx.'),0,0,'C');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(60,-2,utf8_decode('Tel(s).7262665200, 7262665077'),0,0,'C');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(60,-2,utf8_decode('Correo dir.general@tesvb.edu.mx'),0,0,'C');

        // $this->SetMargins(30,0,0);
        // $this->Ln(1);
        //  $this->SetFillColor(166,166,166);
        //  $this->Cell(180,10,utf8_decode('KM. 30 DE LA CARRETERA FEDERAL MONUMENTO-VALLE DE BRAVO, EJIDO DE SAN ANTONIO DE LA LAGUNA'),0,0,'C',TRUE);
    }

}

class pdf_reporte_grafica extends Controller
{
    public function index(Request $request)
    {
        //dd("hola");

        $direccion_img=$request->get('dir_imagen');
        // dd($direccion_img);
        $condi=$request->get('condi');
        $carre=$request->get('carrera');
        $id_profesor=$request->get('id_profesor');
        $id_hrs=$request->get('id_hrs');
        $id_usuario = Session::get('usuario_alumno');
        $periodo=Session::get('periodo_actual');

        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
//dd($request);

        $pdf->SetMargins(10, 25 , 0);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->Image('img/descarga.jpg',60,80,100,100);
        $pdf->SetDrawColor(164,164,164);
        $pdf->SetLineWidth(1.0);
        $pdf->Line(231, 10, 231, 32);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(80);
        $pdf->Cell(35,10,utf8_decode(''),0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(80);
        $pdf->Cell(35,5,utf8_decode('Evaluación por Docentes'),0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(80);
        $pdf->Cell(35,5,utf8_decode('Tipo de Evaluación: Por Alumnos'),0,0,'C');
        $pdf->Ln();
        $nombreperiodo=DB::selectOne('select gnral_periodos.periodo from gnral_periodos where gnral_periodos.id_periodo='.$periodo.'');
        $pdf->Cell(80);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(35,5,utf8_decode('Periodo:'. $nombreperiodo->periodo),0,0,'C');
        $pdf->Ln();
        $profesor=DB::selectOne('select gnral_personales.nombre from gnral_personales where gnral_personales.id_personal='.$id_profesor.'');
        $pdf->Cell(80);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(35,5,utf8_decode("Evaluación del Docente: ".$profesor->nombre.""),0,0,'C');

        //////////////////////////////////////////////////////////////////////datos////////////////////////////////////////////////////////////////////////////


        $periodo=Session::get('periodo_actual');


//dd($hrs);
////////////////////////////////////////////////carreras y materias del docente
        if ($condi==3)
        {
            $datos=(explode(',',$id_profesor));
            //dd($datos);
            $id_hrs=$datos[0];
            $id_profesor=$datos[4];/////para consultar con id_hrs_pro

//dd($id_profesor);
            $carreras=DB::select('select Distinct(gnral_carreras.nombre) carrera,gnral_carreras.id_carrera 
                      from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                      where gnral_periodos.id_periodo='.$periodo.'
                      and gnral_horarios.id_personal='.$id_profesor.' 
                      and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                      and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                      and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                      and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                      and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                      and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                      and gnral_horarios.id_personal=gnral_personales.id_personal 
                      and gnral_materias.id_semestre=gnral_semestres.id_semestre');

        }
        else
        {
            $carreras=DB::select('select Distinct(gnral_carreras.nombre) carrera,gnral_carreras.id_carrera 
                      from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                      where gnral_periodos.id_periodo='.$periodo.'
                      and gnral_horarios.id_personal='.$id_profesor.' 
                      and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                      and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                      and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                      and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                      and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                      and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                      and gnral_horarios.id_personal=gnral_personales.id_personal 
                      and gnral_materias.id_semestre=gnral_semestres.id_semestre');
        }
        $datos_carreras=array();
        foreach ($carreras as $carrera)
        {


            $nombre['nombre_carrera']=$carrera->carrera;
            $nombre['id_carrera']=$carrera->id_carrera;
            $materias=DB::select('select  DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.nombre mat, gnral_carreras.nombre,gnral_carreras.id_carrera,gnral_materias.clave,
        CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro 
        from eva_calificaciones_pre, gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
        where gnral_periodos.id_periodo='.$periodo.'
        and gnral_carreras.id_carrera='.$carrera->id_carrera.' 
        and gnral_horarios.id_personal='.$id_profesor.' 
        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
        and gnral_horarios.id_personal=gnral_personales.id_personal 
        and gnral_materias.id_semestre=gnral_semestres.id_semestre
        and eva_calificaciones_pre.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
        and eva_calificaciones_pre.calificacion_p>0
');
//dd($materias);

            $nombre_materias=array();
            foreach ($materias as $materia)
            {
                $nombrem['nombre_materia']=$materia->mat;
                $nombrem['nombre_materia']=$materia->clave;
                $nombrem['nombre_grupo']=$materia->grupo;
                $nombrem['id_hrs']=$materia->id_hrs_profesor;
                $nombrem['idcarrera']=$materia->id_carrera;
                array_push($nombre_materias,$nombrem);
            }
            $nombre['materias']=$nombre_materias;
            array_push($datos_carreras, $nombre);
        }

        //////////////////////////////////////////////////////////////////////////////////////
        if($condi==1);
        {
            $id_materias=DB::select('select DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.nombre mat, gnral_carreras.nombre,gnral_materias.clave,
                            CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                            from eva_calificaciones_pre, gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                            where gnral_periodos.id_periodo='.$periodo.'
                            and gnral_horarios.id_personal='.$id_profesor.' 
                            and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias.id_semestre=gnral_semestres.id_semestre
                            and eva_calificaciones_pre.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
        and eva_calificaciones_pre.calificacion_p>0
');
            $grafica_condicion="GRÁFICA GENERAL";
//dd($id_materias);
            $g_carrera=0;
            $g_id_profesor=$id_profesor;
            $g_id_hrs=0;


        }
        if ($condi==2)
        {
            // dd($carre);
            $id_materias=DB::select('select DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.nombre mat, gnral_carreras.nombre,gnral_materias.clave,
                            CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                            from eva_calificaciones_pre, gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                            where gnral_periodos.id_periodo='.$periodo.'
                            and gnral_horarios.id_personal='.$id_profesor.' 
                             and gnral_carreras.id_carrera='.$carre.'
                            and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias.id_semestre=gnral_semestres.id_semestre
                            and eva_calificaciones_pre.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
        and eva_calificaciones_pre.calificacion_p>0');


            $nombre_carrera=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where gnral_carreras.id_carrera='.$carre.'');

            $grafica_condicion=$nombre_carrera->nombre;
            $g_carrera=$carre;
            $g_id_profesor=$id_profesor;
            $g_id_hrs=0;
        }

        if ($condi==3)
        {
            $id_materias=DB::select('select DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.nombre mat, gnral_carreras.nombre,gnral_materias.clave,
                            CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                            from eva_calificaciones_pre, gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres 
                            where gnral_periodos.id_periodo='.$periodo.'
                            and gnral_horarios.id_personal='.$id_profesor.' 
                            and gnral_horas_profesores.id_hrs_profesor='.$id_hrs.'
                            and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias.id_semestre=gnral_semestres.id_semestre
                            and eva_calificaciones_pre.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
        and eva_calificaciones_pre.calificacion_p>0');

            if($id_materias==null)
            {
                $mensage="No es posible el cambio de periodo cuando se tiene seleccionada una materia en especifico";
                return view('evaluacion_docente.Admin.mencamper',compact('mensage'));

            }


            $grafica_condicion=$id_materias[0]->nombre." ";

            $g_carrera="0";
            $g_id_profesor=$id_profesor;
            $g_id_hrs=$id_hrs;
        }
//dd($id_materias);

//////////////////////////////VERIFICAR SI EXISTE REGISTRO DE EVALUACION EN EL PERIODO
        $suma=0;
        foreach ($id_materias as $id)
        {

            //$verifica=DB::selectOne('select * from eva_calificaciones_pre where eva_calificaciones_pre.id_hrs_profesor='.$id->id_hrs_profesor.'');
            $verifica=DB::selectOne('select id_periodo,no_pregunta,calificacion_p,id_hrs_profesor,id_criterio from eva_calificaciones_pre where eva_calificaciones_pre.id_hrs_profesor='.$id->id_hrs_profesor.' GROUP by id_periodo, no_pregunta,calificacion_p,id_hrs_profesor,id_criterio');
            if($verifica!=null)
            {
                $suma=$suma+1;
            }

        }

        if($suma==0)
        {

            //dd($id_materias);
            if($condi==2)
            {

                $mensage="No es posible el cambio de periodo cuando se tiene seleccionada una carrera en especifico";
                return view('evaluacion_docente.Admin.mencamper',compact('mensage','periodo'));
            }
            $mensage="No existe registro de Evaluación Docente en este periodo, porfavor seleccionar otro periodo";
            $url=$_SERVER["REQUEST_URI"];

            $periodo_funciona=$periodo;
            return view('evaluacion_docente.Admin.mencamper',compact('mensage','periodo_funciona'));
        }


        else
        {
            $profesor=$id_materias[0]->nombrepro;
            //dd($profesor);
        }










        $con_cri=DB::select("select*from eva_criterio");

        foreach ($con_cri as $cri)
        {
            $cantidad=DB::selectOne('select count(id_criterio) numero from eva_pregunta where eva_pregunta.id_criterio='.$cri->id_criterio.'');
            $arre_div_cri[]=$cantidad->numero;
        }
        $cadena="[";
        foreach ($id_materias as $mat)
        {
////////////////////////////////////calcular porcentaje de alumnos

            $total_alumnos_eva=DB::selectone('select count(gnral_horas_profesores.id_hrs_profesor) alumnos from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_periodos,eva_carga_academica,
                            eva_validacion_de_cargas
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo  
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                              and gnral_horas_profesores.id_hrs_profesor='.$mat->id_hrs_profesor.'
                            and gnral_periodos.id_periodo='.$periodo.'
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_validacion_de_cargas.estado_validacion=2');

            $cantidad_de_alumnos_v=DB::selectone('select COUNT(eva_alumno_materias.id_hrs_profesor)alumnos from eva_alumno_materias,gnral_alumnos,eva_validacion_de_cargas where eva_alumno_materias.id_hrs_profesor='.$mat->id_hrs_profesor.' and gnral_alumnos.cuenta=eva_alumno_materias.cuenta and gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno and eva_validacion_de_cargas.no_pregunta=49 and eva_validacion_de_cargas.id_periodo='.$periodo.'');

            $arreglodatos['materia']=$mat->mat." ".$mat->grupo;
            $arreglodatos['total']=$total_alumnos_eva->alumnos;
            $arreglodatos['total_si']=$cantidad_de_alumnos_v->alumnos;
            $arregloevaluacion['materia']=$mat->mat;
            $arregloevaluacion['clave']=$mat->clave;
            $arregloevaluacion['grupo']=$mat->grupo;
            $arregloevaluacion['total']=$total_alumnos_eva->alumnos;
            $arregloevaluacion['total_si']=$cantidad_de_alumnos_v->alumnos;
            if($total_alumnos_eva->alumnos==0)
            {
                $porcentaje=0;
            }
            else
            {
                $porcentaje=(($cantidad_de_alumnos_v->alumnos*100)/$total_alumnos_eva->alumnos);
                $porcentaje=round($porcentaje*100)/100;


            }
            $arreglodatos['porcentaje']="".$porcentaje."%";
            $materia_por[]=$arreglodatos;
            $mat_evaluacion[]=$arregloevaluacion;





/////modificacion harlock
            // $consulta=DB::select('select* from eva_calificaciones_pre where eva_calificaciones_pre.id_hrs_profesor='.$mat->id_hrs_profesor.' and
            //eva_calificaciones_pre.id_periodo='.$periodo.'');
            $consulta=DB::select('select id_periodo,no_pregunta,calificacion_p,id_hrs_profesor,id_criterio from eva_calificaciones_pre where eva_calificaciones_pre.id_hrs_profesor='.$mat->id_hrs_profesor.' and  eva_calificaciones_pre.id_periodo='.$periodo.' GROUP by id_periodo, no_pregunta,calificacion_p,id_hrs_profesor,id_criterio');


            //DESCRIBE LA CALIFICACION DE LAS PREGUNTAS
            foreach ($consulta as $cons)
            {
                if($cons->calificacion_p>=0 && $cons->calificacion_p<3)
                {
                    $observacioncad=DB::selectOne('select eva_pregunta.recomendaciones from eva_pregunta where eva_pregunta.no_pregunta='.$cons->no_pregunta.'');
                    $cons->id_hrs_profesor=$observacioncad->recomendaciones;
                }
                else
                {
                    $observacioncad=DB::selectOne('select eva_pregunta.felicitaciones from eva_pregunta where eva_pregunta.no_pregunta='.$cons->no_pregunta.'');
                    $cons->id_hrs_profesor=$observacioncad->felicitaciones;
                }
            }
//OBTENER EL PROMEDIO DE CADA CRITERIO
            $criterios=DB::selectOne('select count(id_criterio) numero from eva_criterio');
            $suma=0;
            $contador_cri=0;
            $criterios=($criterios->numero);
            for ($i=1; $i <$criterios+1; $i++)
            {
                //i==1
                for ($j=0; $j<count($consulta) ; $j++)
                {
                    //si consulta en su posicion 0=1
                    if($consulta[($j)]->id_criterio==$i)
                    {

                        $suma=$suma+$consulta[$j]->calificacion_p;
                        $contador_cri=$contador_cri+1;

                    }
                }

                $arreglofinal[$i]=$suma;
                $numerode_cri[$i]=$contador_cri;
                if($numerode_cri[$i]==0)
                {
                    $promedio_criterios[$i]=0;
                }
                else
                {
                    //dd($numerode_cri);
                    $promedio_criterios[$i]=$arreglofinal[$i]/$numerode_cri[$i];
                }
                $suma=0;
                $contador_cri=0;

            }
//dd($promedio_criterios);
///////////////////////////////////////////////////////////////////////////////////////////////

            $arreglo['nombre']=$mat->mat;
            $arreglo['calificacion_ps']=$consulta;
            $cadena.="{name:'".($mat->mat)." ".$mat->grupo."',";///////////////////////
            $cadena.="data:[";///////////////////////////////////////////////////
            // dd($arre_div_cri);
            for ($i=0; $i <count($arreglofinal) ; $i++)
            {
                $nu=$arreglofinal[$i+1]/$arre_div_cri[$i];
                $nu=round($nu*100)/100;
                $arreglofinal[$i+1]=$nu;
                //$nu=$arreglofinal[$i+1];
                $cadena.="$nu,";
            }
            $cadena.="]},";
            $arreglo['promedios']=$arreglofinal;
            $arreglo2[]=$arreglo;

        }
        $cadena.="]";
        ////////////////////////////////////////////////////////////////////
//dd($arreglo2);
////////todas las materias
////ciclo para saber cuantas preguntas seran
        //$arresumap= array();
//dd($consulta);
        for ($i=0; $i <count($consulta) ; $i++)
        {
            $arresumap[$i]=0;
        }
//ciclo para saber cuantos criterios seran
        for ($l=0; $l <$criterios ; $l++)
        {
            $arresumac[$l]=0;
        }
//dd($arresumac);
        foreach ($arreglo2 as $arre)
        {

            ///suma las calificaciones de las p por cada una de las materia
            for($j=0; $j<count($arre["calificacion_ps"]); $j++)
            {
                //dd($arresumap[$j]);
                $arresumap[$j]=$arresumap[$j]+$arre["calificacion_ps"][$j]->calificacion_p;
                //   dd(  $arresuma[$i]=$arre["calificacion_ps"][$i]->calificacion_p);
            }
            ///suma los promedios totales de los criterios por cada una de las materias
//dd($arre["promedios"]);
            for($c=0; $c<count($arre["promedios"]); $c++)
            {

                //dd($arre["promedios"][$c+1]);
                $arresumac[$c]=$arresumac[$c]+$arre["promedios"][$c+1];
                //   dd(  $arresuma[$i]=$arre["calificacion_ps"][$i]->calificacion_p);
            }
        }
///divide las p entre el numero total de materias
        for ($i=0; $i <count($arresumap) ; $i++)
        {
            $arresumap[$i]=$arresumap[$i]/count($arreglo2);
        }



        for ($i=0; $i <count($arresumac) ; $i++)
        {
            $arresumac[$i]=$arresumac[$i]/count($arreglo2);
        }

//dd($arresumac);
///////////////////////////////////////////////////////////valor por cada pregunta/////////////////////////////////////////////////////////////

        $preguntas=DB::select('select eva_pregunta.id_criterio cri,eva_pregunta.no_pregunta, eva_pregunta.descripcion,eva_pregunta.id_criterio,eva_pregunta.descripcion observacion from eva_pregunta');
//dd($preguntas);
        $sum=0;
        for ($i=0; $i <count($preguntas) ; $i++) {

            $preguntas[$i]->id_criterio=$arresumap[$i];
            if($preguntas[$i]->id_criterio>=0 && $preguntas[$i]->id_criterio<3)

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

            $criterios[$i]->color=(round($arresumac[$i]*100)/100);
        }
//dd($criterios);

///////////////////////////////////////////////////

        $datos_preguntas=array(
        );
        $observacioncri="";
//dd($criterios);
        foreach ($criterios as $cri)
        {    $nombrep['id_criterio']=$cri->id_criterio;
            $nombrep['nombre_criterio']=$cri->nombre_criterio;


            $nombrep['calificacion']=$cri->color;

            if($cri->color>=0 && $cri->color<=1)
            {
                $observacioncri='No suficiente';
            }
            if($cri->color>=1.01 && $cri->color<=2)
            {
                $observacioncri='Suficiente';
            }
            if($cri->color>=2.01 && $cri->color<=3)
            {
                $observacioncri='Bien';
            }
            if($cri->color>=3.01 && $cri->color<=4)
            {
                $observacioncri='Muy Bien';
            }
            if($cri->color>=4.01 && $cri->color<=5)
            {
                $observacioncri='Excelente';
            }
            //  dd($observacioncri);
            $nombrep['observacioncri']=$observacioncri;
            $cantidad=DB::selectOne('select count(id_criterio)pregunta 
                                                        from eva_pregunta 
                                                        where id_criterio='.$cri->id_criterio.'');

            $nombrep['cantidad']=$cantidad->pregunta+1;///////////////////calculando el numero de preguntas por criterio

            $preguntascri=DB::select('select eva_pregunta.descripcion, eva_pregunta.no_pregunta  FROM eva_criterio,eva_pregunta WHERE eva_criterio.id_criterio=eva_pregunta.id_criterio and 
      eva_criterio.id_criterio='.$cri->id_criterio.'');
//dd($preguntascri);
            $arrpreguntas=array(
            );
            foreach ($preguntascri as $precri)
            {
//dd($preguntas);
                $nombremp['pregunta']=$precri->descripcion;
                $buscarp=($precri->no_pregunta-1);
                $nombremp['calificacion']=$preguntas[$buscarp]->id_criterio;

                $nombremp['calificacion']=round($nombremp['calificacion']*100)/100;/////redondear pregunta
                $nombremp['observacion']=$preguntas[$buscarp]->observacion;

                array_push($arrpreguntas,$nombremp);
                //  dd($arrpreguntas);
            }

            $nombrep['preguntas']=$arrpreguntas;
            array_push($datos_preguntas, $nombrep);

        }
//dd($datos_preguntas);

////////////////////////////PROMEDIO POR MATERIA///
//dd(count($arreglo2[0]["promedios"]));
        for ($i=0; $i < count($arreglo2); $i++)
        {
            $suma=0;
            $div=count($arreglo2[$i]["promedios"]);
            $promediosmat=$arreglo2[$i]["promedios"];
            foreach ($promediosmat as $prom)
            {
                $suma=$suma+$prom;
            }

            $prommat[]=$suma/$div;
            $materia_por[$i]['total_si']=$suma/$div;
            $materia_por[$i]['total_si']=round($materia_por[$i]['total_si']*100)/100;
            $mat_evaluacion[$i]['promedio']=$materia_por[$i]['total_si'];

        }

//////////////////////////////////////////////////PROMEDIO TOTAL
        $promedio_t=0;
        $conta=0;
        foreach ($datos_preguntas as $da)
        {
            $promedio_t=$promedio_t+$datos_preguntas[$conta]["calificacion"];
            $conta++;
        }
        $promedio_t=$promedio_t/count($numerode_cri);
        $descrip_t="";

        $promedio_t=round($promedio_t*100)/100;
        if($promedio_t>=0 && $promedio_t<=1)
        {
            $descrip_t='No suficiente';
        }
        if($promedio_t>=1.01 && $promedio_t<=2)
        {
            $descrip_t='Suficiente';
        }
        if($promedio_t>=2.01 && $promedio_t<=3)
        {
            $descrip_t='Bien';
        }
        if($promedio_t>=3.01 && $promedio_t<=4)
        {
            $descrip_t='Muy Bien';
        }
        if($promedio_t>=4.01 && $promedio_t<=5)
        {
            $descrip_t='Excelente';
        }
//dd($promedio_t);
        $rubros=DB::select('select eva_criterio.nombre_criterio rubros from eva_criterio');
        //se elimino la variable finall,promedios
        //dd($datos_preguntas);
        //dd($cadenas_p);

//dd($mat_evaluacion);
        /////////////////////////////////////////////////////////////////////
        $pdf->Ln();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(15);
        $pdf->Cell(130,4,'Materias',1,0,'C');
        $pdf->Cell(40,4,'Alumnos',1,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(15);
        $pdf->Cell(15,4,'Clave',1,0,'C');
        $pdf->Cell(10,4,'Grupo',1,0,'C');
        $pdf->Cell(105,4,'Nombre Completo de la Materia',1,0,'C');
        $pdf->Cell(20,4,'Inscritos',1,0,'C');
        $pdf->Cell(20,4,'Evaluaron',1,0,'C');
        $pdf->Ln();
        $promedio_inscritos=array();
        $promedio_evaluar=array();
        foreach ($mat_evaluacion as $mat_evaluacion) {
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(15);
            $pdf->Cell(15,4,utf8_decode($mat_evaluacion['clave']),1,0,'C');
            $pdf->Cell(10,4,utf8_decode($mat_evaluacion['grupo']),1,0,'C');
            $pdf->Cell(105,4,utf8_decode($mat_evaluacion['materia']),1,0,'C');
            $pdf->Cell(20,4,utf8_decode($mat_evaluacion['total']),1,0,'C');
            $pdf->Cell(20,4,utf8_decode($mat_evaluacion['total_si']),1,0,'C');
            $pdf->Ln();
            $dat_semestres_inscritos=$mat_evaluacion['total'];
            array_push($promedio_inscritos,$dat_semestres_inscritos);
            $dat_semestres_evaluar=$mat_evaluacion['total_si'];
            array_push($promedio_evaluar,$dat_semestres_evaluar);
        }
        $sumado_inscritos=array_sum($promedio_inscritos);
        $sumado_evaluados=array_sum($promedio_evaluar);

        $pdf->Cell(15);
        $pdf->Cell(130,4,'TOTAL',1,0,'R');
        $pdf->Cell(20,4,$sumado_inscritos,1,0,'C');
        $pdf->Cell(20,4,$sumado_evaluados,1,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(15);
        $pdf->Cell(170,4,'Aspectos a Evaluar:',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(30);
        $pdf->Cell(90,4,'Aspectos Evaluados',1,0,'L');
        $pdf->Cell(15,4,'Puntuaje',1,0,'C');
        $pdf->Cell(40,4,utf8_decode('Calificación'),1,0,'C');
        $pdf->Ln();
        ///
        //dd($datos_preguntas);
        foreach($datos_preguntas as $datos_pregunta)
        {
            $pdf->SetFont('Arial','',7);

            if($datos_pregunta["id_criterio"]==0){

            }
            elseif($datos_pregunta["id_criterio"]==1){
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('A) '.$datos_pregunta['nombre_criterio']),1,0,'L');
            }

            elseif($datos_pregunta["id_criterio"]==2){
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('B) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }

            elseif($datos_pregunta["id_criterio"]==3)
            {
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('C) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }

            elseif($datos_pregunta["id_criterio"]==4)
            {
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('D) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }
            elseif($datos_pregunta["id_criterio"]==5)
            {
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('E) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }
            elseif($datos_pregunta["id_criterio"]==6)
            {
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('F) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }
            elseif($datos_pregunta["id_criterio"]==7)
            {
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('G) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }
            elseif($datos_pregunta["id_criterio"]==8)
            {
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('H) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }
            elseif($datos_pregunta["id_criterio"]==9)
            {
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('I) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }
            elseif($datos_pregunta["id_criterio"]==10)
            {
                $pdf->Cell(30);
                $pdf->Cell(90,4,utf8_decode('J) '.$datos_pregunta['nombre_criterio']),1,0,'L');

            }
            $pdf->Cell(15,4,utf8_decode($datos_pregunta['calificacion']),1,0,'C');

            if($datos_pregunta["calificacion"]>=0 && $datos_pregunta["calificacion"]<=3.24)
            {
                $pdf->Cell(40,4,utf8_decode('DESEMPEÑO INSUFICIENTE'),1,0,'C');
            }

            elseif($datos_pregunta["calificacion"]>=3.25 && $datos_pregunta["calificacion"]<=3.74)
            {
                $pdf->Cell(40,4,utf8_decode('SUFICIENTE'),1,0,'C');
            }
            elseif($datos_pregunta["calificacion"]>=3.75 && $datos_pregunta["calificacion"]<=4.24)
            {
                $pdf->Cell(40,4,utf8_decode('BUENO'),1,0,'C');
            }
            elseif($datos_pregunta["calificacion"]>=4.25 && $datos_pregunta["calificacion"]<=4.74)
            {
                $pdf->Cell(40,4,utf8_decode('NOTABLE'),1,0,'C');
            }
            elseif($datos_pregunta["calificacion"]>=4.75 && $datos_pregunta["calificacion"]<=5)
            {
                $pdf->Cell(40,4,utf8_decode('EXCELENTE'),1,0,'C');
            }



            $pdf->Ln();

        }
        ///
//dd($sumado);
        $pdf->Ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(80);
        $pdf->Image($direccion_img,35,170,150,70,'PNG');








        /////////////////////////////////////////////////////////

        $pdf->Output();
        exit();
    }
    public function create()
    {

    }
    public function store(Request $request)
    {

    }
    public function show($id)
    {

    }
    public function edit()
    {


    }
    public function update(Request $request, $id)
    {

    }
    public function destroy($id)
    {

    }


}
