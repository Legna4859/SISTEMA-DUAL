<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\RmModelos;
use App\RmCategoria;
use App\RmColores;
use App\RmMarcas;
use App\RmEstadouso;
use App\RmProvedores;
use App\RmResguardos;
use App\RmTipoadqui;
use App\RmTipobienes;

class RmBienes extends Model
{
    protected $table = 'rm_bienes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre','caracteristicas','num_inventario','nick','serie','costo','stock','condicion',
        'fechadqui','tipoadqui','id_categoria','id_provedor','id_modelo','id_estado','id_marca',
        'id_tipob','id_color','id_adqui','factura'];

    public function categorias()
    {
        return $this->belongsTo('App\RmCategoria','id_categoria','id');
    }
    public function provedores()
    {
        return $this->belongsTo('App\RmProvedores','id_provedor','id');
    }
    public function modelos()
    {
        return $this->belongsTo('App\RmModelos','id_modelo','id');
    }
    public function usos()
    {
        return $this->belongsTo('App\RmEstadouso','id_estado','id');
    }
    public function marcas()
    {
        return $this->belongsTo('App\RmMarcas','id_marca','id');
    }
    public function bienest()
    {
        return $this->belongsTo('App\RmTipobienes','id_tipob','id');
    }
    public function colores()
    {
        return $this->belongsTo('App\RmColores','id_color','id');
    }
    public function adquisiciones()
    {
        return $this->belongsTo('App\RmTipoadqui','id_adqui','id');
    }
    public function resguardos()
    {
        return $this->hasMany('App\RmResguardos','id_bienres','id');
    }
    public function scopeBuscarpor($query,$tipo,$buscar)//Se usa QUERY SCOPE para buscar
    {
        if(($tipo) && ($buscar)) {
            return $query->where($tipo, 'like', "%$buscar%");
        }
    }

}

