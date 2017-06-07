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
            console.log(msg.responseText);
        }
    });
});
