<?php

namespace app\controllers;

use app\models\Task;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

  public function actionTest()
  {
    /*$user = new User();

    $user->username = "Student";
    $user->name = "Sergey";
    $user->password_hash = password_hash("qwerty", PASSWORD_BCRYPT);
    $user->creator_id = 2;

    $user->save();

    $firstTask = new Task();
    $firstTask->title = "Task 04";
    $firstTask->description = "This is task 04";

    $secondTask = new Task();
    $secondTask->title = "Task 05";
    $secondTask->description = "This is task 05";

    $thirdTask = new Task();
    $thirdTask->title = "Task 06";
    $thirdTask->description = "This is task 06";

    $firstTask->link(Task::RELATION_CREATOR, $user);
    $secondTask->link(Task::RELATION_CREATOR, $user);
    $thirdTask->link(Task::RELATION_CREATOR, $user);

    VarDumper::dump(User::find()->with(User::RELATION_CREATED_TASK)->all(), 5, true);
    VarDumper::dump(User::find()->joinWith(User::RELATION_CREATED_TASK)->all(), 5, true);

    $fourthTask = new Task();
    $fourthTask->title = "Task 07";
    $fourthTask->description = "This is task 07";

    $fourthTask->link(Task::RELATION_CREATOR, User::findOne(2));

    $fourthTask->link(Task::RELATION_ACCESSED_USERS, User::findOne(1));
    $fourthTask->link(Task::RELATION_ACCESSED_USERS, User::findOne(3));
    $fourthTask->link(Task::RELATION_ACCESSED_USERS, User::findOne(5));

    VarDumper::dump($fourthTask->accessedUsers, 5, true);*/
  }

  /**
   * Lists all User models.
   * @return mixed
   */
  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => User::find(),
    ]);

    return $this->render('index', [
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single User model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new User model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new User();

    $model->setScenario(User::SCENARIO_CREATE);

    $model->creator_id = 1;

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing User model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * Deletes an existing User model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the User model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return User the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = User::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
