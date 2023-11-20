<main>
<!-- Modal para ver horario_grupos -->
<div class="modal fade bs-example-modal-lg" id="modal_hrs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="modal_horas">
        <div class="modal-header bg-info">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">HORARIOS DOCENTE: {{ $nombre }}</h4>
        </div>
        <div class="modal-body">
         <!--<button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>-->

            <table class="table table-bordered text-center ml" style="table-layout:fixed;">
                <thead>
                    <tr>
                      <th>Hora/Día</th>
                      <th>Lunes</th>
                      <th>Martes</th>
                      <th>Miércoles</th>
                      <th>Jueves</th>
                      <th>Viernes</th>
                      <th>Sábado</th>
                      <th>Horas</th>
                    </tr>
                </thead>

                <tbody>  
                          <?php $contador=1 ?>
                          <?php $totalesf=0 ?>
                            @foreach($semanas as $semanass)
                            @if($contador==1)
                              <tr>                            
                                <td class="horario">{{ $semanass->hora }}</td> 
                            @endif 
                                <?php $bandera_ok=true; ?> 
                            <td class="horario iden{{$semanass->id_semana}}"> 
                                  @foreach($horarios_doc as $horario)                    
                                  @if($horario->id_semana==$semanass->id_semana) 
                                      <?php $bandera_ok=false; ?>
                                      <div style="font-weight:bold; color:white;">
                                        <div>{{ $horario->materia }}</div>
                                        <div>{{ $horario->grupo }}:{{ $horario->abre }}</div>
                                        <?php $totalesf++; ?>
                                      </div>  
                                  @endif    
                                @endforeach
                                <?php $contador++?>                  
                                  @if($contador==7)
                                  <?php $contador=1 ?> 
                                    <td>
                                      {{ $totalesf }}
                                      <?php $totalesf=0 ?>
                                    </td>            
                                  </tr>
                                  @endif
                                     @endforeach                                                                                           
                </tbody>
            </table>
            <div class="row">
                  <div class="col-md-4 col-md-offset-4">
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
                </div>
            </div>

      </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
          </div>
    </div>
  </div>
</div>
</main>
<script>
@foreach($semanas as $semanass)
  @foreach($horarios_doc as $horario)                    
    @if($horario->id_semana==$semanass->id_semana) 
      $(".iden{{$semanass->id_semana}}").css('background', '{{$horario->color}}');
    @endif    
  @endforeach
@endforeach
  $(document).ready(function(){

    $("#modal_hrs").modal("show");

  });

</script>
