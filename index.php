<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$localConfig = [];

if (file_exists(__DIR__ . '/config/local.php')) {
    $localConfig = require __DIR__ . '/config/local.php';
}

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/config/web.php',
    $localConfig
);

(new yii\web\Application($config))->run();
