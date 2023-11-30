
@extends('layouts.app')
@section('title', 'Inicio')
@section('content')



<main class="col-md-12">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">VALIDACIÓN DE CARGAS ACADEMICAS</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?php $escolar = session()->has('escolar') ? session()->has('escolar') : false;  ?>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#uno" aria-controls="home" role="tab" data-toggle="tab">Pendientes</a>
                    </li>
                    <li role="presentation">
                        <a href="#dos" aria-controls="dos" role="tab" data-toggle="tab">Aceptados (Normal)</a>
                    </li>
                    <li role="presentation">
                        <a href="#tres" aria-controls="dos" role="tab" data-toggle="tab">Aceptados (Duales nueva versión)</a>
                    </li>
                </ul>
        </div>
    </div>

  <!-- Tab panes -->
    <div class="tab-content ">
        <div role="tabpanel" class="tab-pane active" id="uno">
            <div class=" col-md-10 col-md-offset-1">

			</br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="no_aceptados">
                                   <thead>
                                          <tr class="info">
                                                  <th style="text-align: center">No. CUENTA</th>
                                                  <th style="text-align: center">NOMBRE DE ALUMNO(A)</th>
                                                 <th style="text-align: center">CARRERA</th>
                                                  <th style="text-align: center">CARGA ACADEMICA</th>
                                           </tr>
                                    </thead>
                                    <tbody>

                                          @foreach($consulta as$consulta)
                                          <tr>
                                                  <th style="text-align: center">{{$consulta->cuenta}}</th>
                                                  <td style="text-align: center">{{$consulta->nombre}} {{$consulta->apaterno}} {{$consulta->amaterno}}</td>

                                                  <td style="text-align: center">{{$consulta->carreras}}</td>
                                                  <td  style="text-align: center">

                                                  <a onclick="window.open('{{ url('/revicion_control_escolar/'.$consulta->id ) }}')"><span class="glyphicon glyphicon-list-alt em5" aria-hidden="true"></span></a>

                                                  </td>

                                          </tr>
                                          @endforeach



                                   </tbody>
                            </table>









       </div>
   </div>
    <div role="tabpanel" class="tab-pane" id="dos">
    	<div class=" col-md-10 col-md-offset-1">

    					</br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="aceptados">
                                   <thead>
                                          <tr class="info">
                                                 <th style="text-align: center">No. CUENTA</th>
                                                 <th style="text-align: center">NOMBRE DE ALUMNO(A)</th>
                                                 <th style="text-align: center">SEMESTRE</th>
                                                 <th style="text-align: center">CARRERA</th>
                                                 <th style="text-align: center">CARGA ACADEMICA</th>
                                               @if($periodo_activo == 1)
                                                  <th style="text-align: center">MODIFICACIÓN DE ESTADO DEL ALUMNO</th>
                                                  <th style="text-align: center">DAR DE BAJA ALUMNO</th>
                                               @endif
                                           </tr>
                                    </thead>
                                    <tbody>
                                          
                                          @foreach($consulta2 as$consulta2)
                                          <tr>
                                                  <th style="text-align: center">{{$consulta2->cuenta}}</th>
                                                  <td style="text-align: center">{{$consulta2->nombre}} {{$consulta2->apaterno}} {{$consulta2->amaterno}}</td>
                                                  <td style="text-align: center">{{$consulta2->semestre}}</td>
                                                  <td style="text-align: center">{{$consulta2->carreras}}</td>
                                                  <td style="text-align: center">
                                                  <a onclick="window.open('{{ url('/revicion_control_escolar/'.$consulta2->id ) }}')"><span class="glyphicon glyphicon-list-alt em5" aria-hidden="true"></span></a>
                                                  </td>
                                              @if($periodo_activo == 1)
                                                  <td style="text-align: center">
                                                  @if($escolar  == true)
                                                  <a class=" btn btn-success activar_periodo_carga" id="{{$consulta2->id}}" type="button" >Modificar estado del alumno<span class="glyphicon glyphicon-ok " aria-hidden="true"/></a>
                                                  @endif
                                                  </td>
                                                  <td style="text-align: center">
                                                  @if($escolar  == true)
                                                  <a class=" btn btn-danger baja" id="{{$consulta2->id}}" type="button" >Dar de baja<span class="glyphicon glyphicon-edit " aria-hidden="true"/></a>
                                                  @endif
                                                  </td>
                                              @endif
                                                 
                                          </tr>
                                          @endforeach

                                          

                                   </tbody>
                            </table>
                        </div>
    </div>
        <div role="tabpanel" class="tab-pane" id="tres">
            <div class=" col-md-10 col-md-offset-1">

                </br></br></br>

                <table class="table table-bordered " Style="background: white;" id="version_actual">
                    <thead>
                    <tr class="info">
                        <th style="text-align: center">No. CUENTA</th>
                        <th style="text-align: center">NOMBRE DE ALUMNO(A)</th>
                        <th style="text-align: center">SEMESTRE</th>
                        <th style="text-align: center">CARRERA</th>
                        <th style="text-align: center">CARGA ACADEMICA</th>
                        @if($periodo_activo == 1)
                        <th style="text-align: center">MODIFICACIÓN DE ESTADO DEL ALUMNO</th>
                        <th style="text-align: center">DAR DE BAJA ALUMNO</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($consulta3 as$consulta3)
                        <tr>
                            <th style="text-align: center">{{$consulta3->cuenta}}</th>
                            <td style="text-align: center">{{$consulta3->nombre}} {{$consulta3->apaterno}} {{$consulta3->amaterno}}</td>
                            <td style="text-align: center">{{$consulta3->semestre}}</td>
                            <td style="text-align: center">{{$consulta3->carreras}}</td>
                            <td style="text-align: center">
                                <a onclick="window.open('{{ url('/revicion_control_escolar/'.$consulta3->id ) }}')">
                                    <span class="glyphicon glyphicon-list-alt em5" aria-hidden="true"></span>
                                </a>
                            </td>
                            @if($periodo_activo == 1)
                                <td style="text-align: center">
                                @if($escolar  == true)
                                <a class=" btn btn-success activar_periodo_carga" id="{{$consulta3->id}}" type="button" >
                                    Modificar estado del alumno
                                    <span class="glyphicon glyphicon-ok " aria-hidden="true"/>
                                </a>
                                @endif
                                </td>
                                <td style="text-align: center">
                                @if($escolar  == true)
                                <a class=" btn btn-danger baja" id="{{$consulta3->id}}" type="button" >Dar de baja<span class="glyphicon glyphicon-edit " aria-hidden="true"/></a>
                                @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
	
</main>
<form  method="POST" role="form" id="form_modificar">
    {{ csrf_field() }}
</form>
<form id="form_agregar" class="form" action="/modificar/estado_carga/" role="form" method="POST" >
    <div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar estado del alumno</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{ csrf_field() }}
                        <input type="hidden" id="id_carga" name="id_carga" value="">

                        <div class="col-md-8 col-md-offset-1">

                            <label for="exampleInputEmail1">Estado del alumno<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control "  name="estado" id="estado" required>
                                <option disabled selected hidden>Selecciona una opción</option>
                                <option  value="1">NORMAL</option>
                                <option  value="2">DUAL NUEVA VERSIÓN</option>
                                <option  value="3">DUAL VERSIÓN ANTIGUA</option>
                                <option  value="4">PERMISO DE MODIFICAR CARGA ACADEMICA</option>
                            </select>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="guardar_agregado"  class="btn btn-primary">Aceptar</button>
                </div>
                </div>


            </div>
        </div>
    </div>
</form>
<form id="form_baja" class="form" action="/baja/alumno_baja/" role="form" method="POST" >
    <div class="modal fade" id="modal_baja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Dar de baja alumno</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{ csrf_field() }}
                        <input type="hidden" id="id_carga_a" name="id_carga_a" value="">

                        <div class="col-md-8 col-md-offset-1">

                            <label for="exampleInputEmail1">Dar de baja alumno<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control "  name="estado" id="estado" required>
                                <option disabled selected hidden>Selecciona una opción</option>
                                <option  value="1">BAJA TEMPORAL (SIN ELIMINACION DE CARGA)</option>
                                <option  value="2">BAJA TEMPORAL (ELIMINACION DE CARGA)</option>
                                <option  value="3">BAJA DEFINITIVA</option>

                            </select>
                        </div>
                        <div class="col-md-8 col-md-offset-1">
                            <label for="exampleFormControlTextarea2">Observaciones:</label>
                            <textarea class="form-control rounded-0" id="obser" rows="2"  name="obser" ></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="guardar_baja"  class="btn btn-primary">Aceptar</button>
                </div>
            </div>


        </div>
    </div>
    </div>
</form>
<script type="text/javascript">


   $(document).ready(function(){
       $('#no_aceptados').DataTable();
       $('#aceptados').DataTable();
       $('#version_actual').DataTable();
       $('#version_antigua').DataTable();
       $("#aceptados").on('click','.activar_periodo_carga',function(){
           var idof=$(this).attr('id');
           $('#id_carga').val(idof);
           $('#modal_agregar').modal('show');

       });
       $("#aceptados").on('click','.baja',function(){
           var idof=$(this).attr('id');
           $('#id_carga_a').val(idof);
           $('#modal_baja').modal('show');

       });
       $("#version_actual").on('click','.baja',function(){
           var idof=$(this).attr('id');
           $('#id_carga_a').val(idof);
           $('#modal_baja').modal('show');

       });
       $("#version_antigua").on('click','.baja',function(){
           var idof=$(this).attr('id');
           $('#id_carga_a').val(idof);
           $('#modal_baja').modal('show');

       });
       $("#guardar_baja").click(function(event){
           $("#form_baja").submit();
       });
       $("#form_baja").validate({
           rules: {

               estado: "required",
               obser: "required",
           },
       });
       $("#guardar_agregado").click(function(event){
           $("#form_agregar").submit();
       });
       $("#form_agregar").validate({
           rules: {

               estado: "required",
           },
       });
       $("#version_actual").on('click','.activar_periodo_carga',function(){
           var idof=$(this).attr('id');
           $('#id_carga').val(idof);
           $('#modal_agregar').modal('show');

       });
       $("#version_antigua").on('click','.activar_periodo_carga',function(){
           var idof=$(this).attr('id');
           $('#id_carga').val(idof);
           $('#modal_agregar').modal('show');

       });

       $(".desactivar_periodo_carga").click(function(event){
           var idof=$(this).attr('id');
           swal({
               title: "¿Desactivar periodo de remplazar carga academica?",
               icon: "warning",
               buttons: true,
               dangerMode: true,
           })
               .then((willDelete) => {
                   if (willDelete) {
                       $("#form_modificar").attr("action","/desactivar/periodo_modificacion_carga/"+idof)
                       $("#form_modificar").submit();
                   }
               });
       });



   });

</script>


@endsection
