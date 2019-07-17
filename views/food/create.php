<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Food */

$this->title = 'Новое';
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listIngredients' => $listIngredients,
        'paramIngredients' => $paramIngredients,
    ]) ?>

</div>
