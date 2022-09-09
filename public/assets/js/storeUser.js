$(document).ready(function () {
    let getPositionsListUrl = window.location.protocol + "//" + window.location.host + "/api/positions";
    let postRegisterUserUrl = window.location.protocol + "//" + window.location.host + "/api/users";

    function postRegisterUserAjax(url, data) {

        $.ajax({
            url: url,
            type: 'post',
            data: data,
            cache: false,
            dataType: "json",
            headers: {'Authorization': 'Bearer ' + data.get('token') + ''},
            processData: false,
            contentType: false,
            success: function (response) {
                return response;
            },
            error: function (response) {
                return response;
            }
        });
    }

    function getResponsePositionLists(url) {
        $.ajax({
            url: url,
            type: 'get',
            dataType: "json",
            success: function (response) {
                fillSelect(response);
            }
        });
    }

    getResponsePositionLists(getPositionsListUrl);

    function fillSelect(response) {
        let positionsCount = Object.keys(response['positions']).length;
        for (i = 0; i < positionsCount; i++) {
            $('.container.list div.row select').append("<option value='" + response['positions'][i]['id'] + "'>" + response['positions'][i]['name'] + "</option>")
        }
    }

    var files;

    $('input[type=file]').on('change', function () {
        files = this.files;
    });
    
    $("#register").click(function () {
        var data = new FormData();
        var dataWithOutForm = $('form').serializeArray();
        $.each(dataWithOutForm, function (key, value) {
            data.append(value['name'], value['value']);
        });
        if (typeof files == 'undefined') files = 0;
        $.each(files, function (key, value) {
            data.append('photo', value);
        });

        postRegisterUserAjax(postRegisterUserUrl, data);

    });
});


