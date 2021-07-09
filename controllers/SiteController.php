<?php


namespace app\controllers;


use app\components\cabinet\dto\Account;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {


//        $r = Account::hydrate(json_decode(file_get_contents(\Yii::getAlias('@app/components/cabinet/cache/+79114970004.json')),1));
//var_dump($r);


        \Yii::$app->cabinet;
        exit;
    }

    public function actionError()
    {
        return 'Error';
    }
}