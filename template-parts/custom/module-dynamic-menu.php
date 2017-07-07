<?php

	// Include required module variables
		include(locate_template('template-parts/custom/VARS-modules.php'));

	// Content Module
		$module_label = "Dynamic Menu";
		$module_name = get_row_layout();

	// Extra class for panel content
		$content_class = '';

	// Add to default post class array
		// $post_class_array[] = 'posts-panel';

	// Custom Content variables
		$menu_class = 'menu-module';
		if ( get_sub_field('dcf_menu_selection') ) { $menu_selection = get_sub_field('dcf_menu_selection'); }

?>

<?php if ( have_posts() ) { ?>

	<article aria-label="<?php echo $module_label; ?>" data-module="<?php echo $module_name; ?>" <?php post_class($post_class_array); ?> <?php if ( isset($module_design_style) ) { echo $module_design_style; } ?>>

		<?php if ( isset($module_title) || isset($module_introduction) ) { ?>
			<header class="panel-header">
				<?php if ( isset($module_title) && ( !empty($module_title) ) ) { ?>
					<h1 class="panel-title"><?php echo $module_title; ?></h1>
				<?php } ?>
				<?php if ( isset($module_introduction) && ( !empty($module_introduction) ) ) { ?>
					<div class="panel-introduction"><?php echo $module_introduction; ?></div>
				<?php } ?>
			</header>
		<?php } ?>

		<?php if ( isset($menu_selection) && ( !empty($menu_selection) ) ) { ?>
			<div class="panel-content">
				<section class="<?php echo $content_class; ?>">
					<?php
						wp_nav_menu( array(
							'menu' 			=> $menu_selection,
							'container' 	=> false,
							'menu_class' 	=> $menu_class,
							'items_wrap' 	=> '<ul id="%1$s" class="%2$s" >%3$s</ul>',
							'depth' 		=> 1,
							'fallback_cb' 	=> false,
						));
					?>
				</section>
			</div>
		<?php } ?>
	</article>

<?php } ?>

<?php
	// Restore original Post Data
	wp_reset_postdata();
?>