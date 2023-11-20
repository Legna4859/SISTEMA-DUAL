@extends('tutorias.app_tutorias')
@section('content')
    @if($alumno ==null)
        <div class="container pb-5 pt-5" id="principal">
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-10 align-middle"><h5>{{Session::get('nombre')}}</h5></div>

                                        <div class="col-2" v-if="datos==1">
                                            <a href="{{url('/tutorias/pdf/all')}}" target="_blank" class="btn btn-danger text-white float-right"> <i class="fas fa-file-pdf"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="AlumActualizar" v-if="datos==1" class="btn btn-success"> <h1><i class="fas fa-folder"></i></h1> Editar Expediente</a>
                                <a href="Alum" v-if="datos==2" class="btn btn-primary"> <h1><i class="fas fa-folder"></i></h1> Llenar Expediente</a>

                            </div>



                        </div>
                    </div>

                </div>
            </div>
    @else
        <div class="container pb-5 pt-5" id="principal">
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-10 align-middle"><h5>{{Session::get('nombre')}}</h5></div>

                                        <div class="col-2" v-if="datos==1">
                                            <a href="{{url('/tutorias/pdf/all')}}" target="_blank" class="btn btn-danger text-white float-right"> <i class="fas fa-file-pdf"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="AlumActualizar" v-if="datos==1" class="btn btn-success"> <h1><i class="fas fa-folder"></i></h1> Editar Expediente</a>
                                <a href="Alum" v-if="datos==2" class="btn btn-primary"> <h1><i class="fas fa-folder"></i></h1> Llenar Expediente</a>

                            </div>

                            <div class="row">
                                <div class="col-10" v-if="datos==1">
                                    <br>
                                </div>
                                <div class="col-12 text-center " style="color: #942a25" v-if="datos==1">
                                    @if($alumno->foto == 'image/jpeg')
                                        <img src="{{ asset('Fotografias/'.$alumno->cuenta.'.jpeg') }}" class="img-rounded" alt="Agrega tu foto, para poder imprimir tu expediente. Dar clic en Modificar Fototgrafia" width="136" height="200" />
                                    @elseif($alumno->foto == 'image/png')
                                        <img src="{{ asset('Fotografias/'.$alumno->cuenta.'.png') }}" class="img-rounded" alt="Agrega tu foto, para poder imprimir tu expediente. Dar clic en Modificar Fototgrafia" width="136" height="200" />
                                    @elseif($alumno->foto == 'image/jpg')

                                        <img src="{{ asset('Fotografias/'.$alumno->cuenta.'.jpg') }}" class="img-rounded" alt="Agrega tu foto, para poder imprimir tu expediente. Dar clic en Modificar Fototgrafia" width="136" height="200" />
                                    @endif
                                </div>
                                <div class="col-12 text-center" v-if="datos==1">
                                    <br>
                                    <button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal">Modificar fotografia</button>   </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h4 class="modal-title">Modificar fotografia </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <form class="form" id="form_solicitud_residencia" action="{{url("/computo/modificar_imagen/".$alumno->id_alumno)}}" role="form" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <label>Seleccionar Foto</label>
                                        <input type="file" class="form-control" accept="image/jpeg,image/png" name="foto"  id="foto" required>

                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Aceptar</button>


                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

<script>
    new Vue({
        el: "#principal",
        created: function () {
            this.getDatos();
        },
        data: {
            rut: "/tutorias/panel",
            datos:[],
        },
        methods: {
            getDatos: function () {
                axios.get(this.rut).then(response => {
                    this.datos = response.data;
                }).catch(error => {
                });
            },
        }
    });
</script>
@endsection
