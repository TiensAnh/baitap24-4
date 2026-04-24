<?php
/**
 * Bootstrap plugin components.
 *
 * @package StudentManager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once STUDENT_MANAGER_PATH . 'includes/class-student-manager-post-type.php';
require_once STUDENT_MANAGER_PATH . 'includes/class-student-manager-meta-boxes.php';
require_once STUDENT_MANAGER_PATH . 'includes/class-student-manager-shortcode.php';

final class Student_Manager {
	/**
	 * Plugin singleton instance.
	 *
	 * @var Student_Manager|null
	 */
	private static $instance = null;

	/**
	 * Get plugin instance.
	 *
	 * @return Student_Manager
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register plugin modules.
	 */
	private function __construct() {
		new Student_Manager_Post_Type();
		new Student_Manager_Meta_Boxes();
		new Student_Manager_Shortcode();
	}
}
