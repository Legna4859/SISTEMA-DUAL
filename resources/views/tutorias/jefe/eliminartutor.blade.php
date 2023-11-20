    <div class="modal fade" id="Eliminar" tabindex="-1" role="dialog" aria-hidden="true">
        <form>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar</h5>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que desea eliminar el tutor?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" v-on:click.prevent="deleteT()" data-dismiss="modal">Confirmar</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>