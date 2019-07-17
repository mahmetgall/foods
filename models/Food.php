<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "food".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 */
class Food extends MainActivityRecord
{
    const MIN_INGREDIENT = 3; // показывать блюда состоящие минимум из стольки ингредиентов


    public $ingredients_data;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'foods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['name', 'required', 'message' => 'Задайте название'],
            ['ingredients_data', 'required', 'message' => 'Задайте не менее 3 ингредиентов'],
            ['ingredients_data', 'validateIngredients'],
        ];
    }


    public function validateIngredients($attr) {

        if (!is_array($this->ingredients_data)) {
            $this->addError('ingredients_data', 'Задайте не менее 3 ингредиентов');

        } else {
            if (count($this->ingredients_data) < Food::MIN_INGREDIENT) {
                $this->addError('ingredients_data', 'Задайте не менее 3 ингредиентов');
            }
        }

    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /*
   * relations
   *
   * получить соединение с projects по 2 таблицам
   * yii2
   */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::class, ['id' => 'ingredient_id' ])
            ->viaTable('food_ingredient', ['food_id' => 'id']);
    }

    /**
     *
     *
     */
    public static function find()
    {
        return new FoodQuery(get_called_class());
    }

    /*
     * Запись ингредиентов в блюдо
     */
    public function saveIngredients()
    {
        $oldFood = Food::find()->where(['id' => $this->id])->with(['ingredients'])->asArray()->one();

        $new_ingredients = $this->ingredients_data;
        $old_ingredients = array_column($oldFood['ingredients'], 'id');

        $add_ids = array_diff($new_ingredients, $old_ingredients);
        $del_ids = array_diff($old_ingredients, $new_ingredients);

        // добавить выбранные ингредиенты
        if (!empty($add_ids)) {
            foreach ($add_ids as $id) {
                $model = new FoodIngredient();
                $model->setAttributes([
                    'food_id' => $this->id,
                    'ingredient_id' => $id
                ]);


                if (!$model->save()) {

                }
            }
        }

        // удалить ингредиенты
        if (!empty($del_ids)) {
            Yii::$app->db->createCommand('DELETE FROM food_ingredient WHERE food_id = '. $this->id .
                                              ' AND ingredient_id IN (' . implode(',', $del_ids).')'
                                        )->execute();

        }

    }

    public static function getFoodsByIngredients($ingredients)
    {
        $count_ingredients = count($ingredients);

        // искать блюда с полным совпадением ингредиентов
        $result_max = Yii::$app->db->createCommand(' SELECT f.*,COUNT(*) AS count_ing FROM food_ingredient fi
                                                      LEFT JOIN foods f ON fi.food_id=f.id 
                                                      INNER JOIN ingredients i ON fi.ingredient_id = i.id AND i.status = ' .Ingredient::STATUS_ACTIVE. '
                                                      WHERE fi.ingredient_id IN (' . implode(',', $ingredients).') 
                                                      GROUP BY fi.food_id HAVING 
                                                                            COUNT(*) = (SELECT COUNT(*) FROM food_ingredient WHERE food_id=f.id GROUP BY food_id HAVING COUNT(*) = '.$count_ingredients.')
                                                                            AND COUNT(*)>' . Food::MIN_INGREDIENT .
                                                    ' ORDER BY COUNT(*) DESC'
        )->queryAll();

        if (!empty($result_max)) {
            return $result_max;
        }

        // искать с частичным совпадением ингредиентов
        $result = Yii::$app->db->createCommand(' SELECT f.*,COUNT(*) AS count_ing FROM food_ingredient fi
                                                      LEFT JOIN foods f ON fi.food_id=f.id 
                                                      INNER JOIN ingredients i ON fi.ingredient_id = i.id AND i.status = ' .Ingredient::STATUS_ACTIVE. '
                                                      WHERE fi.ingredient_id IN (' . implode(',', $ingredients).') 
                                                      GROUP BY fi.food_id HAVING COUNT(*)>' . Food::MIN_INGREDIENT . ' ORDER BY COUNT(*) DESC'
                                              )->queryAll();

        return $result;
    }

}
