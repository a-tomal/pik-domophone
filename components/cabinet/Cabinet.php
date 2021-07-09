<?php


namespace app\components\cabinet;


use app\components\cabinet\dto\Account;
use yii\base\Component;

class Cabinet extends Component
{
    public $username;
    public $password;
    public $udid;

    protected $cabinetRepository;
    protected $account;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->cabinetRepository = new CabinetRepository();
    }

    /**
     * @return Account
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getAccount(): Account
    {
        if (null === $this->account) {
            $this->account = $this->cabinetRepository->login($this->username, $this->password, $this->udid);
        }

        return $this->account;
    }
}