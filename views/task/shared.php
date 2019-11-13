<?php

use app\models\TaskUser;
use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shared tasks';
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
        "attribute" => "created_at",
        "format" => ["date", "php:d F Y H:i:s"]
      ],
      [
        "attribute" => "updated_at",
        "format" => ["date", "php:d F Y H:i:s"]
      ],

      [
        'class' => 'yii\grid\ActionColumn',
        "template" => "{view} {update} {share} {delete}",
        "buttons" => [
          "share" => function ($url, \app\models\Task $model, $key) {
            $iconShare = \yii\bootstrap\Html::icon("share-alt");
            return Html::a($iconShare, ["/task-user/create/", "taskId" => $model->id]);
          },
          "delete" => function ($url, \app\models\Task $model, $key) {
            $iconShare = \yii\bootstrap\Html::icon("trash");

            return Html::a(
              $iconShare,
              ["/task-user/delete-all/", "taskId" => $model->id],
              [
                "title" => "Удалить доступ для всех",
                "data-method" => "post"
              ]
            );
          }
        ]
      ],
    ],
  ]); ?>


</div>
