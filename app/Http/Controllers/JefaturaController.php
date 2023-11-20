<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Gnral_Personales;
use App\Carreras;
use App\Gnral_Jefes_Periodos;
use Session;

class JefaturaController extends Controller
{

    public function index()
    {
        $id_periodo=Session::get('periodotrabaja');

        $periodo = DB::selectOne('select periodo from gnral_periodos where id_periodo='.$id_periodo.'');
        $periodo=($periodo->periodo);


        $jefaturas = DB::select('select gnral_jefes_periodos.id_jefe_periodo,gnral_carreras.nombre carrera, 
            gnral_personales.nombre, gnral_periodos.periodo ,gnral_jefes_periodos.tipo_cargo FROM 
            gnral_carreras,gnral_periodos,gnral_personales,gnral_jefes_periodos WHERE 
            gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera AND 
            gnral_jefes_periodos.id_personal=gnral_personales.id_personal AND 
            gnral_jefes_periodos.id_periodo=gnral_periodos.id_periodo AND
            gnral_periodos.id_periodo='.$id_periodo.'');
       
        $docentes = DB::table('gnral_personales')
        ->orderBy('nombre', 'asc')
        ->get();
        $carreras = Carreras::all();

       if(count($jefaturas)==0){


            $ultimo_periodo=DB::select('select id_periodo from gnral_jefes_periodos order by id_jefe_periodo desc LIMIT 1');
           
        foreach($ultimo_periodo as $ultimo_per)
            {
            $ultimo_p = array();
            $ultimo_p['id_periodo']= $ultimo_per->id_periodo;

            

          // $collection = ($ultimo_per->id_periodo)+1;
            //echo $collection;
            

        $consul = DB::select('select id_carrera,id_personal,tipo_cargo FROM gnral_jefes_periodos WHERE id_periodo='.$ultimo_per->id_periodo.'');
        $datos_consul=array();
        
            foreach($consul as $consulta)
             {
            $nombre=array();
            $nombre['id_carrera']= $consulta->id_carrera;
            $nombre['id_personal']= $consulta->id_personal;
            $nombre['tipo_cargo']= $consulta->tipo_cargo;
            $nombre['id_periodo']=($ultimo_per->id_periodo)+1;

            $agrega_jefe=Gnral_Jefes_Periodos::create($nombre);


            //$insert=DB::insert('insert into gnral_jefes_periodos (id_carrera,id_personal,tipo_cargo,id_periodo) values
             //('.$consulta->id_carrera.','.$consulta->id_personal.','.$consulta->tipo_cargo.','.$id_periodo.'');
        
          
        }}
        $jefaturas = DB::select('select gnral_jefes_periodos.id_jefe_periodo,gnral_carreras.nombre carrera, 
            gnral_personales.nombre, gnral_periodos.periodo ,gnral_jefes_periodos.tipo_cargo FROM 
            gnral_carreras,gnral_periodos,gnral_personales,gnral_jefes_periodos WHERE 
            gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera AND 
            gnral_jefes_periodos.id_personal=gnral_personales.id_personal AND 
            gnral_jefes_periodos.id_periodo=gnral_periodos.id_periodo AND
            gnral_periodos.id_periodo='.$id_periodo.'');
     }

//dd($jefaturas);



    return view('generales.jefaturas',compact('jefaturas','docentes','carreras','periodo'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $id_periodo=Session::get('periodotrabaja');

        $this->validate($request,[
            'selectCarrera' => 'required',
            'selectPersonal' => 'required',
            'selectCargo' =>'required'
        ]);

        $jefes = array(
            'id_carrera' => $request->get('selectCarrera'),
            'id_personal' => $request->get('selectPersonal'),
            'id_periodo' => $id_periodo,
            'tipo_cargo' =>$request->get('selectCargo')
        );

        $agrega_jefe=Gnral_Jefes_Periodos::create($jefes);
        return redirect('/generales/jefaturas');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $id_periodo=Session::get('periodotrabaja');

        $periodo = DB::selectOne('select periodo from gnral_periodos where id_periodo='.$id_periodo.'');
        $periodo=($periodo->periodo);

        $jefaturas = DB::select('select gnral_jefes_periodos.id_jefe_periodo,gnral_carreras.nombre carrera, 
            gnral_personales.nombre, gnral_periodos.periodo ,gnral_jefes_periodos.tipo_cargo FROM 
            gnral_carreras,gnral_periodos,gnral_personales,gnral_jefes_periodos WHERE 
            gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera AND 
            gnral_jefes_periodos.id_personal=gnral_personales.id_personal AND 
            gnral_jefes_periodos.id_periodo=gnral_periodos.id_periodo AND
            gnral_periodos.id_periodo='.$id_periodo.'');
        $docentes = DB::table('gnral_personales')
        ->orderBy('nombre', 'asc')
        ->get();
        $carreras = Carreras::all();

        $jefe_edit = Gnral_Jefes_Periodos::find($id);
        return view('generales.jefaturas',compact('periodo','jefaturas','docentes','carreras'))->with(['edit' => true, 'jefe_edit' => $jefe_edit]);
    }

    public function update(Request $request, $id)
    {
       $id_periodo=Session::get('periodotrabaja');

        $this->validate($request,[
            'selectCarrera' => 'required',
            'selectPersonal' => 'required',
            'selectCargo' => 'required',
        ]);

        $jefes = array(
            'id_carrera' => $request->get('selectCarrera'),
            'id_personal' => $request->get('selectPersonal'),
            'id_periodo' => $id_periodo,
            'tipo_cargo' =>$request->get('selectCargo')
        );

       Gnral_Jefes_Periodos::find($id)->update($jefes);
        return redirect('/generales/jefaturas');
    }

    public function destroy($id)
    {
        Gnral_Jefes_Periodos::destroy($id);
        return redirect('/generales/jefaturas');
    }

   
//////////////////////////////////////////////////////////////////
   



}
