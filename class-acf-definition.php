<?php
/**
 * Requires PHP: 7.2
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description:
 *
 * @author Your name
 * @license https://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @package WordPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Wp10_Sample
 *
 * This class represents a sample plugin for WordPress.
 */
class Wp10_Acf_Definition {
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
		// echo 'aaa';
		// exit;

		add_action( 'acf/include_fields', array( $this, 'acf_set_include_field' ) );

		add_action( 'init', array( $this, 'acf_set_post_type' ) );

	}

	/**
	 *
	 */
	public function acf_set_include_field() {

		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'                   => 'group_647db0a874806',
				'title'                 => 'Books fields',
				'fields'                => array(
					array(
						'key'               => 'field_647db0a8d831e',
						'label'             => 'タイトルタイトルタイトル',
						'name'              => 'book_title',
						'aria-label'        => '',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'maxlength'         => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
					),
					array(
						'key'               => 'field_647e999bd5eae',
						'label'             => '出版社',
						'name'              => 'publish_company',
						'aria-label'        => '',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'publish_company',
						),
						'post_status'       => '',
						'taxonomy'          => '',
						'return_format'     => 'id',
						'multiple'          => 0,
						'allow_null'        => 0,
						'ui'                => 1,
					),
					array(
						'key'               => 'field_647e99c5d5eaf',
						'label'             => '発売日',
						'name'              => 'sell_date',
						'aria-label'        => '',
						'type'              => 'date_picker',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'display_format'    => 'Y-m-d',
						'return_format'     => 'Y-m-d',
						'first_day'         => 0,
					),
					array(
						'key'               => 'field_647e9a42bc414',
						'label'             => '画像',
						'name'              => 'book_img',
						'aria-label'        => '',
						'type'              => 'image',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'array',
						'library'           => 'all',
						'min_width'         => '',
						'min_height'        => '',
						'min_size'          => '',
						'max_width'         => '',
						'max_height'        => '',
						'max_size'          => '',
						'mime_types'        => '',
						'preview_size'      => 'medium',
					),
					array(
						'key'               => 'field_647e9a7fbc415',
						'label'             => '商品URL',
						'name'              => 'book_url',
						'aria-label'        => '',
						'type'              => 'url',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
					),
					array(
						'key'               => 'field_647e9a97bc416',
						'label'             => '著者',
						'name'              => 'writer',
						'aria-label'        => '',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'book_writer',
						),
						'post_status'       => '',
						'taxonomy'          => '',
						'return_format'     => 'object',
						'multiple'          => 0,
						'allow_null'        => 0,
						'ui'                => 1,
					),
					array(
						'key'               => 'field_647e9aa6bc417',
						'label'             => '登録ナンバー',
						'name'              => 'book_num',
						'aria-label'        => '',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'maxlength'         => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
					),
					array(
						'key'               => 'field_648028f92292a',
						'label'             => 'レンタル社員',
						'name'              => 'rental_user',
						'aria-label'        => '',
						'type'              => 'user',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'role'              => array(
							0 => 'reviewer3',
						),
						'return_format'     => 'id',
						'multiple'          => 0,
						'allow_null'        => 0,
					),
					array(
						'key'               => 'field_6480293c2292b',
						'label'             => '返却日時',
						'name'              => 'return_date',
						'aria-label'        => '',
						'type'              => 'date_time_picker',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'display_format'    => 'Y-m-d H:i',
						'return_format'     => 'Y-m-d H:i',
						'first_day'         => 0,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'books',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => array(
					0 => 'the_content',
					1 => 'author',
					2 => 'featured_image',
					3 => 'categories',
					4 => 'tags',
				),
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 0,
			)
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_647ea24da916e',
				'title'                 => 'Impression fields',
				'fields'                => array(
					array(
						'key'               => 'field_647ea24d01025',
						'label'             => '感想のタイトル',
						'name'              => 'impression_title',
						'aria-label'        => '',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'maxlength'         => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
					),
					array(
						'key'               => 'field_647ea405719f1',
						'label'             => '感想を書く本',
						'name'              => 'impression_target_book',
						'aria-label'        => '',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'books',
						),
						'post_status'       => '',
						'taxonomy'          => '',
						'return_format'     => 'object',
						'multiple'          => 0,
						'allow_null'        => 0,
						'ui'                => 1,
					),
					array(
						'key'               => 'field_647ea2d401027',
						'label'             => '感想',
						'name'              => 'impression_text',
						'aria-label'        => '',
						'type'              => 'textarea',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'maxlength'         => 1000,
						'rows'              => '',
						'placeholder'       => '',
						'new_lines'         => '',
					),
					array(
						'key'               => 'field_647ea2f301028',
						'label'             => '評価',
						'name'              => 'impression_point',
						'aria-label'        => '',
						'type'              => 'select',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => array(
							1 => '1',
							2 => '2',
							3 => '3',
							4 => '4',
							5 => '5',
						),
						'default_value'     => false,
						'return_format'     => 'value',
						'multiple'          => 0,
						'allow_null'        => 0,
						'ui'                => 0,
						'ajax'              => 0,
						'placeholder'       => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'impression',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'seamless',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => array(
					0 => 'the_content',
					1 => 'featured_image',
					2 => 'categories',
					3 => 'tags',
				),
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 0,
			)
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_648680c344cf6',
				'title'                 => 'Publish Field',
				'fields'                => array(
					array(
						'key'               => 'field_648680c381401',
						'label'             => '出版社名',
						'name'              => 'publish_company',
						'aria-label'        => '',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'maxlength'         => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'publish_company',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => array(
					0 => 'the_content',
					1 => 'comments',
					2 => 'featured_image',
				),
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 0,
			)
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_64868123c05f4',
				'title'                 => 'Writer Field',
				'fields'                => array(
					array(
						'key'               => 'field_64868123f013a',
						'label'             => '著者名',
						'name'              => 'book_writer',
						'aria-label'        => '',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'maxlength'         => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
					),
					array(
						'key'               => 'field_64868151f013b',
						'label'             => '出版社名',
						'name'              => 'writer_publish',
						'aria-label'        => '',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'publish_company',
						),
						'post_status'       => '',
						'taxonomy'          => '',
						'return_format'     => 'object',
						'multiple'          => 0,
						'allow_null'        => 0,
						'ui'                => 1,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'book_writer',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => array(
					0 => 'the_content',
					1 => 'comments',
					2 => 'featured_image',
				),
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 0,
			)
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_writer_field_2',
				'title'                 => 'Writer Field 2',
				'fields'                => array(
					array(
						'key'               => 'group_writer_field_2a',
						'label'             => 'ライター222',
						'name'              => 'writer_222',
						'aria-label'        => '',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'maxlength'         => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'book_writer',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 0,
			)
		);

	}


	/**
	 *
	 */
	public function acf_set_post_type() {
		register_post_type(
			'books',
			array(
				'labels'           => array(
					'name'                     => 'Books',
					'singular_name'            => 'Books',
					'menu_name'                => 'Books',
					'all_items'                => 'Books一覧',
					'edit_item'                => 'Edit Book',
					'view_item'                => 'View Book',
					'view_items'               => 'View Books',
					'add_new_item'             => 'Add New Book',
					'new_item'                 => 'New Book',
					'parent_item_colon'        => 'Parent Text:',
					'search_items'             => 'Search Text',
					'not_found'                => 'No text found',
					'not_found_in_trash'       => 'No text found in Trash',
					'archives'                 => 'Text Archives',
					'attributes'               => 'Text Attributes',
					'insert_into_item'         => 'Insert into text',
					'uploaded_to_this_item'    => 'Uploaded to this text',
					'filter_items_list'        => 'Filter text list',
					'filter_by_date'           => 'Filter text by date',
					'items_list_navigation'    => 'Text list navigation',
					'items_list'               => 'Text list',
					'item_published'           => 'Text published.',
					'item_published_privately' => 'Text published privately.',
					'item_reverted_to_draft'   => 'Text reverted to draft.',
					'item_scheduled'           => 'Text scheduled.',
					'item_updated'             => 'Text updated.',
					'item_link'                => 'Text Link',
					'item_link_description'    => 'A link to a text.',
				),
				'public'           => true,
				'show_in_rest'     => true,
				'supports'         => array(
					0 => 'title',
					1 => 'editor',
					2 => 'thumbnail',
				),
				'delete_with_user' => false,
			)
		);

		register_post_type(
			'impression',
			array(
				'labels'           => array(
					'name'                     => 'Impression',
					'singular_name'            => 'Impression',
					'menu_name'                => 'Impression',
					'all_items'                => 'All Impression',
					'edit_item'                => 'Edit Impression',
					'view_item'                => 'View Impression',
					'view_items'               => 'View Impression',
					'add_new_item'             => 'Add New Impression',
					'new_item'                 => 'New Impression',
					'parent_item_colon'        => 'Parent Impression:',
					'search_items'             => 'Search Impression',
					'not_found'                => 'No impression found',
					'not_found_in_trash'       => 'No impression found in Trash',
					'archives'                 => 'Impression Archives',
					'attributes'               => 'Impression Attributes',
					'insert_into_item'         => 'Insert into impression',
					'uploaded_to_this_item'    => 'Uploaded to this impression',
					'filter_items_list'        => 'Filter impression list',
					'filter_by_date'           => 'Filter impression by date',
					'items_list_navigation'    => 'Impression list navigation',
					'items_list'               => 'Impression list',
					'item_published'           => 'Impression published.',
					'item_published_privately' => 'Impression published privately.',
					'item_reverted_to_draft'   => 'Impression reverted to draft.',
					'item_scheduled'           => 'Impression scheduled.',
					'item_updated'             => 'Impression updated.',
					'item_link'                => 'Impression Link',
					'item_link_description'    => 'A link to a impression.',
				),
				'public'           => true,
				'show_in_rest'     => true,
				'supports'         => array(
					0 => 'title',
					1 => 'editor',
					2 => 'thumbnail',
				),
				'delete_with_user' => false,
			)
		);

		register_post_type(
			'publish_company',
			array(
				'labels'           => array(
					'name'                     => 'Publish',
					'singular_name'            => 'Publish',
					'menu_name'                => 'Publish',
					'all_items'                => 'All Publish',
					'edit_item'                => 'Edit Publish',
					'view_item'                => 'View Publish',
					'view_items'               => 'View Publish',
					'add_new_item'             => 'Add New Publish',
					'new_item'                 => 'New Publish',
					'parent_item_colon'        => 'Parent Publish:',
					'search_items'             => 'Search Publish',
					'not_found'                => 'No publish found',
					'not_found_in_trash'       => 'No publish found in Trash',
					'archives'                 => 'Publish Archives',
					'attributes'               => 'Publish Attributes',
					'insert_into_item'         => 'Insert into publish',
					'uploaded_to_this_item'    => 'Uploaded to this publish',
					'filter_items_list'        => 'Filter publish list',
					'filter_by_date'           => 'Filter publish by date',
					'items_list_navigation'    => 'Publish list navigation',
					'items_list'               => 'Publish list',
					'item_published'           => 'Publish published.',
					'item_published_privately' => 'Publish published privately.',
					'item_reverted_to_draft'   => 'Publish reverted to draft.',
					'item_scheduled'           => 'Publish scheduled.',
					'item_updated'             => 'Publish updated.',
					'item_link'                => 'Publish Link',
					'item_link_description'    => 'A link to a publish.',
				),
				'public'           => true,
				'show_in_rest'     => true,
				'supports'         => array(
					0 => 'title',
					1 => 'editor',
					2 => 'thumbnail',
				),
				'delete_with_user' => false,
			)
		);

		register_post_type(
			'book_writer',
			array(
				'labels'           => array(
					'name'                     => 'Writer',
					'singular_name'            => 'Writer',
					'menu_name'                => 'Writer',
					'all_items'                => 'All Writer',
					'edit_item'                => 'Edit Writer',
					'view_item'                => 'View Writer',
					'view_items'               => 'View Writer',
					'add_new_item'             => 'Add New Writer',
					'new_item'                 => 'New Writer',
					'parent_item_colon'        => 'Parent Writer:',
					'search_items'             => 'Search Writer',
					'not_found'                => 'No writer found',
					'not_found_in_trash'       => 'No writer found in Trash',
					'archives'                 => 'Writer Archives',
					'attributes'               => 'Writer Attributes',
					'insert_into_item'         => 'Insert into writer',
					'uploaded_to_this_item'    => 'Uploaded to this writer',
					'filter_items_list'        => 'Filter writer list',
					'filter_by_date'           => 'Filter writer by date',
					'items_list_navigation'    => 'Writer list navigation',
					'items_list'               => 'Writer list',
					'item_published'           => 'Writer published.',
					'item_published_privately' => 'Writer published privately.',
					'item_reverted_to_draft'   => 'Writer reverted to draft.',
					'item_scheduled'           => 'Writer scheduled.',
					'item_updated'             => 'Writer updated.',
					'item_link'                => 'Writer Link',
					'item_link_description'    => 'A link to a writer.',
				),
				'public'           => true,
				'show_in_rest'     => true,
				'supports'         => array(
					0 => 'title',
					1 => 'editor',
					2 => 'thumbnail',
				),
				'delete_with_user' => false,
			)
		);
	}

}
