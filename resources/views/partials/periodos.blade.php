@section('part_modal_periodos')

<?php

$arre_periodos=Session::get('arre_periodos');

$periodo_anterior=Session::get('periodo_anterior');
$p1=Session::get('p1')->periodo;

$periodo_actual=Session::get('periodo_actual');
$p2=Session::get('p2')->periodo;

//$periodo_siguiente=Session::get('periodo_siguiente');
//$p3=Session::get('p3')->periodo;
//print_r(Session::get('periodo_anterior'));
?>

    <script>
  $(document).ready(function(){


     var id={!!$periodo_actual!!};

     var ante=id-1;
     var actual=id;
     var sig=id+1;
     var ocultar=0;



          $("#periodo").click(function(){
           $('#modal_periodo').modal('show');

                @foreach($arre_periodos as $per)

                   if(ante=={{$per->id_periodo}}||actual=={{$per->id_periodo}}||sig=={{$per->id_periodo}})
                   {
                      $('#tr{{$per->id_periodo}}').show();
                   }
                   else
                   {
                    $('#tr{{$per->id_periodo}}').hide();
                   }
                @endforeach
          });


          $('#arriba').click(function()
          {


              actual=actual-1;
             $('#tr'+actual).show();
             sig=actual+1;
             $('#tr'+sig).show();
             ante=actual-1;
             $('#tr'+ante).show();

             ocultar=actual+2;
             $('#tr'+ocultar).hide();


          });

          $('#abajo').click(function()
          {
             actual=actual+1;
             $('#tr'+actual).show();
             ante=actual-1;
             $('#tr'+ante).show();
             sig=actual+1
             $('#tr'+sig).show();

             ocultar=actual-2;
             $('#tr'+ocultar).hide();


          });



$('#modal_periodo').on('hidden.bs.modal',function(){

  ante=id-1;
  actual=id;
  sig=id+1;
  ocultar=0;


})



  });
</script>


<div id="modal_periodo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_delete">
         {{method_field('DELETE') }}
          {{ csrf_field() }}
                Selecciona Periodo
                    </br>
                    <div class="col-md-2 col-md-offset-10">
                       <a href="#"  id="arriba"   aria-expanded="false" ><span class="glyphicon glyphicon-arrow-up 5em" aria-hidden="true" ></span></a>
                    <a href="#"  id="abajo"   aria-expanded="false" ><span class="glyphicon glyphicon-arrow-down 5em" aria-hidden="true" ></span></a>

                    </div>
                  </br>

                <div class="col-md-12">



                     <table class="table table-bordered " Style="background: white;">
                                   <thead>

                                    </thead>
                                    <tbody>
                                             <style>
                                                        .periodo:hover {
                                                             background:rgb(219,219,219);
                                                                }
                                                            </style>
                                          @foreach($arre_periodos as $per)

                                       @if($per->id_periodo== $periodo_actual)
                                          <tr id="tr{{$per->id_periodo}}" class="periodo" name="tr{{$per->id_periodo}}" style="background:rgb(51,122,183);">
                                              <td > <a href="/periodo/{{$per->id_periodo}}"  id="seleccion"  style="color:white;font-weight:bold;" class="dropdown-toggle"  aria-expanded="false">

                                                 {{$per->periodo}}
                                                     </a>
                                                </td>
                                          </tr>
                                          @else
                                           <tr id="tr{{$per->id_periodo}}" name="tr{{$per->id_periodo}}">
                                              <td > <a href="/periodo/{{$per->id_periodo}}"  id="seleccion" class="dropdown-toggle"  aria-expanded="false">

                                               {{$per->periodo}}
                                                     </a>
                                                </td>
                                          </tr>

                                          @endif

                                          @endforeach





                                   </tbody>
                            </table>




                </div>
        </div>




                    <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection