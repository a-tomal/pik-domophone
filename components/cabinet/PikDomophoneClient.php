<?php


namespace app\components\cabinet;


use yii\httpclient\Client;
use yii\httpclient\JsonParser;

class PikDomophoneClient extends Client
{
    public $baseUrl = 'https://intercom.pik-comfort.ru/api/';
    public $requestConfig = [
        'class' => Request::class
    ];
    public $parsers = [
        Client::FORMAT_JSON => [
            'class' => JsonParser::class
        ]
    ];
}