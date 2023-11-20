@foreach($reticulas as $reti)
<div class="panel-group col-md-10 col-md-offset-1" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#{{ $reti ["id_reticula"]}}r">
        {{ $reti ["reticula"]}}</a>
      </h4>
    </div>
    <div id="{{ $reti ["id_reticula"]}}r" class="panel-collapse collapse">
      <div class="panel-body">

        <div class="list-group col-md-4 cont ml">     
        @foreach($reti["semestres"] as $semes)
            <a href="#tab{{ $reti ["id_reticula"]}}{{ $semes["id_semestre"] }}" role="tab" data-toggle="tab" class="list-group-item">{{ $semes ["semestre"]}}</a>
        @endforeach
        </div>

        <!-- Tab panes -->
    <div class="tab-content">
        @foreach($reti["semestres"] as $semes)
            <div role="tabpanel" class="tab-pane fade" id="tab{{ $reti ["id_reticula"]}}{{ $semes["id_semestre"] }}">
                    <div class="col-md-6 col-md-offset-1">
                      <div style="margin-top:1em;" class="panel panel-info text-center col-md-6 col-md-offset-3">
                        <h4 >Materias {{ $semes["semestre"] }}</h4>
                      </div>
                        <table class="table table-bordered pagina ml">
                          <thead>
                          <tr>
                              <th ></th>
                              <th >Materia</th>
                              <th >Clave</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach($semes["materias"] as $materias)
                            <?php $bandera=false; ?>
                            <tr>
                              <td>
                                @foreach($materias_doc as $m_d)                               
                                  @if($m_d->id_materia==$materias["id_materia"])
                                    <?php $bandera=true ?>
                                  @endif
                                @endforeach
                                @if($bandera)
                                <input type="checkbox" checked="checked" name="materia[]" id="{{ $materias["id_materia"]}}" value="{{ $materias["id_materia"]}}">
                                @else
                                <input type="checkbox" name="materia[]" id="{{ $materias["id_materia"]}}" value="{{ $materias["id_materia"]}}">
                                @endif
                              </td>
                              <td>{{ $materias["materia"]}}</td>
                              <td>{{ $materias["clave"] }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>   
                    </div>         
            </div>
        @endforeach
    </div>

      </div>
    </div>
  </div>
</div>
@endforeach




<script>

  $(document).ready(function() {

$("#modal_hrs").modal("show");

});

</script>

