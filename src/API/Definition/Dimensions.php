<?php

namespace RelatedBits\Flurry\API\Definition;

class Dimensions extends Constants
{

    /**
    * @const ENDPOINT Flurry Dimensions API endpoint
    */
    const ENDPOINT = self::BASE_PATH . '/dimensions/{dimension}/values';

    /**
    * @const array REQUIRED_PATH_PARAMETERS Required url path parameters
    */
    const REQUIRED_PATH_PARAMETERS = [
        'dimension'
    ];

    /**
    * @const array REQUIRED_QUERY_PARAMETERS Required query parameters
    */
    const REQUIRED_QUERY_PARAMETERS = [];

    /**
    * Test dimension
    *
    * @param string $value Dimension name
    *
    * @return string Returns dimension name
    */
    public static function testDimension($value)
    {
        if (!in_array($value, Metrics::getAllPossibleValues('dimensions'))) {
            return Metrics::ACCEPTED_TABLE_PARAMETERS['App Usage Data']['dimensions'][0];
        }
        return $value;
    }
}