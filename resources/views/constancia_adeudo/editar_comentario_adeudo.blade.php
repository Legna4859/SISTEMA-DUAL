<form id="form_modificar_profesores_ingles" action="{{url("/constancia_alumno_editado/".$comentario->id_adeudo_departamento)}}" class="form" role="form" method="POST">
    {{ csrf_field() }}
    <div clas="row">
        <div class="col-md-10 col-md-offset-1">
            <p>No. Cuenta: {{ $comentario->cuenta }}</p>
           <p>Nombre del Estudiante: {{ $comentario->nombre }} {{ $comentario->apaterno }} {{ $comentario->amaterno }}</p>
        </div>
    </div>
    <div clas="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label for="nombre_docente">Comentario</label>
                <textarea class="form-control" type="text" id="comentario" name="comentario"  required>{{  $comentario->comentario }}</textarea>
     </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button  type="submit" class="btn btn-success ">Guardar</button>
        </div>
    </div>
</form>