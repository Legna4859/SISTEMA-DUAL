@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <div id="autorizar_doc">
        <main class="col-md-12">


                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center"> Documentación Autorizada  del periodo {{ $periodo[0]->nombre_periodo_amb }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9 col-md-offset-1">
                        <ul class="nav nav-tabs">
                            <li  > <a href="{{url('/ambiental/ver_documentacion_ambiental')}}">Autorizar documentación</a></li>
                            <li  > <a href="{{url('/ambiental/proceso_de_modificacion/')}}">Proceso de modificación</a></li>
                            <li class="active" ><a href="#">Documentación Autorizada</a>
                            </li>
                        </ul>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div  class="col-md-10 col-lg-offset-1">
                        <table id="tabla_envio" class="table table-bordered table-resposive">
                            <thead>
                            <tr>

                                <th>Procedimiento</th>
                                <th>Nombre del encargado</th>
                                <th>Ver Documentacion</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="encargado in encargados" :key="encargado.id_documentacion_encar">
                                <td>@{{ encargado.nom_procedimiento }}</td>
                                <td>@{{ encargado.nombre }}</td>
                                <td> <button  class="btn btn-success btn-sm" v-on:click="abrirdocumentos_ver(encargado);" >Documentación</button></td>


                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>



        </main>

    </div>
    <script>
        new Vue({
            el:"#autorizar_doc",

            data(){
                return {
                    //objeto donde se va a guardar los datos de un procedimiento
                    modal:0,
                    tituloModal:" ",
                    //lo inicialisamos el array
                    encargados:[],
                    respuestas:[],
                    id_documentacion_encar:0,
                    estadoguardar:false,


                }
            },
            methods:{
                //meetodo para mostrar tabla
                async documentacion_enviada() {
                    //llamar datos al controlador
                    const resultado=await axios.get('/ambiental/ver_documentacion_autorizada/');
                    this.encargados=resultado.data;

                    //aqui se guarda el arreglo que traemos
                },
                async abrirdocumentos_ver(data={}) {
                    this.id_documentacion_encar=data.id_documentacion_encar;
                    window.location.href = '/ambiental/ver_doc_autorizada_departamento/'+this.id_documentacion_encar;
                },

                cerrarModal(){
                    this.modal=0;
                },

            },
            //funciones para cuando se cargue la vista
            async created(){
                //disparar la funcion
                this.documentacion_enviada();

            },
        })
    </script>
    <style>
        .mostrar{
            display: list-item;
            opacity: 1;
            background: rgba(44,38,75,0.849);
        }
    </style>

@endsection
