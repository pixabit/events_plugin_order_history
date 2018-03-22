<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.netpyx.net/
 * @since      1.0.0
 *
 * @package    Event_calender_extension
 * @subpackage Event_calender_extension/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Event_calender_extension
 * @subpackage Event_calender_extension/admin
 * @author     Event Calender Extension <netpyx@gmail.com>
 */
class Event_calender_extension_Admin {

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

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Event_calender_extension_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_calender_extension_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/event_calender_extension-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Event_calender_extension_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_calender_extension_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/event_calender_extension-admin.js', array( 'jquery' ), $this->version, false );

	}


}


function get_passed_event() {
	add_menu_page('Event', 'Old Events List', '1', 'passed-event-list', 'get_passed_event_call', null,6);
}
add_action('admin_menu', 'get_passed_event');

function get_passed_event_call(){
	$dir2 = plugin_dir_path( __FILE__ ) . "passed-event-list.php";
	require_once $dir2;  
}


/*function get_passed_event2() {
	add_menu_page( 'Events', 'Old Events', 'manage_options', '#', 'get_passed_event_call', null, 7);
	//add_submenu_page('#', '', 'Old Event List', 'manage_options', '/edit.php?post_type=tribe_events&id=edit-tribe_events');
    add_submenu_page('#', '', 'Old Event List', 'manage_options', '/admin.php?page=passed-event-list&post_type=tribe_events');
}
add_action( 'admin_menu', 'get_passed_event2' );*/



/*add_action('admin_menu', 'wpse149688');
function wpse149688(){
    add_menu_page( 'Events', 'Old Events', 'manage_options', '#', '');
    add_submenu_page( '#', 'Old Event List', 'Old Event List', 'manage_options', 'edit.php?post_type=tribe_events', '', '7' ); 
}*/




