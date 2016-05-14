<?php

    require 'vendor/autoload.php';
$es = new Elasticsearch\Client(['hosts' => ['localhost:9200'] ]);