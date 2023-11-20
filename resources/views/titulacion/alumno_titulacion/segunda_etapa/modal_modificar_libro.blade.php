<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_modificar_libro}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_modificar_libro();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Modificar libro</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Titulo<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="titulo" name="titulo" type="text" v-model="lib.titulo"  placeholder="Ingresa el titulo del libro"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="lib.titulo == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Autor<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="autor" name="autor" type="text" v-model="lib.autor"  placeholder="Ingresa el autor del libro"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="lib.autor == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Editorial<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="editorial" name="editorial" type="text" v-model="lib.editorial"  placeholder="Ingresa la editorial del libro"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="lib.editorial == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_modificar_libro();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="modificacion_libro();" >Modificar</button>
                </div>
            </div>
        </div>

    </div>
</div>