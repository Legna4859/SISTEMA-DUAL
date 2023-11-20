@extends('layouts.app')
@section('title', 'Ambiental')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <div id="procedimiento">
        <main class="col-md-12">


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Procedimientos</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <br>
                <div class="col-md-2 col-md-offset-1">
                    <button v-on:click=" modificarse=false , abrirModal();" type="button" class="btn btn-primary" >
                        Agregar Procedimiento
                    </button>
                    <p><br></p>
                </div>
                <br>
            </div>
            <div class="row">
                <div  class="col-md-10 col-lg-offset-1">
                    <table id="tabla_envio" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Procedimiento</th>
                            <th>Modificar</th>
                        </tr>
                        </thead>
                        <tbody>

                           <tr v-for="procedimiento in procedimientos" :key="procedimiento.id_procedimiento">
                           <td>@{{ procedimiento.i }}</td>
                            <td>@{{ procedimiento.nom_procedimiento }}</td>
                               <td> <button  class="btn btn-warning btn-sm" v-on:click=" modificarse=true , abrirModal(procedimiento);" >Editar</button></td>
                              {{--
                               <td> <a @click="eliminar_proce(procedimiento.id_procedimiento)"  class="btn btn-danger btn-sm" >Eliminar</a></td>
                               --}}

                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>


        </main>
        @include('ambiental.jefe_ambiental.crear_procedimiento')
    </div>
    <script>
        new Vue({
            el:"#procedimiento",

            data(){
                return {
                    //objeto donde se va a guardar los datos de un procedimiento
                    procedimiento: {
                         nom_procedimiento:'',
                    },
                    modificarse:true,
                    modal:0,
                    tituloModal:" ",
             //lo inicialisamos el array
                    procedimientos:[],
                    id_proce:0,
                    estadoguardar:false,


                }
            },
            methods:{
                //meetodo para mostrar tabla
                async getProcedimiento() {
                    //llamar datos al controlador
                    const resultado=await axios.get('/ambiental/ver_procedimientos/tabla');

                    this.procedimientos=resultado.data;
                    //aqui se guarda el arreglo que traemos
                },

                 async eliminar_proce (id_procedimiento){
                    const resultado=await axios.delete('/ambiental/eliminar_procedimientos/'+id_procedimiento);
                     this.getProcedimiento();
                },
                async guardar_proc (){
                    if(this.modificarse){
                        const resultado=await axios.put('/ambiental/modificar_procedimientos/'+this.id_proce,this.procedimiento);
                        this.cerrarModal();
                        this.getProcedimiento();
                    }else{

                        if( this.procedimiento.nom_procedimiento == ''){
                            swal({
                                position: "top",
                                type: "warning",
                                title: "El campo se encuentra  vacío.",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            this.estadoguardar=true;
                            const resultado=await axios.post('/ambiental/registrar_procedimientos/',this.procedimiento);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                            this.cerrarModal();
                            this.getProcedimiento();
                        }

                    }

                },
                abrirModal(data={}){
                    this.estadoguardar=false;
                    this.modal=1;
                    if(this.modificarse){
                        this.id_proce=data.id_procedimiento;
                        this.tituloModal="Modificar Procedimiento";
                        this.procedimiento.nom_procedimiento=data.nom_procedimiento;
                    }else{
                        this.id_proce=data.id_procedimiento;
                        this.tituloModal="Agregar Nuevo Procedimiento";
                        this.procedimiento.nom_procedimiento='';
                    }
                },
               cerrarModal(){
                    this.modal=0;
                },

            },
            //funciones para cuando se cargue la vista
            async created(){
                //disparar la funcion
                this.getProcedimiento();

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
