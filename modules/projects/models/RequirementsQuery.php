<?php

namespace app\modules\projects\models;

/**
 * This is the ActiveQuery class for [[Project]].
 *
 * @see Project
 */
class RequirementsQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Project[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Project|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
