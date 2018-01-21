<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Employee]].
 *
 * @see \common\models\Employee
 */
class EmployeeQuery extends \yii\db\ActiveQuery
{

    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['{{%employee}}.id' => $id]);
    }


    /**
     * @param $slug
     * @return $this
     */
    public function bySlug($slug)
    {
        return $this->andWhere(['{{%page}}.slug' => $slug]);
    }

    /**
     * @inheritdoc
     * @return \common\models\Employee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Employee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
