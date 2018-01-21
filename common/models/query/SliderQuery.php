<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Slider]].
 *
 * @see \common\models\Slider
 */
class SliderQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @param $position
     * @return $this
     */
    public function byPosition($position){
        return $this->andWhere(['position' => $position]);
    }

    /**
     * @inheritdoc
     * @return \common\models\Slider[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Slider|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
