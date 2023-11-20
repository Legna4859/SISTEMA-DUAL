<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use App\Extensiones\calcular_pdf;

use Session;

class PDF extends FPDF
    { 
        //CABECERA DE LA PAGINA
    /**
     *
     */
    function Header()
        {
            $this->Image('img/logos/ArmasBN.png',7,6,40);
            $this->Image('img/tes.png',203,6,27);
            $this->Image('img/logos/EdoMEXcolor.png',238,6,35);
            $this->Ln(1);
        }
        //PIE DE PAGINA 

    /**
     *
     */
    function Footer()
        {
            $fecha=date('d/m/Y');
            $this->SetY(-20);
            $this->SetFont('Arial','',5.5);
         //   $this->Image('img/sgc.PNG',40,183,20);
            $this->Image('img/pie/logos_iso.jpg',30,180,60);
         //   $this->Image('img/sga.PNG',65,183,20);
            $this->Cell(100);
            $this->Cell(167,-2,utf8_decode('FO-TESVB-36  V.0  23-03-2018'),0,0,'R');
            $this->Ln(3);
            $this->Cell(100);
            $this->Cell(167,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
            $this->Ln(3);
            $this->Cell(100);
            $this->Cell(167,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
            $this->Cell(300);
            $this->SetMargins(0,0,0);
            $this->Ln(1);
            $this->SetXY(30,204);
            $this->SetFillColor(120,120,120);
            $this->Cell(20,10,'',0,0,'',TRUE);
            $this->SetTextColor(255,255,255);
            $this->Cell(297,10,utf8_decode('KM. 30 DE LA CARRETERA FEDERAL MONUMENTO-VALLE DE BRAVO, EJIDO DE SAN ANTONIO DE LA LAGUNA'),0,0,'L',TRUE);
            $this->Ln(3);
            $this->Cell(50);
            $this->Cell(160,10,utf8_decode('VALLE DE BRAVO ESTADO DE MÉXICO C.P.51200     TEL: 01 726 2 62 20 97'),0,0,'L');
            $this->Image('img/logos/Mesquina.jpg',0,190,30);

        }
       
    }
class PdfHorariosController extends Controller
{
        public function index($id_profesor)
        {
            //$id_carrera=Session::get('carrera');

            $id_periodo=Session::get('periodotrabaja');
            
            $abre=DB::selectOne('select abreviaciones.titulo as abre from 
            gnral_personales,abreviaciones,abreviaciones_prof 
            where gnral_personales.id_personal='.$id_profesor.' AND
            abreviaciones_prof.id_personal=gnral_personales.id_personal AND
            abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');

            if($abre==null)
            {
                $profesor=DB::selectOne('select gnral_personales.nombre titulo from 
                gnral_personales where gnral_personales.id_personal='.$id_profesor.'');
            }
            else
            {
                $profesor=DB::selectOne('select concat(abreviaciones.titulo," ",gnral_personales.nombre)titulo from 
                gnral_personales,abreviaciones,abreviaciones_prof 
                where gnral_personales.id_personal='.$id_profesor.' AND
                abreviaciones_prof.id_personal=gnral_personales.id_personal AND
                abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            }
            $profesor=($profesor->titulo);

            $periodo=DB::select('select gnral_periodos.periodo,gnral_periodos.fecha_inicio,
                gnral_periodos.fecha_termino from gnral_periodos where id_periodo='.$id_periodo.'');

$vista_clase=DB::statement('create or replace view clase as (select COUNT(gnral_carreras.id_carrera)num,
        gnral_carreras.nombre,gnral_carreras.id_carrera 
        FROM gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,hrs_rhps,gnral_materias,gnral_periodo_carreras,
        gnral_periodos,gnral_carreras WHERE 
        gnral_periodos.id_periodo='.$id_periodo.' AND 
        gnral_horarios.id_personal='.$id_profesor.' AND 
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND 
        gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND 
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND 
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND 
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
        gnral_materias_perfiles.id_materia_perfil=gnral_horas_profesores.id_materia_perfil AND 
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia group by gnral_carreras.id_carrera,nombre) '); 

        $vista_extra=DB::statement('create or replace view extra_clase as 
            (select COUNT(gnral_carreras.id_carrera) num,gnral_carreras.nombre carrera,gnral_carreras.id_carrera FROM 
                gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_periodos, 
                gnral_periodo_carreras,gnral_carreras WHERE gnral_periodos.id_periodo='.$id_periodo.' AND 
                gnral_horarios.id_personal='.$id_profesor.' AND 
                hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
                gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND 
                gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND 
                gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND 
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase 
                group by gnral_carreras.id_carrera,nombre)');
        $ver_totales=DB::select('select clase.id_carrera,clase.nombre, (clase.num+extra_clase.num)sumaa 
            from clase JOIN extra_clase ON clase.id_carrera=extra_clase.id_carrera 
            UNION select clase.id_carrera,clase.nombre, (clase.num+0)sumaa from 
            clase LEFT OUTER JOIN extra_clase ON clase.id_carrera=extra_clase.id_carrera WHERE 
            clase.id_carrera not in (select extra_clase.id_carrera from extra_clase) 
            UNION select extra_clase.id_carrera,extra_clase.carrera, (extra_clase.num+0)sumaa from 
            extra_clase LEFT OUTER JOIN clase ON clase.id_carrera=extra_clase.id_carrera WHERE 
            extra_clase.id_carrera not in (select clase.id_carrera from clase) ');
    $mayor=0;
    $cuenta=count($ver_totales);
    //dd($ver_totales);

            /*
    foreach($ver_totales as $compara)
    {
        if($compara->sumaa>$mayor)
                $mayor=$compara->sumaa;
        else
            $mayor=$mayor;
    }

    for ($i=0; $i <$cuenta ; $i++)
    {
        if($ver_totales[$i]->sumaa==$mayor)
            $id_carrera=$ver_totales[$i]->id_carrera;
    }
            */
            //dd($ver_totales);

            $jefes=[];
            foreach ($ver_totales as $carrera) {

                $abrej = DB::selectOne('select abreviaciones.titulo from 
                gnral_personales,gnral_jefes_periodos,abreviaciones,abreviaciones_prof
                where gnral_jefes_periodos.id_carrera=' . $carrera->id_carrera . ' AND
                gnral_jefes_periodos.id_personal=gnral_personales.id_personal AND
                abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion AND
                abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_jefes_periodos.id_periodo='.$id_periodo.'');

if($abrej==null)
{
    $jefe=DB::selectOne('select DISTINCT (gnral_personales.nombre) abre from 
                gnral_personales,gnral_jefes_periodos
                where gnral_jefes_periodos.id_carrera='.$id_carrera.' AND
                gnral_jefes_periodos.id_personal=gnral_personales.id_personal
		ORDER BY gnral_personales.id_personal DESC LIMIT 1');
}
else
{
$jefe=DB::selectOne('select DISTINCT (concat(abreviaciones.titulo," ",gnral_personales.nombre))abre from  gnral_personales,gnral_jefes_periodos,abreviaciones,abreviaciones_prof
                where gnral_jefes_periodos.id_carrera=' . $carrera->id_carrera . ' AND
                gnral_jefes_periodos.id_personal=gnral_personales.id_personal AND
                abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion AND
                abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_jefes_periodos.id_periodo='.$id_periodo.'');
                }



                $jefatura="";
                if($carrera->id_carrera==9 || $carrera->id_carrera==11)
                    $jefatura.=" JEFE DE ".$carrera->nombre;
                else
                    $jefatura.=" JEFATURA DE LA DIVISIÓN DE ".$carrera->nombre;

                $jefes[]=['carrera'=>$carrera->nombre, 'jefe'=>$jefe->abre,"jefatura"=>$jefatura];
            }

            //dd($jefes);
            //$jefe=($jefe->abre); //tiene titulo mas el nombre completo

            //$carrera=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$id_carrera.'');
            //$carrera=($carrera->nombre);

           // dd($jefe);



 $horarios_doc = DB::select('
SELECT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,
hrs_rhps.id_semana,
gnral_materias.id_materia idmat,gnral_materias.nombre materia, gnral_reticulas.clave, 
CONCAT(gnral_materias.id_semestre,"0",
    gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
gnral_carreras.color,"0" estado,gnral_materias.especial,hrs_semanas.dia dia_materia,hrs_semanas.hora,gnral_carreras.siglas
FROM
hrs_semanas,gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_aulas,hrs_rhps,gnral_horarios,
gnral_materias_perfiles,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_cargo=gnral_cargos.id_cargo AND
hrs_rhps.id_semana=hrs_semanas.id_semana AND
hrs_aulas.id_aula=hrs_rhps.id_aula AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_materias_perfiles.id_materia_perfil=gnral_horas_profesores.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula
UNION
SELECT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
gnral_materias.id_materia idmat,gnral_materias.nombre materia, gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",
    gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"0" estado,gnral_materias.especial,
hrs_semanas.dia dia_materia,hrs_semanas.hora,gnral_carreras.siglas
FROM
hrs_semanas,gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_cargo=gnral_cargos.id_cargo AND
hrs_rhps.id_semana=hrs_semanas.id_semana AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_materias_perfiles.id_materia_perfil=gnral_horas_profesores.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
hrs_rhps.id_aula=0
UNION
SELECT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad,
hrs_extra_clase.grupo,
gnral_cargos.abre,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"0" estado,
"0" especial,hrs_semanas.dia dia_materia,hrs_semanas.hora,gnral_carreras.siglas
FROM
hrs_actividades_extras,gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,hrs_semanas,gnral_cargos,gnral_periodos,
gnral_periodo_carreras,gnral_carreras
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
gnral_cargos.id_cargo=hrs_horario_extra_clase.id_cargo AND
hrs_horario_extra_clase.id_aula=0
UNION
SELECT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad, 
hrs_extra_clase.grupo,gnral_cargos.abre,
hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"0" estado,
"0" especial,hrs_semanas.dia dia_materia,hrs_semanas.hora,gnral_carreras.siglas
FROM
hrs_actividades_extras, gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,hrs_semanas,gnral_cargos,
hrs_aulas,gnral_periodos,
gnral_periodo_carreras,gnral_carreras
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
gnral_cargos.id_cargo=hrs_horario_extra_clase.id_cargo AND
hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula');

//dd($horarios_doc);
        $tam=count($ver_totales);
        $ssuma=0;
        for ($i=0; $i < $tam; $i++) 
        { 
            $ssuma+=$ver_totales[$i]->sumaa;
        }
        $semanas=DB::select('select hrs_semanas.id_semana,hrs_semanas.dia,hrs_semanas.hora,
            "0" dia2, "0" longitud, hrs_semanas.dia di,"0" suma from hrs_semanas ORDER by hora,id_semana');
        $horas=DB::select('select DISTINCT hora from hrs_semanas ');
        $diass = DB::select('select DISTINCT dia FROM hrs_semanas');
        $horas=DB::select('select DISTINCT hrs_semanas.hora from hrs_semanas ORDER BY hora,id_semana ');

            $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
            $pdf_aux=new PDF($orientation='L',$unit='mm',$format='Letter');
            $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
            $pdf->SetMargins(5, 20 , 0);
            $pdf->SetAutoPageBreak(true,25);
            $pdf->AddPage();
            $pdf->SetDrawColor(164,164,164);
            $pdf->SetLineWidth(0.8);
            $pdf->Line(234, 5, 234, 15);
            $pdf->SetFont('Arial','','6.7');
            $pdf->Cell(80);
            $pdf->Cell(100,4,utf8_decode($etiqueta->descripcion),0,0,'C');
            $pdf->Ln(3);
            $pdf->Cell(85);
            $pdf->SetFont('Arial','B','5');
            $pdf->Cell(100,3,utf8_decode('HORARIOS DE CLASES'),0,0,'C');
            $pdf->Ln(3);
            $pdf->SetFont('Arial','','5');
            $pdf->Cell(170,3,utf8_decode('PROFESOR:'.$profesor.''),0,0,'L');
            $pdf->Ln(3);
            //$pdf->Cell(170,3,utf8_decode('CARRERA:'.$carrera.''),0,0,'L');
            foreach($periodo as $pe)
            {
                $pdf->Cell(270,3,utf8_decode('SEMESTRE:'.$pe->periodo.''),0,0,'R');
                $pdf->Ln(3);
                $pdf->Cell(170);
                $pdf->Cell(100,3,utf8_decode('VIGENCIA DEL '.(isset($_GET["init_periodo"])?$_GET["init_periodo"]:$pe->fecha_inicio).' AL '.$pe->fecha_termino.''),0,0,'R');
                $pdf->Ln(3);
            }
            $pdf->SetDrawColor(49,49,49);
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont('Arial','','6');
       // echo $pdf->GetY();
            $pdf->Cell(15,5,utf8_decode('Hora/Día'),1,0,'C');

            foreach($diass as $dia)
            {
                $pdf->Cell(40.5,5,utf8_decode($dia->dia),1,0,'C');
            }
            $pdf->Cell(12,5,utf8_decode('Totales'),1,0,'C');
            $pdf->Ln();
             $pdf->SetFont('Arial','','5');
     //   echo $pdf->GetY();


$contador=0;
$totalesf=0;
$c_otro=0;
//dd($semanas);
$matriz=array();
$pcontador=count($horarios_doc);
$contador=count($semanas);
//dd($horarios_doc);
for ($j=0; $j < $pcontador;) { 
    
    $com_hora=$horarios_doc[$j]->dia_materia."".$horarios_doc[$j]->hora;
    if($horarios_doc[$j]->grupo==0)
        $horarios_doc[$j]->materia.=" AULA:".$horarios_doc[$j]->aula." ".$horarios_doc[$j]->siglas;
    else
        $horarios_doc[$j]->materia.=" AULA: ".$horarios_doc[$j]->aula." GRUPO: ".$horarios_doc[$j]->grupo." ".$horarios_doc[$j]->siglas;

    $materia=$horarios_doc[$j]->materia;
    $tam=mb_strlen($materia,"UTF-8");

   for ($i=0; $i <$contador;) 
   { 
        $com_sema=$semanas[$i]->dia."".$semanas[$i]->hora;
        if($com_hora==$com_sema)
        {
            $semanas[$i]->dia=$materia;
            $semanas[$i]->longitud=$tam;
            $semanas[$i]->suma=$semanas[$i]->suma+1;
            $j++;
            $i=0;
        }
        else
        {  
            $i++;
        }
   }    
  // dd($semanas);
   }
   foreach ($semanas as $sem) 
   {
       if($sem->dia=="sabado"||$sem->dia=="lunes"
        ||$sem->dia=="martes"||$sem->dia=="miercoles"||$sem->dia=="jueves"||$sem->dia=="viernes")
       {
        $sem->dia="";
       }
   }
   $cont=0;

   for ($i=0; $i <15;$i++) 
   { 
        $nombre=$horas[$i]->hora;
            $arre_fila['lunes']=$semanas[$cont]->dia;
            $arre_fila['martes']=$semanas[$cont+1]->dia;
            $arre_fila['miercoles']=$semanas[$cont+2]->dia;
            $arre_fila['jueves']=$semanas[$cont+3]->dia;
            $arre_fila['viernes']=$semanas[$cont+4]->dia;
            $arre_fila['sabado']=$semanas[$cont+5]->dia;

            $l1=$semanas[$cont]->longitud;
            $l2=$semanas[$cont+1]->longitud;
            $l3=$semanas[$cont+2]->longitud;
            $l4=$semanas[$cont+3]->longitud;
            $l5=$semanas[$cont+4]->longitud;
            $l6=$semanas[$cont+5]->longitud;

      $array = array($l1,$l2,$l3,$l4,$l5,$l6);
      //dd($array);
      $maximo=max($array);

      $suma=0;
      $posi="";
      $num_x=0;
    $cadena_max ="";

    for ($h=0; $h<count($array); $h++) 
        { 
           // $cadena_max.="*".$h."-";
            if($array[$h]!="0")
            {
                $suma=$suma+1;
            }
            if($array[$h]==$maximo)
            {  
                $cadena_max.=$semanas[($cont+$h)]->dia;
                $posi=$semanas[($cont+$h)]->di;
                $num_x=$h;

            }
        }

            $arre_fila['totales']=$suma;
            $arre_fila['maximo']=$maximo;
            $arre_fila['cadenamax']=$cadena_max;
            $arre_fila['posicion']=$posi;
            $arre_fila["posicionx"]=$num_x;
            $cont=$cont+6;
            $arre_fila2[$nombre]=$arre_fila;

       }

      // dd($semanas);
  
$pos=0;
$cont=0;

$pos1y = $pdf->GetY();

//dd($arre_fila2);
foreach($horas as $hora)
{
    $varhei=$pdf->GetMultiCellHeight(40.5,1.5,utf8_decode($arre_fila2[$hora->hora][$arre_fila2[$hora->hora]["posicion"]]),1,'C');
    $contx=20;
    $pdf->SetXY(5,$pos1y);
    $alt_max=$varhei==0?1.65:$varhei;
    $alt2=$varhei==0?1.65:$varhei*1.65;       
    $pdf->Cell(15,$alt2,utf8_decode($hora->hora),1,0,'C');
    $maximo=$arre_fila2[$hora->hora]["maximo"];
    foreach($diass as $dia)
    { 
            $max=$arre_fila2[$hora->hora]["maximo"];
            $cadena=$arre_fila2[$hora->hora][$dia->dia]." ";
            $i=$pdf->GetMultiCellHeight(40.5,2,utf8_decode($cadena),1,'C');
            $pdf->SetXY($contx,$pos1y);
            $varhei=$varhei>2.5?2.5:$varhei;
            if($maximo!=0&&$i!=2)
            $pdf->MultiCellEx(40.5,$varhei,utf8_decode($cadena),1,'C',$i,$alt_max);
            else
             $pdf->Cell(40.5,$alt2,utf8_decode("".$cadena),1,0,'C');
            $contx+=40.5;
    }
     $pdf->SetXY(263,$pos1y);
     if($maximo!=0&&$i!=2)
     $pdf->MultiCellEx(12,$varhei,utf8_decode($arre_fila2[$hora->hora]["totales"]),1,'C',2,$alt_max);
     else{
       $pdf->Cell(12,$alt2,$arre_fila2[$hora->hora]["totales"],1,0,'C');
       $pdf->Ln();
   }
  // if($hora->hora=="09:00-10:00")
     //   break;   
     $pos1y = $pdf->GetY();
}
//dd($pos1y);
     // $pdf->Cell(100,10,"hola");
            
    $pdf->Ln(3);//4
    $total=0;
    foreach($ver_totales as $totales)
    {
        $total=$total+$totales->sumaa;
        $pdf->SetX(104);
        $pos2y = $pdf->GetY();
        $pdf->MultiCell(60,4,utf8_decode($totales->nombre),1,'L');
        $pdf->SetXY(104+60,$pos2y);
        $pdf->MultiCell(20,4,utf8_decode($totales->sumaa),1,'C');
    }
    $pdf->SetXY(104,$pdf->GetY());
    $ty=$pdf->GetY();
    $pdf->MultiCell(60,4,utf8_decode("TOTALES"),1,'R');
    $pdf->SetXY(104+60,$ty);
    $pdf->MultiCell(20,4,utf8_decode($total),1,'C');
     $pdf->Ln();


if($pos1y<=149)
{


    $pdf->SetXY(5,$pos1y+24);
    $pdf->Cell(180,5,utf8_decode("AUTORIZÓ"),1,0,"C");
    $pdf->Ln();
    foreach ($jefes as $jefe){
        $pdf->Cell(80,10,utf8_decode($jefe["jefatura"]),1,"C");
        $pdf->Cell(50,10,utf8_decode($jefe["jefe"]),1,"C");
        $pdf->Cell(50,10,utf8_decode(""),1,"C");
        $pdf->Ln();
    }

    $pdf->SetXY(110,$pos1y-5);
    $pdf->Cell(250,20,utf8_decode("ACEPTO DE CONFORMIDAD"),0,0,'C');
    $pdf->Ln();
    $pdf->SetXY(190,$pdf->GetY());
    $pdf->Cell(90,5,utf8_decode($profesor),0,0,'C');

    $pdf->SetXY(100,$pdf->GetY()-5);
    $pdf->SetLineWidth(0.4);
    $pdf->Line(210, $pdf->GetY()+4, 260, $pdf->GetY()+4);
    //$pdf->Line(200,$pdf->GetY()+4 , 100, $pdf->GetY()+4);



}
else
{
    $pdf->SetXY(5,$pos1y+1);
    $pdf->Cell(180,5,utf8_decode("AUTORIZÓ"),1,0,"C");
    $pdf->Ln();
    foreach ($jefes as $jefe){
        $pdf->Cell(80,10,utf8_decode($jefe["jefatura"]),1,"C");
        $pdf->Cell(50,10,utf8_decode($jefe["jefe"]),1,"C");
        $pdf->Cell(50,10,utf8_decode(""),1,"C");
        $pdf->Ln();
    }


    $pdf->SetMargins(5, 20 , 0);
    $pdf->SetAutoPageBreak(true,25);
    $pdf->AddPage();

    $pdf->SetXY(110,$pdf->GetY());
    $pdf->SetLineWidth(0.4);

    $pdf->Line(115, 45, 145, 45);
    $pdf->Cell(50,20,utf8_decode("ACEPTO DE CONFORMIDAD"),0,0,'C');
    $pdf->Ln();
    $pdf->SetXY(90,$pdf->GetY());
    $pdf->Cell(90,5,utf8_decode($profesor),0,0,'C');
}

      $pdf->Output();
      exit();
}
        public function plantilla($id_cargo)
        {
            $id_carrera=Session::get('carrera');
            $id_periodo=Session::get('periodotrabaja');
            $periodo=DB::selectOne('select gnral_periodos.periodo from gnral_periodos where id_periodo='.$id_periodo.'');

            $carrera=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$id_carrera.'');

            $cargo=DB::selectOne('select cargo from gnral_cargos where id_cargo='.$id_cargo.'');

            $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
            $pdf_aux=new PDF($orientation='L',$unit='mm',$format='Letter');
            $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
            $pdf->SetMargins(5, 20 , 0);
            $pdf->SetAutoPageBreak(true,25);
            $pdf->AddPage();
            $pdf->SetDrawColor(164,164,164);
            $pdf->SetLineWidth(0.6);
            $pdf->Line(234, 4, 234, 24);
            $pdf->SetFont('Arial','','6.7');
            $pdf->Cell(80);
            $pdf->Cell(100,4,utf8_decode($etiqueta->descripcion),0,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(85);
            $pdf->SetFont('Arial','B','6');
            $pdf->Cell(100,3,utf8_decode('PLANTILLA DOCENTE'),0,0,'C');
            $pdf->Ln(3);
            $pdf->SetFont('Arial','','6');
            $pdf->Cell(170,3,utf8_decode(''.$cargo->cargo),0,0,'L');
            $pdf->Ln(3);
            $pdf->Cell(170,3,utf8_decode('CARRERA:'.$carrera->nombre.''),0,0,'L');
            $pdf->Cell(100,3,utf8_decode('PERIODO:'.$periodo->periodo.''),0,0,'R');
            $pdf->Ln(3);

//////////////////////////////////
        $fecha_nuevo = DB::selectOne('select gp.fecha_inicio from gnral_periodos gp WHERE gp.id_periodo='.$id_periodo.'');
        $fecha_nuevo=($fecha_nuevo->fecha_inicio);

        $docentes= DB::select('select DISTINCT h.id_personal, h.id_horario_profesor, p.nombre, h.aprobado, 
            p.rfc, p.clave,p.fch_ingreso_tesvb,gf.descripcion,fch_recontratacion
FROM gnral_horarios h, gnral_horas_profesores hp, hrs_rhps rp, gnral_personales p,gnral_perfiles gf,
gnral_periodo_carreras gpc,gnral_periodos gp,
gnral_carreras gc
WHERE rp.id_hrs_profesor = hp.id_hrs_profesor
AND hp.id_horario_profesor = h.id_horario_profesor
and p.id_personal=h.id_personal
AND gp.id_periodo='.$id_periodo.'
AND gc.id_carrera='.$id_carrera.'
AND rp.id_cargo ='.$id_cargo.'
AND gf.id_perfil=p.id_perfil
AND h.id_periodo_carrera=gpc.id_periodo_carrera
AND gpc.id_carrera=gc.id_carrera AND
gpc.id_periodo=gp.id_periodo
UNION
SELECT DISTINCT h.id_personal, h.id_horario_profesor, p.nombre, h.aprobado,
p.rfc, p.clave,p.fch_ingreso_tesvb,gf.descripcion,fch_recontratacion
FROM gnral_horarios h, hrs_extra_clase ec, hrs_horario_extra_clase hec, gnral_personales p,gnral_perfiles gf,gnral_periodo_carreras gpc,gnral_periodos gp,
gnral_carreras gc
WHERE hec.id_extra_clase= ec.id_extra_clase
AND ec.id_horario_profesor = h.id_horario_profesor
and p.id_personal=h.id_personal
AND gp.id_periodo='.$id_periodo.'
AND gc.id_carrera='.$id_carrera.'
AND hec.id_cargo ='.$id_cargo.'
AND gf.id_perfil=p.id_perfil
AND h.id_periodo_carrera=gpc.id_periodo_carrera
AND gpc.id_carrera=gc.id_carrera AND
gpc.id_periodo=gp.id_periodo order by nombre ');

       $datos_docente=array();
       $total_plantilla=0;
        foreach($docentes as $docente)
        {
            $fecha_periodo=$fecha_nuevo;
            $fech_ingr=$docente->fch_ingreso_tesvb;

            $nombre['nombre']= $docente->nombre;
            $nombre['id_personal']= $docente->id_personal;
            $nombre['clave']= $docente->clave;
            $nombre['descripcion']= $docente->descripcion;

                    if($fech_ingr>=$fecha_periodo)
                    {
                        $contrato='NUEVO INGRESO';
                    }
                    else
                    {
                        $contrato="RECONTRATADO";
                    }

            $nombre['fch_ingreso_tesvb']= $docente->fch_ingreso_tesvb;
            $nombre['rfc']= $docente->rfc;
            $nombre['observaciones']= $contrato;
            $nombre['nuevo_c']= $fecha_nuevo;

 $materias = DB::select('select distinct gnral_materias_perfiles.id_materia_perfil mpf,gnral_materias.id_materia idm,
gnral_materias.nombre,gnral_materias.hrs_practicas hrs_p,gnral_materias.hrs_teoria hrs_t,
(gnral_materias.hrs_practicas+gnral_materias.hrs_teoria) totales
FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_periodos, gnral_carreras
                                WHERE
                                gnral_materias_perfiles.id_personal='.$docente->id_personal.' AND
                                gnral_carreras.id_carrera='.$id_carrera.' AND
                                gnral_periodos.id_periodo='.$id_periodo.' AND
                                gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                                gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                UNION
                                SELECT distinct hrs_actividades_extras.id_hrs_actividad_extra mpf,hrs_actividades_extras.id_hrs_actividad_extra idm,
                                hrs_actividades_extras.descripcion nombre,
                                COUNT(hrs_horario_extra_clase.id_semana) hrs_p,"0" hrs_t,COUNT(hrs_horario_extra_clase.id_semana) totales FROM
                                hrs_actividades_extras,hrs_act_extra_clases,hrs_extra_clase,gnral_horarios,gnral_periodos,gnral_carreras,
                                hrs_horario_extra_clase,
                                gnral_periodo_carreras WHERE
                                gnral_carreras.id_carrera='.$id_carrera.' AND
                                gnral_periodos.id_periodo='.$id_periodo.' AND
                                gnral_horarios.id_personal='.$docente->id_personal.' AND
                                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                                hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
                                hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
                                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase
                                GROUP BY hrs_act_extra_clases.id_hrs_actividad_extra,mpf,idm,hrs_actividades_extras.descripcion');

            $nombre_materias=array();

            $f_total=0;
            foreach($materias as $materia)
            {
                $idmateria=$materia->idm;
                if($idmateria<20000)
                {
                    $grupos=DB::select('select DISTINCT gnral_horas_profesores.grupo 
                    FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,
                    gnral_periodo_carreras,gnral_periodos
                    WHERE
                    gnral_materias_perfiles.id_materia_perfil='.$materia->mpf.' AND
                    gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                    gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
                    gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                    gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                    gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

                    $no_grupos=count($grupos);
                    $total=$no_grupos*$materia->totales;
                }
                else
                {
                     $grupos=DB::select('select DISTINCT hrs_extra_clase.grupo
                    FROM hrs_act_extra_clases,hrs_horario_extra_clase,hrs_extra_clase,
                    gnral_periodo_carreras,gnral_periodos,gnral_horarios,hrs_actividades_extras
                    WHERE
                    hrs_actividades_extras.id_hrs_actividad_extra='.$materia->mpf.' AND
                    gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                    gnral_horarios.id_personal='.$docente->id_personal.' AND
                    gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                    hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
                    hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                    hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');
                    $total=$materia->hrs_p;

                    if($idmateria==20001 || $idmateria==20003 || $idmateria==20006 || $idmateria==20005)
                    {
                        $no_grupos="N.A";         
                    }
                    else
                    {
                        $no_grupos=count($grupos);
                    }
                }
               $f_total=$f_total+$total;
                    $nombrem['nombre_materia']= $materia->nombre;
                    $nombrem['id_materia']= $materia->idm;
                    $nombrem['id_materia_perfil']= $materia->mpf;
                    $nombrem['no_grupos']=$no_grupos;
                    $nombrem['horas_totales']=$materia->totales;
                    $nombrem['total']=$total;
                    array_push($nombre_materias, $nombrem);
            }//foreach de materias
            $nombre['f_total']=$f_total;
            $nombre['materias']=$nombre_materias;
            array_push($datos_docente,$nombre);
            $total_plantilla=$total_plantilla+$f_total;
        }

            $pdf->SetDrawColor(49,49,49);
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont('Arial','','6');
            $pos=$pdf->GetY();
            $pdf->MultiCell(6,10,utf8_decode('N.P'),1,'C');
            $pdf->SetXY(11,$pos);
            $pdf->Cell(35,10,utf8_decode('NOMBRE'),1,0,'C');
            $pdf->SetXY(46,$pos);
            $pdf->Cell(35,10,utf8_decode('ASIGNATURA'),1,0,'C');
            $pdf->SetXY(81,$pos);
            $pdf->MultiCell(12,5,utf8_decode('NO. GRUPOS'),1,'C');
            $pdf->SetXY(93,$pos);
            $pdf->MultiCell(10,5,utf8_decode('HRS.X ASIG.'),1,'C');
            $pdf->SetXY(103,$pos);
            $pdf->MultiCell(15,5,utf8_decode('TOTAL HRS.X ASIG'),1,'C');
            $pdf->SetXY(118,$pos);
            $pdf->MultiCell(10,5,utf8_decode('TOTAL HRS.'),1,'C');
            $pdf->SetXY(128,$pos);
            $pdf->Cell(20,10,utf8_decode('RFC'),1,0,'C');
            $pdf->SetXY(148,$pos);
            $pdf->Cell(20,10,utf8_decode('ISSEMYM'),1,0,'C');
            $pdf->SetXY(168,$pos);
            $pdf->Cell(20,10,utf8_decode('INGRESO TESVB'),1,0,'C');
            $pdf->SetXY(188,$pos);
            $pdf->Cell(20,10,utf8_decode('NEVO CONTRATO'),1,'C');
            $pdf->SetXY(208,$pos);
            $pdf->Cell(35,10,utf8_decode('PERFIL'),1,0,'C');
            $pdf->SetXY(243,$pos);
            $pdf->Cell(33,10,utf8_decode('OBSERVACIONES'),1,0,'C');

            $pdf->Output();
            exit();
        }
        public function aulas($id_carrera,$id_aula)
        {
           // set_time_limit(72000);
            $id_periodo=Session::get('periodotrabaja');

            $periodo=DB::select('select gnral_periodos.periodo,gnral_periodos.fecha_inicio,
                gnral_periodos.fecha_termino from gnral_periodos where id_periodo='.$id_periodo.'');

            $aula = DB::selectOne('select hrs_aulas.nombre from hrs_aulas WHERE id_aula='.$id_aula.'');
        $aulan = ($aula->nombre);

$docentes= DB::select('select gnral_materias.nombre materia,
            CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
        gnral_personales.nombre,gnral_horarios.aprobado,gnral_carreras.nombre carr FROM
gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,
gnral_personales,hrs_rhps,gnral_periodo_carreras,gnral_carreras WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_rhps.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
UNION
SELECT hrs_actividades_extras.descripcion materia,hrs_extra_clase.grupo,
gnral_personales.nombre,gnral_horarios.aprobado,gnral_carreras.nombre carr FROM
hrs_horario_extra_clase,hrs_act_extra_clases,hrs_extra_clase,gnral_personales,gnral_horarios,
gnral_periodo_carreras,gnral_carreras,gnral_periodos,hrs_actividades_extras
WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_horario_extra_clase.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
hrs_act_extra_clases.id_act_extra_clase=hrs_actividades_extras.id_hrs_actividad_extra AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase');

$horarios_aula = DB::select('
        SELECT hrs_rhps.id_semana,hrs_semanas.dia dia_materia,hrs_semanas.hora,gnral_materias.nombre materia,
        CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,gnral_carreras.COLOR FROM
gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,hrs_rhps,gnral_periodo_carreras,hrs_semanas,gnral_carreras WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_rhps.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_semana=hrs_semanas.id_semana
UNION
SELECT hrs_horario_extra_clase.id_semana,hrs_semanas.dia,hrs_semanas.hora,hrs_actividades_extras.descripcion materia,
hrs_extra_clase.grupo,gnral_carreras.COLOR FROM
hrs_horario_extra_clase,hrs_semanas,hrs_act_extra_clases,hrs_extra_clase,gnral_horarios,
gnral_periodo_carreras,gnral_carreras,gnral_periodos,hrs_actividades_extras
WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_horario_extra_clase.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_act_extra_clases.id_act_extra_clase=hrs_actividades_extras.id_hrs_actividad_extra 
ORDER BY id_semana,hora ASC');

$semanas=DB::select('select hrs_semanas.id_semana,hrs_semanas.dia,hrs_semanas.hora,
            "0" dia2, "0" longitud, hrs_semanas.dia di,"0" suma from hrs_semanas ORDER by hora,id_semana');
        $horas=DB::select('select DISTINCT hora from hrs_semanas ');
        $diass = DB::select('select DISTINCT dia FROM hrs_semanas');
        $horas=DB::select('select DISTINCT hrs_semanas.hora from hrs_semanas ORDER BY hora,id_semana ');

            $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
            $pdf_aux=new PDF($orientation='L',$unit='mm',$format='Letter');
            $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
            $pdf->SetMargins(5, 20 , 0);
            $pdf->SetAutoPageBreak(true,25);
            $pdf->AddPage();
            $pdf->SetDrawColor(164,164,164);
            $pdf->SetLineWidth(0.6);
            $pdf->Line(234, 5, 234, 24);
            $pdf->SetFont('Arial','','6');
            $pdf->Cell(80);
            $pdf->Cell(100,4,utf8_decode($etiqueta->descripcion),0,0,'C');
            $pdf->Ln(3);
            $pdf->Cell(85);
            $pdf->SetFont('Arial','B','5');
            $pdf->Cell(100,3,utf8_decode('AULA:  '.$aulan),0,0,'C');
            $pdf->Ln(1);

            foreach($periodo as $pe)
            {
                $pdf->Cell(160);
                $pdf->Cell(100,3,utf8_decode('VIGENCIA DEL '.$pe->fecha_inicio.' AL '.$pe->fecha_termino.''),0,0,'R');
                $pdf->Ln(4);
            }
            $pdf->SetDrawColor(49,49,49);
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont('Arial','','6');
       // echo $pdf->GetY();
            $pdf->Cell(25,5,utf8_decode('Hora/Día'),1,0,'C');

            foreach($diass as $dia)
            {
                $pdf->Cell(37,5,utf8_decode($dia->dia),1,0,'C');
            }
            $pdf->Cell(20,5,utf8_decode('Totales'),1,0,'C');
            $pdf->Ln();
             $pdf->SetFont('Arial','','5.5');
     //   echo $pdf->GetY();
$contador=0;
$totalesf=0;
$c_otro=0;
//dd($semanas);
$matriz=array();
$pcontador=count($horarios_aula);
$contador=count($semanas);

for ($j=0; $j < $pcontador;) { 
    
    $com_hora=$horarios_aula[$j]->dia_materia."".$horarios_aula[$j]->hora;
    if($horarios_aula[$j]->grupo==0)
        $horarios_aula[$j]->materia.=$horarios_aula[$j]->materia;
    else
        $horarios_aula[$j]->materia.=" GRUPO: ".$horarios_aula[$j]->grupo;

    $materia=$horarios_aula[$j]->materia;
    $tam=mb_strlen($materia,"UTF-8");

   for ($i=0; $i <$contador;) 
   { 
        $com_sema=$semanas[$i]->dia."".$semanas[$i]->hora;
        if($com_hora==$com_sema)
        {
            $semanas[$i]->dia=$materia;
            $semanas[$i]->longitud=$tam;
            $semanas[$i]->suma=$semanas[$i]->suma+1;
            $j++;
            $i=0;
        }
        else
            $i++;
   }    
  // dd($semanas);
   }
   foreach ($semanas as $sem) 
   {
       if($sem->dia=="sabado"||$sem->dia=="lunes"
        ||$sem->dia=="martes"||$sem->dia=="miercoles"||$sem->dia=="jueves"||$sem->dia=="viernes")
       {
        $sem->dia="";
       }
   }
   $cont=0;

   for ($i=0; $i <15;$i++) 
   { 
        $nombre=$horas[$i]->hora;
            $arre_fila['lunes']=$semanas[$cont]->dia;
            $arre_fila['martes']=$semanas[$cont+1]->dia;
            $arre_fila['miercoles']=$semanas[$cont+2]->dia;
            $arre_fila['jueves']=$semanas[$cont+3]->dia;
            $arre_fila['viernes']=$semanas[$cont+4]->dia;
            $arre_fila['sabado']=$semanas[$cont+5]->dia;

            $l1=$semanas[$cont]->longitud;
            $l2=$semanas[$cont+1]->longitud;
            $l3=$semanas[$cont+2]->longitud;
            $l4=$semanas[$cont+3]->longitud;
            $l5=$semanas[$cont+4]->longitud;
            $l6=$semanas[$cont+5]->longitud;

      $array = array($l1,$l2,$l3,$l4,$l5,$l6);
      //dd($array);
      $maximo=max($array);

      $suma=0;
      $posi="";
      $num_x=0;
    for ($h=0; $h <count($array) ; $h++) 
        { 
            if($array[$h]!="0")
            {
                $suma=$suma+1;
            }
            if($array[$h]==$maximo)
            {
                $cadena_max=$semanas[$cont+$h]->dia;
                //$posicion=""+$arre_fila[$nombre];

                //dd($semanas);
               // dd();
                $posi=$semanas[$cont+$h]->di;
                $num_x=$h;

            }
        }
            $arre_fila['totales']=$suma;
            $arre_fila['maximo']=$maximo;
            $arre_fila['cadenamax']=$cadena_max;
            $arre_fila['posicion']=$posi;
            $arre_fila["posicionx"]=$num_x;
            $cont=$cont+6;
            $arre_fila2[$nombre]=$arre_fila;
       }
$pos=0;
$cont=0;
//dd($arre_fila2);

$pos1y = $pdf->GetY();
//dd($arre_fila2);
foreach($horas as $hora)
{
    $varhei=$pdf->GetMultiCellHeight(37,1.5,utf8_decode($arre_fila2[$hora->hora][$arre_fila2[$hora->hora]["posicion"]]),1,'L');
    $contx=30;
    $pdf->SetXY(5,$pos1y);
    $alt_max=$varhei==0?1.65:$varhei;
    $alt2=$varhei==0?1.65:$varhei*1.65;       
    $pdf->Cell(25,$alt2,utf8_decode($hora->hora),1,0,'C');
    $maximo=$arre_fila2[$hora->hora]["maximo"];
    foreach($diass as $dia)
    { 
            $max=$arre_fila2[$hora->hora]["maximo"];
            $cadena=$arre_fila2[$hora->hora][$dia->dia]." ";
            $i=$pdf->GetMultiCellHeight(37,2,utf8_decode($cadena),1,'L');
            $pdf->SetXY($contx,$pos1y);
            $varhei=$varhei>2.5?2.5:$varhei;
            if($maximo!=0&&$i!=2)
            $pdf->MultiCellEx(37,$varhei,utf8_decode($cadena),1,'L',$i,$alt_max);
            else
             $pdf->Cell(37,$alt2,utf8_decode("".$cadena),1,0,'C');
            $contx+=37;
    }
     $pdf->SetXY(252,$pos1y);
     if($maximo!=0&&$i!=2)
     $pdf->MultiCellEx(20,$varhei,utf8_decode($arre_fila2[$hora->hora]["totales"]),1,'C',2,$alt_max);
     else{
       $pdf->Cell(20,$alt2,$arre_fila2[$hora->hora]["totales"],1,0,'C');
       $pdf->Ln();
   }  
     $pos1y = $pdf->GetY();
}    
$total=0;

$pdf->SetXY(15,$pos1y+5);
$pdf->MultiCell(90,4,utf8_decode("MATERIA"),1,'C');
$pdf->SetXY(105,$pos1y+5);
$pdf->MultiCell(70,4,utf8_decode("DOCENTE"),1,'C');
$pdf->SetXY(175,$pos1y+5);
$pdf->MultiCell(12,4,utf8_decode("GRUPO"),1,'C');
$pdf->SetXY(187,$pos1y+5);
$pdf->MultiCell(70,4,utf8_decode("CARRERA"),1,'C');

foreach($docentes as $docente)
{
    $pdf->SetX(15);
    $pos2y = $pdf->GetY();
    $pdf->MultiCell(90,4,utf8_decode($docente->materia),1,'L');
    $pdf->SetXY(105,$pos2y);
    $pdf->MultiCell(70,4,utf8_decode($docente->nombre),1,'C');
    $pdf->SetXY(175,$pos2y);
    $pdf->MultiCell(12,4,utf8_decode($docente->grupo),1,'C');
    $pdf->SetXY(187,$pos2y);
    $pdf->MultiCell(70,4,utf8_decode($docente->carr),1,'C');
}
      $pdf->Output();
      exit();
    }

    public function gruposs($id_semestre,$grupo,$id_carrera)
    {
      
        
        $id_periodo=Session::get('periodotrabaja');

        $periodo=DB::select('select gnral_periodos.periodo,gnral_periodos.fecha_inicio,
            gnral_periodos.fecha_termino from gnral_periodos where id_periodo='.$id_periodo.'');

        $docentes = DB::select('select DISTINCT gnral_materias.nombre materia,gnral_personales.nombre,gnral_horarios.aprobado FROM 
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales, 
            hrs_rhps,gnral_periodo_carreras WHERE 
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND 
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND 
            gnral_materias.id_semestre='.$id_semestre.' AND 
            gnral_horas_profesores.grupo='.$grupo.' AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND  
            gnral_horarios.id_personal=gnral_personales.id_personal AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND 
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
            UNION
            select DISTINCT hrs_actividades_extras.descripcion materia,gnral_personales.nombre,gnral_horarios.aprobado FROM 
            gnral_horarios,gnral_periodo_carreras,gnral_personales,
            hrs_extra_clase,hrs_act_extra_clases,hrs_horario_extra_clase,hrs_actividades_extras WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND 
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND 
            hrs_extra_clase.grupo='.$id_semestre.'0'.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra ');


$horarios_grupo = DB::select('select DISTINCT hrs_rhps.id_semana,hrs_semanas.dia dia_materia,hrs_semanas.hora,
    gnral_materias.nombre materia,
            gnral_personales.nombre,"Sin Aula" aula,"0" id_aula FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            hrs_rhps,gnral_periodo_carreras,hrs_semanas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_materias.id_semestre='.$id_semestre.' AND
            gnral_horas_profesores.grupo='.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            hrs_rhps.id_semana=hrs_semanas.id_semana AND
            hrs_rhps.id_aula=0
            UNION
            select DISTINCT hrs_rhps.id_semana,hrs_semanas.dia dia_materia,hrs_semanas.hora,
    gnral_materias.nombre materia,
            gnral_personales.nombre,hrs_aulas.nombre aula,hrs_aulas.id_aula FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            hrs_rhps,gnral_periodo_carreras,hrs_semanas,hrs_aulas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_materias.id_semestre='.$id_semestre.' AND
            gnral_horas_profesores.grupo='.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            hrs_rhps.id_semana=hrs_semanas.id_semana AND
            hrs_rhps.id_aula=hrs_aulas.id_aula
            UNION
select DISTINCT hrs_horario_extra_clase.id_semana,hrs_semanas.dia,hrs_semanas.hora,hrs_actividades_extras.descripcion materia,
            gnral_personales.nombre,"Sin Aula" aula,"0" id_aula FROM
            gnral_horarios,hrs_extra_clase,hrs_act_extra_clases,hrs_actividades_extras,gnral_personales,
            hrs_horario_extra_clase,gnral_periodo_carreras,hrs_semanas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            hrs_extra_clase.grupo='.$id_semestre.'0'.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND                    
            hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_horario_extra_clase.id_aula=0
            UNION
            select DISTINCT hrs_horario_extra_clase.id_semana,hrs_semanas.dia,hrs_semanas.hora,hrs_actividades_extras.descripcion materia,
            gnral_personales.nombre,hrs_aulas.nombre aula,hrs_aulas.id_aula FROM
            gnral_horarios,hrs_extra_clase,hrs_act_extra_clases,hrs_actividades_extras,gnral_personales,
            hrs_horario_extra_clase,gnral_periodo_carreras,hrs_semanas,hrs_aulas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            hrs_extra_clase.grupo='.$id_semestre.'0'.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND                    
            hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula');
//dd($horarios_grupo);

$semanas=DB::select('select hrs_semanas.id_semana,hrs_semanas.dia,hrs_semanas.hora,
            "0" dia2, "0" longitud, hrs_semanas.dia di,"0" suma from hrs_semanas ORDER by hora,id_semana');
        $horas=DB::select('select DISTINCT hora from hrs_semanas ');
        $diass = DB::select('select DISTINCT dia FROM hrs_semanas');
        $horas=DB::select('select DISTINCT hrs_semanas.hora from hrs_semanas ORDER BY hora,id_semana ');

            $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
            $pdf_aux=new PDF($orientation='L',$unit='mm',$format='Letter');

            $pdf->SetMargins(5, 20 , 0);
            $pdf->SetAutoPageBreak(true,25);
            $pdf->AddPage();
            $pdf->SetDrawColor(164,164,164);
            $pdf->SetLineWidth(0.6);
            $pdf->Line(234, 4, 234, 24);
            $pdf->SetFont('Arial','','6');
            $pdf->Cell(80);
            $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
            $pdf->Cell(100,4,utf8_decode($etiqueta->descripcion),0,0,'C');
            $pdf->Ln(3);
            $pdf->Cell(85);
            $pdf->SetFont('Arial','B','5');
            $pdf->Cell(100,3,utf8_decode('GRUPO:  '.$id_semestre."0".$grupo),0,0,'C');
            $pdf->Ln(3);

            foreach($periodo as $pe)
            {
                $pdf->Cell(160);
                $pdf->Cell(100,3,utf8_decode('VIGENCIA DEL '.$pe->fecha_inicio.' AL '.$pe->fecha_termino.''),0,0,'R');
                $pdf->Ln(4);
            }
            $pdf->SetDrawColor(49,49,49);
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont('Arial','','5');
       // echo $pdf->GetY();
            $pdf->Cell(25,5,utf8_decode('Hora/Día'),1,0,'C');

            foreach($diass as $dia)
            {
                $pdf->Cell(37,5,utf8_decode($dia->dia),1,0,'C');
            }
            $pdf->Cell(20,5,utf8_decode('Totales'),1,0,'C');
            $pdf->Ln();
             $pdf->SetFont('Arial','','5');
     //   echo $pdf->GetY();
$contador=0;
$totalesf=0;
$c_otro=0;
//dd($semanas);
$matriz=array();
$pcontador=count($horarios_grupo);
$contador=count($semanas);

for ($j=0; $j < $pcontador;) { 
    
    $com_hora=$horarios_grupo[$j]->dia_materia."".$horarios_grupo[$j]->hora;
    if($horarios_grupo[$j]->id_aula==0)
        $horarios_grupo[$j]->materia.=$horarios_grupo[$j]->materia.'  '."Sin Aula";
    else
        $horarios_grupo[$j]->materia.=" AULA: ".$horarios_grupo[$j]->aula;

    $materia=$horarios_grupo[$j]->materia;
    $tam=mb_strlen($materia,"UTF-8");

   for ($i=0; $i <$contador;) 
   { 
        $com_sema=$semanas[$i]->dia."".$semanas[$i]->hora;
        if($com_hora==$com_sema)
        {
            $semanas[$i]->dia=$materia;
            $semanas[$i]->longitud=$tam;
            $semanas[$i]->suma=$semanas[$i]->suma+1;
            $i=0;
        }
        else
            $i++;
   }    
            $j++;
   
   }
   //dd($semanas);
   foreach ($semanas as $sem) 
   {
       if($sem->dia=="sabado"||$sem->dia=="lunes"
        ||$sem->dia=="martes"||$sem->dia=="miercoles"||$sem->dia=="jueves"||$sem->dia=="viernes")
       {
        $sem->dia="";
       }
   }
   $cont=0;


   for ($i=0; $i <15;$i++) 
   { 
        $nombre=$horas[$i]->hora;
            $arre_fila['lunes']=$semanas[$cont]->dia;
            $arre_fila['martes']=$semanas[$cont+1]->dia;
            $arre_fila['miercoles']=$semanas[$cont+2]->dia;
            $arre_fila['jueves']=$semanas[$cont+3]->dia;
            $arre_fila['viernes']=$semanas[$cont+4]->dia;
            $arre_fila['sabado']=$semanas[$cont+5]->dia;

            $l1=$semanas[$cont]->longitud;
            $l2=$semanas[$cont+1]->longitud;
            $l3=$semanas[$cont+2]->longitud;
            $l4=$semanas[$cont+3]->longitud;
            $l5=$semanas[$cont+4]->longitud;
            $l6=$semanas[$cont+5]->longitud;

      $array = array($l1,$l2,$l3,$l4,$l5,$l6);
      //dd($array);
      $maximo=max($array);

      $suma=0;
      $posi="";
      $num_x=0;
    for ($h=0; $h <count($array) ; $h++) 
        { 
            if($array[$h]!="0")
            {
                $suma=$suma+1;
            }
            if($array[$h]==$maximo)
            {
                $cadena_max=$semanas[$cont+$h]->dia;
                $posi=$semanas[$cont+$h]->di;
                $num_x=$h;

            }
        }
            $arre_fila['totales']=$suma;
            $arre_fila['maximo']=$maximo;
            $arre_fila['cadenamax']=$cadena_max;
            $arre_fila['posicion']=$posi;
            $arre_fila["posicionx"]=$num_x;
            $cont=$cont+6;
            $arre_fila2[$nombre]=$arre_fila;
       }
$pos=0;
$cont=0;
//dd($arre_fila2);

$pos1y = $pdf->GetY();
//dd($arre_fila2);
foreach($horas as $hora)
{
    $varhei=$pdf->GetMultiCellHeight(37,1.5,utf8_decode($arre_fila2[$hora->hora][$arre_fila2[$hora->hora]["posicion"]]),1,'L');
    $contx=30;
    $pdf->SetXY(5,$pos1y);
    $alt_max=$varhei==0?1.65:$varhei;
    $alt2=$varhei==0?1.65:$varhei*1.65;       
    $pdf->Cell(25,$alt2,utf8_decode($hora->hora),1,0,'C');
    $maximo=$arre_fila2[$hora->hora]["maximo"];
    foreach($diass as $dia)
    { 
            $max=$arre_fila2[$hora->hora]["maximo"];
            $cadena=$arre_fila2[$hora->hora][$dia->dia]." ";
            $i=$pdf->GetMultiCellHeight(37,2,utf8_decode($cadena),1,'L');
            $pdf->SetXY($contx,$pos1y);
            $varhei=$varhei>2.5?2.5:$varhei;
            if($maximo!=0&&$i!=2)
            $pdf->MultiCellEx(37,$varhei,utf8_decode($cadena),1,'L',$i,$alt_max);
            else
             $pdf->Cell(37,$alt2,utf8_decode("".$cadena),1,0,'C');
            $contx+=37;
    }
     $pdf->SetXY(252,$pos1y);
     if($maximo!=0&&$i!=2)
     $pdf->MultiCellEx(20,$varhei,utf8_decode($arre_fila2[$hora->hora]["totales"]),1,'C',2,$alt_max);
     else{
       $pdf->Cell(20,$alt2,$arre_fila2[$hora->hora]["totales"],1,0,'C');
       $pdf->Ln();
   }  
     $pos1y = $pdf->GetY();
}    
$total=0;

$pdf->SetXY(55,$pos1y+5);
$pdf->MultiCell(70,4,utf8_decode("MATERIA"),1,'C');
$pdf->SetXY(125,$pos1y+5);
$pdf->MultiCell(70,4,utf8_decode("DOCENTE"),1,'C');

foreach($docentes as $docente)
{
    $pdf->SetX(55);
    $pos2y = $pdf->GetY();
    $pdf->MultiCell(70,4,utf8_decode($docente->materia),1,'L');
    $pdf->SetXY(125,$pos2y);
    $pdf->MultiCell(70,4,utf8_decode($docente->nombre),1,'C');
}
      $pdf->Output();
      exit();
    }
    public function prof_materia()
    {
        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');
        $carrera=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$id_carrera.'');
        $carrera=($carrera->nombre);

        $periodo=DB::selectOne('select gnral_periodos.periodo fecha,gnral_periodos.fecha_inicio,
        gnral_periodos.fecha_termino from gnral_periodos where id_periodo='.$id_periodo.'');
        $periodo=($periodo->fecha);

        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
            $pdf_aux=new PDF($orientation='L',$unit='mm',$format='Letter');

            $pdf->SetMargins(5, 20 , 0);
            $pdf->SetAutoPageBreak(true,25);
            $pdf->AddPage();
            $pdf->SetDrawColor(164,164,164);
            $pdf->SetLineWidth(0.6);
            $pdf->Line(234, 10, 234, 30);
            $pdf->SetFont('Arial','B','7.5');
            $pdf->Ln(3);
            $pdf->Cell(2);
            $pdf->SetFillColor(160,160,160);
            $pdf->Cell(267,5,utf8_decode('RELACIÓN DE DOCENTES'),1,0,'C',true);
            $pdf->Ln(7);
            $pdf->Cell(2);
            $pdf->Cell(120,4.5,utf8_decode('CARRERA:'.$carrera),1,0,'L',true);
            $pdf->Cell(50);
            $pdf->Cell(97,4.5,utf8_decode('SEMESTRE:'.$periodo),1,0,'R',true);

            $relacion=DB::select('select DISTINCT gnral_perfiles.descripcion,gnral_personales.nombre,
            gnral_personales.cedula,gnral_materias.nombre materia,gnral_materias.unidades,
            concat(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo)grupo
            FROM gnral_personales,gnral_perfiles,gnral_horarios,gnral_horas_profesores,hrs_rhps,gnral_materias,
            gnral_materias_perfiles,
            gnral_periodo_carreras
            WHERE
            gnral_personales.id_perfil=gnral_perfiles.id_perfil AND
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            gnral_materias_perfiles.id_personal=gnral_personales.id_personal
            ORDER BY gnral_personales.nombre,grupo');


            //dd($relacion);
            $pdf->Ln(7);
            $pdf->Cell(2);
            $pdf->Cell(10,4.7,utf8_decode('No.'),1,0,'C');
            $pdf->Cell(55,4.7,utf8_decode('GRADO ACADÉMICO'),1,0,'C');
            $pdf->Cell(70,4.7,utf8_decode('NOMBRE COMPLETO'),1,0,'C');
            $pdf->Cell(30,4.7,utf8_decode('CÉDULA'),1,0,'C');
            $pdf->Cell(81,4.7,utf8_decode('MATERIAS QUE IMPARTE'),1,0,'C');
            $pdf->Cell(20,4.7,utf8_decode('UNIDADES'),1,0,'C');

            $contador=1;
            foreach($relacion as $rel)
            {
                $pdf->Ln();
                $pdf->Cell(2);
                $pdf->Cell(10,4,utf8_decode($contador),1,0,'C');
                $contador++;
            }

            $pdf->Output();
            exit();
    }

}
