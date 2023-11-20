@extends('layouts.app')
@section('title', ' solicitud para residencia profesional')
@section('content')
    <main class="col-md-12">

        @if($estado_reg_soli == 0)
            <div class="row">
                <div class="col-md-5 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Agregar datos de la solicitud para residencia profesional</h3>
                        </div>
                    </div>
                </div>
            </div>
            <form id="form_registro_solicitud" class="form" action="{{url("/residencia/guardar_solicitud_residencia/".$anteproyecto->id_anteproyecto)}}" role="form" method="POST" >
                {{ csrf_field() }}
              <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p>Lugar:	VALLE DE BRAVO, ESTADO DE MÉXICO</p>
                            </div>
                            <div class="col-md-4">
                                <?php
                                $fecha_hoy = date("d-m-Y");
                                ?>
                                <p >Fecha: {{ $fecha_hoy }}</p>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p><br></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p>{{ $datos_jefe->titulo }} {{ $datos_jefe->nombre }}</p>
                                <p><b>JEFE DE DIVISIÓN DE  {{ $datos_jefe->carrera }} </b></p>
                                <p>PRESENTE</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>NOMBRE DEL PROYECTO: </b> <br> {{ $nombre_proyecto }}</p>
                            </div>
                        </div>

                                <div style="background: #b8daff" class="row">
                                    <div class="col-md-10">
                                        <p></p><b>Selecciona  la opción del proyecto       <br></b></p>
                                        @foreach($opciones_proyecto as $opcion)
                                              <label class="radio-inline"><input   type="radio" name="id_opcion_proyecto" id="id_opcion_proyecto" value="{{ $opcion->id_opcion_proy }}">{{ $opcion->nombre_opcion }}</label>
                                        @endforeach
                                    </div>
                                </div>
                        <div class="row">
                            <div class="col-md-10">
                                <p><b>PERIODO PROYECTADO: </b>  {{ $nombre_periodo_seguimiento->periodo }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr size="11">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Datos de la empresa</b> </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Nombre de la empresa: </b> {{ $datos_empresa->nombre }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Giro de la empresa: </b> {{ $datos_empresa->giro }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Sector de la empresa: </b> {{ $datos_empresa->sector }}</p>
                            </div>
                        </div>

                                <div style="background: #b8daff" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rfc_empresa">Ingresa el RFC de la empresa:</label>
                                            <input class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();"  id="rfc_empresa" name="rfc_empresa" type="text" placeholder="Ingresa RFC de la empresa" style="" required></input>
                                        </div>
                                    </div>
                                </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Domicilio de la empresa: </b> {{ $domicilio_empresa }}</p>
                            </div>
                        </div>
                            <div style="background: #b8daff" class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="colonia_empresa">Ingresa colonia donde se encuentra la empresa</label>
                                        <input class="form-control"   id="colonia_empresa" name="colonia_empresa" type="text" placeholder="Ingresa la colonia donde se encuentra la empresa" style="" required></input>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo_postal">Ingresa Codigo Postal donde se encuentra la empresa:</label>
                                        <input class="form-control"   id="codigo_postal" name="codigo_postal" type="int" placeholder="Ingresa codigo postal donde se encuentra la empresa" style="" required></input>
                                    </div>
                                </div>
                            </div>
                            <div style="background: #b8daff" class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="municipio_empresa">Ingresa Ciudad o Municipio donde se encuentra la empresa:</label>
                                        <input class="form-control"   id="municipio_empresa" name="municipio_empresa" type="text" placeholder="Ingresa municipio o ciudad donde se encuentra la empresa" style="" required></input>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono_empresa">Ingresa telefono (no celular) de la empresa:</label>
                                        <input class="form-control"   id="telefono_empresa" name="telefono_empresa" type="tel" placeholder="Ingresa telefono de la empresa" style="" required></input>
                                    </div>
                                </div>
                            </div>
                            <div style="background: #b8daff" class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="mision_empresa">Ingresa la misión de la empresa:</label>
                                        <textarea class="form-control"  id="mision_empresa" name="mision_empresa" rows="5" placeholder="Ingresa misión de la empresa" style="" required></textarea>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr size="11">
                            </div>
                        </div>

                            <div  class="row">
                                <div class="col-md-6">
                                    <p><b>Nombre del titular de la empresa o institución: </b> {{ $datos_empresa->dir_gral }}</p>
                                </div>
                                <div style="background: #b8daff" class="col-md-6">
                                    <div class="form-group">
                                        <label for="puesto_titular_empresa">Ingresa el puesto del titular de la empresa o institución :</label>
                                        <input class="form-control"   id="puesto_titular_empresa" name="puesto_titular_empresa" type="text" placeholder="Ingresa el puesto del titular de la empresa o institución" style="" required></input>
                                    </div>
                                </div>
                            </div>


                        <div class="row">
                            <div class="col-md-6">
                                <p><b>Nombre del Asesor Externo:: </b> {{ $datos_empresa->asesor }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><b>Puesto: </b> {{ $datos_empresa->puesto }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr size="11">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Datos del Residente:</b> </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Nombre del residente: </b> {{ $datos_alumn->nombre }} {{ $datos_alumn->apaterno }} {{ $datos_alumn->amaterno }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><b>Carrera: </b> {{ $datos_alumn->carrera }} </p>
                            </div>
                            <div class="col-md-6">
                                <p><b>No. cuenta: </b> {{ $datos_alumn->cuenta }} </p>
                            </div>
                        </div>
                        <div style="background: #b8daff"class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="domiclio_estudiante">Ingresa tu domicilio:</label>
                                    <input class="form-control"   id="domiclio_estudiante" name="domiclio_estudiante" type="text" placeholder="Ingresa tu domicilio" style="" required></input>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><b>E-mail: </b> {{ $datos_alumn->email }} </p>
                            </div>
                            <div class="col-md-3">
                                <p><b>Para Seguridad Social acudir: </b> {{ $datos_alumn->seguro_social }} </p>
                            </div>
                            <div style="background: #b8daff" class="col-md-3">
                                <div class="form-group">
                                    <label for="no_seguro">No. seguro social:</label>
                                    <input class="form-control"   id="no_seguro" name="no_seguro" type="text" placeholder="Ingresa tu número de seguro social" style="" value="{{ $datos_alumn->numero_seguro_social }}" required></input>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p><b>Ciudad o municipio: </b> {{ $datos_alumn->nombre_municipio }} </p>
                            </div>
                            <div style="background: #b8daff" class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono_estudiante">Ingresa tu telefono:</label>
                                    <input class="form-control"   id="telefono_estudiante" name="telefono_estudiante" type="tel" placeholder="Ingresa tu telefono" style=""  required></input>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
            </form>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    <button type="button" class="btn btn-primary" id="registrar_datos">Guardar Datos</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
             <p><br></p>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-5 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Modificar datos de la solicitud para residencia profesional</h3>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-primary" onclick="window.open('{{url('/residencia/pdf_solicitud_residencia/'.$anteproyecto->id_anteproyecto)}}')">Imprimir Solicitud para residencia profesional</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
             <p><br></p>
            </div>
        </div>
            <form id="form_modificar_solicitud" class="form" action="{{url("/residencia/guardar_mod_solicitud_residencia/".$anteproyecto->id_anteproyecto)}}" role="form" method="POST" >
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>Lugar:	VALLE DE BRAVO, ESTADO DE MÉXICO</p>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        $fecha_hoy = date("d-m-Y");
                                        ?>
                                        <p >Fecha: {{ $fecha_hoy }}</p>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <p><br></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>{{ $datos_jefe->titulo }} {{ $datos_jefe->nombre }}</p>
                                        <p><b>JEFE DE DIVISIÓN DE  {{ $datos_jefe->carrera }} </b></p>
                                        <p>PRESENTE</p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>NOMBRE DEL PROYECTO: </b> <br> {{ $nombre_proyecto }}</p>
                                    </div>
                                </div>

                                <div style="background: #b8daff" class="row">
                                    <div class="col-md-10">
                                        <p></p><b>Selecciona  la opción del proyecto       <br></b></p>
                                        @foreach($opciones_proyecto as $opcion)
                                            @if($opcion->id_opcion_proy == $reg_solicitud->id_opcion_proyecto)
                                                <label class="radio-inline"><input   type="radio" name="id_opcion_proyecto" id="id_opcion_proyecto" value="{{ $opcion->id_opcion_proy }}" checked>{{ $opcion->nombre_opcion }}</label>
                                            @else
                                            <label class="radio-inline"><input   type="radio" name="id_opcion_proyecto" id="id_opcion_proyecto" value="{{ $opcion->id_opcion_proy }}">{{ $opcion->nombre_opcion }}</label>
                                             @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <p><b>PERIODO PROYECTADO: </b>  {{ $nombre_periodo_seguimiento->periodo }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr size="11">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Datos de la empresa</b> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Nombre de la empresa: </b> {{ $datos_empresa->nombre }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Giro de la empresa: </b> {{ $datos_empresa->giro }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Sector de la empresa: </b> {{ $datos_empresa->sector }}</p>
                                    </div>
                                </div>

                                <div style="background: #b8daff" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rfc_empresa">Ingresa el RFC de la empresa:</label>
                                            <input class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();"  id="rfc_empresa" name="rfc_empresa" type="text" placeholder="Ingresa RFC de la empresa" value="{{ $reg_solicitud->rfc_empresa }}" style="" required></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Domicilio de la empresa: </b> {{ $domicilio_empresa }}</p>
                                    </div>
                                </div>
                                <div style="background: #b8daff" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="colonia_empresa">Ingresa colonia donde se encuentra la empresa</label>
                                            <input class="form-control"   id="colonia_empresa" name="colonia_empresa" type="text" placeholder="Ingresa la colonia donde se encuentra la empresa" value="{{ $reg_solicitud->colonia_empresa }}" style="" required></input>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="codigo_postal">Ingresa Codigo Postal donde se encuentra la empresa:</label>
                                            <input class="form-control"   id="codigo_postal" name="codigo_postal" type="int" placeholder="Ingresa codigo postal donde se encuentra la empresa" style="" value="{{ $reg_solicitud->codigo_postal_empresa }}" required></input>
                                        </div>
                                    </div>
                                </div>
                                <div style="background: #b8daff" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="municipio_empresa">Ingresa Ciudad o Municipio donde se encuentra la empresa:</label>
                                            <input class="form-control"   id="municipio_empresa" name="municipio_empresa" type="text" placeholder="Ingresa municipio o ciudad donde se encuentra la empresa" value="{{ $reg_solicitud->ciudad_municipio_empresa }}" style="" required></input>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono_empresa">Ingresa telefono (no celular) de la empresa:</label>
                                            <input class="form-control"   id="telefono_empresa" name="telefono_empresa" type="tel" placeholder="Ingresa telefono de la empresa" value="{{ $reg_solicitud->telefono_empresa }}" style="" required></input>
                                        </div>
                                    </div>
                                </div>
                                <div style="background: #b8daff" class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="mision_empresa">Ingresa la misión de la empresa:</label>
                                            <textarea class="form-control"  id="mision_empresa" name="mision_empresa" rows="5" placeholder="Ingresa misión de la empresa"  required>{{ $reg_solicitud->mision_empresa }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr size="11">
                                    </div>
                                </div>

                                <div  class="row">
                                    <div class="col-md-6">
                                        <p><b>Nombre del titular de la empresa o institución: </b> {{ $datos_empresa->dir_gral }}</p>
                                    </div>
                                    <div style="background: #b8daff" class="col-md-6">
                                        <div class="form-group">
                                            <label for="puesto_titular_empresa">Ingresa el puesto del titular de la empresa o institución :</label>
                                            <input class="form-control"   id="puesto_titular_empresa" name="puesto_titular_empresa" type="text" placeholder="Ingresa el puesto del titular de la empresa o institución" style="" value="{{ $reg_solicitud->puesto_titular_empresa }}" required></input>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <p><b>Nombre del Asesor Externo:: </b> {{ $datos_empresa->asesor }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><b>Puesto: </b> {{ $datos_empresa->puesto }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <hr size="11">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Datos del Residente:</b> </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Nombre del residente: </b> {{ $datos_alumn->nombre }} {{ $datos_alumn->apaterno }} {{ $datos_alumn->amaterno }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><b>Carrera: </b> {{ $datos_alumn->carrera }} </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><b>No. cuenta: </b> {{ $datos_alumn->cuenta }} </p>
                                    </div>
                                </div>
                                <div style="background: #b8daff"class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="domiclio_estudiante">Ingresa tu domicilio:</label>
                                            <input class="form-control"   id="domiclio_estudiante" name="domiclio_estudiante" type="text" placeholder="Ingresa tu domicilio" value="{{ $reg_solicitud->domiclio_estudiante }}" required></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><b>E-mail: </b> {{ $datos_alumn->email }} </p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><b>Para Seguridad Social acudir: </b> {{ $datos_alumn->seguro_social }} </p>
                                    </div>
                                    <div style="background: #b8daff" class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_seguro">No. seguro social:</label>
                                            <input class="form-control"   id="no_seguro" name="no_seguro" type="text" placeholder="Ingresa tu número de seguro social" style="" value="{{ $reg_solicitud->no_seguro_estudiante }}" required></input>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><b>Ciudad o municipio: </b> {{ $datos_alumn->nombre_municipio }} </p>
                                    </div>
                                    <div style="background: #b8daff" class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono_estudiante">Ingresa tu telefono:</label>
                                            <input class="form-control"   id="telefono_estudiante" name="telefono_estudiante" type="tel" placeholder="Ingresa tu telefono" value="{{ $reg_solicitud->telefono_estudiante }}"  required></input>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    <button type="button" class="btn btn-primary" id="modificar_datos">Modificar Datos</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    <p><br></p>
                </div>
            </div>
        @endif

    </main>
    <script type="text/javascript">


        $(document).ready(function() {
           $("#registrar_datos").click(function (){

               var id_opcion_proyecto = $("input[type='radio'][name='id_opcion_proyecto']:checked").val();
             //  alert(id_opcion_proyecto);
               if(id_opcion_proyecto != undefined){
                   var rfc_empresa = $("#rfc_empresa").val();
                   if(rfc_empresa != "") {
                       var colonia_empresa = $("#colonia_empresa").val();
                       if (colonia_empresa != "") {
                           var codigo_postal = $("#codigo_postal").val();
                           if (codigo_postal != "") {
                               var municipio_empresa = $("#municipio_empresa").val();
                               if (municipio_empresa != "") {
                                   var telefono_empresa = $("#telefono_empresa").val();
                                   if (telefono_empresa != "") {
                                       var mision_empresa = $("#mision_empresa").val();
                                       if (mision_empresa != "") {
                                           var titular_empresa = $("#titular_empresa").val();
                                           if (titular_empresa != "") {
                                               var puesto_titular_empresa = $("#puesto_titular_empresa").val();
                                               if (puesto_titular_empresa != "") {
                                                           var domiclio_estudiante = $("#domiclio_estudiante").val();
                                                           if (domiclio_estudiante != "") {
                                                               var no_seguro = $("#no_seguro").val();
                                                               if (no_seguro != "") {
                                                                   var telefono_estudiante = $("#telefono_estudiante").val();
                                                                   if (telefono_estudiante != "") {
                                                                       $("#registrar_datos").attr("disabled", true);
                                                                       $("#form_registro_solicitud").submit();
                                                                       swal({
                                                                           position: "top",
                                                                           type: "success",
                                                                           title: "Registro exitoso",
                                                                           showConfirmButton: false,
                                                                           timer: 3500
                                                                       });
                                                                   } else {
                                                                       swal({
                                                                           position: "top",
                                                                           type: "warning",
                                                                           title: "Ingresa tu telefono",
                                                                           showConfirmButton: false,
                                                                           timer: 3500
                                                                       });
                                                                   }

                                                               } else {
                                                                   swal({
                                                                       position: "top",
                                                                       type: "warning",
                                                                       title: "Ingresa tu no. seguro social",
                                                                       showConfirmButton: false,
                                                                       timer: 3500
                                                                   });
                                                               }
                                                           } else {
                                                               swal({
                                                                   position: "top",
                                                                   type: "warning",
                                                                   title: "Ingresa tu domicilio",
                                                                   showConfirmButton: false,
                                                                   timer: 3500
                                                               });
                                                           }





                                               } else {
                                                   swal({
                                                       position: "top",
                                                       type: "warning",
                                                       title: "Ingresa el puesto del titular de la empresa o institución",
                                                       showConfirmButton: false,
                                                       timer: 3500
                                                   });
                                               }

                                           } else {
                                               swal({
                                                   position: "top",
                                                   type: "warning",
                                                   title: "Ingresa el nombre del titular de la empresa o institución",
                                                   showConfirmButton: false,
                                                   timer: 3500
                                               });
                                           }
                                       } else {
                                           swal({
                                               position: "top",
                                               type: "warning",
                                               title: "Ingresa la misión de la empresa",
                                               showConfirmButton: false,
                                               timer: 3500
                                           });
                                       }

                                   } else {
                                       swal({
                                           position: "top",
                                           type: "warning",
                                           title: "Ingresa telefono (no celular) de la empresa",
                                           showConfirmButton: false,
                                           timer: 3500
                                       });
                                   }

                               } else {
                                   swal({
                                       position: "top",
                                       type: "warning",
                                       title: "Ingresa Ciudad o Municipio donde se encuentra la empresa",
                                       showConfirmButton: false,
                                       timer: 3500
                                   });
                               }
                           } else {
                               swal({
                                   position: "top",
                                   type: "warning",
                                   title: "Ingresa Codigo Postal donde se encuentra la empresa",
                                   showConfirmButton: false,
                                   timer: 3500
                               });
                           }

                       } else {
                           swal({
                               position: "top",
                               type: "warning",
                               title: "Ingresa colonia donde se encuentra la empresa",
                               showConfirmButton: false,
                               timer: 3500
                           });
                       }
                   }else{
                       swal({
                           position: "top",
                           type: "warning",
                           title: "Ingresa el RFC de la empresa",
                           showConfirmButton: false,
                           timer: 3500
                       });
                   }
               }else {
                   swal({
                       position: "top",
                       type: "warning",
                       title: "Selecciona  la opción del proyecto ",
                       showConfirmButton: false,
                       timer: 3500
                   });
               }

             /*  var nombre_proyecto = $("#nombre_proyecto").val();
               if (nombre_proyecto != "") {
                   $("#guardar_solicitud").attr("disabled", true);
                   $("#form_portada").submit();
                   swal({
                       position: "top",
                       type: "success",
                       title: "Registro exitoso",
                       showConfirmButton: false,
                       timer: 3500
                   });

               }
               else{
                   swal({
                       position: "top",
                       type: "warning",
                       title: "Selecciona  la opción del proyecto ",
                       showConfirmButton: false,
                       timer: 3500
                   });
               }

              */

           });
            $("#modificar_datos").click(function (){

                var id_opcion_proyecto = $("input[type='radio'][name='id_opcion_proyecto']:checked").val();
                //  alert(id_opcion_proyecto);
                if(id_opcion_proyecto != undefined){
                    var rfc_empresa = $("#rfc_empresa").val();
                    if(rfc_empresa != "") {
                        var colonia_empresa = $("#colonia_empresa").val();
                        if (colonia_empresa != "") {
                            var codigo_postal = $("#codigo_postal").val();
                            if (codigo_postal != "") {
                                var municipio_empresa = $("#municipio_empresa").val();
                                if (municipio_empresa != "") {
                                    var telefono_empresa = $("#telefono_empresa").val();
                                    if (telefono_empresa != "") {
                                        var mision_empresa = $("#mision_empresa").val();
                                        if (mision_empresa != "") {
                                            var titular_empresa = $("#titular_empresa").val();
                                            if (titular_empresa != "") {
                                                var puesto_titular_empresa = $("#puesto_titular_empresa").val();
                                                if (puesto_titular_empresa != "") {
                                                            var domiclio_estudiante = $("#domiclio_estudiante").val();
                                                            if (domiclio_estudiante != "") {
                                                                var no_seguro = $("#no_seguro").val();
                                                                if (no_seguro != "") {
                                                                    var telefono_estudiante = $("#telefono_estudiante").val();
                                                                    if (telefono_estudiante != "") {
                                                                        $("#modificar_datos").attr("disabled", true);
                                                                        $("#form_modificar_solicitud").submit();
                                                                        swal({
                                                                            position: "top",
                                                                            type: "success",
                                                                            title: "Registro exitoso",
                                                                            showConfirmButton: false,
                                                                            timer: 3500
                                                                        });
                                                                    } else {
                                                                        swal({
                                                                            position: "top",
                                                                            type: "warning",
                                                                            title: "Ingresa tu telefono",
                                                                            showConfirmButton: false,
                                                                            timer: 3500
                                                                        });
                                                                    }

                                                                } else {
                                                                    swal({
                                                                        position: "top",
                                                                        type: "warning",
                                                                        title: "Ingresa tu no. seguro social",
                                                                        showConfirmButton: false,
                                                                        timer: 3500
                                                                    });
                                                                }
                                                            } else {
                                                                swal({
                                                                    position: "top",
                                                                    type: "warning",
                                                                    title: "Ingresa tu domicilio",
                                                                    showConfirmButton: false,
                                                                    timer: 3500
                                                                });
                                                            }





                                                } else {
                                                    swal({
                                                        position: "top",
                                                        type: "warning",
                                                        title: "Ingresa el puesto del titular de la empresa o institución",
                                                        showConfirmButton: false,
                                                        timer: 3500
                                                    });
                                                }

                                            } else {
                                                swal({
                                                    position: "top",
                                                    type: "warning",
                                                    title: "Ingresa el nombre del titular de la empresa o institución",
                                                    showConfirmButton: false,
                                                    timer: 3500
                                                });
                                            }
                                        } else {
                                            swal({
                                                position: "top",
                                                type: "warning",
                                                title: "Ingresa la misión de la empresa",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        }

                                    } else {
                                        swal({
                                            position: "top",
                                            type: "warning",
                                            title: "Ingresa telefono (no celular) de la empresa",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }

                                } else {
                                    swal({
                                        position: "top",
                                        type: "warning",
                                        title: "Ingresa Ciudad o Municipio donde se encuentra la empresa",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }
                            } else {
                                swal({
                                    position: "top",
                                    type: "warning",
                                    title: "Ingresa Codigo Postal donde se encuentra la empresa",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }

                        } else {
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa colonia donde se encuentra la empresa",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa el RFC de la empresa",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else {
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Selecciona  la opción del proyecto ",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

                /*  var nombre_proyecto = $("#nombre_proyecto").val();
                  if (nombre_proyecto != "") {
                      $("#guardar_solicitud").attr("disabled", true);
                      $("#form_portada").submit();
                      swal({
                          position: "top",
                          type: "success",
                          title: "Registro exitoso",
                          showConfirmButton: false,
                          timer: 3500
                      });

                  }
                  else{
                      swal({
                          position: "top",
                          type: "warning",
                          title: "Selecciona  la opción del proyecto ",
                          showConfirmButton: false,
                          timer: 3500
                      });
                  }

                 */

            });
        });
    </script>

@endsection