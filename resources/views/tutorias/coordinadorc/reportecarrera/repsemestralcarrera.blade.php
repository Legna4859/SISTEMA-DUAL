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
                            <a href="{{url('/tutorias/reportecoordinador/repsemestralcarrera')}}" class="font-weight-bold h6 pb-1">{{\Illuminate\Support\Facades\Session::get('coordinador')>1?'Regresar':'Regresar'}}</a>
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
    </div>
@endsection