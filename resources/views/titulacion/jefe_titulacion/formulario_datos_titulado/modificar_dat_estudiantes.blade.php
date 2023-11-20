<div class="row">
    <div class="col-md-3 col-md-offset-1">
        <div class="form-group">
            <label for="numero_cuenta">Número de cuenta</label>
            <input class="form-control required" id="cuenta" name="cuenta"  readonly value="{{ $datos_alumno->no_cuenta }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="clave_carrera">Clave de  la carrera</label>
            <input class="form-control required" id="id_clave_carrera" name="id_clave_carrera"  type="hidden"  value="{{ $clave_carrera->id_clave_carrera }}"  required />
            <input class="form-control required" id="clave_carrera" name="clave_carrera" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $clave_carrera->clave }}"  required />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="nombre_carrera">Nombre de la carrera</label>
            <input class="form-control required" id="nombre_carrera" name="nombre_carrera"  readonly value="{{ $datos_alumno->carrera }}" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-1">
        <div class="form-group">
            <label for="nombre_estudiante">Nombre del estudiante </label>
            <input class="form-control required" id="nombre_estudiante" name="nombre_estudiante"  readonly value="{{ $datos_alumno->nombre_al }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="apaterno_estudiante">Apellido paterno del estudiante </label>
            <input class="form-control required" id="apaterno_estudiante" name="apaterno_estudiante"  readonly value="{{ $datos_alumno->apaterno }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="amaterno_estudiante">Apellido materno del estudiante </label>
            <input class="form-control required" id="amaterno_estudiante" name="amaterno_estudiante"  readonly value="{{ $datos_alumno->amaterno }}" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-1">
        <div class="form-group">
            <label for="entidad_federativa_estudiante">Entidad federativa donde vive el estudiante </label>
            <input class="form-control required" id="entidad_federativa_estudiante" name="entidad_federativa_estudiante"  readonly value="ESTADO DE {{ $datos_alumno->nombre_estado }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="dropdown">
            <label for="id_nacionalidad">Nacionalidad del estudiante</label>
            <select class="form-control" id="id_nacionalidad" name="id_nacionalidad" required readonly >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($nacionalidades as $nacionalidad)
                    @if($registro_datos->id_nacionalidad == $nacionalidad->id_nacionalidad)
                        <option value="{{$nacionalidad->id_nacionalidad}}" selected="selected" >{{$nacionalidad->nacionalidad}}</option>
                       @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">

        <div class="form-group">
            <label for="clave_carrera">Genero</label>
            <input class="form-control required" id="id_genero" name="id_genero"  type="hidden"  value="{{ $genero->id_genero }}"  required />
            <input class="form-control required" id="genero" name="genero" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $genero->genero }}"  required />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-1">
        <div class="dropdown">
            <label for="id_genero">Sexo</label>
            <input class="form-control required" id="id_sexo" name="id_sexo"  type="hidden"  value="{{ $sexo->id_sexo }}"  required />
            <input class="form-control required" id="sexo" name="sexo" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $sexo->sexo }}"  required />

        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="curp">CURP </label>
            <input class="form-control required" id="curp" name="curp"  readonly value="{{ $datos_alumno->curp_al }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="edad">Edad </label>
            <input class="form-control required" id="edad" name="edad" readonly value="{{ $edad }}" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-1">
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de nacimiento </label>
            <input class="form-control required" id="fecha_nacimiento" name="fecha_nacimiento" readonly value="{{ $fecha_nacimiento }}" />
        </div>
    </div>
    <div class="col-md-3 ">
        <div class="form-group">
            <label for="tipo_estudiante">¿ Es estudiante?</label>
            <input class="form-control required" id="tipo_estudiante" name="tipo_estudiante"  readonly value="{{ $datos_alumno->tipo_estudiante }}" />
        </div>
    </div>
    <div class="col-md-3 ">
        <div class="form-group">
            <label for="id_opcion_titulacion">Opción de titulación</label>
            <input class="form-control required" id="id_opcion_titulacion" name="id_opcion_titulacion"  readonly value="{{ $datos_alumno->opcion_titulacion }}" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9 col-md-offset-1">
        <div class="dropdown">
            <label for="id_preparatoria">Preparatoria</label>
            <select class="form-control" id="id_preparatoria" name="id_preparatoria" readonly >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($preparatorias as $preparatoria)
                    @if($registro_datos->id_preparatoria == $preparatoria->id_preparatoria)
                        <option value="{{$preparatoria->id_preparatoria}}" selected="selected" >{{$preparatoria->preparatoria}} (ENTIDAD FEDERATIVA: {{ $preparatoria->nom_entidad }})</option>
                      @endif
                @endforeach
            </select>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-1">
        <div class="form-group">
            <label for="id_preparatoria">Fecha de ingreso a la preparatoria</label>
            <input class="form-control datepicker fecha_inicio_prepa" readonly   type="text"  id="fecha_inicio_preparatoria" name="fecha_inicio_preparatoria" value="{{ $registro_datos->fecha_ingreso_preparatoria }}" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" required>
        </div>
    </div>
    <div class="col-md-3 ">
        <div class="form-group">
            <label for="id_preparatoria">Fecha de egreso a la preparatoria</label>
            <input class="form-control datepicker fecha_final_prepa"  readonly type="text"  id="fecha_final_preparatoria" name="fecha_final_preparatoria" value="{{ $registro_datos->fecha_egreso_preparatoria }}" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" required >
        </div>
    </div>

</div>
<div class="row">

    <div class="col-md-3 col-md-offset-1 ">
        <div class="form-group">
            <label for="folio_titulo">Folio del titulo</label>
            <input class="form-control " id="id_numero_titulo" name="id_numero_titulo" readonly  value="{{ $registro_datos->id_numero_titulo }}" type="hidden" value="" required />

            <input class="form-control " id="folio_titulo" name="folio_titulo" readonly onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{ $registro_datos->abreviatura_folio_titulo }}" type="text" value="" required />
        </div>
    </div>
    <div class="col-md-3 ">
        <div class="form-group">
            <label for="numero_foja_titulo">Número de la foja del título</label>
            <input class="form-control " id="numero_foja_titulo" name="numero_foja_titulo"    type="number" value="{{ $registro_datos->numero_foja_titulo }}" required />
        </div>
    </div>
    <div class="col-md-3 ">
        <div class="form-group">
            <label for="numero_libro_titulo">Número del libro del título</label>
            <input class="form-control " id="numero_libro_titulo" name="numero_libro_titulo"  type="number" value="{{ $registro_datos->numero_libro_titulo }}"  required/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-1">
        <div class="form-group">
            <label for="hora_titulacion">Hora de titulación</label>
            <input class="form-control " id="hora_titulacion" name="hora_titulacion"  readonly type="text" value="{{ $reg_fecha_titulacion->hora }}"  required/>
        </div>
    </div>
    <div class="col-md-3 ">
        <div class="form-group">
            <label for="fecha_titulacion">Fecha de titulación</label>
            <input class="form-control " id="fecha_titulacion" name="fecha_titulacion" readonly type="text" value="{{ $reg_fecha_titulacion->fecha_titulacion }}"  required/>
        </div>
    </div>
    <div class="col-md-3">
        <label for="id_tipo_titulo">Titulo obtenido</label>
        <div class="form-group">
            <input class="form-control required" id="id_tipo_titulo" name="id_tipo_titulo"  type="hidden"  value="{{ $titulo_obtenido->id_tipo_titulo }}"  required />
            <input class="form-control required" id="tipo_titulo" name="tipo_titulo" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly value="{{ $titulo_obtenido->tipo_titulo }}"  required />

        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <div class="dropdown">
                <label for="id_decision">Decisión del jurado</label>
                <select class="form-control" id="id_decision" name="id_decision" >
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($tipos_decisiones as $tipos_decisiones)
                        @if($registro_datos->id_decision == $tipos_decisiones->id_decision)
                            <option value="{{$tipos_decisiones->id_decision}}" selected="selected" >{{$tipos_decisiones->decision}}</option>
                        @else
                            <option value="{{$tipos_decisiones->id_decision}}"> {{$tipos_decisiones->decision}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="fecha_ingreso_tesvb">Fecha de ingreso al TESVB</label>
                <input class="form-control datepicker fecha_ingreso_tecno" readonly  type="text"  id="fecha_ingreso_tesvb" name="fecha_ingreso_tesvb" value="{{ $registro_datos->fecha_ingreso_tesvb }}" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" required>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="form-group">
                <label for="fecha_ingreso_tesvb">Fecha de egreso aL TESVB</label>
                <input class="form-control datepicker fecha_egreso_tecno" readonly  type="text"  id="fecha_egreso_tesvb" name="fecha_egreso_tesvb" data-date-format="dd/mm/yyyy" value="{{ $registro_datos->fecha_egreso_tesvb }}" placeholder="DD/MM/YYYY" required >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <div class="dropdown">
                <label for="id_fundamento_legal">Selecciona fundamento legal del servicio social</label>
                <select class="form-control" id="id_fundamento_legal" name="id_fundamento_legal" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($fundamentos_legales as $fundamento)
                        @if($registro_datos->id_fundamento_legal == $fundamento->id_fundamento_legal)
                            <option value="{{$fundamento->id_fundamento_legal}}" selected="selected" >{{$fundamento->fundamento_legal}}</option>
                        @else
                            <option value="{{$fundamento->id_fundamento_legal}}"> {{$fundamento->fundamento_legal}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="dropdown">
                <label for="id_autorizacion_reconocimiento">Selecciona autorización de reconocimiento</label>
                <select class="form-control" id="id_autorizacion_reconocimiento" name="id_autorizacion_reconocimiento" required >
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($autorizaciones_reconocimientos as $autorizacion)
                        @if($registro_datos->id_autorizacion_reconocimiento == $autorizacion->id_autorizacion_reconocimiento)
                            <option value="{{$autorizacion->id_autorizacion_reconocimiento}}" selected="selected" >{{$autorizacion->autorizacion_reconocimiento}}</option>
                        @else
                            <option value="{{$autorizacion->id_autorizacion_reconocimiento}}"> {{$autorizacion->autorizacion_reconocimiento}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {

        $('.fecha_inicio_prepa').datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',

        });
        $('.fecha_final_prepa').datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',

        });
        $('.fecha_ingreso_tecno').datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',

        });
        $('.fecha_egreso_tecno').datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',

        });
    });
</script>