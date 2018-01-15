<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package unite
 */

get_header(); ?>

	<div id="primary" class="content-area col-sm-12 col-md-8 <?php echo of_get_option( 'site_layout' ); ?>">
		<main id="main" class="site-main" role="main">

		<?php

		if( !empty( $_GET['nedv'] && $_GET['nedv']>0) ){

			// echo '<h2>has get </h2>';
			$id = (int)$_GET['nedv'];
			// echo ' ID agentstva - '.$id.'<br>';
			global $wpdb;
			$id_posts = $wpdb->get_col($wpdb->prepare("SELECT p2p_to FROM {$wpdb->prefix}p2p WHERE p2p_from=%d",(int)$id) );
			// var_dump($id_posts);
			// deb_last_query();

			if( !empty($id_posts) ){

				// $params = array('posts_per_page' => 15, 'post_type' => 'nedvigimost', 'post__in' => array(8,11) );
				$params = array( 'post_type' => 'nedvigimost', 'post__in' => $id_posts );
				$wc_query = new WP_Query($params);
				?>
				<?php if ($wc_query->have_posts()) : ?>
				<?php while ($wc_query->have_posts()) : $wc_query->the_post(); ?>
					<h2><a href="<?php echo get_the_permalink();?>"><?php echo get_the_title(); ?></a></h2>
					<?php 
					if(!empty( get_field('ploshad')) )  echo '<p>Площадь: '. get_field('ploshad').' м<span>2</span></p>';
					if(!empty(get_field('стоимость')) )  echo '<p>Стоимость: '.get_field('стоимость').'</p>';
					if(!empty(get_field('адрес') ))  echo '<p>Адрес: '.get_field('адрес').'</p>';
					if(!empty(get_field('жилая_площадь') ))  echo '<p>Жилая площадь: '.get_field('жилая_площадь').' м<span>2</span></p>';
					if(!empty(get_field('этаж')))  echo '<p>Этаж: '.get_field('этаж').'</p>';
					?>
					<!-- 
					<p>Площадь: <?php var_dump( get_fields()); ?> м<span>2</span></p>
					<p>Площадь: <?php print_r( get_field_objects()); ?> м<span>2</span></p>
					 -->
					<?php echo get_the_post_thumbnail(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				<?php else:  ?>
					<p>Нет записей </p>
				<?php endif;
			} 
		}else{

			$params = array('post_type' => 'nedvigimost');
			// $params = array('posts_per_page' => 15, array('post_type' => 'nedvigimost','agentstvo'=>'Азбука жилья') );

			// фрагментарное кэширование
			$wc_query = get_transient( 'wc_query' );
			if ( false === $wc_query ) {
				// Данные получить не удалось, поэтому, создадим их и сохраним
				$wc_query = new WP_Query($params);
				set_transient( 'wc_query', $wc_query,12 * HOUR_IN_SECONDS ); // сохраняем результат sql запроса в бд на 12 часов
			}

			// $wc_query = new WP_Query($params);
			?>
			<?php if ($wc_query->have_posts()) : ?>
				<?php while ($wc_query->have_posts()) : $wc_query->the_post(); ?>
					<h2><a href="<?php echo get_the_permalink();?>"><?php echo get_the_title(); ?></a></h2>
					<?php 
					if(!empty( get_field('ploshad')) )  echo '<p>Площадь: '. get_field('ploshad').' м<span>2</span></p>';
					if(!empty(get_field('стоимость')) )  echo '<p>Стоимость: '.get_field('стоимость').'</p>';
					if(!empty(get_field('адрес') ))  echo '<p>Адрес: '.get_field('адрес').'</p>';
					if(!empty(get_field('жилая_площадь') ))  echo '<p>Жилая площадь: '.get_field('жилая_площадь').' м<span>2</span></p>';
					if(!empty(get_field('этаж')))  echo '<p>Этаж: '.get_field('этаж').'</p>';
					?>
					<!-- 
					<p>Площадь: <?php var_dump( get_fields()); ?> м<span>2</span></p>
					<p>Площадь: <?php print_r( get_field_objects()); ?> м<span>2</span></p>
					 -->
					<?php echo get_the_post_thumbnail(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				<?php else:  ?>
					<p>Нет записей </p>
			<?php endif;
		}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
