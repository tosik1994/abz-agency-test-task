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
        $('.container.list').append("<div>Token: " + response['token'] + "</div>").append("<br>");
        $('.container.list div').addClass('row');
    }
});


