
<div class="modal fade " id="modalgraficas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header alert alert-primary">
                <h4 class=" font-weight-bold modal-title col-10">Estadísticas</h4>
                @if(\Illuminate\Support\Facades\Session::get('PuestoTutorias')=='coordinadorgeneral')
                    <button target="_blank" v-if="inst==false" @click="reporte('ReporteCarrera')" class="btn text-white btn-danger offset-1" ><i class="fas fa-file-pdf"></i></button>
                    <button target="_blank" v-if="inst==true" @click="reporte('ReporteInstitucional')" class="btn text-white btn-danger offset-1" ><i class="fas fa-file-pdf"></i></button>
                 @elseif (\Illuminate\Support\Facades\Session::get('PuestoTutorias')=='desarrollo')
                    <button target="_blank" v-if="inst==false" @click="DatosReporte()" class="btn text-white btn-danger offset-1" ><i class="fas fa-file-pdf"></i></button>
                    <button target="_blank" v-if="inst==true" @click="DatosReporte()" class="btn text-white btn-danger offset-1" ><i class="fas fa-file-pdf"></i></button>
                @endif
                    <button type="button col-1" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">
                <div class="col-12">
                    <div class="row text-center"><div class="col-4 graf offset-4" id="genero1"></div></div>
                    <div class="row pl-4">
                        <div class="col-12">
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
                                                        <div class="col-10 offset-1"><h5 class="alert alert-info text-center font-weight-bold">¿Otro programa iniciado?</h5></div>
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
                                                        <div class="col-4 graf" id="bag"></div>
                                                        <div class="col-4 graf" id="baf"></div>
                                                        <div class="col-4 graf" id="bam"></div>
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
                                                        <div class="col-4 graftb" id="tg"></div>
                                                        <div class="col-4 graftb" id="tf"></div>
                                                        <div class="col-4 graftb" id="tm"></div>
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

