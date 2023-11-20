<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcObjetivos extends Model
{
    //
    protected $table = "aud_objetivo";
    protected $primaryKey = "id_objetivo";
    protected $fillable = ["descripcion"];
}
