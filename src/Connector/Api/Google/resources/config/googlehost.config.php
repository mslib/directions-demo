<?php
/**
 * This file is part of the DirectionsDemo package.
 *
 * (c) Marco Spallanzani <mslib.code@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Google Host Connection config file
 *
 * PHP version 5
 *
 * @author "Marco Spallanzani" <mslib.code@gmail.com>
 */
return array(
    'parameters' => array(
        'host'      => 'http://maps.googleapis.com/maps/api/', // The host api
        'port'      => '', // (optional) The port
        'user'      => '', // (optional) The user
        'password'  => '', // (optional) The password
    ),
    'actions_parameters' => array(
        // Add here all the parameters which are common to all actions. You still can override them by adding a different value in the parameters array of each action
    ),
    // For all possible values, please look at Zend\Http\Client->$config
    'config' => array(
        'maxredirects'  => 2,
        'timeout'       => 30,
        'adapter'       => 'Zend\Http\Client\Adapter\Curl',
    ),
    'actions' => array(
        'google-json' => array(
            'driving-directions' => array(
                'name'              => 'directions/json',
                'request'           => array(
                    'name_in_uri'   => true, // (optional) true is the default value; if true, the action name will be part of the uri (i.e. host + name) (e.g. http://maps.googleapis.com/maps/api/directions/json)
                    'type'                     => 'UrlEncoded', // Default values are 'UrlEncoded', 'PostText', 'Xml'.
                    'method'                   => 'GET', // (optional) POST is the default value
                    'parameters'               => array( // (optional) array containing all request parameters (this array will be merged with the action_parameters defined above)
                        'origin'      => '', // put here a default value for each parameter; note that the default values will be overriden with the values passed in the execute method
                        'destination' => '',
                        'sensor'      => '',
                    ),
                    'host'          => '', //(you can override here the general host; if left empty or not specified, the default value will be used)
                    'port'          => '', //(you can override here the general port; if left empty or not specified, the default value will be used)
                ),
                'response' => array(
                    'type'      => 'Json', // Possible values are: Json|PlainText|Xml|{Custom Class Name with full namespace that extends class Msl\RemoteHost\Response\AbstractActionResponse}', // (REQUIRED) Json, PlainText, Xml are the response implementations available with the library
                    'wrapper'   => 'Connector\Api\Google\ResponseWrapper\JsonGoogleResponseWrapper', // (optional) if not specified, the default wrapper \Msl\RemoteHost\Response\Wrapper\DefaultResponseWrapper will be used
                ),
            ),
        ),
        'google-xml' => array(
            'driving-directions' => array(
                'name'              => 'directions/xml',
                'request'           => array(
                    'name_in_uri'   => true, // (optional) true is the default value; if true, the action name will be part of the uri (i.e. host + name) (e.g. http://maps.googleapis.com/maps/api/directions/json)
                    'type'                     => 'UrlEncoded', // Default values are 'UrlEncoded', 'PostText', 'Xml'.
                    'method'                   => 'GET', // (optional) POST is the default value
                    'parameters'               => array( // (optional) array containing all request parameters (this array will be merged with the action_parameters defined above)
                        'origin'      => '', // put here a default value for each parameter; note that the default values will be overriden with the values passed in the execute method
                        'destination' => '',
                        'sensor'      => '',
                    ),
                    'host'          => '', //(you can override here the general host; if left empty or not specified, the default value will be used)
                    'port'          => '', //(you can override here the general port; if left empty or not specified, the default value will be used)
                ),
                'response' => array(
                    'type'      => 'Xml', // Possible values are: Json|PlainText|Xml|{Custom Class Name with full namespace that extends class Msl\RemoteHost\Response\AbstractActionResponse}', // (REQUIRED) Json, PlainText, Xml are the response implementations available with the library
                    'wrapper'   => 'Connector\Api\Google\ResponseWrapper\XmlGoogleResponseWrapper', // (optional) if not specified, the default wrapper \Msl\RemoteHost\Response\Wrapper\DefaultResponseWrapper will be used
                ),
            ),
        ),
    ),
);