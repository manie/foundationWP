<?php

	// Include required module variables
		include(locate_template('template-parts/custom/VARS-modules.php'));

	// Content Module
		$module_label = "Extra Content & Media";
		$module_name = get_row_layout();

	// Add to default post class array
		// $post_class_array[] = 'posts-panel';

	// Extra class for panel content
		$content_class = 'content';

	// Override default module label with custom text
		if ( isset($module_title) && ( !empty($module_title) ) ) { $module_label = $module_title; }

	// Custom Content variables
		if ( get_sub_field('dcf_extra_content_editor') ) { $extra_content = get_sub_field('dcf_extra_content_editor'); }
		if ( get_sub_field('dcf_extra_media_type') ) { $extra_media_type = get_sub_field('dcf_extra_media_type'); }
		if ( get_sub_field('dcf_extra_media_image') ) { $extra_media_image = get_sub_field('dcf_extra_media_image'); }
		if ( get_sub_field('dcf_extra_media_video') ) { $extra_media_video = get_sub_field('dcf_extra_media_video'); }
		if ( get_sub_field('dcf_extra_media_gallery') ) { $extra_media_gallery = get_sub_field('dcf_extra_media_gallery'); }
		if ( get_sub_field('dcf_extra_media_slider') ) { $extra_media_slider = get_sub_field('dcf_extra_media_slider'); }

	// Custom Slider variables
		$default_post_type = 'sliders';
		$default_post_count = 9;
		$default_order = 'ASC'; // 'DESC';
		$default_orderby = 'menu_order'; // 'date';

	// WP_Query arguments
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		if ( !empty($post_term_restriction) ) {

			// Override selected post type based on selected taxonomy
			$restrictedTerm = $post_term_restriction[0]->slug;
			$restrictedTaxonomy = $post_term_restriction[0]->taxonomy;
			$taxObject = get_taxonomy($restrictedTaxonomy);
			$postTypeArray = $taxObject->object_type;
			$post_type = $postTypeArray[0];

			$args = array(
				'post_type' 		=> $post_type,
				'post_status' 		=> array( 'publish' ),
				'nopaging' 			=> false,
				'paged' 			=> $paged,
				'posts_per_page' 	=> $default_post_count,
				'order' 			=> $default_order,
				'orderby' 			=> $default_orderby,
				'tax_query' => array(
					array (
						'taxonomy' 	=> $restrictedTaxonomy,
						'field' 	=> 'slug',
						'terms' 	=> $restrictedTerm,
					)
				),
			);
		} else {
			$args = array(
				'post_type' 		=> $default_post_type,
				'post_status' 		=> array( 'publish' ),
				'nopaging' 			=> true,
				'paged' 			=> $paged,
				'order' 			=> $default_order,
				'orderby' 			=> $default_orderby,
			);
		}

	// The Query & Post Count
		$query = new WP_Query( $args );
		$count = $query->post_count;

	// Extra class for first active item
		$i = 0; if ( $i == 1 ) { $active = 'is-active'; }

?>

<?php if ( have_posts() && !$disable_mobile ) { ?>

	<article aria-label="<?php echo $module_label; ?>" data-module="<?php echo $module_name; ?>" <?php post_class($post_class_array); ?> <?php if ( isset($module_design_style) ) { echo $module_design_style; } ?>>

		<?php get_template_part( 'template-parts/custom/module/module', 'header' );  ?>

		<?php if ( isset($extra_content) || isset($extra_media_image) || isset($extra_media_video) || isset($extra_media_slider) ) { ?>
			<div class="panel-content">
				<section class="section <?php echo $content_class; ?>">

					<?php if ( isset($extra_content) && ( !empty($extra_content) ) ) { ?>
						<div class="extra-content">
							<?php echo apply_filters('the_content', $extra_content); ?>
						</div>
					<?php } ?>

					<?php if ( $extra_media_type == 'image') { ?>

						<?php if ( isset($extra_media_image) && ( !empty($extra_media_image) ) ) { ?>
							<div class="extra-media <?php echo $extra_media_type; ?>">
								<?php
									if( !empty($extra_media_image) ) {

										// Image vars
										$image_id = $extra_media_image['id'];
										$image_url = $extra_media_image['url'];

										// Get WP responsive markup
										$responsive_image = wp_get_attachment_image( $image_id, 'full', false, array( 'class' => '' ) );
										$responsive_image_src = wp_get_attachment_image_url( $image_id, 'full' );
									}

									if ( isset($responsive_image) ) { echo apply_filters( 'the_content', $responsive_image ); }

								?>
							</div>
						<?php } ?>

					<?php } elseif ( $extra_media_type == 'video') { ?>

						<?php if ( isset($extra_media_video) && ( !empty($extra_media_video) ) ) { ?>
							<div class="extra-media <?php echo $extra_media_type; ?>">
								<div class="responsive-embed"><?php echo $extra_media_video; ?></div>
							</div>
						<?php } ?>

					<?php } elseif ( $extra_media_type == 'gallery') { ?>

						<?php if ( isset($extra_media_gallery) && ( !empty($extra_media_gallery) ) ) { ?>
							<div class="extra-media <?php echo $extra_media_type; ?>">

								<?php if( $extra_media_gallery ):
									$count = count( $extra_media_gallery );
									$i = 0;
								?>
									<article aria-label="Image Slider" role="region" data-count="<?php echo $count; ?>" data-orbit class="content-slider orbit">

										<ul class="orbit-container inlinelist">

											<?php if ( $count > 1 ) { ?>
												<button class="orbit-previous">
													<span class="show-for-sr">Previous Slide</span>
													<span class="nav fa fa-chevron-left fa-3x"></span>
												</button>
												<button class="orbit-next">
													<span class="show-for-sr">Next Slide</span>
													<span class="nav fa fa-chevron-right fa-3x"></span>
												</button>
											<?php } ?>

											<?php foreach( $extra_media_gallery as $image ): ?>

												<?php
													// ACF galery fields
													// $image = $image['url'];
													// $caption = $image['caption'];

													if( !empty($image) ) {

														// Image vars
														$image_id = $image['id'];
														$image_url = $image['url'];

														// Get WP responsive markup
														$responsive_image = wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'orbit-image' ) );
														$responsive_image_src = wp_get_attachment_image_url( $image_id, 'full' );
													}

													// Increment count for active class
													$i++;
												?>

												<li class="orbit-slide <?php if ( isset($active) ) { echo $active; } ?>" <?php if ( isset($responsive_image_src) ) { echo 'style="background-image: url(\''.$responsive_image_src.'\')'; } ?>">

													<?php if ( isset($responsive_image) ) { echo apply_filters( 'the_content', $responsive_image ); } ?>
													<?php if ( isset($caption) ) { ?>
														<figcaption class="orbit-caption">
															<h1><?php echo $caption; ?></h1>
															<?php if ( $link_type == 'button' && !empty($link_url) ) { ?>
																<a href="<?php echo $link_url; ?>" class="button"><?php if (!empty($link_text)) { echo $link_text; } else { echo 'Find our more'; } ?></a>
															<?php } ?>
														</figcaption>
													<?php } ?>

												</li>

											<?php endforeach; ?>
										</ul>
									</article>

								<?php endif; ?>
							</div>
						<?php } ?>

					<?php } elseif ( $extra_media_type == 'slider') { ?>
						<?php if ( $query->have_posts() ) { ?>

							<div class="extra-media <?php echo $extra_media_type; ?>">
								<article aria-label="Media Slider" class="orbit" role="region" data-count="<?php echo $count; ?>" data-orbit>

									<ul class="orbit-container inlinelist">

										<?php if ( $count > 1 ) { ?>
											<button class="orbit-previous">
												<span class="show-for-sr">Previous Slide</span>
												<span class="nav fa fa-chevron-left fa-3x"></span>
											</button>
											<button class="orbit-next">
												<span class="show-for-sr">Next Slide</span>
												<span class="nav fa fa-chevron-right fa-3x"></span>
											</button>
										<?php } ?>

										<?php while ( $query->have_posts() ) { $query->the_post(); ?>

											<?php
												// ACF content fields
												$image = get_field('dcf_slide_image');
												$overlay = get_field('dcf_slide_overlay');
												$caption = get_field('dcf_slide_caption');
												$link_type = get_field('dcf_slide_link');
												$link_url = get_field('dcf_slide_link_url');
												$link_text = get_field('dcf_slide_link_text');

												if( !empty($image) ) {

													// Image vars
													$image_id = $image['id'];
													$image_url = $image['url'];

													// Get WP responsive markup
													$responsive_image = wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'orbit-image' ) );
													$responsive_image_src = wp_get_attachment_image_url( $image_id, 'full' );
												}

												// Increment count for active class
												$i++;
											?>

											<li class="orbit-slide<?php if ( isset($active) ) { echo $active; } ?>" <?php if ( isset($responsive_image_src) ) { echo 'style="background-image: url(\''.$responsive_image_src.'\')'; } ?>">

												<?php if ( isset($link_type) && $link_type == 'slide' && !empty($link_url) ) { ?><a href="<?php echo $link_url; ?>"><?php } ?>

												<?php if ( isset($responsive_image) ) { echo apply_filters( 'the_content', $responsive_image ); } ?>
												<?php if ( isset($caption) ) { ?>
													<figcaption class="orbit-caption <?php echo $overlay; ?>">
														<h1><?php echo $caption; ?></h1>
														<?php if ( isset($link_type) && $link_type == 'button' && !empty($link_url) ) { ?>
															<a href="<?php echo $link_url; ?>" class="button"><?php if (!empty($link_text)) { echo $link_text; } else { echo 'Find our more'; } ?></a>
														<?php } ?>
													</figcaption>
												<?php } ?>
												<?php if ( isset($overlay) ) { ?><div class="orbit-overlay <?php echo $overlay; ?>"></div><?php } ?>

												<?php if ( isset($link_type) && $link_type == 'slide' && !empty($link_url) ) { ?></a><?php } ?>
											</li>
										<?php } ?>
									</ul>
								</article>
							</div>
						<?php } ?>
					<?php } ?>

				</section>
			</div>
		<?php } ?>
	</article>

<?php } ?>

<?php
	// Restore original Post Data
	wp_reset_postdata();
?>