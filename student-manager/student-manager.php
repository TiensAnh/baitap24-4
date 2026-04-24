<?php
/**
 * Plugin Name: Student Manager
 * Description: Quan ly thong tin sinh vien bang Custom Post Type, meta box va shortcode.
 * Version: 1.0.0
 * Author: Codex
 * License: GPL-2.0-or-later
 * Text Domain: student-manager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STUDENT_MANAGER_VERSION', '1.0.0' );
define( 'STUDENT_MANAGER_PATH', plugin_dir_path( __FILE__ ) );
define( 'STUDENT_MANAGER_URL', plugin_dir_url( __FILE__ ) );

require_once STUDENT_MANAGER_PATH . 'includes/class-student-manager.php';

register_activation_hook( __FILE__, 'student_manager_activate' );
register_deactivation_hook( __FILE__, 'student_manager_deactivate' );

/**
 * Flush rewrite rules when plugin is activated.
 */
function student_manager_activate() {
	Student_Manager_Post_Type::register();
	flush_rewrite_rules();
}

/**
 * Flush rewrite rules when plugin is deactivated.
 */
function student_manager_deactivate() {
	flush_rewrite_rules();
}

Student_Manager::get_instance();
