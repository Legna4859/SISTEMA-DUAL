<?php

namespace App\Http\Controllers;

use App\SgcProcesoAgenda;
use Illuminate\Http\Request;

class SgcProcesoAgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $datos=$_GET['arreglo'];
        for ($i=0;$i<sizeof($datos);$i++){
            $get=SgcProcesoAgenda::get()->where('id_proceso',$datos[$i]['proceso'])->where('id_agenda',$datos[$i]['agenda']);
            if($get->isNotEmpty()){
                dd('existen');
            }
            else{
                $procAgenda=array(
                    'id_proceso' => $datos[$i]['proceso'],
                    'id_agenda' => $datos[$i]['agenda']
                );
                SgcProcesoAgenda::create($procAgenda);
            }
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
