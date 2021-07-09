<?php


namespace app\components\cabinet;


class Request extends \yii\httpclient\Request
{
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->setHeaders([
            'User-Agent' => 'domophone-ios/128987 CFNetwork/1237 Darwin/20.4.0',
            'api-version' => 2
        ]);
    }
}