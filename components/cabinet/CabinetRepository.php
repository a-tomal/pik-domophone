<?php


namespace app\components;


use yii\helpers\Json;

class CabinetRepository
{
    public function login($username, $password, $udid, $force = false): ?string
    {
        if (!$force && $this->isUserDataExists($username)) {
            $data = $this->getUserData($username);

            return $data['token'] ?? null;
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
            $data['token'] = $token;
            $this->saveUserData($username, $data);

            return $token;
        }

        return null;
    }

    protected function isUserDataExists($username): bool
    {
        $filePath = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . $username . '.json';

        return file_exists($filePath);
    }

    protected function saveUserData($username, $data): void
    {
        $filePath = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . $username . '.json';

        file_put_contents($filePath, Json::encode($data));
    }

    protected function getUserData($username): array
    {
        $filePath = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . $username . '.json';

        return Json::decode(file_get_contents($filePath));
    }
}