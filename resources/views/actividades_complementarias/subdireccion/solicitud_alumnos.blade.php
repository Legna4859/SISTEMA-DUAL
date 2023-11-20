@extends('layouts.app')
@section('title', 'AlumnosActividades')
@section('content')

<main class="col-md-12">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-info">
        <div class="panel-heading">Solicitud de Alumnos</div>
      </div>
    </div>
  </div>

<div class="row ">
  <div class="row col-md-10 col-md-offset-1">
    <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tres" aria-controls="home" role="tab" data-toggle="tab">No Liberados</a></li>
        <li role="presentation"><a href="#cuatro" aria-controls="cuatro" role="tab" data-toggle="tab">Liberados</a></li>
      </ul>
  <!-- Tab panes -->
    <div class="tab-content ">
    <div role="tabpanel" class="tab-pane active" id="tres">

        <div class=" col-md-12">
           <div class="col-md-8 col-md-offset-5">
              </br></br></br>
                <div class="col-md-4 col-md-offset-4" style="text-align:right;">
                  <label>Seleccionar Todos</label></div>
                    <div class="col-md-4">
                      <label class="switch">
                        <input type="checkbox" id="checktodos">
                          <div class="slider round"></div>
                      </label>
                    </div>
          </div>      
               
      <table class="table table-bordered tabla-grande2 " id="paginacion">
        <thead>
          <tr>
            <th>Cuenta</th>
            <th>Alumno</th>
            <th>Carrera</th>
            <th>Semestre</th>
            <th>Actividad</th>
            <th>Categoría</th>
            <th>Horas</th>
            <th>Créditos</th>
            <th>Docente</th>
            <th>Liberación</th>
          </tr>
        </thead>
        <tbody>
          @foreach($liberacion_sub as $liberacion_sub)
          <tr>
            <td>{{$liberacion_sub->cuenta}}</td>
            <td>{{$liberacion_sub->apaterno}} {{$liberacion_sub->amaterno}} {{$liberacion_sub->alumno}}</td>
            <td>{{$liberacion_sub->carrera}}</td>
            <td>{{$liberacion_sub->semestre}}</td>
            <td>{{$liberacion_sub->descripcion}}</td>
            <td>{{$liberacion_sub->descripcion_cat}}</td>
            <td>{{$liberacion_sub->horas}}</td>
            <td>{{$liberacion_sub->creditos}}</td>
            <td>{{$liberacion_sub->titulo}} {{$liberacion_sub->docente}}</td>
            <td>  
              <input class="checkbox" name="orderbox[]"  type="checkbox" value="1" id="liberacion_jefe" data-cuenta="{{$liberacion_sub->id_registro_alumno}}">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>     
       </div>
      </div>
    <div role="tabpanel" class="tab-pane" id="cuatro">
    </br></br></br>


  
           
<table class="table table-bordered tabla-grande2 " id="pagina2">
        <thead>
          <tr>
            <th>Cuenta</th>
            <th>Alumno</th>
            <th>Carrera</th>
            <th>Semestre</th>
            <th>Actividad</th>
            <th>Categoría</th>
            <th>Horas</th>
            <th>Créditos</th>
            <th>Docente</th>
          </tr>
        </thead>
        <tbody>
          @foreach($liberacion_subsi as $liberacion_subsi)
          <tr>
            <td>{{$liberacion_subsi->cuenta}}</td>
            <td>{{$liberacion_subsi->apaterno}} {{$liberacion_subsi->amaterno}} {{$liberacion_subsi->alumno}}</td>
            <td>{{$liberacion_subsi->carrera}}</td>
            <td>{{$liberacion_subsi->semestre}}</td>
            <td>{{$liberacion_subsi->descripcion}}</td>
            <td>{{$liberacion_subsi->descripcion_cat}}</td>
            <td>{{$liberacion_subsi->horas}}</td>
            <td>{{$liberacion_subsi->creditos}}</td>
            <td>{{$liberacion_subsi->titulo}} {{$liberacion_subsi->docente}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      </div>
  </div>
</div>

<?php
  $direccion=Session::get('ip');
?>

<button type="button" class="btn btn-primary btn-lg flotante" data-placement="left" id="insertar">
  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
</button> 

<div id="mensaje_actividad" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-warning">
        <p style="font-weight: bold; color:#BA0000; text-align:center;">NO HAS SELECCIONADO DATOS A LIBERAR</p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</main>
<script>
    $(document).ready(function(){
     var direccion="{{$direccion}}";

      $("#checktodos").change(function(){

          $('input[name="orderbox[]"]').prop('checked',$(this).prop("checked"));
      });

         $("#checktodoss").change(function(){

          $('input[name="orderboxx[]"]').prop('checked',$(this).prop("checked"));
      });

      
      $('#insertar').click(function(){
          var checkboxValues=[];
         var cuenta=[];

         
         
             $('input[name="orderbox[]"]:checked').each(function(){
            checkboxValues[checkboxValues.length]=$(this).val();
             cuenta[cuenta.length]=$(this).data('cuenta'); 
             
            });
            
          var $marcados=$('input[name="orderbox[]"]:checked');
          var numero=$marcados.length;
          if(numero==0)
          {
              $('#mensaje_actividad').modal('show');
                setTimeout(myFunction, 2000); 

                function myFunction(){
                $('#mensaje_actividad').modal('hide');
                }
          }
          else
          {
          var suma=numero+numero;
          var arreglo=[];
          var j=0;
          for(var i=0;i<numero;i++){

            arreglo[i]=checkboxValues[i];
          }
          for(var e=numero;e<suma;e++){

            arreglo[e]=cuenta[j];
            j++;
          }

              window.location.href=direccion+"/edita_sub_aceptar/"+arreglo;
        }

      });


     $('#remover').click(function(){
          var checkboxValues=[];
         var cuenta=[];

         
          
             $('input[name="orderboxx[]"]:checked').each(function(){
            checkboxValues[checkboxValues.length]=$(this).val();
             cuenta[cuenta.length]=$(this).data('cuentaa'); 
             
            });
          var $marcados=$('input[name="orderboxx[]"]:checked');
          var numero=$marcados.length;
          var suma=numero+numero;
          var arreglo=[];
          var j=0;
          for(var i=0;i<numero;i++){

            arreglo[i]=checkboxValues[i];
          }
          for(var e=numero;e<suma;e++){

            arreglo[e]=cuenta[j];
            j++;
          }

              window.location.href=direccion+"/ed_sub/"+arreglo;

          });
    $('#paginacion').DataTable();
    $('#pagina2').DataTable();
});


          


</script>
@endsection