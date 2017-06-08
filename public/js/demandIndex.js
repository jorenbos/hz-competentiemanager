$(document).ready(function()
{
    jQuery.support.cors = true;

    $.ajax(
    {
        type: 'GET',
        url: '/api/demand',
        data: '{}',
        dataType: 'json',
        cache: false,
        success: function(result) {
            $('#demandTableBody').empty();
            $.each(result, function(index, competency) {
                $('#demandTableBody').append(
                    '<tr>'
                    + '<td>' + competency["competency_name"] + '</td>'
                    + '<td>' + competency["mean_demand"] + '</td>'
                    + '</tr>'
                );
            });
        },
        error: function(msg) {
            $('#demandTableBody').empty();
            $('#demandTableBody').append(
                '<tr>'
                + '<td colspan="2">Er is een fout opgetreden, neem contact op met de beheerder.</td>'
                + '</tr>'
            );
            console.log(msg.responseText);
        }
    });
});
