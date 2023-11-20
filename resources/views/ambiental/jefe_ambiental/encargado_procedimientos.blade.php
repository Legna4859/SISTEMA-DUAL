@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <div id="encargados_procedimiento">
        <main class="col-md-12">


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Encargados Procedimientos</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div  class="col-md-10 col-lg-offset-1">
                    <table id="tabla_envio_encargado" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Procedimiento</th>
                            <th>Encargado</th>
                            <th>Modificar</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="encargado in encargados" :key="encargado.id_encargado">
                            <td>@{{ encargado.i }}</td>
                            <td>@{{ encargado.nom_procedimiento }}</td>
                                <td v-if="encargado.status == 0"> <button  class="btn btn-primary btn-sm" v-on:click="abrirModal(encargado);" >Agregar encargado</button></td>
                                <td v-if="encargado.status == 0"></td>
                                <td v-if="encargado.status == 1">@{{ encargado.nombre_personal }}</td>
                               <td v-if="encargado.status == 1"> <button  class="btn btn-warning btn-sm" v-on:click="abrirModal_mod(encargado);" >Modificar encargado</button></td>




                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>


        </main>
        @include('ambiental.jefe_ambiental.agregar_encargado')
        @include('ambiental.jefe_ambiental.modificar_encargado')

    </div>
    <script>

        new Vue({
            el:"#encargados_procedimiento",

            data(){
                return {
                    //objeto donde se va a guardar los datos de un procedimiento
                    encargado: {
                        nom_procedimiento:'',
                        id_personal:0,
                    },
                    modificar_encar:true,
                    modal_encar:0,
                    modal_mod_encar:0,
                    tituloModal_encar:" ",
                    //lo inicialisamos el array
                    encargados:[],
                    personales:[],
                    id_procedimiento:0,
                    estadoguardar:false,


                }
            },
            methods:{
                //meetodo para mostrar tabla
                async Encargados() {
                    //llamar datos al controlador
                    const resultado=await axios.get('/ambiental/ver_encargados/tabla');

                    this.encargados=resultado.data;

                    //aqui se guarda el arreglo que traemos
                },
                async Personal() {
                    //llamar datos al controlador
                    const resultado=await axios.get('/ambiental/personal_tecnologico/');

                    this.personales=resultado.data;
                    //aqui se guarda el arreglo que traemos
                },

                async eliminar_proce (id_procedimiento){
                    const resultado=await axios.delete('/ambiental/eliminar_procedimientos/'+id_procedimiento);
                    this.getProcedimiento();
                },
                async guardar_encargado (){
                    if(this.encargado.id_personal == 0) {
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Selecciona una opción",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{
                        this.estadoguardar=true;
                        const resultado=await axios.post('/ambiental/guardar_encargado/'+this.id_procedimiento,this.encargado);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        this.cerrarModal();
                        this.Encargados();
                    }
                },
                async guardar_encargado_mod (){

                        this.estadoguardar=true;
                        const resultado=await axios.post('/ambiental/modificar_encargado/'+this.id_procedimiento,this.encargado);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        this.cerrarModal_mod();
                        this.Encargados();
                },
                abrirModal(data={}){
                    this.estadoguardar=false;
                    this.modal_encar=1;
                    this.tituloModal_encar="Agregar Encargado del Procedimiento";
                    this.id_procedimiento=data.id_procedimiento;
                    this.encargado.nom_procedimiento=data.nom_procedimiento;
                    this.encargado.id_personal=0;
                },
                abrirModal_mod(data={}){
                    this.estadoguardar=false;
                    this.modal_mod_encar=1,
                    this.tituloModal_encar="Modificar Encargado del Procedimiento";
                    this.id_procedimiento=data.id_procedimiento;
                    this.encargado.nom_procedimiento=data.nom_procedimiento;
                    this.encargado.id_personal=data.id_personal;
                },
                cerrarModal(){
                    this.modal_encar=0;
                },
                cerrarModal_mod(){
                    this.modal_mod_encar=0;
                },

            },
            //funciones para cuando se cargue la vista
            async created(){
                //disparar la funcion
                this.Encargados();
                this.Personal();
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
