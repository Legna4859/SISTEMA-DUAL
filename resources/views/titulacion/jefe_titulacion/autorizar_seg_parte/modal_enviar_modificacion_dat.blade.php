<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_enviar_moficaciones}" >
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_enviar_modificacion();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Enviar modificaciones al estudiante</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="domicilio3">Modificaciones: <b style="color:red; font-size:23px;">*</b></label>
                            <textarea class="form-control" id="comentario_modificacion" v-model="comentario_modificacion" name="comentario_modificacion" rows="3"  onkeyup="javascript:this.value=this.value.toUpperCase();"  required></textarea>
                            <p v-if="comentario_modificacion ==''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h4>¿ Seguro que quieres enviar  las modificaciones al estudiante?</h4>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_enviar_modificacion();">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="enviar_modificaciones();" :disabled="estado_guardar_autorizar">Aceptar</button>
                </div>
            </div>
        </div>

    </div>
</div>