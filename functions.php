<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

Timber::$dirname = array('templates', 'views');

class HowToBuildWithWP extends TimberSite {

	function __construct() {
		// add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );

		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

		add_action( 'init', function(){
			add_editor_style('style.css');
        } );
        
		parent::__construct();
	}

	function add_to_context( $context ) {
		$context['site'] = $this;
		$context['year'] = date('Y');
		$context['is_home'] = is_home();
		$context['csscache'] = filemtime(get_stylesheet_directory() . '/style.css');
		
		return $context;
	}

	function after_setup_theme(){
		
	}

	function enqueue_scripts(){
        wp_enqueue_style( 'howtobuildwithwp', get_stylesheet_uri() );
        wp_enqueue_script( 'howtobuildwithwp', get_stylesheet_directory_uri() . '/static/js/site.js', array('jquery'), true );
	}

	function dashboard_glance_items( $items ){
		foreach ( get_post_types(array('public'=>true)) as $post_type ){
			$num_posts = wp_count_posts( $post_type );
			if ( $num_posts && $num_posts->publish ) {
				if ( 'post' == $post_type ) {
					continue;
				}
				if ( 'page' == $post_type ) {
					continue;
				}
				$post_type_object = get_post_type_object( $post_type );
				$text = _n( '%s ' . $post_type_object->labels->singular_name, '%s ' . $post_type_object->label, $num_posts->publish );
				$text = sprintf( $text, number_format_i18n( $num_posts->publish ) );
				if ( $post_type_object && current_user_can( $post_type_object->cap->edit_posts ) ) {
					$items[] = sprintf( '<a href="edit.php?post_type=%1$s">%2$s</a>', $post_type, $text );
				} else {
					$items[] = sprintf( '<span>%2$s</span>', $post_type, $text );
				}
			}
		}
		
		return $items;
	}

}

new HowToBuildWithWP();