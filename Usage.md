#1Pass for WordPress

[![Build Status](https://travis-ci.org/1Pass/1pass-for-wordpress.svg?branch=master)](https://travis-ci.org/1Pass/1pass-for-wordpress)

##About 1Pass

1Pass is a button that lets you sell individual articles. This plugin makes it easy to add the button to your WordPress site.

To use the plugin, you need a set of 1Pass API credentials. These are free. To get them, enter your email at 1pass.me/publisher-signup.

####Initial setup

On activating the plugin, you'll find a new 1Pass section in your dashboard. Enter your 1Pass API keys.

####Enabling a post for 1Pass

When you visit the 'Edit Post' screen you'll find an 'Available on 1Pass' block on the right.

Tick that box to make the piece available on 1Pass.

##Using 1Pass to control access to your content

If your content is currently free-to-air, you can use the 1Pass plugin to control access. Tick the 'Restrict your content with 1Pass' box on the settings page.

Once this setting is checked, you can lock up a piece by ticking the 1Pass checkbox for that piece and adding the `[1pass]` shortcode into the body copy. This will result in the article being truncated at that point and the 1Pass button being injected.

##Other

####Logo
The plugin provides a 1Pass logo for illustrating posts available on 1Pass:

    <img src="<?php echo onepass_get_logo_src(); ?>" width="100" height="100" title="Available on 1Pass" />

####Restricting access

This section applies only if you're using 1Pass to restrict access to your content.

By default, all logged-out users will see articles truncated at `[1pass]`.

If you'd like to change this rule, or add your own, use the `onepass_restrictions` hook.

To remove the default behaviour:

    add_action( 'plugins_loaded', function() {
        remove_action( 'onepass_restrictions', 'onepass_reject_logged_out_users' );
    });

Adding a new restrictions, for example to show 1Pass only to users with the role 'subscriber':

    add_action( 'onepass_restrictions', 'onepass_reject_subscribers' );

    function onepass_reject_subscribers() {
        // returning true from this function will cause the button to show
        return current_user_can( 'subscriber' );
    }


####Manually displaying the 1Pass button

If you already have a paywall, you can display the button from your page template by placing the `<?php onepass(); ?>` tag in `single.php` (or equivalent).

The function `is_onepass()` will tell you whether or not the current post has the 1Pass box ticked. It optionally takes a `$post` object as an argument.

An simple integration might look like this:

    if( is_onepass() ) {
      onepass();
    }

##Support

Email support@1pass.me.

##Development

This plugin uses [Composer](https://getcomposer.org/) modules; if you wish to build and use plugin from GitHub, you need to first:

- [install Composer locally](https://getcomposer.org/doc/00-intro.md)
- fetch the runtime dependencies (using `composer install --no-dev`)

##System requirements

PHP 5.4
