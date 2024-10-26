<?php
/*
Plugin Name: 1Pass
Version: 1.1.5
Description: Activate, then configure using the 1Pass link in the admin menu to the left.
Author: 1Pass
Author URI: https://1pass.me
*/

define( 'ONEPASS_PLUGIN_VERSION', "1.1.5" );

define( 'ONEPASS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ONEPASS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

include( ONEPASS_PLUGIN_DIR . '/vendor/autoload.php' );

include( ONEPASS_PLUGIN_DIR . 'lib/settings.php' );
include( ONEPASS_PLUGIN_DIR . 'lib/functions.php' );
include( ONEPASS_PLUGIN_DIR . 'lib/taxonomy.php' );
include( ONEPASS_PLUGIN_DIR . 'lib/authentication.php' );
include( ONEPASS_PLUGIN_DIR . 'lib/init.php' );
include( ONEPASS_PLUGIN_DIR . 'lib/button/button.php' );
include( ONEPASS_PLUGIN_DIR . 'lib/restrict-content/restrict-content.php' );
include( ONEPASS_PLUGIN_DIR . 'lib/atom/atom.php' );

include( ONEPASS_PLUGIN_DIR . 'lib/activation.php' );
register_activation_hook( __FILE__, 'onepass_default_options' );
register_activation_hook( __FILE__, 'onepass_flush_rewrite_rules' );
register_activation_hook( __FILE__, 'onepass_enable_all_posts' );

add_action('admin_notices', function() {
	if( !onepass_is_set_up() && !is_onepass_settings_page() ) {
		$settings_link = 'admin.php?page=onepass_settings_page';
		echo "<div class='notice updated is-dismissable'><p>Configure 1Pass at the <a href='${settings_link}'>settings page</a></p></div>";
	}
});
