<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property integer $type
 *
 * @property CurrencyType $type0
 * @property ProjectLinksCost[] $projectLinksCosts
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'code', 'type'], 'required'],
            [['type'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [['code'], 'string', 'max' => 5],
            [['allow_to_see','allow_to_input','sort'], 'integer'],
            [['allow_to_see','allow_to_input'], 'in', 'range'=>[0,1]],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => CurrencyType::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('projects', 'ID'),
            'title' => Yii::t('projects', 'Title'),
            'code' => Yii::t('projects', 'Code'),
            'type' => Yii::t('projects', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(CurrencyType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectLinksCosts()
    {
        return $this->hasMany(ProjectLinksCost::className(), ['currency_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CurrencyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CurrencyQuery(get_called_class());
    }
}
