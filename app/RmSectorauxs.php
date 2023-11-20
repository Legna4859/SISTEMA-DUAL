<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class RmSectorauxs extends Model
{

    use Notifiable;
    protected $table = 'rm_sectorauxs';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','csp','puesto','fechain','id_area','condicion'];


    public function departamentos() //Relacion de la FK
    {
        /***  relacion de sectoraux solo tiene un departamento**/
        return $this->belongsTo('App\gnral_unidad_administrativa','id','id_unidad_admin' );
    }

    public function scopeBuscarpor($query,$tipo,$buscar)//Se usa QUERY SCOPE para buscar
    {
        if(($tipo) && ($buscar)) {
            return $query->where($tipo, 'like', "%$buscar%");
        }
    }



}
