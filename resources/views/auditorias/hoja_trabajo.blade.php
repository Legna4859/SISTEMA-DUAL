@extends('layouts.app')
@section('title', 'Hoja de trabajo')
@section('content')
@if(\Illuminate\Support\Facades\Session::get('errors'))
<div class="alert alert-danger" role="alert">
    @foreach(\Illuminate\Support\Facades\Session::get('errors')->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</div>
@if(\Illuminate\Support\Facades\Session::forget('errors'))@endif
@endif
<main class="col-md-12">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if (session()->has('flash_notification.message'))
            <div class="alert alert-{{ session('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('flash_notification.message') !!}
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <p>
            <span class="glyphicon glyphicon-arrow-right"></span>
            <a href="{{url('/auditorias/programas')}}">Programas de auditoría</a>
            <span class="glyphicon glyphicon-chevron-right"></span>
            <a href="{{url('/auditorias/programas')}}/{{\Illuminate\Support\Facades\Session::get('id_programa')}}">Detalles del programa</a>
            <span class="glyphicon glyphicon-chevron-right"></span>
            <a href="{{url('/auditorias/programas')}}/{{\Illuminate\Support\Facades\Session::get('id_programa')}}/edit">Planes del programa</a>
            <span class="glyphicon glyphicon-chevron-right"></span>
            <a href="{{url('/auditorias/planes')}}/{{$agenda->id_auditoria}}">Detalles del plan</a>
            <span class="glyphicon glyphicon-chevron-right"></span>
            <a href="{{url('/auditorias/agenda')}}/{{$agenda->id_auditoria}}">Agenda del plan</a>
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span>Hoja de trabajo</span>
        </p>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Hoja de trabajo</h3>
            </div>
            <div class="panel-body">

                @if($reporte->count()>0)
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <strong>Área:</strong>
                            {{\App\audParseCase::parseNombre($reporte->nom_departamento)}}
                        </div>
                        <div class="col-md-4">
                            <strong>Auditoria:</strong>
                            {{\Jenssegers\Date\Date::parse($agenda->fecha)->format('Y').'-'.$noAud}}
                        </div>
                        <div class="col-md-8">
                            <strong>Auditado:</strong>
                            {{\App\audParseCase::parseAbr($reporte->titulo).' '.\App\audParseCase::parseNombre($reporte->nombre)}}
                        </div>
                        <div class="col-md-4">
                            <strong>Fecha:</strong>
                            {{\Jenssegers\Date\Date::parse($agenda->fecha)->format('d-m-Y')}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <h3 class="panel-title text-center ">Reporte Agenda </h3>
                            <br>
                            <table class="table table-striped table-bordered table-condensed">
                                <thead>
                                <tr class="">
                                    <th class="text-center" style="width:20px !important;">Criterio <br>de la norma</th>
                                    <th class="text-center">Hallazgos</th>
                                    <th class="text-center">Evaluación</th>
                                    <th class="text-center">Resultado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($criterios as $nota)
                                    <tr class="">
                                        <td style="width:20px !important;">{{$nota->punto_proceso}}</td>
                                        <td>
                                            <textarea rows="8" disabled="disabled" id="observacion{{$nota->id_notas}}" class="notas{{$nota->id_notas}}">{{$nota->observaciones}}</textarea>
                                        </td>
                                        <td>
                                            <select disabled="disabled" id="clasificacion{{$nota->id_notas}}" class="notas{{$nota->id_notas}}">
                                                <option selected disabled="disabled">No Evaluado</option>
                                                @foreach($audClasificacion as $clasifi)

                                                    <option name="" id="" value="{{$clasifi->id_clasificacion}}" {{$clasifi->id_clasificacion==$nota->id_clasificacion?"selected":""}} {{$clasifi->id_clasificacion==5?"disabled":""}}>{{$clasifi->descripcion}}</option>

                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <textarea  rows="8" disabled="disabled" id="resultado{{$nota->id_notas}}" class="notas{{$nota->id_notas}}">{{$nota->resultado}}</textarea>
                                        </td>
                                        <td class="col-md-2 text-center">

                                            @if($esLider)

                                                <a href="#!" id="autorizar-event{{$nota->id_notas}}" class="autorizar-event btn btn-{{($nota->autorizacion==null||$nota->autorizacion==0)?"danger":"success"}} m-md-2" data-id="{{$nota->id_notas}}" data-value="{{($nota->autorizacion==null||$nota->autorizacion==0)?"true":"false"}}" data-type="{{$agenda['tipo']}}" data-toggle="tooltip" title="{{($nota->autorizacion==null||$nota->autorizacion==0)?"Autorizar evaluación":"Cancelar autorización"}}"><span class="glyphicon glyphicon-star pull-right "></span></a>
                                            @endif
                                            @if(($nota->autorizacion==null||$nota->autorizacion==0)||$esLider)
                                            <a href="#!" id="editar{{$nota->id_notas}}" class="editar_nota btn btn-primary m-md-2" data-id="{{$nota->id_notas}}" data-toggle="tooltip" title="Editar evento"><span class="glyphicon glyphicon-pencil pull-right "></span></a>
                                            @endif
                                                <a href="#!" id="guardar{{$nota->id_notas}}" class="guardar_nota btn btn-success m-md-2" data-id="{{$nota->id_notas}}" data-toggle="tooltip" title="Guardar nota" style="display:none"><span class="glyphicon glyphicon-floppy-save pull-left "></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="width:20px !important;">
                                        <input type="text" id="notaNueva" class="notasNueva" disabled>
                                    </td>
                                    <td>
                                        <textarea rows="8" disabled="disabled" id="observacionNueva" class="notasNueva"></textarea>
                                    </td>
                                    <td>
                                        <select disabled="disabled" id="clasificacionNueva" class="notasNueva">
                                            <option selected disabled="disabled">No Evaluado</option>
                                            @foreach($audClasificacion as $clasifi)
                                                <option name="" id="" value="{{$clasifi->id_clasificacion}}">{{$clasifi->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <textarea rows="8" disabled="disabled" id="resultadoNueva" class="notasNueva"></textarea>
                                    </td>
                                    <td >
                                        <div class="row">
                                            <div class="col-md-1">
                                                <a href="#!" id="editarNueva" class="editar_nota btn btn-primary" data-id="Nueva" data-toggle="tooltip" title="Agregar evento"><span class="glyphicon glyphicon-plus pull-right"></span></a>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="#!" id="guardarNueva" class="guardar_nota btn btn-success" data-id="Nueva" data-toggle="tooltip" title="Guardar nota" style="display:none"><span class="glyphicon glyphicon-floppy-save pull-left"></span></a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <form action="{{url('auditorias/hoja_trabajo')}}" method="POST">
                        @csrf
                        <input type="text" name="id_agenda" value="{{$agenda->id_agenda}}" hidden>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <strong>Área:</strong>
                                <select name="id_area" id="id_area" class="form-control">
                                    <option selected disabled="true" value="">Selecciona...</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id_area}}">{{\App\audParseCase::parseNombre($area->nom_departamento)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <strong>Auditado:</strong>
                                <input type="text" class="form-control" value="" id="auditado" disabled>
                                <input type="text" value="" name="id_auditado" id="id_auditado" hidden>
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary pull-right" value="Guardar"/>
                    </form>
                @endif
            </div>
        </div>
    </div>
</main>

<form  method="POST" role="form" id="form_edit_evento">
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <input type="hidden" id="idNota" name="id_nota" value="">
    <input type="hidden" id="saveNueva" name="saveNueva">
    <input type="hidden" id="saveHallazgo" name="observaciones" value="">
    <input type="hidden" id="saveClasifica" name="id_clasificacion" value="">
    <input type="hidden" id="saveResultado" name="resultado" value="">

    <input type="hidden" id="idReporte" name="idReporte" value="{{$reporte->id_reporte}}">

</form>

<form  method="POST" role="form" id="form_autoriza_evento">
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <input type="hidden" id="id_nota_autorizar" name="id_nota_autorizar" value="">
    <input type="hidden" id="autorizaNota" name="autorizaNota" value="">


</form>

<script>
    $(document).ready(function () {
        $('#id_area').change(function(){
            var val=$(this).val();
            $.get('{{url('auditorias/get_responsable_area')}}/'+val,{},function (data) {
                // $("#id_auditado option[value="+ data.id_personal +"]").attr("selected",true);
                console.log(data);
                $('#auditado').attr('value',data[0].titulo+' '+data[0].nombre);
                $('#id_auditado').attr('value',data[0].id_personal);
            });
        });

        $(".editar_nota").click(function(){
           var id_nota=$(this).data("id");
            $(".notas"+id_nota).prop("disabled",false);
           $(this,"#autorizar-event"+id_nota).hide();

           $("#guardar"+id_nota).show();
           $(".notasNueva").val("");

            $('#form_edit_evento').trigger("reset");
        });

        $(".autorizar-event").click(function(){
            var data_id=$(this).data("id");
            $("#id_nota_autorizar").val(data_id);
            $("#autorizaNota").val($(this).data("value"))
            $("#form_autoriza_evento").submit();
        });
        $(".guardar_nota").click(function(){

            var id_nota=$(this).data("id");
            //alert($("#clasificacionNueva").val());
            if(id_nota=="Nueva")
                if($("#notaNueva").val()!=""&&$("#clasificacionNueva").val()!=""&&$("#clasificacionNueva").val()!=null)
                    if($("#resultadoNueva").val()==""&&($("#clasificacionNueva").val()!=3||$("#clasificacionNueva").val()==null))
                        Swal.fire({
                            title: 'Error',
                            text: 'Debes capturar el resultado de la auditoria',
                            timer: 2500
                        });
                    else
                        saveNota(id_nota);
                else
                    Swal.fire({
                        title: 'Error',
                        text: 'Captura el criterio de la norma y la evaluación',
                        timer: 2500
                    });
            else
                if($("#resultado"+id_nota).val()==""&&($("#clasificacion"+id_nota).val()!=3||$("#clasificacion"+id_nota).val()==null))
                    Swal.fire({
                        title: 'Error',
                        text: 'Debes capturar el resultado de la auditoria',
                        timer: 2500
                    });
                else
                saveNota(id_nota);
        });



        $('[data-toggle="tooltip"]').tooltip();
    });

    function saveNota(id_nota){
        $("#idNota").val(id_nota);
        $("#saveHallazgo").val($("#observacion"+id_nota).val())
        $("#saveClasifica").val($("#clasificacion"+id_nota).val())
        $("#saveResultado").val($("#resultado"+id_nota).val())
        $("#saveNueva").val($("#notaNueva").val())
        $("#form_edit_evento").submit();
        $(".notas"+id_nota).prop("disabled",true);
        $(this).hide();
        $("#editar"+id_nota,"#autorizar-event"+id_nota).show();
        $('#form_edit_evento').trigger("reset");

    }
</script>

@endsection
