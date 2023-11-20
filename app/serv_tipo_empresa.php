<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class serv_tipo_empresa extends Model
{
    protected $table = 'serv_tipo_empresa';
    protected $primaryKey='id_tipo_empresa';
    protected $fillable=['tipo_empresa'];
}
