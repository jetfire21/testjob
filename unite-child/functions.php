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

// проверка,активирован ли плагин Posts 2 Posts
// cвязывание агенства с недвижимостями
  if ( class_exists('scbLoad4') ){

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

}

