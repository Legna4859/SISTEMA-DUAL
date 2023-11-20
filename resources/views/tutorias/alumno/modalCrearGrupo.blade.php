<div class="modal fade" id="CrearGrupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert alert-success">
                <h5 class="modal-title text-center" id="exampleModalLabel">Crear grupo</h5>
            </div>
            <div class="modal-body">
                <h4 class="text-center">¿ Seguro que deseas crear el grupo <b class="h3 font-weight-bold"> @{{ nomg }}
                    </b> en la generación <b class="h3 font-weight-bold">  @{{ nomgen }}</b> ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" @click="crearGrupo()" data-dismiss="modal" class="btn btn-outline-primary">Confirmar</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>