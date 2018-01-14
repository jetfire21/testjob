<?php

add_action( 'wp_enqueue_scripts', 'my_child_theme_scripts' );
function my_child_theme_scripts() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// создание нового типа поста - Недвижимость
add_action('init', 'as21_custom_type_nedvigimost');
function as21_custom_type_nedvigimost()
{
  $labels = array(
  'name' => 'Недвижимость', 
  'singular_name' => 'Недвижимость', 
  'add_new' => 'Добавить новую',
  'add_new_item' => 'Добавить новую',
  'edit_item' => 'Редактировать',
  'new_item' => 'New movie',
  'view_item' => 'View movie',
  'search_items' => 'Search movie',
  'not_found' =>  'Not found',
  'not_found_in_trash' => 'No found in trash',
  'parent_item_colon' => '',
  'menu_name' => 'Недвижимость'

  );
  $args = array(
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'query_var' => true,
  'rewrite' => true,
  'capability_type' => 'post',
  'has_archive' => true,
  'hierarchical' => false,
  'menu_position' => null,
  'supports' => array('title','editor','thumbnail')
  );

  register_post_type('nedvigimost',$args);



  $labels2 = array(
  'name' => 'Агентство',
  'singular_name' => 'Агентство', 
  'add_new' => 'Добавить новое',
  'add_new_item' => 'Add new movie',
  'edit_item' => 'Редактировать',
  'new_item' => 'Новый',
  'view_item' => 'View movie',
  'search_items' => 'Search movie',
  'not_found' =>  'Not found',
  'not_found_in_trash' => 'No found in trash',
  'parent_item_colon' => '',
  'menu_name' => 'Агентство'

  );
  $args2 = array(
  'labels' => $labels2,
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'query_var' => true,
  'rewrite' => true,
  'capability_type' => 'post',
  'has_archive' => true,
  'hierarchical' => false,
  'menu_position' => null,
  'supports' => array('title','editor','thumbnail')
  );

  register_post_type('agentstvo',$args2);

 // создание новой таксономии ТИП недвижисоти для типа записи Недвижимость 
	$labels = array(
		'name' => _x( 'Типы недвижимости', 'taxonomy general name' ),
		'singular_name' => _x( 'Тип недвижимости', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Genres' ),
		'all_items' => __( 'All Genres' ),
		'parent_item' => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item' => __( 'Редактировать тип недвижимости' ),
		'update_item' => __( 'Update Genre' ),
		'add_new_item' => __( 'Добавить новый тип недвижимости' ),
		'new_item_name' => __( 'New Genre Name' ),
		'menu_name' => __( 'Тип недвижимости' ),	);

	register_taxonomy('taxonomy', array('nedvigimost'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'tip_nendig' ),
	));

}


function my_connection_types() {
	p2p_register_connection_type( array(
		'name' => 'posts_to_pages',
		'from' => 'agentstvo',
		'to' => 'nedvigimost'
	) );
}
add_action( 'p2p_init', 'my_connection_types' );


p2p_register_connection_type( array(
  'name' => 'my_connection_type',
  'from' => 'page',
  'to' => 'user',
  'admin_box' => array(
    'show' => 'any',
    'context' => 'side'
  )
) );




add_action('wp_footer','as21_lala');
function as21_lala(){



/*
echo '<hr>';
		// Find connected pages
		$connected = new WP_Query( array(
		  'connected_type' => 'posts_to_pages',
		  'connected_items' => get_queried_object(),
		  'nopaging' => true,
		) );
// alex_debug(0,1,'',$connected);
		// Display connected pages
		if ( $connected->have_posts() ) :
			echo '<hr>';
			global $wpdb;
		?>
		<h3>Related pages:</h3>
		<ul>
		<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
		<?php	$id = get_the_ID();?>
			<!--<li><a href="<?php the_permalink(); ?>?nedv=<? echo $id;?>"><?php the_title();  echo $id;?></a></li>-->
			<li><a href="<?php echo site_url(); ?>?nedv=<? echo $id;?>"><?php the_title();  echo $id;?></a></li>
			 <?php

	// deb_last_query();
			?>
		<?php endwhile; ?>
		</ul>
		<?php 
		// Prevent weirdness
		wp_reset_postdata();

		endif;
*/




}

function deb_last_query(){

	global $wpdb;
	echo '<hr>';
	echo "<b>last query:</b> ".$wpdb->last_query."<br>";
	echo "<b>last result:</b> "; echo "<pre>"; print_r($wpdb->last_result); echo "</pre>";
	echo "<b>last error:</b> "; echo "<pre>"; print_r($wpdb->last_error); echo "</pre>";
	echo '<hr>';
}


function alex_debug ( $show_text = false, $is_arr = false, $title = false, $var, $var_dump = false, $sep = "| "){

    // e.g: alex_debug(0, 1, "name_var", $get_tasks_by_event_id, 1);
    $debug_text = "<br>========Debug MODE==========<br>";
    if( (bool)($show_text) ) echo $debug_text;
    if( (bool)($is_arr) ){
        echo "<br>".$title."-";
        echo "<pre>";
        if($var_dump) var_dump($var); else print_r($var);
        echo "</pre>";
    } else echo $title."-".$var;
    if( is_string($var) ) { if($sep == "l") echo "<hr>"; else echo $sep; }
}

// add_action("wp_footer","wp_get_name_page_template");

function wp_get_name_page_template(){


    global $template;
    // echo basename($template);
    // полный путь с названием шаблона страницы
    echo "1- ".$template;

	echo "<br>2- ".$page_template = get_page_template_slug( get_queried_object_id() )." | ";
	// echo $template = get_post_meta( $post->ID, '_wp_page_template', true );
	// echo $template = get_post_meta( get_queried_object_id(), '_wp_page_template', true );
	// echo "id= ".get_queried_object_id();
	echo "<br>3- ".$_SERVER['PHP_SELF'];
	echo "<br>4- ".__FILE__;
	echo "<br>5- ".$_SERVER["SCRIPT_NAME"];
	echo "<br>6- ".$_SERVER['DOCUMENT_ROOT'];
	print_r($_SERVER);
}	


