<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package unite
 */
?>
	<div id="secondary" class="widget-area col-sm-12 col-md-4" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

		<?php


				$params = array('posts_per_page' => 15, 'post_type' => 'agentstvo');
				// $params = array('posts_per_page' => 15, array('post_type' => 'nedvigimost','agentstvo'=>'Азбука жилья') );
				$wc_query = new WP_Query($params);
				?>
				<?php if ($wc_query->have_posts()) : ?>
				<?php while ($wc_query->have_posts()) :
				                $wc_query->the_post(); ?>
				<h2><a href="<?php echo site_url(); ?>?nedv=<?php echo get_the_ID();?>"><?php echo get_the_title(); ?></a></h2>
				<?php // the_content(); ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				<?php else:  ?>
				<p>
				     <?php _e( 'No Products'); ?>
				</p>
				<?php endif; 

		?>
		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
