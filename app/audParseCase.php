<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class audParseCase extends Model
{
    public static function parseProceso($entrada){
        $entradas=["tesvb","Tesvb","sgc","Sgc"];
        $salidas=["TESVB","TESVB", "SGC", "SGC"];
        return str_replace($entradas,$salidas,ucfirst(mb_strtolower($entrada,'utf8')));
    }
    public static function parseNombre($entrada){
        $entradas=["A ","Para ","Con ","Desde ", "Y ", "De "];
        $salidas=["a ","para ","con ","desde ", "y ", "de "];
        return str_replace($entradas,$salidas,ucwords(mb_strtolower($entrada,'utf8')));
    }
    public static function parseAbr($entrada){
        $entradas=["EN "];
        $salidas=["en "];
        return utf8_decode(str_replace($entradas,$salidas,$entrada));
    }




    public static function parseProcesoPDF($entrada){
        $entradas=["tesvb","Tesvb","sgc","Sgc"];
        $salidas=["TESVB","TESVB", "SGC", "SGC"];
        return str_replace($entradas,$salidas,ucfirst(utf8_decode(mb_strtolower($entrada))));
    }
    public static function parseNombrePDF($entrada){
        $entradas=["A ","Para ","Con ","Desde ", "Y ", "De "];
        $salidas=["a ","para ","con ","desde ", "y ", "de "];
        return str_replace($entradas,$salidas,ucwords(utf8_decode(mb_strtolower($entrada))));
    }


    public static function toSpanish($text){
        if (strtolower($text)=='jan') return 'Enero';
        elseif (strtolower($text)=='feb') return 'Febrero';
        elseif (strtolower($text)=='mar') return 'Marzo';
        elseif (strtolower($text)=='apr') return 'Abril';
        elseif (strtolower($text)=='may') return 'Mayo';
        elseif (strtolower($text)=='jun') return 'Junio';
        elseif (strtolower($text)=='jul') return 'Julio';
        elseif (strtolower($text)=='aug') return 'Agosto';
        elseif (strtolower($text)=='sep') return 'Septiembre';
        elseif (strtolower($text)=='oct') return 'Octubre';
        elseif (strtolower($text)=='nov') return 'Noviembre';
        elseif (strtolower($text)=='dec') return 'Diciembre';
    }
}
