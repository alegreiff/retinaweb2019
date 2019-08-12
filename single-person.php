
<?php

$videos = get_field("videos");		
									foreach($videos as $key => $value):

										$image_p= get_post_meta($value->ID, 'poster',true);
					                
						               	$imgDestacada = wp_get_attachment_url($image_p);						               
						                
										$name = $value->post_title;

										$link = $value->guid;

								?>

								<div class="col-sm-6 col-md-4 col-xs-6">
									<div class="thumbnail">
										<a href="<?php print $link ?>"><img src="<?php print $imgDestacada ?>" class="img-responsive" alt="<?php print $name ?>"></a>
										<div class="caption">
											<h3 class="text-center">
												<a href="<?php print $link ?>"><?php print $name ?></a>
											</h3>
										</div>
									</div>
								</div>

								<?php 

                                    endforeach;
                                    genesis();                                    

								?>


