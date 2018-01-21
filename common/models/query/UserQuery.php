<?php

namespace common\models\query;

use common\models\User;
use yii\db\ActiveQuery;

/**
 * Class UserQuery
 * @package common\models\query
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserQuery extends ActiveQuery
{
    /**
     * @param int $exception_id
     * @return array
     */
    public function getList($exception_id = 0)
    {
        $this->select(["CONCAT(email, ' ', username)", 'id'])
            ->orderBy('email')
            ->indexBy('id');
        if ($exception_id){
            $this->andWhere(['!=', 'id', $exception_id]);
        }
        return $this->column();
    }

    /**
     * @return $this
     */
    public function withProfile()
    {
        $this->joinWith('userProfile profile');
        return $this;
    }

    /**
     * @return $this
     */
    public function buyers()
    {
        $this->innerJoin('rbac_auth_assignment', 'user.id = rbac_auth_assignment.user_id')
            ->andWhere(['rbac_auth_assignment.item_name' => User::ROLE_USER]);
        return $this;
    }

    /**
     * @return $this
     */
    public function notBuyers()
    {
        $this->innerJoin('rbac_auth_assignment', 'user.id = rbac_auth_assignment.user_id')
            ->andWhere(['!=', 'rbac_auth_assignment.item_name', User::ROLE_USER]);
        return $this;
    }

    /**
     * @return $this
     */
    public function notDeleted()
    {
        $this->andWhere(['!=', 'status', User::STATUS_DELETED]);
        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => User::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterByView()
    {
        $this->andWhere(['view' => User::STATUS_ACTIVE]);
        return $this;
    }
}