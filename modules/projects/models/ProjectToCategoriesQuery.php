<?php

namespace app\modules\projects\models;

/**
 * This is the ActiveQuery class for [[ProjectToCategories]].
 *
 * @see ProjectToCategories
 */
class ProjectToCategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProjectToCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectToCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
