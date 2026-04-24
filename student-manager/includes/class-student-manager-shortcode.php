<?php
/**
 * Render the student list shortcode.
 *
 * @package StudentManager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Student_Manager_Shortcode {
	/**
	 * Register shortcode.
	 */
	public function __construct() {
		add_shortcode( 'danh_sach_sinh_vien', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Render student list table.
	 *
	 * @return string
	 */
	public function render_shortcode() {
		wp_enqueue_style(
			'student-manager-frontend',
			STUDENT_MANAGER_URL . 'assets/css/student-manager.css',
			array(),
			STUDENT_MANAGER_VERSION
		);

		$query = new WP_Query(
			array(
				'post_type'      => Student_Manager_Post_Type::POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);

		ob_start();

		if ( ! $query->have_posts() ) :
			wp_reset_postdata();
			?>
			<p class="student-manager-empty"><?php esc_html_e( 'Chua co sinh vien nao duoc them.', 'student-manager' ); ?></p>
			<?php
			return ob_get_clean();
		endif;
		?>
		<div class="student-manager-table-wrapper">
			<table class="student-manager-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'STT', 'student-manager' ); ?></th>
						<th><?php esc_html_e( 'MSSV', 'student-manager' ); ?></th>
						<th><?php esc_html_e( 'Ho ten', 'student-manager' ); ?></th>
						<th><?php esc_html_e( 'Lop', 'student-manager' ); ?></th>
						<th><?php esc_html_e( 'Ngay sinh', 'student-manager' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$index = 1;

					while ( $query->have_posts() ) :
						$query->the_post();

						$post_id    = get_the_ID();
						$mssv       = get_post_meta( $post_id, Student_Manager_Meta_Boxes::META_MSSV, true );
						$major      = get_post_meta( $post_id, Student_Manager_Meta_Boxes::META_MAJOR, true );
						$birth_date = get_post_meta( $post_id, Student_Manager_Meta_Boxes::META_BIRTH_DATE, true );
						?>
						<tr>
							<td><?php echo esc_html( $index ); ?></td>
							<td><?php echo esc_html( $mssv ); ?></td>
							<td><?php echo esc_html( get_the_title() ); ?></td>
							<td><?php echo esc_html( Student_Manager_Meta_Boxes::get_major_label( $major ) ); ?></td>
							<td><?php echo esc_html( Student_Manager_Meta_Boxes::format_birth_date( $birth_date ) ); ?></td>
						</tr>
						<?php
						$index++;
					endwhile;
					?>
				</tbody>
			</table>
		</div>
		<?php

		wp_reset_postdata();

		return ob_get_clean();
	}
}
