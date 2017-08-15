<?php

namespace app\modules\projects\requirements;

use app\modules\projects\models\LinksRequirements;
use yii\base\Model;
use yii\bootstrap\Html;


abstract class RequirementsModel extends Model {

    const RUB = 1;
    const USD = 2;
    const UAH = 3;


    public $value;
    public $id = null;
    public $link_id = null;

    public function render($form,$model){
        return $form->field($model, 'value')->textInput(['maxlength' => 4]);
    }

    abstract public function getValue();

    /**
     * @return mixed
     * Must return IDs of suitable links
     */
    abstract public function getSQLSuitableLinksIDs();

    public function loadDataFromDB(){
        if($this->link_id) {
            $model = LinksRequirements::find()->where(['link_id' => $this->link_id])->andWhere(['requirement_id' => $this->id])->one();
            $this->value = $model->value;
        }
    }


    public function saveByLinkID($link_id){
        if($this->id != null) {
            $model = new LinksRequirements();
            $model->link_id = $link_id;
            $model->requirement_id = $this->id;
            $model->value = $this->getValue();
            $model->save();
        }
    }


}
