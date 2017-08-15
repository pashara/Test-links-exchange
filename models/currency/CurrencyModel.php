<?php

namespace app\models\currency;

use app\models\Currency;
use app\modules\projects\models\LinksRequirements;
use app\modules\projects\models\ProjectLinksCost;
use app\modules\projects\models\ProjectLinksCostQuery;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CurrencyModel extends Model {

    public $code = 'RUB';
    public $link_id = null;
    public $value;
    private $currencyModel = false;
    private $loadedModel = false;



    public static function format($value){
        return $value;
    }

    public function getInfo() {
        if ($this->currencyModel === false) {
            $this->currencyModel = Currency::find()->where(['code' => $this->code])->one();
        }
        return $this->currencyModel;
    }

    public function getInfoWithLink($loadValue = true) {
        $this->getInfo();
        if ($this->loadedModel === false)
            $this->loadedModel = ProjectLinksCost::find()->where(['currency_id' => $this->currencyModel->id])->andWhere(['link_id' => $this->link_id])->one();
        if($loadValue)
            $this->value = $this->loadedModel->value;
        return $this->loadedModel;
    }


    public function loadData($data){
        $this->value = $data['value'];
    }

    public function saveByLinkID($link_id){
        if($link_id != null) {
            $model = new ProjectLinksCost();
            $model->link_id = $link_id;
            $model->currency_id = $this->getInfo()->id;
            $model->value = $this->value;
            $model->save();
        }
    }

/**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['value'], 'required', 'on'=>self::SCENARIO_DEFAULT_CURRENCY],
        ];
    }





    const SCENARIO_DEFAULT_CURRENCY = 'defaultCurrency';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT_CURRENCY] = ['value'];
        return $scenarios;
    }



}
