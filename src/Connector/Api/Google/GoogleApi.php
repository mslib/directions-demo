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
