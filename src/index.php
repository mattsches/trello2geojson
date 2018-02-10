<?php

use GeoJson\Feature\Feature;
use GeoJson\Feature\FeatureCollection;
use GeoJson\Geometry\Point;
use Mattsches\Trello2GeoJson\TrelloService;

require __DIR__.'/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

$trelloService = new TrelloService(getenv('TRELLO_API_KEY'), getenv('TRELLO_TOKEN'));

$features = [];
foreach ($trelloService->getGeoCardsInList(getenv('TRELLO_BOARD_LIST_ID')) as $card) {
    $geometry = null;
    $description = '';
    $cardDescription = $card->getDescription();
    preg_match('/geo:([0-9-.]+),([0-9-.]+)/', $cardDescription, $m);
    $geometry = new Point([(float)$m[2], (float)$m[1]]);
    $description = trim(preg_replace('/\s+/', ' ', str_replace($m[0], '', $cardDescription)));
    $properties = [
        'name' => $card->getName(),
        'description' => $description,
        'marker-symbol' => 'star',
        'marker-color' => '#ff0000',
        'trello_url' => $card->getShortUrl(),
    ];
    $features[] = new Feature($geometry, $properties);
}
$featureCollection = new FeatureCollection($features);

$geoJson = json_encode($featureCollection);
echo 'http://geojson.io/#data=data:application/json,'.rawurlencode($geoJson).PHP_EOL;
