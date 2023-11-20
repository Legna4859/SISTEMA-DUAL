@extends('layouts.app')
@section('title', 'Revisión de requisiciones')
@section('content')

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/revicion_requisiciones_anteproyecto")}}">Revisión de requisiciones de los departamentos </a>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/revicion_req_departamento/".$requisiciones[0]->id_req_mat_ante)}}">Requisiciones del departamento </a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Revisión requisicion</span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">REVISIÓN DE REQUISICIÓN<br>
                        (NOMBRE DEL JEFE(A) DEL DEPARTAMENTO O JEFATURA: <b>{{ $datos_jefe->titulo }} {{ $datos_jefe->nombre }})</b><br>
                        (NOMBRE DEL DEPARTAMENTO O JEFATURA: <b>{{ $datos_jefe->nom_departamento }}</b></h3>
                </div>
            </div>
        </div>
        <br>
    </div>


    <?php setlocale(LC_MONETARY, 'es_MX');
    ?>

     @if($requisiciones[0]->comentario !='')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-danger">
                <div class="panel-heading">
                  <h5 style="text-align: center"><b>COMENTARIO:</b> {{ $requisiciones[0]->comentario }}</h5>
                </div>
            </div>
        </div>
    </div>
    @endif
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-1">
                                {{--  <button type="button" class="btn btn-primary modificar_proyecto" id="{{$presupuesto['id_presupuesto'] }}" title="Modificar proyecto" > <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button>
--}}
                            </div>

                            <div class="col-md-9">
                                <h5 style="text-align: center">PRESUPUESTO DEL ANTEPROYECTO</h5>
                                <h5 style="text-align: center">NOMBRE DEL PROYECTO: <b>{{ $requisiciones[0]->nombre_proyecto }}</b></h5>
                            </div>

                        </div>
                    </div>

                    <div class="panel-body">
                        @if($presupuesto_cap == null)
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <div class="alert alert-danger">
                                        No tiene presupuesto este capitulo de la requisición.
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>

                                            <th style="background:grey;color: #0c0c0c;"></th>
                                            <th style="background: grey;color: #0c0c0c;" COLSPAN="4"> FUENTE DE FINANCIAMIENTO $</th>
                                            <th style="background: grey;color: #0c0c0c;"colspan="4">FUENTE DE FINANCIAMIENTO %</th>
                                        </tr>
                                        <tr>

                                            <th style="background:grey;color: #0c0c0c;">CAPITULO</th>
                                            <th style="text-align: center">ESTATAL</th>
                                            <th style="text-align: center">FEDERAL</th>
                                            <th style="text-align: center">PROPIOS</th>
                                            <th style="text-align: center">TOTAL</th>
                                            <th style="text-align: center">ESTATAL</th>
                                            <th style="text-align: center">FEDERAL</th>
                                            <th style="text-align: center">PROPIOS</th>
                                            <th style="text-align: center">TOTAL</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                            <tr>
                                                        @if($presupuesto_cap->id_capitulo == 1)
                                                        <td style="background: grey;color: #0c0c0c; text-align: center;">1000</td>
                                                        @endif
                                                        @if($presupuesto_cap->id_capitulo == 2)
                                                            <td style="background: grey;color: #0c0c0c; text-align: center;">2000</td>
                                                        @endif
                                                        @if($presupuesto_cap->id_capitulo == 3)
                                                            <td style="background: grey;color: #0c0c0c; text-align: center;">3000</td>
                                                        @endif
                                                        @if($presupuesto_cap->id_capitulo == 4)
                                                            <td style="background: grey;color: #0c0c0c; text-align: center;">4000</td>
                                                        @endif
                                                        @if($presupuesto_cap->id_capitulo == 5)
                                                            <td style="background: grey;color: #0c0c0c; text-align: center;">5000</td>
                                                        @endif
                                                        @if($presupuesto_cap->id_capitulo == 6)
                                                            <td style="background: grey;color: #0c0c0c; text-align: center;">6000</td>
                                                        @endif

                                                    <?php
                                                $presupuesto_estatal=$presupuesto_cap->presupuesto_estatal;
                                                $presupuesto_estatal= "$".number_format($presupuesto_estatal, 2, '.', ',');
                                                ?>
                                                <td style="text-align: right">{{ $presupuesto_estatal }}</td>
                                                <?php
                                                $presupuesto_federal= $presupuesto_cap->presupuesto_federal;
                                                $presupuesto_federal= "$".number_format($presupuesto_federal, 2, '.', ',');
                                                ?>
                                                <td style="text-align: right">{{ $presupuesto_federal }}</td>
                                                <?php
                                                $presupuesto_propios=$presupuesto_cap->presupuesto_propios;
                                                $presupuesto_propios= "$".number_format($presupuesto_propios, 2, '.', ',');
                                                ?>
                                                <td style="text-align: right">{{ $presupuesto_propios}}</td>
                                                <?php
                                                $total_presupuesto=$presupuesto_cap->total_presupuesto;
                                                $total_presupuesto= "$".number_format($total_presupuesto, 2, '.', ',');
                                                ?>
                                                <td style="text-align: right">{{ $total_presupuesto }}</td>
                                                            @if($presupuesto_cap->financiamiento_estatal == 0)
                                                            <td style="text-align: right">-</td>
                                                            @else
                                                           <td style="text-align: right">{{  round($presupuesto_cap->financiamiento_estatal,4) }}</td>
                                                           @endif
                                                            @if($presupuesto_cap->financiamiento_federal == 0)
                                                                <td style="text-align: right">-</td>
                                                            @else
                                                               <td style="text-align: right">{{  round($presupuesto_cap->financiamiento_federal,4) }}</td>
                                                            @endif
                                                            @if($presupuesto_cap->financiamiento_propios == 0)
                                                                <td style="text-align: right">-</td>
                                                            @else
                                                            <td style="text-align: right">{{ round($presupuesto_cap->financiamiento_propios,4) }}</td>
                                                            @endif
                                                            <td style="text-align: right">{{ $presupuesto_cap->total_financiamiento }}</td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right; color: #942a25"> Total de presupuesto sobrante</td>
                                                <?php
                                                $total_pre=$presupuesto_cap->total_presupuesto;
                                                $total_pre_hay1=$total_pre-$total_proyecto;
                                                $total_pre_hay= "$".number_format($total_pre_hay1, 2, '.', ',');
                                                $total_con_requi=$total_pre_hay1-$dat['total_finaciamiento_total'];

                                                ?>
                                                <td style="text-align: right">{{  $total_pre_hay}}</td>
                                            </tr>
                                           <tr>
                                               <td style="background: grey;color: #0c0c0c; text-align: center;"> {{ $dat['clave_partida'] }} {{ $dat['nombre_partida'] }}</td>

                                               <?php
                                               $f_e=$dat['financimiento_estatal'];
                                               $f_e= "$".number_format($f_e, 2, '.', ',');
                                               ?>
                                               <td style="text-align: right">{{ $f_e }}</td>
                                               <?php
                                               $f_federal= $dat['financiamiento_federal'];
                                               $f_federal= "$".number_format($f_federal, 2, '.', ',');
                                               ?>
                                               <td style="text-align: right">{{ $f_federal }}</td>
                                               <?php
                                               $f_propios=$dat['financiamiento_propios'];
                                               $f_propios= "$".number_format($f_propios, 2, '.', ',');
                                               ?>
                                               <td style="text-align: right">{{ $f_propios}}</td>
                                               <?php
                                               $t_presupuesto=$dat['total_finaciamiento_total'];
                                               $t_presupuesto= "$".number_format($t_presupuesto, 2, '.', ',');
                                               ?>
                                               <td style="text-align: right">{{ $t_presupuesto }}</td>
                                           </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right; color: #942a25"> Total de presupuesto con descuento de la requisición</td>
                                            <td style="text-align: right">
                                                @if($total_con_requi <= 0)
                                                    <b style="color: #942a25">{{   "$".number_format($total_con_requi, 2, '.', ',') }}</b>
                                                @else
                                                <b>{{   "$".number_format($total_con_requi,2, '.', ',') }}</b>
                                                @endif
                                            </td>
                                        </tr>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                        @if($total_con_requi <= 0)
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                <div class="alert alert-danger">
                                                     El presupuesto no alcanza para esta requisición.
                                                </div>
                                            </div>
                                        </div>
                                       @endif
                            @endif

                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-md-10">
            <br>
        </div>
    </div>
    @foreach($requisiciones2 as $requisicion)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-warning">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h4 style="text-align: center; color: #0c0c0c">PARTIDA PRESUPUESTAL: <b>{{ $requisicion['nombre_partida'] }}</b></h4>
                                <h4 style="text-align: center; color: #0c0c0c">MES Y AÑO DE ADQUISICIÓN: <b>{{ $requisicion['mes'] }}</b></h4>
                                <h4 style="text-align: center; color: #0c0c0c">PROYECTO: <b>{{ $requisicion['nombre_proyecto'] }}</b></h4>
                                <h5 style="text-align: center; color: #0c0c0c">META: <b>{{ $requisicion['meta'] }}</b></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="5" style="text-align: center">Documentación en pdf</th>
                                    </tr>
                                    <tr>
                                        <th>Requisición </th>
                                        <th>Anexo 1 (opcional)</th>
                                        <th>Oficio de suficiencia presupuestal (opcional)</th>
                                        <th>Justificación</th>
                                        <th>Cotización</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="text-align: center">
                                            @if($requisicion['requisicion_pdf'] == '')
                                                No se registro documento
                                                  @else

                                                <a  target="_blank" href="/finanzas/requisiciones/{{ $requisicion['requisicion_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                <button title="Modificar requisicion pdf" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-primary editar_requisicion_pdf" >
                                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                </button>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if($requisicion['anexo_1_pdf'] == '')
                                                No se registro documento
                                            @else
                                                <a  target="_blank" href="/finanzas/anexo1/{{ $requisicion['anexo_1_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                <button title="Modificar requisicion pdf" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-primary editar_anexo1_pdf" >
                                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                </button>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if($requisicion['oficio_suficiencia_presupuestal_pdf'] == '')
                                                No se registro documento
                                                @else
                                                <a  target="_blank" href="/finanzas/oficio_suficiencia/{{ $requisicion['oficio_suficiencia_presupuestal_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                <button title="Modificar oficio de suficiencia presupuestal pdf" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-primary editar_presupuestal_pdf" >
                                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                </button>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if($requisicion['id_estado_justificacion'] == 0)
                                                No se registro documento
                                                @else
                                                @if($requisicion['id_estado_justificacion'] == 1)
                                                    No
                                                @else
                                                    <a  target="_blank" href="/finanzas/justificacion/{{ $requisicion['justificacion_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                @endif
                                                <button title="Modificar justificacion pdf" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-primary editar_justificacion_pdf" >
                                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                </button>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if($requisicion['cotizacion_pdf'] == '')
                                                No se registro documento
                                            @else

                                                <a  target="_blank" href="/finanzas/cotizaciones/{{ $requisicion['cotizacion_pdf'] }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                <button title="Modificar cotización pdf" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-primary editar_cotizacion_pdf" >
                                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <h5 style="text-align: center">BIENES O SERVICIOS, ETC.</h5>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <p><br></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>N. P</th>
                                                        <th>Descripción</th>
                                                        <th>Unidad de medida</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio unitario de referencia con IVA incluido</th>
                                                        <th>Importe</th>
                                                        <th>Editar</th>
                                                        <th>Eliminar</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i=1; ?>
                                                    @foreach($requisicion['servicios'] as $servicio)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $servicio['descripcion'] }}</td>
                                                            <td>{{ $servicio['unidad_medida'] }}</td>
                                                            <td style="text-align: right;"><h3>{{ $servicio['cantidad'] }}</h3></td>
                                                            <?php
                                                            $precio_unitario=$servicio['precio_unitario'];
                                                            $precio_unitario= "$".number_format($precio_unitario, 2, '.', ',');
                                                            ?>
                                                            <td style="text-align: right;"><h3>{{ $precio_unitario}}</h3></td>
                                                            <?php
                                                            $importe=$servicio['importe'];
                                                            $importe= "$".number_format($importe, 2, '.', ',');
                                                            ?>
                                                            <td style="text-align: right;"><h3>{{ $importe }}</h3></td>
                                                            <td>
                                                                <button title="Modificar bien o servicio" id="{{ $servicio['id_reg_material_ant'] }}"  class="btn btn-primary editar_bien_servicio" >
                                                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button title="Eliminar bien o servicio" id="{{ $servicio['id_reg_material_ant'] }}"  class="btn btn-danger eliminar_bien_servicio" >
                                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                                </button>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="5" style="text-align: right;"> <h3>Total importe</h3></td>
                                                        <?php

                                                        $total_req= "$".number_format($total_req, 2, '.', ',');
                                                        ?>
                                                        <td  style="text-align: right;"> <h3>{{ $total_req }}</h3></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-4">
                                                <button title="Enviar modificaciones" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-primary enviar_modificaciones" >Enviar modificaciones
                                                </button>
                                            </div>
                                            <div class="col-md-2 ">
                                                <button title="Autorizar requisición" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-success autorizar_requisicion" >Autorizar requisición
                                                </button>
                                            </div>
                                            {{--
                                            <div class="col-md-2 ">
                                               <button title="Rechazar requisición" id="{{ $requisicion['id_actividades_req_ante'] }}"  class="btn btn-danger rechazar_requisicion" >Rechazar requisición
                                                </button>

                                            </div>
                                            --}}
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            @endforeach




            {{-- modal crear bien--}}

            <div class="modal fade" id="modal_crear_bien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Agregar nuevo bien o servicio, etc.</h4>
                        </div>
                        <div class="modal-body">

                            <form id="form_agregar_bien" class="form" action="{{url("/presupuesto_anteproyecto/guardar_bien/".$datos_req_envio->id_req_mat_ante)}}" role="form" method="POST" >
                                {{ csrf_field() }}
                                <input type="hidden" id="id_act_req_ante" name="id_act_req_ante" value="">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label>Ingresar el nombre del bien o servicio, etc.</label>
                                            <textarea class="form-control" id="bien_servicio" name="bien_servicio" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label>Ingresa unidad de medida</label>
                                            <input class="form-control" id="unidad_medida" name="unidad_medida" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" required></input>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label>Ingresa cantidad del bien o servicio, etc.</label>
                                            <input class="form-control" id="cantidad" name="cantidad" type="number" pattern="[0-9]+"  required></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label>Ingresa precio unitario de referencia con iva incluido</label>
                                            <input class="form-control" id="precio" name="precio" type="number" step=".01"  required></input>
                                        </div>
                                        <div id="pesos_precio">

                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_bien"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal modificar requisicion de materiales--}}

            <div class="modal fade" id="modal_modificacion_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Modificar requisicion de materiales</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_modificacion_requisicion">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_modificacion_requisicion"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal eliminae requisicion de materiales--}}

            <div class="modal fade" id="modal_eliminar_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Eliminar requisicion de materiales</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_eliminar_requisicion">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_eliminar_requisicion"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal agregar requisicion pdf--}}

            <div class="modal fade" id="modal_agregar_requisicion_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Requisicion pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_agregar_requisicion_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_requisicion_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal modificar requisicion pdf--}}

            <div class="modal fade" id="modal_modificar_requisicion_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Modificar requisicion pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_modificar_requisicion_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_mod_requisicion_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal mod requisicion pdf--}}

            <div class="modal fade" id="modal_mod_anexo1_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Modificar anexo 1 pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_mod_anexo1_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_mod_anexo1_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal agregar requisicion pdf--}}

            <div class="modal fade" id="modal_agregar_anexo1_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Anexo 1 pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_agregar_anexo1_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_anexo1_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal agregar suficiencia  pdf--}}

            <div class="modal fade" id="modal_agregar_suficiencia_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">oficio de suficiencia presupuestal pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_agregar_suficiencia_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_suficiencia_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal modificar suficiencia  pdf--}}

            <div class="modal fade" id="modal_mod_suficiencia_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Modificar oficio de suficiencia presupuestal pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_mod_suficiencia_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_mod_suficiencia_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal agregar justificacion  pdf--}}

            <div class="modal fade" id="modal_agregar_justificacion_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Justificación pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_agregar_justificacion_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_justificacion_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal mod justificacion  pdf--}}

            <div class="modal fade" id="modal_mod_justificacion_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Justificación pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_mod_justificacion_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_mod_justificacion_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modificar servicio --}}

            <div class="modal fade" id="modal_mod_servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Modificar bien o servicio</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_mod_servicio">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_mod_servicio"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- eliminar servicio --}}

            <div class="modal fade" id="modal_eliminar_servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Eliminar bien o servicio</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_eliminar_servicio">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_eliminar_servicio"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- enviar modificaciones --}}

            <div class="modal fade" id="modal_enviar_modificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Enviar modificaciones</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_guardar_modificaciones" class="form" action="{{url("/presupuesto_anteproyecto/guardar_modificaciones/")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                                <input type="hidden" id="id_act_requisicion_ante" name="id_act_requisicion_ante" value="">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label>Ingresar comentario de las modificaciones</label>
                                            <textarea class="form-control" id="comentario" name="comentario" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_enviar_modificacion"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Autorizar --}}

            <div class="modal fade" id="modal_autorizar_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Enviar autorización</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_guardar_autorizar_requisicion" class="form" action="{{url("/presupuesto_anteproyecto/guardar_autorizacion_requisicion/")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                                <input type="hidden" id="id_act_requisicion_antep" name="id_act_requisicion_antep" value="">
                              <div class="row">
                                  <div class="col-md-10 col-md-offset-1">
                                      <h2> ¿Seguro(a)  que quiere autorizar la requisición?</h2>
                                  </div>
                              </div>
                            </form>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_enviar_autorizacion"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Rechazar --}}

            <div class="modal fade" id="modal_rechazar_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Rechazar requisición</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_guardar_rechazar_requisicion" class="form" action="{{url("/presupuesto_anteproyecto/guardar_rechazo_requisicion/")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                                <input type="hidden" id="id_act_requisicion_antepr" name="id_act_requisicion_antepr" value="">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <h2> ¿Seguro(a)  que quiere rechazar la requisición?</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label>Ingresar comentario de porque se rechazó</label>
                                            <textarea class="form-control" id="comentarios" name="comentarios" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_rechazar_requisicion"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal modificar cotizacion  pdf--}}



            <div class="modal fade" id="modal_mod_cotizacion_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Modificar cotización pdf</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_mod_cotizacion_pdf">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_mod_cotizacion_pdf"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {

                    $("#guardar_rechazar_requisicion").click(function (){

                        var comentario = $("#comentarios").val();
                        if(comentario != '') {
                            $("#form_guardar_rechazar_requisicion").submit();
                            $("#guardar_rechazar_requisicion").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Rechazo exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresar comentario de porque se rechazó",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $("#guardar_mod_cotizacion_pdf").click(function (){
                        var requisicion_pdf = $("#mod_cotizacion_pdf").val();

                        if( requisicion_pdf != ''){
                            $("#form_guardar_mod_cotizacion_pdf").submit();
                            $("#guardar_mod_cotizacion_pdf").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_cotizacion_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/modificar_cotizacion_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_mod_cotizacion_pdf").html(request);
                            $("#modal_mod_cotizacion_pdf").modal('show');
                        });
                    });
                    $(".rechazar_requisicion").click(function (){
                        var id_reg_material_ant =$(this).attr('id');
                        $('#id_act_requisicion_antepr').val(id_reg_material_ant);
                        $('#modal_rechazar_requisicion').modal('show');
                    });
                    $(".autorizar_requisicion").click(function (){
                        var id_reg_material_ant =$(this).attr('id');
                        $('#id_act_requisicion_antep').val(id_reg_material_ant);
                        $('#modal_autorizar_requisicion').modal('show');
                    });
                    $(".enviar_modificaciones").click(function (){
                        var id_reg_material_ant =$(this).attr('id');
                        $('#id_act_requisicion_ante').val(id_reg_material_ant);
                        $('#modal_enviar_modificacion').modal('show');

                    });
                    $("#guardar_enviar_modificacion").click(function (){
                        var comentario = $("#comentario").val();
                        if(comentario != ''){
                            $("#form_guardar_modificaciones").submit();
                            $("#guardar_enviar_modificacion").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{

                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresa comentario de las modificaciones",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $("#guardar_enviar_autorizacion").click(function (){
                        $("#form_guardar_autorizar_requisicion").submit();
                        $("#guardar_enviar_autorizacion").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Autorización exitosa",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    });
                    $("#precio").change(function (event){
                        var precio= event.target.value;
                        if(isNaN(precio)){
                            alert( "el precio debe ser un numero");
                            $('#pesos_precio').empty();

                        }else {
                            var p_precio= new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: "MXN"
                            }).format(precio);
                            $('#pesos_precio').empty();
                            $('#pesos_precio').append('<h2>' + p_precio+ '</option>');
                        }
                    });
                    $(".eliminar_bien_servicio").click(function (){
                        var id_reg_material_ant =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/eliminar_servicio/"+id_reg_material_ant,function (request) {
                            $("#contenedor_eliminar_servicio").html(request);
                            $("#modal_eliminar_servicio").modal('show');
                        });
                    });
                    $("#guardar_eliminar_servicio").click(function (){
                        $("#form_mod_bien").submit();
                        $("#guardar_eliminar_servicio").attr("disabled", true);
                    });
                    $(".agregar_bien").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $('#id_act_req_ante').val(id_actividades_req_ante);
                        $('#modal_crear_bien').modal('show');
                    });
                    $(".editar_bien_servicio").click(function (){
                        var id_reg_material_ant =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/modificar_servicio/"+id_reg_material_ant,function (request) {
                            $("#contenedor_mod_servicio").html(request);
                            $("#modal_mod_servicio").modal('show');
                        });

                    });
                    $("#guardar_mod_servicio").click(function (){
                        var bien_servicio = $("#bien_servicio_mod").val();
                        if(bien_servicio != ''){
                            var unidad_medida = $("#unidad_medida_mod").val();
                            if( unidad_medida != ''){

                                var cantidad = $("#cantidad_mod").val();

                                if ( cantidad != ''){

                                    var precio = $("#precio_mod").val();
                                    if ( precio != ''){

                                        $("#form_mod_bien").submit();
                                        $("#guardar_mod_servicio").attr("disabled", true);
                                        swal({
                                            position: "top",
                                            type: "success",
                                            title: "Registro exitoso",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }else{
                                        swal({
                                            position: "top",
                                            type: "error",
                                            title: "Ingresa precio unitario de referencia con iva incluido",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }

                                }else{
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Ingresa cantidad correcta",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            }else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Ingresa unidad de medida",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresar el nombre del bien o servicio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $("#guardar_bien").click(function (){
                        var bien_servicio = $("#bien_servicio").val();
                        if(bien_servicio != ''){
                            var unidad_medida = $("#unidad_medida").val();
                            if( unidad_medida != ''){

                                var cantidad = $("#cantidad").val();

                                if ( cantidad != ''){

                                    var precio = $("#precio").val();
                                    if ( precio != ''){

                                        $("#form_agregar_bien").submit();
                                        $("#guardar_bien").attr("disabled", true);
                                        swal({
                                            position: "top",
                                            type: "success",
                                            title: "Registro exitoso",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }else{
                                        swal({
                                            position: "top",
                                            type: "error",
                                            title: "Ingresa precio unitario de referencia con iva incluido",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }

                                }else{
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Ingresa cantidad correcta",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            }else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Ingresa unidad de medida",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresar el nombre del bien o servicio",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $("#proyecto").change(function (e) {

                        var id_proyecto = e.target.value;
                        $.get('/presupuesto_anteproyecto/ver_meta/' + id_proyecto, function (data) {

                            $('#meta').empty();
                            $.each(data, function (datos_alumno, subcatObj) {
                                //   alert(subcatObj);
                                $('#meta').append('<div class="radio"><label><input class="form-check-input"  type="radio" name="meta1" value="'+subcatObj.id_meta+'" required>'+subcatObj.meta+'</label></div>');

                            });
                        });
                    });
                    $("#guardar_partida_presupuestal").click(function (){
                        var partida_presupuestal = $("#partida_presupuestal").val();
                        if(partida_presupuestal != ''){
                            var mes = $("#mes").val();
                            if( mes != null){
                                var proyecto = $("#proyecto").val();
                                if( proyecto != null){
                                    var meta1 =$('input:radio[name=meta1]:checked').val();

                                    if(meta1 != undefined){
                                        $("#form_agregar").submit();
                                        $("#guardar_partida_presupuestal").attr("disabled", true);
                                        swal({
                                            position: "top",
                                            type: "success",
                                            title: "Registro exitoso",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }else{
                                        swal({
                                            position: "top",
                                            type: "error",
                                            title: "Selecciona meta",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }
                                }else{
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Selecciona proyecto",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }
                            }
                            else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Selecciona mes",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Agregar partida presupuestal",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_requisiciones").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');

                        $.get("/presupuesto_anteproyecto/modificar_requisicion_material/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_modificacion_requisicion").html(request);
                            $("#modal_modificacion_requisicion").modal('show');
                        });
                    });

                    $(".eliminar_requisiciones").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        alert(id_actividades_req_ante);
                        $.get("/presupuesto_anteproyecto/eliminar_requisicion_material/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_eliminar_requisicion").html(request);
                            $("#modal_eliminar_requisicion").modal('show');
                        });

                    });
                    $("#guardar_modificacion_requisicion").click(function (){
                        var partida_presupuestal = $("#partida_presupuestal_mod").val();
                        if(partida_presupuestal != ''){
                            var mes = $("#mes_mod").val();
                            if( mes != null){
                                var proyecto = $("#proyecto_mod").val();
                                if( proyecto != null){
                                    var meta1 =$('input:radio[name=meta_mod]:checked').val();

                                    if(meta1 != undefined){
                                        $("#form_modificar_requisicion").submit();
                                        $("#guardar_modificacion_requisicion").attr("disabled", true);
                                        swal({
                                            position: "top",
                                            type: "success",
                                            title: "Registro exitoso",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }else{
                                        swal({
                                            position: "top",
                                            type: "error",
                                            title: "Selecciona meta",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }
                                }else{
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Selecciona proyecto",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }
                            }
                            else{
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Selecciona mes",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Agregar partida presupuestal",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $("#guardar_eliminar_requisicion").click(function (){

                        $("#form_eliminar_requisicion").submit();
                        $("#guardar_eliminar_requisicion").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Eliminacion exitosa",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    });
                    $(".agregar_requisicion").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/agregar_requisicion_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_agregar_requisicion_pdf").html(request);
                            $("#modal_agregar_requisicion_pdf").modal('show');
                        });

                    });
                    $("#guardar_requisicion_pdf").click(function (){
                        var requisicion_pdf = $("#requisicion_pdf").val();
                        if( requisicion_pdf != ''){
                            $("#form_guardar_req_pdf").submit();
                            $("#guardar_requisicion_pdf").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    });
                    $(".agregar_anexo1").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/agregar_anexo1_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_agregar_anexo1_pdf").html(request);
                            $("#modal_agregar_anexo1_pdf").modal('show');
                        });
                    });
                    $("#guardar_anexo1_pdf").click(function (){
                        var anexo1_pdf = $("#anexo1_pdf").val();
                        if( anexo1_pdf != ''){
                            $("#form_guardar_anexo1_pdf").submit();
                            $("#guardar_anexo1_pdf").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    });
                    $(".agregar_suficiencia").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/agregar_suficiencia_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_agregar_suficiencia_pdf").html(request);
                            $("#modal_agregar_suficiencia_pdf").modal('show');
                        });
                    });
                    $("#guardar_suficiencia_pdf").click(function (){
                        var suficiencia_pdf = $("#suficiencia_pdf").val();
                        if( suficiencia_pdf != ''){
                            $("#form_guardar_deficiencia_pdf").submit();
                            $("#guardar_suficiencia_pdf").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    });
                    $(".agregar_justificacion").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/agregar_justificacion_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_agregar_justificacion_pdf").html(request);
                            $("#modal_agregar_justificacion_pdf").modal('show');
                        });
                    });
                    $("#guardar_justificacion_pdf").click(function (){
                        var justificacion_pdf = $("#justificacion_pdf").val();

                        if(justificacion_pdf != null){
                            if(justificacion_pdf == 1){
                                $("#form_guardar_justificacion_pdf").submit();
                                $("#guardar_justificacion_pdf").attr("disabled", true);
                                swal({
                                    position: "top",
                                    type: "success",
                                    title: "Registro exitoso",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                            if(justificacion_pdf == 2){
                                var doc_justificacion_pdf = $("#doc_justificacion_pdf").val();
                                if(doc_justificacion_pdf == ''){
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Selecciona documento pdf",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }else{
                                    $("#form_guardar_justificacion_pdf").submit();
                                    $("#guardar_justificacion_pdf").attr("disabled", true);
                                    swal({
                                        position: "top",
                                        type: "success",
                                        title: "Registro exitoso",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona una opcion",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_requisicion_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/modificar_req_mat_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_modificar_requisicion_pdf").html(request);
                            $("#modal_modificar_requisicion_pdf").modal('show');
                        });
                    });
                    $("#guardar_mod_requisicion_pdf").click(function (){
                        var requisicion_pdf = $("#requisicion_pdf_mod").val();

                        if( requisicion_pdf != ''){
                            $("#form_guardar_mod_req_pdf").submit();
                            $("#guardar_mod_requisicion_pdf").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_anexo1_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/mod_anexo1_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_mod_anexo1_pdf").html(request);
                            $("#modal_mod_anexo1_pdf").modal('show');
                        });
                    });
                    $("#guardar_mod_anexo1_pdf").click(function (){
                        var anexo1_pdf = $("#mod_anexo1_pdf").val();
                        if( anexo1_pdf != ''){
                            $("#form_guardar_mod_anexo1_pdf").submit();
                            $("#guardar_mod_anexo1_pdf").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_presupuestal_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/mod_suficiencia_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_mod_suficiencia_pdf").html(request);
                            $("#modal_mod_suficiencia_pdf").modal('show');
                        });
                    });
                    $("#guardar_mod_suficiencia_pdf").click(function (){
                        var suficiencia_pdf = $("#mod_suficiencia_pdf").val();
                        if( suficiencia_pdf != ''){
                            $("#form_guardar_mod_deficiencia_pdf").submit();
                            $("#guardar_mod_suficiencia_pdf").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });
                    $(".editar_justificacion_pdf").click(function (){
                        var id_actividades_req_ante =$(this).attr('id');
                        $.get("/presupuesto_anteproyecto/mod_justificacion_pdf/"+id_actividades_req_ante,function (request) {
                            $("#contenedor_mod_justificacion_pdf").html(request);
                            $("#modal_mod_justificacion_pdf").modal('show');
                        });
                    });
                    $("#guardar_mod_justificacion_pdf").click(function (){
                        var justificacion_pdf = $("#mod_justificacion_pdf").val();
                        if(justificacion_pdf != null){
                            if(justificacion_pdf == 1){
                                $("#form_guardar_mod_justificacion_pdf").submit();
                                $("#guardar_mod_justificacion_pdf").attr("disabled", true);
                                swal({
                                    position: "top",
                                    type: "success",
                                    title: "Registro exitoso",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            }
                            if(justificacion_pdf == 2){
                                var doc_justificacion_pdf = $("#mod_doc_justificacion_pdf").val();
                                if(doc_justificacion_pdf == ''){
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Selecciona documento pdf",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }else{
                                    $("#form_guardar_mod_justificacion_pdf").submit();
                                    $("#guardar_mod_justificacion_pdf").attr("disabled", true);
                                    swal({
                                        position: "top",
                                        type: "success",
                                        title: "Registro exitoso",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                }

                            }

                        }else{
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona una opcion",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    });

                });
            </script>
@endsection