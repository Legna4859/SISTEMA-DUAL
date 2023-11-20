
@extends('layouts.app')
@section('title', 'Inicio')
@section('content')

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">VALIDACIÓN DE CARGAS ACADEMICAS</h3>
                    </div>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-bordered " Style="background: white;" id="version_actual">
                        <thead>
                        <tr>
                            <th>No. CUENTA</th>
                            <th>NOMBRE DE ALUMNO(A)</th>
                            <th>CARRERA</th>
                            <th>CARGA ACADEMICA</th>
                            <th>CALIFICAR ESTUDIANTE</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($alumnos as$consulta3)
                            <tr>
                                <th>{{$consulta3->cuenta}}</th>
                                <td>{{$consulta3->nombre}} {{$consulta3->apaterno}} {{$consulta3->amaterno}}</td>

                                <td>{{$consulta3->carreras}}</td>
                                <td>
                                    <a onclick="window.open('{{ url('/revicion_control_escolar/'.$consulta3->id ) }}')"><span class="glyphicon glyphicon-list-alt em5" aria-hidden="true"></span></a>
                                </td>


                                <td style="text-align: center">
                                    <a href="#" onclick="window.open('{{ url('/computo/calificacion_al/'.$consulta3->id ) }}')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>Calificar</a>
                                </td>

                            </tr>
                        @endforeach



                        </tbody>
                    </table>
                </div>
            </div>




    <script type="text/javascript">


        $(document).ready(function(){
            $('#no_aceptados').DataTable();
            $('#aceptados').DataTable();
            $('#version_actual').DataTable();
            $('#version_antigua').DataTable();
            $("#aceptados").on('click','.activar_periodo_carga',function(){
                var idof=$(this).attr('id');
                $('#id_carga').val(idof);
                $('#modal_agregar').modal('show');

            });
            $("#aceptados").on('click','.baja',function(){
                var idof=$(this).attr('id');
                $('#id_carga_a').val(idof);
                $('#modal_baja').modal('show');

            });
            $("#version_actual").on('click','.baja',function(){
                var idof=$(this).attr('id');
                $('#id_carga_a').val(idof);
                $('#modal_baja').modal('show');

            });
            $("#version_antigua").on('click','.baja',function(){
                var idof=$(this).attr('id');
                $('#id_carga_a').val(idof);
                $('#modal_baja').modal('show');

            });
            $("#guardar_baja").click(function(event){
                $("#form_baja").submit();
            });
            $("#form_baja").validate({
                rules: {

                    estado: "required",
                    obser: "required",
                },
            });
            $("#guardar_agregado").click(function(event){
                $("#form_agregar").submit();
            });
            $("#form_agregar").validate({
                rules: {

                    estado: "required",
                },
            });
            $("#version_actual").on('click','.activar_periodo_carga',function(){
                var idof=$(this).attr('id');
                $('#id_carga').val(idof);
                $('#modal_agregar').modal('show');

            });
            $("#version_antigua").on('click','.activar_periodo_carga',function(){
                var idof=$(this).attr('id');
                $('#id_carga').val(idof);
                $('#modal_agregar').modal('show');

            });

            $(".desactivar_periodo_carga").click(function(event){
                var idof=$(this).attr('id');
                swal({
                    title: "¿Desactivar periodo de remplazar carga academica?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_modificar").attr("action","/desactivar/periodo_modificacion_carga/"+idof)
                            $("#form_modificar").submit();
                        }
                    });
            });



        });

    </script>


@endsection
