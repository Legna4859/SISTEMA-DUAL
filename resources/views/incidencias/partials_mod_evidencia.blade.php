<form id="form_enviar_evidencia" action="{{url("/incidencias/guardar_mod_evidencia/".$evidencia->id_evid)}}" role="form" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <label>Instrucciones: </label><br>
      <label> Para poder subir la evidencia correspondiente es necesario que su archivo, que desea subir este en formato PDF y que este legible.</label>
  </div>
</div>
<div class="row">
  <div class="col-md-5 col-md-offset-3">
    <div class= "dropdown">
        <label for="Tipo_evi">Tipo de evidencia:</label>
          <select class="form-control" placeholder="Seleciona una opción" id="id_tipo_evid" name="id_tipo_evid" required>
              <option disabled selected hidden> Selecciona una opción </option>
              @foreach($tipo_evidencia as $tipo_evidencia)
              @if($evidencia->id_tipo_evid==$tipo_evidencia->id_tipo_evid)
                        <option value="{{$tipo_evidencia->id_tipo_evid}}" selected="selected" >{{$tipo_evidencia->nombre_evidencia}}</option>
                    @else
                        <option value="{{$tipo_evidencia->id_tipo_evid}}"> {{$tipo_evidencia->nombre_evidencia}}</option>
                    @endif
              @endforeach
          </select>
    </div>
  </div>
</div>
<div class="row">              
    <div class="col-md-5 col-md-offset-3">
        <span><label for="archivo_subir">Archivo a subir:</label>
          <input  class="form-control" id="arch_evidencia" name="arch_evidencia" type="file" accept="application/pdf"    required/>
      </div> 
    </div> 
 </form>