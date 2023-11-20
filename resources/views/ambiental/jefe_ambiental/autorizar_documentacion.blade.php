@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>



    <div id="autorizar_doc">
        <main class="col-md-12">
            <template v-if="respuestas == 0">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Autorizar documentación</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">No hay un periodo activo.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-if="respuestas == 1">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Autorizar documentación  del periodo {{ $periodo }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <ul class="nav nav-tabs">
                        <li class="active" ><a href="#">Autorizar documentación</a>
                        </li>
                        <li  > <a href="{{url('/ambiental/proceso_de_modificacion/')}}">Proceso de modificación</a></li>
                        <li  > <a href="{{url('/ambiental/documentacion_autorizada/')}}">Documentación Autorizada</a></li>
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
                                <th>Autorizar Documentacion</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="encargado in encargados" :key="encargado.id_documentacion_encar">
                                <td>@{{ encargado.nom_procedimiento }}</td>
                                <td>@{{ encargado.nombre }}</td>
                                <td v-if="encargado.estado_envio_doc == 1"> <button  class="btn btn-success btn-sm" v-on:click="abrirdocumentos_enc(encargado);" >Autorizar</button></td>
                                <td v-if="encargado.estado_envio_doc == 3"> <button  class="btn btn-success btn-sm" v-on:click="abrirdocumentos_enc_con_mod(encargado);" >Autorizar modificaciones</button></td>

                                {{--
                                 <td> <a @click="eliminar_proce(procedimiento.id_procedimiento)"  class="btn btn-danger btn-sm" >Eliminar</a></td>
                                 --}}

                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

            </template>

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
                    respuestass:[],
                    respuestas:[],
                    id_documentacion_encar:0,
                    estadoguardar:false,
                    respuestas:0,


                }
            },
            methods:{
                //meetodo para mostrar tabla
                async documentacion_enviada() {
                    //llamar datos al controlador
                    const res=await axios.get('/ambiental/estado_periodo/');
                    this.respuestass=res.data;
                    this.respuestas=this.respuestass[0].contar;
                    if(this.respuestas == 0){

                    }else {
                        this.respuestas == 1;
                        const resultado = await axios.get('/ambiental/ver_documentacion_encargado/');
                        this.encargados = resultado.data;
                    }





                    //aqui se guarda el arreglo que traemos
                },
                async abrirdocumentos_enc(data={}) {
                    this.id_documentacion_encar=data.id_documentacion_encar;
                    window.location.href = '/ambiental/documentacion_encar/'+this.id_documentacion_encar;
                },
                async abrirdocumentos_enc_con_mod(data={}){
                    this.id_documentacion_encar=data.id_documentacion_encar;
                    window.location.href = '/ambiental/documentacion_encar_mod/'+this.id_documentacion_encar;
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
