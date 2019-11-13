<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use Yii;
use app\models\TaskUser;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskUserController implements the CRUD actions for TaskUser model.
 */
class TaskUserController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      "access" => [
        "class" => AccessControl::class,
        "rules" => [
          [
            "allow" => true,
            "roles" => ["@"]
          ]
        ]
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
          "deleteAll" => ["POST"]
        ],
      ],
    ];
  }

  /**
   * Creates a new TaskUser model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new TaskUser();

    $model->task_id = Yii::$app->request->get("taskId");

    $creatorIdTask = Task::findOne($model->task_id)->creator_id;

    if ($creatorIdTask === Yii::$app->getUser()->id) {
      $idsUsersInTask = $model::find()
        ->select("user_id")
        ->where(["task_id" => $model->task_id])
        ->asArray()
        ->all();

      $arrayIdsUsers = array();

      if ((count($idsUsersInTask) > 0)) {
        foreach ($idsUsersInTask as $rowIdUserInTask) {
          $arrayIdsUsers[] = $rowIdUserInTask["user_id"];
        }
      }

      $users = User::find()
        ->select("username")
        ->where(["<>", "id", Yii::$app->user->id])
        ->andWhere(["not in", "id", $arrayIdsUsers])
        ->indexBy("id")
        ->column();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        $titleTask = $model->getTask()->one()->title;

        $username = $model->getUser()->one()->username;

        Yii::$app->session->setFlash("success", "Пользователю " . $username . " дан доступ к задаче \"" . $titleTask . "\"");
        return $this->redirect(["/task/my"]);
      }

      return $this->render('create', [
        'model' => $model,
        "users" => $users
      ]);
    }

    return $this->redirect(["/task/my"]);
  }

  /**
   * Deletes an existing TaskUser model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $thisModel = $this->findModel($id);

    $userModel = $thisModel->getUser()->one();

    $taskModel = $thisModel->getTask()->one();

    $creatorId = $taskModel->creator_id;

    if (Yii::$app->getUser()->id === $creatorId) {
      $thisModel->delete();

      Yii::$app->getSession()->setFlash(
        "success",
        "Доступ пользователя " . $userModel->username . " к задаче \"" . $taskModel->title . "\" удален"
      );
    } else {
      Yii::$app->getSession()->setFlash(
        "error",
        "Вы не можете редактировать доступы к данной задаче"
      );
    }

    return $this->redirect(['/task/view' , "id" => $taskModel->id]);
  }

  public function actionDeleteAll($taskId)
  {
    if (Task::findOne($taskId)->creator_id === Yii::$app->getUser()->id) {
      TaskUser::deleteAll(["task_id" => $taskId]);

      Yii::$app->getSession()->setFlash(
        "success",
        "Доступы всех пользователей к задаче \"" . Task::findOne($taskId)->title . "\" удалены"
      );
    } else {
      Yii::$app->getSession()->setFlash(
        "error",
        "Вы не можете редактировать доступы к данной задаче"
      );
    }

    return $this->redirect(['/task/my']);
  }

  /**
   * Finds the TaskUser model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return TaskUser the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = TaskUser::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
