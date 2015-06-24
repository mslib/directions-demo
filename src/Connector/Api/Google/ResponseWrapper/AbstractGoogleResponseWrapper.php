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
     * Inits the status field from the response
     *
     * @return mixed
     */
    public function initStatusFromResponse()
    {
        // Setting status
        if (is_array($this->rawData) && isset($this->rawData['status'])) {
            if ($this->rawData['status'] === self::STATUS_OK) {
                $this->status = true;
            } else {
                $this->status = false;
            }
        } else {
            $this->status = false;
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
} 