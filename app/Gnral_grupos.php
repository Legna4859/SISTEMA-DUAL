<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gnral_grupos extends Model
{
    protected $table = 'gnral_grupos';
    protected $primaryKey='id_grupo';
    protected $fillable=['grupo'];
}
