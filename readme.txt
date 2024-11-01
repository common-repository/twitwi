=== Twitwi ===
Contributors: (xuxu.fr)
Donate link: http://goo.gl/SORljr
Tags: Twitter, Connect, API, User, Avatar, Widget
Requires at least: 4.6.1
Tested up to: 4.6.1
Stable tag: 1.11
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Another simple Twitter Connect for WordPress.

== Description ==

Twitwi, another simple Twitter Connect for WordPress.

Only the basic :

*   Login with a Twitter account
*   Create a WordPress user
*   Save locally on the server the Twitter picture's profile as an attachment
*   Shortcode or PHP Code to insert the Twitter Connect button wherever you want
*   Little widget for the sidebar

Page for the plugin : http://xuxu.fr/2013/12/30/twitwi-twitter-connect-basique-pour-wordpress/

You can help me buy some diapers ^_^ : http://goo.gl/SORljr

== Installation ==

1. Extract and upload the directory `twitwi` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Create a Twitter App to get an Consumer Key and an Consumer Secret.
4. Go to Settings -> Twitwi Config to setup Consumer Key and Consumer Secret.
5. Insert a shortcode or the PHP code where you want the Twitter connect button to appear.
6. Enjoy

== Frequently Asked Questions ==

= Why an domain default needed for the user email ? =

Twitter API does not allow us to get the email user (like Facebook API). So you need to set a default domain name to create a temporary email so that the Wordpress Account can be created.

== Screenshots ==

1. Setting the Consumer Key, Consumer Secret, default role for the user created, be notified by email or not, and default domain for the email used for the wordpress user created.
2. Shortcode to put a Twitter Connect Button in a post or page content.
3. Example of button insert with a shortcode.
4. PHP code to insert the Twitter Connect Button where you want.
5. Widget Sidebar : Configuration.
6. Widget Sidebar : Connected.
7. The Twitter profile's picture is saved as a media file.
8. Users created with default domain mail set in the config step #1.

== Changelog ==

= 1.11 =
1. Fix bug Twitter authentication

= 1.10 =
1. Update Twitteroauth to last version (2016/10/16)
2. Translate ready!
3. Add French translations
4. Clean Boobook options on uninstall
5. Can change shortcode and widget button labels
6. Update avatar if needed
7. Refactoring code

= 1.03 =
1. Add include entities in some hook

= 1.02 =
1. Set include entities in option

= 1.01 =
1. Fix bug avatar creation

= 1.00 =
1. Hello world!

== Upgrade Notice ==

= 1.11 =
1. Each time you log in, Twitter asks you to anthenticate again. Problem solved by using "oauth/authenticate" instead of "oauth/authorize"

= 1.10 =
1. Update Twitteroauth to last version (2016/10/16)
2. Settings, widget and shortcode labels can be translated
3. French language added
4. Delete options on plugin uninstall
5. You can change the label of the Twitter button connect in the widget and the shortcode
6. Update the avatar if this one changed since last visit
7. Miscellaneous updates

= 1.03 =
1. Add include entities details in some hook when you connect

= 1.02 =
1. Set include entities in option to get more details when you connect with your twitter account

= 1.01 =
1. Fix a bug when you change the avatar on Twitter. The old image was replaced by the new one. Now both are saved correctly.

= 1.00 =
1. Welcome!