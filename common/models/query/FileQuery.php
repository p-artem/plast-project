<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\File]].
 *
 * @see \common\models\Price
 */
class FileQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return \common\models\Price[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Price|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
