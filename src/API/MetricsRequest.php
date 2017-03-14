<?php

namespace RelatedBits\Flurry\API;

use RelatedBits\Flurry\API\Definition\Dimensions;
use RelatedBits\Flurry\API\Definition\Metrics;

class MetricsRequest extends Request
{

    protected $path = Metrics::ENDPOINT;

    /**
    * @var string $table Table shortcode
    */
    private $table = null;

    /**
    * @var string $tableName Table name
    */
    private $tableName = null;

    /**
    * @var string $timeGrain TimeGrain for table
    */
    private $timeGrain = null;

    protected function setParameter()
    {
        foreach (Metrics::REQUIRED_PATH_PARAMETERS as $requiredParam) {
            if (!array_key_exists($requiredParam, $this->parameter)) {
                throw new \LogicException('Parameter: ' . $requiredParam . ' must be set!');
            }
        }
        $table = Metrics::testTable($this->parameter['table']);
        $this->table = $table['table'];
        $this->tableName = $table['tableName'];
        $this->timeGrain = Metrics::testTimegrain($this->parameter['timeGrain'], $this->tableName);
    }

    protected function setPath()
    {
        $this->path = str_replace('{table}', $this->table, $this->path);
        unset($this->parameter['table']);
        $this->path = str_replace('{timeGrain}', $this->timeGrain, $this->path);
        unset($this->parameter['timeGrain']);
        if (array_key_exists('dimensions', $this->parameter)) {
            $this->path .= '/' . Metrics::testDimensions($this->parameter['dimensions'], $this->tableName);
            unset($this->parameter['dimensions']);
        }
    }

    protected function setQuery()
    {

        foreach (Metrics::REQUIRED_QUERY_PARAMETERS as $requiredParam) {
            if (!array_key_exists($requiredParam, $this->parameter)) {
                throw new \LogicException('Parameter: ' . $requiredParam . ' must be set!');
            }
        }
        $this->query['metrics'] = Metrics::testMetrics($this->parameter['metrics'], $this->tableName);
        unset($this->parameter['metrics']);
        $this->query['dateTime'] = Metrics::testDatetime($this->parameter['dateTime'], $this->timeGrain);
        unset($this->parameter['dateTime']);

        foreach ($this->parameter as $param => $value) {
            $method = 'test' . ucfirst(strtolower($param));
            if (!method_exists(new Metrics, $method)) {
                continue;
            }
            $this->query[$param] = Metrics::$method($this->parameter[$param], $this->tableName);
        }

    }

}