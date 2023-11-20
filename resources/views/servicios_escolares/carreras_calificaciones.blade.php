@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-right">PROGRAMAS DE ESTUDIO <input style="margin-left: 25%" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_periodos_sumativas" value="Periodo de evaluaciones sumativas"></h3>
                </div>
                <div class="panel-body">
                    @if($carreras!=null)
                        <div class="col-md-3">
                            <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                                @foreach($carreras as $carrera)
                                    <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" href="#" onclick="window.location='{{ url('/servicios_escolares/evaluaciones/'.$carrera->id_carrera ) }}'" >   {{$carrera->carrera}}</a></li>

                                @endforeach
                            </ul>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <div>


        <div class="modal fade panel-info" id="modal_periodos_sumativas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Periodo de evaluaciones sumativas</h4>
                    </div>
                    <div class="modal-body col-md-12">
                        @if( $periodo_sumativas==0 )
                            <div class="col-md-6">
                                <label for="">Fecha de inicio</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                            </div>
                            <div class="col-md-6">
                                <label for="">Fecha de finalización</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary h-secondary_m" data-dismiss="modal">Cancelar</button>
                        <button type="" class="btn btn-primary h-primary_m" name="generar_periodo_sumativas" id="generar_periodo_sumativas">Aceptar</button>
                    </div>
                    @else
                        <table class="table text-center my-0 border-table">
                            <thead>
                            <tr class="text-center">
                                <th class="text-center">Fecha de inicio</th>
                                <th class="text-center">Fecha de finalización</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td id="finicio_t" name="finicio_t">{{ $fsum_inicio}}</td>
                                <td id="ffin_t" name="ffin_t">{{$fsum_fin}}</td>
                                <td id="cont_btns" name="cont_btns">
                                    <input type="button" class="btn btn-primary" id="modificav_sumativa" name="modificav_sumativa" value="Modificar">
                                    <input type="hidden" class="btn btn-success" id="guarda_mods" name="guarda_mods" value="Guardar">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                </div>
                @endif
            </div>
        </div>
    </div>
    </div>
    <script>
        $("#generar_periodo_sumativas").on("click",function()
        {
            finicio=$("#fecha_inicio").val();
            ffin=$("#fecha_fin").val();
            if(finicio=="" || ffin=="")
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
                $.get('/servicios_escolares/genperiodoSumativas',{finicio:finicio,ffin:ffin},function(request){
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
        $("#modificav_sumativa").on("click",function()
        {
            $("#finicio_t").html('<input  type="date" class="form-control text-center" id="finicio_mod" name="finicio_mod" value="{{ $fsum_inicio}}">');
            $("#ffin_t").html('<input  type="date" class="form-control text-center" id="ffin_mod" name="ffin_mod" value="{{ $fsum_fin}}">');
            $("#guarda_mods").get(0).type = 'button';
            $("#modificav_sumativa").get(0).type = 'hidden';
        });
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