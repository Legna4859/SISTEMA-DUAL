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
                        <th>Años como tutor(a):</th>
                    </thead>
                    <tbody>
                        <td>Respuesta: {{$res->experiencia}} </td>
                        <td>{{$res->anos_tutor}}</td>
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
                        <th>Comentario: </th>
                    </thead>
                    <tbody>
                        <td>Entrego la Planeación: {{$res->planeacion}}</td>
                        <td>
                            <p>{{$res->com_planeacion}}</p>
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
                           <p>{{$res->fecha_establecida}}</p> 
                        </td>
                        <td>  
                            <p>{{$res->fecha_final}}</p> 
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
                        <th>Respuesta</th>
                    </thead>
                    <tbody>
                        <td><label>1. El tutor explica la forma de trabajar en el l el programa de tutorías.</label></td>
                        <td><p>{{$res->pregunta1}}</p></td>
                    </tbody>
                    <tbody>
                        <td><label>2. El tutor conoce la Normativa del Tecnológico.</label></td>
                        <td><p>{{$res->pregunta2}}</p></td>
                    </tbody>
                    <tbody>
                        <td><label>3. Asiste a las reuniones de tutorías y apoya en las actividades del programa.</label></td>
                        <td><p>{{$res->pregunta3}}</p></td>
                    </tbody>
                    <tbody>
                        <td><label>4. Participa con su grupo en las actividades de tutorías solicitadas.</label></td>
                        <td><p>{{$res->pregunta4}}</p></td>
                    </tbody>
                    <tbody>
                        <td><label>5. Colabora en asesorías y actividades Complementarias.</label></td>
                        <td><p>{{$res->pregunta5}}</p></td>
                    </tbody>
                    <tbody>
                        <td><label>6.Propicia un ambiente de confianza con el tutorado.</label></td>
                        <td><p>{{$res->pregunta6}}</p></td>
                    </tbody>
                    <tbody>
                        <td><label>7. Propicia el interés por las tutorías.</label></td>
                        <td><p>{{$res->pregunta7}}</p></td>
                    </tbody>
                    <tbody>
                        <td><label>8.Entrega en tiempo y forma la información solicitada de su grupo tutorado.</label></td>
                        <td><p>{{$res->pregunta8}}</p></td>
                    </tbody>
                    <tbody>
                    <td><label>9. Entrega en tiempo y forma los informes de tutorías.</label></td>
                    <td><p>{{$res->pregunta9}}</p></td>
                    <tbody>
                    <td><label>10. Resuelve dudas.</label></td>
                    <td><p>{{$res->pregunta10}}</p></td>
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
                        <th><p>Observaciones:</p></th>
                    </thead>
                    <tbody>
                        <td> {{ $res->comentario }} </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection