<?php

namespace RelatedBits\Flurry\API;

abstract class Request
{

    /**
    * @var array $parameter Unprocessed query parameters
    */
    protected $parameter;

    /**
    * @var string $path Flurry API call url
    */
    protected $path = null;

    /**
    * @var array $query Flurry API call query parameters
    */
    protected $query = null;

    /**
    * Set parameters
    */
    abstract protected function setParameter();

    /**
    * Set url
    *
    * @return string Returns an API url
    */
    abstract protected function setPath();

    /**
    * Set query parameters
    */
    abstract protected function setQuery();

    /**
    * Process parameters for API call
    *
    * @param array $parameter Unprocessed query parameters
    *
    * @return object Returns processed request object
    */
    function process(Array $parameter)
    {
        $this->parameter = $parameter;
        $this->setParameter();
        $this->setPath();
        $this->setQuery();
        return $this;
    }

    /**
    * Get a string containing the endpoint for API call
    *
    * @return string Returns url
    */
    public function getPath()
    {
        return $this->path;
    }

    /**
    * Get an array containing the parameters for API call
    *
    * @return array Returns processed query parameters
    */
    public function getQuery()
    {
        return $this->query;
    }

}