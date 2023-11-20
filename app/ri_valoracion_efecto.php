<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_valoracion_efecto extends Model
{
    //
    protected $table = 'ri_valoracion_efectos';
    protected $primaryKey='id_val_efecto';
    protected $fillable=['id_reg_riesgo','efecto','grado_impacto','probabilidad','cuadrante','ocurrencia_final','impacto_final'];

    public function getCuadrantei()
    {
        return ($this->grado_impacto >= 0&&$this->grado_impacto<=5)? (($this->probabilidad>=0&&$this->probabilidad<=5 )?3:2):(($this->probabilidad>=0&&$this->probabilidad<=5 )?4:1) ;

    }
    public function getCuadrantef()
    {

        return ($this->impacto_final >= 0&&$this->impacto_final<=5)? (($this->ocurrencia_final>=0&&$this->ocurrencia_final<=5 )?3:2):(($this->ocurrencia_final>=0&&$this->ocurrencia_final<=5 )?4:1) ;


    }

}