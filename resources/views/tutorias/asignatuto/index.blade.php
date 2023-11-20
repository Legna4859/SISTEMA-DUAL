@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="principaltutor">
        <div class="offset-1 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-content-center">
                        <div class="col-8">
                            <h6>Asignación de tutores</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div id="" class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered header_fijo">
                                    <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                    </tr>
                                    </thead>
                                    <tbody >
                                    <tr v-for="profesor in datos.profesores" @click="profesores(profesor)" v-bind:data-id='profesor.id_personal' v-bind:data-name="profesor.nombre" >
                                        <td><a class="text-dark" style="text-decoration: none;" href="#">@{{profesor.nombre}}</a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Tutor</th>
                                        <th scope="col">Generación</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th id='' >@{{ nameP }}</th>
                                        <th id=''>@{{ generaciong }}</th>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row"></div>
                                <div class="row" v-if="conP==true && conG==true">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <button  @click="guardar()" class="btn btn-success  btn-block">Asignar</button>
                                            </div>
                                            <div class="col-6">
                                                <button  @click="borrar()" class="btn btn-secondary  btn-block">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 header_fijo">
                                <table class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th scope="col">Generación</th>
                                    </tr>
                                    </thead>
                                    <tbody id="datos-tabla">
                                    <tr v-for="grupo in datos.grupos" class="gen" v-bind:id="grupo.id_asigna_generacion"  v-on:click.prevent="generaciones(grupo)" >
                                        <td> <a class="text-dark" style="text-decoration: none;" href="#">@{{grupo.generacion}} grupo: @{{grupo.grupo}}</a></td>
                                    </tr>
                                    <tr v-if="datos.grupos==null"><td>Se han asignado todas las generaciones</td></tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el:"#principaltutor",
            created:function(){
                this.getDatos();
            },
            data:{
                tut:"{{url("/tutorias/asignatutores")}}",
                selected:null,
                datos:[],
                grup:null,
                gen:null,
                idgene:null,
                conG:false,
                conP:false,
                nameP:"",
                idP:"",
                generaciong:"",
            },
            methods:{
                getDatos:function () {
                    axios.get(this.tut).then(response=>{
                        this.datos=response.data;
                    }).catch(error=>{ });
                },
                abrir:function () {
                    $('#add').modal('show');
                },
                borrar:function () {
                    this.conP=false;
                    this.conG=false;
                    this.nameP="";
                    this.generaciong="";
                },
                generaciones:function (genera) {
                    this.grup=genera.grupo;
                    this.gen=genera.generacion;
                    this.idgene=genera.id_asigna_generacion;
                    this.generaciong=this.gen+" grupo: "+this.grup;
                    this.conG=true;
                },
                profesores:function (profesor) {
                    this.nameP=profesor.nombre;
                    this.idP=profesor.id_personal;
                    this.conP=true;
                },
                guardar:function () {
                    axios.post(this.tut,{id_personal:this.idP,id_asigna_generacion:this.idgene}).then(response=>{
                        this.borrar();
                        this.getDatos();
                        this.popToast();
                    });
                },
                popToast() {
                    const h = this.$createElement;
                    const vNodesMsg = h(
                        'p',
                        { class: ['text-center', 'mb-0'] },
                        [
                            h('b-spinner', { props: { type: 'grow', small: true } }),
                            h('strong', {}, '     Asignado correctamente   '),
                            h('b-spinner', { props: { type: 'grow', small: true } })
                        ]
                    );
                    this.$bvToast.toast([vNodesMsg], {
                        solid: true,
                        variant: 'success',
                        toaster:'b-toaster-top-full',
                        noCloseButton: true,
                        noHoverPause:false,
                        autoHideDelay:'3000',

                    });
                },

            },
        });
    </script>
@endsection


