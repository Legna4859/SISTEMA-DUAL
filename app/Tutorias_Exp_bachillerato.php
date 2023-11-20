<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_bachillerato extends Model
{
    protected $table ="exp_bachillerato";
    protected $primaryKey="id_bachillerato";
    protected $fillable=["desc_bachillerato"];
}
