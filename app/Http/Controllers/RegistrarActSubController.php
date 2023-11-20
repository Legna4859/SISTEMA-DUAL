<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\CategoriaAct;
use App\Jefaturas;
use App\ActividadesComplementarias;

class RegistrarActSubController extends Controller
{

    public function index()
    {

        $categoria = DB::select('select actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion,actcomple_categorias.descripcion_cat,
                actividades_complementarias.horas,actividades_complementarias.creditos,actcomple_jefaturas.nom_jefatura 
                from actcomple_jefaturas, actividades_complementarias,actcomple_categorias 
                where actividades_complementarias.id_categoria=actcomple_categorias.id_categoria 
                and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                and actividades_complementarias.estado=1');
        $categorias= CategoriaAct::all();
        $jefaturascar=DB::select('select actcomple_jefaturas.id_jefatura,actcomple_jefaturas.nom_jefatura 
                                    from actcomple_jefaturas 
                                    ORDER BY nom_jefatura ASC');
        return view('actividades_complementarias/subdireccion.agregar_actividades',compact('categorias','categoria','jefaturascar'));
    }


    public function create()
    {
       
    }


    public function store(Request $request)
    {
        
        $this->validate($request,[
            'actividad_sub'=>'required',
            'categoria_sub'=>'required',
            'horas_sub'=>'required',
            'jefatura_sub'=>'required'

        ]);

       $horas= $request->get('horas_sub');
       $creditos=0;
       $estado=1;

       if($horas==20)
        $creditos=1;
        else
        $creditos=2;
        
        $datos=array(
            'descripcion' => $request->get('actividad_sub'),
            'id_categoria' => $request->get('categoria_sub'),
            'horas' => $request->get('horas_sub'),
            'creditos'=>$creditos,
            'id_jefatura'=> $request->get('jefatura_sub'),
            'estado' =>$estado
            );

       $act=ActividadesComplementarias::create($datos);      
       return redirect('/nueva_actividad');


}
    public function show($id)
    {
       
    }


    public function edit($id_actividad_comple)
    {
        $categoria = DB::select('select actividades_complementarias.id_actividad_comple,actividades_complementarias.descripcion,actcomple_categorias.descripcion_cat,
                actividades_complementarias.horas,actividades_complementarias.creditos,actcomple_jefaturas.nom_jefatura from actcomple_jefaturas,
                actividades_complementarias,
                actcomple_categorias where actividades_complementarias.id_categoria=actcomple_categorias.id_categoria and
                actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura');
        $categorias= CategoriaAct::all();
        $jefaturascar=Jefaturas::all();
   

        $actividad = ActividadesComplementarias::find($id_actividad_comple);
        return view('actividades_complementarias/subdireccion.agregar_actividades',compact('categorias','categoria','jefaturascar'))->with(['edit' => true, 'actividad' => $actividad]);
     
       
       
    }

    public function update(Request $request, $id_actividad_comple)
    {
          $this->validate($request,[
            'actividad_sub'=>'required',
            'categoria_sub'=>'required',
            'horas_sub'=>'required',
            'jefatura_sub'=>'required'

        ]);
       $horas= $request->get('horas_sub');
       $creditos=0;
       if($horas==20)
        $creditos=1;
        else
        $creditos=2;
        
        $datos=array(
            'descripcion' => $request->get('actividad_sub'),
            'id_categoria' => $request->get('categoria_sub'),
            'horas' => $request->get('horas_sub'),
            'creditos'=>$creditos,
            'id_jefatura'=> $request->get('jefatura_sub')
            );

       ActividadesComplementarias::find($id_actividad_comple)->update($datos);   
    
       return redirect('/nueva_actividad');

        

    }


    public function destroy($id)
    {
        $elimina_registro=DB::table('actividades_complementarias')->where('id_actividad_comple',$id)->update(['estado'=>0]);
        return redirect('/nueva_actividad');
    }


    public function categoria(Request $request)
    {
        $this->validate($request,[
            'categorias'=>'required',
    
        ]);

        $categoria=array(
            'descripcion_cat' => $request->get('categorias'),
            );

       $act=CategoriaAct::create($categoria);   
        $categorias= CategoriaAct::all();
       
       return $categorias;


    }
}
