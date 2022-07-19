function UpdateGrid(gameItems) {
    gameItems.forEach(gameItem => {
        $("#" + gameItem.coordinate).html(gameItem.token);
    });
}

$('#button-start').click(function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        url: "/start-session",
        type: "POST",
        success: function(response) {
            UpdateGrid(response.boardState);
            $("#step-counter").html(response.stepCounter);
        },
    });
    e.preventDefault();
});

$('#button-step').click(function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        url: "/next-step",
        type: "POST",
        success: function(response) {
            UpdateGrid(response.boardState);
            $("#step-counter").html(response.stepCounter);
        },
    });
    e.preventDefault();
});

$('#button-stop').click(function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        url: "/save-session",
        type: "POST",
        success: function(response) {
            $("#saved-session-list").append('<li class="list-group-item"><a class="savedSession" href="javascript:void(0)" id="' + response.savedSessionId + '">' + response.savedSessionId + '</a></li>');
        },
    });
    e.preventDefault();
});


$(document).on('click', '.savedSession', function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/restore-session",
        type: "POST",
        data: {
            sessionName: e.target.id,
        },
        success: function(response) {
            UpdateGrid(response.boardState);
            $("#step-counter").html(response.stepCounter);
        },
    });
    e.preventDefault();
});