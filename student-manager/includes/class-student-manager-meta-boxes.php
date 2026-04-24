<?php
/**
 * Handle student meta boxes and data persistence.
 *
 * @package StudentManager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Student_Manager_Meta_Boxes {
	/**
	 * Meta key for student code.
	 */
	const META_MSSV = '_student_manager_mssv';

	/**
	 * Meta key for class/major.
	 */
	const META_MAJOR = '_student_manager_major';

	/**
	 * Meta key for birth date.
	 */
	const META_BIRTH_DATE = '_student_manager_birth_date';

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'save_post_' . Student_Manager_Post_Type::POST_TYPE, array( $this, 'save_meta_boxes' ) );
	}

	/**
	 * List available majors.
	 *
	 * @return array<string, string>
	 */
	public static function get_majors() {
		return array(
			'cntt'      => 'CNTT',
			'kinh_te'   => 'Kinh te',
			'marketing' => 'Marketing',
		);
	}

	/**
	 * Resolve major label from stored value.
	 *
	 * @param string $major Major key.
	 * @return string
	 */
	public static function get_major_label( $major ) {
		$majors = self::get_majors();

		return isset( $majors[ $major ] ) ? $majors[ $major ] : '';
	}

	/**
	 * Format birth date for display.
	 *
	 * @param string $birth_date Raw date value.
	 * @return string
	 */
	public static function format_birth_date( $birth_date ) {
		if ( empty( $birth_date ) ) {
			return '';
		}

		$date = DateTime::createFromFormat( 'Y-m-d', $birth_date );

		if ( false === $date || $birth_date !== $date->format( 'Y-m-d' ) ) {
			return '';
		}

		return $date->format( 'd/m/Y' );
	}

	/**
	 * Register student meta box.
	 */
	public function register_meta_boxes() {
		add_meta_box(
			'student-manager-info',
			__( 'Thong tin sinh vien', 'student-manager' ),
			array( $this, 'render_meta_box' ),
			Student_Manager_Post_Type::POST_TYPE,
			'normal',
			'default'
		);
	}

	/**
	 * Render student meta box fields.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function render_meta_box( $post ) {
		$mssv       = get_post_meta( $post->ID, self::META_MSSV, true );
		$major      = get_post_meta( $post->ID, self::META_MAJOR, true );
		$birth_date = get_post_meta( $post->ID, self::META_BIRTH_DATE, true );
		$majors     = self::get_majors();

		wp_nonce_field( 'student_manager_save_meta', 'student_manager_meta_nonce' );
		?>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row">
						<label for="student_manager_mssv"><?php esc_html_e( 'Ma so sinh vien (MSSV)', 'student-manager' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="student_manager_mssv"
							name="student_manager_mssv"
							value="<?php echo esc_attr( $mssv ); ?>"
							class="regular-text"
						/>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="student_manager_major"><?php esc_html_e( 'Lop/Chuyen nganh', 'student-manager' ); ?></label>
					</th>
					<td>
						<select id="student_manager_major" name="student_manager_major">
							<option value=""><?php esc_html_e( '-- Chon --', 'student-manager' ); ?></option>
							<?php foreach ( $majors as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $major, $value ); ?>>
									<?php echo esc_html( $label ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="student_manager_birth_date"><?php esc_html_e( 'Ngay sinh', 'student-manager' ); ?></label>
					</th>
					<td>
						<input
							type="date"
							id="student_manager_birth_date"
							name="student_manager_birth_date"
							value="<?php echo esc_attr( $birth_date ); ?>"
						/>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Save student meta fields safely.
	 *
	 * @param int $post_id Current post id.
	 */
	public function save_meta_boxes( $post_id ) {
		if ( ! isset( $_POST['student_manager_meta_nonce'] ) ) {
			return;
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST['student_manager_meta_nonce'] ) );

		if ( ! wp_verify_nonce( $nonce, 'student_manager_save_meta' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$mssv       = isset( $_POST['student_manager_mssv'] ) ? sanitize_text_field( wp_unslash( $_POST['student_manager_mssv'] ) ) : '';
		$major      = isset( $_POST['student_manager_major'] ) ? sanitize_text_field( wp_unslash( $_POST['student_manager_major'] ) ) : '';
		$birth_date = isset( $_POST['student_manager_birth_date'] ) ? sanitize_text_field( wp_unslash( $_POST['student_manager_birth_date'] ) ) : '';

		if ( ! array_key_exists( $major, self::get_majors() ) ) {
			$major = '';
		}

		if ( ! $this->is_valid_birth_date( $birth_date ) ) {
			$birth_date = '';
		}

		$this->update_or_delete_meta( $post_id, self::META_MSSV, $mssv );
		$this->update_or_delete_meta( $post_id, self::META_MAJOR, $major );
		$this->update_or_delete_meta( $post_id, self::META_BIRTH_DATE, $birth_date );
	}

	/**
	 * Update or delete post meta based on field value.
	 *
	 * @param int    $post_id Post id.
	 * @param string $meta_key Meta key.
	 * @param string $value Sanitized value.
	 */
	private function update_or_delete_meta( $post_id, $meta_key, $value ) {
		if ( '' === $value ) {
			delete_post_meta( $post_id, $meta_key );
			return;
		}

		update_post_meta( $post_id, $meta_key, $value );
	}

	/**
	 * Validate an HTML date field value.
	 *
	 * @param string $birth_date Date value.
	 * @return bool
	 */
	private function is_valid_birth_date( $birth_date ) {
		if ( '' === $birth_date ) {
			return false;
		}

		$date = DateTime::createFromFormat( 'Y-m-d', $birth_date );

		return false !== $date && $birth_date === $date->format( 'Y-m-d' );
	}
}
