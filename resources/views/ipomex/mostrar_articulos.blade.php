@extends('layouts.app')
@section('title', 'Ipomex')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Tabla general de Ipomex</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-10 col-md-offset-1">
                <table id="paginar_table" class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>ARTÍCULO LEY GENERAL</th>
                        <th>FRACCIÓN</th>
                        <th>CONSULTAR FRACCIÓN ART. GENERAL</th>
                        <th>ARTÍCULO LEY ESTATAL</th>
                        <th>FRACCIÓN</th>
                        <th>CONSULTAR FRACCIÓN ART. LEY  ESTATAL</th>
                        <th>DENOMINACIÓN DE LA FRACCIÓN</th>
                        <th>PERIODO DE ACTUALIZACIÓN, PRE APROBACIÓN Y VALIDACIÓN</th>
                        <th>OBSERVACIONES ACERCA DE LA INFORMACIÓN A PUBLICAR</th>
                        <th>PERIODO DE CONSERVACIÓN</th>


                    </tr>
                    </thead>

                    <tbody>
                    @foreach($articulos as $articulo)
                        <tr>
                            <?php   $denominacion_fraccion=$articulo->denominacion_fraccion; ?>
                            <?php   $periodo_ley_general=$articulo->periodo_ley_general; ?>
                            <?php   $observacion_inf_general=$articulo->observacion_inf_general; ?>
                            <?php   $periodo_actualizacion_general=$articulo->periodo_actualizacion_general; ?>

                            <td>{{ $articulo->articulo_general }} </td>
                            <td>{{ $articulo->fraccion_general }} </td>
                                <td>
                            @if($articulo->tiene_fra_general==0)
                                <a target="_blank" href="{{asset($articulo->pdf_general)}}">Ver PDF</a>
                            @else
                                No tiene PDF
                            @endif
                                    <br>
                                @if($articulo->pdf_general_2 != "")
                                    <a target="_blank" href="{{asset($articulo->pdf_general_2)}}">Ver PDF 2</a>
                                @else

                                @endif
                                </td>
                            <td>{{ $articulo->articulo_estatal }} </td>
                            <td>{{ $articulo->fraccion_estatal }} </td>
                                <td>
                            @if($articulo->tiene_fra_estatal==1)
                                <a target="_blank" href="{{asset($articulo->pdf_general)}}"> Ver PDF</a>
                            @else
                                No tiene PDF
                            @endif

                                </td>
                            <td>{{ $denominacion_fraccion }} </td>
                            <td> <textarea id="myTextarea" style="">{{ $periodo_ley_general }} </textarea></td>
                            <td>{{  $observacion_inf_general }} </td>
                            <td><textarea id="myTextarea" style="">{{$periodo_actualizacion_general}} </textarea></td>




                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection