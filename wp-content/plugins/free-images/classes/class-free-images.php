<?php
/**
 * Free Images
 *
 * @package Free Images
 * @since 1.0.0
 */

if ( ! class_exists( 'Free_Images' ) ) :

	/**
	 * Free Images
	 *
	 * @since 1.0.0
	 */
	class Free_Images {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class Instance.
		 * @since 1.0.0
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 1.0.0
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'plugin_action_links_' . FREE_IMAGES_BASE, array( $this, 'action_links' ) );
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 99 );
			add_action( 'wp_ajax_free_image_download', array( $this, 'download' ) );
		}

		/**
		 * Add menu
		 */
		function add_admin_menu() {
			add_submenu_page(
				'upload.php',
				__( 'Download Images', 'free-images' ),
				__( 'Download Images', 'free-images' ),
				'upload_files',
				'free-images',
				array( $this, 'menu_callback' )
			);
		}

		/**
		 * Menu Callback
		 */
		function menu_callback() {
			require_once FREE_IMAGES_DIR . 'includes/admin-page.php';
		}

		/**
		 * Show action links on the plugin screen.
		 *
		 * @since 1.0.0
		 * @param   mixed $links Plugin Action links.
		 * @return  array
		 */
		function action_links( $links ) {
			$action_links = array(
				'settings' => '<a href="' . admin_url( 'upload.php?page=free-images' ) . '" aria-label="' . esc_attr__( 'See Library', 'free-images' ) . '">' . esc_html__( 'See Library', 'free-images' ) . '</a>',
			);

			return array_merge( $action_links, $links );
		}

		/**
		 * Download
		 */
		function download() {

			$args = array(
				'url'       => isset( $_POST['url'] ) ? esc_url( $_POST['url'] ) : '',
				'page_url'  => isset( $_POST['page_url'] ) ? esc_url( $_POST['page_url'] ) : '',
				'user_name' => isset( $_POST['user_name'] ) ? esc_html( $_POST['user_name'] ) : '',
				'user_url'  => isset( $_POST['user_url'] ) ? esc_html( $_POST['user_url'] ) : '',
			);

			if ( empty( $args['url'] ) || empty( $args['page_url'] ) ) {
				wp_send_json_error( __( 'Failed! Not a valid image URL.', 'free-images' ) );
			}

			$output = self::download_image_by_url( $args );

			wp_send_json_success( $output );
		}

		/**
		 * Enqueue Assets.
		 *
		 * @version 1.0.0
		 *
		 * @param  string $hook Current hook name.
		 * @return void
		 */
		function enqueue_assets( $hook ) {
			if ( 'media_page_free-images' !== $hook ) {
				return;
			}

			// font awesome.
			wp_enqueue_style( 'free-images-font-awesome', FREE_IMAGES_URI . 'assets/css/font-awesome.css', null, FREE_IMAGES_VER, 'all' );

			// Lightbox.
			wp_register_script( 'free-images-lightbox', FREE_IMAGES_URI . 'assets/vendor/js/magnific-popup.js', array( 'jquery' ), FREE_IMAGES_VER, true );
			wp_register_style( 'free-images-lightbox', FREE_IMAGES_URI . 'assets/vendor/css/magnific-popup.css', null, FREE_IMAGES_VER, 'all' );

			// Lazyload & Image Loaded.
			wp_register_script( 'free-images-lazyload', FREE_IMAGES_URI . 'assets/vendor/js/lazy.js', array( 'jquery' ), FREE_IMAGES_VER, true );

			wp_register_script( 'free-images-shortcode', FREE_IMAGES_URI . 'assets/js/shortcode.js', array( 'wp-util', 'imagesloaded', 'jquery', 'jquery-masonry', 'free-images-lazyload', 'free-images-lightbox' ), FREE_IMAGES_VER, true );

			// Styles.
			wp_register_style( 'free-images-shortcode', FREE_IMAGES_URI . 'assets/css/shortcode.css', array( 'free-images-lightbox', 'free-images-font-awesome' ), FREE_IMAGES_VER, 'all' );
			wp_register_style( 'free-images-grid', FREE_IMAGES_URI . 'assets/css/grid.css', null, FREE_IMAGES_VER, 'all' );

			$data = array(
				'ajaxurl'     => admin_url( 'admin-ajax.php' ),
				'placeholder' => FREE_IMAGES_URI . 'assets/images/placeholder.jpg',
			);
			wp_localize_script( 'free-images-shortcode', 'freeImages', $data );

			// Enqueue assets.
			wp_enqueue_script( 'free-images-shortcode' );
			wp_enqueue_style( 'free-images-shortcode' );
			wp_enqueue_style( 'free-images-grid' );

		}

		/**
		 * Download File Into Uploads Directory
		 *
		 * @since 1.0.0
		 *
		 * @param  string $file Download File URL.
		 * @param  string $image_name Image name.
		 * @return array        Downloaded file data.
		 */
		public static function download_file( $file = '', $image_name ) {

			// Gives us access to the download_url() and wp_handle_sideload() functions.
			require_once( ABSPATH . 'wp-admin/includes/file.php' );

			$timeout_seconds = 5;

			// Download file to temp dir.
			$temp_file = download_url( $file, $timeout_seconds );

			// WP Error.
			if ( is_wp_error( $temp_file ) ) {
				return array(
					'success' => false,
					'data'    => $temp_file->get_error_message(),
				);
			}

			// Array based on $_FILE as seen in PHP file uploads.
			if ( ! empty( $image_name ) ) {
				$file       = parse_url( $file );
				$file_path  = $file['path'];
				$image_name = $image_name . '.' . pathinfo( $file_path, PATHINFO_EXTENSION );
			} else {
				$image_name = basename( $file );
			}
			$file_args = array(
				'name'     => $image_name,
				'tmp_name' => $temp_file,
				'error'    => 0,
				'size'     => filesize( $temp_file ),
			);

			$overrides = array(

				// Tells WordPress to not look for the POST form
				// fields that would normally be present as
				// we downloaded the file from a remote server, so there
				// will be no form fields
				// Default is true.
				'test_form'   => false,

				// Setting this to false lets WordPress allow empty files, not recommended.
				// Default is true.
				'test_size'   => true,

				// A properly uploaded file will pass this test. There should be no reason to override this one.
				'test_upload' => true,

			);

			// Move the temporary file into the uploads directory.
			$results = wp_handle_sideload( $file_args, $overrides );

			if ( isset( $results['error'] ) ) {
				return array(
					'success' => false,
					'data'    => $results,
				);
			}

			// Success!
			return array(
				'success' => true,
				'data'    => $results,
			);
		}

		/**
		 * Set featured image to post ID by image URL.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Input Arguments.
		 */
		public static function download_image_by_url( $args = '' ) {

			$image_name = rtrim( $args['page_url'], '/' );
			$image_name = substr( $image_name, strrpos( $image_name, '/' ) + 1 );

			// $filename should be the path to a file in the upload directory.
			$file = Free_Images::get_instance()->download_file( $args['url'], $image_name );

			if ( false === $file['success'] ) {
				wp_send_json_error( $file['data'] );
			}

			$file_abs_url = $file['data']['file'];
			$file_url     = $file['data']['file'];
			$file_type    = $file['data']['type'];

			// Get the path to the upload directory.
			$wp_upload_dir = wp_upload_dir();

			$image_name = preg_replace( '/[0-9]+/', '', $image_name );
			$image_name = str_replace( '-', ' ', $image_name );

			// Prepare an array of post data for the attachment.
			$attachment = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $file_abs_url ),
				'post_mime_type' => $file_type,
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_abs_url ) ),
				'post_status'    => 'inherit',
				'post_title'     => ucwords( $image_name ),
				'post_excerpt'   => '<a href="' . $args['user_url'] . '">' . $args['user_name'] . '</a> / Pixabay',
				'meta_input'     => array(
					'_wp_attachment_image_alt' => ucwords( $image_name ) . ' - ' . $args['user_name'] . ' / Pixabay',
				),
			);

			// Insert the attachment.
			$attach_id = wp_insert_attachment( $attachment, $file_abs_url );

			// Include image.php.
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			// Define attachment metadata.
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file_abs_url );

			// Assign metadata to attachment.
			wp_update_attachment_metadata( $attach_id, $attach_data );

			return $attach_data;

		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Free_Images::get_instance();

endif;
