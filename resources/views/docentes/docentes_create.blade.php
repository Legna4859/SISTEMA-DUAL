@extends('layouts.app')
@section('title', 'Creación Docentes')
@section('content')

<main class="col-md-12">

<?php $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;?>

<div class="row">

	<div class="col-md-10 col-xs-10 col-md-offset-1">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">Agregar Personal</h3>
	  		</div>
	  					<div class="panel-body">
<form id="form_docente_crea" class="form" role="form" method="POST">
  {{ csrf_field() }}
            <div clas="row">
              <div class="col-md-12">
                <div class="col-md-3 ">
                     <div class="form-group">
                      <label for="nombre_docente">Nombre Completo</label>
                      <input type="text" id="caja-error" class="form-control"  name="nombre_docente" placeholder="A.Paterno+A.Materno+Nombre" style="text-transform:uppercase">
                      @if($errors -> has ('nombre_docente'))
                          <span style="color:red;">{{ $errors -> first('nombre_docente') }}</span>
                         <style>
                          #caja-error
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div> 
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label for="clave_docente">Clave Docente(ISSEMyM)</label>
<input type="text" onKeypress="if(event.keycode<48 || if(event.keycode>57) event.returnValue = false;" class="form-control" maxlength="8" id="caja-error1" name="clave_docente" placeholder="Clave">
                      @if($errors -> has ('clave_docente'))
                          <span style="color:red;">{{ $errors -> first('clave_docente') }}</span>
                          <style>
                          #caja-error1
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
                                                   <div class="col-md-3 ">
                  <div class="form-group">
                      <label for="f_nac">Fecha de Nacimiento</label>
                          <input type="text" class="form-control datepicker nac" id="caja-error7" name="f_nac" placeholder="AAAA/MM/DD">
                          @if($errors -> has ('f_nac'))
                          <span style="color:red;">{{ $errors -> first('f_nac') }}</span>
                         <style>
                          #caja-error7
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                  </div>
                  </div>

              <div class="col-md-3 ">
               <div class="form-group">
                      <label for="rfc">RFC</label><br>
                      <input type="text" id="caja-error2" class="form-control" maxlength="13" name="rfc" placeholder="RFC" style="text-transform:uppercase">
                      @if($errors -> has ('rfc'))
                          <span style="color:red;">{{ $errors -> first('rfc') }}</span>
                         <style>
                          #caja-error2
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                </div>
              </div>                 
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3 ">
                    <div class="form-group">
                      <label for="dir">Direccion(Calle,No.,Localidad)</label>
                      <input type="text" class="form-control" id="caja-error4" name="dir" placeholder="Calle y número.." style="text-transform:uppercase">
                      @if($errors -> has ('dir'))
                          <span style="color:red;">{{ $errors -> first('dir') }}</span>
                         <style>
                          #caja-error4
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="correo">Correo</label>
                      <input type="text" class="form-control" <?php if($jefe_division==false) echo "disabled"; ?> value="{{ $correo}}" id="caja-error5" name="correo" placeholder="Correo.." style="text-transform:uppercase">
                    </div>
                  </div>
                                                      <div class="col-md-3 ">
                    <div class="form-group">
                      <label for="o_nac">Lugar de Nacimiento</label>
                      <input type="text" class="form-control" id="caja-error6" name="o_nac" placeholder="Origen Nac." style="text-transform:uppercase">
                      @if($errors -> has ('o_nac'))
                          <span style="color:red;">{{ $errors -> first('o_nac') }}</span>
                         <style>
                          #caja-error6
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
                                   <div class="col-md-3 ">
                     <div class="form-group">
                      <label for="esc_p">Esc. de Procedencia</label>
                      <input type="text" class="form-control" id="caja-error3" name="esc_p" placeholder="Escuela..." style="text-transform:uppercase">
                      @if($errors -> has ('esc_p'))
                          <span style="color:red;">{{ $errors -> first('esc_p') }}</span>
                         <style>
                          #caja-error3
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>      
              </div>         
            </div>

              <div class="row">
                <div class="col-md-12">
                   <div class="col-md-3 ml">
                    <div class="form-group">
                      <label for="telefono">Teléfono</label>
                      <input type="number" class="form-control" id="caja-error8" name="telefono" placeholder="Teléfono..">
                      @if($errors -> has ('telefono'))
                          <span style="color:red;">{{ $errors -> first('telefono') }}</span>
                         <style>
                          #caja-error8
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-3 ml">
                    <div class="form-group">
                      <label for="celular">Celular</label>
                      <input type="number" class="form-control" id="caja-error9" name="celular" placeholder="Celular..">
                      @if($errors -> has ('celular'))
                          <span style="color:red;">{{ $errors -> first('celular') }}</span>
                         <style>
                          #caja-error9
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
                                                      <div class="col-md-3 ml">
                    <div class="form-group">
                      <label for="cedula">Cedula</label>
                      <input type="number" class="form-control" maxlength="10" id="caja-error10" name="cedula" placeholder="Cedula..">
                      @if($errors -> has ('cedula'))
                          <span style="color:red;">{{ $errors -> first('cedula') }}</span>
                         <style>
                          #caja-error10
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-3 ml"> 
                    <div class="form-group"> 
                    <label for="f_ingreso">Fecha de Ingreso</label> 
                          <input type="text" class="form-control datepicker normal" id="caja-error11" name="f_ingreso" placeholder="AAAA/MM/DD">
                      @if($errors -> has ('f_ingreso'))
                          <span style="color:red;">{{ $errors -> first('f_ingreso') }}</span>
                         <style>
                          #caja-error11
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                      </div>  
                  </div>
                </div>           
              </div>

              <div class="row">
                <div class="col-md-12">
                                    <div class="col-md-3 ml">
                    <div class="form-group">
                      <label for="f_nac">Fecha de Contratacion</label>
                          <input type="text" class="form-control datepicker normal" id="caja-error14" name="f_contrata" placeholder="AAAA/MM/DD">
                       @if($errors -> has ('f_contrata'))
                          <span style="color:red;">{{ $errors -> first('f_contrata') }}</span>
                         <style>
                          #caja-error14
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                  </div>
                  </div>
                                    <div class="col-md-3 ml"> 
                    <div class="form-group">  
                      <div class="dropdown">
                        <label for="selectSexo">Sexo</label>
                                <select name="selectSexo" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                  <option value="F">F</option>
                                  <option value="M">M</option>
                                </select>
                    </div>  
                  </div>
                  </div>
                                                  <div class="col-md-3 ml">
                  <div class="form-group">    
                      <div class="dropdown">
                        <label for="selectEsc">Escolaridad</label>
                                <select name="selectEsc" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                  <option value="Tecnico">Tecnico</option>
                                  <option value="Licenciatura">Licenciatura</option>
                                  <option value="Maestria">Maestria</option>
                                  <option value="Doctorado">Doctorado</option>
                                    <option value="Preparatoria">Preparatoria</option>
                                    <option value="Secundaria">Secundaria</option>
                                </select>
                    </div>
                  </div>
                  </div>
                                    <div class="col-md-3 ml"> 
                  <div class="form-group">        
                      <div class="dropdown">
                        <label for="selectNombra">Nombramiento</label>
                                <select name="selectNombra" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                  <option value="T" selected>Temporal</option>
                                  <option value="D">Definitivo</option>
                                </select>
                    </div>
                    </div>      
                  </div>
                                                    <!-- <div class="col-md-3 ml">
                    <div class="form-group">
                      <label for="hrs_max_ingles">Hrs Max. Ingles</label>
                      <input type="number" class="form-control"  id="caja-error13" name="hrs_max_ingles" placeholder="Horas M..">
                      @if($errors -> has ('hrs_max_ingles'))
                          <span style="color:red;">{{ $errors -> first('hrs_max_ingles') }}</span>
                         <style>
                          #caja-error13
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>
                                                                <div class="col-md-3 ml">
                    <div class="form-group">
                      <label for="hrs_max">Horas Maximas</label>
                      <input type="number" class="form-control" id="caja-error12" name="hrs_max" placeholder="Horas M..">
                      @if($errors -> has ('hrs_max'))
                          <span style="color:red;">{{ $errors -> first('hrs_max') }}</span>
                         <style>
                          #caja-error12
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>-->
                </div>
              </div>
                  
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-3 ml">
                         <div class="form-group">  
                      <div class="dropdown">
                        <label for="selectPerfil">Perfil</label>
                                <select name="selectPerfil" id="selectPerfil" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($perfiles as $perfil)
                                            <option value="{{$perfil->id_perfil}}" >{{$perfil->descripcion}}</option>
                                    @endforeach
                                </select>
                    </div> 
                  </div>
                  </div>
                <div class="col-md-1 ml" style="margin-top:3em;padding-left: 0px;">
                  <button type="button" class="btn btn-primary b_perfil"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                </div> 
              <div class="col-md-3 ml">  
                  <div class="form-group">              
                      <div class="dropdown">
                        <label for="selectSituacion">Situacion</label>
                                <select name="selectSituacion" id="selectSituacion" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($situaciones as $situacion)
                                            <option value="{{$situacion->id_situacion}}" >{{$situacion->situacion}}</option>
                                    @endforeach
                                </select>
                    </div> 
                    </div>       
              </div>
               <div class="col-md-1 ml" style="margin-top:3em;padding-left: 0px;">
                  <button type="button" class="btn btn-primary b_situacion"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                </div> 
                                            <div class="col-md-3 ml">  
                  <div class="form-group">              
                      <div class="dropdown">
                        <label for="selectPersonal">Abreviación</label>
                                <select name="abrevia" id="selectAbrevia" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($abreviaciones as $abreviacion)
                                            <option value="{{$abreviacion->id_abreviacion}}" >{{$abreviacion->titulo}}</option>
                                    @endforeach
                                </select>
                    </div> 
                    </div>       
              </div> 
                             <div class="col-md-1 ml" style="margin-top:3em;padding-left: 0px;">
                  <button type="button" class="btn btn-primary b_abreviacion"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                </div> 
                                                 <!--   <div class="col-md-3 ml"> 
                    <div class="form-group">  
                      <div class="dropdown">
                        <label for="selectCargo">Cargo</label>
                                <select name="selectCargo" id="selectCargo"class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($cargos as $cargo)
                                            <option value="{{$cargo->id_cargo}}" >{{$cargo->cargo}}</option>
                                    @endforeach
                                </select>
                    </div>  
                  </div>
                  </div> 
               <div class="col-md-1 ml" style="margin-top:3em;padding-left: 0px;">
                  <button type="button" class="btn btn-primary b_cargo"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                </div> -->
            </div>
          </div>
                  <div class="col-md-3 col-md-offset-5 m">
                    <button id="guarda_docente" type="button" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>   Agregar</button>
                  </div>  
              </form>
            </div>
	  			</div>
		</div>	
	</div>

<!-- Modal para crear perfil-->
<div id="m_perfil" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Perfil</h4>
      </div>
      <div class="modal-body">
              <div class="row">
          <div class="col-md-10 col-md-offset-1">
              <div class="form-group">
                  <label for="nombre_perfil">Perfil:</label>
                  <input type="text" class="form-control" id="nombre_perfil" name="nombre_perfil" placeholder="Perfil...">
                  @if($errors -> has ('nombre_perfil'))
                          <span style="color:red;">{{ $errors -> first('nombre_perfil') }}</span>
                         <style>
                          #nombre_perfil
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
              </div>
          </div> 
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="guarda_perfil" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal para crear abreviacion-->
<div id="m_abreviacion" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Abreviación</h4>
      </div>
      <div class="modal-body">
              <div class="row">
          <div class="col-md-10 col-md-offset-1">
              <div class="form-group">
                  <label for="nombre_abre">Abreviación:</label>
                  <input type="text" class="form-control" id="nombre_abre" name="nombre_abre" placeholder="Abreviación...">
                  @if($errors -> has ('nombre_abre'))
                          <span style="color:red;">{{ $errors -> first('nombre_abre') }}</span>
                         <style>
                          #nombre_abre
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
              </div>
          </div> 
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="guarda_abreviacion" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal para crear cargo-->
<div id="m_cargo" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Cargos</h4>
      </div>
      <div class="modal-body">
              <div class="row">
          <div class="col-md-7 col-md-offset-1">
              <div class="form-group">
                  <label for="nombre_cargo">Cargo:</label>
                  <input type="text" class="form-control" id="nombre_cargo" name="nombre_cargo" placeholder="Cargo...">
                  @if($errors -> has ('nombre_cargo'))
                          <span style="color:red;">{{ $errors -> first('nombre_cargo') }}</span>
                         <style>
                          #nombre_cargo
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
              </div>
          </div> 
                    <div class="col-md-3 ">
              <div class="form-group">
                  <label for="c_abrevia">Abreviación:</label>
                  <input type="text" class="form-control" id="c_abrevia" name="c_abrevia" placeholder="Abreviación...">
                  @if($errors -> has ('c_abrevia'))
                          <span style="color:red;">{{ $errors -> first('c_abrevia') }}</span>
                         <style>
                          #c_abrevia
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
              </div>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="guarda_cargo" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal para crear situacion-->
<div id="m_situacion" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Situaciones</h4>
      </div>
      <div class="modal-body">
              <div class="row">
          <div class="col-md-7 col-md-offset-1">
              <div class="form-group">
                  <label for="nombre_situacion">Situación:</label>
                  <input type="text" class="form-control" id="nombre_situacion" name="nombre_situacion" placeholder="Situación...">
                  @if($errors -> has ('nombre_situacion'))
                          <span style="color:red;">{{ $errors -> first('nombre_situacion') }}</span>
                         <style>
                          #nombre_situacion
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
              </div>
          </div> 
          <div class="col-md-3 ">
              <div class="form-group">
                  <label for="s_abrevia">Abreviación:</label>
                  <input type="text" class="form-control" id="s_abrevia" name="s_abrevia" placeholder="Abreviación...">
                  @if($errors -> has ('s_abrevia'))
                          <span style="color:red;">{{ $errors -> first('s_abrevia') }}</span>
                         <style>
                          #s_abrevia
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
              </div>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="guarda_situacion" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</main>

<script>
$(document).ready(function() {
  $(".b_perfil").click(function(event){
    $("#m_perfil").modal("show");
  });
    $(".b_abreviacion").click(function(event){
    $("#m_abreviacion").modal("show");
  });
      $(".b_cargo").click(function(event){
    $("#m_cargo").modal("show");
  });
        $(".b_situacion").click(function(event){
    $("#m_situacion").modal("show");
  });

   $("#guarda_docente").click(function(event){
            $("#form_docente_crea").submit();
    });
//////aqui hay que ver
  $("#guarda_perfil").click(function(event){
      var perfil=$("#nombre_perfil").val();
          $("#selectPerfil tbody").empty();

      $.get('/docentes/perfiles/'+perfil,{},function(request){
        var datos=request['perfiles'];
        for (var i=0; i<datos.length ; i++) 
        {
          var perfil='<option value="'+datos[i].id_perfil+'">'+datos[i].descripcion+'</option>';
          $("#selectPerfil").append(perfil);
        }
        $("#m_perfil").modal("hide");
      }); 
  });

  $("#guarda_abreviacion").click(function(event){
      var abrevia=$("#nombre_abre").val();
    $("#selectAbrevia tbody").empty();

      $.get('/docentes/abreviaciones/'+abrevia,{},function(request){
        var datos=request['abreviaciones'];
        //console.log(datos);
        for (var i=0; i<datos.length ; i++) 
        {
          var abrevia='<option value="'+datos[i].id_abreviacion+'">'+datos[i].titulo+'</option>';
          $("#selectAbrevia").append(abrevia);
        }
        $("#m_abreviacion").modal("hide");
      }); 
  });

  $("#guarda_cargo").click(function(event){
      var cargo=$("#nombre_cargo").val();
      var c_abrevia=$("#c_abrevia").val();

          $("#selectCargo tbody").empty();

      $.get('/docentes/cargos/'+cargo+'/'+c_abrevia,{},function(request){
        var datos=request['cargos'];
        //console.log(datos);
        for (var i=0; i<datos.length ; i++) 
        {
          var cargo='<option value="'+datos[i].id_cargo+'">'+datos[i].cargo+'</option>';
          $("#selectCargo").append(cargo);
        }
        $("#m_cargo").modal("hide");
      });       
  });

  $("#guarda_situacion").click(function(event){
      var situacion=$("#nombre_situacion").val();
      var s_abrevia=$("#s_abrevia").val();
          $("#selectSituacion tbody").empty();

      $.get('/docentes/situaciones/'+situacion+'/'+s_abrevia,{},function(request){
        var datos=request['situaciones'];
        for (var i=0; i<datos.length ; i++) 
        {
          var situacion='<option value="'+datos[i].id_situacion+'">'+datos[i].situacion+'</option>';
          $("#selectSituacion").append(situacion);
        }
        $("#m_situacion").modal("hide");
      });       
  });

          $("#form_docente_crea").validate({
            rules: {
           nombre_docente: {
            required: true,
          },
                     clave_docente: {
            required: true,
          },
                     f_contrata: {
            required: true,
          },
                               f_ingreso: {
            required: true,
          },
                               cedula: {
            required: true,
          },
                               celular: {
            required: true,
          },
                               telefono: {
            required: true,
          },
                               f_nac: {
            required: true,
          },
                               o_nac: {
            required: true,
          },
                               dir: {
            required: true,
          },
                               esc_p: {
            required: true,
          },
                               hrs_max: {
            required: true,
          },
                               rfc: {
            required: true,
          },
          h_clave: {
            required: true,
          },

            selectSituacion : "required",
            selectPerfil : "required",
            selectSexo : "required", 
            selectEsc : "required",
            selectNombra : "required",
            abrevia : "required",      
        },            
          });
});

    $('.nac').datepicker({
        format: "yyyy/mm/dd",
        language: "es",
        autoclose: true,
        startDate: "-90y",
        endDate:"-18y"
    });
    $('.normal').datepicker({
        format: "yyyy/mm/dd",
        language: "es",
        autoclose: true
    });
</script>
@endsection
