@extends('layouts.app')
@section('title', 'Inicio')
@section('content')



    <main>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Solicitud de desempeño escolar</h3>
                    </div>
                </div>
            </div>

            <div class="row col-md-11 col-md-offset-1">



                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#uno" aria-controls="home" role="tab" data-toggle="tab">Autorizar </a></li>
                      <li role="presentation"><a href="#cuatro" aria-controls="dos" role="tab" data-toggle="tab">Rechazados </a></li>
                    <li role="presentation"><a href="#cinco" aria-controls="dos" role="tab" data-toggle="tab">Autorizados </a></li>


                </ul>

                <!-- Tab panes -->
                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active" id="uno">

                        <div class=" col-md-10 col-md-offset-1">

                            </br></br></br>
                            <?php
                            $unidad = Session::get('id_unidad_admin');
                            ;

                            ?>
                            <table class="table table-bordered " Style="background: white;" id="autorizar_escolares">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CURP</th>
                                    <th>CARRERA</th>
                                    <th>DESCUENTO</th>
                                    <th>PROMEDIO</th>
                                    <th>SEMESTRE</th>
                                    @if($unidad == 5)
                                    <th>AUTORIZAR</th>
                                    <th>RECHAZAR</th>
                                        @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($autorizar_profesionales as $autorizar_profesionales)
                                    <tr>
                                        <th>{{$autorizar_profesionales->cuenta}}</th>
                                        <td>{{$autorizar_profesionales->nombre}} {{$autorizar_profesionales->apaterno}} {{$autorizar_profesionales->amaterno}}</td>
                                        <td>{{$autorizar_profesionales->curp_al}}</td>
                                        <td>{{$autorizar_profesionales->carrera}}</td>
                                        <td>{{$autorizar_profesionales->descuento}}</td>
                                        <td>{{$autorizar_profesionales->promedio}}</td>
                                        <td>{{$autorizar_profesionales->semestre}}</td>
                                        @if($unidad == 5)
                                        <td >

                                            <a  onclick="window.location=('{{ url('/beca_estimulo/escolares/verificar_beca_profesionales/'.$autorizar_profesionales->id_autorizar.'/1' ) }}')" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-ok-sign "  aria-hidden="true"></span>Autorizar</a>

                                        </td>
                                        <td >

                                            <a onclick="window.location=('{{ url('/beca_estimulo/escolares/verificar_beca_profesionales/'.$autorizar_profesionales->id_autorizar.'/2' ) }}')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove-sig"  aria-hidden="true"></span>Rechazar</a>

                                        </td>
                                            @endif
                                    </tr>
                                @endforeach



                                </tbody>
                            </table>









                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="cuatro">
                        <div class=" col-md-10 col-md-offset-1">

                            </br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="rechazados_profesionales">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CURP</th>
                                    <th>CARRERA</th>
                                    <th>DESCUENTO</th>
                                    <th>PROMEDIO</th>
                                    <th>SEMESTRE</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($rechazados_profesionales as $rechazados_profesionales)
                                    <tr>
                                        <th>{{$rechazados_profesionales->cuenta}}</th>
                                        <td>{{$rechazados_profesionales->nombre}} {{$rechazados_profesionales->apaterno}} {{$rechazados_profesionales->amaterno}}</td>
                                        <td>{{$rechazados_profesionales->curp_al}}</td>
                                        <td>{{$rechazados_profesionales->carrera}}</td>
                                        <td>{{$rechazados_profesionales->descuento}}</td>
                                        <td>{{$rechazados_profesionales->promedio}}</td>
                                        <td>{{$rechazados_profesionales->semestre}}</td>


                                    </tr>
                                @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="cinco">
                        <div class=" col-md-10 col-md-offset-1">
                            </br></br>
                            <p>   <a href="/solicitud/exportar_beca_cincuenta" class="btn btn-success tooltip-options link" data-toggle="tooltip" data-placement="top" title="Exportar a excel"><span class="oi oi-pencil"></span>Exportar a excel del 50 % de descuento</a>
                                <a href="/solicitud/exportar_beca_cien" class="btn btn-success tooltip-options link" data-toggle="tooltip" data-placement="top" title="Exportar a excel"><span class="oi oi-pencil"></span>Exportar a excel del 100% de descuento</a>

                            </p>

                            </br></br>

                            <table class="table table-bordered " Style="background: white;" id="autorizados_profesionales">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CURP</th>
                                    <th>CARRERA</th>
                                    <th>DESCUENTO</th>
                                    <th>PROMEDIO</th>
                                    <th>SEMESTRE</th>
                                    <th>IMPRIMIR </th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($autorizados_profesionales as $autorizados_profesionales)
                                    <tr>
                                        <th>{{$autorizados_profesionales->cuenta}}</th>
                                        <td>{{$autorizados_profesionales->nombre}} {{$autorizados_profesionales->apaterno}} {{$autorizados_profesionales->amaterno}}</td>
                                        <td>{{$autorizados_profesionales->curp_al}}</td>
                                        <td>{{$autorizados_profesionales->carrera}}</td>
                                        <td>{{$autorizados_profesionales->descuento}}</td>
                                        <td>{{$autorizados_profesionales->promedio}}</td>
                                        <td>{{$autorizados_profesionales->semestre}}</td>
                                        <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{ url('/beca_estimulo/academico_solicitud/'.$autorizados_profesionales->id_autorizar ) }}')">Imprimir</button></td>



                                    </tr>
                                @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </main>
    <script type="text/javascript">
        $(document).ready(function() {


            $('#autorizar_escolares').DataTable(  );

            $('#rechazados_escolares').DataTable(  );
            $('#autorizar_profesionales').DataTable(  );
            $('#rechazados_profesionales').DataTable(  );
            $('#autorizados_profesionales').DataTable(  );



        });

    </script>
@endsection