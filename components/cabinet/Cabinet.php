<?php


namespace app\components;


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

        var_dump($this->cabinetRepository->login($this->username,$this->password,'1'));
    }

}

//{"account":{"id":158503,"apartment_id":168233,"number":"54441","first_name":null,"middle_name":null,"last_name":null,"phone":"+79114970004","email":null},"customer_devices":[{"id":275116,"account_id":158503,"apartment_id":null,"model":"iPhone13,4","kind":"mobile","firmware_version":null,"uid":"8C1C833B-D55F-4339-8BA5-82D440723569","mac_address":null,"os":"ios","deleted_at":null,"sip_account":{"ex_user":25665162,"proxy":"intercom.pik-comfort.ru:9060","realm":null,"ex_enable":false,"alias":null,"remote_request_status":"success","password":"bla3dbycv18823s2"}},{"id":313115,"account_id":158503,"apartment_id":null,"model":"iPhone13,4","kind":"mobile","firmware_version":null,"uid":"891747C6-DD36-458A-894D-7E60DC67C8B0","mac_address":null,"os":"ios","deleted_at":null,"sip_account":{"ex_user":66206571,"proxy":"intercom.pik-comfort.ru:9060","realm":null,"ex_enable":false,"alias":null,"remote_request_status":"success","password":"ihrvrfvacr4jiwi0"}}]}