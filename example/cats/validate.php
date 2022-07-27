<?php
/** 
 * Restfull Validation
 * Ensure the ID is a valid integer.
 * @return Array
 */
return array(
    // Validate Catname
    'catname' => array(
        // Validation callback
        'validate_callback' => function ($param, $request, $key) {
            // Is catname set and a string?
            return (isset($param) && is_string($param));
        }
    )
);