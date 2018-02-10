# trello2geojson

A small script to read geo coordinates from cards on Trello and convert them to GeoJson.

First of all, you must get an [API key and token from Trello](https://trello.readme.io/docs/api-introduction) and use the API to find out the ID of the list that contains the cards with the geo coordinates.

Add geo coordinates to a Trello card description in simple [Geo URI](https://en.wikipedia.org/wiki/Geo_URI_scheme) format: `geo:-39.158611,175.634722` (this references [Mount Ngauruhoe](https://en.wikipedia.org/wiki/Mount_Ngauruhoe) in New Zealand).

## Installation & Running the Script

```
$ composer install
$ cp env.dist .env && vim .env # Set API key, token, and list Id
$ php src/index.php
```

## Main used libraries

* [php-trello-api](https://github.com/cdaguerre/php-trello-api) by Christian Daguerre
* [jmikola/geojson](https://github.com/jmikola/geojson) by Jeremy Mikola
