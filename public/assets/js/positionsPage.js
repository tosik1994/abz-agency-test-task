$(document).ready(function () {
    var currentLocation = 'api' + window.location.pathname;

    function getResponseAjax(url) {
        $.ajax({
            url: url,
            type: 'get',
            dataType: "json",
            success: function (response) {
                makeHeader(response);
            }
        });
    }

    getResponseAjax(currentLocation);

    function makeHeader(response) {
        positionsCount = Object.keys(response['positions']).length;
        $('.container.list div.row').each(function (index) {
            if (index !== 0) {
                $(this).remove('div');
            }
        });

        $('.container.list br').each(function (index) {
            if (index !== 0) {
                $(this).remove('br');
            }
        });
        for (k = 0; k < positionsCount; k++) {
            $('.container.list').append("<div></div>").append("<br>");
            $('.container.list div').addClass('row');
            $('.container.list div .row').removeClass('row');
        }

        $('.container.list div.row').each(function (index) {
            if (index !== 0) {
                $(this).append("<div class='col-md-1'>" + response['positions'][index - 1]['id'] + "</div>");
                $(this).append("<div class='col-md-11'>" + response['positions'][index - 1]['name'] + "</div>");
            }
        });
    }
});


