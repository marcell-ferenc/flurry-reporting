<?php

namespace RelatedBits\Flurry\API\Definition;

class Metrics extends Constants
{

    /**
    * @const string ENDPOINT Flurry Metrics API endpoint
    */
    const ENDPOINT = Constants::BASE_PATH . '/data/{table}/{timeGrain}';

    /**
    * @const array REQUIRED_PATH_PARAMETERS Required url path parameters
    */
    const REQUIRED_PATH_PARAMETERS = [
        'table',
        'timeGrain'
    ];

    /**
    * @const array REQUIRED_QUERY_PARAMETERS Required query parameters
    */
    const REQUIRED_QUERY_PARAMETERS = [
        'dateTime',
        'metrics'
    ];

    /**
    * @const array ACCEPTED_TABLE_PARAMETERS Accepted parameters in specific tables
    */
    const ACCEPTED_TABLE_PARAMETERS = [
        'App Usage Data' => [
            'table' => 'appUsage',
            'metrics' => [
                'sessions',
                'activeDevices',
                'newDevices',
                'timeSpent',
                'averageTimePerDevice',
                'averageTimePerSession',
                'medianTimePerSession'
            ],
            'dimensions' => [
                'company',
                'app',
                'appVersion',
                'country',
                'language',
                'region',
                'category'
            ],
            'timeGrain' => [
                'day',
                'week',
                'month',
                'all'
            ]
        ],
        'App Events Data' => [
            'table' => 'appEvent',
            'metrics' => [
                'activeDevices',
                'newDevices',
                'timeSpent',
                'averageTimePerDevice',
                'averageTimePerSession',
                'medianTimePerSession',
                'occurrences'
            ],
            'dimensions' => [
                'company',
                'app',
                'appVersion',
                'country',
                'language',
                'region',
                'category',
                'event'
            ],
            'timeGrain' => [
                'day',
                'week',
                'month',
                'all'
            ]
        ],
        'App Event Parameter Data' => [
            'table' => 'eventParams',
            'metrics' => [
                'count'
            ],
            'dimensions' => [
                'company',
                'app',
                'appVersion',
                'country',
                'language',
                'region',
                'category',
                'event',
                'paramName',
                'paramValue'
            ],
            'timeGrain' => [
                'day',
                'week',
                'month',
                'all'
            ]
        ],
        'Real Time App Data' => [
            'table' => 'realtime',
            'metrics' => [
                'sessions',
                'activeDevices'
            ],
            'dimensions' => [
                'company',
                'app',
                'appVersion',
                'country'
            ],
            'timeGrain' => [
                'hour',
                'day',
                'all'
            ]
        ]
    ];

    /**
    * @const array ACCEPTED_PARAMETERS Accepted query parameters
    */
    const ACCEPTED_QUERY_PARAMETERS = [
        'filters',
        'sort',
        'topN',
        'having',
        'format',
        'timeZone'
    ];

    /**
    * @const array DATETIME Accepted Date & time format for timeGrain query parameter
    */
    const DATETIME = [
        'hour' => [
            'format' => 'Y-m-d\TH',
            'regex' => '/\d{4}-\d{2}-\d{2}T\d{2}\/\d{4}-\d{2}-\d{2}T\d{2}/'
        ],
        'day'   => [
            'format' => 'Y-m-d',
            'regex' => '/\d{4}-\d{2}-\d{2}\/\d{4}-\d{2}-\d{2}/'
        ],
        'week'  => [
            'format' => 'Y-m-d',
            'regex' => '/\d{4}-\d{2}-\d{2}\/\d{4}-\d{2}-\d{2}/'
        ],
        'month' => [
            'format' => 'Y-m',
            'regex' => '/\d{4}-\d{2}\/\d{4}-\d{2}/'
        ],
        'all'   => [
            'format' => 'Y-m-d',
            'regex' => '/\d{4}-\d{2}-\d{2}\/\d{4}-\d{2}-\d{2}/'
        ]
    ];

    /**
    * @const array ATTRIBUTE Accepted dimension attribute for filters query parameter
    */
    const ATTRIBUTE = [
        'name',
        'id',
        // id and name are available for all dimensions.
        // some dimensions have additional attributes that are called out in dimensions section
    ];

    /**
    * @const array FILTER_OPERATORS Accepted filter query parameter operators
    */
    const FILTER_OPERATORS = [ 'in', 'notin', 'contains', 'startsWith' ];

    /**
    * @const string FILTER_SCHEMA_REGEX Accepted filter query parameter schema
    */
    const FILTER_SCHEMA_REGEX = '/(?<dimension>\w+)\|(?<attribute>\w+)-(?<operator>\w+)\[(?<value>.*?)\]/';

    /**
    * @const array HAVING_OPERATORS Accepted having query parameter operators
    */
    const HAVING_OPERATORS = [ 'eq', 'gt', 'lt', 'noteq', 'notgt', 'notlt' ];

    /**
    * @const array HAVING_SCHEMA_REGEX Accepted having query parameter schema
    */
    const HAVING_SCHEMA_REGEX = '/(?<metric>\w+)-(?<operator>\w+)\[(?<value>.*?)\]/';

    /**
    * List possible parameter values
    *
    * @param string $parameterName Flurry Metrics API Parameter name
    *
    * @return array Returns possible parameter values
    */
    public static function getAllPossibleValues($parameterName)
    {
        $values = [];
        foreach (self::ACCEPTED_TABLE_PARAMETERS as $tableName => $details) {
            if (!is_array($details[$parameterName])) {
                $values = array_merge($values, [$details[$parameterName]] );
            } else {
                $values = array_merge($values, $details[$parameterName]);
            }
        }
        return array_values(array_unique($values, SORT_REGULAR));
    }

    /**
    * Test table
    *
    * @param string $value Table name
    *
    * @return array Returns table name and its shortcode
    */
    public static function testTable($value)
    {
        if (!array_key_exists($value, Metrics::ACCEPTED_TABLE_PARAMETERS)) {
            return [
                'table' => Metrics::ACCEPTED_TABLE_PARAMETERS['App Usage Data']['table'],
                'tableName' => 'App Usage Data'
            ];
        }
        return [
            'table' => Metrics::ACCEPTED_TABLE_PARAMETERS[$value]['table'],
            'tableName' => $value
        ];
    }

    /**
    * Test timeGrain
    *
    * @param string $value TimeGrain value
    * @param string $table Table name
    *
    * @return string Returns timeGrain for the table
    */
    public static function testTimegrain($value, $table)
    {
        if (!in_array($value, Metrics::ACCEPTED_TABLE_PARAMETERS[$table]['timeGrain'])) {
            return Metrics::ACCEPTED_TABLE_PARAMETERS[$table]['timeGrain'][0];
        }
        return $value;
    }

    /**
    * Test dateTime
    *
    * @param string $value     DateTime value
    * @param string $timeGrain TimeGrain value
    *
    * @return string Returns dateTime for timeGrain
    */
    public static function testDatetime($value, $timeGrain)
    {
        if (!preg_match(self::DATETIME[$timeGrain]['regex'], $value)) {
            $start = (new \DateTime('YESTERDAY', new \DateTimeZone('UTC')))->format(self::DATETIME[$timeGrain]['format']);
            $end = (new \DateTime('NOW', new \DateTimeZone('UTC')))->format(self::DATETIME[$timeGrain]['format']);
            return $start . '/' . $end;
        }
        return $value;
    }

    /**
    * Test metrics
    *
    * @param string $value List of metrics (comma-separated)
    * @param string $table Table name
    *
    * @return string Returns comma-separated list of metrics for the table
    */
    public static function testMetrics($value, $table)
    {
        $out = explode(',', $value);
        $out = array_values(array_intersect($out, self::ACCEPTED_TABLE_PARAMETERS[$table]['metrics']));
        if (count($out) === 0) {
            //throw new \InvalidArgumentException('Invalid metrics: ' . $value);
            return implode(',', array_slice(self::ACCEPTED_TABLE_PARAMETERS[$table]['metrics'], 0, 3));
        }
        return implode(',', $out);
    }

    /**
    * Test dimensions
    *
    * @param string $value List of dimensions (comma-separated)
    * @param string $table Table name
    *
    * @throws InvalidArgumentException if there aren't any accepted table dimensions
    *
    * @return string Returns slash-separated list of dimensions for the table
    */
    public static function testDimensions($value, $table)
    {
        $out = explode(',', $value);
        $out = array_values(array_intersect($out, self::ACCEPTED_TABLE_PARAMETERS[$table]['dimensions']));
        if (count($out) === 0) {
            throw new \InvalidArgumentException('Invalid dimensions: ' . $value);
        }
        return implode('/', $out);
    }

    /**
    * Test filters
    *
    * @param string $value List of filters (comma-separated)
    * @param string $table Table name
    *
    * @throws InvalidArgumentException if there is any invalid filter setting
    *
    * @return string Returns comma-separated list of filters for the table
    */
    public static function testFilters($value, $table)
    {
        if (!preg_match_all(self::FILTER_SCHEMA_REGEX, $value, $matches)) {
            throw new \InvalidArgumentException('Invalid filter value: ' . $value);
        }
        $filter = [];
        for ($i=0; $i < count($matches[0]); $i++) {
            $dim = self::testDimensions($matches['dimension'][$i], $table);
            $atr = $matches['attribute'][$i];
            $opr = self::testFilterOperator($matches['operator'][$i], $table);
            $val = $matches['value'][$i];
            $filter[] = $dim . '|' . $atr . '-' . $opr . '[' . $val . ']';
        }
        return implode(',', $filter);
    }

    /**
    * Test filter operators
    *
    * @param string $value Filter operator
    *
    * @throws InvalidArgumentException if there is any invalid filter operator
    *
    * @return string Returns filter operator
    */
    public static function testFilterOperator($value)
    {
        if (!in_array($value, self::FILTER_OPERATORS)) {
            throw new \InvalidArgumentException('Invalid filter operator: ' . $value);
        }
        return $value;
    }

    /**
    * Test filter attributes
    *
    * @param string $value Filter attribute
    *
    * @throws InvalidArgumentException if there is any invalid dimension attribute
    *
    * @return string Returns filter dimension attribute
    */
    public static function testAttribute($value)
    {
        if (!in_array($value, self::ATTRIBUTE)) {
            throw new \InvalidArgumentException('Invalid attribute: ' . $value);
        }
        return $value;
    }

    /**
    * Test sort parameters
    *
    * @param string $value List of sort parameters (comma-separated)
    * @param string $table Table name
    *
    * @throws InvalidArgumentException if there is any invalid sort value
    *
    * @return string Returns comma-separated list of sort parameters for the table
    */
    public static function testSort($value, $table)
    {
        $sort = [];
        $out = explode(',', $value);
        foreach ($out as $str) {
            $str = explode('|', $str);
            if (in_array($str[0], self::ACCEPTED_TABLE_PARAMETERS[$table]['metrics'])) {
                $sortStr = $str[0];
                if (isset($str[1]) && preg_match('/(desc|asc)/i', $str[1])) {
                    $sortStr .= '|' . strtolower($str[1]);
                }
                $sort[] = $sortStr;
            }
        }
        if (count($sort) === 0) {
            throw new \InvalidArgumentException('Invalid sort value: ' . $value);
        }
        return implode(',', $sort);
    }

    /**
    * Test topN
    *
    * @param integer $value Reduces result to match the number specified
    *
    * @throws InvalidArgumentException if the provided argument is not of type 'integer'
    *
    * @return integer Returns topN integer
    */
    public static function testTopn($value)
    {
        if (!is_integer($value)) {
            throw new \InvalidArgumentException('Invalid topN value: ' . $value);
        }
        return $value;
    }

    /**
    * Test having parameters
    *
    * @param string $value List of having parameters (comma-separated)
    * @param string $table Table name
    *
    * @throws InvalidArgumentException if there is any invalid having setting
    *
    * @return string Returns comma-separated list of having parameters for the table
    */
    public static function testHaving($value, $table)
    {
        if (!preg_match_all(self::HAVING_SCHEMA_REGEX, $value, $matches)) {
            throw new \InvalidArgumentException('Invalid having value: ' . $value);
        }
        $having = [];
        for ($i=0; $i < count($matches[0]); $i++) {
            $met = self::testMetrics($matches['metric'][$i], $table);
            $opr = self::testHavingOperator($matches['operator'][$i], $table);
            $val = $matches['value'][$i];
            $having[] = $met . '-' . $opr . '[' . $val . ']';
        }
        return implode(',', $having);
    }

    /**
    * Test having operators
    *
    * @param string $value Having operator
    *
    * @throws InvalidArgumentException if there is any invalid having operator
    *
    * @return string Returns having operator
    */
    public static function testHavingOperator($value)
    {
        if (!in_array($value, self::HAVING_OPERATORS)) {
            throw new \InvalidArgumentException('Invalid having operator: ' . $value);
        }
        return $value;
    }

    /**
    * Test format
    *
    * @param string $value Required format
    *
    * @throws InvalidArgumentException if there is any invalid format name
    *
    * @return string Returns format
    */
    public static function testFormat($value)
    {
        if (!preg_match('/^(json|csv)$/i', $value)) {
            throw new \InvalidArgumentException('Invalid format: ' . $value);
        }
        return strtolower($value);
    }

    /**
    * Test time zone
    *
    * @param string $value time zone
    *
    * @throws InvalidArgumentException if there is any invalid time zone
    *
    * @return string Returns time zone
    */
    public static function testTimezone($value)
    {
        if (!in_array($value, \DateTimeZone::listIdentifiers())) {
            throw new \InvalidArgumentException('Invalid time zone: ' . $value);
        }
        return $value;
    }
}