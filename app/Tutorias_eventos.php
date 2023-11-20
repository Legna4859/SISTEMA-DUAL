<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_eventos extends Model
{
    protected $table ="eventos";
    protected $primaryKey="id_evento";
    public $timestamps=false;
    protected $fillable=["titulo_evento","desc_evento","fecha","hora"];
}
