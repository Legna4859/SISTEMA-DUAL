@extends('layouts.app')
@section('title', 'Docentes')
@section('content')
    
<main class="col-md-12">

   <?php $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
 $directivo=session()->has('directivo')?session()->has('directivo'):false;
 $consultas=session()->has('consultas')?session()->has('consultas'):false;
    $jefe_personal=session()->has('personal')?session()->has('personal'):false;?>


<div class="row">
        <div class="col-md-5 col-md-offset-4">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">PERSONAL DEL TESVB</h3>
        </div>
    </div>  
  </div>

  <div class="col-md-11 cont table-responsive">
    <table id="paginar_table" class="table table-bordered">

            <thead>
              <tr>
                 {{-- @if( $jefe_personal!=null)
                      <th>Eliminar</th>
                  @endif--}}
                @if($directivo!=null || $consultas!=null || $jefe_personal!=null)
                  <th>Datos académicos</th>
                @endif
                  <th >Clave</th>
                  <th >Nombre Completo</th>
                  <th >Situacion</th>
                  <th >Origen de Nacimiento</th>
                  <th >Ingreso al TESVB</th>
                  <th >RFC</th>
                  <th >Fecha de Contratación</th>
                  @if($jefe_division!=null)
                  <th >Materias Perfil</th>
                  <th >Agregar Materias/Perfil</th>
                  @endif
                  @if($directivo!=null || $consultas!=null || $jefe_personal!=null  )
                  <th>Cargo</th>
                  <th>Perfil</th>
                  <th>Correo</th>
                  <th>Tel.</th>
                  <th>Cel.</th>
                  <th>Cédula</th>
                  <th>Esc. Procedencia</th>
                  <th>Fecha/Nac.</th>
                  <th>Dir.</th>
                  <th>Escolaridad</th>
                  <th>Hrs.Max</th>
                  <th>Sexo</th>
                  <th>Hrs.Max.Ingles</th>
                  @endif
              </tr>
            </thead>
            <tbody>

        @if($directivo!=null || $consultas!=null || $jefe_personal!=null)
          @foreach($docentes as $docente)
                    <tr>
                      {{--  @if($jefe_personal!=null)
                        <td>
                            <a class="eliminar_personal" data-id="{{ $docente->id_personal}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                        </td>
                        @endif
                        --}}
                                    <td class="text-center">
                  @if($docente->horas_maxima==0 &&$docente->id_cargo==0 || $docente->horas_maxima==0)
                  {{ "INCOMPLETO" }}<br>
                  <a class="edita" id="{{ $docente->id_personal }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                  @else
                  {{ "COMPLETO" }}<br>
                  <a class="edita" id="{{ $docente->id_personal }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                  @endif
                </td>  
                <td>{{ $docente->clave}}</td>              
                <td>{{ $docente->nombre}}</td>
                <td>{{ $docente->situacion }}</td>
                <td>{{ $docente->origen_nac }}</td>
                <td>{{ $docente->fch_ingreso_tesvb }}</td>
                <td>{{ $docente->rfc }}</td>
                <td>{{ $docente->fch_recontratacion }}</td>

                <td>{{ $docente->cargo }}</td>
                <td>{{ $docente->descripcion }}</td>
                <td>{{ $docente->correo }}</td>
                <td>{{ $docente->telefono }}</td>
                <td>{{ $docente->celular }}</td>
                <td>{{ $docente->cedula }}</td>
                <td>{{ $docente->esc_procedencia }}</td>              
                <td>{{ $docente->fch_nac }}</td>
                <td>{{ $docente->direccion}}</td>  
                <td>{{ $docente->escolaridad }}</td>
                <td>{{ $docente->horas_maxima }}</td>
                <td>{{ $docente->sexo }}</td>
                <td>{{ $docente->maximo_horas_ingles }}</td>   
            </tr>
          @endforeach
        @endif
          @if($jefe_division!=null)
            @foreach($docentesss as $docente)
                              <tr>  
                <td>{{ $docente["clave"]}}</td>              
                <td>{{ $docente["nombre"]}}</td>
                <td>{{ $docente["situacion"] }}</td>
                <td>{{ $docente["origen_nac"] }}</td>
                <td>{{ $docente["fch_ingreso_tesvb"] }}</td>
                <td>{{ $docente["rfc"] }}</td>
                <td>{{ $docente["fch_recontratacion"] }}</td>
                <td>
                  <div class="row">
                  <div class="col-md-12">
                    @foreach($docente["materias"] as $materia)
                    <div class="col-md-9">
                      <p>{{ $materia["nombre_materia"]}}</p>                   
                    </div>
                    <div class="col-md-3">
                      <a class="elimina" id="{{ $materia["id_materia_perfil"] }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>                    
                    </div> 
                    @endforeach           
                  </div> 
                  </div>  
                </td>
                <td class="text-center">
                    <a class="agrega" id="{{ $docente ["id_personal"] }}" ><span class="glyphicon glyphicon-tags em2" aria-hidden="true"></span></a>
                </td>
              </tr>
            @endforeach
          @endif
            </tbody>
          </table> 
  </div>
  <!--@if($jefe_division!=null)
        <div>
        <a href="/docentes/create" data-toggle="tooltip" data-placement="left" title="AGREGAR DOCENTE" class="btn btn-success btn-lg flotante"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </a>
        </div>
  @endif-->
</div>	
</main>

<!-- Modal para ver materias -->
<form id="form_ver_materias" class="form" role="form" method="POST">
<div class="modal fade bs-example-modal-lg" id="modal_materias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">MATERIAS</h4>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          <input type="hidden" id="prof" name="prof" value="">
          <input type="hidden" id="materias" name="materias" value="">
          <div class="row">
              <div id="contenedor_materias">

              </div>
          </div>
        </div>
                      <div class="modal-footer">
              <button type="button" class="btn btn-primary acepta">Agregar</button>
          </div>
    </div>
  </div>
</div>
</form>

<!-- MODAL PARA EDITAR DOCENTES-->

  <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Datos Académicos</h4>
      </div>
      <div class="modal-body">

        <div id="contenedor_editar">

        </div>    
      </div> <!-- modal body  -->

      <div class="modal-footer">
        <input id="modifica_docente" type="button" class="btn btn-primary" value="Guardar" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>

<!-- MODAL PARA ELIMINAR -->
<div id="modal_elimina" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
<form action="" method="POST" role="form" id="form_delete">
 {{method_field('DELETE') }}
  {{ csrf_field() }}
        ¿Realmente deseas eliminar éste elemento?
      </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <input id="confirma_elimina" type="button" class="btn btn-danger" value="Aceptar"></input>
      </div>
</form>
      </div>
    </div>
  </div>
</div>
<form action="" method="POST" role="form" id="form_eliminar">
    {{method_field('DELETE') }}
    {{ csrf_field() }}
</form>

<script>
function bloqueo()
{
    $.blockUI({
    //message: '<img src="/img/cargando.gif" />',
  });
        //setTimeout($.unblockUI, 4000); 
} 
$(document).ready(function() {

$("#paginar_table").on('click','.edita',function(){
  
  var idper=$(this).attr('id');

  $.get("/datos_academicos/"+idper,function(request)
  {
      $("#contenedor_editar").html(request);
      $("#modal_editar").modal("show");
  });
});

$("#modifica_docente").click(function(){
var hmi=$("#caja-error13").val(); //hrs_max_ingles
var hm=$("#caja-error12").val(); //hrs_maximas
var cargo=$("#selectCargo").val();

      window.location.href='/modifica_datos/'+cargo+'/'+hm+'/'+hmi;
});

  $('#paginar_table').DataTable();

      $("#paginar_table").on('click','.agrega',function(){
        var idprof=$(this).attr('id');
        $('#prof').val(idprof);
        $.get("/docentes/materias/"+idprof,function(request)
          {
            $("#contenedor_materias").html(request);
        });
        $('#modal_materias').modal('show');

      });

    $(".close").click(function(){
      $('#selectReticula').val($('#selectReticula > option:first').val());
    });

    $(".acepta").click(function(){
      bloqueo();
        var arreglo_materias=[];
        $("input[name='materia[]']:checked").each(function(){
          arreglo_materias[arreglo_materias.length]=$(this).val();        
        });
        $("#materias").val(arreglo_materias);

      $.post("/agrega/materias_perfil", $("#form_ver_materias").serialize(),function(request)
        {
          window.location.href='/docente';
          $('#modal_materias').modal('hide');
          $.unblockUI();
        });
    });
              $("#form_update_docente").validate({
            rules: {
            hrs_max: {
              required: true,
              },
            hrs_max_ingles: {
              required: true,
              },
            selectCargo: "required" 
        },            
          });


 $("#paginar_table").on('click','.elimina',function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });

                $("#confirma_elimina").click(function(event){
          var id_doc=($(this).data('id'));
          $("#form_delete").attr("action","/docente/"+id_doc)      
          $("#form_delete").submit();
          });
});
$(".eliminar_personal").click(function(){
    var id=$(this).data('id');
    swal({
        title: "¿Seguro que desea eliminar?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $("#form_eliminar").attr("action","/docente/eliminar/"+id)
                $("#form_eliminar").submit();
            }
        });
});

</script> 
@endsection
