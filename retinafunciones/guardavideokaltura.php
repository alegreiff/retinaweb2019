<?php

add_action( 'admin_init', 'codigo_video_kaltura' );

function codigo_video_kaltura() {
    add_meta_box( 'kalturaidretinalatina', 'Código video', 'muestra_kalturaid_metabox','video', 'side', 'high' );
}

function muestra_kalturaid_metabox( $post ) {
    $videos = (get_post_meta($post->ID, 'video', TRUE));
    $elvideo = $videos['embed'];


    ?>
    <h4>ID Kaltura</h4>

    <table width="100%">
        <tr>
            <td>Código: </td>
            <td><input type="text" style="width:80%;" name="meta[video][embed]" value="<?php echo $elvideo;?>" />
            </td>
        </tr>
        
    </table>
<?php 
}
add_action( 'save_post', 'add_kaltura_id', 10, 2 );
function add_kaltura_id( $post_id, $post ) {
    if ( $post->post_type == 'video' ) {
        if ( isset( $_POST['meta'] ) ) {
            foreach( $_POST['meta'] as $key => $value ){
                update_post_meta( $post_id, $key, $value );
            }
        }
    }
}