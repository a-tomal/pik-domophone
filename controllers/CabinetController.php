<?php


namespace app\controllers;


use app\components\cabinet\Cabinet;
use app\components\cabinet\DeviceCategory;
use yii\rest\Controller;
use yii\web\ServerErrorHttpException;

class CabinetController extends Controller
{
    public function actionIndex()
    {
        /** @var Cabinet $cabinet */
        $cabinet = \Yii::$app->cabinet;

        try {
            $account = $cabinet->getAccount();
            $intercoms = $account->getIntercoms(DeviceCategory::CALL_PANEL);
            $result = true;

            foreach ($intercoms as $intercom) {
                $result *= $intercom->unlock();
            }

            return (bool)$result;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());

            throw new ServerErrorHttpException();
        }
    }
}