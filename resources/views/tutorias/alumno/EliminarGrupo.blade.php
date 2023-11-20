<div class="modal fade" id="EliminarGrupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert alert-danger">
                <h5 class="modal-title text-center" id="exampleModalLabel">Eliminar grupo</h5>
            </div>
            <div class="modal-body">
                <h4 class="text-center"><p>Al eliminar el grupo se elimina:</p> <p class="font-weight-bold"> * Tutor asignado</p> <p class="font-weight-bold">* Estudiantes asignados al grupo</p>
                    <p>¿ Seguro que deseas eliminar el grupo <b class="h3 font-weight-bold"> @{{ nomg }}
                        </b> ?</p></h4>
            </div>
            <div class="modal-footer">
                <button type="button" @click="borrarGrupo()" data-dismiss="modal" class="btn btn-outline-primary">Confirmar</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
