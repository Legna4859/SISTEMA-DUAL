<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Carreras;
use App\Alumnos;
use App\Estados;
use App\Municipios;
use App\Semestres;
use App\Tutor;
use App\User;
use Session;


class datos_alumno extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $usuario = Session::get('usuario_alumno');
        $correo=DB::selectOne('select users.email from users where users.id='.$usuario.'');
        $carreras=Carreras::all();
        $estados_alu=Estados::all();
        $estados_tutor=Estados::all();
        $municipios=Municipios::all();
        $entidadnac=Estados::all();

        $respuesta=DB::select('select *from oc_respuesta');
        $respuestass=DB::select('select *from oc_respuesta');
        $seguro=DB::select('select *from gnral_seguro_social');
        $grados=DB::select('select *from gnral_grados');

        ///////////////////////////verificar si el alumno es la primera vez que llenara sus datos

        $sesion=DB::selectOne('select count(gnral_alumnos.id_alumno) alumno from gnral_alumnos WHERE gnral_alumnos.id_usuario="'.$usuario.'"');
        $datos_u=DB::selectOne('select users.email from users WHERE users.id="'.$usuario.'"');
        //  dd($usuario);
        if($sesion->alumno ==0)
        {
            $añoactual=DB::selectOne('select CURDATE() year');
            $año=$añoactual->year;


            $array=array('id_usuario'=>$usuario,
                'correo_al'=>$correo->email,
                'fecha_nac'=>$año);

            Alumnos::create($array);
            $dat_alumno=DB::selectOne('select gnral_alumnos.id_alumno from gnral_alumnos WHERE gnral_alumnos.id_usuario="'.$usuario.'"');
            $id_alumno=$dat_alumno->id_alumno;
            $array=array('id_alumno'=>$id_alumno,'fecha_nac_T'=>$año);
            Tutor::create($array);
            $existe=0;
        }
        else{

            $existe=1;
        }

///////////////////////////////traer datos del alumno//////////////////////////////////////////
        $datos=DB::selectOne('select *from gnral_alumnos WHERE gnral_alumnos.id_usuario='.$usuario.'');

        //*CCT*/
        $estado_institucion= DB::selectOne('SELECT COUNT(id_institucion) contar from gnral_alumnos where id_usuario = '.$usuario.' and id_institucion =0');

        if($estado_institucion->contar == 1){
            $estado_institucion =1;
            $escuelas=DB::select('SELECT * FROM `gnral_instituciones_edu` ORDER BY `cct` ASC');
            return view('evaluacion_docente.Alumnos.cct',compact('escuelas','datos'));
        }else{
            $estado_institucion =2;
            $id_institucion=$datos->id_institucion;
            $institucion=DB::selectOne('SELECT * FROM `gnral_instituciones_edu` where id_institucion ='.$id_institucion.'');
            //dd($institucion);

        }


        $tut=DB::selectOne('select count(id_tutor) tutor from eva_tutor where eva_tutor.id_alumno='.$datos->id_alumno.'');

        $datos_t=DB::selectOne('select *from eva_tutor where eva_tutor.id_alumno='.$datos->id_alumno.'');

        if($tut->tutor==0)
        {
            $dat_alumno=DB::selectOne('select gnral_alumnos.id_alumno from gnral_alumnos WHERE gnral_alumnos.id_usuario="'.$usuario.'"');
            $id_alumno=$dat_alumno->id_alumno;
            //dd($id_alumno);

            $añoactual=DB::selectOne('select CURDATE() year');
            $año=$añoactual->year;
            $array=array('id_alumno'=>$id_alumno,'fecha_nac_T'=>$año);
            Tutor::create($array);
        }
        $datos_t=DB::selectOne('select *from eva_tutor where eva_tutor.id_alumno='.$datos->id_alumno.'');

        $fecha=$datos->fecha_nac;
        $fecha= explode("-", $fecha);
        //dd($fecha);
        $año=$fecha[0];

        $mes=$fecha[1];
        $dia=$fecha[2];
        $fecha=$dia."/".$mes."/".$año;
        $datos->fecha_nac=$fecha;
        //////////////////fecha tutor
        $fechat=$datos_t->fecha_nac_T;
        $fechat= explode("-",$fechat);
        $añot=$fechat[0];
        $mest=$fechat[1];
        $diat=$fechat[2];
        $fechat=$diat."/".$mest."/".$añot;
        $datos_t->fecha_nac_T=$fechat;

        $dat=DB::selectOne('select count(id_carrera) carrera from gnral_alumnos WHERE gnral_alumnos.id_usuario='.$usuario.'');
        $dat=$dat->carrera;
        $escuelas = DB::table('gnral_escuela_procedencia')
            ->select('gnral_escuela_procedencia.*')
            ->orderBy('gnral_escuela_procedencia.nombre_escuela', 'ASC')
            ->orderBy('gnral_escuela_procedencia.estado', 'ASC')
            ->orderBy('gnral_escuela_procedencia.municipio', 'ASC')
            ->get();
        if($datos->edad == null){
           $f_nac=0;
        }
        else{
           $f_nac=1;
        }
        $curp=DB::selectOne('select *from gnral_alumnos WHERE gnral_alumnos.id_usuario='.$usuario.'');
        $curp=$curp->curp_al;
        if($curp== null){
            $ed=0;
            $edad=0;
            $genero="";
    }
    else{
        $ed=1;

        $genero=$al_año=substr($curp, 10,1);


        $al_año=substr($curp, 4,1); //sacar el año
        if($al_año == 9 || $al_año == 8  || $al_año == 7 || $al_año == 6)
        {
            $al_año2=substr($curp, 5,1);
            $amo="19".$al_año.$al_año2;
            $mes=substr($curp, 6,2);
            $dia=substr($curp, 8,2);
            $ano_diferencia  = date("Y") - $amo;

            $mes_diferencia =   date("m")-$mes;

            $dia_diferencia   =   date("d")- $dia;

            if ($dia_diferencia < 0 && $mes_diferencia == 0 || $mes_diferencia < 0)
            {
                $ano_diferencia=$ano_diferencia-1;
            }
            else{
                $ano_diferencia=$ano_diferencia;
            }
        }
        else if($al_año ==0 || $al_año == 1 || $al_año == 2){
            $al_año2=substr($curp, 5,1);
            $amo="20".$al_año.$al_año2;
            $mes=substr($curp, 6,2);
            $dia=substr($curp, 8,2);
            $ano_diferencia  = date("Y") - $amo;

            $mes_diferencia =   date("m")-$mes;

            $dia_diferencia   =   date("d")- $dia;

            if ($dia_diferencia < 0 && $mes_diferencia == 0 || $mes_diferencia < 0)
            {
                $ano_diferencia=$ano_diferencia-1;
            }
            else{
                $ano_diferencia=$ano_diferencia;
            }
        }

        $edad=$ano_diferencia;

    }
        $sem=$datos->s_a;

       if($sem == 0){
           $sem=$datos->id_semestre;
       }else{
           $sem=$datos->s_a;
       }
       $periodo_inscrito=DB::selectOne('SELECT COUNT(id_semestres_al) contar from eva_semestre_alumno where id_alumno ='.$datos->id_alumno.'');
       $periodo_inscrito=$periodo_inscrito->contar;

       //dd($periodo_inscrito);

       if($periodo_inscrito == 0){
           $semestres=Semestres::all();
       }else{
           $periodo_act=DB::selectOne('SELECT * FROM `gnral_periodos` WHERE `estado` =1');
           $period_ins=DB::selectOne('SELECT * FROM `eva_semestre_alumno` WHERE `id_alumno` = '.$datos->id_alumno.'');


           $periodo_ins=$period_ins->id_periodo;
           $semestresins=$period_ins->id_semestre;
           $semestres_cursados=$periodo_act->id_periodo-$periodo_ins;
           $semestres_cursados=$semestres_cursados+$semestresins;
           if($semestres_cursados == 0){
               $semestres_cursados=1;
           }
           $semestres=DB::select('SELECT * FROM `gnral_semestres` WHERE id_semestre='.$semestres_cursados.'');
           $sem=$semestres_cursados;

       }
//dd($datos);
        return view('evaluacion_docente.Alumnos.datos_alumno',compact('grados','seguro','respuestass','respuesta',
            'datos_u','carreras','estados_alu','municipios','estados_tutor','existe','datos','entidadnac','semestres',
            'datos_t','dat','escuelas','f_nac','edad','ed','genero','sem','estado_institucion','institucion'));
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {


        $usuario = Session::get('usuario_alumno');
        $correo=DB::selectOne('select users.email from users where users.id='.$usuario.'');
        $cuent=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_usuario` ='.$usuario.' ');
        $cuentass=$cuent->cuenta;
         //dd($request);
        //dd($request->get('fecha_nac'));
        $id=($request->get('id'));
        $id_tutor=($request->get('id_tutor'));

        $existe=($request->get('existe'));
        $direccion=($request->get('igual'));
        ////////reorganizar fecha

        $fecha=($request->get('fecha_nac'));
        $fecha= explode("/", $fecha);
        $año=$fecha[2];
        $mes=$fecha[1];
        $dia=$fecha[0];
        $fecha=$año."/".$mes."/".$dia;

        $fechat=($request->get('fecha_nac_tutor'));
        $fechat= explode("/", $fechat);
        $añot=$fechat[2];
        $mest=$fechat[1];
        $diat=$fechat[0];
        $fechat=$añot."/".$mest."/".$diat;


////////////////////////////////////////
        $cuent= strtoupper($request->get('cuenta'));
        $curp_al= strtoupper($request->get('curpalu'));
        if($cuentass == ''){
            $datos=array(

                'cuenta'=>$cuent,
                'nombre'=>$request->get('nomalu'),
                'apaterno'=>$request->get('appalu'),
                'amaterno'=>$request->get('apmalu'),
                'genero'=>$request->get('generoalu'),
                //'fecha_nac'=>$request->get('fecha_nac'),
                'fecha_nac'=>$fecha,
                'edad'=>$request->get('edadalu'),
                'curp_al'=>$curp_al,
                'edo_civil'=>$request->get('estadoalu'),
                'nacionalidad'=>$request->get('nacioalu'),
                'twiter_al'=>$request->get('twiteralu'),
                'correo_al'=>$request->get('correoalu'),
                'facebook_al'=>$request->get('facealu'),
                'cel_al'=>$request->get('celalu'),
                'tel_fijo_al'=>$request->get('telalu'),
                'entidad_nac_al'=>$request->get('entidadalu'),
                'grado_estudio_al'=>$request->get('estudiosalu'),
                'id_carrera'=>$request->get('carreras'),
                'id_semestre'=>$request->get('semestre'),
                's_a'=>$request->get('semestre'),
                'grupo'=>$request->get('grupoalu'),
                'promedio'=>$request->get('promedio'),
                'promedio_preparatoria'=>$request->get('promedio_preparatoria'),
                //'id_escuela_procedencia'=>$request->get('escuela'),
                'estado'=>$request->get('estados_alu'),
                'id_municipio'=>$request->get('municipios_alu'),

                'discapacidad'=>$request->get('discapacidad'),
                'descripcion_discapacidad'=>$request->get('descripcion_discapacidad'),
                'lengua'=>$request->get('lengua'),
                'descripcion_lengua'=>$request->get('descripcion_lengua'),
                'id_seguro_social'=>$request->get('seguro'),
                'numero_seguro_social'=>$request->get('seguro_social'),

                'calle_al'=>$request->get('calle_alu'),
                'n_ext_al'=>$request->get('n_exterior_alu'),
                'n_int_al'=>$request->get('n_interior_alu'),
                'entre_calle'=>$request->get('entre_calle_alu'),
                'y_calle'=>$request->get('y_calle_alu'),
                'otra_ref'=>$request->get('otra_ref_alu'),
                'colonia_al'=>$request->get('colonia_alu'),
                'localidad_al'=>$request->get('localidad_alu'),
                'cp'=>$request->get('CP_alu'),

            );
        }else{
            $datos=array(

                'cuenta'=>$cuent,
                'nombre'=>$request->get('nomalu'),
                'apaterno'=>$request->get('appalu'),
                'amaterno'=>$request->get('apmalu'),
                'genero'=>$request->get('generoalu'),
                //'fecha_nac'=>$request->get('fecha_nac'),
                'fecha_nac'=>$fecha,
                'edad'=>$request->get('edadalu'),
                'curp_al'=>$curp_al,
                'edo_civil'=>$request->get('estadoalu'),
                'nacionalidad'=>$request->get('nacioalu'),
                'twiter_al'=>$request->get('twiteralu'),
                'correo_al'=>$request->get('correoalu'),
                'facebook_al'=>$request->get('facealu'),
                'cel_al'=>$request->get('celalu'),
                'tel_fijo_al'=>$request->get('telalu'),
                'entidad_nac_al'=>$request->get('entidadalu'),
                'grado_estudio_al'=>$request->get('estudiosalu'),
                'id_carrera'=>$request->get('carreras'),
                'id_semestre'=>$request->get('semestre'),
                's_a'=>$request->get('semestre'),
                'grupo'=>$request->get('grupoalu'),
                'promedio'=>$request->get('promedio'),
                'promedio_preparatoria'=>$request->get('promedio_preparatoria'),
                //'id_escuela_procedencia'=>$request->get('escuela'),
                'estado'=>$request->get('estados_alu'),
                'id_municipio'=>$request->get('municipios_alu'),

                'discapacidad'=>$request->get('discapacidad'),
                'descripcion_discapacidad'=>$request->get('descripcion_discapacidad'),
                'lengua'=>$request->get('lengua'),
                'descripcion_lengua'=>$request->get('descripcion_lengua'),
                'id_seguro_social'=>$request->get('seguro'),
                'numero_seguro_social'=>$request->get('seguro_social'),

                'calle_al'=>$request->get('calle_alu'),
                'n_ext_al'=>$request->get('n_exterior_alu'),
                'n_int_al'=>$request->get('n_interior_alu'),
                'entre_calle'=>$request->get('entre_calle_alu'),
                'y_calle'=>$request->get('y_calle_alu'),
                'otra_ref'=>$request->get('otra_ref_alu'),
                'colonia_al'=>$request->get('colonia_alu'),
                'localidad_al'=>$request->get('localidad_alu'),
                'cp'=>$request->get('CP_alu'),

            );
        }



        if($direccion==1)
        {
            $curp_tutor = strtoupper($request->get('curp_tutor'));
            $datos_t=array(

                'nombre'=>$request->get('nombre_tutor'),
                'ap_paterno_T'=>$request->get('ap_tutor'),
                'ap_mat_T'=>$request->get('am_tutor'),
                'puesto'=>$request->get('puesto_tutor'),
                'parentezco'=>$request->get('parentesco_tutor'),
                'fecha_nac_T'=>$fechat,
                'edad'=>$request->get('edad_tutor'),
                'genero'=>$request->get('genero_tutor'),
                'edo_civil_t'=>$request->get('estado_civ_t'),
                'grado_est_t'=>$request->get('estudios_tutor'),
                'nacionalidad_t'=>$request->get('nacioanalidad_turor'),
                'curp'=>$curp_tutor,
                'correo_t'=>$request->get('correo_tutor'),
                'twitter_t'=>$request->get('twiter_tutor'),
                'facebook_t'=>$request->get('facebook_tutor'),
                'cel_t'=>$request->get('cel_tutor'),
                'tel_fijo_t'=>$request->get('tel_fijo_tutor'),
                'estado_T'=>$request->get('estados_alu'),
                'municipio_T'=>$request->get('municipios_alu'),
                'calle'=>$request->get('calle_alu'),
                'n_ext_t'=>$request->get('n_exterior_alu'),
                'n_int_t'=>$request->get('n_interior_alu'),
                'entre_calle_t'=>$request->get('entre_calle_alu'),
                'y_calle_t'=>$request->get('y_calle_alu'),
                'otra_ref_t'=>$request->get('otra_ref_alu'),
                'cp_t'=>$request->get('CP_alu'),
                'colonia_t'=>$request->get('colonia_alu'),
                'localidad_t'=>$request->get('localidad_alu'),

            );

        }
        else
        {
            $curp_tutor = strtoupper($request->get('curp_tutor'));

            $datos_t=array(

                'nombre'=>$request->get('nombre_tutor'),
                'ap_paterno_T'=>$request->get('ap_tutor'),
                'ap_mat_T'=>$request->get('am_tutor'),
                'puesto'=>$request->get('puesto_tutor'),
                'parentezco'=>$request->get('parentesco_tutor'),
                'fecha_nac_T'=>$fechat,
                'edad'=>$request->get('edad_tutor'),
                'genero'=>$request->get('genero_tutor'),
                'edo_civil_t'=>$request->get('estado_civ_t'),
                'grado_est_t'=>$request->get('estudios_tutor'),
                'nacionalidad_t'=>$request->get('nacioanalidad_turor'),
                'curp'=>$curp_tutor,
                'correo_t'=>$request->get('correo_tutor'),
                'twitter_t'=>$request->get('twiter_tutor'),
                'facebook_t'=>$request->get('facebook_tutor'),
                'cel_t'=>$request->get('cel_tutor'),
                'tel_fijo_t'=>$request->get('tel_fijo_tutor'),
                'estado_T'=>$request->get('estados_alu'),
                'municipio_T'=>$request->get('municipios_alu'),
                'calle'=>$request->get('calle_tutor'),
                'n_ext_t'=>$request->get('no_exterior_tutor'),
                'n_int_t'=>$request->get('no_interior_tutor'),
                'entre_calle_t'=>$request->get('entre_calle_tutor'),
                'y_calle_t'=>$request->get('y_calle_tutor'),
                'otra_ref_t'=>$request->get('otra_ref_tutor'),
                'cp_t'=>$request->get('cp_tutor'),
                'colonia_t'=>$request->get('colonia_tutor'),
                'localidad_t'=>$request->get('localidad_tutor'),

            );
        }

        $datos_u=array('info_ok'=>2);
        $usuario = Session::get('usuario_alumno');

        Alumnos::find($id)->update($datos);
        Tutor::find($id_tutor)->update($datos_t);
        User::find($usuario)->update($datos_u);
        $mensage_carga='DATOS GUARDADOS EXITOSAMENTE';
        $color=2;
        //return redirect('/home');
        return view('evaluacion_docente.Alumnos.mensages2',compact('mensage_carga','color'));
    }
    public function municipios($checkboxValues){


        echo($checkboxValues);


    }
    public function show($id)

    {
        //
    }
    public function agregar_escuelas(){
        $estados = Estados::all();
        $escuelas = DB::table('gnral_escuela_procedencia')
            ->select('gnral_escuela_procedencia.*')
            ->orderBy('gnral_escuela_procedencia.nombre_escuela', 'ASC')
            ->orderBy('gnral_escuela_procedencia.estado', 'ASC')
            ->orderBy('gnral_escuela_procedencia.municipio', 'ASC')
            ->get();
       // dd($escuelas);
        return view('servicios_escolares.escuelas_procedencia',compact('estados','escuelas'));

    }
    public function registrar_escuela(Request $request){
        $this->validate($request,[
            'nombre_escuela' => 'required',
            'estado' => 'required',
            'municipios' => 'required'
        ]);


            $nombre_escuela =  mb_strtoupper($request->get('nombre_escuela'),'utf-8');
            $id_estado =$request->get('estado');
            $id_municipio =$request->get('municipios');
            $domicilio=DB::selectOne('SELECT gnral_municipios.nombre_municipio,gnral_estados.nombre_estado from gnral_municipios,gnral_estados 
where gnral_municipios.id_estado=gnral_estados.id_estado and gnral_municipios.id_municipio='.$id_municipio.'');
            $nombre_municipio=$domicilio->nombre_municipio;
            $nombre_estado=$domicilio->nombre_estado;

             $insertar = DB:: table('gnral_escuela_procedencia')
                         ->insert(['nombre_escuela'=>$nombre_escuela,
                        'estado'=>$nombre_estado,'municipio'=>$nombre_municipio
                         ]);
        return back();
    }
    public function modificar_escuela($id_escuela){
        $estados = Estados::all();
        $escuela = DB::table('gnral_escuela_procedencia')
            ->where('gnral_escuela_procedencia.id_escuela_procedencia','=',$id_escuela)
            ->select('gnral_escuela_procedencia.*')
            ->orderBy('gnral_escuela_procedencia.nombre_escuela', 'ASC')
            ->get();

return view('servicios_escolares.partials.edit_escuela_procedencia',compact('escuela'));

    }
    public function modificacion_escuela(Request $request){
        $this->validate($request,[
            'id_escuela' => 'required',
            'nombre_escuela' => 'required',
            'estado' => 'required',
            'municipio' => 'required'
        ]);

        $id_escuela =$request->get('id_escuela');
        $nombre_escuela =  mb_strtoupper($request->get('nombre_escuela'),'utf-8');

          $nombre_municipio=mb_strtoupper($request->get('estado'),'utf-8');
        $nombre_estado=mb_strtoupper($request->get('municipio'),'utf-8');

        DB::table('gnral_escuela_procedencia')
            ->where('id_escuela_procedencia', $id_escuela)
            ->update(['nombre_escuela' => $nombre_escuela,'estado'=>$nombre_estado,'municipio'=>$nombre_municipio]);
        return back();
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
    public function buscarcuenta($cuenta){
        $numero=DB::selectOne("SELECT COUNT(id_alumno) num FROM gnral_alumnos WHERE cuenta LIKE '$cuenta'");
        $numero=$numero->num;
        return $numero;

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
    public function guardar_cct(Request $request, $id_alumno){
        $id_escuela =$request->get('id_escuela');

        DB::table('gnral_alumnos')
            ->where('id_alumno', $id_alumno)
            ->update(['id_institucion' => $id_escuela]);

        return back();


    }
    public function modificar_cct($id_alumno){
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` = '.$id_alumno.'');
        $escuelas=DB::select('SELECT * FROM `gnral_instituciones_edu` ORDER BY `cct` ASC');

        return view('evaluacion_docente.Alumnos.editar_cct',compact('alumno','escuelas','id_alumno'));

    }
    public function guardar_mod_cct(Request $request,$id_alumno){
        $id_escuela =$request->get('id_escuela');

        DB::table('gnral_alumnos')
            ->where('id_alumno', $id_alumno)
            ->update(['id_institucion' => $id_escuela]);
        return redirect('/datos_alumno');
    }
    public function  registros_cct(){
        $escuelas= DB::select('SELECT * FROM `gnral_instituciones_edu` ORDER BY `cct` ASC');

        return view('evaluacion_docente.escuelas.escuelas_cct',compact('escuelas'));
    }
    public function registros_modificar($id_institucion){
       $institucion= DB::selectOne('SELECT * FROM `gnral_instituciones_edu` WHERE `id_institucion` ='.$id_institucion.'');
       //dd($institucion);
        return view('evaluacion_docente.escuelas.editar_escuela',compact('institucion'));

    }
    public function guardar_modificacion_cct(Request $request){
        $id_institucion =$request->get('id_institucion');
        $cct =$request->get('cct');
        $nombre_escuela =$request->get('nombre_escuela');
        $domicilio =$request->get('domicilio');
        $municipio =$request->get('municipio');
        $localidad =$request->get('localidad');
        $turno =$request->get('turno');
        $servicio =$request->get('servicio');

        DB::table('gnral_instituciones_edu')
            ->where('id_institucion', $id_institucion)
            ->update([
                'cct' => $cct,
                'nombre_escuela' => $nombre_escuela,
                'domicilio' => $domicilio,
                'municipio' => $municipio,
                'localidad' => $localidad,
                'turno' => $turno,
                'servicio' => $servicio,
                ]);

        return back();

    }
    public function guardar_institucion_educativa(Request $request){

        $cct =$request->get('cct');
        $nombre_escuela =$request->get('nombre_escuela');
        $domicilio =$request->get('domicilio');
        $municipio =$request->get('municipio');
        $localidad =$request->get('localidad');
        $turno =$request->get('turno');
        $servicio =$request->get('servicio');

        $insertar = DB:: table('gnral_instituciones_edu')
            ->insert([
                'cct' => $cct,
                'nombre_escuela' => $nombre_escuela,
                'domicilio' => $domicilio,
                'municipio' => $municipio,
                'localidad' => $localidad,
                'turno' => $turno,
                'servicio' => $servicio,
            ]);
        return back();

    }
}