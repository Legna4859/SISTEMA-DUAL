<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudAuditores extends Model
{
    //
    use SoftDeletes;
    protected $table='aud_auditores';
    protected $primaryKey='id_auditores';
    protected $fillable=['id_personal','id_categoria'];
    //
    public function getName(){
        return $this->hasMany('App\GnralPersonales','id_personal','id_personal');
    }
    public function getAbr(){
        return $this->hasMany('App\Abreviaciones_prof','id_personal','id_personal');
    }
}
