<?php
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

    if ($responseWrapper instanceof Msl\RemoteHost\Response\Wrapper\AbstractResponseWrapper && $responseWrapper->getStatus()) {
        echo "SUCCESS!";
    } else {
        echo "FAIL!";
    }

    var_dump($responseWrapper->getRawData());
}

