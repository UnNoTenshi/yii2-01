<?php


namespace app\controllers;


use yii\web\Controller;
use Yii;

class TestController extends Controller
{
  public function actionIndex() {
    return $this->render("index", [
      "testString" => Yii::$app->test->getTestProperty()
    ]);
  }
}