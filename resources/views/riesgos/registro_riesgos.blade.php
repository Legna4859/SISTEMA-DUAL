@extends('layouts.app')
@section('title', 'Registro Riesgos')
@section('content')
    <main class="col-md-12" id="contRegistroRiesgo">

        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Registro de riesgos</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-md-offset-0" >
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Unidad administrativa</th>
                        <th>Selección</th>
                        <th>Descripción</th>
                        <th>Riesgo</th>
                        <th>Nivel de decisión del riesgo</th>
                        <th>Fecha</th>
                        <th>Clasificación del riesgo</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr v-for="registroRiesgo in tablaRiesgos">
                            <td>@{{registroRiesgo.numero}}</td>
                            <td>@{{(registroRiesgo.unidad_admin[0])?registroRiesgo.unidad_admin[0].nom_departamento:''}}</td>
                            <td>@{{(registroRiesgo.seleccion[0])?registroRiesgo.seleccion[0].des_seleccion:''}}</td>
                            <td>@{{registroRiesgo.descip_riesgo}}</td>
                            <td>@{{(registroRiesgo.riesgos[0])?registroRiesgo.riesgos[0].des_riesgo:''}}</td>
                            <td>@{{(registroRiesgo.nivel_decision[0])?registroRiesgo.nivel_decision[0].des_nivel_des:''}}</td>
                            <td>@{{registroRiesgo.fecha }}</td>
                            <td>@{{(registroRiesgo.clasificacion_riesgo[0])?registroRiesgo.clasificacion_riesgo[0].des_cl:''}}</td>

                            <td>
                                <a href="{{--{{url('/riesgos/registroriesgos/'.$riesgo->id_reg_riesgo)}}--}}" class="modificar" data-id="{{--{{ $riesgo->id_reg_riesgo }}--}}"><span class="glyphicon glyphicon-indent-left em2" aria-hidden="true"></span></a>
                            </td>

                            <td>
                                <a class="elimina" data-id="{{--{{ $riesgo->id_reg_riesgo}}--}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Registrar riesgo" data-target="#modal_registrar_riesgo" type="button" class="btn btn-success btn-lg flotante">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <div class="modal fade" id="modal_registrar_riesgo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Evaluación de Riesgos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_registrar_riesgo" class="form" role="form" method="POST" @submit.prevent="onSubmit" action="{{url('api/riesgos/registroriesgos/')}}">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div :class="['form-group', allerros.unidad_administrativa ? 'has-error' : '']">
                            <label for="unidad_administrativa" class="col-form-label">Unidad Administrativa</label>
                            <select class="form-control" name="unidad_administrativa" id="unidad_administrativa" v-model="form.unidad_administrativa">
                                <option disabled value="">Seleccione una opción</option>
                                @foreach($unidad_administrativa as $unidad)
                                <option value="{{$unidad->id_unidad_admin}}">{{$unidad->nom_departamento}}</option>
                                @endforeach
                            </select>
                            <div v-if="allerros.unidad_administrativa" :class="['alert alert-danger']">@{{ allerros.unidad_administrativa[0] }}</div>
                        </div>
                        <div :class="['form-group', allerros.seleccion_riesgo ? 'has-error' : '']">
                            <label for="seleccion_rieso" class="col-form-label">Alineación a Estrategias, Objetivos,
                                o Metas Institucionales</label>
                            <select class="form-control" name="seleccion_riesgo" id="seleccion_rieso" v-model="form.seleccion_riesgo">
                                <option value="" disabled>Seleccione una opción</option>
                                @foreach($seleccion_riesgo as $seleccion)
                                    <option value="{{$seleccion->id_seleccion}}">{{$seleccion->des_seleccion}}</option>
                                @endforeach
                            </select>
                            <div v-if="allerros.seleccion_riesgo" :class="['alert alert-danger']">@{{ allerros.seleccion_riesgo[0] }}</div>

                        </div>
                        <div :class="['form-group', allerros.descripcion_riesgo ? 'has-error' : '']">
                            <label for="descripcion_riesgo" class="col-form-label">Riesgo</label>
                            <input type="text" id="descripcion_riesgo" class="form-control" placeholder="Escribe riesgo" v-model="form.descripcion_riesgo" v-on:keyup="autoComplete" >
                            <div class="panel-footer" v-if="results.length">
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="result in results" v-on:click="setRiesgo(result.des_riesgo)">
                                        @{{ result.des_riesgo }}
                                    </li>
                                </ul>
                            </div>
                            <div v-if="allerros.descripcion_riesgo" :class="['alert alert-danger']">@{{ allerros.descripcion_riesgo[0] }}</div>

                        </div>

                        <div>
                            <label for="" class="col-form-label">Descripción</label>
                            <textarea class="form-control"></textarea>
                            <label for="" class="col-form-label">Nivel de decisión del riesgo</label>
                            <select class="form-control" name="" id="tipo_periodo">
                                <option value="0" disabled="true" selected="true">Seleccione una opción</option>
                                <option value="">Estratégico</option>
                                <option value="">Directivo</option>
                                <option value="">Operativo</option>
                            </select>
                            <label for="" class="col-form-label">Clasificación del riesgo</label>
                            <select class="form-control" name="" id="tipo_periodo">
                                <option value="0" disabled="true" selected="true">Seleccione una opción</option>
                                <option value="">Administrativo</option>
                                <option value="">De corrupción</option>
                                <option value="">De seguridad</option>
                                <option value="">De servicios</option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary h-secondary_m" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary h-primary_m">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const app = new Vue({
            el: '#modal_registrar_riesgo',
            data(){
                return {
                    results: [],
                    form: {
                        unidad_administrativa : '',
                        seleccion_riesgo : '',
                        descripcion_riesgo:'',
                    },
                    allerros: [],
                }
            },
            methods: {
                autoComplete(){
                    this.results = [];
                    if(this.form.descripcion_riesgo.length > 2){
                        axios.get('/api/searchriesgo',{params: {query: this.form.descripcion_riesgo}}).then(response => {
                            this.results = response.data;
                        });
                    }
                },
                setRiesgo(riesgo)
                {
                    this.form.descripcion_riesgo=riesgo;
                    this.results=[];
                },
                onSubmit(){
                    dataform = new FormData();
                    dataform.append('unidad_administrativa', this.form.unidad_administrativa);
                    dataform.append('seleccion_riesgo', this.form.seleccion_riesgo);
                    dataform.append('descripcion_riesgo', this.form.descripcion_riesgo);
                    this.allerros = [];
                    axios.post('{{url('api/riesgos/registroriesgos/')}}', dataform).then( response => {
                        this.form.unidad_administrativa='';
                        this.form.seleccion_riesgo='';
                        this.form.descripcion_riesgo='';

                        swal('Se ha insertado correctamente');
                        $("#modal_registrar_riesgo").modal("hide");

                    } ).catch((error) => {
                        this.allerros = error.response.data;


                    });
                }
            }
        });
        const loadRiesgo = new Vue({
            el: '#contRegistroRiesgo',
            data(){
                return {
                    tablaRiesgos:[],
                }
            },
            beforeMount(){
                // alert("ok")
                axios.get('/api/riesgos/registroriesgos')
                    .then(response => {
                       // console.log(response);
                        this.tablaRiesgos = response.data;
                    })
                    .catch(function () {
                        swal('No se puede conectar al servidor');
                    });
            },
        });
    </script>

@endsection


