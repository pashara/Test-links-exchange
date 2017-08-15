<?php

namespace app\modules\projects\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $user_id
 * @property integer $link_id
 * @property integer $type_link
 * @property integer $status
 * @property string $data
 * @property string $date_start
 * @property string $date_end
 */
class LinksProcessing extends ActiveRecord {
    private $start_numbers_to_allow = 10;

    const TYPE_ONE = 0;
    const TYPE_MANY = 1;

    const STATUS_BEGINNING = 1;
    const STATUS_MODERATING = 2;
    const STATUS_CANCELED = 3;
    const STATUS_COMPLETING = 4;

    public $mainCurrencyValue;

    private $value;



    public $link_title;
    public $link_number;
    public $link_enable;
    public $link_alias;
    public $link_allow_once;




    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%links_processing}}';
    }


    /**
     * Генерация полей формы для определенной ссылки
     */
    public function generateNewProcess($link_model, $try_do_many_links = false, $user_id = false) {
        if ($user_id === false)
            $user_id = Yii::$app->user->id;
        $this->user_id = $user_id;
        $this->link_id = $link_model->id;
        $this->type_link = ($link_model->number >= $this->start_numbers_to_allow) ? self::TYPE_MANY : self::TYPE_ONE;
        $this->status = self::STATUS_BEGINNING;


        $mainCurrency = $link_model->getMainCurrency();
        $this->value['cost']['id'] = $mainCurrency->currency->id;
        $this->value['cost']['code'] = $mainCurrency->currency->code;
        $this->value['cost']['value'] = $mainCurrency->value;

        foreach ($link_model->getNotMainCurrency() as $c) {
            $this->value['cost']['other'][] = [
                'id' => $c->id,
                'code' => $c->currency->code,
                'value' => $c->value,
            ];
        }

        $this->value['count'] = [
            'needed' => ($link_model->number >= $this->start_numbers_to_allow) ? $link_model->allow_once : 1,
            'processed' => 0,
            'do_many' => false,
        ];
    }


    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->data = json_encode($this->value);
            return true;
        }
        return false;
    }

    public function afterFind() {
        parent::afterFind();
        if (parent::afterFind()) {
            $this->mainCurrencyValue = 50;
            $this->data = json_decode($this->value);
            return true;
        }
        return false;
    }


    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->data = json_encode($this->value);

            //$finded_model =

            /*if($this->value['count']['do_many'] == true && $this->value['count']['processed'] <= $this->value['count']['needed']){
                $this->addError('user_id', 'Пользоваетль уже начинал выполнять это заданиеFAIL.');
            }else {
                $this->addError('user_id', 'Пользоваетль уже начинал выполнять это задание.');
            }*/

            return true;
        }
        return false;
    }


    public function afterValidate() {
        if (parent::afterValidate()) {
            $this->data = json_decode($this->value);
            return true;
        }
        return false;
    }


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'link_id', 'type_link', 'status', 'data'], 'required']
        ];
    }



    public function getLink()
    {
        return $this->hasOne(ProjectLinks::className(), ['id' => 'link_id'])->
        from(ProjectLinks::tableName() . ' AS link');
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('projects', 'ID'),
            'title' => Yii::t('projects', 'Title'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProjectQuery(get_called_class());
    }
}
