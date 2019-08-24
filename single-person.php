<?php
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'loop_persona_cine');

function loop_persona_cine()
{
    if (have_posts())
    {
        while (have_posts())
        {
            the_post();
            $roles_persona = get_the_terms(get_the_ID() , 'persons_categories');
            $losroles = [];
            foreach ($roles_persona as $rol)
            {
                $losroles[] = nombre_taxonomia_persona($rol->slug, 'taxslug', 'campo');
            }
            $losroles = array_filter($losroles);
            $videos = get_field("videos");
            $persona = (basename(get_permalink())); 

            if (!get_the_post_thumbnail())
            {
                $imagen = '<img src=' . get_stylesheet_directory_uri() . '/images/no-imagendestacada.jpg">';
            }
            else
            {
                $imagen = get_the_post_thumbnail();
            }
            $nacionalidad = get_field('citizenship_person');
?>
	<div class="personacine">
		<div class="nombrepaispersonacine">
			<h2><?php the_title(); ?></h2>
			<span><?php echo $nacionalidad; ?></span> 
		</div>
		<div class="fotopersonacine">
			<?php echo $imagen; ?>
		</div>
		<div class="infopersona">
			<div class="infopersonacine">
				<?php the_content(); ?>
			</div>
			<div class="posterespersonacine">
				<?php
            if ($videos)
            {

                foreach ($videos as $video)
                {
                    if ($video->post_status === 'publish')
                    {

                        $cam = get_fields($video->ID);
                        $enlace_video = get_post_permalink($video->ID);

                        $etiquetas_campos = [];
                        foreach ($cam as $nombre => $valor)
                        {
                            $etiquetas_campos[] = $nombre;
                        }
                        $rolesactivos = [];
                        foreach ($losroles as $rol)
                        {
                            if (in_array($rol, $etiquetas_campos))
                            {
                                $temporal = (get_field($rol, $video->ID));
                                if ($temporal)
                                {
                                    foreach ($temporal as $tempo)
                                    {
                                        if ($tempo->post_name === $persona)
                                        {
                                            $rolesactivos[] = nombre_taxonomia_persona($rol, 'campo', 'label');
                                        }
                                    }
                                }
                            }
                        }
                        $poster = trae_poster(get_field('poster', $video->ID));
                        $pais_pelicula = muestra_codigopais(get_field('country_group', $video->ID));
                        $genero_pelicula = wp_get_post_terms($video->ID, 'videos_genres') [0]->name;
                        $duracion = get_field('duration', $video->ID);
                        $year = get_field('year', $video->ID);
                        echo '
								<div class="retina_poster">
                					<a href="' . $enlace_video . '">
                    				<div class="picture" >
                        				<img src="' . $poster . '" alt="">
                        				<span class="duracion"> ' . ($duracion) . '</span>
                    				</div>
                    				<div class="navigation">
									<span class="pais">' . $pais_pelicula . ' - ' . $year . '</span>
                        				<h4>' . $video->post_title . '</h4>
                        				<span class="formato">' . muestra_genero($genero_pelicula) . '</span>
                    				</div>
									';
                        echo '<div class="losroles">';
                        echo implode(" / ", $rolesactivos);
                        echo '</div>';

                        echo '</a></div>';
                    }
                }
            }
            else
            {
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

