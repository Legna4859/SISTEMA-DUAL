<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Dual_Concentrados_Export;

class Dual_Excel extends Controller
{
   public function concentrado_calificaciones_materias($id_materia)
   {
       return Excel::download(new Dual_Concentrados_Export($id_materia), 'concentrado_calificaciones.xlsx');
   }
}