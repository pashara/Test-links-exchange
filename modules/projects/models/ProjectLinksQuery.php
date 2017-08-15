<?php

namespace app\modules\projects\models;

/**
 * This is the ActiveQuery class for [[ProjectLinks]].
 *
 * @see ProjectLinks
 */
class ProjectLinksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProjectLinks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectLinks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
