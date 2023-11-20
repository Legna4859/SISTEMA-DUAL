<div class="modal fade" id="evidalumn" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Evidencias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="s">
                <div class="modal-body">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>Actividad</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-bind:value="es.evidencia" v-for="es in v">
                                <td>
                                    <label>@{{es.desc_actividad}}</label>
                                </td>
                                <td>
                                    <a :href="'/pdf/' + es.evidencia" target="_blank" class="btn btn-danger text-white float-right">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>