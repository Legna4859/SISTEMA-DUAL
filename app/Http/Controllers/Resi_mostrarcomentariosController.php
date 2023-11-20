<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;
class Resi_mostrarcomentariosController extends Controller
{
    public function comentarios_portada($id_revision,$id_anteproyecto){
         $numero_evaluacion=$id_revision;
        $comentario_portada=DB::selectOne('SELECT count(resi_comentarios_portada.id_comentario_portada) comentario_portada 
from resi_comentarios_portada where id_anteproyecto='.$id_anteproyecto.' 
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_portada=$comentario_portada->comentario_portada;
        $comentarios_profesores=DB::select('SELECT resi_comentarios_portada.*,gnral_personales.nombre 
FROM resi_comentarios_portada,gnral_personales 
WHERE gnral_personales.id_personal=resi_comentarios_portada.id_profesor 
and resi_comentarios_portada.id_anteproyecto= '.$id_anteproyecto.'
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'');
        return view('residencia.revisar_anteproyecto.comentarios_portada',compact('comentarios_profesores','comentario_portada'));
    }
    public function comentarios_objetivos($id_revision,$id_anteproyecto){
        $numero_evaluacion=$id_revision;
        $comentario_objetivos=DB::selectOne('SELECT count(resi_comentarios_objetivos.id_comentario_objetivos) comentario_objetivos 
from resi_comentarios_objetivos where id_anteproyecto='.$id_anteproyecto.' 
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'');

        $comentario_objetivos=$comentario_objetivos->comentario_objetivos;

        $comentarios_profesores_objetivos=DB::select('SELECT resi_comentarios_objetivos.*,gnral_personales.nombre 
FROM resi_comentarios_objetivos,gnral_personales 
WHERE gnral_personales.id_personal=resi_comentarios_objetivos.id_profesor 
and resi_comentarios_objetivos.id_anteproyecto= '.$id_anteproyecto.'
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'');
        return view('residencia.revisar_anteproyecto.comentarios_objetivos',compact('comentarios_profesores_objetivos','comentario_objetivos'));


    }
    public function comentarios_alcances($id_revision,$id_anteproyecto){
        $numero_evaluacion=$id_revision;
        $comentario_alcances=DB::selectOne('SELECT count(resi_comentarios_alcances.id_comentario_alcances) comentario_alcances 
from resi_comentarios_alcances where id_anteproyecto='.$id_anteproyecto.' 
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_alcances=$comentario_alcances->comentario_alcances;

        $comentarios_profesores_alcances=DB::select('SELECT resi_comentarios_alcances.*,gnral_personales.nombre 
FROM resi_comentarios_alcances,gnral_personales 
WHERE gnral_personales.id_personal=resi_comentarios_alcances.id_profesor 
and resi_comentarios_alcances.id_anteproyecto= '.$id_anteproyecto.'
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'');

        return view('residencia.revisar_anteproyecto.comentarios_alcances',compact('comentarios_profesores_alcances','comentario_alcances'));
    }

    public function comentarios_justificacion($id_revision,$id_anteproyecto){
        $numero_evaluacion=$id_revision;
        $comentario_justificacion=DB::selectOne('SELECT count(resi_comentarios_justificacion.id_comentario_justificacion) comentario_justificacion 
from resi_comentarios_justificacion where id_anteproyecto='.$id_anteproyecto.'  and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_justificacion=$comentario_justificacion->comentario_justificacion;

        $comentarios_profesores_justificacion=DB::select('SELECT resi_comentarios_justificacion.*,gnral_personales.nombre
 FROM resi_comentarios_justificacion,gnral_personales
  WHERE gnral_personales.id_personal=resi_comentarios_justificacion.id_profesor 
  and resi_comentarios_justificacion.id_anteproyecto='.$id_anteproyecto.'
  and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'');
        return view('residencia.revisar_anteproyecto.comentarios_justificacion',compact('comentarios_profesores_justificacion','comentario_justificacion'));

    }
    public function comentarios_marco_teorico($id_revision,$id_anteproyecto){
        $numero_evaluacion=$id_revision;

        $comentario_marcoteorico=DB::selectOne('SELECT count(resi_comentarios_marcoteorico.id_comentario_marcoteorico) comentario_marcoteorico 
from resi_comentarios_marcoteorico where id_anteproyecto='.$id_anteproyecto.' and 
resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_marcoteorico=$comentario_marcoteorico->comentario_marcoteorico;

        $comentarios_profesores_marcoteorico=DB::select('SELECT resi_comentarios_marcoteorico.*,gnral_personales.nombre 
FROM resi_comentarios_marcoteorico,gnral_personales 
WHERE gnral_personales.id_personal=resi_comentarios_marcoteorico.id_profesor
 and resi_comentarios_marcoteorico.id_anteproyecto='.$id_anteproyecto.'
 and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'');

        return view('residencia.revisar_anteproyecto.comentario_marco_teorico',compact('comentarios_profesores_marcoteorico','comentario_marcoteorico'));

    }
    public function comentarios_cronograma($id_revision,$id_anteproyecto){
        $numero_evaluacion=$id_revision;
        $comentario_cronograma=DB::selectOne('SELECT count(resi_comentarios_cronograma.id_comentario_cronograma) comentario_cronograma 
from resi_comentarios_cronograma where id_anteproyecto='.$id_anteproyecto.'
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'');
      $comentario_cronograma=$comentario_cronograma->comentario_cronograma;

        $comentarios_profesores_cronograma=DB::select('SELECT resi_comentarios_cronograma.*,gnral_personales.nombre 
FROM resi_comentarios_cronograma,gnral_personales WHERE gnral_personales.id_personal=resi_comentarios_cronograma.id_profesor 
and resi_comentarios_cronograma.id_anteproyecto='.$id_anteproyecto.'
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'');
        return view('residencia.revisar_anteproyecto.comentario_cronograma',compact('comentarios_profesores_cronograma','comentario_cronograma'));

    }

}
