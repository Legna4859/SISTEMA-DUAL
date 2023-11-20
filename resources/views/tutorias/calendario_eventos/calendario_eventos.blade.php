@extends('tutorias.app_tutorias')
@section('content')
    <div align="center">
        <div class="row">
            <div class="col-12">
                <div class="card-body row" id="content-info">
                    <form id="form-acti" >
                        {{ csrf_field() }}
                        <div class="card" >
                            <div class="card-body" >
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloEvento"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p>Objetivo:</p>
                            <p id="objetivoEvento"></p>
                        </li>
                        <li class="list-group-item">
                            <p>Estrategia:</p>
                            <p id="descEvento"></p>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('/js/js_tutorias/js/jquery.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonIcons: true,
                weekNumbers: false,
                editable: true,
                eventLimit: true,
                events: [
                        @foreach ($evento as $even)
                    {
                        title: '{{ $even->desc_actividad }}',
                        allDay: true,
                        start: '{{ $even->fi_actividad }}',
                        end:'{{ $even->ff_actividad}}',
                        color: '#6dad75',
                        textColor: '#080808',

                    },
                    @endforeach

                ],
                eventClick:function (calEvent,jsEvent,view) {
                    $('#tituloEvento').html(calEvent.title);
                    $('#objetivoEvento').html(calEvent.objetivo);
                    $('#descEvento').html(calEvent.estrategia);
                    $('#myModal').modal('show');
                }
            });
        });
    </script>
@endsection


