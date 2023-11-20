<div class="row">
    <p></p>
</div>
<div class="row">

        <div class="col-md-8 col-md-offset-2" style="text-align: center">
            <div class="panel panel-default">
                <div class="panel-body">
        <p style="text-align: center">{{$nombre_alum}}</p>
                </div>
            </div>
        </div>
</div>
            @if($adeudo == 0)
                <div class="row">
                <div class="col-md-8 col-md-offset-2 ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No tiene adeudo</h3>
                        </div>
                    </div>
                </div>
                </div>
        <?php
        $id_unidad_admin = Session::get('id_unidad_admin');
        $escolar = session()->has('escolar') ? session()->has('escolar') : false;
        ?>
        @if($id_unidad_admin == 16 || $escolar == true )
                <div class="row">
                    <div class="col-md-8 col-md-offset-2" style="text-align: center">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/constancia_certificado_credencial_no_adeudo/'.$id_alumno.'/1')}}')">CERTIFICADO</a></div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2" style="text-align: center">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/constancia_certificado_credencial_no_adeudo/'.$id_alumno.'/2')}}')">CREDENCIAL</a></div>

                        </div>
                    </div>
                </div>
            @else
            @if($adeudo_encuesta == 0)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2" style="text-align: center">
                        <div class="panel panel-primary">
                            <div class="panel-body"><a href="#"
                                                       onclick="window.open('{{url('/constancia_titulacion_noadeudo/'.$id_alumno)}}')">TITULACION</a></div>

                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Tiene adeudo con el departamento de bolsa de trabajo y seguimiento de egresados: debe la firma de encuesta</h3><br>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
            @else
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tiene adeudo con los siguientes departamentos o carreras:</h3><br>
                            @foreach($departamento_carrera as $departamento_carrera)
                                <p style="text-align: center">{{$departamento_carrera['nombre']}}:- {{$departamento_carrera['comentario']}}</p>
                            @endforeach
                            @if($adeudo_encuesta == 0)
                            @else
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <h3 class="panel-title text-center">Tiene adeudo con el departamento de bolsa de trabajo y seguimiento de egresados: debe la firma de encuesta</h3><br>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                </div>
            @endif
    <div class="row">
        <div class="col-md-1 col-md-offset-9">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
                <div class="row">
                    <p></p>
                </div>