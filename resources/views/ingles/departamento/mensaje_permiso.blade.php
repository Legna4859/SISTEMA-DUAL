<form action="{{url("/ingles/modificacion_carga_academica_ingles/")}}" method="POST" role="form" >

        {{ csrf_field() }}
        ¿Realmente deseas dar permiso de modificacion  de carga academia a
          {{ $alumno[0]->nombre }}  {{ $alumno[0]->apaterno }} {{ $alumno[0]->amaterno }}?
        <input type="hidden" id="id_validar_carga" name="id_validar_carga" value="{{ $id_validar_carga }}">

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <input id="confirma_elimina_oficio" type="submit" class="btn btn-danger" value="Aceptar"/>
    </div>
</form>