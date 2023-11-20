@extends('tutorias.app_tutorias')
@section('content')
<div class="row">
        <div class="col-5 offset-3">
            <div class="card bg-success text-dark text-center">
                <h3 >Cuestionario al tutor</h3>
            </div>
        </div>
    </div>
    <div>
        <p></p>
    </div>
    <form action="{{ url('/tutoras_evaluacion/auto_eveluacion/guardar_evaluacion/dos')}}" class="form" role="form" method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                        <table class="table table-bordered">
                        <input class="form-control" type="hidden" id="id_asigna_tutor" name="id_asigna_tutor" value=" {{ $tutores->id_asigna_tutor }}">
                            <thead>
                                <th>Pregunta</th>
                                <th>Nada de acuerdo</th>
                                <th>Poco de acuerdo</th>
                                <th>De acuerdo</th>
                                <th>Totalmente de acuerdo</th>
                            </thead>
                            <tbody>
                                <td><label><strong>Necesidades de formación</strong></label></td>
                            </tbody>
                            <tbody>
                                <td><label>11. Considero que tengo la formación necesaria para desempeñar mi función de tutor.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta1" id="secion2_pregunta1" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta1" id="secion2_pregunta1" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta1" id="secion2_pregunta1" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta1" id="secion2_pregunta1" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>12. Los cursos en los que he participado me han ayudado en mi desempeño como tutor.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta2" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta2" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta2" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta2" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>13. Considero que las técnicas de entrevista que utilizo en las sesiones de tutoría son las adecuadas.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta3" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta3" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta3" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta3" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>14. Considero que mi proceso de formación como tutor me ha permitido atender las necesidades de mis tutorados.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta4" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta4" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta4" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta4" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>15. Quisiera participar en más cursos de formación como tutor.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta5" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta5" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta5" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta5" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label><strong>Factores que afectan mi desempeño como tutor</strong></label></td>
                            </tbody>
                            <tbody>
                                <td><label>16. Considero que los espacios físicos para las reuniones con mis tutorados son adecuados.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta1" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta1" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta1" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta1" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>17. Considero que existe compatibilidad entre los horarios de mis tutorados y el mío.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta2" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta2" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta2" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta2" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>18.Considero que las herramientas con las que se cuentan son suficientes para poder atender las situaciones planteadas por mis tutorados.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta3" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta3" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta3" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta3" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                            <td><label>19. El Tecnológico, proporciona información pertinente para realizar mi labor como tutor.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta4" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta4" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta4" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta4" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                            <td><label>20. Los recursos requeridos para el desempeño de mis funciones como tutor, están disponibles.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta5" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta5" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta5" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta5" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>21. Mis tutorados asisten con regularidad a sus sesiones de tutoría.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta6" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta6" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta6" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta6" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>22. Los horarios de los cursos de formación de tutores, no interfieren con mis actividades docentes.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta7" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta7" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta7" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta7" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                            <td><label>23. Las actividades extra clase obstaculizan las sesiones de tutoría programadas con mis tutorados.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta8" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta8" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta8" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta8" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                            <td><label>24. Las autoridades de la escuela proporcionan facilidades en mi desempeño como tutor.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta9" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta9" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta9" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion3_pregunta9" value="4" required></label></center></td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-9">
                <button type="submit" id="siguiente" class="btn btn-success">Siguiente</button>
            </div>
        </div>
    </form>
@endsection