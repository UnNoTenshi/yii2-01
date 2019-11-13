<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accessed tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
  </p>


  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'title',
      'description:ntext',
      [
        "attribute" => "creator",
        "format" => "html",
        "value" => function($model, $key) {
          $creatorModel = $model->getCreator()->one();

          return Html::a($creatorModel->name, ["/user/view", "id" => $creatorModel->id]);
        }
      ],
      [
        "attribute" => "created_at",
        "format" => ["date", "php:d F Y H:i:s"]
      ],
    ],
  ]); ?>


</div>
