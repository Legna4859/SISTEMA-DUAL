@extends('layouts.app')
@section('title', 'Historial de presupuesto autorizado')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Historiales de los presupuestos autorizados</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="dropdown">
                                <label for="exampleInputEmail1">Elige año del presupuesto autorizado</label>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="id_year" name="id_year" required>
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    @foreach($years as $year)
                                        <option value="{{$year->id_year}}" data-esta="{{$year->descripcion}}">{{$year->descripcion}} </option>
                                    @endforeach
                                </select>
                                <br>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#id_year").on('change',function(e) {
                // alert($("#grupos").val());
                var id_year=$("#id_year").val();

                window.location.href='/presupuesto_autorizado/menu_presupuesto_autorizado_historial/'+id_year;



            });


        });

    </script>
@endsection