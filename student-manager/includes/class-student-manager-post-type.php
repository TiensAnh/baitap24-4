<?php
/**
 * Register student custom post type.
 *
 * @package StudentManager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Student_Manager_Post_Type {
	/**
	 * Post type slug.
	 */
	const POST_TYPE = 'student';

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Register student custom post type.
	 */
	public function register_post_type() {
		self::register();
	}

	/**
	 * Register student custom post type.
	 */
	public static function register() {
		$labels = array(
			'name'               => __( 'Sinh vien', 'student-manager' ),
			'singular_name'      => __( 'Sinh vien', 'student-manager' ),
			'menu_name'          => __( 'Sinh vien', 'student-manager' ),
			'name_admin_bar'     => __( 'Sinh vien', 'student-manager' ),
			'add_new'            => __( 'Them moi', 'student-manager' ),
			'add_new_item'       => __( 'Them sinh vien', 'student-manager' ),
			'new_item'           => __( 'Sinh vien moi', 'student-manager' ),
			'edit_item'          => __( 'Chinh sua sinh vien', 'student-manager' ),
			'view_item'          => __( 'Xem sinh vien', 'student-manager' ),
			'all_items'          => __( 'Tat ca sinh vien', 'student-manager' ),
			'search_items'       => __( 'Tim sinh vien', 'student-manager' ),
			'not_found'          => __( 'Khong tim thay sinh vien.', 'student-manager' ),
			'not_found_in_trash' => __( 'Khong co sinh vien trong thung rac.', 'student-manager' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_position'      => 20,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'supports'           => array( 'title', 'editor' ),
			'has_archive'        => false,
			'rewrite'            => array( 'slug' => 'sinh-vien' ),
			'show_in_rest'       => true,
			'publicly_queryable' => true,
		);

		register_post_type( self::POST_TYPE, $args );
	}
}
