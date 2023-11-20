@extends('layouts.app')
@section('title', 'Reticulas')
@section('content')


<main class="col-md-12">

 <?php $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
 $directivo=session()->has('directivo')?session()->has('directivo'):false;
 $consultas=session()->has('consultas')?session()->has('consultas'):false; 
?>

<div class="row">
	<div class="col-md-5 col-md-offset-3">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">Reticulas</h3>
	  		</div>
	  					<div class="panel-body">
                @if($directivo==1 || $consultas==1)
                <input type="hidden" id="tipo" name="tipo" value="1"> 
                            <div class="col-md-5 col-md-offset-1">
                              <div class="dropdown">
                                <label for="dropdownMenu1">Carrera</label>
                                 <select name="selectCarrera" id="selectCarrera" class="form-control ">
                                  <option disabled selected>Selecciona carrera...</option>
                                    @foreach($carreras as $carrera)
                                      @if($carrera->id_carrera==$id_carrera2)
                                            <option value="{{$id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                      @else
                                        <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                      @endif
                                    @endforeach
                                </select>
                            </div>
                            </div> 
                                                        <div class="dropdown col-md-6 col-sm-6" id="div_reticula" style="display:none">
                                                          <label for="dropdownMenu1">Reticula</label>
                                <select name="selectReticula" id="selectReticula" class="form-control">
                                  <option disabled selected>Selecciona reticula...</option>
                                @foreach($reticulas as $reticula)
                                  @if($reticula->id_reticula==$id_reticula2)
                                  <option value="{{$reticula->id_reticula}}" selected="selected">{{$reticula->clave}}</option>
                                  @else
                                  <option value="{{$reticula->id_reticula}}" >{{$reticula->clave}}</option>
                                  @endif                                                             
                                @endforeach
                                </select>
                            </div>
                @else
                <input type="hidden" id="tipo" name="tipo" value="2"> 
                            <div class="dropdown col-md-6 col-sm-6" id="div_reticula">
                                <select name="selectReticula" id="selectReticula" class="form-control">
                                  <option disabled selected>Selecciona reticula...</option>
                                @foreach($reticulas as $reticula)
                                  @if($reticula->id_reticula==$id_reticula2)
                                  <option value="{{$reticula->id_reticula}}" selected="selected">{{$reticula->clave}}</option>
                                  @else
                                  <option value="{{$reticula->id_reticula}}" >{{$reticula->clave}}</option>
                                  @endif                                                             
                                @endforeach
                                <option value="00" >Agrega Reticula</option>
                                </select>
                            </div>
                @endif
	  				    </div>
		</div>	
	</div>
</div>	

<div id="contenedor_materias">

</div>

<!-- Modal para crear reticula-->
<form id="form_reticula">
<div id="agrega_reticula" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button id="cierra" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Reticulas</h4>
      </div>
      <div class="modal-body">
              <div class="row">
          <div class="col-md-10 col-md-offset-1">
              <div class="form-group">
                  <label for="nombre_reticula">Nombre:</label>
                  <input type="text" class="form-control" id="reti" name="nombre_reticula" placeholder="Materia" style="text-transform:uppercase">
                  @if($errors -> has ('nombre_reticula'))
                          <span style="color:red;">{{ $errors -> first('nombre_reticula') }}</span>
                         <style>
                          #reti
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
        <button id="cierra" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="guarda_reticula" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>

<!-- Modal para agregar materias-->
<form id="form_materia_crea" class="form" role="form" method="POST">
  <div class="modal fade" id="agrega_materias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Agregar Materias</h4>
        </div>
        <div class="modal-body">
            <div id="warninn" class="alert alert-danger" role="alert" style="display:none;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>El número de hrs. es incorrecto</strong>
            </div>

          {{ csrf_field() }}
            <div class="row">
      <input name="reticula" type="hidden" id="reticula" value="">

      <div class="col-md-12">
          <div class="col-md-10 col-md-offset-1">
              <div class="form-group">
                  <label for="nombre_materia">Nombre de la Materia:</label>
                  <input type="text" class="form-control" id="nombrem" name="nombre_materia" placeholder="Materia" style="text-transform:uppercase">
                  @if($errors -> has ('nombre_materia'))
                    <span style="color:red;">{{ $errors -> first('nombre_materia') }}</span>
                      <style>
                      #nombrem
                      {
                        border:solid 1px red;
                      }
                      </style>
                  @endif
              </div>
          </div> 
      </div>

      <div class="col-md-12">
          <div class="col-md-10 col-md-offset-1" >
              <div class="form-group">
                  <label for="clave_materia">Clave de la Materia:</label>
                  <input type="text" class="form-control" maxlength="10" id="clavem" name="clave_materia" placeholder="Clave" style="text-transform:uppercase">
                  @if($errors -> has ('clave_materia'))
                    <span style="color:red;">{{ $errors -> first('clave_materia') }}</span>
                    <style>
                    #clavem
                    {
                      border:solid 1px red;
                    }
                    </style>
                  @endif
              </div>
          </div>
        </div>                           
    <div class="col-md-12">
        <div class="col-md-3 col-md-offset-1 ml">
            <div class="form-group"> 
                <label for="semestre">Semestre</label> 
                <select name="semestre" id="sem" class="form-control ">
                <option disabled selected>Elige...</option>
                  @foreach($semestres as $semestre)
                  <option value="{{ $semestre->id_semestre }}">{{ $semestre->descripcion }}</option>
                  @endforeach
                </select> 
            </div>
        </div>
        <div class="col-md-3 ml">
            <div class="form-group">
                <label for="hrs_t">Hrs.Teoria</label>
                <select name="hrs_t" id="hrs_t"class="form-control ">
                    <option disabled selected >Elige...</option>
                    @for ($i = 0; $i <=6; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-3 ml">
            <div class="form-group">
                <label for="hrs_p">Hrs.Practicas</label>
                <select name="hrs_p" id="hrs_p"class="form-control ">
                    <option disabled selected>Elige...</option>
                    @for ($i = 0; $i <=6; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div clas="col-md-12">
        <div class="col-md-3 col-md-offset-1 ml">
            <div class="form-group">              
                <label for="uni">Unidades</label> 
                <select name="uni" id="unidades" class="form-control ">
                <option disabled selected>Elige...</option>
                  @for ($i = 1; $i <=10; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select> 
            </div> 
        </div>
        <div class="col-md-3 ml"> 
            <div class="form-group">              
                <label for="especial">Especial</label> 
                <select name="especial" id="espe" class="form-control ">
                  <option disabled selected >Elige...</option>
                  <option value="1">Si</option>
                  <option value="0">No</option>
                 </select> 
            </div> 
        </div> 
        <div class="col-md-3 ml"> 
            <div class="form-group">              
                <label for="creditos">Creditos</label> 
                <select name="creditos" id="creditos" class="form-control ">
                  <option disabled selected >Elige...</option>
                  @for ($i = 1; $i <=10; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select> 
            </div> 
        </div> 
    </div>
 </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <input id="guarda_materia" type="button" class="btn btn-primary" value="Guardar"/>
        </div>
      </div>
  </div>
</div>
</form>


</main>

    <script>
    var ret = '{{$id_reticula2}}';
    if(ret>0)
    {
      $.get("/ver/reticulas/"+ret,function(request)
            {
               $("#contenedor_materias").html(request);
            });
    }

$(document).ready(function() {


$("#selectCarrera").on('change',function(e){
  var carrera=$("#selectCarrera").val();
  $("#selectReticula").empty();

     $.get('/ver/reticulas/directivo/'+carrera,{},function(request){
        var datos=request['reticulas'];
        var retis1='<option disabled selected>Selecciona reticula...</option>';
        $("#selectReticula").append(retis1);
        for (var i=0; i<datos.length ; i++) 
        {
          var retis='<option value="'+datos[i].id_reticula+'">'+datos[i].clave+'</option>';
          $("#selectReticula").append(retis);
        }
           $("#div_reticula").show(1000);
      }); 
});

  $("#selectReticula").on('change',function(e){
    var tipo=$("#tipo").val();
    var id_reticula= $("#selectReticula").val();
    if(tipo==1)//directivo
    {
      var id_carrera= $("#selectCarrera").val();
      $.get("/ver/materias/directivo/"+id_carrera+'/'+id_reticula,function(request)
            {
               $("#contenedor_materias").html(request);
            });
    }
    else
    {
      if (id_reticula==00) 
        {
          $("#agrega_reticula").modal("show");
        }
        else
        {
          $.get("/ver/reticulas/"+id_reticula,function(request)
            {
               $("#contenedor_materias").html(request);
            });
        }
    }

    });

$("#guarda_reticula").click(function(){
  if($("#reti").valid())
  {
    var retii= $("#reti").val();
          window.location.href='/agrega/reticulas/'+retii;
  }
        });

$("#guarda_materia").click(function(event){

     if($("#nombrem").valid()&&$("#clavem").valid()&&$("#sem").valid()&&$("#hrs_p").valid()&&
    $("#hrs_t").valid()&&$("#unidades").valid()&&$("#espe").valid()&&$("#creditos").valid())
    {
        var hp=$("#hrs_p").val();
        var ht=$("#hrs_t").val();

      if(hp==0 && ht==0)
      {
        //alert("deshabilitar");
        $('#warninn').show(1000);
      }
      else
      {
        $.post("/agregar_materias/", $("#form_materia_crea").serialize(),function(request)
          {
            $("#contenedor_materias").html(request);
            $("#warnin").hide(1000);
            $("#agrega_materias").modal("hide");
            $("#form_materia_crea")[0].reset();
            /*$('#nombrem').focus(
              function(){
                  $(this).val('');
              });
            $('#clavem').focus(
              function(){
                  $(this).val('');
              });
             $('#sem').focus(
              function(){
                  $(this).val('Elige...');
              });*/
          });
      }
    }
      });

  $("#form_reticula").validate(
  {
    rules: 
    {
      nombre_reticula: 
      {
        required: true,
      }
    },            
  });

    $("#form_materia_crea").validate(
  {
    rules: 
    {
      nombre_materia: 
      {
        required: true,
      },
      clave_materia:
      {
        required: true,
      },
      semestre : "required",
            hrs_p : "required",  
            hrs_t : "required",
            uni : "required",
            especial : "required" ,
            creditos: "required" 
    },            
  });

});
        </script>
@endsection
