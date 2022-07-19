$('#calculate').click(function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        url: "/calculate-factorial",
        type: "POST",
        data: {
            value: $('#numeric-input').val(),
        },
        success: function(response) {
            $("#result").html(response.factorial);

        },
    });
    e.preventDefault();
});