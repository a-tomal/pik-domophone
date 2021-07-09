<?php


namespace app\components\cabinet;


use app\components\cabinet\dto\Account;
use yii\base\Component;

class Cabinet extends Component
{
    public $username;
    public $password;
    public $udid;

    public $cabinetRepository;
    public ?Account $account;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->cabinetRepository = new CabinetRepository();
        $this->account = $this->cabinetRepository->login($this->username, $this->password, $this->udid);

        $this->account->getIntercoms();
    }
}