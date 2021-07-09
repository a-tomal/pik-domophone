<?php


namespace app\components\cabinet;


use app\components\cabinet\dto\Account;
use app\components\cabinet\dto\Intercom;

class CabinetRepository
{
    /**
     * @param $username
     * @param $password
     * @param $udid
     * @param false $force
     * @return array|false|object|null
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function login($username, $password, $udid, $force = false): ?Account
    {
        if (!$force && Account::isExistsUserData($username)) {
            return Account::find($username);
        }

        $client = new PikDomophoneClient();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('customers/sign_in')
            ->setData([
                'account[phone]' => $username,
                'account[password]' => $password,
                'customer_device[uid]' => $udid
            ])
            ->send();

        if ($response->isOk && ($data = $response->getData()) && isset($data['account'])) {
            $headers = $response->getHeaders();
            $authorization = $headers->get('authorization');
            $tmp = explode(' ', $authorization) ?? null;

            $token = $tmp[1] ?? null;
            $data['account']['token'] = $token;

            Account::saveUserData($username, $data);

            return Account::find($username);
        }

        return null;
    }

    /**
     * @param $apartmentId
     * @param $userToken
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public static function getIntercoms($apartmentId, $userToken): array
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
}