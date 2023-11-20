@extends('layouts.app')
@section('title', 'Centro de Computo')
@section('content')

    <main class="col-md-12">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Estado armar horarios <br>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div id="envio_doc">

        </div>

    </main>

    <script>
        new Vue({
            el:"#envio_doc",

            data(){
                return {

                    //lo inicialisamos el array
                    documentacion:[],

                    titulo_pago_concepto_autenticacion:"",

                }
            },
            methods: {
                //meetodo para mostrar tabla
                async Documentacion() {
                    //llamar datos al controlador
                    swal({
                        title:"",
                        text:"Cargando...",
                        buttons: false,
                        closeOnClickOutside: false,
                        timer: 5000,
                        //icon: "success"
                    });
                    const contar = await axios.get('/titulacion/estado_actual_fecha/{{$id_alumno}}');
                    this.fecha_activa = contar.data;
                    const verificacion_reg_doc = await axios.get('/titulacion/est_actual_doc_al/{{$id_alumno}}');
                    this.est_actual_doc_al = verificacion_reg_doc.data;
                    const verificacion_const_ing = await axios.get('/titulacion/veri_constancia_ingles/{{$id_alumno}}');
                    this.veri_constancia_ingles = verificacion_const_ing.data;
                    const veri_egel_al= await axios.get('/titulacion/veri_egel_al/{{$id_alumno}}');
                    this.veri_egel = veri_egel_al.data;
                    const veri_ante_2010= await axios.get('/titulacion/veri_ante_2010/{{$id_alumno}}');
                    this.veri_anterior_10 = veri_ante_2010.data;



                    if(this.veri_constancia_ingles == 2){
                        const certificado_ingles = await axios.get('/titulacion/status_certi_ingles/{{$id_alumno}}');
                        this.estado_certi_in = certificado_ingles.data;
                        this.ingles.id_certificado_acreditacion=this.estado_certi_in[0].id_certificado_acreditacion;
                        this.ingles.pdf_certificado=this.estado_certi_in[0].pdf_certificado;
                        this.ingles.id_alumno=this.estado_certi_in[0].id_alumno;
                        this.ingles.estado_cert=this.estado_certi_in[0].estado_cert;
                    }
                    if(this.est_actual_doc_al > 0){
                        const doc = await axios.get('/titulacion/documentacion_alumno/{{$id_alumno}}');
                        this.documentacion = doc.data;

                        this.docu.id_requisitos =this.documentacion[0].id_requisitos;
                        this.docu.id_alumno =this.documentacion[0].id_alumno;

                        this.docu.evi_acta_nac =this.documentacion[0].evi_acta_nac;
                        this.docu.comentario_acta_nac =this.documentacion[0].comentario_acta_nac;
                        this.docu.pdf_acta_nac =this.documentacion[0].pdf_acta_nac;
                        this.docu.estado_acta_nac =this.documentacion[0].estado_acta_nac;
                        this.docu.cal_acta_nac  =this.documentacion[0].cal_acta_nac ;

                        this.docu.evi_curp =this.documentacion[0].evi_curp;
                        this.docu.comentario_curp =this.documentacion[0].comentario_curp;
                        this.docu.pdf_curp =this.documentacion[0].pdf_curp;
                        this.docu.estado_curp =this.documentacion[0].estado_curp;

                        this.docu.evi_certificado_prep =this.documentacion[0].evi_certificado_prep;
                        this.docu.comentario_certificado_prep =this.documentacion[0].comentario_certificado_prep;
                        this.docu.pdf_certificado_prep =this.documentacion[0].pdf_certificado_prep;
                        this.docu.estado_certificado_prep =this.documentacion[0].estado_certificado_prep;

                        this.docu.evi_certificado_tesvb =this.documentacion[0].evi_certificado_tesvb;
                        this.docu.comentario_certificado_tesvb =this.documentacion[0].comentario_certificado_tesvb;
                        this.docu.pdf_certificado_tesvb =this.documentacion[0].pdf_certificado_tesvb;
                        this.docu.estado_certificado_tesvb =this.documentacion[0].estado_certificado_tesvb;

                        this.docu.evi_constancia_ss =this.documentacion[0].evi_constancia_ss;
                        this.docu.comentario_constancia_ss =this.documentacion[0].comentario_constancia_ss ;
                        this.docu.pdf_constancia_ss =this.documentacion[0].pdf_constancia_ss;
                        this.docu.estado_constancia_ss =this.documentacion[0].estado_constancia_ss;

                        this.docu.evi_certificado_acred_ingles =this.documentacion[0].evi_certificado_acred_ingles;
                        this.docu.comentario_certificado_acred_ingles =this.documentacion[0].comentario_certificado_acred_ingles ;
                        this.docu.pdf_certificado_acred_ingles =this.documentacion[0].pdf_certificado_acred_ingles;
                        this.docu.estado_certificado_acred_ingles =this.documentacion[0].estado_certificado_acred_ingles;

                        this.docu.evi_reporte_result_egel =this.documentacion[0].evi_reporte_result_egel;
                        this.docu.comentario_reporte_result_egel =this.documentacion[0].comentario_reporte_result_egel ;
                        this.docu.pdf_reporte_result_egel =this.documentacion[0].pdf_reporte_result_egel;
                        this.docu.estado_reporte_result_egel =this.documentacion[0].estado_reporte_result_egel;


                        this.docu.id_opcion_titulacion =this.documentacion[0].id_opcion_titulacion;

                        this.docu.evi_opcion_titulacion =this.documentacion[0].evi_opcion_titulacion;
                        this.docu.comentario_opcion_titulacion =this.documentacion[0].comentario_opcion_titulacion ;
                        this.docu.pdf_opcion_titulacion =this.documentacion[0].pdf_opcion_titulacion;
                        this.docu.estado_opcion_titulacion =this.documentacion[0].estado_opcion_titulacion;

                        this.docu.evi_pago_titulo =this.documentacion[0].evi_pago_titulo;
                        this.docu.comentario_pago_titulo =this.documentacion[0].comentario_pago_titulo ;
                        this.docu.pdf_pago_titulo =this.documentacion[0].pdf_pago_titulo;
                        this.docu.estado_pago_titulo =this.documentacion[0].estado_pago_titulo;

                        this.docu.evi_pago_contancia =this.documentacion[0].evi_pago_contancia;
                        this.docu.comentario_pago_contancia =this.documentacion[0].comentario_pago_contancia ;
                        this.docu.pdf_pago_contancia =this.documentacion[0].pdf_pago_contancia;
                        this.docu.estado_pago_contancia =this.documentacion[0].estado_pago_contancia;

                        this.docu.evi_pago_derecho_ti =this.documentacion[0].evi_pago_derecho_ti;
                        this.docu.comentario_pago_derecho_ti =this.documentacion[0].comentario_pago_derecho_ti ;
                        this.docu.pdf_pago_derecho_ti =this.documentacion[0].pdf_pago_derecho_ti;
                        this.docu.estado_pago_derecho_ti =this.documentacion[0].estado_pago_derecho_ti;

                        this.docu.evi_pago_integrante_jurado =this.documentacion[0].evi_pago_integrante_jurado;
                        this.docu.comentario_pago_integrante_jurado =this.documentacion[0].comentario_pago_integrante_jurado ;
                        this.docu.pdf_pago_integrante_jurado =this.documentacion[0].pdf_pago_integrante_jurado;
                        this.docu.estado_pago_integrante_jurado =this.documentacion[0].estado_pago_integrante_jurado;

                        this.docu.evi_acta_residencia =this.documentacion[0].evi_acta_residencia;
                        this.docu.comentario_acta_residencia =this.documentacion[0].comentario_acta_residencia ;
                        this.docu.pdf_acta_residencia =this.documentacion[0].pdf_acta_residencia;
                        this.docu.estado_acta_residencia =this.documentacion[0].estado_acta_residencia;

                        this.docu.evi_pago_concepto_autenticacion =this.documentacion[0].evi_pago_concepto_autenticacion;
                        this.docu.comentario_pago_concepto_autenticacion =this.documentacion[0].comentario_pago_concepto_autenticacion ;
                        this.docu.pdf_pago_concepto_autenticacion =this.documentacion[0].pdf_pago_concepto_autenticacion;
                        this.docu.estado_pago_concepto_autenticacion =this.documentacion[0].estado_pago_concepto_autenticacion;

                        this.docu.correo_electronico =this.documentacion[0].correo_electronico;
                        this.docu.id_estado_enviado =this.documentacion[0].id_estado_enviado;


                    }
                    const opciones_titulacion = await axios.get('/titulacion/opciones_titulacion/{{ $id_alumno }}/');
                    this.opciones_titulacion = opciones_titulacion.data;





                },
                async abrir_guardar_correo(){
                    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.correo_electronico)) {
                        const resultado= await axios.post('/titulacion/reg_correo_alumno/{{$id_alumno}}/'+this.correo_electronico);
                        this.Documentacion();
                        this.file ='';
                        this.estado_guardar_correo=true;
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    } else {
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa un correo electronico",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                },
                async abrir_modificar_correo(){
                    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.docu.correo_electronico)) {
                        const resultado= await axios.post('/titulacion/modificar_correo_alumno/'+this.docu.id_requisitos+'/'+this.docu.correo_electronico);
                        this.Documentacion();

                        swal({
                            position: "top",
                            type: "success",
                            title: "Modificación exitosa",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    } else {
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa un correo electronico",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                },
                async abrirModal_agregar_acta(){
                    this.estado_guardar_acta=false;
                    this.modal_acta_reg=1;
                    if(this.modificar_acta == true){
                        this.titulo_acta="Modificar Documentación";
                    }else{
                        this.titulo_acta="Registrar Documentación"
                    }
                },

                async abrirModal_agregar_curp(){
                    this.estado_guardar_curp=false;
                    this.modal_curp_reg=1;
                    if(this.modificar_curp == true){
                        this.titulo_curp="Modificar Documentación";
                    }else{
                        this.titulo_curp="Registrar Documentación"
                    }
                },
                async  abrirModal_agregar_certificado_prepa(){
                    this.estado_guardar_certificado_prepa=false;
                    this.modal_certificado_prepa_reg=1;
                    if(this.modificar_certificado_prepa == true){
                        this.titulo_certificado_prepa="Modificar Documentación";
                    }else{
                        this.titulo_certificado_prepa="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_tesvb(){
                    this.estado_guardar_certificado_tesvb=false;
                    this.modal_certificado_tesvb_reg=1;
                    if(this.modificar_certificado_tesvb == true){
                        this.titulo_certificado_tesvb="Modificar Documentación";
                    }else{
                        this.titulo_certificado_tesvb="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_constancia_ss(){
                    this.estado_guardar_constancia_ss=false;
                    this.modal_constancia_ss_reg=1;
                    if(this.modificar_constancia_ss == true){
                        this.titulo_constancia_ss="Modificar Documentación";
                    }else{
                        this.titulo_constancia_ss="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_certificado_ingles(){
                    this.estado_guardar_certificado_ingles=false;
                    this.modal_certificado_ingles_reg=1;
                    if(this.modificar_certificado_ingles == true){
                        this.titulo_certificado_ingles="Modificar Documentación";
                    }else{
                        this.titulo_certificado_ingles="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_reporte_result_egel(){
                    this.estado_guardar_reporte_egel=false;
                    this.modal_reporte_result_egel=1;
                    if(this.modificar_reporte_result_egel == true){
                        this.titulo_reporte_result_egel="Modificar Documentación";
                    }else{
                        this.titulo_reporte_result_egel="Registrar Documentación"
                    }

                },
                async abrirModal_agregar_opciones_titulacion() {
                    this.estado_guardar_opcion_titulacion=false;
                    this.modal_opcion_titulacion_reg=1;
                    if(this.modificar_opcion_titulacion == true){
                        this.titulo_opcion_titulacion="Modificar Documentación";
                    }else{
                        this.titulo_opcion_titulacion="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_pago_titulo(){
                    this.estado_guardar_pago_titulo=false;
                    this.modal_pago_titulo=1;
                    if(this.modificar_pago_titulo == true){
                        this.titulo_pago_titulo="Modificar Documentación";
                    }else{
                        this.titulo_pago_titulo="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_pago_contancia(){
                    this.estado_guardar_pago_contancia=false;
                    this.modal_pago_contancia=1;
                    if(this.modificar_pago_contancia == true){
                        this.titulo_pago_contancia="Modificar Documentación";
                    }else{
                        this.titulo_pago_contancia="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_pago_derecho_ti(){
                    this.estado_guardar_pago_derecho_ti=false;
                    this.modal_pago_derecho_ti=1;
                    if(this.modificar_pago_derecho_ti == true){
                        this.titulo_pago_derecho_ti="Modificar Documentación";
                    }else{
                        this.titulo_pago_derecho_ti="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_pago_integrante_jurado(){
                    this.estado_guardar_pago_integrante_jurado=false;
                    this.modal_pago_integrante_jurado=1;
                    if(this.modificar_pago_integrante_jurado == true){
                        this.titulo_pago_integrante_jurado="Modificar Documentación";
                    }else{
                        this.titulo_pago_integrante_jurado="Registrar Documentación"
                    }
                },
                async abrirModal_agregar_acta_residencia(){
                    this.estado_guardar_acta_residencia=false;
                    this.modal_acta_residencia=1;
                    if(this.modificar_acta_residencia == true){
                        this.titulo_acta_residencia="Modificar Documentación";
                    }else{
                        this.titulo_acta_residencia="Registrar Documentación"
                    }
                },
                async abrirModal_pago_concepto_autenticacion(){

                    this.estado_guardar_pago_concepto_autenticacion=false;
                    this.modal_pago_concepto_autenticacion=1;
                    if(this.modificar_pago_concepto_autenticacion == true){
                        this.titulo_pago_concepto_autenticacion="Modificar Documentación";
                    }else{
                        this.titulo_pago_concepto_autenticacion="Registrar Documentación"
                    }

                },
                async abrirModalenviar(){
                    this.estado_enviar=false;
                    this.modal_enviar=1;
                },
                variable_doc_1(event){
                    this.file = event.target.files[0];
                },
                variable_doc_2(event){
                    this.file2 = event.target.files[0];
                },
                variable_doc_3(event){
                    this.file3 = event.target.files[0];
                },
                variable_doc_4(event){
                    this.file4 = event.target.files[0];
                },
                variable_doc_5(event){
                    this.file5 = event.target.files[0];
                },
                variable_doc_6(event){
                    this.file6 = event.target.files[0];
                },
                variable_doc_7(event){
                    this.file7 = event.target.files[0];
                },
                variable_doc_8(event){
                    this.file8 = event.target.files[0];
                },
                variable_doc_9(event){
                    this.file9 = event.target.files[0];
                },
                variable_doc_10(event){
                    this.file10 = event.target.files[0];
                },
                variable_doc_11(event){
                    this.file11 = event.target.files[0];
                },
                variable_doc_12(event){
                    this.file12 = event.target.files[0];
                },
                variable_doc_13(event){
                    this.file13 = event.target.files[0];
                },
                variable_doc_14(event){
                    this.file14 = event.target.files[0];
                },
                async guardar_doc_acta(){
                    let data = new FormData();


                    let file=this.file;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_acta = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_acta_nacimiento/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_acta_nac();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_curp(){
                    let data = new FormData();


                    let file=this.file2;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_curp = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_curp/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_curp();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_certificado_prepa(){
                    let data = new FormData();
                    let file=this.file3;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_certificado_prepa = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_certificado_prepa/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_certificado_prepa();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_certificado_tec(){
                    let data = new FormData();
                    let file=this.file4;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_certificado_tesvb = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_certificado_tec/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_certificado_tec();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_constancia_ss(){
                    let data = new FormData();
                    let file=this.file5;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_constancia_ss = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_constancia_ss/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_constancia_ss();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_certificado_ingles(){
                    let data = new FormData();
                    let file=this.file6;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_certificado_ingles = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_certificado_ingles/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_certificado_ingles();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_reporte_result_egel(){
                    let data = new FormData();
                    let file=this.file8;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_reporte_egel = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_reporte_result_egel/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_reporte_result_egel();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_opcion_titulacion(){
                    if(this.docu.id_opcion_titulacion == 1  || this.docu.id_opcion_titulacion == 2 ||
                        this.docu.id_opcion_titulacion == 3 || this.docu.id_opcion_titulacion == 4 ||
                        this.docu.id_opcion_titulacion == 5 || this.docu.id_opcion_titulacion == 6 ||
                        this.docu.id_opcion_titulacion == 7 ||
                        this.docu.id_opcion_titulacion == 9 || this.docu.id_opcion_titulacion == 10){
                        let data = new FormData();
                        let file=this.file7;
                        if( file == ''){
                            swal({
                                position: "top",
                                type: "warning",
                                title: "El campo se encuentra  vacío.",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else {

                            this.estado_guardar_opcion_titulacion = true;
                            data.append('name', 'my-file')
                            data.append('file', file)

                            let config = {
                                header: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }
                            const resultado= await axios.post('/titulacion/registrar_opcion_titulacion/'+this.docu.id_requisitos+'/'+this.docu.id_opcion_titulacion, data, config);

                            this.cerrarModal_opciones_titulacion();
                            this.Documentacion();
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });

                        }
                    }else{

                        const resultado= await axios.post('/titulacion/reg_opc_ti_sin_doc/'+this.docu.id_requisitos+'/'+this.docu.id_opcion_titulacion);
                        this.cerrarModal_opciones_titulacion();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                },
                async guardar_doc_pago_titulo(){
                    let data = new FormData();
                    let file=this.file9;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_pago_titulo = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_pago_titulo/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_pago_titulo();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },

                async guardar_doc_pago_constancia(){
                    let data = new FormData();
                    let file=this.file10;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_pago_contancia = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_pago_constancia/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_pago_contancia();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_pago_derecho_ti(){
                    let data = new FormData();
                    let file=this.file11;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_pago_derecho_ti = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_pago_derecho_ti/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_pago_derecho_ti();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_pago_integrante_jurado(){
                    let data = new FormData();
                    let file=this.file12;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_pago_integrante_jurado = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_pago_integrante_jurado/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_pago_integrante_jurado();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_pago_concepto_autenticacion(){
                    let data = new FormData();
                    let file=this.file14;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_pago_concepto_autenticacion = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_pago_concepto_autenticacion/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_pago_concepto_autenticacion();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },
                async guardar_doc_acta_residencia(){
                    let data = new FormData();
                    let file=this.file13;
                    if( file == ''){
                        swal({
                            position: "top",
                            type: "warning",
                            title: "El campo se encuentra  vacío.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {

                        this.estado_guardar_acta_residencia = true;
                        data.append('name', 'my-file')
                        data.append('file', file)

                        let config = {
                            header: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        const resultado= await axios.post('/titulacion/registrar_acta_residencia/'+this.docu.id_requisitos, data, config);

                        this.cerrarModal_acta_residencia();
                        this.Documentacion();
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });

                    }
                },

                async guardar_enviar(){
                    this.estado_enviar=true;
                    const resultado= await axios.post('/titulacion/guardar_enviar_doc_titulacion/'+this.docu.id_requisitos);
                    this.cerrarModal_enviar();
                    this.Documentacion();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Envio correcto",
                        showConfirmButton: false,
                        timer: 3500
                    });


                },
                async abrirModalenviar_correciones(){
                    this.modal_enviar_correcciones=1;
                    this.estado_enviar_correcciones=false;

                },
                async guardar_enviar_correcciones(){
                    this.estado_enviar_correcciones=true;
                    const resultado= await axios.post('/titulacion/enviar_doc_correcciones/'+this.docu.id_requisitos, this.docu);

                    this.cerrarModal_enviar_correcciones();
                    this.Documentacion();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Envio correcto",
                        showConfirmButton: false,
                        timer: 3500
                    });
                },
                async cerrarModal_enviar_correcciones(){
                    this.modal_enviar_correcciones=0;
                },
                async cerrarModal_acta_nac(){
                    this.modal_acta_reg=0;
                },
                async cerrarModal_curp(){
                    this.modal_curp_reg=0;
                },
                async cerrarModal_certificado_prepa(){
                    this.modal_certificado_prepa_reg=0;
                },
                async cerrarModal_certificado_tec(){
                    this.modal_certificado_tesvb_reg=0;
                },
                async cerrarModal_constancia_ss(){
                    this.modal_constancia_ss_reg=0;
                },
                async cerrarModal_certificado_ingles(){
                    this.modal_certificado_ingles_reg=0;
                },
                async cerrarModal_reporte_result_egel(){
                    this.modal_reporte_result_egel=0;
                },
                async cerrarModal_opciones_titulacion(){
                    this.modal_opcion_titulacion_reg=0;
                },
                async cerrarModal_pago_titulo(){
                    this.modal_pago_titulo=0;
                },
                async cerrarModal_pago_contancia(){
                    this.modal_pago_contancia=0;
                },
                async cerrarModal_pago_derecho_ti(){
                    this.modal_pago_derecho_ti=0;
                },
                async cerrarModal_pago_integrante_jurado(){
                    this.modal_pago_integrante_jurado=0;
                },
                async cerrarModal_enviar(){
                    this.modal_enviar=0;
                },
                async cerrarModal_acta_residencia(){
                    this.modal_acta_residencia=0;
                },
                async cerrarModal_pago_concepto_autenticacion(){
                    this.modal_pago_concepto_autenticacion=0;
                },



            },
            //funciones para cuando se cargue la vista
            async created(){
                //disparar la funcion
                this.Documentacion();

            },

        })
    </script>
    <style>
        .mostrar{
            display: list-item;
            opacity: 1;
            background: rgba(44,38,75,0.849);
        }
    </style>

@endsection