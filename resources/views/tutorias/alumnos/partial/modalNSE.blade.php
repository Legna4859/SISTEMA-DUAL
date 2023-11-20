<div class="modal" id="modalNSE" tabindex="-1" name="modal" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-center font-weight-bold modal-title">TEST NIVEL SOCIO-ECONÓMICO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" v-if="test.testlleno==false">
                    <div class="col-12">
                        <h5 class="alert-danger alert text-center">Debes de responder todas las preguntas</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row pt-3">
                            <div class="col-8">
                                <label for="p1"><b>1.-</b> Pensando en el jefe o jefa de hogar, ¿Cuál fue el último año de estudios que aprobó en la
                                    escuela? </label>
                            </div>
                            <div class="col-4">
                                <select name="" id="p1" v-model.number="test.p1" class="custom-select custom-select-md">
                                    <option value="null" selected>Elija una opción</option>
                                    <option value="0">Sin Instrucción</option>
                                    <option value="0">Preescolar</option>
                                    <option value="10">Primaria Incompleta</option>
                                    <option value="22">Primaria Completa</option>
                                    <option value="23">Secundaria Incompleta</option>
                                    <option value="31">Secundaria Completa</option>
                                    <option value="35">Preparatoria Incompleta</option>
                                    <option value="43">Preparatoria Completa</option>
                                    <option value="59">Licenciatura Incompleta</option>
                                    <option value="73">Licenciatura Completa</option>
                                    <option value="101">Posgrado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-8">
                                <label for="p2"><b>2.-</b> ¿Cuántos baños completos con regadera y W.C. (excusado) hay en esta vivienda? </label>
                            </div>
                            <div class="col-4">
                                <select name="" v-model.number="test.p2"  id="p2" class="custom-select custom-select-md">
                                    <option value="null" selected>Elija una opción</option>
                                    <option value="0">0</option>
                                    <option value="24">1</option>
                                    <option value="47">2 o más</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-8">
                                <label for="p3"><b>3.-</b> ¿Cuántos automóviles o camionetas tienen en su hogar, incluyendo camionetas cerradas, o
                                    con cabina o caja? </label>
                            </div>
                            <div class="col-4">
                                <select name="" v-model.number="test.p3"  id="p3" class="custom-select custom-select-md">
                                    <option value="null" selected>Elija una opción</option>
                                    <option value="0">0</option>
                                    <option value="18">1</option>
                                    <option value="37">2 o más</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-8">
                                <label for="p4"><b>4.-</b> Sin tomar en cuenta la conexión móvil que pudiera tener desde algún celular ¿Este hogar
                                    cuenta con internet? </label>
                            </div>
                            <div class="col-4">
                                <select name="" v-model.number="test.p4"  id="p4" class="custom-select custom-select-md">
                                    <option value="null" selected>Elija una opción</option>
                                    <option value="0">No tiene</option>
                                    <option value="31">Sí tiene</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-8">
                                <label for="p5"><b>5.-</b> De todas las personas de 14 años o más que viven en el hogar, ¿Cuántas trabajaron en el
                                    último mes? </label>
                            </div>
                            <div class="col-4">
                                <select name="" v-model.number="test.p5"  id="p5" class="custom-select custom-select-md">
                                    <option value="null" selected>Elija una opción</option>
                                    <option value="0">0</option>
                                    <option value="15">1</option>
                                    <option value="31">2</option>
                                    <option value="46">3</option>
                                    <option value="61">4 o más</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-8">
                                <label for="p6"><b>6.-</b> En esta vivienda, ¿Cuántos cuartos se usan para dormir, sin contar pasillos ni baños? </label>
                            </div>
                            <div class="col-4">
                                <select name=""  v-model.number="test.p6" id="p6" class="custom-select custom-select-md">
                                    <option value="null" selected>Elija una opción</option>
                                    <option value="0">0</option>
                                    <option value="6">1</option>
                                    <option value="12">2</option>
                                    <option value="17">3</option>
                                    <option value="23">4 o más</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="CalculaNivel()" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>


