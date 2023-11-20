@extends('tutorias.app_tutorias')
@section('content')
<div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Nombre</th>
                            <th>Carrera</th>
                            <th>Grupo</th>
                        </thead>
                        <tbody>
                            <td>{{ $datos1->nombre_tutor }}</td>
                            <td> {{ $datos1->carrera }} </td>
                            <td>{{ $datos1->grupo }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@if($igual == false)
<div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Periodo</th>
                            <th>Evaluacion</th>
                            <td>Imprimir PDF</td>
                        </thead>
                        <tbody>
                            <td>Primera Evaluacion</td>
                            <td> 
                            <a  class="btn btn-info" href="/seguimiento_tutorias/formulario/1/  {{ $datos1->id_grupo_semestre }}   / ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-1-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002H7.971L6.072 5.385v1.271l1.834-1.318h.065V12h1.312V4.002Z"/>
                                </svg>
                            </a>
                            </td>
                            <td>
                                <a  class="btn btn-info" href="/seguimiento_tutorias/1/  {{ $datos1->id_grupo_semestre }}   / ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                </svg>
                                </a>
                            </td>
                        </tbody>
                        @if($con1 == 1)
                        <tbody>
                            <td>Segunda Evaluacion</td>
                            <td> 
                                <a  class="btn btn-info" href="/seguimiento_tutorias/formulario/2/  {{ $datos1->id_grupo_semestre }}   /">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-2-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM6.646 6.24c0-.691.493-1.306 1.336-1.306.756 0 1.313.492 1.313 1.236 0 .697-.469 1.23-.902 1.705l-2.971 3.293V12h5.344v-1.107H7.268v-.077l1.974-2.22.096-.107c.688-.763 1.287-1.428 1.287-2.43 0-1.266-1.031-2.215-2.613-2.215-1.758 0-2.637 1.19-2.637 2.402v.065h1.271v-.07Z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a  class="btn btn-info" href="/seguimiento_tutorias/2/  {{ $datos1->id_grupo_semestre }}   / ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                </svg>
                                </a>
                            </td>
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif 
@if($igual == true)
<div class="row">
        <div class="col-10 offset-1">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th> <center>El seguimiento lo debe realizar coordinador institucional y/o Desarrollo Académico</center> </th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif 
@endsection