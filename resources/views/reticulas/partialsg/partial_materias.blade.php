 <?php $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
 $directivo=session()->has('directivo')?session()->has('directivo'):false; ?>

<div>

<ul class="nav nav-tabs" role="tablist">
  @foreach($semestres as $semes)
    @if($semes["id_semestre"]==1)
      <li role="presentation" class="active"><a href="#{{ $semes["id_semestre"] }}s" aria-controls="profile" role="tab" data-toggle="tab">{{ $semes ["semestre"]}}</a></li>
    @else
      <li role="presentation"><a href="#{{ $semes["id_semestre"] }}s" aria-controls="profile" role="tab" data-toggle="tab">{{ $semes ["semestre"]}}</a></li>
    @endif
  @endforeach
</ul>


        <!-- Tab panes -->
    <div class="tab-content">
        @foreach($semestres as $semes)
                     <div role="tabpanel" class="tab-pane fade <?php if($semes["id_semestre"]==1) echo"in active"; ?>" id="{{ $semes["id_semestre"] }}s">
            <div style="margin-top:1em;" class="panel panel-info text-center col-md-5 col-md-offset-3">
                <h4 >Materias de {{ $semes["semestre"] }}</h4>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-1">
            @foreach($semes["materias"] as $materias)
                <div class="col-md-2 materia text-center">
                  {{ $materias["materia"]}}<br>
                    {{ $materias["clave"] }}<br>
                    {{ $materias["hrs_t"]}}-{{ $materias["hrs_p"]}}-{{ $materias["creditos"]}}
                  @if($jefe_division!=null)
                    <div class="row">
                        <div class="col-md-2 col-md-offset-3">
                            <a class="editar" id="{{ $materias["id_materia"]}}" ><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                        </div>
                        <div class="col-md-2 col-md-offset-1">
                            <a class="elimina" id="{{ $materias["id_materia"]}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                        </div> 
                    </div> 
                  @endif

                </div>
          @endforeach
              </div>         
            </div>
          </div>
        @endforeach
    </div>
@if($jefe_division==1)
       <div class="row text-center">
        <button data-toggle="modal" id="abre_modal" data-tooltip="true" data-placement="left" title="Agrega una materia" data-target="#agrega_materias" type="button" class="btn btn-success btn-lg flotante">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>

      <!--<div class="col-md-3 col-md-offset-5 ml">
        <button id="recoje_combo" type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> Ver PDF</button>
      </div>-->
@endif
</div>

<!-- MODAL PARA EDITAR MATERIAS -->
  <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modificación Materias</h4>
      </div>
      <div class="modal-body">
          <div id="warnin" class="alert alert-danger" role="alert" style="display:none">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>El número de hrs. es incorrecto</strong>
  </div>
        <div id="contenedor_editar">

        </div>    
      </div> <!-- modal body  -->

      <div class="modal-footer">
        <input id="modifica_materia" type="button" class="btn btn-primary" value="Guardar" />
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

      <script>
  $(document).ready(function(){

    $("#modal_modifica").modal("show");

$("#modifica_materia").click(function(){

          var hp=$("#hrs_p").val();
          var ht=$("#hrs_t").val();

          if(hp==0 && ht==0)
          {
            $("#warnin").show(1000);
          }
          else
          {
            if($("#nombrem").valid()&&$("#clavem").valid()&&$("#nombrem").valid()&&$("#creditos").valid()&&
              $("#hrs_p").valid()&&$("#hrs_t").valid()&&$("#unidades").valid()&&$("#espe").valid())
            {
              $("#warnin").hide(1000);
              $("#form_update_materia").submit(); 
            }
          } 
        });

         $("#abre_modal").click(function(){
            var id_reticula= $("#selectReticula").val();
            $("#reticula").val(id_reticula);
        });

      $(".editar").click(function(){
        var idmat=$(this).attr('id');

        $.get("/reticulasmo/"+idmat+"/edit",function(request)
            {
              $("#contenedor_editar").html(request);
              $("#modal_editar").modal("show");
            });

        });

                    $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            $('#modal_elimina').modal('show');
        });
              
          $("#confirma_elimina").click(function(event){
          var id_mat=($(this).data('id'));
          $("#form_delete").attr("action","/reticulass/"+id_mat);      
          $("#form_delete").submit();
         /*$.get("/reticulass_elimina/"+id_mat,function(request)
            {
              //$("#contenedor_materias").html(request);
              $('.modal-backdrop').remove();
              //$("#modal_editar").modal("show");
            });*/
        });

$("#form_update_materia").validate(
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

