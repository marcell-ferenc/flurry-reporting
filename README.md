# [Flurry](https://developer.yahoo.com/analytics/) Analytics Reporting API PHP Client

Flurry Analytics Reporting API PHP Client to query the new Flurry Analytics API.
Flurry introduced its [new](https://developer.yahoo.com/flurry/docs/api/code/analyticsapi/) Reporting API before shut down the [old](https://developer.yahoo.com/flurry/docs/api/code/appinfo/) one on the 6th of March 2017.

## Getting Started

Get & use the **flurry-reporting** php package.

## Install

Install ```flurry-reporting``` using [composer](https://getcomposer.org/):
```
composer require relatedbits/flurry-reporting
```

## Usage

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
$token = 'YOUR_API_ACCESS_TOKEN';

$flurry = new Flurry($token);

$data = $flurry->get('Metrics', $params);
```

## Author

* **Marcell Ferenc** - *Initial work* - [marcell-ferenc](https://github.com/marcell-ferenc)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

* Inspired by [MyLittleParis/Flurry](https://github.com/MyLittleParis/Flurry), a client for the [old](https://developer.yahoo.com/flurry/docs/api/code/appinfo/) Flurry Reporting API.