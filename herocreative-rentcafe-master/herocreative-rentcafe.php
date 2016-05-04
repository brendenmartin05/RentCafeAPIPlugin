<?php

/*
 *	Plugin Name: Hero Creative Media RentCafe Integration
 *	Plugin URI: http://heroreativemedia.com
 *	Description: Provides apartment communities to pull in prices, availability and floor
 *  plans for property.
 *	Version: 1.0
 *	Author: Brenden Martin, Brian Hague
 *	Author URI: http://herocreativemedia.com
 *	License: GPL2
 *
*/

/*
 *	Add a link to our plugin in the admin menu
 *	under 'Settings > Treehouse Badges'
 *
*/

function herocreative_rentcafe_menu() {

	/*
	 * 	Use the add_options_page function
	 * 	add_options_page( $page_title, $menu_title, $capability, $menu-slug, $function )
	 *
	*/

	add_options_page(
		'Official RentCafe Integration Plugin',
		'RentCafe Integration',
		'manage_options',
		'herocreative-rentcafe',
		'herocreative_rentcafe_options_page'
	);
}
add_action( 'admin_menu', 'herocreative_rentcafe_menu' );

function herocreative_rentcafe_options_page() {
	$display_json = true;
  $form_post = false;

	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have suggicient permissions to access this page.' );
	}

	if( isset( $_POST['herocreative_form_submitted'] ) ) {

		$hidden_field = esc_html( $_POST['herocreative_form_submitted'] );

		if( $hidden_field == 'Y' ) {
      $form_post = true;

			$rentcafe_company_code = esc_html( $_POST['rentcafe_company_code'] );
			$rentcafe_property_code = esc_html( $_POST['rentcafe_property_code'] );

			$property_data = herocreative_rentcafe_get_data( $rentcafe_company_code, $rentcafe_property_code );

			update_option( 'rentcafe_company_code', $rentcafe_company_code );
			update_option( 'rentcafe_property_code', $rentcafe_property_code );
		}
	}

	$rentcafe_company_code = get_option( 'rentcafe_company_code' );
	$rentcafe_property_code = get_option( 'rentcafe_property_code' );
	$property_data = 	herocreative_rentcafe_get_data( $rentcafe_company_code, $rentcafe_property_code );

	include( sprintf( '%s/includes/options-page-wrapper.php', dirname(__FILE__) ) );
}

// API call to RentCafe
function herocreative_rentcafe_get_data( $rentcafe_company_code, $rentcafe_property_code ) {
	if ( !($rentcafe_company_code && $rentcafe_property_code) ) {
		return false;
	}

	$qs = array('requestType' => 'floorplan',
							'companyCode' => $rentcafe_company_code,
							'propertyCode' => $rentcafe_property_code);

	$json_feed_url = 'https://api.rentcafe.com/rentcafeapi.aspx?' . http_build_query($qs);
	$json_feed = wp_remote_get( $json_feed_url, array( 'timeout' => 120 ) );
	$property_data = json_decode( $json_feed['body'] );
	return $property_data;
}

// Shortcode for the RentCafe data
function rentcafe_shortcode( $atts ){
	$rentcafe_company_code = get_option( 'rentcafe_company_code' );
	$rentcafe_property_code = get_option( 'rentcafe_property_code' );
	$property_data = 	herocreative_rentcafe_get_data( $rentcafe_company_code, $rentcafe_property_code );

	herocreative_rent_cafe_css_js();

	ob_start();
	include( sprintf( '%s/includes/rentcafe-template.php', dirname(__FILE__) ) );
  return ob_get_clean();
}
add_shortcode( 'rentcafe', 'rentcafe_shortcode' );

function herocreative_rent_cafe_css_js() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');

	wp_register_script('herocreative_custom_js', plugins_url( 'public/js/script.js', __FILE__ ), array('jquery', 'jquery-ui-tabs') );
	wp_enqueue_script('herocreative_custom_js');

	wp_register_style('herocreative_custom_style', plugins_url( 'public/css/style.css', __FILE__ ) );
	wp_enqueue_style('herocreative_custom_style');
}
add_action( 'admin_init','herocreative_rent_cafe_css_js' );

?>
