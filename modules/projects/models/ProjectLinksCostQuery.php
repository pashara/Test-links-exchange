<?php

namespace app\modules\projects\models;

/**
 * This is the ActiveQuery class for [[ProjectLinksCost]].
 *
 * @see ProjectLinksCost
 */
class ProjectLinksCostQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProjectLinksCost[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectLinksCost|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
