$(document).ready(function () {
    let host = window.location.protocol + "//" + window.location.host + "/";
    let currentLocation = 'api' + window.location.pathname;
    let fullUrl = host + currentLocation;

    function getResponseAjax(url) {
        $.ajax({
            isLocal: true,
            url: url,
            type: 'get',
            dataType: "json",
            success: function (response) {
                showAndUpdateUserData(response);
            },
            error: function (response) {
                console.log(response);
            }
        });
    }

    getResponseAjax(fullUrl);

    function showAndUpdateUserData(response) {
        $('.container.list div.row').each(function (index) {
            $(this).remove('div');
        });

        $('.container.list br').each(function (index) {
            $(this).remove('br');
        });
        for (k = 0; k < 7; k++) {
            $('.container.list').append("<div></div>").append("<br>");
            $('.container.list div').addClass('row');
            $('.container.list div .row').removeClass('row');
        }
        $('.container.list div.row').each(function (index) {

            switch (index) {
                case 0:
                    $(this).append('id: ' + response['user']['id']);
                    break;

                case 1:
                    $(this).append('name: ' + response['user']['name']);
                    break;

                case 2:
                    $(this).append('email: ' + response['user']['email']);
                    break;

                case 3:
                    $(this).append('phone: ' + response['user']['phone']);
                    break;

                case 4:
                    $(this).append('position_id: ' + response['user']['position_id']);
                    break;

                case 5:
                    $(this).append('position: ' + response['user']['position']);
                    break;

                case 6:
                    $(this).append("<div class='col-md-5'></div>");
                    $(this).append("<div class='col-md-2'>photo: <img id='image' src='../" + response['user']['photo'] + "' height='70' width='70'></div>");
                    $(this).append("<div class='col-md-5'></div>");
                    break;
            }
        });
    }
});


