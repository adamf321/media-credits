<?php
/*
Plugin Name: Media Credits
Description: Allows you to upload accreditation info to a media object and provides functions for accessing the data. This is required under the <a href="https://wiki.creativecommons.org/wiki/Best_practices_for_attribution" target="_blank">Creative Commons</a> license.
Version: 1.0.0
Author: Companamic
Author URI: https://solnamic.com
License: GPLv2 or later
Text Domain: Media-Credits
*/


define( "MC_TEXT_DOMAIN", "Media-Credits" );

include_once( "modules/Main.php" );

\MediaCredits\Modules\Main::init();


/*
 * Wrapper functions for easy access
 */
function mc_get_license_info( $attachment_id )
{
    return \MediaCredits\Modules\Main::get_license_info( $attachment_id );
}

function mc_license_info( $attachment_id, $args = array() )
{
    return \MediaCredits\Modules\Main::license_info( $attachment_id, $args );
}