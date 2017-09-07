<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Bp_Groups_Export_Import
 * @subpackage Bp_Groups_Export_Import/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bp_Groups_Export_Import
 * @subpackage Bp_Groups_Export_Import/admin
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Bp_Groups_Export_Import_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if( stripos( $_SERVER['REQUEST_URI'], $this->plugin_name ) ) {
			wp_enqueue_style( $this->plugin_name.'font-awesome', BPGEI_PLUGIN_URL . 'admin/css/font-awesome.min.css' );
			wp_enqueue_style( $this->plugin_name.'selectize-css', BPGEI_PLUGIN_URL . 'admin/css/selectize.css' );
			wp_enqueue_style( $this->plugin_name, BPGEI_PLUGIN_URL . 'admin/css/bp-groups-export-import-admin.css' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if( stripos( $_SERVER['REQUEST_URI'], $this->plugin_name ) ) {
			wp_enqueue_script( $this->plugin_name.'-selectize', BPGEI_PLUGIN_URL . 'admin/js/selectize.min.js', array( 'jquery' ) );
			wp_enqueue_script( $this->plugin_name.'-xls-export', BPGEI_PLUGIN_URL . 'admin/js/excelexportjs.js', array( 'jquery' ) );
			wp_enqueue_script( $this->plugin_name, BPGEI_PLUGIN_URL . 'admin/js/bp-groups-export-import-admin.js', array( 'jquery' ) );

			wp_localize_script(
				$this->plugin_name,
				'bpgei_admin_js_object',
				array(
					'ajaxurl'		=> admin_url('admin-ajax.php')
				)
			);
		}

	}

	/**
	 * Register a settings page to handle groups export import settings
	 *
	 * @since    1.0.0
	 */
	public function bpgei_add_settings_page() {
		add_options_page( __( 'BuddyPress Groups Export/Import Settings', BPGEI_TEXT_DOMAIN ), __( 'Groups Export/Import', BPGEI_TEXT_DOMAIN ), 'manage_options', $this->plugin_name, array( $this, 'bpgei_admin_settings_page' ) );
	}

	/**
	 * Actions performed to create a settings page content
	 */
	public function bpgei_admin_settings_page() {
		$tab = isset($_GET['tab']) ? $_GET['tab'] : $this->plugin_name;
		?>
		<div class="wrap">
			<div class="bpgei-header">
				<h2 class="bpgei-plugin-heading"><?php _e( 'BuddyPress Groups Export & Import', BPGEI_TEXT_DOMAIN );?></h2>
				<div class="bpgei-extra-actions">
					<button type="button" class="button button-secondary" onclick="window.open('https://wbcomdesigns.com/contact/', '_blank');"><i class="fa fa-envelope" aria-hidden="true"></i> <?php _e( 'Email Support', BPGEI_TEXT_DOMAIN )?></button>
					<button disabled type="button" class="button button-secondary" onclick="window.open('', '_blank');"><i class="fa fa-file" aria-hidden="true"></i> <?php _e( 'User Manual', BPGEI_TEXT_DOMAIN )?></button>
					<button disabled type="button" class="button button-secondary" onclick="window.open('', '_blank');"><i class="fa fa-star" aria-hidden="true"></i> <?php _e( 'Rate Us on WordPress.org', BPGEI_TEXT_DOMAIN )?></button>
				</div>
			</div>
			<?php $this->bpgei_plugin_settings_tabs();?>
			<?php do_settings_sections( $tab );?>
		</div>
		<?php
	}

	/**
	 * Actions performed to create tabs on the sub menu page
	 */
	public function bpgei_plugin_settings_tabs() {
		$current_tab = isset($_GET['tab']) ? $_GET['tab'] : $this->plugin_name;
		echo '<h2 class="nav-tab-wrapper">';
		foreach ($this->plugin_settings_tabs as $tab_key => $tab_caption) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" id="' . $tab_key . '-tab" href="?page=' . $this->plugin_name . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
		echo '</h2>';
	}

	/**
	 * Groups Export Tab
	 */
	public function bpgei_register_bp_groups_export_settings() {
		$this->plugin_settings_tabs[$this->plugin_name] = __( 'Export', BPGEI_TEXT_DOMAIN );
		register_setting($this->plugin_name, $this->plugin_name);
		add_settings_section('bp-groups-export-import-section', ' ', array(&$this, 'bpgei_export_settings_content'), $this->plugin_name );
	}

	/**
	 * Groups Export Tab Content
	 */
	public function bpgei_export_settings_content() {
		if (file_exists(dirname(__FILE__) . '/includes/bp-groups-export-settings.php')) {
			require_once( dirname(__FILE__) . '/includes/bp-groups-export-settings.php' );
		}
	}

	/**
	 * Groups Import Tab
	 */
	public function bpgei_register_bp_groups_import_settings() {
		$this->plugin_settings_tabs['bp-groups-import'] = __( 'Import', BPGEI_TEXT_DOMAIN );
		register_setting('bp-groups-import', 'bp-groups-import');
		add_settings_section('bp-groups-import-section', ' ', array(&$this, 'bpgei_import_settings_content'), 'bp-groups-import');
	}

	/**
	 * Groups Import Tab Content
	 */
	public function bpgei_import_settings_content() {
		if (file_exists(dirname(__FILE__) . '/includes/bp-groups-import-settings.php')) {
			require_once( dirname(__FILE__) . '/includes/bp-groups-import-settings.php' );
		}
	}

	/**
	 * Support Tab
	 */
	public function bpgei_register_support_settings() {
		$this->plugin_settings_tabs['bpgei-support'] = __( 'Support', BPGEI_TEXT_DOMAIN );
		register_setting('bpgei-support', 'bpgei-support');
		add_settings_section('bpchk-support-section', ' ', array(&$this, 'bpgei_support_settings_content'), 'bpgei-support');
	}

	/**
	 * Support Tab Content
	 */
	public function bpgei_support_settings_content() {
		if (file_exists(dirname(__FILE__) . '/includes/bp-groups-export-import-support.php')) {
			require_once( dirname(__FILE__) . '/includes/bp-groups-export-import-support.php' );
		}
	}

	/**
	 * Ajax served, to export the groups
	 */
	public function bpgei_export_groups() {
		if( isset( $_POST['action'] ) && $_POST['action'] == 'bpgei_export_groups' ) {
			$g_status = array();
			if( !empty( $_POST['g_status'] ) ) {
				$g_status = wp_slash( $_POST['g_status'] );
			}

			$g_types = array();
			if( !empty( $_POST['g_types'] ) ) {
				$g_types = wp_slash( $_POST['g_types'] );
			}

			$bp_grp_args = array(
				'per_page'			=> 99999,
				'orderby'			=> 'date_created',
				'order'				=> 'DESC',
				'status'			=> $g_status,
				'group_type__in'	=> $g_types
			);
			$bp_groups = BP_Groups_Group::get( $bp_grp_args );
			$groups = $bp_groups['groups'];
			$bp_groups_data = array();
			foreach( $groups as $group ) {
				$forum_data = groups_get_groupmeta( $group->id, 'forum_id', true );
				$forum_id = $forum_name = '-';
				if( !empty( $forum_data ) ){
					$forum_id = $forum_data[0];
					$forum_name = $group->name;
				}

				//GROUP COVER IMAGE URL
				$group_cover_image_url = bp_attachments_get_attachment('url', array(
					'object_dir'	=>	'groups',
					'item_id'		=>	$group->id,
				));
				//GROUP THUMBNAIL
				$avatar = bp_core_fetch_avatar( array(
					'item_id'	=>	$group->id,
					'object'	=>	'group',
					'html'		=>	false
				) );

				$grp_invite_status = ucfirst( groups_get_groupmeta( $group->id, 'invite_status', true ) );
				$invite_status = !empty( $grp_invite_status ) ? $grp_invite_status : '-';

				$temp													=	array();
				$temp[__( 'Group ID', BPGEI_TEXT_DOMAIN )]				=	"$group->id";
				$temp[__( 'Group Name', BPGEI_TEXT_DOMAIN )]				=	$group->name;
				$temp[__( 'Group Description', BPGEI_TEXT_DOMAIN )]		=	$group->description;
				$temp[__( 'Group Status', BPGEI_TEXT_DOMAIN )]			=	ucfirst( $group->status );
				$temp[__( 'Group Created By', BPGEI_TEXT_DOMAIN )]		=	get_userdata( $group->creator_id )->data->user_login;
				$temp[__( 'Group Created On', BPGEI_TEXT_DOMAIN )]		=	explode(' ', $group->date_created)[0];
				$temp[__( 'Total Members', BPGEI_TEXT_DOMAIN )]			=	groups_get_groupmeta( $group->id, 'total_member_count', true );
				$temp[__( 'Is Forum Enabled', BPGEI_TEXT_DOMAIN )]		=	$group->enable_forum == 0 ? 'No' : 'Yes';
				$temp[__( 'Forum ID', BPGEI_TEXT_DOMAIN )]				=	$forum_id;
				$temp[__( 'Forum Name', BPGEI_TEXT_DOMAIN )]				=	$forum_name;
				$temp[__( 'Group Invite Status', BPGEI_TEXT_DOMAIN )]		=	$invite_status;
				$temp[__( 'Avatar', BPGEI_TEXT_DOMAIN )]				=	$avatar;
				$temp[__( 'Cover Image', BPGEI_TEXT_DOMAIN )]			=	$group_cover_image_url;
				$bp_groups_data[]										=	$temp;
			}

			$response = array(
				'message'			=>	__( 'Groups Exported!', BPGEI_TEXT_DOMAIN ),
				'groups_exported'	=>	'Groups exported: '.$bp_groups['total'],
				'groups'			=>	$bp_groups_data
			);
			wp_send_json_success( $response );
			die;
		}
	}

}
