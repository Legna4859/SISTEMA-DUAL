@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="container card">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" href="{{ url('coordina_inst')}}">Primero</a>
                        <a class="nav-item nav-link" href="{{ url('segundo_sem') }}">Segundo</a>
                        <a class="nav-item nav-link" href="{{ url('tercer_sem') }}">Tercero</a>
                        <a class="nav-item nav-link" href="{{ url('cuarto_sem') }}">Cuarto </a>
                        <a class="nav-item nav-link" href="{{ url('quinto_sem') }}">Quinto </a>
                        <a class="nav-item nav-link" href="{{ url('sexto_sem') }}">Sexto </a>
                        <a class="nav-item nav-link" href="{{ url('septimo_sem') }}">Septimo </a>
                        <a class="nav-item nav-link" href="{{ url('octavo_sem') }}">Octavo </a>
                    </div>
                </nav>
                <br>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="octavo" role="tabpanel" aria-labelledby="octavo-tab">
                        <br>
                        <div class="form-group row">
                            <div class="col-sm-11" align="center"><h5>Planeación Octavo Semestre</h5></div>
                            <a class="btn btn-primary" data-toggle="modal" data-target="#myModal_8" style="background: #067a39;color: white">+</a>
                        </div>
                        <table class="table table-hover table-sm">
                            <tr>
                                <th>Descripción de la actividad</th>
                                <th>Modificar Actividad</th>
                                <th>Eliminar Actividad</th>
                            </tr>

                            @foreach ($planeacion as $plan)
                                @if($plan->id_semestre==8 && $plan->id_estado==0)
                                    <tr onmouseover="this.style.backgroundColor='#DBE7F3'" onmouseout="this.style.backgroundColor='white'">
                                        <td>{{$plan->desc_actividad}}</td>
                                        <td>
                                            <form method="post">
                                                <a class="btn btn-lg" href="{{route('coordina_inst.edit',$plan->id_planeacion)}}" style="background: #f0f0f0;">
                                                    <i class="fas fa-eye" style="color: black"></i></a>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('coordina_inst.destroy', $plan->id_planeacion) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-lg"><i class="fas fa-times-circle"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal_8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="form-expe_8">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                @foreach($fecha as $f)
                                    <div class="col">
                                        <label >Fecha Inicio</label>
                                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" min="{{$f->dia}}">
                                    </div>
                                    <div class="col">
                                        <label >Fecha Limite</label>
                                        <input type="date" class="form-control"  id="fecha_fin" name="fecha_fin" min="{{$f->dia}}" max="{{$f->max}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Objetivo</label>
                            <textarea class="form-control" rows="3" id="desc_actividad" name="desc_actividad"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Descripción de la actividad</label>
                            <textarea class="form-control" rows="3" id="objetivo" name="objetivo"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Instrucciones</label>
                            <textarea class="form-control" rows="3" id="instrucciones" name="instrucciones"></textarea>
                        </div>
                        <div style="display: none">
                            <input type="number" class="form-control"  id="id_semestre" name="id_semestre" value="8">
                            <input type="number" class="form-control"  id="id_estado" name="id_estado" value="0">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" id="final_8" data-dismiss="modal" style="color: white">Agregar</a>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{asset('js/jquery.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#final_8').click(function(){
            var con= true;
            var datos = $('#form-expe_8').serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "octavo_sem",
                method: "POST",
                dataType: "json",
                data:datos,
                success:function (data) {
                    location.reload();
                },
                error:function(request,status,data)
                {
                    alert("Hubo un error al insertar el dato, intentelo de nuevo")
                    console.log(request)
                    console.log(status)
                    console.log(data)
                }
            });
        });
    });
</script>
