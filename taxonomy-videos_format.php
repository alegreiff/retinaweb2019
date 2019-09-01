<?php
//https://wpsmith.net/2011/how-to-make-a-custom-taxonomy-genesis-grid-archive-template/
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'wps_grid_loop_helper');
/** Add support for Genesis Grid Loop **/
    
    
    
function wps_grid_loop_helper(){
    $taxonomy = 'videos_format'; //change me
    $term     = get_query_var('term');
    $term_obj = get_term_by('slug', $term, $taxonomy);
?>
<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filteresnayoajax">
	<?php
		if( $terms = get_terms( array( 'taxonomy' => 'videos_genres', 'orderby' => 'name' ) ) ) : 
 
			echo '<select name="categoryfilter" id="posss"><option value="">Select category...</option>';
			foreach ( $terms as $term ) :
				echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
			endforeach;
			echo '</select>';
		endif;
	?>
	<input type="hidden" name="termino" value="<?php echo $term_obj->term_id;?>">
	<label>
		<input type="radio" name="date" value="ASC" /> Date: Ascending
	</label>
	<label>
		<input type="radio" name="date" value="DESC" selected="selected" /> Date: Descending
	</label>

	
	<button>Apply filter</button>
	<input type="hidden" name="action" value="myfilter">
    
</form>
<div id="response"></div>

<?php
}


 




genesis();