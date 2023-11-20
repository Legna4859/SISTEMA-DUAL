@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">HISTORIAL DE MODIFICACIONES DE CARGAS ACADÉMICAS </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table id="table_historial_carga" class="table table-bordered table-resposive">
            <thead class="">
                <tr class="text-center">
                    <th class="text-center">No.</th>
                    <th class="text-center">NO. CUENTA</th>
                    <th class="text-center">ALUMNO</th>
                    <th class="text-center">PERSONAL QUE HIZO LA MODIFICACIÓN</th>
                    <th class="text-center">FECHA</th>
                    <th class="text-center">INSTRUCCIÓN</th>
                </tr>
                </thead>
                <?php $i=0; ?>
                @foreach($historial as $historial)
                    <?php $i++; ?>
                    <tr class="text-center">
                        <td class="text-center">{{$i}}</td>
                        <td class="text-center">{{$historial->cuenta}}</td>
                        <td class="text-center">{{$historial->alumno}} {{$historial->apaterno}} {{$historial->amaterno}}</td>
                        <td class="text-center">{{$historial->nombre}}</td>
                        <td class="text-center">{{$historial->fecha}}</td>
                        <td class="text-center">{{$historial->estado}}</td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_historial_carga').DataTable( );

        });
    </script>
@endsection
