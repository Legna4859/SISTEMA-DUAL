<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class riEstrategia extends Model
{
    //
    use SoftDeletes;

    protected $table = 'ri_estrategia';
    protected $primaryKey='id_estrategia';
    protected $fillable=['descripcion'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}
