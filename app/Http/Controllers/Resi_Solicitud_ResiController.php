<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class Resi_Solicitud_ResiController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $id_alumno=$datosalumno->id_alumno;
       // dd($id_alumno);
        $id_carrera=$datosalumno->id_carrera;

        $datos_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre, gnral_carreras.nombre carrera 
        from abreviaciones, abreviaciones_prof, gnral_personales, gnral_carreras, gnral_jefes_periodos 
        where abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and 
        abreviaciones_prof.id_personal = gnral_personales.id_personal and
        gnral_personales.id_personal = gnral_jefes_periodos.id_personal and 
        gnral_jefes_periodos.id_carrera = gnral_carreras.id_carrera and gnral_jefes_periodos.id_carrera = '.$id_carrera.'
           and gnral_jefes_periodos.id_periodo = '.$periodo.' ');
      //  dd($datos_jefe);

        $periodo_seguimiento= $periodo+1;
        $nombre_periodo_seguimiento=DB::selectOne('SELECT * FROM `gnral_periodos` WHERE `id_periodo` ='.$periodo_seguimiento.' ');

        $opciones_proyecto =DB::select('SELECT * FROM `resi_opcion_proy_soli` ORDER BY `resi_opcion_proy_soli`.`nombre_opcion` ASC');

        $anteproyecto=DB::selectOne('select resi_anteproyecto.id_anteproyecto from resi_anteproyecto where resi_anteproyecto.id_alumno='.$id_alumno.' and resi_anteproyecto.id_periodo='.$periodo.' ');

        $datos_empresa=DB::selectOne('SELECT resi_proy_empresa.*,resi_giro.descripcion giro, resi_sector.descripcion sector,
        resi_empresa.nombre, resi_empresa.domicilio,resi_empresa.tel_empresa, resi_empresa.correo,resi_empresa.dir_gral, 
        resi_proyecto.nom_proyecto from resi_proy_empresa, resi_empresa, resi_giro, resi_sector, resi_proyecto, resi_anteproyecto
        where resi_proy_empresa.id_empresa = resi_empresa.id_empresa and resi_proy_empresa.id_giro = resi_giro.id_giro and
        resi_proy_empresa.id_sector = resi_sector.id_sector and resi_proyecto.id_proyecto = resi_anteproyecto.id_proyecto and 
        resi_proy_empresa.id_anteproyecto = resi_anteproyecto.id_anteproyecto and resi_anteproyecto.id_anteproyecto ='.$anteproyecto->id_anteproyecto.' ');

        // dd($datos_empresa);
        $nombre_preyecto= $datos_empresa->nom_proyecto;
        $nombre_proyecto=mb_eregi_replace("[\n|\r|\n\r]",'',$nombre_preyecto);

        $contar_reg_solicitud= DB::selectOne('SELECT COUNT(id_anteproyecto) contar from resi_reg_solicitud where id_anteproyecto ='.$anteproyecto->id_anteproyecto.' ');

        if($contar_reg_solicitud->contar == 0){
            $estado_reg_soli=0;
            $reg_solicitud="";
        }else{
            $estado_reg_soli=1;
            $reg_solicitud = DB::selectOne('SELECT * FROM `resi_reg_solicitud` WHERE `id_anteproyecto` ='.$anteproyecto->id_anteproyecto.'');

        }
//dd($reg_solicitud);

        $datos_alumn = DB::selectOne('SELECT gnral_alumnos.*, gnral_municipios.nombre_municipio,
       gnral_seguro_social.descripcion seguro_social, users.email,gnral_carreras.nombre carrera from gnral_alumnos, gnral_municipios, gnral_seguro_social, users, gnral_carreras
       where gnral_alumnos.id_municipio = gnral_municipios.id_municipio and gnral_alumnos.id_seguro_social = gnral_seguro_social.id_seguro_social 
       and gnral_alumnos.id_carrera = gnral_carreras.id_carrera
       and gnral_alumnos.id_usuario = users.id and gnral_alumnos.id_alumno ='.$id_alumno.' ');

        $domicilio_empresa=mb_eregi_replace("[\n|\r|\n\r]",'',$datos_empresa->domicilio);
        //dd($datos_alumn);


//dd($datos_empresa);

       return view('residencia.agregar_datos_solicitud', compact('datos_jefe','datos_empresa',
           'nombre_proyecto','estado_reg_soli','opciones_proyecto','nombre_periodo_seguimiento','domicilio_empresa',
           'datos_alumn','anteproyecto','reg_solicitud'));
    }
    public  function guardar_solicitud_residencia(Request $request,$id_anteproyecto){

        $id_opcion_proyecto = $request->input("id_opcion_proyecto");
        $rfc_empresa = $request->input("rfc_empresa");
        $colonia_empresa = $request->input("colonia_empresa");
        $codigo_postal_empresa = $request->input("codigo_postal");
        $municipio_empresa = $request->input("municipio_empresa");
        $telefono_empresa = $request->input("telefono_empresa");
        $mision_empresa = $request->input("mision_empresa");
        $puesto_titular_empresa = $request->input("puesto_titular_empresa");
      //  $nombre_acuerdo_empresa= $request->input("nombre_acuerdo_empresa");
      //  $puesto_acuerdo_empresa= $request->input("puesto_acuerdo_empresa");
        $domiclio_estudiante= $request->input("domiclio_estudiante");
        $no_seguro= $request->input("no_seguro");
        $telefono_estudiante= $request->input("telefono_estudiante");
        $fecha = date("Y-m-d");


        DB:: table('resi_reg_solicitud')
            ->insert([
                'id_opcion_proyecto' => $id_opcion_proyecto,
                'rfc_empresa' => $rfc_empresa,
                'colonia_empresa' => $colonia_empresa,
                'codigo_postal_empresa' => $codigo_postal_empresa,
                'ciudad_municipio_empresa' => $municipio_empresa,
                'telefono_empresa' => $telefono_empresa,
                'mision_empresa' => $mision_empresa,
                'puesto_titular_empresa' => $puesto_titular_empresa,

                'domiclio_estudiante' => $domiclio_estudiante,
                'no_seguro_estudiante' => $no_seguro,
                'telefono_estudiante' => $telefono_estudiante,
                'id_anteproyecto' => $id_anteproyecto,
                'fecha_registro' => $fecha
        ]);
        return back();



    }
    public function guardar_mod_solicitud_residencia(Request $request, $id_anteproyecto){
        $id_opcion_proyecto = $request->input("id_opcion_proyecto");
        $rfc_empresa = $request->input("rfc_empresa");
        $colonia_empresa = $request->input("colonia_empresa");
        $codigo_postal_empresa = $request->input("codigo_postal");
        $municipio_empresa = $request->input("municipio_empresa");
        $telefono_empresa = $request->input("telefono_empresa");
        $mision_empresa = $request->input("mision_empresa");
        $puesto_titular_empresa = $request->input("puesto_titular_empresa");
        $domiclio_estudiante= $request->input("domiclio_estudiante");
        $no_seguro= $request->input("no_seguro");
        $telefono_estudiante= $request->input("telefono_estudiante");
        $fecha = date("Y-m-d");

        DB::table('resi_reg_solicitud')
            ->where('id_anteproyecto', $id_anteproyecto)
            ->update([
                'id_opcion_proyecto' => $id_opcion_proyecto,
                'rfc_empresa' => $rfc_empresa,
                'colonia_empresa' => $colonia_empresa,
                'codigo_postal_empresa' => $codigo_postal_empresa,
                'ciudad_municipio_empresa' => $municipio_empresa,
                'telefono_empresa' => $telefono_empresa,
                'mision_empresa' => $mision_empresa,
                'puesto_titular_empresa' => $puesto_titular_empresa,
                'domiclio_estudiante' => $domiclio_estudiante,
                'no_seguro_estudiante' => $no_seguro,
                'telefono_estudiante' => $telefono_estudiante,
                'fecha_registro' => $fecha
            ]);
        return back();
    }
}
