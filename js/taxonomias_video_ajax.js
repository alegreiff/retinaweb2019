jQuery(function ($) {
    //$('#filtrotaxonomias_formato').submit(function () {


    var filter = $('#filtrotaxonomias_formato');
    let valor = $('input[name=genero]:checked').attr('data-value');
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
            $('.tax_filter').html(valor);


        },
        error: function (err) {
            console.log("jajajaja");
            console.log(err);
        }
    });
    return false;

});
jQuery(function ($) {
    //$('#filtrotaxonomias_formato').submit(function () {
    $("#filtrotaxonomias_formato").on("change", function () {
        let valor = $('input[name=genero]:checked').attr('data-value');
        var filter = $('#filtrotaxonomias_formato');
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



/* jQuery(function ($) {

    $("input[name=fechaentrada]").change(function () {

        let valor = $('#posss option:selected').text()
        var filter = $('#filtrotaxonomias_formato');
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
                filter.find('button').text('Apply filter');
                $('#contenedor_peliculas_ajax').html(data);
                $('.tax_filter').html(valor);

            },
            error: function (err) {
                console.log("jajajaja");
                console.log(err);
            }
        });
        return false;
    });
}); */

