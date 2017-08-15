<?php

namespace app\modules\users\models;

use app\models\currency;
use app\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property integer $user_id
 * @property integer currency_id
 * @property float $value
 */
class UsersBalance extends ActiveRecord {
    private $defaultCurrencyId = 1;
    private $defaultCurrencyCode = 'RUB';
    private $maxOnce = 100;

    public function getDefaultCurrency(){
        return ['id'=>$this->defaultCurrencyId,'code'=>$this->defaultCurrencyCode];
    }

    /**
     * @param int $count
     * @param $user_id
     * @return bool
     * Каждый новый пользовател должен иметь счёт. При его отсутвии он заводится
     */
    private function createNewBalance($count = 0, $user_id){
        $model = new UsersBalance;
        $model->user_id = $user_id;
        $model->currency_id = $this->defaultCurrencyId;
        $model->value = $count;
        return ($model->save())?$model:false;
    }

    public function addInBalance($count,$user_id){
        if($count >= 0 && $count <= $this->maxOnce ) {
            $data = self::find()->where(['user_id' => $user_id])->joinWith('currency')->one();
            if ($data) {
                $data->value += $count;
                if($data->save())
                    return true;
            } else {
                $model = $this->createNewBalance($count,$user_id);
                if($model)
                    return true;
            }
        }
        return false;
    }


    public function getBalance($user_id) {
        $data = self::find()->where(['user_id' => $user_id])->joinWith('currency')->one();
        if($data){
            $data = $this->createNewBalance(0,$user_id);
            if(!$data)
                return 0;
        }
        return $data->value;
    }
    public function getBalanceInFormat($user_id) {
        $data = self::find()->where(['user_id' => $user_id])->joinWith('currency')->one();
        if(!$data){
            return 'Currency ERROR';
        }
        $currency_CLASS = 'app\models\currency\Currency'.$data->currency->code;
        return $currency_CLASS::format($this->getBalance($user_id));
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_balance}}';
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'currency_id', 'value'], 'required'],

            [['user_id'], 'exist', 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['currency_id'], 'exist', 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
        ];
    }

    /**
     * @inheritdoc
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find() {
        return new UsersBalanceQuery(get_called_class());
    }

}
