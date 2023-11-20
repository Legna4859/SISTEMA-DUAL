<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;
class Resi_documentacionfinal_alController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $seguimiento= DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto 
from resi_anteproyecto,resi_asesores where resi_anteproyecto.id_anteproyecto=resi_asesores.id_anteproyecto 
and resi_asesores.id_periodo='.$periodo.' and resi_anteproyecto.id_alumno='.$alumno.' ');
        $id_anteproyecto=$seguimiento->id_anteproyecto;
        $calificado=DB::selectOne('SELECT * FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` = '.$id_anteproyecto.'');

        if($calificado == null){
            $estado_calificado=0;
            return view('residencia.autorizacion_documentos_final_residencia.estado_documentacion_residencia',compact('estado_calificado'));
        }else{
            $estado_calificado=1;
            $estado_documentacion=DB::selectOne('SELECT * FROM `resi_liberacion_documentos` WHERE `id_anteproyecto` = '.$id_anteproyecto.' ');
            $estado_enviado=$estado_documentacion->id_estado_enviado;

            if($estado_enviado == 0) {
                return view('residencia.autorizacion_documentos_final_residencia.enviar_documento_alumno', compact('estado_enviado', 'estado_documentacion', 'datosalumno'));
            }
            elseif($estado_enviado == 1 || $estado_enviado == 3 || $estado_enviado == 4){
                return view('residencia.autorizacion_documentos_final_residencia.estado_documentacion_residencia',compact('estado_calificado','estado_enviado'));
            }
            elseif($estado_enviado == 2){
                return view('residencia.autorizacion_documentos_final_residencia.enviar_doc_mod_finales_alumn', compact('estado_enviado', 'estado_documentacion', 'datosalumno'));

            }

        }

        }
        public function modificar_correo_documentacionfinal(Request  $request){
            $this->validate($request,[
                'id_liberacion_documentos' => 'required',
                'correo_electronico_doc' => 'required',
            ]);
            $id_liberacion_documentos = $request->input("id_liberacion_documentos");
            $correo_electronico_doc = $request->input("correo_electronico_doc");
            DB::update("UPDATE resi_liberacion_documentos SET correo_electronico='$correo_electronico_doc'  WHERE id_liberacion_documentos=$id_liberacion_documentos");
        return back();
    }
    public function acta_calificacion_documentacionfinal(Request $request,$id_liberacion_documentos){
        $file=$request->file('acta_calificacion');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="acta_calificacion_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_acta_calificacion' => $name]);
        return back();
    }
    public function portada_documentacionfinal(Request $request,$id_liberacion_documentos){
        $file=$request->file('portada');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="portada_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_portada' => $name]);
        return back();
    }
    public function evaluacion_final_residencia_documentacionfinal(Request $request,$id_liberacion_documentos){
        $file=$request->file('evaluacion_final_residencia');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="evaluacion_final_residencia_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_evaluacion_final_residencia' => $name]);
        return back();
    }
    public function oficio_aceptacion_informe_interno_documentacionfinal(Request $request,$id_liberacion_documentos){

        $file=$request->file('oficio_aceptacion_informe_interno');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="oficio_aceptacion_informe_interno_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_oficio_aceptacion_informe_interno' => $name]);
        return back();
    }
    public function formato_evaluacion_documentacionfinal(Request $request,$id_liberacion_documentos){

        $file=$request->file('formato_evaluacion');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="formato_evaluacion_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_formato_evaluacion' => $name]);
        return back();
    }
    public function oficio_aceptacion_informe_revisor_documentacionfinal(Request $request,$id_liberacion_documentos){

        $file=$request->file('oficio_aceptacion_informe_revisor');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="oficio_aceptacion_informe_revisor_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_oficio_aceptacion_informe_revisor' => $name]);
        return back();
    }
    public function oficio_aceptacion_informe_externo_documentacionfinal(Request $request,$id_liberacion_documentos){

        $file=$request->file('oficio_aceptacion_informe_externo');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="oficio_aceptacion_informe_externo_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_oficio_aceptacion_informe_externo' => $name]);
        return back();
    }
    public function formato_hora_documentacionfinal(Request $request,$id_liberacion_documentos){

        $file=$request->file('formato_hora');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="formato_hora_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_formato_hora' => $name]);
        return back();
    }
    public function seguimiento_interno_documentacionfinal(Request $request,$id_liberacion_documentos){

        $file=$request->file('seguimiento_interno');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="seguimiento_interno_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_seguimiento_interno' => $name]);
        return back();
    }
    public function seguimiento_externo_documentacionfinal(Request $request,$id_liberacion_documentos){

        $file=$request->file('seguimiento_externo');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="seguimiento_externo_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf_doc_final/',$name);

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['pdf_seguimiento_externo' => $name]);
        return back();
    }
    public function  envio_documento_residencia_final(Request  $request,$id_liberacion_documentos){

        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['id_estado_enviado' => 1]);
        return back();
    }
    public function enviar_doc_mod_final_dep(Request $request, $id_liberacion_documentos){
        DB::table('resi_liberacion_documentos')
            ->where('id_liberacion_documentos', $id_liberacion_documentos)
            ->update(['id_estado_enviado' => 3]);
        return back();
    }


}
