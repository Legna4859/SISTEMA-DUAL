@extends('layouts.app')
@section('title', 'Solicitud de Prorroga')
@section('content')



    <main>


        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Solicitud de Prorroga</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 col-md-offset-8 text-center">
                <div class="panel panel-info text-center">
                    <div class="panel-heading text-center">
                        <a href="/solicitud/exportar_solicitudes_prorroga" class="btn btn-success tooltip-options link" data-toggle="tooltip" data-placement="top" title="Exportar a excel"><span class="oi oi-pencil"></span>Exportar a excel</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
        <table class="table table-bordered " Style="background: white;" id="solicitudes">
            <thead>
            <tr>
                <th>No. CUENTA</th>
                <th>NOMBRE DE ALUMNO(A)</th>
                <th>CURP</th>
                <th>CARRERA</th>
                <th>CORREO</th>
                <th>SEMESTRE AL QUE INGRESARÁ</th>
                <th>FECHA EFECTUADA PARA EL PAGO DE COLEGIATURA SEMESTRAL</th>
                <th>IMPRIMIR</th>

            </tr>
            </thead>
            <tbody>

            @foreach($solicitudes_prorroga as $solicitudes_prorroga)
                <tr>
                    <th>{{$solicitudes_prorroga->cuenta}}</th>
                    <td>{{$solicitudes_prorroga->nombre}} {{$solicitudes_prorroga->apaterno}} {{$solicitudes_prorroga->amaterno}}</td>
                    <td>{{$solicitudes_prorroga->curp_al}}</td>
                    <td>{{$solicitudes_prorroga->carrera}}</td>
                    <td>{{$solicitudes_prorroga->correo_al}}</td>
                    <td>{{$solicitudes_prorroga->semestre}}</td>
                    <td>{{$solicitudes_prorroga->fecha_efectuar}}</td>
                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{ url('/solicitud/pdf_prorroga/'.$solicitudes_prorroga->id_alumno ) }}')">Imprimir</button></td>



                </tr>
            @endforeach



            </tbody>
        </table>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(document).ready(function() {


            $('#solicitudes').DataTable(  );





        });

    </script>
@endsection