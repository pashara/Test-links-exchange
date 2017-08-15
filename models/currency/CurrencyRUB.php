<?php

namespace app\models\currency;

use app\models\Currency;
use app\modules\projects\models\ProjectLinksCost;
use app\modules\projects\models\ProjectLinksCostQuery;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CurrencyRUB extends CurrencyModel {

    public $code = 'RUB';
    public $link_id = null;
    public $value;





    public static function format($value){
        return Yii::$app->formatter->asDecimal($value).'₽';
    }


    public function rules() {
        return parent::rules();
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'value' => 'RUB',
        ];
    }

}
