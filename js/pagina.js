jQuery(function ($) {
  //$('#filter').submit(function(){

  var filter = $("#filter");
  console.log("======AAA1");
  console.log(filter.serialize());
  console.log("======");
  $.ajax({
    url: MyAjax.ajaxurl,
    data: filter.serialize(),
    type: "POST",
    beforeSend: function (xhr) {
      filter.find("mensaje").text("cateando..."); // changing the button label
    },
    success: function (data) {
      filter.find("mensaje").text("Mensaje Inicio"); // changing the button label back
      $(".peliculas_paises").html(data); // insert data 
    },
    error: function (err) {
      console.log("001 err net");
      console.log(err);
    }
  });
  return false;
});

jQuery(function ($) {
  //$('#filter').submit(function(){
  $("#filter").on("change", function () {
    var filter = $("#filter");
    console.log(filter.serialize());
    $.ajax({
      url: MyAjax.ajaxurl,
      data: filter.serialize(),
      type: "POST",
      beforeSend: function (xhr) {
        filter.find("mensaje").text("cateando..."); // changing the button label 
        console.log("BeforeSend");
      },
      success: function (data) {
        filter.find("mensaje").text("Mensaje"); // changing the button label back
        $(".peliculas_paises").html(data); // insert data
      },
      error: function (err) {
        console.log("jajajaja");
        console.log(err);
      }
    });
    return false;
  });
});

/*jQuery(function($){
$('a.enlaceajax').on('click', function(){
    event.preventDefault();
    console.log($(this).attr("id"))
    var id = $(this).attr("id");
    $.ajax({
        url: MyAjax.ajaxurl,
        data:{
            categoryfilter: id,
            action: 'misha_filter_function'
        },
        type: 'POST',

        success:function(data){
            //filter.find('button').text('Apply filter'); // changing the button label back
            $('.peliculas_paises').html(data); // insert data
        },
        error: function(err){
            console.log(err)
        }
    });
});

});*/

/*jQuery(function($){
    $.ajax({
        url: MyAjax.ajaxurl,
        data:{
            categoryfilter: '22',
            action: 'misha_filter_function'
        },
        type: 'POST',
        success:function(data){
            //filter.find('button').text('Apply filter'); // changing the button label back
            $('.peliculas_paises').html(data); // insert data
        },
        error: function(err){
            console.log(err)
        }
        });
    });*/
