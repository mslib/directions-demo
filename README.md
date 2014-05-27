**DIRECTIONS DEMO**
===================

This library is just a project example of how to use the library mslib/remote-host. 

**INSTALLATION**
----------------

Installation is a quick 3 step process:

1. Checkout the repository
2. Download all dependencies with composer install

### Step 1: Checkout the repository

Checkout this repository with the following command:

``` bash
$ git clone https://github.com/mslib/directions-demo.git
```

### Step2: Download all dependencies with composer install

First, you need to have composer installed (*https://getcomposer.org/download/*). If that's already the case, tell composer to download all dependencies by running the command:

``` bash
$ php composer.phar install 
```

**THE '*GoogleApi*' IMPLEMENTATION EXAMPLE**
-------------

This project gives an example of how to use the repository (*https://github.com/mslib/remote-host*).

More into details, it gives an application layer for the Google API function 'directions' as documented at the following url:

> *https://developers.google.com/maps/documentation/directions/?hl=en*


### Configuration

In order to implement a call to the *'directions'* Google API, we have created an appropriate configuration file that will 
be used by the API class implementation, as explained in the next paragraph. This file is stored in the following project folder: 

> src/Connector/Api/Google/resources/config/googlehost.config.php

The required configuration data for any *'directions'* Google API call, are the following:

* ***Method***: GET
* ***Request Url***: http://maps.googleapis.com/maps/api/directions/json
* ***Response Type***: JSON
* ***Request parameter***: origin, destination, sensor

A request url example is the following: 

> *http://maps.googleapis.com/maps/api/directions/json?origin=Toronto&destination=Montreal&sensor=false*

The configuration for such a call is as follows:

``` php
<?php

return array(
    'parameters' => array(
        'host'      => 'http://maps.googleapis.com/maps/api/', // The host api
    ),
    'actions_parameters' => array(
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
                    'name_in_uri'   => true, // (e.g. http://maps.googleapis.com/maps/api/directions/json)
                    'type'                     => 'UrlEncoded', 
                    'method'                   => 'GET', 
                    'parameters'               => array( 
                        'origin'      => '', // default value for each parameter; default values will be overriden with the values passed in the execute method
                        'destination' => '',
                        'sensor'      => '',
                    ),
                ),
                'response' => array(
                    'type'      => 'Json', 
                ),
            ),
        ),
    ),
);
```

### API Class

Now that we have prepared the configuration for the *'destinations'* API call, we need to implement our API Class, that will be in charge of connecting to remote API and send a request to it.

To do that, we have implemented a class called *'GoogleApi'* that extends the base *'Msl\RemoteHost\Api\AbstractHostApi'* abstract class as follows:

``` php
<?php
/**
 * Google Api implementation
 *
 * PHP version 5
 *
 * @category  Google
 * @package   Connector\Api\Google
 * @author    "Marco Spallanzani" <mslib.code@gmail.com>
 */
namespace Connector\Api\Google;

use Msl\RemoteHost\Api\AbstractHostApi;

/**
 * Google Api implementation
 *
 * @category  Google
 * @package   Connector\Api\Google
 * @author    "Marco Spallanzani" <mslib.code@gmail.com>
 */
class GoogleApi extends AbstractHostApi
{
    /**
     * String containing the name of this api. This value will be used mainly for log purposes.
     *
     * @var string
     */
    const API_NAME = 'GOOGLE_API';

    /**
     * Returns the default config array
     *
     * @return mixed
     */
    public function getDefaultConfig()
    {
        return include __DIR__ . '/resources/config/googlehost.config.php';
    }

    /**
     * A Directions API request
     *
     * @param string $origin      The address or textual latitude/longitude value from which you wish to calculate directions
     * @param string $destination The address or textual latitude/longitude value from which you wish to calculate directions
     * @param string $sensor      whether or not the directions request comes from a device with a location sensor
     *
     * @return \Msl\RemoteHost\Response\AbstractResponseWrapper
     */
    public function getRoutes($origin, $destination, $sensor)
    {

        /** @var /ResponseWrapper/JsonGoogleResponseWrapper $response */
        $response = null;
        try {
            $response = $this->execute(
                'google-json.driving-directions',
                array(
                    'origin'      => $origin,
                    'destination' => $destination,
                    'sensor'      => $sensor,
                )
            );
        } catch (\Exception $e) {
            echo sprintf('[%s] Google Host call failed! Error message is: \'%s\'', $this->getApiName(), $e->getMessage());
        }

        return $response;
    }
}
```

Note that:

* we have implemented the parent abstract method 'getDefaultConfig' that should return the configuration array defined at the previous step. 
* we have redefined the constant 'API_NAME' so that it carries the value 'GOOGLE_API'; this could be useful for logging purposes;


### API Methods

The last step is to define a method in the *'GoogleApi'* class, so that we can wrap the call to the configured action *'google-json.driving-directions'* in a method. 
To do that, we have added to the class a method called *'getRoutes()'*. 

As you can see in the above paragraph, this method has three parameters: 

- origin (string); 
- destination (string); 
- sensor (boolean);

These parameters corresponds to the required Google API call parameter *origin*, *destination* and *sensor* 
as explained in Google API documentation for the action *'directions'*.

**CUSTOM RESPONSE WRAPPERS**
------------------------------

The Google API action *'directions'* could return a Json or an Xml response, according to the request url. 

### The Json Format Response

The main Json response structure is an associative array containing two top level indexes:

- status: OK/KO
- routes: all possible routes for the requested origin and destination

We wanted to wrap the response object in a custom Response Wrapper (for more information about Response Wrapper objects, please refer 
to the online documentation of the mslib/remote-host repository), that extracts the status from a response and sets a return code and/or message. 
To do that, we have created a custom Response Wrapper object, which is exactly in charge of doing that. The 'extraction' action is 
done in the method '*init()*' of the following custom class:

> Connector\Api\Google\ResponseWrapper\JsonGoogleResponseWrapper

In order to use our custom response wrapper object, we set its full class namespace in the configuration key *'response.wrapper'* 
of the action '*google-json.driving-directions*' in the configuration file. 

We report the full configuration here below:

``` php
<?php

return array(
    'parameters' => array(
        'host'      => 'http://maps.googleapis.com/maps/api/', 
        'port'      => '', 
        'user'      => '', 
        'password'  => '', 
    ),
    'actions_parameters' => array(
    ),
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
                    'name_in_uri'   => true, // if true, the action name will be part of the uri (i.e. host + name) (e.g. http://maps.googleapis.com/maps/api/directions/json)
                    'type'                     => 'UrlEncoded', 
                    'method'                   => 'GET', 
                    'parameters'               => array( 
                        'origin'      => '', 
                        'destination' => '',
                        'sensor'      => '',
                    ),
                ),
                'response' => array(
                    'type'      => 'Json', 
                    'wrapper'   => 'Connector\Api\Google\ResponseWrapper\JsonGoogleResponseWrapper', 
                ),
            ),
        ),
    ),
);
```

### The Xml Format Response

The main Xml response structure consists of two main top level tags:

- status: OK/KO
- route: all possible routes for the requested origin and destination

We wanted to wrap the response object in a custom Response Wrapper (for more information about Response Wrapper objects, please refer 
to the online documentation of the mslib/remote-host repository), that extracts the status from a response and sets a return code and/or message. 
To do that, we have created a custom Response Wrapper object, which is exactly in charge of doing that. The 'extraction' action is 
done in the method '*init()*' of the following custom class:

> Connector\Api\Google\ResponseWrapper\XmlGoogleResponseWrapper

In order to use our custom response wrapper object, we set its full class namespace in the configuration key *'response.wrapper'* 
of the action '*google-xml.driving-directions*' in the configuration file. 

We report the full configuration here below:

``` php
<?php

return array(
    'parameters' => array(
        'host'      => 'http://maps.googleapis.com/maps/api/', 
        'port'      => '', 
        'user'      => '', 
        'password'  => '', 
    ),
    'actions_parameters' => array(
    ),
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
                    'name_in_uri'   => true, // if true, the action name will be part of the uri (i.e. host + name) (e.g. http://maps.googleapis.com/maps/api/directions/json)
                    'type'                     => 'UrlEncoded', 
                    'method'                   => 'GET', 
                    'parameters'               => array( 
                        'origin'      => '', 
                        'destination' => '',
                        'sensor'      => '',
                    ),
                ),
                'response' => array(
                    'type'      => 'Xml', 
                    'wrapper'   => 'Connector\Api\Google\ResponseWrapper\XmlGoogleResponseWrapper', 
                ),
            ),
        ),
    ),
);
```

### FINAL NOTES

It is interesting to point out that the main purpose of the Wrapper objects is to define different behaviour of 
extracting information from a given response array. All responses are automatically converted to an array (Json and Xml responses 
are converted to an array by the library), but the way we extract the status and routes information is different 
according to the choosen response type. 

Infact, the Xml response structure consists of two main top level tags (***status*** and ***route***), whereas the Json response 
structure consists of two main top level indexes (***status*** and ***routes*** - for the xml it's ***route*** without ending ***s***!). 

So the need of two different Response Wrapper objects is because of this difference in the xml and json response structure. 

Please, take a look at the methods '*getBody()*' and '*getRoutes()*' of the two custom Response Wrapper objects for more details.
