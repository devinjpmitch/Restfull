<?php
/**
 * Wordpress Implementation of Docsify
 * This Class is used to implement Docsify and extend backend functionality with Wordpress
 *
 * @package MBC\Docsify
 */
namespace MBC\inc;

class Restfull {
    // Stylesheet Directory
    private static $stylesheet_directory = '';
    // Current Directory
    private static $current_dir = false;
    // Current Rest Array
    private static $current_rest = array();
    // Constructor ( Empty Static Class )
    public function __construct(){}
    /**
     * Initialize the class and set its properties.
     */
    public static function init(){
        // Set Stylesheet Directory
        self::$stylesheet_directory = get_stylesheet_directory();
        // Load Rest
        self::load();
    }
    private static function load(){
        // if api directory exists in stylesheet directory
        if(is_dir(self::$stylesheet_directory . '/api')){
            // Scan directory for files
            $files = scandir(self::$stylesheet_directory . '/api');
            // Loop through files
            foreach($files as $file){
                // If file is a directory
                if(is_dir(self::$stylesheet_directory . '/api/' . $file) && $file != '.' && $file != '..'){
                    // Set Current Directory
                    self::$current_dir = self::$stylesheet_directory . '/api/' . $file;
                    // Decode Json and set to Current Rest array
                    self::$current_rest = @json_decode(file_get_contents(self::$current_dir . '/rest.json'), true);
                    // if not empty register rest
                    if(!empty(self::$current_rest)) self::register();
                }
            }
        }
    }
    private static function register(){
        // e variable array of rest and directory
        $e = array(
            'rest'=> self::$current_rest,
            'dir'=> self::$current_dir
        );
        // add wordpress api init action using e variable
        add_action( 'rest_api_init', function () use($e) {
            $user = array(
                'logged_in' => is_user_logged_in(),
                'user_id' => get_current_user_id()
            );
            // seperating variables
            $rest = $e['rest'];
            $dir = $e['dir'];
            // if namespace, route, and method are set 
            if(isset($rest['namespace']) && isset($rest['route']) && isset($rest['method'])) {
                // Set namespace to variable
                $namespace = $rest['namespace'];
                // isset version then add version to namespace
                if(isset($rest['version'])) $namespace .= '/v' . $rest['version'];
                // if rest route postion of first charecter has / then use that if not add /
                $route = $rest['route'][0] == '/' ? $rest['route'] : '/'.$rest['route'];
                // validation variable
                $validate = false;
                if(file_exists($dir . '/validate.php')) $validate = true;
                // if validation file exists then set validate to validation function
               
                /**
                 * setup register rest route
                 * @param $namespace, $route, Array
                 */ 
                register_rest_route( $namespace, $route, array(
                    // Rest Method
                    'methods' => $rest['method'],
                    // Callback expose Request from WP Rest request using Directory And Rest Array
                    'callback' => function(\WP_REST_Request $req) use($dir, $rest, $user){
                        //get post parameters as varible
                        $params = $req->get_url_params();
                        if($_POST) $params = array_merge($params, $_POST);
                        //if callback file exists then include it
                        if(file_exists($dir.'/callback.php')) include $dir.'/callback.php';
                        // if else then return a friendly error
                        else wp_send_json(array(
                            // status error
                            'status' => 'error',
                            // message error including callback location to be set
                            'message' => 'Callback file not found '.$dir.'/callback.php'
                        ));
                    },
                    // Validation
                    'args' =>  $validate ? include $dir.'/validate.php' : array(),
                    // Perminssions callback
                    'permission_callback' => function() use($dir, $rest,$user) {
                        // if permissions file exists then include it
                        if(file_exists($dir.'/permission.php')) return include $dir.'/permission.php';
                        // allow all
                        else return true;
                    }
                ));  
            }
            
        });
    }
};
