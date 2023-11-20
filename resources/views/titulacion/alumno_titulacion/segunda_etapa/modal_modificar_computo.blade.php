<!-- Modal -->
<div  class="modal" :class="{mostrar:modal_modificar_computo}" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="cerrarModal_modificar_computo();">&times;</button>
                <h4 class="modal-title" style=" text-align: center;">Modificar equipo y/o material didáctico</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Nombre del equipo o material didáctico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="nombre" name="nombre" type="text" v-model="comp.nombre_equipo"  placeholder="Igresa el nombre del equipo o material didáctico"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="comp.nombre_equipo == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Descripción del equipo o material didáctico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="descripcion" name="descripcion" type="text" v-model="comp.descripcion"  placeholder="Igresa la descripción del equipo o material didáctico"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="comp.descripcion == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Folio fiscal del equipo o material didáctico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="folio_fiscal" name="folio_fiscal" type="text" v-model="comp.folio_fiscal"  placeholder="Igresa el folio fiscal del equipo o material didáctico"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="comp.folio_fiscal == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="nombre_proyecto">Nombre de la tienda  del equipo o material didáctico<b style="color:red; font-size:23px;">*</b></label>
                            <input class="form-control"  id="folio_fiscal" name="folio_fiscal" type="text" v-model="comp.nombre_tienda"  placeholder="Igresa el nombre de la tienda  del equipo o material didáctico"  style="text-transform:uppercase;"   onkeyup="javascript:this.value=this.value.toUpperCase();"  required/>
                            <p v-if="comp.nombre_tienda == ''" class="alert alert-danger">
                                Este campo es obligatorio
                            </p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="cerrarModal_modificar_computo();">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="guardar_modificar_computo();" >Modificar</button>
                </div>
            </div>
        </div>

    </div>
</div>