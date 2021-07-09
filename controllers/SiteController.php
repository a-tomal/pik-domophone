<?php


namespace app\controllers;


use yii\helpers\Json;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $filePath = sprintf('@cabinet/%s.json', 1);
        var_dump(\Yii::getAlias($filePath));
//        file_put_contents(\Yii::getAliases('@app') . 'test', 1);
//        Json::encode(1);

//        \Yii::$app->cabinet;
        exit;
    }

    public function actionError()
    {
        return 'Error';
    }
}