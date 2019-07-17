<?php

use yii\db\Migration;


/**
 * Class m190716_075614_init_tables
 */
class m190716_075614_init_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // блюда
        $this->createTable('{{foods}}', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255)',
            'created_at' => 'int',
            'updated_at' => 'int',

        ], 'engine=innodb');


        // ингредиенты
        $this->createTable('{{ingredients}}', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255)',
            'status' => 'int default 0', // активен или нет
            'created_at' => 'int',
            'updated_at' => 'int',
        ], 'engine=innodb');


        // связь
        $this->createTable('{{food_ingredient}}', [
            'id' => $this->primaryKey(),
            'food_id' =>  'int',
            'ingredient_id' => 'int',
        ], 'engine=innodb');


        $this->createIndex('{{food_id}}', '{{food_ingredient}}', 'food_id');
        $this->createIndex('{{ingredient_id}}', '{{food_ingredient}}', 'ingredient_id');

        // данные

        $this->insert('ingredients', ['name' => 'Сыр']);
        $this->insert('ingredients', ['name' => 'Томаты']);
        $this->insert('ingredients', ['name' => 'Шампиньоны']);
        $this->insert('ingredients', ['name' => 'Мясо']);
        $this->insert('ingredients', ['name' => 'Лук']);
        $this->insert('ingredients', ['name' => 'Колбаса']);
        $this->insert('ingredients', ['name' => 'Томатный соус']);
        $this->insert('ingredients', ['name' => 'Соленые огурцы']);
        $this->insert('ingredients', ['name' => 'Креветки']);
        $this->insert('ingredients', ['name' => 'Маслины']);

        $this->insert('foods', ['name' => 'Пицца Пепперони']);

        $this->insert('food_ingredient', ['food_id' => 1, 'ingredient_id' => 1]);
        $this->insert('food_ingredient', ['food_id' => 1, 'ingredient_id' => 2]);
        $this->insert('food_ingredient', ['food_id' => 1, 'ingredient_id' => 3]);


        $this->insert('foods', ['name' => 'Пицца Мясная']);

        $this->insert('food_ingredient', ['food_id' => 2, 'ingredient_id' => 3]);
        $this->insert('food_ingredient', ['food_id' => 2, 'ingredient_id' => 4]);
        $this->insert('food_ingredient', ['food_id' => 2, 'ingredient_id' => 5]);








    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190716_075614_init_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190716_075614_init_tables cannot be reverted.\n";

        return false;
    }
    */
}
