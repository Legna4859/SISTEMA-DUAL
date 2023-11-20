@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <div id="periodoss_ver">
        <main class="col-md-12">


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Historial de los procedimientos de ambiental </h3>
                        </div>
                    </div>
                </div>
            </div>




        </main>
        <div class="row">
            <div class="col-md-2 col-md-offset-5">
                <div class="form-group">
                    <label for="personal">Elegir periodo</label>
                    <select class="form-control"  v-validate="'required'" v-model="periodo.id_periodo"  v-on:change="seleccion_periodo();">
                        <option disabled selected hidden :value="0">Selecciona una opción</option>
                        <option v-for="periodo in periodos" :value="periodo.id_periodo_amb">@{{periodo.nombre_periodo_amb}}</option>
                    </select>
                </div>
            </div>
        </div>
        <template v-if="estadover == true">


            <div class="row">
                <div  class="col-md-10 col-lg-offset-1">
                    <table id="tabla_envio" class="table table-bordered table-resposive">
                        <thead>
                        <tr>

                            <th>Procedimiento</th>
                            <th>Encargado</th>
                            <th>Ver</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="procedimiento in procedimientos" :key="procedimiento.id_procedimiento">
                            <td>@{{ procedimiento.nom_procedimiento }}</td>
                            <td>@{{ procedimiento.nombre }}</td>
                            <td v-if="procedimiento.estado_envio_doc == 0">No ha enviado su documentación</td>
                            <td v-if="procedimiento.estado_envio_doc == 1">Envio su documentación al departamento</td>
                            <td v-if="procedimiento.estado_envio_doc == 2">En estado de  modificacion</td>
                            <td v-if="procedimiento.estado_envio_doc == 3">Envio su documentación al departamento</td>
                            <td v-if="procedimiento.estado_envio_doc == 4">
                                <button  class="btn btn-success btn-sm" v-on:click="abrirdocumentos_ver(procedimiento);" >Documentación</button>

                            </td>


                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </template>

    </div>
    <script>
        new Vue({
            el:"#periodoss_ver",

            data(){
                return {
                    periodo: {
                        id_periodo:0,
                        nombre_periodo_amb:"",
                        fecha_an :0,
                        fecha_mes:0,
                    },
                    tituloModal_periodo:" ",
                    //lo inicialisamos el array
                    periodos:[],
                    procedimientos:[],


                    activo:"",
                    estadover:false,
                    modal_per_act:0,
                    modal_per_desact:0,
                    id_periodo:0,
                    id_documentacion_encar:0,



                }
            },
            methods:{
                //meetodo para mostrar tabla
                async Periodos() {
                    //llamar datos al controlador
                    const resultado = await axios.get('/ambiental/ver_periodos/tabla');
                    this.periodos = resultado.data;



//alert(this.periodos[0].id_periodo_amb);
                    //aqui se guarda el arreglo que traemos
                },

                async seleccion_periodo(){


                    const resultado = await axios.get('/ambiental/ver_procedimiento_encargado/'+this.periodo.id_periodo);
                    this.procedimientos = resultado.data;
                    this.estadover=true;
                },
                async abrirdocumentos_ver(data={}) {
                    this.id_documentacion_encar=data.id_documentacion_encar;
                    window.location.href = '/ambiental/ver_doc_encargado_dep_aut/'+this.id_documentacion_encar;
                },




            },
            //funciones para cuando se cargue la vista
            async created(){
                //disparar la funcion

                this.Periodos();


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
