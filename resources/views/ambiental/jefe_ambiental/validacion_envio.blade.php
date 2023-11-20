<div class="row">
    <div class="col-md-2 col-md-offset-5">


            <template v-if="status_doc == 1">
                    <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalAutorizar_doc(encargados);" >Autorizar Documentación</button>

                </template>
        <template v-if="status_doc == 3">
                    <button  class="btn btn-success btn-lg btn-block" v-on:click="abrirModalenviar_correcciones(encargados);" >Enviar correcciones</button>
        </template>



        <p><br/></p>
    </div>
</div>