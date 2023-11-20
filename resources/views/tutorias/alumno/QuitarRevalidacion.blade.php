<div class="modal fade" id="quitarevalidacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert alert-danger">
                <h5 class="modal-title text-center" id="exampleModalLabel">Revalidación</h5>
            </div>
            <div class="modal-body">
                <h4 class="text-center">Al eliminar la revalidación del estudiante se elimina: <p class="font-weight-bold">* Grupo asignado de tutorias</p></h4>
                <h4 class="text-center">¿ Seguro que desea eliminar la revalidación a  <b class="h3 font-weight-bold"> @{{ nombrealumno }}
                    </b>?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" @click="revalidaNO()" data-dismiss="modal" class="btn btn-outline-primary">Confirmar</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>