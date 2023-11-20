@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">HISTORIAL ACADÉMICO <br>{{$nombre_carrera}}</h3>
                    <h5 class="panel-title text-center">(ESTUDIANTES)</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">

                <div class="panel-body">

                    <table class="table table-bordered " Style="background: white;" id="tablas_alumnos">
                        <thead>
                        <tr class="info">
                            <th style="text-align: center">No. CUENTA</th>
                            <th style="text-align: center">NOMBRE DE ALUMNO(A)</th>
                            <th style="text-align: center">HISTORIAL ACADÉMICO</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($alumnos as $alumno)
                            <tr>
                                <th style="text-align: center">{{$alumno->cuenta}}</th>
                                <td style="text-align: center">{{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</td>
                                <td style="text-align: center">
                                    <a href="#" class="id_alumno" id="{{ $alumno->id_alumno }}">
                                        <span class="glyphicon glyphicon-book em5" aria-hidden="true" style="color: #1e7e34"> Mostrar</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach



                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div id="modal_historial" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-content" role="document">
            <div class="modal-content">
                <form action="" method="POST"  role="form" id="form_termino_calificar_actuales">
                    {{ csrf_field() }}
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-md-12 ">
                                <input  type="hidden" class="form-control" id="id_alumno_r" name="id_alumno_r" />

                                <label for="exampleInputEmail1">¿ LAS CALIFICACIONES DEL PERIODO ACTUAL YA ESTAN REGISTRADAS EN EL SISTEMA ? <b style="color:red; font-size:23px;">*</b></label>

                                <select class="form-control" placeholder="selecciona una Opcion" id="calificada" name="calificada" required>
                                    <option disabled selected>Selecciona una opción</option>
                                        <option value="1">SI</option>
                                        <option value="2">NO</option>
                                </select>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_historial" type="button" class="btn btn-danger" value="Aceptar"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablas_alumnos').DataTable();
        });
        $("#tablas_alumnos").on('click','.id_alumno',function(){
            var id=$(this).attr('id');
            $('#id_alumno_r').val(id);

                $("#modal_historial").modal('show');

        });
        $("#confirma_historial").click(function(event) {
            var id_alumno = $("#id_alumno_r").val();
            var calificada = $("#calificada").val();



            if (calificada != null) {
                var link="/servicios_escolares/historial_academico/alumno/"+id_alumno+"/"+calificada+"/";

                window.open(link);


            }
            else{
                swal({
                    position:"top",
                    type: "error",
                    title: "Debes seleccionar una respuesta ",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });

</script>
@endsection