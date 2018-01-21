<?php

namespace common\models\query;

use common\models\Social;
/**
 * This is the ActiveQuery class for [[\common\models\Social]].
 *
 * @see \common\models\Social
 */
class SocialQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => Social::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return \common\models\Social[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Social|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function sorting(){
        return $this->orderBy(['sorting' => SORT_ASC]);
    }
}
