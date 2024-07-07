@extends('components.base')
@section('title')
    - Kalender
@endsection
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kalender</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Events</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <div id="external-events">
                                    <div class="checkbox d-none">
                                        <label for="drop-remove">
                                            <input type="checkbox" id="drop-remove"/>
                                            remove after drop
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Event</h3>
                            </div>
                            <div class="card-body">
                                <div class="btn-group" style="width: 100%; margin-bottom: 10px">
                                    <ul class="fc-color-picker" id="color-chooser">
                                        <li>
                                            <a class="text-primary" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                        <li>
                                            <a class="text-warning" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                        <li>
                                            <a class="text-success" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                        <li>
                                            <a class="text-danger" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                        <li>
                                            <a class="text-muted" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                                <div class="input-group">
                                    <input id="new-event" type="text" class="form-control" placeholder="Event Title" />

                                    <div class="input-group-append">
                                        <button id="add-new-event" type="button" class="btn btn-primary">
                                            Add
                                        </button>
                                    </div>
                                    <!-- /btn-group -->
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-body p-0">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script>
    <script>
        $(function() {
            function ini_events(ele) {
                ele.each(function() {
                    var eventObject = {
                        title: $.trim($(this).text()),
                        backgroundColor: $(this).css("background-color"),
                        borderColor: $(this).css("border-color"),
                        textColor: $(this).css("color")
                    };
                    $(this).data('eventObject', eventObject);
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true,
                        revertDuration: 0,
                        stop: function(event, ui) {
                            var x = ui.offset.left;
                            var y = ui.offset.top;
                            var containerOffset = $('#external-events').offset();
                            var containerWidth = $('#external-events').outerWidth();
                            var containerHeight = $('#external-events').outerHeight();
                            var calendarOffset = $('#calendar').offset();
                            var calendarWidth = $('#calendar').outerWidth();
                            var calendarHeight = $('#calendar').outerHeight();

                            // Check if dragged out of external-events container but not into the calendar
                            if ((x < containerOffset.left || x > (containerOffset.left + containerWidth) ||
                                 y < containerOffset.top || y > (containerOffset.top + containerHeight)) &&
                                !(x >= calendarOffset.left && x <= (calendarOffset.left + calendarWidth) &&
                                  y >= calendarOffset.top && y <= (calendarOffset.top + calendarHeight))) {
                                if (confirm('Are you sure you want to remove this external event?')) {
                                    $(this).remove();
                                    saveExternalEvents();
                                }
                            }
                        }
                    });
                });
            }

            ini_events($('#external-events div.external-event'));

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('external-events');
            var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('calendar');

            new Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText,
                        backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                        borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                        textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                    };
                },
            });

            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                themeSystem: 'bootstrap',
                editable: true,
                droppable: true,
                events: JSON.parse(localStorage.getItem('calendarEvents')) || [],
                drop: function(info) {
                    if (checkbox.checked) {
                        info.draggedEl.parentNode.removeChild(info.draggedEl);
                        saveExternalEvents();
                    }
                    saveEvents();
                },
                eventReceive: function(info) {
                    if (checkbox.checked) {
                        info.draggedEl.parentNode.removeChild(info.draggedEl);
                        saveExternalEvents();
                    }
                    saveEvents();
                },
                eventDragStop: function(info) {
                    var x = info.jsEvent.pageX;
                    var y = info.jsEvent.pageY;
                    var calendarRect = calendarEl.getBoundingClientRect();

                    if (x < calendarRect.left || x > calendarRect.right || y < calendarRect.top || y > calendarRect.bottom) {
                        if (confirm('Are you sure you want to remove this event?')) {
                            info.event.remove();
                            saveEvents();
                        }
                    }
                },
                eventAdd: saveEvents,
                eventChange: saveEvents,
                eventRemove: saveEvents,
            });

            calendar.render();

            function saveEvents() {
                var events = calendar.getEvents().map(event => ({
                    id: event.id,
                    title: event.title,
                    start: event.start,
                    end: event.end,
                    backgroundColor: event.backgroundColor,
                    borderColor: event.borderColor,
                    textColor: event.textColor,
                }));
                localStorage.setItem('calendarEvents', JSON.stringify(events));
            }

            function loadExternalEvents() {
                var storedEvents = JSON.parse(localStorage.getItem('externalEvents')) || [];
                storedEvents.forEach(event => {
                    var eventEl = $("<div />");
                    eventEl.css({
                        "background-color": event.backgroundColor,
                        "border-color": event.borderColor,
                        color: event.textColor,
                    }).addClass("external-event");
                    eventEl.text(event.title);
                    $("#external-events").prepend(eventEl);
                    ini_events(eventEl);
                });
            }

            function saveExternalEvents() {
                var externalEvents = [];
                $("#external-events .external-event").each(function() {
                    var eventEl = $(this);
                    externalEvents.push({
                        title: eventEl.text(),
                        backgroundColor: eventEl.css("background-color"),
                        borderColor: eventEl.css("border-color"),
                        textColor: eventEl.css("color")
                    });
                });
                localStorage.setItem('externalEvents', JSON.stringify(externalEvents));
            }

            loadExternalEvents();

            /* ADDING EVENTS */
            var currColor = "#3c8dbc"; // Red by default
            $("#color-chooser > li > a").click(function(e) {
                e.preventDefault();
                currColor = $(this).css("color");
                $("#add-new-event").css({
                    "background-color": currColor,
                    "border-color": currColor,
                });
            });
            $("#add-new-event").click(function(e) {
                e.preventDefault();
                var val = $("#new-event").val();
                if (val.length == 0) {
                    return;
                }
                var event = $("<div />");
                event.css({
                    "background-color": currColor,
                    "border-color": currColor,
                    color: "#fff",
                }).addClass("external-event");
                event.text(val);
                $("#external-events").prepend(event);
                ini_events(event);
                saveExternalEvents();
                $("#new-event").val("");
            });

        });
    </script>

@endsection
