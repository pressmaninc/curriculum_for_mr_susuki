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
		// Add Menu.
		// add_action( 'admin_menu', array( $this, 'add_menu_page' ), 100 );

		// Postclassに赤背景をセット
		add_action( 'load-edit.php', array( $this, 'set_red_parent' ) );

		// Title Editor 非表示.
		add_action( 'init', array( $this, 'disable_title_and_editor' ), 99 );

		// Set Default title.
		/* add_filter('wp_insert_post_data', array($this, 'replace_post_data'), 99, 2); */
		add_action( 'acf/save_post', array( $this, 'custom_auto_title' ), 19 );

		// Custom Validation.
		add_filter( 'acf/validate_value/name=book_num', array( $this, 'my_acf_validate_value' ), 10, 4 );

		// 新規追加ボタン消す. load-edit.php
		// add_action( 'admin_enqueue_scripts', array( $this, 'custom_edit_newpost_delete' ) );

		// 見るリンク消す and 返却日が過ぎている行に赤背景.
		add_filter( 'post_row_actions', array( $this, 'custom_action_row' ), 10, 2 );

		// Reviewerの時、bodyにclassをセット.
		add_filter( 'admin_body_class', array( $this, 'wpdocs_admin_classes' ) );

		// Set css and js.
		add_action( 'admin_enqueue_scripts', array( $this, 'regist_styles_and_js' ) );

		// 感想平均カラム追加
		add_filter( 'manage_books_posts_columns', array( $this, 'add_posts_columns' ) );
		add_action( 'manage_books_posts_custom_column', array( $this, 'add_posts_columns_row' ), 10, 2 );
		add_filter( 'manage_edit-books_sortable_columns', array( $this, 'posts_sortable_columns' ) );
		// add_filter('request', array( $this, 'posts_columns_sort_param' ) );

		// DashBoard Widget.
		add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widgets' ) );

		/* *** 出版社と著者の紐付け 色々 ---------------------- *** */

		// Fieldがloadされた時に各種変更できるHook
		// add_filter( 'acf/load_field/name=writer', array( $this, 'my_acf_load_field' ) );
		// add_filter( 'acf/load_value/name=publish_company', array( $this, 'my_acf_load_value' ), 10, 3 );

		// Fieldをクリックした時、選択肢リストのajax結果を取得するHook
		// add_filter( 'acf/fields/post_object/result/name=writer', array( $this, 'my_acf_fields_post_object_result' ), 10, 4 );

		// Cookieで取得
		// add_filter( 'acf/fields/post_object/query/name=writer', array( $this, 'acf_fields_post_object_query_cookie' ), 10, 3 );

		// Acf js hookで取得
		add_filter( 'acf/fields/post_object/query/name=writer', array( $this, 'acf_fields_post_object_query_js' ), 10, 3 );

		/* *** 出版社と著者の紐付け 色々 END ---------------------- *** */
	}

	/**
	 * Get choiced publish ID by js post.
	 */
	public function acf_fields_post_object_query_js( $args, $field, $post_id ) {
		$company_id = filter_input( INPUT_POST, 'company_id', FILTER_SANITIZE_NUMBER_INT );

		if ( $company_id !== '' ) {
			$args['meta_key']   = 'writer_publish';
			$args['meta_value'] = $company_id;
		}

		applog( $company_id );

		return $args;
	}

	/**
	 * Get choiced publish ID by cookie.
	 */
	public function acf_fields_post_object_query_cookie( $args, $field, $post_id ) {
		// applog( get_field_object( 'publish_company' ) );

		// Set for WP_Query
		if ( isset( $_COOKIE['company_id'] ) ) {
			$args['meta_key']   = 'writer_publish';
			$args['meta_value'] = $_COOKIE['company_id'];

			setcookie( 'company_id', '', time() - 30 ); // cookie delete.
		}

		applog( 'bbb' );
		applog( $args );

		return $args;
	}

	/**
	 * 未使用.
	 */
	public function my_acf_fields_post_object_result( $text, $post, $field, $post_id ) {
		// applog($field);
		// applog($post_id);
		//applog( $text );

		//$text .= ' (' . $post->post_type . ')';

		// delete_field('writer');

		return $text;
	}

	/**
	 * 未使用.
	 */
	public function my_acf_load_value( $value, $post_id, $field ) {
		// print_r( $value );
		// exit;

		if ( is_string( $value ) ) {
			$value = str_replace( 'Old Company Name', 'New Company Name', $value );
		}
		return $value;
	}


	/**
	 * 未使用.
	 */
	public function my_acf_load_field( $field ) {

		// $choices = get_field('publish_company', 'books', false);
		// print_r($choices);

		$field['required'] = true;
		$field['choices']  = array(
			'custom'   => 'abc',
			'custom_2' => 'My Custom Choice 2',
		);

		return $field;
	}


	/**
	 * 初期Title, Editorを非表示
	 */
	public function disable_title_and_editor() {
		remove_post_type_support( 'books', 'title' );
		remove_post_type_support( 'books', 'editor' );

		remove_post_type_support( 'impression', 'title' );
		remove_post_type_support( 'impression', 'editor' );

		remove_post_type_support( 'publish_company', 'title' );
		remove_post_type_support( 'publish_company', 'editor' );

		remove_post_type_support( 'book_writer', 'title' );
		remove_post_type_support( 'book_writer', 'editor' );
	}


	/**
	 * Acf -> 投稿オブジェクトでデフォルトタイトルが必要になるので、投稿時に合わせてセットする.
	 */
	public function custom_auto_title( $post_id ) {

		$post_type = get_post_type( $post_id );

		$post_title_key = '';

		if ( $post_type == 'books' ) {
			$post_title_key = 'book_title';
		} elseif ( $post_type == 'publish_company' ) {
			$post_title_key = 'publish_company';
		} elseif ( $post_type == 'book_writer' ) {
			$post_title_key = 'book_writer';
		}

		// 投稿タイプ判別.
		if ( '' !== $post_title_key ) {

			// get Acf Title.
			$post_title = get_field( $post_title_key, $post_id );

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
		if ( $value !== '' && ! preg_match( '/^[a-zA-Z0-9]+$/', $value ) ) {
			return __( '半角英数字のみで入力して下さい。' );
		}

		return $valid;
	}

	/**
	 *
	 */
	public function custom_action_row( $actions, $post ) {
		global $pagenow;

		if ( current_user_can( 'reviewer3' ) ) { // reviewerなら非表示.
			unset( $actions['view'] ); // プレビュー.
		}

		return $actions;
	}

	/**
	 *
	 */

	public function set_red_parent() {
		add_filter( 'post_class', array( $this, 'set_red_child' ), 99, 3 );
	}

	/**
	 *
	 */
	public function set_red_child( $classes, $css_class, $post_id ) {

		if ( get_post_type() === 'books' ) {

			$return_date = get_field( 'return_date', $post_id, false );

			$now = ( new DateTime() )->format( 'Ymd' );

			// applog( $return_date );
			// applog( $post_id );

			if ( $return_date != '' && $now > $return_date ) {

				array_push( $classes, 'bg-red' );

			}
		}

		return $classes;
	}

	/*
	* Add Admin body tag class.
	*
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
		$plugin_url     = plugin_dir_url( __FILE__ );

		wp_enqueue_style( 'wp10_style', $plugin_url . 'assets/css/wp10.css', array(), $plugin_version );
		wp_enqueue_script( 'wp10_js', $plugin_url . 'assets/js/wp10.js', array(), $plugin_version, true );
	}

	/**
	 * 　追加カラム：評価平均.
	 */
	public function add_posts_columns( $columns ) {
		$columns['avelage'] = '評価平均';

		return $columns;
	}

	/**
	 * 追加カラム：評価平均の内容.
	 */
	public function add_posts_columns_row( $column_name, $post_id ) {

		// echo $column_name;

		if ( 'avelage' == $column_name ) {

			$arg = array(
				'post_type'  => 'impression',
				'meta_query' => array(
					array(
						'key'   => 'impression_target_book',
						'value' => $post_id,
					),
				),
			);

			$the_query   = new WP_Query( $arg );
			$post_count  = $the_query->post_count;
			$total_point = 0;

			if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) :

					$the_query->the_post();
					$total_point += get_post_meta( get_the_ID(), 'impression_point', true );

				endwhile;
			endif;

			wp_reset_postdata();

			if ( $total_point ) {
				$total_point = round( $total_point / $post_count, 1 );
				$total_point = number_format( $total_point, 1 );
			}

			echo $total_point;

		}

	}

	/**
	 * 追加カラム Set Sortable.
	 */
	public function posts_sortable_columns( $sortable_column ) {
		$sortable_column['avelage'] = 'avelage';
		return $sortable_column;
	}

	/**
	 * カスタムフィールドでソートする際のパラメータ
	 * sortableをセットすれば、それ以降はACが対応するようなので不要だった
	 */
	// public function posts_columns_sort_param($vars){
	// if( isset( $vars['orderby'] ) && 'avelage' === $vars['orderby'] ) {
	// $vars = array_merge(
	// $vars,
	// array(
	// 'meta_key' => 'avelage',
	// 'orderby' => 'meta_value', //対象が文字列の場合は「meta_value」を指定
	// )
	// );
	// }
	// return $vars;
	// }

	/**
	 * DashBoard Widget 返却時間24h以内の書籍
	 */
	public function add_dashboard_widgets() {
		wp_add_dashboard_widget(
			'return_books_24', // ウィジェットのスラッグ名
			'返却24h以内の書籍', // ウィジェットに表示するタイトル
			array( $this, 'return_books_24_func' ) // 実行する関数
		);
	}

	/**
	 *
	 */
	public function return_books_24_func() {
		$now_date = ( new DateTime() )->setTimezone( new DateTimeZone( 'Asia/Tokyo' ) )->format( 'Y-m-d H:i' );
		$plus_one = ( new DateTime() )->setTimezone( new DateTimeZone( 'Asia/Tokyo' ) )->modify( '+1 days' )->format( 'Y-m-d H:i' );

		// applog( 't:' . $plus_one );
		// applog( 'current:' . get_current_user_id() );

		$arg = array(
			'post_type' => 'books',
		);

		$the_query = new WP_Query( $arg );

		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) :

				$the_query->the_post();

				// Administrator or レビュアーで自分レンタル書籍 なら.
				if (
					current_user_can( 'administrator' ) ||
					( current_user_can( 'reviewer3' ) && get_field( 'rental_user' ) == get_current_user_id() )
				) {

					$return_date = get_field( 'return_date' );

					if ( $return_date >= $now_date && $return_date <= $plus_one ) {
						the_title( '<h2><a href="' . get_edit_post_link() . '">', '</a></h2>', true );
					}
				}

			endwhile;
		endif;

		wp_reset_postdata();

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
