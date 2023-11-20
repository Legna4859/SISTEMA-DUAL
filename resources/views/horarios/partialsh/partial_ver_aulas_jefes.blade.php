@section('horario_aula')

<main>
<!-- Modal para ver horario_grupos -->
<div class="modal fade bs-example-modal-lg" id="modal_hrs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="modal_horas">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">HORARIO AULA: {{ $aulan }}</h4>
      </div>
      <div class="modal-body">
        
        @if($imprime==1)         
         <div class="col-md-2">
  <a href="/pdf_aulas/{{$id_carrera}}/{{$id_aula}}" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</a>
                        </div>
      @endif

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
                            </tr>
                          </thead>

                       <tbody>  
                          <?php $contador=1 ?>
                            @foreach($semanas as $semanass)
                              @if($contador==1)
                                <tr>                            
                                  <td class="horario">{{ $semanass->hora }}</td> 
                              @endif                        
                              <td class="horario iden{{$semanass->id_semana}}"> 
                                  @foreach($horario_aula as $horario)                    
                                    @if($horario->id_semana==$semanass->id_semana) 
                                        <div style="font-weight:bold; color:white;">
                                          <div>{{ $horario->materia }}</div>
                                          <div>{{ $horario->grupo }}</div>
                                        </div>                                     
                                    @endif    
                                  @endforeach
                                  <?php $contador++ ?>                  
                                    @if($contador==7)
                                      <?php $contador=1 ?>                                                
                                </tr>
                                    @endif
                            @endforeach                                                                                           
                      </tbody>
            </table>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
                  <table class="table table-bordered tabla-grande2">
                    <thead>
                      <th>Materia</th>
                      <th>Profesor</th>
                      <th>Grupo</th>
                    </thead>
                          <tbody>
                            @foreach($docentes as $docente)
                            <tr>
                              <td>{{ $docente->materia }}</td>
                              <td>{{ $docente->nombre }} </td>
                              <td>{{ $docente->grupo }} </td>
                            </tr>
                            @endforeach
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
  @foreach($horario_aula as $horario)                    
    @if($horario->id_semana==$semanass->id_semana) 
      $(".iden{{$semanass->id_semana}}").css('background', '{{$horario->COLOR}}');
    @endif    
  @endforeach
@endforeach
  $(document).ready(function(){

    $("#modal_hrs").modal("show");

  });

</script>

@endsection