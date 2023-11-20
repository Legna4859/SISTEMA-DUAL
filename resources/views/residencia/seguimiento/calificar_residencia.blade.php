<form class="form" id="formulario_registrar_cal" action="{{url("/residencia/guardar_calificacion__residencia/")}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p style="color: #ee5f5b;">Evaluación por el asesor externo.</p>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{$id_anteproyecto}}">
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <div class="dropdown">
                    <label for="uno">1. Asiste puntualmente con el horario establecido</label>
                    <select name="uno" id="uno" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="dos">2. Trabajo en equipo</label>
                    <select name="dos" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="tres">3. Tiene iniciativa para ayudar en las actividades encomendadas</label>
                    <select name="tres" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="cuatro">4. Organiza su tiempo y trabaja sin necesidad de una supervisión estrecha.</label>
                    <select name="cuatro" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="cinco">5. Realiza mejoras al proyecto</label>
                    <select name="cinco" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="seis">6. Cumple con los objetivos correspondiente al proyecto</label>
                    <select name="seis" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p style="color: #ee5f5b;">Evaluación por el asesor interno.</p>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{$id_anteproyecto}}">
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <div class="dropdown">
                    <label for="siete">1. Mostró responsabilidad y compromiso en la residencia profesional</label>
                    <select name="siete" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="ocho">2. Realizó un trabajo innovador en su área de desempeño</label>
                    <select name="ocho" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="nueve">3. Aplica las competencias para la realización del proyecto</label>
                    <select name="nueve" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="diez">4. Es dedicado y proactivo en los trabajos encomendados</label>
                    <select name="diez" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="once">5. Cumple con los objetivos correspondiente al proyecto</label>
                    <select name="once" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="form-group">
                <div class="dropdown">
                    <label for="doce">6. Entrega en tiempo y forma el informe técnico</label>
                    <select name="doce" class="form-control " required>
                        <option disabled selected>Selecciona...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="dropdown">
                            <label for="selectcalidad">Observaciones</label>

                            <textarea class="form-control" id="observacion" name="observacion"  rows="2" placeholder="Ingresa observaciones"  required></textarea>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>

</form>