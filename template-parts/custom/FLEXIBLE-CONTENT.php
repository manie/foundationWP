<?php

	// check if the flexible content field has rows of data
	if( have_rows('dcm') ):

		// loop through the rows of data
		while ( have_rows('dcm') ) : the_row();

			if( get_row_layout() == 'primary_content' ):
				get_template_part( 'template-parts/custom/module/module', 'primary-content' );
			elseif( get_row_layout() == 'hero_slider' ):
				get_template_part( 'template-parts/custom/module/module', 'hero-slider' );
			elseif( get_row_layout() == 'horizontal_break' ):
				get_template_part( 'template-parts/custom/module/module', 'hr' );
			elseif( get_row_layout() == 'extra_content' ):
				get_template_part( 'template-parts/custom/module/module', 'extra-content' );
			elseif( get_row_layout() == 'extra_content_media' ):
				get_template_part( 'template-parts/custom/module/module', 'extra-content-media' );
			elseif( get_row_layout() == 'post_listing' ):
				get_template_part( 'template-parts/custom/module/module', 'post-listing' );
			elseif( get_row_layout() == 'grid_slider' ):
				get_template_part( 'template-parts/custom/module/module', 'grid-slider' );
			elseif( get_row_layout() == 'contact_form' ):
				get_template_part( 'template-parts/custom/module/module', 'contact-form' );
			elseif( get_row_layout() == 'dynamic_menu' ):
				get_template_part( 'template-parts/custom/module/module', 'dynamic-menu' );
			elseif( get_row_layout() == 'widget_area' ):
				get_template_part( 'template-parts/custom/module/module', 'widget-area' );
			endif;

		endwhile;

	else :

		// no layouts found
		get_template_part( 'template-parts/custom/module/module' );

	endif;

?>
