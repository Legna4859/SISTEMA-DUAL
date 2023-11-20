<div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <b>Solicitante: </b>
                <p>{{$oficios->nombre}}</p>
                <b>Articulo: </b><p>{{$oficios->nombre_articulo}}</p>
                
                <b>Descripción de artículo: </b><p align="justify">{{$oficios->descripcion_art}}</p>
                
                <b>Motivo de oficio: </b><p>{{$oficios->motivo_oficio}}</p>
                <b>Fecha requerida: </b><p>{{$oficios->fecha_req}}</p>
                @if($oficios->id_articulo==5)
                    <b>Hora entrada:</b><p>{{$oficios->hora_e}}</p>
                    <b>Hora llegada tarde:</b><p>{{$oficios->hora_st}}</p>
                @endif
                @if($oficios->id_articulo==8)
                    <b>Inician:</b><p>{{$oficios->fecha_invac}}</p>
                    <b>Finalizan:</b><p>{{$oficios->fecha_tervac}}</p>
                @endif
                @if($oficios->id_articulo==9)
                    <b>Hora entrada:</b><p>{{$oficios->hora_e2}}</p>
                    <b>Hora salida:</b><p>{{$oficios->hora_s2}}</p>
                @endif
                @if($oficios->id_articulo==9)
                    <b>Hora entrada:</b><p>{{$oficios->hora_e1}}</p>
                    <b>Hora salida:</b><p>{{$oficios->hora_s1}}</p>
                @endif
            </div>
        </div>
</div>