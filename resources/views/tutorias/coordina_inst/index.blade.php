@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="ind">
        <div class="row" v-show="menugrupos==true">
            <div class="col-12">
                <div class="row" >
                    <div class="col-2 pt-2" v-for="grupo in grupos">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Generación @{{ grupo.generacion }}</h5>
                                <a href="#" @click="getlista(grupo)" class="btn btn-outline-primary">Ver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-show="menu==true">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 pb-3">
                        <i class="fas fa-chevron-right h5"></i>
                        <a href="{{url('/tutorias/planeacioncoorgen')}}" class="font-weight-bold h6 pb-1">GENERACIONES</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-11 text-center">PLANEACIÓN @{{ gen }}</div>
                                        <div class="col-1 text-center">
                                            <button class="btn btn-outline-success m-1"
                                                    @click="agr()" data-toggle="tooltip" data-placement="bottom" title="Agregar Actividad">+
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" v-if="(lista==true && datos.length>0)">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tableFixHeadLista">
                                                <data-table class=" col-12 table-hover table-sm" :data="datos" :columns-to-display="gridColumns">
                                                    <template slot="Fecha Inicio" scope="alumno">
                                                        <div class="text-center pt-2">@{{ alumno.entry.fi_acti}}</div>
                                                    </template>
                                                    <template slot="Fecha Fin" scope="alumno">
                                                        <div class="text-center pt-2">@{{ alumno.entry.ff_acti}}</div>
                                                    </template>
                                                    <template slot="Nombre Actividad" scope="alumno">
                                                        <div class="text-center pt-2">@{{ alumno.entry.desc_actividad}}</div>
                                                    </template>
                                                    <template slot="Acciones" scope="alumno">
                                                        <div class="text-center" v-if="alumno.entry.id_estado==1">
                                                            <button class="btn btn-outline-primary m-1"
                                                                    @click="veraprobado(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Ver Actividad"><i class="far fa-eye"></i>
                                                            </button>
                                                        </div>
                                                        <div class="text-center" v-else-if="alumno.entry.id_estado==2">
                                                            <button class="btn btn-outline-primary m-1"
                                                                    @click="veractualizar(alumno.entry)" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Editar Actividad"><i class="far fa-edit"></i>
                                                            </button>
                                                        </div>
                                                        <div class="text-center" v-else-if="alumno.entry.id_estado==3">
                                                            <button class="btn btn-outline-dark m-1"
                                                                    @click="versugdes(alumno.entry)" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Actividad con Cambios"><i class="far fa-edit"></i>
                                                            </button>
                                                        </div>
                                                    </template>
                                                    <template slot="Mensaje" scope="alumno">
                                                        <div class="text-center" v-if="alumno.entry.id_estado==1">
                                                            <a>Actividad Aprobada</a>
                                                        </div>
                                                        <div class="text-center" v-else-if="alumno.entry.id_estado==2">
                                                            <button class="btn btn-outline-danger m-1"
                                                                    @click="vereliminar(alumno.entry)" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Eliminar Actividad">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <div class="text-center" v-else-if="alumno.entry.id_estado==3">
                                                            <button class="btn btn-outline-danger m-1"
                                                                    @click="vereliminar(alumno.entry)" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Eliminar Actividad">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </template>
                                                    <template slot="nodata">
                                                        <div class=" alert font-weight-bold alert-danger text-center">Ningún dato encontrado</div>
                                                    </template>
                                                </data-table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" v-if="datos.length==0">
                                <div class="row ">
                                    <div class="col-12 alert-info alert text-center">
                                        <h5 class="font-weight-bold">No se han asignado actividades</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('tutorias.coordina_inst.modalagregar')
        @include('tutorias.coordina_inst.modalveraprobados')
        @include('tutorias.coordina_inst.modaleliminar')
        @include('tutorias.coordina_inst.modalveractualiza')
        @include('tutorias.coordina_inst.modaldesarrollosug')
    </div>

    <script type="text/javascript">
        Vue.use(DataTable);
        new Vue({
            el: "#ind",
            created: function () {
                this.getTut();
            },
            data: {
                gridColumns: ['Fecha Inicio', 'Fecha Fin', 'Nombre Actividad', 'Acciones', 'Mensaje'],
                rut: "/tutorias/actividadescoor",
                send:"/tutorias/enviaplan",
                ver_ap : '/tutorias/modalver',
                ver_elim:'/tutorias/modalelim',
                aceptaelimina:'/tutorias/aceptborrar',
                ver_actpl:'/tutorias/modalveract',
                enviactualiza:'/tutorias/enviact',
                ver_sugdes:'/tutorias/sugerenciades',
                //enviades:'tutorias/envdes',
                generacion: "/tutorias/generacion",
                datos: [],
                grupos: [],
                menugrupos: true,
                act: {
                    va: {
                        id_plan_actividad: "",
                        desc_actividad: "",
                        objetivo_actividad: "",
                        fi_acti: "",
                        ff_acti: "",
                    },
                },
                elimina:{
                    ac: {
                        id_plan_actividad: "",
                        id_asigna_planeacion_tutor:"",
                    },
                },
                actplan: {
                    p: {
                        id_plan_actividad: "",
                        desc_actividad: "",
                        objetivo_actividad: "",
                        fi_acti: "",
                        ff_acti: "",
                    },
                },
                sug:{
                    corr:{
                        id_plan_actividad: "",
                        desc_actividad: "",
                        objetivo_actividad: "",
                        fi_acti: "",
                        ff_acti: "",
                        comentario:"",
                    },
                },
            },
            methods: {
                getTut: function () {
                    axios.get(this.generacion).then(response => {
                        this.grupos = response.data;
                    }).catch(error => {
                    });
                },
                getlista: function (grupo) {
                    this.idgenera = grupo.id_generacion;
                    this.id_generacion = grupo.id_generacion;
                    this.gen = " GENERACIÓN " + grupo.generacion;
                    this.getAlumnos();
                },
                getAlumnos: function () {
                    axios.post(this.rut, {
                        id_generacion: this.idgenera,
                    }).then(response => {
                        this.menugrupos = false;
                        this.menu = true;
                        this.lista = true;
                        this.datos = response.data;
                    }).catch(error => {
                    });
                },
                agr:function (){
                    $("#modalagregar").modal("show");
                },
                enviar:function (){
                    axios.post(this.send,  {
                        desc_actividad: this.desc_actividad,
                        objetivo_actividad:this.objetivo_actividad,
                        fi_actividad :this.fi_actividad,
                        ff_actividad :this.ff_actividad,
                        id_generacion: this.id_generacion,
                    })
                        .then(response => {
                            $("#modalagregar").modal("hide");
                            this.fi_actividad="";
                            this.ff_actividad="";
                            this.desc_actividad="";
                            this.objetivo_actividad="";
                            this.popToast('Actividad Agregada');
                            this.getAlumnos();
                        });
                },
                veraprobado: function (alumno) {
                    axios.post(this.ver_ap, {id: alumno.id_plan_actividad}).then(response => {
                        this.act.va.desc_actividad = response.data.va[0].desc_actividad;
                        this.act.va.objetivo_actividad = response.data.va[0].objetivo_actividad;
                        this.act.va.fi_actividad = response.data.va[0].fi_actividad;
                        this.act.va.ff_actividad = response.data.va[0].ff_actividad;
                        $("#modalveraprobados").modal("show");
                    });
                },
                vereliminar: function(alumno){
                    axios.post(this.ver_elim, {id: alumno.id_plan_actividad}).then(response => {
                        this.elimina.ac.id_plan_actividad = response.data.ac[0].id_plan_actividad;
                        $('#modaleliminar').modal('show');
                    });
                },
                eliminactividad: function(){
                    axios.post(this.aceptaelimina,  {
                        id_plan_actividad: this.elimina.ac.id_plan_actividad,
                    })
                        .then(response => {
                            $('#modaleliminar').modal('hide');
                            this.popToast('Actividad Eliminada');
                            this.getAlumnos();
                        });
                },
                veractualizar: function(alumno){
                    axios.post(this.ver_actpl, {id: alumno.id_plan_actividad}).then(response => {
                        this.actplan.p.id_plan_actividad = response.data.p[0].id_plan_actividad;
                        this.actplan.p.desc_actividad = response.data.p[0].desc_actividad;
                        this.actplan.p.objetivo_actividad = response.data.p[0].objetivo_actividad;
                        this.actplan.p.fi_actividad = response.data.p[0].fi_actividad;
                        this.actplan.p.ff_actividad = response.data.p[0].ff_actividad;
                        $('#modalveractualiza').modal('show');
                    });
                },
                actualizarplan: function(){
                    axios.post(this.enviactualiza,  {
                        id_plan_actividad: this.actplan.p.id_plan_actividad,
                        fi_actividad: this.actplan.p.fi_actividad,
                        ff_actividad:this.actplan.p.ff_actividad,
                        desc_actividad:this.actplan.p.desc_actividad,
                        objetivo_actividad:this.actplan.p.objetivo_actividad,
                    })
                        .then(response => {
                            $("#modalveractualiza").modal("hide");
                            this.popToast('Datos Actualizados');
                            this.getAlumnos();
                        });
                },
                versugdes: function(alumno){
                    axios.post(this.ver_sugdes, {id: alumno.id_plan_actividad}).then(response => {
                        this.sug.corr.id_plan_actividad = response.data.corr[0].id_plan_actividad;
                        this.sug.corr.desc_actividad = response.data.corr[0].desc_actividad;
                        this.sug.corr.objetivo_actividad = response.data.corr[0].objetivo_actividad;
                        this.sug.corr.fi_actividad = response.data.corr[0].fi_actividad;
                        this.sug.corr.ff_actividad = response.data.corr[0].ff_actividad;
                        this.sug.corr.comentario = response.data.corr[0].comentario;
                        $('#modaldesarrollosug').modal('show');
                    });
                },
                correcion: function(){
                    axios.post(this.enviactualiza,  {
                        id_plan_actividad: this.sug.corr.id_plan_actividad,
                        fi_actividad: this.sug.corr.fi_actividad,
                        ff_actividad:this.sug.corr.ff_actividad,
                        desc_actividad:this.sug.corr.desc_actividad,
                        objetivo_actividad:this.sug.corr.objetivo_actividad,
                    })
                        .then(response => {
                            $("#modaldesarrollosug").modal("hide");
                            this.popToast('Correciones Enviadas');
                            this.getAlumnos();
                        });
                },
                popToast(Mensaje) {
                    const h = this.$createElement;
                    const vNodesMsg = h(
                        'p',
                        { class: ['text-center', 'mb-0'] },
                        [
                            h('b-spinner', { props: { type: 'grow', small: true } }),
                            h('strong', {}, Mensaje),
                            h('b-spinner', { props: { type: 'grow', small: true } })
                        ]
                    );
                    this.$bvToast.toast([vNodesMsg], {
                        solid: true,
                        variant: 'success',
                        toaster:'b-toaster-top-full',
                        noCloseButton: true,
                        noHoverPause:false,
                        autoHideDelay:'2000',
                    });
                },
            },
        }).catch(error=>{ });
    </script>
@endsection
