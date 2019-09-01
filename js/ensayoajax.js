jQuery(function ($) {
    //$('#filteresnayoajax').submit(function () {


    var filter = $('#filteresnayoajax');
    $.ajax({
        url: pachukas.ajaxurl,
        data: filter.serialize(),
        type: "POST",
        beforeSend: function (xhr) {
            console.log(filter.attr('action'));
            filter.find('button').text('Processing...'); // changing the button label
        },
        success: function (data) {
            filter.find('button').text('Apply filter'); // changing the button label back
            $('#response').html(data); // insert data

        },
        error: function (err) {
            console.log("jajajaja");
            console.log(err);
        }
    });
    return false;

});
jQuery(function ($) {
    //$('#filteresnayoajax').submit(function () {
    $("#posss").on("change", function () {

        var filter = $('#filteresnayoajax');
        $.ajax({
            url: pachukas.ajaxurl,
            data: filter.serialize(),
            type: "POST",
            beforeSend: function (xhr) {
                console.log(filter.attr('action'));
                filter.find('button').text('Processing...'); // changing the button label
            },
            success: function (data) {
                filter.find('button').text('Apply filter'); // changing the button label back
                $('#response').html(data); // insert data

            },
            error: function (err) {
                console.log("jajajaja");
                console.log(err);
            }
        });
        return false;
    });
});