<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "food_ingredient".
 *
 * @property int $id
 * @property int $food_id
 * @property int $ingredient_id
 */
class FoodIngredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'food_ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['food_id', 'ingredient_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'food_id' => 'Food ID',
            'ingredient_id' => 'Ingredient ID',
        ];
    }
}
