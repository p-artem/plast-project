<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 8/5/14
 * Time: 10:46 AM
 */

namespace common\models\query;

use yii\db\ActiveQuery;

class TimelineEventQuery extends ActiveQuery
{
    public function today()
    {
        $this->andWhere(['>=', 'created_at', strtotime('today midnight')]);
        return $this;
    }
}