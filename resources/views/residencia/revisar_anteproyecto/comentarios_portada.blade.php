<div class="row">
    <br>
    <div class="col-md-10 col-md-offset-1">
        @if( $comentario_portada == 0)
            <div class="alert alert-danger" role="alert">
                No hay ningún comentario
            </div>

        @else
        @foreach($comentarios_profesores as $comentario_prof )
                @if($comentario_prof->id_estado_evaluacion==1)
            <div class="panel  panel-success">
                <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentario_prof->nombre}}<br>
                        <b>STATUS DEL ANTEPROYECTO: </b>AUTORIZADO
                </div>
                <div class="panel-body">
                    {{$comentario_prof->comentario}}

                </div>
            </div>
                @elseif($comentario_prof->id_estado_evaluacion==2)
                    <div class="panel  panel-warning">
                        <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentario_prof->nombre}}<br>

                                <b>STATUS DEL ANTEPROYECTO: </b>AUTORIZADO CON CAMBIOS

                        </div>
                        <div class="panel-body">
                            {{$comentario_prof->comentario}}

                        </div>
                    </div>
                @elseif($comentario_prof->id_estado_evaluacion==3)
                    <div class="panel  panel-danger">
                        <div class="panel-heading" style="text-align: center"> <b>NOMBRE DEL DOCENTE:</b> {{$comentario_prof->nombre}}<br>

                            <b>STATUS DEL ANTEPROYECTO: </b>RECHAZADO

                        </div>
                        <div class="panel-body">
                            {{$comentario_prof->comentario}}

                        </div>
                    </div>
                @endif
        @endforeach
            @endif
    </div>
</div>
</div>