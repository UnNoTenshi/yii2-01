<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
  </p>


  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'id',
      [
        "label" => "Название",
        "attribute" => "name",
        "format" => "html",
        "value" => function ($data) {
          return Html::a(
            Html::tag(
              "strong", Html::encode($data->name)
            ), ["/product/view", "id" => $data->id]
          );
        }
      ],
      [
        "label" => "Цена",
        "attribute" => "price"
      ],
      [
        "label" => "Создан",
        "attribute" => "created_at",
        "format" => "html",
        "value" => function ($data) {
          return Html::tag("span", Yii::$app->formatter->asDatetime($data->created_at, "d.M.Y H:i:s"), [
            "style" => ["font-size" => "10px"]
          ]);
        }
      ],

      ['class' => 'yii\grid\ActionColumn'],
    ],
  ]); ?>


</div>
