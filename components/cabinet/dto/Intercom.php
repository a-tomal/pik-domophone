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

    public function unlock(): bool
    {
        return IntercomRepository::unlock($this->id, $this->account->token);
    }
}