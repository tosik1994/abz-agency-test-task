$(document).ready(function () {
    var plusCount = 6;
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
        currentCount = response['count'];
        userCountOnPage = Object.keys(response['users']).length;
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
        for (k = 0; k < userCountOnPage; k++) {
            $('.container.list').append("<div></div>").append("<br>");
            $('.container.list div').addClass('row');
            $('.container.list div .row').removeClass('row');
        }

        $('.container.list div.row').each(function (index) {
            if (index !== 0) {
                $(this).append("<div class='col-md-1'><a href='/users/" + response['users'][index - 1]['id'] + "'>" + response['users'][index - 1]['id'] + "</a></div>");
                $(this).append("<div class='col-md-2'>" + response['users'][index - 1]['name'] + "</div>");
                $(this).append("<div class='col-md-2'>" + response['users'][index - 1]['email'] + "</div>");
                $(this).append("<div class='col-md-2'>" + response['users'][index - 1]['phone'] + "</div>");
                $(this).append("<div class='col-md-1'>" + response['users'][index - 1]['position_id'] + "</div>");
                $(this).append("<div class='col-md-2'>" + response['users'][index - 1]['position'] + "</div>");
                $(this).append("<div class='col-md-2'><img src='" + response['users'][index - 1]['photo'] + "'></div>");
            }
        });

        $('.container.list').append("<div class='row'></div>").append("<br>");
        $('.container.list div.row').each(function (index) {
            if (index === parseInt(userCountOnPage) + 1) {
                $(this).append("<div class='col-md-4 for-pages'></div>");
                $(this).append("<div class='col-md-4 for-pages'></div>");
                $(this).append("<div class='col-md-4 for-pages'></div>");
                $('.col-md-4.for-pages').each(function (index) {
                    if (index === 1) {
                        for (i = 0; i < response['total_pages']; i++) {
                            $(this).append("<button id='change-page' value='" + (i + 1) + "'>" + (i + 1) + "</button>");
                        }
                    }
                });
            }
        });
        $('.container.list').append("<div class='row'></div>").append("<br>");
        $('.container.list div.row').each(function (index) {
            if (index === (parseInt(userCountOnPage) + 2)) {
                $(this).append("<div class='col-md-4 for-count'></div>");
                $(this).append("<div class='col-md-4 for-count'></div>");
                $(this).append("<div class='col-md-4 for-count'></div>");
                $('.col-md-4.for-count').each(function (index) {
                    if (index === 1) {

                        $(this).append("<button id='show-less' type='button'>Show less</button>");
                        $(this).append("<button id='show-more' type='button'>Show more</button>");
                    }
                });
            }
        });

    }

    $("body").on("click", 'button#change-page', function () {
        changePage($(this).val(), currentCount);
    });

    $("body").on("click", 'button#show-more', function () {
        let count = parseInt(currentCount) + plusCount;
        changeCount(count);
    });

    $("body").on("click", 'button#show-less', function () {
        let count = parseInt(currentCount) - plusCount;
        changeCount(count);
    });

    function changePage(page, count) {
        let url = "api/users?page=" + page + "&count=" + count;
        getResponseAjax(url);
    }

    function changeCount(count) {
        let url = "api/users?page=1&count=" + count;
        getResponseAjax(url);
    }
});


