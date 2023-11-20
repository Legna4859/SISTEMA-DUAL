@extends('tutorias.app_tutorias')
@section('content')
    <div class="container" id="alumnoP">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">Estudiantes</div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link active" id="generacion-tab" data-toggle="tab" href="#generacion" role="tab"  aria-controls="generacion" aria-selected="false">Generaciones</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade pt-4 show active" id="generacion" role="tabpanel" aria-labelledby="generacion-tab">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" v-for="gen in generacion">
                                            <a class="nav-link border m-1" @click="borrarAlumno(gen.generacion)" :id="'pills-'+gen.generacion+'-tab'" data-toggle="pill" :href="'#pills-'+gen.generacion" role="tab" :aria-controls="'pills-'+gen.generacion" aria-selected="true">@{{ gen.generacion }}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade " v-for="gen in generacion" :id="'pills-'+gen.generacion" role="tabpanel" :aria-labelledby="'pills-'+gen.generacion+'-tab'">
                                            <div class="row border-bottom">
                                                <div class="col-12">
                                                    <div class="row pb-3 pl-3">
                                                        <button type="button" class="btn btn-outline-success" @click="confirma(gen)"> <i class="fas fa-plus"></i> Crear grupo</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nav nav-pills mb-3" id="grupo-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link border m-1" @click="getAlumnosGeneracion(gen.generacion)" id="pills-generalgen-tab" data-toggle="pill" href="#generalgen" role="tab" aria-controls="'pills-generalgen" >General</a>
                                                </li>
                                                <li class="nav-item btn-group" v-for="grupo in gen.grupos">
                                                    <a class="nav-link border m-1 "  @click="getAlumnosGrupo(grupo.id_asigna_generacion)" :id="'pills-'+grupo.id_asigna_generacion+'-tab'" data-toggle="pill" :href="'#pills-'+grupo.id_asigna_generacion" role="tab" :aria-controls="'pills-'+grupo.id_asigna_generacion">Grupo @{{ grupo.grupo }}</a>
                                                    <a href="#"><i class="fas text-danger fa-times h4 pt-3" data-toggle="tooltip" data-placement="bottom" title="Eliminar Grupo" @click="ConfirmaBorrar(grupo)"></i></a>
                                                </li>
                                            </ul>
                                            <div class="row border-bottom-1" >
                                                <div class="col-12">
                                                    <div class="row pb-3 pl-3">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-content" id="grupo-tabContent">
                                                <div class="row">
                                                    <div class="col-7 pb-3" v-if="(alumno.length>0)">
                                                        <form id="search">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="inputGroupPrepend3"><i class="fas fa-search"></i></span>
                                                                </div>
                                                                <input class="form-control" name="query" v-model="searchQuery" placeholder="Buscar">
                                                            </div>
                                                        </form>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label class="form-checkbox" v-if="clicgrupo" v-if="alumno.length>1">
                                                                    <input type="checkbox" v-model="selectAllE" @click="seleccionar_todosE">
                                                                    <i class="form-icon text-primary"> Seleccionar todo</i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button  type="button" @click="EliminaAlumnoE()" class="btn btn-outline-danger" v-if="alumno.length>0 && seleccionadosE.length>0">Eliminar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3 " v-bind:class="[alumno.length==0? 'offset-9': 'offset-2']" v-if="clicgrupo">
                                                        <button type="button" class="btn btn-outline-success" @click="Agregar()"> <i class="fas fa-plus"></i> Asignar estudiantes</button>
                                                    </div>
                                                </div>
                                                <div class="row" v-if="(alumno.length>0)">
                                                    <div class="col-12">
                                                        <div class="tableFixHead" id="LISTA">
                                                            <data-table class=" col-12 table table-sm" :data="alumno" :columns-to-display="gridColumns" :filter-key="searchQuery">
                                                                <template v-if="clicgrupo" slot=" " scope="alu">
                                                                    <input type="checkbox" :value="alu.entry.id_alumno" v-model="seleccionadosE">
                                                                    <i class="form-icon"></i>
                                                                </template>
                                                                <template slot="Cuenta" scope="alu">
                                                                    <div class="font-weight-bold pt-2">@{{alu.entry.cuenta}}</div>
                                                                </template>
                                                                <template slot="Nombre" scope="alu">
                                                                    <div class="pt-2">@{{ alu.entry.apaterno }} @{{ alu.entry.amaterno}} @{{ alu.entry.nombre }}</div>
                                                                </template>
                                                                <template slot="Acción" scope="alu">
                                                                    <div v-if="clicgrupo"><button class="btn btn-outline-danger" @click="ConfirmaAlumno(alu.entry)"><i class="fas fa-times" data-toggle="tooltip" data-placement="bottom" title="Eliminar"></i></button></div>
                                                                </template>
                                                               <template v-if="clicgeneracion" slot="Revalidación" scope="alu">
                                                                    <a v-if="alu.entry.revalidacion==0" @click="confirmaRevalidacion(alu.entry)" class="pt-2 cursorM"><i class="fas fa-toggle-off text-secondary h1" data-toggle="tooltip" data-placement="bottom" title="Desactivado"></i></a>
                                                                    <a v-if="alu.entry.revalidacion==1" @click="quitaRevalidacion(alu.entry)" class="pt-2 cursorM"><i class="fas fa-toggle-on text-secondary h1" data-toggle="tooltip" data-placement="bottom" title="Activo"></i></a>
                                                                </template>
                                                                <template slot="nodata">
                                                                    <div class=" alert font-weight-bold alert-danger text-center">Ningún dato encontrado</div>
                                                                </template>
                                                            </data-table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row pt-3" v-if="alumno.length==0 && clicgrupo==true">
                                                <div class="col-12 border-danger">
                                                    <h5 class="font-weight-bold text-center alert alert-danger">No existen estudiantes asignados al grupo</h5>
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
        @include('tutorias.alumno.modalCrearGrupo')
        @include('tutorias.alumno.EliminarGrupo')
        @include('tutorias.alumno.AgregarAlumnos')
        @include('tutorias.alumno.EliminarAlumno')
        @include('tutorias.alumno.ConfirmaRevalidacion')
        @include('tutorias.alumno.QuitarRevalidacion')
        </div>
    <script>
        new Vue({
            el:"#alumnoP",
            created:function(){
                this.getGeneracion();
            },
            data:{
                gene:'/tutorias/generaciones',
                alugeneracion:'/tutorias/alumnosgeneracion',
                alugrupo:'/tutorias/alumnosgrupo',
                grup:'/tutorias/creargrupo',
                buscar:'/tutorias/buscaalumnos',
                asignar:'/tutorias/asignaralumnos',
                eliminar:'/tutorias/eliminaralumno',
                eliminarU:'/tutorias/eliminaralumnouno',
                generacion:[],
                alumno:[],
                alumnosgeneracion:[],
                idgeneracion:null,
                nomg:null,
                nomgen:null,
                idasignagen:null,
                clicgrupo:false,
                clicgeneracion:false,
                idasignageneracion:null,
                nombregeneracion:null,
                seleccionados:[],
                selectAll: false,
                seleccionadosE:[],
                selectAllE: false,
                nombrealumno:null,
                idalumno:null,
                searchQuery: '',
                searchQuery1: '',
                gridColumns: [],
                columnasM:[' ','Cuenta','Nombre'],
                id_revalida:null,
            },
            methods:{
                getGeneracion:function () {
                    axios.get(this.gene).then(response=>{
                        this.generacion=response.data;
                    }).catch(error=>{ });
                },
                getAlumnosGrupo:function (grupo) {
                   this.searchQuery='';
                    this.searchQuery1='';
                    this.idasignageneracion=grupo;
                    this.clicgrupo=true;
                    this.gridColumns= [' ','Cuenta','Nombre','Acción'];
                    this.clicgeneracion=false;
                    axios.post(this.alugrupo,{generacion:grupo}).then(response=>{
                        this.alumno=response.data;
                    }).catch(error=>{ });
                },
                getAlumnosGeneracion:function(genera)
                {
                    this.searchQuery='';
                    this.searchQuery1='';
                    this.clicgrupo=false;
                    this.gridColumns= [' ','Cuenta','Nombre','Revalidación'];
                    this.clicgeneracion=true;
                    axios.post(this.alugeneracion,{generacion:genera}).then(response=>{
                        this.alumno=response.data;
                    }).catch(error=>{ });
                },
                borrarAlumno:function (nombre) {
                    this.alumno=[];
                    this.clicgrupo=false;
                    this.nombregeneracion=nombre;
                },
                confirma:function(genera)
                {
                    this.idgeneracion=genera.id_generacion;
                    this.nomgen=genera.generacion;
                    this.nomg=genera.grupos.length+1;
                    $('#CrearGrupo').modal('show');
                },
                crearGrupo:function () {
                    axios.post(this.grup,{id_generacion:this.idgeneracion,nombre:this.nomg}).then(response=>{
                        $('#CrearGrupo').modal('hide');
                        this.getGeneracion();
                    }).catch(error=>{ });
                },
                ConfirmaBorrar:function(grupo)
                {
                    this.nomg=grupo.grupo;
                    this.idasignagen=grupo.id_asigna_generacion;
                    $('#EliminarGrupo').modal('show');
                },
                borrarGrupo:function () {
                    var url = '/tutorias/alumnos/'+this.idasignagen;
                    axios.delete(url).then(response => {
                        this.getGeneracion();
                        this.alumno=[];
                        this.clicgrupo=false;
                        this.popToast("Grupo eliminado correctamente");
                    });
                },
                Agregar:function () {
                    axios.post(this.buscar,{generacion:this.nombregeneracion,id_asigna_generacion:this.idasignageneracion}).then(response=>{
                        this.alumnosgeneracion=response.data;
                        $('#Alumnos').modal('show');
                    }).catch(error=>{ });
                },
                Guardar:function()
                {
                    axios.post(this.asignar,{alumnos:this.seleccionados,id_asigna_generacion:this.idasignageneracion}).then(response=>{
                        this.BorrarSeleccionados();
                        $('#Alumnos').modal('hide');
                        this.getAlumnosGrupo(response.data);
                        this.popToast('Registro exitoso!');
                    }).catch(error=>{ });
                },
                /*aqui*/
                EliminaAlumnoE:function () {

                    axios.post(this.eliminar,{id_alumno:this.seleccionadosE,id_asigna_generacion:this.idasignageneracion}).then(response=>{
                        this.BorrarSeleccionadosE();
                        this.getAlumnosGrupo(response.data);
                        this.popToast('Eliminado correctamente');

                    }).catch(error=>{ });
                },
                seleccionar_todos: function () {
                    this.seleccionados = [];
                    if (!this.selectAll) {
                        for (let i in this.alumnosgeneracion) {
                            this.seleccionados.push(this.alumnosgeneracion[i].id_alumno);
                        }
                    }
                },
                seleccionar_todosE: function () {
                    this.seleccionadosE = [];
                    if (!this.selectAllE) {
                        for (let i in this.alumno) {
                            this.seleccionadosE.push(this.alumno[i].id_alumno);
                        }
                    }
                },
                ConfirmaAlumno:function (alumno) {

                    this.nombrealumno=alumno.apaterno+" "+alumno.amaterno+" "+alumno.nombre;
                    this.idalumno=alumno.id_asigna_alumno;
                    $('#EliminarAlumno').modal('show');
                },
                EliminaAlumno:function () {

                    axios.post(this.eliminarU,{id_asigna_alumno:this.idalumno,id_asigna_generacion:this.idasignageneracion}).then(response=>{
                        $('#EliminarAlumno').modal('hide');
                        this.getAlumnosGrupo(response.data);
                        this.popToast('Eliminado correctamente');

                    }).catch(error=>{ });
                },
                confirmaRevalidacion:function(alumno)
                {
                    this.nombrealumno=alumno.apaterno+" "+alumno.amaterno+" "+alumno.nombre;
                    this.id_revalida=alumno.id_alumno;
                    $('#confirmarevalidacion').modal('show');
                },
                revalidaSI:function(){
                    axios.post('/tutorias/revalida',{id_alumno:this.id_revalida}).then(response=>{
                        $('#confirmarevalidacion').modal('hide');
                        this.getAlumnosGeneracion(response.data);
                        this.popToast('Asignación exitosa');
                    }).catch(error=>{ });
                },
                quitaRevalidacion:function(alumno){
                    this.nombrealumno=alumno.apaterno+" "+alumno.amaterno+" "+alumno.nombre;
                    this.id_revalida=alumno.id_alumno;
                    $('#quitarevalidacion').modal('show');
                },
                revalidaNO:function(){
                    axios.post('/tutorias/revalidano',{id_alumno:this.id_revalida}).then(response=>{
                        $('#quitarevalidacion').modal('hide');
                        this.getAlumnosGeneracion(response.data);
                        this.popToast('Se ha eliminado la revalidación correctamente');
                    }).catch(error=>{ });
                },
                BorrarSeleccionados:function () {
                    this.seleccionados=[];
                    this.selectAll=false;
                },
                BorrarSeleccionadosE:function () {
                    this.seleccionadosE=[];
                    this.selectAllE=false;
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


