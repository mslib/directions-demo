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

/**
 * Json Google Response Wrapper for Google Actions
 *
 * @category  Google\ResponseWrapper
 * @package   Connector\Api\Google\ResponseWrapper
 * @author    "Marco Spallanzani" <mslib.code@gmail.com>
 */
class JsonGoogleResponseWrapper extends AbstractGoogleResponseWrapper
{
    /**
     * Return the body of the Response.
     *
     * @return array
     */
    public function getBody()
    {
        if (isset($this->rawData['routes'])) {
            return $this->rawData['routes'];
        }
        return array();
    }
}