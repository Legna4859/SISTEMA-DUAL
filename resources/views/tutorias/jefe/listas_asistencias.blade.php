@extends('tutorias.app_tutorias')
@section('content')
   <div class="row">
       <div class="col-md-10 offset-1">
           <div class="alert alert-primary">
               <h3> Grupos del periodo {{ $nombre_periodo }}</h3>
           </div>
       </div>
   </div>
                        <div class="row">
                        @foreach($array_grupos_tutorias as $grupo_tutorias)
                                    <div class="col-md-4 offset-1" >
                                        <div class="card  text-dark">
                                            <div class="card-body">
                                                @if($grupo_tutorias['id_estado_semestre'] == 0)
                                                 <p style="text-align: center">   <button type="button" class="btn btn-primary agregar_semestre" data-id="{{ $grupo_tutorias['id_asigna_tutor']  }}">Agregar semestre</button></p>


                                                @else
                                                    <h3 style="text-align: center"> Semestre: {{ $grupo_tutorias['nombre_semestre'] }}</h3>
                                                    <p style="text-align: center">   <button type="button" class="btn btn-success editar_semestre" data-id="{{ $grupo_tutorias['id_asigna_tutor']  }}">Editar semestre</button></p>
                                                    <p style="text-align: center">   <button type="button" class="btn btn-info" onclick="window.location='{{ url('/tutorias/ver_estudiantes_grupo/'.$grupo_tutorias['id_asigna_tutor'] ) }}'">Ver estudiantes</button></p>


                                                @endif
                                                    <h5 style="text-align: center">Generación: {{ $grupo_tutorias['generacion'] }}</h5>
                                                    <h5 style="text-align: center">Grupo: {{ $grupo_tutorias['grupo'] }}</h5>
                                                    <p style="text-align: center"> Tutor: {{ $grupo_tutorias['nombre'] }}</p>

                                            </div>
                                        </div>
                                    </div>

                        @endforeach
                        </div>
   {{---modal_agregar_semestre_grupo--}}
   <div class="modal fade" id="modal_agregar_semestre_grupo">
       <div class="modal-dialog">
           <div class="modal-content">
               <form class="form" id="formulario_guardar_semestre" action="{{url("/tutorias/guardar_registro_semestre/")}}" role="form" method="POST" >
                   {{ csrf_field() }}
                   <div class="modal-header">
                       <h4 class="modal-title">Agregar semestre grupo</h4>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <div class="modal-body">
                   <div id="contenedor_agregar_semestre_grupo">


                   </div>
                   </div>
               </form>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                       <button type="button" id="guardar_registro" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                   </div>

           </div>

       </div>
   </div>
   {{---modal_modificar_semestre_grupo--}}
   <div class="modal fade" id="modal_modificar_semestre_grupo">
       <div class="modal-dialog">
           <div class="modal-content">
               <form class="form" id="formulario_guardar_mod_semestre" action="{{url("/tutorias/guardar_modificacion_semestre/")}}" role="form" method="POST" >
                   {{ csrf_field() }}
                   <div class="modal-header">
                       <h4 class="modal-title">Modificar semestre grupo</h4>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <div class="modal-body">
                       <div id="contenedor_modificar_semestre_grupo">


                       </div>
                   </div>
               </form>
               <div class="modal-footer">
                   <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                   <button type="button" id="guardar_modificacion" class="btn btn-primary" data-dismiss="modal">Guardar</button>
               </div>

           </div>

       </div>
   </div>


   <script type="text/javascript">

       $(document).ready(function() {

           $(".agregar_semestre").click(function(){
               var id_asigna_tutor=$(this).data("id");
               $.get("/tutorias/agregar_semestre_grupo/"+id_asigna_tutor,function(request){
                   $("#contenedor_agregar_semestre_grupo").html(request);
                   $("#modal_agregar_semestre_grupo").modal('show');

               });
           });
           $("#guardar_registro").click(function (){
               var id_grupo_tutorias = $("#id_grupo_tutorias").val();
               if( id_grupo_tutorias == null){
                   alert('Selecciona semestre');
               }else{
                   $("#formulario_guardar_semestre").submit();
                   $("#guardar_registro").attr("disabled", true);
               }
           });
           $(".editar_semestre").click(function (){
               var id_asigna_tutor=$(this).data("id");
               $.get("/tutorias/modificar_semestre_grupo/"+id_asigna_tutor,function(request){
                   $("#contenedor_modificar_semestre_grupo").html(request);
                   $("#modal_modificar_semestre_grupo").modal('show');

               });
           });
           $("#guardar_modificacion").click(function (){

                   $("#formulario_guardar_mod_semestre").submit();
                   $("#guardar_modificacion").attr("disabled", true);

           });
       });
   </script>



@endsection
