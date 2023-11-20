@extends('layouts.app')
@section('title', 'Oficios')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Solicitud de Oficio de Comisión</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
            <form id="form_solicitud_oficio" action="{{url("/oficios/solicitud/creada")}}"class="form" role="form" method="POST">
                {{ csrf_field() }}
             <div class="row">
             <div class="col-md-10 col-md-offset-1">
                     <div class="form-group">
                         <label for="descripcion_oficio">Motivo de la comisión </label>
                        <textarea class="form-control" id="descripcion_oficio" name="descripcion_oficio" rows="3" placeholder="Ingresa el motivo de la comisión (Utilizar letras mayusculas y minusculas), por ejemplo:
 Entregar documentación" style=""></textarea>

                     </div>
             </div>
             </div>
                <style>
                    .depe {
                        background-color:#e8eaf6;

                    }


                </style>
                <div class="depe">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="dependencia">Dependencia de la comisión</label>
                            <textarea class="form-control" id="dependencia" name="dependencia" rows="3"  placeholder="Ingresa la dependencia de la comisión (La primera palabra que debe utilizar es 'en'), Ejemplo: en la Dirección General de Personal y la Subsecretaria de Educación Superior y Normal" style=""></textarea>
                        </div>
                    </div>
                    <div class="col-md-5 ">
                        <div class="form-group">
                            <label for="domicilio">Dirección de la dependencia de la comisión (calle y numero)</label>
                            <textarea class="form-control" id="domicilio" name="domicilio" rows="3" placeholder="Ingresa domicilio (calle y  número de la dependencia de la comisión) (La primera palabra que debe utilizar es 'en'), Ejemplo: en Lerdo No. 216" style=""></textarea>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md-3 col-md-offset-1">
                        <div class="dropdown">
                            <label for="exampleInputEmail1">Estado de la comisión<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control  "placeholder="selecciona una Opcion" id="estados" name="estados" >
                                <option disabled selected hidden>Selecciona una opción</option>
                                @foreach($estados_alu as$estados_alu)
                                    <option value="{{$estados_alu->id_estado}}" data-esta="{{$estados_alu->nombre_estado}}">{{$estados_alu->nombre_estado}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                        <div class="dropdown">
                            <label for="exampleInputEmail1">Municipio o Ciudad de la comisión<b style="color:red; font-size:23px;">*</b></label>
                            <select class="form-control  "placeholder="selecciona una Opcion" id="municipios" name="municipios" value="">
                                <option disabled selected hidden>Selecciona una opción</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="dropdown">
                            <label for="segunda_dependencia">¿Acude a otra dependencia?<b style="color:red; font-size:23px;"></b></label>
                            <select name="segunda_dependencia" id="segunda_dependencia" class="form-control" required>
                                <option disabled selected>Selecciona...</option>
                                <option value="2">SI</option>
                                <option value="1">NO</option>
                            </select>
                        </div>
                    </div>
                </div>
                    <br>
                    <hr >
                </div>

                {{---segunda dependencia---}}
                <div class="dependencia_dos" style="display:none; ">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-1">
                            <div class="form-group">
                                <label for="dependencia2">Segunda Dependencia de la comisión</label>
                                <textarea class="form-control" id="dependencia2" name="dependencia2" rows="2" placeholder="Ingresa la segunda dependencia de la comisión (La primera palabra que debe utilizar es 'en'), Ejemplo: en las Oficinas de Seguros y Finanzas"  required></textarea>
                            </div>
                        </div>
                        <div class="col-md-5 ">
                            <div class="form-group">
                                <label for="domicilio2">Dirección de la Segunda  dependencia de la comisión (calle y numero)</label>
                                <textarea class="form-control" id="domicilio2" name="domicilio2" rows="2" placeholder="Ingresa domicilio de la segunda dependencia de la comisión (calle y  número de la dependencia de la comisión) (La primera palabra que debe utilizar es 'en'), Ejemplo: en Urawa No. 100 " required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-3 col-md-offset-1">
                            <div class="dropdown">
                                <label for="exampleInputEmail1">Estado de la comisión<b style="color:red; font-size:23px;">*</b></label>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="estados2" name="estados2" required>
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    @foreach($estados_segundo  as $estados_segundo)
                                        <option value="{{$estados_segundo->id_estado}}" data-esta="{{$estados_segundo->nombre_estado}}">{{$estados_segundo->nombre_estado}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1">
                            <div class="dropdown">
                                <label for="exampleInputEmail1">Municipio o Ciudad de la Segunda dependencia<b style="color:red; font-size:23px;">*</b></label>
                                <select class="form-control" placeholder="selecciona una Opcion" id="municipio2" name="municipio2" value="" required>
                                    <option disabled selected hidden>Selecciona una opción</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-md-offset-1">
                            <div class="dropdown">
                                <label for="tercera_dependencia">¿Acude a otra dependencia?<b style="color:red; font-size:23px;"></b></label>
                                <select name="tercera_dependencia" id="tercera_dependencia" class="form-control" required>
                                    <option disabled selected>Selecciona...</option>
                                    <option value="2">SI</option>
                                    <option value="1">NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                </div>
                {{---termino de la segunda dependencia--}}
                {{---tercera dependencia---}}
                <div class="dependencia_tres" style="display: none;">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-1">
                            <div class="form-group">
                                <label for="dependencia3">Tercera Dependencia de la comisión</label>
                                <textarea class="form-control" id="dependencia3" name="dependencia3" rows="2" placeholder="Ingresa la tercera dependencia de la comisión (La primera palabra que debe utilizar es 'en'), Ejemplo: en la Secretaria de la Contraloria" style="" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-5 ">
                            <div class="form-group">
                                <label for="domicilio3">Dirección de la tercera dependencia de la comisión (calle y numero)</label>
                                <textarea class="form-control" id="domicilio3" name="domicilio3" rows="2" placeholder="Ingresa domicilio de la tercera dependencia de la comisión (calle y  número de la dependencia de la comisión) (La primera palabra que debe utilizar es 'en'), Ejemplo: en 1 de Mayo esquina Robert Boch" style="" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" >

                        <div class="col-md-3 col-md-offset-1">
                            <div class="dropdown">
                                <label for="exampleInputEmail1">Estado de la comisión<b style="color:red; font-size:23px;">*</b></label>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="estados3" name="estados3" required>
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    @foreach($estados_tercero  as $estados_tercero)
                                        <option value="{{$estados_tercero->id_estado}}" data-esta="{{$estados_tercero->nombre_estado}}">{{$estados_tercero->nombre_estado}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-md-offset-1">
                            <div class="dropdown">
                                <label for="exampleInputEmail1">Municipio o Ciudad de tercera dependencia la comisión<b style="color:red; font-size:23px;">*</b></label>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="municipio3" name="municipio3" value="" required>
                                    <option disabled selected hidden>Selecciona una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                </div>
                {{---termino de la tercera dependencia--}}

             <div class="row">
                 <div class="col-md-4 col-md-offset-2">
                     <label for="fechadesalida">Horario de salida de la comisión</label><br>
                     <div class="col-md-4">
                     <div class="form-group">
                             <input id="hora_s" class="form-control time" type="text" name="hora_s" placeholder="HORA" />
                     </div>
                     </div>
                     <div class="col-md-5">
                     <div class="form-group">
                         <input class="form-control datepicker fecha_salida"   type="text"  id="fecha_s" name="fecha_salida" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD" >
                     </div>
                     </div>
                 </div>
                  <div class="col-md-4">
                      <label for="fecha_regreso">Horario de regreso de la comisión</label><br>
                      <div class="col-md-4">
                      <div class="form-group">
                          <input id="hora_r" type="text" class="form-control time" name="hora_r" placeholder="HORA" />

                      </div>
                      </div>
                      <div class="col-md-5">
                      <div class="form-group">
                      <input class="form-control datepicker fecha_regreso " type="text" id="fecha_r" name="fecha_regreso" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD">

                      </div>

                      </div>
                  </div>
             </div>
                <div class="row" >
                <div class="col-md-3 col-md-offset-2">
                    <div class="dropdown">
                        <label for="selectLugar_s">Lugar de salida</label>
                        <select class="form-control" id="selectLugar_s" name="selectLugar_s" >
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($lugares as $lugar)
                                <option value="{{$lugar->id_lugar}}" data-esta="{{$lugar->descripcion}}"> {{$lugar->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-1">
                    <div class="dropdown">
                        <label for="selectLugar_r">Lugar de regreso</label>
                        <select name="selectLugar_r" id="selectLugar_r" class="form-control ">
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($lugares as $lugar)
                                <option value="{{$lugar->id_lugar}}" data-esta="{{$lugar->descripcion}}"> {{$lugar->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                </div>

            <div class="row" style="display: inline" id="aceptar">
                <br>
                <div class="col-md-3 col-md-offset-5 m">
                    <button id="guardar_solicitud" type="button" class="btn btn-success btn-lg">Aceptar</button>
                </div>

            </div>
            </form>
            <br>
        </div>
        </div>


         <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_solicitud").click(function(event){
                $("#form_solicitud_oficio").submit();
            });
            $("#form_solicitud_oficio").validate({
                rules: {
                    descripcion_oficio: {
                        required: true,
                    },
                    dependencia: {
                        required: true,
                    },
                    domicilio: {
                        required: true,
                    },
                    hora_r: {
                        required: true,
                    },
                    hora_s: {
                        required: true,
                    },
                    fecha_salida: {
                        required: true,
                    },
                    fecha_regreso: {
                        required: true,
                    },
                    selectLugar_s: "required",
                    selectLugar_r: "required",
                    estados: "required",
                    municipios: "required",


                },
            });
            var getDate = function (input) {
                return new Date(input.date.valueOf());
            }
            $( '.fecha_salida').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                    $('.fecha_regreso').datepicker('setStartDate', getDate(selected));
                });
            $( '.fecha_regreso' ).datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                    $('.fecha_salida').datepicker('setEndDate', getDate(selected));
                });
            $('#hora_s').pickatime({
                format: 'HH:i',

            });
            $('#hora_r').pickatime({

                format: 'HH:i',
            });

           });
        $("#estados").change(function(e){
            console.log(e);
            var id_estado= e.target.value;

            $.get('/ajax-subcat?id_estado=' + id_estado,function(data){

                $('#municipios').empty();
                ;
                $.each(data,function(datos_alumno,subcatObj){
                    //  alert(subcatObj);
                    $('#municipios').append('<option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>');
                });
            });

        });
        $("#estados2").change(function(e){
            console.log(e);
            var id_estado= e.target.value;

            $.get('/ajax-subcat?id_estado=' + id_estado,function(data){


                $('#municipio2').empty();

                $.each(data,function(datos_alumno,subcatObj){
                    //  alert(subcatObj);
                    $('#municipio2').append('<option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>');

                });
            });

        });
        $("#estados3").change(function(e){
            console.log(e);
            var id_estado= e.target.value;
            $.get('/ajax-subcat?id_estado=' + id_estado,function(data){


                $('#municipio3').empty();

                $.each(data,function(datos_alumno,subcatObj){
                    //  alert(subcatObj);
                    $('#municipio3').append('<option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>');

                });
            });

        });

        $("#segunda_dependencia").change(function(e){

            var acudir_dependencia= e.target.value;
            if(acudir_dependencia == 2){
                $(".dependencia_dos").css( {"background-color": "#e8eaf6", "display": "block"});

            } if(acudir_dependencia ==1){
                $(".dependencia_dos").css("display", "none");
                $(".dependencia_tres").css("display", "none");
            }
        });
        $("#tercera_dependencia").change(function(e){

            var acudir_dependencia= e.target.value;
            if(acudir_dependencia == 2){
                $(".dependencia_tres").css( {"background-color": "#e8eaf6", "display": "block"});

            } if(acudir_dependencia ==1){
                $(".dependencia_tres").css("display", "none");
            }
        });



         </script>


    </main>
    @endsection