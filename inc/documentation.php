<?php
add_action('init', function() {
    if(class_exists('MBC\\inc\\WPDocsify')) MBC\inc\WPDocsify::register(
        array(
            array(
                'title'=>'Restfull',
                'label'=>'Restfull',
                'slug'=>'restfull',
                'location'=> plugin_dir_url( __FILE__ ).'docs/',
                'restricted'=> array('administrator'),
                'restrict_operator'=> 'and',
                'config'=> array(
                    'maxLevel'=> 4,
                    'subMaxLevel'=> 2,
                    'loadSidebar'=> "_sidebar.md",
                    'homepage'=> "rf_gettingstarted.md",
                ),
            )
        )
    );
}); 