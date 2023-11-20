@extends('layouts.app')
@section('content')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="container card">
        <br>

        <div class="row">

            <table class="table" id="Table">
                <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">No cuenta</th>
                    <th scope="col">Expediente</th>
                </tr>
                </thead>
                <tbody>
                @foreach($alumnos as $alumno)
                    @if($alumno->exp_generales->count()>0)
                    <tr onmouseover="this.style.backgroundColor='#DBE7F3'" onmouseout="this.style.backgroundColor='white'">
                        <td>{{$alumno->exp_generales[0]->nombre}}</td>
                        <td>{{$alumno->exp_generales[0]->no_cuenta}}</td>
                        <td>
                            <a class="btn btn-lg" href="{{url("pdf_expediente/".$alumno->id_asigna_expediente)}}" target="_blank" style="background: #f0f0f0;">
                                <i class="fas fa-print" style="color: black"></i></a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

        </div>
        </div>
    </div>
@endsection