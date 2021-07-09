<?php


namespace app\components\cabinet\dto;


use app\components\cabinet\IntercomRepository;

class Intercom extends Dto
{
    public $id;
    public $schemeId;
    public $buildingId;
    public $kind;
    public $name;
    public $humanName;
    public $renamedName;
    public $ipAddress;
    public $entrance;
    public $deviceCategory;
    public $mode;
    public $relays;
    public $checkpointRelayIndex;
    public $sipAccount;
    public $canAddress;
    public $faceDetection;
    public $video;
    public $photoUrl;

    public Account $account;

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function unlock(): bool
    {
        return IntercomRepository::unlock($this->id, $this->account->token);
    }
}