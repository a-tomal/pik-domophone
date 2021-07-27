<?php


namespace app\controllers;


use app\components\cabinet\Cabinet;
use app\components\cabinet\DeviceCategory;
use app\components\cabinet\dto\Intercom;
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

    public function actionRtspStreamUri()
    {
        $cabinet = \Yii::$app->cabinet;
        $rtsp = [];

        try {
            $account = $cabinet->getAccount();
            $intercoms = $account->getIntercoms(DeviceCategory::CALL_PANEL);

            /** @var Intercom $intercom */
            foreach ($intercoms as $intercom) {
                $rtsp[] = $intercom->video[0]['source'] ?? '';
            }
        } catch (\Exception $e) {
        }

        return $rtsp;
    }
}