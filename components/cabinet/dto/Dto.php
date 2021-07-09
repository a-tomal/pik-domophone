<?php


namespace app\components\cabinet\dto;


use yii\base\BaseObject;
use yii\helpers\Inflector;

class Dto extends BaseObject
{
    public static function hydrate(array $hydrateData = null)
    {
        $keys = array_map(static fn($key) => Inflector::variablize($key), array_keys($hydrateData));
        $data = array_combine($keys, array_values($hydrateData));
        $data['class'] = static::class;

        return \Yii::createObject($data);
    }
}