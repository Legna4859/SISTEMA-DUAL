<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $table = 'eva_tutor';
    protected $primaryKey='id_tutor';
    protected $fillable=[

      'id_alumno',
      'nombre',
      'ap_paterno_T',
      'ap_mat_T',
      'puesto',
      'parentezco',
      'fecha_nac_T',
      'edad',
      'genero',
      'edo_civil_t',
      'grado_est_t',
      'nacionalidad_t',
      'curp',
      'correo_t',
      'twitter_t',
      'facebook_t',
      'cel_t',
      'tel_fijo_t',
      'estado_T',
      'municipio_T',
      'calle',
      'n_ext_t',
      'n_int_t',
      'entre_calle_t',
      'y_calle_t',
      'otra_ref_t',
      'cp_t',
      'colonia_t',
      'localidad_t'
      ];
}
