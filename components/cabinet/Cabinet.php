<?php


namespace app\components\cabinet;


use yii\base\Component;

class Cabinet extends Component
{
    public $username;
    public $password;
    public $udid;

    public $cabinetRepository;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->cabinetRepository = new CabinetRepository();

        var_dump($this->cabinetRepository->login($this->username, $this->password, '1'));
    }
}