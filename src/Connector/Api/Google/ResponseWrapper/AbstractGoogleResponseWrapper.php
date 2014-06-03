<?php
/**
 * This file is part of the DirectionsDemo package.
 *
 * (c) Marco Spallanzani <mslib.code@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Connector\Api\Google\ResponseWrapper;

use Msl\RemoteHost\Response\Wrapper\AbstractResponseWrapper;
use Msl\RemoteHost\Response\ActionResponseInterface;

/**
 * Abstract Google Response Wrapper for Google Actions
 *
 * @category  Google\ResponseWrapper
 * @package   Connector\Api\Google\ResponseWrapper
 * @author    "Marco Spallanzani" <mslib.code@gmail.com>
 */
abstract class AbstractGoogleResponseWrapper extends AbstractResponseWrapper
{
    /**
     * Defaults status strings
     */
    const STATUS_OK = "OK";

    /**
     * Initializes the object fields with the given raw data
     *
     * @param array                    $rawData        array containing the response raw data
     * @param ActionResponseInterface  $actionResponse the action response object from which to extract additional information
     *
     * @return mixed
     */
    public function init(array $rawData, ActionResponseInterface $actionResponse)
    {
        // Setting raw data field
        $this->rawData = $rawData;

        // Setting status
        if (is_array($rawData) && isset($rawData['status'])) {
            if ($rawData['status'] === self::STATUS_OK) {
                $this->status = true;
            } else {
                $this->status = false;
            }
        } else {
            $this->status = false;
        }

        // Setting return code and return message
        $response = $actionResponse->getResponse();
        $this->returnCode    = $response->getStatusCode();
        $this->returnMessage = $response->getReasonPhrase();
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
} 