@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">

                        <div class="col-md-2" style="text-align: center;">
                            <a    href="{{url('/servicios_escolares/carreras_calificaciones')}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:15px;color:#363636"></span><br>Regresar</a>
                        </div>
                        <div class="col-md-4 col-md-offset-1 " style="text-align: center;">
                            <h3 class="panel-title text-center">DOCENTES DE LA CARRERA</h3>
                        </div>

                    </div>

                </div>
                <div class="panel-body">
                    @if($carreras!=null)
                        <div class="col-md-3">
                            <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                                @foreach($carreras as $carrera)
                                    <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" onclick="ocultar_materias()" href="#ca_{{ $carrera ["id_carrera"] }}">{{$carrera["nombre_carrera"]}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-content col-md-3">
                            <div class="tab-pane fade in active text-center">
                                <div class="col-md-4 col-md-offset-3">
                                </div>
                            </div>
                            @foreach($carreras as $carrera)
                                <div id="ca_{{ $carrera ["id_carrera"] }}" class="tab-pane">
                                    <ul class="nav nav-pills nav-stacked col-md-12" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                                        @foreach($carrera['docentes'] as $docente)
                                            <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" href="#{{$carrera ["id_carrera"] }}doc_{{ $docente ["id_personal"] }}">{{ $docente["nombre"] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-content col-md-6" >
                            <div class="tab-pane fade in active text-center" id="cont_materias">
                                <div class="col-md-4 col-md-offset-3" >

                                </div>
                            </div>
                            @foreach($carreras as $carrera)
                                @foreach($carrera['docentes'] as $docente)
                                    <div id="{{$carrera ["id_carrera"] }}doc_{{$docente ["id_personal"] }}" class="tab-pane">
                                        <h4><label class="label label-success">{{ $docente['nombre'] }}</label></h4>
                                        <table class="table text-center my-0 border-table">
                                            <thead>
                                            <tr class="text-center">
                                                <th class="text-center">NP.</th>
                                                <th class="text-center">Materias</th>
                                                <th class="text-center">Semestre</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($docente['materias'] as $materia)
                                                <tr>
                                                    <td>{{$materia['contador'] }}</td>
                                                    <td><label for="" class="rounded px-3 border border-success bg-light text-success"><strong>{{$materia["nombre_materia"]}}</strong></label></td>
                                                    <td>{{$materia['nombre_semestre']}}</td>
                                                    <td>
                                                        <span data-toggle="modal" data-target="#modal_grupos_{{$materia['id_materia']}}_{{$docente ["id_personal"] }}" data-id=""><a href="#!" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="ver"><span class="oi oi-eye"></span></a></span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <div class="row col-md-12">
                            <div class="col-md-6 col-md-offset-3">
                                <label class=" alert alert-danger text-center"  data-toggle="tab" ><h3>No existen materias asignadas para el periodo seleccionado
                                    </h3></label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div>
        @foreach($carreras as $carrera)
            @foreach($carrera['docentes'] as $docente)
                @foreach($docente['materias']   as $materia)
                    <div class="modal fade" id="modal_grupos_{{$materia['id_materia']}}_{{$docente ["id_personal"] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">{{$materia['nombre_materia']}}</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table text-center my-0 border-table">
                                        <thead>
                                        <tr class="text-center">
                                            <th class="text-center">Grupo</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($materia['grupos'] as $grupo)
                                            <tr>
                                                <td>{{$grupo['grupos']}}</td>
                                                <td>
                                                    <a href="/servicios_escolares/acciones/periodos/{{$docente['id_personal']}}/{{$materia['id_materia']}}/{{$grupo['id_grupo']}}/{{ $carrera ['id_carrera'] }}" class="btn btn-primary tooltip-options link" data-toggle="tooltip" data-placement="top" title="Periodos"><span class="oi oi-calendar"></span></a>
                                                    <a href="/servicios_escolares/acciones/{{$docente['id_personal']}}/{{$materia['id_materia']}}/{{$grupo['id_grupo']}}/{{ $carrera ['id_carrera'] }}" class="btn btn-primary tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluaciones"><span class="oi oi-pencil"></span></a>
                                                    <a href="/servicios_escolares/acciones_sumativa/{{$docente['id_personal']}}/{{$materia['id_materia']}}/{{$grupo['id_grupo']}}/{{ $carrera ['id_carrera'] }}" class="btn btn-danger tooltip-options link" data-toggle="tooltip" data-placement="top" title="Evaluaciones sumativas"><span class="oi oi-pencil"></span></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        @endforeach


    </div>
    <script>


        $("#guarda_mods").on("click",function()
        {
            finicio=$("#finicio_mod").val();
            ffin=$("#ffin_mod").val();
            fsum_inicio= "{{$fsum_inicio}}";
            fsum_fin= "{{$fsum_fin}}";
            if(finicio == fsum_inicio && ffin ==fsum_fin)
            {
                $("#modal_periodos_sumativas").modal("hide");
                swal({
                    type: "warning",
                    title: "No se realizarón modificaciones",
                    showConfirmButton: false,
                    timer: 1500
                }). then(function(result)
                {
                    $("#finicio_t").html('{{ $fsum_inicio}}');
                    $("#ffin_t").html('{{ $fsum_fin}}');
                    $("#guarda_mods").get(0).type = 'hidden';
                    $("#modificav_sumativa").get(0).type = 'button';

                });
            }
            else if(finicio=="" || ffin=="")
            {
                swal({
                    position:"top",
                    type: "error",
                    title: "Deben llenarse todos los campos",
                    showConfirmButton: false,
                    timer: 2500
                });
            }
            else if(finicio == ffin)
            {
                swal({
                    position:"top",
                    type: "error",
                    title: "Las fechas no pueden ser iguales",
                    showConfirmButton: false,
                    timer: 2500
                });
            }
            else if(finicio >= ffin)
            {
                swal({
                    position:"top",
                    type: "error",
                    title: "la fecha inicial no puede ser mayor a la final",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
            else
            {
                $.get('/servicios_escolares/periodoSumativas/{{ $id_periodo_sum }}/modifica',{finicio:finicio,ffin:ffin},function(request){
                    $("#modal_periodos_sumativas").modal("hide");
                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    }). then(function(result)
                    {
                        location.reload(true);
                    });
                });
            }
        });



    </script>
@endsection