<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RmBienes;
use App\RmSectorauxs;

class RmResguardos extends Model
{
    protected $table = 'rm_resguardos';
    protected $primaryKey = 'id';
    protected $fillable = ['fecha','id_bienres','id_sector'];

    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id','id_bienres');
    }
    public function sectores()
    {
        return $this->hasMany('App\RmSectorauxs','id','id_sector');
    }
    public function sectorr()
    {
        return $this->hasMany('App\RmSectorauxs','id','id_sector');
    }
    public function bien()
    {
        return $this->belongsTo('App\RmBienes','id_bienres','id');
    }
    public function scopeBuscarpor($query,$tipo,$buscar)//Se usa QUERY SCOPE para buscar
    {
        if(($tipo) && ($buscar)) {
            return $query->where($tipo, 'like', "%$buscar%");
        }
    }
    public function scopeSector($query,$sectores)//Se usa QUERY SCOPE para buscar
    {
        if($sectores) {
            return $query->where('id_sector', 'like', "%$sectores%");
        }
    }
}
