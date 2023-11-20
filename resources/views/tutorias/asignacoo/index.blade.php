@extends('tutorias.app_tutorias')
@section('content')
<div class="container" id="principal">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Asigna Coordinador </div>
                        <div class="card-body" v-if="datos.check"  >
                            Ya ha sido asignado un coordinador
                        </div>
                    <div v-else class="card-body text-center">
                        <div class="row">
                            <h6 class="pl-4">Selecciona el docente que sera asignado como coordinador</h6>
                        </div>
                        <div class="row" id="">
                            <div class="col-5 header_fijo" >
                                <table class="table table-bordered">
                                    <thead>
                                        <th>Nombre</th>
                                    </thead>
                                    <tbody>
                                        <tr class="text-left" v-on:click="funclick(profesor)"  v-for="profesor in datos.profesores">
                                            <td class="pl-5 border-1" ><a class="text-dark" style="text-decoration: none;" href="#">@{{profesor.nombre}}</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class=" col-md-7">
                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" >Coordinador Asignado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr id='val'><td>@{{ name }}</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row" v-if="bselected==true">
                                            <div class="col-6">
                                                <button id="btnAsigCoo" v-on:click="agregarCo()" class="btn btn-success  btn-block">Aceptar</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" v-on:click="borrar()">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    new Vue({
        el:"#principal",
        created:function(){
            this.getDatos();

        },
        data:{
            coor:"{{url("/tutorias/asignacoordinador/")}}",
            datos:[],
            name:"",
            bselected:false,
            idname:"",
        },
        methods:{
            getDatos:function () {
                axios.get(this.coor).then(response=>{
                    this.datos=response.data;
                }).catch(error=>{ });
            },
            funclick:function (profesor) {
                this.name= profesor.nombre;
                this.idname= profesor.id_personal;
                this.bselected=true;
            },
            borrar:function () {
                this.name="";
                this.idname="";
                this.bselected=false;
            },
            agregarCo:function () {
                axios.post(this.coor,{id_personal:this.idname}).then(response=>{
                    this.getDatos();
                });
            }

        },
    });
</script>
    @endsection
