<?php

namespace common\models\query;
use common\models\CompanyContact;

/**
 * This is the ActiveQuery class for [[\common\models\CompanyContact]].
 *
 * @see \common\models\CompanyContact
 */
class CompanyContactQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['{{%company_contact}}.status' => CompanyContact::STATUS_ACTIVE]);
    }

    /**
     * @return $this
     */
    public function ascSorted()
    {
        return $this->orderBy(['{{%company_contact}}.sorting' => SORT_ASC]);
    }

    /**
     * @return array
     */
    public function getСoordinates()
    {
        return $this->select(['name', 'address', 'lat', 'lng', 'type' => 'CONCAT("2")'])->asArray()->all();
    }

    /**
     * @param null $db
     * @return array|CompanyContact[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|null|CompanyContact
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
