<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\EvidenciaAlumno;
use Storage;
use Session;

class EvidenciasAlumnosController extends Controller
{


    public function index()
    {

        $usuario = Session::get('usuario');

        $periodo=Session::get('periodo_actual');


        $alumnos=DB::select("select actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion,actcomple_categorias.descripcion_cat, actcomple_registros_coordinadores.no_evidencias,actcomple_registros_coordinadores.rubrica, gnral_alumnos.cuenta,actividades_complementarias.horas,actividades_complementarias.creditos,
                            actcomple_registro_alumnos.id_registro_alumno,actcomple_docente_actividad.id_docente_actividad,actcomple_docente_actividad.id_docente_actividad faltan
                            from actividades_complementarias,gnral_alumnos,actcomple_registro_alumnos,actcomple_docente_actividad,actcomple_categorias,actcomple_registros_coordinadores,gnral_periodos
                            where gnral_alumnos.cuenta='$usuario'
                            and actcomple_categorias.id_categoria=actividades_complementarias.id_categoria
                            and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                            and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                            and actcomple_docente_actividad.id_docente_actividad=actcomple_registros_coordinadores.id_docente_actividad
                            and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                            and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo 
                            and gnral_periodos.id_periodo=$periodo
                             and actcomple_docente_actividad.id_periodo=$periodo
                            and actcomple_registro_alumnos.liberacion=2");
    if($alumnos==null)
          {
                $existe_id=0; 
                $mensaje_evidencias="AÚN NO HA SIDO ACEPTADA TU ACTIVIDAD";
                return view('actividades_complementarias.alumnos.mensajes',compact('mensaje_evidencias'));

          }
          else
          {

    for ($i=0; $i <count($alumnos) ; $i++) 
    { 
          $numero_evidencia[$i]=DB::select('select actcomple_registros_coordinadores.no_evidencias from actcomple_registros_coordinadores                                    
                                                where actcomple_registros_coordinadores.id_docente_actividad='.$alumnos[$i]->id_docente_actividad.'');
                
         $evidencia[$i]=DB::select('select sum(actcomple_evidencias_alumno.numero_evidencias) suma from actcomple_evidencias_alumno,actcomple_registro_alumnos,gnral_alumnos
                                        where actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                        and actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                                        and actcomple_registro_alumnos.id_registro_alumno='.$alumnos[$i]->id_registro_alumno.'');

         if($evidencia[$i][0]->suma==null)
         {
            $evidencia[$i][0]->suma=0;
         }   


        $restas[]=(($numero_evidencia[$i][0]->no_evidencias)-($evidencia[$i][0]->suma));

        $alumnos[$i]->faltan=$restas[$i];


        }

        $existe_id=0; 

    }

     
return view('actividades_complementarias.alumnos.carga_evidencias_alumnos',compact('restas','existe_id','alumnos','numero_evidencia','tabla_evidencias','resta'));

        

    }
   
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $usuario = Session::get('usuario');
        $resta=Session::get('ciclos');

        $registro=$request->get('registro_alumno');

        $evi=$request->get('evidencias');
//dd($registro);
            $files=array();
            $fdata=$_FILES["urlImg"];

                    $contar_doc=DB::selectOne('SELECT count(id_evidencia_alumno) contar from actcomple_evidencias_alumno WHERE id_registro_alumno='.$registro.'');
                    $suma=$contar_doc->contar+1;
                    Storage::disk('ArchivosAlumnos')->put($registro."_".$suma."_".$fdata["name"][0],file_get_contents($fdata["tmp_name"][0]));
                    $nuevo = array('id_registro_alumno' => $registro,
                                    'archivo' => $registro."_".$suma."_".$fdata["name"][0],
                                    'numero_evidencias' => 1);
                                    //dd($nuevo);
                                    $planeacion=EvidenciaAlumno::create($nuevo);         
                            
                          

        return redirect('/evidencias_alumnos');

    }

    public function cargar_evidencias(Request $request,$id_registro_alumno)
    {
        dd("hola");

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
