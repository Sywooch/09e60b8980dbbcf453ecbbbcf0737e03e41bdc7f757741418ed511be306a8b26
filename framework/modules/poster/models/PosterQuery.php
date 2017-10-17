<?php

namespace app\modules\poster\models;

/**
 * This is the ActiveQuery class for [[Poster]].
 *
 * @see Poster
 */
class PosterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Poster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Poster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
