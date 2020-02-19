<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserForm]].
 *
 * @see UserForm
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
