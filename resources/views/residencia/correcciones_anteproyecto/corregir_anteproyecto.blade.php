@extends('layouts.app')
@section('title', 'Registrar Anteproyecto')
@section('content')
    @if($modificar == 0)
        <div class="row">
          <div class="col-md-6 col-md-offset-3"  >
              <div class="panel panel-danger">
                  <div class="panel-heading" style="text-align: center;">No has registrado tu anteproyecto</div>
              </div>
          </div>
        </div>

        @elseif($modificar == 1)
        <div class="row">
            <div class="col-md-6 col-md-offset-3"  >
                <div class="panel panel-warning">
                    <div class="panel-heading" style="text-align: center;">Tu anteproyecto fue enviado para revisarlo.</div>
                    <p>Los siguiente son tus revisores</p>
                    @foreach($revisores as $revisor)
                    <p>- {{ $revisor->nombre }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3"  >
                <div class="panel panel-danger">
                    <div class="panel-heading" style="text-align: center;">Los revisores que faltan por revisar tu anteproyecto.</div>

                @foreach($revisores_faltan as $rev)
                        <p>- {{ $rev->nombre }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @elseif($modificar == 3)
        <div class="row">
            <div class="col-md-6 col-md-offset-3"  >
                <div class="panel panel-success">
                    <div class="panel-heading" style="text-align: center;">Tu anteproyecto fue aceptado, registra tu empresa y ya puedes imprimir tu dictamen de anteproyecto</div>
                </div>
            </div>
        </div>

    @endif
    <script type="text/javascript">
        $(document).ready( function() {
            $("#mensaje").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $("#mensaje1").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $("#mensaje2").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $("#mensaje3").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $("#mensaje4").click(function (event) {
                $('#modal_verificar').modal('show');
            });
            $(".enviar").click(function (event) {
                var id=$(this).attr('id');
                $('#id_anteproyecto').val(id);
                $('#modal_enviar').modal('show');
            });
        });
    </script>
@endsection