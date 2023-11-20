<!-- Modal -->
<div  class="modal " :class="{mostrar:modal_agregar_computo}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_agregar_computo();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Agregar equipo y/o material didáctico</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Nombre del equipo o material didáctico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="nombre" name="nombre" type="text" v-model="comput.nombre_equipo"  placeholder="Igresa el nombre del equipo o material didáctico"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="comput.nombre_equipo == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Descripción del equipo o material didáctico<b style="color:red; font-size:23px;">*</b></label>
                            <textarea class="form-control" id="descripcion" v-model="comput.descripcion" name="descripcion" rows="2"    required></textarea>
                        </div>
                        <p v-if="comput.descripcion ==''" class="alert alert-danger">
                            Este campo es obligatorio
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Folio fiscal del equipo o material didáctico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="folio_fiscal" name="folio_fiscal" type="text" v-model="comput.folio_fiscal"  placeholder="Igresa el folio fiscal del equipo o material didáctico"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="comput.folio_fiscal == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Nombre de la tienda  del equipo o material didáctico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="folio_fiscal" name="folio_fiscal" type="text" v-model="comput.nombre_tienda"  placeholder="Igresa el nombre de la tienda  del equipo o material didáctico"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="comput.nombre_tienda == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_agregar_computo();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_agregar_computo();" :disabled="estado_guardar_computo">Guardar</button>
                </div>
            </div>
        </div>

    </div>
</div>