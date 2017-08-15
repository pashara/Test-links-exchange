<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%currency_type}}".
 *
 * @property integer $id
 * @property string $format
 * @property string $parametr
 *
 * @property Currency[] $currencies
 */
class CurrencyType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['format', 'parametr'], 'required'],
            [['format'], 'string', 'max' => 50],
            [['parametr'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('projects', 'ID'),
            'format' => Yii::t('projects', 'Format'),
            'parametr' => Yii::t('projects', 'Parametr'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencies()
    {
        return $this->hasMany(Currency::className(), ['type' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CurrencyTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CurrencyTypeQuery(get_called_class());
    }
}
