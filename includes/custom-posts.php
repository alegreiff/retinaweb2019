<?php

add_action( 'add_meta_boxes', 'ts_pricing_table_add_custom_box' );
add_action( 'save_post', 'ts_pricing_table_save_postdata' );

function ts_pricing_table_add_custom_box()
{
	add_meta_box( 
        'ts_pricing_table',
        'Pricing table',
        'ts_pricing_table_custom_box',
        'ts_pricing_table' 
    );
}

function ts_pricing_table_custom_box( $post )
{
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'ts_pricing_table_nonce' ); 
	$ts_pricing_table_items = get_post_meta($post->ID, 'ts_pricing_table', TRUE);
	$ts_pricing_table_details = get_post_meta($post->ID, 'ts_pricing_table_details', TRUE);

	echo '
	<h4>' . __( 'Pricing table details','slimvideo' ) . '</h4>
	<table width="450"><tr class="ts_pricing_table-price">
				<td>' . __( 'Price','slimvideo' ) . '</td>
				<td>
					<input type="text" class="price" name="ts_pricing_table_details[price]" value="'.@$ts_pricing_table_details['price'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="ts_pricing_table-details">
				<td>' . __( 'Description','slimvideo' ) . '</td>
				<td>
					<input type="text" class="description" name="ts_pricing_table_details[description]" value="'.@$ts_pricing_table_details['description'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="ts_pricing_table-currency">
				<td>' . __( 'Currency','slimvideo' ) . '</td>
				<td>
					<input type="text" class="currency" name="ts_pricing_table_details[currency]" value="'.@$ts_pricing_table_details['currency'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="ts_pricing_table-period">
				<td>' . __( 'Period','slimvideo' ) . '</td>
				<td>
					<input type="text" class="pricing-period" name="ts_pricing_table_details[period]" value="'.@$ts_pricing_table_details['period'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="ts_pricing_table-url">
				<td>' . __( 'Button URL','slimvideo' ) . '</td>
				<td>
					<input type="text" class="pricing-url" name="ts_pricing_table_details[url]" value="'.@$ts_pricing_table_details['url'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="ts_pricing_table-button-text">
				<td>' . __( 'Button Text','slimvideo' ) . '</td>
				<td>
					<input type="text" class="pricing-text" name="ts_pricing_table_details[button_text]" value="'.@$ts_pricing_table_details['button_text'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="ts_pricing_table-button-text">
				<td>' . __( 'Set as featured','slimvideo' ) . '</td>
				<td>
					<input type="radio" class="pricing-featured" name="ts_pricing_table_details[featured]" value="yes"'.  checked(@$ts_pricing_table_details['featured'], 'yes', false). ' /> Yes
					<input type="radio" class="pricing-featured" name="ts_pricing_table_details[featured]" value="no" '. checked(@$ts_pricing_table_details['featured'], 'no', false) . checked(@$ts_pricing_table_details['featured'], '', false) . ' /> No
				</td>
			</tr></table><br><br>';
	echo '<input type="button" class="button" id="add-item" value="' .__('Add New Pricing table Item','slimvideo'). '" /><br/>';
	echo '<ul id="ts_pricing_table-items">';
	
	$ts_pricing_table_editor = '';

	if (!empty($ts_pricing_table_items)) {
		$index = 0;
		foreach ($ts_pricing_table_items as $ts_pricing_table_item_id => $ts_pricing_table_item) {
			$index++;

			$ts_pricing_table_editor .= '
			<li class="ts_pricing_table-item">
			<div class="sortable-meta-element"><span class="tab-arrow icon-down"></span> <span class="ts_pricing_table-item-tab ts-multiple-item-tab">'.($ts_pricing_table_item['item_title'] ? $ts_pricing_table_item['item_title'] : 'Item ' . $index).'</span></div>
			<table class="hidden">
			<tr>
				<td>' . __( 'Title','slimvideo' ) . '</td>
				<td>
					<input type="text" class="item_title" name="ts_pricing_table['.$ts_pricing_table_item_id.'][item_title]" value="'.$ts_pricing_table_item['item_title'].'" style="width: 100%" />
				</td>
			</tr>
			<tr>
				<td></td><td><input type="button" class="button button-primary remove-item" value="'.__('Remove','slimvideo').'" /></td>
			</tr>
			</table>

			</li>';
		}
	}

	echo $ts_pricing_table_editor;
	
	echo '</ul>';

	echo '<script id="ts_pricing_table-items-template" type="text/template">';
	echo '<li class="ts_pricing_table-item">
	<div class="sortable-meta-element"><span class="tab-arrow icon-down"></span> <span class="ts_pricing_table-item-tab ts-multiple-item-tab">Pricing table {{slide-number}}</span></div>
	<table>
		<tr>
			<td>' . __( 'Title','slimvideo' ) . '</td>
			<td>
				<input type="text" class="item_title" name="ts_pricing_table[{{item-id}}][item_title]" value="" style="width: 100%" />
			</td>
		</tr>
		<tr>
			<td></td><td><input type="button" class="button button-primary remove-item" value="'.__('Remove','slimvideo').'" /></td>
		</tr>
	</table></li>';
	
	echo '</script>';
?>
	<script>
	jQuery(document).ready(function($) {
		var ts_pricing_table_items = $("#ts_pricing_table-items > li").length;

		// sortable ts_pricing_table items
		$("#ts_pricing_table-items").sortable();
		//$("#ts_pricing_table-items").disableSelection();

		$(document).on('change', '.item_title', function(event) {
			event.preventDefault();
			var _this = $(this);
			_this.closest('.ts_pricing_table-item').find('.ts_pricing_table-item-tab').text(_this.val());
		});

		// Media uploader
		var items = $('#ts_pricing_table-items');
			slideTempalte = $('#ts_pricing_table-items-template').html();

		// Remove item
		$(document).on('click', '.remove-item', function(event) {
			event.preventDefault();
			$(this).closest('li').remove();
			ts_pricing_table_items--;
		});

		$(document).on('click', '#add-item', function(event) {
			event.preventDefault();
			ts_pricing_table_items++;
			var sufix = new Date().getTime();
			var item_id = new RegExp('{{item-id}}', 'g');
			var item_number = new RegExp('{{slide-number}}', 'g');

			var template = slideTempalte.replace(item_id, sufix).replace(item_number, ts_pricing_table_items);
			items.append(template);
		});
	});
	</script>
<?php
}

// saving slider
function ts_pricing_table_save_postdata( $post_id )
{
	global $post;

	if ( isset($post->post_type) && @$post->post_type != 'ts_pricing_table' ) {
		return;
	}

	if ( ! isset( $_POST['ts_pricing_table_nonce'] ) ||
		 ! wp_verify_nonce( $_POST['ts_pricing_table_nonce'], plugin_basename( __FILE__ ) ) 
	) return;

	if( !current_user_can( 'edit_post', $post_id ) ) return;

	// array containing filtred items
	$ts_pricing_table_items = array();

	if ( isset( $_POST['ts_pricing_table'] ) ) {
		if ( is_array( $_POST['ts_pricing_table'] ) && !empty( $_POST['ts_pricing_table'] ) ) {
			foreach ( $_POST['ts_pricing_table'] as $item_id => $ts_pricing_table_item ) {

				$p = array();
				$p['item_id']	= $item_id;


				$p['item_title'] = isset($ts_pricing_table_item['item_title']) ?
								esc_textarea($ts_pricing_table_item['item_title']) : '';

				$ts_pricing_table_items[] = $p; 
			}
		}
	}
	if(isset($_POST['ts_pricing_table_details'])){
		$ts_pricing_table_details = $_POST['ts_pricing_table_details'];
	}

    update_post_meta( $post_id, 'ts_pricing_table', $ts_pricing_table_items );
    update_post_meta( $post_id, 'ts_pricing_table_details', $ts_pricing_table_details );
}

add_action( 'add_meta_boxes', 'ts_portfolio_add_custom_box' );
add_action( 'save_post', 'ts_portfolio_save_postdata' );

function ts_portfolio_add_custom_box()
{
	add_meta_box( 
        'ts_portfolio',
        'Portfolio',
        'ts_portfolio_custom_box',
        'portfolio' 
    );
}

function ts_portfolio_custom_box( $post )
{
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'ts_portfolio_nonce' ); 
	$portfolio_items = get_post_meta($post->ID, 'ts_portfolio', TRUE);
	$portfolio_details = get_post_meta($post->ID, 'ts_portfolio_details', TRUE);

	echo '
	<h4>' . __( 'Portfolio details','slimvideo' ) . '</h4>
	<table width="450"><tr class="portfolio-client">
				<td>' . __( 'Client','slimvideo' ) . '</td>
				<td>
					<input type="text" class="client" name="portfolio_details[client]" value="'.@$portfolio_details['client'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="portfolio-services">
				<td>' . __( 'Services','slimvideo' ) . '</td>
				<td>
					<input type="text" class="services" name="portfolio_details[services]" value="'.@$portfolio_details['services'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="portfolio-client-url">
				<td>' . __( 'Project URL','slimvideo' ) . '</td>
				<td>
					<input type="text" class="client_url" name="portfolio_details[project_url]" value="'.@$portfolio_details['project_url'].'" style="width: 100%" />
				</td>
			</tr></table><br><br>';
	echo '<input type="button" class="button" id="add-item" value="' .__('Add New Portfolio Item','slimvideo'). '" /><br/>';
	echo '<ul id="portfolio-items">';
	
	$portfolio_editor = '';

	if (!empty($portfolio_items)) {
		$index = 0;
		foreach ($portfolio_items as $portfolio_item_id => $portfolio_item) {
			$index++;
			$is_image = ($portfolio_item['item_type'] == 'i') ? 'checked="checked"' : ''; 
			$is_video = ($portfolio_item['item_type'] == 'v') ? 'checked="checked"' : ''; 

			$portfolio_editor .= '
			<li class="portfolio-item">
			<div class="sortable-meta-element"><span class="tab-arrow icon-up"></span> <span class="portfolio-item-tab">'.($portfolio_item['slide_title'] ? $portfolio_item['slide_title'] : 'Slide ' . $index).'</span></div>
			<table class="hidden">
			<tr>
				<td>' . __( 'Item type','slimvideo' ) . '</td>
				<td>
					<label for="item-type-image-'.$portfolio_item_id.'">
						<input type="radio" class="item-type-image" name="portfolio['.$portfolio_item_id.'][item_type]" value="i" checked="checked" id="item-type-image-'.$portfolio_item_id.'" '.$is_image.'/> Image
					</label> 
					<label for="item-type-video-'.$portfolio_item_id.'">
						<input type="radio" class="item-type-video" name="portfolio['.$portfolio_item_id.'][item_type]" value="v" id="item-type-video-'.$portfolio_item_id.'" '.$is_video.'/> Video
					</label>
				</td>
			</tr>
			<tr>
				<td>' . __( 'Title','slimvideo' ) . '</td>
				<td>
					<input type="text" class="slide_title" name="portfolio['.$portfolio_item_id.'][slide_title]" value="'.$portfolio_item['slide_title'].'" style="width: 100%" />
				</td>
			</tr>
			<tr class="portfolio-embed '.( $is_image ? 'hidden' : '' ).'">
				<td valign="top">' . __( 'Embed/Video URL<br/>(<a href="http://codex.wordpress.org/Embeds#Can_I_Use_Any_URL_With_This.3F" target="_blank">supported sites</a>)','slimvideo' ) . '</td>
				<td>
					<textarea name="portfolio['.$portfolio_item_id.'][embed]" cols="60" rows="5">'.$portfolio_item['embed'].'</textarea>
				</td>
			</tr>
			<tr class="portfolio-description '.( $is_video ? 'hidden' : '' ).'">
				<td valign="top">' . __( 'Description','slimvideo' ) . '</td>
				<td>
					<textarea class="slide_description" name="portfolio['.$portfolio_item_id.'][description]" cols="60" rows="5">'.$portfolio_item['description'].'</textarea>
				</td>
			</tr>
			<tr class="portfolio-image-url '.( $is_video ? 'hidden' : '' ).'">
				<td>' . __( 'Image URL','slimvideo' ) . '</td>
				<td>
					<input type="text" class="slide_url" name="portfolio['.$portfolio_item_id.'][item_url]" value="'.$portfolio_item['item_url'].'" />
					<input type="hidden" class="slide_media_id" name="portfolio['.$portfolio_item_id.'][media_id]" value="'.$portfolio_item['media_id'].'" />
					<input type="button" id="upload-'.$portfolio_item_id.'" class="button ts-upload-slide" value="' .__( 'Upload','slimvideo' ). '" /> 
				</td>
			</tr>
			<tr class="portfolio-redirect-url '.( $is_video ? 'hidden' : '' ).'">
				<td>' . __( 'Redirect to URL','slimvideo' ) . '</td>
				<td>
					<input type="text" class="redirect_to_url" name="portfolio['.$portfolio_item_id.'][redirect_to_url]" value="'.$portfolio_item['redirect_to_url'].'" style="width: 100%" />
				</td>
			</tr>
			<tr>
				<td></td><td><input type="button" class="button button-primary remove-item" value="'.__('Remove','slimvideo').'" /></td>
			</tr>
			</table>

			</li>';
		}
	}

	echo $portfolio_editor;
	
	echo '</ul>';

	echo '<script id="portfolio-items-template" type="text/template">';
	echo '<li class="portfolio-item">
	<div class="sortable-meta-element"><span class="tab-arrow icon-up"></span> <span class="portfolio-item-tab">Slide {{slide-number}}</span></div>
	<table>
		<tr>
			<td>' . __( 'Item type','slimvideo' ) . '</td>
			<td>
				<label for="item-type-image-{{item-id}}">
					<input type="radio" class="item-type-image" name="portfolio[{{item-id}}][item_type]" value="i" checked="checked" id="item-type-image-{{item-id}}"/> Image
				</label> 
				<label for="item-type-video-{{item-id}}">
					<input type="radio" class="item-type-video" name="portfolio[{{item-id}}][item_type]" value="v" id="item-type-video-{{item-id}}" /> Video
				</label>
			</td>
		</tr>
		<tr>
			<td>' . __( 'Title','slimvideo' ) . '</td>
			<td>
				<input type="text" class="slide_title" name="portfolio[{{item-id}}][slide_title]" value="" style="width: 100%" />
			</td>
		</tr>
		<tr class="portfolio-embed hidden">
			<td valign="top">' . __( 'Embed/Video URL<br/>(<a href="http://codex.wordpress.org/Embeds#Can_I_Use_Any_URL_With_This.3F" target="_blank">supported sites</a>)','slimvideo' ) . '</td>
			<td>
				<textarea name="portfolio[{{item-id}}][embed]" cols="60" rows="5"></textarea>
			</td>
		</tr>
		<tr class="portfolio-description">
			<td valign="top">' . __( 'Description','slimvideo' ) . '</td>
			<td>
				<textarea class="slide_description" name="portfolio[{{item-id}}][description]" cols="60" rows="5"></textarea>
			</td>
		</tr>
		<tr class="portfolio-image-url">
			<td>' . __( 'Image URL','slimvideo' ) . '</td>
			<td>
				<input type="text" class="slide_url" name="portfolio[{{item-id}}][item_url]" value="" />
				<input type="hidden" class="slide_media_id" name="portfolio[{{item-id}}][media_id]" value="" />
				<input type="button" id="upload-{{item-id}}" class="button ts-upload-slide" value="' .__( 'Upload','slimvideo' ). '" /> 
			</td>
		</tr>
		<tr class="portfolio-redirect-url">
			<td>' . __( 'Redirect to URL','slimvideo' ) . '</td>
			<td>
				<input type="text" class="redirect_to_url" name="portfolio[{{item-id}}][redirect_to_url]" value="" style="width: 100%" />
			</td>
		</tr>
		<tr>
			<td></td><td><input type="button" class="button button-primary remove-item" value="'.__('Remove','slimvideo').'" /></td>
		</tr>
	</table></li>';
	
	echo '</script>';
?>
	<script>
	jQuery(document).ready(function($) {
		var portfolio_items = $("#portfolio-items > li").length;

		// sortable portfolio items
		$("#portfolio-items").sortable();
		//$("#portfolio-items").disableSelection();

		$(document).on('change', '.slide_title', function(event) {
			event.preventDefault();
			var _this = $(this);
			_this.closest('.portfolio-item').find('.portfolio-item-tab').text(_this.val());
		});

		// Content type switcher
		$(document).on('click', '.item-type-image', function(event) {
			var _this = $(this);
			_this.closest('table').find('.portfolio-embed').hide();
			_this.closest('table').find('.portfolio-description').show();
			_this.closest('table').find('.portfolio-image-url').show();
			_this.closest('table').find('.portfolio-redirect-url').show();
		});

		$(document).on('click', '.item-type-video', function(event) {
			var _this = $(this);
			_this.closest('table').find('.portfolio-embed').show();
			_this.closest('table').find('.portfolio-description').hide();
			_this.closest('table').find('.portfolio-image-url').hide();
			_this.closest('table').find('.portfolio-redirect-url').hide();
		});

		// Media uploader
		var items = $('#portfolio-items'),
			slideTempalte = $('#portfolio-items-template').html(),
			custom_uploader = {};
		  	
		if (typeof wp.media.frames.file_frame == 'undefined') {
		    wp.media.frames.file_frame = {};
		}

		$(document).on('click', '#add-item', function(event) {
			event.preventDefault();
			portfolio_items++;
			var sufix = new Date().getTime();
			var item_id = new RegExp('{{item-id}}', 'g');
			var item_number = new RegExp('{{slide-number}}', 'g');

			var template = slideTempalte.replace(item_id, sufix).replace(item_number, portfolio_items);
			items.append(template);
		});

		$(document).on('click', '.remove-item', function(event) {
			event.preventDefault();
			$(this).closest('li').remove();
			portfolio_items--;
		});

		
		$(document).on('click', '.ts-upload-slide', function(e) {
			e.preventDefault();
			
			var _this     = $(this),
				target_id = _this.attr('id'),
				media_id  = _this.closest('li').find('.slide_media_id').val();
			
			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader[target_id]) {
				custom_uploader[target_id].open();
				return;
			}

			//Extend the wp.media object
			custom_uploader[target_id] = wp.media.frames.file_frame[target_id] = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				library: {
					type: 'image'
				},
				multiple: false,
				selection: [media_id]
			});

			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader[target_id].on('select', function() {
				var attachment = custom_uploader[target_id].state().get('selection').first().toJSON();
				var item = _this.closest('table');
				
				item.find('.slide_url').val(attachment.url);
				item.find('.slide_media_id').val(attachment.id);
			});

			//Open the uploader dialog
			custom_uploader[target_id].open();
		});
	});
	</script>
<?php
}

// saving slider
function ts_portfolio_save_postdata( $post_id )
{
	global $post;

	if ( isset($post->post_type) && @$post->post_type != 'portfolio' ) {
		return;
	}

	if ( ! isset( $_POST['ts_portfolio_nonce'] ) ||
		 ! wp_verify_nonce( $_POST['ts_portfolio_nonce'], plugin_basename( __FILE__ ) ) 
	) return;

	if( !current_user_can( 'edit_post', $post_id ) ) return;

	// array containing filtred items
	$portfolio_items = array();

	if ( isset( $_POST['portfolio'] ) ) {
		if ( is_array( $_POST['portfolio'] ) && !empty( $_POST['portfolio'] ) ) {
			foreach ( $_POST['portfolio'] as $item_id => $portfolio_item ) {

				$p = array();
				$p['item_id']	= $item_id;

				$p['item_type'] = isset($portfolio_item['item_type']) ?
								esc_attr($portfolio_item['item_type']) : '';

				$p['item_type'] = isset($portfolio_item['item_type']) && 
								( $portfolio_item['item_type'] === 'i' || $portfolio_item['item_type'] === 'v' ) ?
								$portfolio_item['item_type'] : 'i';

				$p['slide_title'] = isset($portfolio_item['slide_title']) ?
								esc_textarea($portfolio_item['slide_title']) : ''; 

				$p['embed']	= isset($portfolio_item['embed']) ?
							esc_textarea($portfolio_item['embed']) : ''; 

				$p['description'] = isset($portfolio_item['description']) ?
								esc_textarea($portfolio_item['description']) : ''; 

				$p['item_url'] = isset($portfolio_item['item_url']) ?
								esc_url($portfolio_item['item_url']) : '';

				$p['media_id'] = isset($portfolio_item['media_id']) ?
								esc_attr($portfolio_item['media_id']) : '';

				$p['redirect_to_url'] = isset($portfolio_item['redirect_to_url']) ?
									esc_url($portfolio_item['redirect_to_url']) : '';

				$portfolio_items[] = $p; 
			}
		}
	}
	if(isset($_POST['portfolio_details'])){
		$portfolio_details = $_POST['portfolio_details'];
	}

    update_post_meta( $post_id, 'ts_portfolio', $portfolio_items );
    update_post_meta( $post_id, 'ts_portfolio_details', $portfolio_details );
}

add_action( 'add_meta_boxes', 'ts_teams_add_custom_box' );
add_action( 'save_post', 'ts_teams_save_post' );

function ts_teams_add_custom_box()
{
	add_meta_box( 
        'ts_member',
        __('About Team Member','slimvideo'),
        'ts_teams_options_custom_box',
        'ts_teams' 
    );

    add_meta_box( 
        'ts_member_networks',
        __('Social Networks','slimvideo'),
        'ts_teams_social_networks_custom_box',
        'ts_teams' 
    );
}

function ts_teams_options_custom_box($post)
{
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'ts_teams_nonce' ); 	
	$teams = get_post_meta($post->ID, 'ts_member', TRUE);
    
	if (!$teams) {
		$teams = array();
		$teams['about_member'] = '';
        $teams['position'] = '';
		$teams['team-user'] = '';
	}

    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => '',
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => array(),
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'login',
        'order'        => 'ASC',
        'offset'       => '',
        'search'       => '',
        'number'       => '',
        'count_total'  => false,
        'fields'       => 'all',
        'who'          => ''
    );
    $users = get_users($args);
    $html = '';

    if( isset($users) && is_array($users) && count($users) > 0 ){
        $none = ($teams['team-user'] == 'none' || $teams['team-user'] == '') ? ' selected="selected"' : '';
        $html .= '<select name="teams[team-user]">
                    <option' . $none . ' value="none">' . __('None','slimvideo') . '</option>';
        foreach($users as $user){
            if( is_object($user) && isset($user->ID, $user->user_login) ){
                if( $teams['team-user'] == $user->ID ) $selected = ' selected="selected"';
                else $selected = '';
                $html .= '<option' . $selected . ' value="' . $user->ID . '">' . $user->user_login . '</option>';
            }
        }   
        $html .= '</select>';
    }

	echo '<table>
		<tr valign="top">
			<td>' . __('Short information','slimvideo') . '</td>
			<td>
				<textarea name="teams[about_member]" cols="60" rows="5">'.esc_attr($teams['about_member']).'</textarea>
			</td>
		</tr>
		<tr>
            <td>' . __('Title','slimvideo') . '</td>
            <td>
                <input type="text" name="teams[position]" value="'.esc_attr($teams['position']).'" />
            </td>
        </tr>
        <tr>
			<td>' . __('Link team member to a user','slimvideo') . '</td>
			<td>
				' . balanceTags($html, true) . '
			</td>
		</tr>
		</table>';

}

function ts_teams_social_networks_custom_box($post)
{
	$teams = get_post_meta($post->ID, 'ts_member', TRUE);
	$arraySocials = array('facebook', 'twitter', 'linkedin', 'gplus', 'email', 'skype', 'github', 'dribble', 'lastfm', 'linkedin', 'tumblr', 'twitter', 'vimeo', 'wordpress', 'yahoo', 'youtube', 'flickr', 'pinterest', 'instagram');
    $teams  = (isset($teams) && !empty($teams)) ? $teams : array();
    $optionsSocial = get_option( 'slimvideo_social' );
    $customSocial = (isset($optionsSocial['social_new']) && is_array($optionsSocial['social_new']) && !empty($optionsSocial['social_new'])) ? $optionsSocial['social_new'] : '';

    echo '<table class="socials-admin">';
        foreach($arraySocials as $social){
            if( !isset($teams[$social]) ){
                $teams[$social] = '';
            }

            if( $social == 'email' ){
                $icon = 'mail';
            }elseif( $social == 'dribble' ){
                $icon = 'dribbble';
            }elseif( $social == 'youtube' ){
                $icon = 'video';
            }else{
                $icon = NULL;
            }

            echo    '<tr>
                        <td>
                            <i alt="'. $social .'" class="icon-'. (isset($icon) ? $icon : $social) .'"></i>
                        </td>
                        <td>
                            <input type="text" name="teams['. $social .']" value="'. $teams[$social] .'" />
                        </td>
                    </tr>';
        }

        if( !empty($customSocial) ){
            foreach($customSocial as $key => $social){
                $socialNew = (isset($teams[$key])) ? $teams[$key] : '';

                echo    '<tr>
                            <td>
                                <img src="'. esc_url($social['image']) .'" style="width: 22px;"/>
                            </td>
                            <td>
                                <input type="text" name="teams['. $key .']" value="'. $socialNew .'" />
                            </td>
                        </tr>';
            }
        }

    echo '</table>';

}

function ts_teams_save_post($post_id)
{
	global $post;

    if ( isset($post->post_type) && @$post->post_type != 'ts_teams' ) {
        return;
    }
	
	if (!isset( $_POST['ts_teams_nonce'] ) ||
		!wp_verify_nonce( $_POST['ts_teams_nonce'], plugin_basename( __FILE__ ) ) 
	) return;

	if( !current_user_can( 'edit_post', $post_id ) ) return;
	
	// array containing filtred slides
    $teams = array();
    $optionsSocial = get_option( 'slimvideo_social' );
    $customSocial = (isset($optionsSocial['social_new']) && is_array($optionsSocial['social_new']) && !empty($optionsSocial['social_new'])) ? $optionsSocial['social_new'] : '';

    $arraySocials = array('facebook', 'twitter', 'linkedin', 'gplus', 'email', 'skype', 'github', 'dribble', 'lastfm', 'linkedin', 'tumblr', 'twitter', 'vimeo', 'wordpress', 'yahoo', 'youtube', 'flickr', 'pinterest', 'instagram');

    if( !empty($customSocial) ){
        $arraySocials = array_merge($arraySocials, array_keys($customSocial));
    }

    if ( isset( $_POST['teams'] ) && is_array( $_POST['teams'] ) && !empty( $_POST['teams'] )  ) {
		$t = $_POST['teams'];
		$teams['about_member'] = isset($t['about_member']) ? wp_kses_post($t['about_member']) : '';
		$teams['position']     = isset($t['position']) ? sanitize_text_field($t['position']) : '';
		$teams['team-user']    = isset($t['team-user']) ? sanitize_text_field($t['team-user']) : '';

        foreach($t as $key => $value){
            
            if( in_array($key, $arraySocials) ){
                $teams[$key] = esc_url_raw($value);
            }
        }

    } else {
		$teams['about_member'] = '';
		$teams['position']     = '';
		$teams['team-user']    = '';
        foreach($arraySocials as $social){
            $teams[$social] = '';
        }
    }

    update_post_meta( $post_id, 'ts_member', $teams );
}


add_action( 'add_meta_boxes', 'ts_videos_add_custom_box' );
add_action( 'save_post', 'ts_videos_save_post' );

function ts_videos_add_custom_box()
{
	add_meta_box( 
        'video',
        __('Insert Video','slimvideo'),
        'ts_videos_options_custom_box',
        'video' 
    );
}

function ts_videos_options_custom_box($post)
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_videos_nonce' );   
    $videos = get_post_meta($post->ID, 'video', TRUE);
    $your = (isset($videos['your_url'])) ? $videos['your_url'] : '';
    $extern = (isset($videos['extern_url'])) ? $videos['extern_url'] : '';
    $embed = (isset($videos['embed'])) ? $videos['embed'] : '';
    $active = (empty($your) && empty($extern) && empty($embed)) ? ' class="active"' : '';
    $default_videoplayer = fields::get_options_value('slimvideo_single_post', 'default_videoplayer');
    $ajax_nonce = wp_create_nonce( "video-image" );
    wp_nonce_field( 'ts_layout_nonce', 'ts_layout_nonce_filed' );
?>
    <ul class="ts-url nav nav-tabs" role="tablist">
        <li <?php echo $active; if( !empty($extern) ) echo ' class="active"' ?>><a href="#extern" role="tab" data-toggle="tab"><?php _e('Use video URL', 'slimvideo'); ?></a></li>
        <li <?php if( !empty($your) ) echo ' class="active"' ?>><a href="#your" role="tab" data-toggle="tab"><?php _e('Upload video', 'slimvideo'); ?></a></li>
        <?php if( $default_videoplayer !== 'y' ): ?>
        <li <?php if( !empty($embed) ) echo ' class="active"' ?>><a href="#embed" role="tab" data-toggle="tab"><?php _e('Use EMBED code', 'slimvideo'); ?></a></li>
        <?php endif; ?>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane<?php if( $active === ' class="active"' ) echo ' active'; if( !empty($extern) ) echo ' active'; ?>" id="extern">
            <textarea id="ts-video-url" class="ts-empty-click" name="video[extern_url]" cols="60" rows="5"><?php echo esc_url($extern); ?></textarea>
            <input class="ts-tab-active" type="hidden" name="video[tab-active][extern_url]" value="" />
            <div class="ts-option-description"><?php _e('Insert your external video URL here. All services supported by WordPress are available. You can check the list here', 'slimvideo'); ?>: <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"><?php _e('Source List', 'slimvideo'); ?></a></div>
        </div>
        <div role="tabpanel" class="tab-pane<?php if( !empty($your) ) echo ' active' ?>" id="your">
            <input class="ts-empty-click" type="text" value="<?php echo esc_url($your); ?>" name="video[your_url]" id="custom-type-upload-videos"/>
            <input type="hidden" value="" id="select-custom_media_id" />
            <input type="button" class="button" id="select-custom-type-video" value="Upload" />
            <input class="ts-tab-active" type="hidden" name="video[tab-active][your_url]" value="" />
            <br><br>
              <div class="ts-option-description"><?php _e('Upload your video here. We would recommend using MP4 file format for best compatibility', 'slimvideo'); ?></div>
        </div>
        <div role="tabpanel" class="tab-pane<?php if( !empty($embed) ) echo ' active' ?>" id="embed">
            <textarea class="ts-empty-click" name="video[embed]" cols="60" rows="5"><?php echo $embed; ?></textarea>
            <input class="ts-tab-active" type="hidden" name="video[tab-active][embed]" value="" />
            <br><br>
            <div class="ts-option-description"><?php _e('Insert your embed code here. You can take videos from anywhere you want, embeds provided from anywhere. NOTE: Not all services could work properly (video resizing). If you tried a service and there was a problem with it, please report this on our help desk.', 'slimvideo'); ?></div>
        </div>
        <div>
            <input style="display: none;" id="ts-get-featured-image" type="button" value="<?php _e('Get featured image', 'slimvideo'); ?>" />
        </div>
        <div style="display: none;" class="ts-remove-featured">
            <a id="ts-remove-featured-image" data-post-id="<?php echo $post->ID; ?>" href="#"><?php _e('Remove featured image', 'slimvideo'); ?></a>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery('.ts-url > li.active > a').tab('show');

            jQuery( '.ts-url > li' ).click(function(){
                setTimeout(function(){
                    jQuery('div[role="tabpanel"]').each(function(){
                        if( jQuery(this).hasClass('active') ){
                            jQuery('.ts-tab-active').val('');
                            jQuery(this).find('.ts-tab-active').val('1');
                        }
                    })

                    if( typeof(jQuery('.ts-url > li:first-child')) !== 'undefined' && jQuery('.ts-url > li:first-child').hasClass('active') ){
                        jQuery('#ts-get-featured-image').css('display', '');
                    }else{
                        jQuery('#ts-get-featured-image').css('display', 'none');
                    }

                }, 100);
            });

            if( typeof(jQuery('.ts-url > li:first-child')) !== 'undefined' && jQuery('.ts-url > li:first-child').hasClass('active') ){
                jQuery('#ts-get-featured-image').css('display', '');
            }else{
                jQuery('#ts-get-featured-image').css('display', 'none');
            }

            jQuery('#ts-get-featured-image').click(function(event){
                event.preventDefault();
                var link = jQuery('#ts-video-url').val();

                jQuery.post(ajaxurl, 'action=ts_video_image&link=' + link + '&post_id=<?php echo $post->ID; ?>&nonce=<?php echo $ajax_nonce; ?>', function(response){
                    response = jQuery.parseJSON(response)
                    setTimeout(function(){
                        jQuery('#postimagediv .inside .ts-image-extern').remove();
                        jQuery('#postimagediv .inside').prepend('<p class="hide-if-no-js ts-image-extern" data-attachment-id="' + response.attachment_id + '"><a href="#"><img src="' + response.url + '"/></a></p>');
                        jQuery('#postimagediv .inside a#set-post-thumbnail').hide();
                        if( jQuery('#remove-post-thumbnail').length == 0 ){
                            jQuery('#postimagediv .inside').append(jQuery('.ts-remove-featured').html());
                        }
                    }, 500);
                });
            });

            jQuery(document).on('click', '#ts-remove-featured-image', function(event){
                event.preventDefault();
                var postId = jQuery(this).attr('data-post-id');

                data = {
                    action  : 'tsRemoveSetFeaturedImageFromPost',
                    nonce   : '<?php echo $ajax_nonce; ?>',
                    make    : 'remove',
                    postId  : postId
                };

                jQuery.post(ajaxurl, data, function(response) {
                    if( response ) {
                        jQuery('#postimagediv .inside a#set-post-thumbnail').show();
                        jQuery('#ts-remove-featured-image').remove();
                        jQuery('.ts-image-extern').remove();
                    }
                });
            });

            var featurdedImageAll;

            jQuery(document).on("click", ".ts-image-extern", function(event) {
                event.preventDefault();

                var elementThis = jQuery(this);    
                var id_attachment = jQuery(this).attr('data-attachment-id');
                
                // Create the media frame.
                featurdedImageAll = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: '<?php _e( 'Edit images', 'slimvideo' ); ?>',
                    button: {
                        text: '<?php _e( 'Save changes', 'slimvideo' ); ?>',
                    },
                    multiple: false
                });

                featurdedImageAll.on('open', function(){
                    var selection = featurdedImageAll.state().get('selection');
                    attachment = wp.media.attachment(id_attachment);
                    attachment.fetch();
                    selection.add(attachment);
                });

                // When an image is selected, run a callback.
                featurdedImageAll.on('select', function(){
                    
                    var selection = featurdedImageAll.state().get('selection');
                    selection.map( function(attachment){
                        attachment = attachment.toJSON();
                        data = {
                            action       : 'tsRemoveSetFeaturedImageFromPost',
                            nonce        : '<?php echo $ajax_nonce; ?>',
                            make         : 'add',
                            attachmentId : attachment.id,
                            postId       : <?php echo $post->ID ?>
                        };

                        jQuery.post(ajaxurl, data, function(response) {
                            if( response == '1' ) {
                                jQuery('#postimagediv .inside .ts-image-extern').remove();
                                jQuery('#postimagediv .inside').prepend('<p class="hide-if-no-js ts-image-extern" data-attachment-id="' + attachment.id + '"><a href="#"><img src="' + attachment.url + '"/></a></p>');
                            }
                        });
                    });

                });

                // Finally, open the modal.
                featurdedImageAll.open();
            });

            jQuery('div[role="tabpanel"]').each(function(){
                if( jQuery(this).hasClass('active') ){
                    jQuery(this).find('.ts-tab-active').val('1');
                }
            });
        });
    </script>
<?php
}

function ts_videos_save_post($post_id)
{
	global $post;

    if ( isset($post->post_type) && $post->post_type !== 'video' ) return;
    
    if ( !isset( $_POST['ts_videos_nonce'] ) || !wp_verify_nonce($_POST['ts_videos_nonce'], plugin_basename( __FILE__ )) ) return;
        
    if( !current_user_can('edit_post', $post_id) ) return;
    
    $videos = array();
  
    if ( isset($_POST['video']) && is_array($_POST['video']) && !empty($_POST['video'])  ) {
        $t = $_POST['video'];
        if( is_array($t['tab-active']) && $t['tab-active']['extern_url'] == 1 ){
            $videos['extern_url'] = isset($t['extern_url']) ? esc_url($t['extern_url']) : '';
            $videos['your_url'] = '';
            $videos['embed'] = '';
        }elseif( is_array($t['tab-active']) && $t['tab-active']['your_url'] == 1 ){
            $videos['your_url'] = isset($t['your_url']) ? esc_url($t['your_url']) : '';
            $videos['extern_url'] = '';
            $videos['embed'] = '';
        }elseif( is_array($t['tab-active']) && $t['tab-active']['embed'] == 1 ){
            $videos['embed'] = isset($t['embed']) ? $t['embed'] : '';
            $videos['extern_url'] = '';
            $videos['your_url'] = '';
        }
    
    } else {
        $videos['extern_url'] = '';
        $videos['your_url'] = '';
        $videos['embed'] = '';

    }

    update_post_meta($post_id, 'video', $videos);
}


add_action( 'save_post', 'ts_slider_save_postdata' );
add_action( 'add_meta_boxes', 'ts_slider_add_custom_box' );
function ts_slider_add_custom_box()
{
	add_meta_box( 
        'ts_slider_options',
        'Slider Options',
        'ts_slider_options_custom_box',
        'ts_slider' 
    );

	add_meta_box( 
        'ts_slides',
        'Slides',
        'ts_slider_custom_box',
        'ts_slider' 
    );
}

function ts_slider_options_custom_box($post) {
	
    $slider_type = get_post_meta($post->ID, 'slider_type', TRUE);
	$slider_source = get_post_meta($post->ID, 'slider-source', TRUE);
    $slider_size = get_post_meta($post->ID, 'slider-size', TRUE);
    $sliderNrOfPosts = get_post_meta($post->ID, 'slider-nr-of-posts', TRUE);

    if( !$sliderNrOfPosts ){
        $sliderNrOfPosts = 5;
    }

    if( $slider_size ){
          $slider_width = $slider_size['width'];
          $slider_height = $slider_size['height'];
    }else{
        $slider_size = get_option('slimvideo_image_sizes');
        $slider_width = $slider_size['slider']['width'];
        $slider_height = $slider_size['slider']['height'];
    }

    if( $slider_source ){
        $slider_source = ($slider_source == 'latest-posts' || $slider_source == 'latest-galleries' || $slider_source == 'latest-videos' || $slider_source == 'custom-slides' || $slider_source == 'latest-featured-posts' || $slider_source == 'latest-featured-videos' || $slider_source == 'latest-featured-galleries') ? $slider_source : 'custom-slides';
    }else{
        $slider_source = 'custom-slides';
    }

	if ($slider_type) {
		$is_flexslider = ( $slider_type == 'flexslider' ) ? 'selected="selected"' : '';
        $is_slicebox = ( $slider_type == 'slicebox' ) ? 'selected="selected"' : '';
        $is_bxslider = ( $slider_type == 'bxslider' ) ? 'selected="selected"' : '';
        $is_paraslider = ( $slider_type == 'parallax' ) ? 'selected="selected"' : '';
		$is_streamslider = ( $slider_type == 'stream' ) ? 'selected="selected"' : '';
	} else {
		$is_flexslider = 'flexslider';
        $is_slicebox = '';
        $is_bxslider = '';
        $is_paraslider = '';
		$is_streamslider = '';
	}

	echo '
	<table>
        <tr>
            <td>' . __('Slider source','slimvideo') . '</td>
            <td>
                <select name="slider-source" id="ts-slider-source">
                    <option ' . selected($slider_source, 'latest-posts', false) . ' value="latest-posts">' . __('Latest posts','slimvideo') . '</option>
                    <option ' . selected($slider_source, 'latest-videos', false) . ' value="latest-videos">' . __('Latest videos','slimvideo') . '</option>
                    <option ' . selected($slider_source, 'latest-galleries', false) . ' value="latest-galleries">' . __('Latest galleries','slimvideo') . '</option>
                    <option ' . selected($slider_source, 'custom-slides', false) . ' value="custom-slides">' . __('Custom slides','slimvideo') . '</option>
                    <option ' . selected($slider_source, 'latest-featured-posts', false) . ' value="latest-featured-posts">' . __('Latest featured posts','slimvideo') . '</option>
                    <option ' . selected($slider_source, 'latest-featured-galleries', false) . ' value="latest-featured-galleries">' . __('Latest featured galleries','slimvideo') . '</option>
                    <option ' . selected($slider_source, 'latest-featured-videos', false) . ' value="latest-featured-videos">' . __('Latest featured videos','slimvideo') . '</option>
                </select>
            </td>
        </tr>
        <script>
            jQuery(document).ready(function(){
                jQuery("#ts-slider-source").change(function(){
                    if( jQuery(this).val() == "custom-slides" ){
                        jQuery("#ts_slides").css("display", "");
                        jQuery("#ts-slider-nr-of-posts").css("display", "none");
                    }else{
                        jQuery("#ts_slides").css("display", "none");
                        jQuery("#ts-slider-nr-of-posts").css("display", "");
                    }
                });

                if( jQuery("#ts-slider-source").val() == "custom-slides" ){
                    jQuery("#ts_slides").css("display", "");
                    jQuery("#ts-slider-nr-of-posts").css("display", "none");
                }else{
                    jQuery("#ts_slides").css("display", "none");
                    jQuery("#ts-slider-nr-of-posts").css("display", "");
                }
            });
        </script>
		<tr>
            <td>' . __('Slider type','slimvideo') . '</td>
            <td>
                <select name="slider_type">
                    <option value="flexslider" ' . $is_flexslider . '>' . __('Flex Slider','slimvideo') . '</option>
                    <option value="slicebox" ' . $is_slicebox . '>' . __('Slicebox','slimvideo') . '</option>
                    <option value="bxslider" ' . $is_bxslider . '>' . __('bxSlider','slimvideo') . '</option>
                    <option value="parallax" ' . $is_paraslider . '>' . __('Parallax slider','slimvideo') . '</option>
                    <option value="stream" ' . $is_streamslider . '>' . __('Stream slider','slimvideo') . '</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>' . __('Slider image width','slimvideo') . '</td>
            <td>
                <input type="text" name="slider-size[width]" value="' . absint($slider_width) . '" />px
            </td>
        </tr>
        <tr>
            <td>' . __('Slider image height','slimvideo') . '</td>
            <td>
                <input type="text" name="slider-size[height]" value="' . absint($slider_height) . '" />px
            </td>
        </tr>
        <tr id="ts-slider-nr-of-posts">
			<td>' . __('How many posts to extract','slimvideo') . '</td>
			<td>
				<input type="text" name="slider-nr-of-posts" value="' . absint($sliderNrOfPosts) . '" />
			</td>
		</tr>
	</table>';
}

function ts_slider_custom_box( $post )
{

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'ts_slider_nonce' ); 
	$slides = get_post_meta($post->ID, 'ts_slides', TRUE);

	echo '<input type="button" class="button" id="add-slide" value="' .__('Add New Slide','slimvideo'). '" /><br/><br/>';
	echo '<ul id="ts-slides">';

	$slides_editor = '';
	
	if ( ! empty( $slides ) ) {
		$index = 0;
		foreach ( $slides as $slide_id => $slide ) {
			$index++;
			$slide_title = ($slide["slide_title"]) ? $slide["slide_title"] : 'Slide ' . $index;
			$slides_editor .= '
			<li class="ts-slide">
			<div class="sortable-meta-element"><span class="tab-arrow icon-down"></span> <span class="slide-tab">'.$slide_title.'</span>
			</div>
			<table class="hidden">
				<tr>
					<td>' . __( 'Slide title','slimvideo' ) . '</td>
					<td>
						<input type="text" class="slide_title" name="ts_slider['.$slide_id.'][slide_title]" value="'.$slide["slide_title"].'" style="width: 100%" />
					</td>
				</tr>
				<tr>
					<td valign="top">' . __( 'Slide description','slimvideo' ) . '</td>
					<td>
						<textarea class="slide_description" name="ts_slider['.$slide_id.'][slide_description]" cols="60" rows="5">'.$slide["slide_description"].'</textarea>
					</td>
				</tr>
				<tr valign="top">
					<td>' . __( 'Slide URL','slimvideo' ) . '</td>
					<td>
						<input type="text" class="slide_url" name="ts_slider['.$slide_id.'][slide_url]" value="'.$slide["slide_url"].'" />
						<input type="hidden" class="slide_media_id" name="ts_slider['.$slide_id.'][slide_media_id]" value="'.$slide['slide_media_id'].'" />
						<input type="button" id="upload-'.$slide_id.'" class="button ts-upload-slide" value="' .__( 'Upload','slimvideo' ). '" /> <br />
						<div class="slide_preview"><img src="'.$slide["slide_url"].'" style="width: 400px" /></div>
					</td>
				</tr>
				<tr>
					<td>' . __( 'Redirect to URL','slimvideo' ) . '</td>
					<td>
						<input type="text" class="redirect_to_url" name="ts_slider['.$slide_id.'][redirect_to_url]" value="'.$slide['redirect_to_url'].'" style="width: 100%" />
					</td>
				</tr>
				<tr>
					<td>' . __( 'Select caption position','slimvideo' ) . '</td>
					<td>
						<select name="ts_slider['.$slide_id.'][slide_position]" class="slide_position">
							<option value="left" ' . selected($slide['slide_position'], 'left', false) . '>Left</option>
							<option value="center" ' . selected($slide['slide_position'], 'center', false) . '>Center</option>
							<option value="right" ' . selected($slide['slide_position'], 'right', false) . '>Right</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td><td><input type="button" class="button button-primary remove-slide" value="'.__('Remove','slimvideo').'" /></td>
				</tr>
			</table></li>';
		}
	}
	echo $slides_editor;
	echo '</ul>';
	echo '<script id="ts-add-slider" type="text/template">';
	echo '<li class="ts-slide">
	<div class="sortable-meta-element"><span class="tab-arrow icon-down"></span><span class="slide-tab">Slide {{slide-number}}</span>
	</div>
	<table>
		<tr>
			<td>' . __( 'Slide title','slimvideo' ) . '</td>
			<td>
				<input type="text" class="slide_title" name="ts_slider[slide-{{slide-id}}][slide_title]" value="" style="width: 100%" />
			</td>
		</tr>
		<tr>
			<td valign="top">' . __( 'Slide description','slimvideo' ) . '</td>
			<td>
				<textarea class="slide_description" name="ts_slider[slide-{{slide-id}}][slide_description]" cols="60" rows="5"></textarea>
			</td>
		</tr>
		<tr>
			<td>' . __( 'Slide URL','slimvideo' ) . '</td>
			<td>
				<input type="text" class="slide_url" name="ts_slider[slide-{{slide-id}}][slide_url]" value="" />
				<input type="hidden" class="slide_media_id" name="ts_slider[slide-{{slide-id}}][slide_media_id]" value="" />
				<input type="button" id="upload-{{slide-id}}" class="button ts-upload-slide" value="' .__( 'Upload','slimvideo' ). '" /> 
				<div class="slide_preview"></div>
			</td>
		</tr>
		<tr>
			<td>' . __( 'Redirect to URL','slimvideo' ) . '</td>
			<td>
				<input type="text" class="redirect_to_url" name="ts_slider[slide-{{slide-id}}][redirect_to_url]" value="" style="width: 100%" />
			</td>
		</tr>
		<tr>
            <td>' . __( 'Select caption position','hologram' ) . '</td>
            <td>
                <select name="ts_slider[slide-{{slide-id}}][slide_position]" class="slide_position">
                    <option value="left">' . __('Left', 'touchsize') . '</option>
                    <option value="center">' . __('Center', 'touchsize') . '</option>
                    <option value="right">' . __('Right', 'touchsize') . '</option>
                </select>
            </td>
        </tr>
		<tr>
			<td></td><td><input type="button" class="button button-primary remove-slide" value="'.__('Remove','slimvideo').'" /></td>
		</tr>
	</table></li>';
	echo '</script>';
?>
	<script>
	jQuery(document).ready(function($) {
		var slides_count = $("#ts-slides > li").length;
		// sortable portfolio items
		$("#ts-slides").sortable();

		$(document).on('change', '.slide_title', function(event) {
			event.preventDefault();
			var _this = $(this);
			_this.closest('.ts-slide').find('.slide-tab').text(_this.val());
		});

		var slides = $('#ts-slides'),
			slideTempalte = $('#ts-add-slider').html(),
			custom_uploader = {};
		  	
		if (typeof wp.media.frames.file_frame == 'undefined') {
		    wp.media.frames.file_frame = {};
		}


		$(document).on('click', '#add-slide', function(event) {
			event.preventDefault();

			slides_count++;
			var id = new Date().getTime();
			var slide_id = new RegExp('{{slide-id}}', 'g');
			var slide_number = new RegExp('{{slide-number}}', 'g');

			var template = slideTempalte.replace(slide_id, id).replace(slide_number, slides_count);
			slides.append(template);
		});


		$(document).on('click', '.remove-slide', function(event) {
			event.preventDefault();
			$(this).closest('li').remove();
			slides_count--;
		});

		
		$(document).on('click', '.ts-upload-slide', function(e) {
			e.preventDefault();
			
			var _this     = $(this),
				target_id = _this.attr('id'),
				media_id  = _this.closest('li').find('.slide_media_id').val();

			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader[target_id]) {
				custom_uploader[target_id].open();
				return;
			}

			//Extend the wp.media object
			custom_uploader[target_id] = wp.media.frames.file_frame[target_id] = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				library: {
					type: 'image'
				},
				multiple: false,
				selection: [media_id]
			});

			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader[target_id].on('select', function() {
				var attachment = custom_uploader[target_id].state().get('selection').first().toJSON();
				var slide = _this.closest('table');
				slide.find('.slide_url').val(attachment.url);
				slide.find('.slide_media_id').val(attachment.id);
				var img = $("<img>").attr('src', attachment.url).attr('style', 'width:400px');
				slide.find('.slide_preview').html(img);
			});

			//Open the uploader dialog
			custom_uploader[target_id].open();
		});
	});
	</script>
<?php
}

// saving slider
function ts_slider_save_postdata( $post_id )
{
	global $post;

    if ( isset($post->post_type) && @$post->post_type != 'ts_slider' ) {
        return;
    }
	
	if (!isset( $_POST['ts_slider_nonce'] ) ||
		!wp_verify_nonce( $_POST['ts_slider_nonce'], plugin_basename( __FILE__ ) ) 
	) return;

	if( !current_user_can( 'edit_post', $post_id ) ) return;
	
    if ( isset( $_POST['slider_type'] ) ) {
    	switch ($_POST['slider_type']) {
    		case 'flexslider':
    			$slider_type = 'flexslider';
    			break;

            case 'slicebox':
                $slider_type = 'slicebox';
                break;

    		case 'bxslider':
                $slider_type = 'bxslider';
                break;

            case 'parallax':
                $slider_type = 'parallax';
                break;

            case 'stream':
    			$slider_type = 'stream';
    			break;

    		default:
    			$slider_type = 'flexslider';
    			break;
    	}
    } else {
    	$slider_type = 'flexslider';
    }

	update_post_meta( $post_id, 'slider_type', $slider_type );

    $sliderNrOfPosts = (isset($_POST['slider-nr-of-posts'])) ? absint($_POST['slider-nr-of-posts']) : 5;
    update_post_meta($post_id, 'slider-nr-of-posts', $sliderNrOfPosts);

    if( isset($_POST['slider-source']) ){
        $slider_source = ($_POST['slider-source'] == 'latest-posts' || $_POST['slider-source'] == 'latest-videos' || $_POST['slider-source'] == 'custom-slides' || $_POST['slider-source'] == 'latest-galleries' || $_POST['slider-source'] == 'latest-featured-galleries' || $_POST['slider-source'] == 'latest-featured-videos' || $_POST['slider-source'] == 'latest-featured-posts') ? $_POST['slider-source'] : 'custom-slides';
    }else{
        $slider_source = 'custom-slides';
    }
    update_post_meta( $post_id, 'slider-source', $slider_source );

    if( isset($_POST['slider-size']) && is_array($_POST['slider-size']) && !empty($_POST['slider-size']) ){
        if( isset($_POST['slider-size']['height']) ) $slider_size['height'] = absint($_POST['slider-size']['height']);
        if( isset($_POST['slider-size']['width']) ) $slider_size['width'] = absint($_POST['slider-size']['width']);   
    }else{
        $slider_size = get_option('slimvideo_image_sizes');
        if( isset($slider_size['slider']['height']) ) $slider_size['height'] = absint($slider_size['slider']['height']);
        if( isset($slider_size['slider']['width']) ) $slider_size['width'] = absint($slider_size['slider']['width']);  
    }
    update_post_meta( $post_id, 'slider-size', $slider_size );

	// array containing filtred slides
    $slider = array();
    
    if ( isset( $_POST['ts_slider'] ) ) {
    	if ( is_array( $_POST['ts_slider'] ) && !empty( $_POST['ts_slider'] ) ) {
    		foreach ( $_POST['ts_slider'] as $slide_id => $slide ) {
				$s['slide_id']          = $slide_id;
				$s['slide_title']       = isset($slide['slide_title']) ? esc_attr($slide['slide_title']) : ''; 
				$s['slide_description'] = isset($slide['slide_description']) ?
											esc_textarea($slide['slide_description']) : ''; 
				$s['slide_url']         = isset($slide['slide_url']) ? esc_url($slide['slide_url']) : ''; 
				$s['slide_media_id']    = isset($slide['slide_media_id']) ? esc_attr($slide['slide_media_id']) : ''; 
				$s['redirect_to_url']   = isset($slide['redirect_to_url']) ? esc_url($slide['redirect_to_url']) : '';
				$s['slide_position']   = isset($slide['slide_position']) ? esc_attr($slide['slide_position']) : '';
    			$slider[] = $s; 
    		}
    	}
    }

    update_post_meta( $post_id, 'ts_slides', $slider );
}


add_action( 'add_meta_boxes', 'ts_event_add_custom_box' );
add_action( 'save_post', 'ts_event_save_post' );

function ts_event_add_custom_box()
{
    add_meta_box( 
        'event',
        __('Settings event','slimvideo'),
        'ts_event_options_custom_box',
        'event' 
    );
}

function ts_event_options_custom_box($post)
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_event_nonce' );     
    $event = get_post_meta($post->ID, 'event', TRUE);
    $day = get_post_meta($post->ID, 'day', TRUE);
  
    if( !$day ){
        $day = '';
    }else{
        if( !empty($day) ){
            $day = date('Y-m-d', $day);
        }
    }
   
    if ( !$event ) {
        $event = array();
        $event['start-time'] = '';
        $event['end-time'] = '';
        $event['event-days'] = '';
        $event['event-repeat'] = '';
        $event['event-enable-repeat'] = 'n';
        $event['forever'] = 'n';
        $event['event-end'] = '';
        $event['theme'] = '';
        $event['person'] = '';
        $event['map'] = '';
        $event['free-paid'] = '';
        $event['ticket-url'] = '';
        $event['price'] = '';
        $event['venue'] = '';
    }

    echo '<table>
            <tr valign="top">
                <td>' . __('Start day','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($day) .'" name="day" />
                </td>
            </tr>
            <tr>
                <td>' . __('End day','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($event['event-end']) .'" name="event[event-end]" />
                </td>
            </tr>
            <tr>
                <td>' . __('Start time','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($event['start-time']) .'" name="event[start-time]" />
                </td>
            </tr>
            <tr>
                <td>' . __('End time','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($event['end-time']) .'" name="event[end-time]" />
                </td>
            </tr>
            <tr>
                <td>' . __('Repeat event','slimvideo') . '</td>
                <td>
                    <select name="event[event-enable-repeat]">
                    	<option ' . selected($event['event-enable-repeat'], 'y', false) . ' value="y">' . __('Yes','slimvideo') . '</option>
                    	<option ' . selected($event['event-enable-repeat'], 'n', false) . ' value="n">' . __('No','slimvideo') . '</option>
                    </select>
                </td>
            </tr>
            <tr>
            	<td>' . __('Change event repeat','slimvideo') . '</td>
            	<td>
            		<select name="event[event-repeat]">
                    	<option ' . selected($event['event-repeat'], '1', false) . ' value="1">' . __('Weekly','slimvideo') . '</option>
                    	<option ' . selected($event['event-repeat'], '2', false) . ' value="2">' . __('Monthly','slimvideo') . '</option>
                    	<option ' . selected($event['event-repeat'], '3', false) . ' value="3">' . __('Yearly','slimvideo') . '</option>
                    </select>
            	</td>
            </tr>
            <tr>
                <td>' . __('Add theme here','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($event['theme']) .'" name="event[theme]" />
                </td>
            </tr>
            <tr>
                <td>' . __('Person','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($event['person']) .'" name="event[person]" />
                </td>
            </tr>
            <tr>
                <td>' . __('Map','slimvideo') . '</td>
                <td>
                    <textarea name="event[map]" cols="60" rows="5">' . $event['map'] . '</textarea>
                </td>
            </tr>
            <tr>
                <td>' . __('Free or paid','slimvideo') . '</td>
                <td>
                    <select class="ts-free-paid" name="event[free-paid]">
                        <option ' . selected($event['free-paid'], 'paid', false) . ' value="paid">' . __('Paid','slimvideo') . '</option>
                        <option ' . selected($event['free-paid'], 'free', false) . ' value="free">' . __('Free','slimvideo') . '</option>
                    </select>
                </td>
            </tr>
            <tr class="ts-event-price-url">
                <td>' . __('Price','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($event['price']) .'" name="event[price]" />
                </td>
            </tr>
            <tr class="ts-event-price-url">
                <td>' . __('Ticket buy URL','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($event['ticket-url']) .'" name="event[ticket-url]" />
                </td>
            </tr>
            <tr>
                <td>' . __('Venue','slimvideo') . '</td>
                <td>
                    <input size="60" type="text" value="'. esc_attr($event['venue']) .'" name="event[venue]" />
                </td>
            </tr>
        </table>
        <script>
            jQuery(document).ready(function(){
                jQuery(".ts-free-paid").change(function(){
                    if( jQuery(this).val() == "free" ){
                        jQuery(".ts-event-price-url").css("display", "none");
                    }else{
                        jQuery(".ts-event-price-url").css("display", "");
                    }
                });
                
                if( jQuery(".ts-free-paid").val() == "free" ){
                    jQuery(".ts-event-price-url").css("display", "none");
                }else{
                    jQuery(".ts-event-price-url").css("display", "");
                }
            });
        </script>
        ';

}

function ts_event_save_post($post_id)
{
    global $post;

    if ( isset($post->post_type) && @$post->post_type != 'event' ) {
        return;
    }
    
    if (!isset( $_POST['ts_event_nonce'] ) ||
        !wp_verify_nonce( $_POST['ts_event_nonce'], plugin_basename( __FILE__ ) ) 
    ) return;

    if( !current_user_can( 'edit_post', $post_id ) ) return;
    
    // array containing filtred slides
    $event = array();

    if( isset( $_POST['day'] ) ){
        $day = $_POST['day'];
    }else{
        $day = '';
    }
    
    if ( isset( $_POST['event'] ) && is_array( $_POST['event'] ) && !empty( $_POST['event'] )  ) {
        $t = $_POST['event'];
        $event['day'] = isset($day) ? esc_attr($day) : '';
        $event['start-time'] = isset($t['start-time']) ? esc_attr($t['start-time']) : '';
        $event['end-time'] = isset($t['end-time']) ? esc_attr($t['end-time']) : '';
        $event['event-enable-repeat'] = (isset($t['event-enable-repeat']) && ($t['event-enable-repeat'] == 'y' || $t['event-enable-repeat'] == 'n')) ? $t['event-enable-repeat'] : 'n';
        $event['event-end'] = isset($t['event-end']) ? $t['event-end'] : '';
        $event['event-repeat'] = (isset($t['event-repeat']) && ($t['event-repeat'] == '1' || $t['event-repeat'] == '2' || $t['event-repeat'] == '3')) ? $t['event-repeat'] : '';
        $event['theme'] = isset($t['theme']) ? esc_attr($t['theme']) : '';
        $event['person'] = isset($t['person']) ? esc_attr($t['person']) : '';
        $event['map'] = isset($t['map']) ? $t['map'] : '';
        $event['free-paid'] = (isset($t['free-paid']) && ($t['free-paid'] == 'free' || $t['free-paid'] == 'paid')) ? $t['free-paid'] : '';
        $event['ticket-url'] = isset($t['ticket-url']) ? esc_attr($t['ticket-url']) : '';
        $event['price'] = isset($t['price']) ? esc_attr($t['price']) : '';
        $event['venue'] = isset($t['venue']) ? esc_attr($t['venue']) : '';
        
    } else {
        $event['day'] = '';
        $event['start-time'] = '';
        $event['end-time'] = '';
        $event['event-days'] = '';
        $event['event-repeat'] = '';
        $event['event-enable-repeat'] = 'n';
        $event['forever'] = 'n';
        $event['event-end'] = 'n';
        $event['theme'] = '';
        $event['person'] = '';
        $event['map'] = '';
        $event['price'] = '';
        $event['ticket-url'] = '';
        $event['free-paid'] = '';
        $event['venue'] = '';

    }

    update_post_meta($post_id, 'event', $event);
    update_post_meta($post_id, 'day', strtotime($day));
}
// Create boxes for audio post format

add_action( 'add_meta_boxes', 'ts_audio_post_add_custom_box' );
function ts_audio_post_add_custom_box()
{
	add_meta_box( 
        'audio_embed',
        __('Audio embed','slimvideo'),
        'ts_audio_post_options_custom_box',
        'post' 
    );
}

function ts_audio_post_options_custom_box($post)
{
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'ts_audio_nonce' ); 	
	$audio_post = get_post_meta($post->ID, 'audio_embed' , TRUE);

	if (!$audio_post) {
		$audio_post = '';
	}

	echo '<table>
		<tr valign="top">
			<td>' . __('Audio embed code','slimvideo') . '</td>
			<td>
				<textarea name="audio_embed" cols="60" rows="5">'.esc_attr(@$audio_post).'</textarea>
			</td>
		</tr>
		</table>';

}
// saving audio post embed data
function ts_audio_post_postdata( $post_id )
{
	global $post;

    if ( isset($post->post_type) && @$post->post_type != 'post' ) {
        return;
    }
	
	if (!isset( $_POST['ts_audio_nonce'] ) ||
		!wp_verify_nonce( $_POST['ts_audio_nonce'], plugin_basename( __FILE__ ) ) 
	) return;


	// array containing filtred slides

    $audio_embed_code = $_POST['audio_embed'];
    update_post_meta( $post_id, 'audio_embed', $audio_embed_code );
}
add_action( 'save_post', 'ts_audio_post_postdata' );

/**
// Create boxes for video post format
*/
add_action( 'add_meta_boxes', 'ts_video_post_add_custom_box' );
function ts_video_post_add_custom_box()
{
    add_meta_box( 
        'video_embed',
        __('Video embed','slimvideo'),
        'ts_video_post_options_custom_box',
        'post' 
    );
}

function ts_video_post_options_custom_box($post)
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_video_nonce' );    
    $video_post = get_post_meta($post->ID, 'video_embed' , TRUE);

    if (!$video_post) {
        $video_post = '';
    }

    echo '<table>
        <tr valign="top">
            <td>' . __('Video embed code','slimvideo') . '</td>
            <td>
                <textarea name="video_embed" cols="60" rows="5">'.esc_attr(@$video_post).'</textarea>
            </td>
        </tr>
        </table>';

}
// saving video embed data
function ts_video_post_postdata( $post_id )
{
    global $post;

    if ( isset($post->post_type) && @$post->post_type != 'post' ) {
        return;
    }
    
    if (!isset( $_POST['ts_video_nonce'] ) ||
        !wp_verify_nonce( $_POST['ts_video_nonce'], plugin_basename( __FILE__ ) ) 
    ) return;


    // array containing filtred slides

    $video_embed_code = $_POST['video_embed'];
    update_post_meta( $post_id, 'video_embed', $video_embed_code );
}
add_action( 'save_post', 'ts_video_post_postdata' );

/**************************************************************************
 ************** Select layouts for posts and pages ************************
 *************************************************************************/

add_action( 'add_meta_boxes', 'ts_layout_custom_boxes' );

//include_once( ABSPATH . 'wp-admin/includes/ts-custom-posts.php' );
/* Adds a box to the main column on the Post and Page edit screens */
function ts_layout_custom_boxes() {

   add_meta_box(
       'ts_layout_id',
       __( 'Custom Layout','slimvideo' ),
       'ts_layout_selector_custom_box',
       'page'
   );
    
    // Add the header and footer meta box
    add_meta_box(
        'ts_header_and_footer',
        __( 'Header & Footer','slimvideo' ),
        'ts_header_and_footer_custom_box',
        'page',
        'normal',
        'high'
    );
    // Add the page options meta box
    add_meta_box(
        'ts_page_options',
        __( 'Page options','slimvideo' ),
        'ts_page_options_custom_box',
        'page',
        'normal',
        'high'
    );
    // Add the post options meta box
    add_meta_box(
        'ts_post_options',
        __( 'Post options','slimvideo' ),
        'ts_post_options_custom_box',
        'post',
        'normal',
        'high'
    );

    if( is_plugin_active('ts-custom-posts/ts-custom-posts.php') ){
        add_meta_box(
            'ts_post_options',
            __( 'Post options','slimvideo' ),
            'ts_post_options_custom_box',
            'video',
            'normal',
            'high'
        );
    }

    
    if( is_plugin_active('ts-custom-posts/ts-custom-posts.php') ){
        $sidebar_screens = array( 'page', 'post', 'portfolio', 'product', 'event', 'ts-gallery' ); 
    }else{
        $sidebar_screens = array( 'page', 'post' ); 
    }

    foreach ($sidebar_screens as $screen) {
        add_meta_box(
            'ts_sidebar',
            __( 'Layout','slimvideo' ),
            'ts_sidebar_custom_box',
            $screen,
            'side',
            'low'
        );
    }
}

/* Prints the box content */
function ts_layout_selector_custom_box( $post ) {
                    
    $template_id = Template::get_template_info('page', 'id');
    $template_name = Template::get_template_info('page', 'name');     

    echo slimvideo_template_modals( 'page', $template_id, $template_name );
    ts_layout_wrapper(Template::edit($post->ID));
}

function ts_page_options_custom_box( $post )
{
  fields::logicMetaRadio('page_settings', 'hide_title', fields::get_value($post->ID, 'page_settings', 'hide_title', true), 'Hide title for this post', __('If set to yes, this option will hide the title of the post on this specific post','slimvideo') );
  fields::logicMetaRadio('page_settings', 'hide_meta', fields::get_value($post->ID, 'page_settings', 'hide_meta', true), 'Hide meta for this post', __('If set to yes, this option will hide the meta of the post on this specific post','slimvideo') );
  fields::logicMetaRadio('page_settings', 'hide_social_sharing', fields::get_value($post->ID, 'page_settings', 'hide_social_sharing', true), 'Hide social sharing for this post', __('If set to yes, this option will hide the social sharing buttons of the post on this specific post','slimvideo') );
  fields::logicMetaRadio('page_settings', 'hide_featimg', fields::get_value($post->ID, 'page_settings', 'hide_featimg', true), 'Hide featured image for this post', __('If set to yes, this option will hide the featured image of the post on this specific post','slimvideo') );
  fields::logicMetaRadio('page_settings', 'hide_author_box', fields::get_value($post->ID, 'page_settings', 'hide_author_box', true), 'Hide author box for this post', __('If set to yes, this option will hide the author box of the post on this specific post','slimvideo') );

}

function ts_post_options_custom_box( $post )
{
    if( get_post_type($post->ID) !== 'video' ){
        fields::textareaText('post_settings', 'subtitle', fields::get_options_value($post->ID, 'post_settings', 'subtitle', true), 'Add subtitle', __('Add subtitle to post','slimvideo') );
    }

    fields::logicMetaRadio('post_settings', 'hide_title', fields::get_value($post->ID, 'post_settings', 'hide_title', true), 'Hide title for this post', __('If set to yes, this option will hide the title of the post on this specific post','slimvideo') );
    fields::logicMetaRadio('post_settings', 'hide_related', fields::get_value($post->ID, 'post_settings', 'hide_related', true), 'Hide related articles for this post', __('If set to yes, this option will hide the related articles of the post on this specific post','slimvideo') );
    fields::logicMetaRadio('post_settings', 'hide_meta', fields::get_value($post->ID, 'post_settings', 'hide_meta', true), 'Hide meta for this post', __('If set to yes, this option will hide the meta of the post on this specific post','slimvideo') );
    fields::logicMetaRadio('post_settings', 'hide_social_sharing', fields::get_value($post->ID, 'post_settings', 'hide_social_sharing', true), 'Hide social sharing for this post', __('If set to yes, this option will hide the social sharing buttons of the post on this specific post','slimvideo') );

    if( get_post_type($post->ID) !== 'video' ){
        fields::logicMetaRadio('post_settings', 'hide_featimg', fields::get_value($post->ID, 'post_settings', 'hide_featimg', true), 'Hide featured image for this post', __('If set to yes, this option will hide the featured image of the post on this specific post','slimvideo') );
    }

    fields::logicMetaRadio('post_settings', 'hide_author_box', fields::get_value($post->ID, 'post_settings', 'hide_author_box', true), 'Hide author box for this post', __('If set to yes, this option will hide the author box of the post on this specific post','slimvideo') );

    if( get_post_type($post->ID) == 'video' ){
        fields::logicMetaRadio('post_settings', 'not_safe_for_work', fields::get_value($post->ID, 'post_settings', 'not_safe_for_work', true), 'Not safe for work', __('','slimvideo') );
    }

    $arrayLayoutStylesVideoPost = array('single_style1' => get_template_directory_uri() . '/images/options/singlevideo_style1.png', 'single_style2' => get_template_directory_uri() . '/images/options/singlevideo_style2.png', 'single_style3' => get_template_directory_uri() . '/images/options/singlevideo_style3.png', 'single_style4' => get_template_directory_uri() . '/images/options/singlevideo_style4.png');

    if( get_post_type($post->ID) == 'video' ){
    	$options = get_option('slimvideo_single_post');
    	$singleLayoutStyle = (isset($options['single_layout_style']) && 
    	                        (
    	                            $options['single_layout_style'] == 'single_style1' || 
    	                            $options['single_layout_style'] == 'single_style2' || 
    	                            $options['single_layout_style'] == 'single_style3' || 
    	                            $options['single_layout_style'] == 'single_style4' 
    	                        )
    	                    ) ? $options['single_layout_style'] : 'single_style1';
        fields::radioImageMeta('post_settings', 'single_layout', $arrayLayoutStylesVideoPost, 2, $singleLayoutStyle, 'Single layout style', __('Select the single layout you want to use.','slimvideo') );
    }
}


function ts_header_and_footer_custom_box( $post )
{
    $header_footer = get_post_meta( $post->ID, 'ts_header_and_footer', true );
    $breadcrumbs = get_option('slimvideo_single_post', array('breadcrumbs' => 'y'));
    $breadcrumbs_clean = (isset($breadcrumbs['breadcrumbs']) && $breadcrumbs['breadcrumbs'] === 'y' ) ? 0 : 1;
    
    if( isset($header_footer['breadcrumbs']) ){
    	$disable_breadcrumbs = ( $header_footer['breadcrumbs'] === 1 ) ? 'checked="checked"' : '';
    }else{
        $disable_breadcrumbs = ($breadcrumbs_clean === 1) ? 'checked="checked"' : '';
    }

    if ( $header_footer ) {
        $disable_header = ( $header_footer['disable_header'] === 1 ) ? 'checked="checked"' : '';
        $disable_footer = ( $header_footer['disable_footer'] === 1 ) ? 'checked="checked"' : '';
        
    } else {
        $disable_header = '';
        $disable_footer = '';
    }

    echo '<p>
            <label class="switch" for="ts-disable-header">
              <input id="ts-disable-header" class="switch-input" name="ts_header_footer[disable_header]" type="checkbox" value="1" '.$disable_header.'>
              <span class="switch-label" data-on="'. __("Yes", "touchsize") . '" data-off="' . __("No", "touchsize") . '"></span>
              <span class="switch-handle"></span>
            </label>
            '.__('Disable header','slimvideo').'
            <div class="ts-option-description">
				'.__('This options will disable the default global header. You can use it if you want to create a custom header for this page using the layout builder. Global (default) header options are in a tab in the theme options panel. (in the menu on the left, last icon).','slimvideo').'
            </div>
        </p>
        <p>
            <label class="switch" for="ts-disable-footer">
              <input id="ts-disable-footer" class="switch-input" type="checkbox" name="ts_header_footer[disable_footer]" value="1" '.$disable_footer.'>
              <span class="switch-label" data-on="'. __("Yes", "touchsize") . '" data-off="' . __("No", "touchsize") . '"></span>
              <span class="switch-handle"></span>
            </label>
            '.__('Disable footer','slimvideo').'
            <div class="ts-option-description">
				'.__('This options will disable the default global footer. You can use it if you want to create a custom footer for this page using the layout builder. Global (default) footer options are in a tab in the theme options panel. (in the menu on the left, last icon).','slimvideo').'
            </div>
        </p>
        <p>
            <label class="switch" for="ts-disable-breadcrumbs">
              <input id="ts-disable-breadcrumbs" class="switch-input" type="checkbox" name="ts_header_footer[breadcrumbs]" value="1" '.$disable_breadcrumbs.'>
              <span class="switch-label" data-on="'. __("Yes", "touchsize") . '" data-off="' . __("No", "touchsize") . '"></span>
              <span class="switch-handle"></span>
            </label>
            '.__('Disable breadcrumbs','slimvideo').'
            <div class="ts-option-description">
				'.__('Hide the breadcrumbs in this page','slimvideo').'
            </div>
        </p>';
       

}


add_action( 'save_post', 'ts_layout_save_postdata' );
/* When the post is saved, saves our custom data */
function ts_layout_save_postdata( $post_id ) {

    if( is_plugin_active('ts-custom-posts/ts-custom-posts.php') ){
        $post_types = array( 'page', 'post', 'portfolio', 'video', 'product', 'event', 'ts-gallery' );
    }else{
        $post_types = array( 'page', 'post' );
    }
   
	// First we need to check if the current user is authorised to do this action. 
	if ( in_array(get_post_type($post_id), $post_types) ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Secondly we need to check if the user intended to change this value.
		 
		if ( !isset($_POST['ts_layout_nonce_filed']) || !wp_verify_nonce( @$_POST['ts_layout_nonce_filed'], 'ts_layout_nonce' ) ) return $post_id;
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

		// Thirdly we can save the value to the database
		$post_ID = @$_POST['post_ID'];
		$sidebar = @$_POST['ts_sidebar'];
       
		$new_sidebar_options = array(
			'position' => '',
			'size' => ''
		);
		
		if ( is_array( $sidebar ) &&
			 isset( $sidebar['position'] ) &&
			 isset( $sidebar['size'] ) &&
             isset( $sidebar['id'] )
			) {

			$valid_positions = array( 'none', 'left', 'right' );
			$valid_sizes = array( '1-3', '1-4' );

			if ( in_array( $sidebar['position'], $valid_positions ) ) {
				$new_sidebar_options['position'] = $sidebar['position'];
			} else {
				$new_sidebar_options['position'] = 'none';
			}

			if ( in_array( $sidebar['size'], $valid_sizes ) ) {
				$new_sidebar_options['size'] = $sidebar['size'];
			} else {
				$new_sidebar_options['size'] = '1-4';
			}
            
            $sidebars = ts_get_sidebars();
            
            if ( array_key_exists( $sidebar['id'], $sidebars ) || $sidebar['id'] == 'main' ) {
                $new_sidebar_options['id'] = $sidebar['id'];
            } else {
                $new_sidebar_options['id'] = 0;
            }
  
			update_post_meta( $post_ID, 'ts_sidebar', $new_sidebar_options );
		}

		// Get and save header meta box options
        $header_footer = @$_POST['ts_header_footer'];

        $header_footer_options = array(
            'disable_header' => 0,
            'disable_footer' => 0,
            'breadcrumbs' => 0
        );

        if ( isset($header_footer['disable_header']) ) {
            $header_footer_options['disable_header'] = 1;
        }

        if ( isset($header_footer['disable_footer']) ) {
            $header_footer_options['disable_footer'] = 1;
        }

        if ( isset($header_footer['breadcrumbs']) ) {
            $header_footer_options['breadcrumbs'] = 1;
        }

        update_post_meta( $post_ID, 'ts_header_and_footer', $header_footer_options );


		// Get and save page options meta box options
        $page_settings = @$_POST['page_settings'];

        update_post_meta( $post_ID, 'page_settings', $page_settings );

        // Get and save page options meta box options
        $post_settings = @$_POST['post_settings'];
        
        update_post_meta( $post_ID, 'post_settings', $post_settings );
	}
}

function get_layout_type( $postID = 0 )
{
	$layout_type = get_post_meta( $postID, 'ts_layout_id', true );
}

function ts_sidebar_custom_box( $post ) {

	$sidebar = get_post_meta( $post->ID, 'ts_sidebar', true );
 
	// IF there are not settings for this specific post, get those from layout settings.
	if ( !isset( $sidebar ) || $sidebar == '' ) {
		if ( get_post_type($post->ID) == 'page' ) {
			$sidebar = fields::get_options_value('slimvideo_layout', 'page_layout');
		} elseif( get_post_type($post->ID) != 'page' && get_post_type($post->ID) == 'product' ){
			$sidebar = fields::get_options_value('slimvideo_layout', 'product_layout');
		} else{
			$sidebar = fields::get_options_value('slimvideo_layout', 'single_layout');
		}
		$sidebar = $sidebar['sidebar'];
	}

	$positions = array(
		'none'  => __( 'None','slimvideo' ),
		'left'  => __( 'Left','slimvideo' ),
		'right' => __( 'Right','slimvideo' )
	);

	$positions_options = '';

	if ( array_key_exists(@$sidebar['position'], $positions) ) {
		foreach ($positions as $option_id => $option) {
			if ( $option_id === $sidebar['position'] ) {
				$positions_options .= '<option value="'.$option_id .'" selected="selected">'.$option.'</option>';
			} else {
				$positions_options .= '<option value="'.$option_id .'">'.$option.'</option>';
			}
		}
	} else {
		foreach ($positions as $option_id => $option) {
			$positions_options .= '<option value="'.$option_id .'">'.$option.'</option>';
		}
	}

	$sizes = array(
		'1-3'  => '1/3',
		'1-4'  => '1/4'
	);

	$size_options = '';

	if ( array_key_exists(@$sidebar['size'], $sizes) ) {
		foreach ($sizes as $size_id => $size) {
			if ( $size_id === $sidebar['size'] ) {
				$size_options .= '<option value="'.$size_id .'" selected="selected">'.$size.'</option>';
			} else {
				$size_options .= '<option value="'.$size_id .'">'.$size.'</option>';
			}
		}
	} else {
		foreach ($sizes as $size_id => $size) {
			$size_options .= '<option value="'.$size_id .'">'.$size.'</option>';
		}
	}
    
    wp_nonce_field( 'ts_layout_nonce','ts_layout_nonce_filed' );

    if ( isset( $sidebar['id'] ) ) {
        $sidebar_id = $sidebar['id'];
    } else {
        $sidebar_id = 0;
    }
	
    echo '<div id="ts_sidebar_position"><p><strong>'.__( 'Sidebar position','slimvideo' ).'</strong></p>
		    <ul id="page-sidebar-position-selector" data-selector="#page-sidebar-position" class="imageRadioMetaUl perRow-3 ts-custom-selector">
		       <li><img src="'.get_template_directory_uri() . '/images/options/none.png'.'" data-option="none" class="image-radio-input"></li>
		       <li><img src="'.get_template_directory_uri() . '/images/options/left_sidebar.png'.'" data-option="left" class="image-radio-input"></li>
		       <li><img src="'.get_template_directory_uri() . '/images/options/right_sidebar.png'.'" data-option="right" class="image-radio-input"></li>
		    </ul>
			<select name="ts_sidebar[position]" id="page-sidebar-position" class="hidden">
			' . $positions_options . '
			</select></div>
			<div id="ts_sidebar_size">
			<p><strong>'.__( 'Sidebar size','slimvideo' ).'</strong></p>
			<select id="ts_sidebar_size" name="ts_sidebar[size]">
			' . $size_options . '
			</select>
			</div><div id="ts_sidebar_sidebars">
            <p><strong>'.__('Sidebar name','slimvideo').'</strong></p>
            '.ts_sidebars_drop_down($sidebar_id, '', 'ts_sidebar[id]') . '</div>';

}//end function ts_sidebar_custom_box


// Custom boxes defaults
$global_hide_author = get_option('slimvideo_single_post', array('display_author_box' => 'y'));
$global_hide_author_box = (isset($global_hide_author['display_author_box']) && $global_hide_author['display_author_box'] === 'y') ? 'yes' : 'no';

$post_custom_box_defaults = array(
		'hide_title' => 'no',
		'hide_meta' => 'no',
		'hide_related' => 'no',
		'hide_social_sharing' => 'no',
		'hide_featimg' => 'no',
		'hide_author_box' => $global_hide_author_box,
		'background_img' => '',
		'background_position' => 'left',
        'single_layout' => 'single_style1',
		'subtitle' => '',
        'not_safe_for_work' => 'no'
	);
$page_custom_box_defaults = array(
		'hide_title' => 'no',
		'hide_meta' => 'yes',
		'hide_social_sharing' => 'no',
		'hide_featimg' => 'no',
		'hide_author_box' => $global_hide_author_box,
		'background_img' => '',
		'background_position' => 'left'
	);

if( false == get_option( 'post_settings_defaults' ) && false == get_option( 'page_settings_defaults' ) ) {
    //delete_option('post_settings_defaults');
	add_option( 'post_settings_defaults', $post_custom_box_defaults);
	add_option( 'page_settings_defaults', $page_custom_box_defaults);

} // end custom boxes default
// Function for setting defaults for existing posts
function setMetaForExistingPosts($post){
	$global_hide_author = get_option('slimvideo_single_post', array('display_author_box' => 'y'));
	$global_hide_author_box = (isset($global_hide_author['display_author_box']) && $global_hide_author['display_author_box'] === 'y') ? 'yes' : 'no';

	$post_custom_box_defaults = array(
			'hide_title' => 'no',
			'hide_meta' => 'no',
			'hide_related' => 'no',
			'hide_social_sharing' => 'no',
			'hide_featimg' => 'no',
			'hide_author_box' => $global_hide_author_box,
			'background_img' => '',
			'background_position' => 'left',
            'title_position' => 'below',
			'subtitle' => '',
            'single_layout' => 'single_style1',
            'not_safe_for_work' => 'no'
		);
	$page_custom_box_defaults = array(
			'hide_title' => 'no',
			'hide_meta' => 'yes',
			'hide_social_sharing' => 'no',
			'hide_featimg' => 'yes',
			'hide_author_box' => $global_hide_author_box,
			'background_img' => '',
			'background_position' => 'left'
		);

	if( is_object($post) ) {
		$the_ID = get_the_ID();
		$post_type = get_post_type( get_the_ID() );
		$meta_settings = get_post_meta( $the_ID, $post_type . '_settings' );

		if ( $post_type == 'page' ) {
			$meta_to_add = $page_custom_box_defaults;
		}
		else {
			$meta_to_add = $post_custom_box_defaults;
		}
		if ( empty($meta_settings) ) {
			update_post_meta( get_the_ID() , $post_type . '_settings', $meta_to_add);
		}
	}
	
}
add_action('pre_post_update', 'setMetaForExistingPosts');

//Add the box import/export to page

function ts_custom_box_import_export() {
	
	add_meta_box( 'ts-import-export', 'Import/Export options', 'ts_html_custom_box_import_export', 'page' );

}
add_action('add_meta_boxes', 'ts_custom_box_import_export'); 

/***********/

function ts_html_custom_box_import_export($post) {
	
	$settings = get_post_meta( $post->ID, 'ts_template', true );
	$settings = json_encode($settings);
	$settings = ts_base_64($settings, 'encode');

	echo '<table>
			<tr>
				<td><h4>' . __('Export options','slimvideo') . '</h4>
					<div class="ts-option-description">
						' . __('This is the export data. Copy this into another page import field and you should get the same builder elements and arrangement.','slimvideo') . '
					</div>

					<textarea name="export_options" cols="60" rows="5">' . $settings . '</textarea>
				</td>
			</tr>
			<tr>
				<td><h4>' . __('Import options','slimvideo') . '</h4>
					<div class="ts-option-description">
						' . __('This is the import data field. <b style="color: #Ff0000;">BE CAUTIONS, changing anythig here will result in breaking all your page elements and arrangement. Please save your previous data before proceding.</b>','slimvideo') . '
					</div>
					<textarea name="import_options" cols="60" rows="5"></textarea>
				</td>
			</tr>
		</table>';
				
}

function ts_import_export_save_postdata( $post_id ) {
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	if ( 'page' == get_post_type($post_id) && ! current_user_can( 'edit_page', $post_id ) ) {
		  return $post_id;
	} elseif( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	if( isset($_POST['import_options']) && $_POST['import_options'] != '' ){
		
		$import_export = ts_base_64($_POST['import_options'], 'decode');
		$import_export = json_decode($import_export, true);

		update_post_meta( $post_id, 'ts_template', $import_export );
	}

}
add_action( 'save_post', 'ts_import_export_save_postdata' );

// Custom mega menu saving
if(!function_exists('ts_ajax_switch_menu_walker'))
{
	function ts_ajax_switch_menu_walker()
	{	
		if ( ! current_user_can('edit_theme_options') )
		die('-1');
		
		check_ajax_referer('add-menu_item', 'menu-settings-column-nonce');
	
		require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
	
		$item_ids = wp_save_nav_menu_items(0, $_POST['menu-item']);
		if ( is_wp_error($item_ids) )
			die('-1');
	
		foreach ( (array)$item_ids as $menu_item_id ) {

			$menu_obj = get_post($menu_item_id);

			if ( !empty($menu_obj->ID) ) {
				$menu_obj = wp_setup_nav_menu_item($menu_obj);
				$menu_obj->label = $menu_obj->title; // don't show "(pending)" in ajax-added items
				$menu_items[] = $menu_obj;
			}
		}
	
		if ( !empty($menu_items) ) {
			$args = array(
				'after' => '',
				'before' => '',
				'link_after' => '',
				'link_before' => '',
				'walker' => new ts_backend_walker
			);
			echo walk_nav_menu_tree($menu_items, 0, (object)$args);
		}
		
		die('end');
	}
	
	//hook into wordpress admin.php
	add_action('wp_ajax_ts_ajax_switch_menu_walker', 'ts_ajax_switch_menu_walker');
}

// Adding the post rating box here
add_action( 'add_meta_boxes', 'ts_post_rating_add_custom_box' );
add_action( 'save_post', 'ts_post_rating_save_postdata' );

function ts_post_rating_add_custom_box()
{
    add_meta_box( 
        'ts_post_rating',
        'Post rating',
        'ts_post_rating_custom_box',
        'post'
    );
}

function ts_post_rating_custom_box( $post )
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_post_rating_nonce' ); 
    $rating_items = get_post_meta($post->ID, 'ts_post_rating', TRUE);

    echo '<br/><input type="button" class="button button-primary" id="add-item" value="' .__('Add New rating Item','slimvideo'). '" /><br/><br/>';
    echo '<ul id="rating-items">';
    
    $rating_editor = '';

    if (!empty($rating_items)) {
        $index = 0;
        foreach ($rating_items as $rating_item_id => $rating_item) {
            $index++;
            
            $rating_editor .= '
            <li class="rating-item">
            <div class="sortable-meta-element"><span class="tab-arrow icon-down"></span><span class="rating-item-tab ts-multiple-item-tab">'.($rating_item['rating_title'] ? $rating_item['rating_title'] : 'Rating ' . $index).'</span></div>
                <table class="hidden">
                    <tr>
                        <td>
                            Rating name<br>
                            <input type="text" class="rating_title" name="rating['.$rating_item_id.'][rating_title]" value="'.$rating_item['rating_title'].'" style="width: 100%" />
                        </td>
                        <td>
                            Rating score<br>
                            <select name="rating['.$rating_item_id.'][rating_score] " id="rating_score">
                                <option value="1" ' . selected( $rating_item['rating_score'] , 1 , false) . ' >1</option>
                                <option value="2" ' . selected( $rating_item['rating_score'] , 2  , false) . '>2</option>
                                <option value="3" ' . selected( $rating_item['rating_score'] , 3  , false) . '>3</option>
                                <option value="4" ' . selected( $rating_item['rating_score'] , 4  , false) . '>4</option>
                                <option value="5" ' . selected( $rating_item['rating_score'] , 5  , false) . '>5</option>
                                <option value="6" ' . selected( $rating_item['rating_score'] , 6  , false) . '>6</option>
                                <option value="7" ' . selected( $rating_item['rating_score'] , 7  , false) . '>7</option>
                                <option value="8" ' . selected( $rating_item['rating_score'] , 8  , false) . '>8</option>
                                <option value="9" ' . selected( $rating_item['rating_score'] , 9  , false) . '>9</option>
                                <option value="10" ' . selected( $rating_item['rating_score'] , 10 , false) . '>10</option>
                            </select>
                        </td>
                        <td>&nbsp;<br><input type="button" class="button button-primary remove-item" value="'.__('Remove','slimvideo').'" /></td>
                    </tr>
                </table>
            </li>';
        }
    } else{
        echo __('Sorry, no rating items were found. Please add some.','slimvideo');
    }

    echo $rating_editor;
    
    echo '</ul>';
    echo '<br/><input type="button" class="button button-primary" id="add-item" value="' .__('Add New rating Item','slimvideo'). '" /><br/><br/>';
    echo '<script id="rating-items-template" type="text/template">';
    echo '<li class="rating-item ts-multiple-add-list-element">
    <div class="sortable-meta-element"><span class="tab-arrow icon-up"></span><span class="rating-item-tab ts-multiple-item-tab">' . __('Rating','slimvideo') . ' {{slide-number}}</span></div>
        <table>
            <tr>
                <td>
                    ' . __('Rating name','slimvideo') . '<br>
                    <input type="text" class="rating_title" name="rating[{{item-id}}][rating_title]" value="" style="width: 100%" />
                </td>
                <td>
                    ' . __('Rating score','slimvideo') . '<br>
                    <select name="rating[{{item-id}}][rating_score]" id="rating_score">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </td>
                <td>&nbsp;<br><input type="button" class="button button-primary remove-item" value="'.__('Remove','slimvideo').'" /></td>
            </tr>
        </table>       
    </li>';
    echo '</script>';
?>
    <script>
    jQuery(document).ready(function($) {
        var rating_items = $("#rating-items > li").length;

        // sortable rating items
        $("#rating-items").sortable();
        //$("#rating-items").disableSelection();

        $(document).on('change', '.slide_title', function(event) {
            event.preventDefault();
            var _this = $(this);
            _this.closest('.rating-item').find('.rating-item-tab').text(_this.val());
        });

        // Media uploader
        var items = $('#rating-items'),
            slideTempalte = $('#rating-items-template').html();
            
        $(document).on('click', '#add-item', function(event) {
            event.preventDefault();
            rating_items++;
            var sufix = new Date().getTime();
            var item_id = new RegExp('{{item-id}}', 'g');
            var item_number = new RegExp('{{slide-number}}', 'g');

            var template = slideTempalte.replace(item_id, sufix).replace(item_number, rating_items);
            items.append(template);
        });

        $(document).on('click', '.remove-item', function(event) {
            event.preventDefault();
            $(this).closest('li').remove();
            rating_items--;
        });

    });
    </script>
<?php
}

// saving slider
function ts_post_rating_save_postdata( $post_id )
{
    global $post;

    if ( is_object($post) && @$post->post_type != 'post' ) {
        return;
    }

    if ( ! isset( $_POST['ts_post_rating_nonce'] ) ||
         ! wp_verify_nonce( $_POST['ts_post_rating_nonce'], plugin_basename( __FILE__ ) ) 
    ) return;

    if( !current_user_can( 'edit_post', $post_id ) ) return;

    // array containing filtred items
    $rating_items = array();

    if ( isset( $_POST['rating'] ) ) {
        if ( is_array( $_POST['rating'] ) && !empty( $_POST['rating'] ) ) {
            foreach ( $_POST['rating'] as $item_id => $rating_item ) {

                $p = array();
                $p['item_id']   = $item_id;


                $p['rating_title'] = isset($rating_item['rating_title']) ?
                                esc_textarea($rating_item['rating_title']) : ''; 

                $p['rating_score'] = isset($rating_item['rating_score']) ?
                            esc_textarea($rating_item['rating_score']) : ''; 

                $rating_items[] = $p; 
            }
        }
    }

    update_post_meta( $post_id, 'ts_post_rating', $rating_items );
}
?>
