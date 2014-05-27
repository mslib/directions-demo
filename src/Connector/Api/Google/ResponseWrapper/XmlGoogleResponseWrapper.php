<?php
/**
 * Xml Response Wrapper for Google Actions
 *
 * PHP version 5
 *
 * @category  Google\ResponseWrapper
 * @package   Connector\Api\Google\ResponseWrapper
 * @author    "Marco Spallanzani" <mslib.code@gmail.com>
 */
namespace Connector\Api\Google\ResponseWrapper;

use Msl\RemoteHost\Response\Wrapper\AbstractResponseWrapper;

/**
 * Xml Google Response Wrapper for Google Actions
 *
 * @category  Google\ResponseWrapper
 * @package   Connector\Api\Google\ResponseWrapper
 * @author    "Marco Spallanzani" <mslib.code@gmail.com>
 */
class XmlGoogleResponseWrapper extends AbstractResponseWrapper
{
    /**
     * Defaults status strings
     */
    const STATUS_NOT_FOUND = "NOT_FOUND";
    const STATUS_OK        = "OK";

    /**
     * Initializes the object fields with the given raw data.
     *
     * @param array $rawData an array containing the raw response
     *
     * @return mixed
     */
    public function init(array $rawData)
    {
        // Setting raw data field
        $this->rawData = $rawData;

        // Setting status, returnCode and returnMessage fields to the ResponseWrapper entity
        if (is_array($rawData)) {
            // Setting  return code and return message
            if (isset($rawData['status'])) {
                if ($rawData['status'] === self::STATUS_OK) {
                    $this->status        = true;
                    $this->returnCode    = self::STATUS_OK;
                    $this->returnMessage = self::STATUS_OK;
                } else {
                    $this->status        = false;
                    $this->returnCode    = self::STATUS_NOT_FOUND;
                    $this->returnMessage = self::STATUS_NOT_FOUND;
                }
            }
        }
    }

    /**
     * Returns the found routes
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->getBody();
    }

    /**
     * Return the body of the Response.
     *
     * @return array
     */
    public function getBody()
    {
        if (isset($this->rawData['route'])) {
            return $this->rawData['route'];
        }
        return array();
    }
}