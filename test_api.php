<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$payload = [
    'sensor_device_id' => 1,
    'food_category_id' => 1,
    'sample_name' => 'Daging Sapi Lot B',
    'temperature' => 25.5,
    'humidity' => 60.2,
    'gas_level' => 1250
];

$request = Illuminate\Http\Request::create('/api/sensor-data', 'POST', [], [], [], [], json_encode($payload));
$request->headers->set('Content-Type', 'application/json');
$request->headers->set('Accept', 'application/json');

$response = $kernel->handle($request);
echo $response->getStatusCode() . PHP_EOL;
echo $response->getContent();
