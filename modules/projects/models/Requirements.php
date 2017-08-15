<?php

namespace app\modules\projects\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $id
 * @property integer $enable
 * @property integer $sort
 * @property string $class
 *
 */
class Requirements extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%requirements}}';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','class','name'], 'required'],
            [['id','sort','enable'],'integer'],
            [['sort','enable'], 'in','range'=>[0,1]],
            [['class'], 'string', 'max' => 255, 'min'=>1],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('projects', 'ID'),
            'project_id' => Yii::t('projects', 'Project ID'),
            'name' => Yii::t('projects', 'Title'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequirementsQuery(get_called_class());
    }
}
