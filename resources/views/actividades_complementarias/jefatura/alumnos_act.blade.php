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

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#uno" aria-controls="home" role="tab" data-toggle="tab">No Liberados</a></li>
        <li role="presentation"><a href="#dos" aria-controls="dos" role="tab" data-toggle="tab">Liberados</a></li>  
        <li role="presentation"><a href="#tres" aria-controls="tres" role="tab" data-toggle="tab">Registrados</a></li>  

      </ul>
      <!-- Tab panes -->
      <div class="tab-content ">
        <div role="tabpanel" class="tab-pane active" id="uno">
          <div class="col-md-12">
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
            <th>Liberación Jefatura</th>
          </tr>
        </thead>
        <tbody>
          @foreach($libera_alumnos as $liberacion_jefe)
          <tr>
            <td>{{$liberacion_jefe->cuenta}}</td>
            <td>{{$liberacion_jefe->apaterno}} {{$liberacion_jefe->amaterno}} {{$liberacion_jefe->alumno}}</td>
            <td>{{$liberacion_jefe->carrera}}</td>
            <td>{{$liberacion_jefe->semestre}}</td>
            <td>{{$liberacion_jefe->descripcion}}</td>
            <td>{{$liberacion_jefe->descripcion_cat}}</td>
            <td>{{$liberacion_jefe->horas}}</td>
            <td>{{$liberacion_jefe->creditos}}</td>
            <td>{{$liberacion_jefe->titulo}} {{$liberacion_jefe->docente}}</td>
            <td>
              
            <input class="checkbox" name="orderbox[]"  type="checkbox" value="1" id="liberacion_jefe" data-cuenta="{{$liberacion_jefe->id_registro_alumno}}">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>    
       </div>
      </div>
    <div role="tabpanel" class="tab-pane" id="dos">
      <div class=" col-md-12">
        <br><br><br>

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
          @foreach($liberacion_si as $liberacion_si)
          <tr>
            <td>{{$liberacion_si->cuenta}}</td>
            <td>{{$liberacion_si->apaterno}} {{$liberacion_si->amaterno}} {{$liberacion_si->alumno}}</td>
            <td>{{$liberacion_si->carrera}}</td>
            <td>{{$liberacion_si->semestre}}</td>
            <td>{{$liberacion_si->descripcion}}</td>
            <td>{{$liberacion_si->descripcion_cat}}</td>
            <td>{{$liberacion_si->horas}}</td>
            <td>{{$liberacion_si->creditos}}</td>
            <td>{{$liberacion_si->titulo}} {{$liberacion_si->docente}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>            
         </div>
      </div>

      <div role="tabpanel" class="tab-pane" id="tres">
        <div class="col-md-12">
          <br><br><br>
               
      <table class="table table-bordered tabla-grande2 " id="pag">
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
          @foreach($liberacion_registro as $liberacion_registro)
          <tr>
            <td>{{$liberacion_registro->cuenta}}</td>
            <td>{{$liberacion_registro->apaterno}} {{$liberacion_registro->amaterno}} {{$liberacion_registro->alumno}}</td>
            <td>{{$liberacion_registro->carrera}}</td>
            <td>{{$liberacion_registro->semestre}}</td>
            <td>{{$liberacion_registro->descripcion}}</td>
            <td>{{$liberacion_registro->descripcion_cat}}</td>
            <td>{{$liberacion_registro->horas}}</td>
            <td>{{$liberacion_registro->creditos}}</td>
            <td>{{$liberacion_registro->titulo}} {{$liberacion_registro->docente}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>    
       </div>
      </div>


</div>
</div>
</div>

<?php
  $direccion=Session::get('ip');
?>
  <div class="col-md-8 col-md-offset-2">
    <button type="button" class="btn btn-primary btn-lg flotante" data-placement="left" id="insertar">
      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
    </button>  
  </div>

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
            window.location.href=direccion+"/edita_jefe_aceptar/"+arreglo;
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

              window.location.href=direccion+"/ed/"+arreglo;

          });

    $('#paginacion').DataTable();
    $('#pagina2').DataTable();
    $('#pag').DataTable();
});
</script>
@endsection