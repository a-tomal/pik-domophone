<?php


namespace app\controllers;


use app\components\cabinet\Cabinet;
use app\components\cabinet\DeviceCategory;
use app\components\cabinet\dto\Account;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        /** @var Cabinet $cabinet */
        $cabinet = \Yii::$app->cabinet;
        $account = $cabinet->getAccount();

        $r = $account->getIntercoms(DeviceCategory::CALL_PANEL);

//        $r = $account->getIntercoms()[0]->unlock();

        var_dump($r);

exit;

        exit;
    }

    public function actionError()
    {
        return 'Error';
    }
}