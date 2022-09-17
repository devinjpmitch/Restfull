<?php
/**
* Restfull Callback: Cats
* @param WP_REST_Request $request
* @param $params
* @return wp_send_json
* @throws wp_send_json_error
*/

// Not required as we have validate.php set to check this
// if parameter of catname is not set then return json error
if(!isset($params['catname'])) {
    return wp_send_json_error('Catname is required');
}
//Get all posts from posttype 'cats' that are published
$posts = get_posts(array(
        'post_type' => 'cats',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    )) ?? array();
//if $posts is not empty
if (!empty($posts)) {
    //Array of cats
    $cats = array();
    //loop through each post and add data if catname parameter is post name
    foreach ($posts as $post) {
        // if catname parameter is post name
        if($value->post_title == $params['catname']){
            $cats[] = array(
                'id' => $value->ID,
                'title' => $value->post_title,
                'content' => $value->post_content,
                'thumbnail' => get_the_post_thumbnail_url($value->ID, 'full')
            );
        }
    }
    // if cats array is empty
    if(empty($cats)){
        // return no cat found
        return wp_send_json_error('Cat not found');
    } 
    // Respond with JSON
    wp_send_json($cats);
}
