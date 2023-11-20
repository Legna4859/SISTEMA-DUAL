@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="ind">
        <div class="row" v-show="menugrupos==true">
            <div class="col-12">
                <div align="center">
                    <h3>Probabilidad de Deserción</h3>
                </div>
                <div class="row">
                    <div class="col-3" v-for="grupo in grupos">
                        <div class="card">
                            <div class="card-header text-center font-weight-bold"> @{{ grupo.nombre }}</div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Generación @{{ grupo.generacion }}</h5>
                                <p class="card-text">Grupo @{{ grupo.grupo }}</p>
                                <a href="#?" @click="getlista(grupo)" class="btn btn-outline-primary">Ver</a>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-show="menu==true">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 pb-3">
                        <i class="fas fa-chevron-left h5"></i>
                        <a href="{{url('/tutorias/desercion')}}" class="font-weight-bold h6 pb-1">{{\Illuminate\Support\Facades\Session::get('tutor')>1?'Regresar':'Regresar'}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-header">
                                    <div align="center">
                                        <div class="col-9 text-center font-weight-bold">@{{ carrera }}</div>
                                    </div>
                                    <div align="center"><div class="col-9 text-center">@{{ gen }}</div></div>
                                </div>
                                <div class="card-body" v-if="(lista==true && datos.length>0)">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tableFixHeadLista">
                                                <data-table class=" col-12 table table-sm" :data="datos" :columns-to-display="gridColumns" :filter-key="searchQuery">
                                                    <template slot="Cuenta" scope="alumno">
                                                        <div class="pt-2">@{{ alumno.entry.no_cuenta }}</div>
                                                    </template>
                                                    <template slot="Nombre" scope="alumno">
                                                        <div class="pt-2">@{{ alumno.entry.ap }} @{{ alumno.entry.am }} @{{ alumno.entry.nom }}</div>
                                                    </template>
                                                    <template slot="No.hijos" scope="alumno">
                                                        <div class="pt-2">@{{ alumno.entry.no_hijos-1 }}</div>
                                                    </template>
                                                    <template slot="Trabaja" scope="alumno">
                                                        <div v-if="alumno.entry.trabaja == 1">
                                                            <div class="pt-2">Si</div>
                                                        </div>
                                                        <div v-else>
                                                            <div class="pt-2">No</div>
                                                        </div>
                                                    </template>
                                                    <template slot="Alcoholismo" scope="alumno">
                                                        <div v-if="alumno.entry.id_expbebidas == 1">
                                                            <div class="pt-2">Nunca</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.id_expbebidas == 2">
                                                            <div class="pt-2">Rara vez</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.id_expbebidas == 3">
                                                            <div class="pt-2">A veces</div>
                                                        </div>
                                                        <div v-else>
                                                            <div class="pt-2">Frecuentemente</div>
                                                        </div>
                                                    </template>
                                                    <template slot="No.Repeticiones" scope="alumno">
                                                        <div v-if="alumno.entry.tot_repe == NULL">
                                                            <div class="pt-2">0</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.tot_repe == 1">
                                                            <div class="pt-2">0</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.tot_repe == 2">
                                                            <div class="pt-2">1</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.tot_repe == 3">
                                                            <div class="pt-2">2</div>
                                                        </div>
                                                        <div v-else>
                                                            <div class="pt-2">3 o más</div>
                                                        </div>
                                                    </template>
                                                    <template slot="No.Especiales" scope="alumno">
                                                        <div v-if="alumno.entry.tot_espe == NULL">
                                                            <div class="pt-2">0</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.tot_espe == 1">
                                                            <div class="pt-2">0</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.tot_espe == 2">
                                                            <div class="pt-2">1</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.tot_espe == 3">
                                                            <div class="pt-2">2</div>
                                                        </div>
                                                        <div v-else>
                                                            <div class="pt-2">3 o más</div>
                                                        </div>
                                                    </template>
                                                    <template slot="Total Especiales" scope="alumno">
                                                        <div v-if="alumno.entry.gen_espe == NULL">
                                                            <div class="pt-2">0</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.gen_espe == 1">
                                                            <div class="pt-2">0</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.gen_espe == 2">
                                                            <div class="pt-2">1</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.gen_espe == 3">
                                                            <div class="pt-2">2</div>
                                                        </div>
                                                        <div v-else>
                                                            <div class="pt-2">3 o más</div>
                                                        </div>
                                                    </template>
                                                    <template slot="Probabilidad" scope="alumno">
                                                        <div v-if="alumno.entry.id_carrera_v+alumno.entry.sexo_v+alumno.entry.id_estado_civil_v+
                                                        alumno.entry.no_hijos_v+alumno.entry.no_hermanos_v+alumno.entry.enfermedad_cronica_v+
                                                        alumno.entry.trabaja_v+alumno.entry.practica_deporte_v+alumno.entry.actividades_culturales_v+
                                                        alumno.entry.etnia_indigena_v+alumno.entry.lugar_nacimientos_v+alumno.entry.nivel_economico_v+
                                                        alumno.entry.sostiene_economia_hogar_v+alumno.entry.tegusta_carrera_elegida_v+
                                                        alumno.entry.beca_v+alumno.entry.estado_v+alumno.entry.id_expbebidas_v+
                                                        alumno.entry.poblacion_v+alumno.entry.ant_inst_v+alumno.entry.satisfaccion_c_v+
                                                        alumno.entry.materias_repeticion_v+alumno.entry.tot_repe_v+ alumno.entry.materias_especial_v+
                                                        alumno.entry.tot_espe_v+alumno.entry.gen_espe_v >= 70.0">
                                                            <div class="pt-2" style="background: #e02224;color: black">@{{ alumno.entry.id_carrera_v+alumno.entry.sexo_v+alumno.entry.id_estado_civil_v+
                                                                alumno.entry.no_hijos_v+alumno.entry.no_hermanos_v+alumno.entry.enfermedad_cronica_v+
                                                                alumno.entry.trabaja_v+alumno.entry.practica_deporte_v+alumno.entry.actividades_culturales_v+
                                                                alumno.entry.etnia_indigena_v+alumno.entry.lugar_nacimientos_v+alumno.entry.nivel_economico_v+
                                                                alumno.entry.sostiene_economia_hogar_v+alumno.entry.tegusta_carrera_elegida_v+
                                                                alumno.entry.beca_v+alumno.entry.estado_v+alumno.entry.id_expbebidas_v+
                                                                alumno.entry.poblacion_v+alumno.entry.ant_inst_v+alumno.entry.satisfaccion_c_v+
                                                                alumno.entry.materias_repeticion_v+alumno.entry.tot_repe_v+ alumno.entry.materias_especial_v+
                                                                alumno.entry.tot_espe_v+alumno.entry.gen_espe_v}}</div>
                                                        </div>
                                                        <div v-else-if="alumno.entry.id_carrera_v+alumno.entry.sexo_v+alumno.entry.id_estado_civil_v+
                                                        alumno.entry.no_hijos_v+alumno.entry.no_hermanos_v+alumno.entry.enfermedad_cronica_v+
                                                        alumno.entry.trabaja_v+alumno.entry.practica_deporte_v+alumno.entry.actividades_culturales_v+
                                                        alumno.entry.etnia_indigena_v+alumno.entry.lugar_nacimientos_v+alumno.entry.nivel_economico_v+
                                                        alumno.entry.sostiene_economia_hogar_v+alumno.entry.tegusta_carrera_elegida_v+
                                                        alumno.entry.beca_v+alumno.entry.estado_v+alumno.entry.id_expbebidas_v+
                                                        alumno.entry.poblacion_v+alumno.entry.ant_inst_v+alumno.entry.satisfaccion_c_v+
                                                        alumno.entry.materias_repeticion_v+alumno.entry.tot_repe_v+ alumno.entry.materias_especial_v+
                                                        alumno.entry.tot_espe_v+alumno.entry.gen_espe_v >= 60.0">
                                                            <div class="pt-2" style="background: #e9c423">@{{ alumno.entry.id_carrera_v+alumno.entry.sexo_v+alumno.entry.id_estado_civil_v+
                                                                alumno.entry.no_hijos_v+alumno.entry.no_hermanos_v+alumno.entry.enfermedad_cronica_v+
                                                                alumno.entry.trabaja_v+alumno.entry.practica_deporte_v+alumno.entry.actividades_culturales_v+
                                                                alumno.entry.etnia_indigena_v+alumno.entry.lugar_nacimientos_v+alumno.entry.nivel_economico_v+
                                                                alumno.entry.sostiene_economia_hogar_v+alumno.entry.tegusta_carrera_elegida_v+
                                                                alumno.entry.beca_v+alumno.entry.estado_v+alumno.entry.id_expbebidas_v+
                                                                alumno.entry.poblacion_v+alumno.entry.ant_inst_v+alumno.entry.satisfaccion_c_v+
                                                                alumno.entry.materias_repeticion_v+alumno.entry.tot_repe_v+ alumno.entry.materias_especial_v+
                                                                alumno.entry.tot_espe_v+alumno.entry.gen_espe_v}}</div>
                                                        </div>
                                                        <div v-else="alumno.entry.id_carrera_v+alumno.entry.sexo_v+alumno.entry.id_estado_civil_v+
                                                        alumno.entry.no_hijos_v+alumno.entry.no_hermanos_v+alumno.entry.enfermedad_cronica_v+
                                                        alumno.entry.trabaja_v+alumno.entry.practica_deporte_v+alumno.entry.actividades_culturales_v+
                                                        alumno.entry.etnia_indigena_v+alumno.entry.lugar_nacimientos_v+alumno.entry.nivel_economico_v+
                                                        alumno.entry.sostiene_economia_hogar_v+alumno.entry.tegusta_carrera_elegida_v+
                                                        alumno.entry.beca_v+alumno.entry.estado_v+alumno.entry.id_expbebidas_v+
                                                        alumno.entry.poblacion_v+alumno.entry.ant_inst_v+alumno.entry.satisfaccion_c_v+
                                                        alumno.entry.materias_repeticion_v+alumno.entry.tot_repe_v+ alumno.entry.materias_especial_v+
                                                        alumno.entry.tot_espe_v+alumno.entry.gen_espe_v">
                                                            <div class="pt-2" style="background: #5bc013">@{{ alumno.entry.id_carrera_v+alumno.entry.sexo_v+alumno.entry.id_estado_civil_v+
                                                                alumno.entry.no_hijos_v+alumno.entry.no_hermanos_v+alumno.entry.enfermedad_cronica_v+
                                                                alumno.entry.trabaja_v+alumno.entry.practica_deporte_v+alumno.entry.actividades_culturales_v+
                                                                alumno.entry.etnia_indigena_v+alumno.entry.lugar_nacimientos_v+alumno.entry.nivel_economico_v+
                                                                alumno.entry.sostiene_economia_hogar_v+alumno.entry.tegusta_carrera_elegida_v+
                                                                alumno.entry.beca_v+alumno.entry.estado_v+alumno.entry.id_expbebidas_v+
                                                                alumno.entry.poblacion_v+alumno.entry.ant_inst_v+alumno.entry.satisfaccion_c_v+
                                                                alumno.entry.materias_repeticion_v+alumno.entry.tot_repe_v+ alumno.entry.materias_especial_v+
                                                                alumno.entry.tot_espe_v+alumno.entry.gen_espe_v}}</div>
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
                                        <h5 class="font-weight-bold">Los estudiantes no han completado su expediente</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        Vue.use(DataTable);
        new Vue({
            el: "#ind",
            created: function () {
                this.lista = false;
                this.menugrupos = true;
                this.menu = false;
                this.getTut();
            },
            data: {
                searchQuery: '',
                gridColumns: ['Cuenta', 'Nombre', 'No.hijos', 'Trabaja', 'Alcoholismo','No.Repeticiones','No.Especiales','Total Especiales','Probabilidad'],
                rut: "/tutorias/probabilidad",
                grup: "/tutorias/grupos",
                veralu: "/tutorias/ver",
                datos: [],
                grupos: [],
                alumnog: [],
                vista: [],
                periodos: [],
                semestres: [],
                carreras: [],
                grupo: [],
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
                    axios.post(this.rut, {
                        id_asigna_generacion: this.idasigna,
                        id_carrera: this.idca
                    }).then(response => {
                        this.menugrupos = false;
                        this.menu = true;
                        this.lista = true;
                        this.plan = false;
                        this.listacanaliza = false;
                        this.graficas = false;
                        this.datos = response.data;
                        this.nuevos = response.data;
                    }).catch(error => {
                    });
                },
            },
        });
    </script>
@endsection