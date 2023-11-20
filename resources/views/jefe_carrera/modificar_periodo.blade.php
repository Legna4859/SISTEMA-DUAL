<div class="modal-body">



<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="form-group">
            <label>Seleccionar fecha de evaluación:</label>

            <?php  $fecha_periodo=date("d-m-Y ",strtotime($fecha_final)) ?>
            <input class="form-control datepicker"  type="text"  id="fecha_s" name="fecha_s" value="{{ $fecha_periodo }}">
            <label>Observaciones:</label>
            <input class="form-control datepicker"  type="text"  id="observaciones" name="observaciones" value="" >
            <input type="hidden"  id="id_periodo_cal" name="id_periodo_cal"  value="{{  $id_periodo_cal }}">
            <input type="hidden"  id="id_docente" name="id_docente"  value="{{  $id_docente }}">



        </div>
    </div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

    <button id="modificar_periodo"  style="display: none" class="btn btn-primary boton" >Guardar</button>
</div>
<script type="text/javascript">
    $(document).ready( function() {
        var numero="<?php  echo $unidad;?>";
        var dia="<?php  echo $di;?>";
        var posterior="<?php  echo $numero;?>";
        if(numero ==1){
            var dias_p="<?php  echo $dias_p;?>";
         //   alert(dias_p);
            if(dias_p==1){
                if(dia== 1){
                    var fec="<?php  echo $dias;?>";
                    var fecha='+'+fec+'d';
                    var fecho=posterior-1;
                    var post='+'+fecho+'d';
                    $('#fecha_s').datepicker({
                        pickTime: false,
                        autoclose: true,
                        language: 'es',
                        startDate: fecha,
                        endDate: post,
                    });

                }
                if(dia== 2){
                    var fec="<?php  echo $dias;?>";
                    var fecha='-'+fec+'d';
                    var fecho=posterior-1;
                    var post='+'+fecho+'d';
                    $('#fecha_s').datepicker({
                        pickTime: false,
                        autoclose: true,
                        language: 'es',
                        startDate: fecha,
                        endDate: post,
                    });

                }

            }
            if(dias_p==2) {
                if (dia == 1) {
                    var fec = "<?php  echo $dias;?>";
                    var fecha = '+' + fec + 'd';
                    var fecho=posterior;
                    var post='-'+fecho+'d';
                    $('#fecha_s').datepicker({
                        pickTime: false,
                        autoclose: true,
                        language: 'es',
                        startDate: fecha,
                        endDate: post,
                    });

                }
                if (dia == 2) {
                    var fec = "<?php  echo $dias;?>";
                    var fecha = '-' + fec + 'd';
                    var fecho=posterior;
                    var post='-'+fecho+'d';
                    $('#fecha_s').datepicker({
                        pickTime: false,
                        autoclose: true,
                        language: 'es',
                        startDate: fecha,
                        endDate: post,
                    });

                }
            }

        }
        if(numero ==0){
            if(dia== 1){
                var fec="<?php  echo $dias;?>";
                var fecha='+'+fec+'d';
                $('#fecha_s').datepicker({
                    pickTime: false,
                    autoclose: true,
                    language: 'es',
                    startDate: fecha,
                });

            }
            if(dia== 2){
                var fec="<?php  echo $dias;?>";
                var fecha='-'+fec+'d';
                $('#fecha_s').datepicker({
                    pickTime: false,
                    autoclose: true,
                    language: 'es',
                    startDate: fecha,
                });

            }

        }
        $("#fecha_s").change(function(e){
            console.log(e);
            var fecha_i="<?php  echo $fecha_i;?>";

            var fech= e.target.value;


            if(fech!="") {

                var f = fech.split("/").reverse().join("/")
                var fi = f.split("/").reverse().join("-")
                var fio = fi.split("-").reverse().join("-")

                 if(fio >= fecha_i)
                 {


                     $(".boton").css("display", "inline");


                 }
                 else{
                     swal({
                         position: "top",
                         type: "error",
                         title: "La fecha no debe menor a la de hoy",
                         showConfirmButton: false,
                         timer: 3500
                     });
                 }

            }
            else
            {
                swal({
                    position:"top",
                    type: "error",
                    title: "La fecha no debe ser vacia",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
            // alert(resultado);

        });

    });
</script>