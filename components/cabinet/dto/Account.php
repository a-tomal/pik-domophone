<?php


namespace app\components\cabinet\dto;


use yii\base\BaseObject;
use yii\base\Exception;
use yii\helpers\Inflector;
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
class Account extends BaseObject
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

    /**
     * @param array|null $hydrateData
     * @return static|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function hydrate(array $hydrateData = null): ?self
    {
        if ($hydrateData && isset($hydrateData['account'])) {
            $account = $hydrateData['account'];
            $keys = array_map(static fn($key) => Inflector::variablize($key), array_keys($account));
            $data = array_combine($keys, array_values($account));
            $data['class'] = self::class;

            return \Yii::createObject($data);
        }

        return null;
    }

    /**
     * @param string $phone
     * @return $this
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function find(string $phone): self
    {
        if (static::isExistsUserData($phone) && ($data = static::getUserData($phone))) {
            return static::hydrate($data);
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