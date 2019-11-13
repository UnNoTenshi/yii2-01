<?php

namespace app\controllers;

use app\models\TaskUser;
use Yii;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
        ],
      ],
    ];
  }

  /**
   * Lists all Task models.
   * @return mixed
   */
  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => Task::find(),
    ]);

    return $this->render('index', [
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Task model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    $dataProvider = new ActiveDataProvider([
      "query" => Task::findOne($id)->getAccessedUsers()
    ]);

    return $this->render('view', [
      "dataProvider" => $dataProvider,
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Task model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Task();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      Yii::$app->session->setFlash("success", "Задача \"" . $model->title . "\" успешно создана");
      return $this->redirect(["my"]);
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Task model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->creator_id === Yii::$app->getUser()->id) {
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash("success", "Задача \"" . $model->title . "\" успешно обновлена");
        return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('update', [
        'model' => $model,
      ]);
    }

    return $this->redirect(["my"]);
  }

  /**
   * Deletes an existing Task model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    TaskUser::deleteAll(["task_id" => $id]);
    $this->findModel($id)->delete();

    return $this->redirect(['my']);
  }

  public function actionMy() {
    $dataProvider = new ActiveDataProvider([
      'query' => Task::find()->byCreator(Yii::$app->user->id),
    ]);

    return $this->render('my', [
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionShared() {
    $dataProvider = new ActiveDataProvider([
      'query' => Task::find()->innerJoinWith(Task::RELATION_ACCESSED_USERS)->byCreator(Yii::$app->getUser()->id),
    ]);

    return $this->render('shared', [
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionAccessed() {
    $dataProvider = new ActiveDataProvider([
      'query' => Task::find()->innerJoinWith(Task::RELATION_ACCESSED_USERS)->where(["user.id" => Yii::$app->getUser()->id])
    ]);

    return $this->render('accessed', [
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Finds the Task model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Task the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Task::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
