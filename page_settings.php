<?php
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function cfapi_settings_init() {
 // register a new setting for "cfapi" page
 register_setting( 'cfapi', 'cfapi_bot_id' );
 register_setting( 'cfapi', 'cfapi_bot_token' );
 
 // register a new section in the "cfapi" page
 add_settings_section(
 'cfapi_section_developers',
 'Chatfuel Woocommerce API',
 'cfapi_section_developers_cb',
 'cfapi'
 );
 
 add_settings_field(
 'cfapi_field_bot_id',
 'Bot ID',
 'cfapi_field_bot_field_cb',
 'cfapi',
 'cfapi_section_developers',
  array('cfapi_bot_id')
 );

 add_settings_field(
 'cfapi_field_bot_token',
 'Bot Token',
 'cfapi_field_bot_field_cb',
 'cfapi',
 'cfapi_section_developers',
  array('cfapi_bot_token')
 );
}
 
/**
 * register our cfapi_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'cfapi_settings_init' );
 
/**
 * custom option and settings:
 * callback functions
 */
 
// developers section cb
 
// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function cfapi_section_developers_cb( $args ) {
 ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>">Settings</p>
 <?php
}
 
function cfapi_field_bot_field_cb( $args ) {
 $cfapi_val = get_option( $args[0] );
 ?>
 <input name="<?php echo $args[0]; ?>" value="<?php echo esc_attr($cfapi_val); ?>" />
 <?php
}
 
/**
 * top level menu
 */
function cfapi_options_page() {
 // add top level menu page
 add_menu_page(
 'cfapi',
 'Chatfuel API',
 'manage_options',
 'cfapi',
 'cfapi_options_page_html'
 );
}
 
/**
 * register our cfapi_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'cfapi_options_page' );
 
/**
 * top level menu:
 * callback functions
 */
function cfapi_options_page_html() {
 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }
 
 // add error/update messages
 
 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
 if ( isset( $_GET['settings-updated'] ) ) {
 // add settings saved message with the class of "updated"
 add_settings_error( 'cfapi_messages', 'cfapi_message', __( 'Settings Saved', 'cfapi' ), 'updated' );
 }
 
 // show error/update messages
 settings_errors( 'cfapi_messages' );
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form action="options.php" method="post">
 <?php
 // output security fields for the registered setting "cfapi"
 settings_fields( 'cfapi' );
 // output setting sections and their fields
 // (sections are registered for "cfapi", each field is registered to a specific section)
 do_settings_sections( 'cfapi' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>
 </div>
 <?php
}