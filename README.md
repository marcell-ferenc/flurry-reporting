# [Flurry](https://developer.yahoo.com/analytics/) Analytics Reporting API PHP Client

Flurry Analytics Reporting API PHP Client to query the new Flurry Analytics API.
Flurry introduced its [new](https://developer.yahoo.com/flurry/docs/api/code/analyticsapi/) Reporting API before shut down the [old](https://developer.yahoo.com/flurry/docs/api/code/appinfo/) one on the 6th of March 2017.
For a detailed description review the Flurry documentation [here](https://developer.yahoo.com/flurry/docs/api/code/analyticsapi/).

## Getting Started

Get & use the **flurry-reporting** php package.

## Install

Install ```flurry-reporting``` using [composer](https://getcomposer.org/):
```
composer require relatedbits/flurry-reporting
```

## Usage

```
$token = 'YOUR_API_ACCESS_TOKEN';

$flurry = new Flurry($token);
```

* Query **Metrics API** data

    ```
    $params = [
        'dimensions' => 'country',
        'table' => 'App Usage Data',
        'timeGrain' => 'day',
        'metrics' => 'sessions,activeDevices,newDevices',
        'dateTime' => '2017-03-13/2017-03-14',
        'filters' => 'country|name-in["United States"]',
        'format' => 'csv'
    ];
    ```

    ```
    $data = $flurry->get('Metrics', $params);
    ```

* Query **Dimensions API** data

    ```
    $params = [
        'dimension' => 'country'
    ];
    ```

    ```
    $data = $flurry->get('Dimensions', $params);
    ```

## Exceptions

If required parameters for the API are not provided it will trhow LogicException.
In case of invalid parameter values are provided InvalidArgumentException will be thrown if there is no default value defined in the library. Invalid parameter names are simply omitted.

## Author

* **Marcell Ferenc** - *Initial work* - [marcell-ferenc](https://github.com/marcell-ferenc)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

* Inspired by [MyLittleParis/Flurry](https://github.com/MyLittleParis/Flurry), a client for the [old](https://developer.yahoo.com/flurry/docs/api/code/appinfo/) Flurry Reporting API.