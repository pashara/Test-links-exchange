<?php

namespace app\modules\projects\requirements;

use Yii;

class Pay extends RequirementsModel
{

    public $value;
    public $id = 4;
    public $cost = [parent::RUB=>20,parent::USD=>10,parent::UAH=>25];


    public function __construct(array $config = [],$selectedItemsNames)
    {
        parent::__construct($config);
    }

    public function loadData($data){

        $this->value = $data['value'];
    }

    public function getValue(){
        return $this->value;
    }


    public function getSQLSuitableLinksIDs(){
        return 'SELECT lr.link_id FROM {{%links_requirements}} lr
                WHERE lr.value = '.$this->value.' AND lr.requirement_id = '.$this->id.'
                GROUP BY lr.link_id';
    }

    public function render($form,$model){
        echo $form->field($model, 'value')->textInput(['maxlength' => 4]);
    }

    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'integer'],
        ];
    }

}
