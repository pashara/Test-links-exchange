<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CurrencyType]].
 *
 * @see CurrencyType
 */
class CurrencyTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CurrencyType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CurrencyType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
