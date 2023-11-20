<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcNotas extends Model
{
    //
    protected $table = 'aud_notas';
    protected $primaryKey='id_notas';
    protected $fillable=['id_reporte','proceso','descripcion','id_clasificacion'];
    public function getClasificacion(){
        return $this->hasOne('App\SgcClasificacion','id_clasificacion','id_clasificacion');
    }
}
