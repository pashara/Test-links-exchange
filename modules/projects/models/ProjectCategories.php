<?php

namespace app\modules\projects\models;

use kartik\tree\models\Tree;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%project_categories}}".
 *
 * @property integer $id
 * @property integer $parent
 * @property string $title
 * @property integer $sort
 * @property integer $enabled
 * @property integer parent_title
 *
 * @property ProjectToCategories[] $projectToCategories
 * @property mixed parents
 */
class ProjectCategories extends  Tree
{
    /**
     * @inheritdoc
     */
    public $parent_title;
    public static function tableName()
    {
        return '{{%project_categories}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectToCategories()
    {
        return $this->hasMany(ProjectToCategories::className(), ['category_id' => 'id']);
    }

    /*public function getParents()
    {
        //return $this->hasOne(ProjectCategories::className(),['id'=>'parent']);
        //return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }*/

    public static function getAllCategoriesArray()
    {
        $id = 'all_categories';
        if(Yii::$app->cache->get("cat_{$id}") === false)
        {
            $model = self::find()->where(['active'=>1])->addOrderBy('root, lft')->all();
            Yii::$app->cache->set("cat_{$id}",$model,30);
        }else{
            $model = Yii::$app->cache->get("cat_{$id}");
        }

        return $model;
    }



}
