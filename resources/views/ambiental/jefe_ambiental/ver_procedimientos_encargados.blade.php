@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <div id="reg_proc">
        <main class="col-md-12">


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Solicitud de Documentación de los procedimientos del Periodo @{{ nom_periodo }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-xs-10 col-md-offset-1">
                    <p>
                        <span class="glyphicon glyphicon-arrow-right"></span>
                        <a href="{{url("/ambiental/ver_periodos")}}">Periodos Ambiental</a>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span>Procedimientos Registrados </span>

                    </p>
                    <br>
                </div>
            </div>
            <div class="row">
                <div  class="col-md-10 col-lg-offset-1">
                    <table id="tabla_envio" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Procedimiento</th>
                            <th>Encargado</th>
                            <th>Solicitar Documentación</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="procedimiento in procedimientos" :key="procedimiento.id_procedimiento">
                            <td>@{{ procedimiento.i }}</td>
                            <td>@{{ procedimiento.nombre_procedimiento }}</td>
                            <td>@{{ procedimiento.nombre_encargado }}</td>
                            <td v-if="procedimiento.estado_doc == 0" > <button  class="btn btn-primary btn-sm" v-on:click="agregar_solicitud(procedimiento);" >Agregar</button></td>
                            <td v-if="procedimiento.estado_doc == 1" > <button  class="btn btn-success btn-sm" v-on:click="agregar_solicitud(procedimiento);" >Ver solicitud </button></td>

                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>


        </main>
        @include('ambiental.jefe_ambiental.activar_periodo')
        @include('ambiental.jefe_ambiental.desactivar_periodo')
    </div>
    <script>
        new Vue({
            el:"#reg_proc",

            data(){
                return {
                    periodo: {
                        nombre_periodo_amb:"",
                        fecha_an :0,
                        fecha_mes:0,
                    },
                    tituloModal_periodo:" ",
                    //lo inicialisamos el array
                    procedimientos:[],
                    period:[],


                    activo:"",
                    estadoguardar:false,
                    modal_per_act:0,
                    modal_per_desact:0,
                    id_periodo:0,
                    nom_periodo:"",
                    id_encargado:0,



                }
            },
            methods:{
                //meetodo para mostrar tabla
                async Procedimientos() {
                    //llamar datos al controlador

                    const resultado=await axios.get('/ambiental/buscar_encargados_procedimientos/{{$id_periodo}}');
                    this.procedimientos=resultado.data;


                    const periodo = await axios.get('/ambiental/datos_periodo/{{$id_periodo}}');
                    this.period = periodo.data;
                    this.nom_periodo = this.period[0].nombre_periodo_amb;


//alert(this.periodos[0].id_periodo_amb);
                    //aqui se guarda el arreglo que traemos
                },


                async agregar_solicitud(data={}) {
                    this.id_encargado=data.id_encargado;

                    window.location.href = '/ambiental/ver_proc_encargado_doc/'+ {{$id_periodo}}+'/'+this.id_encargado;
                },

            },
            //funciones para cuando se cargue la vista
            async created(){
                //disparar la funcion
                this.Procedimientos();


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
