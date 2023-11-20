@extends('layouts.app')
@section('title', 'Incidencias')
@section('content')
    
<main class="col-md-12">
<div class="row">
        <div class="col-md-5 col-md-offset-4">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">REPORTES</h3>
        </div>
    </div>  
  </div>
  </div>
  @if($estado == 0)
  
<div class="row">
<form id="form_buscar_reportes" action="{{url("/incidencias/reportes_incidencias_ver")}}" method="POST" role="form" >
  {{ csrf_field() }}
  <div class="col-md-3 col-md-offset-1">
    <div class= "dropdown">
        <label for="Tipo_of">Artículo/Cláusula: </label>
          <select class="form-control" placeholder="Seleciona una opción" id="id_articulo" name="id_articulo" required>
              <option disabled selected hidden> Selecciona una opción </option>
              @foreach($articulos as $articulo)
                <option value="{{$articulo->id_articulo}}" data-art="{{$articulo->nombre_articulo}}"> {{$articulo->nombre_articulo}} </option>
              @endforeach
              <option value="20" data_art="Todos"> Todos </option>
          </select>
    </div>
  </div>
  <div class="col-md-2 ">
    <label for="fecha_req">Desde Fecha:</label>
                     <div class="form-group">
                         <input class="form-control datepicker id_desd_fech"   type="text"  id="id_desd_fech" name="id_desd_fech" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD" >
                     </div>
  </div>
  <div class="col-md-2 ">
    <label for="fecha_req">Hasta Fecha:</label>
                     <div class="form-group">
                         <input class="form-control datepicker id_hast_fech"   type="text"  id="id_hast_fech" name="id_hast_fech" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD" >
                     </div>
  </div>
</form> 
  <div class="col-md-2">
    <label><br></label>
    <div class="form-group">
      <button id="buscar_registros" type="submit" class="btn btn-success">Buscar registros</button>
  </div> 
  </div>    
</div>

@endif
@if($estado == 1)
<div class="row">
<form id="form_buscar_reportes" action="{{url("/incidencias/reportes_incidencias_ver")}}" method="POST" role="form" >
  {{ csrf_field() }}
  <div class="col-md-3 col-md-offset-1">
    <div class= "dropdown">
        <label for="Tipo_of">Articulo/Cláusula:</label>
          <select class="form-control" placeholder="Seleciona una opción" id="id_articulo" name="id_articulo" required>
              <option disabled selected hidden> Selecciona una opción </option>
              @foreach($articulos as $articulo)
              @if($articulo->id_articulo==$arti)
                                                <option value="{{$articulo->id_articulo}}" selected="selected" >{{$articulo->nombre_articulo}}</option>
                                            @else
                                                <option value="{{$articulo->id_articulo}}"> {{$articulo->nombre_articulo}}</option>
                                            @endif
                @endforeach
          </select>
    </div>
  </div>
  <div class="col-md-2 ">
    <label for="fecha_req">Desde Fecha:</label>
                     <div class="form-group">
                         <input class="form-control datepicker id_desd_fech" value="{{$desd_fecha}}"  type="text"  id="id_desd_fech" name="id_desd_fech" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD" >
                     </div>
  </div>
  <div class="col-md-2 ">
    <label for="fecha_req">Hasta Fecha:</label>
                     <div class="form-group">
                         <input class="form-control datepicker id_hast_fech"  value="{{$hast_fecha}}" type="text"  id="id_hast_fech" name="id_hast_fech" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD" >
                     </div>
  </div>
</form> 
  <div class="col-md-2">
    <label><br></label>
    <div class="form-group">
      <button id="buscar_registros" type="submit" class="btn btn-success">Buscar registros</button>
  </div> 
  </div>    
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <table id="tabla_reportes" class="table table-bordered table-resposive" align="center">
                          <thead >                                     
                            <th class="text-center">No. de Oficio</th> 
                            <th class="text-center">Nombre del Solicitante</th>
                            <th class="text-center">Artículo Aplicado</th> 
                            <th class="text-center">Fecha</th>                 
                          </thead>
                          <tbody>
                      @if($arti==20)
                      @foreach($todos as $fecha)
                      <tr>
                        <td>{{$fecha->id_solicitud}}</td>
                        <td>{{$fecha->nombre}}</td>
                        <td>{{$fecha->nombre_articulo}}</td>
                        <td>{{$fecha->fecha_req}}</td>
                      </tr>
                      @endforeach             
                      @else
                      @foreach($fecha as $fecha)
                      <tr>
                        <td>{{$fecha->id_solicitud}}</td>
                        <td>{{$fecha->nombre}}</td>
                        <td>{{$fecha->nombre_articulo}}</td>
                        <td>{{$fecha->fecha_req}}</td>
                      </tr>
                      @endforeach
                      @endif
                          </tbody>
          </table>                   
    </div>
</div>

<div class="row">
  
  
  <div class="row" style="display: inline" id="generar">
    <div class="col-md-4 col-md-offset-10">
    <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfreportes')}}')">Generar reporte</button>
    </div>
  </div>
</div>
@endif
</div>
  <script>
$(document).ready( function() {

    $('#tabla_reportes').DataTable( {

    } );

  
  $( '.id_desd_fech').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                  $('.id_desd_fech').datepicker('setStartDate', getDate(selected));
                });
  $( '.id_hast_fech').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                  $('.id_hast_fech').datepicker('setStartDate', getDate(selected));
                });

    $("#buscar_registros").click(function(){  
      var id_articulo = $('#id_articulo').val();
      if(id_articulo == null){
      swal({
        position: "top",
        type: "error",
        title: "Selecciona articulo/cláusula a buscar",
        showConfirmButton: false,
        timer: 3500
      });
     }
     ///////////////////////////////////////////////
    else{
      var desd_fech = $('#id_desd_fech').val();
      
      if(desd_fech == ''){
        swal({
          position:"top",
          type:"error",
          title:"Selecciona la fecha de inicio de la búsqueda",
          showConfirmButton:false,
          timer:3500
        });
      }
    else{
        var hast_fech = $('#id_hast_fech').val();
        ///alert(hast_fech);
        if(hast_fech == ''){
          swall({
            position:"top",
            type:"error",
            title:"Selecciona la fecha de termino de la búsqueda",
            showConfirmButton:false,
            timer:3500
          });
        }
        else{
          $("#form_buscar_reportes").submit();
          $("#buscar_registros").attr("disableb", true);
            swal({
        position: "top",
        type: "success",
        title: "Búsqueda exitosa",
        showConfirmButton: false,
        timer: 3500
            });
          } 
        
      }
     }
    

      
      });

    });

  </script>

  </main>
@endsection