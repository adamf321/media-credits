=== Plugin Name ===
Contributors: adamf321
Donate link: https://www.paypal.me/solnamic
Tags: media, creative commons, images, media library, photos, credits, image credits, media credits
Author URI: https://solnamic.com
Plugin URI: https://solnamic.com/plugins/media-credits
Requires at least: 4.1
Tested up to: 4.3
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Upload accreditation info to media objects. Functions and a shortcode for accessing the formatted data. Great for developers and regular users alike.

== Description ==

Allows you to upload accreditation info to a media object and provides functions and a shortcode for accessing the data. Great for developers and regular users alike. This is required under the <a href="https://wiki.creativecommons.org/wiki/Best_practices_for_attribution" target="_blank">Creative Commons</a> license.

The plugin will add the following fields to the media object:

*   Original title: The original title of the media object
*   Source Link: Link to the original image
*   Author: Name of the author
*   Author Profile Link: Link to the author's profile page
*   License: Dropdown list of licenses

You can then output the information formatted according to the <a href="https://wiki.creativecommons.org/wiki/Best_practices_for_attribution" target="_blank">Creative Commons best practices</a> using the following methods:

*   Shortcode:  [mc_display_credits attachment_id="2345"]
*   Function:   echo mc_display_credits( $attachment_id );

You can also output the raw data as an array using the following function:

*   mc_credits_info( $$attachment_id );

Additionally there are several filters which you can use to customise the plugin:

*   mc_license_types: Alter the list of available license types
*   mc_attachment_fields: Alter the fields added to the media object in the library
*   mc_get_credit_info: Alter the results of the mc_credits_info() function
*   mc_display_credits: Alter the HTML output by the mc_display_credits shortcode or function


== Installation ==

1. Upload the media-credits folder to the /wp-content/plugins/ directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the shortcode to your content or function to you theme files


== Frequently Asked Questions ==

= What languages does the plugin support? =

English and Spanish. Contact us if you want to translate it into your language.

= How do I add an new license type to the dropdown? =

Add the following code to your theme's functions.php file:

```
function my_add_license_types( $license_types )
{
    $license_types['new-license-type'] = array(
        'label'     => 'NEW 5.0',
        'fullname'  => 'My New License Type',
        'deed'      => 'http://my-licenses.org/licenses/new/5.0/'
    );

    return $license_types;
}
add_filter( 'mc_license_types', 'my_add_license_types' );
```


== Screenshots ==

1. Shows how the media credits are output in the front-end (Spanish language version)


== Changelog ==

= 1.0.0 =
* Original version.


== Upgrade Notice ==