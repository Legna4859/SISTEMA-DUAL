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
    <form action="{{ url('/tutoras_evaluacion/auto_eveluacion/guardar_evaluacion')}}" class="form" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-10 offset-1">
                <div class="form-group">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead><p>Seleccione el tiempo que lleva como tutor.</p></thead>
                            <thead>
                                <th>Menos de 1 año</th>
                                <th>Entre 1 y 5 años</th>
                                <th>Entre 6 y 10 años</th>
                                <th>Entre 11 y 15 años</th>
                                <th>Entre 16 y 20 años</th>
                            </thead>
                            <tbody>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="id_tiempo"  value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="id_tiempo"  value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="id_tiempo"  value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="id_tiempo"  value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="id_tiempo"  value="5" required></label></center></td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <input class="form-control" type="hidden" id="id_asigna_tutor" name="id_asigna_tutor" value=" {{ $tutores->id_asigna_tutor }}">
                <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <p><strong>Instrucciones:</strong></p>
                                <p>De acuerdo con la siguiente escala, seleccione el espacio que corresponda a su respuesta.</p>
                            </thead>
                            <thead>
                                <th>Pregunta</th>
                                <th>Nada de acuerdo</th>
                                <th>Poco de acuerdo</th>
                                <th>De acuerdo</th>
                                <th>Totalmente de acuerdo</th>
                            </thead>
                            <tbody>
                                <td><label><strong>Satisfacción de su desempeño como tutor</strong></label></td>
                            </tbody>
                            <tbody>
                                <td><label>1.Considero que mi trabajo como tutor, ha fomentado la responsabilidad en mis tutorados.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta1" id="secion1_pregunta1" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta1" id="secion1_pregunta1" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta1" id="secion1_pregunta1" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta1" id="secion1_pregunta1" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>2. Considero motivantes para mí las reuniones con mis tutorados.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta2" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta2" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta2" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta2" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>3. Mi trabajo como tutor, ha sido una oportunidad de superación en el plano personal.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta3" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta3" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta3" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta3" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>4. Considero importante, que el alumno perciba que mi actitud es de atención a su persona.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta4" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta4" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta4" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta4" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>5. Los resultados positivos que percibo en mis tutorados son una motivación en mi trabajo como tutor.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta5" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta5" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta5" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta5" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>6. Mi trabajo como tutor, ha sido una oportunidad de superación para mí en el plano académico.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta6" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta6" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta6" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta6" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>7. Mi trabajo como tutor, me ha permitido una mejor comprensión de las problemáticas del estudiante.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta7" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta7" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta7" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta7" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>8. Mi trabajo como tutor, ha enriquecido mi actividad docente.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta8" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta8" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta8" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta8" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                            <td><label>9. Mi trabajo como tutor, me ocupa un tiempo, que sería más productivo.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta9" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta9" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta9" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta9" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
                            <td><label>10. Mi experiencia como tutor la considero productiva.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta10" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta10" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta10" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta10" value="4" required></label></center></td>
                            </tbody>
                            <tbody>
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