@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Facilitadores de ingles')
@section('content')

    <main class="col-md-12">
        <div id="reg_facilitadores">
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Facilitadores de Ingles</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <table id="tabla_facilitadores" class="table table-bordered table-resposive" >
                            <thead>
                            <tr>
                                <th>Agregar_horas</th>
                                <th>Horas maximas</th>
                                <th>Nombre</th>
                                <th>nivel ingles</th>
                                <th>Titulo</th>
                                <th>Fecha emisión</th>
                                <th>Sexo</th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr v-for="facilitador in facilitadores">
                                <td class="text-center">
                                    <a v-on:click=" abrirModal_facilitador(facilitador);" ><i class="glyphicon glyphicon-cog em2"></i></a>
                                </td>
                                <td v-if="facilitador.horas_maximas == 0">NO SE HAN ASIGNADO HORAS</td>
                                <td v-if="facilitador.horas_maximas > 0">@{{ facilitador.horas_maximas }}</td>
                                <td>@{{ facilitador.nombre }}  @{{ facilitador.apellido_paterno }} @{{ facilitador.apellido_materno }}</td>
                                <td>@{{ facilitador.nivel_ingles }}</td>
                                <td>@{{ facilitador.titulo }}</td>
                                <td>@{{ facilitador.fecha_emision_titulo }}</td>
                                <td>@{{ facilitador.sexo }}</td>


                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div  class="modal" :class="{mostrar:modal}" >
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModal_F();">&times;</button>
                            <h4 class="modal-title" style=" text-align: center;">Agregar o Modificar Horas al Facilitador</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <p style="text-align: center">NOMBRE DEL FACILITADOR:  @{{ nombre_facilitador }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="horas">Horas asignadas: </label>
                                        <template v-if="horas_maximas == 0">
                                            <input class="form-control" type="number" min="0" max="49" id="horas_profesor" name="horas_profesor" v-model="horas_maximas" placeholder="Asignar horas"  required />
                                        </template>
                                        <template v-if="horas_maximas > 0">
                                            <input class="form-control" type="number" min="0" max="49" id="horas_profesor" name="horas_profesor" v-model="horas_maximas"   required />
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" @click="cerrarModal_F();">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click=" guardar_horas();" :disabled="estado_guardar">Agregar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        new Vue({
            el:"#reg_facilitadores",

            data(){
                return {

                    modal:0,
                    modal_mod:0,
                    estado_guardar:false,
                    facilitadores:[],
                    activo:0,
                    id_facilitador:0,
                    nombre_facilitador:"",
                    horas_maximas:0,





                }
            },
            methods:{

                async Ver_Facilitadores() {
                    //llamar datos al controlador
                    const res= await axios.get('/ingles/mostrar_profesore_ingles/');
                    this.facilitadores=res.data;


                },
                async  abrirModal_facilitador(data={}){
                    this.id_facilitador=data.id_profesores;
                    this.nombre_facilitador=data.nombre+" "+data.apellido_paterno+" "+data.apellido_materno;
                    this.horas_maximas=data.horas_maximas;
                    this.estado_guardar=false;
                    this.modal=1;


                },
                async cerrarModal_F(){
                    this.modal=0;
                },
                async  guardar_horas(){

                    if(this.horas_maximas > 0){

                        const resultado=await axios.post('/armar_plantilla/profesor/agregar_horas_profesor/'+this.id_facilitador+'/'+this.horas_maximas);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                        this.cerrarModal_F();
                        this.Ver_Facilitadores();
                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Selecciona una opción",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }



                },



            },
            //funciones para cuando se cargue la vista
            async created(){
                axios.get('/ingles/mostrar_profesore_ingles/').then(res=>{
                    this.facilitadores = res.data.data;
                    this.Tabla_Facilitador();
                });
                this.Ver_Facilitadores();


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