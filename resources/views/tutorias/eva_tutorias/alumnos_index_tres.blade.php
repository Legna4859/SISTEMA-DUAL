@extends('tutorias.app_tutorias')
@section('content')
    <div class="row">
        <div class="col-5 offset-3">
            <div class="card bg-success text-dark text-center">
                <h3 >Encuesta de evaluación al tutor</h3>
            </div>
        </div>
    </div>
    <div>
        <p></p>
    </div>

    <form action="{{ url("/tutoras_evaluacion/guardar_evaluacion/tres/")  }}" class="form" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="form-group">
                    <input class="form-control" type="hidden" id="id_asigna_tutor" name="id_asigna_tutor" value=" {{ $alumno->id_asigna_tutor }}">
                    <input class="form-control" type="hidden" id="id_asigna_alumno" name="id_asigna_alumno" value=" {{ $alumno->id_asigna_alumno }}">
                    <table class="table table-bordered">
                        <thead>
                        <th>Nombre de la pregunta</th>
                        <th>Nada de acuerdo</th>
                        <th>Poco de acuerdo</th>
                        <th>De acuerdo</th>
                        <th>Totalmente de acuerdo</th>
                        </thead>
                        <tbody>
                        <td colspan="5"><label><strong>Percepción respecto a tus logros y avances.</strong></label></td>
                        </tbody>
                        <tbody>
                        <td><label>23. La tutoría ha sido un factor importante en mi desarrollo académico.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta1" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta1" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta1" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta1" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>24. Considero que la tutoría ha sido un factor positivo en mi capacidad de socializar.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta2" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta2" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta2" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta2" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>25. La tutoría ha facilitado mi integración a la institución.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta3" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta3" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta3" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta3" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>26. Considero que la tutoría ha influido positivamente en mis calificaciones.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta4" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta4" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta4" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta4" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>27. La tutoría me ha permitido desarrollar estrategias de aprendizaje.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta5" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta5" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta5" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta5" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>28. Considero que la tutoría ha favorecido en mí, el estudio independiente.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta6" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta6" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta6" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta6" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>29. La tutoría ha favorecido mi autonomía como estudiante.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta7" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta7" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta7" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta7" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>30. La tutoría me ha permitido visualizar las perspectivas laborales en el campo profesional.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta8" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta8" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta8" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta8" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>31. Considero que la tutoría ha contribuido a ampliar mis perspectivas académicas.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta9" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta9" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta9" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion5_pregunta9" value="4" required></label></center></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <p>Comentarios u opiniones: A continuación, podrás expresar tus comentarios u opiniones, respecto a Fortalezas del Programa de Tutorias.</p>
            <textarea class="form-control" rows="3" name="comentarios" id="comentarios"></textarea>
        <p><br></p>
        </div>

        <div class="row">
            <div class="col-md-2 col-md-offset-9">
                <button type="submit" class="btn btn-success" onclick="operacion();">Guardar</button>
            </div>
        </div>
    </form>

@endsection

<!--script>
    function operacion()
    {
        alert( "Datos guardados" );
    }
</script-->
