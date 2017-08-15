<?php

namespace app\modules\projects\models;

use Yii;

/**
 * This is the model class for table "{{%project_links}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $alias
 * @property string $enable
 * @property string $number
 * @property double $default_currency
 */
class LinksRequirements extends \yii\db\ActiveRecord
{
    public function getRequirement()
    {
        return $this->hasOne(Requirements::className(), ['id' => 'requirement_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%links_requirements}}';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('projects', 'ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProjectLinksQuery the active query used by this AR class.
     *
    public static function find()
    {
        return new ProjectLinksQuery(get_called_class());
    }*/
}
