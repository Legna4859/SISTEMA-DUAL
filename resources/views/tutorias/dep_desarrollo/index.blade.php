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
                        <a href="{{url('/tutorias/planeaciondesarrollo')}}" class="font-weight-bold h6 pb-1">GENERACIONES</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row"><div class="col-12 text-center">PLANEACIÓN @{{ gen }}</div></div>
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
                                                    <template slot="Revisar" scope="alumno">
                                                        <div class="text-center" v-if="alumno.entry.id_estado==1">
                                                            <a>Actividad Aprobada</a>
                                                        </div>
                                                        <div class="text-center" v-else-if="alumno.entry.id_estado==2" class="text-center">
                                                            <button class="btn btn-outline-primary m-1"
                                                                    @click="des_ver(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Revisar Actividad"><i class="far fa-edit"></i>
                                                            </button>
                                                        </div>
                                                        <div class="text-center" v-else-if="alumno.entry.id_estado==3">
                                                            <button class="btn btn-outline-dark m-1"
                                                                    @click="ver_corr(alumno.entry)" data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title="Actividad con Cambios"><i class="far fa-edit"></i>
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
            @include('tutorias.dep_desarrollo.modalveractividades')
            @include('tutorias.dep_desarrollo.modalsugerencia')
            @include('tutorias.dep_desarrollo.modalvercorrecion')
            @include('tutorias.dep_desarrollo.modalsugerencia2')
        </div>
    </div>
    <script type="text/javascript">
        Vue.use(DataTable);
        new Vue({
            el: "#ind",
            created: function () {
                this.menugrupos = true;
                this.getTut();
            },
            data: {
                gridColumns: ['Fecha Inicio', 'Fecha Fin', 'Nombre Actividad', 'Revisar'],
                rut: "/tutorias/actividades",
                ver_des:'/tutorias/desver',
                apruebades:'/tutorias/apruebadesarrollo',
                sendsug:'/tutorias/enviasug',
                sendsug2:'/tutorias/enviasug2',
                vercorr:'/tutorias/vercorrecion',
                apcorr:'/tutorias/apc',
                generacion: "/tutorias/generacion",
                datos: [],
                grupos: [],
                actividad: {
                    des: {
                        id_plan_actividad: "",
                        desc_actividad: "",
                        objetivo_actividad: "",
                        fi_acti: "",
                        ff_acti: "",
                    },
                },
                act:{
                    coor_c:{
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
                des_ver: function (alumno) {
                    axios.post(this.ver_des, {id: alumno.id_plan_actividad}).then(response => {
                        this.actividad.des.id_plan_actividad = response.data.des[0].id_plan_actividad;
                        this.actividad.des.desc_actividad = response.data.des[0].desc_actividad;
                        this.actividad.des.objetivo_actividad = response.data.des[0].objetivo_actividad;
                        this.actividad.des.fi_actividad = response.data.des[0].fi_actividad;
                        this.actividad.des.ff_actividad = response.data.des[0].ff_actividad;
                        $("#modalveractividades").modal("show");
                    });
                },
                aprobaract: function (alumno) {
                    axios.post(this.apruebades,  { id_plan_actividad: this.actividad.des.id_plan_actividad })
                        .then(response => {
                            $("#modalveractividades").modal("hide");
                            this.popToast('Actividad Aprobada');
                            this.getAlumnos();
                        });
                },
                sugdes: function(){
                    $("#modalveractividades").modal("hide");
                    $("#modalsugerencia").modal("show");
                },
                envsuge: function(){
                    axios.post(this.sendsug,  { id_plan_actividad: this.actividad.des.id_plan_actividad,
                        comentario: this.comentario })
                        .then(response => {
                            this.comentario="";
                            $("#modalsugerencia").modal("hide");
                            this.popToast('Sugerencias Enviadas');
                            this.getAlumnos();
                        });
                },
                ver_corr: function(alumno){
                    axios.post(this.vercorr, {id: alumno.id_plan_actividad}).then(response => {
                        this.act.coor_c.id_plan_actividad = response.data.coor_c[0].id_plan_actividad;
                        this.act.coor_c.desc_actividad = response.data.coor_c[0].desc_actividad;
                        this.act.coor_c.objetivo_actividad = response.data.coor_c[0].objetivo_actividad;
                        this.act.coor_c.fi_actividad = response.data.coor_c[0].fi_actividad;
                        this.act.coor_c.ff_actividad = response.data.coor_c[0].ff_actividad;
                        this.act.coor_c.comentario = response.data.coor_c[0].comentario;
                        $("#modalvercorrecion").modal("show");
                    });
                },
                apruebac: function(){
                    axios.post(this.apcorr,  { id_plan_actividad: this.act.coor_c.id_plan_actividad })
                        .then(response => {
                            $("#modalvercorrecion").modal("hide");
                            this.popToast('Actividad Aprobada');
                            this.getAlumnos();
                        });
                },
                sugdes2: function(){
                    $("#modalvercorrecion").modal("hide");
                    $("#modalsugerencia2").modal("show");
                },
                envsuge2: function(){
                    axios.post(this.sendsug2,  { id_plan_actividad: this.act.coor_c.id_plan_actividad,
                        comentario: this.comentario })
                        .then(response => {
                            $("#modalsugerencia2").modal("hide");
                            this.comentario="";
                            this.popToast('Sugerencias Enviadas');
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