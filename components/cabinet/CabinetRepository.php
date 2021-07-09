<?php


namespace app\components\cabinet;


use app\components\cabinet\dto\Account;

class CabinetRepository
{
    /**
     * @param $username
     * @param $password
     * @param $udid
     * @param false $force
     * @return Account|null
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function login($username, $password, $udid, $force = false): ?Account
    {
        if (!$force && Account::isExistsUserData($username)) {
            return Account::find($username);
        }

        $client = new IntercomClient();
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
}