<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
//Require Rest
require 'rest.php';
//Require Documentation
require plugin_dir_path( __FILE__ ) . 'documentation.php';
use MBC\inc;

/**
 * Wordpress plugins loaded
 * This action is used to load Restfull
 */
add_action('plugins_loaded', function(){
    inc\Restfull::init(); 
});