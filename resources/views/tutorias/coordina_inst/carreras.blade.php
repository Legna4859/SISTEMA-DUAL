@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="ind">
        <div class="row" >
            <div class="col-5">
                <ul class="nav flex-column nav-pills bg-white" id="myTab" role="tablist">
                    <li class="nav-item border">
                        <a class="nav-link" id="carreras-tab" @click="GeneroInstitucion()" data-toggle="tab" href="#carreras" role="tab"  aria-controls="carreras" aria-selected="false">INSTITUCIONAL</a>
                    </li>
                    <li class="nav-item border" v-for="carrera in carreras">
                        <a class="nav-link" id="carreras-tab" @click="GeneroCarrera(carrera)" data-toggle="tab" href="#carreras" role="tab"  aria-controls="carreras" aria-selected="false">@{{ carrera.nombre }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-7">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="carreras" role="tabpanel" aria-labelledby="generacion-tab">
                        <div class="row">
                            <div class="grafgen" id="genero"></div>
                        </div>
                        <div class="row pt-3" v-if="inst==false">
                            <div class="col-5 offset-4"><button @click="getGraficasCarrera()" class="btn btn-outline-success" data-toggle="tooltip" data-placement="bottom" title="Gráficas">Estadísticas del expediente <i class="fas fa-chart-pie"></i></button></div>
                        </div>
                        <div class="row pt-3" v-if="inst==true">
                            <div class="col-7 offset-3"><button @click="getGraficasInstitucion()" class="btn btn-outline-success" data-toggle="tooltip" data-placement="bottom" title="Gráficas">Estadísticas institucionales del expediente <i class="fas fa-chart-pie"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('tutorias.coordina_inst.estadisticas')
        @include('tutorias.coordina_inst.responsable')
    </div>

    <script>
        new Vue({
            el:"#ind",
            created:function(){
                this.getCarreras();
            },
            data:{
                rut:"/tutorias/tes/carreras",
                carreras:[],
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
                eg:[],
                ea:[],
                ef:[],
                eh:[],
                es:[],
                eas:[],
                grafcagene:'/tutorias/grafcarrera/genero',
                grafcagen:'/tutorias/grafcarrera/generales',
                grafcaaca:'/tutorias/grafcarrera/academico',
                grafcafam:'/tutorias/grafcarrera/familiares',
                grafcahab:'/tutorias/grafcarrera/habitos',
                grafcasal:'/tutorias/grafcarrera/salud',
                grafcaare:'/tutorias/grafcarrera/area',
                grafinsgene:'/tutorias/grafinstitut/genero',
                grafinsgen:'/tutorias/grafinstitut/generales',
                grafinsaca:'/tutorias/grafinstitut/academico',
                grafinsfam:'/tutorias/grafinstitut/familiares',
                grafinshab:'/tutorias/grafinstitut/habitos',
                grafinssal:'/tutorias/grafinstitut/salud',
                grafinsare:'/tutorias/grafinstitut/area',
                alumnog:[],
                generocarrera:[],
                inst:false,
                rep:"/tutorias/pdf/reporte",
                direcciones_img:[],
                arreglo_graficas:['genero','hf','hm','etg','etf','etm','enfcg','enfcf','enfcm','eag','eaf','eam','bf','bm'],
                responsable:"",
                cargores:"",
                reslleno:"",


            },
            methods:{
                getCarreras:function(){
                    axios.get(this.rut).then(response=>{
                        this.carreras=response.data;
                    }).catch(error=>{ });
                },
                GeneroCarrera:function(carrera){
                    this.id_carrera=carrera.id_carrera;
                    this.inst=false;
                    axios.post(this.grafcagene,{id_carrera:this.id_carrera}).then(response=>{
                        this.generocarrera=response.data;
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
                                    data: this.generocarrera
                                }
                            ],
                        });
                        Highcharts.chart('genero1', {
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
                                    data: this.generocarrera
                                }
                            ],
                        })
                    }).catch(error=>{ });
                },
                GeneroInstitucion:function(){
                    this.inst=true;
                    axios.get(this.grafinsgene).then(response=>{
                        this.generocarrera=response.data;
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
                                    data: this.generocarrera
                                }
                            ],
                        });
                        Highcharts.chart('genero1', {
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
                                    data: this.generocarrera
                                }
                            ],
                        })
                    }).catch(error=>{ });
                },
                getGraficasCarrera:function ()
                {
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
                                        headerFormat: '<span style="font-size:14px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                                    },
                                    series: [
                                        {
                                            name: this.titulosGrafica[z],
                                            colorByPoint: true,
                                            data: this.eg[i][z]
                                        },
                                    ]
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
                    /*m1*/
                    $('#modalgraficas').modal('show');

                },
                getGraficasInstitucion:function ()
                {
                    axios.get(this.grafinsgen).then(response=>{
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
                    axios.get(this.grafinsaca).then(response=>{
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
                    axios.get(this.grafinsfam).then(response=>{
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
                    axios.get(this.grafinshab).then(response=>{
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
                    axios.get(this.grafinssal).then(response=>{
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
                    axios.get(this.grafinsare).then(response=>{
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
                reporte: function (tipoR) {
                    if (tipoR == 'ReporteCarrera') {
                        axios.post(this.rep, {
                            id_carrera: this.id_carrera,
                            imagen: this.direcciones_img,
                            cargo: "{{\Illuminate\Support\Facades\Session::get('PuestoTutorias')}}"
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
                    else if (tipoR == 'ReporteInstitucional') {
                        axios.post(this.rep, {
                            id_carrera: null,
                            imagen: this.direcciones_img,
                            cargo: "{{\Illuminate\Support\Facades\Session::get('PuestoTutorias')}}"
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
                    else if (tipoR == 'ReporteCarreraD') {

                        if(this.responsable!="" && this.cargores!="")
                        {
                            this.reslleno='true';
                        }
                        else {
                            this.reslleno='false';
                        }
                        if(this.reslleno=='true')
                        {
                            axios.post(this.rep, {
                                id_carrera: this.id_carrera,
                                imagen: this.direcciones_img,
                                responsable:this.responsable,
                                cargores:this.cargores,
                                cargo: "{{\Illuminate\Support\Facades\Session::get('PuestoTutorias')}}"
                            }, {
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/pdf'
                                },
                                responseType: "blob"
                            }).then(response => {
                                // console.log(response.data);
                                $('#responsable').modal('hide');
                                const blob = new Blob([response.data], {type: 'application/pdf'});
                                const objectUrl = URL.createObjectURL(blob);
                                window.open(objectUrl)
                            });
                        }

                    }
                    else if (tipoR == 'ReporteInstitucionalD') {

                        if(this.responsable!="" && this.cargores!="")
                        {
                            this.reslleno='true';
                        }
                        else {
                            this.reslleno='false';
                        }
                        if(this.reslleno=='true') {
                            axios.post(this.rep, {
                                id_carrera: null,
                                imagen: this.direcciones_img,
                                responsable: this.responsable,
                                cargores: this.cargores,
                                cargo: "{{\Illuminate\Support\Facades\Session::get('PuestoTutorias')}}"
                            }, {
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/pdf'
                                },
                                responseType: "blob"
                            }).then(response => {
                                // console.log(response.data);
                                $('#responsable').modal('hide');
                                const blob = new Blob([response.data], {type: 'application/pdf'});
                                const objectUrl = URL.createObjectURL(blob);
                                window.open(objectUrl)
                            });
                        }
                    }
                },
                DatosReporte:function () {
                    this.responsable="";
                    this.cargores="";
                    $('#modalgraficas').modal('hide');
                    $('#responsable').modal('show');
                },
                CancelReporte:function () {
                    this.responsable="";
                    this.cargores="";
                    this.reslleno="";
                    $('#modalgraficas').modal('show');
                    $('#responsable').modal('hide');
                }
            },


        });
    </script>

@endsection
