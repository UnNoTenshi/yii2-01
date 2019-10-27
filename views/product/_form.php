<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'name')->dropDownList([
    1 => "firstItem",
    2 => "secondItem",
    3 => "thirdItem"
  ]) ?>

  <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'created_at')->textInput() ?>

  <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
