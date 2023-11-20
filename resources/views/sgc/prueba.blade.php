@extends('layouts.app')
@section('title','Agendar auditorias')
@section('content')
<style>
    .margin-top-30 {
        margin-top: 30px;
    }

    .banner-component,
    .important-links-component {
        height: 465px;
    }

    .training-status-component {
        height: 178px;
    }

    .learning-activities-component {
        height: 394px;
    }

    .popular-courses-component,
    .resources-component,
    .news-and-updates-component {
        height: 438px;
    }
</style>

<div class="container margin-top-30">
    <div class="row component-container">

        <div class="col-md-9 col-sm-6 col-xs-12 component-section" data-width="col-md-9 col-sm-6 col-xs-12" data-wrapper="bannerwrapper" data-componentname="Banner" data-componenttype="Complex">
            <div class="panel panel-default banner-component">
                <div class="panel-heading">
                    <h3>Heading</h3>
                </div>
                <div class="panel-body">
                    <h1>Banner</h1>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12 component-section" data-width="col-md-3 col-sm-6 col-xs-12" data-wrapper="importantlinkswrapper" data-componentname="ImportantLinks" data-componenttype="Simple">
            <div class="panel panel-default important-links-component">
                <div class="panel-heading">
                    <h3>Heading</h3>
                </div>
                <div class="panel-body">
                    <h1>Important Links</h1>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-6 col-xs-12 component-section" data-width="col-md-12 col-sm-6 col-xs-12" data-wrapper="trainingstatuswrapper" data-componentname="TrainingStatus" data-componenttype="Mediocre">
            <div class="panel panel-default training-status-component">
                <div class="panel-heading">
                    <h3>Heading</h3>
                </div>
                <div class="panel-body">
                    <h1>Training Status</h1>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-6 col-xs-12 component-section" data-width="col-md-12 col-sm-6 col-xs-12" data-wrapper="learningactivitieswrapper" data-componentname="LearningActivities" data-componenttype="Simple">
            <div class="panel panel-default learning-activities-component">
                <div class="panel-heading">
                    <h3>Heading</h3>
                </div>
                <div class="panel-body">
                    <h1>Learning Activities</h1>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 component-section" data-width="col-md-4 col-sm-6 col-xs-12" data-wrapper="popularcourseswrapper" data-componentname="PopularCourses" data-componenttype="Simple">
            <div class="panel panel-default popular-courses-component">
                <div class="panel-heading">
                    <h3>Heading</h3>
                </div>
                <div class="panel-body">
                    <h1>Popular Courses</h1>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 component-section" data-width="col-md-4 col-sm-6 col-xs-12" data-wrapper="resourceswrapper" data-componentname="Resources" data-componenttype="Mediocre">
            <div class="panel panel-default resources-component">
                <div class="panel-heading">
                    <h3>Heading</h3>
                </div>
                <div class="panel-body">
                    <h1>Resources</h1>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 component-section" data-width="col-md-4 col-sm-6 col-xs-12" data-wrapper="newsandupdateswrapper" data-componentname="NewsAndUpdates" data-componenttype="Simple">
            <div class="panel panel-default news-and-updates-component">
                <div class="panel-heading">
                    <h3>Heading</h3>
                </div>
                <div class="panel-body">
                    <h1>News And Updates</h1>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.component-container').sortable({
            cursor: 'move',
            placeholder: 'ui-state-highlight',
            start: function(e, ui) {
                ui.placeholder.width(ui.item.find('.panel').width());
                ui.placeholder.height(ui.item.find('.panel').height());
                ui.placeholder.addClass(ui.item.attr("class"));
            }
        });
    });

</script>
@endsection
