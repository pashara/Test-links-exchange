<?php

namespace app\modules\projects\requirements;

use app\modules\projects\models\LinksRequirements;
use app\modules\projects\models\ProjectLinks;
use Yii;

class Avatar extends RequirementsModel
{



    public $value;
    public $id = 2;
    public $cost = [parent::RUB=>20,parent::USD=>10,parent::UAH=>25];

    public function __construct(array $config = [],$selectedItemsNames)
    {
        parent::__construct($config);
    }

    public function getSQLSuitableLinksIDs(){
        if($this->value == 0)
            return true;
        return 'SELECT lr.link_id FROM {{%links_requirements}} lr
                WHERE lr.value = '.$this->value.' AND lr.requirement_id = '.$this->id.'
                GROUP BY lr.link_id';
    }

    public function loadData($data){

        $this->value = $data['value'];
    }

    public function getValue(){
        return $this->value;
    }

    public function render($form,$model){
        return $form->field($model, 'value')->checkbox(['data'=>$this->cost,'class'=>'costField']);
    }


    public function attributeLabels() {
        return [
            'value' => 'Наличие автара',
        ];
    }

    public function rules()
    {
        return [
            [['value'], 'required','requiredValue' => 1, 'message' => 'my test message'],
            [['value'], 'integer'],
        ];
    }

}
