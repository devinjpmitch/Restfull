<?php
/**
 * Restfull Permission
 * This is used to define the permissions for the Restfull
 */

// Variable logged in
$logged_in = is_user_logged_in();
// if user is logged in
if($logged_in){
    // return boolean if user can edit others posts
    return current_user_can( 'edit_others_posts' );
}
// else 
else {
    // user is not logged in therefor they cant edit others posts
    return false;
}

