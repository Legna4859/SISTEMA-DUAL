<div class="modal fade" id="responsable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header alert alert-info">
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Datos del reporte</h5>
                <button type="button" class="close" @click="CancelReporte()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" v-if="reslleno=='false'">
                    <div class="col-12">
                        <h5 class="alert-danger alert text-center">Debes de llenar todos los campos</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nd" class="col-form-label">Nombre completo</label>
                            <input id="nd" type="text" class="form-control" v-model="responsable">
                        </div>
                        <div class="form-group">
                            <label for="cd" class="col-form-label">Cargo</label>
                            <input id="cd" type="text" class="form-control" v-model="cargores">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button target="_blank" v-if="inst==false" @click="reporte('ReporteCarreraD')" class="btn btn-outline-primary" >Generar reporte</button>
                <button target="_blank" v-if="inst==true" @click="reporte('ReporteInstitucionalD')" class="btn btn-outline-primary" >Generar reporte</button>
                <button type="button" class="btn btn-outline-danger" @click="CancelReporte()" >Cancelar</button>
            </div>
        </div>
    </div>
</div>