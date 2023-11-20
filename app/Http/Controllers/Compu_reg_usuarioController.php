<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
class Compu_reg_usuarioController extends Controller
{
    public function index(){
    return view('centro_computo.registrar_usuarios.registrar_usuario');
    }
    public function registro_datos_estudiante_excel(Request $request){
        if($request->hasFile('excel_registro'))
        {
            $path = $request->file('excel_registro')->getRealPath();
            $datos = Excel::load($path,function ($reader){

            })->get();


        }
       // dd($datos);
        $dat=array();
        foreach ($datos as $dato){
            $tipo = gettype($dato->no_cuenta);
            if($tipo == "double"){
                $da['no_cuenta'] =intval($dato->no_cuenta);
            }else{
                $da['no_cuenta'] =$dato->no_cuenta;
            }
          $da['nombre'] =$dato->nombre;
          $da['grupo'] =$dato->grupo;
          $estado= DB::selectOne("SELECT COUNT(id) contar FROM `users` WHERE `email` = '$dato->usuario'");
          $estado=$estado->contar;
          if($estado == 0){
              $estado =0;
              $da['estado'] =0;
          }else{
              $estado=1;
              $da['estado'] =1;
          }
            $da['usuario'] =$dato->usuario;
            $da['contrasena'] =$dato->contrasena;

          array_push($dat,$da);
        }
        foreach ($dat as $dat){
            if($dat['estado'] == 0){
                User::create([
                    //'name' => $data['name'],
                    'email' => $dat['usuario'],
                    'password' => bcrypt($dat['contrasena']),
                    'tipo_usuario' => 1
                ]);
            }

        }
        return back();


    }
}
