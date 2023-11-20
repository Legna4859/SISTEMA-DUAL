@extends('layouts.app')
@section('title', 'Constancias')
@section('content')

<main class="col-md-12">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-info">
        <div class="panel-heading">Liberación de Actividades</div>
      </div>
    </div>
  </div>


<div class="row ">
  <div class="row col-md-10 col-md-offset-1">
    <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tres" aria-controls="home" role="tab" data-toggle="tab">No Liberados</a></li>
        <li role="presentation"><a href="#cuatro" aria-controls="cuatro" role="tab" data-toggle="tab">Aprobados</a></li>
        <li role="presentation"><a href="#dos" aria-controls="dos" role="tab" data-toggle="tab">No Aprobados</a></li>  
      
      </ul>
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
        </br>  

      <table class="table table-bordered tabla-grande2" id="paginacion">
        <thead>
          <tr>
            <th>Cuenta</th>
            <th>Alumno</th>
            <th>Semestre</th>
            <th>Grupo</th>
            <th>Actividad</th>
            <th>Docente</th>
            <th>Créditos</th>
            <th>Promedio</th>
            <th>Liberación</th>
          </tr>
        </thead>
        <tbody>
          @foreach($liberacion_evaluacion_si as $liberacion_evaluacion_si)
          <tr>
            <td>{{$liberacion_evaluacion_si->cuenta}}</td>
            <td>{{$liberacion_evaluacion_si->nombre}} {{$liberacion_evaluacion_si->apaterno}} {{$liberacion_evaluacion_si->amaterno}}</td>
            <td>{{$liberacion_evaluacion_si->semestre}}</td>
            <td>{{$liberacion_evaluacion_si->grupo}}</td>
            <td>{{$liberacion_evaluacion_si->descripcion}}</td>
            <td>{{$liberacion_evaluacion_si->titulo}} {{$liberacion_evaluacion_si->docente}}</td>
            <td>{{$liberacion_evaluacion_si->creditos}}</td>
            <td>{{$liberacion_evaluacion_si->promedio}}</td>
            <td>  
              <input class="checkbox" name="orderbox[]"  type="checkbox" value="1" id="liberacion_jefe" data-cuenta="{{$liberacion_evaluacion_si->id_registro_alumno}}">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>      
       </div>
      </div>
    <div role="tabpanel" class="tab-pane" id="cuatro">
    </br></br></br>

      <table class="table table-bordered tabla-grande2" id="pagi">
        <thead>
          <tr>
            <th>Cuenta</th>
            <th>Alumno</th>
            <th>Semestre</th>
            <th>Grupo</th>
            <th>Actividad</th>
            <th>Docente</th>
            <th>Créditos</th>
            <th>Promedio</th>
          </tr>
        </thead>
        <tbody>
          @foreach($liberacion_evaluacion_no as $liberacion_evaluacion_no)
          @if($liberacion_evaluacion_no->promedio>=70)
          <tr>
            <td>{{$liberacion_evaluacion_no->cuenta}}</td>
            <td>{{$liberacion_evaluacion_no->nombre}} {{$liberacion_evaluacion_no->apaterno}} {{$liberacion_evaluacion_no->amaterno}}</td>
            <td>{{$liberacion_evaluacion_no->semestre}}</td>
            <td>{{$liberacion_evaluacion_no->grupo}}</td>
            <td>{{$liberacion_evaluacion_no->descripcion}}</td>
            <td>{{$liberacion_evaluacion_no->titulo}} {{$liberacion_evaluacion_no->docente}}</td>
            <td>{{$liberacion_evaluacion_no->creditos}}</td>
            <td>{{$liberacion_evaluacion_no->promedio}}</td>
            @if($liberacion_evaluacion_no->estado==1)
            <td>
                <a href="{{url("/Constancia/".$liberacion_evaluacion_no->id_registro_alumno."/edit")}}" target="_blank"><span class="glyphicon glyphicon-print em"  aria-hidden="true"></span></a>
            </td>
            @endif
          </tr>
          @endif
          @endforeach
        </tbody>
      </table>
          <div class="boton col-md-10 col-md-offset-5 regis">
            <a href="{{url("/constancias_todas")}}" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-print em"  aria-hidden="true"></span>Imprimir Todo</a>
          </div>
        </div>

      <div role="tabpanel" class="tab-pane" id="dos">
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
            <th>Docente</th>
            <th>Créditos</th>
            <th>Promedio</th>
          </tr>
        </thead>
        <tbody>
          @foreach($promedio_cero as $promedio_cero)
            @if($promedio_cero->promedio < 70)
              <tr>
                <td>{{$promedio_cero->cuenta}}</td>
                <td>{{$promedio_cero->nombre}} {{$promedio_cero->apaterno}} {{$promedio_cero->amaterno}}</td>
                <td>{{$promedio_cero->semestre}}</td>
                <td>{{$promedio_cero->grupo}}</td>
                <td>{{$promedio_cero->descripcion}}</td>
                <td>{{$promedio_cero->titulo}} {{$promedio_cero->docente}}</td>
                <td>{{$promedio_cero->creditos}}</td>
                <td>{{$promedio_cero->promedio}}</td>
              <tr>
            @endif
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

       
  <button type="button" class="btn btn-primary btn-lg flotante" data-placement="left" id="insertar">
    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  </button>


<div id="mensaje_actividad" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-warning">
        <p style="font-weight: bold; color:#BA0000; text-align:center;">NO HAS SELECCIONADO DATOS A IMPRIMIR</p>
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
            window.location.href=direccion+"/constancias_si/"+arreglo;
          }
      });

    $('#paginacion').DataTable();
    $('#pag').DataTable();  
    $('#pagi').DataTable();    
});
</script>
@endsection