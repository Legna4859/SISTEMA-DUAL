<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Session;
class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->SetXY(42,10);
        $this->SetFont('Arial','B',8);
        $this->Cell(131,5,utf8_decode('HISTORIAL ACADÉMICO'),0,1,'C');
        $this->Cell(195,5,utf8_decode('FO- TESVB -38'),0,0,'C');
        $this->SetXY(15,0);
        $this->Image('img/tes.png', 177, 10, 25);
        $this->Image('img/gem.png',14,5,25);
        $this->SetFont('Arial','',8);
        $this->Ln(5);
        $this->Cell(32,20,utf8_decode(''),1,0,'R');
        $this->Cell(131,20,utf8_decode(''),1,0,'R');
        $this->Cell(32,20,utf8_decode(''),1,0,'R');

        $this->Ln(18);

    }
    //PIE DE PAGINA
    function Footer()
    {
        /*
                $this->SetY(-25);
                $this->SetFont('Arial','',8);
                $this->Image('img/sgc.PNG',40,183,20);

                $this->Image('img/sga.PNG',65,183,20);
                $this->Cell(100);
                $this->Cell(167,-2,utf8_decode('FO-TESVB-39  V.1  14-08-2019'),0,0,'R');
                $this->Ln(3);
                $this->Cell(100);
                $this->Cell(167,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
                $this->Ln(3);
                $this->Cell(100);
                $this->Cell(167,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
                $this->Ln(3);
                $this->Cell(100);
                $this->Cell(167,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
                $this->Ln(3);
                $this->Cell(100);
                $this->Cell(167,-2,utf8_decode('SUBDIRECCIÓN DE SERVICIOS ESCOLARES'),0,0,'R');
                $this->Cell(280);
                $this->SetMargins(0,0,0);
                $this->Ln(0);
                $this->SetXY(30,204);
                $this->SetFillColor(120,120,120);
                $this->Cell(20,10,'',0,0,'',TRUE);
                $this->SetTextColor(255,255,255);
                $this->Cell(297,10,utf8_decode('Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
                $this->Ln(3);
                $this->Cell(50);
                $this->Cell(160,10,utf8_decode(' Valle de Bravo, Estado de México, C.P. 51200.    Tels.: (726)26 6 52 00, 26 6 50 77,26 6 51 87 Ext 115                             sub.escolares@tesvb.edu.mx'),0,0,'L');

                $this->Image('img/logos/Mesquina.jpg',0,190,30);
        */
    }

}
class Cal_pdf_historial_academicoController extends Controller
{
    public function pdf_academico($id_alumno,$plan,$especialidad,$calificada){

        $alumno=DB::selectOne('SELECT gnral_alumnos.*, gnral_carreras.nombre carrera from gnral_carreras,gnral_alumnos where gnral_alumnos.id_carrera=gnral_carreras.id_carrera and gnral_alumnos.id_alumno='.$id_alumno.'');
        $nombre=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
        $no_cuenta=mb_strtoupper($alumno->cuenta);
        $carrera=mb_strtoupper($alumno->carrera);
        $id_periodo=Session::get('periodotrabaja');

        if($calificada == 1) {


            $materias_rep = DB::select('SELECT distinct gnral_materias.id_materia from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 
 and eva_carga_academica.id_materia  NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571) 
 and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
  and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo 
  and gnral_periodos.id_periodo >= 20 and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');

            $materias = array();
            foreach ($materias_rep as $materias_rep) {
                $contar_mat = DB::selectOne('SELECT  count(gnral_materias.id_materia) contar_materia from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 and eva_carga_academica.id_materia=' . $materias_rep->id_materia . ' 
 and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
  and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo 
  and gnral_periodos.id_periodo >= 20 and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');
                if ($contar_mat->contar_materia > 1) {
                    $max_periodo = DB::selectOne('SELECT  max(eva_validacion_de_cargas.id_periodo) periodo  from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 and eva_carga_academica.id_materia=' . $materias_rep->id_materia . ' 
 and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
  and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo 
  and gnral_periodos.id_periodo >= 20 and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');
                    $max= DB::selectOne('SELECT  eva_carga_academica.id_carga_academica   from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 and eva_carga_academica.id_materia=' . $materias_rep->id_materia . ' 
 and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
  and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo 
  and gnral_periodos.id_periodo = '.$max_periodo->periodo.' and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');

                    $materias_n = DB::selectOne('SELECT gnral_materias.*,eva_carga_academica.id_tipo_curso,eva_carga_academica.id_carga_academica,gnral_periodos.year,
gnral_periodos.siglas,gnral_periodos.id_periodo from eva_carga_academica,gnral_materias,gnral_periodos
 where   eva_carga_academica.id_carga_academica=' . $max->id_carga_academica . '  and eva_carga_academica.id_periodo= gnral_periodos.id_periodo
        and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');
                    $alumnos_materia['id_carga_academica'] = $materias_n->id_carga_academica;
                    $alumnos_materia['id_materia'] = $materias_n->id_materia;
                    $alumnos_materia['unidades'] = $materias_n->unidades;
                    $alumnos_materia['clave'] = $materias_n->clave;
                    $alumnos_materia['nombre_materia'] = $materias_n->nombre;
                    $alumnos_materia['creditos'] = $materias_n->creditos;
                    $alumnos_materia['periodo'] = $materias_n->siglas;
                    $alumnos_materia['year'] = $materias_n->year;
                    $alumnos_materia['id_semestre'] = $materias_n->id_semestre;
                    $alumnos_materia['id_tipo_curso'] = $materias_n->id_tipo_curso;

                } else {
                    $materias_o = DB::selectOne('SELECT gnral_materias.*,eva_carga_academica.id_tipo_curso,eva_carga_academica.id_carga_academica,gnral_periodos.year,
gnral_periodos.siglas,gnral_periodos.id_periodo from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 and  eva_carga_academica.id_materia=' . $materias_rep->id_materia . ' 
        and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
        and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
        and gnral_periodos.id_periodo >= 20 and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');
                    $alumnos_materia['id_carga_academica'] = $materias_o->id_carga_academica;
                    $alumnos_materia['id_materia'] = $materias_o->id_materia;
                    $alumnos_materia['unidades'] = $materias_o->unidades;
                    $alumnos_materia['clave'] = $materias_o->clave;
                    $alumnos_materia['nombre_materia'] = $materias_o->nombre;
                    $alumnos_materia['creditos'] = $materias_o->creditos;
                    $alumnos_materia['periodo'] = $materias_o->siglas;
                    $alumnos_materia['year'] = $materias_o->year;
                    $alumnos_materia['id_semestre'] = $materias_o->id_semestre;
                    $alumnos_materia['id_tipo_curso'] = $materias_o->id_tipo_curso;

                }
                array_push($materias, $alumnos_materia);
            }
        }
        elseif($calificada == 2)
        {
            $materias_rep = DB::select('SELECT distinct gnral_materias.id_materia from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 
 and eva_carga_academica.id_materia  NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
 and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
  and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo 
  and gnral_periodos.id_periodo >= 20 and  gnral_periodos.id_periodo <'.$id_periodo.' and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');

            $materias = array();
            foreach ($materias_rep as $materias_rep) {
                $contar_mat = DB::selectOne('SELECT  count(gnral_materias.id_materia) contar_materia from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 and eva_carga_academica.id_materia=' . $materias_rep->id_materia . ' 
 and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
  and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo 
  and gnral_periodos.id_periodo >= 20  and  gnral_periodos.id_periodo <'.$id_periodo.' and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');
                if ($contar_mat->contar_materia > 1) {
                    $max_periodo = DB::selectOne('SELECT  max(eva_validacion_de_cargas.id_periodo) periodo  from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 and eva_carga_academica.id_materia=' . $materias_rep->id_materia . ' 
 and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
  and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo 
  and gnral_periodos.id_periodo >= 20 and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');
                    $max= DB::selectOne('SELECT  eva_carga_academica.id_carga_academica   from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 and eva_carga_academica.id_materia=' . $materias_rep->id_materia . ' 
 and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
  and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo 
  and gnral_periodos.id_periodo = '.$max_periodo->periodo.' and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');

                    $materias_n = DB::selectOne('SELECT gnral_materias.*,eva_carga_academica.id_tipo_curso,eva_carga_academica.id_carga_academica,gnral_periodos.year,
gnral_periodos.siglas,gnral_periodos.id_periodo from eva_carga_academica,gnral_materias,gnral_periodos
 where   eva_carga_academica.id_carga_academica=' . $max->id_carga_academica . '  and eva_carga_academica.id_periodo= gnral_periodos.id_periodo
        and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');
                    $alumnos_materia['id_carga_academica'] = $materias_n->id_carga_academica;
                    $alumnos_materia['id_materia'] = $materias_n->id_materia;
                    $alumnos_materia['unidades'] = $materias_n->unidades;
                    $alumnos_materia['clave'] = $materias_n->clave;
                    $alumnos_materia['nombre_materia'] = $materias_n->nombre;
                    $alumnos_materia['creditos'] = $materias_n->creditos;
                    $alumnos_materia['periodo'] = $materias_n->siglas;
                    $alumnos_materia['year'] = $materias_n->year;
                    $alumnos_materia['id_semestre'] = $materias_n->id_semestre;
                    $alumnos_materia['id_tipo_curso'] = $materias_n->id_tipo_curso;

                } else {
                    $materias_o = DB::selectOne('SELECT gnral_materias.*,eva_carga_academica.id_tipo_curso,eva_carga_academica.id_carga_academica,gnral_periodos.year,
gnral_periodos.siglas,gnral_periodos.id_periodo from eva_validacion_de_cargas,eva_carga_academica,gnral_materias,gnral_periodos
 where eva_validacion_de_cargas.id_alumno=' . $id_alumno . ' and eva_carga_academica.id_status_materia=1 and  eva_carga_academica.id_materia=' . $materias_rep->id_materia . ' 
        and eva_validacion_de_cargas.estado_validacion in (2,8,9,10) and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno
        and eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
        and gnral_periodos.id_periodo >= 20 and eva_carga_academica.id_materia=gnral_materias.id_materia ORDER BY `gnral_materias`.`id_semestre` ASC');
                    $alumnos_materia['id_carga_academica'] = $materias_o->id_carga_academica;
                    $alumnos_materia['id_materia'] = $materias_o->id_materia;
                    $alumnos_materia['unidades'] = $materias_o->unidades;
                    $alumnos_materia['clave'] = $materias_o->clave;
                    $alumnos_materia['nombre_materia'] = $materias_o->nombre;
                    $alumnos_materia['creditos'] = $materias_o->creditos;
                    $alumnos_materia['periodo'] = $materias_o->siglas;
                    $alumnos_materia['year'] = $materias_o->year;
                    $alumnos_materia['id_semestre'] = $materias_o->id_semestre;
                    $alumnos_materia['id_tipo_curso'] = $materias_o->id_tipo_curso;

                }
                array_push($materias, $alumnos_materia);
            }

        }
        // dd($materias);

        $suma_promedio_final=0;
        $suma_materia=0;
        $alumnos= array();
        foreach($materias as $mat){
            $suma_materia++;
            $datos_alumnos['numero']=$suma_materia;
            $datos_alumnos['id_carga_academica']=$mat['id_carga_academica'];
            $datos_alumnos['id_materia']=$mat['id_materia'];
            $datos_alumnos['nombre_materia']=$mat['nombre_materia'];
            $datos_alumnos['id_semestre']=$mat['id_semestre'];
            $datos_alumnos['clave']=$mat['clave'];
            $datos_alumnos['creditos'] = $mat['creditos'];
            $datos_alumnos['periodo'] = $mat['periodo'];
            $datos_alumnos['year'] = $mat['year'];
            $datos_alumnos['id_tipo_curso'] = $mat['id_tipo_curso'];

            $materia_promedio=DB::selectOne('SELECT SUM(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` ='.$mat['id_carga_academica'].' and calificacion >=70');
            $materia_promedio=$materia_promedio->suma;

            $contar_unidades_pasadas=DB::selectOne('SELECT count(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` = '.$mat['id_carga_academica'].' and calificacion >=70');
            $contar_unidades_pasadas=$contar_unidades_pasadas->suma;

            $contar_sumativa=DB::selectOne('SELECT count(esc) contar FROM `cal_evaluaciones` WHERE `id_carga_academica` = '.$mat['id_carga_academica'].' and esc=1');
            $contar_sumativa=$contar_sumativa->contar;

            if($contar_unidades_pasadas ==$mat['unidades']){
                if($materia_promedio == 0){
                    $promedio=0;
                }
                else{
                    $promedio=round($materia_promedio/$mat['unidades']);
                }
                if($mat['id_tipo_curso'] ==1  ){
                    if($contar_sumativa == 0){
                        $te='O';
                    }
                    else{
                        $te='ESC';
                    }

                }

                if($mat['id_tipo_curso'] ==2){
                    if($contar_sumativa == 0){
                        $te='O2';
                    }
                    else{
                        $te='ESC2';
                    }

                }
                if($mat['id_tipo_curso'] ==3){
                    if($contar_sumativa == 0){
                        $te='CE';
                    }
                    else{
                        $te='CG';
                    }

                }
                if($mat['id_tipo_curso'] ==4){
                    if($contar_sumativa == 0){
                        $te='CG';
                    }
                    else{
                        $te='CG';
                    }

                }
            }
            else{

                if($mat['id_tipo_curso'] == 0){
                    $promedio=0;
                }
                else{
                    $promedio=0;
                }
                if($mat['id_tipo_curso'] ==1){
                    $te='ESC';
                }
                if($mat['id_tipo_curso'] ==2){
                    $te='ESC2';
                }
                if($mat['id_tipo_curso'] ==3){
                    $te='CE';
                }
                if($mat['id_tipo_curso'] ==4){
                    $te='CG';
                }



            }
            $datos_alumnos['promedio']=$promedio;
            $datos_alumnos['te']=$te;
            array_push($alumnos,$datos_alumnos);
        }
        $suma_mat=0;
        $promedio_final=0;
        $contar_creditos=0;
        $materias_actualizadas= array();
        foreach ($alumnos as $alum){
            $eliminacion_mat=DB::selectOne('SELECT COUNT(id_carga_academica) total FROM cal_eliminacion_materia WHERE id_carga_academica='.$alum['id_carga_academica'].'');
            if($eliminacion_mat->total == 0)
            {
                $suma_mat++;
                $datos_alu['numero']=$suma_materia;
                $datos_alu['id_carga_academica']=$alum['id_carga_academica'];
                $datos_alu['id_materia']=$alum['id_materia'];
                $datos_alu['nombre_materia']=$alum['nombre_materia'];
                $datos_alu['id_semestre']=$alum['id_semestre'];
                $datos_alu['clave']=$alum['clave'];
                if($alum['promedio'] < 70)
                {
                    $datos_alu['creditos']  = 0;
                }
                else{
                    $datos_alu['creditos'] = $alum['creditos'];
                    $contar_creditos+=$alum['creditos'];
                }
                $datos_alu['periodo'] = $alum['periodo'];
                $datos_alu['year'] = $alum['year'];
                $datos_alu['id_tipo_curso'] = $alum['id_tipo_curso'];
                $datos_alu['promedio'] = $alum['promedio'];
                $datos_alu['esc'] = $alum['te'];
                $promedio_final+=$alum['promedio'];
                //$contar_creditos+=$alum['creditos'];
                array_push($materias_actualizadas,$datos_alu);
            }

        }

        $residencia=DB::selectOne('SELECT count(id_cal_residencia) residencia FROM cal_residencia WHERE id_alumno='.$id_alumno.'');
        $residencia=$residencia->residencia;
        if($residencia == 0){
            $resi=0;

        }
        else{

            $resi=10;
            $datos_residencia=DB::selectOne('SELECT *FROM cal_residencia WHERE id_alumno='.$id_alumno.'');
            $promedio_residencia=$datos_residencia->calificacion;
            $promedio_final=$promedio_final+$promedio_residencia;
            $suma_mat++;
            if($promedio_residencia >= 70){
                $contar_creditos=$contar_creditos+$resi;
            }

        }

        $servicio_social=DB::selectOne('SELECT count(id_servicio_social) servicio FROM cal_servicio_social WHERE id_alumno='.$id_alumno.'');
        $servicio_social=$servicio_social->servicio;
        if($servicio_social == 0){
            $servicio=0;

        }
        else{
            $servicio=10;
            $datos_servicio=DB::selectOne('SELECT *FROM cal_servicio_social WHERE id_alumno='.$id_alumno.'');
            $promedio_servicio=$datos_servicio->calificacion;
            $promedio_final=$promedio_final+$promedio_servicio;
            $suma_mat++;
            if($promedio_servicio >= 70) {
                $contar_creditos = $contar_creditos + $servicio;
            }
        }


        $actividades_complementaria=DB::selectOne('SELECT count(id_actividades_comple)actividades from cal_actividades_complementarias WHERE id_alumno='.$id_alumno.'');
        $actividades_complementaria=$actividades_complementaria->actividades;
        if($actividades_complementaria == 0){
            $actividades=0;
        }
        else{
            $actividades=5;
            $datos_actividades=DB::selectOne('SELECT *from cal_actividades_complementarias WHERE id_alumno='.$id_alumno.'');

            $contar_creditos=$contar_creditos+$actividades;
        }

//dd($suma_mat);
        if($promedio_final == 0)
        {
            $promedio_f=0;
        }
        else{
            $promedio_f=($promedio_final/$suma_mat);
            $promedio_f = number_format($promedio_f, 2, '.', ' ');
        }
        $especialidad=mb_strtoupper($especialidad);
        $plan=mb_strtoupper($plan);
        $fechas = date("Y-m-d");

        $num=date("d",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num.' de '.$mes.' de '.$ano;
        $pdf=new PDF($orientation='P',$unit='mm',$format='Legal');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 0, 10);
        $pdf->AddPage();
        $pdf->SetFillColor(166,166,166);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(30,3,utf8_decode('No. Cuenta'),'LTR',0,'L');
        $pdf->Cell(90,3,utf8_decode('Nombre:'),'LTR',0,'L');
        $pdf->Cell(75,3,utf8_decode('Carrera:'),'LTR',1,'L');
        $pdf->SetFont('Arial','B','7');
        $pdf->Cell(30,3,utf8_decode($no_cuenta),'LBR',0,'L');
        $pdf->Cell(90,3,utf8_decode($nombre),'LBR',0,'L');
        $pdf->Cell(75,3,utf8_decode($carrera),'LBR',1,'L');
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(65,3,utf8_decode('Especialidad'),1,0,'L');
        $pdf->Cell(65,3,utf8_decode('Plan:'),1,0,'L');
        $pdf->Cell(65,3,utf8_decode('Fecha:'),1,1,'L');
        $pdf->SetFont('Arial','B','7');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->MultiCell(65, 4,utf8_decode($especialidad),0);
        $y2=$pdf->GetY();
        $x2=$pdf->GetX();
        $pdf->Setxy(75,37);
        $pdf->MultiCell(65, 4, utf8_decode($plan),0);
        $pdf->Setxy(140,37);
        $pdf->MultiCell(65, 4, utf8_decode($fech),0);

        $y3=$y2-$y;
        $pdf->Setxy($x,$y);
        $pdf->Cell(65,$y3,utf8_decode(''),1,0,'L');
        $pdf->Cell(65,$y3,utf8_decode(''),1,0,'L');
        $pdf->Cell(65,$y3,utf8_decode(''),1,0,'L');
        //dd($y3);
        //$pdf->Cell(65,3,utf8_decode($plan),'LBR',0,'L');
        //$pdf->Cell(65,3,utf8_decode($fech),'LBR',1,'L');
        $pdf->Setxy($x2,$y2);
        $pdf->SetFont('Arial','B','7');
        $pdf->Cell(8,4,utf8_decode('Sem.'),1,0,'C');
        $pdf->Cell(18,4,utf8_decode('Clave'),1,0,'C');
        $pdf->Cell(100,4,utf8_decode('Nombre de la Materia'),1,0,'C');
        $pdf->Cell(8,4,utf8_decode('Cr.'),1,0,'C');
        $pdf->Cell(8,4,utf8_decode('Cal.'),1,0,'C');
        $pdf->Cell(8,4,utf8_decode('Acr.'),1,0,'C');
        $pdf->Cell(20,4,utf8_decode('Periodo'),1,0,'C');
        $pdf->Cell(8,4,utf8_decode('Año'),1,0,'C');
        $pdf->Cell(17,4,utf8_decode('Fech. Esp.'),1,1,'C');

        $pdf->SetFont('Arial','','6');
        foreach($materias_actualizadas as $alumno) {
            $pdf->Cell(8, 4, utf8_decode($alumno['id_semestre']), 1, 0, 'C');
            $pdf->Cell(18, 4, utf8_decode($alumno['clave']), 1, 0, 'C');

            $pdf->Cell(100, 4, utf8_decode($alumno['nombre_materia']), 1, 0, 'L');

            $pdf->Cell(8, 4, utf8_decode($alumno['creditos']), 1, 0, 'C');
            if($alumno['promedio']  <70 )
            {
                $pdf->Cell(8, 4, utf8_decode('N.A.'), 1, 0, 'C');
            }
            else{
                $pdf->Cell(8, 4, utf8_decode($alumno['promedio']), 1, 0, 'C');
            }

            $pdf->Cell(8, 4, utf8_decode($alumno['esc']), 1, 0, 'C');
            $pdf->Cell(20, 4, utf8_decode($alumno['periodo']), 1, 0, 'C');
            $pdf->Cell(8, 4, utf8_decode($alumno['year']), 1, 0, 'C');
            $pdf->Cell(17, 4, utf8_decode(''), 1, 1, 'C');
        }

        if($residencia > 0)
        {

            $num=$datos_residencia->fecha_termino;
            $year =substr($num, 0,4);
            $mes =substr($num, 5,2);
            $dia =substr($num, 8,2);
            $fecha_re= $dia.'/'.$mes.'/'.$year;
            $pdf->Cell(8, 4, utf8_decode('9'), 1, 0, 'C');
            $pdf->Cell(18, 4, utf8_decode('RES-0001'), 1, 0, 'C');

            $pdf->Cell(100, 4, utf8_decode('RESIDENCIA PROFESIONAL'), 1, 0, 'L');

            //$pdf->Cell(8, 4, utf8_decode('10'), 1, 0, 'C');
            if($datos_residencia->calificacion < 70)
            {
                $pdf->Cell(8, 4, utf8_decode('0'), 1, 0, 'C');
                $pdf->Cell(8, 4, utf8_decode("N.A"), 1, 0, 'C');

            }
            else{
                $pdf->Cell(8, 4, utf8_decode('10'), 1, 0, 'C');
                $pdf->Cell(8, 4, utf8_decode($datos_residencia->calificacion), 1, 0, 'C');

            }
            $pdf->Cell(8, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(20, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(8, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(17, 4, utf8_decode($fecha_re), 1, 1, 'C');
        }
        if($servicio > 0)
        {
            $num=$datos_servicio->fecha_termino;
            $year =substr($num, 0,4);
            $mes =substr($num, 5,2);
            $dia =substr($num, 8,2);


            $fecha_s= $dia.'/'.$mes.'/'.$year;
            $pdf->Cell(8, 4, utf8_decode('9'), 1, 0, 'C');
            $pdf->Cell(18, 4, utf8_decode('SSC-0001'), 1, 0, 'C');

            $pdf->Cell(100, 4, utf8_decode('SERVICIO SOCIAL'), 1, 0, 'L');


            if($datos_servicio->calificacion < 70){
                $pdf->Cell(8, 4, utf8_decode('0'), 1, 0, 'C');
                $pdf->Cell(8, 4, utf8_decode("N.A."), 1, 0, 'C');

            }
            else{
                $pdf->Cell(8, 4, utf8_decode('10'), 1, 0, 'C');
                $pdf->Cell(8, 4, utf8_decode($datos_servicio->calificacion), 1, 0, 'C');

            }
             $pdf->Cell(8, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(20, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(8, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(17, 4, utf8_decode($fecha_s), 1, 1, 'C');
        }
        if($actividades > 0)
        {

            $pdf->Cell(8, 4, utf8_decode('9'), 1, 0, 'C');
            $pdf->Cell(18, 4, utf8_decode('ACC-0001'), 1, 0, 'C');

            $pdf->Cell(100, 4, utf8_decode('ACTIVIDADES COMPLEMENTARIAS'), 1, 0, 'L');

            $pdf->Cell(8, 4, utf8_decode('5'), 1, 0, 'C');
            $pdf->Cell(8, 4, utf8_decode('ACA'), 1, 0, 'C');
            $pdf->Cell(8, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(20, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(8, 4, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(17, 4, utf8_decode(''), 1, 1, 'C');
        }
        $pdf->SetFont('Arial','B','6');
        $pdf->Cell(126, 4, utf8_decode('Totales:'), 0, 0, 'R');
        $pdf->Cell(8, 4, utf8_decode($contar_creditos), 1, 0, 'C');
        $pdf->Cell(8, 4, utf8_decode($promedio_f), 1, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('O'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Curso Normal Ordinario'), 1, 0, 'L');
        $pdf->Cell(48, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(48, 3, utf8_decode('A T E N T A M E N T E '), 0, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('R'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Curso Normal Regularización'), 1, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('E'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Curso Normal Extraordinario'), 1, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('O2'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Curso Repetición Ordinario'), 1, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('R2'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Curso Repetición Regularización'), 1, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('EE'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Examen Especial'), 1, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('CG'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Examen Global'), 1, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('ESC'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Evaluación Sumativa de Complementación'), 1, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('ESC2'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Evaluación Sumativa de Complementación 2'), 1, 0, 'L');
        $pdf->Cell(35, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(56, 3, utf8_decode(' __________________________________'), 0, 1, 'L');


        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('CR'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Curso de Repetición'), 1, 1, 'L');


        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('CE'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Curso Especial'), 1, 0, 'L');
        $pdf->Cell(35, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(56, 3, utf8_decode('L. EN C. ROMULO ESQUIVEL REYES'), 0, 1, 'L');

        $pdf->SetFont('Arial','','6');
        $pdf->Cell(12, 3, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(8, 3, utf8_decode('ACA'), 1, 0, 'L');
        $pdf->Cell(55, 3, utf8_decode('Actividad Complementaria Acreditada'), 1, 1, 'L');

        $pdf->Output();
        exit();

    }
}
