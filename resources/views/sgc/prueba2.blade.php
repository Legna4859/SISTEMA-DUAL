@extends('layouts.app')
@section('title','Agendar auditorias')
@section('content')
    <style>
        .ui-draggable, .ui-droppable {
            background-position: top;
        }
        ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
        li { margin: 5px; padding: 5px; width: 150px; }
        #sortable > div {
            background: #1f6377;
            width: 33.3333333333% !important;
        }
    </style>

<div class="row">
    <div id="draggable" class="alert alert-success col-md-6 ui-state-highlight">Drag me down</div>
</div>



<div class="row" id="sortable">
    <div class="alert alert-success col-md-3 ui-state-default">Item 1</div>
    <div class="alert alert-success col-md-3 ui-state-default">Item 2</div>
    <div class="alert alert-success col-md-3 ui-state-default">Item 3</div>
    <div class="alert alert-success col-md-3 ui-state-default">Item 4</div>
    <div class="alert alert-success col-md-3 ui-state-default">Item 5</div>
</div>


<script>
    $( function() {
        $( "#sortable" ).sortable({
            revert: true
        });
        $( "#draggable" ).draggable({
            connectToSortable: "#sortable",
            helper: "clone",
            revert: "invalid"
        });
        $( "ul, li" ).disableSelection();
    } );
</script>
@endsection
