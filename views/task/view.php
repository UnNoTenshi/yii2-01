<?php

use app\models\TaskUser;
use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'My tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= ($model->creator_id === Yii::$app->getUser()->id) ? Html::a('Shared', ['/task-user/create', 'taskId' => $model->id], ['class' => 'btn btn-primary']) : "" ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
      ],
    ]) ?>
  </p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      'title',
      'description:ntext',
      'creator_id',
      'updater_id',
      'created_at',
      'updated_at',
    ],
  ]) ?>

  <h2>Accessed users</h2>

  <?= (Yii::$app->getUser()->id === $model->creator_id) ?
    GridView::widget([
      'dataProvider' => $dataProvider,
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        "username",
        [
          'class' => 'yii\grid\ActionColumn',
          "template" => "{delete}",
          "buttons" => [
            "delete" => function ($url, \app\models\User $userModel, $key) use ($model) {
              $iconShare = \yii\bootstrap\Html::icon("trash");

              $taskUserId = TaskUser::findOne([
                "user_id" => $key,
                "task_id" => $model->id
              ])->id;

              return Html::a(
                $iconShare,
                ["/task-user/delete/", "id" => $taskUserId],
                [
                  "title" => "Удалить доступ для пользователя",
                  "data-method" => "post"
                ]
              );
            }
          ]
        ],
      ],
    ]) : "";
  ?>

</div>
