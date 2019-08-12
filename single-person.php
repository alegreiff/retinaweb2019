<?php

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'your_custom_loop' );
function your_custom_loop() {

	if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 

	$videos = get_field("videos");		

	/*foreach($videos as $key => $value):
	$image_p= get_post_meta($value->ID, 'poster',true);
	$imgDestacada = wp_get_attachment_url($image_p);						               
	$name = $value->post_title;
	$link = $value->guid;
	endforeach;*/

	/*if(has_post_thumbnail( get_the_ID() )){
		$foto = 'SIII';
	}else{
		$foto = 'NOOO';
	}*/

	if(!get_the_post_thumbnail()){
		$imagen='<img src='.get_stylesheet_directory_uri().'/images/no-imagendestacada.jpg">';
	}else{
		$imagen = get_the_post_thumbnail();
	}
	$nacionalidad = get_field('citizenship_person');
	



	?>
	<div class="personacine">
		<div class="nombrepaispersonacine">
			<h2><?php the_title();?></h2>
			<span><?php echo $nacionalidad;?></span> 
		</div>
		<div class="fotopersonacine">
			<!-- <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt=""> -->
			<?php echo $imagen;?>
			
		</div>
		<div class="infopersona">
		<div class="infopersonacine">
			<?php the_content();?>
		</div>
		<div class="posterespersonacine">
			<?php 
				if($videos){
					foreach($videos as $video){
						$poster = trae_poster(get_field('poster', $video->ID));
						?>
						<img src="<?php echo $poster;?>" alt="">
						<?php
					}
				}else{
					echo '';
				}
			?>
		</div>
		</div>
	
	</div>
	
	<?php
	

		
	} // end while
} // end if




	
}
 

genesis();


