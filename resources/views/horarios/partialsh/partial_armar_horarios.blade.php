<div class="col-md-2">
      <table class="table table-bordered chica">
                          <tbody>
                            @foreach($ver_totales as $totaless)
                            <tr>
                              <td>{{ $totaless->nombre }}</td>
                              <td>{{ $totaless->sumaa }}</td>
                            </tr>
                            @endforeach
                            <tr class="borde">
                              <td>Total de Horas:</td>
                              <td>{{ $ssuma }}</td>
                            </tr>
                          </tbody>
      </table>

      @if($imprime==1)
      
        <div class="col-md-2">

        <button class="btn btn-primary crear" data-toggle="modal" data-target="#modal_periodo_change"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</button>
                        </div>
      @endif
</div>


<main class="col-md-12">

<input type="hidden" id="notifi" name="notifi" value="{{ $noti }}"/>
<input type="hidden" id="estado" name="estado" value="{{ $estado }}"/>

<div class="col-md-11 cont" id="horario" >
  <input type="hidden" value="" id="checa" />

<div class="alert alert-danger" role="alert" id="notifi_bloqueo" style="display:none">
  Elementos bloqueados hasta completar hrs para: {{ $nombre_materia }}
</div>

<table class="table table-bordered text-center" style="table-layout:fixed;">
    <thead>
        <tr>
          <th>Hora/Día</th>
            @foreach($dias as $diass)
              <th>{{ $diass->dia }}</th>
            @endforeach
          <th>Totales</th>
        </tr>
    </thead>
    <tbody>  
        <?php $contador=1 ?>
        <?php $totalesf=0 ?>
        <?php $totalest=0 ?>
            @foreach($semanas as $semanass)
                @if($contador==1)
                    <tr>                                                   
                      <td class="horario">{{ $semanass->hora }}</td> 
                @endif 
                <?php $bandera_ok=true; ?> 
                <?php $bandera_max=true; ?>

                      <td id="{{ $semanass->id_semana }}" class="horario"> 
                      @foreach($horarios as $horario)                    
                          @if($horario->id_semana==$semanass->id_semana) 
                              @if($id_carrera==$horario->id_carrera)
                                  <?php $bandera_ok=false; ?>
                                  <?php $bandera_max=false; ?>
                                     
                                    @if($horario->estado==2)
                                      @if($contar>=$hrs_maximas)
                                        <div style="font-weight:bold; height:7.5em; vertical-align:middle;">
                                            {{ "HORAS MÁXIMAS" }}
                                          </div>
                                      @else
                                        @if($horario->especial==1)
                                          @if($horario->checa_esp<2)
                                          <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->nombre }}<br> {{ $horario->materia }} <br> {{ $horario->grupo }}" style="font-weight:bold; vertical-align:middle;background-color: #ccffcc;">
                                            <a id="{{ $semanass->id_semana }}" class="guarda"><span class="glyphicon glyphicon-ok em5" aria-hidden="true"></span></a>
                                          <br><br>
                                          {{ $semanass->dia }}
                                          <br><br>
                                          </div>
                                          @else
                                          <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->nombre }}<br> {{ $horario->materia }} <br> {{ $horario->grupo }}" style="font-weight:bold; color:{{ $horario->color }}; vertical-align:middle;">
                                            <br>{{ "AULA OCUPADA" }}
                                            </div> 
                                          @endif
                                        @else
                                            <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->nombre }}<br> {{ $horario->materia }} <br> {{ $horario->grupo }}" style="font-weight:bold; color:{{ $horario->color }}; height:9em; vertical-align:middle;">
                                            <br><br>
                                              {{ "AULA OCUPADA" }}
                                            <br><br>
                                            <br><br>
                                            </div> 
                                        @endif                         
                                      @endif
                                    @else
                                      @if($horario->estado==3)
                                        @if($contar>=$hrs_maximas)
                                          <div style="font-weight:bold; height:7.5em; vertical-align:middle;">
                                            {{ "HORAS MÁXIMAS" }}
                                          </div>
                                         @else
                                            @if($horario->especial==1)
                                              @if($horario->checa_esp<2)
                                                <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->nombre }}<br> {{ $horario->materia }} <br> {{ $horario->grupo }}" style="font-weight:bold; vertical-align:middle;background-color: #ccffcc;">
                                                  <a id="{{ $semanass->id_semana }}" class="guarda"><span class="glyphicon glyphicon-ok em5" aria-hidden="true"></span></a>
                                                <br><br>
                                                {{ $semanass->dia }}
                                                <br><br>
                                                </div>
                                                @else
                                                <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->nombre }}<br> {{ $horario->materia }} <br> {{ $horario->grupo }}" style="font-weight:bold; color:{{ $horario->color }}; vertical-align:middle;">
                                                  <br>{{ "GRUPO OCUPADO" }}
                                                  </div> 
                                                @endif
                                            @else
                                                <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->nombre }}<br>{{ $horario->materia }} <br> {{ $horario->aula }}" style="font-weight:bold; color:{{ $horario->color }}; height:9em; vertical-align:middle;">
                                                  <br><br>
                                                  {{ "GRUPO OCUPADO" }} 
                                                  <br><br>
                                                </div>
                                            @endif
                                        @endif
                                      @else
                                      @if($contador==1)
                                          <input name="uno[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==2)
                                          <input name="dos[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==3)
                                          <input name="tres[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==4)
                                          <input name="cua[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==5)
                                          <input name="cinco[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==6)
                                          <input name="seis[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        <input type="hidden" value="{{ $horario->hrs_prof }}" name="hrsprof"/> 
                                        <input type="hidden" value="{{ $horario->rhps }}" name="rhps"/>                             
                                        <div class="tooltip-options link" data-toggle="tooltip" data-placement="right"title="{{ $horario->clave }}">{{ $horario->materia }}
                                        <!--si materia es especial y el profesor es diferente se agrega en el div -->
                                        <div>
                                        @if( $horario->grupo == 0) 
                                          {{ $horario->abre }}
                                        @else
                                          Grupo {{ $horario->grupo }}:{{ $horario->abre }}
                                        @endif
                                        <div>{{ $horario->aula }}</div>
                                        <?php $totalesf++; ?>
                                        <div><a class="elimina" id="{{ $horario->rhps }}" data-mat="{{ $horario->idmat }}"><span class="glyphicon glyphicon-remove em4" aria-hidden="true"></span></a></div>
                                        </div>
                                        </div>
                                      @endif  
                                    @endif
                              @else
                                  <?php $bandera_ok=false; ?>
                                  <?php $bandera_max=false; ?> 
                                  @if($horario->estado==2)
                                    @if($contar>=$hrs_maximas)
                                      <div style="font-weight:bold; height:7.5em; vertical-align:middle;">
                                            {{ "HORAS MÁXIMAS" }}
                                          </div>
                                      @else
                                      <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->carrera }} <br> {{ $horario->nombre }}<br> {{ $horario->materia }} <br> {{ $horario->grupo }}" style="font-weight:bold; color:{{ $horario->color }}; height:9em; vertical-align:middle;">
                                        <br><br>
                                          {{ "AULA OCUPADA" }}
                                        <br><br>
                                      </div>
                                    @endif
                                  @else
                                    @if($horario->estado==3)
                                      @if($contar>=$hrs_maximas)
                                        <div style="font-weight:bold; height:7.5em; vertical-align:middle;">
                                          {{ "HORAS MÁXIMAS" }}
                                        </div>
                                      @else
                                        <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->carrera }} <br> {{ $horario->nombre }}<br>{{ $horario->materia }} <br> {{ $horario->aula }}" style="font-weight:bold; color:{{ $horario->color }}; height:9em; vertical-align:middle;">
                                          <br><br>
                                          {{ "GRUPO OCUPADO" }}
                                          <br><br>
                                        </div>
                                      @endif
                                    @else
                                      @if($contador==1)
                                          <input name="uno[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==2)
                                          <input name="dos[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==3)
                                          <input name="tres[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==4)
                                          <input name="cua[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==5)
                                          <input name="cinco[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif 
                                        @if($contador==6)
                                          <input name="seis[]" type="checkbox" checked="checked" style="display:none"/>
                                        @endif  
                                      <div class = "tooltip-options link" data-toggle="tooltip" data-placement="right" title = "{{ $horario->materia }} <br> {{ $horario->grupo }}" style="font-weight:bold; color:{{ $horario->color }}; height:9em; vertical-align:middle;"><br>
                                        {{ $horario->carrera }}  
                                        <?php $totalesf++; ?>
                                      </div>
                                    @endif
                                  @endif
                              @endif
                          @endif   
                      @endforeach

                      @if($contar >= $hrs_maximas)
                          @if($bandera_max)
                            <div style="font-weight:bold; height:7.5em; vertical-align:middle;">
                              {{ "HORAS MÁXIMAS" }}
                            </div>
                          @endif
                      @else 
                          @if($bandera_ok)  
                            <?php $bandera_max=false; ?>                              
                            <div style="height:7.5em;"> <a id="{{ $semanass->id_semana }}" class="guarda"><span class="glyphicon glyphicon-ok em5" aria-hidden="true"></span></a> <br><br>{{ $semanass->dia }}</div>
                          @endif
                       @endif
                      <?php $contador++?> 

                      @if($contador==7)
                        <?php $contador=1 ?> 
                      </td>
                      <td>
                        <input name="totales[]" value="{{ $totalesf }}" type="checkbox" checked="checked" style="display:none"/>
                        <?php $totalest=$totalest+$totalesf; ?>
                        {{ $totalesf }}
                        <?php $totalesf=0 ?>
                      </td>            
                  </tr>
                      @endif
            @endforeach    
            <tr>
              <td></td>
                <td><label id="dos" value=""></label></td>
                <td><label id="tres" value=""></label></td>
                <td><label id="cuatro" value=""></label></td>
                <td><label id="cinco" value=""></label></td>
                <td><label id="seis" value=""></label></td>
                <td><label id="siete" value=""></label></td>
                <td>{{ $totalest }}</td>
            </tr>                                                                                       
    </tbody>
</table>
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
        <input type="hidden" id="id_materia" name="id_materia" value="" />
        <input type="hidden" id="t_doc" value="" />
      </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <input id="confirma_elimina" type="button" class="btn btn-danger" data-dismiss="modal" value="Aceptar"></input>
      </div>
</form>
      </div>
    </div>
  </div>
</div>
</main>

<script>

function bloqueo()
{
    $.blockUI({
  });
}
$(document).ready(function() 
{ 

  $(".link").tooltip({html:true});

var total1 = $("input[name='uno[]']:checked").length;
var total2 = $("input[name='dos[]']:checked").length;
var total3 = $("input[name='tres[]']:checked").length;
var total4 = $("input[name='cua[]']:checked").length;
var total5 = $("input[name='cinco[]']:checked").length;
var total6 = $("input[name='seis[]']:checked").length;
var totales=[];

$('input[name="totales[]"]:checked').each(function()
{
    totales[totales.length]=$(this).val();
});

document.getElementById('dos').innerHTML = total1;
document.getElementById('tres').innerHTML = total2;
document.getElementById('cuatro').innerHTML = total3;
document.getElementById('cinco').innerHTML = total4;
document.getElementById('seis').innerHTML = total5;
document.getElementById('siete').innerHTML = total6;


$(".guarda").click(function()
  {
    var id=$(this).attr('id');
    $("#idsemana").val(id);  
    //alert(id);

    if($("#selectMateria").valid()&&$("#selectAula").valid())
      {
        var mat=$("#selectMateria").val();

        if(mat==20005)
        {
          if($("#selectAula").valid()&&$("#selectGestion").valid()&&$("#SelectGrupoT").valid())
          {
              var grup=$("#SelectGrupoT").val();
            var n = grup.length;
            if(n==3)
            {
              bloqueo();
              agrega();
            }
            else
            {
              alert("El grupo debe ser de 3 cifras");
            }
          }
        }
        else if(mat==20001 || mat==20003)
        {
          if($("#selectAula").valid()&&$("#descripcion").valid())
          {
            bloqueo();
            agrega();
          }
        }
        else if(mat==20002)
        {
          if($("#selectAula").valid()&&$("#SelectGrupoT").valid())
          {
            var grup=$("#SelectGrupoT").val();
            var n = grup.length;
            if(n==3)
            {
              bloqueo();
              agrega();
            }
            else
            {
              alert("El grupo debe ser de 3 cifras");
            }
          }
        }
        else if(mat==20006)
        {
          if($("#selectAula").valid()&&$("#selectVinculacion").valid())
          {
            bloqueo();
            agrega();
          }
        }
        else if($("#selectGrupo").valid())
        {
          bloqueo();
            agrega();
        }
      }

    });
  $(".elimina").click(function(){
      var id=$(this).attr('id');//rhps

      var did=$(this).data('mat'); //materia
      $('#id_materia').val(did);
      $('#confirma_elimina').data('id',id);

      $('#modal_elimina').modal('show');
    });

    $("#confirma_elimina").click(function(){
      bloqueo();
        var idrhps=($(this).data('id'));//rhps
        var id_mat=$('#id_materia').val();

          if(id_mat>20000)
          {
            var decision=2;
          }
          else
          {
            var decision=1;
          }
          $("#decision").val(decision);
          $("#idaula").val(idrhps);
     
            $.post("/elimina_horario",$("#form_arma_horario").serialize(),function(request)
            {
              $("#contenedor_horarios").html(request);
              $.unblockUI();
            });
        });

              $("#form_arma_horario").validate({
            rules: {
            selectGrupoT: {
              required: true,
              minlength: 3,
              },
            descripcion: {
              required: true,
              },
              mat: {
              required: true,
              },
            selectGrupo : "required",
            selectAula : "required",  
            SelectGrupoT : "required",
            selectGestion : "required",
            selectVinculacion : "required" ,
            selectMateria: "required" 
        },            
          });
$.unblockUI();
});
function agrega()
{    
            $.post("/agrega_horario",$("#form_arma_horario").serialize(),function(request)
                        {
                           $.unblockUI();
                        $("#contenedor_horarios").html(request);
                        });

}
  var error=$('#notifi').val();
  if(error>0)
  {
    //alert(error);
    $('#notificacion'+error).modal('show');
  }

@if($ok=="false")
  $('.bloqueo').removeClass('disabled');
  $('#selectMateria').prop('disabled', false);
  $('#selectProfesor').prop('disabled', false);
  $('#notifi_bloqueo').hide(1000);
@else
    $('.bloqueo').addClass('disabled');
    $('#selectProfesor').prop('disabled', true);
    $('#notifi_bloqueo').show(1000);
@endif
        </script>

