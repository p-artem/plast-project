<?php

namespace common\models\query;

use common\models\Contact;

/**
 * This is the ActiveQuery class for [[\common\models\Contact]].
 *
 * @see \common\models\Contact
 */
class ContactQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @return $this
     */
    public function notActive()
    {
        return $this->andWhere('[[status]]=0');
    }

    /**
     * @param $type
     * @return $this
     */
    public function type($type){
        return $this->andWhere(['type' => $type]);
    }

    /**
     * @return $this
     */
    public function sorting(){
        return  $this->orderBy(['id' => SORT_DESC]);
    }

    /**
     * @return $this
     */
    public function byTypeSubscribe(){
        return $this->andWhere(['type' => Contact::TYPE_SUBSCRIBE]);
    }

    /**
     * @return $this
     */
    public function byTypeContactUs(){
        return $this->andWhere(['type' => Contact::TYPE_CONTACT_US]);
    }

    /**
     * @inheritdoc
     * @return \common\models\Contact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Contact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
