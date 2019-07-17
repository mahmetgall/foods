<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Ingredient]].
 *
 * @see Ingredient
 */
class IngredientQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Ingredient[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Ingredient|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    

    public function active() {
        $alias = Ingredient::tableName();
        return $this->andWhere([$alias.'.status' => Ingredient::STATUS_ACTIVE]);

    }

}
