<?php
/*
add_meta_box( string $id, string $title, callable $callback, string|array|WP_Screen $screen = null, string $context = 'advanced', string $priority = 'default', array $callback_args = null )

*/
add_action( 'add_meta_boxes', 'ts_videos_add_custom_box' );
//add_action( 'save_post', 'ts_videos_save_post' );

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
    //$default_videoplayer = fields::get_options_value('slimvideo_single_post', 'default_videoplayer');
    $default_videoplayer = 'n';
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
                        jQuery('#_thumbnail_id').val( response.attachment_id );
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


?>
