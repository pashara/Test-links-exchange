<?php

namespace app\modules\projects\models;

use app\models\Currency;
use Yii;

/**
 * This is the model class for table "{{%project_links_cost}}".
 *
 * @property integer $id
 * @property integer $link_id
 * @property integer $currency_id
 * @property double $value
 *
 * @property Currency $currency
 * @property ProjectLinks $link
 */
class ProjectLinksCost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project_links_cost}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_id', 'currency_id', 'value'], 'required'],
            [['link_id', 'currency_id'], 'integer'],
            [['value'], 'number'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['link_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectLinks::className(), 'targetAttribute' => ['link_id' => 'id']],
        ];
    }


    public function getCurrencyName(){
        return $this->hasOne(Currency::className(),['id'=>'currency_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('projects', 'ID'),
            'link_id' => Yii::t('projects', 'Link ID'),
            'currency_id' => Yii::t('projects', 'Currency ID'),
            'value' => Yii::t('projects', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(ProjectLinks::className(), ['id' => 'link_id']);
    }

    /**
     * @inheritdoc
     * @return ProjectLinksCostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectLinksCostQuery(get_called_class());
    }
}
