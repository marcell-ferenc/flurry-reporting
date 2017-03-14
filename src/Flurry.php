<?php

namespace RelatedBits\Flurry;

use RelatedBits\Flurry\API\Definition\Metrics;
use RelatedBits\Flurry\API\Definition\Dimensions;
use RelatedBits\Flurry\API\Request;
use RelatedBits\Flurry\API\DimensionsRequest;
use RelatedBits\Flurry\API\MetricsRequest;

/**
 * Flurry Analytics Reporting API Client
 *
 * This class can be used to query Flurry Analytics (www.flurry.com)
 * You need to create a programmatic user account and an API access token to be able to use this class.
 * To acquire the API access token visit https://developer.yahoo.com/flurry/docs/api/code/apptoken.
 * In order not to exceed the API rate limit 1 second sleep is applied.
 *
 * @copyright       Copyright 2017 Marcell Ferenc.
 * @author          Marcell Ferenc <marcell.ferenc.uni@gmail.com>
 * @version         1.0.0 (2017-03-13)
 * @example         $flurry = new Flurry($token);
 *                  $data = $flurry->get('Metrics', $params);
 */
class Flurry
{

    /**
    * @const string VERSION Flurry Analytics Reporting API client version
    */
    const VERSION = '1.0.0';

    /**
    * @const string VERSION Flurry Analytics Reporting API client user agent
    */
    const USER_AGENT = 'Flurry-Reporting/' . self::VERSION . ' (+https://github.com/marcell-ferenc/flurry-reporting)';

    /**
    * @var string $token Flurry API access token
    */
    private $token;

    /**
    * Construct
    *
    * @param string $token
    */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Set Flurry API access token
     *
     * @param string $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * Makes API call & get results
     *
     * @uses   RelatedBits\Flurry\API\Request::process() To process parameters for API call
     *
     * @param  string       $api                         Flurry API to use
     * @param  array        $parameters                  Parameters for API call
     *
     * @return string|array                              The response data depending on the selected format
     */
    public function get($api, Array $parameters)
    {
        $httpHeader = [ 'Authorization: Bearer ' . $this->token ];
        $userAgent = self::USER_AGENT . ' PHP/' . PHP_VERSION . ' CURL/' . curl_version()['version'];

        $namespace = 'RelatedBits\Flurry\API';
        $class = ucfirst(strtolower($api)) . 'Request';
        $class = $namespace . '\\' .  $class;

        $request = new $class();
        $request->process($parameters);
        $curl = curl_init();
        $url = $request->getPath() . (empty($request->getQuery()) ? '' : '?' . http_build_query($request->getQuery(), '', '&'));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader);
        $response = curl_exec($curl);
        curl_close($curl);

        if (isset($request->getQuery()['format']) && $request->getQuery()['format'] !== 'json') {
            return $response;
        }
        return json_decode($response);
    }

}