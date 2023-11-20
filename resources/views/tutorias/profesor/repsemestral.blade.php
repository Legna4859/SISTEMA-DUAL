@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="ind">
        <div class="row" v-show="menugrupos==true">
            <div class="col-12">
                <div align="center">
                    <h3>Reporte Semestral</h3>
                </div>
                <div class="row">
                    <div class="col-3 pt-4" v-for="grupo in grupos">
                        <div class="card">
                            <div class="card-header text-center font-weight-bold"> @{{ grupo.nombre }}</div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Generación @{{ grupo.generacion }}</h5>
                                <p class="card-text">Grupo @{{ grupo.grupo }}</p>
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
                         <div class="col-12 pb-3">
                            <i class="fas fa-chevron-left h5"></i>
                            <a href="{{url('/tutorias/repsemestral')}}" class="font-weight-bold h6 pb-1">{{\Illuminate\Support\Facades\Session::get('tutor')>1?'Regresar':'Regresar'}}</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-9 text-center font-weight-bold">@{{ carrera }}</div>
                                    </div>
                                    <div class="row"><div class="col-9 text-center">@{{ gen }}</div></div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row pb-3">
                                                <div class="col-6">
                                                    <form id="search">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="inputGroupPrepend3"><i class="fas fa-search"></i></span>
                                                            </div>
                                                            <input class="form-control" name="query" v-model="searchQuery" placeholder="Buscar">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-1 offset-5">
                                                    <button @click="pdf()" target="_blank" class="btn btn-danger text-white float-right" data-toggle="tooltip" data-placement="bottom" title="Generar Reporte">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tableFixHeadLista">
                                                <data-table class=" col-12 table table-sm" :data="datos" :columns-to-display="gridColumns" :filter-key="searchQuery">
                                                    <template slot="Cuenta" scope="alumno">
                                                        <div class="text-center">
                                                             @{{ alumno.entry.cuenta }}
                                                        </div>
                                                    </template>
                                                    <template slot="Nombre" scope="alumno">
                                                        <div class="text-center">@{{ alumno.entry.apaterno }} @{{ alumno.entry.amaterno}} @{{ alumno.entry.nombre }}</div>
                                                    </template>
                                                    <template slot="Reporte" scope="alumno">
                                                        <div class="text-center" v-if="alumno.entry.conteo==true">
                                                            {{--
                                                            <button class="btn btn-outline-dark"
                                                                    @click="reporte(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Agregar al reporte">+</button>
                                                         --}}
                                                        </div>
                                                        <div class="text-center" v-else>

                                                            <button class="btn btn-outline-success"
                                                                    @click="reporte(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Agregar al reporte">+</button>

                                                        </div>
                                                    </template>
                                                    <template slot="Actualizar" scope="alumno">
                                                        <div class="text-center" v-if="alumno.entry.conteo==true">
                                                        <div class="text-center">
                                                            <button class="btn btn-outline-primary"
                                                            @click="reporteactualiza(alumno.entry)" data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title="Editar datos"><i class="fas fa-edit"></i>
                                                            </button>
                                                        </div>
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
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('tutorias.profesor.modalreportesemestral')
        @include('tutorias.profesor.modalreportesemactualiza')
    </div>
    <script type="text/javascript">
        Vue.use(DataTable);
        new Vue({
            el: "#ind",
            created: function () {
                this.getTut();
            },
            data: {
                searchQuery: '',
                gridColumns: ['Cuenta', 'Nombre','Reporte','Actualizar'],
                ruts: "/tutorias/reportealum",
                grup: "/tutorias/grupos",
                vereporte: "/tutorias/verepo",
                envdatos: "/tutorias/sendreporte",
                vereporteact: "/tutorias/updatereporte",
                envdatosactualiza: "/tutorias/envirepactu",
                pdfrep: "/tutorias/pdf/pdfreportegen",
                datos: [],
                grupos: [],
                menugrupos: true,
                report:{
                      ver:{
                        id_asigna_generacion:"",
                        nombre:"",
                        apaterno:"",
                        amaterno:"",
                        cuenta:"",
                        beca:"",
                        materias_repeticion:"",
                        materias_especial:"",
                        estado:"",
                      },
                },
                actual:{
                    otro:{
                        id_asigna_generacion:"",
                        cuenta:"",
                        tutoria_grupal:"",
                        tutoria_individual:"",
                        beca:"",
                        materias_repeticion:"",
                        materias_especial:"",
                        academico:"",
                        medico:"",
                        psicologico:"",
                        estado:"",
                        observaciones:"",
                    },
                },
            },
            methods: {
                getTut: function () {
                    axios.get(this.grup).then(response => {
                        this.grupos = response.data;
                    }).catch(error => {
                    });
                },
                getlista: function (grupo) {
                    this.idca = grupo.id_carrera;
                    this.idasigna = grupo.id_asigna_generacion;
                    this.carrera = grupo.nombre;
                    this.gen = " GENERACIÓN " + grupo.generacion + " GRUPO " + grupo.grupo;
                    this.gene = " GENERACIÓN " + grupo.generacion;
                    this.getAlumnos();
                },
                getAlumnos: function () {
                    axios.post(this.ruts, {
                        id_asigna_generacion: this.idasigna,
                        id_carrera: this.idca
                    }).then(response => {
                        this.menugrupos = false;
                        this.menu = true;
                        this.lista = true;
                        this.datos = response.data;
                        this.nuevos = response.data;
                    }).catch(error => {
                    });
                },
                reporte:function(alumno){
                    axios.post(this.vereporte, {id_alu: alumno.id_alumno,
                                                id:alumno.id_asigna_generacion}).then(response => {
                        this.report.ver.id_asigna_generacion = response.data.ver[0].id_asigna_generacion;
                        this.report.ver.nombre = response.data.ver[0].nombre;
                        this.report.ver.apaterno = response.data.ver[0].apaterno;
                        this.report.ver.amaterno = response.data.ver[0].amaterno;
                        this.report.ver.cuenta = response.data.ver[0].cuenta;
                        this.report.ver.beca = response.data.ver[0].beca;
                        this.report.ver.materias_repeticion = response.data.ver[0].materias_repeticion;
                        this.report.ver.materias_especial = response.data.ver[0].materias_especial;
                        this.report.ver.estado = response.data.ver[0].estado;
                        $("#modalreportesemestral").modal("show");
                    });
                },
                enviadatos:function(){
                    axios.post(this.envdatos,  {
                                    id_asigna_generacion: this.report.ver.id_asigna_generacion,
                                    nombre:this.report.ver.nombre,
                                    apaterno:this.report.ver.apaterno,
                                    amaterno:this.report.ver.amaterno,
                                    cuenta:this.report.ver.cuenta,
                                    beca:this.report.ver.beca,
                                    materias_repeticion:this.report.ver.materias_repeticion,
                                    materias_especial:this.report.ver.materias_especial,
                                    estado:this.report.ver.estado,
                                    tutoria_grupal:this.tutoria_grupal,
                                    tutoria_individual:this.tutoria_individual,
                                    academico:this.academico,
                                    medico:this.medico,
                                    psicologico:this.psicologico,
                                    observaciones:this.observaciones,
                                    })
                    .then(response => {
                        $("#modalreportesemestral").modal("hide");
                        this.tutoria_grupal="";
                        this.tutoria_individual="";
                        this.academico="";
                        this.medico="";
                        this.psicologico="";
                        this.observaciones="";
                        this.popToast('Datos Agregados al reporte');
                        this.getAlumnos();
                    });
                },
                reporteactualiza:function(alumno){
                    axios.post(this.vereporteact, {id_alu: alumno.id_alumno,
                                                id:alumno.id_asigna_generacion}).then(response => {
                        this.actual.otro.id_asigna_generacion = response.data.otro[0].id_asigna_generacion;
                        this.actual.otro.cuenta = response.data.otro[0].cuenta;
                        this.actual.otro.tutoria_grupal = response.data.otro[0].tutoria_grupal;
                        this.actual.otro.tutoria_individual = response.data.otro[0].tutoria_individual;
                        this.actual.otro.beca = response.data.otro[0].beca;
                        this.actual.otro.materias_repeticion = response.data.otro[0].materias_repeticion;
                        this.actual.otro.materias_especial = response.data.otro[0].materias_especial;
                        this.actual.otro.academico = response.data.otro[0].academico;
                        this.actual.otro.medico = response.data.otro[0].medico;
                        this.actual.otro.psicologico = response.data.otro[0].psicologico;
                        this.actual.otro.estado = response.data.otro[0].estado;
                        this.actual.otro.observaciones = response.data.otro[0].observaciones;
                        $("#modalreportesemactualiza").modal("show");
                    });
                },
                enviactualizar:function(){
                    axios.post(this.envdatosactualiza,  {
                                    id_asigna_generacion: this.actual.otro.id_asigna_generacion,
                                    cuenta:this.actual.otro.cuenta,
                                    tutoria_grupal:this.actual.otro.tutoria_grupal,
                                    tutoria_individual:this.actual.otro.tutoria_individual,
                                    beca:this.actual.otro.beca,
                                    materias_repeticion:this.actual.otro.materias_repeticion,
                                    materias_especial:this.actual.otro.materias_especial,
                                    academico:this.actual.otro.academico,
                                    medico:this.actual.otro.medico,
                                    psicologico:this.actual.otro.psicologico,
                                    estado:this.actual.otro.estado,
                                    observaciones:this.actual.otro.observaciones,
                                    })
                    .then(response => {
                        $("#modalreportesemactualiza").modal("hide");
                        this.popToast('Datos Actualizados');
                        this.getAlumnos();
                    });
                },
                pdf: function () {
                    axios.post(this.pdfrep, {id_asigna_generacion: this.idasigna,
                                             id_carrera:this.idca}, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/pdf'
                        },
                        responseType: "blob"
                    }).then(response => {
                        console.log(response.data);
                        const blob = new Blob([response.data], {type: 'application/pdf'});
                        const objectUrl = URL.createObjectURL(blob);
                        window.open(objectUrl)
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
        });
    </script>
@endsection