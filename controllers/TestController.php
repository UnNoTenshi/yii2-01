<?php


namespace app\controllers;


use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;

class TestController extends Controller
{
  public function actionIndex() {
    return $this->render("index", [
      "testString" => Yii::$app->test->getTestProperty()
    ]);
  }

  public function actionInsert() {
    Yii::$app->db->createCommand()->insert("user", [
      "username" => "Khamyanov",
      "name" => "Aleksandr",
      "password_hash" => password_hash("password_12345", PASSWORD_BCRYPT),
      "creator_id" => 1,
      "created_at" => time()
    ])->execute();

    Yii::$app->db->createCommand()->insert("user", [
      "username" => "User",
      "name" => "NameUser",
      "password_hash" => password_hash("password", PASSWORD_BCRYPT),
      "creator_id" => 1,
      "created_at" => time()
    ])->execute();

    Yii::$app->db->createCommand()->insert("user", [
      "username" => "Guest",
      "name" => "NameGuest",
      "password_hash" => password_hash("12345", PASSWORD_BCRYPT),
      "creator_id" => 2,
      "created_at" => time()
    ])->execute();

    Yii::$app->db->createCommand()->batchInsert("task", ["title", "description", "creator_id", "created_at"], [
      ["Task 01", "This is task 01", 1, time()],
      ["Task 02", "THis is task 02", 3, time()],
      ["Task 03", "This is task 03", 1, time()]
    ])->execute();
  }

  public function actionSelect() {
    VarDumper::dump(
      (new Query())
      ->from("user")
      ->where(["id" => 1])
      ->all()
    );

    VarDumper::dump(
      (new Query())
        ->from("user")
        ->where([">", "id", 1])
        ->orderBy("name")
        ->all()
    );

    VarDumper::dump(
      (new Query())
        ->from("user")
        ->count()
    );

    VarDumper::dump(
      (new Query())
      ->from("task")
      ->innerJoin("user", "task.creator_id = user.id")
      ->all()
    );
  }
}