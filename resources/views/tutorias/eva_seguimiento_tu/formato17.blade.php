@extends('tutorias.app_tutorias')
@section('content')
<div class="row">
        <div class="col-5 offset-3">
            <div class="card bg-success text-dark text-center">
                <h3 >Seguimiento al Tutor</h3>
            </div>
        </div>
    </div>
    <div>
        <p></p>
    </div>
    <form action="{{ url('/seguimiento_tutorias/formulario/guardar/') }}" class="form" role="form" method="POST">
    {{ csrf_field() }}
    <input class="form-control" type="hidden" id="per" name="per" value=" {{ $per }}">
    <input class="form-control" type="hidden" id="id_asigna_tutor" name="id_asigna_tutor" value=" {{ $datos1->id_asigna_tutor }}">
    <div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Nombre del Tutor(a):</th>
                            <th>Carrera</th>
                            <th>Grupo</th>
                        </thead>
                        <tbody>
                            <td> {{ $datos1->nombre_tutor }} </td>
                            <td> {{ $datos1->carrera }} </td>
                            <td> {{ $datos1->grupo }} </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Cuenta con experiencia como tutor(a):</th>
                            <th>Si</th>
                            <th>No</th>
                            <th>Años como tutor(a):</th>
                        </thead>
                        <tbody>
                            <td>Respuesta </td>
                            <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="id_tiempo"  value="1" required></label></center></td>
                            <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="id_tiempo"  value="2" required></label></center></td>
                            <td>
                                <div class="col-4">
                                        <textarea  class="form-control" rows="1" name="anos" id="anos" placeholder="00"></textarea>
                                </div>
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Entrego la Planeación:</th>
                            <th>Si</th>
                            <th>No</th>
                            <th>Comentario: </th>
                        </thead>
                        <tbody>
                            <td>Entrego la Planeación:</td>
                            <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="planeacion"  value="1" required></label></center></td>
                            <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="planeacion"  value="2" required></label></center></td>
                            <td>
                                <div class="col-12">
                                    <p>En caso de No cumplir describir en Observaciones las causas</p>
                                </div>
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Fecha establecida</th>
                            <th>Fecha real</th>
                        </thead>
                        <tbody>
                            <td> 
                                <table class="table table-bordered">
                                    <thead>
                                        <th>Año</th>
                                        <th>Mes</th>
                                        <th>Dia</th>
                                    </thead>
                                    <tbody>
                                        <td>
                                            <div class="col-20">
                                                <textarea  class="form-control" rows="1" name="ano_es" id="ano_es" placeholder=" {{ $datos1->ano }} " required></textarea>
                                            </div>
                                        </td>
                                        <td>  
                                            <div class="col-20">
                                                <textarea  class="form-control" rows="1" name="mes_es" id="mes_es" placeholder="{{ $datos1->mes }}" required></textarea>
                                            </div>
                                        </td>
                                        <td>  
                                            <div class="col-20">
                                                <textarea  class="form-control" rows="1" name="dia_es" id="dia_es" placeholder="{{ $datos1->dia }}" required></textarea>
                                            </div>
                                        </td>
                                    </tbody>
                                </table>
                            </td>
                            <td>  
                            <table class="table table-bordered">
                                    <thead>
                                        <th>Año</th>
                                        <th>Mes</th>
                                        <th>Dia</th>
                                    </thead>
                                    <tbody>
                                        <td>
                                            <div class="col-20">
                                                <textarea  class="form-control" rows="1" name="ano_re" id="ano_re" placeholder=" {{ $datos1->ano }} " required></textarea>
                                            </div>
                                        </td>
                                        <td>  
                                            <div class="col-20">
                                                <textarea  class="form-control" rows="1" name="mes_re" id="mes_re" placeholder="{{ $datos1->mes }}" required></textarea>
                                            </div>
                                        </td>
                                        <td>  
                                            <div class="col-20">
                                                <textarea  class="form-control" rows="1" name="dia_re" id="dia_re" placeholder="{{ $datos1->dia }}" required></textarea>
                                            </div>
                                        </td>
                                    </tbody>
                                </table>
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <p><center> La ponderación para el juicio de valor es: Excelente= 5, Muy buena = 4, Buena = 3, Regular = 2, Mala = 1 </center></p>
    <div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Pregunta</th>
                                <th>Mala</th>
                                <th>Regular</th>
                                <th>Buena</th>
                                <th>Muy buena</th>
                                <th>Excelente</th>
                            </thead>
                            <tbody>
                                <td><label>1. El tutor explica la forma de trabajar en el l el programa de tutorías.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta1" id="pregunta1" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta1" id="pregunta1" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta1" id="pregunta1" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta1" id="pregunta1" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta1" id="pregunta1" value="5" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>2. El tutor conoce la Normativa del Tecnológico.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta2" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta2" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta2" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta2" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta2" value="5" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>3. Asiste a las reuniones de tutorías y apoya en las actividades del programa.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta3" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta3" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta3" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta3" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta3" value="5" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>4. Participa con su grupo en las actividades de tutorías solicitadas.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta4" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta4" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta4" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta4" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta4" value="5" required`></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>5. Colabora en asesorías y actividades Complementarias.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta5" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta5" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta5" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta5" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta5" value="5" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>6.Propicia un ambiente de confianza con el tutorado.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta6" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta6" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta6" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta6" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta6" value="5" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>7. Propicia el interés por las tutorías.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta7" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta7" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta7" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta7" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta7" value="5" required></label></center></td>
                            </tbody>
                            <tbody>
                                <td><label>8.Entrega en tiempo y forma la información solicitada de su grupo tutorado.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta8" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta8" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta8" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta8" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta8" value="5" required></label></center></td>
                            </tbody>
                            <tbody>
                            <td><label>9. Entrega en tiempo y forma los informes de tutorías.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta9" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta9" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta9" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta9" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta9" value="5" required></label></center></td>
                            </tbody>
                            <tbody>
                            <td><label>10. Resuelve dudas.</label></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta10" value="1" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta10" value="2" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta10" value="3" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta10" value="4" required></label></center></td>
                                <td> <center><label class="radio-inline"><input class="form-check-input" type="radio" name="pregunta10" value="5" required></label></center></td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <p>Observaciones:</p>
            <textarea class="form-control" rows="3" name="comentarios" id="comentarios" required></textarea>
            <p><br></p>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-9">
                <button type="submit" id="siguiente" class="btn btn-success">Siguiente</button>
            </div>
        </div>
    </form>
@endsection