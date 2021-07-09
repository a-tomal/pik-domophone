<?php


namespace app\components\cabinet\dto;


use app\components\cabinet\CabinetRepository;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * Class Account
 * @package app\components\cabinet\models
 *
 * @property $id
 * @property $apartmenId
 * @property $number
 * @property $firstName
 * @property $middleName
 * @property $lastName
 * @property $phone
 * @property $email
 * @property $token
 */
class Account extends Dto
{
    public $id;
    public $apartmentId;
    public $number;
    public $firstName;
    public $middleName;
    public $lastName;
    public $phone;
    public $email;
    public $token;

    public function getIntercoms()
    {
        return CabinetRepository::getIntercoms($this->apartmentId, $this->token);
    }

    /**
     * @param string $phone
     * @return array|false|object
     * @throws Exception
     */
    public static function find(string $phone)
    {
        if (static::isExistsUserData($phone) && ($data = static::getUserData($phone))) {
            return static::hydrate($data['account'] ?? []);
        }

        throw new Exception('User data not found');
    }

    /**
     * @param $phone
     * @return bool
     */
    public static function isExistsUserData($phone): bool
    {
        return file_exists(static::getCacheFolder($phone));
    }

    /**
     * @param $phone
     * @param $data
     */
    public static function saveUserData($phone, $data): void
    {
        file_put_contents(static::getCacheFolder($phone), Json::encode($data));
    }

    /**
     * @param $phone
     * @return array
     */
    public static function getUserData($phone): array
    {
        return Json::decode(file_get_contents(static::getCacheFolder($phone)));
    }

    /**
     * @param $phone
     * @return string
     */
    public static function getCacheFolder($phone): string
    {
        return \Yii::getAlias(sprintf('@cabinet/%s.json', $phone));
    }
}