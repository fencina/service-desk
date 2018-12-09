<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <form id="helpDeskForm">
                <div class="form-group">
                    <label for="help_desk_id">Help Desk Id</label>
                    <input id="help_desk_id" name="help_desk_id" class="form-control" required>
                </div>
                <button id="submitButton" type="submit">Enviar</button>
            </form>

            <div id="searchDiv" class="pt-5" hidden>
                <form id="searchForm">
                    <div class="form-group">
                        <label for="text">Buscar texto</label>
                        <input id="search" name="text" class="form-control">
                    </div>
                </form>

                <table id="incidentsTable" class="table text-center">
                    <tr id="tableHeader">
                        <th>Id</th>
                        <th>Título</th>
                        <th>Descripción</th>
                    </tr>
                </table>
            </div>
        </div>
    </body>

<script type="text/javascript">
    $(document).ready(function() {
        var incidents = [];

        $('#helpDeskForm').on('submit', function (e) {
            e.preventDefault();
            $('#submitButton').attr('disabled', 'disabled');
            $('#submitButton').text('Buscando...');

            $.get('/getIncidents?help_desk_id='+$('#help_desk_id').val(), function (data) {
                $('.incidentRow').remove();

                incidents = data;

                if (incidents.length > 0) {
                    incidents.forEach(function (incident) {
                        $('#incidentsTable tbody').append('<tr class="incidentRow">' +
                            '<td>'+incident.id+'</td>' +
                            '<td>'+incident.title+'</td>' +
                            '<td>'+incident.description+'</td>' +
                            '</tr>');

                        $('#searchDiv').removeAttr('hidden');
                    })
                } else {
                    $('#incidentsTable tbody').append('<tr class="incidentRow"><td colspan="3">No se encontraron incidentes para éste help desk</td></tr>');
                }

            })
            .fail(function (data) {
                alert('Ocurrió un error')
            })
            .always(function() {
                $('#submitButton').removeAttr('disabled');
                $('#submitButton').text('Enviar');
            });
        });


        $('#search').keyup(function() {
            let text = $(this).val();
            let filteredIncidents = incidents.filter(function (incident) {
                return incident.description.includes(text);
            });
            updateIncidentsTable(filteredIncidents);
        });

        function updateIncidentsTable(incidents) {
            $('.incidentRow').remove();

            if (incidents.length > 0) {
                incidents.forEach(function (incident) {
                    $('#incidentsTable tbody').append('<tr class="incidentRow">' +
                        '<td>'+incident.id+'</td>' +
                        '<td>'+incident.title+'</td>' +
                        '<td>'+incident.description+'</td>' +
                        '</tr>');

                    $('#searchDiv').removeAttr('hidden');
                })
            } else {
                $('#incidentsTable tbody').append('<tr class="incidentRow"><td colspan="3">No se encontraron incidentes con ésta descripción</td></tr>');
            }
        }
    });
</script>
</html>
