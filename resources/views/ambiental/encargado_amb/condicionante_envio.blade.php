<div class="row">
    <div class="col-md-2 col-md-offset-5">
        <template v-if="status_documentacion == 1 ">
            <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar(documentacion);" >Enviar Documentación</button>

        </template>
        <p><br/></p>
    </div>
</div>