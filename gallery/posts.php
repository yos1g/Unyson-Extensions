<?php if (!defined('FW')) die('Forbidden');


register_post_type(fw()->extensions->get('gallery')->get_post_type(), array(
	'labels' => array(
		'name' => __('Gallery', 'fw'),
		'singular_name' => __('Gallery', 'fw'),
		'add_new' => __('Add New', 'fw'),
		'add_new_item' => __('Add New Gallery', 'fw'),
		'edit_item' => __('Edit Gallery', 'fw'),
		'new_item' => __('New Gallery', 'fw'),
		'all_items' => __('Gallery', 'fw'),
		'view_item' => __('View Gallery', 'fw'),
		'search_items' => __('Search Gallery', 'fw'),
		'not_found' => __('No Gallery found', 'fw'),
		'not_found_in_trash' => __('No Gallery found in Trash', 'fw'),
		'parent_item_colon' => '',
		'menu_name' => __('Gallery', 'fw')
	),
	'public' => false,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_nav_menus' => false,
	'query_var' => true,
    'rewrite' => array('slug' => fw()->extensions->get('gallery')->get_post_type()),
	'has_archive' => true,
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title', 'slug'),
	'capabilities' => array(
		'edit_post'         => 'edit_pages',
		'read_post'         => 'edit_pages',
		'delete_post'       => 'edit_pages',
		'edit_posts'        => 'edit_pages',
		'edit_others_posts' => 'edit_pages',
		'publish_posts'     => 'edit_pages',
		'read_private_posts'=> 'edit_pages',

		'read'                  => 'edit_pages',
		'delete_posts'          => 'edit_pages',
		'delete_private_posts'  => 'edit_pages',
		'delete_published_posts'=> 'edit_pages',
		'delete_others_posts'   => 'edit_pages',
		'edit_private_posts'    => 'edit_pages',
		'edit_published_posts'  => 'edit_pages',
	),
	/**
	 * Show in menu only if user has access to the Appearance (Themes) menu
	 * else, the Gallery menu will appear, but when clicked on it
	 * users with smaller privileges that does not have access to Appearance menu (for e.g. 'edit_pages' capability)
	 * will see Access denied page
	 */
	'show_in_menu' => current_user_can('switch_themes') ? true : null,
));

