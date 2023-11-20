<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class In_voucher_pago extends Model
{
    protected $table = 'in_voucher_pago';
    protected $primaryKey = 'id_voucher';
    protected $fillable = [
        'id_usuario',
        'voucher',
        'linea_captura',
        'fecha_cambio',
        'id_estado_carga_voucher',
        'id_estado_valida_voucher',
        'id_periodo_ingles',
        'num_veces_usado',
        'in_tipo_voucher',
        'comentario'
    ];
}