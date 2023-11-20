@extends('layouts.app')
@section('content')
    <div class="container" id="ind">
        <div class="row" v-if="menu" >
            <div class="col-12">
                <div class="row">
                    <div class="col-3" v-for="carrera in carreras">
                        <div class="card">
                            <div class="card-header text-center font-weight-bold"> @{{ carrera.nombre }}</div>
                            <div class="card-body text-center">
                                <a href="#" @click="getGeneracion(carrera)" class="btn btn-outline-primary">Ver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="menucarrera" >
            <div class="row">
                <div class="col-12 pb-3">
                    <i class="fas fa-chevron-right h5"></i>
                    <a href="{{url('/revision')}}" class="font-weight-bold h6 pb-1">{{\Illuminate\Support\Facades\Session::get('coordinador')>1?'CARRERAS':'CARRERAS'}}</a>
                    <i class="fas fa-chevron-right h5"></i>
                    <a class="text-primary h6" v-if="menucarrera==true">PRINCIPAL</a>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">@{{ nombrecarrera }}</div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="generacion-tab" data-toggle="tab" href="#generacion" role="tab"  aria-controls="generacion" aria-selected="false">Generacion</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row p-3">
                                    <div class="col-12">
                                        <div class="row">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade pt-4" id="generacion" role="tabpanel" aria-labelledby="generacion-tab">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" v-for="gen in generaciones">
                                        <a class="nav-link border m-1" @click="borrarAlumno(gen.generacion)" :id="'pills-'+gen.generacion+'-tab'" data-toggle="pill" :href="'#pills-'+gen.generacion" role="tab" :aria-controls="'pills-'+gen.generacion" aria-selected="true">@{{ gen.generacion }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade " v-for="gen in generaciones" :id="'pills-'+gen.generacion" role="tabpanel" :aria-labelledby="'pills-'+gen.generacion+'-tab'">
                                        <ul class="nav nav-pills mb-3" id="grupo-tab" role="tablist">
                                            <li class="nav-item btn-group" v-for="grupo in gen.grupos">
                                                <a class="nav-link border m-1 "  @click="getAlumnosGrupo(grupo.id_asigna_generacion)" :id="'pills-'+grupo.id_asigna_generacion+'-tab'" data-toggle="pill" :href="'#pills-'+grupo.id_asigna_generacion" role="tab" :aria-controls="'pills-'+grupo.id_asigna_generacion">Grupo @{{ grupo.grupo }}</a>
                                          </li>
                                        </ul>
                                        <div class="tab-content" id="grupo-tabContent" v-if="alumno.length>0">
                                            <div class="row p-3">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 pb-3" v-if="(alumno.length>0)">
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
                                                    <div class="tableFixHead">
                                                        <data-table class=" col-12 table table-sm" :data="alumno" :columns-to-display="gridColumns1" :filter-key="searchQuery">
                                                            <template slot="Fecha Inicio" scope="alumno">
                                                                <div class="text-center">@{{ alumno.entry.fi_actividad }}</div>
                                                            </template>
                                                            <template slot="Fecha Fin" scope="alumno">
                                                                <div class="text-center">@{{ alumno.entry.ff_actividad }}</div>
                                                            </template>
                                                            <template  slot="Decripción Actividad" scope="alumno">
                                                                <div class="text-center">@{{ alumno.entry.desc_actividad }}</div>
                                                            </template>
                                                            <template slot="Objetivo" scope="alumno">
                                                                <div class="text-center">@{{ alumno.entry.objetivo_actividad }}</div>
                                                            </template>
                                                            <template slot="Sugerencia" scope="alumno">
                                                                <div class="text-center" v-if="alumno.entry.id_sugerencia==2">
                                                                    <button class="btn btn-outline-primary m-1" @click="versugerencia(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Ver Sugerencia"><i class="far fa-eye"></i></button>
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
                                        <div class="row" v-if="alumno.length==0 && clicgrupo==true">
                                            <div class="col-12 border-danger">
                                                <h5 class="font-weight-bold text-center alert alert-danger">No existen actividades asignadas a la planeacion</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('dep_desarrollo.modalcorrecion')
        </div>

    </div>

    <script>
        new Vue({
            el:"#ind",
            created:function(){
                this.getCarreras();
            },
            data:{
                searchQuery: '',
                gridColumns: ['Cuenta','Nombre','Revalidación'],
                gridColumns1: ['Fecha Inicio', 'Fecha Fin', 'Decripción Actividad', 'Objetivo', 'Sugerencia'],
                rut:"/tutorias/carrerasinst",
                gen:'/tutorias/generacionca',
                alugrupo:'/tutorias/alumnosgrupo',
                plan:'/tutorias/planeacioninst',
                alugeneracion:'/tutorias/alumnosgeneracion',
                versuge: '/tutorias/versuge',
                actsuge: '/tutorias/actualizasuge',
                carreras:[],
                alumno:[],
                datos1:[],

                menu:true,
                menucarrera:false,
                generaciones:[],
                nombrecarrera:null,
                clicgrupo:false,
                id_asigna:null,
                generacion:null,
                id_carrera: null,
                suge: {
                    sugerencia: {
                        id_asigna_planeacion_tutor: "",
                        id_sugerencia: 2,
                        desc_actividad_cambio: "",
                        objetivo_actividad_cambio : "",
                    },
                    actividad: {
                        fi_actividad: "",
                        ff_actividad: "",
                        desc_actividad: "",
                        objetivo_actividad : "",
                    },
                    cadena: null
                },
                titulosGrafica:['General','Mujeres','Hombres'],
                general:[
                    ['ecg','ecf','ecm'],['neg','nef','nem'],['trag','traf','tram'],
                    ['eag','eaf','eam'],['bg','bf','bm'],['tbg','tbf','tbm'],['hg','hf','hm']
                ],
                academic:[['gg','gf','gm'],['esg','esf','esm'],['og','of','om'],['bag','baf','bam']],
                famili:[['vg','vf','vm'],['etg','etf','etm'],['hag','haf','ham'],['ug','uf','um']],
                habito:[['tg','tf','tm']],
                integra:[['pdg','pdf','pdm'],['ag','af','am'],['csg','csf','csm'],['enfcg','enfcf','enfcm'],['penfcg','penfcf','penfcm'],
                    ['opeg','opef','opem'],['visg','visf','vism'],['lg','lf','lm'],['meg','mef','mem']],
                areap:[['trg','trf','trm'],['reng','renf','renm'],['comg','comf','comm'],['retg','retf','retm'],['exag','exaf','exam'],
                    ['cong','conf','conm'],['bbg','bbf','bbm'],['oig','oif','oim'],['matg','matf','matm']],
                alumnog:[],
                eg:[],
                ea:[],
                ef:[],
                eh:[],
                es:[],
                eas:[],
                academico:'graphics/academico',
                rutgen:"/graphics/genero",
                generales:"/graphics/generales",
                familiares:"/graphics/familiares",
                habitos:"/graphics/habitos",
                salud:"/graphics/salud",
                area:"/graphics/area",
                gengen:'/grafgeneracion/genero',
                grafgen:'/grafgeneracion/generales',
                grafaca:'/grafgeneracion/academico',
                graffam:'/grafgeneracion/familiares',
                grafhab:'/grafgeneracion/habitos',
                grafsal:'/grafgeneracion/salud',
                grafare:'/grafgeneracion/area',
                grafcagene:'/grafcarrera/genero',
                grafcagen:'/grafcarrera/generales',
                grafcaaca:'/grafcarrera/academico',
                grafcafam:'/grafcarrera/familiares',
                grafcahab:'/grafcarrera/habitos',
                grafcasal:'/grafcarrera/salud',
                grafcaare:'/grafcarrera/area',
                rep:"pdf/reporte",
                direcciones_img:[],
                arreglo_graficas:['genero','hf','hm','etg','etf','etm','enfcg','enfcf','enfcm','eag','eaf','eam','bf','bm'],

            },
            methods:{
                getCarreras:function(){
                    axios.get(this.rut).then(response=>{
                        this.carreras=response.data;
                    }).catch(error=>{ });
                },
                getGeneracion:function (carrera) {
                    this.menu=false;
                    this.menucarrera=true;
                    this.nombrecarrera=carrera.nombre;
                    this.id_carrera=carrera.id_carrera;
                    axios.post(this.gen,{id_carrera:carrera.id_carrera}).then(response=>{
                        this.generaciones=response.data;
                    }).catch(error=>{ });
                },
                getAlumnosGrupo:function (grupo) {

                    this.clicgrupo=true;
                    this.id_asigna=grupo;
                    axios.post(this.plan,{generacion:grupo}).then(response=>{
                        this.alumno=response.data;
                    }).catch(error=>{ });
                },
                getAlumnosGeneracion:function(genera)
                {
                    this.clicgrupo=false;
                    this.generacion=genera;
                    axios.post(this.alugeneracion,{generacion:genera}).then(response=>{
                        this.alumno=response.data;
                    }).catch(error=>{ });
                },
                getGraficas:function()
                {
                    if(this.clicgrupo==true)
                    {
                        axios.post(this.rutgen,{id_carrera:this.id_carrera,id_asigna_generacion:this.id_asigna}).then(response=>{
                            this.alumnog=response.data;
                            Highcharts.chart('genero', {
                                chart: {
                                    type: 'column'
                                },
                                exporting: {
                                    url: 'http://localhost',
                                },
                                navigation: {
                                    buttonOptions: {
                                        enabled: false
                                    }
                                },
                                credits: {
                                    enabled: false
                                },
                                title: {
                                    text: 'Alumnos por sexo'
                                },
                                accessibility: {
                                    announceNewData: {
                                        enabled: true
                                    }
                                },
                                xAxis: {
                                    type: 'category'
                                },
                                yAxis: {
                                    title: {
                                        text: 'Total'
                                    }
                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        borderWidth: 0,
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.y:.1f}%'
                                        }
                                    }
                                },
                                tooltip: {
                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                },
                                series: [
                                    {
                                        name: "Sexo",
                                        colorByPoint: true,
                                        data: this.alumnog
                                    }
                                ],
                            });
                        }).catch(error=>{ });
                        axios.post(this.generales,{id_carrera:this.id_carrera,id_asigna_generacion:this.id_asigna}).then(response=>{
                            this.eg=response.data;
                            for (let i in  this.eg)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.general[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.eg[i][z]
                                            }
                                        ],
                                    });
                                }
                            }
                        }).catch(error=>{ });
                        axios.post(this.academico,{id_carrera:this.id_carrera,id_asigna_generacion:this.id_asigna}).then(response=>{
                            this.ea=response.data;
                            for (let i in  this.ea)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.academic[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.ea[i][z]
                                            }
                                        ],
                                    });
                                }
                            }

                        }).catch(error=>{ });
                        axios.post(this.familiares,{id_carrera:this.id_carrera,id_asigna_generacion:this.id_asigna}).then(response=>{
                            this.ef=response.data;
                            for (let i in  this.ef)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.famili[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.ef[i][z]
                                            }
                                        ],
                                    });
                                }
                            }

                        }).catch(error=>{ });
                        axios.post(this.habitos,{id_carrera:this.id_carrera,id_asigna_generacion:this.id_asigna}).then(response=>{
                            this.eh=response.data;
                            for (let i in  this.eh)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.habito[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.eh[i][z]
                                            }
                                        ],
                                    });
                                }
                            }

                        }).catch(error=>{ });
                        axios.post(this.salud,{id_carrera:this.id_carrera,id_asigna_generacion:this.id_asigna}).then(response=>{
                            this.es=response.data;
                            for (let i in  this.es)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.integra[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.es[i][z]
                                            }
                                        ],
                                    });
                                }
                            }

                        }).catch(error=>{ });
                        axios.post(this.area,{id_carrera:this.id_carrera,id_asigna_generacion:this.id_asigna}).then(response=>{
                            this.eas=response.data;
                            for (let i in  this.eas)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.areap[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.eas[i][z]
                                            }
                                        ],
                                    });
                                }
                            }
                        }).catch(error=>{ });
                        $('#modalgraficas').modal('show');
                    } else if(this.clicgrupo==false)
                    {
                        axios.post(this.gengen,{id_carrera:this.id_carrera,generacion:this.generacion}).then(response=>{
                            this.alumnog=response.data;
                            Highcharts.chart('genero', {
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: 'Alumnos por sexo'
                                },
                                exporting: {
                                    url: 'http://localhost',
                                },
                                navigation: {
                                    buttonOptions: {
                                        enabled: false
                                    }
                                },
                                credits: {
                                    enabled: false
                                },
                                accessibility: {
                                    announceNewData: {
                                        enabled: true
                                    }
                                },
                                xAxis: {
                                    type: 'category'
                                },
                                yAxis: {
                                    title: {
                                        text: 'Total'
                                    }
                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        borderWidth: 0,
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.y:.1f}%'
                                        }
                                    }
                                },
                                tooltip: {
                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                },
                                series: [
                                    {
                                        name: "Sexo",
                                        colorByPoint: true,
                                        data: this.alumnog
                                    }
                                ],
                            });
                        }).catch(error=>{ });
                        axios.post(this.grafgen,{id_carrera:this.id_carrera,generacion:this.generacion}).then(response=>{
                            this.eg=response.data;
                            for (let i in  this.eg)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.general[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.eg[i][z]
                                            }
                                        ],
                                    });
                                }
                            }
                        }).catch(error=>{ });
                        axios.post(this.grafaca,{id_carrera:this.id_carrera,generacion:this.generacion}).then(response=>{
                            this.ea=response.data;
                            for (let i in  this.ea)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.academic[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.ea[i][z]
                                            }
                                        ],
                                    });
                                }
                            }

                        }).catch(error=>{ });
                        axios.post(this.graffam,{id_carrera:this.id_carrera,generacion:this.generacion}).then(response=>{
                            this.ef=response.data;
                            for (let i in  this.ef)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.famili[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.ef[i][z]
                                            }
                                        ],
                                    });
                                }
                            }

                        }).catch(error=>{ });
                        axios.post(this.grafhab,{id_carrera:this.id_carrera,generacion:this.generacion}).then(response=>{
                            this.eh=response.data;
                            for (let i in  this.eh)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.habito[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.eh[i][z]
                                            }
                                        ],
                                    });
                                }
                            }

                        }).catch(error=>{ });
                        axios.post(this.grafsal,{id_carrera:this.id_carrera,generacion:this.generacion}).then(response=>{
                            this.es=response.data;
                            for (let i in  this.es)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.integra[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.es[i][z]
                                            }
                                        ],
                                    });
                                }
                            }

                        }).catch(error=>{ });
                        axios.post(this.grafare,{id_carrera:this.id_carrera,generacion:this.generacion}).then(response=>{
                            this.eas=response.data;
                            for (let i in  this.eas)
                            {
                                for (let z in this.titulosGrafica)
                                {
                                    Highcharts.chart(this.areap[i][z], {
                                        chart: {
                                            type: 'column'
                                        },
                                        exporting: {
                                            url: 'http://localhost',
                                        },
                                        navigation: {
                                            buttonOptions: {
                                                enabled: false
                                            }
                                        },
                                        credits: {
                                            enabled: false
                                        },
                                        title: {
                                            text: this.titulosGrafica[z]
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                        },
                                        series: [
                                            {
                                                name: this.titulosGrafica[z],
                                                colorByPoint: true,
                                                data: this.eas[i][z]
                                            }
                                        ],
                                    });
                                }
                            }
                        }).catch(error=>{ });
                        $('#modalgraficas').modal('show');
                    }

                },
                getGraficasCarrera:function ()
                {
                    axios.post(this.grafcagene,{id_carrera:this.id_carrera}).then(response=>{
                        this.alumnog=response.data;
                        Highcharts.chart('genero', {
                            chart: {
                                type: 'column'
                            },
                            exporting: {
                                url: 'http://localhost',
                            },
                            navigation: {
                                buttonOptions: {
                                    enabled: false
                                }
                            },
                            credits: {
                                enabled: false
                            },
                            title: {
                                text: 'Alumnos por sexo'
                            },
                            accessibility: {
                                announceNewData: {
                                    enabled: true
                                }
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: {
                                    text: 'Total'
                                }
                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.y:.1f}%'
                                    }
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                            },
                            series: [
                                {
                                    name: "Sexo",
                                    colorByPoint: true,
                                    data: this.alumnog
                                }
                            ],
                        });
                    }).catch(error=>{ });
                    axios.post(this.grafcagen,{id_carrera:this.id_carrera}).then(response=>{
                        this.eg=response.data;
                        for (let i in  this.eg)
                        {
                            for (let z in this.titulosGrafica)
                            {
                                Highcharts.chart(this.general[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://localhost',
                                    },
                                    navigation: {
                                        buttonOptions: {
                                            enabled: false
                                        }
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: this.titulosGrafica[z]
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Total'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                    },
                                    series: [
                                        {
                                            name: this.titulosGrafica[z],
                                            colorByPoint: true,
                                            data: this.eg[i][z]
                                        }
                                    ],
                                });
                            }
                        }
                    }).catch(error=>{  });
                    axios.post(this.grafcaaca,{id_carrera:this.id_carrera}).then(response=>{
                        this.ea=response.data;
                        for (let i in  this.ea)
                        {
                            for (let z in this.titulosGrafica)
                            {
                                Highcharts.chart(this.academic[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://localhost',
                                    },
                                    navigation: {
                                        buttonOptions: {
                                            enabled: false
                                        }
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: this.titulosGrafica[z]
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Total'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                    },
                                    series: [
                                        {
                                            name: this.titulosGrafica[z],
                                            colorByPoint: true,
                                            data: this.ea[i][z]
                                        }
                                    ],
                                });
                            }
                        }

                    }).catch(error=>{ });
                    axios.post(this.grafcafam,{id_carrera:this.id_carrera}).then(response=>{
                        this.ef=response.data;
                        for (let i in  this.ef)
                        {
                            for (let z in this.titulosGrafica)
                            {
                                Highcharts.chart(this.famili[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://localhost',
                                    },
                                    navigation: {
                                        buttonOptions: {
                                            enabled: false
                                        }
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: this.titulosGrafica[z]
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Total'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                    },
                                    series: [
                                        {
                                            name: this.titulosGrafica[z],
                                            colorByPoint: true,
                                            data: this.ef[i][z]
                                        }
                                    ],
                                });
                            }
                        }

                    }).catch(error=>{ });
                    axios.post(this.grafcahab,{id_carrera:this.id_carrera}).then(response=>{
                        this.eh=response.data;
                        for (let i in  this.eh)
                        {
                            for (let z in this.titulosGrafica)
                            {
                                Highcharts.chart(this.habito[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://localhost',
                                    },
                                    navigation: {
                                        buttonOptions: {
                                            enabled: false
                                        }
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: this.titulosGrafica[z]
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Total'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                    },
                                    series: [
                                        {
                                            name: this.titulosGrafica[z],
                                            colorByPoint: true,
                                            data: this.eh[i][z]
                                        }
                                    ],
                                });
                            }
                        }

                    }).catch(error=>{ });
                    axios.post(this.grafcasal,{id_carrera:this.id_carrera}).then(response=>{
                        this.es=response.data;
                        for (let i in  this.es)
                        {
                            for (let z in this.titulosGrafica)
                            {
                                Highcharts.chart(this.integra[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://localhost',
                                    },
                                    navigation: {
                                        buttonOptions: {
                                            enabled: false
                                        }
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: this.titulosGrafica[z]
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Total'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                    },
                                    series: [
                                        {
                                            name: this.titulosGrafica[z],
                                            colorByPoint: true,
                                            data: this.es[i][z]
                                        }
                                    ],
                                });
                            }
                        }

                    }).catch(error=>{ });
                    axios.post(this.grafcaare,{id_carrera:this.id_carrera}).then(response=>{
                        this.eas=response.data;
                        for (let i in  this.eas)
                        {
                            for (let z in this.titulosGrafica)
                            {
                                Highcharts.chart(this.areap[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://localhost',
                                    },
                                    navigation: {
                                        buttonOptions: {
                                            enabled: false
                                        }
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: this.titulosGrafica[z]
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Total'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                    },
                                    series: [
                                        {
                                            name: this.titulosGrafica[z],
                                            colorByPoint: true,
                                            data: this.eas[i][z]
                                        }
                                    ],
                                });
                            }
                        }
                    }).catch(error=>{ });
                    $('#modalgraficas').modal('show');

                },
                borrarAlumno:function (nombre) {
                    this.alumno=[];
                    this.clicgrupo=false;
                },
                reporte:function () {

                    this.direcciones_img=[];

                    for(let p in this.arreglo_graficas)
                    {
                        var chart = $('#'+this.arreglo_graficas[p]).highcharts();
                        var obj = {}, exportUrl = 'http://localhost:8004/';
                        obj.type = 'image/png';
                        obj.async = true;
                        obj.svg=chart.getSVG();

                        axios.post(exportUrl,obj).then(response=> {
                            this.direcciones_img.push(exportUrl+response.data);
                            // console.log(this.direcciones_img.length);
                            if((this.direcciones_img.length-1)=='13') {

                                axios.post(this.rep,{id_asigna_generacion:this.idasigna,id_carrera:this.idca,generacion:this.gen,imagen:this.direcciones_img},{
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/pdf'
                                    },
                                    responseType: "blob"
                                }).then(response=>{
                                    // console.log(response.data);
                                    const blob = new Blob([response.data], { type: 'application/pdf' });
                                    const objectUrl = URL.createObjectURL(blob);
                                    window.open(objectUrl)
                                });

                            }
                        });

                    }
                },
                versugerencia: function (alumno) {
                    console.log(alumno);
                    $("#modalsugerencia").modal("show");
                    axios.post(this.versuge, {id: alumno.id_asigna_planeacion_tutor,id_actividad: alumno.id_plan_actividad}).then(response => {
                        this.suge.sugerencia.id_asigna_planeacion_tutor = response.data.sugerencia[0].id_asigna_planeacion_tutor;
                    //this.suge.sugerencia.id_sugerencia= response.data.sugerencia[0].id_sugerencia;
                    this.suge.sugerencia.objetivo_actividad_cambio = response.data.sugerencia[0].objetivo_actividad_cambio;
                    this.suge.sugerencia.desc_actividad_cambio = response.data.sugerencia[0].desc_actividad_cambio;
                    this.suge.actividad.fi_actividad = response.data.actividad[0].fi_actividad;
                    this.suge.actividad.ff_actividad = response.data.actividad[0].ff_actividad;
                    this.suge.actividad.desc_actividad = response.data.actividad[0].desc_actividad;
                    this.suge.actividad.objetivo_actividad = response.data.actividad[0].objetivo_actividad;
                });
                },
                actualizasuge: function () {
                    /*AQUI*/
                    axios.post(this.actsuge, {suge: this.suge}).then(response => {
                        $("#modalsugerencia").modal("hide");
                });
                },
                actualizasuge1: function () {
                    /*AQUI*/
                    axios.post(this.actsuge, {suge: this.suge}).then(response => {
                        $("#modalsugerencia").modal("hide");
                });
                },


            },

        });
    </script>

@endsection
