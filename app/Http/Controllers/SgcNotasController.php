<?php

namespace App\Http\Controllers;

use App\SgcNotas;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SgcNotasController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'proceso' => 'required',
            'descripcion' => 'required',
            'clasificacion' => 'required',
        ]);
        if($validator->fails()){
//            dd($validator->errors());
            Session::put('errors',$validator->errors());
            return redirect()->back();
        }

        $nota= array(
            'id_reporte' => Session::get('id_reporte'),'utf-8',
            'proceso' => $request->get('proceso'),'utf-8',
            'descripcion' => $request->get('descripcion'),'utf-8',
            'id_clasificacion' => $request->get('clasificacion'),'utf-8',
        );
        SgcNotas::create($nota);
        Session::forget('errors');
        return back();
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
