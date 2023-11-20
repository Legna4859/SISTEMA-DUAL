@extends('tutorias.app_tutorias')
@section('content')
    <div id="index_d">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6" id="coordinador">
                                    <div class="card" v-if="datos.coordinador!=null">
                                        <div class="card-header">
                                            <h5 class="card-title">Coordinador asignado</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="text-center table">
                                                <thead>
                                                <th>Nombre</th>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>@{{datos.coordinador[0].nombre}}</td>
                                                    <td><button  v-on:click="confirmC(datos.coordinador[0].id_asigna_coordinador)" class=" btn btn-outline-danger">X</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card" v-if="datos.coordinador==null">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Coordinador No Asignado</h5>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6" >
                                    <div class="card" v-if="datos.tutores!=null">
                                        <div class="card-header"><h5 class="card-title">Tutores asignados</h5></div>
                                        <div class="card-body">
                                            <table class="table text-center">
                                                <thead>
                                                <th>Nombre</th>
                                                <th>Generación</th>
                                                <th>Grupo</th>
                                                </thead>
                                                <tbody id="tabla">
                                                <tr class="prof" v-for="tutor in datos.tutores">
                                                    <td >@{{tutor.nombre}}</td>
                                                    <td>@{{ tutor.generacion }}</td>
                                                    <td>@{{ tutor.grupo }}</td>
                                                    <td><button v-on:click="confirmT(tutor.id_asigna_tutor)" class="eliminar btn btn-outline-danger">X</button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card" v-if="datos.tutores==null">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Tutores no asignados</h5>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('tutorias.jefe.eliminartutor')
        @include('tutorias.jefe.eliminarcoor')
    </div>

    <script>
        new Vue({
            el:"#index_d",
            created:function(){
                this.getDatos();
            },
            data:{
                jefe:"{{url("/tutorias/jefe")}}",
                datos:[],
                id_tu:null,
                id_c:null
            },
            methods:{
                getDatos:function () {
                    axios.get(this.jefe).then(response=>{
                        this.datos=response.data;
                    }).catch(error=>{ });
                },
                deleteT:function () {
                    var url = '/tutorias/asignatutores/' + this.id_tu;
                    //alert(id);
                    axios.delete(url).then(response => {
                        this.getDatos();
                    });
                },
                confirmT:function(id)
                {
                    this.id_tu=id;
                    $('#Eliminar').modal('show');
                },
                deleteC:function () {
                    var url = '/tutorias/asignacoordinador/eliminar/' + this.id_co;
                    axios.delete(url).then(response => {
                        this.getDatos();
                    });
                },
                confirmC:function (id) {
                    this.id_co=id;
                    $('#EliminarCo').modal('show');
                },

            },
        });

    </script>
@endsection


