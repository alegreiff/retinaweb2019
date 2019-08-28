/*
 * Toggles Search Field on and off
 *
 */
jQuery(document).ready(function ($) {
  $(".search-toggle").click(function () {
    console.log('Se ha hecho clic en un elemento')
    $("#search-container").slideToggle("slow", function () {
      $(".search-toggle").toggleClass("active");
    });
  });
});
