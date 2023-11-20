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

    <form action="{{ url("/tutoras_evaluacion/guardar_evaluacion/dos/")  }}" class="form" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-10 offset-1">
                <div class="form-group">
                    <input class="form-control" type="hidden" id="id_asigna_tutor" name="id_asigna_tutor" value=" {{ $alumno->id_asigna_tutor }}">
                    <input class="form-control" type="hidden" id="id_asigna_alumno" name="id_asigna_alumno" value=" {{ $alumno->id_asigna_alumno }}">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>Nombre de la pregunta</th>
                        <th>Nada de acuerdo</th>
                        <th>Poco de acuerdo</th>
                        <th>De acuerdo</th>
                        <th>Totalmente de acuerdo</th>
                        </thead>
                        <tbody>
                        <td colspan="5"><label><strong>Percepción respecto a tu tutor(a) en la disponibilidad y confianza</strong></label></td>
                        </tbody>
                        <tbody>
                        <td><label>12. Mi tutor, ha estado disponible cuantas veces he requerido de su atención.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta1" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta1" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta1" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta1" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>13. Considero que el tiempo que me dedica mi tutor es suficiente.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta2" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta2" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta2" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta2" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>14. El clima durante las sesiones de tutoría ha sido de confianza.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta3" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta3" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta3" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta3" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>15. En las sesiones con mi tutor he podido plantear mis dificultades respecto a mi desarrollo académico.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta4" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta4" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta4" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta4" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>16. La retroalimentación de mi tutor, respecto a las actividades acordadas en las sesiones, ha sido oportuna.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta5" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta5" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta5" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta5" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td colspan="5"><label><strong>Percepción respecto a los servicios del Programa de Tutoría</strong></label></td>
                        </tbody>
                        <tbody>
                        <td><label>17. Considero importante el Programa de Tutorías.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta1" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta1" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta1" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta1" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>18. Considero que los espacios físicos dedicados a la tutoría son adecuados.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta2" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta2" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta2" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta2" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>19. Considero que el número de sesiones programadas para la tutoría, no interfieren con mis horarios de clase ni otras actividades académicas.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta3" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta3" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta3" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta3" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>20. Los materiales requeridos para las tutorías, están siempre disponibles.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta4" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta4" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta4" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta4" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>21. Las quejas respecto a la tutoría han sido atendidas oportunamente.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta5" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta5" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta5" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta5" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>22. La información respecto al Programa de Tutorías, ha sido puntual.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta6" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta6" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta6" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion4_pregunta6" value="4" required></label></center></td>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-9">
                <button type="submit" class="btn btn-success" onclick="operacion();">Siguiente</button>
            </div>
        </div>
    </form>

@endsection
