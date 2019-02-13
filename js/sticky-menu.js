console.log("Cómo se llama la lora");
jQuery(function($) {
  var navOffset = jQuery("#genesis-nav-primary").offset().top;
  //jQuery("#genesis-nav-primary").wrap('<div class="nav-placeholder"></div>');
  /* jQuery(".nav-placeholder").height(
    jQuery("#genesis-nav-primary").outerHeight()
  ); */
  //jQuery("#genesis-nav-primary").wrapInner('<div class="nav-inner"></div>');
  jQuery(window).scroll(function() {
    var scrollPos = jQuery(window).scrollTop();
    console.log(scrollPos);
    if (scrollPos >= navOffset) {
      jQuery("#genesis-nav-primary").addClass("fixedBar");
    } else {
      jQuery("#genesis-nav-primary").removeClass("fixedBar");
    }
  });
});

/* $(window).scroll(function () {
    var yPos = $(window).scrollTop();
    if (yPos > 200) {
        // show sticky menu after screen has scrolled down 200px from the top
        $("#subnav").fadeIn();
    } else {
        $("#subnav").fadeOut();
    }
}); */
