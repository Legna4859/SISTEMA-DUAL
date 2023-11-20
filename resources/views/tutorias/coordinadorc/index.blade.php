@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="ind">
        <div class="row" v-if="menu" >
            <div class="col-12">
                <div class="row">
                    <div class="col-3" v-for="carrera in carreras">
                        <div class="card pt-4">
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
                    <a href="{{url('/tutorias/carreras')}}" class="font-weight-bold h6 pb-1">{{\Illuminate\Support\Facades\Session::get('coordinador')>1?'PROGRAMAS EDUCATIVOS':'PROGRAMA EDUCATIVO'}}</a>
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
                                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" @click="refrescar()" aria-controls="general" aria-selected="true">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="generacion-tab" data-toggle="tab" href="#generacion" role="tab"  aria-controls="generacion" aria-selected="false">Generaciones</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row p-3">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-4"><button @click="getGraficasCarrera()" class="btn btn-outline-success" data-toggle="tooltip" data-placement="bottom" title="Gráficas">Estadísticas <i class="fas fa-chart-pie"></i></button></div>
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
                                            <li class="nav-item">
                                                <a class="nav-link border m-1" @click="getAlumnosGeneracion(gen.generacion)" id="pills-generalgen-tab" data-toggle="pill" href="#generalgen" role="tab" aria-controls="'pills-generalgen" >General</a>
                                            </li>
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
                                                        <div class="col-2 offset-4"><button @click="getGraficas()" class="btn btn-outline-success" data-toggle="tooltip" data-placement="bottom" title="Gráficas">Estadísticas <i class="fas fa-chart-pie"></i></button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="tableFixHead">
                                                        <data-table class=" col-12 table table-sm" :data="alumno" :columns-to-display="gridColumns" :filter-key="searchQuery">
                                                            <template slot="Cuenta" scope="alu">
                                                                <div class="font-weight-bold pt-2">@{{alu.entry.cuenta}}</div>
                                                            </template>
                                                            <template slot="Nombre" scope="alu">
                                                                <div class="pt-2">@{{ alu.entry.apaterno }} @{{ alu.entry.amaterno}} @{{ alu.entry.nombre }}</div>
                                                            </template>
                                                            <template slot="Revalidación" scope="alu">
                                                                <a v-if="alu.entry.revalidacion==0" class="pt-2 font-weight-bold text-secondary">No</a>
                                                                <a v-if="alu.entry.revalidacion==1" class="pt-2 font-weight-bold text-danger">Sí</a>
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
                                                <h5 class="font-weight-bold text-center alert alert-danger">No existen estudiantes asignados al grupo</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @include('tutorias.coordinadorc.estadisticas')
                </div>
            </div>
          <!--1-->

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
                rut:"/tutorias/carrera",
                gen:'/tutorias/generacionca',
                alugrupo:'/tutorias/alumnosgrupo',
                alugeneracion:'/tutorias/alumnosgeneracion',
                carreras:[],
                alumno:[],
                menu:true,
                menucarrera:false,
                generaciones:[],
                nombrecarrera:null,
                clicgrupo:false,
                id_asigna:null,
                generacion: null,
                id_carrera: null,
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
                academico:'/tutorias/graphics/academico',
                rutgen:"/tutorias/graphics/genero",
                generales:"/tutorias/graphics/generales",
                familiares:"/tutorias/graphics/familiares",
                habitos:"/tutorias/graphics/habitos",
                salud:"/tutorias/graphics/salud",
                area:"/tutorias/graphics/area",
                gengen:'/tutorias/grafgeneracion/genero',
                grafgen:'/tutorias/grafgeneracion/generales',
                grafaca:'/tutorias/grafgeneracion/academico',
                graffam:'/tutorias/grafgeneracion/familiares',
                grafhab:'/tutorias/grafgeneracion/habitos',
                grafsal:'/tutorias/grafgeneracion/salud',
                grafare:'/tutorias/grafgeneracion/area',
                grafcagene:'/tutorias/grafcarrera/genero',
                grafcagen:'/tutorias/grafcarrera/generales',
                grafcaaca:'/tutorias/grafcarrera/academico',
                grafcafam:'/tutorias/grafcarrera/familiares',
                grafcahab:'/tutorias/grafcarrera/habitos',
                grafcasal:'/tutorias/grafcarrera/salud',
                grafcaare:'/tutorias/grafcarrera/area',
                rep:"/tutorias/pdf/reporte",
                direcciones_img:[],
                arreglo_graficas:['genero','hf','hm','etg','etf','etm','enfcg','enfcf','enfcm','eag','eaf','eam','bf','bm'],
                reporteGen:false,

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

                    this.searchQuery='';
                    this.clicgrupo=true;
                    this.id_asigna=grupo;
                    this.reporteGen=false;
                    axios.post(this.alugrupo,{generacion:grupo}).then(response=>{
                        this.alumno=response.data;
                    }).catch(error=>{ });
                },
                getAlumnosGeneracion:function(genera)
                {
                    this.searchQuery='';
                    this.clicgrupo=false;
                    this.generacion=genera;
                    this.reporteGen=false;
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
                                    url: 'http://192.168.43.226',
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
                                    text: 'Estudiantes por sexo'
                                },
                                accessibility: {
                                    announceNewData: {
                                        enabled: true
                                    }
                                },
                                xAxis: {
                                    type: 'category',
                                    labels: {
                                        style: {
                                            fontSize: '15px'
                                        }
                                    }

                                },
                                yAxis: {
                                    max:100,
                                    title: {
                                        text: 'Total',
                                        style: {
                                            fontSize: "15px",
                                        }
                                    },
                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.y:.1f}%',
                                            style: {
                                                fontSize:'15px'
                                            }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                            this.direcciones_img = [];
                            this.exportIMG(0);
                        }).catch(error=>{ });
                        /*m1*/
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
                                    text: 'Estudiantes por sexo'
                                },
                                exporting: {
                                    url: 'http://192.168.43.226',
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
                                    type: 'category',
                                    labels: {
                                        style: {
                                            fontSize: '15px'
                                        }
                                    }

                                },
                                yAxis: {
                                    max:100,
                                    title: {
                                        text: 'Total',
                                        style: {
                                            fontSize: "15px",
                                        }
                                    },
                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.y:.1f}%',
                                            style: {
                                                fontSize:'15px'
                                            }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                                            url: 'http://192.168.43.226',
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
                                            type: 'category',
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            }

                                        },
                                        yAxis: {
                                            max:100,
                                            title: {
                                                text: 'Total',
                                                style: {
                                                    fontSize: "15px",
                                                }
                                            },
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.1f}%',
                                                    style: {
                                                        fontSize:'15px'
                                                    }
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
                            this.direcciones_img = [];
                            this.exportIMG(0);
                        }).catch(error=>{ });
                        /*m2*/
                        $('#modalgraficas').modal('show');
                    }

                },
                getGraficasCarrera:function ()
                {
                    this.reporteGen=true;
                    axios.post(this.grafcagene,{id_carrera:this.id_carrera}).then(response=>{
                        this.alumnog=response.data;
                        Highcharts.chart('genero', {
                            chart: {
                                type: 'column'
                            },
                            exporting: {
                                url: 'http://192.168.43.226',
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
                                text: 'Estudiantes por sexo'
                            },
                            accessibility: {
                                announceNewData: {
                                    enabled: true
                                }
                            },
                            xAxis: {
                                type: 'category',
                                labels: {
                                    style: {
                                        fontSize: '15px'
                                    }
                                }

                            },
                            yAxis: {
                                max:100,
                                title: {
                                    text: 'Total',
                                    style: {
                                        fontSize: "15px",
                                    }
                                },
                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.y:.1f}%',
                                        style: {
                                            fontSize:'15px'
                                        }
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
                                        url: 'http://192.168.43.226',
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
                                        type: 'category',
                                        labels: {
                                            style: {
                                                fontSize: '15px'
                                            }
                                        }

                                    },
                                    yAxis: {
                                        max:100,
                                        title: {
                                            text: 'Total',
                                            style: {
                                                fontSize: "15px",
                                            }
                                        },
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%',
                                                style: {
                                                    fontSize:'15px'
                                                }
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
                                        url: 'http://192.168.43.226',
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
                                        type: 'category',
                                        labels: {
                                            style: {
                                                fontSize: '15px'
                                            }
                                        }

                                    },
                                    yAxis: {
                                        max:100,
                                        title: {
                                            text: 'Total',
                                            style: {
                                                fontSize: "15px",
                                            }
                                        },
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%',
                                                style: {
                                                    fontSize:'15px'
                                                }
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
                                        url: 'http://192.168.43.226',
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
                                        type: 'category',
                                        labels: {
                                            style: {
                                                fontSize: '15px'
                                            }
                                        }

                                    },
                                    yAxis: {
                                        max:100,
                                        title: {
                                            text: 'Total',
                                            style: {
                                                fontSize: "15px",
                                            }
                                        },
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%',
                                                style: {
                                                    fontSize:'15px'
                                                }
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
                                        url: 'http://192.168.43.226',
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
                                        type: 'category',
                                        labels: {
                                            style: {
                                                fontSize: '15px'
                                            }
                                        }

                                    },
                                    yAxis: {
                                        max:100,
                                        title: {
                                            text: 'Total',
                                            style: {
                                                fontSize: "15px",
                                            }
                                        },
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%',
                                                style: {
                                                    fontSize:'15px'
                                                }
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
                                        url: 'http://192.168.43.226',
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
                                        type: 'category',
                                        labels: {
                                            style: {
                                                fontSize: '15px'
                                            }
                                        }

                                    },
                                    yAxis: {
                                        max:100,
                                        title: {
                                            text: 'Total',
                                            style: {
                                                fontSize: "15px",
                                            }
                                        },
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%',
                                                style: {
                                                    fontSize:'15px'
                                                }
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
                                        url: 'http://192.168.43.226',
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
                                        type: 'category',
                                        labels: {
                                            style: {
                                                fontSize: '15px'
                                            }
                                        }

                                    },
                                    yAxis: {
                                        max:100,
                                        title: {
                                            text: 'Total',
                                            style: {
                                                fontSize: "15px",
                                            }
                                        },
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.1f}%',
                                                style: {
                                                    fontSize:'15px'
                                                }
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
                        this.direcciones_img = [];
                        this.exportIMG(0);
                    }).catch(error=>{ });
                    /*m3*/
                    $('#modalgraficas').modal('show');

                },
                exportIMG: function (cont) {
                    if(cont<=13)
                    {
                        var obj = {}, exportUrl;
                        var chart = $('#' + this.arreglo_graficas[cont]).highcharts();
                        exportUrl = 'http://192.168.43.226:8004/';
                        obj.type = 'image/png';
                        obj.async = true;
                        obj.svg = chart.getSVG();
                        axios.post(exportUrl, obj).then(response => {
                            this.direcciones_img[cont] = exportUrl + response.data;
                            if (cont <=13) {
                                this.exportIMG(cont + 1)
                            }
                        });
                    }
                },
                borrarAlumno:function (nombre) {
                    this.alumno=[];
                    this.clicgrupo=false;
                },
                reporte: function (tipoR) {
                    if(tipoR=='ReporteGeneracion')
                    {
                        axios.post(this.rep, {
                            id_carrera: this.id_carrera,
                            generacion_grupo: null,
                            generacion:this.generacion,
                            imagen: this.direcciones_img,
                            cargo:"coordinadorc"
                        }, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/pdf'
                            },
                            responseType: "blob"
                        }).then(response => {
                            // console.log(response.data);
                            const blob = new Blob([response.data], {type: 'application/pdf'});
                            const objectUrl = URL.createObjectURL(blob);
                            window.open(objectUrl)
                        });
                    }
                    else if(tipoR=='ReporteGrupo')
                    {
                        axios.post(this.rep, {
                            id_carrera: this.id_carrera,
                            generacion_grupo: this.id_asigna,
                            generacion:null,
                            imagen: this.direcciones_img,
                            cargo:"coordinadorc"
                        }, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/pdf'
                            },
                            responseType: "blob"
                        }).then(response => {
                            // console.log(response.data);
                            const blob = new Blob([response.data], {type: 'application/pdf'});
                            const objectUrl = URL.createObjectURL(blob);
                            window.open(objectUrl)
                        });
                    }
                    else if(tipoR=='ReporteCarrera')
                    {
                        axios.post(this.rep, {
                            id_carrera: this.id_carrera,
                            generacion_grupo: null,
                            generacion:null,
                            imagen: this.direcciones_img,
                            cargo:"coordinadorc"
                        }, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/pdf'
                            },
                            responseType: "blob"
                        }).then(response => {
                            // console.log(response.data);
                            const blob = new Blob([response.data], {type: 'application/pdf'});
                            const objectUrl = URL.createObjectURL(blob);
                            window.open(objectUrl)
                        });
                    }
                },
            },

        });
    </script>

@endsection
