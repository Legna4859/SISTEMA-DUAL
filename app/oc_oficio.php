<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oc_oficio extends Model
{
    protected $table='oc_oficio';
    protected $primaryKey='id_oficio';
    protected $fillable=['fecha','desc_comision','fecha_salida','fecha_regreso','hora_s','hora_r','id_lugar_salida','id_lugar_entrada','id_notificacion_solicitud','fecha_hora','id_usuario'];
    public function comisionados()
    {
        return $this->hasMany('App\oc_oficio_personal','id_oficio','id_oficio')
            ->where('id_notificacion','=',1);
    }
    public function comisiones()
    {
        return $this->hasMany('App\oc_oficio_personal','id_oficio','id_oficio')
            ->where('id_notificacion','=',2);
    }
    public function comisionadosprofesores()
    {
        return $this->hasMany('App\oc_oficio_personal','id_oficio','id_oficio')
            ->where('id_notificacion','=',5);
    }
    public function usuario(){
        return $this->hasMany('App\Gnral_Personales','tipo_usuario','id_usuario');
    }
    public function comisionesvalidadas()
    {
        return $this->hasMany('App\oc_oficio_personal','id_oficio','id_oficio')
            ->whereIn('oc_oficio_personal.id_notificacion',[1,2,3,4,5,6]);
    }


}

