<?php

require 'vendor/autoload.php';
require_once 'vendor/tourcms/tourcms-php/src/TourCMS.php';
require_once 'vendor/tourcms/tourcms-php/src/tourcms-cache-file.php';

use Dotenv\Dotenv;

function setEnviroment() {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

setEnviroment();
function getApiKey(){
    $apiKey = $_ENV["API_KEY"];
    return $apiKey;
}

function getMarketPlace(){
    $marketPlace = $_ENV["MARKETPLACE_ID"];
    return $marketPlace;
}

function getChannel(){
    $channel = $_ENV["CHANNEL_ID"];
    return $channel;
}

function login(){
    $tourcms = new CachedTourCMS(getMarketPlace(), getApiKey(), 'simplexml');
    $tourcms->cache_dir = '/var/www/html/config/cache/search_tours/';
    return $tourcms;
}

function getTours(){
    $tourcms = login();
    $channel = getChannel();
    $params = "product_type=4&country=ES";
    $result = $tourcms->search_tours($params, $channel);
    return $result;
}



?>
