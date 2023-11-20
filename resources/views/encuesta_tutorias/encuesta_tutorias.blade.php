@extends('tutorias.app_tutorias')
@section('content')
    <form id="form_encuesta" class="form" action="{{url("/tutoria/guardar_encuesta/")}}" role="form" method="POST" >
        {{ csrf_field() }}
        <div class="row">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>pregunta</th>
            <th>opcion 1</th>
            <th>opcion 2</th>
            <th>opcion 3</th>
            <th>opcion 4</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Pregunta 1 cuestionario sobre algo</td>
            <td><label class="radio-inline"><input type="radio" name="optradio1" value="1" ></label></td>
            <td><label class="radio-inline"><input type="radio" name="optradio1" value="2" ></label></td>
            <td><label class="radio-inline"><input type="radio" name="optradio1" value="3" ></label></td>
            <td><label class="radio-inline"><input type="radio" name="optradio1" value="4" ></label></td>
        </tr>
        <tr>
            <td>Pregunta 2 cuestionario sobre algo</td>
            <td><label class="radio-inline"><input type="radio" name="optradio2" value="1" ></label></td>
            <td><label class="radio-inline"><input type="radio" name="optradio2" value="2" ></label></td>
            <td><label class="radio-inline"><input type="radio" name="optradio2" value="3" ></label></td>
            <td><label class="radio-inline"><input type="radio" name="optradio2" value="4" ></label></td>
        </tr>
        </tbody>
    </table>



</div>
    </form>
<div class="row">
    <div class="col-md-2 col-md-offset-5">
        <button type="button" id="siguiente" class="btn-success" >Siguiente</button>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {
     $("#siguiente").click(function (){

         var  optradio1 = $('input[name="optradio1"]:checked').val();
         var  optradio2 = $('input[name="optradio2"]:checked').val();

         if(optradio1 != undefined && optradio2 != undefined ){
             $("#siguiente").attr("disabled", true); // se utiliza para bloquear el boton
             $("#form_encuesta").submit(); // se utiliza para el submit del formulario

         }else{
               alert("Pregunta vacia");

         }


     });
    });
</script>
@endsection

