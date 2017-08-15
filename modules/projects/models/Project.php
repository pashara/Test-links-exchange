<?php

namespace app\modules\projects\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 *
 * @property ProjectToCategories[] $projectToCategories
 */
class Project extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    public function afterFind()
    {
        $this->description = stripslashes(htmlspecialchars_decode($this->description));
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->description = htmlspecialchars($this->description);
            return true;
        }
        return false;
    }


    public function getCategories()
    {
        return $this->hasMany(ProjectCategories::className(), ['id' => 'id'])
            ->viaTable(ProjectToCategories::tableName(), ['project_id' => 'id']);
    }

    public function getCategoriesArray($project_id = 0){
        $project_id = ($project_id <= 0)?$this->id:$project_id;
        if($project_id)
           $categories = Yii::$app->db->createCommand('SELECT t.id,t.root,t.name,t.disabled FROM {{%project_to_categories}} p  INNER JOIN {{%project_categories}} t ON p.category_id = t.id WHERE p.project_id = :project_id', [':project_id' =>$project_id])->queryAll();
        else
            $categories = NULL;
        /**/

        return $categories;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 80],
            ['description', 'safe']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectToCategories()
    {
        return $this->hasMany(ProjectToCategories::className(), ['project_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
}
