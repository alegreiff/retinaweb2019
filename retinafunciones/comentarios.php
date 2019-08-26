<?php

// Mostrar los comentarios de forma colapsable
function antescomentarios(){
    add_filter( 'genesis_title_comments', '__return_false' );
    if(have_comments()){
        if(get_comments_number()==='1'){
            $mensaje = 'Ver un comentario en "'.get_the_title().'"';
        }else{
            $mensaje = 'Ver '.get_comments_number().' comentarios en "'.get_the_title().'"';
        }
        echo '
        <div class="coment_retina">
            <div class="toggle">
                <input type="checkbox" value="selected" id="colapsar_retina" class="toggle-input">
        <label for="colapsar_retina" class="toggle-label titulo_comentarios">'.$mensaje.'</label>
        <div role="toggle" class="toggle-content">';
    }
    
}
add_action('genesis_before_comments', 'antescomentarios');

function postcomentarios(){
    if(have_comments()){
        echo '</div></div></div>';
    }
    
}

add_action('genesis_after_comments', 'postcomentarios');
function eachcomment(){
    echo ' =============== COMM BEFORE';
}
add_action( 'genesis_before_comment', 'eachcomment' );

function eachcomment2(){
    echo ' $$$$$$$$$$$$$$$ COMM AFTER';
}
add_action( 'genesis_after_comment', 'eachcomment2' );

function lescomentarios(){
    if(have_comments()){
        echo 'LESCOOOEMNTARRIESS';
    }
}
add_action('genesis_comments', 'lescomentarios');


function antesformulario(){
    echo '<div class="coment_retina">';
}
add_action('genesis_before_comment_form','antesformulario');
function despuesformulario(){
    echo '</div>';
}
add_action('genesis_after_comment_form','despuesformulario');

add_filter('genesis_no_comments_text', 'texto_no_comentarios');
function texto_no_comentarios(){
$mensaje = '<div class="coment_retina">No hay comentarios para esta entrada.</div>';
return $mensaje;
}
// FIN Mostrar los comentarios de forma colapsable