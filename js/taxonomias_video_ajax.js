jQuery(function ($) {
    //$('#filteresnayoajax').submit(function () {


    var filter = $('#filteresnayoajax');
    let img = pachukas.imagen;
    $.ajax({
        url: pachukas.ajaxurl,
        data: filter.serialize(),

        type: "POST",
        beforeSend: function (xhr) {
            console.log(filter.attr('action'));
            //$('#response').html('procesando'); // insert data

            $('#contenedor_peliculas_ajax').html('<img class="rl_imagen_load" alt="" src="' + img + '" align="center" />');

        },
        success: function (data) {
            filter.find('button').text('Apply filter'); // changing the button label back
            $('#contenedor_peliculas_ajax').html(data); // insert data


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
        let valor = $('#posss option:selected').text()



        var filter = $('#filteresnayoajax');
        let img = pachukas.imagen;
        $.ajax({
            url: pachukas.ajaxurl,
            data: filter.serialize(),

            type: "POST",
            beforeSend: function (xhr) {
                console.log(filter.attr('action'));
                filter.find('button').text('Processing...'); // changing the button label
                $('#contenedor_peliculas_ajax').html('<img class="rl_imagen_load" alt="" src="' + img + '" align="center" />');
            },
            success: function (data) {
                filter.find('button').text('Apply filter'); // changing the button label back
                $('#contenedor_peliculas_ajax').html(data); // insert data
                $('.tax_filter').html(valor);

            },
            error: function (err) {
                console.log("jajajaja");
                console.log(err);
            }
        });
        return false;
    });
});



jQuery(function ($) {
    //$('#filteresnayoajax').submit(function () {

    $("input[name=fechaentrada]").change(function () {

        let valor = $('#posss option:selected').text()



        var filter = $('#filteresnayoajax');
        let img = pachukas.imagen;
        $.ajax({
            url: pachukas.ajaxurl,
            data: filter.serialize(),

            type: "POST",
            beforeSend: function (xhr) {
                console.log(filter.attr('action'));
                $('#contenedor_peliculas_ajax').html('<img class="rl_imagen_load" alt="" src="' + img + '" align="center" />');
            },
            success: function (data) {
                filter.find('button').text('Apply filter'); // changing the button label back
                $('#contenedor_peliculas_ajax').html(data); // insert data
                $('.tax_filter').html(valor);

            },
            error: function (err) {
                console.log("jajajaja");
                console.log(err);
            }
        });
        return false;
    });
});

