<?php
/**
 * Author: Sridhar Katakam
 * Link: https://sridharkatakam.com/
 * https://sridharkatakam.com/custom-search-template-in-genesis-showing-results-grouped-by-post-types/
 */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'sk_do_search_loop' );
/**
 * Outputs a custom loop.
 *
 * @global mixed $paged current page number if paginated.
 * @return void
 */
function sk_do_search_loop() {
	// create an array variable with specific post types in your desired order.
	$post_types = array( 'video', 'post', 'person' );
	echo '<div class="search-content">';
	foreach ( $post_types as $post_type ) {
		// get the search term entered by user.
		$s = isset( $_GET["s"] ) ? $_GET["s"] : "";
		// accepts any wp_query args.
		$args = (array(
			's' => $s,
			'post_type' => $post_type,
			'posts_per_page' => 5,
			'order' => 'ASC',
            'orderby' => 'title',
            'paged' => get_query_var( 'paged' )

		));
        $query = new WP_Query( $args );
        switch ($post_type) {
            case 'video':
                $nombreColeccion = 'Películas';
                break;
            case 'person':
                $nombreColeccion = 'Personajes del cine';
                break;
            case 'post':
                $nombreColeccion = 'Entradas';
                break;
        }
		if ( $query->have_posts() ) {
            echo '<div class="post-type '. $post_type .'"><div class="post-type-heading">'. $nombreColeccion. '</div>';
            echo '<h1>'. $post_type.'</h1>';
			
                
				// remove post info.
				remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
				// remove post image (from theme settings).
				remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
				// remove entry content.
				// remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
				// remove post content nav.
				remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );
				remove_action( 'genesis_entry_content', 'genesis_do_post_permalink', 14 );
				// force content limit.
				add_filter( 'genesis_pre_get_option_content_archive_limit', 'sk_content_limit' );
				// modify the Content Limit read more link.
				add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
				// force excerpts.
				// add_filter( 'genesis_pre_get_option_content_archive', 'sk_show_excerpts' );
				// modify the Excerpt read more link.
				add_filter( 'excerpt_more', 'new_excerpt_more' );
				// modify the length of post excerpts.
				add_filter( 'excerpt_length', 'sp_excerpt_length' );
				// remove entry footer.
				remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
				remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
				remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
				// remove archive pagination.
				//remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
				// custom genesis loop with the above query parameters and hooks.
                if ($post_type!='video'){
                    genesis_custom_loop( $args );
                }else{
                    
                    $loop = new WP_Query( $args );
        if( $loop->have_posts() ):
            echo '<div class="peliculas_search">';
            while( $loop->have_posts() ): $loop->the_post(); global $post;

            $poster = trae_poster(get_field('poster'));
            //$pais_pelicula = get_field('country_group');

            $pais_pelicula = muestra_codigopais(get_field('country_group'));
            d($pais_pelicula);
            $formato_pelicula = wp_get_post_terms(get_the_ID(), 'videos_format')[0]->name;
            $genero_pelicula = wp_get_post_terms(get_the_ID(), 'videos_genres')[0]->name;
            $duracion = get_field('duration');
            $year = get_field('year');

            echo '

            <div class="container">
                <a href="'.get_post_permalink().'">
                    <div class="picture" >
                        <img src="'.$poster.'" alt="">
                        <span class="duracion"> '.($duracion).'</span>
                    </div>
                    <div class="navigation">
                        <span class="pais">'.$pais_pelicula.' - '.$year.'</span>
                        <h4>'.get_the_title().'</h4>
                        <span class="formato">'.muestra_genero($genero_pelicula).'</span>
                    </div>
                </a>
            </div>
            ';
            endwhile;
            echo '</div>';
        endif;
        
        wp_reset_query();
                }
                
			echo '</div>';
            
		}
	}
	echo '</div>'; // .search-content
}
function sk_content_limit() {
	return '150'; // number of characters.
}
function sp_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}
function sk_show_excerpts() {
	return 'excerpts';
}
function new_excerpt_more( $more ) {
    return '... <a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}
function sp_excerpt_length( $length ) {
	return 20; // pull first 20 words.
}
genesis();