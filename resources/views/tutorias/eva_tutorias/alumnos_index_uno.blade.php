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
    <form action="{{ url('/tutoras_evaluacion/guardar_evaluacion')}}" class="form" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-10 offset-1">
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
                        <td><label><strong>Percepción respecto a tu tutor(a) en la gestión</strong></label></td>
                        </tbody>
                        <tbody>
                        <td><label>1. Cuando ha sido necesario, mi tutor me ha canalizado a las instancias </label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta1" id="secion1_pregunta1" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta1" id="secion1_pregunta1" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta1" id="secion1_pregunta1" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta1" id="secion1_pregunta1" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>2. Mi tutor, ha mostrado interés por mis problemas académicos y ha sido un apoyo en los trámites.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta2" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta2" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta2" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta2" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>3. Mi tutor, me ha guiado respecto a estrategias de aprendizaje para las materias que considero difíciles.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta3" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta3" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta3" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta3" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>4. Mi tutor ha sido un factor importante, para facilitar mi integración a la institución.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta4" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta4" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta4" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion1_pregunta4" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label><strong>Percepción respecto a tu tutor(a) en la Actitud</strong></label></td>
                        </tbody>
                        <tbody>
                        <td><label>5. El trato de mi tutor ha sido siempre respetuoso.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta1" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta1" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta1" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta1" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>6. Asistir a las sesiones de tutorías ha sido motivante.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta2" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta2" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta2" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta2" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>7. El trabajo realizado en las sesiones de tutoría, me han estimulado hacia el estudio independiente.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta3" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta3" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta3" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta3" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>8. Mi tutor, ha mostrado interés en mis problemas personales.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta4" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta4" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta4" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta4" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>9. Mi tutor, no ha mostrado comportamiento de prepotencia.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta5" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta5" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta5" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta5" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>10. Mi tutor, no ha mostrado el comportamiento de acoso.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta6" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta6" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta6" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta6" value="4" required></label></center></td>
                        </tbody>
                        <tbody>
                        <td><label>11. Mi tutor, no ha mostrado el comportamiento de intimidación.</label></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta7" value="1" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta7" value="2" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta7" value="3" required></label></center></td>
                        <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="secion2_pregunta7" value="4" required></label></center></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-9">
                <button type="submit" id="siguiente" class="btn btn-success">Siguiente</button>
            </div>
        </div>
    </form>
    <!--div class="row">
        <div class="col-md-2 col-md-offset-5">
            <button type="button" id="siguiente" class="btn-success" >Siguiente</button>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {
            $("#siguiente").click(function (){

                var  optradio1 = $('input[name="secion1_pregunta1"]:checked').val();
                var  optradio2 = $('input[name="secion1_pregunta2"]:checked').val();
                var  optradio3 = $('input[name="secion1_pregunta3"]:checked').val();
                var  optradio4 = $('input[name="secion1_pregunta4"]:checked').val();
                var  optradio5 = $('input[name="secion2_pregunta1"]:checked').val();
                var  optradio6 = $('input[name="secion2_pregunta2"]:checked').val();
                var  optradio7 = $('input[name="secion2_pregunta3"]:checked').val();
                var  optradio8 = $('input[name="secion2_pregunta4"]:checked').val();
                var  optradio9 = $('input[name="secion2_pregunta5"]:checked').val();
                var  optradio10 = $('input[name="secion2_pregunta6"]:checked').val();
                var  optradio11 = $('input[name="secion2_pregunta7"]:checked').val();

                if(optradio1 != undefined && optradio2 != undefined && optradio3 != undefined && optradio4 != undefined && optradio5 != undefined && optradio6 != undefined && optradio7 != undefined && optradio8 != undefined && optradio9 != undefined && optradio10 != undefined && optradio11 != undefined ){
                    $("#siguiente").attr("disabled", true); // se utiliza para bloquear el boton
                    $("#form_encuesta").submit(); // se utiliza para el submit del formulario
                }
                else{
                    alert("Pregunta vacia");
                }
            });
        });
    </script-->

@endsection

