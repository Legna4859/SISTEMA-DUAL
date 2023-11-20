<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_area_psicopedagogica extends Model
{
    protected $table ="exp_area_psicopedagogica";
    protected $primaryKey="id_exp_area_psicopedagogica";
   // public $timestamps = false;
    protected $fillable=["rendimiento_escolar","dominio_idioma","otro_idioma","conocimiento_compu","aptitud_especial",
        "comprension","preparacion","estrategias_aprendizaje","organizacion_actividades","concentracion","solucion_problemas",
        "condiciones_ambientales","busqueda_bibliografica","trabajo_equipo","id_alumno"];

    public function rendimientoescolar()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','rendimiento_escolar');
    }
    public function dominioidioma()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','dominio_idioma');
    }
    public function otroidioma()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','otro_idioma');
    }
    public function conocimientocompu ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','conocimiento_compu');
    }
    public function aptitudespecial ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','aptitud_especial');
    }
    public function comprension1 ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','comprension');
    }
    public function preparacion1 ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','preparacion');
    }
    public function estrategiasaprendizaje ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','estrategias_aprendizaje');
    }
    public function organizacionactividades ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','organizacion_actividades');
    }
    public function concentracion1 ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','concentracion');
    }
    public function solucionproblemas ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','solucion_problemas');
    }
    public function condicionesambientales ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','condiciones_ambientales');
    }
    public function busquedabibliografica ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','busqueda_bibliografica');
    }
    public function trabajoequipo ()
    {
        return $this->hasOne('App\Tutorias_Exp_escalas','id_escala','trabajo_equipo');
    }
}
