<?php
/*
Plugin Name: Media Credits
Description: Allows you to upload accreditation inf to a media object and provides functions for accessing the data.
Version: 1.0.0
Author: Companamic
Author URI: https://solnamic.com
License: GPLv2 or later
Text Domain: Media-Credits
*/

define( "MC_TEXT_DOMAIN", "Media-Credits" );

//define( "DIRECTORY_FRAMEWORK_MAIN_FILE", __FILE__ );
//
//define( "DIRECTORY_FRAMEWORK_ROUTE_DIR", dirname(__FILE__) );
//
//define( "DIRECTORY_FRAMEWORK_ROUTE_URL", plugins_url("", __FILE__) );

include_once( "modules/Main.php" );

\MediaCredits\Modules\Main::init();