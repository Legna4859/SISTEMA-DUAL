@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <div id="periodoss">
        <main class="col-md-12">


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Periodos de ambiental </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div  class="col-md-10 col-lg-offset-1">
                    <table id="tabla_envio" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Periodo</th>
                            <th>Año</th>
                            <th>Mes</th>
                            <th>Acción</th>
                            <th>Solicitud de documentacion</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="periodo in periodos" :key="periodo.id_periodo_amb">
                            <td>@{{ periodo.id_periodo_amb }}</td>
                            <td>@{{ periodo.nombre_periodo_amb}}</td>
                            <td>@{{ periodo.fecha_an}}</td>
                            <td v-if="periodo.fecha_mes == 1">Enero</td>
                            <td v-if="periodo.fecha_mes == 2">Junio</td>
                            <template v-if="activo == 0 ">
                            <td  v-if="periodo.estado_periodo == 0"> <button  class="btn btn-success btn-sm" v-on:click="abrirModal_activar(periodo);" >Activar</button></td>
                                <td  v-if="periodo.estado_periodo == 2"> <button  class="btn btn-success btn-sm" v-on:click="abrirModal_activar(periodo);" >Activar nuevamente</button></td>
                            </template>
                            <template v-if="activo > 0 ">
                                <td  v-if="periodo.estado_periodo == 1"> <button  class="btn btn-danger btn-sm" v-on:click="abrirModal_desactivar(periodo);" >Desactivar</button> Periodo Activo</td>
                                <td  v-if="periodo.estado_periodo == 1"> <button  class="btn btn-success btn-sm" v-on:click="solicitud_documentacion(periodo);" >Solicitud de Documentación</button></td>

                                <td  v-if="periodo.estado_periodo == 0"> <button  class="btn btn-primary btn-sm" :disabled="true">Se encuentra activo un periodo</button></td>
                                <td  v-if="periodo.estado_periodo == 2"> <button  class="btn btn-primary btn-sm" :disabled="true">Se encuentra activo un periodo</button></td>

                            </template>


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
            el:"#periodoss",

            data(){
                return {
                    periodo: {
                        nombre_periodo_amb:"",
                        fecha_an :0,
                        fecha_mes:0,
                    },
                    tituloModal_periodo:" ",
                    //lo inicialisamos el array
                    periodos:[],
                    activaciones:[],


                    activo:"",
                    estadoguardar:false,
                    modal_per_act:0,
                    modal_per_desact:0,
                    id_periodo:0,



                }
            },
            methods:{
                //meetodo para mostrar tabla
                async Periodos() {
                    //llamar datos al controlador
                    const resultado = await axios.get('/ambiental/ver_periodos/tabla');
                    this.periodos = resultado.data;
                    const contar = await axios.get('/ambiental/periodo_activado');
                    this.activaciones = contar.data;
                    this.activo = this.activaciones[0].contar;


//alert(this.periodos[0].id_periodo_amb);
                    //aqui se guarda el arreglo que traemos
                },

                abrirModal_activar(data={}){

                    this.estadoguardar=false;
                    this.modal_per_act=1;
                    this.tituloModal_periodo="Activar periodo";
                    this.id_periodo=data.id_periodo_amb;
                    this.periodo.nombre_periodo_amb=data.nombre_periodo_amb;
                    this.periodo.fecha_an=data.fecha_an;
                    this.periodo.fecha_mes=data.fecha_mes;
                },
                abrirModal_desactivar(data={}){

                    this.estadoguardar=false;
                    this.modal_per_desact=1;
                    this.tituloModal_periodo="Desactivar periodo";
                    this.id_periodo=data.id_periodo_amb;
                    this.periodo.nombre_periodo_amb=data.nombre_periodo_amb;
                    this.periodo.fecha_an=data.fecha_an;
                    this.periodo.fecha_mes=data.fecha_mes;
                },
                cerrarModal_activar(){
                    this.modal_per_act=0;
                },
                cerrarModal_desactivar(){
                    this.modal_per_desact=0;
                },

                async guardar_periodo_activo (){

                    this.estadoguardar=true;
                    const resultado=await axios.post('/ambiental/guardar_periodo_activo/'+this.id_periodo);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                    this.cerrarModal_activar();
                    this.Periodos();

                },
                async guardar_periodo_desactivo (){

                    this.estadoguardar=true;
                    const resultado=await axios.post('/ambiental/guardar_periodo_desactivo/'+this.id_periodo);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                    this.cerrarModal_desactivar();
                    this.Periodos();

                },
                async solicitud_documentacion(data={}) {
                    this.id_periodo=data.id_periodo_amb;
                    window.location.href = '/ambiental/ver_proc_ambiental/'+this.id_periodo;
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
