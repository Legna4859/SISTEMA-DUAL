@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="ind">
        <div class="row" v-show="menugrupos==true">
            <div class="col-12">
                <div class="row" >
                    <div class="col-3 pt-4" v-for="grupo in grupos">
                        <div class="card">
                            <div class="card-header text-center font-weight-bold"> @{{ grupo.nombre }}</div>
                            <div class="card-body text-center">

                                <a href="#" @click="getagregar_semestre(grupo)" v-show="grupo.estado_semestre == 0" class="btn btn-outline-success">Agregar semestre</a><br>
                                <div  style="text-align: center;" v-show="grupo.estado_semestre == 1">
                                    <h5 class="card-title" style="text-align: center">Semestre: @{{ grupo.nombre_semestre }}</h5>
                                    <a href="#" @click="geteditar_semestre(grupo)"  class="btn btn-outline-primary">Editar semestre</a><br>

                                </div>
                                <h5 class="card-title">Generación @{{ grupo.generacion }}</h5>
                                <p class="card-text">Grupo @{{ grupo.grupo }}</p>

                                <a href="#" @click="getlista(grupo)" class="btn btn-outline-success">Ver grupo</a>
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
                        <a href="{{url('/tutorias/tutorvista')}}" class="font-weight-bold h6 pb-1">{{\Illuminate\Support\Facades\Session::get('tutor')>1?'PROGRAMAS EDUCATIVOS':'PROGRAMA EDUCATIVO'}}</a>
                        <i class="fas fa-chevron-right h5"></i>
                        <a class="text-primary h6" v-if="lista==true">LISTA</a>
                        <a class="text-primary h6" v-if="graficas==true">ESTADÍSTICAS</a>
                        <a class="text-primary h6" v-if="actividades==true">ACTIVIDADES APROBADAS</a>
                        <a class="text-primary h6" v-if="plan==true">PLANEACION</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-9 text-center font-weight-bold">@{{ carrera }}</div>
                                        <div class="row" v-if="datos.length>0">
                                            <div class="col-3"><button class="btn text-white btn-success" @click="getAlumnos()" data-toggle="tooltip" data-placement="bottom" title="Lista"><i class="fas fa-list"></i></button></div>
                                            <div class="col-3"><button class="btn text-white btn-primary" @click="graficagenero()" data-toggle="tooltip" data-placement="bottom" title="Gráficas"><i class="fas fa-chart-pie"></i></button></div>
                                            <div class="col-3"><button class="btn text-white btn-dark"  @click="getplaneacion()" data-toggle="tooltip" data-placement="bottom" title="Actividades Aprobadas"><i class="fas fa-check-square"></i></button></div>
                                            <div class="col-3"><button class="btn text-white btn-danger"  @click="getAlumnos1()" data-toggle="tooltip" data-placement="bottom" title="Planeación"><i class="fas fa-file-alt"></i></button></div>
                                        </div>
                                    </div>
                                    <div class="row"><div class="col-9 text-center">@{{ gen }}</div></div>
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
                                                <div class="col-1 offset-5">
                                                    <button @click="pdf()" target="_blank" class="btn btn-danger text-white float-right" data-toggle="tooltip" data-placement="bottom" title="Generar lista"> <i class="fas fa-file-pdf"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tableFixHeadLista">
                                                <data-table class=" col-12 table table-sm" :data="datos" :columns-to-display="gridColumns" :filter-key="searchQuery">
                                                    <template slot="Cuenta" scope="alumno">
                                                        <div class="text-center font-weight-bold pt-2" style="height: 45px" v-bind:class="[alumno.entry.estado==2 ? 'bg-warning' : alumno.entry.estado==3 ? 'bg-danger':'']">@{{ alumno.entry.cuenta }}</div>
                                                    </template>
                                                    <template slot="Nombre" scope="alumno">
                                                        <div class="pt-2">@{{ alumno.entry.apaterno }} @{{ alumno.entry.amaterno}} @{{ alumno.entry.nombre }}</div>
                                                    </template>
                                                    <template slot="Acciones" scope="alumno">
                                                        <div class="text-center">
                                                            <button class="btn btn-outline-success" @click="cambio(alumno.entry,1)" data-toggle="tooltip" data-placement="bottom" title="Normal"><i class="fas fa-check-circle"></i></button>
                                                            <button class="btn btn-outline-warning m-1" @click="cambio(alumno.entry,2)" data-toggle="tooltip" data-placement="bottom" title="Baja temporal"><i class="fas fa-minus-circle"></i></button>
                                                            <button class="btn btn-outline-danger m-1" @click="cambio(alumno.entry,3)" data-toggle="tooltip" data-placement="bottom" title="Baja definitiva"><i class="fas fa-times-circle"></i></button>
                                                        </div>
                                                    </template>
                                                    <template  slot="Expediente" scope="alumno">
                                                        <div class="text-center" v-if="alumno.entry.expediente">
                                                            <button class="btn btn-outline-primary m-1" @click="ver(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit"></i></button>
                                                            <button class="btn btn-outline-danger" @click="pdfAlumno(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Expediente"><i class="far fa-file-pdf"></i></button>
                                                        </div>
                                                        <div v-else class="text-center" ><i class="fas h4 fa-times text-danger pt-2 " data-toggle="tooltip" data-placement="bottom" title="Expediente sin llenar"></i></div>
                                                    </template>
                                                    <template slot="Canalizacion" scope="alumno">
                                                        <div class="text-center" v-if="alumno.entry.canalizacion">
                                                            <button class="btn btn-outline-primary m-1"
                                                                    @click="acanaliza(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit"></i></button>
                                                            <button class="btn btn-outline-danger" @click="pdfCana(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Canalización"><i class="far fa-file-pdf"></i></button>
                                                        </div>
                                                        <div v-else class="text-center">
                                                            <button class="btn btn-outline-primary m-1" @click="vercanaliza(alumno.entry)" data-toggle="tooltip" data-placement="bottom" title="Canalizar"><i class="far fa-check-square "></i></button>
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
                                <div class="card-body" v-if="(actividades==true && datos1.length>0)">
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
                                                <data-table class=" col-12 table table-sm" :data="datos1" :columns-to-display="gridColumns1" :filter-key="searchQuery">
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
                                                    <template slot="Acciones" scope="alumno">
                                                        <div class="text-center">
                                                            <button class="btn btn-outline-success m-1"
                                                                    @click="seleccionact(alumno.entry)" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Agregar Actividad">+</button>
                                                        </div>
                                                    </template>
                                                    <template slot="nodata">
                                                        <div class=" alert font-weight-bold alert-danger text-center">Las actividades aún no han sido aprobadas</div>
                                                    </template>
                                                </data-table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" v-if="(plan==true && datos1.length>0)">
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
                                                    <button @click="pdf1()" target="_blank" class="btn btn-danger text-white float-right"
                                                            data-toggle="tooltip" data-placement="bottom" title="Generar planeacion">
                                                        <i class="fas fa-file-pdf"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tableFixHeadLista">
                                                <data-table class=" col-12 table table-sm" :data="datos1" :columns-to-display="gridColumns2" :filter-key="searchQuery">
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
                                                    <template slot="Estrategia" scope="alumno">
                                                        <div class="text-center" v-if="alumno.entry.boton==0">
                                                            <button class="btn btn-outline-success m-1"
                                                                    @click="verestrategia(alumno.entry)" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Agregar Estrategia">+</button>
                                                        </div>
                                                        <div class="text-center" v-else="alumno.entry.boton==1">
                                                            <button class="btn btn-outline-primary m-1"
                                                                    @click="verest(alumno.entry)" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Editar Estrategia">
                                                                <i class="fas fa-edit"></i>
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
                                        <h5 class="font-weight-bold">No se han asignado estudiantes al grupo</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="graficas==true">
                                <div class="col-12">
                                    <div class="row pt-3">
                                        <!--REPORTE PDF GRAFICAS-->
                                        <div class="col-1 offset-11"><button @click="reporte()" target="_blank" class="btn text-white btn-danger" ><i class="fas fa-file-pdf"></i></button></div>
                                    </div>
                                    <div class="row m-2"><div class="col-12 "><h5 class="alert alert-primary text-center font-weight-bold">Estadísticas</h5></div></div>
                                    <div class="row text-center"><div class="col-4"></div><div class="col-4 graf" id="genero"></div></div>
                                    <div class="row pl-4">
                                        <div class="col-12 pt-4">
                                            <div class="nav  nav-tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                <a class="nav-link active" id="v-pills-general-tab" data-toggle="pill"
                                                   href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true">Datos Generales</a>
                                                <a class="nav-link" id="v-pills-antecedentes-tab" data-toggle="pill"
                                                   href="#v-pills-antecedentes" role="tab" aria-controls="v-pills-antecedentes" aria-selected="false">Antecedentes Acádemicos</a>
                                                <a class="nav-link" id="v-pills-familiares-tab" data-toggle="pill"
                                                   href="#v-pills-familiares" role="tab" aria-controls="v-pills-familiares" aria-selected="false">Datos Familiares</a>
                                                <a class="nav-link" id="v-pills-habitos-tab" data-toggle="pill"
                                                   href="#v-pills-habitos" role="tab" aria-controls="v-pills-habitos" aria-selected="false">Hábitos de Estudio</a>
                                                <a class="nav-link" id="v-pills-formacion-tab" data-toggle="pill"
                                                   href="#v-pills-formacion" role="tab" aria-controls="v-pills-formacion" aria-selected="false">Formación Integral/Salud</a>
                                                <a class="nav-link" id="v-pills-area-tab" data-toggle="pill"
                                                   href="#v-pills-area" role="tab" aria-controls="v-pills-area" aria-selected="false">Área Psicopedagógica</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id='cont-preg'>
                                        <div class="col-12">
                                            <div class="tab-content text-justify" id="v-pills-tabContent">
                                                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                                                    <div class="row pt-4">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Estado civil</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="ecg"></div>
                                                                        <div class="col-4 graf" id="ecf"></div>
                                                                        <div class="col-4 graf" id="ecm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Nivel socioeconómico</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="neg"></div>
                                                                        <div class="col-4 graf" id="nef"></div>
                                                                        <div class="col-4 graf" id="nem"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Trabaja</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="trag"></div>
                                                                        <div class="col-4 graf" id="traf"></div>
                                                                        <div class="col-4 graf" id="tram"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Estado académico</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="eag"></div>
                                                                        <div class="col-4 graf" id="eaf"></div>
                                                                        <div class="col-4 graf" id="eam"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Beca</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="bg"></div>
                                                                        <div class="col-4 graf" id="bf"></div>
                                                                        <div class="col-4 graf" id="bm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Tipo de beca</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graftb" id="tbg"></div>
                                                                        <div class="col-4 graftb" id="tbf"></div>
                                                                        <div class="col-4 graftb" id="tbm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Número de hijos</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="hg"></div>
                                                                        <div class="col-4 graf" id="hf"></div>
                                                                        <div class="col-4 graf" id="hm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-antecedentes" role="tabpanel" aria-labelledby="v-pills-antecedentes-tab">
                                                    <div class="row pt-4">
                                                        <div class="col-12">
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">¿Te gusta el programa educativo elegido?</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="gg"></div>
                                                                        <div class="col-4 graf" id="gf"></div>
                                                                        <div class="col-4 graf" id="gm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">¿Te motiva tu familia en tus estudios?</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="esg"></div>
                                                                        <div class="col-4 graf" id="esf"></div>
                                                                        <div class="col-4 graf" id="esm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">¿Otro programa educativo iniciado?</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="og"></div>
                                                                        <div class="col-4 graf" id="of"></div>
                                                                        <div class="col-4 graf" id="om"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Tipo de bachillerato</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 grafmd" id="bag"></div>
                                                                        <div class="col-4 grafmd" id="baf"></div>
                                                                        <div class="col-4 grafmd" id="bam"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-familiares" role="tabpanel" aria-labelledby="v-pills-familiares-tab">
                                                    <div class="row pt-4">
                                                        <div class="col-12">
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Actualmente viven con</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graftb" id="vg"></div>
                                                                        <div class="col-4 graftb" id="vf"></div>
                                                                        <div class="col-4 graftb" id="vm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Pertenecen a etnia indígena</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="etg"></div>
                                                                        <div class="col-4 graf" id="etf"></div>
                                                                        <div class="col-4 graf" id="etm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Hablan lengua indígena</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="hag"></div>
                                                                        <div class="col-4 graf" id="haf"></div>
                                                                        <div class="col-4 graf" id="ham"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Unión familiar</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="ug"></div>
                                                                        <div class="col-4 graf" id="uf"></div>
                                                                        <div class="col-4 graf" id="um"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-habitos" role="tabpanel" aria-labelledby="v-pills-habitos-tab">
                                                    <div class="row pt-4">
                                                        <div class="col-12">
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Tiempo dedicado a estudiar</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 grafmd" id="tg"></div>
                                                                        <div class="col-4 grafmd" id="tf"></div>
                                                                        <div class="col-4 grafmd" id="tm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-formacion" role="tabpanel" aria-labelledby="v-pills-formacion-tab">
                                                    <div class="row pt-4">
                                                        <div class="col-12">
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Practican deporte</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="pdg"></div>
                                                                        <div class="col-4 graf" id="pdf"></div>
                                                                        <div class="col-4 graf" id="pdm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Practican alguna actividad artística</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="ag"></div>
                                                                        <div class="col-4 graf" id="af"></div>
                                                                        <div class="col-4 graf" id="am"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Participación en actividades culturales o sociales</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="csg"></div>
                                                                        <div class="col-4 graf" id="csf"></div>
                                                                        <div class="col-4 graf" id="csm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Padecen enfermedad crónica</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="enfcg"></div>
                                                                        <div class="col-4 graf" id="enfcf"></div>
                                                                        <div class="col-4 graf" id="enfcm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Padres que padecen enfermedad crónica</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="penfcg"></div>
                                                                        <div class="col-4 graf" id="penfcf"></div>
                                                                        <div class="col-4 graf" id="penfcm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Han tenido una cirugía</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="opeg"></div>
                                                                        <div class="col-4 graf" id="opef"></div>
                                                                        <div class="col-4 graf" id="opem"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Padecen enfermedad visual</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="visg"></div>
                                                                        <div class="col-4 graf" id="visf"></div>
                                                                        <div class="col-4 graf" id="vism"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Usan lentes</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="lg"></div>
                                                                        <div class="col-4 graf" id="lf"></div>
                                                                        <div class="col-4 graf" id="lm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Toman medicamento controlado</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="meg"></div>
                                                                        <div class="col-4 graf" id="mef"></div>
                                                                        <div class="col-4 graf" id="mem"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-area" role="tabpanel" aria-labelledby="v-pills-area-tab">
                                                    <div class="row pt-4">
                                                        <div class="col-12">
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Trabajo en equipo</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="trg"></div>
                                                                        <div class="col-4 graf" id="trf"></div>
                                                                        <div class="col-4 graf" id="trm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Rendimiento escolar</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="reng"></div>
                                                                        <div class="col-4 graf" id="renf"></div>
                                                                        <div class="col-4 graf" id="renm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Conocimientos en cómputo</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="comg"></div>
                                                                        <div class="col-4 graf" id="comf"></div>
                                                                        <div class="col-4 graf" id="comm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Comprensión y retención en clase</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="retg"></div>
                                                                        <div class="col-4 graf" id="retf"></div>
                                                                        <div class="col-4 graf" id="retm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Preparación de examenes</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="exag"></div>
                                                                        <div class="col-4 graf" id="exaf"></div>
                                                                        <div class="col-4 graf" id="exam"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Concentración durante el estudio</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="cong"></div>
                                                                        <div class="col-4 graf" id="conf"></div>
                                                                        <div class="col-4 graf" id="conm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Búsqueda bibliográfica</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="bbg"></div>
                                                                        <div class="col-4 graf" id="bbf"></div>
                                                                        <div class="col-4 graf" id="bbm"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Dominio del idioma inglés</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="oig"></div>
                                                                        <div class="col-4 graf" id="oif"></div>
                                                                        <div class="col-4 graf" id="oim"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">Solución de problemas y aprendizaje de las matemáticas</h5></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 graf" id="matg"></div>
                                                                        <div class="col-4 graf" id="matf"></div>
                                                                        <div class="col-4 graf" id="matm"></div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('tutorias.profesor.modaleditar')
        @include('tutorias.profesor.modalestrategia')
        @include('tutorias.profesor.modalcanalizacion')
        @include('tutorias.profesor.modalcanalizacionact')
        @include('tutorias.profesor.modalnuevaestra')
        @include('tutorias.profesor.modalseleccionactividad')
        @include('tutorias.profesor.modal_agregar_semestre_grupo')
        @include('tutorias.profesor.modal_modificar_semestre_grupo')

    </div>
    <script type="text/javascript">
        Vue.use(DataTable);
        new Vue({
            el: "#ind",
            created: function () {
                this.lista = false;
                this.plan = false;
                this.actividades = false;
                this.menugrupos = true;
                this.graficas = false;
                this.menu = false;
                this.getTut();
            },
            data: {
                searchQuery: '',
                gridColumns: ['Cuenta', 'Nombre', 'Acciones', 'Expediente', 'Canalizacion'],
                gridColumns1: ['Fecha Inicio', 'Fecha Fin', 'Decripción Actividad', 'Objetivo','Acciones'],
                gridColumns2: ['Fecha Inicio', 'Fecha Fin', 'Decripción Actividad', 'Objetivo','Estrategia'],
                rut: "/tutorias/profesor",
                rutaa: "/tutorias/semestre",
                rutab:"/tutorias/eleccion",
                grup: "/tutorias/grupos",
                sem: "/tutorias/semestres_tesvb",
                act: '/tutorias/actualiza',
                actestra: '/tutorias/actualizaestra',
                actsuge: '/tutorias/actualizasuge',
                cambios: '/tutorias/cambio',
                academico: '/tutorias/graphics/academico',
                rutgen: "/tutorias/graphics/genero",
                generales: "/tutorias/graphics/generales",
                familiares: "/tutorias/graphics/familiares",
                habitos: "/tutorias/graphics/habitos",
                salud: "/tutorias/graphics/salud",
                area: "/tutorias/graphics/area",
                pd: "/tutorias/pdf/lista",
                pl: "pdf/planeacion",
                rep: "/tutorias/pdf/reporte",
                palu: '/tutorias/pdf/alumno',
                veralu: '/tutorias/ver',
                vercanalizacion: '/tutorias/vercanaliza',
                pdfcan: '/tutorias/pdf/citacan',
                canalizaciona : '/tutorias/modalact',
                pruebact: '/tutorias/actualizadatos',
                enviasele: '/tutorias/envsel',
                verestra: '/tutorias/verestra',
                versuge: '/tutorias/versuge',
                prueba: '/tutorias/pcan',
                enviaestra:'/tutorias/updatestra',
                verenviado:'/tutorias/versend',
                nuevaes:'/tutorias/nuevodato',
                reg_semestre_grupo:'/tutorias/registrar_semestre_grupo',
                mod_semestre_grupo:'/tutorias/modificar_semestre_grupo',
                datos: [],
                catalogo_semestres: [],
                datos1: [],
                grupos: [],
                alumnog: [],
                eg: [],
                ea: [],
                ef: [],
                eh: [],
                es: [],
                eas: [],
                vista: [],
                periodos: [],
                semestres: [],
                carreras: [],
                grupo: [],
                estadociv: [],
                /*nivel:[],*/
                becas: [],
                bachiller: [],
                vive: [],
                union: [],
                turno: [],
                tiempo: [],
                intelectual: [],
                parentesco: [],
                escala: [],
                bebidas: [],
                lista: false,
                listaa: false,
                listacanaliza: false,
                menugrupos: true,
                menu: false,
                graficas: false,
                carrera: "",
                gen: "",
                gene: "",
                idca: null,
                idasigna: null,
                content_modal: "",
                datos_generacion:{
                    carrera:"",
                    generacion:"",
                    grupo:"",
                    id_grupo_tutoria:0,
                    id_semestre_grupo:0,
                    id_asigna_tutor:0,

                },
                alu: {
                    generales: {
                        id_exp_general: "",
                        id_periodo: "",
                        nombre: "",
                        edad: "",
                        sexo: "",
                        fecha_nacimientos: "",
                        lugar_nacimientos: "",
                        id_semestre: "",
                        id_estado_civil: "",
                        no_hijos: "",
                        direccion: "",
                        correo: "",
                        tel_casa: "",
                        cel: "",
                        nivel_economico: "",
                        trabaja: "",
                        ocupacion: "",
                        horario: "",
                        no_cuenta: "",
                        beca: "",
                        /*tipo_beca:"",*/
                        id_expbeca: null,
                        estado: "",
                        turno: "",
                        id_grupo: "",
                        id_carrera: "",
                        poblacion: "",
                        ant_inst: "",
                        satisfaccion_c: "",
                        materias_repeticion: "",
                        tot_repe: "",
                        materias_especial: "",
                        tot_espe: "",
                        gen_espe: "",
                        id_alumno: "",
                    },
                    academicos: {
                        id_exp_antecedentes_academicos: "",
                        id_bachillerato: "",
                        otros_estudios: "",
                        anos_curso_bachillerato: "",
                        ano_terminacion: "",
                        escuela_procedente: "",
                        promedio: "",
                        materias_reprobadas: "",
                        otra_carrera_ini: "",
                        institucion: "",
                        semestres_cursados: "",
                        interrupciones_estudios: "",
                        razones_interrupcion: "",
                        razon_descide_estudiar_tesvb: "",
                        sabedel_perfil_profesional: "",
                        otras_opciones_vocales: "",
                        cuales_otras_opciones_vocales: "",
                        tegusta_carrera_elegida: "",
                        porque_carrera_elegida: "",
                        suspension_estudios_bachillerato: "",
                        razones_suspension_estudios: "",
                        teestimula_familia: "",
                        id_alumno: "",
                    },
                    familiares: {
                        id_exp_datos_familiares: "",
                        nombre_padre: "",
                        edad_padre: "",
                        ocupacion_padre: "",
                        lugar_residencia_padre: "",
                        nombre_madre: "",
                        edad_madre: "",
                        ocupacion_madre: "",
                        lugar_residencia_madre: "",
                        no_hermanos: "",
                        lugar_ocupas: "",
                        id_opc_vives: "",
                        no_personas: "",
                        etnia_indigena: "",
                        cual_etnia: "",
                        hablas_lengua_indigena: "",
                        sostiene_economia_hogar: "",
                        id_familia_union: "",
                        nombre_tutor: "",
                        id_parentesco: "",
                        id_alumno: ""
                        ,
                    },
                    estudio: {
                        id_exp_habitos_estudio: "",
                        tiempo_empleado_estudiar: "",
                        id_opc_intelectual: "",
                        forma_estudio: "",
                        tiempo_libre: "",
                        asignatura_preferida: "",
                        porque_asignatura: "",
                        asignatura_dificil: "",
                        porque_asignatura_dificil: "",
                        opinion_tu_mismo_estudiante: "",
                        id_alumno: ""
                        ,
                    },
                    integral: {
                        id_exp_formacion_integral: "",
                        practica_deporte: "",
                        especifica_deporte: "",
                        practica_artistica: "",
                        especifica_artistica: "",
                        pasatiempo: "",
                        actividades_culturales: "",
                        cuales_act: "",
                        estado_salud: "",
                        enfermedad_cronica: "",
                        especifica_enf_cron: "",
                        enf_cron_padre: "",
                        especifica_enf_cron_padres: "",
                        operacion: "",
                        deque_operacion: "",
                        enfer_visual: "",
                        especifica_enf: "",
                        usas_lentes: "",
                        medicamento_controlado: "",
                        especifica_medicamento: "",
                        estatura: "",
                        peso: "",
                        accidente_grave: "",
                        relata_breve: "",
                        id_expbebidas: "",
                        id_alumno: "",
                    },
                    area: {
                        id_exp_area_psicopedagogica: "",
                        rendimiento_escolar: "",
                        dominio_idioma: "",
                        otro_idioma: "",
                        conocimiento_compu: "",
                        aptitud_especial: "",
                        comprension: "",
                        preparacion: "",
                        estrategias_aprendizaje: "",
                        organizacion_actividades: "",
                        concentracion: "",
                        solucion_problemas: "",
                        condiciones_ambientales: "",
                        busqueda_bibliografica: "",
                        trabajo_equipo: "",
                        id_alumno: "",
                    },
                    cadena: null
                },
                estra: {
                    planeacion: {
                        id_plan_actividad: "",
                        id_asigna_generacion:"",
                        id_asigna_planeacion_tutor: "",
                    },
                },
                ingresado: {
                    env: {
                        id_asigna_planeacion_tutor: "",
                        id_asigna_generacion:"",
                        estrategia:"",
                        requiere_evidencia:"",
                    },
                },
                canaliza: {
                    valores: {
                        grupo: "",
                        nombre: "",
                        apaterno: "",
                        amaterno: "",
                        carrera: "",
                        descripcion: "",
                        id_alumno: "",
                        nombre_tut: "",
                    },
                },
                can: {
                    va: {
                        grupo: "",
                        nombre: "",
                        apaterno: "",
                        amaterno: "",
                        carrera: "",
                        descripcion: "",
                        id_alumno: "",
                        nombre_tut: "",
                        observaciones:"",
                        aspectos_sociologicos1:"",
                        aspectos_sociologicos2:"",
                        aspectos_sociologicos3:"",
                        aspectos_academicos1:"",
                        aspectos_academicos2:"",
                        aspectos_academicos3:"",
                        otros:"",
                        status:"",
                        desc_area:"",
                        desc_subarea:"",
                    },
                },

                areas: [],
                subareas: [],
                fin: true,
                titulosGrafica: ['General', 'Mujeres', 'Hombres'],
                general: [
                    ['ecg', 'ecf', 'ecm'], ['neg', 'nef', 'nem'], ['trag', 'traf', 'tram'],
                    ['eag', 'eaf', 'eam'], ['bg', 'bf', 'bm'], ['tbg', 'tbf', 'tbm'], ['hg', 'hf', 'hm']
                ],
                academic: [['gg', 'gf', 'gm'], ['esg', 'esf', 'esm'], ['og', 'of', 'om'], ['bag', 'baf', 'bam']],
                famili: [['vg', 'vf', 'vm'], ['etg', 'etf', 'etm'], ['hag', 'haf', 'ham'], ['ug', 'uf', 'um']],
                habito: [['tg', 'tf', 'tm']],
                integra: [['pdg', 'pdf', 'pdm'], ['ag', 'af', 'am'], ['csg', 'csf', 'csm'], ['enfcg', 'enfcf', 'enfcm'], ['penfcg', 'penfcf', 'penfcm'],
                    ['opeg', 'opef', 'opem'], ['visg', 'visf', 'vism'], ['lg', 'lf', 'lm'], ['meg', 'mef', 'mem']],
                areap: [['trg', 'trf', 'trm'], ['reng', 'renf', 'renm'], ['comg', 'comf', 'comm'], ['retg', 'retf', 'retm'], ['exag', 'exaf', 'exam'],
                    ['cong', 'conf', 'conm'], ['bbg', 'bbf', 'bbm'], ['oig', 'oif', 'oim'], ['matg', 'matf', 'matm']],
                direcciones_img: [],
                arreglo_graficas: ['genero', 'hf', 'hm', 'etg', 'etf', 'etm', 'enfcg', 'enfcf', 'enfcm', 'eag', 'eaf', 'eam', 'bf', 'bm'],
                nuevos: [],
            },
            methods: {
                getTut: function () {
                    axios.get(this.grup).then(response => {
                        this.grupos = response.data;
                    }).catch(error => {
                    });
                    axios.get(this.sem).then(response => {
                        this.catalogo_semestres = response.data;
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
                    //this.getAlumnos1();
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
                        this.actividades = false;
                        this.listacanaliza = false;
                        this.graficas = false;
                        this.datos = response.data;
                        this.nuevos = response.data;
                    }).catch(error => {
                    });
                },
                getplaneacion: function () {
                    axios.post(this.rutab, {
                        id_asigna_generacion: this.idasigna,
                    }).then(response => {
                        this.menugrupos = false;
                        this.menu = true;
                        this.lista = false;
                        this.plan = false;
                        this.actividades = true;
                        this.listacanaliza = false;
                        this.graficas = false;
                        this.datos1 = response.data;
                        this.nuevos = response.data;
                    }).catch(error => {
                    });
                },
                getAlumnos1: function () {
                    axios.post(this.rutaa, {
                        id_asigna_generacion: this.idasigna,
                    }).then(response => {
                        this.menugrupos = false;
                        this.menu = true;
                        this.lista = false;
                        this.plan = true;
                        this.actividades = false;
                        this.listacanaliza = false;
                        this.graficas = false;
                        this.datos1 = response.data;
                        this.nuevos = response.data;
                    }).catch(error => {
                    });
                },
                graficagenero: function () {
                    this.lista = false;
                    this.plan = false;
                    this.menugrupos = false;
                    this.graficas = true;
                    this.listacanaliza = false;
                    axios.post(this.rutgen, {
                        id_carrera: this.idca,
                        id_asigna_generacion: this.idasigna
                    }).then(response => {
                        this.alumnog = response.data;
                        Highcharts.chart('genero', {
                            chart: {
                                type: 'column'
                            },
                            exporting: {
                                url: 'http://177.244.44.90:8006',
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
                    }).catch(error => {
                    });
                    axios.post(this.generales, {
                        id_carrera: this.idca,
                        id_asigna_generacion: this.idasigna
                    }).then(response => {
                        this.eg = response.data;
                        for (let i in  this.eg) {
                            for (let z in this.titulosGrafica) {
                                Highcharts.chart(this.general[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://177.244.44.90:8006',
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
                    }).catch(error => {
                        this.sindato = true;
                    });
                    axios.post(this.academico, {
                        id_carrera: this.idca,
                        id_asigna_generacion: this.idasigna
                    }).then(response => {
                        this.ea = response.data;
                        for (let i in  this.ea) {
                            for (let z in this.titulosGrafica) {
                                Highcharts.chart(this.academic[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://177.244.44.90:8006',
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
                    }).catch(error => {
                    });
                    axios.post(this.familiares, {
                        id_carrera: this.idca,
                        id_asigna_generacion: this.idasigna
                    }).then(response => {
                        this.ef = response.data;
                        for (let i in  this.ef) {
                            for (let z in this.titulosGrafica) {
                                Highcharts.chart(this.famili[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://177.244.44.90:8006',
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
                    }).catch(error => {
                    });
                    axios.post(this.habitos, {
                        id_carrera: this.idca,
                        id_asigna_generacion: this.idasigna
                    }).then(response => {
                        this.eh = response.data;
                        for (let i in  this.eh) {
                            for (let z in this.titulosGrafica) {
                                Highcharts.chart(this.habito[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://177.244.44.90:8006',
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
                    }).catch(error => {
                    });
                    axios.post(this.salud, {
                        id_carrera: this.idca,
                        id_asigna_generacion: this.idasigna
                    }).then(response => {
                        this.es = response.data;
                        for (let i in  this.es) {
                            for (let z in this.titulosGrafica) {
                                Highcharts.chart(this.integra[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://177.244.44.90:8006',
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
                    }).catch(error => {
                    });
                    axios.post(this.area, {
                        id_carrera: this.idca,
                        id_asigna_generacion: this.idasigna
                    }).then(response => {
                        this.eas = response.data;
                        for (let i in  this.eas) {
                            for (let z in this.titulosGrafica) {
                                Highcharts.chart(this.areap[i][z], {
                                    chart: {
                                        type: 'column'
                                    },
                                    exporting: {
                                        url: 'http://177.244.44.90:8006/',
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
                    }).catch(error => {
                    });
                },
                exportIMG: function (cont) {
                    if(cont<=13)
                    {
                        var obj = {}, exportUrl;
                        var chart = $('#' + this.arreglo_graficas[cont]).highcharts();
                        exportUrl = 'http://177.244.44.90:8006/';
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
                cambio: function (alumno, num) {
                    axios.post(this.cambios, {id_asigna_alumno: alumno.id_asigna_alumno, estado: num}).then(response => {
                        this.getAlumnos();
                    });
                },
                actualiza: function () {
                    /*AQUI*/
                    if (this.alu.generales.estado != "null"
                        && this.alu.generales.nivel_economico != "null"
                        && this.alu.generales.materias_especial != "null"
                        && this.alu.generales.materias_repeticion != "null"
                        && this.alu.generales.direccion != "null"
                        && this.alu.generales.id_periodo != "null"
                        && this.alu.generales.no_hijos != "null"
                        && this.alu.generales.id_grupo != "null"
                        && this.alu.generales.sexo != "null"
                        && this.alu.generales.id_estado_civil != "null"
                        && this.alu.generales.trabaja != "null"
                        && this.alu.academicos.teestimula_familia != "null"
                        && this.alu.academicos.tegusta_carrera_elegida != "null"
                        && this.alu.academicos.otra_carrera_ini != "null"
                        && this.alu.familiares.nombre_padre != "null"
                        && this.alu.familiares.nombre_madre != "null"
                        && this.alu.familiares.lugar_residencia_madre != "null"
                        && this.alu.familiares.lugar_residencia_padre != "null"
                        && this.alu.familiares.etnia_indigena != "null"
                        && this.alu.familiares.hablas_lengua_indigena != "null"
                        && this.alu.familiares.id_opc_vives != "null"
                        && this.alu.familiares.id_familia_union != "null"
                        && this.alu.familiares.nombre_tutor != "null"
                        && this.alu.familiares.id_parentesco != "null"
                        && this.alu.estudio.forma_estudio != "null"
                        && this.alu.estudio.tiempo_empleado_estudiar != "null"
                        && this.alu.estudio.id_opc_intelectual != "null"
                        && this.alu.integral.enfermedad_cronica != "null"
                        && this.alu.integral.enf_cron_padre != "null"
                        && this.alu.integral.operacion != "null"
                        && this.alu.integral.enfer_visual != "null"
                        && this.alu.integral.medicamento_controlado != "null"
                        && this.alu.integral.practica_deporte != "null"
                        && this.alu.integral.practica_artistica != "null"
                        && this.alu.integral.actividades_culturales != "null"
                        && this.alu.integral.usas_lentes != "null"
                        && this.alu.area.trabajo_equipo != "null"
                        && this.alu.area.rendimiento_escolar != "null"
                        && this.alu.area.conocimiento_compu != "null"
                        && this.alu.area.comprension != "null"
                        && this.alu.area.concentracion != "null"
                        && this.alu.area.otro_idioma != "null"
                        && this.alu.area.solucion_problemas != "null"
                        && this.alu.area.preparacion != "null"
                        && this.alu.area.busqueda_bibliografica != "null") {
                        if (this.alu.generales.turno == "null") {
                            this.fin = false;
                        } else if (this.alu.generales.beca == 1 && this.alu.generales.id_expbeca != "null" && this.alu.generales.id_expbeca != null && this.alu.generales.id_expbeca != 0) {
                            this.fin = true;
                            axios.post(this.act, {alu: this.alu}).then(response => {
                                $("#modaleditar").modal("hide");
                            });
                        } else if (this.alu.generales.beca == 1 && this.alu.generales.id_expbeca == "null") {
                            this.fin = false;
                        } else if (this.alu.generales.beca == 2) {
                            this.fin = true;
                            axios.post(this.act, {alu: this.alu}).then(response => {
                                $("#modaleditar").modal("hide");
                            });
                        }
                    } else {
                        this.fin = false;
                    }
                },
                ver: function (alumno) {
                    ///console.log(alumno);
                    $("#modaleditar").modal("show");
                    axios.post(this.veralu, {id: alumno.id_alumno}).then(response => {
                        this.alu.generales.id_exp_general = response.data.generales[0].id_exp_general;
                        this.alu.generales.id_periodo = response.data.generales[0].id_periodo;
                        this.alu.generales.nombre = response.data.generales[0].nombre;
                        this.alu.generales.edad = response.data.generales[0].edad;
                        this.alu.generales.sexo = response.data.generales[0].sexo;
                        this.alu.generales.fecha_nacimientos = response.data.datos_alumn[0].fecha_nac;
                        this.alu.generales.lugar_nacimientos = response.data.generales[0].lugar_nacimientos;
                        this.alu.generales.id_semestre = response.data.datos_alumn[0].id_semestre;
                        this.alu.generales.id_estado_civil = response.data.generales[0].id_estado_civil;
                        this.alu.generales.no_hijos = response.data.generales[0].no_hijos;
                        this.alu.generales.direccion = response.data.generales[0].direccion;
                        this.alu.generales.correo = response.data.generales[0].correo;
                        this.alu.generales.tel_casa = response.data.generales[0].tel_casa;
                        this.alu.generales.cel = response.data.generales[0].cel;
                        this.alu.generales.nivel_economico = response.data.generales[0].nivel_economico;
                        this.alu.generales.trabaja = response.data.generales[0].trabaja;
                        this.alu.generales.ocupacion = response.data.generales[0].ocupacion;
                        this.alu.generales.horario = response.data.generales[0].horario;
                        this.alu.generales.no_cuenta = response.data.generales[0].no_cuenta;
                        this.alu.generales.beca = response.data.generales[0].beca;
                        this.alu.generales.id_expbeca = response.data.generales[0].id_expbeca;
                        this.alu.generales.estado = response.data.generales[0].estado;
                        this.alu.generales.turno = response.data.generales[0].turno;
                        this.alu.generales.id_alumno = response.data.generales[0].id_alumno;
                        this.alu.generales.id_grupo = response.data.generales[0].id_grupo;
                        this.alu.generales.id_carrera = response.data.generales[0].id_carrera;
                        this.alu.generales.poblacion = response.data.generales[0].poblacion;
                        this.alu.generales.ant_inst = response.data.generales[0].ant_inst;
                        this.alu.generales.ant_inst = response.data.generales[0].ant_inst;
                        this.alu.generales.satisfaccion_c = response.data.generales[0].satisfaccion_c;
                        this.alu.generales.materias_repeticion = response.data.generales[0].materias_repeticion;
                        this.alu.generales.tot_repe = response.data.generales[0].tot_repe;
                        this.alu.generales.materias_especial = response.data.generales[0].materias_especial;
                        this.alu.generales.tot_espe = response.data.generales[0].tot_espe;
                        this.alu.generales.gen_espe = response.data.generales[0].gen_espe;
                        this.alu.academicos.id_exp_antecedentes_academicos = response.data.academicos[0].id_exp_antecedentes_academicos;
                        this.alu.academicos.id_bachillerato = response.data.academicos[0].id_bachillerato;
                        this.alu.academicos.otros_estudios = response.data.academicos[0].otros_estudios;
                        this.alu.academicos.anos_curso_bachillerato = response.data.academicos[0].anos_curso_bachillerato;
                        this.alu.academicos.ano_terminacion = response.data.academicos[0].ano_terminacion;
                        this.alu.academicos.escuela_procedente = response.data.academicos[0].escuela_procedente;
                        this.alu.academicos.promedio = response.data.academicos[0].promedio;
                        this.alu.academicos.materias_reprobadas = response.data.academicos[0].materias_reprobadas;
                        this.alu.academicos.otra_carrera_ini = response.data.academicos[0].otra_carrera_ini;
                        this.alu.academicos.institucion = response.data.academicos[0].institucion;
                        this.alu.academicos.semestres_cursados = response.data.academicos[0].semestres_cursados;
                        this.alu.academicos.interrupciones_estudios = response.data.academicos[0].interrupciones_estudios;
                        this.alu.academicos.razones_interrupcion = response.data.academicos[0].razones_interrupcion;
                        this.alu.academicos.razon_descide_estudiar_tesvb = response.data.academicos[0].razon_descide_estudiar_tesvb;
                        this.alu.academicos.sabedel_perfil_profesional = response.data.academicos[0].sabedel_perfil_profesional;
                        this.alu.academicos.otras_opciones_vocales = response.data.academicos[0].otras_opciones_vocales;
                        this.alu.academicos.cuales_otras_opciones_vocales = response.data.academicos[0].cuales_otras_opciones_vocales;
                        this.alu.academicos.tegusta_carrera_elegida = response.data.academicos[0].tegusta_carrera_elegida;
                        this.alu.academicos.porque_carrera_elegida = response.data.academicos[0].porque_carrera_elegida;
                        this.alu.academicos.suspension_estudios_bachillerato = response.data.academicos[0].suspension_estudios_bachillerato;
                        this.alu.academicos.razones_suspension_estudios = response.data.academicos[0].razones_suspension_estudios;
                        this.alu.academicos.teestimula_familia = response.data.academicos[0].teestimula_familia;
                        this.alu.academicos.id_alumno = response.data.academicos[0].id_alumno;
                        this.alu.familiares.id_exp_datos_familiares = response.data.familiares[0].id_exp_datos_familiares;
                        this.alu.familiares.nombre_padre = response.data.familiares[0].nombre_padre;
                        this.alu.familiares.edad_padre = response.data.familiares[0].edad_padre;
                        this.alu.familiares.ocupacion_padre = response.data.familiares[0].ocupacion_padre;
                        this.alu.familiares.lugar_residencia_padre = response.data.familiares[0].lugar_residencia_padre;
                        this.alu.familiares.nombre_madre = response.data.familiares[0].nombre_madre;
                        this.alu.familiares.edad_madre = response.data.familiares[0].edad_madre;
                        this.alu.familiares.ocupacion_madre = response.data.familiares[0].ocupacion_madre;
                        this.alu.familiares.lugar_residencia_madre = response.data.familiares[0].lugar_residencia_madre;
                        this.alu.familiares.no_hermanos = response.data.familiares[0].no_hermanos;
                        this.alu.familiares.lugar_ocupas = response.data.familiares[0].lugar_ocupas;
                        this.alu.familiares.id_opc_vives = response.data.familiares[0].id_opc_vives;
                        this.alu.familiares.no_personas = response.data.familiares[0].no_personas;
                        this.alu.familiares.etnia_indigena = response.data.familiares[0].etnia_indigena;
                        this.alu.familiares.cual_etnia = response.data.familiares[0].cual_etnia;
                        this.alu.familiares.hablas_lengua_indigena = response.data.familiares[0].hablas_lengua_indigena;
                        this.alu.familiares.sostiene_economia_hogar = response.data.familiares[0].sostiene_economia_hogar;
                        this.alu.familiares.id_familia_union = response.data.familiares[0].id_familia_union;
                        this.alu.familiares.nombre_tutor = response.data.familiares[0].nombre_tutor;
                        this.alu.familiares.id_parentesco = response.data.familiares[0].id_parentesco;
                        this.alu.familiares.id_alumno = response.data.familiares[0].id_alumno;
                        this.alu.estudio.id_exp_habitos_estudio = response.data.estudio[0].id_exp_habitos_estudio;
                        this.alu.estudio.tiempo_empleado_estudiar = response.data.estudio[0].tiempo_empleado_estudiar;
                        this.alu.estudio.id_opc_intelectual = response.data.estudio[0].id_opc_intelectual;
                        this.alu.estudio.forma_estudio = response.data.estudio[0].forma_estudio;
                        this.alu.estudio.tiempo_libre = response.data.estudio[0].tiempo_libre;
                        this.alu.estudio.asignatura_preferida = response.data.estudio[0].asignatura_preferida;
                        this.alu.estudio.porque_asignatura = response.data.estudio[0].porque_asignatura;
                        this.alu.estudio.asignatura_dificil = response.data.estudio[0].asignatura_dificil;
                        this.alu.estudio.porque_asignatura_dificil = response.data.estudio[0].porque_asignatura_dificil;
                        this.alu.estudio.opinion_tu_mismo_estudiante = response.data.estudio[0].opinion_tu_mismo_estudiante;
                        this.alu.estudio.id_alumno = response.data.estudio[0].id_alumno;
                        this.alu.integral.id_exp_formacion_integral = response.data.integral[0].id_exp_formacion_integral;
                        this.alu.integral.practica_deporte = response.data.integral[0].practica_deporte;
                        this.alu.integral.especifica_deporte = response.data.integral[0].especifica_deporte;
                        this.alu.integral.practica_artistica = response.data.integral[0].practica_artistica;
                        this.alu.integral.especifica_artistica = response.data.integral[0].especifica_artistica;
                        this.alu.integral.pasatiempo = response.data.integral[0].pasatiempo;
                        this.alu.integral.actividades_culturales = response.data.integral[0].actividades_culturales;
                        this.alu.integral.cuales_act = response.data.integral[0].cuales_act;
                        this.alu.integral.estado_salud = response.data.integral[0].estado_salud;
                        this.alu.integral.enfermedad_cronica = response.data.integral[0].enfermedad_cronica;
                        this.alu.integral.especifica_enf_cron = response.data.integral[0].especifica_enf_cron;
                        this.alu.integral.enf_cron_padre = response.data.integral[0].enf_cron_padre;
                        this.alu.integral.especifica_enf_cron_padres = response.data.integral[0].especifica_enf_cron_padres;
                        this.alu.integral.operacion = response.data.integral[0].operacion;
                        this.alu.integral.deque_operacion = response.data.integral[0].deque_operacion;
                        this.alu.integral.enfer_visual = response.data.integral[0].enfer_visual;
                        this.alu.integral.especifica_enf = response.data.integral[0].especifica_enf;
                        this.alu.integral.usas_lentes = response.data.integral[0].usas_lentes;
                        this.alu.integral.medicamento_controlado = response.data.integral[0].medicamento_controlado;
                        this.alu.integral.especifica_medicamento = response.data.integral[0].especifica_medicamento;
                        this.alu.integral.estatura = response.data.integral[0].estatura;
                        this.alu.integral.peso = response.data.integral[0].peso;
                        this.alu.integral.accidente_grave = response.data.integral[0].accidente_grave;
                        this.alu.integral.relata_breve = response.data.integral[0].relata_breve;
                        this.alu.integral.id_expbebidas = response.data.integral[0].id_expbebidas;
                        this.alu.integral.id_alumno = response.data.integral[0].id_alumno;
                        this.alu.area.id_exp_area_psicopedagogica = response.data.area[0].id_exp_area_psicopedagogica;
                        this.alu.area.rendimiento_escolar = response.data.area[0].rendimiento_escolar;
                        this.alu.area.dominio_idioma = response.data.area[0].dominio_idioma;
                        this.alu.area.otro_idioma = response.data.area[0].otro_idioma;
                        this.alu.area.conocimiento_compu = response.data.area[0].conocimiento_compu;
                        this.alu.area.aptitud_especial = response.data.area[0].aptitud_especial;
                        this.alu.area.comprension = response.data.area[0].comprension;
                        this.alu.area.preparacion = response.data.area[0].preparacion;
                        this.alu.area.estrategias_aprendizaje = response.data.area[0].estrategias_aprendizaje;
                        this.alu.area.organizacion_actividades = response.data.area[0].organizacion_actividades;
                        this.alu.area.concentracion = response.data.area[0].concentracion;
                        this.alu.area.solucion_problemas = response.data.area[0].solucion_problemas;
                        this.alu.area.condiciones_ambientales = response.data.area[0].condiciones_ambientales;
                        this.alu.area.busqueda_bibliografica = response.data.area[0].busqueda_bibliografica;
                        this.alu.area.trabajo_equipo = response.data.area[0].trabajo_equipo;
                        this.alu.area.id_alumno = response.data.area[0].id_alumno;
                        ///CATALOGOS
                        this.periodos = response.data.periodos;
                        this.semestres = response.data.semestres;
                        this.carreras = response.data.carreras;
                        this.grupo = response.data.grupos;
                        this.estadociv = response.data.estadocivil;
                        this.nivel = response.data.nivel;
                        this.bachiller = response.data.bachillerato;
                        this.vive = response.data.vive;
                        this.union = response.data.unionfam;
                        this.turno = response.data.turno;
                        this.tiempo = response.data.tiempoestudia;
                        this.intelectual = response.data.intelectual;
                        this.parentesco = response.data.parentesco;
                        this.escala = response.data.escala;
                        this.bebidas = response.data.bebidas;
                        this.becas = response.data.becas;
                    });
                },
                vercanaliza: function (alumno) {
                    this.fecha_canalizacion="";
                    this.observaciones="";
                    this.hora="";
                    this.aspectos_sociologicos1="";
                    this.aspectos_sociologicos2="";
                    this.aspectos_sociologicos3="";
                    this.aspectos_academicos1="";
                    this.aspectos_academicos2="";
                    this.aspectos_academicos3="";
                    this.otros="";
                    this.status="";
                    this.desc_area="";
                    this.desc_subarea="";
                    axios.post(this.vercanalizacion, {id: alumno.id_alumno}).then(response => {
                        this.canaliza.valores.grupo = response.data.valores[0].grupo;
                        this.canaliza.valores.nombre = response.data.valores[0].nombre;
                        this.canaliza.valores.apaterno = response.data.valores[0].apaterno;
                        this.canaliza.valores.amaterno = response.data.valores[0].amaterno;
                        this.canaliza.valores.carrera = response.data.valores[0].carrera;
                        this.canaliza.valores.descripcion = response.data.valores[0].semestre;
                        this.canaliza.valores.id_alumno = response.data.valores[0].id_alumno;
                        this.canaliza.valores.nombre_tut = response.data.valores[0].nombre_tut;
                        /////areas
                        this.areas= response.data.areas;
                        this.subareas= response.data.subareas;
                        $("#modalcanalizacion").modal("show");
                    });
                },
                submitForm: function(){
                    axios.post(this.prueba,  {
                        id_alumno: this.canaliza.valores.id_alumno,
                        id_personal:this.canaliza.valores.id_personal,
                        fecha_canalizacion:this.fecha_canalizacion,
                        hora:this.hora,
                        observaciones:this.observaciones,
                        aspectos_sociologicos1:this.aspectos_sociologicos1,
                        aspectos_sociologicos2:this.aspectos_sociologicos2,
                        aspectos_sociologicos3:this.aspectos_sociologicos3,
                        aspectos_academicos1:this.aspectos_academicos1,
                        aspectos_academicos2:this.aspectos_academicos2,
                        aspectos_academicos3:this.aspectos_academicos3,
                        otros:this.otros,
                        status:this.status,
                        desc_area:this.desc_area,
                        desc_subarea:this.desc_subarea,
                    })
                        .then(response => {
                            $("#modalcanalizacion").modal("hide");
                            this.popToast('Alumno Canalizado');
                            this.getAlumnos();
                        });
                },
                acanaliza: function (alumno) {
                    this.hora="";
                    this.aspectos_sociologicos1="";
                    this.aspectos_sociologicos2="";
                    this.aspectos_sociologicos3="";
                    this.aspectos_academicos1="";
                    this.aspectos_academicos2="";
                    this.aspectos_academicos3="";
                    this.status="";
                    this.desc_area="";
                    this.desc_subarea="";

                    axios.post(this.canalizaciona, {id: alumno.id_alumno}).then(response => {
                        this.can.va.grupo = response.data.va[0].grupo;
                        this.can.va.nombre = response.data.va[0].nombre;
                        this.can.va.apaterno = response.data.va[0].apaterno;
                        this.can.va.amaterno = response.data.va[0].amaterno;
                        this.can.va.carrera = response.data.va[0].carrera;
                        this.can.va.descripcion = response.data.va[0].semestre;
                        this.can.va.id_alumno = response.data.va[0].id_alumno;
                        this.can.va.nombre_tut = response.data.va[0].nombre_tut;
                        /////areas
                        this.can.va.fecha_canalizacion = response.data.va[0].fecha_canalizacion;
                        this.can.va.observaciones = response.data.va[0].observaciones;
                        this.can.va.aspectos_sociologicos1 = response.data.va[0].aspectos_sociologicos1;
                        this.can.va.aspectos_sociologicos2 = response.data.va[0].aspectos_sociologicos2;
                        this.can.va.aspectos_sociologicos3 = response.data.va[0].aspectos_sociologicos3;
                        this.can.va.aspectos_academicos1 = response.data.va[0].aspectos_academicos1;
                        this.can.va.aspectos_academicos2 = response.data.va[0].aspectos_academicos2;
                        this.can.va.aspectos_academicos3 = response.data.va[0].aspectos_academicos3;
                        this.can.va.otros = response.data.va[0].otros;
                        this.can.va.status = response.data.va[0].status;
                        this.can.va.desc_area = response.data.va[0].desc_area;
                        this.can.va.desc_subarea = response.data.va[0].desc_subarea;
                        /////
                        $("#actualizacanalizacion").modal("show");
                    });
                },
                submitActualiza: function(){
                    axios.post(this.pruebact,  {
                        id_alumno: this.can.va.id_alumno,
                        fecha_canalizacion:this.can.va.fecha_canalizacion,
                        hora:this.hora,
                        observaciones:this.can.va.observaciones,
                        aspectos_sociologicos1:this.aspectos_sociologicos1,
                        aspectos_sociologicos2:this.aspectos_sociologicos2,
                        aspectos_sociologicos3:this.aspectos_sociologicos3,
                        aspectos_academicos1:this.aspectos_academicos1,
                        aspectos_academicos2:this.aspectos_academicos2,
                        aspectos_academicos3:this.aspectos_academicos3,
                        otros:this.can.va.otros,
                        status:this.status,
                        desc_area:this.desc_area,
                        desc_subarea:this.desc_subarea,
                    })
                        .then(response => {
                            $("#actualizacanalizacion").modal("hide");
                            this.popToast('Datos Actualizados');
                        });
                },
                seleccionact:function(alumno){

                    //alert(alumno.id_plan_actividad);
/*
                    axios.post(this.verestra, {id_gen: alumno.id_plan_actividad,
                        id_plan:alumno.id_asigna_planeacion_actividad }).then(response => {
                        this.estra.planeacion.id_ = response.data.planeacion[0].id_asigna_planeacion_actividad;
                        this.estra.planeacion.id_asigna_generacion = response.data.planeacion[0].id_asigna_generacion;
                        $("#modalseleccionactividad").modal("show");
                    });

 */
                    this.estra.planeacion.id_plan_actividad = alumno.id_plan_actividad;
                    this.estra.planeacion.id_asigna_generacion = this.idasigna;
                    $("#modalseleccionactividad").modal("show");
                },
                getagregar_semestre:function (grupo){

                    this.datos_generacion.carrera = grupo.nombre;
                        this.datos_generacion.generacion = grupo.generacion;
                        this.datos_generacion.grupo = grupo.grupo;
                        this.datos_generacion.id_asigna_tutor = grupo.id_asigna_tutor;
                    this.datos_generacion.id_grupo_tutoria = 0;

                    $("#modal_agregar_semestre_grupo").modal("show");
                },
                guardar_semestre_grupo:function (){

                 if(  this.datos_generacion.id_grupo_tutoria == 0){
                     alert('Selecciona semestre del grupo')
                 }else{
                     axios.post(this.reg_semestre_grupo,  {
                         id_asigna_tutor: this.datos_generacion.id_asigna_tutor,
                         id_grupo_tutoria: this.datos_generacion.id_grupo_tutoria,
                     }).then(response => {
                             $("#modal_agregar_semestre_grupo").modal("hide");
                             this.popToast('Semestre registrado');
                         this.getTut();
                         });
                 }
                },
                geteditar_semestre: function (grupo){

                    this.datos_generacion.carrera = grupo.nombre;
                    this.datos_generacion.generacion = grupo.generacion;
                    this.datos_generacion.grupo = grupo.grupo;
                    this.datos_generacion.id_grupo_tutoria = grupo.id_grupo_tutorias;
                    this.datos_generacion.id_semestre_grupo = grupo.id_grupo_semestre;

                    $("#modal_modificar_semestre_grupo").modal("show");

                },
                guardar_mod_semestre_grupo:function (){
                    axios.post(this.mod_semestre_grupo,  {
                        id_semestre_grupo: this.datos_generacion.id_semestre_grupo,
                        id_grupo_tutoria: this.datos_generacion.id_grupo_tutoria,
                    }).then(response => {
                        $("#modal_modificar_semestre_grupo").modal("hide");
                        this.popToast('Modificar semestre');
                        this.getTut();
                    });
                },
                enviaseleccionado: function(){
                    axios.post(this.enviasele,  {
                        id_plan_actividad:this.estra.planeacion.id_plan_actividad,
                        id_asigna_generacion:this.estra.planeacion.id_asigna_generacion,
                    })
                        .then(response => {
                            $("#modalseleccionactividad").modal("hide");
                            this.popToast('Actividad agregada a la planeación');
                            this.getplaneacion();
                        });
                },
                verestrategia: function (alumno) {
                 // alert(alumno.id_asigna_planeacion_tutor);
                    /*
                   axios.post(this.verestra, {id_gen: alumno.id_asigna_generacion,
                        id_plan:alumno.id_asigna_planeacion_tutor }).then(response => {
                        this.estra.planeacion.id_asigna_planeacion_tutor = response.data.planeacion[0].id_asigna_planeacion_actividad;
                        this.estra.planeacion.id_asigna_generacion = response.data.planeacion[0].id_asigna_generacion;
                        $("#modalestrategia").modal("show");
                    });

                     */
                    this.estra.planeacion.id_asigna_planeacion_tutor = alumno.id_asigna_planeacion_tutor;
                    this.estra.planeacion.id_asigna_generacion = alumno.id_asigna_generacion;
                    $("#modalestrategia").modal("show");

                },
                actualizaestra: function () {
                    axios.post(this.enviaestra,  {
                        id_asigna_planeacion_tutor:this.estra.planeacion.id_asigna_planeacion_tutor,
                        id_asigna_generacion:this.estra.planeacion.id_asigna_generacion,
                        estrategia:this.estrategia,
                        requiere_evidencia:this.requiere_evidencia,
                    })
                        .then(response => {
                            this.estrategia="";
                            this.requiere_evidencia=false;
                            $("#modalestrategia").modal("hide");
                            this.popToast('Estrategia agregada');
                            this.getAlumnos1();
                        });
                },
                verest: function (alumno) {
                    axios.post(this.verenviado, {id_gen: alumno.id_asigna_generacion,
                        id_asigna_planeacion_tutor:alumno.id_asigna_planeacion_tutor }).then(response => {
                        this.ingresado.env.id_asigna_planeacion_tutor = response.data.env[0].id_asigna_planeacion_tutor;
                        this.ingresado.env.id_asigna_generacion = response.data.env[0].id_asigna_generacion;
                        this.ingresado.env.estrategia = response.data.env[0].estrategia;
                        this.ingresado.env.requiere_evidencia = response.data.env[0].requiere_evidencia;
                        $("#modalnuevaestra").modal("show");
                    });
                },
                nueva:function(){
                    axios.post(this.nuevaes,  {
                        id_asigna_planeacion_tutor:this.ingresado.env.id_asigna_planeacion_tutor,
                        id_asigna_generacion:this.ingresado.env.id_asigna_generacion,
                        estrategia:this.ingresado.env.estrategia,
                        requiere_evidencia:this.ingresado.env.requiere_evidencia,
                    })
                        .then(response => {
                            $("#modalnuevaestra").modal("hide");
                            this.popToast('Estrategia Actualizada');
                            this.getAlumnos1();
                        });
                },
                borra_institucion: function () {
                    this.alu.academicos.institucion = null;
                    this.alu.academicos.semestres_cursados = null;
                },
                borra_trabaja: function () {
                    this.alu.generales.ocupacion = null;
                    this.alu.generales.horario = null;
                },
                borra_beca: function () {
                    this.alu.generales.id_expbeca = null;
                },
                pdf: function () {
                    axios.post(this.pd, {
                        id_asigna_generacion: this.idasigna,
                        id_carrera: this.idca,
                        generacion: this.gen
                    }, {
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
                pdf1: function () {
                    axios.post(this.pl, {
                        id_asigna_generacion: this.idasigna,
                        id_carrera: this.idca,
                        generacion: this.gen
                    }, {
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
                reporte: function () {
                    axios.post(this.rep, {
                        id_carrera: this.idca,
                        generacion_grupo: this.gen,
                        imagen: this.direcciones_img,
                        cargo:"tutor"
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
                },
                pdfAlumno: function (alumno) {
                    axios.post(this.palu, {id_alumno: alumno.id_alumno}, {
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
                pdfCana: function (alumno) {
                    axios.post(this.pdfcan, {id_alumno: alumno.id_alumno}, {
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
