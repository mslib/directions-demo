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
 * App bootstrap file
 *
 * PHP version 5
 *
 * @author "Marco Spallanzani" <mslib.code@gmail.com>
 */
namespace {
    $loader = require __DIR__.'/vendor/autoload.php';

    $googleApi = new \Connector\Api\Google\GoogleApi();

    $responseWrapper = $googleApi->getRoutes('Toronto', 'Montreal', 'true');
    if ($responseWrapper instanceof Msl\RemoteHost\Response\Wrapper\AbstractResponseWrapper) {
        if ($responseWrapper->getStatus()) {
            echo "SUCCESS!" . PHP_EOL;
        } else {
            echo "FAIL!" . PHP_EOL;
        }
        echo $responseWrapper->getReturnCode() . PHP_EOL;
        echo $responseWrapper->getReturnMessage() . PHP_EOL;
    } else {
        echo "FAIL! Unexpected response object" . PHP_EOL;
    }
}

