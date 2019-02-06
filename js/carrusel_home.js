jQuery(document).ready(function(){
    jQuery('.slider').bxSlider(
        {
            auto: true,
            pager: false,
            
            //captions: true,
            onSliderLoad: function(currentIndex) {
                var indice = currentIndex - 1;
                var enlace = jQuery('.slider div').eq(indice).find("a").attr("href");
                var texto = jQuery('.slider div').eq(indice).find("img").attr("title");
                var elem = "<a href='" + enlace + "'>" + texto + "</a>";
                //alert(elem);
                jQuery(".slider-txt").html(elem);
                //jQuery(".slider-txt").html(jQuery('.slider div').eq(currentIndex).find("img").attr("title"));
            },
            onSlideBefore: function($slideElement, oldIndex, newIndex) {
                var enlace = $slideElement.find("a").attr("href");
                var texto = $slideElement.find("img").attr("title");
                var elem = "<a href='" + enlace + "'>" + texto + "</a>";
                jQuery(".slider-txt").html(elem);
                //jQuery(".slider-txt").html($slideElement.find("img").attr("title"));
            }
        }
    );
  });