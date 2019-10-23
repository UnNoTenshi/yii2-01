<?php


namespace app\controllers;


use app\models\Product;
use yii\web\Controller;

class TestController extends Controller
{
  public function actionIndex() {
    $product = new Product();
    $product->id = 1;
    $product->name = "Samsung S11 Edge";
    $product->category = "Phones";
    $product->price = 84999;

    return $this->render("index", ["product" => $product]);
  }
}