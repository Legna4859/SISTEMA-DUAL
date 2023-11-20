
@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
    <main>
        <style>
            #resultado {
                background-color: red;
                color: white;
                font-weight: bold;
            }
            #resultado.ok {
                background-color: green;
            }
            #result {
                background-color: red;
                color: white;
                font-weight: bold;
            }
            #result.ok {
                background-color: green;
            }
        </style>
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="#cero" aria-controls="uno" role="tab" data-toggle="tab">Tu escuela de procedencia</a></li>
                        <li role="presentation" ><a href="#uno" aria-controls="uno" role="tab" data-toggle="tab">Tus datos personales</a></li>
                        <li role="presentation"><a href="#dos" aria-controls="dos" role="tab" data-toggle="tab">Tus datos domiciliarios</a></li>
                        <li role="presentation"><a href="#tres" aria-controls="tres" role="tab" data-toggle="tab">Datos de tu tutor (Padre o madre o etc.)</a></li>
                        <li role="presentation"><a href="#cuatro" aria-controls="cuatro" role="tab" data-toggle="tab">Datos Domiciliarios de tu tutor</a></li>

                    </ul>
                    <br>
                </div>
            </div>

            <form class="form" role="form" method="POST" id="formgeneral">
                <!-- Tab panes -->

                {{ csrf_field()}}
                <div class="tab-content">
                    <div  class="tab-pane fade in active" id="cero">
                      <div class="row">
                          <div class="col-md-8 col-md-offset-2">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h3 class="panel-title text-center">Datos de tu escuela de procedencia (bachillerato o preparatoria, etc.)</h3>
                                  </div>
                              </div>
                          </div>
                      </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <table class="table table-bordered"  id="registro_cct">
                                    <thead>
                                    <tr>
                                        <th>CCT</th>
                                        <th>NOMBRE DE LA ESCUELA</th>
                                        <th>DOMICILIO</th>
                                        <th>MUNICIPIO</th>
                                        <th>LOCALIDAD</th>
                                        <th>TURNO</th>
                                        <th>SERVICIO</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $institucion->cct }}</td>
                                            <td>{{ $institucion->nombre_escuela }}</td>
                                            <td>{{ $institucion->domicilio }}</td>
                                            <td>{{ $institucion->municipio }}</td>
                                            <td>{{ $institucion->localidad }}</td>
                                            <td>{{ $institucion->turno }}</td>
                                            <td>{{ $institucion->servicio }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">
                                <a type="button" class="btn btn-success" href="{{url('/datos_alumnos/modificar_cct/'.$datos->id_alumno)}}">Modificar escuela</a>
                            </div>
                        </div>
                        <div class="row">
                            <p><br></p>
                        </div>

                    </div>
                    <div  class="tab-pane fade" id="uno">




                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="color: #942a25">No. de Cuenta<b style="color:red; font-size:23px;">*</b></h4>
                                <input type="text" class="form-control"  placeholder="" name="id" value="{{$datos->id_alumno}}" style="display:none;">
                                <input type="text" class="form-control"  placeholder="" name="id_tutor" value="{{$datos_t->id_tutor}}" style="display:none;">
                                <input type="text" class="form-control"  placeholder="" name="existe" value="{{$existe}}" style="display:none;">
                                <input type="text" class="form-control"  placeholder="" name="cuentao" value="{{$datos->cuenta}}" style="display:none;">
                                @if($dat ==0)
                                    <input type="text" class="form-control "  placeholder="Ejem: 201207017" name="cuenta" id="cuenta"
                                           value="{{$datos->cuenta}}" >
                                @else
                                    <input type="text" class="form-control "  readonly="readonly" name="cuenta" id="cuenta"
                                           value="{{$datos->cuenta}}" >
                                @endif


                                @if($errors->has('cuenta'))
                                    <span style="color:red;">{{$errors->first('cuenta')}}</span>
                                    <style type="text/css" > #cuenta{
                                            border:solid red 1px;
                                        }</style>

                                @else

                                @endif
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Nombre(s)<b style="color:red; font-size:23px;">*</b><h4>
                                <input type="text" class="form-control "  placeholder="" onkeyup="javascript:this.value=this.value.toUpperCase();" name="nomalu" id="nomalu" value="{{$datos->nombre}}" >
                                @if($errors->has('nomalu'))
                                    <span style="color:red;">{{$errors->first('nomalu')}}</span>
                                    <style type="text/css" > #nomalu{
                                            border:solid red 1px;
                                        }</style>

                                @else

                                @endif
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Apellido Paterno<a style="color:red; font-size:23px;">*</a></h4>
                                <input type="text" class="form-control"  placeholder="" name="appalu" id="appalu" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$datos->apaterno}}">
                                @if($errors->has('appalu'))
                                    <span style="color:red;">{{$errors->first('appalu')}} </span>
                                    <style type="text/css" > #appalu{
                                            border:solid red 1px;
                                        }</style>

                                @else

                                @endif

                            </div>

                            <div class="col-md-3">
                                <h4 style="color: #942a25">Apellido Materno<b style="color:red; font-size:23px;">*</b></h4>
                                <input type="text" class="form-control"  placeholder="" onkeyup="javascript:this.value=this.value.toUpperCase();" name="apmalu" id="apmalu" value="{{$datos->amaterno}}">
                                @if($errors->has('apmalu'))
                                    <span style="color:red;">{{$errors->first('appalu')}} </span>
                                    <style type="text/css" > #appalu{
                                            border:solid red 1px;
                                        }</style>

                                @endif

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="color: #942a25">Fecha De Nacimiento<b style="color:red; font-size:23px;">*</b></h4>
                                <input type="text" class="form-control datepicker" name="fecha_nac" id="fecha_nac" value="{{$datos->fecha_nac}}">
                            </div>
                            <div class="col-md-1" id="fecha_nacimiento">
                                @if($ed == 0)
                                    <h4 style="color: #942a25">Edad<b style="color:red; font-size:23px;">*</b></h4>
                                <input type="text" class="form-control"  placeholder="" name="edadalu" value="{{$datos->edad}}" >
                                @else
                                    <h4 style="color: #942a25">Edad<b style="color:red; font-size:23px;">*</b></h4>
                                    <input type="text" class="form-control"  placeholder="" name="edadalu" value="{{$edad}}" readonly="readonly">

                                @endif
                            </div>
                            <div class="col-md-3">

                                <h4 style="color: #942a25">Genero<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control "  name="generoalu" value="{{$datos->genero}}">
                                        @if($datos->genero == null)
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            <option  value="F">FEMENINO</option>
                                            <option  value="M">MASCULINO</option>
                                        @else
                                        @if($genero=="M")

                                            <option value="F" selected="selected">FEMENINO</option>

                                        @else

                                            <option  value="M" selected="selected">MASCULINO</option>
                                        @endif
                                        @endif


                                </select>
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Curp<b style="color:red; font-size:23px;">*</b></h4>
                                <input type="text" class="form-control"  onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="" name="curpalu" oninput="validarInput(this)" value="{{$datos->curp_al}}">
                                <p id="resultado"></p>
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Nacionalidad<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control "placeholder="selecciona una Opcion" name="nacioalu" >
                                    @if($existe==0)
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        <option  value="MEXICANA">MEXICANA</option>
                                        <option  value="EXTRANJERA">EXTRANJERA</option>
                                    @else
                                        @if($datos->nacionalidad == null)
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            <option  value="MEXICANA">MEXICANA</option>
                                            <option  value="EXTRANJERA">EXTRANJERA</option>

                                        @elseif($datos->nacionalidad=="MEXICANA"||$datos->nacionalidad=="")
                                            <option value="MEXICANA" selected="selected">MEXICANA</option>
                                            <option  value="EXTRANJERA">EXTRANJERA</option>
                                        @else
                                            <option value="MEXICANA" >MEXICANA</option>
                                            <option  value="EXTRANJERA" selected="selected">EXTRANJERA</option>
                                        @endif

                                    @endif
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Estado Civil<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control  "placeholder="selecciona una Opcion" name="estadoalu" >
                                    @if($existe==0)
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        <option  value="SOLTERO">SOLTERO</option>
                                        <option  value="CASADO">CASADO</option>
                                        <option  value="DIVORCIADO">DIVORCIADO</option>
                                        <option  value="UNION LIBRE">UNION LIBRE</option>
                                        <option  value="VIUDO">VIUDO</option>
                                    @else
                                        @if($datos->edo_civil == null)
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            <option  value="SOLTERO">SOLTERO</option>
                                            <option  value="CASADO">CASADO</option>
                                            <option  value="DIVORCIADO">DIVORCIADO</option>
                                            <option  value="UNION LIBRE">UNION LIBRE</option>
                                            <option  value="VIUDO">VIUDO</option>

                                        @elseif($datos->edo_civil=="SOLTERO")
                                            <option  value="SOLTERO" selected="selected">SOLTERO</option>
                                            <option  value="CASADO">CASADO</option>
                                            <option  value="DIVORCIADO">DIVORCIADO</option>
                                            <option  value="UNION LIBRE">UNION LIBRE</option>
                                            <option  value="VIUDO">VIUDO</option>
                                        @endif
                                        @if($datos->edo_civil=="CASADO")
                                            <option  value="SOLTERO" >SOLTERO</option>
                                            <option  value="CASADO" selected="selected">CASADO</option>
                                            <option  value="DIVORCIADO">DIVORCIADO</option>
                                            <option  value="UNION LIBRE">UNION LIBRE</option>
                                            <option  value="VIUDO">VIUDO</option>
                                        @endif
                                        @if($datos->edo_civil=="DIVORCIADO")
                                            <option  value="SOLTERO" >SOLTERO</option>
                                            <option  value="CASADO" >CASADO</option>
                                            <option  value="DIVORCIADO" selected="selected">DIVORCIADO</option>
                                            <option  value="UNION LIBRE">UNION LIBRE</option>
                                            <option  value="VIUDO">VIUDO</option>
                                        @endif
                                        @if($datos->edo_civil=="UNION LIBRE")
                                            <option  value="SOLTERO" >SOLTERO</option>
                                            <option  value="CASADO" >CASADO</option>
                                            <option  value="DIVORCIADO" >DIVORCIADO</option>
                                            <option  value="UNION LIBRE" selected="selected">UNION LIBRE</option>
                                            <option  value="VIUDO">VIUDO</option>
                                        @endif
                                        @if($datos->edo_civil=="VIUDO")
                                            <option  value="SOLTERO" >SOLTERO</option>
                                            <option  value="CASADO" >CASADO</option>
                                            <option  value="DIVORCIADO" >DIVORCIADO</option>
                                            <option  value="UNION LIBRE" >UNION LIBRE</option>
                                            <option  value="VIUDO" selected="selected">VIUDO</option>
                                        @endif




                                    @endif
                                </select>

                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Correo<b style="color:red; font-size:23px;">*</b></h4>
                                <input type="text" class="form-control" id="Email" readonly="readonly" name="correoalu" value="{{$datos->correo_al}}">
                                <span id="emailOK"></span>
                            </div>

                            <div class="col-md-3">

                                <label for="exampleInputEmail1">TwitTer<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                                <input type="text" class="form-control" name="twiteralu" placeholder="" value="{{$datos->twiter_al}}">
                            </div>

                            <div class="col-md-3">
                                <label for="exampleInputEmail1">Facebook<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                                <input type="text" class="form-control" name="facealu" placeholder="" value="{{$datos->facebook_al}}">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Celular<b style="color:red; font-size:23px;">*</b></h4>
                                <input type="text" class="form-control" name="celalu" placeholder="Ejem: 7221232323"
                                       onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                       maxlength="10" value="{{$datos->cel_al}}">
                            </div>
                            <div class="col-md-3">
                                <label>Tel. Fijo<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                                <input type="text" class="form-control" name="telalu" placeholder=""
                                       onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                       maxlength="10" value="{{$datos->tel_fijo_al}}">

                            </div>

                            <div class="col-md-3">
                                <h4 style="color: #942a25">Entidad de Nacimiento<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="entidadalu" name="entidadalu" >
                                    @if($existe==0)

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($entidadnac as$entidadnac)
                                            <option value="{{$entidadnac->id_estado}}" data-esta="{{$entidadnac->nombre_estado}}">{{$entidadnac->nombre_estado}}</option>
                                        @endforeach

                                    @else

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($entidadnac as$entidadnac)
                                            @if($entidadnac->id_estado == $datos->entidad_nac_al)
                                                <option value="{{$entidadnac->id_estado}}" data-esta="{{$entidadnac->nombre_estado}}" selected="selected">{{$entidadnac->nombre_estado}}</option>
                                            @else
                                                <option value="{{$entidadnac->id_estado}}" data-esta="{{$entidadnac->nombre_estado}}" >{{$entidadnac->nombre_estado}}</option>

                                            @endif
                                        @endforeach


                                    @endif
                                </select>
                            </div>



                        </div>

                        {{--
                        <div class="row">
                            <div class="col-md-10" >
                                <h3 style="color: #942a25"><b>Escuela de procedencia</b><b style="color:red; font-size:23px;"></b></h3>
                                <select class="form-control" placeholder="selecciona una Opcion" id="escuela" name="escuela" >
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    @foreach($escuelas as $escuela)
                                        @if($datos->id_escuela_procedencia == $escuela->id_escuela_procedencia)
                                            <option value="{{$escuela->id_escuela_procedencia}}"  selected="selected" data-toggle="tooltip" data-placement="top" title="DE {{  $escuela->municipio}},{{  $escuela->estado}}">{{$escuela->nombre_escuela}}</option>
                                        @else
                                            <option value="{{$escuela->id_escuela_procedencia}}" data-toggle="tooltip" data-placement="top" title="DE {{ $escuela->municipio }},{{  $escuela->estado}}" >{{$escuela->nombre_escuela}} <b>UBICADA: {{ $escuela->municipio }},{{  $escuela->estado}}</b></option>

                                        @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        --}}

                        <div class="row">
                            <div class="col-md-4">
                                <h4 style="color: #942a25">Carrera<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control" name="carreras" value="{{$datos->id_carrera}}">
                                    @if($existe==0)

                                        <option  disabled selected hidden>Selecciona una carrera</option>
                                        @foreach($carreras as$carreras)
                                            <option value="{{$carreras->id_carrera}}">{{$carreras->nombre}}</option>
                                        @endforeach
                                    @else

                                        <option  disabled selected hidden>Selecciona una carrera</option>
                                        @foreach($carreras as $carreras)
                                            @if($carreras->id_carrera == $datos->id_carrera)
                                                <option value="{{$carreras->id_carrera}}" selected="selected">{{$carreras->nombre}}</option>

                                            @else
                                                  <option value="{{$carreras->id_carrera}}" >{{$carreras->nombre}}</option>
                                            @endif
                                        @endforeach

                                    @endif
                                </select>

                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Semestre<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control  "placeholder="selecciona una Opcion" name="semestre" value="{{$datos->id_semestre}}">
                                    @if($existe==0)
                                        <option disabled selected hidden>Selecciona semestre</option>
                                        @foreach($semestres as $semestres)
                                            <option value="{{$semestres->id_semestre}}">{{$semestres->descripcion}}</option>
                                        @endforeach

                                    @else
                                        <option disabled selected hidden>Selecciona semestre</option>
                                        @foreach($semestres as $semestres)
                                            @if($semestres->id_semestre == $sem)
                                                <option value="{{$semestres->id_semestre}}" selected="selected">{{$semestres->descripcion}}</option>

                                            @else

                                                <option value="{{$semestres->id_semestre}}" >{{$semestres->descripcion}}</option>
                                            @endif
                                        @endforeach


                                    @endif
                                </select>

                            </div>

                            <div class="col-md-2">

                                <h4 style="color: #942a25">Grupo<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control  "placeholder="selecciona una Opcion" name="grupoalu" id="grupoalu">

                                    @if($existe==0)

                                        <option disabled selected hidden>Selecciona grupo</option>
                                        @foreach($grados as $grado)
                                            <option value="{{$grado->id_grado}}"  >{{$grado->des}}</option>
                                        @endforeach

                                    @else

                                        <option disabled selected hidden>Selecciona grupo</option>
                                        @foreach($grados as $grado)
                                            @if($grado->id_grado == $datos->grupo )
                                                <option value="{{$grado->id_grado}}"  selected="selected">{{$grado->des}}</option>
                                            @else
                                                <option value="{{$grado->id_grado}}"  >{{$grado->des}}</option>

                                            @endif
                                        @endforeach


                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2">


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">

                                <h4 style="color: #942a25">Tienes alguna discapacidad<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control" id="discapacidad" name="discapacidad" >
                                    @if($existe==0)

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($respuesta as $respuestas)
                                            <option value="{{$respuestas->id_respuesta}}"  >{{$respuestas->respuesta}}</option>
                                        @endforeach

                                    @else

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($respuesta as $respuestas)
                                            @if($respuestas->id_respuesta == $datos->discapacidad)
                                                <option value="{{$respuestas->id_respuesta}}"  selected="selected">{{$respuestas->respuesta}}</option>
                                            @else
                                                <option value="{{$respuestas->id_respuesta}}"  >{{$respuestas->respuesta}}</option>

                                            @endif
                                        @endforeach


                                    @endif
                                </select>

                            </div>
                            <div class="col-md-3" id="descripcion_discapacidad">
                                <h4 style="color: #942a25">Cual es?<b style="color:red; font-size:23px;"></b></h4>
                                <input type="text" class="form-control" id="descripcion_discapacidad" name="descripcion_discapacidad" placeholder="" value="{{$datos->descripcion_discapacidad}}" re>
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Hablas alguna lengua indigena<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="lengua" name="lengua" >
                                    @if($existe==0)

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($respuesta as $respuestas)
                                            <option value="{{$respuestas->id_respuesta}}"  >{{$respuestas->respuesta}}</option>
                                        @endforeach

                                    @else

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($respuesta as $respuestas)
                                            @if($respuestas->id_respuesta == $datos->lengua)
                                                <option value="{{$respuestas->id_respuesta}}"  selected="selected">{{$respuestas->respuesta}}</option>
                                            @else
                                                <option value="{{$respuestas->id_respuesta}}"  >{{$respuestas->respuesta}}</option>

                                            @endif
                                        @endforeach


                                    @endif
                                </select>

                            </div>
                            <div class="col-md-3" id="descripcion_lengua">
                                <h4 style="color: #942a25">Cual es?<b style="color:red; font-size:23px;"></b></h4>
                                <input type="text" class="form-control" id="descripcion_lengua" name="descripcion_lengua" placeholder="" value="{{$datos->descripcion_lengua }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h5 style="color: #942a25">En que  Institucion de Salud Pública<br> estas afiliado?<b style="color:red; font-size:23px;">*</b></h5>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="seguro" name="seguro" >
                                    @if($existe==0)

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($seguro as $seguro)
                                            <option value="{{$seguro->id_seguro_social}}"  >{{$seguro->descripcion}}</option>
                                        @endforeach

                                    @else

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($seguro as $seguro)
                                            @if($seguro->id_seguro_social == $datos->id_seguro_social)
                                                <option value="{{$seguro->id_seguro_social}}"  selected="selected">{{$seguro->descripcion}}</option>
                                            @else
                                                <option value="{{$seguro->id_seguro_social}}"  >{{$seguro->descripcion}}</option>

                                            @endif
                                        @endforeach


                                    @endif
                                </select>
                            </div>

                                 @if($datos->id_seguro_social == 1 || $datos->id_seguro_social == 2 || $datos->id_seguro_social == 3 || $datos->id_seguro_social == 4 || $datos->id_seguro_social == 5)
                                <div class="col-md-3">
                                    <div id="seguro_s" >
                                        <br>
                                        <h5 style="color: #942a25" >Numero de Seguro social<b style="color:red; font-size:23px;">*</b></h5>
                                        <input type="text" class="form-control" name="seguro_social" id="seguro_social"    value="{{$datos->numero_seguro_social }}">
                                    </div>
                                </div>
                                     @else
                            <div class="col-md-3">
                                <div id="seguro_s" style="display: none;">
                                <br>
                                    <h5 style="color: #942a25" >Numero de Seguro social<b style="color:red; font-size:23px;">*</b></h5>
                                <input type="text" class="form-control" name="seguro_social" id="seguro_social"    value="{{$datos->numero_seguro_social }}">
                                </div>
                            </div>
                            @endif

                            <div class="col-md-3">
                                <br>
                                <?php $num = number_format($datos->promedio_preparatoria, 1, '.', ''); ?>
                               <h5 style="color: #942a25" >Promedio de la Preparatoria<b style="color:red; font-size:23px;">*</b></h5>
                                @if($num==0.0)

                                <input type="text" class="form-control"  placeholder="Ejemplo: 8.6" name="promedio_preparatoria"
                                       value="">
                                    @else
                                    <input type="text" class="form-control"  placeholder="Ejemplo: 8.6" name="promedio_preparatoria"
                                           value="{{$num}}">
                                @endif

                            </div>
                        </div>

                        <br>
                        <br>
                        <p><br></p>


                    </div>


                    <div class="tab-pane fade" id="dos">
                        <div class="row">
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Estado<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="estados_alu" name="estados_alu" >
                                    @if($existe==0)

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($estados_alu as$estados_alu)
                                            <option value="{{$estados_alu->id_estado}}" data-esta="{{$estados_alu->nombre_estado}}">{{$estados_alu->nombre_estado}}</option>
                                        @endforeach

                                    @else

                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($estados_alu as$estados_alu)
                                            @if($estados_alu->id_estado == $datos->estado)
                                                <option value="{{$estados_alu->id_estado}}" data-esta="{{$estados_alu->nombre_estado}}" selected="selected">{{$estados_alu->nombre_estado}}</option>
                                            @else
                                                <option value="{{$estados_alu->id_estado}}" data-esta="{{$estados_alu->nombre_estado}}" >{{$estados_alu->nombre_estado}}</option>

                                            @endif
                                        @endforeach


                                    @endif
                                </select>

                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Municipio<b style="color:red; font-size:23px;">*</b></h4>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="municipios_alu" name="municipios_alu" value="">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Calle<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="calle_alu" id="calle_alu" value="{{$datos->calle_al}}">
                            </div>
                            <div class="col-md-2">
                            <label for="exampleInputEmail1">No. Exterior<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control"  placeholder="" name="n_exterior_alu" id="n_exterior_alu" value="{{$datos->n_ext_al}}">
                            </div>

                    </div>
                    <div class="row">
                                <div class="col-md-2">
                            <label for="exampleInputEmail1">No. Interior<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control"  placeholder="" name="n_interior_alu" id="n_interior_alu" value="{{$datos->n_int_al}}">
                                </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Entre Calle<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="entre_calle_alu" id="entre_calle_alu" value="{{$datos->entre_calle}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Y Calle<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control" placeholder="" name="y_calle_alu" id="y_calle_alu" value="{{$datos->y_calle}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Otra referencia<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="otra_ref_alu" id="otra_ref_alu" value="{{$datos->otra_ref}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <h4 style="color: #942a25">C. Postal<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control" maxlength="5" placeholder="" name="CP_alu" id="CP_alu" value="{{$datos->cp}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Colonia<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="colonia_alu" id="colonia_alu" value="{{$datos->colonia_al}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Localidad<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="localidad_alu" id="localidad_alu" value="{{$datos->localidad_al}}">
                        </div>
                    </div>
                        <br>
                        <br>
                        <p><br></p>

                    </div>
                <div class="tab-pane fade" id="tres">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <h4 style="color: #942a25">Nombre(s)<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="nombre_tutor" id="nombre_tutor" value="{{$datos_t->nombre}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Apellido Paterno<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="ap_tutor" id="ap_tutor" value="{{$datos_t->ap_paterno_T}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Apellido Materno<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="am_tutor" id="am_tutor" value="{{$datos_t->ap_mat_T}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="exampleInputEmail1">Ocupación<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control" placeholder="" name="puesto_tutor" id="puesto_tutor" value="{{$datos_t->puesto}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Parentezco<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" name="parentesco_tutor" id="parentesco_tutor" value="{{$datos_t->parentezco}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Fecha de Nacimiento<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control datepicker"  placeholder="" name="fecha_nac_tutor" id="fecha_nac_tutor" value="{{$datos_t->fecha_nac_T}}">
                        </div>

                    </div>
                    <div class="row">
                    <div class="col-md-1 col-md-offset-1" id="edad_tutor">
                        <h4 style="color: #942a25">Edad<b style="color:red; font-size:23px;">*</b></h4>
                        <input type="text" class="form-control"  placeholder=""  name="edad_tutor" id="edad_tutor" value="{{$datos_t->edad}}" readonly="readonly">
                    </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Genero<b style="color:red; font-size:23px;">*</b></h4>
                            <select class="form-control" name="genero_tutor" id="genero_tutor">
                                @if($existe==0)
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    <option  value="1">FEMENINO</option>
                                    <option  value="2">MASCULINO</option>
                                @else
                                    @if($datos_t->genero==null)
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        <option  value="1">FEMENINO</option>
                                        <option  value="2">MASCULINO</option>
                                    @elseif($datos_t->genero==1)
                                        <option value="1" selected="selected">FEMENINO</option>
                                        <option  value="2">MASCULINO</option>
                                    @else
                                        <option value="1" >FEMENINO</option>
                                        <option  value="2" selected="selected">MASCULINO</option>
                                    @endif

                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Estado Civil<b style="color:red; font-size:23px;">*</b></h4>
                            <select class="form-control  "placeholder="selecciona una Opcion" name="estado_civ_t" id="estado_civ_t" >
                                @if($existe==0)
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    <option  value="SOLTERO">SOLTERO</option>
                                    <option  value="CASADO">CASADO</option>
                                    <option  value="DIVORCIADO">DIVORCIADO</option>
                                    <option  value="UNION LIBRE">UNION LIBRE</option>
                                    <option  value="VIUDO">VIUDO</option>
                                @else
                                    @if($datos_t->edo_civil_t == null)
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        <option  value="SOLTERO">SOLTERO</option>
                                        <option  value="CASADO">CASADO</option>
                                        <option  value="DIVORCIADO">DIVORCIADO</option>
                                        <option  value="UNION LIBRE">UNION LIBRE</option>
                                        <option  value="VIUDO">VIUDO</option>
                                   @elseif($datos_t->edo_civil_t=="SOLTERO")
                                       <option  value="SOLTERO" selected="selected">SOLTERO</option>
                                       <option  value="CASADO">CASADO</option>
                                       <option  value="DIVORCIADO">DIVORCIADO</option>
                                       <option  value="UNION LIBRE">UNION LIBRE</option>
                                       <option  value="VIUDO">VIUDO</option>
                                   @else
                                       @if($datos_t->edo_civil_t=="CASADO")
                                           <option  value="SOLTERO" >SOLTERO</option>
                                           <option  value="CASADO" selected="selected">CASADO</option>
                                           <option  value="DIVORCIADO">DIVORCIADO</option>
                                           <option  value="UNION LIBRE">UNION LIBRE</option>
                                           <option  value="VIUDO">VIUDO</option>
                                       @else
                                           @if($datos_t->edo_civil_t=="UNION LIBRE")
                                               <option  value="SOLTERO" >SOLTERO</option>
                                               <option  value="CASADO" >CASADO</option>
                                               <option  value="DIVORCIADO" >DIVORCIADO</option>
                                               <option  value="UNION LIBRE" selected="selected">UNION LIBRE</option>
                                               <option  value="VIUDO">VIUDO</option>

                                           @else
                                               @if($datos_t->edo_civil_t)=="DIVORCIADO")
                                                <option  value="SOLTERO" >SOLTERO</option>
                                                <option  value="CASADO" >CASADO</option>
                                                <option  value="DIVORCIADO" selected="selected">DIVORCIADO</option>
                                                <option  value="UNION LIBRE">UNION LIBRE</option>
                                                <option  value="VIUDO">VIUDO</option>
                                                @else
                                                    @if($datos_t->edo_civil_t=="VIUDO")
                                                        <option  value="SOLTERO" >SOLTERO</option>
                                                        <option  value="CASADO" >CASADO</option>
                                                        <option  value="DIVORCIADO" >DIVORCIADO</option>
                                                        <option  value="UNION LIBRE" >UNION LIBRE</option>
                                                        <option  value="VIUDO" selected="selected">VIUDO</option>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1">Grado de Estudios<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control"  placeholder="" name="estudios_tutor" id="estudios_tutor" value="{{$datos_t->grado_est_t}}">
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3 col-md-offset-1">
                            <h4 style="color: #942a25">Nacionalidad<b style="color:red; font-size:23px;">*</b></h4>

                            <select class="form-control "placeholder="selecciona una Opcion" name="nacioanalidad_turor" id="nacioanalidad_turor" >
                                @if($existe==0)
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    <option  value="MEXICANA">MEXICANA</option>
                                    <option  value="EXTRANJERA">EXTRANJERA</option>
                                @else
                                    @if($datos_t->nacionalidad_t== null)
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        <option  value="MEXICANA">MEXICANA</option>
                                        <option  value="EXTRANJERA">EXTRANJERA</option>
                                    @elseif($datos_t->nacionalidad_t=="MEXICANA")
                                        <option value="MEXICANA" selected="selected">MEXICANA</option>
                                        <option  value="EXTRANJERA">EXTRANJERA</option>
                                    @else
                                        <option value="MEXICANA" >MEXICANA</option>
                                        <option  value="EXTRANJERA" selected="selected">EXTRANJERA</option>
                                    @endif

                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Curp<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();"  oninput="validarcurp(this)" placeholder="" name="curp_tutor" id="curp_tutor" value="{{$datos_t->curp}}">
                            <p id="result"></p>
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1">Correo<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control"  placeholder="" name="correo_tutor" id="correo_tutor" value="{{$datos_t->correo_t}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="exampleInputEmail1">Twitter<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="twiter_tutor" id="twiter_tutor" value="{{$datos_t->twitter_t}}">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1">Facebook<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control"  placeholder="" name="facebook_tutor" id="facebook_tutor" value="{{$datos_t->facebook_t}}">
                        </div>
                        <div class="col-md-3">
                            <h4 style="color: #942a25">Celular<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control" id="exampleInputEmail1" nKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                   maxlength="10" placeholder="Ejem: 7221232323" name="cel_tutor" id="cel_tutor" value="{{$datos_t->cel_t}}">
                        </div>

                    </div>
                    <div class="row">
                    <div class="col-md-3 col-lg-offset-1">
                        <label for="exampleInputEmail1">Tel Fijo<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                        <input type="text" class="form-control"  placeholder="" name="tel_fijo_tutor" id="tel_fijo_tutor" value="{{$datos_t->tel_fijo_t}}">
                    </div>
                    </div>
                    <br>
                    <br>
                    </div>
                    <div class="tab-pane fade" id="cuatro">
                       {{--
                          <div class="row">
                              <div class="col-md-5 col-md-offset-4">
                        <h5>El Domicilio del Padre o Tutor es el mismo que el del Alumno?</h5>
                             <br>
                            <p style="text-align: center" >
                                <input type="checkbox" value="" id="direccion_igual">
                                Si
                            </p>

                              </div>
                          </div>
                          --}}

                        <div class="row">
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Estado<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control" placeholder="" id="estado_tutorinput" name="estado_tutorinput" value="" style="display:none;">
                            <select class="form-control  "placeholder="selecciona una Opcion" id="estados_tutor" value="" name="estados_tutor">

                                @if($existe==0||$datos_t->estado_T==0)


                                    <option  disabled selected hidden>Selecciona una opción</option>
                                    @foreach($estados_tutor as$estados_tutor)
                                        <option value="{{$estados_tutor->id_estado}}" data-esta="{{$estados_tutor->nombre_estado}}">{{$estados_tutor->nombre_estado}}</option>
                                    @endforeach

                                @else

                                    <option  disabled selected hidden>Selecciona una carrera</option>
                                    @foreach($estados_tutor as$estados_tutor)
                                        @if($estados_tutor->id_estado == $datos_t->estado_T)
                                            <option value="{{$estados_tutor->id_estado}}" data-esta="{{$estados_tutor->nombre_estado}}" selected="selected">{{$estados_tutor->nombre_estado}}</option>
                                        @else

                                            <option value="{{$estados_tutor->id_estado}}" data-esta="{{$estados_tutor->nombre_estado}}" >{{$estados_tutor->nombre_estado}}</option>

                                        @endif
                                    @endforeach


                                @endif
                            </select>
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Municipio<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" name="municipios_tutorinput" class="form-control" placeholder="" id="municipio_tutorinput" value="" style="display:none;">
                            <select class="form-control  "placeholder="selecciona una Opcion" id="municipios_tutor" value="" name="municipios_tutor">
                                <option disabled selected hidden>Selecciona una opcion</option>
                            </select>
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">calle<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control" placeholder="" id="calle_tutor" name="calle_tutor" value="{{$datos_t->calle}}">
                            </div>
                            <div class="col-md-2">
                            <label for="exampleInputEmail1">No. Exterior<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control" placeholder="" id="no_exterior_tutor" name="no_exterior_tutor" value="{{$datos_t->n_ext_t}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                            <label for="exampleInputEmail1">No. Interior<b style="color:#F5F8FA; font-size:23px;">*</b></label>
                            <input type="text" class="form-control"placeholder="" id="no_interior_tutor" name="no_interior_tutor" value="{{$datos_t->n_int_t}}">
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Entre Calle<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" id="entre_calle_tutor" name="entre_calle_tutor" value="{{$datos_t->entre_calle_t}}">
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Y Calle<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" id="y_calle_tutor" name="y_calle_tutor" value="{{$datos_t->y_calle_t}}">
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Otra referencia<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" id="otra_ref_tutor" name="otra_ref_tutor" value="{{$datos_t->otra_ref_t}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="color: #942a25">C. Postal<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" id="cp_tutor" name="cp_tutor" value="{{$datos_t->cp_t}}">
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Colonia<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control"  placeholder="" id="colonia_tutor" name="colonia_tutor" value="{{$datos_t->colonia_t}}">
                            </div>
                            <div class="col-md-3">
                                <h4 style="color: #942a25">Localidad<b style="color:red; font-size:23px;">*</b></h4>
                            <input type="text" class="form-control" placeholder="" id="localidad_tutor" name="localidad_tutor" value="{{$datos_t->localidad_t}}">
                            </div>
                        <input type="text" class="form-control" placeholder="" id="igual" name="igual" value="2" style="display:none;">

                        </div>

                        <div class="row">
                            <br>
                            <div class="col-md-2 col-md-offset-4">
                                <br>
                        <input type="button"  class="btn btn-primary"  id="guardar" value="Guardar Cambios"/>
                          </div>
                            <br>
                            </div>

                      <br>
                    </div>

                </div>

            </form>
        </div>

    </main>

    <script >

        /*var seguro=$("#seguro").val();
        var seguro_social=$("#seguro_social").val();

        if(seguro == 1){
            if(seguro_social.length == 11) {

            }
            else
            {
                $("#seguro_social").val('');
                swal({
                    position: "top",
                    type: "error",
                    title: "El número de seguro social del IMSS es de 11 digitos",
                    showConfirmButton: false,
                    timer: 3500
                });
            }

        }
        else if(seguro == 2){
            if(seguro_social.length == 11) {

            }
            else
            {
                $("#seguro_social").val('');
                swal({
                    position: "top",
                    type: "error",
                    title: "El número de seguro social del ISSSTE es de 11 digitos",
                    showConfirmButton: false,
                    timer: 3500
                });
            }

        }
        else if(seguro == 3){
            if(seguro_social.length == 9) {

            }
            else
            {
                $("#seguro_social").val('');
                swal({
                    position: "top",
                    type: "error",
                    title: "El número de seguro social del ISEMMYM es de 9 digitos",
                    showConfirmButton: false,
                    timer: 3500
                });
            }

        }
        else if(seguro == 4){
            if(seguro_social.length == 10 || seguro_social.length == 11) {

            }
            else
            {
                $("#seguro_social").val('');
                swal({
                    position: "top",
                    type: "error",
                    title: "El número de seguro social del seguro popular ahora INSABI es de 10 a 11 digitos",
                    showConfirmButton: false,
                    timer: 3500
                });
            }

        }*/
        var lenguas=$("#lengua").val();

        if(lenguas == 1) {
            $('#descripcion_lengua').empty();
            $('#descripcion_lengua').append('<label for="exampleInputEmail1">Cual es?<b style="color:red; font-size:23px;"></b></label> <input type="text" class="form-control" id="descripcion_lengua" name="descripcion_lengua"  value=""  readonly="readonly">\n' +
                '                          ');
        }
        var disc=$("#discapacidad").val();
        if(disc == 1) {
            $('#descripcion_discapacidad').empty();
            $('#descripcion_discapacidad').append(' <label for="exampleInputEmail1">Cual es?<b style="color:red; font-size:23px;"></b></label> <input type="text" class="form-control" id="descripcion_discapacidad" name="descripcion_discapacidad" placeholder="" value="" readonly="readonly">\n' +
                '                          ');
        }


        var d = new Date();

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true
        });
        function validarcurp(input) {
            var curp = input.value.toUpperCase(),
                resultado = document.getElementById("result"),
                valido = "No válido";

            if (curpValida(curp)) {
                valido = "Válido";
                resultado.classList.add("ok");
            } else {
                resultado.classList.remove("ok");
            }

            resultado.innerText = "Formato: " + valido;
        }
        function validarInput(input) {
            var curp = input.value.toUpperCase(),
                resultado = document.getElementById("resultado"),
                valido = "No válido";

            if (curpValida(curp)) {
                valido = "Válido";
                resultado.classList.add("ok");
            } else {
                resultado.classList.remove("ok");
            }

            resultado.innerText = "Formato: " + valido;
        }

        function curpValida(curp) {
            var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
                validado = curp.match(re);

            if (!validado)  //Coincide con el formato general?
                return false;

            //Validar que coincida el dígito verificador
            function digitoVerificador(curp17) {
                //Fuente https://consultas.curp.gob.mx/CurpSP/
                var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
                    lngSuma      = 0.0,
                    lngDigito    = 0.0;
                for(var i=0; i<17; i++)
                    lngSuma= lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
                lngDigito = 10 - lngSuma % 10;
                if(lngDigito == 10)
                    return 0;
                return lngDigito;
            }
            if (validado[2] != digitoVerificador(validado[1]))
                return false;

            return true; //Validado
        }

        function calculateAge(birthday) {
            var birthday_arr = birthday.split("/");
            var birthday_date = new Date(birthday_arr[2], birthday_arr[1] - 1, birthday_arr[0]);
            var ageDifMs = Date.now() - birthday_date.getTime();
            var ageDate = new Date(ageDifMs);
            return Math.abs(ageDate.getUTCFullYear() - 1970);
        }


        $(document).ready(function(){

            $("#seguro").change(function(e) {

                $("#seguro_s").css("display", "inline");
                $("#seguro_social").val('');
            });
            $("#seguro_social").change(function(e) {

                var seguro=$("#seguro").val();
                var seguro_social=$("#seguro_social").val();

                if(seguro == 1){
                    if(seguro_social.length == 11) {

                    }
                    else
                    {
                        $("#seguro_social").val('');
                        swal({
                            position: "top",
                            type: "error",
                            title: "El número de seguro social del IMSS es de 11 digitos",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }
                else if(seguro == 2){
                    if(seguro_social.length == 11) {

                    }
                    else
                    {
                        $("#seguro_social").val('');
                        swal({
                            position: "top",
                            type: "error",
                            title: "El número de seguro social del ISSSTE es de 11 digitos",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }
                else if(seguro == 3){
                    if(seguro_social.length == 9 || seguro_social.length == 8 || seguro_social.length == 7 ) {

                    }
                    else
                    {
                        $("#seguro_social").val('');
                        swal({
                            position: "top",
                            type: "error",
                            title: "El número de seguro social del ISEMMYM es de 7 a 9  digitos",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }
                else if(seguro == 4){
                    if(seguro_social.length == 10 || seguro_social.length == 11) {

                    }
                    else
                    {
                        $("#seguro_social").val('');
                        swal({
                            position: "top",
                            type: "error",
                            title: "El número de seguro social del seguro popular ahora INSABI  es de 10 a 11 digitos",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }
                else if(seguro == 5){
                    if(seguro_social.length >= 8) {

                    }
                    else
                    {
                        $("#seguro_social").val('');
                        swal({
                            position: "top",
                            type: "error",
                            title: "El número de seguro social del ISSFAM   es de 8 digitos",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }

            });


            $("#fecha_nac_tutor").change(function (e) {
                var fecha_nacimiento_tutor = e.target.value;
                var fecha_tutor= calculateAge(fecha_nacimiento_tutor);
                $('#edad_tutor').empty();
                $('#edad_tutor').append(' <label for="exampleInputEmail1">Edad<b style="color:red; font-size:23px;">*</b></label>\n' +
                    '                <input type="text" class="form-control"  placeholder=""  name="edad_tutor" id="edad_tutor" value="'+fecha_tutor+'" readonly="readonly">\n' +
                    '               ');

            });

            $("#lengua").change(function(e) {

                var lengua = e.target.value;
                if(lengua == 1) {
                    $('#descripcion_lengua').empty();
                    $('#descripcion_lengua').append('<label for="exampleInputEmail1">Cual es?<b style="color:red; font-size:23px;"></b></label> <input type="text" class="form-control" id="descripcion_lengua" name="descripcion_lengua"  value=""  readonly="readonly">\n' +
                        '                          ');
                }
                if(lengua == 2) {
                    $('#descripcion_lengua').empty();
                    $('#descripcion_lengua').append('<label for="exampleInputEmail1">Cual es?<b style="color:red; font-size:23px;"></b></label> <input type="text" class="form-control" id="descripcion_lengua" name="descripcion_lengua" value="{{$datos->descripcion_lengua }}" required>\n' +
                        '                          ');
                }
            });
            $("#discapacidad").change(function(e) {

                var discapacidad = e.target.value;
                if(discapacidad == 1) {
                    $('#descripcion_discapacidad').empty();
                    $('#descripcion_discapacidad').append(' <label for="exampleInputEmail1">Cual es?<b style="color:red; font-size:23px;"></b></label> <input type="text" class="form-control" id="descripcion_discapacidad" name="descripcion_discapacidad" placeholder="" value="" readonly="readonly">\n' +
                        '                          ');
                }
                if(discapacidad == 2) {
                    $('#descripcion_discapacidad').empty();
                    $('#descripcion_discapacidad').append(' <label for="exampleInputEmail1">Cual es?<b style="color:red; font-size:23px;"></b></label> <input type="text" class="form-control" id="descripcion_discapacidad"  name="descripcion_discapacidad" placeholder="" value="{{$datos->descripcion_discapacidad}}" required>\n' +
                        '                          ');
                }
            });
            $("#cuenta").change(function(e) {
                console.log(e);
                var cuenta = e.target.value;
                $.get("/cuenta_alumno/"+cuenta,function(response,state){
                       // alert(response[0].numero);
                         if(response == 1)
                         {
                             $("#cuenta").val('');
                             swal({
                                 position: "top",
                                 type: "error",
                                 title: "El número de cuenta ya está registrado...",
                                 showConfirmButton: false,
                                 timer: 3500
                             });
                         }

                });

            });
            var saber;
            $("#formgeneral").validate({
                ignore:[],
                rules:{
                    cuenta:"required",
                    nomalu:"required",
                    appalu:"required",
                    apmalu:"required",
                    fecha_nac:"required",
                    edadalu:{required:true, digits:true,minlength: 2},
                    generoalu:"required",
                    curpalu:"required",
                    nacioalu:"required",
                    estadoalu:"required",
                    correoalu:"required",
                    entidadalu:"required",
                   // escuela:"required",
                  //  estudiosalu:"required",
                    carreras:"required",
                    semestre:"required",
                    promedio_preparatoria:{required:true},
                    grupoalu:"required",
                    celalu:{required:true, digits:true,minlength: 10},
                    estados_alu:"required",
                    municipios_alu:"required",
                    calle_alu:"required",
                    entre_calle_alu:"required",
                    y_calle_alu:"required",
                    otra_ref_alu:"required",
                    CP_alu:{required:true, digits:true,minlength: 5},
                    colonia_alu:"required",
                    localidad_alu:"required",
                    discapacidad:"required",
                    lengua:"required",
                    seguro:"required",
                    seguro_social:{required:true},



                    nombre_tutor:"required",
                    ap_tutor:"required",
                    am_tutor:"required",
                    parentesco_tutor:"required",
                    fecha_nac_tutor:"required",
                    edad_tutor:{required:true, digits:true,minlength: 2},
                    genero_tutor:"required",
                    estado_civ_t:"required",
                    nacioanalidad_turor:"required",
                    curp_tutor:"required",
                    cel_tutor:{required:true, digits:true,minlength: 10},

                    estados_tutor:"required",
                    calle_tutor:"required",
                    entre_calle_tutor:"required",
                    y_calle_tutor:"required",
                    otra_ref_tutor:"required",
                    cp_tutor:{required:true, digits:true,minlength: 5},
                    colonia_tutor:"required",
                    localidad_tutor:"required",


                },

                invalidHandler:function(event,validator){
                    //$("#uno").addClass("active");
                    $.each(validator.errorMap,function(key,value){

                        $('.nav-tabs a[href="#'+ $("#"+key).parents(".tab-pane").attr('id')+'"]').tab("show");

                        //alert( $("'#"+key+"'").parents(".tab-pane"));


                        //console.log(html)
                        console.log(key);
                        return false;
                    });

                },
                submitHandler: function(form){
                    form.submit();


                }


            });
            $("#guardar").click(function(){


                saber=$("#igual").val();

                // alert(saber);

                $("#formgeneral").submit();
            });

//alert("{{$datos->id_carrera}}");
                    @if($existe==1)



            var id_estado={!!$x=$datos->estado==null?0:$datos->estado!!};
            var id_municipio={!!$y=$datos->id_municipio==null?0:$datos->id_municipio!!};
            //console.log(id_estado);
            //console.log(id_municipio);




            $.get('/ajax-subcat?id_estado=' + id_estado,function(data){

                $('#municipios_alu').empty();
                $.each(data,function(datos_alumno,subcatObj){


                    if(subcatObj.id_municipio==id_municipio)
                    {
                        $('#municipios_alu').append(' <option selected="selected" value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>'
                        );
                    }
                    else
                    {
                        $('#municipios_alu').append(' <option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>'
                        );
                    }

                });
            });


                    @endif

                    @if($existe==1)
            var id_estadot={!!$x=$datos_t->estado_T==null?0:$datos_t->estado_T!!};
            var id_municipiot={!!$y=$datos_t->municipio_T==null?0:$datos_t->municipio_T!!};
            // var id_municipiot={{$datos_t->municipio_T}};
            //console.log(id_estadot);
            //console.log(id_municipiot);


            $.get('/ajax-subcat?id_estado=' + id_estadot,function(data){

                $('#municipios_tutor').empty();
                $.each(data,function(datos_alumno,subcatObj){


                    if(subcatObj.id_municipio==id_municipiot)
                    {
                        $('#municipios_tutor').append(' <option selected="selected" value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>'
                        );
                    }
                    else
                    {
                        $('#municipios_tutor').append(' <option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>'
                        );
                    }

                });
            });


            @endif



            $("#direccion_igual").click(function(){


                if($('#direccion_igual').is(':checked') )
                {

                    var selected = $("#estados_alu").find('option:selected');
                    var selected2 = $("#municipios_alu").find('option:selected');
                    var direccion=1;

                    var es=selected.data('esta');
                    var mu=selected2.data('muni');

                    $('#igual').val(direccion);
                    $('#estado_tutorinput').val(es);
                    document.getElementById('estado_tutorinput').style.display="";
                    document.getElementById('estado_tutorinput').disabled="true";
                    document.getElementById('estados_tutor').style.display="none";


                    $('#municipio_tutorinput').val(mu);
                    document.getElementById('municipio_tutorinput').style.display="";
                    document.getElementById('municipio_tutorinput').disabled="true";
                    document.getElementById('municipios_tutor').style.display="none";




                    $('#calle_tutor').val($("#calle_alu").val());
                    document.getElementById('calle_tutor').disabled="true";
                    $('#no_exterior_tutor').val($("#n_exterior_alu").val());
                    document.getElementById('no_exterior_tutor').disabled="true";
                    $('#no_interior_tutor').val($("#n_interior_alu").val());
                    document.getElementById('no_interior_tutor').disabled="true";
                    $('#entre_calle_tutor').val($("#entre_calle_alu").val());
                    document.getElementById('entre_calle_tutor').disabled="true";
                    $('#y_calle_tutor').val($("#y_calle_alu").val());
                    document.getElementById('y_calle_tutor').disabled="true";
                    $('#otra_ref_tutor').val($("#otra_ref_alu").val());
                    document.getElementById('otra_ref_tutor').disabled="true";
                    $('#colonia_tutor').val($("#colonia_alu").val());
                    document.getElementById('colonia_tutor').disabled="true";
                    $('#localidad_tutor').val($("#localidad_alu").val());
                    document.getElementById('localidad_tutor').disabled="true";
                    $('#cp_tutor').val($("#CP_alu").val());
                    document.getElementById('cp_tutor').disabled="true";



                }
                else
                {
                    var direccion=2;

                    document.getElementById('estado_tutorinput').style.display="none";
                    document.getElementById('municipio_tutorinput').style.display="none";
                    document.getElementById('estados_tutor').style.display="";
                    document.getElementById('municipios_tutor').style.display="";

                    document.getElementById('estado_tutorinput').disabled="";
                    document.getElementById('municipio_tutorinput').disabled="";
                    document.getElementById('calle_tutor').disabled="";
                    document.getElementById('no_exterior_tutor').disabled="";
                    document.getElementById('no_interior_tutor').disabled="";
                    document.getElementById('entre_calle_tutor').disabled="";
                    document.getElementById('y_calle_tutor').disabled="";
                    document.getElementById('otra_ref_tutor').disabled="";
                    document.getElementById('colonia_tutor').disabled="";
                    document.getElementById('localidad_tutor').disabled="";
                    document.getElementById('cp_tutor').disabled="";
                    $('#igual').val(direccion);
                    //  $('#estados_tutor').val("");
                    $('#municipios_tutor').val("");
                    $('#calle_tutor').val("");
                    $('#no_exterior_tutor').val("");
                    $('#no_interior_tutor').val("");
                    $('#entre_calle_tutor').val("");
                    $('#y_calle_tutor').val("");
                    $('#otra_ref_tutor').val("");
                    $('#colonia_tutor').val("");
                    $('#localidad_tutor').val("");
                    $('#cp_tutor').val("");
                }
            });


///////////////////////////////////////trae los municipios para la parte del alumno

            $("#estados_alu").change(function(e){
                console.log(e);

                var id_estado= e.target.value;
                //alert(id_estado);

                $.get('/ajax-subcat?id_estado=' + id_estado,function(data){

                    $('#municipios_alu').empty();
                    $.each(data,function(datos_alumno,subcatObj){


                        //  alert(subcatObj);
                        $('#municipios_alu').append('<option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>');
                    });
                });
            });

///////////////////////////////////trae los municipios para la parte del tutor
            $("#estados_tutor").on('change',function(e){
                console.log(e);
                var id_estado= e.target.value;
                //alert(id_estado);
                $.get('/ajax-subcat?id_estado=' + id_estado,function(data){
                    $('#municipios_tutor').empty();
                    $.each(data,function(datos_alumno,subcatObj){
                        //  alert(subcatObj);
                        $('#municipios_tutor').append('<option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>');
                    });
                });
            });


        });
    </script>
@endsection
