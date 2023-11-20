<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RmBienes;
use Illuminate\Notifications\Notifiable;

class RmProvedores extends Model
{
    use Notifiable;
    protected $table = 'rm_provedores';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','contacto','email','condicion'];

    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id_provedor');
    }
    public function scopeBuscarpor($query,$tipo,$buscar)//Se usa QUERY SCOPE para buscar
    {
        if(($tipo) && ($buscar)) {
            return $query->where($tipo, 'like', "%$buscar%");
        }
    }
}

