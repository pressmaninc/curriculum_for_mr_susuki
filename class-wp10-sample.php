<?php
/**
 * Plugin Name: WP10 Sample
 * Description: カリキュラム用プラグインです
 * Version: 1.0.0
 * Requires at least: 5.5.1
 * Requires PHP: 7.2
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @author Your name
 * @license https://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @package WordPress
 */

// ①
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Wp10_Sample
 *
 * This class represents a sample plugin for WordPress.
 */
class Wp10_Sample {

	/**
	 * The singleton instance of this class.
	 *
	 * @var Wp10_Sample|null
	 */
	private static $instance;

	/**
	 * Returns a single instance of the class.
	 *
	 * @return ClassName The single instance of the class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construct a new instance
	 *
	 * Initializes a new object of the Wp10_Sample class.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_page' ), 100 );

		// Title Editor 非表示.
		add_action(
			'init',
			function() {
				remove_post_type_support( 'books', 'title' );
				remove_post_type_support( 'books', 'editor' );

				remove_post_type_support( 'impression', 'title' );
				remove_post_type_support( 'impression', 'editor' );
			},
			99
		);

		// Set Default title.
		/* add_filter('wp_insert_post_data', array($this, 'replace_post_data'), '99', 2); */
		add_action( 'acf/save_post', array( $this, 'custom_auto_title' ), 19 );

		// Custom Validation.
		add_filter( 'acf/validate_value/name=book_num', array( $this, 'my_acf_validate_value' ), 10, 4 );

		// 新規追加ボタン消す.
		//add_action( 'admin_enqueue_scripts', array( $this, 'custom_edit_newpost_delete' ) );

		// 見るリンク消す.
		add_filter( 'post_row_actions', array( $this, 'custom_action_row' ), 10, 2 );

		// reviewerの時、bodyにclassをセット.
		add_filter( 'admin_body_class', array( $this, 'wpdocs_admin_classes' ) );

		// Set css and js.
		add_action( 'admin_enqueue_scripts', array( $this, 'regist_styles_and_js' ) );

		add_filter( 'manage_posts_columns', array( $this, 'add_posts_columns' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'add_posts_columns_row' ), 10, 2 );

	}

	public function custom_auto_title( $post_id ) {

		// 投稿タイプ判別.
		if ( get_post_type( $post_id ) == 'books' ) {

			// get Acf Title.
			$post_title = get_field( 'book_title', $post_id );

			// サニタイズ処理.
			$post_name = sanitize_title( $post_title );

			// 投稿Data.
			$post = array(
				'ID'         => $post_id,
				'post_name'  => $post_name,
				'post_title' => $post_title,
			);

			// 更新.
			wp_update_post( $post );
		}

	}

	// 半角英数字 Validation.
	public function my_acf_validate_value( $valid, $value, $field, $input_name ) {

		// Bail early if value is already invalid.
		if ( $valid !== true ) {
			return $valid;
		}

		// 半角英数字 Check.
		if ( ! preg_match( '/^[a-zA-Z0-9]+$/', $value ) ) {
			return __( '半角英数字のみで入力して下さい。' );
		}

		return $valid;
	}

	/**
	 *
	 */
	public function custom_action_row( $actions, $post ) {

		if ( current_user_can( 'reviewer3' ) ) { // reviewerなら非表示.
			unset( $actions['view'] ); // プレビュー.
		}

		return $actions;
	}

	/*
	 * Add Admin body tag class.
	 */
	public function wpdocs_admin_classes( $classes ) {

		if ( current_user_can( 'reviewer3' ) ) { // reviewerなら非表示.
			$classes .= ' reviewer';
		}

		return $classes;
	}

	/**
	 * Set css js.
	 */
	public function regist_styles_and_js() {
		$plugin_version = '1.0'; // Set version number as per requirement e.g 1.0, 1.1 etc.
		$plugin_url = plugin_dir_url( __FILE__ );

		wp_enqueue_style( 'wp10_style', $plugin_url . 'assets/css/wp10.css', array(), $plugin_version );
		wp_enqueue_script( 'wp10_js', $plugin_url . 'assets/js/wp10.js', array(), $plugin_version, true );
	}

	
	/**
	 *
	 */
	public function add_posts_columns($columns) {
		$columns['avelage'] = '平均値';

		return $columns;
	}

	/**
	 *
	 */
	public function add_posts_columns_row($column_name, $post_id) {
		if ( 'avelage' == $column_name ) {
			echo 0;
		}
	}

	/**
	 * Menu Set Function.
	 */
	public function add_menu_page() {
		add_menu_page(
			__( 'Books一覧', '' ),
			__( 'Books一覧', '' ),
			'administrator',
			'wp10_sample_index',
			array( $this, 'view_sample_page_index' ),
		);

		add_menu_page(
			__( 'Books新規追加', '' ),
			__( 'Books新規追加', '' ),
			'administrator',
			'wp10_sample_add',
			array( $this, 'view_sample_page_add' ),
		);
	}

}


Wp10_Sample::get_instance();

/**
 * 有効化時に一度だけreviewerのroleを設定
 */
function add_community_manager_role() {
	$author = get_role( 'reviewer3' );

	// $author->add_cap( 'delete_posts' );
	// $author->add_cap( 'edit_posts' );
	$author->remove_cap( 'delete_published_posts' );
	$author->remove_cap( 'edit_published_posts' );
	$author->remove_cap( 'create_posts' );

	// 最初からソースで追加するなら.
	// add_role(
	// 'reviewer3',
	// __('Reviewer3', 'reviewer3-role'),
	// array(
	// 'read' => true,
	// 'moderate_comments' => false,
	// 'edit_posts' => true,
	// 'edit_other_posts' => false,
	// 'edit_published_posts' => false,
	// 'create_posts' => false,
	// )
	// );
}

// register_activation_hook( __FILE__, 'add_community_manager_role' );
