<?php


namespace app\components\cabinet;


use app\components\cabinet\dto\Intercom;

class IntercomRepository
{
    /**
     * @param $apartmentId
     * @param $userToken
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public static function list($apartmentId, $userToken): array
    {
        $client = new PikDomophoneClient();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl("customers/properties/{$apartmentId}/intercoms")
            ->addHeaders([
                'Authorization' => "Bearer $userToken"
            ])
            ->send();

        if ($response->isOk && ($data = $response->getData())) {
            $intercoms = [];

            foreach ($data as $intercom) {
                $intercoms[] = Intercom::hydrate($intercom);
            }

            return $intercoms;
        }

        return [];
    }

    /**
     * @param $intercomId
     * @param $userToken
     * @return false|mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public static function unlock($intercomId, $userToken)
    {
        $client = new PikDomophoneClient();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl("customers/intercoms/{$intercomId}/unlock")
            ->addHeaders([
                'Authorization' => "Bearer $userToken"
            ])
            ->send();

        if ($response->isOk && ($data = $response->getData())) {
            return $data['request'] ?? false;
        }

        return false;
    }
}