//console.log("Cómo se llama la lora");
jQuery(function($) {
  var navOffset = jQuery("#genesis-nav-primary").offset().top;
  jQuery(window).scroll(function() {
    var scrollPos = jQuery(window).scrollTop();
    //console.log(scrollPos);
    if (scrollPos >= navOffset) {
      jQuery("#genesis-nav-primary").addClass("fixedBar");
    } else {
      jQuery("#genesis-nav-primary").removeClass("fixedBar");
    }
  });
});

jQuery(document).ready(function() {
  jQuery(".noticia").click(function() {
    window.location = jQuery(this)
      .find("a")
      .attr("href");
    return false;
  });
  jQuery(".personaje").click(function() {
    window.location = jQuery(this)
      .find("a")
      .attr("href");
    return false;
  });
});
