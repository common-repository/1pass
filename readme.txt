=== 1Pass ===
Contributors: 1pass, duncanjbrown
Tags: paywalls, single-article-sales
Requires at least: 4.0
Tested up to: 4.5
Stable tag: 1.1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sell articles from any WordPress website instantly

== Description ==

[1Pass](https://1pass.me) is a simple and robust plug-in for selling digital content instantly from your WordPress site.

The 1Pass plugin allows you to place “buy” buttons anywhere on your posts and pages.

You receive 70% of gross sales revenues via PayPal.

1Pass retains 30% of gross sales revenues, out of which we pay all transaction costs and applicable taxes. There are no other charges or fees for using 1Pass.

You can track your sales in real time on your 1Pass publisher dashboard.

To start taking money you need a free API key from our website: [https://1pass.me/publisher-signup](https://1pass.me/publisher-signup)

More documentation here: [https://1pass.me/1pass-for-wordpress](https://1pass.me/1pass-for-wordpress)

Email questions: support@1pass.me.

Custom support available for large and complex sites: duncan@1pass.me.

== Installation ==

1. Upload the `/1pass-for-wordpress` folder to the `wp-content/plugins` directory
2. Activate
3. Add your API keys to the 1Pass settings page. Get keys from [https://1pass.me](https://1pass.me).

== Screenshots ==

1. The 1Pass button in situ on an article page
2. A user tops up their account on the 1Pass service
3. The 1Pass settings page

== Changelog ==

= 1.1.5 =

Update documentation. Add 1Pass as an author.

= 1.1.4 =

Ensure GUIDs are always html-decoded by the time they appear in the feed or on
the page. Workaround for https://core.trac.wordpress.org/ticket/24248.

= 1.1.3 =

Custom Post Types were not appearing in the Atom feed. They do now.

= 1.1.2 =

Easy configuration. Copy and paste your API keys into the plugin with a couple of clicks.

= 1.1.1 =

Fix bug where 1Pass was not automatically enabled

= 1.1.0 =

Remodel settings page
Use 'Read More' instead of the `[1pass]` shortcode
Fix issue with WooCommerce

= 1.0.3 =
Fix issue with conflicting README.md and readme.txt

= 1.0.1 =
Depend on the [1Pass-Common PHP library](https://github.com/1Pass/1pass-common)

= 0.3 =
* Add custom Atom template

= 0.2 =
* Add demo mode

= 0.1 =
* Initial release
