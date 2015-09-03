<?php
/*
Plugin Name: Media Credits
Description: Allows you to upload accreditation info to a media object and provides functions for accessing the data. This is required under the <a href="https://wiki.creativecommons.org/wiki/Best_practices_for_attribution" target="_blank">Creative Commons</a> license.
Version: 1.0.0
Author: Solnamic
Author URI: https://solnamic.com
License: GPLv2 or later
Text Domain: Media-Credits
*/


define( "MC_TEXT_DOMAIN", "Media-Credits" );

define( "MC_ROUTE_DIR", dirname(__FILE__) );


include_once( "modules/Main.php" );

\MediaCredits\Modules\Main::init();


/*
 * Wrapper functions for easy access
 */
function mc_get_credit_info( $attachment_id )
{
    return \MediaCredits\Modules\Main::get_credit_info( $attachment_id );
}

function mc_display_credits( $attachment_id, $args = array() )
{
    return \MediaCredits\Modules\Main::display_credits( $attachment_id, $args );
}