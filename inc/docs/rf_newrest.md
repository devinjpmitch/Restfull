# Adding New REST
Adding a new REST route is simple, if you followed the quickstart and setup your ```/api/``` directory continue to create a new folder where your new rest will be set example ```/api/harrypotter/```

## Folder layout
The following files will exist within new your REST folder
```
callback.php
permission.php * ( No required )
rest.json
validate.php * ( No required )
```

## REST json
The ```rest.json``` file contains the namespace and methods to which your new REST apply by
Here is an example for both a **GET** & **POST** JSON look like for comparison

**GET**
```json
{
  "namespace": "harrypotter",
  "version": "1",
  "route": "all",
  "method": "get"
}
```
the URL for this rest will look like this
```https://example.com/wp-json/harrypotter/v1/all/```

<br/>

**POST**
```json
{
  "namespace": "harrypotter",
  "version": "1",
  "route": "charecter/(?P<username>[a-zA-Z0-9-]+)",
  "method": "post"
}
```
the URL for this rest will look like this
```https://example.com/wp-json/harrypotter/v1/charecter/{{username}}```

**Note:** we can also implement REGEX like expressions into the route to capture information to be used in our callback.

!> Versioning is not required but is useful when testing multiple version of the same REST

## Callback
The ```callback.php``` is used to build up the callback to the REST request 
```php
/**
* Restfull Callback: harrypotter
* @param WP_REST_Request $request
* @param $params
* @return wp_send_json
* @throws wp_send_json_error
* Note: none of these comments is required just showing what is queryable within this file.
*/
// all users
$users = array(
    'Harry Potter',
    'Hermione Granger',
    'Ron Weasley',
    'Draco Malfoy',
    'Severus Snape',
    'Albus Dumbledore',
    'Minerva McGonagall',
    'Sirius Black',
    'Rubeus Hagrid',
    'Voldemort',
    'Dobby',
    'Molly Weasley',
    'Luna Lovegood',
    'Cedric Diggory',
    'Cho Chang',
    'Gregory Goyle',
    'Bellatrix Lestrange',
    'Argus Filch',
    'Padma Patil',
    'Lucius Malfoy',
    'Narcissa Malfoy',
);
// return json of users
wp_send_json($users);
```

## Persmision
The ```permission.php``` is not a required file but is used for setting permissions on this REST request
```php
/**
 * Restfull Permission
 * This is used to define the permissions for the Restfull
 * Note: none of these comments is required
 */

// is user logged in
return is_user_logged_in();
```

## Validate
The ```validate.php``` is not a required file but is used for validating request variables
```php
/** 
 * Restfull Validation
 * Ensure the ID is a valid integer.
 * @return Array
 * Note: none of these comments is required
 */
return array(
    // Validate Catname
    'username' => array(
        // Validation callback
        'validate_callback' => function ($param, $request, $key) {
            // Is catname set and a string?
            return (isset($param) && is_string($param));
        }
    )
);
```