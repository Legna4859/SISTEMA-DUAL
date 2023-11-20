@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="principal">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Asigna Coordinador Institucional</div>
                    <div class="card-body" v-if="extra.check"  >
                        Ya ha sido asignado un coordinador general
                    </div>
                    <div v-else class="card-body text-center">
                        <div class="row">
                            <div class="col-lg">
                                <input class="form-control" name="query" v-model="searchQuery" placeholder="Coloque el nombre de el docente que será asignado como coordinador institucional">
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-5 header_fijo" >
                                <!--
                                <table class="table table-bordered">
                                    <thead>
                                        <th>Nombre</th>
                                    </thead>
                                    <tbody>
                                        <tr class="text-left" v-on:click="funclick(profesor)"  v-for="profesor in datos">
                                            <td class="pl-5 border-1" ><a class="text-dark" style="text-decoration: none;" href="#">@{{profesor.nombre}}</a></td>
                                        </tr>
                                    </tbody>
                                </table>-->
                                <div class="tableFixHeadLista">
                                    <data-table class=" table table-sm" :data="datos" :columns-to-display="gridColumns" :filter-key="searchQuery">
                                        <template slot="Nombre" scope="alumno">
                                            <tr class="text-left" v-on:click="funclick(alumno.entry)" >
                                                <td class="pl-5 border-1" ><a class="text-dark" style="text-decoration: none;" href="#">@{{ alumno.entry.nombre }}</a></td>
                                            </tr>
                                        </template>
                                    </data-table>
                                </div>
                            </div>
                            <div class=" col-md-7">
                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" >Asignar coordinador institucional</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr id='val'><td>@{{name}}</td></tr>
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
                this.getCheck();
            },
            data:{
                coor:"{{url("/tutorias/asignacoordinadorgeneral")}}",
                chec:"{{url("/tutorias/check")}}",
                datos:[],
                extra:[],
                name:"",
                bselected:false,
                idname:"",
                searchQuery: '',
                gridColumns: ['Nombre'],
            },
            methods:{
                getDatos:function () {
                    axios.get(this.coor).then(response=>{
                        this.datos=response.data;
                    }).catch(error=>{ });
                },
                getCheck:function () {
                    axios.get(this.chec).then(response=>{
                        this.extra=response.data;
                        this.getDatos();
                    }).catch(error=>{ });
                },
                funclick:function (datos) {
                    this.name= datos.nombre;
                    this.idname= datos.id_personal;
                    this.bselected=true;
                },
                borrar:function () {
                    this.name="";
                    this.idname="";
                    this.bselected=false;
                },
                agregarCo:function () {
                    axios.post(this.coor,{id_personal:this.idname}).then(response=>{
                        this.getCheck();
                    });
                }
            },
        });
    </script>
@endsection

