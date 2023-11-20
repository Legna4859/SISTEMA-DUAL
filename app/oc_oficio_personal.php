<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oc_oficio_personal extends Model
{
    //
    protected $table='oc_oficio_personal';
    protected $primaryKey='id_oficio_personal';
    protected $fillable=['anio','id_oficio','id_personal','viaticos','automovil','id_notificacion'];

   public  function  oficio(){
       return $this->belongsTo(oc_oficio::class, 'id_oficio');

   }
    public function notificacion()
    {
        return $this->hasMany(oc_notificacion::class, 'id_notificacion')
            ->where('id_notificacion','=',2)
            ->orwhere('id_notificacion','=',3);
    }
    public function personal()
    {
        return $this->hasMany('App\Personal','id_personal','id_personal');


    }
}

