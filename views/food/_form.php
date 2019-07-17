<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Food */
/* @var $form yii\widgets\ActiveForm */

?>

<style type="text/css">
    .multiselect-container {
        width: 100% !important;
    }
</style>

<div class="food-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <p>Выберите ингредиенты:</p>
    <!-- Build your select: -->

    <?= $form->field($model, 'ingredients_data')
    ->dropDownList( $listIngredients,
    [
    'options' => $paramIngredients,
    'multiple'=>'multiple',
    'class'=>'chosen-select input-md required',
        'size' => 10,
    ]
    )->label(""); ?>




    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#food-ingredients_data').multiselect();
    });
</script>

