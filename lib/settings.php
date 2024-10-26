<?php

/**
 * Configure and display a generic settings page for 1Pass
 *
 * This page handles API keys, Live/Test environment, and the choice
 * whether to use 1Pass to restrict content.
 */

add_action( 'admin_menu', 'onepass_add_admin_menu' );
add_action( 'admin_init', 'onepass_settings_init' );

function is_onepass_settings_page() {
	global $pagenow;
	return ($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == 'onepass_settings_page');
}

function onepass_add_admin_menu() {
    add_menu_page(
        '1Pass',
        '1Pass',
        'manage_options',
        'onepass_settings_page',
        function() {
            include( ONEPASS_PLUGIN_DIR . 'views/settings-page.php' );
        },
        'dashicons-arrow-right-alt'
    );
}

function onepass_settings_init() {

    register_setting( 'onepass_options', 'onepass_environment' );
    register_setting( 'onepass_options', 'onepass_use_content_restrictions' );

    if( onepass_is_test_environment() ) {
        register_setting( 'onepass', 'onepass_test_credentials' );
        add_settings_section(
            'onepass_test_credentials',
            '',
            null,
            'onepass_settings_page'
        );
        add_settings_field(
    		'onepass_test_publishable_id',
    		'Publishable key',
    		function() {
                $set = 'onepass_test_credentials';
                $option = get_option( $set );
                $value = isset( $option['publishable_key'] ) ? $option['publishable_key'] : false;
                include( ONEPASS_PLUGIN_DIR . 'views/settings/publishable-key.php' );
            },
    		'onepass_settings_page',
            'onepass_test_credentials'
    	);

        add_settings_field(
    		'onepass_test_secret_key',
    		'Secret key',
    		function() {
                $set = 'onepass_test_credentials';
                $option = get_option( $set );
                $value = isset( $option['secret_key'] ) ? $option['secret_key'] : false;
                include( ONEPASS_PLUGIN_DIR . 'views/settings/secret-key.php' );
            },
    		'onepass_settings_page',
            'onepass_test_credentials'
    	);
    } else {
        register_setting( 'onepass', 'onepass_live_credentials' );
        add_settings_section(
            'onepass_credentials',
            '',
            null,
            'onepass_settings_page'
        );

        add_settings_field(
    		'onepass_live_publishable_id',
    		'Publishable key',
    		function() {
                $set = 'onepass_live_credentials';
                $option = get_option( $set );
                $value = isset( $option['publishable_key'] ) ? $option['publishable_key'] : false;
                include( ONEPASS_PLUGIN_DIR . 'views/settings/publishable-key.php' );
            },
    		'onepass_settings_page',
            'onepass_credentials'
    	);

        add_settings_field(
    		'onepass_live_secret_key',
    		'Secret key',
    		function() {
                $set = 'onepass_live_credentials';
                $option = get_option( $set );
                $value = isset( $option['secret_key'] ) ? $option['secret_key'] : false;
                include( ONEPASS_PLUGIN_DIR . 'views/settings/secret-key.php' );
            },
    		'onepass_settings_page',
            'onepass_credentials'
    	);
    }

    add_settings_section(
        'onepass_options',
        '',
        '',
        'onepass_settings_options'
    );

    add_settings_field(
		'onepass_environment',
		'Select mode',
		function() {
            include( ONEPASS_PLUGIN_DIR . 'views/settings/select-environment.php' );
        },
		'onepass_settings_options',
        'onepass_options'
	);

    add_settings_field(
		'onepass_use_content_restrictions',
		'Automatically insert 1Pass buttons',
		function() {
            $option = get_option( 'onepass_use_content_restrictions' );?>
            <input type='checkbox' name='onepass_use_content_restrictions' <?php checked( $option, 'on' ); ?>>
            <p class="description">If this box is ticked, 1Pass buttons will appear automatically at the 'Read More' break.</p>
        <?php },
		'onepass_settings_options',
        'onepass_options'
    );

}

/**
 * Load a constant if it's defined
 *
 * @return mixed
 */
function onepass_load_constant( $key ) {
    if( defined( $key ) ) {
        return constant( $key );
    }  else {
        return false;
    }
}
