@extends('layouts.app')
@section('title', 'Empresa')
@section('content')
<main class="col-md-12">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Agregar empresa y asesor externo</h3>
                </div>
            </div>
        </div>
    </div>
    @if($reg_empresa == 0)
    <form class="form" action="{{url("/residencia/registrar_empresa_asesor/")}}" role="form" method="POST" >
        {{ csrf_field() }}
        <div class="row">
            <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{ $anteproyecto->id_anteproyecto }}">

            <div class="col-md-4 col-md-offset-2">
            <div class="form-group">
                <label for="asesor">Nombre del asesor externo</label>
                <input class="form-control"  id="asesor" name="asesor"  placeholder="Ingresa el asesor externo "  required></input>
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="form-group">
                <label for="asesor">Puesto del asesor externo</label>
                <input class="form-control"  id="puesto_asesor" name="puesto_asesor"  placeholder="Ingresa el puesto del asesor externo "  required></input>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="dropdown">
                <label for="exampleInputEmail1">Elige empresa<b style="color:red; font-size:23px;">*</b></label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="empresa" name="empresa" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($empresa as $empresa)
                        <option value="{{$empresa->id_empresa}}" data-esta="{{$empresa->nombre}}">{{$empresa->nombre}}</option>
                    @endforeach
                </select>
                <br>
            </div>
        </div>
        <br>
    </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="dropdown">
                    <label for="exampleInputEmail1">Sector de  la empresa<b style="color:red; font-size:23px;">*</b></label>
                    <select class="form-control  "placeholder="selecciona una Opcion" id="sector" name="sector" required>
                        <option disabled selected hidden>Selecciona una opción</option>
                        @foreach($sectores as $sector)
                                <option value="{{$sector->id_sector}}" data-esta="{{$sector->descripcion}}">{{$sector->descripcion}}</option>

                        @endforeach
                    </select>
                    <br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dropdown">
                    <label for="exampleInputEmail1">Giro de la empresa<b style="color:red; font-size:23px;">*</b></label>
                    <select class="form-control  "placeholder="selecciona una Opcion" id="giro" name="giro" required>
                        <option disabled selected hidden>Selecciona una opción</option>
                        @foreach($giros as $giro)
                                <option value="{{$giro->id_giro}}" data-esta="{{$giro->descripcion}}">{{$giro->descripcion}}</option>

                        @endforeach
                    </select>
                    <br>
                </div>
            </div>
            <br>
        </div>
    <div class="row">
        <div class="col-md-12 " id="empre">

        </div>
    </div>
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="form-group">
                    <label for="dependencia">Información de la empresa</label>
                    <textarea class="form-control" id="informacion_empresa" name="informacion_empresa" rows="15"  placeholder="Ingresa informacion de la empresa" maxlength="1200" style=""></textarea>
                </div>
            </div>
            <br>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-5">
                <button type="submit" class="btn btn-primary">Guardar</button>

            </div>
            <br>
        </div>
        <br>
    </form>
        @endif
    @if($reg_empresa == 1)
        <form class="form" action="{{url("/residencia/modificar_empresa_asesor/")}}" role="form" method="POST" >
            {{ csrf_field() }}
            <div class="row">
                <input type="hidden" id="id_anteproyecto" name="id_anteproyecto" value="{{ $anteproyecto->id_anteproyecto }}">

                <div class="col-md-4 col-md-offset-2">
                    <div class="form-group">
                        <label for="asesor">Nombre del asesor externo</label>
                        <input class="form-control"  id="asesor" name="asesor"  placeholder="Ingresa el asesor externo " value="{{ $proyecto_empresa->asesor }}" required></input>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label for="asesor">Puesto del asesor externo</label>
                        <input class="form-control"  id="puesto_asesor" name="puesto_asesor"  placeholder="Ingresa el puesto del asesor externo " value="{{ $proyecto_empresa->puesto }}"  required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Elige empresa<b style="color:red; font-size:23px;">*</b></label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="empresa" name="empresa" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($empresa as $empresa)
                                @if($proyecto_empresa->id_empresa == $empresa->id_empresa)
                                <option value="{{$empresa->id_empresa}}" selected="selected">{{$empresa->nombre}}</option>
                                @else
                                    <option value="{{$empresa->id_empresa}}" data-esta="{{$empresa->nombre}}">{{$empresa->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>
                <br>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Sector de la empresa<b style="color:red; font-size:23px;">*</b></label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="sector" name="sector" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($sectores as $sector)
                                @if($proyecto_empresa->id_sector == $sector->id_sector)
                                    <option value="{{$sector->id_sector}}" selected="selected">{{$sector->descripcion}}</option>
                                @else
                                    <option value="{{$sector->id_sector}}" data-esta="{{$sector->descripcion}}">{{$sector->descripcion}}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Giro de la empresa<b style="color:red; font-size:23px;">*</b></label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="giro" name="giro" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($giros as $giro)
                                @if($proyecto_empresa->id_giro == $giro->id_giro)
                                    <option value="{{$giro->id_giro}}" selected="selected">{{$giro->descripcion}}</option>
                                @else
                                    <option value="{{$giro->id_giro}}" data-esta="{{$giro->descripcion}}">{{$giro->descripcion}}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>
                <br>
            </div>

            <div class="row">
                <div class="col-md-12 " id="empre">
                    <table id="tabla_envioss" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>Nombre de la empresa</th>
                            <th>Domicilio </th>
                            <th>Telefono</th>
                            <th>Correo</th>
                            <th>Director General</th>

                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{$emp->nombre}}</td>
                                <td>{{$emp->domicilio}}</td>
                                <td>{{$emp->tel_empresa}}</td>
                                <td>{{$emp->correo }}</td>
                                <td>{{$emp->dir_gral}}</td>


                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 col-md-offset-2">
                    <div class="form-group">
                        <label for="dependencia">Información de la empresa</label>
                        <textarea class="form-control" id="informacion_empresa" name="informacion_empresa" rows="15"  placeholder="Ingresa informacion de la empresa" maxlength="1200" style="">{{ $proyecto_empresa->informacion_empresa }}</textarea>
                    </div>
                </div>
                <br>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-5">
                    <button type="submit" class="btn btn-primary">Guardar</button>

                </div>
                <br>
            </div>
            <br>
        </form>
        @endif
</main>
<script type="text/javascript">
    $(document).ready( function() {

        $("#empresa").change(function(e){

            var id_empresa= e.target.value;
//alert(id_empresa);
            $.get("/residencia/datos_empresa/"+id_empresa,function(response,state){
               // alert(response);
                $("#empre").empty();

                  //  alert(subcatObj);
                    $('#empre').append("<h3>Datos de la empresa</h3><table class='table table-bordered table-resposive'> <thead> <tr><th>Nombre de la empresa</th><th>Domicilio</th>" +
                        "<th>Tel_empresa</th> <th>Correo</th><th>Director General</th> </tr> </thead><tbody><tr>"+"<td>" +response.nombre+ "</td><td> "+response.domicilio+ "</td><td>"+response.tel_empresa+ "</td><td>"+response.correo+ "</td><td>"+response.dir_gral + "</td>"+"</tr> </tbody> </table>");

            });



        });
    });



</script>
@endsection