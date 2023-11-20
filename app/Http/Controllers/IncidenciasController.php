<?php

namespace App\Http\Controllers;
use App\Incidencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;
use App\Inc_solicitude;

class IncidenciasController extends Controller
{
    
    public function vista()
    { 
        $articulos= DB::select('SELECT * from inc_articulos ORDER by nombre_articulo ASC');
       // dd($articulos);

       $id_usuario = Session::get('usuario_alumno');
       $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
       $id_personal = $id_personal->id_personal;
        $id_periodo = Session::get('periodotrabaja');
        $estado_profesor = DB::SelectOne('SELECT COUNT(gnral_personales.id_personal) contar 
        from gnral_personales, gnral_horarios, gnral_periodo_carreras WHERE 
        gnral_horarios.id_personal = gnral_personales.id_personal AND 
        gnral_horarios.id_periodo_carrera = gnral_periodo_carreras.id_periodo_carrera AND gnral_personales.id_personal = '.$id_personal.' 
        AND gnral_periodo_carreras.id_periodo = '.$id_periodo.'');
        //dd($estado_profesor);
        if($estado_profesor->contar == 0){
            $estado_profesor=0;
            $array_carreras=0;
        }else
        {
            $estado_profesor=1;
            $carreras = DB::Select('SELECT gnral_periodo_carreras.id_carrera
            from gnral_personales, gnral_horarios, gnral_periodo_carreras WHERE 
            gnral_horarios.id_personal = gnral_personales.id_personal AND 
            gnral_horarios.id_periodo_carrera = gnral_periodo_carreras.id_periodo_carrera AND gnral_personales.id_personal='.$id_personal.' 
            AND gnral_periodo_carreras.id_periodo ='.$id_periodo.'');
            $array_carreras=array();
            
            foreach($carreras as $carrera){
                //
                $titulo=DB::SelectOne('SELECT abreviaciones.titulo as titulo
                FROM abreviaciones_prof, abreviaciones 
                where  abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                and id_personal='.$id_personal.'');
                $nombre_jefe=DB::SelectOne('SELECT gnral_personales.id_personal,gnral_personales.nombre
                FROM gnral_personales, gnral_jefes_periodos WHERE gnral_jefes_periodos.id_personal=gnral_personales.id_personal 
                AND gnral_jefes_periodos.id_carrera='.$carrera->id_carrera.' and gnral_jefes_periodos.id_periodo='.$id_periodo.'');
            $dat['id_personal']=$nombre_jefe->id_personal;
            $dat['nombre']=$nombre_jefe->nombre;
            
           
            array_push($array_carreras, $dat);
            }

        }
    return view('incidencias.agregar', compact('articulos', 'estado_profesor', 'array_carreras','titulo'));
    }
    
    //////////////agregar evidencia
    public function vista2($id_evid)
    {
    
        $tipo_evidencia= DB::select('SELECT * from inc_tipo_evidencia ORDER by nombre_evidencia ASC');
        $evidencia = DB::selectOne('SELECT * FROM `inc_evidencias` WHERE id_evid='.$id_evid.'');
         return view('incidencias.cargar_evidencia', compact ('tipo_evidencia','evidencia'));
    
    }
    public function vista2_1()
    {
        $tipo_evidencia= DB::select('SELECT * from inc_tipo_evidencia ORDER by nombre_evidencia ASC');
        $evidencia = DB::selectOne('SELECT * FROM `inc_evidencias`');
        return view('incidencias.cargar_evidencia_otra', compact ('tipo_evidencia','evidencia'));
    }
    

    public function vista3(){
        $solicitud = DB::table ('inc_solicitudes')
        ->join('inc_articulos','inc_solicitudes.id_articulo','=','inc_articulos.id_articulo')
        ->join('gnral_personales','inc_solicitudes.id_personal','=','gnral_personales.id_personal')
        ->select('inc_solicitudes.*', 'inc_articulos.*', 'gnral_personales.*') 
        ->orderBy('inc_solicitudes.id_solicitud','DESC')
        ->get();
        return view('incidencias.historial_oficio', compact('solicitud'));
        /*$usuario=DB:: table('user')*/  
    }

    public function vistaevidencias(){
        $evid= DB::table('inc_evidencias')   
        ->join('inc_tipo_evidencia', 'inc_tipo_evidencia.id_tipo_evid','=','inc_evidencias.id_tipo_evid')
        ->join('inc_solicitudes', 'inc_solicitudes.id_solicitud','=','inc_evidencias.id_solicitud')
        ->join('gnral_personales','inc_evidencias.id_personal','=','gnral_personales.id_personal')
        ->join('inc_articulos', 'inc_articulos.id_articulo','=','inc_solicitudes.id_articulo')
        ->select('inc_evidencias.*','inc_solicitudes.*', 'inc_articulos.*', 'gnral_personales.nombre','inc_tipo_evidencia.nombre_evidencia')
        ->orderBy('inc_evidencias.id_evid','DESC')
        ->get();
        $evidencias=DB::select('SELECT e.*, p.nombre, te.nombre_evidencia 
        FROM inc_evidencias as e, gnral_personales as p, inc_tipo_evidencia as te
         WHERE e.id_personal=p.id_personal and e.id_solicitud IS null AND e.id_tipo_evid=te.id_tipo_evid ORDER BY e.id_evid DESC');
        //dd($evidencias);

        return view('incidencias.historial_evidencias', compact('evid','evidencias'));
        /*$usuario=DB:: table('user')*/  
    }
    ///////VISTA REPORTES INCIDENCIAS//////
    public function vista4(){
        
        $articulos= DB::select('SELECT * from inc_articulos ORDER by nombre_articulo ASC');
        $estado=0;
        
        return view('incidencias.reportes_quincenales', compact('articulos','estado'));

    }
    public function vista5(){
        $id_usuario = Session::get('usuario_alumno');
        $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
        $id_personal = $id_personal->id_personal;
        $titulo=DB::SelectOne('SELECT abreviaciones.titulo as titulo
                FROM abreviaciones_prof, abreviaciones 
                where  abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                and id_personal='.$id_personal.'');
        $solicitudes = DB:: table ('inc_solicitudes')
        ->join('inc_articulos','inc_solicitudes.id_articulo','=','inc_articulos.id_articulo')
        ->join('gnral_personales','inc_solicitudes.id_personal','=','gnral_personales.id_personal')
        ->select('inc_solicitudes.*', 'inc_articulos.*', 'gnral_personales.*')
        ->orderBy('inc_solicitudes.id_solicitud','DESC')   
        ->get();
       return view('incidencias.validar_oficios', compact('solicitudes','id_personal'));
    }
    public function vista6(){
        $id_usuario = Session::get('usuario_alumno');
        $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
        $id_personal = $id_personal->id_personal;

        $histSol = DB:: table ('inc_solicitudes')
        ->join ('inc_articulos', 'inc_solicitudes.id_articulo','=','inc_articulos.id_articulo')
        ->select('inc_solicitudes.*', 'inc_articulos.*')
        ->get();

        return view('incidencias.historial_docentesSo', compact ('histSol','id_personal'));
    }
    public function vista7(){
        $id_usuario = Session::get('usuario_alumno');
        $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
        $id_personal = $id_personal->id_personal;
        $histEvi = DB:: table ('inc_evidencias')
        ->join ('inc_tipo_evidencia', 'inc_evidencias.id_tipo_evid','=','inc_tipo_evidencia.id_tipo_evid')
        ->select('inc_evidencias.*', 'inc_tipo_evidencia.*')
        ->get();
 
        return view('incidencias.historial_docentesEv', compact ('histEvi','evidencia','id_personal'));
    }
    public function vista8(){
        $id_usuario = Session::get('usuario_alumno');
        $id_personal=DB::selectOne('SELECT * FROM `gnral_personales` WHERE `tipo_usuario` ='.$id_usuario.'');
        $id_personal=$id_personal->id_personal;
        $eviden= DB::table('inc_evidencias')
        ->join('inc_solicitudes', 'inc_solicitudes.id_solicitud','=','inc_evidencias.id_solicitud')
        ->join('inc_articulos', 'inc_articulos.id_articulo','=','inc_solicitudes.id_articulo')
            ->where('inc_evidencias.id_personal','=',$id_personal)
        ->select( 'inc_evidencias.*','inc_solicitudes.*', 'inc_articulos.*')
        ->orderBy('inc_evidencias.id_evid','DESC')
        ->get();

        $fechaact = date('Y-m-d');
    
        return view('incidencias.articulos_evidencia',compact('eviden','fechaact'));
    }
    /*public function articulos_evidencia(Request $request){
        
        return view('incidencias.articulos_evidencia', compact('eviden'));


    }*/

    public function guardar_evidencia(Request $request, $id_evid)
{ 
    //dd($request);
    $file=$request->file('arch_evidencia');
    $id_tipo_evid=$request->input('id_tipo_evid');
    $name="evidencia_incidencia_".$id_evid.".".$file->getClientOriginalExtension();
    $file->move(public_path().'/incidencias/', $name);
        
        DB::table('inc_evidencias')->where('id_evid', $id_evid)
        ->update([
            'id_tipo_evid' => $id_tipo_evid,
            'arch_evidencia' => $name,  
        ]);
    //dd($id_evid, $name, $id_tipo_evid);
    return redirect('/incidencias/editar_evidencia/'.$id_evid);
}
    public function reportes_incidencias_ver(Request $request){
        
        $id_usuario = Session::get('usuario_alumno');
        $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
        $id_personal = $id_personal->id_personal;
        $arti=$request->input ('id_articulo');
        $desd_fecha=$request->input('id_desd_fech');
        $hast_fecha=$request->input('id_hast_fech');
        $estado=1;

        //dd($arti);
        ///////variables de sesión////////
        Session::put('id_articulo_solicitud',$arti);
        Session::put('id_desd_fech_solicitud',$desd_fecha);
        Session::put('id_hast_fech_solicitud',$hast_fecha);
        
        $articulos= DB::select('SELECT * from inc_articulos ORDER by nombre_articulo ASC');
        $fecha=DB::select("SELECT inc_articulos.nombre_articulo, gnral_personales.nombre, inc_solicitudes.fecha_req, inc_solicitudes.id_solicitud from 
        inc_solicitudes,inc_articulos, gnral_personales 
        where inc_solicitudes.id_articulo=inc_articulos.id_articulo and inc_solicitudes.id_personal=gnral_personales.id_personal 
        and fecha_req>='$desd_fecha' and fecha_req<= '$hast_fecha' 
        and inc_solicitudes.id_articulo='$arti'");

        $todos=DB::select("SELECT inc_articulos.nombre_articulo, gnral_personales.nombre, inc_solicitudes.fecha_req, inc_solicitudes.id_solicitud from 
        inc_solicitudes,inc_articulos, gnral_personales 
        where inc_solicitudes.id_articulo=inc_articulos.id_articulo and inc_solicitudes.id_personal=gnral_personales.id_personal 
        and fecha_req>='$desd_fecha' and fecha_req<= '$hast_fecha' 
        ORDER BY `inc_solicitudes`.`id_articulo` ASC");
        //dd($fecha);
        return view('incidencias.reportes_quincenales', compact('fecha','articulos','estado','arti', 'desd_fecha','hast_fecha','todos'));
        

    }
    public function index(){
        $historial = DB::table('inc_solicitudes')->paginate(10);
        return view ('inc_solicitudes.index',['historial'=> $historial]);
    }
    public function guardar_mod_evidencia(Request $request, $id_evid){
        $documento=$request->file('arch_evidencia');
        $id_tipo_evid=$request->input('id_tipo_evid');
        $name="evidencia_incidencia_".$id_evid.".".$documento->getClientOriginalExtension();
        $documento->move(public_path().'/incidencias/', $name);

        $id_usuario = Session::get('usuario_alumno');
        $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
        $id_personal = $id_personal->id_personal;
    
            DB::table('inc_evidencias')->where('id_evid', $id_evid)
            ->update([
                'id_tipo_evid' => $id_tipo_evid,
                'arch_evidencia' => $name,  
                'id_personal' =>$id_personal,
            ]);
         return redirect('/incidencias/editar_evidencia/'.$id_evid);
    }
    public function guardar_incidencia_solicitada(Request $request){
        //dd($request);
        $id_usuario = Session::get('usuario_alumno');
        $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
        $id_personal = $id_personal->id_personal;
        $id_estado_solicitud="1";
        
        //dd($estado_profesor);
       $id_articulo = $request->input('id_articulo');
       $estado_profesor = $request->input('estado_profesor');
       if($estado_profesor==0){
        $id_pers = DB::SelectOne('SELECT *FROM `adscripcion_personal` WHERE id_personal='.$id_personal.'');
        ///dd($id_pers);
        $id_jefe= DB::SelectOne('SELECT * FROM `gnral_unidad_personal` WHERE `id_unidad_persona` ='.$id_pers->id_unidad_persona.'') ;
        //dd($id_unidad_persona);
        $id_jefe_finan = DB::SelectOne('SELECT * FROM `gnral_unidad_personal` WHERE `id_unidad_admin` = 22 '); 
        $id_jefe_a=$id_jefe_finan->id_personal;
        $id_jefe=$id_jefe->id_personal;
       }
       else{
        $id_jefe_academ = DB::SelectOne('SELECT * FROM `gnral_unidad_personal` WHERE `id_unidad_admin` = 5 '); 
        $id_jefe_a=$id_jefe_academ->id_personal;
        $id_jefe = $request->input('id_jefe');
        
       }
       //////////articulo 56///////////////
        if($id_articulo ==2){
        $fecha_req = $request->input('fecha_req');
        $motivo_oficio = $request->input('motivo_oficio');
        
        //$usuario = DB::select("Consulta de usuario logeado");
        $id_solicitud=Inc_solicitude::create([
            'id_articulo' => $id_articulo,
            'fecha_req' => $fecha_req,
            'motivo_oficio' => $motivo_oficio,  
            'id_personal' =>$id_personal,
            'id_jefe' =>$id_jefe,
            'id_estado_solicitud'=>$id_estado_solicitud,
        ]);

        $id_solicitud=$id_solicitud->id;
        DB::table('inc_evidencias')->insert([
            'id_solicitud' => $id_solicitud,  
            'id_personal' =>$id_personal,
            'id_jefe' =>$id_jefe,
        ]);
        }
        //////articulo 61///////////////
        if($id_articulo ==4){
            $fecha_req = $request->input('fecha_req');
            $motivo_oficio = $request->input('motivo_oficio');


            $id_solicitud=Inc_solicitude::create([
                'id_articulo' => $id_articulo,
                'fecha_req' => $fecha_req,
                'motivo_oficio' => $motivo_oficio,
                'id_personal' =>$id_personal,
                'id_estado_solicitud'=>$id_estado_solicitud,
                'id_jefe' =>$id_jefe,
            ]);
            $id_solicitud=$id_solicitud->id;
            DB::table('inc_evidencias')->insert([
                'id_solicitud' => $id_solicitud,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
            ]);
        }
        ////////////////articulo 64/////////////
        if($id_articulo ==5){
            $fecha_req=$request->input('fecha_req');
            $motivo_oficio = $request->input('motivo_oficio');
            $hora_e=$request->input('hora_e');
            $hora_st=$request->input('hora_st');

            $id_solicitud=Inc_solicitude::create([
                'id_articulo'=>$id_articulo,
                'fecha_req'=>$fecha_req,
                'motivo_oficio' => $motivo_oficio,
                'hora_e'=>$hora_e,
                'hora_st'=>$hora_st,
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
                'id_estado_solicitud'=>$id_estado_solicitud,
            ]); 
            $id_solicitud=$id_solicitud->id;
            DB::table('inc_evidencias')->insert([
                'id_solicitud' => $id_solicitud,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
            ]);
        }
        //////art68diaeconomico/////
        if($id_articulo ==6){
            $fecha_req=$request->input('fecha_req');
            $motivo_oficio = $request->input('motivo_oficio');

            $id_solicitud=Inc_solicitude::create([
                'id_articulo'=>$id_articulo,
                'fecha_req'=>$fecha_req,
                'motivo_oficio' => $motivo_oficio,
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
                'id_estado_solicitud'=>$id_estado_solicitud,
            ]); 
            $id_solicitud=$id_solicitud->id;
            DB::table('inc_evidencias')->insert([
                'id_solicitud' => $id_solicitud,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
            ]);
        } 
        /////////art 68 mediass jornadas//////////////
        if($id_articulo ==10){
            $fecha_req=$request->input('fecha_req');
            $motivo_oficio = $request->input('motivo_oficio');
            $hora_e1=$request->input('hora_e1');
            $hora_s1=$request->input('hora_s1');

            $id_solicitud=Inc_solicitude::create([
                'id_articulo'=>$id_articulo,
                'fecha_req'=>$fecha_req,
                'motivo_oficio' => $motivo_oficio,
                'hora_e1'=>$hora_e1,
                'hora_s1'=>$hora_s1,
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
                'id_estado_solicitud'=>$id_estado_solicitud,
                
            ]);
            $id_solicitud=$id_solicitud->id;
            DB::table('inc_evidencias')->insert([
                'id_solicitud' => $id_solicitud,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
            ]); 
        }
         /////////art 68 dia economico//////////////
         if($id_articulo ==7){
            $fecha_req=$request->input('fecha_req');
            $motivo_oficio = $request->input('motivo_oficio');
            
            $id_solicitud=Inc_solicitude::create([
                'id_articulo'=>$id_articulo,
                'fecha_req'=>$fecha_req,  
                'motivo_oficio' => $motivo_oficio,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe_a,
                'id_estado_solicitud'=>$id_estado_solicitud,
            ]); 
            $id_solicitud=$id_solicitud->id;
            DB::table('inc_evidencias')->insert([
                'id_solicitud' => $id_solicitud,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe_a,
            ]);
        }
        ///////////////art 73//////////
        if($id_articulo ==8){
            $fecha_req=$request->input('fecha_req');
            $fecha_invac=$request->input('fecha_invac');
            $fecha_tervac=$request->input('fecha_tervac');
            $motivo_oficio = $request->input('motivo_oficio');
            
            $id_solicitud=Inc_solicitude::create([
                'id_articulo'=>$id_articulo,
                'fecha_req'=>$fecha_req,
                'motivo_oficio' => $motivo_oficio,
                'fecha_invac'=>$fecha_invac,
                'fecha_tervac'=>$fecha_tervac,
                'id_personal' =>$id_personal,
                'id_estado_solicitud'=>$id_estado_solicitud,
                'id_jefe' =>$id_jefe,
            ]); 
            $id_solicitud=$id_solicitud->id;
            DB::table('inc_evidencias')->insert([
                'id_solicitud' => $id_solicitud,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
            ]);
        }
        ////art44 diaeconomico////
        if($id_articulo ==1){
            $fecha_req=$request->input('fecha_req');
            $motivo_oficio = $request->input('motivo_oficio');
            $id_solicitud=Inc_solicitude::create([
                'id_articulo'=>$id_articulo,
                'fecha_req'=>$fecha_req,
                'motivo_oficio' => $motivo_oficio,
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
                'id_estado_solicitud'=>$id_estado_solicitud,
            ]); 
            $id_solicitud=$id_solicitud->id;
            DB::table('inc_evidencias')->insert([
                'id_solicitud' => $id_solicitud,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
            ]);
        }
        ///////art 44 medias jornadas////
        if($id_articulo ==9){
            $fecha_req=$request->input('fecha_req');
            $motivo_oficio = $request->input('motivo_oficio');
            $hora_e2=$request->input('hora_e2');
            $hora_s2=$request->input('hora_s2');

            $id_solicitud=Inc_solicitude::create([
                'id_articulo'=>$id_articulo,
                'fecha_req'=>$fecha_req,
                'motivo_oficio' => $motivo_oficio,
                'hora_e2'=>$hora_e2,
                'hora_s2'=>$hora_s2,
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
                'id_estado_solicitud'=>$id_estado_solicitud,
                //////a
            ]); 
            $id_solicitud=$id_solicitud->id;
            DB::table('inc_evidencias')->insert([
                'id_solicitud' => $id_solicitud,  
                'id_personal' =>$id_personal,
                'id_jefe' =>$id_jefe,
            ]);
        } 
        return Redirect::to('/incidencias/historial_docentesSo');
        }

    public function guardar_otra_evidencia(Request $request)
    { 
    $maximo= DB::selectOne('select max(id_evid) maximo FROM inc_evidencias'); 
  
    if($maximo->maximo==null){
     $maximo=1;
    
    }else{
        $maximo= $maximo->maximo+1;
    }
    $file=$request->file('arch_evidencia');
   
    $documento=$request->file('arch_evidencia');
    $id_tipo_evid=$request->input('id_tipo_evid');
    $name="evidencia_incidencia_".$maximo.".".$file->getClientOriginalExtension();
    $file->move(public_path().'/incidencias/', $name);
    $id_usuario = Session::get('usuario_alumno');
    $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
    $id_personal = $id_personal->id_personal;

        DB::table('inc_evidencias')->insert([
            'id_evid'=>$maximo,
            'id_personal'=>$id_personal,
            'id_tipo_evid' => $id_tipo_evid,
            'arch_evidencia' => $name,  
        ]);
     return redirect('/incidencias/editar_evidencia/'.$maximo);
    }



    public function editar_evidencia ($id_evid){
    
    $evidencia= DB::selectOne('select inc_evidencias.*,inc_tipo_evidencia.nombre_evidencia FROM inc_tipo_evidencia, inc_evidencias WHERE inc_evidencias.id_tipo_evid = inc_tipo_evidencia.id_tipo_evid AND inc_evidencias.id_evid='.$id_evid);
    //dd($maximo);
    return view('incidencias.editar_evidencia',compact ('evidencia'));
}
public function modificar_evidencia($id_evid){
    $evidencia= DB::selectOne('select inc_evidencias.*,inc_tipo_evidencia.nombre_evidencia FROM inc_tipo_evidencia, inc_evidencias WHERE inc_evidencias.id_tipo_evid = inc_tipo_evidencia.id_tipo_evid AND inc_evidencias.id_evid='.$id_evid);
    $tipo_evidencia= DB::select('SELECT * from inc_tipo_evidencia ORDER by nombre_evidencia ASC');
    dd($evidencia);
    return view('incidencias.partials_mod_evidencia',compact('evidencia','tipo_evidencia'));
}


public function consultar_jefes(){
    $id_usuario = Session::get('usuario_alumno');
    $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
    $id_personal = $id_personal->id_personal;
    $id_periodo = Session::get('periodotrabaja');
    $carreras = DB::Select('SELECT gnral_periodo_carreras.id_carrera
    from gnral_personales, gnral_horarios, gnral_periodo_carreras WHERE 
    gnral_horarios.id_personal = gnral_personales.id_personal AND 
    gnral_horarios.id_periodo_carrera = gnral_periodo_carreras.id_periodo_carrera AND gnral_personales.id_personal='.$id_personal.' 
    AND gnral_periodo_carreras.id_periodo ='.$id_periodo.'');
    $array_carreras=array();
    
    foreach($carreras as $carrera){
        $nombre_jefe=DB::SelectOne('SELECT gnral_personales.id_personal,gnral_personales.nombre 
        FROM gnral_personales, gnral_jefes_periodos WHERE gnral_jefes_periodos.id_personal=gnral_personales.id_personal 
        AND gnral_jefes_periodos.id_carrera='.$carrera->id_carrera.' and gnral_jefes_periodos.id_periodo='.$id_periodo.'');
    $dat['id_personal']=$nombre_jefe->id_personal;
    $dat['nombre']=$nombre_jefe->nombre;
    array_push($array_carreras, $dat);
    }
    return $array_carreras;

}
public function aceptadojefe($id_solicitud_oficio){
    DB::update('UPDATE `inc_solicitudes` SET `id_estado_solicitud` = 2 WHERE `inc_solicitudes`.`id_solicitud` = '.$id_solicitud_oficio.'');
    return redirect('/incidencias/validar_oficios/historial');
}
public function rechazadojefe($id_solicitud_oficio){
    DB::update('UPDATE `inc_solicitudes` SET `id_estado_solicitud` = 3 WHERE `inc_solicitudes`.`id_solicitud` = '.$id_solicitud_oficio.'');
    return redirect('/incidencias/validar_oficios');
}
public function enviadojefe($id_solicitud_oficio){
    DB::update('UPDATE `inc_solicitudes` SET `id_estado_solicitud` = 4 WHERE `inc_solicitudes`.`id_solicitud` = '.$id_solicitud_oficio.'');
    DB::update('UPDATE `inc_solicitudes` SET `directora` = 274  WHERE `inc_solicitudes`.`id_solicitud` = '.$id_solicitud_oficio.'');
    return redirect('/incidencias/validar_oficios');
}

public function validacion_historial(){
    $id_usuario = Session::get('usuario_alumno');
    $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
    $id_personal = $id_personal->id_personal;
    //dd($id_personal);
    $solicitudes = DB:: table ('inc_solicitudes')
    ->join('inc_articulos','inc_solicitudes.id_articulo','=','inc_articulos.id_articulo')
    ->join('gnral_personales','inc_solicitudes.id_personal','=','gnral_personales.id_personal')
    ->select('inc_solicitudes.*', 'inc_articulos.*', 'gnral_personales.*') 
    ->orderBy('inc_solicitudes.id_solicitud','DESC')   
    ->get();
    ///dd($solicitudes);
    return view('incidencias.validacion_historial',compact('solicitudes', 'id_personal'));
}
public function ver($id_oficio){
    //mostar la solicitud por comisionado

    $oficios=DB::selectOne('select gnral_personales.nombre, inc_solicitudes.*,inc_articulos.* 
    FROM inc_solicitudes, inc_articulos, gnral_personales
    WHERE inc_solicitudes.id_personal=gnral_personales.id_personal and inc_solicitudes.id_articulo=inc_articulos.id_articulo and id_solicitud='.$id_oficio.'');

    return view('incidencias.modal_ver',compact('oficios'));
}
public function validar_articulos($id_articulo){
    $id_usuario = Session::get('usuario_alumno');
    $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
    $id_personal = $id_personal->id_personal;
    $articulo=$id_articulo;

    $anio=DB::SelectOne('SELECT p.nombre, (YEAR(NOW())-p.fch_ingreso_tesvb ) as anios_tesvb
    from gnral_personales as p where p.id_personal='.$id_personal.'');
    $estado='2';
    $s_enviada=DB::SelectOne('SELECT COUNT(s.id_articulo) as solicitudes 
    from inc_solicitudes as s, inc_articulos as a, gnral_personales as p 
    where s.id_articulo=a.id_articulo and s.id_articulo='.$articulo.' 
    and p.id_personal=s.id_personal and p.id_personal='.$id_personal.' and s.id_estado_solicitud='.$estado.'');
    
    $validacion_art=DB::selectOne('SELECT * FROM inc_articulos WHERE inc_articulos.id_articulo='.$id_articulo.'');
    
    if($validacion_art->id_articulo==1 || $validacion_art->id_articulo==6){
        if($anio->anios_tesvb>= '1' && $anio->anios_tesvb<='9'){
            $dias_dis = '4';
        }else{
            if($anio->anios_tesvb> '9'  && $anio->anios_tesvb<='15'){
                $dias_dis = '5';
            }else{
                if($anio->anios_tesvb>'15'){
                    $dias_dis='6';
                }
            }
        }
        $estado=$dias_dis-$s_enviada->solicitudes;
    }else{
        if($validacion_art->id_articulo==9 || $validacion_art->id_articulo==10){
            $dias_art='4';
            $estado=$dias_art-$s_enviada->solicitudes;
        }else{
            $estado='1';
        }     
    }
    return($estado);
}

public function vista2oficio($id_solicitud)
{
    $oficio = DB::selectOne('SELECT * FROM `inc_solicitudes` WHERE id_solicitud='.$id_solicitud.'');
    return view('incidencias.cargar_oficio', compact ('oficio'));
}

public function guardar_oficio(Request $request, $id_oficio)
{ 
    $file=$request->file('arch_solicitud');
    $name="evidencia_oficio_".$id_oficio.".".$file->getClientOriginalExtension();
    $file->move(public_path().'/incidencias_oficios/', $name);
        
        DB::table('inc_solicitudes')->where('id_solicitud', $id_oficio)
        ->update([
            'arch_solicitud' => $name,  
        ]);   
 return redirect('/incidencias/historial_docentesSo');
}
public function  notificaciones() {
    $id_usuario = Session::get('usuario_alumno');
    $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
    $id_personal = $id_personal->id_personal;
    $num=1;
    $noti=DB::selectOne('SELECT COUNT(id_jefe) as contador FROM inc_solicitudes WHERE inc_solicitudes.id_jefe='.$id_personal.' and inc_solicitudes.id_estado_solicitud='.$num.'');

    return response()->json($noti);

}
public function  notificacionesacep() {
    $id_usuario = Session::get('usuario_alumno');
    $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
    $id_personal = $id_personal->id_personal;
    $num=2;
    $noti=DB::selectOne('SELECT COUNT(id_personal) as contador FROM inc_solicitudes 
    WHERE inc_solicitudes.id_personal='.$id_personal.' and inc_solicitudes.id_estado_solicitud='.$num.' and inc_solicitudes.arch_solicitud IS null');

    return response()->json($noti);

}
}
