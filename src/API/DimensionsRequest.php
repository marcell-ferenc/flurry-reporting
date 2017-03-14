<?php

namespace RelatedBits\Flurry\API;

use RelatedBits\Flurry\API\Definition\Dimensions;
use RelatedBits\Flurry\API\Definition\Metrics;

class DimensionsRequest extends Request
{

    protected $path = Dimensions::ENDPOINT;

    protected function setParameter()
    {
    }

    protected function setPath()
    {
        foreach (Dimensions::REQUIRED_PATH_PARAMETERS as $requiredParam) {
            if (!array_key_exists($requiredParam, $this->parameter)) {
                throw new \LogicException('Parameter: ' . $requiredParam . ' must be set!');
            }
            $method = 'test' . ucfirst(strtolower($requiredParam));
            $validatedValue = Dimensions::$method($this->parameter[$requiredParam]);
            $this->path = str_replace('{' . $requiredParam . '}', $validatedValue, $this->path);
        }
    }

    protected function setQuery()
    {
        $this->query = null;
    }

}