# Rajaongkir PHP API

Another alternative of rajaongkir PHP API. It is using GuzzleHttp as its underlying CURL request

## Installation

Run this on your composer `composer require gufy/rajaongkir`

## Usage

```php
<?php
use Gufy\Rajaongkir\Rajaongkir;
use Gufy\Rajaongkir\Province;
use Gufy\Rajaongkir\City;
use Gufy\Rajaongkir\Cost;
use Gufy\Rajaongkir\Waybill;
// initialize api. first argument will be your api key, and the second one is your package
Rajaongkir::init('your-api-key', 'starter');

// get all provinces
$provinces = Province::all();

// get cities
$cities = City::all();

// get cities based on province id
$cities = City::all($province_id);

// get cost
$cost = Cost::get(['city'=>$origin_city_id], ['city'=>$destination_city], $weight, 'jne');

// get waybill
$cost = Waybill::find('jne', 'your-waybill');
```
