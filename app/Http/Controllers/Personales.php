<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\User;
use App\Personal;
class Personales extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personal=DB::select('select gnral_personales.id_personal, gnral_personales.nombre,gnral_personales.clave,gnral_personales.correo,gnral_personales.id_departamento from gnral_personales');
        

        foreach ($personal as $per)
         {
                if($per->id_departamento==0)
                {
                    $per->id_departamento="Sin permisos";
                }
                if($per->id_departamento!=0)
                {

                    $descripcion_depa=DB::selectone('select gnral_departamentos.nombre_departamento from gnral_departamentos where gnral_departamentos.id_departamento='.$per->id_departamento.'');
                    $per->id_departamento=$descripcion_depa->nombre_departamento;
                }

         }  
        return view('personal',compact('personal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       // dd($id);

         $personal=DB::select('select gnral_personales.id_personal, gnral_personales.nombre,gnral_personales.clave,gnral_personales.correo,gnral_personales.id_departamento from gnral_personales');
        

        foreach ($personal as $per)
         {
                if($per->id_departamento==0)
                {
                    $per->id_departamento="Sin permisos";
                }
                if($per->id_departamento!=0)
                {

                    $descripcion_depa=DB::selectone('select gnral_departamentos.nombre_departamento from gnral_departamentos where gnral_departamentos.id_departamento='.$per->id_departamento.'');
                    $per->id_departamento=$descripcion_depa->nombre_departamento;
                }

         }  

         $sss=DB::selectone('select gnral_personales.id_personal, gnral_personales.nombre,gnral_personales.clave,gnral_personales.correo,gnral_personales.id_departamento from gnral_personales where gnral_personales.id_personal='.$id.'');
        $combo=DB::select('select *from gnral_departamentos');
      
        return view('personal',compact('personal','combo'))->with(['edit'=>true,'consultaedit'=>$sss]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
           $datos = array(

      'id_departamento'=>$request->get('permiso'),


        );

       Personal::find($id)->update($datos);
       return redirect()->route('persona.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $usuario=DB::selectone('select gnral_personales.tipo_usuario from gnral_personales where gnral_personales.id_personal='.$id.'');
        $id_us=$usuario->tipo_usuario;


         Personal::destroy($id); 
         User::destroy($id_us);  


        return redirect()->route('personales.index');

    }
}
