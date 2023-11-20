<form class="form" action="{{url("/residencia/guardar_calificacion_anteproyecto/")}}" role="form" method="POST" >
    {{ csrf_field() }}
<div class="row">
    <input type="hidden" id="id_cronograma" name="id_cronograma" value="{{$id_cronograma}}">
            <div class="col-md-8 col-md-offset-2">
                <div class="form-group">
                    <div class="dropdown">
                        <label for="selectactitud">Actitud</label>
                        <select name="id_actitud" class="form-control " required>
                            <option disabled selected>Selecciona...</option>
                            <option value="0">N. A.</option>
                            <option value="70">70</option>
                            <option value="80">80</option>
                            <option value="90">90</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2 ">
        <div class="form-group">
            <div class="dropdown">
                <label for="selectresponsabilidad">Responsabilidad</label>
                <select name="id_responsabilidad" class="form-control " required>
                    <option disabled selected>Selecciona...</option>
                    <option value="0">N. A.</option>
                    <option value="70">70</option>
                    <option value="80">80</option>
                    <option value="90">90</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <div class="dropdown">
                <label for="selectcapacidad">Capacidad de solucionar problemas</label>
                <select name="id_capacidad" class="form-control " required>
                    <option disabled selected>Selecciona...</option>
                    <option value="0">N. A.</option>
                    <option value="70">70</option>
                    <option value="80">80</option>
                    <option value="90">90</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <div class="dropdown">
                <label for="selectaplicacion">Aplicación de los conocimientos teóricos en la práctica</label>
                <select name="id_aplicacion" class="form-control " required>
                    <option disabled selected>Selecciona...</option>
                    <option value="0">N. A.</option>
                    <option value="70">70</option>
                    <option value="80">80</option>
                    <option value="90">90</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <div class="dropdown">
                <label for="selectcalidad">Calidad del contenido de los avances del informe</label>
                <select name="id_calidad" class="form-control " required >
                    <option disabled selected>Selecciona...</option>
                    <option value="0">N. A.</option>
                    <option value="70">70</option>
                    <option value="80">80</option>
                    <option value="90">90</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label for="comentario">Observaciones</label>
                <textarea class="form-control"  id="id_observacion" name="id_observacion" rows="3" placeholder="Ingresa un comentario " style="" required></textarea>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <label for="comentario">Pendientes</label>
            <textarea class="form-control"  id="id_pendiente" name="id_pendiente" rows="3" placeholder="Ingresa un comentario " style="" required></textarea>
        </div>
    </div>
</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <input  type="submit" class="btn btn-primary" value="Guardar"/>
    </div>
</form>