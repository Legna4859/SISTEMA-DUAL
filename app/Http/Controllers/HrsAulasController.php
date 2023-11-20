<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Carreras;
use App\Hrs_Aulas;
use Session;

class HrsAulasController extends Controller
{
    public function index()
    {
        $id_carrera=0;
        $carreras = DB::select('select *from gnral_carreras order by nombre');
        $datos_carreras=array();    
            foreach($carreras as $carrera){
            $nombre['nombre_carrera']= $carrera->nombre;
            $nombre['id_carrera']= $carrera->id_carrera;

            $aulas = DB::select('select *from hrs_aulas where id_carrera='.$carrera->id_carrera.'');
            $nombre_aulas=array();

            foreach($aulas as $aula)
            {
                $nombrem['nombre_aula']= $aula->nombre;
                $nombrem['id_aula']= $aula->id_aula;
                array_push($nombre_aulas, $nombrem);
            }
            $nombre['aulas']=$nombre_aulas;
            array_push($datos_carreras,$nombre);
        }
        return view('horarios.horarios_aulas',compact('id_carrera'))->with('carreras',$datos_carreras);
    }
    public function horarios_aulas($id_carrera,$id_aula)
    {
        $id_periodo=Session::get('periodotrabaja');
        
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
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase');

$no_im=0;
$si_im=0;
$cuenta=count($docentes);

foreach($docentes as $docente)
{
    if($docente->aprobado==0)
        $no_im++;
    else
        $si_im++;
}
if($no_im>0)
$imprime=0;
else
    if($si_im==$cuenta)
        $imprime=1;

        $carreras = DB::select('select *from gnral_carreras order by nombre');

        $datos_carreras=array();    
            foreach($carreras as $carrera){
            $nombre['nombre_carrera']= $carrera->nombre;
            $nombre['id_carrera']= $carrera->id_carrera;

            $aulas = DB::select('select *from hrs_aulas where id_carrera='.$carrera->id_carrera.'');
            $nombre_aulas=array();

            foreach($aulas as $aula)
            {
                $nombrem['nombre_aula']= $aula->nombre;
                $nombrem['id_aula']= $aula->id_aula;
                array_push($nombre_aulas, $nombrem);
            }
            $nombre['aulas']=$nombre_aulas;
            array_push($datos_carreras,$nombre);
        }
        $horario_aula = DB::select('
        SELECT hrs_rhps.id_semana,hrs_semanas.dia,hrs_semanas.hora,gnral_materias.nombre materia,
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
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra 
ORDER BY id_semana,hora ASC');

/*$max_clase = DB::select('select MAX( sem.hora ) hcmax, MIN( sem.hora ) hcmin FROM gnral_personales p, gnral_horarios h, gnral_horas_profesores hp, gnral_materias_perfiles mf, gnral_materias m, gnral_periodo_carreras pc, gnral_periodos pe, gnral_carreras ca, hrs_rhps rhps, hrs_semanas sem
WHERE p.id_personal = h.id_personal
AND h.id_periodo_carrera = pc.id_periodo_carrera
AND pc.id_carrera = ca.id_carrera
AND pc.id_periodo = pe.id_periodo
AND h.id_horario_profesor = hp.id_horario_profesor
AND hp.id_materia_perfil = mf.id_materia_perfil
AND mf.id_materia = m.id_materia
AND hp.id_hrs_profesor = rhps.id_hrs_profesor
AND rhps.id_semana = sem.id_semana
and rhps.id_aula='.$id_aula.'
AND pe.id_periodo ='.$id_periodo.'');

$max_extra = DB::select('
SELECT  MAX( s.hora ) hemax, MIN( s.hora ) hemin FROM hrs_act_extra_clases aec, hrs_extra_clase ec, hrs_horario_extra_clase hec, hrs_semanas s, gnral_horarios h, gnral_personales p, gnral_periodo_carreras pc, gnral_periodos pe, hrs_aulas a
WHERE pe.id_periodo = pc.id_periodo
AND pc.id_periodo_carrera = h.id_periodo_carrera
AND h.id_personal = p.id_personal
AND h.id_horario_profesor = ec.id_horario_profesor
AND ec.id_act_extra_clase = aec.id_act_extra_clase
AND ec.id_extra_clase = hec.id_extra_clase
AND hec.id_semana = s.id_semana
AND hec.id_aula = a.id_aula
AND pe.id_periodo ='.$id_periodo.'
AND a.id_aula ='.$id_aula.'');

$tam=count($max_clase);

for ($i=0; $i <$tam ; $i++) 
{ 
        if($max_clase[$i]->hcmax < $max_extra[$i]->hemax)
        {

            $max_clase[$i]->hcmax=$max_extra[$i]->hemax;
        }
        else
        {
            $max_clase[$i]->hcmax=$max_clase[$i]->hcmax;
        }
         if($max_clase[$i]->hcmin < $max_extra[$i]->hemin)
        {

            $max_clase[$i]->hcmin=$max_clase[$i]->hcmin;
        }
        else
        {
            $max_clase[$i]->hcmin=$max_extra[$i]->hemin;
        }
}*/
    /*$semanas= DB::select('select * FROM hrs_semanas where hora IN 
        (select hora FROM hrs_semanas where hora>="'.$max_clase[0]->hcmin.'" and hora<="'.$max_clase[0]->hcmax.'" group by hora)
        ORDER by hora,id_semana');*/
$semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
    
    return view('horarios.horarios_aulas',compact('horario_aula','aulan','carreras',
        'semanas','id_carrera','horas','docentes','imprime','id_aula'))->with(['ver' => true, 'carreras' => $datos_carreras]);
   
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
