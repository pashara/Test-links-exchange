<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property integer $user_id
 */
class Settings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','part'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 225],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'   => Yii::t('app', 'User ID'),
            'group_id'  => Yii::t('app', 'Group ID'),
            'username'  => Yii::t('app', 'Username'),
            'password'  => Yii::t('app', 'Password'),
            'accessToken' => Yii::t('app', 'accessToken'),
            'authKey'   => Yii::t('app', 'authKey'),
        ];
    }

    public static function get($part,$field){
        $item = Yii::$app->db->createCommand('SELECT * FROM {{%settings}} p  WHERE  p.part=:part  AND p.name=:name', [
            ':part' => $part,
            ':name' => $field
        ])->queryOne();
        if($item)
            return $item['value'];
        else
            return null;
    }


}
